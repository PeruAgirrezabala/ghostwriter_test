<!-- Accesos -->
<table class="table table-striped table-hover" id='tabla-jornada' style="margin: 0px auto 20px auto;">
    <thead>
        <tr class="bg-dark">
        <th class="text-center">DÍA</th>
        <th class="text-center">ACCESOS</th>
        <th class="text-center">H.LABORABLES</th>
        <th class="text-center">H.ORDINARIAS</th>
        <th class="text-center">H.EXTRA</th>
        <th class="text-center">H.VACACIONES</th>
        <th class="text-center">H.MEDICO</th>
        <th class="text-center">H.DEBIDAS</th>
        <th class="text-center">FIRMA</th>
        <th class="text-center">AÑADIR</th>
      </tr>
    </thead>
    <tbody>
<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
        $sql = "SELECT 
                    CALENDARIO.id,
                    CALENDARIO.fecha, 
                    CALENDARIO.horas,
                    erp_users.nombre,
                    JORNADAS.id,
                    erp_users.firma_path,
                    CALENDARIO.festivo,
                    CALENDARIO.tipo_jornada 
                FROM 
                    CALENDARIO, JORNADAS, erp_users 
                WHERE 
                    CALENDARIO.id = JORNADAS.calendario_id 
                AND
                    JORNADAS.user_id = erp_users.id 
                AND 
                    MONTH(CALENDARIO.fecha) = ".$monthNum." 
                AND 
                    YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND
                    erp_users.id = ".$idtrabajador."
                ORDER BY 
                    CALENDARIO.fecha ASC";
    
    //file_put_contents("queryCalendario.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Calendario");
    
    $horasOrdinariasMes = 0;
    $horasExtraMes = 0;
    $horasjornadaMes = 0;
    while ($registros = mysqli_fetch_array($resultado)) { 
        $horasJornada = $registros[2];
        $horasjornadaMes = ($horasjornadaMes + $horasJornada);
        if ($registros[6] == 1) {
            $festivo = "class='danger'";
        }
        else {
            $festivo = "";
        }
        if ($registros[7] == 2) {
            $festivo = "class='info'";
        }
        if ($date = date('Y-m-d', time()) == $registros[1]) {
            $festivo = "class='success'";
        }
        echo "
            <tr ".$festivo." data-id='".$registros[0]."'>
                <td>".$registros[1]."</td> 
                <td>";
        
        $sql = "SELECT 
                    JORNADAS_ACCESOS.id,
                    JORNADAS_ACCESOS.hora_entrada, 
                    JORNADAS_ACCESOS.hora_salida,
                    JORNADAS_ACCESOS.tipo_horas 
                FROM 
                    JORNADAS, JORNADAS_ACCESOS  
                WHERE 
                    JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                    JORNADAS.id = ".$registros[4]."
                ORDER BY 
                    JORNADAS_ACCESOS.hora_entrada ASC";
        //file_put_contents("queryAccesos.txt", $sql);
        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de los Accesos");
        $firma = "";
        if (mysqli_num_rows($resultado2) > 0) {
            if ($registros[5] != "") {
                $firma = "<img src='".$registros[5]."' style='max-height: 80px; max-width:80px; height: 70px;'>";
            }
            else {
                $firma = "";
            }
            /*
            echo "<table class='table table-striped table-hover tabla-detalles-acceso' style='margin-bottom: 5px !important;'>
                    <thead>";
             */
            $horasTotales = 0;
            $horasExtra = 0;
            $horasVacaciones = 0;
            $horasMedico = 0;
            $horasDebidas = 0;
            $testVacacionesDiaCompleto = 0;
            $tablaDias = "<table class='table table-striped table-hover tabla-detalles-acceso' style='margin-bottom: 5px !important;'>
                            <thead>";
            while ($registros2 = mysqli_fetch_array($resultado2)) { 
                $tipo_horas = $registros2[3];
                $fecha1 = new DateTime($registros2[1]);//fecha inicial
                if (($registros2[1] != "0000-00-00 00:00:00") && ($registros2[2] != "0000-00-00 00:00:00")) {
                    $estilo = "class='info'";
                } 
                else {
                    $estilo = "class='danger'";
                }
                if ($tipo_horas == 2) {
                    $estilo = "class='active'";
                }
                if ($tipo_horas == 3) {
                    $estilo = "class='warning'";
                    $testVacacionesDiaCompleto = $testVacacionesDiaCompleto + 1;
                }
                
                $fecha2 = new DateTime($registros2[2]);//fecha de cierre
                if ($registros2[2] != "0000-00-00 00:00:00") {
                    $intervalo = $fecha1->diff($fecha2);
                    $hours = round($intervalo->s / 3600 + $intervalo->i / 60 + $intervalo->h + $intervalo->days * 24, 2);
                    if (($tipo_horas == 1) || ($tipo_horas == 2)) {
                        $horasTotales = ($horasTotales + $hours);
                    }
                    if ($tipo_horas == 2) {
                        $horasMedico = ($horasMedico + $hours);
                    }
                    if ($tipo_horas == 3) {
                        if (($fecha1->format('H') >= "14") && ($testVacacionesDiaCompleto <= 1)) {
                            $estilo = "class='info-warning'";
                        }
                        else {
                            if ($testVacacionesDiaCompleto > 1) {
                                $estilo = "class='warning'";
                                $tablaDias = str_replace("warning-info","warning",$tablaDias);
                            }
                            else {
                                $estilo = "class='warning-info'";
                            }
                        }
                        $horasVacaciones = ($horasVacaciones + $hours);
                    }
                }
                $tablaDias .= "
                        <tr ".$estilo." data-id='".$registros2[0]."'>
                            <td style='text-align:center;'><strong>E:</strong> ".$fecha1->format('H:i')." <strong>S:</strong> ".$fecha2->format('H:i')."</td> 
                        </tr>";
                //$intervalo->format('H');// horas de diferencia entre las dos fechas
                //$horasTotales = $horasTotales + $intervalo;
            } // fin del while de los accesos por dia
            $tablaDias .= "  </thead> 
                  </table>";
            echo $tablaDias;
        }
        else {
            $horasTotales = 0;
            $horasVacaciones = 0;
            $horasMedico = 0;
            $horasDebidas = 0;
        }
            
        if ($horasTotales > $horasJornada) {
            $horasExtra = ($horasTotales - $horasJornada);
            $horasTotales = $horasJornada;
            $horasDebidas = 0;
        }
        else {
            $horasExtra = 0;
            if ($registros[1] > date("Y-m-d")) {
                $horasDebidas = 0;
            }
            else {
                $horasDebidas = $horasJornada - ($horasTotales + $horasExtra + $horasVacaciones);
            }
            
        }
        $horasOrdinariasMes = ($horasOrdinariasMes + $horasTotales);
        $horasExtraMes = ($horasExtraMes + $horasExtra);
        $horasDebidasMes = ($horasDebidasMes + $horasDebidas);
        $horasVacMes = ($horasVacMes + $horasVacaciones);
        $horasMedMes = ($horasMedMes + $horasMedico);
        $horasDebMes = ($horasDebMes + $horasDebidas);
        
        $horasTotalesTime = decimal2hours($horasTotales);
        
        
        echo "  </td>
                <td class='text-center'>".decimal2hours($horasJornada)."h</td>
                <td class='text-center'>".decimal2hours($horasTotales)."h</td>
                <td class='text-center'>".decimal2hours($horasExtra)."h</td>
                <td class='text-center'>".decimal2hours($horasVacaciones)."h</td>
                <td class='text-center'>".decimal2hours($horasMedico)."h</td>
                <td class='text-center'>".decimal2hours($horasDebidas)."h</td>
                <td>".$firma."</td>
                <td>
                    <div class='form-group form-group-tools'>
                        <button class='button add-acceso btn-default' data-jornadaid='".$registros[4]."' data-fecha='".$registros[1]."'><img src='/erp/img/add.png' height='30' title='Insertar Acceso'></button>
                        <button class='button add-autoacceso btn-default' data-jornadaid='".$registros[4]."' data-tipojornada='".$registros[7]."' data-fecha='".$registros[1]."' title='Jornada Automática'><strong>A</strong></button>
                        <button class='button add-autovacaciones btn-warning' data-jornadaid='".$registros[4]."' data-tipojornada='".$registros[7]."' data-fecha='".$registros[1]."' title='Jornada Vacaciones'><strong>V</strong></button>
                        <button class='button add-automedico' data-jornadaid='".$registros[4]."' data-tipojornada='".$registros[7]."' data-fecha='".$registros[1]."' title='Jornada Médico'><strong>M</strong></button>
                    </div>
                </td>
            </tr>
        ";
    } // fin del while de los dias
    $saldo = $horasExtraMes - $horasDebMes;
    
