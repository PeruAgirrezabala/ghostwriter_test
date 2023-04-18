<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT
                ENSAYOS.id,
                ENSAYOS.nombre,
                ENSAYOS.plantilla_id,
                PLANTILLAS.nombre,
                ENTREGAS.proyecto_id,
                PROYECTOS.nombre,
                CLIENTES.id,
                CLIENTES.nombre,
                ENSAYOS.fecha,
                ENSAYOS.erp_userid,
                erp_users.nombre,
                erp_users.apellidos,
                ENSAYOS.descripcion,
                ENTREGAS.instalacion_id,
                CLIENTES_INSTALACIONES.nombre,
                CLIENTES_INSTALACIONES.direccion,
                USERS_DOC.id,
                USERS_DOC_VERSIONES.doc_path
            FROM ENSAYOS
                INNER JOIN ENTREGAS ON ENSAYOS.entrega_id=ENTREGAS.id
                INNER JOIN PLANTILLAS ON ENSAYOS.plantilla_id=PLANTILLAS.id
                INNER JOIN PROYECTOS ON ENTREGAS.proyecto_id=PROYECTOS.id
                INNER JOIN CLIENTES ON PROYECTOS.cliente_id=CLIENTES.id
                INNER JOIN erp_users ON ENSAYOS.erp_userid=erp_users.id
                INNER JOIN CLIENTES_INSTALACIONES ON CLIENTES.id=CLIENTES_INSTALACIONES.cliente_id
                INNER JOIN USERS_DOC ON erp_users.id=USERS_DOC.erpuser_id
                INNER JOIN USERS_DOC_VERSIONES ON USERS_DOC.id=USERS_DOC_VERSIONES.doc_id
            WHERE ENSAYOS.id=".$_GET['id']." AND USERS_DOC.nombre='FIRMA'";
    
    file_put_contents("printProject.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar el Proyecto");
    $registros = mysqli_fetch_row($res);
    
    $ensayoID = $registros[0];
    $nombreEnsayo = $registros[1];
    $plantillaID = $registros[2];
    $nombrePlantilla = $registros[3];
    $proyectoID = $registros[4];
    $nombreProyecto = $registros[5];
    $clienteID = $registros[6];
    $nombreCliente = $registros[7];
    $fecha = $registros[8];
    $tecnicoID = $registros[9];
    $nombreTecnico = $registros[10];
    $apellidosTecnico = $registros[11];
    $descripcionEnsayo = $registros[12];
    $instalacionID = $registros[13];
    $instalacionNombre = $registros[14];
    $instalacionDireccion = $registros[15];
    // 16 docID
    $tecnicoFirma = $registros[17];
    
    //$path = date("Y",strtotime($fecha_ini))."\\".$nombre;
    
    if($instalacionDireccion==""){
        $instalacionDireccion="S/N";
    }
    if($instalacionNombre==""){
        $instalacionNombre="S/N";
    }    
    
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <title>PRUEBAS ARMARIOS</title>
    
    <style>
        @font-face {
            font-family: SourceSansPro;
            src: url(/erp/includes/pdf/SourceSansPro-Regular.ttf);
          }
          @media print {
            @page { margin: 0; }
            body { margin: 0; }
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
              
              /*padding: 0px;
              margin-bottom: 20px;*/
/*              background-image: url("img/Doc1-Reles.png");
              background-size:   cover;                       <------ 
              background-repeat: no-repeat;
              background-position: center center;*/
              /*border-bottom: 1px solid #AAAAAA;*/
              /*max-width: 500px;*/
              /*height: 800px;*/
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
/*              margin-bottom: 110px;
              max-width: 21cm;
              width: 21cm;*/
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
              /*padding: 0px;*/
              /*background: #EEEEEE;*/
              text-align: center;
              /*border-bottom: 1px solid #2222;*/
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
              /*border: none;*/
            }
            
            .tabla-resultados{
                width: 95%;
                margin-right: 20px;
                margin-left: 20px;
            }
            .tabla-resultados th, .tabla-resultados td {
              border: 1px solid #2222;
            }
            .tabla-resultados td, .tabla-resultados th {
                padding-left: 5px;
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
                margin-top: 500px;
                border-top: 1px solid #AAAAAA;
                padding: 8px 0;
                text-align: center;
            }

            .titulo {
                /*width: 700px !important;*/
                /*border-collapse: collapse;*/
                border-spacing: 5px;
                margin-bottom: 20px;
                table-layout:fixed;
                margin-top: 30px;
            }
            .titulo div.iz {
                margin-left: 5%;
                width: 40%;
                float: left;
/*                margin-right: 5%;*/
            }
            .titulo div.ri {
                width: 40%;
                float: right;
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
            #imgHeader{
                position:absolute;
            }
            #header{
                
            }
            #datos0{
                position: relative;
                top: 600px;
                text-align: center;
                left: 100px;
                width: 100px;
                color: #FFFFFF;
            }
            #datos1{
                width: 80px;
                position: relative;
                top: 620px;
            }
            #datos1 > p{
                text-align: right;
            }
            #datos2{
                width: 180px;
                position: relative;
                top: 620px;
            }
            #datos2 > p{
                text-align: left;
            }
            #datos3{
                padding-right: 40px;
                width: 250px;
                position: relative;
                top: 620px;
            }
            #datos3 > p{
                text-align: justify;
            }
            .fila {
                display: table;
                width: 100%; /*Optional*/
                table-layout: fixed; /*Optional*/
                border-spacing: 10px; /*Optional*/
                /*PAGE-BREAK-AFTER: always;*/
            }
            .columna {
                display: table-cell;
                
            }
            #logoGen{
                float: left;
                width: 200px;
                margin-top: 15px;
                opacity: 0.5;
                content:url("/erp/img/GENELEKSISTEMASS.L._logo-sticky.png");
            }
            #logoBure{
                float: right;
                width: 200px;
                opacity: 0.5;
                content:url("/erp/img/BureauVeritas.png");
            }
            #logoblanco{
                content:url("/erp/img/genelekblanco.png");
                position: relative;
                top: 0;
                float: right;
            }
            #tituloPrueba{
                font-size: 2em;
                color: black;
                position: relative;
                top: 550px;
                float: right;
                padding-left: 30%;
                padding-right: 3%;
            }
            #firma{
                margin-top: 200px;
                float: right;
                margin-right: 80px;
                width: 40%;
                border: 1px solid #2222;
                height: 80px;
            }
            #imgFirma{
