<div class="form-group form-group-tools">
    <button class="button" id="add-perfil" title="Nuevo Perfil"><img src="/erp/img/add.png" height="20"></button>
</div>

<div id="addPerfil_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR PERFIL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_perfil">
                        <input type="hidden" class="form-control" id="newperfil_id" name="newperfil_id">
                        <input type="hidden" class="form-control" id="newperfil_del" name="newperfil_del">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newperfil_nombre" name="newperfil_nombre">
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newperfil_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Perfil guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_perfil" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_perfil" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
