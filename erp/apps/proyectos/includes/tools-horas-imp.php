<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-horas" title="Imputar Horas"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-horas" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-horas" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>
<div id="horas_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">IMPUTAR HORAS TRABAJADAS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_horas">
                        <input type="hidden" value="" name="horas_detalle_id" id="horas_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="horas_proyecto_id" id="horas_proyecto_id">
                        <input type="hidden" value="" name="horas_tarea_id" id="horas_tarea_id">
                        <input type="hidden" value="" name="deldetalle" id="deldetalle">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Tareas:</label>
                            <select id="horas_tareas" name="horas_tareas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Tipo de Horas:</label>
                            <select id="horas_horas" name="horas_horas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="horas_titulo" name="horas_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="horas_descripcion" name="horas_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="labelBeforeBlack">Horas Trabajadas:</label>
                                <input type="text" class="form-control" id="horas_cantidad" name="horas_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Técnico:</label>
                            <select id="horas_tecnicos" name="horas_tecnicos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBeforeBlack">Fecha:</label>
                                <input type="date" class="form-control" id="horas_fecha" name="horas_fecha">
                            </div>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_horas_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>