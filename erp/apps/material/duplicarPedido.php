<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['duplicar_pedido_id'] != "") {
        duplicarPedido($_POST['duplicar_pedido_id']);
    }    
    
    
    function duplicarPedido($pedido_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT SUBSTRING( PEDIDOS_PROV.pedido_genelek, 4, LENGTH( PEDIDOS_PROV.pedido_genelek ) )
                FROM PEDIDOS_PROV
                WHERE YEAR( fecha ) = YEAR( NOW( ) )
                ORDER BY 1 DESC
                LIMIT 1";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $registros = mysqli_fetch_row ($result);
        $numPedidos = $registros[0];
        $numPedidos++;
        
        $REF = "P".date("y").str_pad($numPedidos, 4, '0', STR_PAD_LEFT);
        $nombre1 = str_replace(" ", "_", $_POST['newduplicado_titulo']); 
        $nombre = str_replace("/", "_", $nombre1); 
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
        
        //Obtengo los datos generales del pedido para insertarlos en el nuevo
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
        
        $forma_pago = $registros[0];
        $prov_id = $registros[1];
        $contacto = $registros[2];
        $plazo = $registros[3];
        $titulo = $_POST['newduplicado_titulo'];
        $descripcion = $_POST['newduplicado_desc'];
        $pedido_cliente = $_POST['newduplicado_pedidocliente'];
        $oferta_prov = $_POST['newduplicado_oferta_prov'];
        if ($_POST['newduplicado_clientes'] == "") {
            $cliente_id = "null";
        }
        else {
            $cliente_id = $_POST['newduplicado_clientes'];
        }
        if ($_POST['duplicar_pedido_proyectos'] == "") {
            $proyecto_id = "null";
        }
        else {
            $proyecto_id = $_POST['duplicar_pedido_proyectos'];
        }
        $fecha = $_POST['newduplicado_fecha'];
        $fecha_entrega = $_POST['newduplicado_fechaentrega'];
        
        $sqlPedido = "INSERT INTO PEDIDOS_PROV 
                        (pedido_genelek,
                        ref,
                        ref_oferta_prov,
                        tecnico_id,
                        titulo,
                        descripcion,
                        cliente_id,
                        proyecto_id,
                        proveedor_id,
                        fecha,
                        fecha_entrega,
                        forma_pago,
                        contacto,
                        plazo,
                        path
                        )
                        VALUES
                        ('".$REF."',
                        '".$pedido_cliente."',
                        '".$oferta_prov."',
                        ".$_SESSION['user_session'].",
                        '".$titulo."',
                        '".$descripcion."',
                        ".$cliente_id.",
                        ".$proyecto_id.",
                        ".$prov_id.",
                        '".$fecha."',
                        '".$fecha_entrega."',
                        '".$forma_pago."',
                        '".$contacto."',
                        '".$plazo."',
                        '".$path."')";
        file_put_contents("insertDuplicado.txt", $sqlPedido);
        $result = mysqli_query($connString, $sqlPedido) or die("Error al guardar el Duplicado");
        
        $sql = "SELECT id FROM PEDIDOS_PROV ORDER BY id DESC LIMIT 1";
        $resultPedido = mysqli_query($connString, $sql) or die("Error al consultar el Pedido Duplicado");
        $row = mysqli_fetch_row($resultPedido);
        $duplicado_id = $row[0];
        
        //Ahora obtengo los detalles del pedido para duplicarlo
        $sql = "SELECT 
                    material_id,
                    material_tarifa_id,
                    ref,
                    unidades,
                    dto,
                    fecha_entrega,
                    dto_prov_activo,
                    dto_mat_activo,
                    dto_ad_activo, 
                    dto_ad_prior,
                    iva_id,
                    cliente_id,
                    dto_prov_id
                FROM PEDIDOS_PROV_DETALLES
                WHERE 
                    pedido_id = ".$pedido_id;
        $res = mysqli_query($connString, $sql) or die("Error al consultar detalles del Pedido");
        while( $row = mysqli_fetch_array($res) ) {
            if ($row[11] == "") {
                $detallecliente_id = "null";
            }
            else {
                $detallecliente_id = $row[11];
            }
            if ($row[12] == "") {
                $detalledtoprov_id = "null";
            }
            else {
                $detalledtoprov_id = $row[12];
            }
            $sql = "INSERT INTO PEDIDOS_PROV_DETALLES
                        (pedido_id,
                        material_id,
                        material_tarifa_id,
                        ref,
                        unidades,
                        dto,
                        fecha_entrega,
                        dto_prov_activo,
                        dto_mat_activo,
                        dto_ad_activo, 
                        dto_ad_prior,
                        iva_id,
                        cliente_id,
                        dto_prov_id)
                        VALUES 
                        (".$duplicado_id.",
                        ".$row[0].",
                        ".$row[1].",
                        '".$row[2]."',
                        ".$row[3].",
                        ".$row[4].",
                        '".$row[5]."',
                        ".$row[6].",
                        ".$row[7].",
                        ".$row[8].",
                        ".$row[9].",
                        ".$row[10].",
                        ".$detallecliente_id.",
                        ".$detalledtoprov_id."
                    )";
            file_put_contents("insertDetalleDuplicado.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar los detalles del Duplicado");
        }

        echo $duplicado_id;
    }
?>
	