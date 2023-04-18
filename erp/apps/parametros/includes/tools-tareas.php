<div class="form-group form-group-tools">
    <button class="button" id="add-tarea" title="Nueva Tarea"><img src="/erp/img/add.png" height="20"></button>
</div>

<div id="addTarea_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR TAREA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_tarea">
                        <input type="hidden" class="form-control" id="newtarea_id" name="newtarea_id">
                        <input type="hidden" class="form-control" id="newtarea_del" name="newtarea_del">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newtarea_nombre" name="newtarea_nombre">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBefore">Perfil:</label>
                                <select id="newtarea_perfil" name="newtarea_perfil" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newtarea_desc" name="newtarea_desc" placeholder="Descripción de la Tarea" rows="8"></textarea>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newtarea_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Tarea guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_tarea" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_tarea" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>