<div class="form-group form-group-tools">
    <button class="button" id="add-categoria" title="Nueva Categoría"><img src="/erp/img/add.png" height="20"></button>
</div>

<div id="addCat_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR CATEGORÍA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_cat">
                        <input type="hidden" class="form-control" id="newCat_id" name="newCat_id">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newCat_nombre" name="newCat_nombre">
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newCat_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Categoría guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_cat" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_cat" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
