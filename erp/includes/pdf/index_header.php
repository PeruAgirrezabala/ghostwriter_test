<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>PEDIDO</title>
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
            width: 595px;  
            height: 842; 
            margin: 0 auto; 
            color: #555555;
            background: #FFFFFF; 
            font-family: Arial, sans-serif;
            font-size: 11px; 
            font-family: SourceSansPro ;
        }

        #header {
            padding: 10px 0;
            margin-bottom: 20px;
            /*border-bottom: 1px solid #AAAAAA;*/
            max-width: 595px;  
            height: 150px;
        }

        #logo {
            position: relative;
            float: left;
            display: inline-block;
            margin-top: 8px;
        }

        #logo img {
            height: 140px;
        }

        #company {
            position: relative;
            display: inline-block;
            float: right;
            margin-left: 380px;
            /*text-align: right;*/
        }
        #company img {
            /*height: 30px;*/
            width: 100%;
        }

        #details {
            margin-bottom: 10px;
            width: 760px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        .to {
            font-size: 12px;
            magin-top: 20px;
            margin-bottom: 5px;
        }
        .address {
            margin-bottom: 5px;
            font-size: 12px;
            margin-top: 0px;
        }
        .email {
            margin-bottom: 15px;
        }

        h2.name {
            font-size: 12px;
            font-weight: normal;
            margin: 0;
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



        td.ri h2 {
            font-size: 12px;
            font-weight: normal;
            margin: 0;
            margin-top: 0px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            /*page-break-inside:auto;*/
            /*table-layout:fixed;*/
            /*max-width: 500px;*/
        }


        table th,
        table td {
            padding: 5px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
            word-wrap: break-word;         
            overflow-wrap: break-word; 
            font-size: 11px;
            break-inside:auto;
        }

        table tr { 
            break-inside:auto;
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
            font-size: 10px;
            background: #0087C3;
            width: 18%;
            max-width: 18%;
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
            font-size: 10px;
            width: 42.5%;
            max-width: 42.5%;
        }
        
        table .pos {
            text-align: right;
            width: auto;
            font-size: 10px;
            width: 5%;
            max-width: 5%;
        }

        table .desc .obs {
            text-align: left;
            width: auto;
            font-size: 9px;
            width: 44%;
            max-width: 47%;
            color: #333333;
        }

        table .fab {
            text-align: left;
            width: auto;
            font-size: 10px;
            width: 10%;
            max-width: 10%;
        }

        table .unit {
            background: #DDDDDD;
            font-size: 10px;
            text-align: center;
            width: 9%;
            max-width: 9%;
            white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
            white-space: -webkit-pre-wrap; /*Chrome & Safari */ 
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            white-space: pre-wrap;       /* css-3 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
            word-break: break-all;
            white-space: normal;
        }

        table .qty, table .pvp, table .dto {
            font-size: 10px;
            width: 9%;
            max-width: 9%;
        }

        table .total {
            background: #0087C3;
            color: #FFFFFF;
            font-size: 10px;
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

        #thanks {
            font-size: 12px;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;  
        }

        #notices .notice {
            font-size: 12px;
        }
        #notices .observaciones {
            font-size: 10px;
            margin-top: 10px;
            width: 98%;
        }

        .footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: left;
            font-size: 7px;
        }

        .no-break {
            break-inside:avoid !important;
        }
        table.detalles {
            break-inside:auto !important;
            break-before: auto !important;
            break-after: auto !important;
        }
        table.titulo {
            width: 760px;
            height: 275px;
            border-collapse: collapse;
            border-spacing: 0;
            table-layout:fixed;
            margin-bottom: 0px;
            display: block;
            clear: both;
            page-break-inside:avoid !important;
            page-break-before: avoid !important;
            page-break-after: auto !important;
        }
        .iz {
            width:50%;
            text-align: left;
            max-width: 150px;
            background-color: #ffffff;
        }
        .ri {
            width:50%;
            text-align: right;
            background-color: #ffffff;
        }

        .iz h2 {
            margin-bottom: 5px;
        }

        .iz-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 1;
            height: 270px;
            border: 1px #333333 solid;
        }
        .iz-table tr {
            width: 100%;
        }
        .iz-table tr td {
            width: 100%;
        }
        .ri-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .ri-table tr {
            width: 100%;
        }
        .ri-table tr td {
            width: 100%;
        }
        .header-rows {
            color: #FFFFFF;
            font-size: 12px;
            background: #0087C3;
            text-align: left;
        }
        .text-rows {
            color: #333333;
            font-size: 12px;
            background: transparent;
            text-align: left;
            word-wrap: break-word;         
            overflow-wrap: break-word; 
            white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
            white-space: -webkit-pre-wrap; /*Chrome & Safari */ 
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            white-space: pre-wrap;       /* css-3 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
            word-break: break-all;
            white-space: normal;
        }
          
          

    </style>
  </head>
  <body>
    <?
        $factuDir = "Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa";
        $factuTlfno = "943 14 33 11";
        $factuEmail = "genelek@genelek.com";
    ?>
    <div id="header" class="clearfix">
      <div id="logo">
        <img src="http://192.168.3.108/erp/img/logo_pdf.png">
        <div id="company">
            <h2 class="name">GENELEK SISTEMAS S.L.</h2>
            <div><? echo $factuDir; ?> </div>
            <!--<div>48940 - Leioa</div>-->
            <div><? echo $factuTlfno; ?></div>
            <div><a href="mailto:<? echo $factuEmail; ?>"><? echo $factuEmail; ?></a></div>
        </div>
      </div>
        
    </div>
    
      