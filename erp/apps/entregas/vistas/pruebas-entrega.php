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
                    ENSAYOS.plantilla_id
                FROM 
                    ENTREGAS 
                INNER JOIN ENSAYOS
                    ON  ENTREGAS.id = ENSAYOS.entrega_id 
                INNER JOIN ESTADOS_ENSAYOS
                    ON  ENSAYOS.estado_id = ESTADOS_ENSAYOS.id 
                LEFT JOIN erp_users 
                    ON  ENSAYOS.erp_userid = erp_users.id 
                WHERE
                    ENTREGAS.id = ".$_GET['id']."
                ORDER BY 
                    ENSAYOS.fecha ASC";
    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ensayos");
    
?>

<table class="table table-striped table-hover" id='tabla-ensayos'>
    <thead>
      <tr class="bg-dark">
        <th>NOMBRE</th>
        <th class="text-center">FECHA</th>
        <th class="text-center">TÉCNICO</th>
        <th class="text-center">ESTADO</th>
        <th class="text-center">PRINT</th>
        <th class="text-center">A</th>
        <th class="text-center" style='width:5%;'>E</th>
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
        $tecnico = $registros[8];
        $plantilla_id = $registros[9];
        
        echo "
            <tr data-id='".$id_ensayo."'>
                <td class='text-left'>".$nombreEnsayo."</td>
                <td class='text-center'>".$fechaEnsayo."</td>
                <td class='text-center'>".$tecnico."</td>
                <td class='text-center'><span class='label label-".$estadoColor."'>".$estadoEnsayo."</span></td>
                <td class='text-center'><button type='button' class='print_ensayo_view' data-id='".$id_ensayo."' value='".$plantilla_id."'><img src='/erp/img/print.png' height='60'></button></td>
                <td class='text-center' style='max-width:200px;'>
                    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#test-tools".$contador."'>
                        <img src='/erp/img/gear2.png' style='height: 20px;'>
                    </button>
                    <div class='row collapse navbar-collapse' id='test-tools".$contador."'>
                        <button class='btn-default aprobar-ensayo' data-id='".$id_ensayo."' title='Aprobar Ensayo'><img src='/erp/img/approved.png' style='height: 60px;'></button>
                        <button class='btn-default fallido-ensayo' data-id='".$id_ensayo."' title='Ensayo Fallido'><img src='/erp/img/remove.png' style='height: 60px;'></button>
                        <button class='btn-default enproceso-ensayo' data-id='".$id_ensayo."' title='Empezar Ensayo'><img src='/erp/img/process.png' style='height: 60px;'></button>
                        <button class='btn-default aviso-ensayo' data-id='".$id_ensayo."' title='Ensayo con Aviso'><img src='/erp/img/warning-test.png' style='height: 60px;'></button>
                        <button class='btn-default pendiente-ensayo' data-id='".$id_ensayo."' title='Ensayo Pendiente'><img src='/erp/img/pending.png' style='height: 60px;'></button>
                    </div>
                </td>
                <td class='text-center' style='width:5%;'><button class='btn btn-circle btn-danger remove-ensayo' data-id='".$id_ensayo."' title='Eliminar Ensayo'><img src='/erp/img/cross.png'></button></td>
            </tr>
        ";
        $contador = $contador + 1;
    }
?>
    </tbody>
</table>

<? //echo $pagination; ?>

<!-- entregas activos -->