/*                float: right;
                margin-right: 20px;*/
                margin-top: 5px;
                height: 75px;
                width: 80px;
            }
            #pruebasRealizadas{
                margin-top: 35%;
            }
            #pruebasRealizadas > h4{
                margin-left: 15%;
            }
            .tabla-ensayos-info{
                margin-left: 15%;
                max-width: 580px;
                border-collapse: collapse;
            }
            .tabla-ensayos-info > tr, td{
                border: 0.5px solid grey;
                
            }
            .tabla-ensayos-info > tbody > tr > td:first-child{
                padding: 5px;
                max-width: 80px;
            }
            .tabla-ensayos-info > tbody > tr > td:last-child{
                text-align: center;
            }
            .grupo-2{
                PAGE-BREAK-AFTER: always;
            }
    </style>
    <script>
        $(document).ready(function() {
           window.print(); 
        });
    </script>
  </head>
  <body>
    
    <div id="header" style="height: 1050px; width: 800px;">
        <img id="imgHeader" src="img/fondoplantilla.png" style="height: 1100px; width: 800px;"/>
        <div id="logoblanco"></div>
        <div id="tituloPrueba">
            <h1>Pruebas Armario</h1>
        </div>        
        <div id="datos0">
            <h1><? echo $nombreEnsayo; ?></h1>
            <h2><? echo $fecha; ?></h2>
        </div>
        <div class="fila">
            <div id="datos1" class="columna">
                <p>CLIENTE :</p>
                <p>INSTALACIÓN :</p>
                <p>DIRECCIÓN :</p>
                <p>FECHA :</p>
                <p>TÉCNICO :</p>
            </div>
            <div id="datos2" class="columna">
                <p><? echo $nombreCliente; ?></p>
                <p><? echo $instalacionNombre; ?></p>
                <p><? echo $instalacionDireccion; ?></p>
                <p><? echo $fecha; ?></p>
                <p><? echo $nombreTecnico." ".$apellidosTecnico; ?></p>            
            </div>
            <div id="datos3" class="columna">
                <p><? echo $descripcionEnsayo; ?></p>
            </div>
        </div>
    </div>
    <div id='details'>
        <div id="cabecera">
            <div id="logoGen"></div>
            <div id="logoBure"></div>
        </div>
        <h1 style="padding-top: 120px;">
            <? echo $nombreEnsayo; ?>
        </h1>
        
        <div class='titulo'>
            <div class='iz' colspan="2">
                    <h2 class='titdetalles'>INSTALACIÓN</h2>
                    <p>Instalación: <? echo $instalacionNombre; ?></p><p>Dirección: <? echo $instalacionDireccion; ?></p><p>Técnico: <? echo $nombreTecnico." ".$apellidosTecnico; ?></p><p>Fecha: <? echo $fecha; ?></p><p>Fabricante:</p><p>Modelo:</p>
                </div>
            
                <div class='iz' colspan="2">
                    <h2 class='titdetalles'>RESULTADOS DE LAS PRUEBAS</h2>
                    <p><? echo $descripcionEnsayo; ?></p>
                </div>
            
        </div>
        <div id="pruebasRealizadas">
        <?
       $sql="SELECT 
                ENSAYOS_PLANTILLAS.id,
                ENSAYOS_PLANTILLAS.plantilla_id,
                ENSAYOS_PLANTILLAS.nombre,
                ENSAYOS_PLANTILLAS.grupo_id,
                ENSAYOS_PLANTILLA_GRUPO.nombre,
                ENSAYOS_PRUEBAS.estado_id,
                ENSAYOS_PRUEBAS.id,
                ENSAYOS_PRUEBAS.texto
              FROM ENSAYOS_PLANTILLAS, ENSAYOS_PLANTILLA_GRUPO, ENSAYOS_PRUEBAS
              WHERE ENSAYOS_PLANTILLAS.plantilla_id =".$_GET["plantilla_id"]."
              AND ENSAYOS_PLANTILLAS.grupo_id = ENSAYOS_PLANTILLA_GRUPO.id
              AND ENSAYOS_PLANTILLAS.id = ENSAYOS_PRUEBAS.ensayoplantilla_id
              AND ENSAYOS_PRUEBAS.ensayo_id=".$_GET["id"]."
              ORDER BY ENSAYOS_PLANTILLAS.id ASC ,ENSAYOS_PLANTILLAS.grupo_id ASC";
        file_put_contents("log00012.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error al realizar select de INFO Ensayos (Armarios).");
        $ahtml="";
        $count=0;
        $countgroup=0;
        $grupoanterior=0;
        // Hacer un while y comparar cada uno. ENSAYOS_PRUEBAS where ensayo_id=X.
        while ($row = mysqli_fetch_array($res)) {
            
            if($count==0){ // La primera vez:
                $ahtml="<h4>".$row[4]."</h4>";
                $ahtml.='<table class="table table-striped table-hover tabla-ensayos-info" id="grupo-'.$row[3].'">
                        <tbody>
                        <tr data-id="'.$row[0].'">
                            <td class="text-left">'.$row[2].'</td>
                            <td class="text-left" style="width: 80px;">'.$row[7].'</td>
                        </tr>';
                $grupoanterior=$row[3];
            }
            if($grupoanterior!=$row[3]){ // Si hay que iniciar otro grupo
                $countgroup++;
                if($countgroup==3 || $countgroup==6){ // Salto página manual
                    $salto = "grupo-2";
                }else{
                    $salto = "";
                }
                if($countgroup==4 || $countgroup==7){
                    $cabezera='<div id="cabecera">
                        <div id="logoGen"></div>
                        <div id="logoBure"></div>
                        <br><br><br><br><br><br><br><br>
                    </div>';
                }else{
                    $cabezera='';
                }
                $ahtml.='</tbody></table>
                        '.$cabezera.'
                        <h4>'.$row[4].'</h4>
                        <table class="table table-striped table-hover tabla-ensayos-info '.$salto.'" id="grupo-'.$row[3].'">
                        <tbody>
                        <tr data-id="'.$row[0].'">
                            <td class="text-left">'.$row[2].'</td>
                            <td class="text-left" style="width: 80px;">'.$row[7].'</td>
                        </tr>';
            }elseif($count!=0){
                $ahtml.='<tr data-id="'.$row[0].'">
                            <td class="text-left">'.$row[2].'</td>
                            <td class="text-left" style="width: 80px;">'.$row[7].'</td>
                        </tr>';
            }
            $grupoanterior=$row[3];
            $count++;
        }
        $ahtml.='</tbody></table>';
        echo $ahtml;
        ?>
        </div>
        
        <div id="firma">
            <div style="margin-bottom: 0px; float: left; margin-left: 5px;">Firma, el técnico de Genelek Sistemas S.L.:</div>
            <img id="imgFirma" src="<? echo "//192.168.3.108/".$tecnicoFirma; ?>" />
        </div>
        
    </div>  
        
        
        
    
    <div class="footer">
        GENELEK SISTEMAS S.L. - INGENIERÍA DE SISTEMAS / COGENERACIÓN
    </div>
  </body>
</html>