<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT'];
    include($pathraiz."/common.php");

    if(isset($_POST['btn-login-client'])) {
        $user_email = trim($_POST['clientuser_email']);
        $user_password = trim($_POST['clientpassword']);

        $password = md5($user_password);

        try
        { 
                $stmt = $db_con->prepare("SELECT * FROM tools_clientes WHERE user_email=:usermail");
                $stmt->execute(array(":usermail"=>$user_email));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $count = $stmt->rowCount();
                
                if ($count > 0) {
                    if($row['activo'] == "on"){
                        if($row['user_password']==$password){
                            $_SESSION['user_session'] = $row['id'];
                            $_SESSION['user_name'] = $row['nombre'];
                            $_SESSION['user_email'] = $row['user_email'];
                            $_SESSION['user_rol'] = "CLIENTE";
                            $_SESSION['name'] = $row['nombre'];

                            if(isset($_POST['user_recordar'])){
                                if($_POST['user_recordar'] == true){
                                    mt_srand(time());
                                    $rand = mt_rand(1000000,9999999);

                                    $sql = "UPDATE tools_clientes SET cookie='".$rand."' WHERE id=".$row['id'];

                                    // Prepare statement
                                    $stmt = $db_con->prepare($sql);

                                    // execute the query
                                    $stmt->execute();

                                    if(isset($_COOKIE['id_client']) && isset($_COOKIE['marca'])){
                                        unset($_COOKIE['id_client']);
                                        unset($_COOKIE['marca']);
                                    }
                                    //$dominio = $_SERVER["HTTP_HOST"];
                                    setcookie("id_client", $row["id"], time()+(60*60*24*365),"/", "tools.we-roi.com");
                                    setcookie("marca", $rand, time()+(60*60*24*365), "/", "tools.we-roi.com");
                                }
                            }
                            echo "ok"; // log in
                        }
                        else{
                            echo "El usuario y la contraseña no coinciden"; // wrong details 
                        }
                    }
                    else {
                        echo "Usuario creado. A la espera de autorizar por Weroi"; // wrong details 
                    }
                }
                else {
                    echo "El usuario introducido no existe"; // wrong details 
                }
        }
        catch(PDOException $e){
                echo $e->getMessage();
        }
    } //if isset btn_login

?>