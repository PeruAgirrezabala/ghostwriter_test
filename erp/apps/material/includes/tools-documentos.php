<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-documento" title="Añadir Documento"><img src="/erp/img/add.png" height="20" style="width: auto !important;"></button>
    <button class="button" id="search-documento" title="Buscar"><img src="/erp/img/search.png" height="20" style="width: auto !important;"></button>
    <button class="button" id="refresh-documento" title="Actualizar"><img src="/erp/img/refresh.png" height="20" style="width: auto !important;"></button>
    <?
        if ($pedido_file_path != "") {
    ?>
    <button class="button" id="download-pedido" title="Descargar Pedido"><a href="<? echo $pedido_file_path; ?>" target="_blank"><img src="/erp/img/download.png" height="20" style="width: auto !important;"></a></button>
    <?
        }
    ?>
</div>

<div id="detallepedido_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_pedidodocs">
                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="pedidodetalle_docnombre" name="pedidodetalle_docnombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripcion:</label>
                            <input type="text" class="form-control" id="pedidodetalle_docdesc" name="pedidodetalle_docdesc">
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <div class="file-loading">
                                <label class="labelBefore">Archivos</label>
                                <input id="uploaddocs" name="uploaddocs[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
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

<!-- tools proyectos -->

<!-- Confirm Delete -->
<div id="confirm_del_doc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" name="del_doc_id" id="del_doc_id" value="">
                    <input type="hidden" name="del_option_id" id="del_option_id" value="">
                    <p>¿Estas seguro de que quieres eliminar este documento?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-del-doc" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>