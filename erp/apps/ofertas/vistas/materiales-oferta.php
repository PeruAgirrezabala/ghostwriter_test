<div class="form-group" id="material-ofertas-container">
    <table class="table table-striped table-condensed table-hover" id='tabla-material-ofertas'>
        <thead>
            <tr class="bg-dark">
                <th class="text-center">REF</th>
                <th class="text-center">TITULO</th>
                <th class="text-center">CANT</th>
                <th class="text-center">Unitario (€)</th>
                <th class="text-center">DTO PROV (%)</th>
                <th class="text-center">Coste (€)</th>
                <th class="text-center">DTO CLI (%)</th>
                <th class="text-center">Coste Final (€)</th>
                <th class="text-center">Margen (%)</th>
                <th class="text-center">PVP (€)</th>
                <th class="text-center">ORIGEN</th>
            </tr>
        </thead>
        <tbody>
            <?
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");
                $db = new dbObj();
                $connString =  $db->getConnstring();

                $sql = "SELECT 
                    OFERTAS_DETALLES_MATERIALES.id,
                    MATERIALES.id as material,
                    MATERIALES.ref,
                    MATERIALES.nombre,
                    MATERIALES.modelo,
                    MATERIALES.descripcion,
                    MATERIALES_PRECIOS.pvp as precio,
                    OFERTAS_DETALLES_MATERIALES.cantidad,
                    OFERTAS_DETALLES_MATERIALES.titulo,
                    OFERTAS_DETALLES_MATERIALES.descripcion,
                    OFERTAS_DETALLES_MATERIALES.incremento,
                    OFERTAS_DETALLES_MATERIALES.dto1, 
                    OFERTAS_DETALLES_MATERIALES.dto_prov_activo, 
                    OFERTAS_DETALLES_MATERIALES.dto_mat_activo, 
                    OFERTAS_DETALLES_MATERIALES.dto_ad_activo, 
                    PROVEEDORES_DTO.dto_prov, 
                    MATERIALES.dto2,
                    OFERTAS_DETALLES_MATERIALES.origen,
                    PROVEEDORES.nombre 
                FROM 
                    MATERIALES
                INNER JOIN MATERIALES_PRECIOS
                    ON MATERIALES_PRECIOS.material_id = MATERIALES.id  
                INNER JOIN PROVEEDORES
                    ON MATERIALES_PRECIOS.proveedor_id = PROVEEDORES.id 
                INNER JOIN OFERTAS_DETALLES_MATERIALES
                    ON OFERTAS_DETALLES_MATERIALES.material_tarifa_id = MATERIALES_PRECIOS.id
                INNER JOIN OFERTAS 
                    ON OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id  
                LEFT JOIN PROVEEDORES_DTO 
                    ON PROVEEDORES_DTO.id = OFERTAS_DETALLES_MATERIALES.dto_prov_id
                WHERE 
                    OFERTAS.id = ".$_GET['oferta_id']." 
                ORDER BY 
                    OFERTAS_DETALLES_MATERIALES.id ASC";

                file_put_contents("vistaMaterialesOferta.txt", $sql);
                $res = mysqli_query($connString, $sql) or die("Error al generar la vista de Materiales");

                $pedidoGroup = "";
                $contador = 0;
                while( $registros = mysqli_fetch_array($res) ) {        
                    $oferta_id = $_GET['oferta_id'];
                    $id = $registros[0];
                    $ref = $registros[2];
                    $nombreMat = $registros[3];
                    $modeloMat = $registros[4];
                    $descMat = $registros[5];
                    $pvpMat = $registros[6];
                    $cantidad = $registros[7];
                    $tituloMat = $registros[8];
                    $descripcionMat = $registros[9];
                    $incMat = $registros[10];
                    $dtoProvActivo = $registros[12];
                    $dtoMatActivo = $registros[13];
                    $dtoCliActivo = $registros[14];
                    $dtoProv = $registros[15];
                    $dtoMat = $registros[16];
                    $origen = $registros[17];
                    $proveedor = $registros[18];
                    
                    if ($pedidoGroup != $proveedor) {
                        //insertamos cabecera del siguiente grupo
                        $pedidoGroup = $proveedor;
                        echo "<tr>
                                    <td class='text-left' style='background-color: #219ae0; color: #ffffff;' colspan='12'><strong>PROVEEDOR: </strong> ".$pedidoGroup." </td>
                              </tr>";
                    }
                    
                    if ($origen == 0) {
                        $origen = "COMPRA";
                        $trcolor = "style='background-color: #b7fca4;'";
                    }
                    else {
                        $origen = "ALMACÉN";
                        $trcolor = "";
                    }
                    
                    if ($dtoProvActivo == 1) {
                        $dto_sum  = $dto_sum + $dtoProv;
                    }
                    if ($dtoMatActivo == 1) {
                        $dto_sum  = $dto_sum + $dtoMat;
                    }
                    if ($dtoCliActivo == 1) {
                        $dtoAcliente = $registros[11];
                    }
                    else {
                        $dtoAcliente = 0.00;
                    }       

                    $subtotal = ($pvpMat*$cantidad);
                    $dto = ($subtotal*$dto_sum)/100;
                    $subtotalDTOPROVapli = $subtotal-$dto;
                    $dtoCliPVP = ($subtotalDTOPROVapli*$dtoAcliente)/100;
                    $subtotalDTOCLIapli = $subtotalDTOPROVapli - $dtoCliPVP;
                    $inc = $incMat;
                    $pvpTOTAL = $subtotalDTOCLIapli/$inc;

                    echo "
                            <tr data-id='".$registros[0]."' ".$trcolor.">
                                <td class='text-center'>".$ref."</td>
                                <td class='text-left'>".$nombreMat." - ".$modeloMat."</td>
                                <td class='text-center'>".$cantidad."</td>
                                <td class='text-right'>".number_format((float)$pvpMat, 2, '.', '')."</td>
                                <td class='text-center'>".number_format((float)$dto_sum, 2, '.', '')."</td>
                                <td class='text-right'>".number_format((float)$subtotalDTOPROVapli, 2, '.', '')."</td>
                                <td class='text-center'>".number_format((float)$dtoAcliente, 2, '.', '')."</td>
                                <td class='text-right'>".number_format((float)$subtotalDTOCLIapli, 2, '.', '')."</td>
                                <td class='text-center'>".number_format((float)$incMat, 2, '.', '')."</td>
                                <td class='text-right'>".number_format((float)$pvpTOTAL, 2, '.', '')."</td>
                                <td class='text-center'>".$origen."</td>
                            </tr>";
                    
                }
            ?>
        </tbody>
    </table>
</div>

