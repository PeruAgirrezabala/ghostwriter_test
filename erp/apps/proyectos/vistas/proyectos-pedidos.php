<!-- pedidos del proyecto -->

<table class="table table-striped table-hover" id='tabla-pedidos-proyecto'>
    <input type="hidden" id="to_project" name="to_project">
    <input type="hidden" id="to_project2" name="to_project2">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">A</th>
            <th>REF</th>
            <th>TITULO</th>
            <th class="text-center">PROV</th>
            <th class="text-center">FECHA</th>
            <th class="text-center">ESTADO</th>
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
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.pedido_genelek,
                    PEDIDOS_PROV.titulo,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV_ESTADOS.color,
                    PEDIDOS_PROV_ESTADOS.id,
                    PEDIDOS_PROV.fecha_prog
                FROM 
					PEDIDOS_PROV
				INNER JOIN PEDIDOS_PROV_DETALLES 
					ON PEDIDOS_PROV_DETALLES .pedido_id = PEDIDOS_PROV.id
				INNER JOIN PROVEEDORES
					ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id
				INNER JOIN PEDIDOS_PROV_ESTADOS
					ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                WHERE (
                        PEDIDOS_PROV.proyecto_id = ".$_GET['id']."
                    OR
                        PEDIDOS_PROV_DETALLES .proyecto_id = ".$_GET['id']."
                    )
		GROUP BY PEDIDOS_PROV.id
                ORDER BY 
                    PEDIDOS_PROV.fecha DESC";
        //file_put_contents("queryPedidos.txt", $sql);

        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Pedidos");
        $log="";
        while ($registros = mysqli_fetch_array($resultado)) {
            $pedido_id = $registros[0];
            $refPedido = $registros[1];
            $tituloPedido = $registros[2];
            $proveedorPedido = $registros[3];
            $fechaPedido = $registros[4];
            $estadoPedido = $registros[5];
            $totalPedido = $registros[6];
            $estadoPedidoColor = $registros[7];
            $estadoId = $registros[8];
            $fechaProg = $registros[9];
            
            $refPedido; // Pedido_Genelek
            //$log.=$refPedido;
            $sqlPedidoUtilizado = "SELECT PEDIDOS_PROV.pedido_genelek
                                    FROM PROYECTOS_MATERIALES
                                    INNER JOIN PEDIDOS_PROV_DETALLES ON PROYECTOS_MATERIALES.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                                    INNER JOIN PEDIDOS_PROV ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
                                    WHERE PROYECTOS_MATERIALES.proyecto_id =".$_GET['id'];
            //file_put_contents("selectUtilizados.txt", $sqlPedidoUtilizado);
            $resPedUtilizado = mysqli_query($connString, $sqlPedidoUtilizado) or die("Error al ejecutar la consulta de Pedidos");
            $row_cnt_ped = mysqli_num_rows($resPedUtilizado);
            $count=0;
            if($estadoId==7){ // Si el estado es Programado coger fecha diferente
                $fecha=$fechaProg;
            }else{
                $fecha=$fechaPedido;
            }
            
            while ($regPedUtilizado = mysqli_fetch_array($resPedUtilizado)) {
                $count++;
                //$log.=$regPedUtilizado[0];
                if($refPedido==$regPedUtilizado[0]){
                    echo "<tr data-id='".$pedido_id."' class='oferta'>
                        <td class='text-center'><input type='checkbox' class='to-project' data-pedidoid='".$pedido_id."' disabled title='No se puede Añadir. Algun detalle ya añadido'></td>
                        <td>".$refPedido."</td>
                        <td>".$tituloPedido."</td>
                        <td>".$proveedorPedido."</td>
                        <td class='text-center'>".$fecha."</td>
                        <td class='text-center'><span class='label label-".$estadoPedidoColor."'>".$estadoPedido."</span></td>
                    </tr>";
                    break;
                }else{
                    if($row_cnt_ped==$count){
                        echo "<tr data-id='".$pedido_id."' class='oferta'>
                            <td class='text-center'><input type='checkbox' class='to-project' data-pedidoid='".$pedido_id."'></td>
                            <td>".$refPedido."</td>
                            <td>".$tituloPedido."</td>
                            <td>".$proveedorPedido."</td>
                            <td class='text-center'>".$fecha."</td>
                            <td class='text-center'><span class='label label-".$estadoPedidoColor."'>".$estadoPedido."</span></td>
                        </tr>";
                        break;
                    }                    
                }
            }
            if($count==0){
                echo "<tr data-id='".$pedido_id."' class='oferta'>
                        <td class='text-center'><input type='checkbox' class='to-project' data-pedidoid='".$pedido_id."'></td>
                        <td>".$refPedido."</td>
                        <td>".$tituloPedido."</td>
                        <td>".$proveedorPedido."</td>
                        <td class='text-center'>".$fecha."</td>
                        <td class='text-center'><span class='label label-".$estadoPedidoColor."'>".$estadoPedido."</span></td>
                     </tr>";
            }
            //$log.="...";
            /*
            echo "<tr data-id='".$pedido_id."' class='oferta'>
                <td class='text-center'><input type='checkbox' class='to-project' data-pedidoid='".$pedido_id."'></td>
                <td>".$refPedido."</td>
                <td>".$tituloPedido."</td>
                <td>".$proveedorPedido."</td>
                <td class='text-center'>".$fechaPedido."</td>
                <td class='text-center'><span class='label label-".$estadoPedidoColor."'>".$estadoPedido."</span></td>
            </tr>";
            */
        }
         
        // Materiales añadidos desde el almacen
        $sqlDet = "SELECT MATERIALES_STOCK.id,
                    MATERIALES_STOCK.material_id,
                    MATERIALES_STOCK.stock,
                    MATERIALES_STOCK.ubicacion_id,
                    MATERIALES_STOCK.proyecto_id,
                    MATERIALES_STOCK.pedido_detalle_id,
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.pedido_genelek,
                    PEDIDOS_PROV.titulo,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV_ESTADOS.color,
                    PEDIDOS_PROV_ESTADOS.id,
                    PEDIDOS_PROV.fecha_prog
                  FROM MATERIALES_STOCK
                    INNER JOIN PEDIDOS_PROV_DETALLES
                  ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
		    INNER JOIN PEDIDOS_PROV
		  ON PEDIDOS_PROV_DETALLES.pedido_id=PEDIDOS_PROV.id
                    INNER JOIN PROVEEDORES
                  ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id
                    INNER JOIN PEDIDOS_PROV_ESTADOS
		  ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                  WHERE MATERIALES_STOCK.proyecto_id=".$_GET['id']."
                  AND PEDIDOS_PROV_DETALLES.proyecto_id=11";
        //file_put_contents("materialesDelAmacenReservados.txt", $sqlDet);
        $resDet = mysqli_query($connString, $sqlDet) or die("database error:");
        $row_cnt = mysqli_num_rows($resDet);
        if($row_cnt!=0){
            echo "<tr data-id='' class='oferta'>
                    <td colspan='6' style='background-color:#7fb9d8;'><b>MATERIAL AÑADIDO DESDE ALMACÉN:</b></td>
                </tr>";
        }
        while ($registros = mysqli_fetch_array($resDet)) {
            $pedido_id = $registros[6];
            $refPedido = $registros[7];
            $tituloPedido = $registros[8];
            $proveedorPedido = $registros[9];
            $fechaPedido = $registros[10];
            $estadoPedido = $registros[11];
            $totalPedido = $registros[12];
            $estadoPedidoColor = $registros[13];
            $estadoId = $registros[14];
            $fechaProg = $registros[15];
            
            $refPedido; // Pedido_Genelek
            //$log.=$refPedido;
            $sqlPedidoUtilizado = "SELECT PEDIDOS_PROV.pedido_genelek
                                    FROM PROYECTOS_MATERIALES
                                    INNER JOIN PEDIDOS_PROV_DETALLES ON PROYECTOS_MATERIALES.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                                    INNER JOIN PEDIDOS_PROV ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
                                    WHERE PROYECTOS_MATERIALES.proyecto_id =".$_GET['id']." AND PEDIDOS_PROV_DETALLES.proyecto_id=11";
            //file_put_contents("selectUtilizados.txt", $sqlPedidoUtilizado);
            $resPedUtilizado = mysqli_query($connString, $sqlPedidoUtilizado) or die("Error al ejecutar la consulta de Pedidos");
            $row_cnt_ped = mysqli_num_rows($resPedUtilizado);
            $count=0;
            if($estadoId==7){ // Si el estado es Programado coger fecha diferente
                $fecha=$fechaProg;
            }else{
                $fecha=$fechaPedido;
            }            
            $tituloPedido="MATERIAL ALMACÉN / MATERIAL ADICIONAL"; // Reset de nombre de pedido para evitar confusiones
            while ($regPedUtilizado = mysqli_fetch_array($resPedUtilizado)) {
                $count++;
                //$log.=$regPedUtilizado[0];
                    echo "<tr data-id='".$pedido_id."' class='oferta'>
                        <td class='text-center'><input type='checkbox' class='to-project' data-pedidoid='".$pedido_id."' disabled title='No se puede Añadir. Mirar desde Posiciones'></td>
                        <td>".$refPedido."</td>
                        <td>".$tituloPedido."</td>
                        <td>".$proveedorPedido."</td>
                        <td class='text-center'>".$fecha."</td>
                        <td class='text-center'><span class='label label-".$estadoPedidoColor."'>".$estadoPedido."</span></td>
                    </tr>";               
            }
            if($count==0){
                echo "<tr data-id='".$pedido_id."' class='oferta'>
                        <td class='text-center'><input type='checkbox' class='to-project' data-pedidoid='".$pedido_id."' disabled title='No se puede Añadir. Mirar desde Posiciones'></td>
                        <td>".$refPedido."</td>
                        <td>".$tituloPedido."</td>
                        <td>".$proveedorPedido."</td>
                        <td class='text-center'>".$fecha."</td>
                        <td class='text-center'><span class='label label-".$estadoPedidoColor."'>".$estadoPedido."</span></td>
                     </tr>";
            }
        }
        
        //file_put_contents("log.txt", $log);
        $totalGanancia = $total - $totalPVPdto;
    ?>
    </tbody>
