<!-- filtros proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="edit_act" title="Editar Actividad"><img src="/erp/img/edit.png" height="30"></button>
    <button class="button" id="cancel_act" title="Cancelar"><img src="/erp/img/delete.png" height="30"></button>
    <button class="button" id="print_act" title="Imprimir Actividad"><img src="/erp/img/print.png" height="30"></button>
    <button class="button" id="delete_act" title="Eliminar Actividad"><img src="/erp/img/bin.png" height="30"></button>
    <button class="button" id="dupli_act" title="Duplicar Actividad"><img src="/erp/img/duplicar.png" height="30"></button>
    <button class="button" id="notificacion_act" title="Envíar notificación de Actividad"><img src="/erp/img/campana.png" height="30"></button>    
</div>
<!-- filtros proyectos -->

<!-- Confirmación eliminar actividad -->
<div id="confirm_del_act_modal" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR ACTIVIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" name="act_idact" id="act_idact">
                    <p>¿Estas seguro de que desea borrar la actividad?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_delete_act" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Duplicar actividad -->
<div id="confirm_dupli_act_modal" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DUPLICAR ACTIVIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" name="dupli_act_id" id="dupli_act_id">
                    <p>¿Estas seguro de que desea duplicar la actividad?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_dupli_act" class="btn btn-info">Duplicar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Añadir Instalacion -->
<div id="addinstalacion_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR INSTALACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_instalacion">
                        <div class="form-group">
                            <label class="labelBefore">Cliente: </label>
                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="<? echo $cliente; ?>" disabled>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre Instalación: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="nombre_instalacion" name="nombre_instalacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="direccion_instalacion" name="direccion_instalacion">
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--<br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                        </div>
                        <div class="form-group"></div>                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_instalacion" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- ENVIAR NOTIFICAIÓN -->
<div id="notificacion_act_modal" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ENVIAR NOTIFICACIÓN DE ACTIVIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_instalacion">
                        <div class="form-group">
                            <label class="labelBefore">Se enviará un correo electronico a los técnicos involucrados:</label>
                            <div id="msg_tecnicos">
                                <?
                                    $db = new dbObj();
                                    $connString =  $db->getConnstring();

                                    $sql = "SELECT ACTIVIDAD_USUARIO.actividad_id, erp_users.id, erp_users.nombre, erp_users.apellidos, erp_users.user_email
                                            FROM ACTIVIDAD_USUARIO
                                            INNER JOIN erp_users
                                            ON ACTIVIDAD_USUARIO.user_id = erp_users.id
                                            WHERE actividad_id=".$_GET['id'];
                                    file_put_contents("logGetTecnicosActividad.txt", $sql);
                                    $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Actividades");
                                    
                                    while($reg = mysqli_fetch_row($result)){
                                        $nombre=$reg[2];
                                        $apellidos=$reg[3];
                                        $mail=$reg[4];
                                        echo "<p>".$nombre." ".$apellidos." - ".$mail."</p>";
                                    }
                                ?>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label class="labelBefore">Mensaje Opcional: </label>
                            <textarea rows="4" class="form-control" id="textarea_mensaje" name="textarea_mensaje"></textarea>
                        </div>
                        <div class="form-group"></div>                        
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="act_not_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Mails enviados</p>
                    </div>
                    <div class="alert-middle alert alert-danger alert-dismissable" id="act_not_error" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Ha habido algún error</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_notificacion_act" class="btn btn-info">Enviar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>