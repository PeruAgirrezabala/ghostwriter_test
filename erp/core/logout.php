<?php
	session_start();
        if ($_SESSION['user_rol'] == "CLIENTE") {
            $rol = "CLIENTE";
        }
	
        if(isset($_COOKIE['id_user']) && isset($_COOKIE['marca'])){
            unset($_COOKIE['id_user']);
            unset($_COOKIE['marca']);
            setcookie('id_user', "", time()-3600, '/', 'erp.genelek.com');
            setcookie('marca', "", time()-3600, '/', 'erp.genelek.com');
        }
        if(isset($_COOKIE['id_client']) && isset($_COOKIE['marca'])){
            unset($_COOKIE['id_client']);
            unset($_COOKIE['marca']);
            setcookie('id_client', "", time()-3600, '/', 'erp.genelek.com');
            setcookie('marca', "", time()-3600, '/', 'erp.genelek.com');
        }
	unset($_SESSION['user_session']);
        
	if(session_destroy()) {
            if ($rol == "CLIENTE") {
                header("Location: /erp/loginclientes.php");
            }
            else {
                header("Location: /erp/login.php");
            }
	}
?>