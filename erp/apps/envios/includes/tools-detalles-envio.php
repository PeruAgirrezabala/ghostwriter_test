<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-detalleenvio" title="Añadir Detalle"><img src="/erp/img/add.png" height="20"></button>
</div>

<!-- tools proyectos -->
<!-- Confirmacion Borrado -->
<div id="remove_detalleenvio_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_detenvio" id="del_detenvio">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar el detalle?</label>
                    </div>
                    <div class="form-group">
                           
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_remove_detalle" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- / Confirmacion Borrado -->