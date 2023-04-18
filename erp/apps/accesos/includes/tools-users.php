<div class="form-group form-group-tools">
    <button class="button" id="add-user" title="Nuevo Trabajador"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="view-users" title="Ver Trabajadores Antiguos SI/NO" value="on"><img id="imgojo-trabajadores" src="/erp/img/ojo.png" height="20"></button>
    <label id="texto-trabajadores">Todos los trabajadores</label>
</div>
<div id="addUser_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">NUEVO REGISTRO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_user">
                        <input type="hidden" class="form-control" id="newuser_iduser" name="newuser_iduser">
                        <input type="hidden" class="form-control" id="newuser_deluser" name="newuser_deluser">
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBefore">Empresa:</label>
                                <select id="newuser_empresas" name="newuser_empresas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Identificador:</label>
                                <input type="text" class="form-control" id="newuser_txartela" name="newuser_txartela">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newuser_nombre" name="newuser_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Apellidos:</label>
                            <input type="text" class="form-control" id="newuser_apellidos" name="newuser_apellidos">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Email:</label>
                            <input type="text" class="form-control" id="newuser_email" name="newuser_email">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Teléfono:</label>
                                <input type="text" class="form-control" id="newuser_tlfno" name="newuser_tlfno">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">NIF:</label>
                                <input type="text" class="form-control" id="newuser_nif" name="newuser_nif">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Firma:</label>
                            <input type="text" class="form-control" id="newuser_firma" name="newuser_firma">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Role:</label>
                                <select id="newuser_roles" name="newuser_roles" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Username:</label>
                                <input type="text" class="form-control" id="newuser_username" name="newuser_username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Contraseña:</label>
                            <input type="password" class="form-control" id="newuser_pass" name="newuser_pass">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Activo:</label>
                            <input class='form-control' name='newuser_activo' type='checkbox' title='Activar Desactivar Trabajador' id='newuser_activo'>
                            <!-- <input type="text" class="form-control" id="newuser_activo" name="newuser_activo"> -->
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Color:</label>
                            <input type="text" class="form-control" id="newuser_color" name="newuser_color">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Avatar:</label>
                            <img id="newuser_avatar_img" style='heith:35px; width:35px'>
                            <button type="button" id="btn_avatar_user" class="btn btn-info2">Cambiar Avatar</button>
                            <input type="hidden" class="form-control" id="newuser_avatar" name="newuser_avatar">
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newuser_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Usuario guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_user" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="delete_user_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR TRABAJADOR</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar el Trabajador?</label>
                    </div>
                    <div class="form-group"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_delete_user" data-id class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div id="avatar_user_model" class="modal fade">
    <div class="modal-dialog" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">SELECCIÓN AVATAR</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-borderless" id="tabla-users-avatares">
                <tbody>
                 <?
                //include connection file 
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");

                $db = new dbObj();
                $connString =  $db->getConnstring();
                
                $sql = "SELECT 
                            erp_avatares.id,
                            erp_avatares.url
                        FROM 
                            erp_avatares";
                file_put_contents("queryAvatares.txt", $sql);
                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Avatares");
                $row_cnt = mysqli_num_rows($resultado);
                $cnt_tot = 0;
                $cnt = 0;
                while ($registros = mysqli_fetch_array($resultado)) {
                    
                    $id = $registros[0];
                    $urlImg = $registros[1];
                    if($cnt==0){
                        echo "<tr data-id='66'>
                            <td data-id='".$id."' class='text-center avatar-icon' value=".$urlImg."><img style='heith:35px;width:35px' src='".$urlImg."'></img></td>";                        
                    }else{
                        echo "<td data-id='".$id."' class='text-center avatar-icon' value=".$urlImg."><img style='heith:35px;width:35px' src='".$urlImg."'></img></td>";                    
                    }
                    $cnt++;
                    $cnt_tot++;

                    if($row_cnt==$cnt_tot || $cnt==10){
                        $cnt=0;
                        echo "</tr>";
                    }
                }   
                ?>
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_avatar_user" data-id class="btn btn-info">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>