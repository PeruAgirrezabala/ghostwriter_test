
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['orden_deldetalle'] != "") {
        delDetalleOrden($_POST['orden_deldetalle']);
    }    
    else {
        if ($_POST['orden_detalle_id'] != "") {
            updateDetalleOrden();
        }
        else {
            insertDetalleOrden();
        }
    }
    
    function insertDetalleOrden() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        
        $sql = "INSERT INTO PROYECTOS_TAREAS 
                    (tarea_id,
                    tipo_hora_id,
                    proyecto_id,
                    titulo,
                    descripcion,
                    cantidad,
                    tecnico_id,
                    fecha_entrega
                    )
                VALUES (".$_POST['orden_tareas'].",
                ".$_POST['orden_horas'].",
                ".$_POST['orden_proyecto_id'].",
                '".$_POST['orden_titulo']."',
                '".$_POST['orden_descripcion']."',
                ".$_POST['orden_cantidad'].",
                ".$_POST['orden_tecnicos'].",
                '".$_POST['orden_fecha_entrega']."')";
        //file_put_contents("insertOrden.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Orden");
        
    }
    
    function updateDetalleOrden() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE PROYECTOS_TAREAS 
                SET tarea_id = ".$_POST['orden_tareas'].", 
                    tipo_hora_id = ".$_POST['orden_horas'].", 
                    proyecto_id = ".$_POST['orden_proyecto_id'].", 
                    titulo = '".$_POST['orden_titulo']."', 
                    descripcion = '".$_POST['orden_descripcion']."', 
                    cantidad = ".$_POST['orden_cantidad'].",  
                    tecnico_id = ".$_POST['orden_tecnicos'].", 
                    fecha_entrega = '".$_POST['orden_fecha_entrega']."' 
                WHERE id = ".$_POST['orden_detalle_id'];
        //file_put_contents("updateOrden.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Orden");
    }

    function delDetalleOrden($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE FROM PROYECTOS_TAREAS WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Orden");
    }
?>
	