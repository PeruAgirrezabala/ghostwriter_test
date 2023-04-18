<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "SELECT 
                PEDIDOS_PROV_DETALLES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                PEDIDOS_PROV_DETALLES.unidades,
                MATERIALES_PRECIOS.pvp, 
                PEDIDOS_PROV_DETALLES.recibido,
                PEDIDOS_PROV_DETALLES.fecha_recepcion,
                PROYECTOS.nombre,
                PEDIDOS_PROV_DETALLES.pvp,
                MATERIALES_PRECIOS.dto_material, 
                PEDIDOS_PROV_DETALLES.dto_prov_activo, 
                PEDIDOS_PROV_DETALLES.dto_mat_activo, 
                PEDIDOS_PROV_DETALLES.dto_ad_activo, 
                PROVEEDORES_DTO.dto_prov, 
                PEDIDOS_PROV_DETALLES.dto, 
                ENTREGAS.nombre,
                erp_users.nombre, 
                MATERIALES.id,
                PEDIDOS_PROV_DETALLES.dto_ad_prior,
                PEDIDOS_PROV_DETALLES.iva_id,
                IVAS.nombre,
                PEDIDOS_PROV_DETALLES.pedido_id
            FROM 
                PEDIDOS_PROV_DETALLES
            INNER JOIN MATERIALES
                ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
            INNER JOIN IVAS
                ON IVAS.id = PEDIDOS_PROV_DETALLES.iva_id 
            LEFT JOIN MATERIALES_PRECIOS 
                ON MATERIALES_PRECIOS.id = PEDIDOS_PROV_DETALLES.material_tarifa_id 
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = PEDIDOS_PROV_DETALLES.proyecto_id 
            LEFT JOIN PROVEEDORES_DTO 
                ON PROVEEDORES_DTO.id = PEDIDOS_PROV_DETALLES.dto_prov_id
            LEFT JOIN ENTREGAS
                ON PEDIDOS_PROV_DETALLES.entrega_id = ENTREGAS.id
            LEFT JOIN erp_users 
                ON PEDIDOS_PROV_DETALLES.erp_userid = erp_users.id 
            WHERE
                PEDIDOS_PROV_DETALLES.erp_userid = ".$_SESSION['user_session']." 
            AND
                PEDIDOS_PROV_DETALLES.recibido = 0 
            ORDER BY 
                PEDIDOS_PROV_DETALLES.id ASC";

    file_put_contents("array.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover table-condensed' id='tabla-detalles-pedidos' style='font-size: 9px !important;'>
                <thead>
                  <tr>
                    <th>REF</th>
                    <th>MATERIAL</th>
                    <th>FABRICANTE</th>
                    <th>UNID.</th>
                    <th>PVP</th>
                    <th>DTO %</th>
                    <th>IMPORTE</th>
                    <th>IVA %</th>
                    <th>RECIBIDO</th>
                    <th>FECHA RECEPCION</th>
                    <th>ENTREGA</th>
                    <th>PROYECTO</th>
                  </tr>
                </thead>
                <tbody>";
    
    $iva = 0;
    while( $row = mysqli_fetch_array($res) ) {
        if ($row[5] != "") {
            $pvp = $row[5];
        }
        else {
            $pvp = $row[9];
        }
        
        $dto_sum = 0;
        $pvp_dto = 0;
        if ($row[11] == 1) {
            $dto_sum  = $dto_sum + $row[14];
        }
        if ($row[12] == 1) {
            $dto_sum  = $dto_sum + $row[10];
        }
        if ($row[13] == 1) {
            if ($row[19] == 1) {
                $dto_extra = $row[15];
            }
            else {
                $dto_sum  = $dto_sum + $row[15];
                $dto_extra = "";
            }
        }       
        
        $ivaPercent = $row[21];
        $subtotal = ($pvp*$row[4]);
        $dto = ($subtotal*$dto_sum)/100;
        $subtotalDtoApli = $subtotal-$dto;
        if ($row[19] == 1) {
            $dtoNeto = ($subtotalDtoApli*$dto_extra)/100;
            $subtotalDtoApli = $subtotalDtoApli-$dtoNeto;
            $dto_extra =  " + ".number_format($dto_extra, 2);
        }
        else {
            $dtoNeto = 0;
        }
        
        if ($row[6] == 0) {
            $recibidoDet = "NO";
        }
        else {
            $recibidoDet = "SI";
        }
        
        if ($recibidoDet == "SI") {
            $disableButton = " disabled ";
        }
        else {
            $disableButton = " ";
        }
        
        $html .= "
                <tr data-id='".$row[22]."'>
                    <td>".$row[1]."</td>
                    <td>".$row[2]."</td>
                    <td>".$row[3]."</td>
                    <td class='text-center'>".$row[4]."</td>
                    <td class='text-right'>".$pvp."</td>
                    <td class='text-right'>".number_format($dto_sum, 2).$dto_extra."</td>
                    <td class='text-right'>".number_format($subtotalDtoApli, 2)."</td>
                    <td class='text-right'>".$ivaPercent."</td>
                    <td>".$recibidoDet."</td>
                    <td>".$row[7]."</td>
                    <td>".$row[16]."</td>
                    <td>".$row[8]."</td>
                </tr>";
        $importe = $importe+$subtotal;
        $totaldto = $totaldto + $dto + $dtoNeto;
        $iva = $iva + (($subtotal-($dto + $dtoNeto))*$ivaPercent/100);
    }
    $html .= "      </tbody>
                </table>";
    
    //$iva = (($importe-$totaldto)*21)/100;
    $totalPVP = ($importe-$totaldto);
    $total = ($importe-$totaldto) + $iva;
    
    echo $html;

?>
