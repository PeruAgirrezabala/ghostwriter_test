<?
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    include($pathraiz."/apps/calidad/vistas/generar-tabla-indicadores.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    ////////////////////////////////////////////////////
    /******* Carga de bloques de indicadores ******/
    $html1='<div id="dash-content">';
    $sql = "SELECT 
                CALIDAD_INDICADORES.id,
                CALIDAD_INDICADORES.nombre,  
                CALIDAD_INDICADORES.meta,
                CALIDAD_INDICADORES.proceso_id,
                CALIDAD_INDICADORES.objetivo,
                CALIDAD_INDICADORES.calculo,
                CALIDAD_INDICADORES.resultado,
                CALIDAD_INDICADORES.valor,
                CALIDAD_INDICADORES.tienehijos,
                CALIDAD_PROCESOS.nombre
            FROM 
                CALIDAD_INDICADORES, CALIDAD_PROCESOS
            WHERE
                CALIDAD_INDICADORES.proceso_id = CALIDAD_PROCESOS.id
            AND
                CALIDAD_INDICADORES.tienehijos = 1
            ORDER BY 
                CALIDAD_INDICADORES.nombre ASC";
    file_put_contents("seleccionIndicadores.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error Indicadores X");
    
    $html1 .= "<span class='stretch'></span>";
    while( $row = mysqli_fetch_array($res) ) {
        $idIndicador = $row[0];
        $nombreIndicador = $row[1];
        $metaIndicador = $row[2];
        $dprocesoidIndicador = $row[3];
        $objetivoIndicador = $row[4];
        $calculoIndicador = $row[5];
        $resultadoIndicador = $row[6];
        $valorIndicador = $row[7];
        $tienehijosIndicador = $row[8];
        $nombreProcesoIndicador = $row[9];
        /***** Establecemos criterio de filtro en base a idIdentificador ****/
        //$filtros=pedirFiltro($idIndicador);
        if($idIndicador==$_GET['detalleid']){
            $mostrar="display:block;";
        }else{
            $mostrar="display:none;";
        }
        $html1 .='<div id="dash-indic-'.$idIndicador.'" class="one-column" style="min-height: 400px; padding-right:5px; padding-left:5px; '.$mostrar.'">
                    <span class="dash-title">'.$nombreIndicador.'</span>
                        <div class="form-group form-group-tools"> 
                            <button class="button" id="clean-filters-indicador-detalles" data-id='.$idIndicador.' title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
                        </div>
                    <span class="stretch"></span>
                    <hr class="dash-underline">
                    '.pedirFiltro($idIndicador).'
                        <div id="indicador-detalle-'.$idIndicador.'" data-id="'.$idIndicador.'" style="'.$mostrar.'">
                        '.generarTabla($idIndicador).'
                        </div>
                 </div>';
    }
    $html1.='</div>';

    function pedirFiltro($id){
        
        switch($id){
            case 9: // AVERIAS
                $ahtml.='<div id="proyectos-filterbar" class="one-column">
                            <div class="form-group form-group-filtros">
                            <label for="filter_actas_years" class="col-sm-1 control-label labelFiltros">Año: </label>
                            <div class="col-xs-3">
                                <select id="filter_actas_years" name="filter_actas_years" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                            <label for="filter_actas_mes" class="col-sm-1 control-label labelFiltros">Mes: </label>
                            <div class="col-xs-3">
                                <select id="filter_actas_mes" name="filter_actas_mes" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Dicciembre</option>
                                </select>
                            </div>
                        </div>
                        </div>';
                break;
            case 6:
                $ahtml.='<div id="proyectos-filterbar" class="one-column">
                            <div class="form-group form-group-filtros">
                            <label for="filter_actas_years" class="col-sm-1 control-label labelFiltros">Año: </label>
                            <div class="col-xs-3">
                                <select id="filter_actas_years" name="filter_actas_years" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                            <label for="filter_actas_mes" class="col-sm-1 control-label labelFiltros">Mes: </label>
                            <div class="col-xs-3">
                                <select id="filter_actas_mes" name="filter_actas_mes" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Dicciembre</option>
                                </select>
                            </div>
                        </div>
                        </div>';
                break;
            case 7:
                $ahtml.='<div id="proyectos-filterbar" class="one-column" data-id="7">
                            <div class="form-group form-group-filtros">
                            <label for="filter_indicadores_years" class="col-sm-1 control-label labelFiltros">Año: </label>
                            <div class="col-xs-2">
                                <select id="filter_indicadores_years" name="filter_indicadores_years" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                            <label for="filter_indicadores_resultado" class="col-sm-1 control-label labelFiltros">Resultado: </label>
                            <div class="col-xs-2">
                                <select id="filter_indicadores_resultado" name="filter_indicadores_resultado" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="1">OK</option>
                                    <option value="0">NO-OK</option>
                                </select>
                            </div>
                            <label for="filter_indicadores_proyectos" class="col-sm-1 control-label labelFiltros">Proyectos: </label>
                            <div class="col-xs-3">
                                <select id="filter_indicadores_proyectos" name="filter_indicadores_proyectos" class="selectpicker" data-live-search="true">
                                <option value=""></option>';
                            $db = new dbObj();
                            $connString =  $db->getConnstring();
                            $sql = "SELECT 
                                    PROYECTOS.id,
                                    PROYECTOS.ref,
                                    PROYECTOS.nombre,
                                    PROYECTOS.fecha_ini,
                                    PROYECTOS.fecha_entrega,
                                    PROYECTOS_ESTADOS.nombre, 
                                    CLIENTES.nombre, 
                                    CLIENTES.img,
                                    PROYECTOS_ESTADOS.color 
                                FROM 
                                    PROYECTOS, CLIENTES, PROYECTOS_ESTADOS 
                                WHERE 
                                    PROYECTOS.cliente_id = CLIENTES.id
                                AND 
                                    PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
                                AND
                                    PROYECTOS.tipo_proyecto_id = 1 
                                AND
                                    PROYECTOS.estado_id <> 3 
                                AND 
                                    PROYECTOS.estado_id <> 6
                                ORDER BY 
                                    PROYECTOS.fecha_mod DESC,
                                    PROYECTOS.fecha_ini DESC";
                                file_put_contents("selectProyectos.txt", $sql);
                                $res = mysqli_query($connString, $sql) or die("Error al seleccionar proyectos");
                                while ($row = mysqli_fetch_array($res)) {
                                    $ahtml.='<option value="'.$row[0].'">'.$row[2].'</option>';
                                }
                                $ahtml.='</select></div></div></div>';
                break;
            case 8: // NO CONFORMIDADES
                $ahtml.='<div id="proyectos-filterbar" class="one-column">
                            <div class="form-group form-group-filtros">
                            <label for="filter_actas_years" class="col-sm-1 control-label labelFiltros">Año: </label>
                            <div class="col-xs-3">
                                <select id="filter_actas_years" name="filter_actas_years" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                            <label for="filter_actas_mes" class="col-sm-1 control-label labelFiltros">Mes: </label>
                            <div class="col-xs-3">
                                <select id="filter_actas_mes" name="filter_actas_mes" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Dicciembre</option>
                                </select>
                            </div>
                        </div>
                        </div>';
                break;
            case 5:
                $ahtml.='<div id="proyectos-filterbar" class="one-column">
                            <div class="form-group form-group-filtros">
                            <label for="filter_actas_years" class="col-sm-1 control-label labelFiltros">Año: </label>
                            <div class="col-xs-3">
                                <select id="filter_actas_years" name="filter_actas_years" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                            <label for="filter_actas_mes" class="col-sm-1 control-label labelFiltros">Mes: </label>
                            <div class="col-xs-3">
                                <select id="filter_actas_mes" name="filter_actas_mes" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Dicciembre</option>
                                </select>
                            </div>
                        </div>
                        </div>';
                break;
            case 1:
                break;
            default :
                $ahtml="Error en filtro: ".$id;
                break;
        }
        return $ahtml;
    }
    
    
    echo $html1;
?>