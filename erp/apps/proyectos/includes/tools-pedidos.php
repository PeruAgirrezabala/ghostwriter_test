<div class="form-group form-group-tools" style="width: 70%;">
    <button class="button" id="add_from_almacen_view" title="Añadir Stock de Almacén"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="view-posiciones" title="Ver Posiciones"><img src="/erp/img/posiciones.png" height="20"></button>
    <button class="button" id="add-pedidos-to-material" title="Añadir Material automáticamente (Deshabilitado temporalmente)" disabled><img src="/erp/img/right-arrow.png" height="20"></button>
    <label id="adding-mat" class="label label-success blink_me" style="margin-left: 2%; display: none;">Añadiendo material al Proyecto</label>
</div>

<div id="add-pedidos-to-material_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore text-center">¿Estas seguro de que deseas añadir todo el material pedido al proyecto?</label>
                    </div>
                    <div class="form-group"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="add-pedidos-to-material-button" data-id="" class="btn btn-info">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>



