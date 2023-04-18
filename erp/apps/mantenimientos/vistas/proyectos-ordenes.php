<!-- Ordenes de Trabajo -->

<div class="alert-middle alert alert-success alert-dismissable" id="ordenes_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Orden guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-ordenes'>
    <thead>
      <tr>
        <th class="text-center">H.</th>
        <th>TAREA</th>
        <th>TITULO</th>
        <th class="text-center">FECHA ENTREGA</th>
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
                    PROYECTOS_TAREAS.cantidad,
                    PROYECTOS_TAREAS.titulo,
                    PROYECTOS_TAREAS.descripcion,
                    erp_users.nombre,
                    erp_users.apellidos,
                    PROYECTOS_TAREAS.id as detalle,
                    PROYECTOS_TAREAS.fecha_entrega
                FROM 
                    TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_TAREAS, PROYECTOS, erp_users  
                WHERE 
                    PROYECTOS_TAREAS.tarea_id = TAREAS.id
                AND
                    TAREAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.perfil_id = PERFILES.id
                            AND
                    PERFILES_HORAS.id = PROYECTOS_TAREAS.tipo_hora_id
                AND
                    PROYECTOS_TAREAS.proyecto_id = PROYECTOS.id 
                AND 
                    PROYECTOS_TAREAS.tecnico_id = erp_users.id 
                AND 
                    PROYECTOS.id = ".$_GET['id']."
                ORDER BY 
                    PROYECTOS_TAREAS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ordenes de Trabajo");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $proyecto_id = $_GET['id'];
            $nombreTAR = $registros[1];
            $cantidadORD = $registros[2];
            $tituloORD = $registros[3];
            $descORD = $registros[4];
            $tecnicoNombre = $registros[5];
            $tecnicoApellidos = $registros[6];
            $id = $registros[7];
            $fecha_entrega = $registros[8];
            
            echo "
                <tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidadORD."</td>
                    <td>".$nombreTAR."</td>
                    <td>".$tituloORD."</td>
                    <td class='text-center'>".$fecha_entrega."</td>
                    <td class='text-center'>".$tecnicoNombre." ".$tecnicoApellidos."</td>
                    <td class='text-center'><button class='btn-default remove-orden' data-id='".$id."'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
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

<div id="orden_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR ORDEN DE TRABAJO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_orden">
                        <input type="hidden" value="" name="orden_detalle_id" id="orden_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="orden_proyecto_id" id="orden_proyecto_id">
                        <input type="hidden" value="" name="orden_tarea_id" id="orden_tarea_id">
                        <input type="hidden" value="" name="orden_del" id="orden_del">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Tareas:</label>
                            <select id="orden_tareas" name="orden_tareas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Tipo de Horas:</label>
                            <select id="orden_horas" name="orden_horas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="orden_titulo" name="orden_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="orden_descripcion" name="orden_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Horas Asignadas:</label>
                                <input type="text" class="form-control" id="orden_cantidad" name="orden_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Técnico:</label>
                            <select id="orden_tecnicos" name="orden_tecnicos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fecha Entrega:</label>
                            <input type="date" class="form-control" id="orden_fecha_entrega" name="orden_fecha_entrega">
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_orden_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Ordenes de Trabajo -->