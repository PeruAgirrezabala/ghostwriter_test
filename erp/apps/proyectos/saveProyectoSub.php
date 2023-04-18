
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['proyectosub_deldetalle'] != "") {
        delDetalleProyecto($_POST['proyectosub_deldetalle']);
    }    
    else {
        if ($_POST['proyectosub_detalle_id'] != "") {
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
        
        
        $sql = "INSERT INTO PROYECTOS_DETALLES_TERCEROS 
                    (tercero_id,
                    proyecto_id,
                    titulo,
                    descripcion,
                    unitario,
                    cantidad,
                    dto1,
                    iva,
                    pvp,
                    pvp_dto,
                    pvp_total
                    )
                VALUES (".$_POST['proyectosub_terceros'].",
                ".$_POST['proyectosub_proyecto_id'].",
                '".$_POST['proyectosub_titulo']."',
                '".$_POST['proyectosub_descripcion']."',
                ".$_POST['proyectosub_unitario'].",
                ".$_POST['proyectosub_cantidad'].",
                ".$_POST['proyectosub_dto'].",
                ".$_POST['proyectosub_iva'].",
                ".$_POST['proyectosub_pvp'].",
                ".$_POST['proyectosub_pvpdto'].",
                ".$_POST['proyectosub_pvp_total'].")";
        //file_put_contents("insertProyectoSUB.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
    }
    
    function updateDetalleProyecto() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE PROYECTOS_DETALLES_TERCEROS 
                SET tercero_id = ".$_POST['proyectosub_terceros'].", 
                    oferta_id = ".$_POST['proyectosub_proyecto_id'].", 
                    titulo = '".$_POST['proyectosub_titulo']."', 
                    descripcion = '".$_POST['proyectosub_descripcion']."', 
                    unitario = ".$_POST['proyectosub_unitario'].", 
                    cantidad = ".$_POST['proyectosub_cantidad'].",  
                    dto1 = ".$_POST['proyectosub_dto'].", 
                    incremento = ".$_POST['proyectosub_iva'].", 
                    pvp = ".$_POST['proyectosub_pvp'].", 
                    pvp_dto = ".$_POST['proyectosub_pvpdto'].", 
                    pvp_total = ".$_POST['proyectosub_pvp_total']." 
                WHERE id = ".$_POST['proyectosub_detalle_id'];
        //file_put_contents("updateProyectoSUB.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
    }

    function delDetalleProyecto($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sqlSel = "SELECT PROYECTOS_DETALLES_TERCEROS.of_det_id FROM PROYECTOS_DETALLES_TERCEROS WHERE PROYECTOS_DETALLES_TERCEROS.id=".$detalle_id;
        $resSel = mysqli_query($connString, $sqlSel) or die("Error al seleccionar el Detalle");
        $regSel = mysqli_fetch_array($resSel);
        
        $sqlUpdate = "UPDATE OFERTAS_DETALLES_TERCEROS SET added=0 WHERE id=".$regSel[0];
        $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar el Detalle de la oferta");
        
        $sql = "delete from PROYECTOS_DETALLES_TERCEROS WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	