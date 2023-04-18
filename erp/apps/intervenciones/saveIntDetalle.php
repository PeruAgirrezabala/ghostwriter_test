<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['intdetalle_deldetalle'] != "") {
        delDetalleInt($_POST['intdetalle_deldetalle']);
    }    
    else {
        
            if ($_POST['intdetalle_detalle_id'] != "") {
                if ($_POST['intdetalle_horas'] != "") {
                    updateHoras();
                }
                else {
                    updateDetalleInt();
                }
            }
            else {
                insertDetalleInt();
            }
    }
    
    function insertDetalleInt() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sql = "INSERT INTO INTERVENCIONES_DETALLES 
                    (titulo,
                    descripcion,
                    fecha,
                    fecha_mod,
                    int_id,
                    erpuser_id
                    )
                VALUES ('".$_POST['intdetalle_nombre']."',
                '".$_POST['intdetalle_desc']."', 
                '".$_POST['intdetalle_fecha']."',
                now(),
                ".$_POST['intdetalle_int_id'].",
                ".$_POST['intdetalle_tecnicos'].")";

        file_put_contents("insertIntdetalle.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        
        //mysqli_set_charset($connString, "utf8");
    }
    
    function updateDetalleInt() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['intdetalle_tecnicos'] != "") {
            $erpuser = ", erpuser_id = ".$_POST['intdetalle_tecnicos'];
        }
        else {
            $erpuser = "";
        }
        $sql = "UPDATE INTERVENCIONES_DETALLES 
                    SET titulo = '".$_POST['intdetalle_nombre']."', 
                        descripcion = '".$_POST['intdetalle_desc']."',
                        fecha = '".$_POST['intdetalle_fecha']."',  
                        fecha_mod = now() 
                        ".$erpuser."
                    WHERE id = ".$_POST['intdetalle_detalle_id'];
        
        file_put_contents("updateDet.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        //mysqli_set_charset($connString, "utf8");
    }
    function updateHoras() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT erpuser_id FROM INTERVENCIONES_DETALLES_TECNICOS WHERE intdetalle_id = ".$_POST['intdetalle_detalle_id']." AND erpuser_id = ".$_POST['intdetalle_tecnicos'];
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el tecnico");
        $registros = mysqli_fetch_row ($result);
        $existenHoras = $registros[0];
        
        if ($existenHoras != "") {
            $sql = "UPDATE INTERVENCIONES_DETALLES_TECNICOS
                        SET  
                            H820 = ".$_POST['intdetalle_H820'].",  
                            H208 = ".$_POST['intdetalle_H208'].",  
                            Hviaje = ".$_POST['intdetalle_Hviaje'].",  
                            coste_H820 = ".$_POST['intdetalle_costeH820'].",
                            coste_H208 = ".$_POST['intdetalle_costeH208'].",
                            erpuser_id = ".$_POST['intdetalle_tecnicos']."
                        WHERE intdetalle_id = ".$_POST['intdetalle_detalle_id'];
        }
        else {
            $sql = "INSERT INTO INTERVENCIONES_DETALLES_TECNICOS 
                    (H820,
                    H208,
                    Hviaje,
                    coste_H820,
                    coste_H208,
                    erpuser_id,
                    intdetalle_id
                    )
                VALUES (".$_POST['intdetalle_H820'].",
                ".$_POST['intdetalle_H208'].", 
                ".$_POST['intdetalle_Hviaje'].",
                ".$_POST['intdetalle_costeH820'].",
                ".$_POST['intdetalle_costeH208'].",
                ".$_POST['intdetalle_tecnicos'].",
                ".$_POST['intdetalle_detalle_id'].")";
        }
        
        file_put_contents("updateDetHoras.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle de las Horas");
        updateDetalleInt();
        //mysqli_set_charset($connString, "utf8");
    }

    function delDetalleInt($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from INTERVENCIONES_DETALLES_TECNICOS WHERE intdetalle_id=".$detalle_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
        $sql = "delete from INTERVENCIONES_DETALLES WHERE id=".$detalle_id;
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	