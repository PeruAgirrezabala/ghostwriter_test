<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="ofertas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-ofertas-mat'>
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
                    OFERTAS_DETALLES_MATERIALES.pedcreado,
                    OFERTAS_DETALLES_MATERIALES.material_tarifa_id,
                    PROVEEDORES.id,
                    PROVEEDORES.nombre
                FROM 
                    MATERIALES
                INNER JOIN MATERIALES_PRECIOS
                    ON MATERIALES_PRECIOS.material_id = MATERIALES.id  
                INNER JOIN OFERTAS_DETALLES_MATERIALES
                    ON OFERTAS_DETALLES_MATERIALES.material_tarifa_id = MATERIALES_PRECIOS.id
                INNER JOIN OFERTAS 
                    ON OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id  
                INNER JOIN PROVEEDORES
                    ON MATERIALES_PRECIOS.proveedor_id=PROVEEDORES.id
                LEFT JOIN PROVEEDORES_DTO 
                    ON PROVEEDORES_DTO.id = OFERTAS_DETALLES_MATERIALES.dto_prov_id
                WHERE 
                    OFERTAS.id = ".$_GET['id']." 
                ORDER BY
                    PROVEEDORES.id ASC";
        
        file_put_contents("queryMat.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Material");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        $providold=0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $oferta_id = $_GET['id'];
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
            $dto_sum = 0;
            $pvp_dto = 0;
            $pedcreado = $registros[18];
            $mattarifaid = $registros[19];
            $provid = $registros[20];
            $provnom = $registros[21];
            
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
            //$pvpTOTAL = $subtotalDTOCLIapli/$inc;
            $pvpTOTAL = $subtotalDTOCLIapli+(($subtotalDTOCLIapli*$inc)/100);
            
            $totalPVP = $totalPVP + $subtotalDTOCLIapli;
            $totalDTO = $totalDTO + $dtoCliPVP;
            $total = $total + $pvpTOTAL;
            
            if($pedcreado!=0){
                $style="style='background-color: #ffced8;'";
                $disable="disabled";
                $title="title='Borrar primero del proyecto'";
                $id=0; // machacamos id para que no se pueda hacer nada si se ha creado un pedido (evitar desgloses)
            }else{
                $style="style=''"; 
                $title="title='Borrar Material'";
                $disable="";
            }
            
            // Comprobar si es prov igual que el anterior
            if($provid!=$providold){
                echo '<tr data-id="0">
                        <td class="text-left" style="background-color: #219ae0; color: #ffffff;" colspan="14">
                            <strong>PROVEEDOR: </strong> '.$provnom.'
                        </td>
                      </tr>';
            }
            $providold=$provid;
            echo "
                <tr data-id='".$id."' class='oferta' ".$style.">
                    <td class='text-center'>".$ref."</td>
                    <td>".$nombreMat." - ".$modeloMat."</td>
                    <td class='text-center'>".$cantidad."</td>
                    <td class='text-center'>".number_format((float)$pvpMat, 2, '.', '')."</td>
                    <td class='text-center'>".number_format((float)$dto_sum, 2, '.', '')."</td>
                    <td class='text-center'>".number_format((float)$subtotalDTOPROVapli, 2, '.', '')."</td>
                    <td class='text-center'>".number_format((float)$dtoAcliente, 2, '.', '')."</td>
                    <td class='text-center'>".number_format((float)$subtotalDTOCLIapli, 2, '.', '')."</td>
                    <td class='text-center'>".number_format((float)$incMat, 2, '.', '')."</td>
                    <td class='text-center'>".number_format((float)$pvpTOTAL, 2, '.', '')."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-detalle' data-id='".$id."' ".$disable." ".$title."><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
        $totalGanancia = $total - $totalPVP;
    ?>
    </tbody>
</table>

<div class="row pvp_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>COSTE: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO CLI: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>MARGEN: </label> <label id='materiales_iva' class="precio_right_vistas"> <? echo number_format((float)$totalGanancia, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format((float)$total, 2, ',', '.'); ?> €</label></div>
</div>
   
