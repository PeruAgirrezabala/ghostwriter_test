
<?php
$tohtml='<div class="alert-middle alert alert-success alert-dismissable" id="ordenes_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Orden guardada</p>
</div>

<table class="table table-striped table-hover" id="tabla-ordenes">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">H.</th>
            <th>TAREA</th>
            <th>TITULO</th>
            <th class="text-center">FECHA ENTREGA</th>
            <th class="text-center">TÉCNICO</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>';
    
    
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT DISTINCT
                    TAREAS.id as tarea,
                    TAREAS.nombre,
                    PROYECTOS_TAREAS.cantidad,
                    PROYECTOS_TAREAS.titulo,
                    PROYECTOS_TAREAS.descripcion,
                    PROYECTOS_TAREAS.tecnico_id,
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
                    PROYECTOS.id = ".$_POST['id']."
                ORDER BY 
                    PROYECTOS_TAREAS.id ASC";
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ordenes de Trabajo");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $proyecto_id = $_POST['id'];
            $nombreTAR = $registros[1];
            $cantidadORD = $registros[2];
            $tituloORD = $registros[3];
            $descORD = $registros[4];
            $tecnico = $registros[5];
            $id = $registros[6];
            $fecha_entrega = $registros[7];
            
            $sqlTec="SELECT erp_users.nombre, erp_users.apellidos FROM erp_users WHERE erp_users.id=".$tecnico;
            $resTec = mysqli_query($connString, $sqlTec) or die("Error al ejcutar la consulta de tecnico");
            $regTec = mysqli_fetch_row($resTec);
            
            $tohtml.= "
                <tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidadORD."</td>
                    <td>".$nombreTAR."</td>
                    <td>".$tituloORD."</td>
                    <td class='text-center'>".$fecha_entrega."</td>
                    <td class='text-center'>".$regTec[0]." ".$regTec[1]."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-orden' data-id='".$id."' title='Eliminar Orden'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    
    $tohtml.='</tbody>
</table>';
    
    echo $tohtml;

    
?>
                                    
    
    
    
    