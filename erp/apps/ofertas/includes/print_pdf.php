<?php
    session_start();
    require("../../../common.php");
    require_once($pathraiz."/connection.php");
    
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;
    use Spipu\Html2Pdf\Exception\ExceptionFormatter;
    
    require_once($pathraiz."/includes/plugins/html2pdf/src/Html2Pdf.php");

    //require_once($pathraiz."/includes/plugins/phpMailer/PHPMailer.php");

    //use PHPMailer\PHPMailer\PHPMailer;
    //use PHPMailer\PHPMailer\SMTP;
    //use PHPMailer\PHPMailer\Exception;
    //require_once $pathraiz.'/includes/plugins/phpMailer/PHPMailer.php';
    //require_once $pathraiz.'/includes/plugins/phpMailer/SMTP.php';
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $data = array();
    
    $sql = "SELECT 
                    CLIENTES.nombre,
                    CLIENTES.direccion,
                    CLIENTES.poblacion,
                    CLIENTES.provincia,
                    CLIENTES.cp,
                    CLIENTES.pais,
                    CLIENTES.telefono,
                    CLIENTES.email,
                    OFERTAS.id,
                    OFERTAS.ref,
                    OFERTAS.titulo,
                    OFERTAS.descripcion,
                    OFERTAS.cliente_id,
                    OFERTAS.fecha,
                    OFERTAS.fecha_validez,
                    OFERTAS.path,
                    OFERTAS.dto_final,
                    OFERTAS.forma_pago,
                    OFERTAS.plazo_entrega
                FROM 
                    OFERTAS, CLIENTES 
                WHERE 
                    OFERTAS.cliente_id = CLIENTES.id
                AND
                    OFERTAS.id = ".$_POST['id_oferta'];
    file_put_contents("oferta.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar la Oferta");
    $registrosCLI = mysqli_fetch_row($res);
    $nombreCLI = $registrosCLI[0];
    $dirCLI = $registrosCLI[1];
    $poblacionCLI = $registrosCLI[2];
    $provinciaCLI = $registrosCLI[3];
    $cpCLI = $registrosCLI[4];
    $paisCLI = $registrosCLI[5];
    $tlfnoCLI = $registrosCLI[6];
    $emailCLI = $registrosCLI[7];
    $refOferta = $registrosCLI[9];
    $titOferta = $registrosCLI[8];
    $descOferta = $registrosCLI[11];
    $fechaOferta = $registrosCLI[13];
    $fechavalOferta = $registrosCLI[14];
    $pathoferta = $registrosCLI[15];
    $dtoFinalOferta = $registrosCLI[16];
    $formaPagoOferta = $registrosCLI[17];
    $plazoEntregaOferta = $registrosCLI[18];
    
    $consulta = "SELECT 
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
                    MATERIALES.dto2 
                FROM 
                    MATERIALES
                INNER JOIN MATERIALES_PRECIOS
                    ON MATERIALES_PRECIOS.material_id = MATERIALES.id  
                INNER JOIN OFERTAS_DETALLES_MATERIALES
                    ON OFERTAS_DETALLES_MATERIALES.material_tarifa_id = MATERIALES_PRECIOS.id
                INNER JOIN OFERTAS 
                    ON OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id  
                LEFT JOIN PROVEEDORES_DTO 
                    ON PROVEEDORES_DTO.id = OFERTAS_DETALLES_MATERIALES.dto_prov_id
                WHERE 
                    OFERTAS.id = ".$_POST['id_oferta']." 
                ORDER BY 
                    OFERTAS_DETALLES_MATERIALES.id ASC";
    
    file_put_contents("detallesMateriales.txt", $consulta);
    $resultado = mysqli_query($connString, $consulta) or die("Error al consultar los Materiales de la Oferta");
    
    // ************************ CONSTRUCCION DE OFERTA ******************************
    // Recoger HTML
    ob_start();
    require_once($pathraiz."/includes/pdf/index_oferta_header.php");
    $factuDir = "Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa";
    $html = ob_get_clean();

    $contador = 0;
    $totalPVP = 0;
    $totalDTO = 0;
    $total = 0;
    $totalIVA = 0;
    $totalPVPdto = 0;
    $totalOferta = 0;
    
    $html .= "
                    <div id='details' class='clearfix'>
                        <h1 class='presentacion'>VALORACIÓN ECONÓMICA DE LA OFERTA</h1>
                        <table class='titulo'>
                              <tr>
                                  <td class='iz'>
                                        <h1>CLIENTE: </h1>
                                        <div class='to'>".$nombreCLI."</div>
                                        <div class='address'>".$dirCLI."</div>
                                        <div class='address'>".$cpCLI." - ".$poblacionCLI."</div>
                                        <div class='address'>".$provinciaCLI." (".$paisCLI.")</div>
                                        <div class='email'><a href='mailto:".$emailCLI."'>".$emailCLI."</a></div>
                                  </td>
                                  <td class='ri'>
                                        <h1>OFERTA: ".$refOferta."</h1>
                                        <h2>Fecha: ".$fechaOferta."</h2>
                                        <h2>Validez: ".$fechavalOferta."</h2>
                                        <h2 class='name'>DESCRIPCIÓN:</h2>
                                        <p class='address'>".$descOferta."</p>
                                  </td>
                              </tr>
                        </table>
                          
                    
                    ";
    
    while ($registros = mysqli_fetch_array($resultado)) {
        $oferta_id = $_GET['id'];
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
        $dto_sum = 0;
        $pvp_dto = 0;

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

        $totalPVP = $totalPVP + $subtotalDTOCLIapli;
        $totalDTO = $totalDTO + $dtoCliPVP;
        $total = $total + $pvpTOTAL;

        if ($contador == 0) {
            
            $html .= "<div id='saltodiv'>
                    <h2 class='titSeccion'>MATERIALES</h2>
                    <table border='0' cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                            <th class='no'>REF</th>
                            <th class='desc'>MATERIAL</th>
                            <th class='qty'>CANTIDAD</th>
                            <th class='pvp'>PVP</th>
                            <!--<th class='dto'>DTO</th>-->
                            <th class='total'>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                    ";
        } // if contador = 0
        
        $html .= " 
                    <tr>
                        <td class='no'>".$ref."</td>
                        <td class='desc'><h3>".$nombreMat."</h3>".$modeloMat."</td>
                        <td class='qty'>".$cantidad."</td>
                        <td class='unit'>".number_format(($pvpTOTAL/$cantidad), 2)."€</td>
                        <!--<td class='unit'>".$dto_prov."%, ".$dto_mat."%, ".$dto_extra."% </td>-->
                        <td class='total'>".number_format($pvpTOTAL, 2)."€</td>
                    </tr>
                ";
        //$base = $base + ($registros[20]*$registros[18]);
        
        $contador = $contador + 1;
        
    } // while
    
    $totalOferta = $totalOferta + $total;
    
    $html .= " 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan='2' style='padding-top: 20px;'></td>
                        <td colspan='2' style='padding-top: 20px;' class='footerfondo'>TOTAL</td>
                        <td style='padding-top: 20px;' class='footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      <!--
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='footerfondo'>IVA 21%</td>
                        <td class='footerfondo'>".number_format($iva, 2)."€</td>
                      </tr>
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='total-final footerfondo'>TOTAL</td>
                        <td class='total-final footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      -->
                    </tfoot>
                </table> </div>
            ";
    
    // TERCEROS
    
    $sql = "SELECT 
                PROVEEDORES.id as tercero,
                PROVEEDORES.nombre,
                OFERTAS_DETALLES_TERCEROS.cantidad,
                OFERTAS_DETALLES_TERCEROS.unitario,
                OFERTAS_DETALLES_TERCEROS.titulo,
                OFERTAS_DETALLES_TERCEROS.descripcion,
                OFERTAS_DETALLES_TERCEROS.incremento,
                OFERTAS_DETALLES_TERCEROS.dto1,
                OFERTAS_DETALLES_TERCEROS.pvp,
                OFERTAS_DETALLES_TERCEROS.pvp_dto,
                OFERTAS_DETALLES_TERCEROS.pvp_total, 
                OFERTAS_DETALLES_TERCEROS.id as detalle
            FROM 
                PROVEEDORES, OFERTAS_DETALLES_TERCEROS, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_TERCEROS.tercero_id = PROVEEDORES.id
            AND
                OFERTAS_DETALLES_TERCEROS.oferta_id = OFERTAS.id 
            AND 
                OFERTAS.id = ".$_POST['id_oferta']." 
            ORDER BY 
                OFERTAS_DETALLES_TERCEROS.id ASC";
    file_put_contents("detallesTerceros.txt", $sql);
    $contador = 0;
    $totalPVP = 0;
    $totalDTO = 0;
    $total = 0;
    $totalIVA = 0;
    $totalPVPdto = 0;
    $resultado = mysqli_query($connString, $sql) or die("Error al consultar los Materiales de la Oferta");
    while ($registros = mysqli_fetch_array($resultado)) {
        $nombrePROV = $registros[1];
        $cantidad = $registros[2];
        $unitario = $registros[3];
        $tituloSUB = $registros[4];
        $descripcionSUB = $registros[5];
        $incSUB = $registros[6];
        $dto = $registros[7];
        $pvp = $registros[8];
        $pvpdto = $registros[9];
        $pvptotal = $registros[10];
        $id = $registros[11];

        $totalPVP = $totalPVP + $pvp;
        $totalDTO = $totalDTO + ($pvp - $pvpdto);
        $totalPVPdto = $totalPVPdto + $pvpdto;
        $total = $total + $pvptotal;
        
        if ($contador == 0) {
            $html .= "<div id='saltodiv'>
                    <h2 class='titSeccion'>SUBCONTRATACIONES</h2>
                    <table border='0' cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th class='descSolo'>CONCEPTO</th>
                                <th class='qty'>CANTIDAD</th>
                                <th class='pvp'>PVP</th>
                                <th class='total'>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
        } // if contador = 0
        
        $html .= " 
                    <tr>
                        <td class='descSolo'><h3>".$tituloSUB."</h3></td>
                        <td class='qty'>".$cantidad."</td>
                        <td class='unit'>".number_format($unitario, 2)."€</td>
                        <td class='total'>".number_format($pvptotal, 2)."€</td>
                    </tr>
                ";
        //$base = $base + ($registros[20]*$registros[18]);
        
        $contador = $contador + 1;
    } //while
    
    $totalOferta = $totalOferta + $total;

    
    $html .= " 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style='padding-top: 20px;'></td>
                        <td colspan='2' style='padding-top: 20px;' class='footerfondo'>TOTAL</td>
                        <td style='padding-top: 20px;' class='footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      <!--
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='footerfondo'>IVA 21%</td>
                        <td class='footerfondo'>".number_format($iva, 2)."€</td>
                      </tr>
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='total-final footerfondo'>TOTAL</td>
                        <td class='total-final footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      -->
                    </tfoot>
                </table> </div>
            ";
    
    // MANO DE OBRA
    
    $sql = "SELECT 
                TAREAS.id as tarea,
                TAREAS.nombre,
                OFERTAS_DETALLES_HORAS.cantidad,
                PERFILES_HORAS.precio,
                OFERTAS_DETALLES_HORAS.titulo,
                OFERTAS_DETALLES_HORAS.descripcion,
                OFERTAS_DETALLES_HORAS.dto,
                OFERTAS_DETALLES_HORAS.pvp,
                OFERTAS_DETALLES_HORAS.pvp_total, 
                OFERTAS_DETALLES_HORAS.id as detalle
            FROM 
                TAREAS, PERFILES, PERFILES_HORAS, OFERTAS_DETALLES_HORAS, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_HORAS.tarea_id = TAREAS.id
            AND
                TAREAS.perfil_id = PERFILES.id
            AND
                PERFILES_HORAS.perfil_id = PERFILES.id
			AND
                PERFILES_HORAS.id = OFERTAS_DETALLES_HORAS.tipo_hora_id
            AND
                OFERTAS_DETALLES_HORAS.oferta_id = OFERTAS.id 
            AND 
                OFERTAS.id = ".$_POST['id_oferta']."
            ORDER BY 
                OFERTAS_DETALLES_HORAS.id ASC";
    file_put_contents("detallesManodeObra.txt", $sql);
        
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Mano de Obra");

    $contador = 0;
    $totalPVP = 0;
    $totalDTO = 0;
    $total = 0;
    $totalIVA = 0;
    $totalPVPdto = 0;
    while ($registros = mysqli_fetch_array($resultado)) {
        $nombreTAR = $registros[1];
        $cantidadMANO = $registros[2];
        $unitarioMANO = $registros[3];
        $tituloMANO = $registros[4];
        $descripcionMANO = $registros[5];
        $dto = $registros[6];
        $pvp = $registros[7];
        $pvptotal = $registros[8];
        $id = $registros[9];

        $totalPVP = $totalPVP + $pvp;
        $totalDTO = $totalDTO + ($pvp - $pvptotal);
        $total = $total + $pvptotal;

        if ($contador == 0) {
            $html .= "<div id='saltodiv'>
                    <h2 class='titSeccion'>MANO DE OBRA</h2>
                    <table border='0' cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th class='descSolo'>CONCEPTO</th>
                                <th class='qty'>CANTIDAD</th>
                                <th class='pvp'>PVP</th>
                                <th class='total'>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
        } // if contador = 0

        $html .= " 
                    <tr>
                        <td class='descSolo'><h3>".$nombreTAR." ".$tituloMANO."</h3></td>
                        <td class='qty'>".$cantidadMANO."</td>
                        <td class='unit'>".number_format($unitarioMANO, 2)."€</td>
                        <td class='total'>".number_format($pvptotal, 2)."€</td>
                    </tr>
                ";
        //$base = $base + ($registros[20]*$registros[18]);

        $contador = $contador + 1;
    } //while
    
    $totalOferta = $totalOferta + $total;
    
    $html .= " 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style='padding-top: 20px;'></td>
                        <td colspan='2' style='padding-top: 20px;' class='footerfondo'>TOTAL</td>
                        <td style='padding-top: 20px;' class='footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      <!--
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='footerfondo'>IVA 21%</td>
                        <td class='footerfondo'>".number_format($iva, 2)."€</td>
                      </tr>
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='total-final footerfondo'>TOTAL</td>
                        <td class='total-final footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      -->
                    </tfoot>
                </table> </div>
            ";
    
    // VIAJES
    
    $sql = "SELECT 
                OFERTAS_DETALLES_VIAJES.cantidad,
                OFERTAS_DETALLES_VIAJES.unitario,
                OFERTAS_DETALLES_VIAJES.titulo,
                OFERTAS_DETALLES_VIAJES.descripcion,
                OFERTAS_DETALLES_VIAJES.incremento,
                OFERTAS_DETALLES_VIAJES.pvp,
                OFERTAS_DETALLES_VIAJES.pvp_total, 
                OFERTAS_DETALLES_VIAJES.id as detalle
            FROM 
                OFERTAS_DETALLES_VIAJES, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_VIAJES.oferta_id = OFERTAS.id 
            AND 
                OFERTAS.id = ".$_POST['id_oferta']."
            ORDER BY 
                OFERTAS_DETALLES_VIAJES.id ASC";
    file_put_contents("detallesViajes.txt", $sql);
        
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Mano de Obra");
    
    $contador = 0;
    $totalPVP = 0;
    $totalDTO = 0;
    $total = 0;
    $totalIVA = 0;
    $totalPVPdto = 0;
    while ($registros = mysqli_fetch_array($resultado)) {
        $oferta_id = $_GET['id'];
        $cantidadVI = $registros[0];
        $unitarioVI = $registros[1];
        $tituloVI = $registros[2];
        $descripcionVI = $registros[3];
        $incrementoVI = $registros[4];
        $pvp = $registros[5];
        $pvptotal = $registros[6];
        $id = $registros[7];

        $totalPVP = $totalPVP + $pvp;
        $total = $total + $pvptotal;

        if ($contador == 0) {
            $html .= "<div id='saltodiv'>
                    <h2 class='titSeccion'>VIAJES Y DESPLAZAMIENTOS</h2>
                    <table border='0' cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th class='descSolo'>CONCEPTO</th>
                                <th class='qty'>CANTIDAD</th>
                                <th class='pvp'>PVP</th>
                                <th class='total'>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
        } // if contador = 0

        $html .= " 
                    <tr>
                        <td class='descSolo'><h3>".$tituloVI."</h3></td>
                        <td class='qty'>".$cantidadVI."</td>
                        <td class='unit'>".number_format($unitarioVI, 2)."€</td>
                        <td class='total'>".number_format($pvptotal, 2)."€</td>
                    </tr>
                ";
        //$base = $base + ($registros[20]*$registros[18]);

        $contador = $contador + 1;
    } //while
    
    $totalOferta = $totalOferta + $total;
    
    $html .= " 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style='padding-top: 20px;'></td>
                        <td colspan='2' style='padding-top: 20px;' class='footerfondo'>TOTAL</td>
                        <td style='padding-top: 20px;' class='footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      <!--
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='footerfondo'>IVA 21%</td>
                        <td class='footerfondo'>".number_format($iva, 2)."€</td>
                      </tr>
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='total-final footerfondo'>TOTAL</td>
                        <td class='total-final footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      -->
                    </tfoot>
                </table> </div>
            ";
    
    // OTROS
    
    $sql = "SELECT 
                OFERTAS_DETALLES_OTROS.cantidad,
                OFERTAS_DETALLES_OTROS.unitario,
                OFERTAS_DETALLES_OTROS.titulo,
                OFERTAS_DETALLES_OTROS.descripcion,
                OFERTAS_DETALLES_OTROS.incremento,
                OFERTAS_DETALLES_OTROS.pvp,
                OFERTAS_DETALLES_OTROS.pvp_total, 
                OFERTAS_DETALLES_OTROS.id as detalle
            FROM 
                OFERTAS_DETALLES_OTROS, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_OTROS.oferta_id = OFERTAS.id 
            AND 
                OFERTAS.id = ".$_POST['id_oferta']."
            ORDER BY 
                OFERTAS_DETALLES_OTROS.id ASC";
        file_put_contents("detallesOtros.txt", $sql);
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Otros");
        
        $contador = 0;
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $oferta_id = $_GET['id'];
            $cantidadOTR = $registros[0];
            $unitarioOTR = $registros[1];
            $tituloOTR = $registros[2];
            $descripcionOTR = $registros[3];
            $incrementoOTR = $registros[4];
            $pvp = $registros[5];
            $pvptotal = $registros[6];
            $id = $registros[7];
            
            $totalPVP = $totalPVP + $pvp;
            $total = $total + $pvptotal;
            
            if ($contador == 0) {
            $html .= "<div id='saltodiv'>
                    <h2 class='titSeccion'>OTROS CONCEPTOS</h2>
                    <table border='0' cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th class='descSolo'>CONCEPTO</th>
                                <th class='qty'>CANTIDAD</th>
                                <th class='pvp'>PVP</th>
                                <th class='total'>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
        } // if contador = 0

        $html .= " 
                    <tr>
                        <td class='descSolo'><h3>".$tituloOTR."</h3></td>
                        <td class='qty'>".$cantidadOTR."</td>
                        <td class='unit'>".number_format($unitarioOTR, 2)."€</td>
                        <td class='total'>".number_format($pvptotal, 2)."€</td>
                    </tr>
                ";
        //$base = $base + ($registros[20]*$registros[18]);

        $contador = $contador + 1;
    } //while
    
    $totalOferta = $totalOferta + $total;
    
    $html .= " 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style='padding-top: 20px;'></td>
                        <td colspan='2' style='padding-top: 20px;' class='footerfondo'>TOTAL</td>
                        <td style='padding-top: 20px;' class='footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      <!--
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='footerfondo'>IVA 21%</td>
                        <td class='footerfondo'>".number_format($iva, 2)."€</td>
                      </tr>
                      <tr>
                        <td colspan='3'></td>
                        <td colspan='2' class='total-final footerfondo'>TOTAL</td>
                        <td class='total-final footerfondo'>".number_format($total, 2)."€</td>
                      </tr>
                      -->
                    </tfoot>
                </table> </div>
            ";
    
    // TOTAL OFERTA
    $html .= "
                    <table border='0' cellspacing='0' cellpadding='0'>
                        <tbody>
                            <tr>
                                <td class='descSolo'><h3></h3></td>
                                <td class='qty'></td>
                                <td class='unit'></td>
                                <td class='total'></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                              <td colspan='2' style='padding-top: 20px;'><strong>TOTAL OFERTA</strong></td>
                              <td colspan='2' style='padding-top: 20px;' class='footerfondoTotal'><strong>".number_format($totalOferta, 2)."€</strong></td>
                            </tr>";
    if ($dtoFinalOferta != "") {
        $dto = ($totalOferta*$dtoFinalOferta)/100;
        $totalOferta = $totalOferta - $dto;
        $html .= "              <tr>
                                  <td colspan='2' style='padding-top: 20px;'><strong>DTO ".$dtoFinalOferta."% NETO</strong></td>
                                  <td colspan='2' style='padding-top: 20px;' class='footerfondoTotal'><strong>".number_format($totalOferta, 2)."€</strong></td>
                                </tr>
                        ";
    }
    $html .= "          </tfoot>
                    </table></div> ";
    
    ob_start();
    require_once($pathraiz."/includes/pdf/index_oferta_footer.php");
    $html .= ob_get_clean();
    
    file_put_contents("html.txt", $html);
    
    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
    file_put_contents("lgtmp0.txt", 0);
    //$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first dg ds gd gsd  test');
    $html2pdf->writeHTML($html);
    file_put_contents("lgtmp1.txt", 0);
    $nombrefichero = (str_replace("/", "", $refOferta)).".pdf";
    file_put_contents("lgtmp2.txt", 0);
