<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-doc" title="Nuevo Documento"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-int" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<div id="addDoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_doc">
                        <input type="hidden" class="form-control" id="newdoc_iddoc" name="newdoc_iddoc">
                        <input type="hidden" class="form-control" id="newdoc_deldoc" name="newdoc_deldoc">
                        <div class="form-group">
                            <label class="labelBefore">REF:</label>
                            <input type="text" class="form-control" id="newdoc_REF" name="newdoc_REF">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newdoc_nombre" name="newdoc_nombre">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBefore">Tipo:</label>
                                <select id="newdoc_tipo" name="newdoc_tipo" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newdoc_desc" name="newdoc_desc" placeholder="Descripción del Documento" rows="8"></textarea>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newdoc_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Documento guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_doc" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_doc_modal" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmación Borrado -->
<div id="delDoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_doc">
                        <input type="hidden" class="form-control" id="newdoc_iddoc" name="newdoc_iddoc">
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro que quieres eliminar el documento?</label>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="deldoc_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Documento eliminado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_del_doc" class="btn btn-primary">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- doc admon -->
<div id="doc_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_adddoc_doc">
                        <input type="hidden" id="docDOC_iddoc">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha Emisión:</label>
                                <input type="date" class="form-control" id="docdoc_docfechaexp" name="docdoc_docfechaexp">
                            </div>
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <div class="file-loading">
                                <label class="labelBefore">Archivo</label>
                                <input id="uploaddocsDOC" name="uploaddocsDOC[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
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