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
                    PROVEEDORES.formaPago,
                    PEDIDOS_PROV.forma_pago,
                    PEDIDOS_PROV.dir_entrega,
                    PEDIDOS_PROV.contacto,
                    PEDIDOS_PROV.observaciones 
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
    if ($registrospROV[25] == "") {
        $formaPago = $registrospROV[24];
    }
    else {
        $formaPago = $registrospROV[25];
    }
    
    if ($registrospROV[26] == "") {
        $dirEntrega = "GENELEK SISTEMAS S.L. <br> Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa";
    }
    else {
        $dirEntrega = $registrospROV[26];
    }
    
    if ($registrospROV[27] == "") {
        $contactoProv = $registrospROV[22];
    }
    else {
        $contactoProv = $registrospROV[27];
    }
    
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
                PEDIDOS_PROV_DETALLES.fecha_entrega,
                erp_users.nombre,
                erp_users.apellidos,
                PEDIDOS_PROV_DETALLES.dto_ad_prior, 
                PEDIDOS_PROV_DETALLES.descripcion ,
                PEDIDOS_PROV_DETALLES.detalle_libre,
                PEDIDOS_PROV_DETALLES.ref
            FROM 
                PEDIDOS_PROV_DETALLES
            LEFT JOIN MATERIALES
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
    
    $salto = "<br>";
    $contador = 0;
    $destinatarios = array();
    $mensaje = "PEDIDO: ".$registrospROV[9].$salto."FECHA: ".$registrospROV[14].$salto."PROVEEDOR: ".$registrospROV[0].$salto.$salto.$salto;
    while ($registros = mysqli_fetch_array($resultado)) {
        $dto_total = 0;
        if ($registros[6] != "") {
            $pvp = $registros[6];
        }
        else {
            $pvp = $registros[10];
        }
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
        $base = ($pvp*$registros[5]);
        
        // Sumatorio de descuentos activos
        if ($dto_prov_activo == 1) {
            $dto_total = $dto_total + $dto_prov;
        }
        if ($dto_mat_activo == 1) {
            $dto_total = $dto_total + $dto_mat;
        }
        if ($dto_ad_activo == 1) {
            if ($registros[22] == 0) {
                $dto_total = $dto_total + $dto_extra;
            }
        }
        $dto = (100-$dto_total)/100;
        
        // Aplicación del descuento al precio base
        if ($dto <> 0) {
           $basedto = $base*$dto; 
        }
        else {
            $basedto = $base;
        }
        
        if ($registros[22] == 1) {
            $dtoNeto = ($basedto*$dto_extra)/100;
            $basedto = $basedto-$dtoNeto;
        }
        else {
            $dtoNeto = 0;
        }

        $totalDto = $totalDto + $basedto;
        $totalBase = $totalBase + $basedto;
        //$iva = $iva + ($basedto*21)/100;
        //$total = $total + ($basedto + $iva);
        
        if ($registros[23] != "") {
            $observaciones = "<p class='obs'>".$registros[23]."</p>";
        }
        
        if ($registros[2] != "") {
            $descripcion = "<h3>".$registros[2]."</h3>".$registros[4].$observaciones;
        }
        else {
            $descripcion = "<h3>".$registros[24]."</h3>".$observaciones;
        }
        
        if ($registros[25] == "") {
            $ref = $registros[1];
        }
        else {
            $ref = $registros[25];
        }
        
        if ($contador == 0) {
            $html .= "
                    <div id='details' class='clearfix no-break'>
                        <hr style='width: 100%; border: 3px solid #666666;'>
                        <table class='titulo no-break' >
                            <tr class='no-break'>
                                <td class='iz no-break'>
                                    <table class='iz-table no-break' cellspacing='0' cellpadding='0'>
                                        <thead>
                                            <tr>
                                                <th class='header-rows'>PROVEEDOR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class='text-rows'>OFERTA: ".$registrospROV[21]."</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>NOMBRE: ".$registrospROV[0]."</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>DIRECCIÓN: ".$registrospROV[1]."</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>EMAIL: ".$registrospROV[7]."</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>AT/ATT: ".$contactoProv."</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class='ri no-break'>
                                    <table class='iz-table' cellspacing='0' cellpadding='0'>
                                        <thead>
                                            <tr>
                                                <th class='header-rows'>DATOS DEL PEDIDO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class='text-rows'>PEDIDO: ".$registrospROV[9]."</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>FECHA: ".$registrospROV[14]."</td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>LUGAR DE ENTREGA: </td>
                                            </tr>
                                            <tr>
                                                <td class='text-rows'>".$dirEntrega."</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </table>
                        <hr style='width: 100%; border: 3px solid #666666;'>
                    </div>
                    ";
            
        } // if contador = 0
        if($contador==0){
            $html .= "
                    <table border='0' cellspacing='0' cellpadding='0' class='detalles no-break'>
                        <thead>
                            <tr style='border-bottom: solid 1px #ffffff;'>
                                <th class='no'>REF</th>
                                <th class='desc'>DESCRIPCIÓN</th>
                                <th class='qty'>CANTIDAD</th>
                                <th class='pvp'>PVP</th>
                                <th class='dto'>DTO</th>
                                <th class='total'>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
        }elseif($contador==16){
            $html .= "
                </tbody>
                </table> 
                    <table border='0' cellspacing='0' cellpadding='0' class='detalles no-break'>
                        <thead>
                            <tr style='border-bottom: solid 1px #ffffff;'>
                                <th class='no'>REF</th>
                                <th class='desc'>DESCRIPCIÓN</th>
                                <th class='qty'>CANTIDAD</th>
                                <th class='pvp'>PVP</th>
                                <th class='dto'>DTO</th>
                                <th class='total'>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
        }
        
        
        $dto_show = "";
        if ($dto_prov_activo == 1) {
            $dto_show .= $dto_prov."% ";
        }
        if ($dto_mat_activo == 1) {
            $dto_show .= $dto_mat."% ";
        }
        if ($dto_ad_activo == 1) {
            if ($registros[22] == 1) {
                $dto_show .= "+ ".$dto_extra."% ";
            }
            else {
                $dto_show .= $dto_extra."% ";
            }
        }

        $html .= " 
                    <tr>
                        <td class='no'>".$ref."</td>
                        <td class='desc'>".$descripcion."</td>
                        <td class='qty'>".$registros[5]."</td>
                        <td class='unit'>".number_format($pvp, 2)."€</td>
                        <td class='unit'>".$dto_show." </td>
                        <td class='total'>".number_format($basedto, 2)."€</td>
                    </tr>
                ";
        //$base = $base + ($registros[20]*$registros[18]);
        
        $contador = $contador + 1;
        
        // Mandamos email al interesado de cada artículo
        
        $para = $registros[18];
        $fecha_entrega = $registros[19];
        $tecnicoNombre = $registros[20];
        $tecnicoApellidos = $registros[21];
        $mensaje .= "[".$tecnicoNombre." ".$tecnicoApellidos."] - Artículo: ".$registros[2].$salto."Referencia: ".$registros[1].$salto."Pedido el: ".$registrospROV[14].$salto."Al proveedor: ".$registrospROV[0].$salto."Con fecha prevista de entrega: ".$fecha_entrega.$salto.$salto;
        array_push($destinatarios, $para);
        //sendMail($para, "Artículo pedido", $mensaje, $de);
    } // while
    
    //Metemos la URL del pedido en el mensaje
    // $mensaje .= "<a href='http://192.168.3.109/erp/apps/material/editPedido.php?id=".$_POST['id_pedido']."'>VER EL PEDIDO</a>";
    $mensaje .= "<a href='".$pathraiz."/apps/material/editPedido.php?id=".$_POST['id_pedido']."'>VER EL PEDIDO</a>";
    $destinatarios = array_unique($destinatarios);
    foreach ($destinatarios as &$destinatario) {
        //sendMail($destinatario, "[PEDIDO ".$registrospROV[9]."] Se ha pedido material asignado a tí", $mensaje, $de);
    }
        
    $iva = ($totalBase * 21) / 100;
    $total = ($totalBase + $iva);
    
    $html .= " <tr>
                        <td colspan='3' style='padding-top: 20px;'></td>
                        <td colspan='2' style='padding-top: 20px;' class='footerfondo'>SUBTOTAL</td>
                        <td style='padding-top: 20px;' class='footerfondo'>".number_format($totalBase, 2)."€</td>
                      </tr>
                    </tbody>
                </table> 
            ";
            
    ob_start();
    require_once($pathraiz."/includes/pdf/index_footer.php");
    $html .= ob_get_clean();
    
    file_put_contents("html.txt", $html);
    
    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
    //$html2pdf->addFont('Montserrat', '', '/erp/includes/pdf/Montserrat-Regular.php');
    //$html2pdf->setDefaultFont('Helvetica');
    //$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first dg ds gd gsd  test');
    $html2pdf->writeHTML($html);
    
    $sql = "UPDATE PEDIDOS_PROV SET estado_id = 1 WHERE id =".$_POST['id_pedido'];
    $upd = mysqli_query($connString, $sql) or die("Error al actualizar el Pedido");
    
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