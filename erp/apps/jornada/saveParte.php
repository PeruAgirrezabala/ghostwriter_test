
<?php
    session_start();
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['proyectoparte_del'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delParte($_POST['proyectoparte_del']);
    }    
    else {
        if ($_POST['proyectoparte_idparte'] != "") {
            updateParte();
        }
        else {
            insertParte();
        }
    }
    
    function insertParte() {
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
        $sql = "INSERT INTO PARTES (
                    titulo,
                    ref, 
                    fecha,
                    fecha_entrega,
                    fecha_factu,
                    proyecto_id,
                    tecnico_id,
                    instalacion,
                    parte_estado_id
                    )
                VALUES (
                    '".$_POST["proyecto_partenombre"]."',
                    '".$_POST["proyecto_parteref"]."',
                    '".$_POST["proyecto_partefecha"]."',
                    now(),
                    '".$_POST["proyecto_partefecha_factu"]."',
                    ".$_POST["proyectoparte_proyecto_id"].",
                    ".$_SESSION['user_session'].",
                    '".$_POST["proyecto_parteinstalacion"]."',
                    ".$_POST["proyecto_parteestados"]." 
                    )";
        file_put_contents("insertParte.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Parte");
    }
    
    function updateParte() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "UPDATE PROYECTOS 
                SET titulo = '".$_POST['proyecto_partenombre']."', 
                    ref = '".$_POST['proyecto_parteref']."', 
                    fecha = '".$_POST['proyecto_partefecha']."',  
                    fecha_factu = '".$_POST['proyecto_partefecha_factu']."', 
                    proyecto_id = '".$_POST['proyectoparte_proyecto_id']."', 
                    instalacion = '".$_POST['proyecto_parteinstalacion']."', 
                    parte_estado_id = ".$_POST['proyecto_parteestados']."
                WHERE id = ".$_POST['proyectoparte_idparte'];
        file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Parte");
    }

    function delParte($parte_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE FROM PARTES WHERE id=".$parte_id;

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Parte");
    }
?>
	