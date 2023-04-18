<!-- filtros proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="edit_proyecto" title="Editar Mantenimiento"><img src="/erp/img/edit.png" height="30"></button>
    <button class="button" id="save_proyectos" title="Guardar Mantenimiento"><img src="/erp/img/save.png" height="30"></button>
    <button class="button" id="delete_proyecto" title="Eliminar Mantenimiento" disabled><img src="/erp/img/bin.png" height="30"></button>
    <button class="button" id="extend_mantenimiento" title="Extender Mantenimiento"><img src="/erp/img/duplicar.png" height="30"></button>
</div>

<!-- filtros proyectos -->
<div id="add_visita_modal" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR VISITA AL MANTENIMIENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_visita_mant">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="mantenimiento_id" id="mantenimiento_id">
                        <input type="hidden" value="" name="visita_fecha_mant" id="visita_fecha_mant">
                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre Visita: <span class='requerido'>*</span></label>
                            <input type='text' class='form-control' id='visita_nombre_mant' name='visita_nombre_mant'>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Responsable: <span class='requerido'>*</span></label>
                            <select id='visita_responsable_mant' name='visita_responsable_mant' class='selectpicker' data-live-search='true' data-width='33%' title='Técnico Responsable'>
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Estado: <span class='requerido'>*</span></label>
                            <select id='visita_estado_mant' name='visita_estado_mant' class='selectpicker' data-live-search='true' data-width='33%' title='Estado'>
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Prioridad: <span class='requerido'>*</span></label>
                            <select id='visita_prioridad_mant' name='visita_prioridad_mant' class='selectpicker' data-live-search='true' data-width='33%' title='Prioridad'>
                                <option></option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label for='act_edit_tecnicos'>Tecnicos Asignados a la Visita: <span class='requerido'>*</span></label>
                        </div>
                        <div class='form-group'>
                            <div class='col-xs-6'>
                                <select id='visita_tecnicos_mant' name='visita_tecnicos_mant' class='selectpicker' data-live-search='true' data-width='33%' title='Técnico Asignado'>
                                    <option></option>
                                </select>
                            </div>
                            <div class='col-xs-6'>
                                <button type='button' id='btn_add_tec' class='btn btn-info'>Añadir Técnico</button>
                                <button type='button' id='btn_clear_tec' class='btn btn-primary'>Quitar Técnico</button>
                            </div>
                        </div>
                        <div class='form-group'></div>
                        <div class='form-group'>
                            <div class='col-xs-6' id='div_visita_addtecnicos_mant'>
                                    <select class='form-control' id='visita_addtecnicos_mant' name='visita_addtecnicos_mant[]' multiple readonly>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--<br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="visita_addsuccess" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Visiata guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_visita_mant" class="btn btn-info">Agregar Visita</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>