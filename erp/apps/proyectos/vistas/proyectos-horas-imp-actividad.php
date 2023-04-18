<!-- Ordenes de Trabajo -->

<div class="alert-middle alert alert-success alert-dismissable" id="horas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Horas guardadas</p>
</div>

<table class="table table-striped table-hover" id='tabla-horas-1'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">H.</th>
            <th>TAREA</th>
            <th>ACTIVIDAD</th>
            <th class="text-center">FECHA</th>
            <th class="text-center">TÉCNICO</th><!--
            <th class="text-center">COSTE/HORA</th>
            <th class="text-center">COSTE</th>-->
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    ACTIVIDAD.id as actid,
                    TAREAS.id as tarea,
                    TAREAS.nombre,
                    (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id AND ACTIVIDAD_DETALLES.actividad_id = actid) as totalHoras,
                    ACTIVIDAD.nombre,
                    ACTIVIDAD_DETALLES.nombre,
                    erp_users.nombre,
                    erp_users.apellidos,
                    ACTIVIDAD_DETALLES_HORAS.id as detalle,
                    ACTIVIDAD_DETALLES_HORAS.fecha,
                    PERFILES_HORAS.precio_coste,
                    ACTIVIDAD_DETALLES_HORAS.cantidad,
                    ACTIVIDAD_DETALLES.fecha
                FROM 
                    TAREAS, PERFILES, PERFILES_HORAS, ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES, ACTIVIDAD, PROYECTOS, erp_users  
                WHERE 
                    ACTIVIDAD.tarea_id = TAREAS.id
                AND
                    TAREAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.id = ACTIVIDAD_DETALLES_HORAS.tipo_hora_id
                AND
                    ACTIVIDAD.item_id = PROYECTOS.id 
                AND
                    ACTIVIDAD_DETALLES.actividad_id = ACTIVIDAD.id
                AND
                    ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id 
                AND 
                    ACTIVIDAD_DETALLES_HORAS.tecnico_id = erp_users.id 
                AND
                    ACTIVIDAD.imputable = 1 
                AND
                    PROYECTOS.id = ".$_GET['id']."
                ORDER BY 
                    ACTIVIDAD_DETALLES_HORAS.id ASC";
        /* Se ha quitado:
         *                 AND 
                    ACTIVIDAD.categoria_id = 3
         */

        file_put_contents("viewHoras.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Actividad Imputable");
        
        $totalCosteHoras = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $proyecto_id = $_GET['id'];
            $nombreTAR = $registros[2];
            $cantidadORD = $registros[11];
            $tituloORD = $registros[4];
            $descORD = $registros[5];
            $tecnicoNombre = $registros[6];
            $tecnicoApellidos = $registros[7];
            $id = $registros[0];
            $fecha = $registros[12]; // 9 old
            $pvpHora = $registros[10];
            
            $costeHoras = $cantidadORD*$pvpHora;
          
            $totalCosteHoras = $totalCosteHoras + $costeHoras;
            
            $totalHoras = $totalHoras + $cantidadORD;
            
            echo "<tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidadORD."</td>
                    <td>".$nombreTAR."</td>
                    <td>".$tituloORD."</td>
                    <td class='text-center'>".$fecha."</td>
                    <td class='text-center'>".$tecnicoNombre." ".$tecnicoApellidos."</td><!--
                    <td class='text-center'>".number_format($pvpHora, 2)."</td>
                    <td class='text-center'>".number_format($costeHoras, 2)."</td>-->
                    <td class='text-center'><button class='btn btn-default open-actividad' data-id='".$id."' title='Ver Actividad'><img src='/erp/img/external.png' style='height: 20px;'></button></td>
                </tr>";
        }
        echo "</tbody>
            </table>";
        echo '<table class="table table-striped table-hover" id="tabla-horas-2">
                <thead>
                    <tr class="bg-dark">
                        <th class="text-center">H.</th>
                        <th>TITULO</th>
                        <th>DESC.</th>
                        <th class="text-center">FECHA</th>
                        <th class="text-center">TÉCNICO</th><!--
                        <th class="text-center">COSTE/HORA</th>
                        <th class="text-center">COSTE</th>-->
                        <th class="text-center"></th>
                        <th class="text-center">E</th>
                    </tr>
                </thead>
                <tbody>';
        // Añadir horas no asociadas a Actividades
        $sql = "SELECT 
                    PROYECTOS_HORAS_IMPUTADAS.id,
                    PROYECTOS_HORAS_IMPUTADAS.titulo,
                    PROYECTOS_HORAS_IMPUTADAS.cantidad,
                    PROYECTOS_HORAS_IMPUTADAS.tecnico_id,
                    PROYECTOS_HORAS_IMPUTADAS.descripcion,
                    PROYECTOS_HORAS_IMPUTADAS.fecha,                    
                    erp_users.nombre,
                    erp_users.apellidos
                FROM 
                    PROYECTOS_HORAS_IMPUTADAS, erp_users  
                WHERE 
                    PROYECTOS_HORAS_IMPUTADAS.tecnico_id = erp_users.id
                AND
                    PROYECTOS_HORAS_IMPUTADAS.proyecto_id = ".$_GET['id']."
                ORDER BY 
                    PROYECTOS_HORAS_IMPUTADAS.id ASC";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Horas sin actividad");
        while ($registros = mysqli_fetch_array($resultado)) {
            $idHoras=$registros[0];
            $titulo=$registros[1];
            $cant=$registros[2];
            $tecId=$registros[3];
            $desc=$registros[4];
            $fecha=$registros[5];
            $tecNombre=$registros[6];
            $tecApellido=$registros[7];
            $totalHoras = $totalHoras + $registros[2];
            echo "<tr data-id='".$idHoras."' class='oferta'>
                    <td class='text-center'>".$cant."</td>
                    <td>".$titulo."</td>
                    <td>-</td>
                    <td class='text-center'>".$fecha."</td>
                    <td class='text-center'>".$tecNombre." ".$tecApellido."</td><!--
                    <td class='text-center'>".number_format($pvpHora, 2)."</td>
                    <td class='text-center'>".number_format($costeHoras, 2)."</td>-->
                    <td class='text-center'><button class='btn btn-default edit-horas-imput' data-id='".$idHoras."' title='Ver Actividad'><img src='/erp/img/edit.png' style='height: 20px;'></button></td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-horas-imput' data-id='".$idHoras."' title='Eliminar Proceso'><img src='/erp/img/cross.png'></button></td>    
                </tr>";
        }
    ?>
    </tbody>
