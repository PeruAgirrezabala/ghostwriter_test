
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['oferta_deloferta'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delOferta();
    }    
    else {
        if ($_POST['ofertas_idoferta'] != "") {
            updateOferta();
        }
        else {
            insertOferta();
        }
    }
    
    function insertOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        $sql = "INSERT INTO OFERTAS 
                    (ref,
                    titulo,
                    descripcion,
                    proyecto_id,
                    fecha,
                    fecha_mod,
                    fecha_validez)
                VALUES ('".$_POST['newoferta_ref']."',
                '".$_POST['newoferta_titulo']."',
                '".$_POST['newoferta_desc']."',
                ".$_POST['newoferta_proyectos'].",
                '".$_POST['newoferta_fecha']."',
                now(),
                '".$_POST['newoferta_fechaval']."')";
        file_put_contents("insert.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar la Oferta");
        
        $sql = "SELECT id FROM OFERTAS ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($connString, $sql) or die("Error al guardar la Oferta");
        $registros = mysqli_fetch_row($result);
        echo $registros[0];
    }
    
    function updateOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE PROYECTOS 
                SET ref = '".$_POST['proyectos_edit_ref']."', 
                    nombre = '".$_POST['proyectos_edit_nombre']."', 
                    descripcion = '".$_POST['proyectos_edit_desc']."',  
                    fecha_ini = '".$_POST['proyectos_edit_fechaini']."', 
                    fecha_entrega = '".$_POST['proyectos_edit_fechaentrega']."', 
                    fecha_fin = '".$_POST['proyectos_edit_fechafin']."', 
                    fecha_mod = now(), 
                    cliente_id = ".$_POST['proyectos_clientes'].", 
                    estado_id = ".$_POST['proyectos_estados'].",     
                    descripcion = '".$_POST['proyectos_edit_desc']."' 
                WHERE id = ".$_POST['proyectos_idproyecto'];
        file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Oferta");
    }

    function delProyeco($proyecto_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from PROYECTOS WHERE id=".$proyecto_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el partido");
    }
?>
	