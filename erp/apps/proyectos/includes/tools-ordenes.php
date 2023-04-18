<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-orden" title="Crear Orden de Trabajo. DESHABILITADO por el momento" disabled><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-orden" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-orden" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
    <button class="button" id="refresh-resumenhoras" title="Actualizar resumen horas" hidden></button>
</div>

<!-- tools proyectos -->
<!-- DELETE VERSIONES -->
<div id="delete_ordenes_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_orden_id" id="del_orden_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar esta orden?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_orden" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="orden_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR ORDEN DE TRABAJO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_orden">
                        <input type="hidden" value="" name="orden_detalle_id" id="orden_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="orden_proyecto_id" id="orden_proyecto_id">
                        <input type="hidden" value="" name="orden_tarea_id" id="orden_tarea_id">
                        <input type="hidden" value="" name="orden_del" id="orden_del">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Tareas:</label>
                            <select id="orden_tareas" name="orden_tareas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Tipo de Horas:</label>
                            <select id="orden_horas" name="orden_horas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="orden_titulo" name="orden_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="orden_descripcion" name="orden_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Horas Asignadas:</label>
                                <input type="text" class="form-control" id="orden_cantidad" name="orden_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Técnico:</label>
                            <select id="orden_tecnicos" name="orden_tecnicos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fecha Entrega:</label>
                            <input type="date" class="form-control" id="orden_fecha_entrega" name="orden_fecha_entrega">
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_orden_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>