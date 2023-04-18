
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");

    if ($_POST['acta_delformacion'] != "") {
        deleteFormacion();
    }
    else {
        if ($_POST['addFormacion_id'] != "") {
            updateFormacion();
        }  
        else {
            insertFormacion();
        }
    }
    
    
    function updateFormacion () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CALIDAD_FORMACION SET 
                        nombre = '".$_POST['addFormacion_nombre']."', 
                        descripcion = '".$_POST['addFormacion_descripcion']."',
                        fecha = '".$_POST['addFormacion_fecha']."'
                    WHERE id =".$_POST['addFormacion_id'];
        file_put_contents("updateFormacion.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la formación. UPDATE");
    }
        
    function insertFormacion () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO CALIDAD_FORMACION 
                            (nombre,
                            descripcion,
                            fecha) 
                       VALUES (
                            '".$_POST['addFormacion_nombre']."', 
                            '".$_POST['addFormacion_descripcion']."',
                            '".$_POST['addFormacion_fecha']."'    
                        )";
        file_put_contents("insertFormacion.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la formación. INSERT");
    }
    function deleteFormacion () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CALIDAD_FORMACION WHERE id = ".$_POST['acta_delformacion'];        
        file_put_contents("delFormacion.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la formación");
    }
   
?>
	