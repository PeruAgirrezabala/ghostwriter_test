<!-- proyectos activos -->
<table class="table table-striped table-hover table-condensed" id='tabla-previsiones' style="font-size: 9px !important;">
    <thead>
      <tr class="bg-dark">
        <th class="text-center">FECHAS</th>
        <th class="text-center">PREVISIÓN</th>
        <th class="text-center">INSTALACION | CLIENTE</th>
        <th class="text-center">TÉCNICOS</th>
        <th class="text-center">TIPO</th>
        <th class="text-center">REF.</th>
        <th class="text-center">ESTADO</th>
        <th class="text-center"></th>
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
                PREVISIONES.id prev,
                PREVISIONES.nombre,
                PREVISIONES.fecha_ini,
                PREVISIONES.fecha_fin,
                PREVISIONES.cliente_id,
                PREVISIONES.instalacion, 
                CLIENTES.nombre, 
                CLIENTES.img,
                PREVISIONES.item_id item,
                PREVISIONES.tipo_prev,
                PREVISIONES_ESTADOS.nombre,
                PREVISIONES_ESTADOS.color,
                (SELECT GROUP_CONCAT(CONCAT(erp_users.nombre,' ', erp_users.apellidos)) FROM erp_users, PREVISIONES_TECNICOS WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = prev) as tecnicos,
                (SELECT ref FROM INTERVENCIONES WHERE id = item),
                (SELECT ref FROM PROYECTOS WHERE id = item),
                (SELECT ref FROM OFERTAS WHERE id = item)
            FROM 
                PREVISIONES
            INNER JOIN PREVISIONES_ESTADOS
                ON PREVISIONES.estado_id = PREVISIONES_ESTADOS.id 
            LEFT JOIN CLIENTES
                ON PREVISIONES.cliente_id = CLIENTES.id
            WHERE 
                PREVISIONES.estado_id <> 3
            ORDER BY 
                PREVISIONES.fecha_ini ASC";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Previsiones");
    
    while ($registros = mysqli_fetch_array($resultado)) { 
        switch ($registros[9]) {
            case "0":
                $tipoprev = "Visita";
                $tipoprevLink = "";
                break;
            case "1":
                $tipoprev = "Mantenimiento";
                $tipoprevLink = "/erp/apps/mantenimientos/view.php?id=".$registros[8];
                $ref = $registros[14];
                break;
            case "2":
                $tipoprev = "Intervención";
                $tipoprevLink = "/erp/apps/intervenciones/editInt.php?id=".$registros[8];
                $ref = $registros[13];
                break;
            case "3":
                $tipoprev = "Proyecto";
                $tipoprevLink = "/erp/apps/proyectos/view.php?id=".$registros[8];
                $ref = $registros[14];
                break;
            case "4":
                $tipoprev = "Comercial";
                $tipoprevLink = "";
                $ref = $registros[15];
                break;
        }
        echo "
            <tr data-id='".$registros[0]."'>
                <td class='text-center'>".$registros[2]." - ".$registros[3]."</td>
                <td class='text-center'>".$registros[1]."</td>
                <td class='text-center'>".$registros[5]." - ".$registros[6]."</td>
                <td class='text-center'>".$registros[12]."</td>
                <td class='text-center'>".$tipoprev."</td>
                <td class='text-center'><a href='".$tipoprevLink."' target='_blank'>".$ref."</a></td>
                <td class='text-center'><span class='label label-".$registros[11]."'>".$registros[10]."</span></td>
                <td class='text-center'><button class='btn btn-circle btn-danger remove-prev' data-id='".$registros[0]."' title='Eliminar Previsión'><img src='/erp/img/cross.png'></button></td>
            </tr>
        ";
    }
?>

    </tbody>
</table>

<div id="calendario_prev" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CALENDARIO PREVISIONES</h4>
            </div>
            <div class="modal-body">
                <div class="loading-div"></div>
                <div class="contenedor-form" id="contenedor-previsiones">
                    
                </div>
                <div id="leyendaVacaciones" style="margin-top: 50px;">
                    <?
                        $sql = "SELECT 
                                        erp_users.nombre,
                                        erp_users.apellidos,
                                        erp_users.color
                                    FROM 
                                        erp_users 
                                    ORDER BY 
                                        nombre ASC";

                        //file_put_contents("queryCalendario.txt", $sql);
                        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de la Leyenda");

                        while ($registros = mysqli_fetch_array($resultado)) { 
                            echo "<label class='label block' style='white-space: normal;'><span class='badge' style='background-color:".$registros[2]."; white-space: normal;'>".$registros[0]." ".$registros[1]."</span></label>";
                        }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>