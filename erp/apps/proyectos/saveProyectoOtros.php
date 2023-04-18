
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['proyectootros_deldetalle'] != "") {
        delDetalleProyecto($_POST['proyectootros_deldetalle']);
    }    
    else {
        if ($_POST['proyectootros_detalle_id'] != "") {
            updateDetalleProyecto();
        }
        else {
            insertDetalleProyecto();
        }
    }
    
    function insertDetalleProyecto() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        
        $sql = "INSERT INTO PROYECTOS_DETALLES_OTROSGASTOS 
                    (proyecto_id,
                    titulo,
                    descripcion,
                    unitario,
                    cantidad,
                    iva,
                    pvp,
                    pvp_total
                    )
                VALUES (".$_POST['proyectootros_proyecto_id'].",
                '".$_POST['proyectootros_titulo']."',
                '".$_POST['proyectootros_descripcion']."',
                ".$_POST['proyectootros_unitario'].",
                ".$_POST['proyectootros_cantidad'].",
                ".$_POST['proyectootros_iva'].",
                ".$_POST['proyectootros_pvp'].",
                ".$_POST['proyectootros_pvp_total'].")";
        //file_put_contents("insertProyectoOtros.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
    }
    
    function updateDetalleProyecto() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE PROYECTOS_DETALLES_OTROSGASTOS 
                SET oferta_id = ".$_POST['proyectootros_oferta_id'].", 
                    titulo = '".$_POST['proyectootros_titulo']."', 
                    descripcion = '".$_POST['proyectootros_descripcion']."', 
                    unitario = ".$_POST['proyectootros_unitario'].", 
                    cantidad = ".$_POST['proyectootros_cantidad'].",  
                    incremento = ".$_POST['proyectootros_inc'].", 
                    pvp = ".$_POST['proyectootros_pvp'].", 
                    pvp_total = ".$_POST['proyectootros_pvp_total']." 
                WHERE id = ".$_POST['proyectootros_detalle_id'];
        //file_put_contents("updateProyectoOtros.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
    }

    function delDetalleProyecto($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sqlSel = "SELECT PROYECTOS_DETALLES_OTROSGASTOS.of_det_id FROM PROYECTOS_DETALLES_OTROSGASTOS WHERE PROYECTOS_DETALLES_OTROSGASTOS.id=".$detalle_id;
        $resSel = mysqli_query($connString, $sqlSel) or die("Error al seleccionar el Detalle");
        $regSel = mysqli_fetch_array($resSel);
        
        $sqlUpdate = "UPDATE OFERTAS_DETALLES_OTROS SET added=0 WHERE id=".$regSel[0];
        $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar el Detalle de la oferta");
        
        $sql = "delete from PROYECTOS_DETALLES_OTROSGASTOS WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	