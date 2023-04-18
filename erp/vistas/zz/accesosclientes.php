<!-- accesosweroi -->
<div id="accesosclientes">
    
    <!-- Este boton está aqui pero se mueve por jquery al cargar el grid para ponerlo a la altura de los botones del grid -->
    <button type="button" class="btn btn-default" id="clients-command-add" data-row-id="0">
        <span class="glyphicon glyphicon-plus"></span> Nuevo Cliente
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
        <table id="clients_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
                    <th data-column-id="nombre">Nombre</th>
                    <th data-column-id="apellidos">Apellidos</th>
                    <th data-column-id="user_email">Email</th>
                    <th data-column-id="telefono">Teléfono</th>
                    <th data-column-id="empresa">Empresa</th>
                    <th data-column-id="user_password">Contraseña</th>
                    <th data-column-id="activo">Activo</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>

    <div id="editclient_model" class="modal fade">
        <div class="modal-dialog dialog_mediano">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">EDITAR CLIENTE</h4>
                </div>
                <div class="modal-body">
                    <div class="contenedor-form">
                        <form method="post" id="frm_edit_client">
                            <input type="hidden" value="edit" name="action" id="action">
                            <input type="hidden" value="0" name="editclient_id" id="editclient_id">
                            <div class="crmdetalles-block2" style="margin-bottom: 0px;">
                                <h4>
                                    INFORMACIÓN DEL CLIENTE
                                </h4>
                                <div class="form-group">
                                    <label class="labelBefore">Nombre: <span id="editclient_nombreUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="editclient_nombreUsuario" name="editclient_nombreUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Apellidos: <span id="editclient_apellidosUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="editclient_apellidosUsuario" name="editclient_apellidosUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Email: <span id="editclient_emailUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="email" class="form-control" id="editclient_emailUsuario" name="editclient_emailUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Teléfono: <span id="editclient_telefono-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="editclient_telefono" name="editclient_telefono">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Empresa: <span id="editclient_empresa-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="editclient_empresa" name="editclient_empresa">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Cambiar Password:</label>
                                    <input type="password" class="form-control" id="editclient_passwordUsuario" name="editclient_passwordUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Activo:</label>
                                    <input type="checkbox" name="chkactivoclient" id="editclient_chkactivo" checked data-size="mini">
                                </div>
                            </div>
                            <div class="crmdetalles-block2" style="margin-bottom: 0px; background-color: #999999 !important;">
                                <h4 style="color: #ffffff;">
                                    ACCESO A PROYECTOS
                                </h4>
                                <div class="form-group">
                                    <label class="labelBefore" style="color: #ffffff;">Proyecto:</label>
                                    <select id="accesos_proyecto" name="accesos_proyecto" class="selectpicker" data-live-search="true">
                                        <option></option>
                                    </select>
                                    <input type="checkbox" name="chkescritura" id="chkescritura" checked data-size="small" data-label-text="Editor" data-label-width="40">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" id="asignar-proyecto"><span class="glyphicon glyphicon-plus"></span> Conceder</button>
                                    <button type="button" class="btn btn-default" id="desasignar-proyecto"><span class="glyphicon glyphicon-minus"></span> Denegar</button>
                                </div>
                                <div id="alertProyectosClientes" class="alert alert-danger alert-dismissable" style="display:none;">
                                    <button type="button" class="close" aria-hidden="true">&times;</button>
                                    <p id="errorMessageClientes"></p>
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore" style="color: #ffffff;">Proyectos Asignados:</label>
                                    <select multiple class="form-control" id="editclient_proyectosacceso" name="editclient_proyectosacceso">
                                        
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="client_btn_edit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="addclient_model" class="modal fade">
        <div class="modal-dialog dialog_estrecho">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">NUEVO CLIENTE</h4>
                </div>
                <div class="modal-body">
                    <div class="contenedor-form">
                        <form method="post" id="frm_add_client">
                            <input type="hidden" value="add" name="action" id="action">
                            <div class="crmdetalles-block4 crmdetalles-block4-full" style="margin-bottom: 0px;">
                                <h5>
                                    INFORMACIÓN DEL CLIENTE
                                </h5>
                                <div class="form-group">
                                    <label class="labelBefore">Nombre: <span id="newclient_nombreUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="newclient_nombreUsuario" name="newclient_nombreUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Apellidos: <span id="newclient_apellidosUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="newclient_apellidosUsuario" name="newclient_apellidosUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Email: <span id="newclient_emailUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="email" class="form-control" id="newclient_emailUsuario" name="newclient_emailUsuario">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Teléfono: <span id="newclient_telefono-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="newclient_telefono" name="newclient_telefono">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Empresa: <span id="newclient_empresa-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="text" class="form-control" id="newclient_empresa" name="newclient_empresa">
                                </div>
                                <div class="form-group">
                                    <label class="labelBefore">Password: <span id="newclient_passwordUsuario-error" class="labelerror" style="display: none;">* Este campo es obligatorio</span></label>
                                    <input type="password" class="form-control" id="newclient_passwordUsuario" name="newclient_passwordUsuario">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="client_btn_add" class="btn btn-primary">Guardar</button>
                </div>
                <div id="alertNewCliente" class="alert alert-danger alert-dismissable" style="display:none;">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <p id="errorNewCliente"></p>
                </div>
            </div>
        </div>
    </div>
</div> 
<!-- accesosweroi -->