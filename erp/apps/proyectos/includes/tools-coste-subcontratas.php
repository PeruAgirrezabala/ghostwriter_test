<!-- tools subcaontratas -->
<div class="form-group form-group-tools">
    <button class="button" id="add-costesubcontratas" title="Añadir Subcontratación. Deshabilitado por el momento; añadir desde ofertas." disabled><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-costesubcontratas" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-costesubcontratas" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools subcontratas -->

<!-- Confirmar del Subcontratas --> 
<div id="confirm_del_sub_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR SUBCONTRATA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_sub_id" id="del_sub_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar esta subcontratación de este proyecto?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-del-sub" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>