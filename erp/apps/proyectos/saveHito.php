
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['hito_deldetalle'] != "") {
        delDetalleHito($_POST['hito_deldetalle']);
    }    
    else {
        if ($_POST['hito_detalle_id'] != "") {
            updateDetalleHito();
        }
        else {
            insertDetalleHito();
        }
    }
    
    function insertDetalleHito() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        if ($_POST['hito_tecnicos'] == "") {
            $tecnico_id = "null";
        }
        else {
            $tecnico_id = $_POST['hito_tecnicos'];
        }
        if ($_POST['hito_estados'] == "") {
            $estado_id = "1";
        }
        else {
            $estado_id = $_POST['hito_estados'];
        }
        
        $sql = "INSERT INTO PROYECTOS_HITOS 
                    (proyecto_id,
                    nombre,
                    descripcion,
                    erpuser_id,
                    fecha_entrega,
                    fecha_realizacion,
                    observaciones,
                    estado_id
                    )
                VALUES (".$_POST['hito_proyecto_id'].",
                '".$_POST['hito_nombre']."',
                '".$_POST['hito_descripcion']."',
                ".$tecnico_id.",
                '".$_POST['hito_fecha_entrega']."',
                '".$_POST['hito_fecha_realizacion']."',
                '".$_POST['hito_observaciones']."',
                ".$estado_id.")";
        //file_put_contents("insertHIto.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Hito");
        
    }
    
    function updateDetalleHito() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['hito_tecnicos'] == "") {
            $tecnico_id = "null";
        }
        else {
            $tecnico_id = $_POST['hito_tecnicos'];
        }
        if ($_POST['hito_estados'] == "") {
            $estado_id = "1";
        }
        else {
            $estado_id = $_POST['hito_estados'];
        }
        
        $sql = "UPDATE PROYECTOS_HITOS 
                SET proyecto_id = ".$_POST['hito_proyecto_id'].", 
                    nombre = '".$_POST['hito_nombre']."', 
                    descripcion = '".$_POST['hito_descripcion']."', 
                    erpuser_id = ".$tecnico_id.", 
                    fecha_entrega = '".$_POST['hito_fecha_entrega']."', 
                    fecha_realizacion = '".$_POST['hito_fecha_realizacion']."', 
                    observaciones = '".$_POST['hito_observ']."', 
                    estado_id = ".$estado_id." 
                WHERE id = ".$_POST['hito_detalle_id'];
        //file_put_contents("updateHito.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Hito");
    }

    function delDetalleHito($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE FROM PROYECTOS_HITOS WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Hito");
    }
?>
	