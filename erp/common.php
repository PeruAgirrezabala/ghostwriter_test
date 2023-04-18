<?php
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");
    require_once($pathraiz."/connection.php");
    //require($pathraiz."/includes/functions.php");
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    
    require_once $pathraiz.'/plugins/phpMailer/PHPMailer.php';
    require_once $pathraiz.'/plugins/phpMailer/SMTP.php';
    require_once $pathraiz.'/plugins/phpMailer/Exception.php';
        
    function sendMail($para, $asunto, $mensaje, $de) {
        $mail = new PHPMailer;
        
        if ($de != "") {
            $from = $de;
        }
        else {
            $from = "erp@genelek.com";
        }
        
        //Server settings
            $mail->SMTPDebug = 0;                                   // Enable verbose debug output
            $mail->isSMTP();                                        // Set mailer to use SMTP
            $mail->Host = '217.116.0.228';                          // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                 // Enable SMTP authentication
            $mail->Username = 'erp@genelek.com';                    // SMTP username
            $mail->Password = 'GSistemaS*21';                      // SMTP password
            $mail->SMTPSecure = false;                              // Enable TLS encryption, `ssl` also accepted
            $mail->SMTPAutoTLS = false;                             // Disable auto TLS if SMTPSecure is not especified
            $mail->Port = 587;                                      // TCP port to connect to
        //Recipients
            $mail->setFrom($from, 'ERP|GENELEK');
            $mail->addAddress($para, '');
            //$mail->addAddress("julendiez@genelek.com", '');       // Para establecer que siempre se le envie a esa persona
        //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        //Content
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true); 
            $mail->Subject  = $asunto;
            $mail->Body     = $mensaje;
            
        if(!$mail->send()) {
            echo 'La notificación no ha podido ser entregada por email.';
            echo 'Mailer error: ' . $mail->ErrorInfo;
        } else {
            return;
        }
    }
    
    function checkPedidosEstados() {
        global $db_con;
        $stmt = $db_con->prepare("UPDATE PEDIDOS_PROV SET estado_id = 3 WHERE fecha_entrega < now() AND estado_id < 3 AND fecha_entrega <> '0000-00-00'");
        $stmt->execute();
        return 1;
    }
    
    function insertActivity ($mensaje) {
        global $db_con;
        $stmt = $db_con->prepare("INSERT INTO erp_activity (user_id, fecha, descripcion ) VALUES(".$_SESSION['user_session'].", now(), '".$mensaje."')");
        $stmt->execute();
        return 1;
    }
    
    function SpanishDate($FechaStamp)
    {
       $ano = date('Y',$FechaStamp);
       $mes = date('n',$FechaStamp);
       $dia = date('d',$FechaStamp);
       $diasemana = date('w',$FechaStamp);
       $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
                      "Jueves","Viernes","Sábado");
       $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                 "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
       //return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
       return $diassemanaN[$diasemana];
    }  
    
    function decimal2hours($decimal) {
        $decimalParts = explode(".", $decimal);
        $hours2 = "0.".$decimalParts[1];
        $hours2time = round((double)$hours2*60);
        $hours1 = $decimalParts[0];
        $hours = sprintf("%02d", $hours1).":".sprintf("%02d", $hours2time);
        return $hours;
    }
    
    function checkCookie () {
        global $db_con;
        if(isset($_COOKIE['id_user']) && isset($_COOKIE['marca'])){
            if($_COOKIE['id_user']!="" || $_COOKIE['marca']!=""){
                
                $stmt = $db_con->prepare("SELECT erp_users.id, erp_users.nombre, erp_roles.nombre role, erp_users.user_email, erp_users.user_password, erp_users.activo FROM erp_users, erp_roles WHERE erp_users.role_id = erp_roles.id AND erp_users.id=".$_COOKIE["id_user"]." AND cookie='".$_COOKIE["marca"]."' AND cookie <> ''");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);    
                $count = $stmt->rowCount();

                if($count > 0){
                    $stmtApps = $db_con->prepare("SELECT erp_apps.nombre, erp_apps.icon, erp_apps.url, erp_apps.menuitemname  
                                                    FROM erp_users, erp_roles, erp_roles_apps, erp_apps  
                                                    WHERE erp_users.role_id = erp_roles.id 
                                                    AND erp_apps.id = erp_roles_apps.app_id 
                                                    AND erp_roles.id = erp_roles_apps.role_id 
                                                    AND erp_users.id =:userid");
                    $stmtApps->execute(array(":userid"=>$row['id']));
                    $rowApps = $stmtApps->fetchAll(PDO::FETCH_ASSOC);
                    $countApps = $stmtApps->rowCount();

                    $_SESSION['user_session'] = $row['id'];
                    $_SESSION['user_name'] = $row['nombre'];
                    $_SESSION['user_email'] = $row['user_email'];
                    $_SESSION['user_rol'] = strtoupper($row['role']);
                    $_SESSION['name'] = $row[1];
                    $_SESSION['user_apps'] = $rowApps;
                    return "si";
                }
                else {
                    return "no";
                }
            }
            else {
                return "no";
            }
        }
        else {
            return "no";
        }

        if(isset($_COOKIE['id_client']) && isset($_COOKIE['marca'])){
            if($_COOKIE['id_client']!="" || $_COOKIE['marca']!=""){
                $stmt = $db_con->prepare("SELECT * FROM erp_clientes WHERE erp_clientes.id=".$_COOKIE["id_client"]." AND cookie='".$_COOKIE["marca"]."' AND cookie <> ''");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);    
                $count = $stmt->rowCount();

                if($count > 0){
                    $_SESSION['user_session'] = $row['id'];
                    $_SESSION['user_name'] = $row['nombre'];
                    $_SESSION['user_email'] = $row['user_email'];
                    $_SESSION['user_rol'] = "CLIENTE";
                    $_SESSION['name'] = $row['nombre'];
                    return "si";
                }
                else {
                    return "no";
                }
            }
            else {
                return "no";
            }
        }
        else {
            return "no";
        }
    }
    
    function checkPedidosProg () {
        global $pathraiz;
        require_once($pathraiz."/connection.php");
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // Chequeo de los pedidos que estan programados y notificar para realizarlos
        $sql = "SELECT PEDIDOS_PROV.id, PEDIDOS_PROV.pedido_genelek, PEDIDOS_PROV.titulo, erp_users.user_email FROM PEDIDOS_PROV, erp_users WHERE erp_users.id = PEDIDOS_PROV.tecnico_id AND PEDIDOS_PROV.estado_id = 7 AND PEDIDOS_PROV.aviso = 0 AND PEDIDOS_PROV.fecha_prog = CURDATE()";
        $res = mysqli_query($connString, $sql) or die("database error:");
                
        $salto = "<br>";
        while($row = mysqli_fetch_array($res)) {
            $url = "<a href='http://192.168.3.108/erp/apps/material/editPedido.php?id=".$row[0]."'>".$row[1]." - ".$row[2]."</a>";
            $mensaje = "Pedido: ".$row[1]." - ".$row[2]." programado para hoy.".$salto.$url;
            $para = $row[3];
            sendMail($para, "[Pedido ".$row[1]."] Programado para hoy", $mensaje, $de);
            //echo "UPDATE PEDIDOS_PROV SET aviso = 1 WHERE id = ".$row[0];
            $sql2 = "UPDATE PEDIDOS_PROV SET aviso = 1 WHERE id = ".$row[0];
            $result = mysqli_query($connString, $sql2) or die("Error al guardar el Detalle");
        }
    }
    
    function query_bd($strConsulta, $env) {
        //global $connection;
        $db = new dbObj();
        $connection =  $db->getConnstring();
        //$db = mysqli_select_db('iralbizu_fisio', $enlace);
        //$resultado = mysqli_query($strConsulta);
        $resultado = mysqli_query($connection, $strConsulta) or die($env);
        return $resultado;
    }
    function query_bd_noreturn($strConsulta, $env) {
        //global $db;
        //global $connection;
        //mysql_db_query("cms", $strConsulta, $db);
        $db = new dbObj();
        $connection =  $db->getConnstring();
        
        mysqli_query($connection, $strConsulta) or die($env);
    }
    
    function query_bd_num_rows($strResultado) {
        $numRows = mysqli_num_rows($strResultado);
        return $numRows;
    }
    
?>