?>
    </tbody>
</table>

<div class="row pvp_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>H.LABORABLES MES: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo decimal2hours($horasjornadaMes); ?> h</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>H.ORDINARIAS MES: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo decimal2hours($horasOrdinariasMes); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>H.VACACIONES MES: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo decimal2hours($horasVacMes); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>H.MÉDICO MES: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo decimal2hours($horasMedMes); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>H.EXTRA MES: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo decimal2hours($horasExtraMes); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>H.DEBIDAS MES: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo decimal2hours($horasDebMes); ?> h</label></div>
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas'>SALDO MES: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo decimal2hours($saldo); ?> h</label></div>
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas'>SALDO TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> Próximamente</label></div>
</div>

<div id="detalleacceso_add_model" class="modal fade">
    <div class="modal-dialog dialog_mini" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">EDITAR ACCESO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_acceso">
                        <input type="hidden" class="form-control" id="editacceso_id" name="editacceso_id">
                        <input type="hidden" class="form-control" id="editacceso_del" name="editacceso_del">
                        <input type="hidden" class="form-control" id="editacceso_idjornada" name="editacceso_idjornada">
                        <div class="form-group">
                            <div class="col-md-5" style="margin: 0px auto; float: none;">
                                <label class="labelBefore">Día:</label>
                                <input type="text" class="form-control" id="editacceso_dia" name="editacceso_dia">
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-5" style="float: none; display: inline-block;">
                                <label class="labelBefore">Hora Entrada:</label>
                                <input type="time" class="form-control" id="editacceso_horaentrada" name="editacceso_horaentrada">
                            </div>
                            <div class="col-md-5" style="float: none; display: inline-block;">
                                <label class="labelBefore">Hora Salida:</label>
                                <input type="time" class="form-control" id="editacceso_horasalida" name="editacceso_horasalida">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-5" style="float: none; margin: 0px auto;">
                                <label class="labelBefore">Tipo de Horas:</label>
                                <!-- <input type="text" class="form-control" id="pedidodetalle_dtoprov" name="pedidodetalle_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                                <select id="editacceso_tipohora" name="editacceso_tipohora" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="editacceso_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Acceso guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_detalleacceso" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_detalleacceso" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Accesos -->

