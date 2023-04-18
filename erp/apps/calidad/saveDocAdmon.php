
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['newdocADMON_delid'] != "") {
        deleteDocADMON();
    }
    else {
        if ($_POST['newdocADMON_id'] != "") {
            updateDocADMON();
        }  
        else {
            insertDocADMON();
        }
    }
    
    function updateDocADMON () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE ADMON_DOC SET 
                        nombre = '".$_POST['newdocADMON_nombre']."', 
                        descripcion = '".$_POST['newdocADMON_desc']."',
                        empresa_id = ".$_POST['newdocADMON_empresas'].", 
                        org_id = ".$_POST['newdocADMON_organismo'].", 
                        periodicidad_id = ".$_POST['newdocADMON_periodicidades']."
                    WHERE id =".$_POST['newdocADMON_id'];
        //file_put_contents("updateDocADMON.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Administrativo");
    }
    
    function insertDocADMON () {
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
        
        $sql = "INSERT INTO ADMON_DOC 
                            (nombre,
                            descripcion,
                            empresa_id,
                            org_id,
                            periodicidad_id) 
                       VALUES (
                            '".$_POST['newdocADMON_nombre']."', 
                            '".$_POST['newdocADMON_descripcion']."', 
                            ".$_POST['newdocADMON_empresas'].", 
                            ".$_POST['newdocADMON_organismo'].", 
                            ".$_POST['newdocADMON_periodicidades'].")";
        file_put_contents("insertDocADMON.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Administrativo");
    }
   
   

    function deleteDocADMON () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM ADMON_DOC_VERSIONES WHERE doc_id = ".$_POST['newdocADMON_delid'];
        $sql = "DELETE FROM ADMON_DOC WHERE id=".$_POST['newdocADMON_delid'];
        //file_put_contents("delGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Documento Administrativo");
    }
?>
	