
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['pedidos_edit_delpedido'] != "") {
        delPedido($_POST['pedidos_edit_delpedido']);
    }    
    else {
        if ($_POST['pedidos_edit_idpedido'] != "") {
            updatePedido();
        }
        else {
            insertPedido();
        }
    }
    
    function insertPedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sql = "SELECT COUNT(*) FROM PEDIDOS_PROV WHERE YEAR(fecha) = YEAR(now())";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $registros = mysqli_fetch_row ($result);
        $numPedidos = $registros[0];
        
        $REF = "P".date("y",strtotime($_POST["newpedido_fecha"])).str_pad($numPedidos, 4, '0', STR_PAD_LEFT);
        $nombre = str_replace(" ", "_", $_POST['newpedido_titulo']);        
        $path = "/".date('Y', strtotime($_POST["newpedido_fecha"]))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($_POST["newpedido_fecha"]))."/";
        
        
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
        
        $sql = "INSERT INTO PEDIDOS_PROV 
                    (ref,
                    titulo,
                    descripcion,
                    proyecto_id,
                    proveedor_id,
                    fecha,
                    fecha_entrega,
                    forma_pago,
                    plazo,
                    contacto,
                    tecnico_id,
                    estado_id,
                    path,
                    ref_oferta_prov,
                    pedido_genelek
                    )
                VALUES ('".$_POST['newpedido_ref']."',
                    '".$_POST['newpedido_titulo']."',
                    '".$_POST['newpedido_descripcion']."',
                    '".$_POST['newpedido_proyectos']."',
                    ".$_POST['newpedido_proveedores'].",
                    '".$_POST['newpedido_fecha']."',
                    '".$_POST['newpedido_fechaentrega']."',
                    '".$_POST['newpedido_formapago']."',
                    '".$_POST['newpedido_plazo']."',
                    '".$_POST['newpedido_contacto']."',
                    ".$_POST['newpedido_tecnicos'].",
                    ".$_POST['newpedido_estados'].",
                    '".$path."',
                    '".$_POST['newpedido_oferta_prov']."',
                    '".$REF."')";
        //file_put_contents("insertpedido.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Pedido");
        
        $sql = "SELECT id, titulo FROM PEDIDOS_PROV ORDER BY id DESC LIMIT 1";
        $resultPedido = mysqli_query($connString, $sql) or die("Error al consultar el Pedido");
        $dataPedidos = array();
        while ( $row = mysqli_fetch_assoc($resultPedido) )
        {
            $dataPedidos[] = $row;
        }
        echo json_encode( $dataPedidos );
    }
    
    function updatePedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['pedidos_edit_proyectos'] != "") {
            $sql = "UPDATE PEDIDOS_PROV 
                SET ref = '".$_POST['pedidos_edit_ref']."', 
                    ref_oferta_prov = '".$_POST['pedidos_edit_ofertaprov']."',
                    titulo = '".$_POST['pedidos_edit_titulo']."', 
                    descripcion = '".$_POST['pedidos_edit_desc']."',  
                    proyecto_id = ".$_POST['pedidos_edit_proyectos'].", 
                    proveedor_id = ".$_POST['pedidos_edit_proveedores'].", 
                    fecha = '".$_POST['pedidos_edit_fecha']."', 
                    fecha_entrega = '".$_POST['pedidos_edit_fechaentrega']."', 
                    fecha_recepcion = '".date("Y-m-d H:i:s",strtotime($_POST['pedidos_edit_fecharecepcion']))."', 
                    forma_pago = '".$_POST['pedidos_edit_formapago']."', 
                    plazo = '".$_POST['pedidos_edit_plazo']."', 
                    contacto = '".$_POST['pedidos_edit_contacto']."', 
                    tecnico_id = ".$_POST['pedidos_edit_tecnicos'].", 
                    estado_id = ".$_POST['pedidos_edit_estados']." 
                WHERE id = ".$_POST['pedidos_edit_idpedido'];
        }
        else {
            $sql = "UPDATE PEDIDOS_PROV 
                SET ref = '".$_POST['pedidos_edit_ref']."', 
                    ref_oferta_prov = '".$_POST['pedidos_edit_ofertaprov']."',
                    titulo = '".$_POST['pedidos_edit_titulo']."', 
                    descripcion = '".$_POST['pedidos_edit_desc']."',  
                    proveedor_id = ".$_POST['pedidos_edit_proveedores'].", 
                    fecha = '".$_POST['pedidos_edit_fecha']."', 
                    fecha_entrega = '".$_POST['pedidos_edit_fechaentrega']."', 
                    fecha_recepcion = '".date("Y-m-d H:i:s",strtotime($_POST['pedidos_edit_fecharecepcion']))."', 
                    forma_pago = '".$_POST['pedidos_edit_formapago']."', 
                    plazo = '".$_POST['pedidos_edit_plazo']."', 
                    contacto = '".$_POST['pedidos_edit_contacto']."', 
                    tecnico_id = ".$_POST['pedidos_edit_tecnicos'].", 
                    estado_id = ".$_POST['pedidos_edit_estados']." 
                WHERE id = ".$_POST['pedidos_edit_idpedido'];
        }
        
        //file_put_contents("updatePedido.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Pedido");
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
	