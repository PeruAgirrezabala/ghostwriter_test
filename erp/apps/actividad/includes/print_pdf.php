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
                    ACTIVIDAD.id actid,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.nombre,
                    ACTIVIDAD.descripcion,
                    ACTIVIDAD.fecha,
                    ACTIVIDAD.fecha_mod,
                    ACTIVIDAD.instalacion,
                    ACTIVIDAD.solucion,
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.observaciones,
                    ACTIVIDAD.item_id,
                    ACTIVIDAD.fecha_factu,
                    ACTIVIDAD_ESTADOS.nombre,
                    ACTIVIDAD_ESTADOS.color,
                    erp_users.nombre,
                    erp_users.apellidos,
                    erp_users.firma_path,
                    CLIENTES.id,
                    CLIENTES.nombre,
                    CLIENTES.direccion,
                    CLIENTES.poblacion,
                    CLIENTES.provincia,
                    CLIENTES.cp,
                    CLIENTES.pais,
                    CLIENTES.telefono,
                    CLIENTES.nif,
                    CLIENTES.email,
                    OFERTAS.ref,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.descripcion,
                    PROYECTOS.fecha_entrega,
                    erp_users.id,
                    (SELECT SUM(ACTIVIDAD_DETALLES_HORAS.cantidad) FROM ACTIVIDAD_DETALLES, ACTIVIDAD_DETALLES_HORAS, PERFILES_HORAS WHERE ACTIVIDAD_DETALLES.id = ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id AND ACTIVIDAD_DETALLES_HORAS.tipo_hora_id = PERFILES_HORAS.id AND PERFILES_HORAS.tipo_id = 1 AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    (SELECT SUM(ACTIVIDAD_DETALLES_HORAS.cantidad) FROM ACTIVIDAD_DETALLES, ACTIVIDAD_DETALLES_HORAS, PERFILES_HORAS WHERE ACTIVIDAD_DETALLES.id = ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id AND ACTIVIDAD_DETALLES_HORAS.tipo_hora_id = PERFILES_HORAS.id AND PERFILES_HORAS.tipo_id = 2 AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    (SELECT SUM(ACTIVIDAD_DETALLES_HORAS.cantidad) FROM ACTIVIDAD_DETALLES, ACTIVIDAD_DETALLES_HORAS, PERFILES_HORAS WHERE ACTIVIDAD_DETALLES.id = ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id AND ACTIVIDAD_DETALLES_HORAS.tipo_hora_id = PERFILES_HORAS.id AND PERFILES_HORAS.tipo_id = 3 AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    OFERTAS.titulo,
                    CLIENTES_INSTALACIONES.nombre
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES 
                    ON ACTIVIDAD.cliente_id = CLIENTES.id
                LEFT JOIN OFERTAS 
                    ON ACTIVIDAD.item_id = OFERTAS.id
                INNER JOIN erp_users  
                    ON ACTIVIDAD.responsable = erp_users.id  
                INNER JOIN ACTIVIDAD_ESTADOS 
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                LEFT JOIN PROYECTOS 
                    ON ACTIVIDAD.item_id = PROYECTOS.id 
                INNER JOIN CLIENTES_INSTALACIONES 
                    ON ACTIVIDAD.instalacion = CLIENTES_INSTALACIONES.id 
                WHERE
                    ACTIVIDAD.id = ".$_POST['id'];
    
    file_put_contents("printAct.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error al consultar la Actividad");
    $registros = mysqli_fetch_row($res);
    
    $ref = $registros[1];
    $nombre = $registros[2];
    $descripción = $registros[3];
    $fecha = $registros[4];
    $fecha_mod = $registros[5];
    $instalacionId = $registros[6];
    $instalacion = $registros[37];
    $observ = $registros[9];
    $estado = $registros[12];
    $estadocolor = $registros[13];
    $tecnico = $registros[14];
    $tecnicoApellidos = $registros[15];
    $tecnicoFirma = $registros[16];
    $cliente = $registros[18];
    $clidireccion = $registros[19];
    $clipoblacion = $registros[20];
    $cliprovincia = $registros[21];
    $cliPais = $registros[23];
    $cliTlfno = $registros[24];
    $cliNIF = $registros[25];
    $cliEmail = $registros[26];
    $h820 = $registros[33];
    $h208 = $registros[34];
    $hviaje = $registros[35];
    
    // ************************ CONSTRUCCION DE PEDIDO ******************************
    // Recoger HTML
    ob_start();
    require_once($pathraiz."/includes/pdf/index_actividad_header.php");
    $factuDir = "Pol. Ind. A.D.U. 21<br>Plaza Urola, s/n 20750<br>Zumaia, Gipuzkoa";
    $html = ob_get_clean();
    
    $salto = "<br>";
    $contador = 0;
    $destinatarios = array();
    $mensaje = "PEDIDO: ".$registrospROV[9].$salto."FECHA: ".$registrospROV[14].$salto."PROVEEDOR: ".$registrospROV[0].$salto.$salto.$salto;
    
    //$html="";
    
      $html.='
        <table id="cabecera-ISO9001" border="1">
            <tbody>
                <tr>
                    <td width="560" rowspan="2" style="text-align: left;">
                        <h1>PARTE DE INTERVENCIÓN</h1>
                    </td>
                    <td width="150" style="text-align: left;">
                        <p>COD: PART-INT-01</p>
                        <p>REV: 01</p>
                        <p>FECHA: '.$fecha.'</p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table id="bloque2" border="1">
            <tbody>
                <tr>
                    <td width="346" class="two-column iz" rowspan="2" style="text-align: left;">
                        <h3>Nº INTERVENCIÓN: <span class="datos">'.$ref.'</span></h3>
                        <h3>DE GENELEK: <span class="datos">'.$tecnico." ".$tecnicoApellidos.'</span></h3>
                        <h3>FECHA: <span class="datos">'.$fecha.'</span></h3>
                        <h3>TOTAL HORAS DE VIAJE: <span class="datos">'.$hviaje.'</span></h3>
                        <h3>TOTAL HORAS 08:00-20:00: <span class="datos">'.$h820.'</span></h3>
                        <h3>TOTAL HORAS 20:00-08:00: <span class="datos">'.$h208.'</span></h3>
                    </td>
                    <td id="espacio" width="15"></td>
                    <td width="346" class="two-column der" style="text-align: left;">
                        <h3>CLIENTE: <span class="datos">'.$cliente.'</span></h3>
                        <h3>NIF: <span class="datos">'.$cliNIF.'</span></h3>
                        <h3>DIRECCIÓN: <span class="datos">'.$clidireccion.'</span></h3>
                        <h3>LOCALIDAD: <span class="datos">'.$clipoblacion."(".$cliprovincia.")".'</span></h3>
                        <h3>PAÍS: <span class="datos">'.$cliPais.'</span></h3>
                        <h3>TLFNO: <span class="datos">'.$cliTlfno.'</span></h3>
                        <h3>INSTALACIÓN: <span class="datos">'.$instalacion.'</span></h3>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="titulo" border="1">
            <thead>
                <tr>
                    <th class="porcentaje10">
                        <h2 class="titdetalles">FECHA</h2>
                    </th>
                    <th class="porcentaje90">
                        <h2 class="titdetalles">DESCRIPCIÓN DEL TRABAJO REALIZADO</h2>
                    </th>
                </tr>
            </thead>
            <tbody>';
      
        $sql = "SELECT 
                    ACTIVIDAD_DETALLES.id,
                    ACTIVIDAD_DETALLES.nombre,  
                    ACTIVIDAD_DETALLES.descripcion,
                    ACTIVIDAD_DETALLES.fecha,
                    ACTIVIDAD_DETALLES.fecha_mod,
                    erp_users.nombre,
                    erp_users.apellidos
                FROM 
                    ACTIVIDAD_DETALLES, erp_users
                WHERE
                    ACTIVIDAD_DETALLES.erpuser_id = erp_users.id
                AND
                    ACTIVIDAD_DETALLES.actividad_id = ".$_POST["id"]." 
                ORDER BY 
                    ACTIVIDAD_DETALLES.id ASC";

        file_put_contents("queryActDetalles.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error seleccionando los detalles de la Actividad");

                while( $row = mysqli_fetch_array($res) ) {
                    $html.= "<tr>
                            <td class='text-center' width='100'>
                                <p>".$row[3]."</p>
                            </td>
                            <td class='text-left' width='605'>
                               <p>".$row[1]."</p> ".$row[2];
                    $sqlHoras = "SELECT 
                                        ACTIVIDAD_DETALLES_HORAS.id,
                                        erp_users.id as tecid,
                                        erp_users.nombre,
                                        erp_users.apellidos,
                                        ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id detid,
                                        (SELECT SUM(ACTIVIDAD_DETALLES_HORAS.cantidad) FROM ACTIVIDAD_DETALLES_HORAS, PERFILES_HORAS WHERE ACTIVIDAD_DETALLES_HORAS.tipo_hora_id = PERFILES_HORAS.id AND PERFILES_HORAS.tipo_id = 1 AND ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = detid AND ACTIVIDAD_DETALLES_HORAS.tecnico_id = tecid) as horas1,
                                        (SELECT SUM(ACTIVIDAD_DETALLES_HORAS.cantidad) FROM ACTIVIDAD_DETALLES_HORAS, PERFILES_HORAS WHERE ACTIVIDAD_DETALLES_HORAS.tipo_hora_id = PERFILES_HORAS.id AND PERFILES_HORAS.tipo_id = 2 AND ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = detid AND ACTIVIDAD_DETALLES_HORAS.tecnico_id = tecid) as horas2,
                                        (SELECT SUM(ACTIVIDAD_DETALLES_HORAS.cantidad) FROM ACTIVIDAD_DETALLES_HORAS, PERFILES_HORAS WHERE ACTIVIDAD_DETALLES_HORAS.tipo_hora_id = PERFILES_HORAS.id AND PERFILES_HORAS.tipo_id = 3 AND ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = detid AND ACTIVIDAD_DETALLES_HORAS.tecnico_id = tecid) as horas3,
                                        PERFILES_HORAS.tipo_id
                                    FROM 
                                        ACTIVIDAD_DETALLES_HORAS, erp_users, PERFILES_HORAS
                                    WHERE
                                        ACTIVIDAD_DETALLES_HORAS.tecnico_id = erp_users.id
                                    AND
                                        PERFILES_HORAS.id = ACTIVIDAD_DETALLES_HORAS.tipo_hora_id 
                                    AND
                                        ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ".$row[0]." 
                                    GROUP BY 
                                            erp_users.id
                                    ORDER BY 
                                            ACTIVIDAD_DETALLES_HORAS.id ASC";
                    
                    $resHoras = mysqli_query($connString, $sqlHoras) or die("Error seleccionando los detalles de las Horas");
                    if (mysqli_num_rows($resHoras) > 0) {
                        $html.= "<table class='tabla-horas' colspacing='0' border='1' cellspacing='0'>
                                <thead>
                                    <tr>
                                        <th width='150'>
                                            <h2 class='tithoras'>Técnico</h2>
                                        </th>
                                        <th width='100'>
                                            <h2 class='tithoras'>Horas 08:00-20:00</h2>
                                        </th>
                                        <th width='100'>
                                            <h2 class='tithoras'>Horas 20:00-08:00</h2>
                                        </th>
                                        <th width='100'>
                                            <h2 class='tithoras'>Horas VIAJE</h2>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>";
                        while($rowHoras = mysqli_fetch_array($resHoras) ) {
                            $html.= "<tr>
                                    <td class='text-left'>
                                        <p>".$rowHoras[2]." ".$rowHoras[3]."</p>
                                    </td>
                                    <td class='text-center'>
                                        <p>".$rowHoras[5]."</p>
                                    </td>
                                    <td class='text-center'>
                                        <p>".$rowHoras[6]."</p>
                                    </td>
                                    <td class='text-center'>
                                        <p>".$rowHoras[7]."</p>
                                    </td>
                                  </tr>";
                        }
                        $html.= "  </tbody>
                              </table>";
                    } // fin del if del numero de registros
                    $html.=    "
                                </td>
                              </tr>
                            ";
                }
    
      $html.='</tbody>
        </table>';
    
    // Metemos la URL del pedido en el mensaje
    // $mensaje .= "<a href='http://192.168.3.109/erp/apps/material/editPedido.php?id=".$_POST['id_pedido']."'>VER EL PEDIDO</a>";
    //$mensaje .= "<a href='".$pathraiz."/apps/material/editPedido.php?id=".$_POST['id_pedido']."'>VER EL PEDIDO</a>";
    $destinatarios = array_unique($destinatarios);
    foreach ($destinatarios as &$destinatario) {
        //sendMail($destinatario, "[PEDIDO ".$registrospROV[9]."] Se ha pedido material asignado a tí", $mensaje, $de);
    }
        
            
    ob_start();
    require_once($pathraiz."/includes/pdf/index_actividad_footer.php");
    $html .= ob_get_clean();
    
    file_put_contents("html.txt", $html);
    
    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
    //$html2pdf->addFont('Montserrat', '', '/erp/includes/pdf/Montserrat-Regular.php');
    //$html2pdf->setDefaultFont('Helvetica');
    //$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first dg ds gd gsd  test');
    $html2pdf->writeHTML($html);
    
    //$sql = "UPDATE PEDIDOS_PROV SET estado_id = 1 WHERE id =".$_POST['id_pedido'];
    //$upd = mysqli_query($connString, $sql) or die("Error al actualizar el Pedido");
    
    $nombrefichero = (str_replace("/", "", $ref)).".pdf";
    if ($pathpedido != "") {
        $outputFile = "ERP/ACTIVIDAD/".$pathpedido.$nombrefichero;
    }
    else {
        $outputFile = "ERP/ACTIVIDAD/TEMP/".$nombrefichero;
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
        echo "/erp/apps/actividad/includes/".$tempfile;
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