//    if ($pathoferta != "") {
//        $outputFile = "ERP/OFERTAS".$pathoferta.$nombrefichero;
//    }
//    else {
//        $outputFile = "ERP/OFERTAS/TEMP/".$nombrefichero;
//    }
    $outputFile = "ERP/OFERTAS/TEMP/".$nombrefichero;
    
    $tempfile = "temp/".$nombrefichero;
    file_put_contents("log.txt", "refOferta: ".$refOferta."\n || nombrefichero: ".$nombrefichero."\n || outputFile: ".$outputFile."\n || tempfile: ".$tempfile);
    $eMailAtachment = $html2pdf->Output(__DIR__."/".$tempfile, "F");
    
    $ftp_server = "192.168.3.108";
    $ftp_username = "admin";
    $ftp_password = "Sistemas2111";
    ///share/MD0_DATA/Download/

// connection to ftp
    $ftp_connection = ftp_connect($ftp_server);
    $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
    
    $destination_directory = $outputFile;
    $source_directory = $tempfile;

    $upload = ftp_put($ftp_connection, $destination_directory, $source_directory, FTP_ASCII);
     file_put_contents("log1.txt",$upload);
    if ($upload == 1) {
        $success = true;
        echo "/erp/apps/ofertas/includes/".$tempfile;
    }
    else {
        $success = false;
        echo "error";
    }
    

    
    // ************************ /CONSTRUCCION DE FACURA ******************************
    
    /*
    $mail = new PHPMailer;  
    
    $salto = chr(13).chr(10);
    if(isset($_POST['notif_email'])) {
        $email = trim($_POST['notif_email']);

        //try
        //{ 
            /*
            $stmt = $db_con->prepare("SELECT * FROM tools_users WHERE user_email='".$email."'");
            $stmt->execute(array(":usermail"=>$email));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
            if($count > 0){
                    $db_con->query("UPDATE tools_users 
                                        SET user_password = '".$password."' WHERE user_email = '".$email."'");
            
                    /*
                    $para      = $email;
                    //$para      = 'julen@gogolan.net';
                    $titulo    = 'CRM WEROI // Cambio de password';
                    $mensaje   = 'Su nueva password es: '. $strPassword;
                    $cabeceras = 'From: noreply@gogolan.net' . $salto .
                        'X-Mailer: PHP/' . phpversion();

                    mail($para, $titulo, $mensaje, $cabeceras);
                    
                    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
                    //$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first dg ds gd gsd  test');
                    $html2pdf->writeHTML($html);
                    $eMailAtachment = $html2pdf->output("factura".$_POST['notif_numfactu'].".pdf", "F");
                    
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('noreply@ongibili.com', 'ONGIBILI');
                    $mail->addAddress($email, '');
                    $mail->addAddress("info@ongibili.com", '');
                    $mail->addAddress("julen@gogolan.net", '');
                    $mail->AddAttachment("factura".$_POST['notif_numfactu'].".pdf");
                    $mail->isHTML(true); 
                    $mail->Subject  = $_POST['notif_asunto'];
                    $mail->Body     = $_POST['notif_mensaje'];
                    if(!$mail->send()) {
                      echo 'error';
                      echo 'Mailer error: ' . $mail->ErrorInfo;
                    } else {
                      echo 'ok';
                    }

                    //echo "ok"; // log in
            /*
            }
            else{
                    echo "Email no existente"; // wrong details 
            }
             
             
        //}
        //catch(PDOException $e){
                //echo $e->getMessage();
                //echo "Email ya existente.";
        //}
    }
         */                        
?>