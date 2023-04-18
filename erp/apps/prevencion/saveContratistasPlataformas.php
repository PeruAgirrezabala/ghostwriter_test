
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['del_contratistaPlat'] != "") {
        deleteContratistaPlataforma();
    }
    else {
        if ($_POST['newcontratistas-plataformas-id'] != "") {
            updateContratistaPlataforma();
        }  
        else {
            insertContratistaPlataforma();
        }
    }
    
    function updateContratistaPlataforma () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CONTRATISTAS_PLATAFORMAS SET 
                        url = '".$_POST['newcontratistas-plataformas_url']."', 
                        instalacion = '".$_POST['newcontratistas-plataformas_instalacion']."', 
                        user = '".$_POST['newcontratistas-plataformas_usuario']."', 
                        pass = '".$_POST['newcontratistas-plataformas_pass']."', 
                        cliente_id = ".$_POST['newcontratistas-plataformas-cli']."
                    WHERE id =".$_POST['newcontratistas-plataformas-id'];
        file_put_contents("updateContratistasPlataformas.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al actualizar la Plataforma del Contratista");
    }
    
    function insertContratistaPlataforma () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO CONTRATISTAS_PLATAFORMAS 
                            (url,
                            instalacion,
                            user,
                            pass,
                            cliente_id) 
                       VALUES (
                            '".$_POST['newcontratistas-plataformas_url']."', 
                            '".$_POST['newcontratistas-plataformas_instalacion']."', 
                            '".$_POST['newcontratistas-plataformas_usuario']."', 
                            '".$_POST['newcontratistas-plataformas_pass']."', 
                            ".$_POST['newcontratistas-plataformas-cli'].")";
        file_put_contents("insertContratistaPlataforma.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Plataforma del Contratista");
    }
    
    function deleteContratistaPlataforma () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CONTRATISTAS_PLATAFORMAS WHERE id = ".$_POST['del_contratistaPlat'];
        //file_put_contents("delGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la plataforma del Contratista");
    }
?>
	