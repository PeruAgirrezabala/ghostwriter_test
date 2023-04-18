
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['proyectos_delproyecto'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delProyecto();
    }    
    else {
        if ($_POST['proyectos_idproyecto'] != "") {
            updateProyecto();
        }
        else {
            insertProyecto();
        }
    }
    
    function insertProyecto() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST["newproyecto_parentproyecto"] != "") {
            $parentproject = ", proyecto_id ";
            $parentprojectvalue = ", ".$_POST["newproyecto_parentproyecto"];
        }
        else {
            $parentproject = "";
            $parentprojectvalue = "";
        }
        $sql = "INSERT INTO PROYECTOS (
                    ref, 
                    nombre,
                    descripcion,
                    fecha_ini,
                    fecha_entrega,
                    fecha_fin,
                    fecha_mod,
                    cliente_id,
                    estado_id,
                    ubicacion
                    ".$parentproject."
                    )
                VALUES (
                    '".$_POST["newproyecto_ref"]."',
                    '".$_POST["newproyecto_nombre"]."',
                    '".$_POST["newproyecto_desc"]."',
                    '".$_POST["newproyecto_fechaini"]."',
                    '".$_POST["newproyecto_fechaentrega"]."',
                    '".$_POST["newproyecto_fechafin"]."',
                    now(),
                    ".$_POST["newproyecto_clientes"].",
                    ".$_POST["newproyecto_estados"].",
                    '".$_POST["newproyecto_ubicacion"]."' 
                    ".$parentprojectvalue."
                    )";
        file_put_contents("insertProyecto.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Proyecto");
    }
    
    function updateProyecto() {
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
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la jornada");
    }

    function delProyecto($proyecto_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from PROYECTOS WHERE id=".$proyecto_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el partido");
    }
?>
	