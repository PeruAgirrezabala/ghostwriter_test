<?php
    session_start();
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['prev_del'] != "") {
        delPrev($_POST['prev_del']);
    }    
    else {
        if ($_POST['prev_id'] != "") {
            updatePrev();
        }
        else {
            insertPrev();
        }
    }
    
    function insertPrev() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $itemid = "null";
        if ($_POST['prev_proyectos'] != "") {
            $itemid = $_POST['prev_proyectos'];
        }  
        if ($_POST['prev_ofertas'] != "") {
            $itemid = $_POST['prev_ofertas'];
        }  
        if ($_POST['prev_intervenciones'] != "") {
            $itemid = $_POST['prev_intervenciones'];
        }  
        if ($_POST['prev_mantenimientos'] != "") {
            $itemid = $_POST['prev_mantenimientos'];
        }
        if ($_POST['prev_tipos'] == 5) {
            $itemid = 215;
        }
        if ($_POST['prev_estados'] != "") {
            $estadofield = ", estado_id";
            $estado_id = $_POST['prev_estados'];
        }
        else {
            $estadofield = "";
            $estado_id = "null";
        }
        
        $sql = "INSERT INTO PREVISIONES (
                    nombre,
                    descripcion,
                    item_id,
                    tipo_prev,
                    fecha_ini,
                    fecha_fin 
                    ".$estadofield."
                    )
                VALUES (
                    '".$_POST["prev_nombre"]."',
                    '".$_POST["prev_descripcion"]."',
                    ".$itemid.",
                    ".$_POST["prev_tipos"].",
                    '".$_POST['prev_fechaini']."',
                    '".$_POST["prev_fechafin"]."', 
                    ".$estado_id." 
                    )";
        file_put_contents("insertPrev.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar la Prevision");
        $idPrev = mysqli_insert_id($connString);
        
        if($_POST["prev_instalacion"]!=""){
            $instalacion=$_POST["prev_instalacion"];
        }else{
            $instalacion=0;
        }
        
//        $sql = "INSERT INTO PREVISIONES_INSTALACIONES (
//                    prevision_id, 
//                    instalacion_id
//                    )
//                VALUES (
//                    ".$prev_id.",
//                    ".$instalacion."
//                    )";
//        file_put_contents("insertPrevInst.txt", $sql);
//        $result = mysqli_query($connString, $sql) or die("Error al guardar la Previsión Instalación");
//        
//        $sql = "SELECT id FROM PREVISIONES ORDER BY id DESC LIMIT 1";
//        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el id Prevision");
//        $registros = mysqli_fetch_row ($result);
//        $idPrev = $registros[0];
//        
        
        if ($_POST["prev_addtecnicos"] != "") {
            foreach ($_POST["prev_addtecnicos"] as $value) {
                // Asignaremos los expedientes al proyecto que estamos editando
                $sql = "INSERT INTO PREVISIONES_TECNICOS (prevision_id, erpuser_id) VALUES ('".$idPrev."', ".$value.")";
                $result = mysqli_query($connString, $sql) or die("Error al asignar Tecnicos");
            }
        }
        echo $result;
    }
    
    function updatePrev() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $itemid = "null";
        if ($_POST['prev_proyectos'] != "") {
            $itemid = $_POST['prev_proyectos'];
        }  
        if ($_POST['prev_ofertas'] != "") {
            $itemid = $_POST['prev_ofertas'];
        }  
        if ($_POST['prev_intervenciones'] != "") {
            $itemid = $_POST['prev_intervenciones'];
        }  
        if ($_POST['prev_mantenimientos'] != "") {
            $itemid = $_POST['prev_mantenimientos'];
        }
        if ($_POST['prev_tipos'] == 5) {
            $itemid = 215;
        }
        $sql = "DELETE FROM PREVISIONES_TECNICOS WHERE prevision_id = ".$_POST['prev_id'];
        $result = mysqli_query($connString, $sql) or die("Error al desasignar Técnicos");
        if ($_POST["prev_addtecnicos"] != "") {
            foreach ($_POST["prev_addtecnicos"] as $value) {
                // Asignaremos los tecnicos a la prevision que estamos editando
                $sql = "INSERT INTO PREVISIONES_TECNICOS (prevision_id, erpuser_id) VALUES ('".$_POST['prev_id']."', ".$value.")";
                $result = mysqli_query($connString, $sql) or die("Error al asignar Tecnicos");
            }
        }
        /*
        $sql = "UPDATE PREVISIONES_INSTALACIONES
                    SET instalacion_id = ".$_POST["prev_instalacion"]."
                WHERE prevision_id = ".$_POST['prev_id'];
        file_put_contents("updatePrevInst.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar la Previsión Instalación");*/
        
//        $sql = "INSERT INTO PREVISIONES_INSTALACIONES (
//                    prevision_id, 
//                    instalacion_id
//                    )
//                VALUES (
//                    ".$_POST['prev_id'].",
//                    ".$_POST["prev_instalacion"]."
//                    )";
//        file_put_contents("insertPrevInst.txt", $sql);
//        $result = mysqli_query($connString, $sql) or die("Error al guardar la Prevision Instalación");
        
        $sql = "UPDATE PREVISIONES 
                SET nombre = '".$_POST['prev_nombre']."', 
                    descripcion = '".$_POST['prev_descripcion']."',
                    item_id = ".$itemid.", 
                    tipo_prev = ".$_POST['prev_tipos'].", 
                    fecha_ini = '".$_POST['prev_fechaini']."',  
                    fecha_fin = '".$_POST['prev_fechafin']."',  
                    estado_id = ".$_POST['prev_estados']."
                WHERE id = ".$_POST['prev_id'];
        file_put_contents("updatePrev.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Previsión");
    }

    function delPrev($prev_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE FROM PREVISIONES_TECNICOS WHERE prevision_id=".$prev_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Técnicos de la Previsión");
        
        $sql = "DELETE FROM PREVISIONES WHERE id=".$prev_id;
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Previsión");
    }
?>
	