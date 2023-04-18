
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
        file_put_contents("updateGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Grupo");
    }
    
    function insertGrupoDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO GRUPOS_DOC 
                            (nombre,
                            descripcion,
                            proyecto_id) 
                       VALUES (
                            '".$_POST['proyecto_gruposdocnombre']."',  
                            '".$_POST['proyecto_gruposdocdesc']."', 
                            ".$_POST['gruposdoc_proyecto_id'].")";
        file_put_contents("insertGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Grupo");
    }
   
   

    function deleteGrupoDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM GRUPOS_DOC WHERE id=".$_POST['gruposdoc_del'];
        file_put_contents("delGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Grupo");
    }
?>
	