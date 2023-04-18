<!-- filtros entregas -->
<div class="form-group form-group-tools">
    <button class="button" id="edit_entrega" title="Editar Entrega"><img src="/erp/img/edit.png" height="30"></button>
    <button class="button" id="save_entrega" title="Guardar Entrega"><img src="/erp/img/save.png" height="30"></button>
    <button class="button" id="delete_entrega" title="Eliminar Entrega"><img src="/erp/img/bin.png" height="30"></button>
    <!--<button class="button" id="add-grupo-envio" title="Realizar Envío del Grupo de Materiales.
        Solo se puede hacer si estan todos Aprobados o si no se ha realizado un envio antes."><img src="/erp/img/right-arrow.png" height="30"></button>
    <button class="button" id="ira-envio" title="Ir a Envios" style="display:none"><img src="/erp/img/proveedores.png" height="30"></button>-->
    <button class="button" id="duplicar_entrega" title="Duplicar Entrega"><img src="/erp/img/duplicar.png" height="30"></button>
</div>

<!-- filtros entregas -->
<!-- Confirmar borrado -->
<div id="confirm_delete_entrega" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR ENTREGA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore text-center">Esta Opción eliminará todos los ensayos/pruebas de la entrega y la entrega misma.</label>
                        <label class="labelBefore text-center">¿Estas seguro de que lo quieres eliminar?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_delete_entrega" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar duplicar -->
<div id="confirm_duplicate_entrega" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DUPLICAR ENTREGA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore text-center">Esta Opción duplicará todos los ensayos/pruebas de la entrega y la entrega misma.</label>
                        <label class="labelBefore text-center">¿Estas seguro de que lo quieres duplicar?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_duplicate_entrega" data-id="" class="btn btn-info">Duplicar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Añadir Instalacion -->
<div id="addinstalacion_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR INSTALACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_instalacion">
                        <div class="form-group">
                            <label class="labelBefore">Cliente: </label>
                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="<? echo $cliente; ?>" disabled>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre Instalación: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="nombre_instalacion" name="nombre_instalacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="direccion_instalacion" name="direccion_instalacion">
                        </div>
                        <div class="form-group"></div>                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_instalacion" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>