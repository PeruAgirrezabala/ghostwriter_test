<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    file_put_contents("log.txt", $_GET['act_id']);
 
    $sql = "SELECT 
                ACTIVIDAD_DETALLES.id as detid,
                ACTIVIDAD_DETALLES.nombre,  
                ACTIVIDAD_DETALLES.descripcion,
                ACTIVIDAD_DETALLES.fecha,
                ACTIVIDAD_DETALLES.fecha_mod,
                erp_users.nombre,
                erp_users.apellidos,
                (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS WHERE actividad_detalle_id = detid) as totalhoras,
                ACTIVIDAD_DETALLES.completado
            FROM 
                ACTIVIDAD_DETALLES, erp_users, ACTIVIDAD
            WHERE
                ACTIVIDAD_DETALLES.erpuser_id = erp_users.id
            AND
                ACTIVIDAD_DETALLES.actividad_id = ACTIVIDAD.id
            AND
                ACTIVIDAD_DETALLES.actividad_id = ".$_GET["act_id"]." 
            ORDER BY 
                ACTIVIDAD_DETALLES.id ASC";

    file_put_contents("queryPlanDetalles.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error seleccionando los detalles de la Actividad");
    
    $tohtml='<table class="table table-striped table-condensed table-hover" id="tabla-detalles-act">
    <thead>
        <tr class="bg-dark">
        <th>EST.</th>
        <th>TITULO</th>
        <th class="text-center">FECHA</th>
        <th class="text-center">TÉCNICO</th>
        <th class="text-center">HORAS TOTALES</th>
        <th class="text-center">E</th>
      </tr>
    </thead>
    <tbody>';

    while ($registros = mysqli_fetch_array($resultado)) { 
        if($registros[8]==0){ // No completado
            $estadodot='<span class="dot-red" title="No completado"></span>';
        }elseif($registros[8]==1){ // A medias
            $estadodot='<span class="dot-yellow" title="A medias"></span>';
        }elseif($registros[8]==2){ // Completado
            $estadodot='<span class="dot-green" title="Completado"></span>';
        }       
        
        $tohtml.= "
            <tr data-id='".$registros[0]."'>
                <td>".$estadodot."</td>
                <td>".$registros[1]."</td>
                <td class='text-center'>".$registros[3]."</td>
                <td class='text-center'>".$registros[5]." ".$registros[6]."</td>
                <td class='text-center'>".$registros[7]."</td>
                <td class='text-center'><button class='btn btn-danger btn-circle remove-detalle' data-id='".$registros[0]."' title='Eliminar detalle'><img src='/erp/img/cross.png'></button></td>
            </tr>
        ";
    }

    $tohtml.="</tbody>
</table>";
    file_put_contents("log01.txt", $tohtml);
    echo $tohtml;
?>