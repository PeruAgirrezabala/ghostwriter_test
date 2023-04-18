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
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
            max-width: 500px;
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
            margin-bottom: 50px;
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
            width: 20%;
            max-width: 20%;
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
            width: 38%;
            max-width: 46%;
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
            text-align: left;
            font-size: 7px;
          }
        
          table.titulo {
            width: 700px !important;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            table-layout:fixed;
          }
          table.titulo td.iz {
                width:50%;
                text-align: left;
                max-width: 150px;
          }
          table.titulo td.ri {
            width:50%;
            text-align: right;
          }
          
          .iz h2 {
              margin-bottom: 5px;
          }
          
          table.titulo td.iz table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
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
        <img src="http://192.168.3.109/erp/img/logo_pdf.png">
        <div id="company">
            <h2 class="name">GENELEK SISTEMAS S.L.</h2>
            <div><? echo $factuDir; ?> </div>
            <!--<div>48940 - Leioa</div>-->
            <div><? echo $factuTlfno; ?></div>
            <div><a href="mailto:<? echo $factuEmail; ?>"><? echo $factuEmail; ?></a></div>
        </div>
      </div>
      
    </div>
    <div>
      