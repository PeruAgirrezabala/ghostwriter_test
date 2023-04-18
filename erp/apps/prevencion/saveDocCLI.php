
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['newdocCLI_delid'] != "") {
        deleteDocCLI();
    }
    else {
        if ($_POST['newdocCLI_id'] != "") {
            updateDocCLI();
        }  
        else {
            insertDocCLI();
        }
    }
    
    function updateDocCLI () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CLIENTES_DOC SET 
                        nombre = '".$_POST['newdocCLI_nombre']."', 
                        descripcion = '".$_POST['newdocCLI_desc']."', 
                        cliente_id = ".$_POST['newdocCLI_clienteid'].", 
                        org_id = ".$_POST['newdocCLI_organismo'].", 
                        periodicidad_id = ".$_POST['newdocCLI_periodicidades']."
                    WHERE id =".$_POST['newdocCLI_id'];
        //file_put_contents("updateDocCLI.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Contratista");
    }
    
    function insertDocCLI () {
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
        
        $sql = "INSERT INTO CLIENTES_DOC 
                            (nombre,
                            descripcion,
                            cliente_id,
                            org_id,
                            periodicidad_id) 
                       VALUES (
                            '".$_POST['newdocCLI_nombre']."', 
                            '".$_POST['newdocCLI_descripcion']."', 
                            ".$_POST['newdocCLI_clienteid'].", 
                            ".$_POST['newdocCLI_organismo'].", 
                            ".$_POST['newdocCLI_periodicidades'].")";
        file_put_contents("insertDocCLI.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Contratista");
    }
   
   

    function deleteDocCLI () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CLIENTES_DOC_VERSIONES WHERE doc_id = ".$_POST['newdocCLI_delid'];
        $sql = "DELETE FROM CLIENTES_DOC WHERE id=".$_POST['newdocCLI_delid'];
        //file_put_contents("delGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Documento Contratista");
    }
?>
	