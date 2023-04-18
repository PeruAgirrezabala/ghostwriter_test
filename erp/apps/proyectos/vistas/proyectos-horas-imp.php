<!-- Ordenes de Trabajo -->

<div class="alert-middle alert alert-success alert-dismissable" id="horas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Horas guardadas</p>
</div>

<table class="table table-striped table-hover" id='tabla-horas'>
    <thead>
      <tr class="bg-dark">
        <th class="text-center">H.</th>
        <th>TAREA</th>
        <th>TITULO</th>
        <th class="text-center">FECHA</th>
        <th class="text-center">TÉCNICO</th>
        <th class="text-center">COSTE/HORA</th>
        <th class="text-center">PVP</th>
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
                    PROYECTOS_HORAS_IMPUTADAS.cantidad,
                    PROYECTOS_HORAS_IMPUTADAS.titulo,
                    PROYECTOS_HORAS_IMPUTADAS.descripcion,
                    erp_users.nombre,
                    erp_users.apellidos,
                    PROYECTOS_HORAS_IMPUTADAS.id as detalle,
                    PROYECTOS_HORAS_IMPUTADAS.fecha,
                    PERFILES_HORAS.precio_coste
                FROM 
                    TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_HORAS_IMPUTADAS, PROYECTOS, erp_users  
                WHERE 
                    PROYECTOS_HORAS_IMPUTADAS.tarea_id = TAREAS.id
                AND
                    TAREAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.id = PROYECTOS_HORAS_IMPUTADAS.tipo_hora_id
                AND
                    PROYECTOS_HORAS_IMPUTADAS.proyecto_id = PROYECTOS.id 
                AND 
                    PROYECTOS_HORAS_IMPUTADAS.tecnico_id = erp_users.id 
                AND 
                    PROYECTOS.id = ".$_GET['id']."
                ORDER BY 
                    PROYECTOS_HORAS_IMPUTADAS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ordenes de Trabajo");
        
        $totalCosteHoras = 0;
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
            $pvpHora = $registros[9];
            
            $costeHoras = $cantidadORD*$pvpHora;
          
            $totalCosteHoras = $totalCosteHoras + $costeHoras;
            
            echo "
                <tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidadORD."</td>
                    <td>".$nombreTAR."</td>
                    <td>".$tituloORD."</td>
                    <td class='text-center'>".$fecha."</td>
                    <td class='text-center'>".$tecnicoNombre." ".$tecnicoApellidos."</td>
                    <td class='text-center'>".number_format($pvpHora, 2)."</td>
                    <td class='text-center'>".number_format($costeHoras, 2)."</td>
                    <td class='text-center'><button class='btn-default remove-horas' data-id='".$id."' title='Eliminar Horas'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3" style="background-color: #000000; float:right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteHoras, 2, ',', '.'); ?> €</label></div>
</div>



<!-- Ordenes de Trabajo -->