<!-- proyectos activos -->
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $limit = 10;
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
        
    $sql = "SELECT DISTINCT
                    ACTIVIDAD.id actid,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.categoria_id,
                    ACTIVIDAD_CATEGORIAS.nombre,
                    ACTIVIDAD.item_id as item,
                    ACTIVIDAD.nombre AS titulo,
                    ACTIVIDAD.fecha,
                    ACTIVIDAD.fecha_mod,
                    CREADA.nombre,
                    ACTIVIDAD_ESTADOS.nombre, 
                    ACTIVIDAD_ESTADOS.color,
                    ACTIVIDAD_PRIORIDADES.nombre, 
                    ACTIVIDAD_PRIORIDADES.color,
                    CLIENTES.nombre,
                    ASIGNADO.nombre,
                    ASIGNADO.id,
                    (SELECT PROYECTOS.ref FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.ref FROM OFERTAS WHERE id = item),
                    (SELECT PROYECTOS.nombre FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.titulo FROM OFERTAS WHERE id = item),
                    TAREAS.nombre,
                    TAREAS.id,
                    CREADA.apellidos,
                    ASIGNADO.apellidos,
                    (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.fecha_fin
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES
                    ON CLIENTES.id = ACTIVIDAD.cliente_id
                INNER JOIN ACTIVIDAD_CATEGORIAS
                    ON ACTIVIDAD.categoria_id = ACTIVIDAD_CATEGORIAS.id 
                INNER JOIN TAREAS
                    ON ACTIVIDAD.tarea_id = TAREAS.id 
                INNER JOIN ACTIVIDAD_ESTADOS
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                INNER JOIN ACTIVIDAD_PRIORIDADES 
                    ON ACTIVIDAD_PRIORIDADES.id = ACTIVIDAD.prioridad_id
                INNER JOIN erp_users AS CREADA
                    ON ACTIVIDAD.responsable = CREADA.id 
                LEFT JOIN erp_users AS ASIGNADO
                    ON ACTIVIDAD.tecnico_id = ASIGNADO.id
                INNER JOIN ACTIVIDAD_USUARIO 
                    ON ACTIVIDAD.id=ACTIVIDAD_USUARIO.actividad_id
                    WHERE ACTIVIDAD_USUARIO.user_id=".$_SESSION['user_session']."
                    AND ACTIVIDAD.estado_id !=3
                    AND ACTIVIDAD.estado_id !=4
                ORDER BY 
                    ACTIVIDAD.fecha DESC, ACTIVIDAD.ref DESC";
    
    file_put_contents("queryActividades.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Actividades");
    
    
?>
<table class="table table-striped table-hover table-condensed" id='tabla-act' style='font-size: 9px !important;'>
    <thead>
      <tr class="bg-dark">
        <th class="text-center">REF</th>
            <th class="text-center">FECHA</th>
            <th class="text-center">CATEGORÍA</th>
            <th class="text-center">TITULO</th>
            <th class="text-center">CÓDIGO</th>
            <th class="text-center">TAREA</th>
            <th class="text-center">CREADA</th>
            <th class="text-center">PRIORIDAD</th>
            <th class="text-center">ESTADO</th>
            <th class="text-center">ACCIÓN</th>
      </tr>
    </thead>
    <tbody>
<?
    while ($registros = mysqli_fetch_array($resultado)) { 
        switch ($registros[2]) {
            case "1":
                $tipoItemLink = "/erp/apps/mantenimientos/view.php?id=".$registros[4];
                $ref = $registros[16];
                $nombreItem = $registros[18];
                break;
            case "3":
                $tipoItemLink = "/erp/apps/proyectos/view.php?id=".$registros[4];
                $ref = $registros[16];
                $nombreItem = $registros[18];
                break;
            case "4":
                $tipoItemLink = "/erp/apps/ofertas/editOferta.php?id=".$registros[4];
                $ref = $registros[17];
                $nombreItem = $registros[19];
                break;
            default:
                $tipoItemLink = "";
                $ref = "";
                break;
        }
        
        if ($registros[15] == $_SESSION['user_session']) {
            $button = "<button class='btn btn-success btn-circle get-plan' data-id='".$registros[0]."' data-soltar='1' title='Soltar Tarea'><img src='/erp/img/check.png'></button>";
        }
        else {
            $button = "<button class='btn btn-info btn-circle get-plan' data-id='".$registros[0]."' data-soltar='0' title='Coger Tarea'><img src='/erp/img/link-w.png'></button>";
        }
        $cellPriorStyle = "label-".$registros[12];
        $cellStateStyle = "label-".$registros[10];
        
        if($registros[24] != "") {
            $totalHoras = $registros[24];
        }
        else {
            $totalHoras = 0;
        }
        
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td class='text-center'>".$registros[6]."</td>
                <td>".$registros[3]."</td>
                <td>".$registros[5]."</td>
                <td>".$ref." - ".$nombreItem."</td>
                <td class='text-center'>".$registros[20]."</td>
                <td class='text-center'>".$registros[8]." ".substr($registros[22],0,1).".</td>
                <td class='text-center ".$cellPriorStyle."' ><span class='label ".$cellPriorStyle."'>".$registros[11]."</span></td>
                <td class='text-center ".$cellStateStyle."' ><span class='label ".$cellStateStyle."'>".$registros[9]."</span></td>
                <td class='text-center'>".$button."</td>
            </tr>
        ";
    }
?>

    </tbody>
</table>

<? echo $pagination; ?>

