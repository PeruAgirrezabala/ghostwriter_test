<!-- tools crear proceso -->
<div class="form-group form-group-tools">
    <button class="button" id="add-proceso" title="Crear Proceso"><img src="/erp/img/add.png" height="20"></button>
</div>
<!-- tools crear proceso -->

<div id="proceso_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">FICHA DE PROCESO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_proceso">
                        <input type="hidden" value="" name="proceso_id" id="proceso_id">

                        <div class="form-group">
                            <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="proceso_nombre" name="proceso_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Responsable: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="proceso_resp" name="proceso_resp">
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="labelBefore">Año:</label>
                            <input type="text" class="form-control" id="proceso_year" name="proceso_year">
                        </div>
                        -->
                        <div class="form-group">
                            <label class="labelBefore">Departamentos: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="proceso_dptos" name="proceso_dptos">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Objeto: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="proceso_objeto" name="proceso_objeto" placeholder="Objeto" rows="5"></textarea>
                        </div>
                        <!--
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Recursos: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="proceso_recursos" name="proceso_recursos" placeholder="Recursos" rows="5"></textarea>
                        </div>
                        -->
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Entradas: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="proceso_entradas" name="proceso_entradas" placeholder="Entradas" rows="5"></textarea>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Salidas: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="proceso_salidas" name="proceso_salidas" placeholder="Salidas" rows="5"></textarea>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Registros: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="proceso_registros" name="proceso_registros" placeholder="Registros" rows="5"></textarea>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Procedimientos Relacionados: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="proceso_procedimientos" name="proceso_procedimientos" placeholder="Procedimientos Relacionados" rows="5"></textarea>
                        </div>
                        <!--
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Actividades: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="proceso_actividades" name="proceso_actividades" placeholder="Actividades" rows="5"></textarea>
                        </div>
                        -->
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_proceso_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- POP-UP Subir fichero-->

<div id="adddocProcesos_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_adddocProcesos">
                        <input type="hidden" id="adddocProcesos">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha hoy: </label>
                                <input type="date" class="form-control" id="adddocProcesos_fecha" name="adddocProcesos_fecha">
                            </div>
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <label class="labelBefore">Archivo: </label>
                            <div class="file-loading">
                                <label class="labelBefore">Archivo</label>
                                <input id="uploaddocsProcesos" name="uploaddocsPCS[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <!--
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_pedidodetalle_save" class="btn btn-primary">Guardar</button>
                
            </div>
            -->
        </div>
    </div>
</div>