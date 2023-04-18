
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

    if ($_POST['newplantilla_delplan'] != "") {
        deletePlan();
    }
    else {
        if ($_POST['newplantilla_idplan'] != "") {
            updatePlan();
        }  
        else {
            insertPlan();
        }
    }
    
    
    function updatePlan () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE PLANTILLAS SET 
                        nombre = '".$_POST['newplantilla_nombre']."', 
                        descripcion = '".$_POST['newplantilla_desc']."', 
                        ref = '".$_POST['newplantilla_REF']."',
                        tipodoc_id = ".$_POST['newplantilla_tipo']."
                    WHERE id =".$_POST['newplantilla_idplan'];
        file_put_contents("updatePlantilla.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Plantilla");
    }
        
    function insertPlan () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO PLANTILLAS 
                            (nombre,
                            descripcion,
                            ref,
                            tipodoc_id) 
                       VALUES (
                            '".$_POST['newplantilla_nombre']."', 
                            '".$_POST['newplantilla_desc']."', 
                            '".$_POST['newplantilla_REF']."',
                            ".$_POST['newplantilla_tipo']."
                        )";
        file_put_contents("insertPlantilla.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Plantilla");
    }
    
    function deletePlan () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM PLANTILLAS_VERSIONES WHERE plantilla_id = ".$_POST['newplantilla_delplan'];
        file_put_contents("delPlantillaVer.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar las versiones de la Plantilla");

        $sql = "DELETE FROM PLANTILLAS WHERE id = ".$_POST['newplantilla_delplan'];
        file_put_contents("delPlantilla.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Plantilla");
    }
   
?>
	