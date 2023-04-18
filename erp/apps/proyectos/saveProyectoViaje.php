
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['proyectoviajes_deldetalle'] != "") {
        delDetalleOferta($_POST['proyectoviajes_deldetalle']);
    }    
    else {
        if ($_POST['proyectoviajes_detalle_id'] != "") {
            updateDetalleOferta();
        }
        else {
            insertDetalleOferta();
        }
    }
    
    function insertDetalleOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        
        $sql = "INSERT INTO PROYECTOS_DETALLES_VIAJES 
                    (proyecto_id,
                    titulo,
                    descripcion,
                    unitario,
                    cantidad,
                    iva,
                    pvp,
                    pvp_total
                    )
                VALUES (".$_POST['proyectoviajes_proyecto_id'].",
                '".$_POST['proyectoviajes_titulo']."',
                '".$_POST['proyectoviajes_descripcion']."',
                ".$_POST['proyectoviajes_unitario'].",
                ".$_POST['proyectoviajes_cantidad'].",
                ".$_POST['proyectoviajes_iva'].",
                ".$_POST['proyectoviajes_pvp'].",
                ".$_POST['proyectoviajes_pvp_total'].")";
        //file_put_contents("insertProyectoViajes.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
    }
    
    function updateDetalleOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE PROYECTOS_DETALLES_VIAJES 
                SET oferta_id = ".$_POST['proyectoviajes_proyecto_id'].", 
                    titulo = '".$_POST['proyectoviajes_titulo']."', 
                    descripcion = '".$_POST['proyectoviajes_descripcion']."', 
                    unitario = ".$_POST['proyectoviajes_unitario'].", 
                    cantidad = ".$_POST['proyectoviajes_cantidad'].",  
                    incremento = ".$_POST['proyectoviajes_iva'].", 
                    pvp = ".$_POST['proyectoviajes_pvp'].", 
                    pvp_total = ".$_POST['proyectoviajes_pvp_total']." 
                WHERE id = ".$_POST['proyectoviajes_detalle_id'];
        //file_put_contents("updateProyectoViaje.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
    }

    function delDetalleOferta($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sqlSel = "SELECT PROYECTOS_DETALLES_VIAJES.of_det_id FROM PROYECTOS_DETALLES_VIAJES WHERE PROYECTOS_DETALLES_VIAJES.id=".$detalle_id;
        $resSel = mysqli_query($connString, $sqlSel) or die("Error al seleccionar el Detalle");
        $regSel = mysqli_fetch_array($resSel);
        
        $sqlUpdate = "UPDATE OFERTAS_DETALLES_VIAJES SET added=0 WHERE id=".$regSel[0];
        $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar el Detalle de la oferta");
        
        $sql = "delete from PROYECTOS_DETALLES_VIAJES WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	