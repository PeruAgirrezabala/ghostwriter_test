<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-documento-cli" title="Añadir Documento" type="button"><img src="/erp/img/add.png" height="20" style="width: auto !important;"></button>
</div>

<div id="clientes_adddoc_model" class="modal fade">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_clientedocs">
                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="clientes_docnombre" name="clientes_docnombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripcion:</label>
                            <input type="text" class="form-control" id="clientes_docdesc" name="clientes_docdesc">
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <div class="file-loading">
                                <label class="labelBefore">Archivos</label>
                                <input id="uploaddocs_cli" name="uploaddocs_cli[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
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