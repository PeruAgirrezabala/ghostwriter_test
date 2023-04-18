<div class="form-group form-group-tools">
    <button class="button" id="add-hora" title="Nueva Hora"><img src="/erp/img/add.png" height="20"></button>
</div>

<div id="addHora_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR HORA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_hora">
                        <input type="hidden" class="form-control" id="newhora_id" name="newhora_id">
                        <input type="hidden" class="form-control" id="newhora_del" name="newhora_del">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newhora_nombre" name="newhora_nombre">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBefore">Perfil:</label>
                                <select id="newhora_perfil" name="newhora_perfil" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBefore">Tipo de Hora:</label>
                                <select id="newhora_tipo" name="newhora_tipo" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Coste:</label>
                                <input type="text" class="form-control" id="newhora_coste" name="newhora_coste">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Tarifa venta:</label>
                                <input type="text" class="form-control" id="newhora_tarifa" name="newhora_tarifa">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newhora_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Hora guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_hora" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_hora" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>