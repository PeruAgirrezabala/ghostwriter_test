<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                    INTERVENCIONES.id intid,
                    INTERVENCIONES.ref,
                    INTERVENCIONES.nombre,
                    INTERVENCIONES.descripcion,
                    INTERVENCIONES.fecha,
                    INTERVENCIONES.fecha_mod,
                    INTERVENCIONES.instalacion,
                    INTERVENCIONES.solucion,
                    INTERVENCIONES.fecha_solucion,
                    INTERVENCIONES.observaciones,
                    INTERVENCIONES.proyecto_id,
                    INTERVENCIONES.fecha_factu,
                    INTERVENCIONES_ESTADOS.nombre,
                    INTERVENCIONES_ESTADOS.color,
                    erp_users.nombre,
                    erp_users.apellidos,
                    erp_users.firma_path,
                    CLIENTES.id,
                    CLIENTES.nombre,
                    CLIENTES.direccion,
                    CLIENTES.poblacion,
                    CLIENTES.provincia,
                    CLIENTES.cp,
                    CLIENTES.pais,
                    CLIENTES.telefono,
                    CLIENTES.nif,
                    CLIENTES.email,
                    OFERTAS.ref,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.descripcion,
                    PROYECTOS.fecha_entrega,
                    erp_users.id,
                    (SELECT SUM(INTERVENCIONES_DETALLES_TECNICOS.H820) FROM INTERVENCIONES_DETALLES, INTERVENCIONES_DETALLES_TECNICOS WHERE INTERVENCIONES_DETALLES.id = INTERVENCIONES_DETALLES_TECNICOS.intdetalle_id AND INTERVENCIONES_DETALLES.int_id = intid),
                    (SELECT SUM(INTERVENCIONES_DETALLES_TECNICOS.H208) FROM INTERVENCIONES_DETALLES, INTERVENCIONES_DETALLES_TECNICOS WHERE INTERVENCIONES_DETALLES.id = INTERVENCIONES_DETALLES_TECNICOS.intdetalle_id AND INTERVENCIONES_DETALLES.int_id = intid),
                    (SELECT SUM(INTERVENCIONES_DETALLES_TECNICOS.Hviaje) FROM INTERVENCIONES_DETALLES, INTERVENCIONES_DETALLES_TECNICOS WHERE INTERVENCIONES_DETALLES.id = INTERVENCIONES_DETALLES_TECNICOS.intdetalle_id AND INTERVENCIONES_DETALLES.int_id = intid)
                FROM 
                    INTERVENCIONES
                LEFT JOIN CLIENTES 
                    ON INTERVENCIONES.cliente_id = CLIENTES.id
                LEFT JOIN OFERTAS 
                    ON INTERVENCIONES.oferta_id = OFERTAS.id
                INNER JOIN erp_users  
                    ON INTERVENCIONES.tecnico_id = erp_users.id  
                INNER JOIN INTERVENCIONES_ESTADOS 
                    ON INTERVENCIONES.estado_id = INTERVENCIONES_ESTADOS.id 
                LEFT JOIN PROYECTOS 
                    ON INTERVENCIONES.proyecto_id = PROYECTOS.id 
                WHERE
                    INTERVENCIONES.id = ".$_GET['id'];
    
    file_put_contents("printProject.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar la Intervención");
    $registros = mysqli_fetch_row($res);
    
    $ref = $registros[1];
    $nombre = $registros[2];
    $descripción = $registros[3];
    $fecha = $registros[4];
    $fecha_mod = $registros[5];
    $instalacion = $registros[6];
    $observ = $registros[9];
    $estado = $registros[12];
    $estadocolor = $registros[13];
    $tecnico = $registros[14];
    $tecnicoApellidos = $registros[15];
    $tecnicoFirma = $registros[16];
    $cliente = $registros[18];
    $clidireccion = $registros[19];
    $clipoblacion = $registros[20];
    $cliprovincia = $registros[21];
    $cliPais = $registros[23];
    $cliTlfno = $registros[24];
    $cliNIF = $registros[25];
    $cliEmail = $registros[26];
    $h820 = $registros[33];
    $h208 = $registros[34];
    $hviaje = $registros[35];
    
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <title>IMPRIMIR INTERVENCIÓN </title>
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
              margin-bottom: 10px;
              border-bottom: 1px solid #AAAAAA;
              /*max-width: 500px;*/
              /* height: 150px; */
              /* background-color: #219ae0; */
            }

            #ref {
                position: relative;
                float: left;
                display: inline-block;
                margin-top: 8px;
                /* margin-right: 1%; */
                width: 37%;
                min-height: 94px;
                /* line-height: 94px; */
                font-size: 40px;
                padding: 10px;
                /* background-color: #219ae0; */
                text-align: left;
            }

            #ref img {
                width: 180px;
            }

            #company {
              position: relative;
              display: inline-block;
              float: right;
              /* margin-left: 380px; */
              margin-top: 8px;
              width: 57%;
              height: 140px;
              text-align: right;
              padding: 10px;
              /*background-color: #219ae0;*/
              /*color: #ffffff;*/
            }
            #company img {
              /*height: 30px;*/
              /*width: 100%;*/
            }
            #company a {
              /*color: #ffffff;*/
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
            .two-column {
                width: 48%;
                display: inline-block;
                height: 210px;
                vertical-align: top;
                border: solid #cccccc 1px;
                padding-left: 5px;
            }
            .two-column h3 {
                margin-top: 8px;
                margin-bottom: 8px;
            }
            .datos {
                color:#999999;
                padding-left: 2px;
                font-weight: 100;
            }
          
            #details h1 {
                color: #219ae0;
                text-align: left;
                font-size: 25px;
                margin-top: 0px;
                margin-bottom: 10px;
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
                font-size: 1.17em;
                font-weight: normal;
                margin: 0;
                /*border-bottom: solid #AAAAAA 1px;*/
                line-height: 25px;
            }
            h2.tithoras {
                font-size: 11px;
                font-weight: normal;
                margin: 0;
                line-height: 15px;
                font-weight: bold;
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
                padding: 5px;
                padding-bottom: 10px;
                padding-top: 5px;
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
              border-collapse: collapse;
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
              word-wrap: break-word;         
              overflow-wrap: break-word; 
              font-size: 1.17em;
            }

  /*
            table th {
              white-space: nowrap;        
              font-weight: normal;
            }
  */
            table td {
              text-align: right;
              vertical-align: top;
            }
            .text-center {
                text-align: center;
            }
            .text-left {
                text-align: left;
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
                position: absolute;
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
                margin-top: 20px;
                table-layout:fixed;
                border: solid 1px #AAAAAA;
            }
            table.titulo td.iz {
                width:50%;
                text-align: left;
            }
            table.titulo td.ri {
                width:50%;
                text-align: right;
            }
            table.titulo td {
                padding: 5px;
                padding-top: 15px;
            }
            table.titulo th {
                background: #EEEEEE;
            }
            table.tabla-horas {
                width: 100% !important;
                border-collapse: collapse;
                border-spacing: 5px;
                margin-bottom: 5px;
                margin-top: 5px;
                table-layout:fixed;
                border: solid 1px #AAAAAA;
            }
            table.tabla-horas td {
              padding: 2px;
              background: #EEEEEE;
              border-bottom: 1px solid #AAAAAA;
              word-wrap: break-word;         
              overflow-wrap: break-word; 
              font-size: 11px;
            }
            table.tabla-horas th {
                height: 20px;
                font-size: 2px !important;
                border-bottom: 1px solid #AAAAAA;
            }
            #cabecera-ISO9001 {
                border: solid 1px #AAAAAA;
                background: #EEEEEE;
            }
            #cabecera-ISO9001 td {
                padding-right: 5px;
                padding-left: 5px;
                vertical-align: middle;
            }
            #cabecera-ISO9001 td p {
                margin-top: 4px;
                margin-bottom: 4px;
            }
            .text-center {
                text-align: center;
            }
    </style>
    <script>
        $(document).ready(function() {
           //window.print(); 
        });
    </script>
  </head>
  <body>
    <?
      $factuDir = "Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa";
      $factuTlfno = "943 14 33 11";
      $factuEmail = "genelek@genelek.com";
    ?>
    
    <div id="header" class="clearfix">
        <div id="ref">
            <img src="http://192.168.3.109/erp/img/logo_pdf.png">
        </div>
        <div id="company">
            <div id="logo">
                
            </div>
            <div id="info">
                <h2 class="name">GENELEK SISTEMAS S.L.</h2>
                <div><? echo $factuDir; ?> </div>
                <!--<div>48940 - Leioa</div>-->
                <div><? echo $factuTlfno; ?></div>
                <div><a href="mailto:<? echo $factuEmail; ?>"><? echo $factuEmail; ?></a></div>
            </div>
        </div>
    </div>
    <div id='details'>
        <table id="cabecera-ISO9001" border="1">
            <tbody>
                <tr>
                    <td width="80%" rowspan="2">
                        <h1>PARTE DE INTERVENCIÓN</h1>
                    </td>
                    <td width="20%" style="text-align: left;">
                        <p>COD: PART-INT-01</p>
                        <p>REV: 01</p>
                        <p>FECHA: <? echo $fecha; ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="two-column" style="margin-right: 15px;">
            <h3>Nº INTERVENCIÓN: <span class="datos"><? echo $ref; ?></span></h3>
            <h3>DE GENELEK: <span class="datos"><? echo $tecnico." ".$tecnicoApellidos; ?></span></h3>
            <h3>FECHA: <span class="datos"><? echo $fecha; ?></span></h3>
            <h3>TOTAL HORAS DE VIAJE: <span class="datos"><? echo $hviaje; ?></span></h3>
            <h3>TOTAL HORAS 08:00-20:00: <span class="datos"><? echo $h820; ?></span></h3>
            <h3>TOTAL HORAS 20:00-08:00: <span class="datos"><? echo $h208; ?></span></h3>
        </div>
        <div class="two-column">
            <h3>CLIENTE: <span class="datos"><? echo $cliente; ?></span></h3>
            <h3>NIF: <span class="datos"><? echo $cliNIF; ?></span></h3>
            <h3>DIRECCIÓN: <span class="datos"><? echo $clidireccion; ?></span></h3>
            <h3>LOCALIDAD: <span class="datos"><? echo $clipoblacion."(".$cliprovincia.")"; ?></span></h3>
            <h3>PAÍS: <span class="datos"><? echo $cliPais; ?></span></h3>
            <h3>TLFNO: <span class="datos"><? echo $cliTlfno; ?></span></h3>
            <h3>INSTALACIÓN: <span class="datos"><? echo $instalacion; ?></span></h3>
        </div>

        <table class='titulo' border="1">
            <thead>
                <tr>
                    <th width="10%">
                        <h2 class='titdetalles'>FECHA</h2>
                    </th>
                    <th width="90%">
                        <h2 class='titdetalles'>DESCRIPCIÓN DEL TRABAJO REALIZADO</h2>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?
                $sql = "SELECT 
                            INTERVENCIONES_DETALLES.id,
                            INTERVENCIONES_DETALLES.titulo,  
                            INTERVENCIONES_DETALLES.descripcion,
                            INTERVENCIONES_DETALLES.fecha,
                            INTERVENCIONES_DETALLES.fecha_mod,
                            INTERVENCIONES_DETALLES.H820,
                            INTERVENCIONES_DETALLES.H208,
                            INTERVENCIONES_DETALLES.Hviaje,
                            erp_users.nombre,
                            erp_users.apellidos
                        FROM 
                            INTERVENCIONES_DETALLES, erp_users
                        WHERE
                            INTERVENCIONES_DETALLES.erpuser_id = erp_users.id
                        AND
                            INTERVENCIONES_DETALLES.int_id = ".$_GET["id"]." 
                        ORDER BY 
                            INTERVENCIONES_DETALLES.id ASC";

                file_put_contents("queryIntDetalles.txt", $sql);
                $res = mysqli_query($connString, $sql) or die("Error seleccionando los detalles de la Intervención");

                while( $row = mysqli_fetch_array($res) ) {
                    echo "<tr>
                            <td class='text-center'>
                                ".$row[3]."
                            </td>
                            <td class='text-left'>
                                ".$row[2];
                    $sqlHoras = "SELECT 
                            INTERVENCIONES_DETALLES_TECNICOS.id,
                            INTERVENCIONES_DETALLES_TECNICOS.H820,
                            INTERVENCIONES_DETALLES_TECNICOS.H208,
                            INTERVENCIONES_DETALLES_TECNICOS.Hviaje,
                            erp_users.nombre,
                            erp_users.apellidos
                        FROM 
                            INTERVENCIONES_DETALLES_TECNICOS, erp_users
                        WHERE
                            INTERVENCIONES_DETALLES_TECNICOS.erpuser_id = erp_users.id
                        AND
                            INTERVENCIONES_DETALLES_TECNICOS.intdetalle_id = ".$row[0]." 
                        ORDER BY 
                            INTERVENCIONES_DETALLES_TECNICOS.id ASC";
                    
                    $resHoras = mysqli_query($connString, $sqlHoras) or die("Error seleccionando los detalles de las Horas");
                    if (mysqli_num_rows($resHoras) > 0) {
                        echo "<table class='tabla-horas' colspacing='0' border='1' cellspacing='0'>
                                <thead>
                                    <tr>
                                        <th width='40%'>
                                            <h2 class='tithoras'>TÉCNICO</h2>
                                        </th>
                                        <th width='20%'>
                                            <h2 class='tithoras'>Horas 08:00-20:00</h2>
                                        </th>
                                        <th width='20%'>
                                            <h2 class='tithoras'>Horas 20:00-08:00</h2>
                                        </th>
                                        <th width='20%'>
                                            <h2 class='tithoras'>Horas VIAJE</h2>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>";
                        while($rowHoras = mysqli_fetch_array($resHoras) ) {
                            echo "<tr>
                                    <td class='text-left'>
                                        ".$rowHoras[4]." ".$rowHoras[5]."
                                    </td>
                                    <td class='text-center'>
                                        ".$rowHoras[1]."
                                    </td>
                                    <td class='text-center'>
                                        ".$rowHoras[2]."
                                    </td>
                                    <td class='text-center'>
                                        ".$rowHoras[3]."
                                    </td>
                                  </tr>";
                        }
                        echo "  </tbody>
                              </table>";
                    } // fin del if del numero de registros
                    echo    "
                                </td>
                              </tr>
                            ";
                }
            ?>
            </tbody>
        </table>
        <table class='titulo' border="1" style="border: double;border-color: #AAAAAA;">
            <tbody>
                <tr>
                    <td width="50%" height="60" class="text-left">
                        Firma, el Resp. de Genelek:
                        <? echo $tecnico." ".$tecnicoApellidos; ?>
                        <br>
                        <img src="<? echo $tecnicoFirma ?>" height="70">
                    </td>
                    <td width="50%" height="60" class="text-left" style="border: double;border-color: #AAAAAA;">
                        Firma, el Resp. del Cliente:
                    </td>
                </tr>
            </tbody>
        </table>
    </div>  
        
        
        
    
    <div class="footer">
        GENELEK SISTEMAS S.L. - INGENIERÍA DE SISTEMAS / COGENERACIÓN
    </div>
  </body>
</html>