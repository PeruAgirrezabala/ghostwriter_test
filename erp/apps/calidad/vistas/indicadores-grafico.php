
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    
    /************************************************************/
    /******************** % Ofertas Aceptadas *******************/
    /************************************************************/
    
    $sql = "SELECT 
                CALIDAD_INDICADORES_VERSIONES.id,
                CALIDAD_INDICADORES_VERSIONES.nombre,  
                CALIDAD_INDICADORES_VERSIONES.descripcion,
                CALIDAD_INDICADORES_VERSIONES.proceso_id,
                CALIDAD_INDICADORES_VERSIONES.objetivo,
                CALIDAD_INDICADORES_VERSIONES.calculo,
                CALIDAD_INDICADORES_VERSIONES.resultado,
                CALIDAD_INDICADORES_VERSIONES.valor,
                CALIDAD_INDICADORES_VERSIONES.anyo
            FROM 
                CALIDAD_INDICADORES_VERSIONES
            WHERE
                CALIDAD_INDICADORES_VERSIONES.indicador_id = 6 
            ORDER BY 
                CALIDAD_INDICADORES_VERSIONES.anyo ASC";

    file_put_contents("indicadores6.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error Indicadores 6 SELECT");
    $log="";
    // Datos Objetivo //
    $objetivePoints6 = array();
    while( $row = mysqli_fetch_array($res) ) {
        $temp_arr= array("y" => $row[7], "label" => $row[8]);
        array_push($objetivePoints6,array("y" => $row[7], "label" => $row[8]));
        $log.="|..|".$row[7]."/".$row[8];
    }
    file_put_contents("log.txt", $log);
    // Datos Reales //
    
    $dataPoints6 = array();
    for($i=2017; $i<=date("Y"); $i++){
        $sql = "SELECT COUNT(*)
            FROM OFERTAS
            WHERE YEAR(OFERTAS.fecha)=".$i."
            AND OFERTAS.0_ver=0";
        $res = mysqli_query($connString, $sql) or die("Error Indicadores 6 SELECT Real");
        $row = mysqli_fetch_array($res);
        $numOfertasYear=$row[0];
        
        $sql = "SELECT COUNT(*)
            FROM OFERTAS
            WHERE YEAR(OFERTAS.fecha)=".$i."
            AND OFERTAS.estado_id=4";
        $res = mysqli_query($connString, $sql) or die("Error Indicadores 6 SELECT Real");
        $row = mysqli_fetch_array($res);
        //$numaceptados = $row[0];
        if($numOfertasYear==0){
            $valor=0;
        }else{
            $valor=(($row[0]*100)/$numOfertasYear);
        }
        // Formato para dos decimales
        $valor=number_format((float)$valor,2,'.','');
        
        $temp_arr= array("y" => $valor, "label" => $i);
        array_push($dataPoints6,array("y" => $valor, "label" => $i));
    }
    
    
    /************************************************************/
    /*************** Nº Contratos nuevos Mantenimiento **********/
    /************************************************************/
    
    $sql = "SELECT 
                CALIDAD_INDICADORES_VERSIONES.id,
                CALIDAD_INDICADORES_VERSIONES.nombre,  
                CALIDAD_INDICADORES_VERSIONES.descripcion,
                CALIDAD_INDICADORES_VERSIONES.proceso_id,
                CALIDAD_INDICADORES_VERSIONES.objetivo,
                CALIDAD_INDICADORES_VERSIONES.calculo,
                CALIDAD_INDICADORES_VERSIONES.resultado,
                CALIDAD_INDICADORES_VERSIONES.valor,
                CALIDAD_INDICADORES_VERSIONES.anyo
            FROM 
                CALIDAD_INDICADORES_VERSIONES
            WHERE
                CALIDAD_INDICADORES_VERSIONES.indicador_id = 5 
            ORDER BY 
                CALIDAD_INDICADORES_VERSIONES.anyo ASC";

    file_put_contents("indicadores5.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error Indicadores 5 SELECT");
    
    // Datos Objetivo
    $objetivePoints5 = array();
    while( $row = mysqli_fetch_array($res) ) {
        $temp_arr= array("y" => $row[7], "label" => $row[8]);
        array_push($objetivePoints5,array("y" => $row[7], "label" => $row[8]));
    }
    // Añadir objetivo este año (mejor en bd)
    //array_push($objetivePoints5,array("y" => "2", "label" => "2021"));
    
    // Datos Reales
    $dataPoints5 = array();
    for($i=2017; $i<=date("Y"); $i++){
        $sql = "SELECT COUNT(*) FROM PROYECTOS WHERE PROYECTOS.ref like 'M%' AND YEAR(PROYECTOS.fecha_ini)=".$i;
        
        file_put_contents("indicadores5.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error Indicadores 5 SELECT");
        $row = mysqli_fetch_array($res);
        
        $temp_arr= array("y" => $row[0], "label" => $i);
        array_push($dataPoints5,array("y" => $row[0], "label" => $i));
    }
    
    // ****************************** //
    // Cambiar datos! //
    unset($dataPoints5);
    $dataPoints5 = array();
    array_push($dataPoints5,array("y" => "1", "label" => "2016"));  
    array_push($dataPoints5,array("y" => "3", "label" => "2017"));  
    array_push($dataPoints5,array("y" => "4", "label" => "2018"));  
    array_push($dataPoints5,array("y" => "2", "label" => "2019"));  
    array_push($dataPoints5,array("y" => "2", "label" => "2020"));      
    array_push($dataPoints5,array("y" => "2", "label" => "2021"));  
    // ****************************** //
    
    
    if($_POST["indicador_id"]==6){
        $datos = array();
        array_push($datos,array(type => "column", name => "Actual", showInLegend => true, dataPoints => $dataPoints6));
        array_push($datos,array(type => "spline", name => "Objetivo", showInLegend => true, dataPoints => $objetivePoints6));
        echo json_encode($datos, JSON_NUMERIC_CHECK);
    }else{
        if($_POST["indicador_id"]==5){
            $datos = array();
            array_push($datos,array(type => "column", name => "Actual", showInLegend => true, dataPoints => $dataPoints5));
            array_push($datos,array(type => "spline", name => "Objetivo", showInLegend => true, dataPoints => $objetivePoints5));
            echo json_encode($datos, JSON_NUMERIC_CHECK);
        }
    }
?>
	