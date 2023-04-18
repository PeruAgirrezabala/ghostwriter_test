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
                PROYECTOS.id,
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
                PROYECTOS.coordgps_instalacion
            FROM 
                PROYECTOS, CLIENTES, PROYECTOS_ESTADOS, TIPOS_PROYECTO  
            WHERE 
                PROYECTOS.cliente_id = CLIENTES.id
            AND 
                PROYECTOS.estado_id = PROYECTOS_ESTADOS.id
            AND 
                PROYECTOS.tipo_proyecto_id = TIPOS_PROYECTO.id
            AND
                PROYECTOS.id = ".$_POST['id_proyecto'];
    
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
    
    
    // ************************ CONSTRUCCION DE PEDIDO ******************************
    // Recoger HTML
    ob_start();
    require_once($pathraiz."/includes/pdf/index_project_header.php");
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