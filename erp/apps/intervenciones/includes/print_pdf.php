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
                    PROVEEDORES.nombre,
                    PROVEEDORES.direccion,
                    PROVEEDORES.poblacion,
                    PROVEEDORES.provincia,
                    PROVEEDORES.cp,
                    PROVEEDORES.pais,
                    PROVEEDORES.telefono,
                    PROVEEDORES.email,
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.pedido_genelek, 
                    PEDIDOS_PROV.ref,
                    PEDIDOS_PROV.titulo,
                    PEDIDOS_PROV.descripcion,
                    PEDIDOS_PROV.proveedor_id,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    PEDIDOS_PROV.tecnico_id,
                    PEDIDOS_PROV.proyecto_id,
                    PEDIDOS_PROV.estado_id, 
                    PEDIDOS_PROV.total, 
                    PEDIDOS_PROV.path,
                    PEDIDOS_PROV.ref_oferta_prov,
                    PROVEEDORES.contacto,
                    PEDIDOS_PROV.plazo, 
                    PROVEEDORES.formaPago
                FROM 
                    PEDIDOS_PROV, PROVEEDORES 
                WHERE 
                    PEDIDOS_PROV.proveedor_id = PROVEEDORES.id
                AND
                    PEDIDOS_PROV.id = ".$_POST['id_pedido'];
    file_put_contents("pedido.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar el Proveedor");
    $registrospROV = mysqli_fetch_row($res);
    $pathpedido = $registrospROV[20];
    
    $consulta = "SELECT 
                PEDIDOS_PROV_DETALLES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                MATERIALES.modelo,                
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
                ENTREGAS.nombre,
                erp_users.user_email,
                PEDIDOS_PROV_DETALLES.fecha_entrega 
            FROM 
                PEDIDOS_PROV_DETALLES
            INNER JOIN MATERIALES
                ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
            LEFT JOIN MATERIALES_PRECIOS 
                ON MATERIALES_PRECIOS.id = PEDIDOS_PROV_DETALLES.material_tarifa_id 
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = PEDIDOS_PROV_DETALLES.proyecto_id 
            LEFT JOIN PROVEEDORES_DTO 
                ON PROVEEDORES_DTO.id = PEDIDOS_PROV_DETALLES.dto_prov_id
            LEFT JOIN ENTREGAS
                ON PEDIDOS_PROV_DETALLES.entrega_id = ENTREGAS.id
            LEFT JOIN erp_users
                ON PEDIDOS_PROV_DETALLES.erp_userid = erp_users.id 
            WHERE
                PEDIDOS_PROV_DETALLES.pedido_id = ".$_POST['id_pedido']." 
            ORDER BY 
                PEDIDOS_PROV_DETALLES.id ASC";
    
    file_put_contents("detalles.txt", $consulta);
    $resultado = mysqli_query($connString, $consulta) or die("Error al consultar el Pedido");
    
    // ************************ CONSTRUCCION DE PEDIDO ******************************
    // Recoger HTML
    ob_start();
    require_once($pathraiz."/includes/pdf/index_header.php");
    $factuDir = "Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa";
    $html = ob_get_clean();

    $contador = 0;
    while ($registros = mysqli_fetch_array($resultado)) {
        $dto_total = 0;
        if ($registros[11] != "") {
            $dto_mat = $registros[11];
        }
        else {
            $dto_mat = 0.00;
        }
        if ($registros[15] != "") {
            $dto_prov = $registros[15];
        }
        else {
            $dto_prov = 0.00;
        }
        if ($registros[16] != "") {
            $dto_extra = $registros[16];
        }
        else {
            $dto_extra = 0.00;
        }
        $dto_prov_activo = $registros[12];
        $dto_mat_activo = $registros[13];
        $dto_ad_activo = $registros[14];
        $base = ($registros[6]*$registros[5]);
        
        // Sumatorio de descuentos activos
        if ($dto_prov_activo == 1) {
            $dto_total = $dto_total + $dto_prov;
        }
        if ($dto_mat_activo == 1) {
            $dto_total = $dto_total + $dto_mat;
        }
        if ($dto_ad_activo == 1) {
            $dto_total = $dto_total + $dto_extra;
        }
        $dto = (100-$dto_total)/100;
        
        // Aplicación del descuento al precio base
        if ($dto <> 0) {
           $basedto = $base*$dto; 
        }
        else {
            $basedto = $base;
        }

        $totalDto = $totalDto + $basedto;
        $totalBase = $totalBase + $basedto;
        //$iva = $iva + ($basedto*21)/100;
        //$total = $total + ($basedto + $iva);
        if ($contador == 0) {
            $html .= "
                    <div id='details' class='clearfix'>
                        <table class='titulo'>
                              <tr>
                                  <td class='iz'>
                                        <h1>REF. SU OFERTA: ".$registrospROV[21]."</h1>
                                        <div class='to'>A/TO:</div>
                                        <h2 class='name'>".$registrospROV[0]."</h2>
                                        <div class='address'>".$registrospROV[1]."</div>
                                        <div class='email'><a href='mailto:".$registrospROV[7]."'>$registrospROV[7]</a></div>
                                        <div class='to'>At./Att.:</div>
                                        <h2 class='name'>".$registrospROV[22]."</h2>
                                  </td>
                                  <td class='ri'>
                                        <h1>PEDIDO Nº: ".$registrospROV[9]."</h1>
                                        <h2>Fecha: ".$registrospROV[14]."</h2>
                                        <h2>Lugar de Entrega:</h2>
                                        <h2 class='name'>GENELEK SISTEMAS S.L.</h2>
                                        <p class='address'>Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa</p>
                                  </td>
                              </tr>
                        </table>
                          
                    </div>
                    ";
            $html .= "
                    <table border='0' cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                            <th class='no'>REF</th>
                            <th class='desc'>MATERIAL</th>
                            <th class='qty'>CANTIDAD</th>
                            <th class='pvp'>PVP</th>
                            <th class='dto'>DTO</th>
                            <th class='total'>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                    ";
        } // if contador = 0
        
        $html .= " 
                    <tr>
                        <td class='no'>".$registros[1]."</td>
                        <td class='desc'><h3>".$registros[2]."</h3>".$registros[4]."</td>
                        <td class='qty'>".$registros[5]."</td>
                        <td class='unit'>".number_format($registros[6], 2)."€</td>
                        <td class='unit'>".$dto_prov."%, ".$dto_mat."%, ".$dto_extra."% </td>
                        <td class='total'>".number_format($basedto, 2)."€</td>
                    </tr>
                ";
        //$base = $base + ($registros[20]*$registros[18]);
        
        $contador = $contador + 1;
        
        // Mandamos email al interesado de cada artículo
        $salto = "<br>";
        $para = $registros[18];
        $fecha_entrega = $registros[19];
        $mensaje = "Artículo: ".$registros[2].$salto."Referencia: ".$registros[1].$salto."Pedido el: ".$registrospROV[14].$salto."Al proveedor: ".$registrospROV[0].$salto."Con fecha prevista de entrega: ".$fecha_entrega;
        sendMail($para, "Artículo pedido", $mensaje, $de);
    } // while
    
    $iva = ($totalBase * 21) / 100;
    $total = ($totalBase + $iva);
    
    $html .= " 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan='3' style='padding-top: 20px;'></td>
                        <td colspan='2' style='padding-top: 20px;' class='footerfondo'>SUBTOTAL</td>
                        <td style='padding-top: 20px;' class='footerfondo'>".number_format($totalBase, 2)."€</td>
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
                </table> 
            ";
            
    ob_start();
    require_once($pathraiz."/includes/pdf/index_footer.php");
    $html .= ob_get_clean();
    
    //file_put_contents("html.txt", $html);
    
    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
    //$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first dg ds gd gsd  test');
    $html2pdf->writeHTML($html);
    
    $nombrefichero = (str_replace("/", "", $registrospROV[9])).".pdf";
    if ($pathpedido != "") {
        $outputFile = "ERP/MATERIAL/PEDIDOS".$pathpedido.$nombrefichero;
    }
    else {
        $outputFile = "ERP/MATERIAL/PEDIDOS/TEMP/".$nombrefichero;
    }
    $tempfile = "temp/".$nombrefichero;
    
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
    if ($upload == 1) {
        $success = true;
        echo "/erp/apps/material/includes/".$tempfile;
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