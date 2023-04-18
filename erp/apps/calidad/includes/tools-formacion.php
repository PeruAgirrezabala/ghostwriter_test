<!-- tools doc admon -->
<div class="form-group form-group-tools">
    <button class="button" id="add-formacion" title="Crear Formacion"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="clean-filters-formacion" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
</div>
<span class="stretch"></span>
<div id="proyectos-filterbar" class="one-column">
     <? include($pathraiz."/apps/calidad/vistas/filtros-formaciones.php"); ?>
</div>
<!--
<span class="stretch"></span>
<div id="proyectos-filterbar" class="one-column">
     <? //include($pathraiz."/apps/calidad/vistas/filtros-actas.php"); ?>
</div> -->
<!-- tools

<!-- tools doc admon -->
<div id="formacion_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">FORMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_addFormacion">
                        <input type="hidden" value="" name="addFormacion_id" id="addFormacion_id">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="addFormacion_nombre" name="addFormacion_nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="labelBefore">Descripción: <span class="requerido">*</span></label>
                                <textarea type="text" class="form-control" id="addFormacion_descripcion" name="addFormacion_descripcion" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="addFormacion_fecha" name="addFormacion_fecha">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_formacion_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- POP-UP Subir fichero-->

<div id="adddocFormacion_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_adddocFormacion">
                        <input type="hidden" id="adddocFormacion">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha hoy: </label>
                                <input type="date" class="form-control" id="adddocFormacion_fecha" name="adddocFormacion_fecha">
                            </div>
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <label class="labelBefore">Archivo: </label>
                            <div class="file-loading">
                                <label class="labelBefore">Archivo</label>
                                <input id="uploaddocsFORMACION" name="uploaddocsFORMACION[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <!--
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_pedidodetalle_save" class="btn btn-primary">Guardar</button>
                
            </div>
            -->
        </div>
    </div>
</div>

<!-- Formacion Detalles! POP-UP-->
<div id="container-para-model-detalles">
    
</div>
                    
            
<!-- Modal / Pop-up de añadir Tecnicos a Formaciones -->
<div id="addTecnicoFormacion_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR TECNICOS A FORMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_addTecnicoFormacion">
                        <input type="hidden" id="addTecnicoFormacion" name="addTecnicoFormacion">
                        <div class="form-group">
                            <div class="col-xs-6">
                            <label class="labelBefore">Técnico: <span class="requerido">*</span></label>
                                <select id="tecnicos_formacion" name="tecnicos_formacion" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <?php 
                                        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                        include_once($pathraiz."/connection.php");

                                        $db = new dbObj();
                                        $connString =  $db->getConnstring();

                                        $sql = "SELECT 
                                                    erp_users.id,
                                                    erp_users.nombre,
                                                    erp_users.apellidos
                                                FROM 
                                                    erp_users
                                                WHERE 
                                                    erp_users.empresa_id=1";
                                        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de USUARIOS_ERP");

                                        while ($registros = mysqli_fetch_array($resultado)) {
                                            $id = $registros[0];
                                            $nombre = $registros[1];
                                            $apellido = $registros[2];

                                            echo "<option id='tecnicos_formacion_".$id."' value=".$id.">".$nombre." ".$apellido."</option>";

                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="labelBeforeBlack">Descripción: </label>
                                <textarea type="text" class="form-control" id="addTecnicoFormacion_descripcion" name="addTecnicoFormacion_descripcion"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha: </label>
                                <input type="date" class="form-control" id="adddTecnicoFormacion_fecha" name="addTecnicoFormacion_fecha">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_formacionTecnico_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div id="addTodosTecnicoFormacion_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR TODOS LOS TECNICOS A FORMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_addTodosTecnicoFormacion">
                        <input type="hidden" id="addTodosTecnicosFormacion" name="addTodosTecnicosFormacion">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="labelBeforeBlack">Descripción: </label>
                                <textarea type="text" class="form-control" id="addTodosTecnicoFormacion_descripcion" name="addTodosTecnicoFormacion_descripcion"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha: </label>
                                <input type="date" class="form-control" id="TodosTecnicoFormacion_fecha" name="addTodosTecnicoFormacion_fecha">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_formacionTecnicoTodos_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Borrar Formacion Detalles -->
<div id="delete_formacion_detalle_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR TÉCNICO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="formacion_detalle_id" id="formacion_detalle_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar el Tecnico de la Formación?</label>
                    </div>
                    <div class="form-group"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_detalle_formacion" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- -->
<!-- Cambiar Fecha -->
<div id="cambiar_fecha_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CAMBIAR FECHA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_addFormacion">
                        <input type="hidden" value="" name="formacionId" id="formacionId">
                        <input type="hidden" value="" name="tecnicoId" id="tecnicoId">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="addFomacionDetalle_fecha" name="addFomacionDetalle_fecha">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_formacionFecha_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- -->