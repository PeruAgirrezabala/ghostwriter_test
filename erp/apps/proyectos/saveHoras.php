
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['horas_deldetalle'] != "") {
        delDetalleHoras($_POST['horas_deldetalle']);
    }    
    else {
        if ($_POST['horas_detalle_id'] != "") {
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
        
        $sql = "INSERT INTO PROYECTOS_HORAS_IMPUTADAS 
                    (tarea_id,
                    tipo_hora_id,
                    proyecto_id,
                    titulo,
                    descripcion,
                    cantidad,
                    tecnico_id,
                    fecha
                    )
                VALUES (".$_POST['horas_tareas'].",
                ".$_POST['horas_horas'].",
                ".$_POST['horas_proyecto_id'].",
                '".$_POST['horas_titulo']."',
                '".$_POST['horas_descripcion']."',
                ".$_POST['horas_cantidad'].",
                ".$_POST['horas_tecnicos'].",
                '".$_POST['horas_fecha']."')";
        file_put_contents("insertHoras.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar las Horas");
    }
    
    function updateDetalleHoras() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if($_POST['horas_horas']==""){
            $tipo = "";
        }else{
            $tipo = " tipo_hora_id = ".$_POST['horas_horas'].",  ";
        }
        
        if($_POST['horas_tareas']==""){
            $tareas = "";
        }else{
            $tareas = " tarea_id = ".$_POST['horas_tareas'].",  ";
        }
        
        if($_POST['horas_tecnicos']==""){
            $tecnico = "";
        }else{
            $tecnico = " tecnico_id = ".$_POST['horas_tecnicos'].",  ";
        }
        
        $sql = "UPDATE PROYECTOS_HORAS_IMPUTADAS 
                SET ". $tareas ." 
                    ". $tipo ." 
                    titulo = '".$_POST['horas_titulo']."', 
                    descripcion = '".$_POST['horas_descripcion']."', 
                    cantidad = ".$_POST['horas_cantidad'].",  
                    ". $tecnico ." 
                    fecha = '".$_POST['horas_fecha']."' 
                WHERE id = ".$_POST['horas_detalle_id'];
        file_put_contents("updateHoras.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al actualizar las Horas");
    }

    function delDetalleHoras($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE FROM PROYECTOS_HORAS_IMPUTADAS WHERE id=".$detalle_id;
        //file_put_contents("deleteHoras.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar las Horas");
    }
?>
	