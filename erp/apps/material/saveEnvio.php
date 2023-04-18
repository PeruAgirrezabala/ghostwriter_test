
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    include("../../common.php");
    
    if ($_POST['action'] == "add") {
        envio();
    }else{
        
    }
    
    function envio(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sqlSelDet = "SELECT 
                        PEDIDOS_PROV_DETALLES.cliente_id, 
                        PEDIDOS_PROV_DETALLES.proyecto_id, 
                        PEDIDOS_PROV.proveedor_id,
                        PEDIDOS_PROV_DETALLES.material_id,
                        PEDIDOS_PROV_DETALLES.unidades
                      FROM PEDIDOS_PROV 
                        INNER JOIN PEDIDOS_PROV_DETALLES ON 
                        PEDIDOS_PROV.id=PEDIDOS_PROV_DETALLES.pedido_id 
                      WHERE PEDIDOS_PROV_DETALLES.id=".$_POST["materialdetalle_id"];
        file_put_contents("log001.txt", $sqlSelDet);
        $resSelDet = mysqli_query($connString, $sqlSelDet) or die("Error al seleccionar el detalle del pedido. RECIBIR INFO. SELECT.");
        $regSelDet = mysqli_fetch_row ($resSelDet);
        
        // Calcular REF ALB990001
        $sqlSelRef = "SELECT SUBSTRING(ref, 6, LENGTH(ref)) FROM ENVIOS_CLI WHERE year(fecha)=".date("Y",$_POST["envio_fecha"])." ORDER BY 1 DESC LIMIT 1";
        file_put_contents("log002.txt", $sqlSelRef);
        $resSelRef = mysqli_query($connString, $sqlSelRef) or die("Error al seleccionar la última REF del ENVIO. SELECT.");
        $regSelRef = mysqli_fetch_row ($resSelRef);
        $numEnvio = $regSelRef[0] + 1;
        $REF = "ALB".date("y",strtotime($_POST["envio_fecha"])).str_pad($numEnvio, 4, '0', STR_PAD_LEFT);
        
        
        // ###################### CREAR PATH ####################### //
        $nombre1 = str_replace(" ", "_", $_POST['envio_nombre']);
        $nombre = str_replace("/", "_", $nombre1);         
        $path = "/".date('Y', strtotime($_POST["envio_fecha"]))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($_POST["envio_fecha"]))."/";
        
        
        // file paths to store
            $basepath = "ERP/MATERIAL/ENVIOS".$path;
            $ftp_server = "192.168.3.108";
            $ftp_username = "admin";
            $ftp_password = "Sistemas2111";
            ///share/MD0_DATA/Download/

        // connection to ftp
            $ftp_connection = ftp_connect($ftp_server);
            $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

        // crear path del año si no existiera
            if (ftp_nlist($ftp_connection, "ERP/MATERIAL/ENVIOS".$pathYear) === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, "ERP/MATERIAL/ENVIOS".$pathYear)) {
                    //echo "Successfully created $basepath";
                    $success = true;
                }
                else
                {
                    //echo "Error while creating $basepath";
                    $success = false;
                }
            }
                
        // crear path del pedido si no existiera
            if (ftp_nlist($ftp_connection, $basepath) === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, $basepath)) {
                    //echo "Successfully created $basepath";
                    $success = true;
                }
                else
                {
                    //echo "Error while creating $basepath";
                    $success = false;
                }
            }
        // ###################### CREAR PATH ####################### //
        $sqlInsert = " INSERT INTO ENVIOS_CLI
                       ( transportista_id, 
                       nombre, 
                       tecnico_id, 
                       fecha, 
                       fecha_entrega, 
                       ref, 
                       cliente_id,
                       proveedor_id, 
                       proyecto_id,
                       estado_id, 
                       path, 
                       direccion_envio, 
                       forma_envio, 
                       portes, 
                       tipo_envio_id 
                       ) VALUES
                       (".$_POST["envio_transportistas"].",
                        '".$_POST["envio_nombre"]."',
                        ".$_POST["envio_usuario_id"].",
                        '".$_POST["envio_fecha"]."',
                        '".$_POST["envio_fechaentrega"]."',
                        '".$REF."',
                        ".$regSelDet[0].",
                        ".$regSelDet[2].",
                        ".$regSelDet[1].",
                        99,
                        '".$path."',
                        '".$_POST["envio_direccion"]."',
                        'NORMAL',
                        ".$_POST["envio_portes"].",
                        ".$_POST["envio_tipo"]."
                       )";
        file_put_contents("log003.txt", $sqlInsert);
        $resInsert = mysqli_query($connString, $sqlInsert) or die("Error al realizar el INSERT de la cabecera del envío.");
        $envioID= mysqli_insert_id($connString);
        
        $sql="INSERT INTO ENVIOS_CLI_DETALLES
                (envio_id, 
                material_id, 
                unidades, 
                entregado, 
                fecha_recepcion, 
                proyecto_id,
                material_proyecto_id, 
                pedido_detalle_id
                ) VALUES 
                (".$envioID.",
                ".$regSelDet[3].",
                ".$_POST["envio_cant"].",
                0,
                '0000-00-00 00:00:00',
                ".$regSelDet[1].",
                0,
                ".$_POST["materialdetalle_id"].")";        
        $res = mysqli_query($connString, $sql) or die("Error al realizar el INSERT del detalle del envío.");
        file_put_contents("log004.txt", $sql);
        
        // Update pedido detalle //
        // Controlar cantidades y si no es completo partirlo.
        
        if($regSelDet[4]==$_POST["envio_cant"]){ // Cantidad completa a devolver
            $sqlUpdateDet = "UPDATE PEDIDOS_PROV_DETALLES SET recibido=2 WHERE id=".$_POST["materialdetalle_id"];
            $resUpdateDet = mysqli_query($connString, $sqlUpdateDet) or die("Error al actualizar el pedido => envio. Cambiar estado.");
        }else{ // Cantidad inferior, habría que restar y partir el detalle....
            $cantTot=$regSelDet[4];
            $cantEnv=$_POST["envio_cant"];
            $cantRest=$cantTot-$cantEnv;
            
            // Partir los detalles del pedido y asignar la cantidad restante.
            $sqlInsert2 = "INSERT INTO PEDIDOS_PROV_DETALLES (pedido_id, material_id, almacen, unidades, detalle_libre, recibido, fecha_recepcion, plazo, dto, fecha_entrega, proyecto_id, material_tarifa_id, ref, pvp, descripcion, dto_prov_activo, dto_mat_activo, dto_ad_activo, dto_prov_id, entrega_id, dto_prov_prior, dto_mat_prior, dto_ad_prior, erp_userid, iva_id, cliente_id)
                            SELECT pedido_id, material_id, almacen, ".$cantRest.", detalle_libre, recibido, fecha_recepcion, plazo, dto, fecha_entrega, proyecto_id, material_tarifa_id, ref, pvp, descripcion, dto_prov_activo, dto_mat_activo, dto_ad_activo, dto_prov_id, entrega_id, dto_prov_prior, dto_mat_prior, dto_ad_prior, erp_userid, iva_id, cliente_id 
                                FROM PEDIDOS_PROV_DETALLES WHERE id=".$_POST["materialdetalle_id"];
            $resInsert2 = mysqli_query($connString, $sqlInsert2) or die("Error al partir el pedido => envio. Dividir detalles a causa de que no es toda la cantidad.");
            
            // Actualizar detalle actual a enviado/devuelto y actualizar cantidad/unidades.
            $sqlUpdateDet = "UPDATE PEDIDOS_PROV_DETALLES SET recibido=2, unidades=".$cantEnv." WHERE id=".$_POST["materialdetalle_id"];
            $resUpdateDet = mysqli_query($connString, $sqlUpdateDet) or die("Error al actualizar el pedido => envio. Cambiar estado.");
            
        }
        echo 1;
    }
    

    function delPedido($pedido_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        $sql = "delete from PEDIDOS_PROV_DETALLES WHERE pedido_id=".$pedido_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los detalles del Pedido");
        $sql = "delete from PEDIDOS_PROV_DOC WHERE pedido_id=".$pedido_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los documentos del Pedido");
        $sql = "delete from PEDIDOS_PROV WHERE id=".$pedido_id;
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Pedido");
    }
?>
	