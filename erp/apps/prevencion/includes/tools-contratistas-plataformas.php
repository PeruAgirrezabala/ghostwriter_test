<!-- tools doc admon -->
<div class="form-group form-group-tools">
    <button class="button" id="add-contratistas-plataformas" title="Añadir Plataforma"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh_contratistas_plataformas" title="Refrescar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools doc admon -->

<div id="addcontratistas-plataformas" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR PLATAFORMA CONTRATISTA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_contratistas-plataformas">
                        <input type="hidden" class="form-control" id="newcontratistas-plataformas-id" name="newcontratistas-plataformas-id">
                        <input type="hidden" class="form-control" id="newcontratistas-plataformas-cli" name="newcontratistas-plataformas-cli">
                        <div class="form-group">
                            <label class="labelBefore">Instalacion: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newcontratistas-plataformas_instalacion" name="newcontratistas-plataformas_instalacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Plataforma: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newcontratistas-plataformas_url" name="newcontratistas-plataformas_url">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Usuario: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newcontratistas-plataformas_usuario" name="newcontratistas-plataformas_usuario">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Contraseña: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newcontratistas-plataformas_pass" name="newcontratistas-plataformas_pass">
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--<br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newcontratistas-plataformas_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Plataforma Guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_contratistas-plataformas" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- delete modal -->

<div id="modal-del-contratistas-plataformas" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR PLATAFORMA CONTRATISTA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_del-contratistas-plataformas">
                        <input type="hidden" id="del-contratistas-plataformas">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <p>¿Estas seguro de que desea eliminar esta plataforma?</p>
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-del-contratistas-plataformas" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>