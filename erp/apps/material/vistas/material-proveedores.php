<div class="form-group" id="material-proveedores-container">
    <table class="table table-striped table-condensed table-hover" id='tabla-material-proveedores'>
        <thead>
            <tr class="bg-dark">
                <th class="text-center">REF</th>
                <th class="text-center">MATERIAL</th>
                <th class="text-center">FABRICANTE</th>
                <th class="text-center">UNID.</th>
                <th class="text-center">PVP</th>
                <th class="text-center">DTO %</th>
                <th class="text-center">IMPORTE</th>
                <th class="text-center">RECIBIDO</th>
                <th class="text-center">FECHA</th>
                <th class="text-center">F.ENTREGA</th>
            </tr>
        </thead>
        <tbody>
            <?
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");
                $db = new dbObj();
                $connString =  $db->getConnstring();

                if ($_GET['proveedor_id'] != "") {
                    $criteria .= " WHERE PEDIDOS_PROV.proveedor_id = ".$_GET['proveedor_id'];
                    $and = " AND ";
                }
                if ($_GET['year'] != "") {
                    if ($criteria == "") {
                        $criteria = " WHERE ";
                    }
                    $criteria .= $and." YEAR(PEDIDOS_PROV.fecha) = ".$_GET['year'];
                    $and = " AND ";
//                    if ($_GET['month'] != "") {
//                        $criteria .= " AND MONTH(PEDIDOS_PROV.fecha) = ".$_GET['month'];
//                    }
                }
                if ($_GET['estado'] != "") {
                    if ($criteria == "") {
                        $criteria = " WHERE ";
                    }
                    if ($_GET['estado'] == 99) {
                        $criteria .= $and." PEDIDOS_PROV.estado_id <> 2 AND PEDIDOS_PROV.estado_id <> 4 AND PEDIDOS_PROV.estado_id <> 5 AND PEDIDOS_PROV.estado_id <> 6 AND PEDIDOS_PROV.estado_id <> 7 ";
                    }
                    else {
                        $criteria .= $and." PEDIDOS_PROV.estado_id = ".$_GET['estado'];
                    }
                    $and = " AND ";
                }
                if ($_GET['recibido'] == "1") {
                    if ($criteria == "") {
                        $criteria = " WHERE ";
                    }
                    $criteria .= $and." PEDIDOS_PROV_DETALLES.recibido = 1 ";  
                    $and = " AND ";
                }elseif($_GET['recibido'] == "0"){
                    $criteria .= $and." PEDIDOS_PROV_DETALLES.recibido = 0 ";
                    $and = " AND ";
                }
                if ($_GET['proyecto'] != "") {
                    if ($criteria == "") {
                        $criteria = " WHERE ";
                    }
                    $criteria .= $and." PEDIDOS_PROV.proyecto_id = ".$_GET['proyecto'];  
                    $and = " AND ";
                }
                if ($_GET['cliente'] != "") {
                    if ($criteria == "") {
                        $criteria = " WHERE ";
                    }
                    $criteria .= $and." PEDIDOS_PROV.cliente_id = ".$_GET['cliente'];  
                    $and = " AND ";
                }
                
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
                            PEDIDOS_PROV_DETALLES.fecha_entrega,
                            erp_users.nombre, 
                            MATERIALES.id,
                            PEDIDOS_PROV_DETALLES.dto_ad_prior,
                            PEDIDOS_PROV_DETALLES.iva_id,
                            IVAS.nombre,
                            PEDIDOS_PROV_DETALLES.detalle_libre,
                            PEDIDOS_PROV_DETALLES.ref,
                            PEDIDOS_PROV.id,
                            PEDIDOS_PROV.pedido_genelek,
                            PEDIDOS_PROV.fecha,
                            PROVEEDORES.nombre,
                            PEDIDOS_PROV_DETALLES.material_tarifa_id,
                            PEDIDOS_PROV_DETALLES.dto_prov_id,
                            PEDIDOS_PROV.estado_id,
                            PEDIDOS_PROV.plazo
                        FROM 
                            PEDIDOS_PROV_DETALLES
                        LEFT JOIN MATERIALES
                            ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
                        INNER JOIN IVAS
                            ON IVAS.id = PEDIDOS_PROV_DETALLES.iva_id 
                        LEFT JOIN MATERIALES_PRECIOS 
                            ON MATERIALES_PRECIOS.id = PEDIDOS_PROV_DETALLES.material_tarifa_id 
                        LEFT JOIN PROYECTOS 
                            ON PROYECTOS.id = PEDIDOS_PROV_DETALLES.proyecto_id 
                        LEFT JOIN PROVEEDORES_DTO 
                            ON PROVEEDORES_DTO.id = PEDIDOS_PROV_DETALLES.dto_prov_id
                        LEFT JOIN erp_users 
                            ON PEDIDOS_PROV_DETALLES.erp_userid = erp_users.id 
                        INNER JOIN PEDIDOS_PROV
                            ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                        INNER JOIN PROVEEDORES 
                            ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id
                        ".$criteria."
                        ORDER BY 
                            PEDIDOS_PROV.fecha DESC, PEDIDOS_PROV_DETALLES.id ASC";

                file_put_contents("selMatpedxProv.txt", $sql);
                $res = mysqli_query($connString, $sql) or die("database error:");

                $iva = 0;
                $pedidoGroup = "";
                $contador = 0;
                while( $row = mysqli_fetch_array($res) ) {        
                    $fecha_entrega = strtotime($row[16]);
                    $fecha_entrega = date("Y-m-d", $fecha_entrega);
                    if ((date("Y-m-d") > $fecha_entrega) && (($row[30] < 4) || ($row[30] > 7)) && ($row[16] != "0000-00-00")) {
                        $fecha_entrega = $row[16]."<span class='blink_me' title='Pedido Retrasado'><img src='/erp/img/warning-test.png'></span>";
                    }
                    else {
                        $fecha_entrega = $row[16];
                    }
                    if ($pedidoGroup != $row[25]) {
                        //insertamos cabecera del siguiente grupo
                        $pedidoGroup = $row[25];
                        echo "<tr>
                                    <td class='text-left' style='background-color: #219ae0; color: #ffffff;' colspan='12'><strong>REF:</strong> ".$pedidoGroup." <strong>Fecha:</strong> ".$row[26]." <strong>Plazo:</strong> ".$row[31]." <strong>Fecha estimada de Entrega:</strong> ".$fecha_entrega." </td>
                              </tr>";
                    }
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
                        $trcolor = "style='background-color: #b7fca4;'";
                    }
                    else {
                        $disableButton = " ";
                        $trcolor = "";
                    }

                    if ($row[2] != "") {
                        $material = $row[2];
                    }
                    else {
                        $material = $row[22];
                    }

                    if ($row[1] != "") {
                        $ref = $row[1];
                    }
                    else {
                        $ref = $row[23];
                    }

                    echo "
                            <tr data-id='".$row[0]."' ".$trcolor.">
                                <td class='text-left'>".$ref."</td>
                                <td class='text-left'>".$material."</td>
                                <td class='text-center'>".$row[3]."</td>
                                <td class='text-center'>".$row[4]."</td>
                                <td class='text-right'>".$pvp."</td>
                                <td class='text-right'>".number_format($dto_sum, 2).$dto_extra."</td>
                                <td class='text-right'>".number_format($subtotalDtoApli, 2)."</td>
                                <td class='text-center'>".$recibidoDet."</td>
                                <td class='text-center'>".$row[26]."</td>
                                <td class='text-center'>".$row[16]."</td>
                            </tr>";
                    $importe = $importe+$subtotal;
                    $totaldto = $totaldto + $dto + $dtoNeto;
                    $iva = $iva + (($subtotal-($dto + $dtoNeto))*$ivaPercent/100);
                    $contador = $contador + 1;
                }

                //$iva = (($importe-$totaldto)*21)/100;
                $totalPVP = ($importe-$totaldto);
                $total = ($importe-$totaldto) + $iva;
            ?>
        </tbody>
    </table>
</div>

