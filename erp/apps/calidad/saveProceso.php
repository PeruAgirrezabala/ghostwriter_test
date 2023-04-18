
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");

    if ($_POST['proceso_delproceso'] != "") {
        deletePlan();
    }
    else {
        if ($_POST['proceso_id'] != "") {
            updateProceso();
        }  
        else {
            insertProceso();
        }
    }
    
    
    function updateProceso () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CALIDAD_PROCESOS SET 
                        nombre = '".$_POST['proceso_nombre']."', 
                        responsable = '".$_POST['proceso_resp']."', 
                        dptos = '".$_POST['proceso_dptos']."', 
                        objeto = '".$_POST['proceso_objeto']."', 
                        recursos = '".$_POST['proceso_recursos']."', 
                        entradas = '".$_POST['proceso_entradas']."', 
                        salidas = '".$_POST['proceso_salidas']."', 
                        registros = '".$_POST['proceso_registros']."', 
                        procedimientos = '".$_POST['proceso_procedimientos']."', 
                        actividades = '".$_POST['proceso_actividades']."' 
                    WHERE id =".$_POST['proceso_id'];
        file_put_contents("updateProceso.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Proceso. UPDATE");
    }
        
    function insertProceso () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO CALIDAD_PROCESOS 
                            (nombre,
                            responsable,
                            dptos,
                            objeto,
                            recursos,
                            entradas,
                            salidas,
                            registros,
                            procedimientos,
                            actividades) 
                       VALUES (
                            '".$_POST['proceso_nombre']."', 
                            '".$_POST['proceso_resp']."', 
                            '".$_POST['proceso_dptos']."', 
                            '".$_POST['proceso_objeto']."', 
                            '".$_POST['proceso_recursos']."', 
                            '".$_POST['proceso_entradas']."', 
                            '".$_POST['proceso_salidas']."', 
                            '".$_POST['proceso_registros']."', 
                            '".$_POST['proceso_procedimientos']."', 
                            '".$_POST['proceso_actividades']."'
                        )";
        file_put_contents("insertProceso.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Proceso. INSERT");
    }
    function deletePlan () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CALIDAD_INDICADORES WHERE proceso_id = ".$_POST['proceso_delproceso'];
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Indicadores del Proceso");
        
        /* TABLA VACIA, NO PROCEDE
        $sql = "DELETE FROM CALIDAD_PROCESOS_RIESGOS WHERE proceso_id = ".$_POST['proceso_delproceso'];
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Riesgos del Proceso");
        */
        $sql = "DELETE FROM CALIDAD_PROCESOS WHERE id = ".$_POST['proceso_delproceso'];
        file_put_contents("delProceso.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Proceso");
    }
   
?>
	