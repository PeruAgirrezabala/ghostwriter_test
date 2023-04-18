<?php
    session_start();
	$pathraiz = $_SERVER['DOCUMENT_ROOT'];
	require_once($pathraiz."/core/dbconfig.php");
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        require_once '../plugins/phpMailer/PHPMailer.php';
        require_once '../plugins/phpMailer/SMTP.php';
        
        $mail = new PHPMailer;
    
    $button = filter_input(INPUT_POST, "btn-signin");
    $salto = chr(13).chr(10);
    if(isset($button)) {
        $user_name = trim($_POST['sign_name']);
        $apellidos = trim($_POST['sign_apellidos']);
        $email = trim($_POST['signemail']);
        $tlfno = trim($_POST['signtlfno']);
        $empresa = trim($_POST['signempresa']);
        $user_password = trim($_POST['signpassword']);
        $user_password2 = trim($_POST['signpassword2']);
		
		if ($user_password != $user_password2) {
			echo "Las contraseñas no coinciden";
		}
		else {
			$password = md5($user_password);
			$password2 = md5($user_password2);
	
			try
			{ 
				$stmt = $db_con->prepare("SELECT * FROM tools_users WHERE user_email=:usermail");
				$stmt->execute(array(":usermail"=>$email));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$count = $stmt->rowCount();
				if($count == 0){
					$db_con->query("INSERT INTO tools_users 
									(nombre, apellidos, user_email, telefono, empresa, user_password) 
									VALUES ('".$user_name."', '".$apellidos."','".$email."', '".$tlfno."', '".$empresa."','".$password."')");
                                        /*
                                        $para      = 'urko.delatorre@we-roi.com';
                                        $para      = 'urkodelatorre@gmail.com';
                                        //$para      = 'julen@gogolan.net';
                                        $titulo    = 'CRM WEROI // Nueva solicitud de acceso';
                                        $mensaje   = 'Tienes una nueva solicitud de acceso al CRM por parte de Weroi:'. $salto.$salto .
                                                     'Sus datos son los siguientes:'. $salto .
                                                     'Nombre: '.$user_name. $salto .
                                                     'Apellidos: '.$apellidos. $salto .
                                                     'Empresa: '.$empresa. $salto .
                                                     'Telefono: '.$tlfno. $salto .
                                                     'Email: '.$email. $salto.$salto .
                                                     'Haz click en el siguiente enlace para dar acceso a este usuario: '. $salto .
                                                     'https://tools.we-roi.com/accesos.php?p=w';
                                        $cabeceras = 'From: noreply@gogolan.net' . $salto .
                                            'X-Mailer: PHP/' . phpversion();

                                        mail($para, $titulo, $mensaje, $cabeceras);
                                        
					echo "ok"; // log in
                                         */
                                        
                                        /* PHPMAILER EXAMPLE OF USE
                                            //Server settings
                                               $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                                               $mail->isSMTP();                                      // Set mailer to use SMTP
                                               $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
                                               $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                               $mail->Username = 'user@example.com';                 // SMTP username
                                               $mail->Password = 'secret';                           // SMTP password
                                               $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                                               $mail->Port = 587;                                    // TCP port to connect to

                                           //Recipients
                                               $mail->setFrom('from@example.com', 'Mailer');
                                               $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
                                               $mail->addAddress('ellen@example.com');               // Name is optional
                                               $mail->addReplyTo('info@example.com', 'Information');
                                               $mail->addCC('cc@example.com');
                                               $mail->addBCC('bcc@example.com');

                                           //Attachments
                                               $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                                               $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                                           //Content
                                               $mail->isHTML(true);                                  // Set email format to HTML
                                               $mail->Subject = 'Here is the subject';
                                               $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                                               $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                                         */
                                        
                                        $mail->setFrom('noreply@we-roi.com', 'WEROI');
                                        $mail->addAddress("urko.delatorre@we-roi.com", '');
                                        $mail->addAddress("inigo.lekunberri@we-roi.com", '');
                                        $mail->isHTML(true); 
                                        $mail->Subject  = 'TOOLS WEROI // Nueva solicitud de acceso';
                                        $mail->Body     = 'Tienes una nueva solicitud de acceso a TOOLS WEROI por parte de Weroi:'. $salto.$salto .
                                                     'Sus datos son los siguientes:'. $salto .
                                                     'Nombre: '.$user_name. $salto .
                                                     'Apellidos: '.$apellidos. $salto .
                                                     'Telefono: '.$tlfno. $salto .
                                                     'Empresa: '.$empresa. $salto .
                                                     'Email: '.$email. $salto.$salto .
                                                     'Haz click en el siguiente enlace para dar acceso a este usuario: '.$email. $salto .
                                                     '/ https://tools.we-roi.com/accesos.php?p=w';
                                        if(!$mail->send()) {
                                          echo 'El email con la solicitud de acceso no ha podido ser enviado. Por favor póngase en contacto con urko.delatorre@we-roi.com para notificarle su solicitud.';
                                          echo 'Mailer error: ' . $mail->ErrorInfo;
                                        } else {
                                          echo 'ok';
                                        }
				}
				else{
					echo "Email ya existente"; // wrong details 
				}
			}
			catch(PDOException $e){
				echo $e->getMessage();
				echo "Email ya existente.";
			}
		} //
	}
	else {
		echo "no";
    } //if isset btn_login
                                        
?>