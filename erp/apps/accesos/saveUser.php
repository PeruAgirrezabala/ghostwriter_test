
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

    if ($_POST['newuser_deluser'] != "") {
        deleteUser();
    }
    else {
        if ($_POST['newuser_iduser'] != "") {
            updateUser();
        }  
        else {
            insertUser();
        }
    }
    
    
    function updateUser () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['newuser_pass'] != "") {
            $password = ", user_password = '".md5($_POST['newuser_pass'])."'";
        }
        else {
            $password = "";
        }
        $activo="";
        if($_POST['newuser_activo']==""){
            $activo="off";
        }else{
            $activo="on";
        }
        $newuser_avatar=str_replace("\\", "/", $_POST['newuser_avatar']);
        $sql = "UPDATE erp_users SET 
                        nombre = '".$_POST['newuser_nombre']."',
                        apellidos = '".$_POST['newuser_apellidos']."',
                        user_name = '".$_POST['newuser_username']."',
                        user_email = '".$_POST['newuser_email']."',
                        telefono = '".$_POST['newuser_tlfno']."',
                        empresa_id = ".$_POST['newuser_empresas'].", 
                        NIF = '".$_POST['newuser_nif']."',
                        role_id = ".$_POST['newuser_roles'].", 
                        firma_path = '".$_POST['newuser_firma']."',
                        txartela = '".$_POST['newuser_txartela']."',
                        activo = '".$activo."',
                        color = '".$_POST['newuser_color']."',
                        avatar = '".$newuser_avatar."'
                        ".$password."
                    WHERE id =".$_POST['newuser_iduser'];
        file_put_contents("updateTrabajador.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Trabajador");
    }
        
    function insertUser () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['newuser_pass'] != "") {
            $password_field = ", user_password ";
            $password = ", '".md5($_POST['newuser_pass'])."'";
        }
        else {
            $password = "";
            $password_field = "";
        }
        
        $sql = "INSERT INTO erp_users 
                            (nombre,
                            apellidos,
                            user_name,
                            user_email,
                            telefono,
                            empresa_id,
                            NIF,
                            role_id,
                            firma_path,
                            txartela,
                            activo,
                            color
                            ".$password_field."
                            )
                       VALUES (
                            '".$_POST['newuser_nombre']."',
                            '".$_POST['newuser_apellidos']."',
                            '".$_POST['newuser_username']."',
                            '".$_POST['newuser_email']."',
                            '".$_POST['newuser_tlfno']."',
                            ".$_POST['newuser_empresas'].",
                            '".$_POST['newuser_nif']."',
                            ".$_POST['newuser_roles'].",
                            '".$_POST['newuser_firma']."',
                            '".$_POST['newuser_txartela']."',
                            '".$_POST['newuser_activo']."',
                            '".$_POST['newuser_color']."' 
                            ".$password."
                        )";
        file_put_contents("insertTrabajador.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Trabajador");
    }
    
    function deleteUser () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM erp_users WHERE id = ".$_POST['newuser_deluser'];
        file_put_contents("delTrabajador.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Trabajador");
    }
   
?>
	