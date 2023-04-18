<!-- tools planificaciones -->
<div class="form-group form-group-tools">
    <button class="button" id="add-act" title="Nueva Planificación"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-act" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-act" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
    <button class="button" id="clean-filters" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
</div>

<!-- tools planificaciones -->

<div id="addact_model" class="modal fade">
    <div class="modal-dialog dialog_mediano">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">NUEVA ACTIVIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_act_addact">
                        <input type="hidden" name="act_idact" id="act_idact">
                        <input type="hidden" name="act_del" id="act_del">
                        <!--
                        <div class="form-group">
                            <label class="labelBefore">REF:</label>
                            <input type="text" class="form-control" id="act_ref" name="act_ref">
                        </div>
                        -->
                        
                        <legend class="col-form-label">Registro</legend>
                        <div class="form-group">
                            <label for="act_responsable" class="col-xs-1" style="text-align: right;">Resp./Fechas<span class="requerido">*</span>:</label>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_responsable" name="act_responsable" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-3" style="float:left !important;">
                                <input type="date" class="form-control" id="act_fecha" name="act_fecha">
                            </div>
                            <div class="col-xs-3" style="float:left !important;">
                                <input type="date" class="form-control" id="act_fecha_fin" name="act_fecha_fin">
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label for="act_clientes" class="col-xs-1" style="text-align: right;">Cliente/Inst.:</label>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_clientes" name="act_clientes" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_instalacion" name="act_instalacion" class="selectpicker" placeholder="Instalación" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                                <!--<input type="text" class="form-control" id="act_instalacion" name="act_instalacion" placeholder="Instalación">
                            </div>
                        </div>
                        <div class="form-group"></div>-->
                        <div class="form-group">
                            <label for="act_categorias" class="col-xs-1" style="text-align: right;">Título: <span class="requerido">*</span></label>
                            <div class="col-xs-10" style="float:left !important;">
                                <input type="text" class="form-control" id="act_nombre" name="act_nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="act_desc" class="col-xs-1" style="text-align: right;">Descripción:</label>
                            <div class="col-xs-10" style="float:left !important;">
                                <textarea class="form-control" id="act_desc" name="act_desc" placeholder="Descripción de la Actividad" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="act_estados" class="col-xs-1" style="text-align: right;">Estado: <span class="requerido">*</span></label>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_estados" name="act_estados" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group"></div>
                        
                        <legend class="col-form-label" style="display: inline-grid">Clasificación</legend>
                        <div class="form-group">
                            <label for="act_categorias" class="col-xs-1" style="text-align: right;">Cat.<span class="requerido">*</span>/Tarea<span class="requerido">*</span>:</label>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_categorias" name="act_categorias" class="selectpicker" data-live-search="true" data-width="33%" placeholder="Categorías" title="Categorías">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_tareas" name="act_tareas" class="selectpicker" data-live-search="true" data-width="33%" placeholder="Tareas" title="Tareas">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label for="act_mantenimientos" class="col-xs-1" style="text-align: right;">Item: <span class="requerido2">*</span></label>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_mantenimientos" name="act_mantenimientos" class="selectpicker" data-live-search="true" data-width="33%" placeholder="Mantenimientos" title="Mantenimientos">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_proyectos" name="act_proyectos" class="selectpicker" data-live-search="true" data-width="33%" placeholder="Proyectos" title="Proyectos">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_ofertas" name="act_ofertas" class="selectpicker" data-live-search="true" data-width="33%" placeholder="Ofertas" title="Ofertas">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label for="act_prior" class="col-xs-1" style="text-align: right;">Prioridad: <span class="requerido">*</span></label>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_prior" name="act_prior" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <!--<label for="act_tecnicos" class="col-xs-1" style="text-align: right;">Asignado:</label>
                            <div class="col-xs-3" style="float:left !important;">
                                <select id="act_tecnicos" name="act_tecnicos" class="selectpicker" data-live-search="true" data-width="33%" title="Técnico Asignado">
                                    <option></option>
                                </select>
                            </div>-->
                            <label for="act_tecnicos" class="col-xs-1" style="text-align: right;">Asignado: <span class="requerido">*</span></label>
                            <div class="col-xs-3" style="float:left !important;" >
                                <select id="act_tecnicos" name="act_tecnicos" class="selectpicker" data-live-search="true" data-width="33%" title="Técnico Asignado">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-3" style="float:left !important;" >
                                <button type="button" id="btn_add_tec" class="btn btn-info">Añadir Técnico</button>
                                <button type="button" id="btn_clear_tec" class="btn btn-primary">Quitar Técnico</button>
                            </div>
                            
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-1"></div>
                            <div class="col-xs-3">
                                <select class="form-control" id="act_addtecnicos" name="act_addtecnicos[]" multiple readonly>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label for="act_chkfacturable" class="col-xs-1" style="text-align: right;">Facturable:</label>
                            <div class="col-xs-1" style="float:left !important;">
                                <input type="checkbox" name="act_chkfacturable" id="act_chkfacturable" data-size="mini">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label for="act_chkimputable" class="col-xs-1" style="text-align: right;">Imputable:</label>
                            <div class="col-xs-1" style="float:left !important;">
                                <input type="checkbox" name="act_chkimputable" id="act_chkimputable" data-size="mini">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group"></div>
                        
                        <legend class="col-form-label" style="display: inline-grid">Finalización</legend>
                        <div class="form-group">
                            <label for="act_fecha_solucion" class="col-xs-1" style="text-align: right;">Fecha Solución:</label>
                            <div class="col-xs-3" style="float:left !important;">
                                <input type="date" class="form-control" id="act_fecha_solucion" name="act_fecha_solucion">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="act_solucion" class="col-xs-1" style="text-align: right;">Solución:</label>
                            <div class="col-xs-10" style="float:left !important;">
                                <textarea class="form-control" id="act_solucion" name="act_solucion" placeholder="Solución de la Actividad" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="act_fecha_factu" class="col-xs-1" style="text-align: right;">Fecha Factu.:</label>
                            <div class="col-xs-3" style="float:left !important;">
                                <input type="date" class="form-control" id="act_fecha_factu" name="act_fecha_factu">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="act_observ" class="col-xs-1" style="text-align: right;">Observaciones:</label>
                            <div class="col-xs-10" style="float:left !important;">
                                <textarea class="form-control" id="act_observ" name="act_observ" placeholder="Observaciones de la Actividad" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="act_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Actividad guardada</p>
                    </div>
                    <div class="alert-middle alert alert-danger alert-dismissable" id="act_error" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Datos necesarios incompletos</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_act_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>