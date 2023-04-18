<!-- Ordenes de Trabajo -->
<table class="table table-striped table-hover table-condensed" id='tabla-ordenes' style="font-size: 9px !important;">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">H.</th>
            <th>TAREA</th>
            <th>TITULO</th>
            <th class="text-center">FECHA ENTREGA</th>
            <th class="text-center">TÉCNICO</th>
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
                    PROYECTOS_TAREAS.fecha_entrega,
                    PROYECTOS.id 
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
                    erp_users.id = ".$_SESSION['user_session']." 
                ORDER BY 
                    PROYECTOS_TAREAS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ordenes de Trabajo");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $proyecto_id = $registros[9];
            $nombreTAR = $registros[1];
            $cantidadORD = $registros[2];
            $tituloORD = $registros[3];
            $descORD = $registros[4];
            $tecnicoNombre = $registros[5];
            $tecnicoApellidos = $registros[6];
            $id = $registros[7];
            $fecha_entrega = $registros[8];
            
            echo "
                <tr data-id='".$proyecto_id."' class='oferta'>
                    <td class='text-center'>".$cantidadORD."</td>
                    <td>".$nombreTAR."</td>
                    <td>".$tituloORD."</td>
                    <td class='text-center'>".$fecha_entrega."</td>
                    <td class='text-center'>".$tecnicoNombre." ".$tecnicoApellidos."</td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>
