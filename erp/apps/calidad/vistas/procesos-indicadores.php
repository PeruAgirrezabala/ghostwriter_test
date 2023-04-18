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
                CALIDAD_INDICADORES.meta,
                CALIDAD_INDICADORES.proceso_id,
                CALIDAD_INDICADORES.objetivo,
                CALIDAD_INDICADORES.calculo,
                CALIDAD_INDICADORES.resultado,
                CALIDAD_INDICADORES.valor,
                CALIDAD_PROCESOS.nombre,
                CALIDAD_INDICADORES.tienehijos
            FROM 
                CALIDAD_INDICADORES, CALIDAD_PROCESOS
            WHERE
                CALIDAD_INDICADORES.proceso_id = ".$_GET['idproceso']."
            AND
                CALIDAD_PROCESOS.id = ".$_GET['idproceso']."
            ORDER BY 
                CALIDAD_INDICADORES.proceso_id ASC";
    //file_put_contents("indicadores.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error Indicadores 1");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-indicadores'>
                <thead>
                    <tr>
                        <th>INDICADOR</th>
                        <th>OBJETIVO</th>
                        <th>PROCESO</th>
                        <th>CALCULO</th>
                        <th>VALOR</th>
                        <th>RESULTADO44</th>
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $idIndicador = $row[0];
        $nombreIndicador = $row[1];
        $metaIndicador = $row[2];
        $dprocesoidIndicador = $row[3];
        $objetivoIndicador = $row[4];
        $calculoIndicador = $row[5];
        $resultadoIndicador = $row[6];
        $valorIndicador = $row[7];
        $nombreprocesoIndicador = $row[8];
        $tiejehijosIndicador = $row[9];
        
        if($resultadoIndicador==0){
            $resultado_indicador="<span class='label label-danger'>NO-OK</span>";
        }elseif ($resultadoIndicador==1){
            $resultado_indicador="<span class='label label-success'>OK</sapn>";
        }else{
            $resultado_indicador="valor num 1/0";
        }
        
        $html .= "
                <tr data-id='".$idIndicador."'>
                    <td class='text-left'>".$nombreIndicador."</td>
                    <td class='text-left'>".$objetivoIndicador."</td>
                    <td class='text-left'>".$nombreprocesoIndicador."</td>
                    <td class='text-left'>".$calculoIndicador."</td>
                    <td class='text-left'>".$valorIndicador."</td>
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
                CALIDAD_INDICADORES.meta,
                CALIDAD_INDICADORES.proceso_id,
                CALIDAD_INDICADORES.objetivo,
                CALIDAD_INDICADORES.calculo,
                CALIDAD_INDICADORES.resultado,
                CALIDAD_PROCESOS.nombre,
                CALIDAD_INDICADORES.valor,
                CALIDAD_INDICADORES.tienehijos,
                (SELECT COUNT(*) FROM OFERTAS WHERE OFERTAS.estado_id =4 AND YEAR( OFERTAS.fecha ) =".date("Y").") AS aceptados,
                (SELECT COUNT(*) FROM OFERTAS WHERE YEAR(OFERTAS.fecha)=".date("Y")." AND OFERTAS.0_ver=0) AS num_ofertas_total
            FROM 
                CALIDAD_INDICADORES, CALIDAD_PROCESOS
            WHERE
                CALIDAD_INDICADORES.proceso_id = CALIDAD_PROCESOS.id 
            ORDER BY 
                CALIDAD_INDICADORES.proceso_id ASC";

    //file_put_contents("indicadores.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error Indicadores 2");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-indicadores'>
                <thead>
                    <tr class='bg-dark'>
                        <th>INDICADOR</th>
                        <th>OBJETIVO</th>
                        <th>PROCESO</th>
                        <th>CALCULO</th>
                        <th>VALOR</th>
                        <th>RESULTADO</th>
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    $cont=0;
    while( $row = mysqli_fetch_array($res) ) {
        
        $aceptados = $row[10];
        $num_ofertas_total = $row[11];
        $porcentaje_real = ($aceptados*100)/$num_ofertas_total;

        $idIndicador = $row[0];
        $nombreIndicador = $row[1];
        $metaIndicador = $row[2];
        $procesoidIndicador = $row[3];
        $objetivoIndicador = $row[4];
        $calculoIndicador = $row[5];
        $resultadoIndicador = $row[6]; // ?¿
        $nombreProcesoIndicador = $row[7];
        $valorIndicador = $row[8];
        $tienehijosIndicador = $row[9];
        $cont++;
        
        if($procesoidIndicador==1){ // Cuando el proceso es una ofertas (1)
            if($idIndicador==6){
                if($porcentaje_real>=$valorIndicador){
                    $resultado_indicador="<span class='label label-success'>OK</sapn>";
                }else{
                    $resultado_indicador="<span class='label label-danger'>NO-OK</span>";
                }
            }elseif($idIndicador==5){
                if($valorIndicador<2){
                    $resultado_indicador="<span class='label label-danger'>NO-OK</span>";
                }else{
                    $resultado_indicador="<span class='label label-success'>OK</sapn>";
                }
            }
            
        }
        
        
        
        if($tienehijosIndicador!=1){
            $botonvermas="";
            $tienehijos="<td id='tienehijos-".$idIndicador."' value='".$tienehijosIndicador."'  hidden></td>";
        }else{
            $tienehijos="<td id='tienehijos-".$idIndicador."' value='".$tienehijosIndicador."'  hidden></td>";
            $botonvermas="<button class='btn btn-circle btn-default vermas' data-id='".$idIndicador."' title='Ver todos'><img src='/erp/img/informacion.png' height='20px'></button>";
            $resultado_indicador="";
        }
        $html .= "
                <tr data-id='".$idIndicador."' value=".$tienehijosIndicador.">
                    <td class='text-left'>".$nombreIndicador."</td>
                    <td class='text-left'>".$objetivoIndicador."</td>
                    <td class='text-left'>".$nombreProcesoIndicador."</td>
                    <td class='text-left'>".$calculoIndicador."</td>
                    <td class='text-left'>".$valorIndicador."</td>
                    <td class='text-left'>".$botonvermas.$resultado_indicador."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-indicador' data-id='".$idIndicador."' title='Eliminar Indicador'><img src='/erp/img/cross.png' style='height: 20px;'></button></td>
                </tr>";
        /*
        if($cont==1){
            $html .="";
        }else{
            $html .="
                <tr id='subind-".$idIndicador."' hidden>
                    <td class='text-left'>
                        <table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th>col1</th>
                                <th>col2</th>
                                <th>col2</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                             <tr data-id='qqq'>
                                <td class='text-left'>asdf</td>
                                <td class='text-left'>asdf</td>
                                <td class='text-left'>asdf</td>
                             </tr>
                        </table>
                    </td>
                </tr>";
        }*/
    }
    $html .= "      </tbody>
                </table>";    
}

$html .='<div id="delete_indicadores_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR INDICADOR</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                        <input type="hidden" value="" name="del_indicador_id" id="del_indicador_id">
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas eliminar el indicador?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_indicador" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>';
////////////////////////////////////////////////////
/******* Carga de bloques de indicadores ******/

echo $html;

?>