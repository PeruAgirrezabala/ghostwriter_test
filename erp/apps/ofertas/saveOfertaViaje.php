
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['ofertaviajes_deldetalle'] != "") {
        delDetalleOferta($_POST['ofertaviajes_deldetalle']);
    }    
    else {
        if ($_POST['ofertaviajes_detalle_id'] != "") {
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
        
        
        $sql = "INSERT INTO OFERTAS_DETALLES_VIAJES 
                    (oferta_id,
                    titulo,
                    descripcion,
                    unitario,
                    cantidad,
                    incremento,
                    pvp,
                    pvp_total
                    )
                VALUES (".$_POST['ofertaviajes_oferta_id'].",
                '".$_POST['ofertaviajes_titulo']."',
                '".$_POST['ofertaviajes_descripcion']."',
                ".$_POST['ofertaviajes_unitario'].",
                ".$_POST['ofertaviajes_cantidad'].",
                ".$_POST['ofertaviajes_inc'].",
                ".$_POST['ofertaviajes_pvp'].",
                ".$_POST['ofertaviajes_pvp_total'].")";
        //file_put_contents("insertofertaviajes.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
    }
    
    function updateDetalleOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE OFERTAS_DETALLES_VIAJES 
                SET oferta_id = ".$_POST['ofertaviajes_oferta_id'].", 
                    titulo = '".$_POST['ofertaviajes_titulo']."', 
                    descripcion = '".$_POST['ofertaviajes_descripcion']."', 
                    unitario = ".$_POST['ofertaviajes_unitario'].", 
                    cantidad = ".$_POST['ofertaviajes_cantidad'].",  
                    incremento = ".$_POST['ofertaviajes_inc'].", 
                    pvp = ".$_POST['ofertaviajes_pvp'].", 
                    pvp_total = ".$_POST['ofertaviajes_pvp_total']." 
                WHERE id = ".$_POST['ofertaviajes_detalle_id'];
        //file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
    }

    function delDetalleOferta($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from OFERTAS_DETALLES_VIAJES WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	