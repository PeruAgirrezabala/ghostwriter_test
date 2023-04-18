
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");

    if ($_POST['indicador_delindicador'] != "") {
        deleteIndicador();
    }
    else {
        if ($_POST['indicador_id'] != "") {
            updateIndicador();
        }  
        else {
            insertIndicador();
        }
    }
    
    
    function updateIndicador () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if(($_POST['indicador_resultado']==1)||($_POST['indicador_resultado']==0)){
            $resultado=$_POST['indicador_resultado'];
        }else{
            $resultado="error";
        }
        
        $sql = "UPDATE CALIDAD_INDICADORES_VERSIONES SET 
                        valor = '".$_POST['indicador_valor']."'
                    WHERE indicador_id = ".$_POST['indicador_id']."
                    AND anyo=".date("Y");
        file_put_contents("updateIndicadorVersiones.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar Indicador Versiones. UPDATE");
        
        $sql = "UPDATE CALIDAD_INDICADORES SET 
                        nombre = '".$_POST['indicador_nombre']."', 
                        meta = '".$_POST['indicador_meta']."',
                        proceso_id = ".$_POST['indicador_proceso_id'].",
                        objetivo = '".$_POST['indicador_objetivo']."',
                        calculo = '".$_POST['indicador_calculo']."',
                        resultado = '".$resultado."',
                        valor = '".$_POST['indicador_valor']."'
                    WHERE id = ".$_POST['indicador_id'];
        file_put_contents("updateIndicador.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Indicador. UPDATE");
    }
        
    function insertIndicador () {
        $db = new dbObj();
        $connString =  $db->getConnstring();

        if(($_POST['indicador_resultado']==1)||($_POST['indicador_resultado']==0)){
            $resultado=$_POST['indicador_resultado'];
        }else{
            $resultado="error";
        }
        
        $sql = "INSERT INTO CALIDAD_INDICADORES 
                            (nombre,
                            meta,
                            proceso_id,
                            objetivo,
                            calculo,
                            resultado,
                            valor)
                       VALUES (
                            '".$_POST['indicador_nombre']."', 
                            '".$_POST['indicador_meta']."', 
                            ".$_POST['indicador_proceso_id'].", 
                            '".$_POST['indicador_objetivo']."', 
                            '".$_POST['indicador_calculo']."', 
                            '".$resultado."',
                            '".$_POST['indicador_valor']."'
                        )";
        file_put_contents("insertIndicador.txt", $sql);
        echo $_POST['indicador_proceso'];
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Indicador. INSERT");
    }
    
    function deleteIndicador () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CALIDAD_INDICADORES WHERE id = ".$_POST['indicador_delindicador'];
        file_put_contents("deleteIndicador.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Indicador");
    }
   
?>
	