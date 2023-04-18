<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-detalleact" title="Añadir Detalle"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh_tareas" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="detalleact_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DETALLE DE ACTIVIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_actdetalle" enctype="multipart/form-data">
                        <input type="hidden" value="" name="actdetalle_detalle_id" id="actdetalle_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="actdetalle_act_id" id="actdetalle_act_id">

                        <div class="form-group">
                            <label class="labelBefore">TÍTULO:</label>
                            <input type="text" class="form-control" id="actdetalle_nombre" name="actdetalle_nombre">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">DESCRIPCIÓN:</label>
                            <textarea class="textarea-cp form-control" id="actdetalle_desc" name="actdetalle_desc" placeholder="Descripción de la Intervención" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBefore">FECHA:</label>
                                <input type="date" class="form-control" id="actdetalle_fecha" name="actdetalle_fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="actdetalle_tecnicos" class="labelBefore">TÉCNICO: </label>
                                <select id="actdetalle_tecnicos" name="actdetalle_tecnicos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="actdetalle_completado" class="labelBefore">COMPLETADO: </label>
                                <select id="actdetalle_completado" name="actdetalle_completado" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div id="bloque-horas" style="display: none;">
                            <legend class="col-form-label" style="display: inline-grid">Horas</legend>
                            <div class="form-group form-group-tools">
                                <button type="button" class="button" id="add-detalleact-horas" title="Añadir Horas"><img src="/erp/img/add.png" height="20"></button>
                            </div>
                            <div class="loading-div"></div>
                            <div class="form-group" id="tabla-horas">
                                <table class="table table-striped table-condensed table-hover" id='tabla-detalleshoras-act'>
                                    <thead>
                                        <tr class="bg-dark">
                                        <th>TECNICO</th>
                                        <th class="text-center">TIPO DE HORAS</th>
                                        <th class="text-center">CANTIDAD</th>
                                        <th class="text-center">E</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_actdetalle_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="detalleact_horas_add_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR HORAS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_actdetallehoras_horas" enctype="multipart/form-data">
                        <input type="hidden" value="" name="actdetallehoras_detalle_id" id="actdetallehoras_detalle_id">
                        <input type="hidden" value="" name="actdetallehoras_hora_id" id="actdetallehoras_hora_id">
                        <input type="hidden" value="" name="actdetallehoras_delhora" id="actdetallehoras_delhora">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="actdetallehoras_act_id" id="actdetallehoras_act_id">

                        <div class="form-group">
                            <label for="actdetallehoras_tecnicos" class="labelBefore">TÉCNICO: </label>
                            <select id="actdetallehoras_tecnicos" name="actdetallehoras_tecnicos" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label for="actdetallehoras_tipo" class="labelBefore">TIPO DE HORA: </label>
                            <select id="actdetallehoras_tipo" name="actdetallehoras_tipo" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBefore">CANTIDAD:</label>
                                <input type="text" class="form-control" id="actdetallehoras_cantidad" name="actdetallehoras_cantidad" value="0">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_actdetallehoras_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- DETALLE -->

<!-- ELIMINAR DETALLE -->
<div id="confirm_del_tarea" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR ACTIVIDAD/TAREA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_tarea_id" id="del_tarea_id">
                    <p>¿Estas seguro de que desea eliminar esta actividad/tarea?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_confirmar_del_tarea" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- ELIMINAR DETALLE -->
<div id="confirm_del_tarea_hora" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR HORA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_tarea_hora_id" id="del_tarea_hora_id">
                    <p>¿Estas seguro de que desea eliminar esta hora de la actividad/tarea?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_confirmar_del_tarea_hora" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>