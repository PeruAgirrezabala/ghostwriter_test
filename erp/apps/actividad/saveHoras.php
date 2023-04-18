
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['actdetallehoras_delhora'] != "") {
        delDetalleHoras($_POST['actdetallehoras_delhora']);
    }    
    else {
        if ($_POST['actdetallehoras_hora_id'] != "") {
            updateDetalleHoras();
        }
        else {
            insertDetalleHoras();
        }
    }
    
    function insertDetalleHoras() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sql = "INSERT INTO ACTIVIDAD_DETALLES_HORAS 
                    (actividad_detalle_id,
                    tipo_hora_id,
                    cantidad,
                    tecnico_id
                    )
                VALUES (".$_POST['actdetallehoras_detalle_id'].",
                ".$_POST['actdetallehoras_tipo'].",
                ".$_POST['actdetallehoras_cantidad'].",
                '".$_POST['actdetallehoras_tecnicos']."')";
        file_put_contents("insertHoras.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar las Horas");
    }
    
    function updateDetalleHoras() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE ACTIVIDAD_DETALLES_HORAS 
                SET actividad_detalle_id = ".$_POST['actdetallehoras_detalle_id'].", 
                    tipo_hora_id = ".$_POST['actdetallehoras_tipo'].", 
                    cantidad = ".$_POST['actdetallehoras_cantidad'].", 
                    tecnico_id = '".$_POST['actdetallehoras_tecnicos']."' 
                WHERE id = ".$_POST['actdetallehoras_hora_id'];
        //file_put_contents("updateHoras.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar las Horas");
    }

    function delDetalleHoras($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE FROM ACTIVIDAD_DETALLES_HORAS WHERE id=".$detalle_id;
        //file_put_contents("deleteHoras.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar las Horas");
    }
?>
	