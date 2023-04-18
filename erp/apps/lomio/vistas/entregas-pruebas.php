<!-- entregas activos -->
<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "SELECT 
                    ENSAYOS.id,
                    ENSAYOS.nombre,
                    ENSAYOS.descripcion,
                    ENSAYOS.fecha,
                    ENSAYOS.fecha_finalizacion,
                    ENTREGAS.nombre, 
                    ESTADOS_ENSAYOS.nombre,
                    ESTADOS_ENSAYOS.color, 
                    erp_users.nombre,
                    ENTREGAS.id,
                    erp_users.apellidos
                FROM 
                    ENTREGAS 
                INNER JOIN ENSAYOS
                    ON  ENTREGAS.id = ENSAYOS.entrega_id 
                INNER JOIN ESTADOS_ENSAYOS
                    ON  ENSAYOS.estado_id = ESTADOS_ENSAYOS.id 
                LEFT JOIN erp_users 
                    ON  ENSAYOS.erp_userid = erp_users.id 
                WHERE
                    erp_users.id = ".$_SESSION['user_session']."
                ORDER BY 
                    ENSAYOS.fecha ASC";
    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ensayos");
    
?>

<table class="table table-striped table-hover table-condensed" id='tabla-ensayos' style='font-size: 9px !important;'>
    <thead>
        <tr class="bg-dark">
            <th>NOMBRE</th>
            <th class="text-center">FECHA</th>
            <th class="text-center">TÉCNICO</th>
            <th class="text-center">ESTADO</th>
        </tr>
    </thead>
    <tbody>
<?    
    $contador = 0;
    while ($registros = mysqli_fetch_array($resultado)) { 
        $id_ensayo = $registros[0];
        $nombreEnsayo = $registros[1];
        $fechaEnsayo = $registros[3];
        $estadoColor = $registros[7];
        $estadoEnsayo = $registros[6];
        $tecnico = $registros[8]." ".$registros[10];
        $entregaid = $registros[9];
        
        echo "
            <tr data-id='".$entregaid."'>
                <td class='text-left' style='font-size: 9px !important;'>".$nombreEnsayo."</td>
                <td class='text-center' style='font-size: 9px !important;'>".$fechaEnsayo."</td>
                <td class='text-center' style='font-size: 9px !important;'>".$tecnico."</td>
                <td class='text-center label-".$estadoColor."' style='font-size: 9px !important;'><span class='label label-".$estadoColor."'>".$estadoEnsayo."</span></td>
            </tr>
        ";
        $contador = $contador + 1;
    }
?>
    </tbody>
</table>

<? echo $pagination; ?>

<!-- entregas activos -->