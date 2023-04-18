<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $filtros = "";
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
        $filtros .= $separator." <strong>Año:</strong> ".$_GET['year']." ";
        $separator = "|";
        if ($_GET['month'] != "") {
            $criteria .= " AND MONTH(PEDIDOS_PROV.fecha) = ".$_GET['month'];
            $filtros .= $separator." <strong>Mes:</strong> ".$_GET['month']." ";
            $separator = "|";
        }
    }
    if ($_GET['estado'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteria .= $and." PEDIDOS_PROV.estado_id = ".$_GET['estado'];
        $and = " AND ";
        $filtros .= $separator." <strong>Estado:</strong> ".$_GET['estado']." ";
    }
    if ($_GET['recibido'] == "1") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteria .= $and." PEDIDOS_PROV_DETALLES.recibido = ".$_GET['recibido'];
        $and = " AND ";
        $filtros .= $separator." <strong> Pedidos Recibidos </strong> ";
    }elseif($_GET['recibido'] == "0"){
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteria .= $and." PEDIDOS_PROV_DETALLES.recibido = ".$_GET['recibido'];
        $and = " AND ";
        $filtros .= $separator." <strong> Pedidos Pendientes de recibir </strong> ";
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
                PROVEEDORES.id,
                PROVEEDORES.nombre,
                PROVEEDORES.direccion,
                PROVEEDORES.poblacion,
                PROVEEDORES.provincia,
                PROVEEDORES.telefono,
                PROVEEDORES.email,
                PROVEEDORES.cp,
                PROVEEDORES.pais,
                PROVEEDORES.contacto,
                PROVEEDORES.email_pedidos
            FROM 
                PROVEEDORES
            WHERE 
                id = ".$_GET['proveedor_id'];
    
    file_put_contents("printProject.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar el Proyecto");
    $registros = mysqli_fetch_row($res);
    
    $provNombre = $registros[1];
    $provDir = $registros[2];
    $provPoblacion = $registros[3];
    $provProvincia = $registros[4];
    $provTlfno = $registros[5];
    $provEmail = $registros[6];
    $provCP = $registros[7];
    $provPais = $registros[8];
    $provContacto = $registros[9];
    $provEmailPedidos = $registros[10];
    
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <title>MATERIAL PEDIDO A <? echo $provNombre; ?></title>
    
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
                  display: none;
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
              max-width: 21cm;
              width: 100%;
              height: 180px;
              text-align: left;
              /*padding: 10px;*/
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
                width: 100%;
                display: inline-block;
                position: relative;
                vertical-align: top;
                font-size: 14px;
                padding: 10px;
            }
            #logo {
                width: 20%;
                display: inline-block;
                display: none;
                position: relative;
                vertical-align: top;
                text-align: left;
                height: 100px;
                padding: 10px;
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
            .blink_me img {
                height: 20px;
                vertical-align: middle;
                margin-left: 10px;
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
            <strong><? //echo $ref; ?></strong>
        </div>
        <div id="company">
            <div id="logo">
                <img src="<? echo $provImg; ?>">
            </div>
            <div id="info">
                <h2 class="name"><? echo $provNombre; ?></h2>
                <div><? echo $provDir; ?> </div>
                <div><? echo $provCP." - ".$provPoblacion."(".$provProvincia.")"; ?></div>
                <div><? echo $provPais; ?></div>
                <div><? echo $provTlfno; ?></div>
                <div><? echo $provContacto; ?></div>
                <div><? echo $provEmailPedidos; ?></div>
                <div><a href="mailto:<? echo $provEmail; ?>"><? echo $provEmail; ?></a></div>
            </div>
        </div>
    </div>
    <div id='details'>
        <table class='titulo'>
            <tr>
                <td class='iz' colspan="2">
                    <h2 class='titdetalles'>MATERIAL PEDIDO A <? echo $provNombre; ?></h2>
                    <p><? echo $filtros; ?></p>
                </td>
            </tr>
        </table>
        
        <div class="form-group" id="tabla-material">
            <table class="table table-striped table-condensed table-hover" id='tabla-material-proveedores'>
                <thead>
                    <tr class="bg-dark">
                        <th class="text-center">REF</th>
                        <th class="text-center">MATERIAL</th>
                        <th class="text-center">FABRICANTE</th>
                        <th class="text-center">UNID.</th>
                        <th class="text-center">PVP</th>
                        <th class="text-center">DTO</th>
                        <th class="text-center">IMPORTE</th>
                        <th class="text-center">RECIBIDO</th>
                        <th class="text-center">FECHA</th>
                        <th class="text-center">F.ENTREGA</th>
                    </tr>
                </thead>
                <tbody>
        <?
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

            file_put_contents("array.txt", $sql);
            $res = mysqli_query($connString, $sql) or die("database error:");

            $iva = 0;
            $pedidoGroup = "";
            $contador = 0;
            while( $row = mysqli_fetch_array($res) ) {  
                $fecha_entrega = strtotime($row[16]);
                $fecha_entrega = date("Y-m-d", $fecha_entrega);
                if ((date("Y-m-d") > $fecha_entrega) && (($row[28] < 4) || ($row[28] > 7))) {
                    $fecha_entrega = $row[16]."<span class='blink_me' title='Pedido Retrasado'><img src='/erp/img/warning-test.png'></span>";
                }
                else {
                    $fecha_entrega = $row[16];
                }
                if ($contador%2==0) {
                    $bgcolor = "style='background-color:#ffffff;'";
                }
                else {
                    $bgcolor = "style='background-color:#f9f9f9;'";
                }
                if ($pedidoGroup != $row[25]) {
                    //insertamos cabecera del siguiente grupo
                    $pedidoGroup = $row[25];
                    echo "<tr>
                                <td class='text-left' style='background-color: #219ae0; color: #ffffff; padding: 4px;' colspan='12'><strong>REF:</strong> ".$pedidoGroup." <strong>Fecha:</strong> ".$row[26]." <strong>Plazo:</strong> ".$row[29]." <strong>Fecha estimada de Entrega:</strong> ".$fecha_entrega." </td>
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
                    $trcolor = "style='background-color: #b7fca4 !important;'";
                    $bgcolor = "";
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
                        <tr data-id='".$row[0]."' ".$bgcolor." ".$trcolor.">
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
    </div>  
        
        
        
    
    <div class="footer">
        GENELEK SISTEMAS S.L. - INGENIERÍA DE SISTEMAS / COGENERACIÓN
    </div>
  </body>
</html>