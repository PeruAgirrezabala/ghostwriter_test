<?php
    session_start();
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['int_delint'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delInt($_POST['int_delint']);
    }    
    else {
        if ($_POST['int_idint'] != "") {
            updateInt();
        }
        else {
            insertInt();
        }
    }
    
    function insertInt() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT COUNT(*) FROM INTERVENCIONES WHERE YEAR(fecha) = YEAR(now())";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Interevenciones");
        $registros = mysqli_fetch_row ($result);
        $numEnvios = $registros[0];
        
        $REF = "INT".date("y",strtotime($_POST['int_fecha'])).str_pad($numEnvios, 4, '0', STR_PAD_LEFT);
        $nombre = str_replace(" ", "_", $_POST['int_nombre']);        
        $path = "/".date('Y', strtotime($_POST["int_fecha"]))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($_POST["int_fecha"]))."/";
        
        
        // file paths to store
            $basepath = "ERP/INTERVENCIONES".$path;
            $ftp_server = "192.168.3.108";
            $ftp_username = "admin";
            $ftp_password = "Sistemas2111";
            ///share/MD0_DATA/Download/

        // connection to ftp
            $ftp_connection = ftp_connect($ftp_server);
            $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

        // crear path del año si no existiera
            if (ftp_nlist($ftp_connection, "ERP/INTERVENCIONES".$pathYear) === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, "ERP/INTERVENCIONES".$pathYear)) {
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
            
        
        if ($_POST['int_proyectos'] != "") {
            $proyectoid = $_POST['int_proyectos'];
        }
        else {
            $proyectoid = "null";
        }
        if ($_POST['int_ofertas'] != "") {
            $ofertaid = $_POST['int_ofertas'];
        }
        else {
            $ofertaid = "null";
        }
        if ($_POST['int_clientes'] != "") {
            $clienteid = $_POST['int_clientes'];
        }
        else {
            $clienteid = "null";
        }
        if ($_POST['int_estados'] != "") {
            $estadoid = $_POST['int_estados'];
        }
        else {
            $estadoid = "null";
        }        
        if ($_POST['int_chkfacu'] == true) {
            $facturable = 1;
        }
        else {
            $facturable = 0;
        }
        
        $sql = "INSERT INTO INTERVENCIONES (
                    nombre,
                    descripcion,
                    ref, 
                    fecha,
                    fecha_mod,
                    fecha_factu,
                    proyecto_id,
                    oferta_id,
                    cliente_id,
                    tecnico_id,
                    instalacion,
                    estado_id,
                    facturable
                    )
                VALUES (
                    '".$_POST["int_nombre"]."',
                    '".$_POST["int_desc"]."',
                    '".$REF."',
                    '".$_POST["int_fecha"]."',
                    now(),
                    '".$_POST["int_fecha_factu"]."',
                    ".$proyectoid.",
                    ".$ofertaid.",
                    ".$clienteid.",
                    ".$_POST['int_responsable'].",
                    '".$_POST["int_instalacion"]."',
                    ".$estadoid.",
                    ".$facturable."
                    )";
        file_put_contents("insertInt.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar la Intervención");
        
        $sql = "SELECT id FROM INTERVENCIONES ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el id Intervencion");
        $registros = mysqli_fetch_row ($result);
        $idInt = $registros[0];
        
        if ($_POST["int_addtecnicos"] != "") {
            foreach ($_POST["int_addtecnicos"] as $value) {
                // Asignaremos los expedientes al proyecto que estamos editando
                $sql = "INSERT INTO INTERVENCIONES_TECNICOS (int_id, erpuser_id) VALUES ('".$idInt."', ".$value.")";
                $result = mysqli_query($connString, $sql) or die("Error al asignar Tecnicos");
            }
        }
        
        echo $idInt;
    }
    
    function updateInt() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM INTERVENCIONES_TECNICOS WHERE int_id = ".$_POST['int_edit_idint'];
        $result = mysqli_query($connString, $sql) or die("Error al desasignar Técnicos");
        if ($_POST["int_edit_tecnicosint"] != "") {
            foreach ($_POST["int_edit_tecnicosint"] as $value) {
                // Asignaremos los expedientes al proyecto que estamos editando
                $sql = "INSERT INTO INTERVENCIONES_TECNICOS (erpuser_id, int_id) VALUES (".$value.", ".$_POST['int_edit_idint'].")";
                //file_put_contents("insertTec.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al asignar Técnicos");
            }
        }
        
        if ($_POST['int_edit_proyectos'] != "") {
            $proyectoid = $_POST['int_edit_proyectos'];
        }
        else {
            $proyectoid = "null";
        }
        if ($_POST['int_edit_ofertas'] != "") {
            $ofertaid = $_POST['int_edit_ofertas'];
        }
        else {
            $ofertaid = "null";
        }
        if ($_POST['int_edit_clientes'] != "") {
            $clienteid = $_POST['int_edit_clientes'];
        }
        else {
            $clienteid = "null";
        }
        if ($_POST['int_edit_estados'] != "") {
            $estadoid = $_POST['int_edit_estados'];
        }
        else {
            $estadoid = "null";
        } 
        if ($_POST['int_edit_tecnicos'] != "") {
            $tecnicoid = $_POST['int_edit_tecnicos'];
        }
        else {
            $tecnicoid = "null";
        }     
        if ($_POST['int_edit_chkfacu'] == true) {
            $facturable = 1;
        }
        else {
            $facturable = 0;
        }
        
        $sql = "UPDATE INTERVENCIONES 
                SET nombre = '".$_POST['int_edit_titulo']."', 
                    descripcion = '".$_POST['int_edit_desc']."',
                    fecha = '".$_POST['int_edit_fecha']."',  
                    fecha_mod = now(), 
                    fecha_factu = '".$_POST['int_edit_fecha_factu']."', 
                    proyecto_id = ".$proyectoid.", 
                    oferta_id = ".$ofertaid.", 
                    cliente_id = ".$clienteid.", 
                    instalacion = '".$_POST['int_edit_instalacion']."', 
                    estado_id = ".$estadoid.",
                    tecnico_id = ".$tecnicoid.",
                    facturable = ".$facturable."
                WHERE id = ".$_POST['int_edit_idint'];
        //file_put_contents("updateParte.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Intervención");
    }

    function delInt($int_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "SELECT id FROM INTERVENCIONES_DETALLES WHERE int_id=".$int_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Detalles de la Intervención");
        while( $row = mysqli_fetch_array($result) ) {
            $sql = "DELETE FROM INTERVENCIONES_DETALLES_TECNICOS WHERE intdetalle_id=".$row[0];
            $result = mysqli_query($connString, $sql) or die("Error al eliminar los Tecnicos del Detalle de la Intervención");
        }
        
        $sql = "DELETE FROM INTERVENCIONES_DETALLES WHERE int_id=".$int_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Detalles de la Intervención");
        
        $sql = "DELETE FROM INTERVENCIONES_TECNICOS WHERE int_id=".$int_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Técnicos de la Intervención");
        
        $sql = "DELETE FROM INTERVENCIONES_DOC WHERE int_id=".$int_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Documentos de la Intervención");
        
        $sql = "DELETE FROM INTERVENCIONES WHERE id=".$int_id;
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Intervención");
    }
?>
	