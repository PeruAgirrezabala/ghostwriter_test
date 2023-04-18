<!-- tools proyectos -->
<script>
    //se ejecuta cuando el documento estacargado completamente
    //en general parece ser un script para popular unos elementos de select con opciones de una base de datos con un corto retraso
    $(document).ready(function() {
        //este bloque se ejecuta con 100o millisegundos--> 1 segundo de retraso
        setTimeout(function(){
            loadSelect("editacceso_tipohora","JORNADAS_TIPOS_HORAS","id","","","");
            $("#editacceso_tipohora").selectpicker("val", 1);
        
        }, 1000);
    });
</script>
<div class="form-group form-group-tools">
    <button class="button" id="link-teclado" title="Ir al teclado"><img src="/erp/img/keyboard.png" height="20"></button>
    <?  
        //se chequea si el usuario logeado tiene el rol de superadmin 
        if ($_SESSION['user_rol'] == "SUPERADMIN") {
        //si es hasi se habilitan ciertas funciones
    ?> 
    <!--Btonose de opciones para las jorandas (solo si eres superadmin) -->
    <button class="button" id="gen-jornadas" title="Generar Jornadas para el trabajador actual"><img src="/erp/img/jornadas.png" height="20"></button>
    <button class="button" id="gen-jornadas-all" title="Generar Jornadas para todos los trabajadores"><img src="/erp/img/jornadaAll.png" height="20"></button>
    <button class="button" id="save-calendario" title="Generar Calendario"><img src="/erp/img/calendar.png" height="20"></button>
    <button class="button" id="add-festivos" title="Añadir Festivos"><img src="/erp/img/festivos.png" height="20"></button>
    <button class="button" id="add-media" title="Añadir Media Jornada"><img src="/erp/img/media.png" height="20"></button>
    <!--<button class="button" id="exportar-excel" title="Exportar a Excel"><img src="/erp/img/excel.png" height="20"></button>-->
    <?
        }
    ?>
        <!--Botones de opciones para las jorandas (cualquier usuario) -->
    <button class="button" id="exportar-excel-m" title="Exportar a Excel Mensual"><img src="/erp/img/excelM.png" height="20"></button>
    <button class="button" id="exportar-excel-a" title="Exportar a Excel Anual"><img src="/erp/img/excelA.png" height="20"></button>
    <button class="button" id="ver-vacaciones" title="Ver Calendario de Vacaciones"><img src="/erp/img/vacaciones.png" height="20"></button>
</div>

<!-- tools proyectos -->

<!-- MODALS -->
<!-- Calendario Vacaciones -->
<div id="calendario_vac" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CALENDARIO VACACIONES</h4>
            </div>
            <div class="modal-body">
                <div class="loading-div"></div>
                <div class="contenedor-form" id="contenedor-vacaciones">
   
                </div>
                <div id="leyendaVacaciones" style="margin-top: 50px;">
                    <?
                        include_once($pathraiz."/connection.php");
                        
                        $db = new dbObj();
                        $connString =  $db->getConnstring();
                        
                        $sql = "SELECT 
                                        erp_users.nombre,
                                        erp_users.apellidos,
                                        erp_users.color
                                    FROM 
                                        erp_users 
                                    WHERE
                                        activo='on' AND empresa_id=1
                                    ORDER BY 
                                        nombre ASC";

                        //file_put_contents("queryCalendario.txt", $sql);
                        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de la Leyenda");

                        while ($registros = mysqli_fetch_array($resultado)) { 
                            echo "<label class='label block' style='white-space: normal;'><span class='badge' style='background-color:".$registros[2]."; white-space: normal;'>".$registros[0]." ".$registros[1]."</span></label>";
                        }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Calendario Festivos -->

<div id="festivos_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR FESTIVOS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_festivos">
                        <div class="form-group">
                            <div class="col-md-5" style="margin: 0px auto; float: none;">
                                <label class="labelBefore">Selecciona el día:</label>
                                <input type="date" class="form-control" id="festivos_dia" name="festivos_dia">
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="festivo_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Festivo guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_festivo" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Calendario Media Jornada -->

<div id="media_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR MEDIA JORNADA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_media">
                        <div class="form-group">
                            <div class="col-md-5" style="margin: 0px auto; float: none;">
                                <label class="labelBefore">Selecciona el día:</label>
                                <input type="date" class="form-control" id="media_dia" name="media_dia">
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="media_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Media Jornada guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_media" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div id="detalleacceso_add_model" class="modal fade">
    <div class="modal-dialog dialog_mini" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">EDITAR ACCESO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_acceso">
                        <input type="hidden" class="form-control" id="editacceso_id" name="editacceso_id">
                        <input type="hidden" class="form-control" id="editacceso_del" name="editacceso_del">
                        <input type="hidden" class="form-control" id="editacceso_idjornada" name="editacceso_idjornada">
                        <div class="form-group">
                            <div class="col-md-5" style="margin: 0px auto; float: none;">
                                <label class="labelBefore">Día:</label>
                                <input type="text" class="form-control" id="editacceso_dia" name="editacceso_dia">
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-1" style="float: none; display: inline-block;"></div>
                            <div class="col-md-5" style="float: none; display: inline-block;">
                                <label class="labelBefore">Hora Entrada:</label>
                                <input type="time" class="form-control" id="editacceso_horaentrada" name="editacceso_horaentrada">
                            </div>
                            <div class="col-md-5" style="float: none; display: inline-block;">
                                <label class="labelBefore">Hora Salida:</label>
                                <input type="time" class="form-control" id="editacceso_horasalida" name="editacceso_horasalida">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-5" style="float: none; margin: 0px auto;">
                                <label class="labelBefore">Tipo de Horas:</label>
                                <!-- <input type="text" class="form-control" id="pedidodetalle_dtoprov" name="pedidodetalle_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                                <select id="editacceso_tipohora" name="editacceso_tipohora" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="editacceso_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Acceso guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_detalleacceso" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_detalleacceso" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Cambiar proyecto jornadaa -->
<div id="proyectojornada_model" class="modal fade">
    <div class="modal-dialog dialog_mini" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PROYECTO JORNADA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_proyectojornada">
                        <input type="hidden" class="form-control" id="idcalendariojornada" name="idcalendariojornada">
                        <input type="hidden" class="form-control" id="idtrabajadorjornada" name="idtrabajadorjornada">
                        <div class="form-group">
                            <div class="col-md-12" style="float: none; margin: 0px auto;">
                                <label class="labelBefore">Proyecto:</label>
                                <select id="proyectojornada_proyectos" name="proyectojornada_proyectos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="proyectojornada_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Proyecto Actualizado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_proyectojornada" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Accesos -->
<!-- /MODALS -->