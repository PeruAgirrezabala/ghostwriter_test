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
    <title>PROYECTO</title>
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
                font-size: 51px;
                margin-top: 0px;
                margin-bottom: 20px;
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
              border-bottom: 1px solid #FFFFFF;
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
                <div><? echo $cliDir; ?> </div>
                <div><? echo $cliCP." - ".$cliPoblacion."(".$cliProvincia.")"; ?></div>
                <div><? echo $cliTlfno; ?></div>
                <div><a href="mailto:<? echo $cliEmail; ?>"><? echo $cliEmail; ?></a></div>
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
                    <p>
                        <? echo $descripción; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class='iz'>
                    <h2 class='titdetalles'>FECHA INICIO</h2>
                    <p class="text-center">
                        <? echo $fecha_ini; ?>
                    </p>
                </td>
                <td class='iz' align="center">
                    <h2 class='titdetalles'>FECHA ENTREGA</h2>
                    <p class="text-center">
                        <? echo $fecha_entrega; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class='iz' colspan="2">
                    <h2 class='titdetalles'>CLIENTE</h2>
                    <p>
                        <? echo $cliente; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class='iz'>
                    <h2 class='titdetalles'>INSTALACIÓN</h2>
                    <p>
                        <? echo $ubicacion; ?>
                    </p>
                </td>
                <td class='iz'>
                    <h2 class='titdetalles'>DIRECCIÓN</h2>
                    <p>
                        <? echo $direccion; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class='iz' colspan="2">
                    <h2 class='titdetalles'>COORDENADAS GPS</h2>
                    <p>
                        <? echo $gps; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class='iz' colspan="2">
                    <h2 class='titdetalles'>PATH EXPEDIENTE</h2>
                    <p>
                        \\192.168.3.108\PROYECTOS\<? echo $path; ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>  
        
        
        
    
    <div class="footer">
        GENELEK SISTEMAS S.L. - INGENIERÍA DE SISTEMAS / COGENERACIÓN
    </div>
  </body>
</html>