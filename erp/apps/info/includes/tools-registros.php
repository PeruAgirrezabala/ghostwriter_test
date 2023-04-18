<div class="form-group form-group-tools">
    <button class="button" id="add-registro" title="Nuevo Registro"><img src="/erp/img/add.png" height="20"></button>
</div>

<div id="addRegistro_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">NUEVO REGISTRO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_registro">
                        <input type="hidden" class="form-control" id="newregistro_idreg" name="newregistro_idreg">
                        <input type="hidden" class="form-control" id="newregistro_delreg" name="newregistro_delreg">
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBefore">Empresa:</label>
                                <select id="newregistro_empresa" name="newregistro_empresa" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Plataforma:</label>
                            <input type="text" class="form-control" id="newregistro_plataforma" name="newregistro_plataforma">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Usuario:</label>
                            <input type="text" class="form-control" id="newregistro_usuario" name="newregistro_usuario">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Contraseña:</label>
                            <input type="text" class="form-control" id="newregistro_pass" name="newregistro_pass">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newregistro_desc" name="newregistro_desc" placeholder="Descripción de la Plataforma" rows="8"></textarea>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newregistro_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Registro guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_registro" class="btn btn-info">Guardar</button>
                <!--<button type="button" id="btn_del_registro_modal" class="btn btn-primary">Eliminar</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar Delete Registro plataformas--> 
<div id="confirm_del_reg_plat_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR REGISTRO PLATAFORMAS</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_reg_plat" id="del_reg_plat" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>¿Estas seguro que quieres eliminar el registro de la plataforma?</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_registro" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>