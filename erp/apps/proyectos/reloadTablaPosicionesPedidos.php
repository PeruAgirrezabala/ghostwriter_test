
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    //file_put_contents("debug0.txt", $_POST['proyecto_id']);
    
    $tohtml='<thead>
                                    <tr class="bg-dark">
                                        <th class="text-center">S</th>
                                        <th class="text-center">REF</th>
                                        <th class="text-center">MATERIAL</th>
                                        <th class="text-center">FABRICANTE</th>
                                        <th class="text-center">UNID.</th>
                                        <th class="text-center">PVP</th>
                                        <th class="text-center">DTO %</th>
                                        <th class="text-center">IMPORTE</th>
                                        <th class="text-center">IVA %</th>
                                        <th class="text-center">RECIBIDO</th>
                                        <th class="text-center">F. RECEPCION</th>
                                        <th class="text-center">F.ENTREGA</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>';
                                
                        
                        
                            $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                            include_once($pathraiz."/connection.php");
                            $db = new dbObj();
                            $connString =  $db->getConnstring();
                            
                            /****************************************************************************************************************/
                            // ########################################## / MATERIAL AGRUPADO / ########################################### //
                            /****************************************************************************************************************/
                            $contador1 = "";
                            $contador2 = "";
                            $htmlGrupos = "";
                            $arrayDetallesEnGrupo = [""];
                            $contador = 0;
                            // Para saber cuantos grupos tiene el proyecto
                            $sqlGrupo="SELECT 
                                            MATERIALES_GRUPOS.grupos_nombres_id, MATERIALES_STOCK.proyecto_id
                                            FROM MATERIALES_GRUPOS 
                                            INNER JOIN MATERIALES_STOCK
                                            ON MATERIALES_STOCK.pedido_detalle_id=MATERIALES_GRUPOS.pedido_detalle_id
                                            WHERE MATERIALES_STOCK.proyecto_id= ".$_POST['id']."
                                            GROUP BY MATERIALES_GRUPOS.grupos_nombres_id, MATERIALES_STOCK.proyecto_id";
                            //file_put_contents("materialAgrupadoProyecto.txt", $sqlGrupo);
                            $resGrupo = mysqli_query($connString, $sqlGrupo) or die("Error select materiales grupos.");
                            $row_cntGrupo = mysqli_num_rows($resGrupo);
                            
                            if($row_cntGrupo!=0){
                                $htmlGrupos .= "<tr>
                                                <td class='text-left' style='background-color: #124350; color: #ffffff;' colspan='14'><strong>MATERIAL AGRUPADO:</strong></td>
                                          </tr>";
                                
                                while($rowGrupos = mysqli_fetch_array($resGrupo)){
                                    // Para coger nombre e id //
                                    $sql = "SELECT 
                                                MATERIALES_GRUPOS_NOMBRES.id, 
                                                MATERIALES_GRUPOS_NOMBRES.nombre,
                                                MATERIALES_GRUPOS_NOMBRES.descripcion,
						MATERIALES_STOCK.ubicacion_id,
                                                MATERIALES_STOCK.proyecto_id,
                                                MATERIALES_STOCK.pedido_detalle_id
                                            FROM MATERIALES_GRUPOS_NOMBRES
                                                INNER JOIN MATERIALES_GRUPOS
                                            ON MATERIALES_GRUPOS_NOMBRES.id=MATERIALES_GRUPOS.grupos_nombres_id
                                                INNER JOIN MATERIALES_STOCK
                                            ON MATERIALES_GRUPOS.pedido_detalle_id=MATERIALES_STOCK.pedido_detalle_id
                                                WHERE MATERIALES_GRUPOS_NOMBRES.id=".$rowGrupos[0]."
                                            ORDER BY
                                                MATERIALES_STOCK.ubicacion_id ASC LIMIT 1";
                                    //file_put_contents("prearray3.txt", $sql);
                                    $res = mysqli_query($connString, $sql) or die("Error select Pre-Array 3!");
                                    
                                    $iva = 0;
                                    $pedidoGroup = "";
                                    
                                    while( $rowGrupo = mysqli_fetch_array($res) ) {
                                        if($rowGrupo[3]==0){
                                            $checkAddHabilitado = "disabled";
                                            $botonBorrar='';
                                        }else{
                                            $checkAddHabilitado = "";
                                            $botonBorrar='<button disabled type="button" value="'.$rowGrupos[0].'" class="btn btn-circle btn-danger remove-group-alm-pro" data-id="'.$rowGrupos[0].'" title="Eliminar Grupo (Por el momento solo se puede eliminar desde Entregas)"><img src="/erp/img/cross.png"></button>';
                                        }
                                        
                                        $sqlSelEntregas="SELECT ENTREGAS.id FROM ENTREGAS WHERE ENTREGAS.grupos_nombres_id=".$rowGrupo[0];
                                        $resEntregas = mysqli_query($connString, $sqlSelEntregas) or die("Error select ENTREGAS ID!");
                                        $rowEntregas = mysqli_fetch_array($resEntregas);
                                        
                                        $gotoentrega='<button type="button" value="'.$rowEntregas[0].'" class="btn btn-info btn-circle goto-entrega" data-id="'.$rowEntregas[0].'" title="Ir a la entrega del grupo"><img src="/erp/img/link-w.png" style="height:20px;"></button>';
                                        $checkAdd="<input disabled type='checkbox' ".$checkAddHabilitado." class='grup-pos-to-project' data-matid='".$row[18]."' value='".$row[18]."' name='posiciones[".$contador."][grup-pos-to-project]' ".$habilitado.">
                                                   <input type='hidden' name='posiciones[".$contador."][pos_mat_grup]' value='".$rowGrupos[0]."'>";
                                        $htmlGrupos .= "<tr data-idgrp=".$rowGrupo[0].">
                                                <td class='text-left' style='background-color: #219ae0; color: #ffffff;' colspan='12'>".$checkAdd." ".$gotoentrega." <strong>NOMBRE DEL GRUPO:</strong> ".$rowGrupo[1]." </td>
                                                <td class='text-left' style='background-color: #219ae0; color: #ffffff;' colspan='2'>".$botonBorrar."</td>
                                             </tr>";
                                        // Sacar detalles id de cada linea //
                                        $sqlDetallesGrupo="SELECT 
                                                MATERIALES_GRUPOS.id, 
                                                MATERIALES_GRUPOS.materiales_stock_id,
                                                MATERIALES_GRUPOS.pedido_detalle_id, 
                                                MATERIALES_GRUPOS.grupos_nombres_id, 
                                                MATERIALES_STOCK.proyecto_id
                                            FROM 
                                                MATERIALES_GRUPOS 
                                            INNER JOIN MATERIALES_STOCK ON
                                                MATERIALES_STOCK.pedido_detalle_id = MATERIALES_GRUPOS.pedido_detalle_id
                                            WHERE
                                                MATERIALES_STOCK.proyecto_id=".$rowGrupos[1]."
                                            AND
                                                MATERIALES_GRUPOS.grupos_nombres_id=".$rowGrupos[0];
                                        //file_put_contents("array3.txt", $sqlDetallesGrupo);
                                        $resDetallesGrupo = mysqli_query($connString, $sqlDetallesGrupo) or die("Error select Array 3!");
                                        
                                        //$row_cnt_DetGrup = mysqli_num_rows($resDetallesGrupo);
                                        $contador1.=$rowDetalleGrupo[3]." ";
                                        while($rowDetallesGrupo = mysqli_fetch_array($resDetallesGrupo)){
                                    // Select de datos de cada detalle para pintar
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
                                        PEDIDOS_PROV.plazo,
                                        PEDIDOS_PROV_DETALLES.material_id,
                                        MATERIALES_STOCK.stock,
                                        MATERIALES_STOCK.id
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
                                    INNER JOIN MATERIALES_STOCK 
                                        ON PEDIDOS_PROV_DETALLES.id = MATERIALES_STOCK.pedido_detalle_id
                                    WHERE
                                        PEDIDOS_PROV_DETALLES.id = ".$rowDetallesGrupo[2]." 
                                    AND
					MATERIALES_STOCK.ID = ".$rowDetallesGrupo[1]."
                                    ORDER BY 
                                        PEDIDOS_PROV.pedido_genelek ASC, PEDIDOS_PROV_DETALLES.id ASC";

                                //file_put_contents("array3Post.txt", $sql);
                                $res = mysqli_query($connString, $sql) or die("Error Post Array 3");
                                
                                
                                $iva = 0;
                            $pedidoGroup = "";
                            //$contador = 0;
                            while( $row = mysqli_fetch_array($res) ) {                                
                                $contador2.=$row[0]. " ";
                                if ($row[5] != "") {
                                    $pvp = $row[5];
                                }
                                else {
                                    $pvp = $row[9];
                                }

                                $dto_sum = 0;
                                $pvp_dto = 0;
                                $dto_extra = "";
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
                                $subtotal = ($pvp*$row[33]);
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
                                    if($row[6] == 1){
                                        $trcolor = "background-color: #b7fca4;";
                                        $habilitado = "";
                                        $botonEnviado ="";
                                    }elseif($row[6] == 2){
                                        $trcolor = "background-color: #ffce89;";
                                        $habilitado = "disabled";
                                        // Generar Boton cuando hay una devolución!
                                        $sqlSelEnvId="SELECT
                                                        ENVIOS_CLI_DETALLES.envio_id
                                                      FROM ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI_DETALLES.pedido_detalle_id=".$row[0];
                                        //file_put_contents("selectEnvioID.txt", $sqlSelEnvId);
                                        $resSel = mysqli_query($connString, $sqlSelEnvId) or die("Error al reealizar sleect de los pedidos detalles.");
                                        $regEnvId = mysqli_fetch_array($resSel);
                                        $botonEnviado="<button type='button' class='btn-default view-envio' data-id='".$regEnvId[0]."' title='Ver Devolución'><img src='/erp/img/proveedores.png' style='height: 20px;'></button>";
                                    }elseif($row[6] == 3){
                                        $trcolor = "background-color: #70a561;";
                                        $habilitado = "disabled";
                                        $botonEnviado ="";
                                    }
                                }
                                else {
                                    $disableButton = " ";
                                    $trcolor = "";
                                    $habilitado = "";
                                }
                                // Ver si el id del MAT_STOCK existe y pintar diferente
                                $sqlMaterial ="SELECT MATERIALES_STOCK.id
                                                FROM PEDIDOS_PROV_DETALLES
                                                INNER JOIN MATERIALES_STOCK 
                                                ON PEDIDOS_PROV_DETALLES.id=MATERIALES_STOCK.pedido_detalle_id
                                                WHERE PEDIDOS_PROV_DETALLES.id =".$row[0]."
                                                AND MATERIALES_STOCK.ubicacion_id=0
                                                AND MATERIALES_STOCK.id=".$row[34];
                                //file_put_contents("log.txt", $sqlMaterial);
                                $resMat = mysqli_query($connString, $sqlMaterial);
                                $rowMat = mysqli_fetch_array($resMat);
                                if($row[34]==$rowMat[0]){
                                    $disableButton = " disabled ";
                                    $trcolor = "background-color: #70a561;";
                                    // Deshabilitar check
                                    $habilitado = "disabled";
                                    $botonBorrarM = "";
                                }else{
                                    $botonBorrarM='<button type="button" value="'.$rowDetallesGrupo[0].'" class="btn btn-circle btn-danger remove-groupmat-alm-pro" data-id="1" title="Eliminar material del Grupo"><img src="/erp/img/cross.png"></button>';
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
                                
                                if ($row[29] != "") {
                                    $dtoprovid = $row[29];
                                }
                                else {
                                    $dtoprovid = 0;
                                }
                                    
                                    array_push($arrayDetallesEnGrupo, $row [0]);
                                            
                                        $htmlGrupos .= "
                                                <tr data-id='".$row[0]."' style='".$trcolor."'>
                                                    <td class='text-center'><!--
                                                        <input type='checkbox' class='pos-to-project' data-matid='".$row[18]."' value='".$row[18]."' name='posiciones[".$contador."][pos-to-project]' disabled>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_unidades]' value='".$row[33]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_tarifa_id]' value='".$row[28]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_dto_prov_id]' value='".$dtoprovid."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_dto_prov_activo]' value='".$row[11]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_dto_mat_activo]' value='".$row[12]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_dto_ad_activo]' value='".$row[13]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_prov_detalle_id]' value='".$row[0]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_mat_stock_id]' value='".$row[34]."'>-->
                                                    </td>
                                                    <td class='text-left'>".$ref."</td>
                                                    <td class='text-left'>".$material."</td>
                                                    <td class='text-center'>".$row[3]."</td>
                                                    <td class='text-center'>".$row[33]."</td>
                                                    <td class='text-right'>".$pvp."</td>
                                                    <td class='text-right'>".number_format($dto_sum, 2).$dto_extra."</td>
                                                    <td class='text-right'>".number_format($subtotalDtoApli, 2)."</td>
                                                    <td class='text-right'>".$ivaPercent."</td>
                                                    <td class='text-center'>".$recibidoDet."</td>
                                                    <td class='text-center'>".$row[7]."</td>
                                                    <td class='text-center'>".$row[16]."</td>
                                                    <td class='text-center'>".$botonBorrarM."</td>
                                                </tr>";
                                        $importe = $importe+$subtotal;
                                        $totaldto = $totaldto + $dto + $dtoNeto;
                                        $iva = $iva + (($subtotal-($dto + $dtoNeto))*$ivaPercent/100);
                                        $contador = $contador + 1;
                                        
                                    }
                                    }
                                    }
                                }
                            }
                            //file_put_contents("contadores.txt", $contador1."|".$contador2);
                            // / ############################## MATERIAL AGRUPADO                             
                            
                            /****************************************************************************************************************/
                            /////////////////////////////////////// MATERIAL ASIGNADO AL PROYECTO ////////////////////////////////////////////
                            /****************************************************************************************************************/
                            
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
                                        PEDIDOS_PROV.plazo,
                                        PEDIDOS_PROV_DETALLES.material_id
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
                                    WHERE
                                        PEDIDOS_PROV_DETALLES.proyecto_id = " . $_POST['id'] . " 
                                    ORDER BY 
                                        PEDIDOS_PROV.pedido_genelek ASC, PEDIDOS_PROV_DETALLES.id ASC";

                            //file_put_contents("array.txt", $sql);
                            $res = mysqli_query($connString, $sql) or die("Error al realizar select de Material asignado a proyecto");

                            $iva = 0;
                            $pedidoGroup = "";
                            while( $row = mysqli_fetch_array($res) ) {
                                
                                // Comprobación si se ha añadido en un grupo y no pintar si es asi
                                $existe=false;
                                for($i=0; $i<count($arrayDetallesEnGrupo); $i++){
                                    if($arrayDetallesEnGrupo[$i]==$row[0]){
                                        $existe=true;
                                    }
                                }
                                
                                $fecha_entrega = strtotime($row[16]);
                                $fecha_entrega = date("Y-m-d", $fecha_entrega);
                                if ((date("Y-m-d") > $fecha_entrega) && (($row[30] < 4) || ($row[30] > 7)) && ($row[16] != "0000-00-00")) {
                                    $fecha_entrega = $row[16]."<span class='blink_me' title='Pedido Retrasado'><img src='/erp/img/warning-test.png'></span>";
                                }
                                else {
                                    $fecha_entrega = $row[16];
                                }
                                if ($pedidoGroup != $row[25] && $existe==false) {
                                    //insertamos cabecera del siguiente grupo
                                    $pedidoGroup = $row[25];
                                    $tohtml.= "<tr>
                                                <td class='text-left' style='background-color: #219ae0; color: #ffffff;' colspan='14'><strong>REF:</strong> ".$pedidoGroup." <strong>Fecha:</strong> ".$row[26]." <strong>Plazo:</strong> ".$row[31]." <strong>Fecha estimada de Entrega:</strong> ".$fecha_entrega." </td>
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
                                $dto_extra = "";
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
                                    
                                    if($row[6] == 1){
                                        $trcolor = "background-color: #b7fca4;";
                                        $habilitado = "";
                                        
                                        $sqlMaterial ="
                                                SELECT PEDIDOS_PROV_DETALLES.id
                                                FROM PEDIDOS_PROV_DETALLES
                                                INNER JOIN MATERIALES_STOCK 
                                                ON PEDIDOS_PROV_DETALLES.id=MATERIALES_STOCK.pedido_detalle_id
                                                WHERE PEDIDOS_PROV_DETALLES.id =".$row[0]."
                                                AND MATERIALES_STOCK.ubicacion_id=0";
                                        //file_put_contents("log.txt", $sqlMaterial);
                                        $resMat = mysqli_query($connString, $sqlMaterial);
                                        $rowMat = mysqli_fetch_array($resMat);
                                        if($row[0]==$rowMat[0]){
                                            $disableButton = " disabled ";
                                            $trcolor = "background-color: #70a561;";
                                            // Deshabiitar check
                                            $habilitado = "disabled";
                                        }
                                        $botonEnviado ="";
                                    }elseif($row[6] == 2){
                                        $trcolor = "background-color: #ffce89;";
                                        $habilitado = "disabled";
                                        // Generar Boton cuando hay una devolución!
                                        $sqlSelEnvId="SELECT
                                                        ENVIOS_CLI_DETALLES.envio_id
                                                      FROM ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI_DETALLES.pedido_detalle_id=".$row[0];
                                        //file_put_contents("selectEnvioID.txt", $sqlSelEnvId);
                                        $resSel = mysqli_query($connString, $sqlSelEnvId) or die("Error al reealizar sleect de los pedidos detalles.");
                                        $regEnvId = mysqli_fetch_array($resSel);
                                        $botonEnviado="<button type='button' class='btn-default view-envio' data-id='".$regEnvId[0]."' title='Ver Devolución'><img src='/erp/img/proveedores.png' style='height: 20px;'></button>";
                                    }elseif($row[6] == 3){
                                        $trcolor = "background-color: #70a561;";
                                        $habilitado = "disabled";
                                        $botonEnviado ="";
                                    }
                                    
                                }else{
                                    $disableButton = " ";
                                    $trcolor = "";
                                    $habilitado = "disabled";
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
                                
                                if ($row[29] != "") {
                                    $dtoprovid = $row[29];
                                }
                                else {
                                    $dtoprovid = 0;
                                }
                                if( ($row[4]>1) && ($habilitado!="disabled")){
                                    $unidades='<button class="btn_divi_material_asignado" type="button" style="border-color: grey; '.$trcolor.'">'.$row[4].'</button>';
                                }else{
                                    $unidades=$row[4];
                                }
                                

                                if($existe==false){
                                    $tohtml.= "
                                        <tr data-id='".$row[0]."' style='".$trcolor."'>
                                            <td class='text-center'>
                                                <input type='checkbox' class='pos-to-project' data-matid='".$row[18]."' value='".$row[18]."' name='posiciones[".$contador."][pos-to-project]' ".$habilitado.">
                                                <input type='hidden' name='posiciones[".$contador."][pos_unidades]' value='".$row[4]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_tarifa_id]' value='".$row[28]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_dto_prov_id]' value='".$dtoprovid."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_dto_prov_activo]' value='".$row[11]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_dto_mat_activo]' value='".$row[12]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_dto_ad_activo]' value='".$row[13]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_prov_detalle_id]' value='".$row[0]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_mat_stock_id]' value='".$row[34]."'>
                                            </td>
                                            <td class='text-left'>".$ref."</td>
                                            <td class='text-left'>".$material."</td>
                                            <td class='text-center'>".$row[3]."</td>
                                            <td class='text-center'>".$unidades."</td>
                                            <td class='text-right'>".$pvp."</td>
                                            <td class='text-right'>".number_format($dto_sum, 2).$dto_extra."</td>
                                            <td class='text-right'>".number_format($subtotalDtoApli, 2)."</td>
                                            <td class='text-right'>".$ivaPercent."</td>
                                            <td class='text-center'>".$recibidoDet."</td>
                                            <td class='text-center'>".$row[7]."</td>
                                            <td class='text-center'>".$row[16]."</td>
                                            <td class='text-center'>".$botonEnviado."</td>
                                        </tr>";      
                                    $importe = $importe+$subtotal;
                                    $totaldto = $totaldto + $dto + $dtoNeto;
                                    $iva = $iva + (($subtotal-($dto + $dtoNeto))*$ivaPercent/100);
                                    $contador = $contador + 1;
                                }
                            }
                            
                            //$iva = (($importe-$totaldto)*21)/100;
                            $totalPVP = ($importe-$totaldto);
                            $total = ($importe-$totaldto) + $iva;
                            
                            // / //////////////////////////////// MATERIAL ASIGNADO AL PROYECTO
                            
                            /****************************************************************************************************************/
                            ////////////////////////////////////// MATERIAL AÑADIDO DESDE ALMACEN ////////////////////////////////////////////
                            /****************************************************************************************************************/
                            // Materiales añadidos desde el almacen
                            $sqlDet = "SELECT MATERIALES_STOCK.id,
                                            MATERIALES_STOCK.material_id,
                                            MATERIALES_STOCK.stock,
                                            MATERIALES_STOCK.ubicacion_id,
                                            MATERIALES_STOCK.proyecto_id,
                                            MATERIALES_STOCK.pedido_detalle_id
                                        FROM MATERIALES_STOCK
                                            INNER JOIN PEDIDOS_PROV_DETALLES
                                        ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                                        WHERE MATERIALES_STOCK.proyecto_id=".$_POST['id']."
                                        AND PEDIDOS_PROV_DETALLES.proyecto_id=11";
                            //file_put_contents("materialesDelAmacenReservados.txt", $sqlDet);
                            $resDet = mysqli_query($connString, $sqlDet) or die("Error al realizar la select desde Material Añadido desde Almacen");
                            $row_cnt = mysqli_num_rows($resDet);
                            if($row_cnt!=0){
                                $tohtml.= "<tr>
                                                <td class='text-left' style='background-color: #124350; color: #ffffff;' colspan='14'><strong>MATERIAL COGIDO DESDE ALMACEN:</strong></td>
                                          </tr>";
                                
                                while($rowDet = mysqli_fetch_array($resDet)){
                                    // SELECT cada uno para pintar
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
                                        PEDIDOS_PROV.plazo,
                                        PEDIDOS_PROV_DETALLES.material_id,
                                        MATERIALES_STOCK.stock,
                                        MATERIALES_STOCK.id
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
                                    INNER JOIN MATERIALES_STOCK 
                                        ON PEDIDOS_PROV_DETALLES.id = MATERIALES_STOCK.pedido_detalle_id
                                    WHERE
                                        PEDIDOS_PROV_DETALLES.id = ".$rowDet[5]." 
                                    AND
					MATERIALES_STOCK.ID = ".$rowDet[0]."
                                    ORDER BY 
                                        PEDIDOS_PROV.pedido_genelek ASC, PEDIDOS_PROV_DETALLES.id ASC";

                                //file_put_contents("array3.txt", $sql);
                                $res = mysqli_query($connString, $sql) or die("Error al realizar la select desde Material Añadido desde Almacen 2");
                                
                                
                                $iva = 0;
                            $pedidoGroup = "";
                            //$contador = 0;
                            while( $row = mysqli_fetch_array($res) ) {  
                                
                                // Comprobación si se ha añadido en un grupo y no pintar si es asi
                                $existe=false;
                                for($i=0; $i<count($arrayDetallesEnGrupo); $i++){
                                    if($arrayDetallesEnGrupo[$i]==$row[0]){
                                        $existe=true;
                                    }
                                }
                                
                                $fecha_entrega = strtotime($row[16]);
                                $fecha_entrega = date("Y-m-d", $fecha_entrega);
                                if ((date("Y-m-d") > $fecha_entrega) && (($row[30] < 4) || ($row[30] > 7)) && ($row[16] != "0000-00-00")) {
                                    $fecha_entrega = $row[16]."<span class='blink_me' title='Pedido Retrasado'><img src='/erp/img/warning-test.png'></span>";
                                }
                                else {
                                    $fecha_entrega = $row[16];
                                }
                                if ($pedidoGroup != $row[25] && $existe==false) {
                                    //insertamos cabecera del siguiente grupo
                                    $pedidoGroup = $row[25];
                                    $tohtml.= "<tr>
                                                <td class='text-left' style='background-color: #219ae0; color: #ffffff;' colspan='14'><strong>REF:</strong> ".$pedidoGroup." <strong>Fecha:</strong> ".$row[26]." <strong>Plazo:</strong> ".$row[31]." <strong>Fecha estimada de Entrega:</strong> ".$fecha_entrega." </td>
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
                                $dto_extra = "";
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
                                $subtotal = ($pvp*$row[33]);
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
                                    if($row[6] == 1){
                                        $trcolor = "background-color: #b7fca4;";
                                        $habilitado = "";
                                        $botonEnviado ="";
                                    }elseif($row[6] == 2){
                                        $trcolor = "background-color: #ffce89;";
                                        $habilitado = "disabled";
                                        // Generar Boton cuando hay una devolución!
                                        $sqlSelEnvId="SELECT
                                                        ENVIOS_CLI_DETALLES.envio_id
                                                      FROM ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI_DETALLES.pedido_detalle_id=".$row[0];
                                        //file_put_contents("selectEnvioID.txt", $sqlSelEnvId);
                                        $resSel = mysqli_query($connString, $sqlSelEnvId) or die("Error al reealizar sleect de los pedidos detalles.");
                                        $regEnvId = mysqli_fetch_array($resSel);
                                        $botonEnviado="<button type='button' class='btn-default view-envio' data-id='".$regEnvId[0]."' title='Ver Devolución'><img src='/erp/img/proveedores.png' style='height: 20px;'></button>";
                                    }elseif($row[6] == 3){
                                        $trcolor = "background-color: #70a561;";
                                        $habilitado = "disabled";
                                        $botonEnviado ="";
                                    }
                                    
                                }
                                else {
                                    $disableButton = " ";
                                    $trcolor = "";
                                    $habilitado = "";
                                }
                                // Ver si el id del MAT_STOCK existe y pintar diferente
                                $sqlMaterial ="SELECT MATERIALES_STOCK.id
                                                FROM PEDIDOS_PROV_DETALLES
                                                INNER JOIN MATERIALES_STOCK 
                                                ON PEDIDOS_PROV_DETALLES.id=MATERIALES_STOCK.pedido_detalle_id
                                                WHERE PEDIDOS_PROV_DETALLES.id =".$row[0]."
                                                AND MATERIALES_STOCK.ubicacion_id=0
                                                AND MATERIALES_STOCK.id=".$row[34];
                                //file_put_contents("log.txt", $sqlMaterial);
                                $resMat = mysqli_query($connString, $sqlMaterial);
                                $rowMat = mysqli_fetch_array($resMat);
                                if($row[34]==$rowMat[0]){
                                    $disableButton = " disabled ";
                                    $trcolor = "background-color: #70a561;";
                                    // Deshabiitar check
                                    $habilitado = "disabled";
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
                                
                                if ($row[29] != "") {
                                    $dtoprovid = $row[29];
                                }
                                else {
                                    $dtoprovid = 0;
                                }
                                $botonBorrar='<button '.$habilitado.' type="button" class="btn btn-circle btn-danger remove-material-alm-pro" data-id="1" title="Eliminar Material Cogido desde almacen"><img src="/erp/img/cross.png"></button>';
                                if($existe==false){
                                $tohtml.= "
                                        <tr data-id='".$row[0]."' style='".$trcolor."'>
                                            <td class='text-center'>
                                                <input type='checkbox' class='pos-to-project' data-matid='".$row[18]."' value='".$row[18]."' name='posiciones[".$contador."][pos-to-project]' ".$habilitado.">
                                                <input type='hidden' name='posiciones[".$contador."][pos_unidades]' value='".$row[33]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_tarifa_id]' value='".$row[28]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_dto_prov_id]' value='".$dtoprovid."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_dto_prov_activo]' value='".$row[11]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_dto_mat_activo]' value='".$row[12]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_dto_ad_activo]' value='".$row[13]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_prov_detalle_id]' value='".$row[0]."'>
                                                <input type='hidden' name='posiciones[".$contador."][pos_mat_stock_id]' value='".$row[34]."'>
                                            </td>
                                            <td class='text-left'>".$ref."</td>
                                            <td class='text-left'>".$material."</td>
                                            <td class='text-center'>".$row[3]."</td>
                                            <td class='text-center'>".$row[33]."</td>
                                            <td class='text-right'>".$pvp."</td>
                                            <td class='text-right'>".number_format($dto_sum, 2).$dto_extra."</td>
                                            <td class='text-right'>".number_format($subtotalDtoApli, 2)."</td>
                                            <td class='text-right'>".$ivaPercent."</td>
                                            <td class='text-center'>".$recibidoDet."</td>
                                            <td class='text-center'>".$row[7]."</td>
                                            <td class='text-center'>".$row[16]."</td>
                                            <td class='text-center'>".$botonBorrar.$botonEnviado."</td>
                                        </tr>";
                                $importe = $importe+$subtotal;
                                $totaldto = $totaldto + $dto + $dtoNeto;
                                $iva = $iva + (($subtotal-($dto + $dtoNeto))*$ivaPercent/100);
                                $contador = $contador + 1;
                                }
                            }
                            
                            //$iva = (($importe-$totaldto)*21)/100;
                            $totalPVP = ($importe-$totaldto);
                            $total = ($importe-$totaldto) + $iva;  
                            }
                            }
                            
                            // / //////////////////////////////// MATERIAL AÑADIDO  DESDE ALMACEN
                            
                            // PRINT MATERIAL AGRUPADO 
                            $tohtml.= $htmlGrupos;
                            // / PRINT MATERIAL AGRUPADO 
                            $tohtml.='</tbody>';
                            echo $tohtml;
                        ?>
                                    
    
    
    
    