<?
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['idproceso'])) {    
            
    $sql = "SELECT 
                CALIDAD_INDICADORES.id,
                CALIDAD_INDICADORES.nombre,  
                CALIDAD_INDICADORES.descripcion,
                CALIDAD_INDICADORES.proceso_id,
                CALIDAD_INDICADORES.objetivo,
                CALIDAD_INDICADORES.actual,
                CALIDAD_INDICADORES.resultado,
                CALIDAD_INDICADORES.operacion,
                CALIDAD_PROCESOS.nombre
            FROM 
                CALIDAD_INDICADORES, CALIDAD_PROCESOS
            WHERE
                CALIDAD_INDICADORES.proceso_id = ".$_GET['idproceso']."
            AND
                CALIDAD_PROCESOS.id = ".$_GET['idproceso']."
            ORDER BY 
                CALIDAD_INDICADORES.nombre ASC";

    file_put_contents("indicadores.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error Indicadores 1");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-indicadores'>
                <thead>
                    <tr>
                        <th>INDICADOR</th>
                        <th>DESCRIPCION</th>
                        <th>PROCESO</th>
                        <th>ACTUAL</th>
                        <th>OPERACION</th>
                        <th>OBJETIVO</th>
                        <th>RESULTADO</th>
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $idIndicador = $row[0];
        $nombreIndicador = $row[1];
        $descIndicador = $row[2];
        $dprocesoidIndicador = $row[3];
        $objetivoIndicador = $row[4];
        $actualIndicador = $row[5];
        $resultadoIndicador = $row[6];
        $operacionIndicador = $row[7];
        $nombreprocesoIndicador = $row[8];
        
        if($resultadoIndicador==0){
            $resultado_indicador="<span class='label label-danger'>NO-OK</span>";
        }elseif ($resultadoIndicador==1){
            $resultado_indicador="<span class='label label-success'>OK</sapn>";
        }
        
        $html .= "
                <tr data-id='".$idIndicador."'>
                    <td class='text-left'>".$nombreIndicador."</td>
                    <td class='text-left'>".$descIndicador."</td>
                    <td class='text-left'>".$nombreprocesoIndicador."</td>
                    <td class='text-left'>".$actualIndicador."</td>
                    <td class='text-left'>".$operacionIndicador."</td>
                    <td class='text-left'>".$objetivoIndicador."</td>
                    <td class='text-left'>".$resultado_indicador."</td>
                    <td class='text-center'><button class='btn-default remove-indicador' data-id='".$idIndicador."' title='Eliminar Indicador'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
} //if id isset
else {
    $sql = "SELECT 
                CALIDAD_INDICADORES.id,
                CALIDAD_INDICADORES.nombre,  
                CALIDAD_INDICADORES.descripcion,
                CALIDAD_INDICADORES.proceso_id,
                CALIDAD_INDICADORES.objetivo,
                CALIDAD_INDICADORES.actual,
                CALIDAD_INDICADORES.resultado,
                CALIDAD_PROCESOS.nombre,
                CALIDAD_INDICADORES.operacion
            FROM 
                CALIDAD_INDICADORES, CALIDAD_PROCESOS
            WHERE
                CALIDAD_INDICADORES.proceso_id = CALIDAD_PROCESOS.id 
            ORDER BY 
                CALIDAD_INDICADORES.nombre ASC";

    file_put_contents("indicadores.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error Indicadores 2");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-indicadores'>
                <thead>
                    <tr class='bg-dark'>
                        <th>INDICADOR</th>
                        <th>DESCRIPCION</th>
                        <th>PROCESO</th>
                        <th>ACTUAL</th>
                        <th>OP</th>
                        <th>OBJETIVO</th>
                        <th>RESULTADO</th>
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $idIndicador = $row[0];
        $nombreIndicador = $row[1];
        $descIndicador = $row[2];
        $dprocesoidIndicador = $row[3];
        $objetivoIndicador = $row[4];
        $actualIndicador = $row[5];
        $resultadoIndicador = $row[6];
        $nombreProcesoIndicador = $row[7];
        $opreacionIndicador = $row[8];
        
        if($resultadoIndicador==0){
            $resultado_indicador="<span class='label label-danger'>NO-OK</span>";
        }elseif ($resultadoIndicador==1){
            $resultado_indicador="<span class='label label-success'>OK</sapn>";
        }
        $html .= "
                <tr data-id='".$idIndicador."'>
                    <td class='text-left'>".$nombreIndicador."</td>
                    <td class='text-left'>".$descIndicador."</td>
                    <td class='text-left'>".$nombreProcesoIndicador."</td>
                    <td class='text-left'>".$actualIndicador."</td>
                    <td class='text-left'>".$opreacionIndicador."</td>
                    <td class='text-left'>".$objetivoIndicador."</td>
                    <td class='text-left'>".$resultado_indicador."</td>
                    <td class='text-center'><button class='btn-default remove-indicador' data-id='".$idIndicador."' title='Eliminar Indicador'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";    
}
echo $html;

?>