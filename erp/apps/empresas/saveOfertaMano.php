
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['ofertamano_deldetalle'] != "") {
        delDetalleOferta($_POST['ofertamano_deldetalle']);
    }    
    else {
        if ($_POST['ofertamano_detalle_id'] != "") {
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
        
        
        $sql = "INSERT INTO OFERTAS_DETALLES_HORAS 
                    (tarea_id,
                    tipo_hora_id,
                    oferta_id,
                    titulo,
                    descripcion,
                    cantidad,
                    dto,
                    pvp,
                    pvp_total
                    )
                VALUES (".$_POST['ofertamano_tareas'].",
                ".$_POST['ofertamano_horas'].",
                ".$_POST['ofertamano_oferta_id'].",
                '".$_POST['ofertamano_titulo']."',
                '".$_POST['ofertamano_descripcion']."',
                ".$_POST['ofertamano_cantidad'].",
                ".$_POST['ofertamano_dto'].",
                ".$_POST['ofertamano_pvp'].",
                ".$_POST['ofertamano_pvp_total'].")";
        //file_put_contents("insertofertamano.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
    }
    
    function updateDetalleOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE OFERTAS_DETALLES_HORAS 
                SET tarea_id = ".$_POST['ofertamano_tareas'].", 
                    tipo_hora_id = ".$_POST['ofertamano_horas'].", 
                    oferta_id = ".$_POST['ofertamano_oferta_id'].", 
                    titulo = '".$_POST['ofertamano_titulo']."', 
                    descripcion = '".$_POST['ofertamano_descripcion']."', 
                    cantidad = ".$_POST['ofertamano_cantidad'].",  
                    dto = ".$_POST['ofertamano_dto'].", 
                    pvp = ".$_POST['ofertamano_pvp'].", 
                    pvp_total = ".$_POST['ofertamano_pvp_total']." 
                WHERE id = ".$_POST['ofertamano_detalle_id'];
        file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
    }

    function delDetalleOferta($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from OFERTAS_DETALLES_HORAS WHERE id=".$detalle_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	