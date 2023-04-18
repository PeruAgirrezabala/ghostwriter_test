<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['actdetalle_deldetalle'] != "") {
        delDetalleAct($_POST['actdetalle_deldetalle']);
    }else{
        if ($_POST['actdetalle_detalle_id'] != "") {
            updateDetalleAct();
        }else{
            if($_POST['actdetalle_estado_id'] != ""){
                updateDetalleActEstado();
            }else{
                insertDetalleAct();
            }
        }
    }
    
    function insertDetalleAct() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        if($_POST['actdetalle_completado']!=""){
            $completado=$_POST['actdetalle_completado'];
        }else{
            $completado=0;
        }
        
        $sql = "INSERT INTO ACTIVIDAD_DETALLES 
                    (nombre,
                    descripcion,
                    fecha,
                    fecha_mod,
                    actividad_id,
                    erpuser_id,
                    completado
                    )
                VALUES ('".$_POST['actdetalle_nombre']."',
                '".$_POST['actdetalle_desc']."', 
                '".$_POST['actdetalle_fecha']."',
                now(),
                ".$_POST['actdetalle_act_id'].",
                ".$_POST['actdetalle_tecnicos'].",
                ".$completado.")";

        file_put_contents("insertActdetalle.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
        //mysqli_set_charset($connString, "utf8");
    }
    
    function updateDetalleAct() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE ACTIVIDAD_DETALLES 
                    SET nombre = '".$_POST['actdetalle_nombre']."', 
                        descripcion = '".$_POST['actdetalle_desc']."',
                        fecha = '".$_POST['actdetalle_fecha']."',  
                        fecha_mod = now(), 
                        completado = '".$_POST['actdetalle_completado']."',
                        erpuser_id = ".$_POST['actdetalle_tecnicos']."
                    WHERE id = ".$_POST['actdetalle_detalle_id'];
        
        file_put_contents("updateActDetalle.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        //mysqli_set_charset($connString, "utf8");
    }
    
    function delDetalleACt($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sql = "delete from ACTIVIDAD_DETALLES WHERE id=".$detalle_id;
        file_put_contents("detalleDel.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
    
    function updateDetalleActEstado(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // Get estado and +1  
        $sqlSel = "SELECT ACTIVIDAD_DETALLES.completado FROM ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES.id=".$_POST['actdetalle_estado_id'];
        //file_put_contents("selEstadoDet.txt", $sqlSel);
        $resSel = mysqli_query($connString, $sqlSel) or die("Error al seleccionar el estado/completado de la actividad");
        $regSel = mysqli_fetch_row ($resSel);
        
        $estado = $regSel[0];
        $estado++;
        
        // Si es mayor que 2, es 0
        if($estado>2){
            $estado=0;
        }
        
        $sqlUpdate="UPDATE ACTIVIDAD_DETALLES SET completado=".$estado." WHERE id=".$_POST['actdetalle_estado_id'];
        //file_put_contents("updateEstadoDet.txt", $sqlUpdate);
        echo $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar el estado/completado de la actividad");
        
        
    }
?>
	