<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-documento" title="Añadir Documento"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="add-group" title="Grupos de Documentos"><img src="/erp/img/folder.png" height="20"></button>
    <button class="button" id="search-documento" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-documento" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="entrega_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_proyecto_add_doc">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="doc_entrega_id" id="doc_entrega_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Titulo:</label>
                            <input type="text" class="form-control" id="entrega_doctitulo" name="entrega_doctitulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripcion:</label>
                            <input type="text" class="form-control" id="entrega_docdesc" name="entrega_docdesc">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Fecha Documento: </label>
                            <input type="date" class="form-control" id="adddocEntrega_fecha" name="adddocEntrega_fecha">
                            <label class="labelBefore">Archivo: </label>
                            <div class="file-loading">
                                <label class="labelBefore">Adjunto:</label>
                                <input type="file" id="newentrega_adjunto" name="newentrega_adjunto[]" data-show-preview="true" data-browse-on-zone-click="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <!--
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_proyecto_save" class="btn btn-primary">Guardar</button>
                
            </div>
            -->
        </div>
    </div>
</div>

<div id="proyecto_adddocgroup_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">GRUPOS DE DOCUMENTOS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_proyecto_addgroup_doc">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="gruposdoc_proyecto_id" id="gruposdoc_proyecto_id">
                        <input type="hidden" name="gruposdoc_idgrupo" id="gruposdoc_idgrupo">
                        <input type="hidden" name="gruposdoc_del" id="gruposdoc_del">
                        <input type="hidden" name="gruposdoc_proyectopath" id="gruposdoc_proyectopath" value="<? echo $proyectopath; ?>">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Grupo:</label>
                            <select id="proyecto_gruposdocgrupos" name="proyecto_gruposdocgrupos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="proyecto_gruposdocnombre" name="proyecto_gruposdocnombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripcion:</label>
                            <input type="text" class="form-control" id="proyecto_gruposdocdesc" name="proyecto_gruposdocdesc">
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newgrupodoc_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Grupo guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_proyecto_gruposdoc_save" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_gruposdoc" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Documentos Entregas -->
<div id="confirm_deldoc_entrega_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR DOCUMENTO ENTREGA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" name="deldoc_entregas" id="deldoc_entregas">
                    <p>¿Estas seguro de que quiere borrar el Documento de las entregas?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_deldoc_entregas" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>