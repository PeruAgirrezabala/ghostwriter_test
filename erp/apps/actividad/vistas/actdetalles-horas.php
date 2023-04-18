<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "SELECT 
                ACTIVIDAD_DETALLES_HORAS.id,
                erp_users.nombre,
                erp_users.apellidos,
                PERFILES_HORAS.nombre,
                ACTIVIDAD_DETALLES_HORAS.cantidad
            FROM
                ACTIVIDAD_DETALLES_HORAS, erp_users, PERFILES_HORAS
            WHERE
                ACTIVIDAD_DETALLES_HORAS.tipo_hora_id = PERFILES_HORAS.id
            AND
                ACTIVIDAD_DETALLES_HORAS.tecnico_id = erp_users.id
            AND
                ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ".$_GET["det_id"]."
            ";
    
    file_put_contents("queryActDetallesHoras.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Horas");
    
    
?>
<table class="table table-striped table-condensed table-hover" id='tabla-detalleshoras-act'>
    <thead>
        <tr class="bg-dark">
        <th>TECNICO</th>
        <th class="text-center">TIPO DE HORAS</th>
        <th class="text-center">CANTIDAD</th>
        <th class="text-center">E</th>
      </tr>
    </thead>
    <tbody>
<?
    $totalHoras = 0;
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]." ".$registros[2]."</td>
                <td class='text-center'>".$registros[3]."</td>
                <td class='text-center'>".$registros[4]."</td>
                <td class='text-center'><button type='button' class='btn btn-danger btn-circle remove-detalle-horas' data-id='".$registros[0]."' title='Eliminar Horas'><img src='/erp/img/cross.png'></button></td>
            </tr>
        ";
        $totalHoras = $totalHoras + $registros[4];
    }
?>
        <tr>
            <td colspan="2"></td>
            <td class="text-center" style="background-color: lightblue; font-weight: bolder;"><? echo $totalHoras; ?></td>
            <td></td>
        </tr>
    </tbody>
</table>

