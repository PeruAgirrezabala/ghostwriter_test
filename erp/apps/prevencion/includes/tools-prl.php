<!-- tools doc admon -->
<div class="form-group form-group-tools">
    <button class="button" id="add-doc-PRL" title="Subir documento PRL"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh_doc_PRL" title="Refrescar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools doc admon -->

<div id="adddocPRL_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR DOCUMENTO PREVENCIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_doc_PRL">
                        <input type="hidden" class="form-control" id="newdocPRL_id" name="newdocPRL_id">
                        <input type="hidden" class="form-control" id="newdocPRL_delid" name="newdocPRL_delid">
                        <div class="form-group">
                            <label class="labelBefore">Empresa: <span class="requerido">*</span></label>
                            <select id="newdocPRL_empresas" name="newdocPRL_empresas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newdocPRL_nombre" name="newdocPRL_nombre">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newdocPRL_desc" name="newdocPRL_desc" placeholder="Descripción del Documento" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Organismo: <span class="requerido">*</span></label>
                            <select id="newdocPRL_organismo" name="newdocPRL_organismo" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Periodicidades: <span class="requerido">*</span></label>
                            <select id="newdocPRL_periodicidades" name="newdocPRL_periodicidades" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--<br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newdocPRL_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Documento guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_doc_PRL" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- doc admon -->

<div id="adddocPRL_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_adddocPRL">
                        <input type="hidden" id="adddocPRL_iddoc">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha Emisión:</label>
                                <input type="date" class="form-control" id="adddocPRL_docfechaexp" name="adddocPRL_docfechaexp">
                            </div>
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <div class="file-loading">
                                <label class="labelBefore">Archivo</label>
                                <input id="uploaddocsPRL" name="uploaddocsPRL[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
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