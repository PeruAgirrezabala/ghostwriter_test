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
            font-family: SourceSansPro;
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
            page-break-inside:avoid !important;
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
            page-break-inside:avoid !important; 
          }
          
          table tr { 
              page-break-inside:avoid !important; 
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
            width: 10%;
            max-width: 10%;
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
            width: 760px;
            height: 275px;
            border-collapse: collapse;
            border-spacing: 0;
            table-layout:fixed;
            margin-bottom: 0px;
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
        <div id="header" class="clearfix">
      <div id="logo">
        <img src="http://192.168.3.109/erp/img/logo_pdf.png">
        <div id="company">
            <h2 class="name">GENELEK SISTEMAS S.L.</h2>
            <div>Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa </div>
            <!--<div>48940 - Leioa</div>-->
            <div>943 14 33 11</div>
            <div><a href="mailto:genelek@genelek.com">genelek@genelek.com</a></div>
        </div>
      </div>
        
    </div>
    <div>
      
                    <div id='details' class='clearfix'>
                        <hr style='width: 100%; border: 3px solid #666666;'>
                        <table class='titulo' >
                            <tr>
                                <td class='iz'>
                                    <table class='iz-table' cellspacing='0' cellpadding='0'>
                                        <thead>
                                            <tr>
                                                <th class='header-rows'>PROVEEDOR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class='text-rows'>OFERTA: </td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>NOMBRE: SCHNEIDER ELECTRIC</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>DIRECCIÓN: CARRETERA NACIONAL II, KM.592</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>EMAIL: </td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>AT/ATT: ENRIQUE MENDOZA, JON SANCHEZ</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class='ri'>
                                    <table class='iz-table' cellspacing='0' cellpadding='0'>
                                        <thead>
                                            <tr>
                                                <th class='header-rows'>DATOS DEL PEDIDO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class='text-rows'>PEDIDO: P190125</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>FECHA: 2019-08-29</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>LUGAR DE ENTREGA: </td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>GENELEK SISTEMAS S.L. <br> Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </table>
                        <hr style='width: 100%; border: 3px solid #666666;'>
                    </div>
                    
                    <table border='0' cellspacing='0' cellpadding='0' class='detalles'>
                        <thead>
                            <tr style='border-bottom: solid 1px #ffffff;'>
                                <th class='no'>REF</th>
                                <th class='desc'>DESCRIPCIÓN</th>
                                <th class='qty'>CANTIDAD</th>
                                <th class='pvp'>NETO</th>
                                <th class='dto'>DTO</th>
                                <th class='total'>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                     
                    <tr>
                        <td class='no'>BMEXBP0400</td>
                        <td class='desc'><h3>BASTIDOR X-BUS + ETHERNET 4 SLOTS</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>221.86€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>199.67€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMXCPS2010</td>
                        <td class='desc'><h3>M340, MÓDULO ALIMENTACIÓN 24VCC 17W</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>247.97€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>223.17€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMEH582040</td>
                        <td class='desc'><h3>CPU M580 2040 H HOT-STANDBY</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>3,327.55€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>2,994.80€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMENOC0301</td>
                        <td class='desc'><h3>M580, MÓDULO DE COMUNICACIONES ETHERNET NOC CON RSTP</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>1,198.00€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>1,078.20€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>490NAC0100</td>
                        <td class='desc'><h3>CONECTOR SFP RJ45 LINK. HOT-STANDBY</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>178.64€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>160.78€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMEXBP1002</td>
                        <td class='desc'><h3>M580, RACK ETH 10 POS. FA DUAL</h3></td>
                        <td class='qty'>1</td>
                        <td class='unit'>533.13€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>239.91€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMXCPS4022</td>
                        <td class='desc'><h3>M580  FA 24-48 vDC  REDUNDANT</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>757.50€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>681.75€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMXCRA31210</td>
                        <td class='desc'><h3>M340, MÓDULO DE RED PERIFERIA RIO ETHERNET CON RSTP</h3></td>
                        <td class='qty'>1</td>
                        <td class='unit'>850.00€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>382.50€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMXDDI3202K</td>
                        <td class='desc'><h3>M340, MÓDULO DE E/S DIGITALES, 32 ENTRADAS 24VCC</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>337.10€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>303.39€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMXDDO1602</td>
                        <td class='desc'><h3>M340, MÓDULO DE E/S DIGITALES, 16 SALIDAS TRT 24VCC </h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>213.70€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>192.33€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMXAMI0810</td>
                        <td class='desc'><h3>M340,08 EA 16BITS,AISLADAS,+-10V,+-20MA</h3></td>
                        <td class='qty'>1</td>
                        <td class='unit'>677.52€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>304.88€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>ABE7H16R20</td>
                        <td class='desc'><h3>TELEFAST,16 ED/SD,2T/C,NO LED,TORNILLOS</h3></td>
                        <td class='qty'>4</td>
                        <td class='unit'>98.14€</td>
                        <td class='unit'>50.00%  </td>
                        <td class='total'>196.28€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMXFCC203</td>
                        <td class='desc'><h3>TELEFAST, CABLE 2M DE CONEXIÓN 40 POLOS A HE10 PARA BASES E/S DIGITALES</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>67.60€</td>
                        <td class='unit'>50.00%  </td>
                        <td class='total'>67.60€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>ABE7CPA02</td>
                        <td class='desc'><h3>TELEFAST, SUB-BASE E/S PASIVAS, 8 ENTRADAS ANALÓGICAS</h3></td>
                        <td class='qty'>1</td>
                        <td class='unit'>138.02€</td>
                        <td class='unit'>50.00%  </td>
                        <td class='total'>69.01€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>BMXFTA150</td>
                        <td class='desc'><h3>M340, BONRERO 28P+ CONECTOR SUB-D25_1.5m</h3></td>
                        <td class='qty'>1</td>
                        <td class='unit'>63.78€</td>
                        <td class='unit'>50.00%  </td>
                        <td class='total'>31.89€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>HMIGTO5310</td>
                        <td class='desc'><h3>PANTALLA MAGELIS 10 " COLOR</h3></td>
                        <td class='qty'>2</td>
                        <td class='unit'>1,834.98€</td>
                        <td class='unit'>40.00%  </td>
                        <td class='total'>2,201.98€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>TCSESU083FN0</td>
                        <td class='desc'><h3>SWITCH NO GEST.8 RJ45</h3></td>
                        <td class='qty'>1</td>
                        <td class='unit'>197.14€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>88.71€</td>
                    </tr>
                 
                    <tr>
                        <td class='no'>EGX150</td>
                        <td class='desc'><h3>GATEWAY EGX150 BRIDGE MODBUS/ETHERNET</h3></td>
                        <td class='qty'>1</td>
                        <td class='unit'>572.61€</td>
                        <td class='unit'>55.00%  </td>
                        <td class='total'>257.67€</td>
                    </tr>
                 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan='3' style='padding-top: 20px;'></td>
                        <td colspan='2' style='padding-top: 20px;' class='footerfondo'>SUBTOTAL</td>
                        <td style='padding-top: 20px;' class='footerfondo'>9,674.52€</td>
                      </tr>
                      <!--
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='footerfondo'>IVA 21%</td>
                        <td class='footerfondo'>2,031.65€</td>
                      </tr>
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='total-final footerfondo'>TOTAL</td>
                        <td class='total-final footerfondo'>11,706.17€</td>
                      </tr>
                      -->
                    </tfoot>
                </table> 
            <div id="thanks"></div>
      <div id="notices">
        <div>Plazo de entrega: </div>
        <div style="color: #f4df42 !important;">Forma de pago: 90 DiAS F.F. FIN DE MES</div>
      </div>
    </div>
    <div class="footer">
        En cumplimiento de lo establecido en la Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPD-GDD), le comunicamos que los datos que usted nos facilite quedarán incorporados y serán tratados en los ficheros titularidad de Genelek Sistemas S.L. con el fin de poderle prestar nuestros servicios, así como para mantenerle informado sobre cuestiones relativas a la actividad de la empresa y sus servicios.
Mediante la firma del presente documento usted da su consentimiento expreso para que Genelek Sistemas S.L. pueda utilizar con este fin concreto los datos facilitados por usted, comprometiéndose a tratar de forma confidencial los datos de carácter personal facilitados y a no comunicar o ceder dicha información a terceros.
Asimismo, le informamos de la posibilidad que tiene de ejercer los derechos de acceso, rectificación, cancelación y oposición de sus datos de carácter personal mediante escrito dirigido a: Pol. A.D.U. Plaza Urola, s/n - 20750 Zumaia (Gipuzkoa), acompañando copia de DNI.
    </div>
  </body>
</html>