<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                PROYECTOS.ref,
                PROYECTOS.nombre,
                PROYECTOS.descripcion,
                PROYECTOS.fecha_ini,
                PROYECTOS.fecha_entrega,
                PROYECTOS.fecha_fin,
                PROYECTOS.fecha_mod,
                PROYECTOS_ESTADOS.nombre, 
                CLIENTES.nombre, 
                CLIENTES.img,
                PROYECTOS_ESTADOS.color, 
                PROYECTOS_ESTADOS.id,
                CLIENTES.id,
                PROYECTOS.path, 
                TIPOS_PROYECTO.nombre,
                TIPOS_PROYECTO.id, 
                TIPOS_PROYECTO.color,
                PROYECTOS.proyecto_id,
                PROYECTOS.ubicacion,
                PROYECTOS.dir_instalacion,
                PROYECTOS.coordgps_instalacion,
                CLIENTES.direccion,
                CLIENTES.poblacion,
                CLIENTES.provincia,
                CLIENTES.telefono,
                CLIENTES.email,
                CLIENTES.cp
            FROM 
                PROYECTOS, CLIENTES, PROYECTOS_ESTADOS, TIPOS_PROYECTO  
            WHERE 
                PROYECTOS.cliente_id = CLIENTES.id
            AND 
                PROYECTOS.estado_id = PROYECTOS_ESTADOS.id
            AND 
                PROYECTOS.tipo_proyecto_id = TIPOS_PROYECTO.id
            AND
                PROYECTOS.id = ".$_GET['id'];
    
    file_put_contents("printProject.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar el Proyecto");
    $registros = mysqli_fetch_row($res);
    
    $ref = $registros[0];
    $nombre = $registros[1];
    $descripción = $registros[2];
    $fecha_ini = $registros[3];
    $fecha_entrega = $registros[4];
    $fecha_fin = $registros[5];
    $estado = $registros[7];
    $cliente = $registros[8];
    $clienteimg = $registros[9];
    $estadocolor = $registros[10];
    $tipoProyecto = $registros[14];
    $tipoProyectoColor = $registros[16];
    $ubicacion = $registros[18];
    $direccion = $registros[19];
    $gps = $registros[20];
    $cliDir = $registros[21];
    $cliPoblacion = $registros[22];
    $cliProvincia = $registros[23];
    $cliTlfno = $registros[24];
    $cliEmail = $registros[25];
    $cliCP = $registros[26];
    
    $path = date("Y",strtotime($fecha_ini))."\\".$nombre;
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <title>POSICIONES</title>
    
    <style>
        @font-face {
            font-family: SourceSansPro;
            src: url(/erp/includes/pdf/SourceSansPro-Regular.ttf);
          }

            .clearfix:after {
              content: "";
              display: table;
              clear: both;
            }

            a {
              color: #0087C3;
              text-decoration: none;
            }

            body {
              position: relative;
              width: 21cm;  
              height: 29.7cm; 
              margin: 0 auto; 
              color: #555555;
              background: #FFFFFF; 
              font-family: Arial, sans-serif; 
              font-size: 11px; 
              font-family: SourceSansPro;
            }

            #header {
              padding: 0px;
              margin-bottom: 20px;
              /*border-bottom: 1px solid #AAAAAA;*/
              /*max-width: 500px;*/
              /* height: 150px; */
              /* background-color: #219ae0; */
            }

            #ref {
                  position: relative;
                  float: left;
                  display: inline-block;
                  margin-top: 8px;
                  /*margin-right: 1%;*/
                  width: 37%;
                  min-height: 94px;
                  line-height: 94px;
                  font-size: 40px;
                  padding: 10px;
                  /*background-color: #219ae0;*/
                  text-align: center;
            }

            #ref img {
              width: 140px;
            }

            #company {
              position: relative;
              display: inline-block;
              float: right;
              /* margin-left: 380px; */
              margin-top: 8px;
              width: 57%;
              height: 100px;
              text-align: right;
              padding: 10px;
              background-color: #219ae0;
              color: #ffffff;
            }
            #company img {
              /*height: 30px;*/
              /*width: 100%;*/
            }
            #company a {
              color: #ffffff;
            }
            #info {
                width: 49%;
                display: inline-block;
                position: relative;
                vertical-align: top;
                font-size: 14px;
            }
            #logo {
                width: 49%;
                display: inline-block;
                position: relative;
                vertical-align: top;
                text-align: left;
                height: 100px;
            }
            #logo img {
                max-height: 100px;
                max-width: 50%;
                border: solid #ffffff;
                border-width: 12px;
                background-color: #ffffff;
            }

            #details {
              margin-bottom: 50px;
              max-width: 21cm;
              width: 21cm;
            }
          
            #details h1 {
                color: #219ae0;
                text-align: center;
                font-size: 30px;
                margin-top: 0px;
                margin-bottom: 0px;
                word-break: break-word;
            }

            #client {
              padding-left: 6px;
              border-left: 6px solid #0087C3;
            }

            .to {
              font-size: 14px;
              magin-top: 20px;
              margin-bottom: 5px;
            }
            .address {
              margin-bottom: 5px;
            }
            .email {
              margin-bottom: 15px;
            }

            h2.name {
              /*font-size: 14px;*/
              font-weight: normal;
              margin: 0;
            }
            h2.titdetalles {
                font-size: 16px;
                font-weight: normal;
                margin: 0;
                border-bottom: solid #d9534f;
                line-height: 25px;
            }


            #invoice {
              /*text-align: right;*/
              /*margin-left: 500px;*/
            }

            td.ri h1, td.iz h1 {
                color: #0087C3;
                font-size: 18px;
                line-height: 14px;
                font-weight: normal;
                margin: 0  0 10px 0;
                margin-bottom: 10px;
            }

            td.iz h2 {
                margin-bottom: 0px;
            }
            td.iz p {
                margin-top: 0px;
                margin-bottom: 0px;
                line-height: 14px;
                padding: 10px;
                /*padding-bottom: 10px;*/
                /*padding-top: 5px;*/
                /* padding: 5px; */
                background: #EEEEEE;
                font-size: 14px;
            }

            td.ri h2 {
              font-size: 14px;
              font-weight: normal;
              margin: 0;
              margin-top: 10px;
            }

            table {
              width: 100%;
              /*border-collapse: collapse;*/
              border-spacing: 0;
              margin-bottom: 20px;
              /*table-layout:fixed;*/
              /*max-width: 500px;*/
            }

            table th,
            table td {
              padding: 0px;
              /*background: #EEEEEE;*/
              text-align: center;
              border-bottom: 1px solid #2222;
              word-wrap: break-word;         
              overflow-wrap: break-word; 
              font-size: 11px;
            }

  /*
            table th {
              white-space: nowrap;        
              font-weight: normal;
            }
  */
            table td {
              text-align: right;
              white-space: pre-line;        
            }

            table td h3{
              color: #0087C3;
              font-size: 11px;
              font-weight: normal;
              margin: 0 0 2px 0;
            }

            table .no {
              color: #FFFFFF;
              font-size: 11px;
              background: #0087C3;
              width: 30%;
              max-width: 30%;
              text-align: left;
              white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
              white-space: -webkit-pre-wrap; /*Chrome & Safari */ 
              white-space: -pre-wrap;      /* Opera 4-6 */
              white-space: -o-pre-wrap;    /* Opera 7 */
              white-space: pre-wrap;       /* css-3 */
              word-wrap: break-word;       /* Internet Explorer 5.5+ */
              word-break: break-all;
              white-space: normal;

            }

            table .desc {
              text-align: left;
              width: auto;
              font-size: 11px;
              width: 60%;
              max-width: 60%;
            }

            table .fab {
              text-align: left;
              width: auto;
              font-size: 11px;
              width: 10%;
              max-width: 10%;
            }

            table .unit {
              background: #DDDDDD;
              font-size: 11px;
              text-align: center;
            }

            table .qty, table .pvp, table .dto {
                font-size: 11px;
                width: 10%;
                max-width: 10%;
            }

            table .total {
              background: #0087C3;
              color: #FFFFFF;
              font-size: 11px;
              width: 8%;
              max-width: 8%;
            }

            table td.unit,
            table td.qty {
              text-align: center;
            }

            table tbody tr:last-child td {
              border: none;
            }

            table tfoot td {
              /*padding: 10px 20px; */
              background: #FFFFFF;
              border-bottom: none;
              font-size: 12px;
              /*white-space: nowrap; */
              border-top: 1px solid #AAAAAA; 
            }

            table tfoot tr:first-child td {
              border-top: none; 
            }

            table tfoot tr:last-child td {
              border-top: 1px solid #AAAAAA; 

            }
            .footerfondo {
                background: #0087C3;
                color: #FFFFFF;
            }
            .total-final {
                  border-top: 1px solid #AAAAAA; 
                  font-weight: bolder;
            }

            table tfoot tr td:first-child {
              border: none;
              padding-top: 20px;            
            }

            #thanks{
              font-size: 12px;
              margin-bottom: 50px;
            }

            #notices{
              padding-left: 6px;
              border-left: 6px solid #0087C3;  
            }

            #notices .notice {
              font-size: 12px;
            }

            .footer {
                color: #777777;
                width: 100%;
                height: 30px;
                position: relative;
                bottom: 0;
                border-top: 1px solid #AAAAAA;
                padding: 8px 0;
                text-align: center;
            }

            table.titulo {
                /*width: 700px !important;*/
                /*border-collapse: collapse;*/
                border-spacing: 5px;
                margin-bottom: 20px;
                table-layout:fixed;
            }
            table.titulo td.iz {
                width:50%;
                text-align: left;
            }
            table.titulo td.ri {
                width:50%;
                text-align: right;
            }
            .text-center {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
            .text-right {
                text-align: right;
            }
            .bg-dark {
                color: #333333;
                background-color: #EEEEEE;
            }
            .bg-dark th {
                padding: 4px;
            }
    </style>
    <script>
        $(document).ready(function() {
           window.print(); 
        });
    </script>
  </head>
  <body>
    
    <div id="header" class="clearfix">
        <div id="ref" style="border: solid;">
            <strong><? echo $ref; ?></strong>
        </div>
        <div id="company">
            <div id="logo">
                <img src="<? echo $clienteimg; ?>">
            </div>
            <div id="info">
                <h2 class="name"><? echo $cliente; ?></h2>
                <div><? echo $direccion; ?></div>
                    <!--
                <div><? //echo $cliDir; ?> </div>
                <div><? //echo $cliCP." - ".$cliPoblacion."(".$cliProvincia.")"; ?></div>
                <div><? //echo $cliTlfno; ?></div>-->
                    <!--
                <div><a href="mailto:<? //echo $cliEmail; ?>"><? //echo $cliEmail; ?></a></div>-->
            </div>
        </div>
    </div>
    <div id='details'>
        <h1>
            <? echo $nombre; ?>
        </h1>
        <table class='titulo'>
            
            <tr>
                <td class='iz' colspan="2">
                    <h2 class='titdetalles'>DESCRIPCIÓN</h2>
                    <p><? echo $descripción; ?></p>
                </td>
            </tr>
            <tr>
                <td class='iz' colspan="2">
                    <h2 class='titdetalles'>MATERIAL PEDIDO PARA EL PROYECTO</h2>
                </td>
            </tr>
        </table>
        
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
                        <th class="text-center">DTO</th>
                        <th class="text-center">IMPORTE</th>
                        <th class="text-center">IVA</th>
                        <th class="text-center">RECIBIDO</th>
                        <th class="text-center">F. RECEP.</th>
                        <th class="text-center">F.ENTREGA</th>
                    </tr>
                </thead>
                <tbody>
        <?
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
                                            //$botonBorrar='<button disabled type="button" value="'.$rowGrupos[0].'" class="btn btn-circle btn-danger remove-group-alm-pro" data-id="'.$rowGrupos[0].'" title="Eliminar Grupo (Por el momento solo se puede eliminar desde Entregas)"><img src="/erp/img/cross.png"></button>';
                                        }
                                        
                                        $sqlSelEntregas="SELECT ENTREGAS.id FROM ENTREGAS WHERE ENTREGAS.grupos_nombres_id=".$rowGrupo[0];
                                        file_put_contents("selectEntrtegasID.txt", $sqlSelEntregas);
                                        $resEntregas = mysqli_query($connString, $sqlSelEntregas) or die("Error select ENTREGAS ID!");
                                        $rowEntregas = mysqli_fetch_array($resEntregas);
                                        
                                        //$gotoentrega='<button type="button" value="'.$rowEntregas[0].'" class="btn btn-info btn-circle goto-entrega" data-id="'.$rowEntregas[0].'" title="Ir a la entrega del grupo"><img src="/erp/img/link-w.png" style="height:20px;"></button>';
                                        //$checkAdd="<input disabled type='checkbox' ".$checkAddHabilitado." class='grup-pos-to-project' data-matid='".$row[18]."' value='".$row[18]."' name='posiciones[".$contador."][grup-pos-to-project]' ".$habilitado.">
                                        //           <input type='hidden' name='posiciones[".$contador."][pos_mat_grup]' value='".$rowGrupos[0]."'>";
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
                                    //$botonBorrarM='<button type="button" value="'.$rowDetallesGrupo[0].'" class="btn btn-circle btn-danger remove-groupmat-alm-pro" data-id="1" title="Eliminar material del Grupo"><img src="/erp/img/cross.png"></button>';
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
                                                    <td class='text-center'>
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
                                    $fecha_entrega = $row[16]."<img src='/erp/img/warning-test.png' style='height: 15px;'>";
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
                                
                                if($existe==false){
                                    echo "
                                        <tr data-id='".$row[0]."' style='".$trcolor."'>
                                            <td class='text-center'>
                                            </td>
                                            <td class='text-left'>".$ref."</td>
                                            <td class='text-left'>".$material."</td>
                                            <td class='text-center'>".$row[3]."</td>
                                            <td class='text-center'>".$row[4]."</td>
                                            <td class='text-right'>".$pvp."</td>
                                            <td class='text-right'>".number_format($dto_sum, 2).$dto_extra."</td>
                                            <td class='text-right'>".number_format($subtotalDtoApli, 2)."</td>
                                            <td class='text-right'>".$ivaPercent."</td>
                                            <td class='text-center'>".$recibidoDet."</td>
                                            <td class='text-center'>".$row[7]."</td>
                                            <td class='text-center'>".$row[16]."</td>
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
                                    $fecha_entrega = $row[16]."<img src='/erp/img/warning-test.png' style='height: 10px;'>";
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
                                //$botonBorrar='<button '.$habilitado.' type="button" class="btn btn-circle btn-danger remove-material-alm-pro" data-id="1" title="Eliminar Material Cogido desde almacen"><img src="/erp/img/cross.png"></button>';
                                if($existe==false){
                                echo "
                                        <tr data-id='".$row[0]."' style='".$trcolor."'>
                                            <td class='text-center'>
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
    </div>  
        
        
        
    
    <div class="footer">
        GENELEK SISTEMAS S.L. - INGENIERÍA DE SISTEMAS / COGENERACIÓN
    </div>
  </body>
</html>