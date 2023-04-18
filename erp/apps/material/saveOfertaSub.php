
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['ofertasub_deldetalle'] != "") {
        delDetalleOferta($_POST['ofertasub_deldetalle']);
    }    
    else {
        if ($_POST['ofertasub_detalle_id'] != "") {
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
        
        
        $sql = "INSERT INTO OFERTAS_DETALLES_TERCEROS 
                    (tercero_id,
                    oferta_id,
                    titulo,
                    descripcion,
                    unitario,
                    cantidad,
                    dto1,
                    incremento,
                    pvp,
                    pvp_dto,
                    pvp_total
                    )
                VALUES (".$_POST['ofertasub_terceros'].",
                ".$_POST['ofertasub_oferta_id'].",
                '".$_POST['ofertasub_titulo']."',
                '".$_POST['ofertasub_descripcion']."',
                ".$_POST['ofertasub_unitario'].",
                ".$_POST['ofertasub_cantidad'].",
                ".$_POST['ofertasub_dto'].",
                ".$_POST['ofertasub_incremento'].",
                ".$_POST['ofertasub_pvp'].",
                ".$_POST['ofertasub_pvpdto'].",
                ".$_POST['ofertasub_pvpinc'].")";
        file_put_contents("insertofertasub.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
    }
    
    function updateDetalleOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE OFERTAS_DETALLES_TERCEROS 
                SET tercero_id = ".$_POST['ofertasub_terceros'].", 
                    oferta_id = ".$_POST['ofertasub_oferta_id'].", 
                    titulo = '".$_POST['ofertasub_titulo']."', 
                    descripcion = '".$_POST['ofertasub_descripcion']."', 
                    unitario = ".$_POST['ofertasub_unitario'].", 
                    cantidad = ".$_POST['ofertasub_cantidad'].",  
                    dto1 = ".$_POST['ofertasub_dto'].", 
                    incremento = ".$_POST['ofertasub_incremento'].", 
                    pvp = ".$_POST['ofertasub_pvp'].", 
                    pvp_dto = ".$_POST['ofertasub_pvpdto'].", 
                    pvp_total = ".$_POST['ofertasub_pvpinc']." 
                WHERE id = ".$_POST['ofertasub_detalle_id'];
        file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
    }

    function delDetalleOferta($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from OFERTAS_DETALLES_TERCEROS WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	