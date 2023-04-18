<?php
    session_start();
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['horasint_deldetalle'] != "") {
        delDetalleHoras($_POST['horasint_deldetalle']);
    }    
    else {
        if ($_POST['horasint_detalle_id'] != "") {
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
        
        $sql = "INSERT INTO INTERVENCIONES_HORAS_IMPUTADAS 
                    (tarea_id,
                    tipo_hora_id,
                    int_id,
                    titulo,
                    descripcion,
                    cantidad,
                    tecnico_id,
                    fecha
                    )
                VALUES (".$_POST['horasint_tareas'].",
                ".$_POST['horasint_horas'].",
                ".$_POST['horasint_int'].",
                '".$_POST['horasint_titulo']."',
                '".$_POST['horasint_descripcion']."',
                ".$_POST['horasint_cantidad'].",
                ".$_SESSION['user_session'].",
                '".$_POST['horasint_fecha']."')";
        file_put_contents("insertHorasInt.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar las Horas");
    }
    
    function updateDetalleHoras() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE INTERVENCIONES_HORAS_IMPUTADAS 
                SET tarea_id = ".$_POST['horasint_tareas'].", 
                    tipo_hora_id = ".$_POST['horasint_horas'].", 
                    int_id = ".$_POST['horasint_int'].", 
                    titulo = '".$_POST['horasint_titulo']."', 
                    descripcion = '".$_POST['horasint_descripcion']."', 
                    cantidad = ".$_POST['horasint_cantidad'].",  
                    tecnico_id = ".$_SESSION['user_session'].", 
                    fecha = '".$_POST['horasint_fecha']."' 
                WHERE id = ".$_POST['horasint_detalle_id'];
        //file_put_contents("updateHoras.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar las Horas");
    }

    function delDetalleHoras($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE FROM INTERVENCIONES_HORAS_IMPUTADAS WHERE id=".$detalle_id;
        //file_put_contents("deleteHoras.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar las Horas");
    }
?>
	