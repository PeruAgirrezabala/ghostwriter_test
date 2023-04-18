
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['gruposdoc_del'] != "") {
        deleteGrupoDoc();
    }
    else {
        if ($_POST['gruposdoc_idgrupo'] != "") {
            updateGrupoDoc();
        }  
        else {
            insertGrupoDoc();
        }
    }
    
    function updateGrupoDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE GRUPOS_DOC SET 
                        nombre = '".$_POST['proyecto_gruposdocnombre']."', 
                        descripcion = '".$_POST['proyecto_gruposdocdesc']."' 
                    WHERE id =".$_POST['gruposdoc_idgrupo'];
        //file_put_contents("updateGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Grupo");
    }
    
    function insertGrupoDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
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
        
        $sql = "INSERT INTO GRUPOS_DOC 
                            (nombre,
                            descripcion,
                            proyecto_id) 
                       VALUES (
                            '".$nombre."',  
                            '".$_POST['proyecto_gruposdocdesc']."', 
                            ".$_POST['gruposdoc_proyecto_id'].")";
        //file_put_contents("insertGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Grupo");
    }
   
   

    function deleteGrupoDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM GRUPOS_DOC WHERE id=".$_POST['gruposdoc_del'];
        //file_put_contents("delGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Grupo");
    }
?>
	