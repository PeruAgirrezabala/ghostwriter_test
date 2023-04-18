<!-- tools doc admon -->
<div class="form-group form-group-tools">
    <button class="button" id="add-calibraciones" title="Crear Calibración"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="ver-calibraciones-old" title="Ver todos"><img src="/erp/img/ojo.png" height="20"></button>
<!--    <button class="button" id="clean-filters-calibraciones" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>-->
</div>
<span class="stretch"></span>
<!--<div id="proyectos-filterbar" class="one-column">
     <? //include($pathraiz."/apps/calidad/vistas/filtros-actas.php"); ?>
</div>-->
<!-- tools

<!-- tools doc admon -->

<div id="calibraciones_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CALIBRACIONES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_addCalibraciones">
                        <input type="hidden" value="" name="addCalibraciones_id" id="addCalibraciones_id">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Equipo: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="addCalibraciones_equipo" name="addCalibraciones_equipo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">NºSerie: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="addCalibraciones_numserie" name="addCalibraciones_numserie">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Tecnico: <span class="requerido">*</span></label>
<!--                                <input type="text" class="form-control" id="addCalibraciones_tecnico" name="addCalibraciones_tecnico">-->
                                    <select id="addCalibraciones_tecnico" name="addCalibraciones_tecnico" class="selectpicker" data-live-search="true" data-width="33%">
                                    <?php 
                                        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                        include_once($pathraiz."/connection.php");

                                        $db = new dbObj();
                                        $connString =  $db->getConnstring();

                                         $sql = "SELECT 
                                                    erp_users.id,
                                                    erp_users.nombre,
                                                    erp_users.apellidos
                                                FROM erp_users";
                                        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de USUARIOS_ERP");

                                        while ($registros = mysqli_fetch_array($resultado)) {
                                            $id = $registros[0];
                                            $nombre = $registros[1];
                                            $apellido = $registros[2];

                                            echo "<option id='addCalibraciones_tecnico'".$id." value=".$id.">".$nombre." ".$apellido."</option>";

                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Labor: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="addCalibraciones_labor" name="addCalibraciones_labor">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Periodo: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="addCalibraciones_periodo" name="addCalibraciones_periodo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Proced: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="addCalibraciones_proced" name="addCalibraciones_proced">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Última Calibración: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="addCalibraciones_lastcalibracion" name="addCalibraciones_lastcalibracion">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Próxima Calibración: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="addCalibraciones_nextcalibracion" name="addCalibraciones_nextcalibracion">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Activo:</label>
                            <input type="checkbox" name="addCalibraciones_activado" id="addCalibraciones_activado" checked data-size="mini">
                            <input type="text" name="txt_activado" id="txt_activado" hidden>                            
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_calibraciones_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- POP-UP Subir fichero-->
<div id="adddocCalibraciones_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_adddocCalibraciones">
                        <input type="hidden" id="adddocCalibraciones">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha hoy: </label>
                                <input type="date" class="form-control" id="adddocCalibraciones_fecha" name="adddocCalibraciones_fecha">
                            </div>
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <label class="labelBefore">Archivo: </label>
                            <div class="file-loading">
                                <label class="labelBefore">Archivo</label>
                                <input id="uploaddocsCALIBRACIONES" name="uploaddocsCALIBRACIONES[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
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
<!--* Visualizar TODOS Calidad Sistema *-->

<!-- Antiguas Calibraciones cambiar-->
<div id="Calibraciones_old_model" class="modal fade"></div>
<!-- -->
<div id="antiguascalibraciones_habilitado" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="antiguascalibraciones_id" id="antiguascalibraciones_id">
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas cambiar el estado del Calibrador?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_antiguascalibraciones_habilitado" data-id="" class="btn btn-info">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

