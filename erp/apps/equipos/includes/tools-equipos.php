<!-- tools equipos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-pc" title="Añadir PC"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh-pcs" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools equipos -->

<div id="addPC_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">NUEVO EQUIPO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_pc">
                        <input type="hidden" class="form-control" id="newPC_idpc" name="newPC_idpc">
                        <input type="hidden" class="form-control" id="newPC_delid" name="newPC_delid">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">HOSTNAME:</label>
                                <input type="text" class="form-control" id="newPC_hostname" name="newPC_hostname">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newPC_desc" name="newPC_desc" placeholder="Descripción del Equipo" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newPC_proyectos" class="labelBefore">Proyecto: </label>
                                <select id="newPC_proyectos" name="newPC_proyectos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">FECHA INI:</label>
                                <input type="date" class="form-control" id="newPC_fecha_ini" name="newPC_fecha_ini">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newPC_proyectos" class="labelBefore">Técnico: </label>
                                <select id="newPC_tecnicos" name="newPC_tecnicos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newPC_proyectos" class="labelBefore">Estado: </label>
                                <select id="newPC_estados" name="newPC_estados" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newPC_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Equipo guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_pc" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- PCs activos -->

<!-- Confirmar borrado -->

<div id="delocnfirmPC_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" class="form-control" id="delPC_id" name="delPC_id">
                    <p>¿Estas seguro de que quieres eliminar este equipo?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_pc" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
