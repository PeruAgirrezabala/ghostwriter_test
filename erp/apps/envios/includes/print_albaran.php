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
                    ENVIOS_CLI.id,
                    ENVIOS_CLI.ref, 
                    ENVIOS_CLI.ref_pedido_cliente,
                    ENVIOS_CLI.nombre,
                    ENVIOS_CLI.descripcion,
                    ENVIOS_CLI.cliente_id,
                    ENVIOS_CLI.fecha,
                    ENVIOS_CLI.fecha_entrega,
                    ENVIOS_CLI.tecnico_id,
                    ENVIOS_CLI.proyecto_id,
                    ENVIOS_CLI.estado_id, 
                    ENVIOS_CLI.path,
                    ENVIOS_CLI.ref_oferta_proveedor,
                    CLIENTES.contacto,
                    ENVIOS_CLI.plazo,
                    OFERTAS.ref,
                    ENVIOS_CLI.direccion_envio,
                    TRANSPORTISTAS.nombre,
                    PROVEEDORES.id,
                    PROVEEDORES.direccion,
                    PROVEEDORES.poblacion,
                    PROVEEDORES.provincia,
                    PROVEEDORES.cp,
                    PROVEEDORES.pais,
                    PROVEEDORES.telefono,
                    PROVEEDORES.CIF,
                    PROVEEDORES.email,
                    PROVEEDORES.nombre,
                    ENVIOS_CLI.destinatario,
                    ENVIOS_CLI.att,
                    ENVIOS_CLI.proveedor_id,
                    PROVEEDORES.contacto,
                    CLIENTES.contacto
                FROM 
                    ENVIOS_CLI
                LEFT JOIN CLIENTES
                    ON ENVIOS_CLI.cliente_id = CLIENTES.id
                LEFT JOIN PROVEEDORES 
                    ON ENVIOS_CLI.proveedor_id = PROVEEDORES.id
                LEFT JOIN OFERTAS
                    ON OFERTAS.id = ENVIOS_CLI.oferta_id 
                INNER JOIN TRANSPORTISTAS 
                    ON TRANSPORTISTAS.id = ENVIOS_CLI.transportista_id 
                WHERE 
                    ENVIOS_CLI.id = ".$_POST['id_envio'];
    
    file_put_contents("pedido.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar el Cliente");
    $registrospCLI = mysqli_fetch_row($res);
    $pathenvio = $registrospCLI[19];
    
    if ($_POST['materiales_id'] != "") {
        $materiales = explode("-", $_POST['materiales_id']);
        $matids = join("','",$materiales);   

        $consulta = "SELECT 
                        ENVIOS_CLI_DETALLES.id,
                        MATERIALES.ref,  
                        MATERIALES.nombre,
                        MATERIALES.fabricante,
                        MATERIALES.modelo,
                        ENVIOS_CLI_DETALLES.unidades,
                        MATERIALES_PRECIOS.pvp, 
                        ENVIOS_CLI_DETALLES.entregado,
                        ENVIOS_CLI_DETALLES.fecha_recepcion,
                        PROYECTOS.nombre,
                        ENTREGAS.nombre,
                        erp_users.nombre, 
                        MATERIALES.id 
                    FROM 
                        ENVIOS_CLI_DETALLES
                    INNER JOIN MATERIALES
                        ON ENVIOS_CLI_DETALLES.material_id = MATERIALES.id 
                    LEFT JOIN MATERIALES_PRECIOS 
                        ON MATERIALES_PRECIOS.id = ENVIOS_CLI_DETALLES.material_tarifa_id 
                    LEFT JOIN PROYECTOS 
                        ON PROYECTOS.id = ENVIOS_CLI_DETALLES.proyecto_id 
                    LEFT JOIN ENTREGAS
                        ON ENVIOS_CLI_DETALLES.entrega_id = ENTREGAS.id
                    LEFT JOIN erp_users 
                        ON ENVIOS_CLI_DETALLES.erp_userid = erp_users.id 
                    WHERE
                        ENVIOS_CLI_DETALLES.envio_id = ".$_POST['id_envio']." 
                    AND 
                        MATERIALES.id IN ('".$materiales[0]."')
                    ORDER BY 
                        ENVIOS_CLI_DETALLES.id ASC";
    }
    else {
        $consulta = "SELECT 
                        ENVIOS_CLI_DETALLES.id,
                        MATERIALES.ref,  
                        MATERIALES.nombre,
                        MATERIALES.fabricante,
                        MATERIALES.modelo,
                        ENVIOS_CLI_DETALLES.unidades,
                        ENVIOS_CLI_DETALLES.entregado,
                        ENVIOS_CLI_DETALLES.fecha_recepcion,
                        PROYECTOS.nombre,
                        ENTREGAS.nombre,
                        MATERIALES.id 
                    FROM 
                        ENVIOS_CLI_DETALLES
                    INNER JOIN MATERIALES
                        ON ENVIOS_CLI_DETALLES.material_id = MATERIALES.id 
                    LEFT JOIN PROYECTOS 
                        ON PROYECTOS.id = ENVIOS_CLI_DETALLES.proyecto_id 
                    LEFT JOIN ENTREGAS
                        ON ENVIOS_CLI_DETALLES.entrega_id = ENTREGAS.id
                    WHERE
                        ENVIOS_CLI_DETALLES.envio_id = ".$_POST['id_envio']." 
                    ORDER BY 
                        ENVIOS_CLI_DETALLES.id ASC";
    }
    
    file_put_contents("detallesAlbaran.txt", $consulta);
    $resultado = mysqli_query($connString, $consulta) or die("Error al consultar el Envio");
    
    // ************************ CONSTRUCCION DE ENVIO ******************************
    // Recoger HTML
    ob_start();
    require_once($pathraiz."/includes/pdf/index_alb_header.php");
    $factuDir = "Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa";
    $html = ob_get_clean();

    $contador = 0;
    while ($registros = mysqli_fetch_array($resultado)) {
        if ($registrospCLI[24] == "") {
            if ($registrospCLI[38] != "") { // envio a proveedor
                $direccionEnvio  = "<h2 class='name'>".$registrospCLI[27]."</h2>
                                    <div class='address'>".$registrospCLI[28]."</div>
                                    <div class='address'>".$registrospCLI[31]." - ".$registrospCLI[29]."</div>
                                    <div class='address'>".$registrospCLI[30]." (".$registrospCLI[32].")</div>
                                    ";
            }
            else {
                $direccionEnvio  = "<h2 class='name'>".$registrospCLI[0]."</h2>
                                    <div class='address'>".$registrospCLI[1]."</div>
                                    <div class='address'>".$registrospCLI[4]." - ".$registrospCLI[2]."</div>
                                    <div class='address'>".$registrospCLI[3]." (".$registrospCLI[5].")</div>
                                    ";
            }
        }
        else {
            $direccionEnvio = "<h2 class='name'></h2>
                                <div class='address'>".$registrospCLI[24]."</div>
                                ";
        }
        if ($contador == 0) {
            if ($registrospCLI[38] != "") { // es un envio a un proveedor
                $html .= "
                        <div id='details' class='clearfix'>
                            <table class='titulo'>
                                  <tr>
                                      <td class='iz'>
                                            <h1>ENVÍO A PROVEEDOR: ".$registrospCLI[35]."</h1>
                                            <div class='to'>LUGAR DE ENTREGA:</div>
                                            ".$direccionEnvio."
                                            <div class='email'><a href='mailto:'>".$registrospCLI[34]."</a></div>
                                            <div class='to'>At./Att.:</div>
                                            <h2 class='name'>".$registrospCLI[39]."</h2>
                                      </td>
                                      <td class='ri'>
                                            <h1>ALBARÁN Nº: ".str_replace("ENV","AL",$registrospCLI[9])."</h1>
                                            <h2>Fecha Envío: ".$registrospCLI[14]."</h2>
                                            <h2>Transportista: ".$registrospCLI[25]."</h2>
                                      </td>
                                  </tr>
                            </table>

                        </div>
                        ";
            }
            else {
                $html .= "
                        <div id='details' class='clearfix'>
                            <table class='titulo'>
                                  <tr>
                                      <td class='iz'>
                                            <h1>PEDIDO DEL CLIENTE: ".$registrospCLI[10]."</h1>
                                            <div class='to'>LUGAR DE ENTREGA:</div>
                                            ".$direccionEnvio."
                                            <div class='email'><a href='mailto:'>".$registrospCLI[10]."</a></div>
                                            <div class='to'>At./Att.:</div>
                                            <h2 class='name'>".$registrospCLI[21]."</h2>
                                      </td>
                                      <td class='ri'>
                                            <h1>ALBARÁN Nº: ".str_replace("ENV","AL",$registrospCLI[9])."</h1>
                                            <h2>Fecha Envío: ".$registrospCLI[14]."</h2>
                                            <h2>Transportista: ".$registrospCLI[25]."</h2>
                                      </td>
                                  </tr>
                            </table>

                        </div>
                        ";
            }
            $html .= "
                    <table border='0' cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                            <th class='no'>REF</th>
                            <th class='desc'>MATERIAL</th>
                            <th class='qty'>CANTIDAD</th>
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
                    </tr>
                ";
        //$base = $base + ($registros[20]*$registros[18]);
        
        $contador = $contador + 1;
        $bultos = $bultos + $registros[5];
    } // while
    
    $html .= " 
                    </tbody>
                    
                </table> 
            ";
            
    ob_start();
    require_once($pathraiz."/includes/pdf/index_alb_footer.php");
    $html .= ob_get_clean();
    
    //file_put_contents("html.txt", $html);
    
    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
    //$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first dg ds gd gsd  test');
    $html2pdf->writeHTML($html);
    
    $nombrefichero = (str_replace("/", "", str_replace("ENV","AL",$registrospCLI[9]))).".pdf";
    if ($pathenvio != "") {
        $outputFile = "ERP/MATERIAL/ENVIOS".$pathenvio.$nombrefichero;
    }
    else {
        $outputFile = "ERP/MATERIAL/ENVIOS/TEMP/".$nombrefichero;
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
        echo "/erp/apps/envios/includes/".$tempfile;
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