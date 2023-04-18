<!-- tools Previsiones -->
<div class="form-group form-group-tools">
    <button class="button" id="add-prev" title="Nueva Previsión"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh-previsiones" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
    <button class="button" id="clean-filters" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
    <button class="button" id="ver-previsiones" title="Ver Calendario de Previsiones"><img src="/erp/img/calendar.png" height="20"></button>
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
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Tipo: <span class="requerido">*</span></label>
                                <select id="prev_tipos" name="prev_tipos" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                    <option value="1">Mantenimento</option>
                                    <option value="2">Intervencion</option>
                                    <option value="3">Proyecto</option>
                                    <option value="4">Visita</option>
                                    <option value="5">Gestión interna</option>
                                    <option value="6">Oferta</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <!-- -->
                        <div class="form-group" id="grupo_mantenimiento" style="display:none;">
                            <label class="labelBefore">Mantenimiento: <small>(opcional)</small></label>
                            
                            <select id="prev_mantenimientos" name="prev_mantenimientos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group" id="grupo_intervencion" style="display:none;">
                            <label class="labelBefore">Intervención: <small>(opcional)</small></label>
                            <select id="prev_intervenciones" name="prev_intervenciones" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group" id="grupo_proyecto" style="display:none;">
                            <label class="labelBefore">Proyecto: <small>(opcional)</small></label>
                            <select id="prev_proyectos" name="prev_proyectos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group" id="grupo_oferta" style="display:none;">
                            <label class="labelBefore">Oferta: <small>(opcional)</small></label>
                            <select id="prev_ofertas" name="prev_ofertas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <!-- -->
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
                        <!--
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
                        </div>
                        -->
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

