
<?php
    //include connection file 
    $password;
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");


    if ($_POST['perfil_edit_iduser'] != "") {
        updatePerfil();
    }  
    else {
        //insertInfo();
    }
    
    function updatePerfil () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        if ($_POST['perfil_edit_pass'] != ' ') {
            $password = md5($_POST['perfil_edit_pass']);
        }
        else {
            $sql= "SELECT user_password FROM erp_users WHERE id  =".$_POST['perfil_edit_iduser'];
            $password = mysqli_query($connString, $sql) or die("Error al encontrar la contraseña");
            echo $password;
            file_put_contents("update_contraseña.txt", $password);

        }
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql2 = "UPDATE erp_users SET 
        nombre = '".$_POST['perfil_edit_nombre']."',
        apellidos = '".$_POST['perfil_edit_apellidos']."',
        user_name = '".$_POST['perfil_edit_username']."',
        user_email = '".$_POST['perfil_edit_email']."',
        telefono = '".$_POST['perfil_edit_tlfno']."',
        NIF = '".$_POST['perfil_edit_nif']."',
        user_password = '".$password."',
        firma_path = '".$_POST['perfil_edit_firma']."',
        avatar = '".$_POST['avatar_src']."'

        WHERE id =".$_POST['perfil_edit_iduser'];
        file_put_contents("updatePerfil.txt", $sql2);
        $result = mysqli_query($connString, $sql2) or die("Error al guardar el Perfil");
        echo $result;
        exit;
    }

?>
	