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
        //$user_name = trim($_POST['signuser_name']);
        $email = trim($_POST['signemail']);
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
				$stmt = $db_con->prepare("SELECT * FROM tools_clientes WHERE user_email=:usermail");
				$stmt->execute(array(":usermail"=>$email));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$count = $stmt->rowCount();
				if($count == 0){
					$db_con->query("INSERT INTO tools_clientes 
									(user_email, user_password, nombre, apellidos, empresa, telefono) 
									VALUES ('".$email."','".$password."', '".$_POST['signname']."', '".$_POST['sign_apellidos']."', '".$_POST['signempresa']."', '".$_POST['signtlfno']."')");
                                        /*
                                        $para      = 'urko.delatorre@we-roi.com';
                                        $para      = 'urkodelatorre@gmail.com';
                                        //$para      = 'julen@gogolan.net';
                                        $titulo    = 'CRM WEROI // Nueva solicitud de acceso';
                                        $mensaje   = 'Tienes una nueva solicitud de acceso al CRM por parte de un Cliente.'. $salto.$salto .
                                                     'Sus datos son los siguientes:'. $salto .
                                                     'Nombre: '.$_POST['signname']. $salto .
                                                     'Apellidos: '.$_POST['sign_apellidos']. $salto .
                                                     'Telefono: '.$_POST['signtlfno']. $salto .
                                                     'Empresa: '.$_POST['signempresa']. $salto .
                                                     'Email: '.$email. $salto.$salto .
                                                     'Haz click en el siguiente enlace para dar acceso a este Cliente: '.$email. $salto .
                                                     'https://tools.we-roi.com/accesos.php?p=c';
                                        $cabeceras = 'From: noreply@gogolan.net' . $salto .
                                            'X-Mailer: PHP/' . phpversion();

                                        mail($para, $titulo, $mensaje, $cabeceras);

                                        echo "ok"; // log in
                                         
                                         */
                                        
                                        $mail->setFrom('noreply@we-roi.com', 'WEROI');
                                        $mail->addAddress("urko.delatorre@we-roi.com", '');
                                        $mail->addAddress("inigo.lekunberri@we-roi.com", '');
                                        //$mail->addAddress("julen@gogolan.net", '');
                                        $mail->isHTML(true); 
                                        $mail->Subject  = 'TOOLS WEROI // Nueva solicitud de acceso';
                                        $mail->Body     = 'Tienes una nueva solicitud de acceso a TOOLS WEROI por parte de un Cliente:'. $salto.$salto .
                                                     'Sus datos son los siguientes:'. $salto .
                                                     'Nombre: '.$_POST['signname']. $salto .
                                                     'Apellidos: '.$_POST['sign_apellidos']. $salto .
                                                     'Telefono: '.$_POST['signtlfno']. $salto .
                                                     'Empresa: '.$_POST['signempresa']. $salto .
                                                     'Email: '.$email. $salto.$salto .
                                                     'Haz click en el siguiente enlace para dar acceso a este Cliente: '.$email. $salto .
                                                     '/ https://tools.we-roi.com/accesos.php?p=c';
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