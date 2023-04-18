<!-- proyectos activos -->
<table class="table table-striped table-hover" id='tabla-plan-prior'>
    <thead>
        <tr class="bg-dark">
            <th>REF</th>
            <th>TITULO</th>
            <th style="min-width: 35%;">CÓDIGO</th>
            <th class="text-center">F. FIN</th>
            <th class="text-center">PRIORIDAD</th>
            <th class="text-center">ESTADO</th>
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
                    ACTIVIDAD.id,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.nombre,
                    ACTIVIDAD.fecha_fin,
                    PROYECTOS.nombre,
                    OFERTAS.titulo,
                    ACTIVIDAD_ESTADOS.nombre, 
                    ACTIVIDAD_ESTADOS.color,
                    ACTIVIDAD_PRIORIDADES.nombre, 
                    ACTIVIDAD_PRIORIDADES.color,
                    ACTIVIDAD.categoria_id,
                    PROYECTOS.ref,
                    OFERTAS.ref,
                    PROYECTOS.id,
                    OFERTAS.id
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES A
                    ON A.id = ACTIVIDAD.cliente_id
                INNER JOIN ACTIVIDAD_ESTADOS
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                INNER JOIN ACTIVIDAD_PRIORIDADES 
                    ON ACTIVIDAD_PRIORIDADES.id = ACTIVIDAD.prioridad_id
                INNER JOIN erp_users AS CREADA
                    ON ACTIVIDAD.responsable = CREADA.id 
                LEFT JOIN erp_users AS ASIGNADO
                    ON ACTIVIDAD.tecnico_id = ASIGNADO.id 
                LEFT JOIN PROYECTOS
                    ON ACTIVIDAD.item_id = PROYECTOS.id
                LEFT JOIN OFERTAS 
                    ON ACTIVIDAD.item_id = OFERTAS.id 
                WHERE 
                    (ACTIVIDAD.fecha_fin<date('".date('Y-m-d')."') AND ACTIVIDAD.fecha_fin !='0000-00-00')
                AND
                    NOT(ACTIVIDAD.estado_id=3 OR ACTIVIDAD.estado_id=4)
                ORDER BY 
                    ACTIVIDAD.fecha DESC";
    
    file_put_contents("sqlRetr.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Prioritarias");
    
    while ($registros = mysqli_fetch_array($resultado)) { 
        switch ($registros[10]) {
            case "1":
                $tipoItemLink = "/erp/apps/mantenimientos/view.php?id=".$registros[13];
                $ref = $registros[11];
                $nombreItem = $registros[4];
                break;
            case "3":
                $tipoItemLink = "/erp/apps/proyectos/view.php?id=".$registros[13];
                $ref = $registros[11];
                $nombreItem = $registros[4];
                break;
            case "4":
                $tipoItemLink = "/erp/apps/ofertas/editOferta.php?id=".$registros[14];
                $ref = $registros[12];
                $nombreItem = $registros[5];
                break;
            default:
                $nombreItem = "";
                $tipoItemLink = "";
                $ref = "";
                break;
        }
        $cellPriorStyle = "label-".$registros[9];
        $cellStateStyle = "label-".$registros[7];
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td>".$registros[2]."</td>
                <td>
                    ".$ref." - ".substr($nombreItem, 0, 30)."
                </td>
                <td class='text-center'>".$registros[3]."</td>
                <td class='text-center ".$cellPriorStyle."' ><span class='label ".$cellPriorStyle."'>".$registros[8]."</span></td>
                <td class='text-center ".$cellStateStyle."' ><span class='label ".$cellStateStyle."'>".$registros[6]."</span></td>
            </tr>";
    }
?>

    </tbody>
</table>