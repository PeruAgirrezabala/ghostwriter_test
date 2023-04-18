<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "SELECT 
                OFERTAS.id,
                OFERTAS.ref,
                OFERTAS.titulo,
                OFERTAS.descripcion,
                OFERTAS.fecha,
                OFERTAS.fecha_validez,
                OFERTAS.fecha_mod,
                OFERTAS_ESTADOS.nombre, 
                PROYECTOS.nombre, 
                OFERTAS_ESTADOS.color, 
                OFERTAS_ESTADOS.id,
                OFERTAS.proyecto_id, 
                CLI1.nombre, 
                CLI1.img,
                CLI2.nombre, 
                CLI2.img, 
                CLI2.id,
                CLI1.id,
                OFERTAS.dto_final,
                OFERTAS.forma_pago,
                OFERTAS.plazo_entrega,
                OFERTAS.ref_genelek,
                CLI1.direccion,
                CLI1.poblacion,
                CLI1.provincia,
                CLI1.telefono,
                CLI1.email,
                CLI1.cp,
                CLI2.direccion,
                CLI2.poblacion,
                CLI2.provincia,
                CLI2.telefono,
                CLI2.email,
                CLI2.cp,
                PROYECTOS.ref
            FROM 
                OFERTAS
            INNER JOIN OFERTAS_ESTADOS
                ON OFERTAS.estado_id = OFERTAS_ESTADOS.id 
            LEFT JOIN PROYECTOS
                ON OFERTAS.proyecto_id = PROYECTOS.id 
            LEFT JOIN CLIENTES as CLI1
                ON PROYECTOS.cliente_id = CLI1.id
            LEFT JOIN CLIENTES as CLI2
                ON OFERTAS.cliente_id = CLI2.id  
            WHERE OFERTAS.id = ".$_GET['oferta_id']."
            ORDER BY 
                OFERTAS.fecha_mod DESC";
    
    //file_put_contents("printOferta.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar la Oferta");
    $registros = mysqli_fetch_row($res);
    
    $id = $_GET['id'];
    $ref = $registros[1];
    $nombreOferta = $registros[2];
    $descripcion = $registros[3];
    $fecha = $registros[4];
    $fecha_val = $registros[5];
    $fecha_mod = $registros[6];
    $estado = $registros[7];
    $proyecto = $registros[8];
    $estadocolor = $registros[9];
    $estado_id = $registros[10];
    $proyecto_id = $registros[11];
    if ($proyecto_id != "") {
        $cliente = $registros[12];
        $clienteimg = $registros[13];
        $cliente_id = $registros[17];
        $cliDir = $registros[22];
        $cliPoblacion = $registros[23];
        $cliProvincia = $registros[24];
        $cliTlfno = $registros[25];
        $cliEmail = $registros[26];
        $cliCP = $registros[27];
    }
    else {
        $cliente = $registros[14];
        $clienteimg = $registros[15];
        $cliente_id = $registros[16];
        $cliDir = $registros[28];
        $cliPoblacion = $registros[29];
        $cliProvincia = $registros[30];
        $cliTlfno = $registros[31];
        $cliEmail = $registros[32];
        $cliCP = $registros[33];
    }
    $dto_final = $registros[18];
    $forma_pago = $registros[19];
    $plazo_entrega = $registros[20];
    $ref_genelek = $registros[21];
    $refProyecto = $registros[34];
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <title>MATERIAL OFERTADO A <? echo $cliente; ?></title>
    
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
                width: 49%;
                display: inline-block;
                position: relative;
                vertical-align: top;
                font-size: 14px;
                text-align: right;
            }
            #logo {
                width: 47%;
                display: inline-block;
                position: relative;
                vertical-align: top;
                text-align: left;
                height: 100px;
                padding: 5px;
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
                <img src="<? echo $clienteimg; ?>">
            </div>
            <div id="info">
                <h2 class="name"><? echo $cliente; ?></h2>
                <div><? echo $cliDir; ?> </div>
                <div><? echo $cliCP." - ".$cliPoblacion."(".$cliProvincia.")"; ?></div>
                <div><? echo $cliTlfno; ?></div>
                <div><a href="mailto:<? echo $cliEmail; ?>"><? echo $cliEmail; ?></a></div>
            </div>
        </div>
    </div>
    <div id='details'>
        <table class='titulo'>
            <tr>
                <td class='iz' colspan="2">
                    <h2 class='titdetalles'>MATERIAL OFERTADO A <strong><? echo strtoupper($cliente); ?></strong> PARA EL PROYECTO <strong><? echo $refProyecto." - ".strtoupper($proyecto); ?></strong></h2>
                </td>
            </tr>
        </table>
        
        <div class="form-group" id="tabla-material">
            <table class="table table-striped table-condensed table-hover" id='tabla-material-oferta'>
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

            //file_put_contents("printMaterialesOferta.txt", $sql);
            $res = mysqli_query($connString, $sql) or die("Error al imprimir los Materiales de la Oferta");

            $iva = 0;
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
                
                if ($contador%2==0) {
                    $bgcolor = "style='background-color:#ffffff;'";
                }
                else {
                    $bgcolor = "style='background-color:#f9f9f9;'";
                }

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
                    $bgcolor = "";
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
                $inc = "1.".$incMat;
                $pvpTOTAL = $inc*$subtotalDTOCLIapli;

                echo "
                        <tr data-id='".$registros[0]."' ".$bgcolor." ".$trcolor.">
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
    </div>  
        
        
        
    
    <div class="footer">
        GENELEK SISTEMAS S.L. - INGENIERÍA DE SISTEMAS / COGENERACIÓN
    </div>
  </body>
</html>