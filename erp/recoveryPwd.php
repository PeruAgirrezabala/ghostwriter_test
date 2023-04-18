<?php
    session_start();
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include($pathraiz."/common.php");
	require_once($pathraiz."/core/dbconfig.php");
    
    function generateRandomString($length = 8) {
        $characters = '.,-_{}[]()$&=?!0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }    
    
    $salto = "<br>";
    if(isset($_POST['user_email'])) {
        $email = trim($_POST['user_email']);
        $strPassword = generateRandomString();
        $password = md5($strPassword);
        
        try
        { 
                $stmt = $db_con->prepare("SELECT * FROM erp_users WHERE user_email='".$email."'");
                $stmt->execute(array(":usermail"=>$email));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $count = $stmt->rowCount();
                if($count > 0){
                    $db_con->query("UPDATE 
                                        erp_users 
                                    SET 
                                        user_password = '".$password."' 
                                    WHERE 
                                        user_email = '".$email."'");

                    $mensaje = "Ha solicitado una nueva contraseña para el usuario: ".$email.$salto.$salto."Su nueva contraseña es: ".$strPassword.$salto.$salto;
                    sendMail($email, "[ACCESO] Solicitud de nueva contraseña", $mensaje, $de);
                    echo "ok";
                }
                else{
                        echo "Email no existente"; // wrong details 
                }
        }
        catch(PDOException $e){
                echo $e->getMessage();
                echo "Email ya existente.";
        }
    }
?>