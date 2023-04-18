<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-proc" title="Nueva Plantilla"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-int" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<div id="addProcedimiento_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR PROCEDIMIENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_procedimiento">
                        <input type="hidden" class="form-control" id="newprocedimiento_idproc" name="newprocedimiento_idproc">
                        <input type="hidden" class="form-control" id="newprocedimiento_delproc" name="newprocedimiento_delproc">
                        <div class="form-group">
                            <label class="labelBefore">REF:</label>
                            <input type="text" class="form-control" id="newprocedimiento_REF" name="newprocedimiento_REF">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newprocedimiento_nombre" name="newprocedimiento_nombre">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBefore">Tipo:</label>
                                <select id="newprocedimiento_tipo" name="newprocedimiento_tipo" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newprocedimiento_desc" name="newprocedimiento_desc" placeholder="Descripción del Procedimiento" rows="8"></textarea>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newprocedimiento_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Procedimiento guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_procedimiento" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_procedimiento" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- doc admon -->

<div id="procedimiento_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_adddoc_procedimiento">
                        <input type="hidden" id="docPROC_iddoc">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha Emisión:</label>
                                <input type="date" class="form-control" id="docproc_docfechaexp" name="docproc_docfechaexp">
                            </div>
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <div class="file-loading">
                                <label class="labelBefore">Archivo</label>
                                <input id="uploaddocsPROC" name="uploaddocsPROC[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
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