<!-- Calendario Festivos -->

<div id="festivos_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR FESTIVOS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_festivos">
                        <div class="form-group">
                            <div class="col-md-5" style="margin: 0px auto; float: none;">
                                <label class="labelBefore">Selecciona el día:</label>
                                <input type="date" class="form-control" id="festivos_dia" name="festivos_dia">
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="festivo_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Festivo guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_festivo" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Calendario Media Jornada -->

<div id="media_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR MEDIA JORNADA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_media">
                        <div class="form-group">
                            <div class="col-md-5" style="margin: 0px auto; float: none;">
                                <label class="labelBefore">Selecciona el día:</label>
                                <input type="date" class="form-control" id="media_dia" name="media_dia">
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="media_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Media Jornada guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_media" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Calendario Vacaciones -->

<div id="calendario_vac" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CALENDARIO VACACIONES</h4>
            </div>
            <div class="modal-body">
                <div class="loading-div"></div>
                <div class="contenedor-form" id="contenedor-vacaciones">
                    
                </div>
                <div id="leyendaVacaciones" style="margin-top: 50px;">
                    <?
                        $sql = "SELECT 
                                        erp_users.nombre,
                                        erp_users.apellidos,
                                        erp_users.color
                                    FROM 
                                        erp_users 
                                    ORDER BY 
                                        nombre ASC";

                        //file_put_contents("queryCalendario.txt", $sql);
                        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de la Leyenda");

                        while ($registros = mysqli_fetch_array($resultado)) { 
                            echo "<label class='label block' style='white-space: normal;'><span class='badge' style='background-color:".$registros[2]."; white-space: normal;'>".$registros[0]." ".$registros[1]."</span></label>";
                        }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>