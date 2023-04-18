
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['ofertaotros_deldetalle'] != "") {
        delDetalleOferta($_POST['ofertaotros_deldetalle']);
    }    
    else {
        if ($_POST['ofertaotros_detalle_id'] != "") {
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
        
        
        $sql = "INSERT INTO OFERTAS_DETALLES_OTROS 
                    (oferta_id,
                    titulo,
                    descripcion,
                    unitario,
                    cantidad,
                    incremento,
                    pvp,
                    pvp_total
                    )
                VALUES (".$_POST['ofertaotros_oferta_id'].",
                '".$_POST['ofertaotros_titulo']."',
                '".$_POST['ofertaotros_descripcion']."',
                ".$_POST['ofertaotros_unitario'].",
                ".$_POST['ofertaotros_cantidad'].",
                ".$_POST['ofertaotros_inc'].",
                ".$_POST['ofertaotros_pvp'].",
                ".$_POST['ofertaotros_pvp_total'].")";
        file_put_contents("insertofertaotros.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
    }
    
    function updateDetalleOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE OFERTAS_DETALLES_OTROS 
                SET oferta_id = ".$_POST['ofertaotros_oferta_id'].", 
                    titulo = '".$_POST['ofertaotros_titulo']."', 
                    descripcion = '".$_POST['ofertaotros_descripcion']."', 
                    unitario = ".$_POST['ofertaotros_unitario'].", 
                    cantidad = ".$_POST['ofertaotros_cantidad'].",  
                    incremento = ".$_POST['ofertaotros_inc'].", 
                    pvp = ".$_POST['ofertaotros_pvp'].", 
                    pvp_total = ".$_POST['ofertaotros_pvp_total']." 
                WHERE id = ".$_POST['ofertaotros_detalle_id'];
        file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
    }

    function delDetalleOferta($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from OFERTAS_DETALLES_OTROS WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	