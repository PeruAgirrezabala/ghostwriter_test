<!-- filtros proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="edit_int" title="Editar Intervención"><img src="/erp/img/edit.png" height="30"></button>
    <button class="button" id="print_int" title="Imprimir Intervención"><img src="/erp/img/print.png" height="30"></button>
    <button class="button" id="delete_int" title="Eliminar Intervención"><img src="/erp/img/bin.png" height="30"></button>
    <input type="hidden" id="to_albaran">
</div>

<div id="int_duplicar_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DUPLICAR INTERVENCIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_duplicar_int">
                        <input type="hidden" value="" name="duplicar_int_id" id="duplicar_int_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="newduplicado_titulo" name="newduplicado_titulo">
                        </div>
                        <div class="col-xs-6">
                            <label class="labelBeforeBlack">Proyecto:</label>
                            <!-- <input type="text" class="form-control" id="proyectomaterial_dtoprov" name="proyectomaterial_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                            <select id="duplicar_pedido_proyectos" name="duplicar_pedido_proyectos" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_duplicarint_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- filtros proyectos -->