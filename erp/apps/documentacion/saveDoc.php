
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

    if ($_POST['newdoc_deldoc'] != "") {
        deleteDoc();
    }
    else {
        if ($_POST['newdoc_iddoc'] != "") {
            updateDoc();
        }  
        else {
            insertDoc();
        }
    }
    
    
    function updateDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE DOCUMENTACION SET 
                        nombre = '".$_POST['newdoc_nombre']."', 
                        descripcion = '".$_POST['newdoc_desc']."', 
                        ref = '".$_POST['newdoc_REF']."',
                        tipodoc_id = ".$_POST['newdoc_tipo']."
                    WHERE id =".$_POST['newdoc_iddoc'];
        file_put_contents("updateDocumento.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento");
    }
        
    function insertDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO DOCUMENTACION 
                            (nombre,
                            descripcion,
                            ref,
                            tipodoc_id) 
                       VALUES (
                            '".$_POST['newdoc_nombre']."', 
                            '".$_POST['newdoc_desc']."', 
                            '".$_POST['newdoc_REF']."',
                            ".$_POST['newdoc_tipo']."
                        )";
        file_put_contents("insertDocumento.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento");
    }
    
    function deleteDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM DOCUMENTACION_VERSIONES WHERE proc_id = ".$_POST['newdoc_deldoc'];
        file_put_contents("delDocumentoVer.txt", $sql);
        $result = mysqli_query($connString, $sql);

        $sql = "DELETE FROM DOCUMENTACION WHERE id = ".$_POST['newdoc_deldoc'];
        file_put_contents("delDocumento.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Documento");
    }
   
?>
	