</table>

<!-- pedidos del proyecto -->

<div id="posiciones_view_model" class="modal fade">
    <div class="modal-dialog dialog_mediano">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">POSICIONES PEDIDAS PARA EL PROYECTO 
                    <button class="btn button" id="print_posiciones" title="Imprimir Posiciones"><img src="/erp/img/print.png" height="30"></button>&nbsp;
                    <button class="btn button" id="export_excel_materiales_proyecto" title="Exportar a excel"><img src="/erp/img/excel.png" height="30"></button>&nbsp;
                    <button class="btn button" id="refresh_posiciones" title="Refrescar Posiciones"><img src="/erp/img/refresh.png" height="30"></button>&nbsp;
                </h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_posiciones" enctype="multipart/form-data">
                        <input type="hidden" name="posiciones_proyecto_id" id="posiciones_proyecto_id" value="<? echo $_GET["id"]; ?>">
                        <input type="hidden" name="det_mat_pro_grup" id="det_mat_pro_grup" value="">
                        <input type="hidden" name="det_mat_pro_grup2" id="det_mat_pro_grup2" value="">
                        <div class="form-group" id="tabla-posiciones">
                            <table class="table table-striped table-condensed table-hover" id='tabla-posiciones-pedidos'>
                                <thead>
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
                                <tbody>
                                
                        
                        <?
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
                                            WHERE MATERIALES_STOCK.proyecto_id= ".$_GET['id']."
                                            GROUP BY MATERIALES_GRUPOS.grupos_nombres_id, MATERIALES_STOCK.proyecto_id";
                            //file_put_contents("materialAgrupadoProyecto.txt", $sqlGrupo);
                            $resGrupo = mysqli_query($connString, $sqlGrupo) or die("database error:");
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
                                        file_put_contents("selectEntrtegasID.txt", $sqlSelEntregas);
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
                                        file_put_contents("selectEnvioID.txt", $sqlSelEnvId);
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
                                        PEDIDOS_PROV_DETALLES.proyecto_id = " . $_GET['id'] . " 
                                    AND
                                        PEDIDOS_PROV.estado_id <> 4
                                    ORDER BY 
                                        PEDIDOS_PROV.pedido_genelek ASC, PEDIDOS_PROV_DETALLES.id ASC";

                            //file_put_contents("array.txt", $sql);
                            $res = mysqli_query($connString, $sql) or die("database error:");

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
                                    echo "<tr>
                                                <td class='text-left' style='background-color: #219ae0; color: #ffffff;' colspan='14'><strong>REF:</strong> ".$pedidoGroup." <strong>Fecha:</strong> ".$row[26]." <strong>Plazo:</strong> ".$row[31]." <strong>Fecha estimada de Entrega:</strong> ".$fecha_entrega." <strong>Proveedor:</strong> ".$row[27]." </td>
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
                                        file_put_contents("selectEnvioID.txt", $sqlSelEnvId);
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
                                    echo "
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
                                        WHERE MATERIALES_STOCK.proyecto_id=".$_GET['id']."
                                        AND PEDIDOS_PROV_DETALLES.proyecto_id=11";
                            file_put_contents("materialesDelAmacenReservados.txt", $sqlDet);
                            $resDet = mysqli_query($connString, $sqlDet) or die("database error:");
                            $row_cnt = mysqli_num_rows($resDet);
                            if($row_cnt!=0){
                                echo "<tr>
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

                                file_put_contents("array3.txt", $sql);
                                $res = mysqli_query($connString, $sql) or die("database error:");
                                
                                
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
                                    echo "<tr>
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
                                        file_put_contents("selectEnvioID.txt", $sqlSelEnvId);
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
                                echo "
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
                            echo $htmlGrupos;
                            // / PRINT MATERIAL AGRUPADO 
                            
                        ?>
                                    </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_posiciones" class="btn btn-info2">Realizar Envío</button>
                <button type="button" id="btn_devolver" class="btn btn-warning">Devolver</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <!--<button type="button" id="btn_agrupar" class="btn btn-info">Agrupar</button>-->
            </div>
        </div>
    </div>
</div>

<!-- Añadir desde el almacén -->
<div id="add_from_almacen_view_model" class="modal fade">
    <div class="modal-dialog dialog_mediano">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR MATERIAL DEL ALMACÉN AL PROYECTO</h4>
            </div>
            <div class="modal-body">
                <? include("vistas/filtros-material-almacen.php"); ?>
                <div class="contenedor-form" id="tabla_material_almacen">
                    <form method="post" id="frm_add_posiciones" enctype="multipart/form-data">
                        <input type="hidden" name="posiciones_proyecto_id" id="posiciones_proyecto_id" value="<? echo $_GET["id"]; ?>">

                        <div class="form-group" id="tabla-materiales">
                            <table class="table table-striped table-condensed table-hover" id='tabla-materiales-almacen'>
                                <thead>
                                    <tr class="bg-dark">
                                        <th class="text-center">S</th>
                                        <th class="text-center">REF</th>
                                        <th class="text-center">MATERIAL</th>
                                        <th class="text-center">FABRICANTE</th>
                                        <th class="text-center">MODELO</th>
                                        <th class="text-center">DESCUENTO</th>
                                        <th class="text-center">STOCK</th>
                                        <th class="text-center">PVP</th>
                                        <th class="text-center">CADUCIDAD</th>
                                        <th class="text-center">SUSTITUTO</th>
                                        <th class="text-center">D</th>
                                </thead>
                                <tbody>
                                
                        
                        <?
                            $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                            include_once($pathraiz."/connection.php");
                            $db = new dbObj();
                            $connString =  $db->getConnstring();
                            
                            $sql = "SELECT
                                        MATERIALES.id,
                                        MATERIALES.ref,
                                        MATERIALES.nombre,
                                        MATERIALES.fabricante,
                                        MATERIALES.modelo,
                                        MATERIALES.DTO2,
                                        MATERIALES_STOCK.stock,
                                        MATERIALES.cad,
                                        MATERIALES.sustituto,
                                        MATERIALES_STOCK.pedido_detalle_id,
                                        MATERIALES_STOCK.id
                                    FROM 
                                        MATERIALES, MATERIALES_STOCK
                                    WHERE
                                        MATERIALES.id=MATERIALES_STOCK.material_id
                                    AND
                                        MATERIALES_STOCK.ubicacion_id=1
                                    AND  
                                        MATERIALES_STOCK.proyecto_id=11";
                            $res = mysqli_query($connString, $sql) or die("database error:");
                            while( $row = mysqli_fetch_array($res) ) {
                                // SELECT MATERIALES_PRECIOS.pvp FROM MATERIALES_PRECIOS WHERE material_id = 3837 ORDER BY fecha_val DESC LIMIT 1
                            
                                $sql2 = "SELECT MATERIALES_PRECIOS.pvp, MATERIALES_PRECIOS.id FROM MATERIALES_PRECIOS WHERE MATERIALES_PRECIOS.material_id = ".$row[0]." ORDER BY fecha_val DESC LIMIT 1";
                                $res2 = mysqli_query($connString, $sql2) or die("database error:");
                                
                                //file_put_contents("stock.txt", $sql);
                                //$res = mysqli_query($connString, $sql) or die("database error:");
                                $contador=0;
                                    while( $row2 = mysqli_fetch_array($res2) ) {
                                        $contador++;
                                        // if count 1 no
                                        if($row[6]>1){
                                            $imgDividir='<img src="/erp/img/dividido.png" height="20" id="ver_dividir_pedido_almacen" title="Dividir Pedido del Almacén">';
                                        }else{
                                            $imgDividir='';
                                        }
                                        
                                        echo "
                                                <tr data-id='".$row[9]."' data-id2='".$row[10]."'>
                                                    <td class='text-center atributos-material'>
                                                        <input type='checkbox' class='pos-to-project' data-matid='".$row[0]."' value='".$row[0]."' name='posiciones[".$contador."][pos-to-project]'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_unidades]' value='".$row[6]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_tarifa_id]' value='".$row2[1]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_prov_detalle_id]' value='".$row[9]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_mat_stock_id]' value='".$row[10]."'>
                                                    </td>
                                                    <td class='text-left'>".$row[1]."</td>
                                                    <td class='text-left'>".$row[2]."</td>
                                                    <td class='text-center'>".$row[3]."</td>
                                                    <td class='text-center'>".$row[4]."</td>
                                                    <td class='text-right'>".$row[5]."%</td>
                                                    <td class='text-center'>".$row[6]."</td>
                                                    <td class='text-center'>".$row2[0]."</td>
                                                    <td class='text-center'>".$row[8]."</td>
                                                    <td class='text-center'>".$row[9]."</td>
                                                    <td class='text-center'>".$imgDividir."</td>
                                                </tr>";
                                    }
                            
                            }
                            
                        ?>
                                    </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_stock_from_almacen" class="btn btn-info">Agregar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Devolver Materiales -->
