<!-- Ordenes de Trabajo -->

<div class="alert-middle alert alert-success alert-dismissable" id="horasint_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Horas guardadas</p>
</div>

<table class="table table-striped table-hover" id='tabla-horas-int'>
    <thead>
      <tr>
        <th class="text-center">H.</th>
        <th>INTERVENCIÓN</th>
        <th>TAREA</th>
        <th>DESCRIPCIÓN</th>
        <th class="text-center">FECHA</th>
        <th class="text-center">TÉCNICO</th>
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
                    TAREAS.id as tarea,
                    TAREAS.nombre,
                    INTERVENCIONES_HORAS_IMPUTADAS.cantidad,
                    INTERVENCIONES_HORAS_IMPUTADAS.titulo,
                    INTERVENCIONES_HORAS_IMPUTADAS.descripcion,
                    erp_users.nombre,
                    erp_users.apellidos,
                    INTERVENCIONES_HORAS_IMPUTADAS.id as detalle,
                    INTERVENCIONES_HORAS_IMPUTADAS.fecha, 
                    INTERVENCIONES.nombre
                FROM 
                    TAREAS, PERFILES, PERFILES_HORAS, INTERVENCIONES_HORAS_IMPUTADAS, INTERVENCIONES, erp_users  
                WHERE 
                    INTERVENCIONES_HORAS_IMPUTADAS.tarea_id = TAREAS.id
                AND
                    TAREAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.id = INTERVENCIONES_HORAS_IMPUTADAS.tipo_hora_id
                AND
                    INTERVENCIONES_HORAS_IMPUTADAS.int_id = INTERVENCIONES.id 
                AND 
                    INTERVENCIONES_HORAS_IMPUTADAS.tecnico_id = erp_users.id 
                AND
                    MONTH(INTERVENCIONES_HORAS_IMPUTADAS.fecha) = ".$monthNum." 
                AND 
                    INTERVENCIONES_HORAS_IMPUTADAS.tecnico_id = ".$_SESSION['user_session']."
                ORDER BY 
                    INTERVENCIONES_HORAS_IMPUTADAS.id ASC";

        //file_put_contents("horasQuery.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Horas Imputadas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $proyecto_id = $_GET['id'];
            $nombreTAR = $registros[1];
            $cantidadORD = $registros[2];
            $tituloORD = $registros[3];
            $descORD = $registros[4];
            $tecnicoNombre = $registros[5];
            $tecnicoApellidos = $registros[6];
            $id = $registros[7];
            $fecha = $registros[8];
            $diaSemana = SpanishDate(strtotime($fecha));
            $nombrePRO = $registros[9];
            
            echo "
                <tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidadORD."</td>
                    <td>".$nombrePRO."</td>
                    <td>".$nombreTAR."</td>
                    <td>".$tituloORD."</td>
                    <td class='text-center'>".$diaSemana.", ".$fecha."</td>
                    <td class='text-center'>".$tecnicoNombre." ".$tecnicoApellidos."</td>
                    <td class='text-center'><button class='btn-default remove-horas-int' data-id='".$id."' title='Eliminar Horas'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>
<!--
<div class="row pvp_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PLUS: </label> <label id='materiales_iva' class="precio_right_vistas"> <? echo number_format((float)$totalGanancia, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format((float)$total, 2, ',', '.'); ?> €</label></div>
</div>
-->    

<div id="horasint_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">IMPUTAR HORAS TRABAJADAS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_horasint">
                        <input type="hidden" value="" name="horasint_detalle_id" id="horasint_detalle_id">
                        <input type="hidden" value="" name="horasint_tarea_id" id="horasint_tarea_id">
                        <input type="hidden" value="" name="deldetalleint" id="deldetalleint">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Tareas:</label>
                            <select id="horasint_tareas" name="horasint_tareas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Tipo de Horas:</label>
                            <select id="horasint_horas" name="horasint_horas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="horasint_titulo" name="horasint_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="horasint_descripcion" name="horasint_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label class="labelBeforeBlack">Horas Trabajadas:</label>
                                <input type="text" class="form-control" id="horasint_cantidad" name="horasint_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Intervención:</label>
                            <select id="horasint_int" name="horasint_int" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBeforeBlack">Fecha:</label>
                                <input type="date" class="form-control" id="horasint_fecha" name="horasint_fecha">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_horasint_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Ordenes de Trabajo -->