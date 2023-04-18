<!-- proyectos activos -->
<div >
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $fechahoy=date("Y-m-d");
    
    // 86400 un día => 2592000, 30 días
    $fechamas30 = $tomorrow = date("Y-m-d", time() + 2592000);
    
    /* Total */
    $sql = "SELECT 
                ACTIVIDAD.id,
                ACTIVIDAD.ref as ref_act,
                ACTIVIDAD.fecha,
                PROYECTOS.ref as ref_mant,
                PROYECTOS.nombre,
                ACTIVIDAD_ESTADOS.nombre,
                ACTIVIDAD_ESTADOS.color,
                CLIENTES_INSTALACIONES.nombre
            FROM 
                ACTIVIDAD
            INNER JOIN PROYECTOS ON
                ACTIVIDAD.item_id=PROYECTOS.id
            INNER JOIN ACTIVIDAD_ESTADOS ON
                ACTIVIDAD.estado_id=ACTIVIDAD_ESTADOS.id
            INNER JOIN CLIENTES_INSTALACIONES ON
                ACTIVIDAD.estado_id=ACTIVIDAD_ESTADOS.id
            WHERE 
                categoria_id=1
            AND
                ACTIVIDAD.instalacion=CLIENTES_INSTALACIONES.id
            AND 
                fecha>='".$fechahoy."'
            AND 
                fecha<='".$fechamas30."'";
    file_put_contents("logNext0.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    //$registros = mysqli_fetch_row($resultado);
    
    echo "<div id='tabla-visitas-proximos' class='pre-scrollable' style='font-size:10px;'>";
    echo "<table class='table table-striped table-hover' id='tabla-visitas-proximos'>";
    echo "<thead>
        <tr class='bg-dark'>
            <th class='text-center'>REF</th>
            <th class='text-center' title='Mantenimiento'>MANT.</th>
            <th class='text-center' title='Instalación'>INST.</th>
            <th class='text-center'>FECHA</th>
            <th class='text-center'>ESTADO</th>
        </tr>
    </thead>";
    echo "<tbody>";
    
    while($registros = mysqli_fetch_row($resultado)){
        echo '<tr data-id="'.$registros[0].'" draggable="true" ondragstart="drag(event)">
                    <td class="text-left">'.$registros[3].'</td>
                    <td class="text-left">'.$registros[4].'</td>
                        <td class="text-left">'.$registros[7].'</td>
                    <td class="text-left">'.$registros[2].'</td>
                    <td class="text-center"><span class="label label-'.$registros[6].'">'.$registros[5].'</span></td>
                </tr>';
    }
    
    echo "</tbody>";
    
    echo "</table>";
    
    echo "</div>";
    
    /**/
    
    
?>
</div>