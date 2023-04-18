
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['envios_edit_delenvio'] != "") {
        delEnvio($_POST['envios_edit_delenvio']);
    }    
    else {
        if ($_POST['envios_edit_idenvio'] != "") {
            updateEnvio();
        }
        else {
            if ($_POST['to_albaran'] != "") {
                generarEnvioFromProject();
            }
            else {
                insertEnvio();
            }
        }
    }
    
    function insertEnvio() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sql = "SELECT COUNT(*) FROM ENVIOS_CLI WHERE YEAR(fecha) = YEAR(now())";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Envios");
        $registros = mysqli_fetch_row ($result);
        $numEnvios = $registros[0];
        
        $REF = "ALB".date("y",strtotime($_POST["newenvio_fecha"])).str_pad($numEnvios, 4, '0', STR_PAD_LEFT);
        $nombre = str_replace(" ", "_", $_POST['newenvio_titulo']);        
        $path = "/".date('Y', strtotime($_POST["newenvio_fecha"]))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($_POST["newenvio_fecha"]))."/";
        
        
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
        
        if ($_POST['newenvio_proyectos'] != "") {
            $proyectoid = $_POST['newenvio_proyectos'];
        }
        else {
            $proyectoid = "null";
        }
        if ($_POST['newenvio_entregas'] != "") {
            $entregaid = $_POST['newenvio_entregas'];
        }
        else {
            $entregaid = "null";
        }
        if ($_POST['newenvio_ofertas_gen'] != "") {
            $ofertaid = $_POST['newenvio_ofertas_gen'];
        }
        else {
            $ofertaid = "null";
        }
        if ($_POST['newenvio_clientes'] != "") {
            $clienteid = $_POST['newenvio_clientes'];
        }
        else {
            $clienteid = "null";
        }
        if ($_POST['newenvio_proveedores'] != "") {
            $provid = $_POST['newenvio_proveedores'];
        }
        else {
            $provid = "null";
        }
        $sql = "INSERT INTO ENVIOS_CLI 
                    (transportista_id,
                    nombre,
                    descripcion,
                    tecnico_id,
                    fecha,
                    fecha_entrega,
                    ref,
                    ref_transportista,
                    cliente_id,
                    proveedor_id,
                    proyecto_id,
                    contacto,
                    estado_id,
                    path,
                    entrega_id,
                    ref_pedido_cliente,
                    plazo,
                    oferta_id,
                    ref_oferta_proveedor,
                    gastos_envio,
                    direccion_envio,
                    forma_envio,
                    portes
                    )
                VALUES (".$_POST['newenvio_transportistas'].",
                    '".$_POST['newenvio_titulo']."',
                    '".$_POST['newenvio_descripcion']."',
                    ".$_POST['newenvio_tecnicos'].",
                    '".$_POST['newenvio_fecha']."',
                    '".$_POST['newenvio_fechaentrega']."',
                    '".$REF."',
                    '".$_POST['newenvio_ref_trans']."',
                    ".$clienteid.",
                    ".$provid.",
                    ".$proyectoid.",
                    '".$_POST['newenvio_contacto']."',
                    ".$_POST['newenvio_estados'].",
                    '".$path."',
                    ".$entregaid.",    
                    '".$_POST['newenvio_pedido_CLI']."',
                    '".$_POST['newenvio_plazo']."',
                    ".$ofertaid.",
                    '".$_POST['newenvio_oferta_prov']."', 
                    ".$_POST['newenvio_gastos'].", 
                    '".$_POST['newenvio_direnvio']."',
                    '".$_POST['newenvio_formaenvio']."',
                    '".$_POST['newenvio_portes']."')";
        file_put_contents("insertEnvio.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Envío");
        
        $sql = "SELECT id, nombre FROM ENVIOS_CLI ORDER BY id DESC LIMIT 1";
        $resultEnvio = mysqli_query($connString, $sql) or die("Error al consultar el Envío");
        $dataEnvios = array();
        while ( $row = mysqli_fetch_assoc($resultEnvio) )
        {
            $dataEnvios[] = $row;
        }
        echo json_encode( $dataEnvios );
    }
    
    function generarEnvioFromProject() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sql = "SELECT COUNT(*) FROM ENVIOS_CLI WHERE YEAR(fecha) = YEAR(now())";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Envios");
        $registros = mysqli_fetch_row ($result);
        $numEnvios = $registros[0];
        
        $REF = "ALB".date("y",strtotime($_POST["newenvio_fecha"])).str_pad($numEnvios, 4, '0', STR_PAD_LEFT);
        $nombre = str_replace(" ", "_", $_POST['newenvio_titulo']);        
        $path = "/".date('Y', strtotime($_POST["newenvio_fecha"]))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($_POST["newenvio_fecha"]))."/";
        
        
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
        
        if ($_POST['newenvio_proyectos'] != "") {
            $proyectoid = $_POST['newenvio_proyectos'];
        }
        else {
            $proyectoid = "null";
        }
        if ($_POST['newenvio_entregas'] != "") {
            $entregaid = $_POST['newenvio_entregas'];
        }
        else {
            $entregaid = "null";
        }
        if ($_POST['newenvio_ofertas_gen'] != "") {
            $ofertaid = $_POST['newenvio_ofertas_gen'];
        }
        else {
            $ofertaid = "null";
        }
        if ($_POST['newenvio_clientes'] != "") {
            $clienteid = $_POST['newenvio_clientes'];
        }
        else {
            $clienteid = "null";
        }
        if ($_POST['newenvio_proveedores'] != "") {
            $provid = $_POST['newenvio_proveedores'];
        }
        else {
            $provid = "null";
        }
        $sql = "INSERT INTO ENVIOS_CLI 
                    (transportista_id,
                    nombre,
                    descripcion,
                    tecnico_id,
                    fecha,
                    fecha_entrega,
                    ref,
                    ref_transportista,
                    cliente_id,
                    proveedor_id,
                    proyecto_id,
                    contacto,
                    estado_id,
                    path,
                    entrega_id,
                    ref_pedido_cliente,
                    plazo,
                    oferta_id,
                    ref_oferta_proveedor,
                    gastos_envio,
                    direccion_envio,
                    forma_envio,
                    portes
                    )
                VALUES (".$_POST['newenvio_transportistas'].",
                    '".$_POST['newenvio_titulo']."',
                    '".$_POST['newenvio_descripcion']."',
                    ".$_POST['newenvio_tecnicos'].",
                    '".$_POST['newenvio_fecha']."',
                    '".$_POST['newenvio_fechaentrega']."',
                    '".$REF."',
                    '".$_POST['newenvio_ref_trans']."',
                    ".$clienteid.",
                    ".$provid.",
                    ".$proyectoid.",
                    '".$_POST['newenvio_contacto']."',
                    ".$_POST['newenvio_estados'].",
                    '".$path."',
                    ".$entregaid.",    
                    '".$_POST['newenvio_pedido_CLI']."',
                    '".$_POST['newenvio_plazo']."',
                    ".$ofertaid.",
                    '".$_POST['newenvio_oferta_prov']."', 
                    ".$_POST['newenvio_gastos'].", 
                    '".$_POST['newenvio_direnvio']."',
                    '".$_POST['newenvio_formaenvio']."',
                    '".$_POST['newenvio_portes']."')";
        file_put_contents("insertEnvioFromProj.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Envío");
        
        $sql = "SELECT id, nombre FROM ENVIOS_CLI ORDER BY id DESC LIMIT 1";
        $resultEnvio = mysqli_query($connString, $sql) or die("Error al consultar el Envío");
        
        $dataEnvios = array();
        
        while ( $row = mysqli_fetch_assoc($resultEnvio) )
        {
            $idenvio = $row['id'];
            $dataEnvios[] = $row;
        }
        
        // LOS ID DE MATERIALES ASIGNADOS A PROYECTO
        $materiales = array_map('intval', explode('-', $_POST['to_albaran']));
        $materiales = implode("','",$materiales);
        //AHORA POR CADA MATERIAL DEL PROYECTO HAY QUE 
        $sql = "SELECT id, material_id, unidades, proyecto_id FROM PROYECTOS_MATERIALES WHERE id IN ('".$materiales."')";
        file_put_contents("queryArray.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error al consultar los materiales del Envío");
        while( $row = mysqli_fetch_array($res) ) {
            $sql2 = "INSERT INTO ENVIOS_CLI_DETALLES 
                        (material_id,
                        envio_id,
                        unidades,
                        proyecto_id,
                        material_proyecto_id
                        )
                    VALUES (".$row[1].",
                    ".$idenvio.", 
                    ".$row[2].",
                    ".$row[3].",
                    ".$row[0].")";
            file_put_contents("insertDetalleFromProj.txt", $sql2);
            $res2 = mysqli_query($connString, $sql2) or die("Error al insertar Detalle de Envío");
        }
        
        echo json_encode( $dataEnvios );
    }
    
    function updateEnvio() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['newenvio_proyectos'] != "") {
            $proyectoid = $_POST['newenvio_proyectos'];
        }
        else {
            $proyectoid = "null";
        }
        if ($_POST['newenvio_entregas'] != "") {
            $entregaid = $_POST['newenvio_entregas'];
        }
        else {
            $entregaid = "null";
        }
        if ($_POST['newenvio_ofertas_gen'] != "") {
            $ofertaid = $_POST['newenvio_ofertas_gen'];
        }
        else {
            $ofertaid = "null";
        }
        
        if ($_POST['envios_edit_proyectos'] != "") {
            $sql = "UPDATE ENVIOS_CLI 
                    SET 
                        transportista_id = ".$_POST['envios_edit_transportistas'].",
                        nombre = '".$_POST['envios_edit_titulo']."',
                        descripcion = '".$_POST['envios_edit_descripcion']."',
                        tecnico_id = ".$_POST['envios_edit_tecnicos'].",
                        fecha = '".$_POST['envios_edit_fecha']."',
                        fecha_entrega = '".$_POST['envios_edit_fechaentrega']."',
                        ref = '".$_POST['envios_edit_ref']."',
                        ref_transportista = '".$_POST['envios_edit_ref_trans']."',
                        cliente_id = ".$_POST['envios_edit_clientes'].",
                        proyecto_id = ".$proyectoid.",
                        contacto = '".$_POST['envios_edit_contacto']."',
                        estado_id = ".$_POST['envios_edit_estados'].",
                        entrega_id = ".$entregaid.", 
                        ref_pedido_cliente = '".$_POST['envios_edit_pedido_CLI']."',
                        plazo = '".$_POST['envios_edit_plazo']."',
                        oferta_id = ".$ofertaid.",
                        ref_oferta_proveedor = '".$_POST['envios_edit_oferta_prov']."',
                        gastos_envio = ".$_POST['envios_edit_gastos'].", 
                        direccion_envio = '".$_POST['envios_edit_direnvio']."',
                        forma_envio = '".$_POST['envios_edit_formaenvio']."',
                        portes = '".$_POST['envios_edit_portes']."'
                    WHERE id = ".$_POST['envios_edit_idenvio'];
        }
        else {
            $sql = "UPDATE ENVIOS_CLI 
                    SET 
                        transportista_id = ".$_POST['envios_edit_transportistas'].",
                        nombre = '".$_POST['envios_edit_titulo']."',
                        descripcion = '".$_POST['envios_edit_descripcion']."',
                        tecnico_id = ".$_POST['envios_edit_tecnicos'].",
                        fecha = '".$_POST['envios_edit_fecha']."',
                        fecha_entrega = '".$_POST['envios_edit_fechaentrega']."',
                        ref = '".$_POST['envios_edit_ref']."',
                        ref_transportista = '".$_POST['envios_edit_ref_trans']."',
                        cliente_id = ".$_POST['envios_edit_clientes'].",
                        proyecto_id = ".$proyectoid.",
                        contacto = '".$_POST['envios_edit_contacto']."',
                        estado_id = ".$_POST['envios_edit_estados'].",
                        entrega_id = ".$entregaid.", 
                        ref_pedido_cliente = '".$_POST['envios_edit_pedido_CLI']."',
                        plazo = '".$_POST['envios_edit_plazo']."',
                        oferta_id = ".$ofertaid.",
                        ref_oferta_proveedor = '".$_POST['envios_edit_oferta_prov']."',
                        gastos_envio = ".$_POST['envios_edit_gastos'].",
                        direccion_envio = '".$_POST['envios_edit_direnvio']."',
                        forma_envio = '".$_POST['envios_edit_formaenvio']."',
                        portes = '".$_POST['envios_edit_portes']."'
                    WHERE id = ".$_POST['envios_edit_idenvio'];
        }
        
        file_put_contents("updateEnvio.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Envío");
    }

    function delEnvio($envio_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from ENVIOS_CLI_DETALLES WHERE pedido_id=".$envio_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los detalles del Envío");
        $sql = "delete from ENVIOS_CLI_DOC WHERE envio_id=".$envio_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los documentos del Envío");
        $sql = "delete from ENVIOS_CLI WHERE id=".$envio_id;
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Envío");
    }
?>
	