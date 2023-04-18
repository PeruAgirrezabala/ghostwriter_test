<div class="form-group form-group-tools">
    <button class="button" id="add-role" title="Nuevo Role"><img src="/erp/img/add.png" height="20"></button>
</div>

<div id="addRole_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">NUEVO REGISTRO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_role">
                        <input type="hidden" class="form-control" id="newrole_idrole" name="newrole_idrole">

                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newrole_nombre" name="newrole_nombre">
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newrole_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Role guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_role" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>