</table>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3" style="background-color: #000000; float:right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo $totalHoras; ?>  horas</label></div>
</div>
<!--
<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3" style="background-color: #000000; float:right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteHoras, 2, ',', '.'); ?> €</label></div>
</div>
-->
<div id="horas_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">IMPUTAR HORAS TRABAJADAS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_horas">
                        <input type="hidden" value="" name="horas_detalle_id" id="horas_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="horas_proyecto_id" id="horas_proyecto_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Tareas:</label>
                            <select id="horas_tareas" name="horas_tareas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Tipo de Horas:</label>
                            <select id="horas_horas" name="horas_horas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="horas_titulo" name="horas_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="horas_descripcion" name="horas_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="labelBeforeBlack">Horas Trabajadas:</label>
                                <input type="number" class="form-control" id="horas_cantidad" name="horas_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Técnico:</label>
                            <select id="horas_tecnicos" name="horas_tecnicos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBeforeBlack">Fecha:</label>
                                <input type="date" class="form-control" id="horas_fecha" name="horas_fecha">
                            </div>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_horas_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Ordenes de Trabajo -->

<!-- Confirmar borrado horas imputadas -->
<div id="horas_remove_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR HORAS TRABAJADAS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_horas">
                        <input type="hidden" value="" name="horas_deldetalle" id="horas_deldetalle">
                        
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas eliminar estas horas imputadas?</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_remove_horas_imput" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

