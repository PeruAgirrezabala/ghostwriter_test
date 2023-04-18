
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");

    if ($_POST['acta_delacta'] != "") {
        deleteActa();
    }
    else {
        if ($_POST['addActa_id'] != "") {
            updateActa();
        }  
        else {
            insertActa();
        }
    }
    
    
    function updateActa () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CALIDAD_ACTAS SET 
                        nombre = '".$_POST['addActa_nombre']."', 
                        descripcion = '".$_POST['addActa_descripcion']."', 
                        fecha = '".$_POST['addActa_fecha']."'
                    WHERE id =".$_POST['addActa_id'];
        file_put_contents("updateActa.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Acta. UPDATE");
    }
        
    function insertActa () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO CALIDAD_ACTAS 
                            (nombre,
                            descripcion,
                            fecha) 
                       VALUES (
                            '".$_POST['addActa_nombre']."', 
                            '".$_POST['addActa_descripcion']."',
                            '".$_POST['addActa_fecha']."'
                        )";
        file_put_contents("insertActa.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Acta. INSERT");
    }
    function deleteActa () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CALIDAD_ACTAS WHERE id = ".$_POST['acta_delacta'];        
        file_put_contents("delActa.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Acta");
    }
   
?>
	