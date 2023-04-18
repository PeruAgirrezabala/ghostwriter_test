
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['newdocPRL_delid'] != "") {
        deleteDocPRL();
    }
    else {
        if ($_POST['newdocPRL_id'] != "") {
            updateDocPRL();
        }  
        else {
            insertDocPRL();
        }
    }
    
    function updateDocPRL () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE PRL_DOC SET 
                        nombre = '".$_POST['newdocPRL_nombre']."', 
                        descripcion = '".$_POST['newdocPRL_desc']."',
                        empresa_id = ".$_POST['newdocPRL_empresas'].", 
                        org_id = ".$_POST['newdocPRL_organismo'].", 
                        periodicidad_id = ".$_POST['newdocPRL_periodicidades']."
                    WHERE id =".$_POST['newdocPRL_id'];
        file_put_contents("updateDocPRL.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Prevencion");
    }
    
    function insertDocPRL () {
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
        
        $sql = "INSERT INTO PRL_DOC 
                            (nombre,
                            descripcion,
                            empresa_id,
                            org_id,
                            periodicidad_id) 
                       VALUES (
                            '".$_POST['newdocPRL_nombre']."', 
                            '".$_POST['newdocPRL_descripcion']."', 
                            ".$_POST['newdocPRL_empresas'].", 
                            ".$_POST['newdocPRL_organismo'].", 
                            ".$_POST['newdocPRL_periodicidades'].")";
        file_put_contents("insertDocPRL.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Prevencion");
    }
   
   

    function deleteDocPRL () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM PRL_DOC_VERSIONES WHERE doc_id = ".$_POST['newdocPRL_delid'];
        $sql = "DELETE FROM PRL_DOC WHERE id=".$_POST['newdocPRL_delid'];
        //file_put_contents("delGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Documento Prevencion");
    }
?>
	