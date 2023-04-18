<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");

    if(isset($_POST['btn-login'])) {
        $user_email = trim($_POST['user_email']);
        $user_password = trim($_POST['password']);

        $password = md5($user_password);

        try
        { 
                $stmt = $db_con->prepare("SELECT erp_users.id, erp_users.nombre, erp_roles.nombre role, erp_users.user_email, erp_users.user_password, erp_users.activo, erp_users.role_id FROM erp_users, erp_roles WHERE erp_users.role_id = erp_roles.id AND user_name=:usermail");
                $stmt->execute(array(":usermail"=>$user_email));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $count = $stmt->rowCount();

                $stmtApps = $db_con->prepare("SELECT erp_apps.nombre, erp_apps.icon, erp_apps.url, erp_apps.menuitemname  
                                            FROM erp_users, erp_roles, erp_roles_apps, erp_apps  
                                            WHERE erp_users.role_id = erp_roles.id 
                                            AND erp_apps.id = erp_roles_apps.app_id 
                                            AND erp_roles.id = erp_roles_apps.role_id 
                                            AND erp_users.id =:userid 
                                            AND erp_roles.id =:roleid 
                                            AND erp_apps.ubicacion = 1 
                                            ORDER BY erp_apps.id ASC");
                $stmtApps->execute(array(":userid"=>$row['id'],":roleid"=>$row['role_id']));
                $rowApps1 = $stmtApps->fetchAll(PDO::FETCH_ASSOC);
                $countApps = $stmtApps->rowCount();
                
                $stmtApps = $db_con->prepare("SELECT erp_apps.nombre, erp_apps.icon, erp_apps.url, erp_apps.menuitemname  
                                            FROM erp_users, erp_roles, erp_roles_apps, erp_apps  
                                            WHERE erp_users.role_id = erp_roles.id 
                                            AND erp_apps.id = erp_roles_apps.app_id 
                                            AND erp_roles.id = erp_roles_apps.role_id 
                                            AND erp_users.id =:userid 
                                            AND erp_roles.id =:roleid 
                                            AND erp_apps.ubicacion = 2  
                                            ORDER BY erp_apps.id ASC");
                $stmtApps->execute(array(":userid"=>$row['id'],":roleid"=>$row['role_id']));
                $rowApps2 = $stmtApps->fetchAll(PDO::FETCH_ASSOC);
                
                $stmtApps = $db_con->prepare("SELECT erp_apps.nombre, erp_apps.icon, erp_apps.url, erp_apps.menuitemname  
                                            FROM erp_users, erp_roles, erp_roles_apps, erp_apps  
                                            WHERE erp_users.role_id = erp_roles.id 
                                            AND erp_apps.id = erp_roles_apps.app_id 
                                            AND erp_roles.id = erp_roles_apps.role_id 
                                            AND erp_users.id =:userid 
                                            AND erp_roles.id =:roleid 
                                            AND erp_apps.ubicacion = 3 
                                            ORDER BY erp_apps.id ASC");
                $stmtApps->execute(array(":userid"=>$row['id'],":roleid"=>$row['role_id']));
                $rowApps3 = $stmtApps->fetchAll(PDO::FETCH_ASSOC);
                
                if ($count > 0) {
                    if($row['activo'] == "on"){
                        if($row['user_password']==$password){
                            $_SESSION['user_session'] = $row['id'];
                            $_SESSION['user_name'] = $row['nombre'];
                            $_SESSION['user_email'] = $row['user_email'];
                            $_SESSION['user_rol'] = strtoupper($row['role']);
                            $_SESSION['user_role_id'] = strtoupper($row['role_id']);
                            $_SESSION['name'] = $row[1];
                            $_SESSION['user_apps_menu1'] = $rowApps1;
                            $_SESSION['user_apps_menu2'] = $rowApps2;
                            $_SESSION['user_apps_menu3'] = $rowApps3;

                            if(isset($_POST['user_recordar'])){
                                if($_POST['user_recordar'] == true){
                                    mt_srand(time());
                                    $rand = mt_rand(1000000,9999999);

                                    $sql = "UPDATE erp_users SET cookie='".$rand."' WHERE id=".$row['id'];

                                    // Prepare statement
                                    $stmt = $db_con->prepare($sql);

                                    // execute the query
                                    $stmt->execute();

                                    if(isset($_COOKIE['id_user']) && isset($_COOKIE['marca'])){
                                        unset($_COOKIE['id_user']);
                                        unset($_COOKIE['marca']);
                                    }
                                    //$dominio = $_SERVER["HTTP_HOST"];
                                    setcookie("id_user", $row["id"], time()+(60*60*24*365),"/", "erp.genelek.com");
                                    setcookie("marca", $rand, time()+(60*60*24*365), "/", "erp.genelek.com");
                                }
                            }
                            
                            // Last Conn Update
                            $sql = "UPDATE erp_users SET last_conn='".date('Y-m-d H:i:s',strtotime('-6 hours'))."' WHERE erp_users.id=".$row['id'];
                            // Prepare statement
                            $stmt = $db_con->prepare($sql);
                            // execute the query
                            $stmt->execute();
                            
                            echo "ok"; // log in
                        }
                        else{
                            echo "El usuario y la contraseña no coinciden"; // wrong details 

                        }
                    }
                    else {
                        echo "Usuario creado. A la espera de autorizar por Genelek"; // wrong details 
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