<div id="devolver_mat_view_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DEVOLVER MATERIALES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <h3>Nombre de la devolución: </h3>
                        <div class="col-xs-12">
                            <input type="text" class="form-control required" name="devolucion_nombre" id="devolucion_nombre" value="">
                        </div><!--
                        <h3>Ref / Albarán: </h3>
                        <div class="col-xs-12">
                            <input type="text" class="form-control required" name="devolucion_ref" id="devolucion_ref" value="">
                        </div>-->
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_devolver_ok" class="btn btn-warning">Devolver</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Agrupar Materiales -->
<div id="add_group_view_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AGRUPAR MATERIALES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <h3>Nombre del grupo: </h3>
                        <div class="col-xs-12">
                            <input type="text" class="form-control required" name="nom_materiales_grupo" id="nom_materiales_grupo" value="">
                        </div>
                        <div class="form-group">
                        <label class="labelBefore text-center">Se Creará un grupo que sera enviado a Entregas para realizar pruebas. ¿Estas seguro?</label>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_add_grupo" class="btn btn-info">Agrupar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar Delete Material Almacen--> 
<div id="confirm_del_mat_alm_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">BORRAR MATERIAL COGIDO DESDE ALMACEN</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_mat_alm" id="del_mat_alm" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>¿Estas seguro que quieres borrar el material?</p>
                        <p>Esta acción no borra el material, solo lo devuelve al almacen.</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_mat_alm" class="btn btn-danger">Borrar/Desasignar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar Delete Material Agrupado--> 
