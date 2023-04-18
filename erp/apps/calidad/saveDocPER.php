
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['newdocPER_delid'] != "") {
        deleteDocPER();
    }
    else {
        if ($_POST['newdocPER_id'] != "") {
            updateDocPER();
        }  
        else {
            insertDocPER();
        }
    }
    
    function updateDocPER () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE USERS_DOC SET 
                        nombre = '".$_POST['newdocPER_nombre']."', 
                        descripcion = '".$_POST['newdocPER_desc']."',
                        erpuser_id = ".$_POST['newdocPER_trabajadores'].", 
                        org_id = ".$_POST['newdocPER_organismo'].", 
                        periodicidad_id = ".$_POST['newdocPER_periodicidades']."
                    WHERE id =".$_POST['newdocPER_id'];
        file_put_contents("updateDocUSERS.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Personal");
    }
    
    function insertDocPER () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        /*
        $nombre = str_replace(" ", "_", $_POST['proyecto_gruposdocnombre']);
        
        // file paths to store
            $basepath = "PROYECTOS".$_POST['gruposdoc_proyectopath'].$nombre."/";
            $ftp_server = "192.168.3.108";
            $ftp_username = "admin";
            $ftp_password = "Sistemas2111";
            ///share/MD0_DATA/Download/

        // connection to ftp
            $ftp_connection = ftp_connect($ftp_server);
            $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

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
        */
        // SI NO SE HA SELECCIONADO NINGUN TRABAJADOR SE LO ASIGNO A TODOS
        if ($_POST['newdocPER_trabajadores'] == "") {
            $sql = "SELECT id FROM erp_users ORDER BY id ASC";

            $resultado = mysqli_query($connString, $sql) or die("Error al consultar los Trabajadores");
            while ($registros = mysqli_fetch_array($resultado)) {
                $sql2 = "INSERT INTO USERS_DOC 
                                (nombre,
                                descripcion,
                                erpuser_id,
                                org_id,
                                periodicidad_id) 
                           VALUES (
                                '".$_POST['newdocPER_nombre']."', 
                                '".$_POST['newdocPER_descripcion']."', 
                                ".$registros[0].", 
                                ".$_POST['newdocPER_organismo'].", 
                                ".$_POST['newdocPER_periodicidades'].")";
                $result2 = mysqli_query($connString, $sql2) or die("Error al guardar el Documento Personal");
            }
            echo 1;
        }
        else {
            $sql = "INSERT INTO USERS_DOC 
                                (nombre,
                                descripcion,
                                erpuser_id,
                                org_id,
                                periodicidad_id) 
                           VALUES (
                                '".$_POST['newdocPER_nombre']."', 
                                '".$_POST['newdocPER_descripcion']."', 
                                ".$_POST['newdocPER_trabajadores'].", 
                                ".$_POST['newdocPER_organismo'].", 
                                ".$_POST['newdocPER_periodicidades'].")";
            file_put_contents("insertDocUSERS.txt", $sql);
            echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Personal");
        }
    }
   
   

    function deleteDocPER () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM USERS_DOC_VERSIONES WHERE doc_id = ".$_POST['newdocPER_delid'];
        $sql = "DELETE FROM USERS_DOC_VERSIONES WHERE id=".$_POST['newdocPER_delid'];
        //file_put_contents("delGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Documento Personal");
    }
?>
	