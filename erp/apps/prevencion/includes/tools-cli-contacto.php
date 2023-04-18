<!-- tools doc admon -->
<div class="form-group form-group-tools">
    <button class="button" id="add-contacto-CLI" title="Añadir Contacto Cliente"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh_contactos_CLI" title="Refrescar"><img src="/erp/img/refresh.png" height="20"></button>
</div>
<!-- tools doc admon -->

<!-- Modal contacto CLiente -->
<div id="addcontactoCLI_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR CONTACTO CLIENTE</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_contacto_CLI">
                        <input type="hidden" class="form-control" id="newcontactoCLI_id" name="newcontactoCLI_id">
                        <input type="hidden" class="form-control" id="newcontactoCLI_id_update" name="newcontactoCLI_id_update">
                        <div class="form-group">
                            <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newcontactoCLI_nombre" name="newcontactoCLI_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Mail: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newcontactoCLI_mail" name="newcontactoCLI_mail">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Teléfono: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newcontactoCLI_telefono" name="newcontactoCLI_telefono">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newcontactoCLI_instalacion" class="labelBefore">Instalacion: <span class="requerido">*</span></label>
                                <select id="newcontactoCLI_instalacion" name="newcontactoCLI_instalacion" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6" style="margin-top: 3px;">
                                <label class="labelBefore"></label>
                                <button type="button" class="btn btn-info" id="btn_viewInstalaciones">
                                    Gestionar Instalaciones
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Activo:</label>
                            <input type="checkbox" name="newcontactoCLI_activo" id="newcontactoCLI_activo" checked data-size="mini">
                            <input type="text" name="txt_activo" id="txt_activo" hidden>                            
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newcontactoCLI_desc" name="newcontactoCLI_desc" placeholder="Descripción del Contacto" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--<br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newcontactoCLI_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Contacto Cliente guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_contacto_CLI" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- / Modal contacto CLiente -->

<!-- Delete Contacto -->
<div id="confirm_del_contacto_CLI_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR CONTACTO CLIENTE</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_contacto_cliente" id="del_contacto_cliente" value="">
                <button class="button" id="add-instalacion-cliente" title="Añadir Instalación a cliente"><img src="/erp/img/add.png" height="20"></button>
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>¿Estas seguro que quieres eliminar el contacto del cliente?</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_contacto_cliente" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- / Delete Contacto -->

<!-- Gestionar Instalaciones -->
<div id="gestionarInstalaciones_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">GESTIÓN INSTALACIONES</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="cliente_id_in" name="cliente_id_in">
                <div class="contenedor-form" id="instalaciones_cliente_tabla">
                    <!-- A insertar tabla -->
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" id="btn_del_contacto_cliente" class="btn btn-primary">Eliminar</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- / Gestionar Instalaciones -->

<!-- Añadir Contacto -->
<div id="confirm_add_instalacion_CLI_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR INSTALACION DEL CLIENTE</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_instalacion_CLI">
                        <input type="hidden" class="form-control" id="newcontactoCLI_id" name="newinstalacionCLI_id">
                        <input type="hidden" class="form-control" id="newcontactoCLI_id_update" name="newinstalacionCLI_id_update">
                        <div class="form-group">
                            <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newinstalacionCLI_nombre" name="newinstalacionCLI_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newinstalacionCLI_direccion" name="newinstalacionCLI_direccion">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_instalacion_cliente" class="btn btn-primary">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- / Añadir Contacto -->


<!-- Delete Contacto -->
<div id="confirm_del_instalacion_CLI_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR INSTALACION DEL CLIENTE</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_instalacion_cliente" id="del_instalacion_cliente" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>¿Estas seguro que quieres eliminar la instalacion del cliente?</p>
                        <p>Esto puede generar problemas de cara a futuro y no quedar referenciadas las instalaciones.</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_instalacion_cliente" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- / Delete Contacto -->