<div id="confirm_del_mat_grup_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">BORRAR GRUPO CREADO</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_mat_grup" id="del_mat_grup" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>Hay una entrega realcionada a este grupo, revisa por si acaso su estado.</p>
                        <p>¿Estas seguro que quieres borrar el grupo?</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_mat_grup" class="btn btn-danger">Borrar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar Delete Material1 Agrupado--> 
<div id="confirm_del_mat1_grup_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">BORRAR GRUPO CREADO</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_mat1_grup" id="del_mat1_grup" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>¿Estas seguro que quieres eliminar este material para el grupo?</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_mat1_grup" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Partir Material Asignado Al proyecto: En un POST??--> 
<div id="divi_mat_asignado_proyecto_model" class="modal fade">
    
</div>
<!-- Nombre para el Envío -->
<div id="add_envio_posiciones_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">REALIZAR ENVÍO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <h3>Nombre del Envío: </h3>
                    <div class="col-xs-12">
                        <input type="text" class="form-control required" name="nom_envio_posiciones" id="nom_envio_posiciones" value="">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore text-center">Se generará un envío de todo el material seleccionado y añadirá todo el material seleccionado al proyecto. ¿Estas seguro?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_envio_posiciones" data-id="" class="btn btn-info">Realizar envío</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>