<!-- tools Previsiones -->
<div class="form-group form-group-tools">
    <!--<button class="button" id="add-event" title="Nuevo Evento"><img src="/erp/img/add.png" height="20"></button>-->
    <button class="button" id="refresh-previsiones-calendario" title="Actualizar Calendario"><img src="/erp/img/refresh.png" height="20"></button>
</div>
<span class="stretch"></span>
<hr class="dash-underline" style="margin-bottom: 0px;">
<div class="one-column">
                <div class="form-group form-group-calendario-meses">
                    <div class="col-md-1">
                        <!--
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="calendar-link" data-id="1" href="#">Año</a></li>
                            <li class="page-item disabled"><a class="calendar-link" data-id="2" href="#">Mes</a></li>
                            <li class="page-item disabled"><a class="calendar-link" data-id="3" href="#">Semana</a></li>
                            <li class="page-item disabled"><a class="calendar-link" data-id="4" href="#">Día</a></li>
                        </ul>
                        -->
                    </div>
                    <div class="col-md-1">
                        <label class="labelBefore">Año:</label>
                        <select id="filtro_calendario_year" name="filtro_calendario_year" class="selectpicker" data-live-search="true">
                            <? 
                                $year=date("Y");
                                for($i=($year-2);$i<=($year+2);$i++){
                                    echo "<option value=".$i.">".$i."</option>";
                                }
                            ?>
                            
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="labelBefore">Mes:</label>
                        <!--<button class="button" style="float:right;"><img src="/erp/img/anterior.png" height="28"></button>-->
                        <select id="filtro_calendario_mes" name="filtro_calendario_mes" class="selectpicker" data-live-search="true">
                            <option value='1'>Enero</option>
                            <option value='2'>Febrero</option>
                            <option value='3'>Marzo</option>
                            <option value='4'>Abril</option>
                            <option value='5'>Mayo</option>
                            <option value='6'>Junio</option>
                            <option value='7'>Julio</option>
                            <option value='8'>Agosto</option>
                            <option value='9'>Septiembre</option>
                            <option value='10'>Octubre</option>
                            <option value='11'>Noviembre</option>
                            <option value='12'>Dicciembre</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="labelBefore">Tipo Previsión:</label>
                        <select id="filtro_calendario_tipo_prevision" name="filtro_calendario_tipo_prevision" class="selectpicker" data-live-search="true" data-width="33%">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="labelBefore">Técnico:</label>
                        <select id="filtro_calendario_tecnicos" name="filtro_calendario_tecnicos" class="selectpicker" data-live-search="true">
                            <option value=''></option>
                        </select>
                    </div>
                    <div class="col-md-1" style="margin-top:15px">
                        <!--<button class="button" style="float:left;"><img src="/erp/img/siguiente.png" height="28"></button>-->
                    </div>
                    <div class="col-md-4"></div>
                </div>
</div>

<!-- tools Previsiones -->

<div id="addprev_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PREVISIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_previsiones" name="frm_previsiones">
                        <input type="hidden" name="prev_id" id="prev_id">
                        <input type="hidden" name="prev_del" id="prev_del">
                        <!--
                        <div class="form-group">
                            <label class="labelBefore">REF:</label>
                            <input type="text" class="form-control" id="prev_ref" name="prev_ref">
                        </div>
                        -->
                        <div class="form-group">
                            <label class="labelBefore">Previsión:</label>
                            <input type="text" class="form-control" id="prev_nombre" name="prev_nombre">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="prev_descripcion" name="prev_descripcion" placeholder="Descripción de la Previsión" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Inicio: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="prev_fechaini" name="prev_fechaini">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Fin: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="prev_fechafin" name="prev_fechafin">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Cliente: <span class="requerido">*</span></label>
                            <select id="prev_clientes" name="prev_clientes" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Instalación: <span class="requerido">*</span></label>
                            
                            <select id="prev_instalacion" name="prev_instalacion" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                            
                            <!--<input type="text" class="form-control" id="prev_instalacion" name="prev_instalacion">-->
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Técnico: <span class="requerido">*</span></label>
                                <select id="prev_tecnicos" name="prev_tecnicos" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label for="prev_oo" class="labelBefore" style="color: #ffffff;">oo </label>
                                <button type="button" id="btn_add_tec" class="btn btn-info">Añadir Técnico</button>
                                <button type="button" id="btn_clear_tec" class="btn btn-primary">Quitar Técnico</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="prev_addtecnicos" name="prev_addtecnicos[]" multiple readonly>
                                
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="labelBefore">Mantenimiento: <small>(opcional)</small></label>
                            
                            <select id="prev_mantenimientos" name="prev_mantenimientos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Intervención: <small>(opcional)</small></label>
                            <select id="prev_intervenciones" name="prev_intervenciones" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Proyecto: <small>(opcional)</small></label>
                            <select id="prev_proyectos" name="prev_proyectos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Oferta: <small>(opcional)</small></label>
                            <select id="prev_ofertas" name="prev_ofertas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Tipo: <span class="requerido">*</span></label>
                                <select id="prev_tipos" name="prev_tipos" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                    <option value="1">Mantenimento</option>
                                    <option value="2">Intervencion</option>
                                    <option value="3">Proyecto</option>
                                    <option value="4">Oferta</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Estado: <span class="requerido">*</span></label>
                                <select id="prev_estados" name="prev_estados" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="prev_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Previsión guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_prev_save" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_prev" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

