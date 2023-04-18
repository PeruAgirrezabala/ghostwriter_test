
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
            if ($_POST['pedido_recid'] != "") {
                updatePedido();
            }
            else {
                insertPedido();
            }
        }
    }
    
    function generatePedidoREF ($counter) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        refIterator:
        // Empieza a contar desde 1 si el año es nuevo.
        /*
        $sql = "SELECT SUBSTRING(pedido_genelek,5,length(pedido_genelek)) 
                FROM PEDIDOS_PROV 
                WHERE pedido_genelek LIKE 'P".date("y")."%'
                ORDER BY 1 DESC LIMIT 1";
        */
        // Sigue contando a partir del último pedido
        $sql = "SELECT SUBSTRING(pedido_genelek,5,length(pedido_genelek)) FROM PEDIDOS_PROV
                WHERE year(fecha) > 2020
                ORDER BY pedido_genelek DESC LIMIT 1";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $registros = mysqli_fetch_row ($result);
        $numPedidos = $registros[0] + $counter;
        $REF = "P".date("y",strtotime($_POST["newpedido_fecha"])).str_pad($numPedidos, 4, '0', STR_PAD_LEFT);
        
        $sql = "SELECT pedido_genelek FROM PEDIDOS_PROV WHERE pedido_genelek = '".$REF."'";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $numRegistros = mysqli_num_rows ($result);
        
        if ($numRegistros > 0) {
            $counter = $counter + 1;
            goto refIterator;
        }else{
            return $REF;
        }
        
        
        /*
        refIterator:
        $sql = "SELECT COUNT(*) FROM PEDIDOS_PROV WHERE YEAR(fecha) = YEAR(now())";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $registros = mysqli_fetch_row ($result);
        $numPedidos = $registros[0] + $counter;
        $REF = "P".date("y",strtotime($_POST["newpedido_fecha"])).str_pad($numPedidos, 4, '0', STR_PAD_LEFT);
        
        
        $sql = "SELECT pedido_genelek FROM PEDIDOS_PROV WHERE pedido_genelek = '".$REF."'";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $numRegistros = mysqli_num_rows ($result);
        
        if ($numRegistros > 0) {
            $counter = $counter + 1;
            goto refIterator;
        }else{
            return $REF;
        }
         */
    }
    
    function insertPedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        /*
        $sql = "SELECT COUNT(*) FROM PEDIDOS_PROV WHERE YEAR(fecha) = YEAR(now())";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $registros = mysqli_fetch_row ($result);
        $numPedidos = $registros[0] + 1;
        
        $REF = "P".date("y",strtotime($_POST["newpedido_fecha"])).str_pad($numPedidos, 4, '0', STR_PAD_LEFT);
         */
        $REF = generatePedidoREF(1);
        $nombre1 = str_replace(" ", "_", $_POST['newpedido_titulo']);
        $nombre = str_replace("/", "_", $nombre1);         
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
        
        if ($_POST['newpedido_formaspago'] == "") {
            $formapago_id = "null";
        }
        else {
            $formapago_id = $_POST['newpedido_formaspago'];
        }
        if ($_POST['newpedido_fechaprog'] == "") {
            $fecha_prog = "null";
        }
        else {
            $fecha_prog = date("Y-m-d H:i:s",strtotime($_POST['newpedido_fechaprog']));
        }
        if ($_POST['newpedido_estados'] == "") {
            $estado_id = "2";
        }
        else {
            $estado_id = $_POST['newpedido_estados'];
        }
            
        $sql = "INSERT INTO PEDIDOS_PROV 
                    (ref,
                    titulo,
                    descripcion,
                    cliente_id,
                    proyecto_id,
                    proveedor_id,
                    fecha,
                    fecha_entrega,
                    fecha_mod,
                    forma_pago,
                    forma_pago_id,
                    plazo,
                    contacto,
                    tecnico_id,
                    estado_id,
                    path,
                    ref_oferta_prov,
                    pedido_genelek,
                    dir_entrega,
                    observaciones,
                    fecha_prog
                    )
                VALUES ('".$_POST['newpedido_ref']."',
                    '".$_POST['newpedido_titulo']."',
                    '".$_POST['newpedido_descripcion']."',
                    '".$_POST['newpedido_clientes']."',
                    '".$_POST['newpedido_proyectos']."',
                    ".$_POST['newpedido_proveedores'].",
                    '".$_POST['newpedido_fecha']."',
                    '".$_POST['newpedido_fechaentrega']."',
                    now(),
                    '".$_POST['newpedido_formapago']."',
                    ".$formapago_id.",
                    '".$_POST['newpedido_plazo']."',
                    '".$_POST['newpedido_contacto']."',
                    ".$_POST['newpedido_tecnicos'].",
                    ".$estado_id.",
                    '".$path."',
                    '".$_POST['newpedido_oferta_prov']."',
                    '".$REF."', 
                    '".$_POST['newpedido_direntrega']."',
                    '".$_POST['newpedido_observ']."',
                    '".$fecha_prog."')";
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
        echo json_encode($dataPedidos);
    }
    
    function updatePedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['pedido_recid'] != "") {
            $sql = "UPDATE PEDIDOS_PROV SET estado_id = 5, fecha_recepcion = now() WHERE id = ".$_POST['pedido_recid'];
        } else {
            if ($_POST['pedidos_edit_fecharecepcion'] == "") {
                $fecha_recepcion = "null";
            }
            else {
                $fecha_recepcion = date("Y-m-d H:i:s",strtotime($_POST['pedidos_edit_fecharecepcion']));
            }
            if ($_POST['pedidos_edit_fechaprog'] == "") {
                $fecha_prog = "null";
            }
            else {
                $fecha_prog = date("Y-m-d H:i:s",strtotime($_POST['pedidos_edit_fechaprog']));
            }
            if ($_POST['pedidos_edit_clientes'] == "") {
                $cliente_id = "null";
            }
            else {
                $cliente_id = $_POST['pedidos_edit_clientes'];
            }
            if ($_POST['pedidos_edit_formaspago'] == "") {
                $formapago_id = "null";
            }
            else {
                $formapago_id = $_POST['pedidos_edit_formaspago'];
            }
            if ($_POST['pedidos_edit_estados'] == "") {
                $estado_id = "2";
            }
            else {
                $estado_id = $_POST['pedidos_edit_estados'];
            }

            if ($_POST['pedidos_edit_proyectos'] != "") {
                $sql = "UPDATE PEDIDOS_PROV 
                    SET ref = '".$_POST['pedidos_edit_ref']."', 
                        ref_oferta_prov = '".$_POST['pedidos_edit_ofertaprov']."',
                        titulo = '".$_POST['pedidos_edit_titulo']."', 
                        descripcion = '".$_POST['pedidos_edit_desc']."',  
                        cliente_id = ".$cliente_id.",
                        proyecto_id = ".$_POST['pedidos_edit_proyectos'].", 
                        proveedor_id = ".$_POST['pedidos_edit_proveedores'].", 
                        fecha = '".$_POST['pedidos_edit_fecha']."', 
                        fecha_entrega = '".$_POST['pedidos_edit_fechaentrega']."', 
                        fecha_recepcion = '".$fecha_recepcion."', 
                        forma_pago = '".$_POST['pedidos_edit_formapago']."', 
                        plazo = '".$_POST['pedidos_edit_plazo']."', 
                        contacto = '".$_POST['pedidos_edit_contacto']."', 
                        tecnico_id = ".$_POST['pedidos_edit_tecnicos'].", 
                        estado_id = ".$estado_id.",
                        forma_pago_id = ".$formapago_id.",
                        dir_entrega = '".$_POST['pedidos_edit_direntrega']."',
                        fecha_mod = now(),
                        observaciones = '".$_POST['pedidos_edit_observ']."',
                        fecha_prog = '".$fecha_prog."'
                    WHERE id = ".$_POST['pedidos_edit_idpedido'];
            }
            else {
                $sql = "UPDATE PEDIDOS_PROV 
                    SET ref = '".$_POST['pedidos_edit_ref']."', 
                        ref_oferta_prov = '".$_POST['pedidos_edit_ofertaprov']."',
                        titulo = '".$_POST['pedidos_edit_titulo']."', 
                        descripcion = '".$_POST['pedidos_edit_desc']."',  
                        cliente_id = ".$cliente_id.",
                        proyecto_id = null, 
                        proveedor_id = ".$_POST['pedidos_edit_proveedores'].", 
                        fecha = '".$_POST['pedidos_edit_fecha']."', 
                        fecha_entrega = '".$_POST['pedidos_edit_fechaentrega']."', 
                        fecha_recepcion = '".$fecha_recepcion."', 
                        forma_pago = '".$_POST['pedidos_edit_formapago']."', 
                        plazo = '".$_POST['pedidos_edit_plazo']."', 
                        contacto = '".$_POST['pedidos_edit_contacto']."', 
                        tecnico_id = ".$_POST['pedidos_edit_tecnicos'].", 
                        estado_id = ".$estado_id.",
                        forma_pago_id = ".$formapago_id.", 
                        dir_entrega = '".$_POST['pedidos_edit_direntrega']."',
                        fecha_mod = now(),
                        observaciones = '".$_POST['pedidos_edit_observ']."',
                        fecha_prog = '".$fecha_prog."'
                    WHERE id = ".$_POST['pedidos_edit_idpedido'];
            }
        }
        //$sqlActivity = "INSERT INTO erp_activity (user_id, fecha, descripcion ) VALUES(".$_SESSION['user_session'].", now(), 'Pedido ".$_POST['pedidos_edit_idpedido']." actualizado')";
        //file_put_contents("log99.txt", $sqlActivity);
        //$result = mysqli_query($connString, $sqlActivity) or die("Error al guardar la Actividad del ERP");
        //
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
	