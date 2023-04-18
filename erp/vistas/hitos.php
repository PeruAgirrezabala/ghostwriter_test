<!-- proyectos activos -->
<table class="table table-striped table-hover table-condensed" id='tabla-hitos' style="font-size: 9px !important;">
    <thead>
      <tr>
            <th class="text-center">E</th>
            <th class="text-center">HITO</th>
            <th class="text-center">FECHA ENTREGA</th>
            <th class="text-center">PROYECTO</th>
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
                    PROYECTOS_HITOS.id as hito,
                    PROYECTOS_HITOS.nombre,
                    PROYECTOS_HITOS.descripcion,
                    PROYECTOS_HITOS.fecha_entrega,
                    PROYECTOS_HITOS.fecha_realizacion,
                    PROYECTOS_HITOS.observaciones,
                    HITOS_ESTADOS.nombre,
                    HITOS_ESTADOS.color,
                    PROYECTOS.nombre,
                    PROYECTOS.id 
                FROM 
                    PROYECTOS 
                INNER JOIN PROYECTOS_HITOS
                    ON PROYECTOS_HITOS.proyecto_id = PROYECTOS.id 
                INNER JOIN HITOS_ESTADOS
                    ON PROYECTOS_HITOS.estado_id = HITOS_ESTADOS.id 
                LEFT JOIN erp_users  
                    ON PROYECTOS_HITOS.erpuser_id = erp_users.id 
                WHERE 
                    erp_users.id = ".$_SESSION['user_session']." 
                AND
                    PROYECTOS_HITOS.estado_id <> 3  
                ORDER BY 
                    PROYECTOS_HITOS.id ASC";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Hitos");
    
    while ($registros = mysqli_fetch_array($resultado)) { 
        $idHIT = $registros[0];
        $nombreHIT = $registros[1];
        $descHIT = $registros[2];
        $fecha_entrega = $registros[3];
        $fecha_realizacion = $registros[4];
        $observ = $registros[5];
        $estado = $registros[6];
        $estado_color = $registros[7];
        $proyecto = $registros[8];
        $proyecto_id = $registros[9];

        echo "
            <tr data-id='".$proyecto_id."' class='oferta'>
                <td class='text-center'><span class='label label-".$estado_color."'>".$estado."</span></td>
                <td class='text-left'>".$nombreHIT."</td>
                <td class='text-center'>".$fecha_entrega."</td>
                <td class='text-center'>".$proyecto."</td>
            </tr>
        ";
    }
?>

    </tbody>
</table>
