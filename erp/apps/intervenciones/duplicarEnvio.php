<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['id_pedido'] != "") {
        duplicarPedido($_POST['id_pedido']);
    }    
    
    
    function duplicarPedido($pedido_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT COUNT(*) FROM PEDIDOS_PROV WHERE YEAR(fecha) = YEAR(now())";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $registros = mysqli_fetch_row ($result);
        $numPedidos = $registros[0];
        
        $REF = "P".date("y").str_pad($numPedidos, 4, '0', STR_PAD_LEFT);
        $nombre = str_replace(" ", "_", $_POST['newduplicado_titulo']);        
        $path = "/".date('Y')."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y')."/";
        
        
        // file paths to store
            $basepath = "ERP/MATERIAL/PEDIDOS".$path;
            $ftp_server = "192.168.3.108";
            $ftp_username = "admin";
            $ftp_password = "Sistemas2111";
            ///share/MD0_DATA/Download/

        // connection to ftp
            $ftp_connection = ftp_connect($ftp_server);
            $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

        // crear path del año si no existiera
            if (ftp_nlist($ftp_connection, "ERP/MATERIAL/PEDIDOS".$pathYear) === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, "ERP/MATERIAL/PEDIDOS".$pathYear)) {
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
        
        $sql = "SELECT 
                    forma_pago, 
                    proveedor_id,
                    contacto,
                    plazo                    
                FROM 
                    PEDIDOS_PROV  
                WHERE
                    id = ".$pedido_id;
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $registros = mysqli_fetch_row ($result);
        
        $sqlPedido = "";
        file_put_contents("insertpedidodetalleee.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
    }
    
    function updateDetallePedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['pedidodetalle_recmat'] != "") {
            $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                    SET recibido = 1,
                        fecha_recepcion = now()
                    WHERE id = ".$_POST['pedidodetalle_recmat'];
            updateStock("", $_POST['pedidodetalle_recmat'], $_POST['cantidad']);
            
            $sqlNotificacion = "SELECT user_email FROM erp_users WHERE erp_users.id = (SELECT erp_userid FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$_POST['pedidodetalle_recmat'].")";
            $result = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar user_email");
            $registro = mysqli_fetch_row($result);
            $para = $registro[0];
            $sqlNotificacion = "SELECT ref, nombre FROM MATERIALES WHERE id = (SELECT material_id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$_POST['pedidodetalle_recmat'].")";
            $result = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar material_id");
            $registro = mysqli_fetch_row($result);
            $mensaje = "Artículo: ".$registro[1]." con referencia: ".$registro[0]." recibido el: ".date("Y-m-d H:i:s")." en las instalaciones de Genelek Sistemas.";
            sendMail($registro[0], "Artículo recibido", $mensaje, $de);
        }
        else {
            if ($_POST['pedidodetalle_proyectos'] != "") {
                $proyectoid = ", proyecto_id = ".$_POST['pedidodetalle_proyectos'];
            }
            else {
                $proyectoid = "";
            }
            if ($_POST['pedidodetalle_entregas'] != "") {
                $entregaid = ", entrega_id = ".$_POST['pedidodetalle_entregas'];
            }
            else {
                $entregaid = "";
            }
            if ($_POST['pedidodetalle_dtoprov'] != "") {
                $provdto_id = ", dto_prov_id = ".$_POST['pedidodetalle_dtoprov'];
            }
            else {
                $provdto_id = "";
            }
            if ($_POST['pedidodetalle_tecnicos'] != "") {
                $tecnico_id = ", erp_userid = ".$_POST['pedidodetalle_tecnicos'];
            }
            else {
                $tecnico_id = "";
            }

            if ($_POST['pedidodetalle_dtoprov_desc'] == "") {
                $dtoprov_activo = 0;
            }
            else {
                $dtoprov_activo = 1;
            }
            if ($_POST['pedidodetalle_dtomat_desc'] == "") {
                $dtomat_activo = 0;
            }
            else {
                $dtomat_activo = 1;
            }
            if ($_POST['pedidodetalle_dto_desc'] == "") {
                $dtoad_activo = 0;
            }
            else {
                $dtoad_activo = 1;
            }

            if ($_POST['edit_chkrecibido'] == true) {
                $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                    SET material_id = ".$_POST['pedidodetalle_material_id'].", 
                        material_tarifa_id = ".$_POST['pedidodetalle_precios'].", 
                        pedido_id = ".$_POST['pedidodetalle_pedido_id'].",
                        ref = '".$_POST['pedidodetalle_ref']."',
                        unidades = ".$_POST['pedidodetalle_cantidad'].",  
                        dto = ".$_POST['pedidodetalle_dto'].", 
                        fecha_recepcion = '".date("Y-m-d H:i:s",strtotime($_POST['pedidodetalle_fecha_recepcion']))."', 
                        fecha_entrega = '".$_POST['pedidodetalle_fecha_entrega']."', 
                        recibido = 1,
                        dto_prov_activo = ".$dtoprov_activo.",
                        dto_mat_activo = ".$dtomat_activo.",
                        dto_ad_activo = ".$dtoad_activo."  
                        ".$tecnico_id."
                        ".$proyectoid."
                        ".$entregaid."
                        ".$provdto_id."
                    WHERE id = ".$_POST['pedidodetalle_detalle_id'];
            } 
            else {
                $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                    SET material_id = ".$_POST['pedidodetalle_material_id'].", 
                        material_tarifa_id = ".$_POST['pedidodetalle_precios'].", 
                        pedido_id = ".$_POST['pedidodetalle_pedido_id'].", 
                        ref = '".$_POST['pedidodetalle_ref']."',
                        unidades = ".$_POST['pedidodetalle_cantidad'].",  
                        dto = ".$_POST['pedidodetalle_dto'].", 
                        fecha_recepcion = '".date("Y-m-d H:i:s",strtotime($_POST['pedidodetalle_fecha_recepcion']))."', 
                        fecha_entrega = '".$_POST['pedidodetalle_fecha_entrega']."', 
                        recibido = 0,
                        dto_prov_activo = ".$dtoprov_activo.",
                        dto_mat_activo = ".$dtomat_activo.",
                        dto_ad_activo = ".$dtoad_activo." 
                        ".$tecnico_id."
                        ".$proyectoid."
                        ".$entregaid."
                        ".$provdto_id."
                    WHERE id = ".$_POST['pedidodetalle_detalle_id'];
            }
        }
        
        file_put_contents("updateDet.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        updateStock($_POST['pedidodetalle_detalle_id'], $_POST['pedidodetalle_cantidad']);
        //mysqli_set_charset($connString, "utf8");
        
    }

    function updateStock($detalle, $incremento, $material_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($detalle != "") {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + ".$incremento." WHERE id = (SELECT material_id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$detalle.")";
        }
        else {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + ".$incremento." WHERE id = ".$material_id;
        }
        //file_put_contents("updateStock.txt", $sql);
        $result = mysqli_query($connString, $sqlStock) or die("Error al actualizar el Stock");
    }
    
    function delDetallePedido($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from PEDIDOS_PROV_DETALLES WHERE id=".$detalle_id;
        file_put_contents("delDetalle.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	