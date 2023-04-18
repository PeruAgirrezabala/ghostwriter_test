<!-- accesosweroi -->
<div id="accesosweroi">
    
    <!-- Este boton está aqui pero se mueve por jquery al cargar el grid para ponerlo a la altura de los botones del grid -->
    <button type="button" class="btn btn-default" id="command-add" data-row-id="0">
        <span class="glyphicon glyphicon-plus"></span> Nuevo Usuario
    </button>
    
    <!--
    <div class="buttonContainer">
        <button type="button" class="btn btn-default" id="pruebadetalles" data-row-id="0">
            <span class="glyphicon glyphicon-plus"></span> Prueba
        </button>
    </div>
    -->
    
    <div class="table-responsive">
        <!--
        <div class="well clearfix">
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-primary" id="command-add" data-row-id="0">
                    <span class="glyphicon glyphicon-plus"></span> Record
                </button>
            </div>
        </div>
        -->
            <!--
            <table id="employee_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
                <thead>
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
                        <th data-column-id="nombre">Nombre</th>
                        <th data-column-id="apellido">Apellido</th>
                        <th data-column-id="email">email</th>
                        <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commandos</th>
                    </tr>
                </thead>
            </table>
            -->
        <table id="weroi_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
                    <th data-column-id="nombre">Nombre</th>
                    <th data-column-id="apellidos">Apellidos</th>
                    <th data-column-id="user_email">Email</th>
                    <th data-column-id="telefono">Teléfono</th>
                    <th data-column-id="empresa">Empresa</th>
                    <th data-column-id="user_password">Contraseña</th>
                    <th data-column-id="role">Rol</th>
                    <th data-column-id="activo">Activo</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
                    <th data-column-id="role_id">role_id</th>
                </tr>
            </thead>
        </table>
    </div>

    <div id="edit_model" class="modal fade">
        <div class="modal-dialog dialog_mediano">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">EDITAR USUARIO</h4>
                </div>
                <div class="modal-body">
                    <div class="contenedor-form">
                        <form method="post" id="frm_edit">
                            <input type="hidden" value="edit" name="action" id="action">
                            <input type="hidden" value="0" name="edit_id" id="edit_id">
                            <div class="crmdetalles-block2" style="margin-bottom: 0px;">
                                <h5>
                                    INFORMACIÓN DEL USUARIO
                                </h5>
                                <div class="form-group">
                                    <label class="labelBefore">Nombre: <span id="edit_nombreUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="edit_nombreUsuario" name="edit_nombreUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Apellidos: <span id="edit_apellidosUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="edit_apellidosUsuario" name="edit_apellidosUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Email: <span id="edit_emailUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="email" class="form-control" id="edit_emailUsuario" name="edit_emailUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Teléfono: <span id="edit_tlfnoUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="edit_tlfnoUsuario" name="edit_tlfnoUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Empresa: <span id="edit_empresaUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="edit_empresaUsuario" name="edit_empresaUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Cambiar Password:</label>
                                    <input type="password" class="form-control" id="edit_passwordUsuario" name="edit_passwordUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Rol: <span id="edit_accesosroles_roles-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <select id="edit_accesosroles_roles" name="edit_accesosroles_roles" class="selectpicker" data-live-search="true">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Activo:</label>
                                    <input type="checkbox" name="chkactivo" id="edit_chkactivo" checked data-size="mini">
                                </div>
                            </div>
                            <div class="crmdetalles-block2" style="margin-bottom: 0px; background-color: #999999 !important;">
                                <h4 style="color: #ffffff;">
                                    ACCESO A PROYECTOS
                                </h4>
                                <div class="form-group">
                                    <label class="labelBefore" style="color: #ffffff;">Proyecto:</label>
                                    <select id="edit_accesos_proyecto" name="edit_accesos_proyecto" class="selectpicker" data-live-search="true">
                                        <option></option>
                                    </select>
                                    <input type="checkbox" name="chkescritura-weroi" id="chkescritura-weroi" checked data-size="small" data-label-text="Editor" data-label-width="40">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" id="asignar-proyecto-weroi"><span class="glyphicon glyphicon-plus"></span> Conceder</button>
                                    <button type="button" class="btn btn-default" id="desasignar-proyecto-weroi"><span class="glyphicon glyphicon-minus"></span> Denegar</button>
                                </div>
                                <div id="alertProyectosWeroi" class="alert alert-danger alert-dismissable" style="display:none;">
                                    <button type="button" class="close" aria-hidden="true">&times;</button>
                                    <p id="errorMessageWeroi"></p>
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore" style="color: #ffffff;">Proyectos Asignados:</label>
                                    <select multiple class="form-control" id="edit_proyectosacceso" name="edit_proyectosacceso" style="height: 200px !important;">
                                        
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_edit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="add_model" class="modal fade">
        <div class="modal-dialog dialog_estrecho">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">NUEVO USUARIO</h4>
                </div>
                <div class="modal-body">
                    <div class="contenedor-form">
                        <form method="post" id="frm_add">
                            <input type="hidden" value="add" name="action" id="action">
                            <div class="crmdetalles-block4 crmdetalles-block4-full" style="margin-bottom: 0px;">
                                <h5>
                                    INFORMACIÓN DEL USUARIO
                                </h5>
                                <div class="form-group">
                                    <label class="labelBefore">Nombre: <span id="new_nombreUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="new_nombreUsuario" name="new_nombreUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Apellidos: <span id="new_apellidosUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="new_apellidosUsuario" name="new_apellidosUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Email: <span id="new_emailUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="email" class="form-control" id="new_emailUsuario" name="new_emailUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Teléfono: <span id="new_tlfnoUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="new_tlfnoUsuario" name="new_tlfnoUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Empresa: <span id="new_empresaUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="new_empresaUsuario" name="new_empresaUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Password: <span id="new_passwordUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="password" class="form-control" id="new_passwordUsuario" name="new_passwordUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Rol: <span id="new_accesosroles_roles-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <select id="new_accesosroles_roles" name="new_accesosroles_roles" class="selectpicker" data-live-search="true">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_add" class="btn btn-primary">Guardar</button>
                </div>
                <div id="alertNewUsuario" class="alert alert-danger alert-dismissable" style="display:none;">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <p id="errorNewUsuario"></p>
                </div>
            </div>
        </div>
    </div>
</div> 
<!-- accesosweroi -->