<?php
    session_start();
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['int_edit_delintmat'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delIntMat($_POST['int_edit_delintmat']);
    }    
    else {
        insertIntMat();
    }
    
    function insertIntMat() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO INTERVENCIONES_MATERIALES (
                    material_id,
                    int_id
                    )
                VALUES (
                    ".$_POST["intmaterial_materiales"].",
                    ".$_POST["intmaterial_int_id"].")";
        file_put_contents("insertIntMat.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
        
    }
    
    function delIntMat($int_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE FROM INTERVENCIONES_MATERIALES WHERE id=".$int_id;
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el material");
    }
?>
	