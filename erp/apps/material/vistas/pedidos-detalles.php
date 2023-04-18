<?
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    date_default_timezone_set('Europe/Madrid');
    //header('Content-type: text/html; charset=utf-8');
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    if(isset($_GET['id'])) {    
        $sql = "SELECT 
                        PEDIDOS_PROV.id,
                        PEDIDOS_PROV.ref,
                        PEDIDOS_PROV.titulo,
                        PEDIDOS_PROV.descripcion,
                        PEDIDOS_PROV.proveedor_id,
                        PEDIDOS_PROV.fecha,
                        PEDIDOS_PROV.fecha_entrega,
                        PEDIDOS_PROV.tecnico_id,
                        PEDIDOS_PROV.proyecto_id,
                        PEDIDOS_PROV.estado_id, 
                        PEDIDOS_PROV.total 
                    FROM 
                        PEDIDOS_PROV 
                    WHERE 
                        id = ".$_GET["id"];

        $res = mysqli_query($connString, $sql) or die("database error:");
        $registros = mysqli_fetch_row($res);

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
                    PEDIDOS_PROV_DETALLES.ref 
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
                WHERE
                    PEDIDOS_PROV_DETALLES.pedido_id = ".$registros[0]." 
                ORDER BY 
                    PEDIDOS_PROV_DETALLES.id ASC";

        file_put_contents("array.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("database error:");

        $html .= "<table class='table table-striped table-hover' id='tabla-detalles-pedidos'>
                    <input type='hidden' value='' name='multi-mat-rec' id='multi-mat-rec'>
                    <thead>
                      <tr class='bg-dark'>
                        <th class='text-center'>A</th>
                        <th class='text-center'>POS</th>
                        <th class='text-center'>REF</th>
                        <th class='text-center'>MATERIAL</th>
                        <th class='text-center'>FABRICANTE</th>
                        <th class='text-center'>UNID.</th>
                        <th class='text-center'>PVP</th>
                        <th class='text-center'>DTO %</th>
                        <th class='text-center'>IMPORTE</th>
                        <th class='text-center'>IVA %</th>
                        <th class='text-center'>RECIBIDO</th>
                        <th class='text-center'>F. RECEPCION</th>
                        <th class='text-center'>F.ENTREGA</th>
                        <th class='text-center'>PROYECTO</th>
                        <th class='text-center'>R</th>
                        <th class='text-center'>E</th>
                      </tr>
                    </thead>
                    <tbody>";

        $iva = 0;
        $posicion = 10;
        while( $row = mysqli_fetch_array($res) ) {
            if ($row[5] != "") { // Sacar precio material
                $pvp = $row[5];
            }
            else {
                $pvp = $row[9];
            }
            // Settear descuentos a 0
            $dto_sum = 0;
            $pvp_dto = 0;
            $dto_extra = "";
            if ($row[11] == 1) { // Añadir descuento
                $dto_sum  = $dto_sum + $row[14];
            }
            if ($row[12] == 1) { // Añadir descuento
                $dto_sum  = $dto_sum + $row[10];
            }
            if ($row[13] == 1) { // Añadir descuento Extra
                if ($row[19] == 1) {
                    $dto_extra = $row[15];
                }else {
                    $dto_sum  = $dto_sum + $row[15];
                    $dto_extra = "";
                }
            }       

            $ivaPercent = $row[21]; // Obtener porcentaje IVA
            $subtotal = ($pvp*$row[4]); // Obtener precio subtotal
            $dto = ($subtotal*$dto_sum)/100; // Obtener descuento
            $subtotalDtoApli = $subtotal-$dto; // Subtotal descuento aplicado
            if ($row[19] == 1) {
                $dtoNeto = ($subtotalDtoApli*$dto_extra)/100;
                $subtotalDtoApli = $subtotalDtoApli-$dtoNeto;
                $dto_extra =  " + ".number_format($dto_extra, 2);
            }
            else {
                $dtoNeto = 0;
            }

            if ($row[6] == 0) { // Detalle recibido NO, SI
                $recibidoDet = "NO";
            }
            else {
                $recibidoDet = "SI";
            }

            if ($recibidoDet == "SI") {
                $disableButton = " disabled ";
                $disableButton2 = " disabled ";
                if($row[6] == 1){ // Recibido // Añadir boton a devolver?¿
                    $trcolor = "background-color: #b7fca4;";
                    $habilitado = "";
                    $imgDet = "/erp/img/enviar.png";
                    $imgClass = "enviar-mat";
                    $disableButton2 = " ";
                    $titulo = "Recibido. Realizar Envio/Devolución";
                }elseif($row[6] == 2){ // Devuelto
                    $trcolor = "background-color: #ffce89;";
                    $habilitado = "disabled";
                    $imgDet = "/erp/img/enviar.png";
                    $imgClass = "enviar-mat";
                    $titulo = "Devuelto";
                }elseif($row[6] == 3){ // Asignado a proyecto
                    $trcolor = "background-color: #70a561;";
                    $habilitado = "disabled";
                    $imgDet = "/erp/img/recibido.png";
                    $imgClass = "recibir-mat";
                    $titulo = "Recibido. Asignado a Proyecto";
                }
            } else {
                $imgDet = "/erp/img/recibido.png";
                $titulo = "Recibido";
                $imgClass = "recibir-mat";
                $disableButton = " ";
                $trcolor = "";
            }

            if ($row[2] != "") {
                $material = $row[2];
            } else {
                $material = $row[22];
            }

            if ($row[1] != "") {
                $ref = $row[1];
            } else {
                $ref = $row[23];
            }

            $html .= "
                    <tr data-id='".$row[0]."' style='".$trcolor."'>
                        <td class='text-center'><input type='checkbox' class='to-alb' data-matid='".$row[18]."' $disableButton></td>
                        <td class='text-center'>".$posicion."</td>
                        <td class='text-center'>".$ref."</td>
                        <td>".$material."</td>
                        <td class='text-center'>".$row[3]."</td>
                        <td class='text-center'>".$row[4]."</td>
                        <td class='text-right'>".$pvp."</td>
                        <td class='text-right'>".number_format($dto_sum, 2).$dto_extra."</td>
                        <td class='text-right'>".number_format($subtotalDtoApli, 2)."</td>
                        <td class='text-right'>".$ivaPercent."</td>
                        <td class='text-center'>".$recibidoDet."</td>
                        <td class='text-center'>".$row[7]."</td>
                        <td class='text-center'>".$row[16]."</td>
                        <td>".$row[8]."</td>
                        <td class='text-center'><button class='btn btn-default ".$imgClass."' data-id='".$row[0]."' title='".$titulo."' ".$disableButton2."><img src='".$imgDet."' style='height: 20px;'></button></td>
                        <td class='text-center'><button class='btn btn-circle btn-danger remove-detalle' data-id='".$row[0]."' title='Eliminar detalle'><img src='/erp/img/cross.png'></button></td>
                    </tr>";
            $importe = $importe+$subtotal;
            $totaldto = $totaldto + $dto + $dtoNeto;
            $iva = $iva + (($subtotal-($dto + $dtoNeto))*$ivaPercent/100);
            $posicion = $posicion + 10;
        }
        $html .= "      </tbody>
                    </table>";

        //$iva = (($importe-$totaldto)*21)/100;
        $totalPVP = ($importe-$totaldto);
        $total = ($importe-$totaldto) + $iva;

        echo $html;
    } //if isset $_GET['id']

?>

<div class="row pvp_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-2"><label class='viewTitle resumen-title-vistas'>IMPORTE: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format($importe, 2); ?> €</label> </div>
    <div class="col-sm-2"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format($totaldto, 2); ?> €</label> </div>
    <div class="col-sm-2"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format($totalPVP, 2); ?> €</label> </div>
    <div class="col-sm-2"><label class='viewTitle resumen-title-vistas'>IVA: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format($iva, 2); ?> €</label></div>
    <div class="col-sm-2" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format($total, 2); ?> €</label></div>
</div>

