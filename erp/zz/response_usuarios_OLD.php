
<?php
	//include connection file 
	include_once("connection.php");
	
        require_once("plugins/phpMailer/PHPMailer.php");
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        require_once 'plugins/phpMailer/PHPMailer.php';
        require_once 'plugins/phpMailer/SMTP.php';
        
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new Employee($connString);

	switch($action) {
		case 'add':
			$empCls->insertEmployee($params);
			break;
		case 'edit':
			$empCls->updateEmployee($params);
			break;
		case 'delete':
			$empCls->deleteEmployee($params);
			break;
		default:
			$empCls->getEmployees($params);
			return;
	}
	
	class Employee {
		protected $conn;
		protected $data = array();
		function __construct($connString) {
			$this->conn = $connString;
		}
	
		public function getEmployees($params) {
			
			$this->data = $this->getRecords($params);
			
			echo json_encode($this->data);
		}
		function insertEmployee($params) {
			$data = array();
                        
                        $activo = "on";

                        $password = "";
                        if ($params["new_passwordUsuario"] != "") {
                            $password = md5($params["new_passwordUsuario"]);
                        }
                        
                        $sqlEmail = "(SELECT id FROM tools_clientes WHERE user_email='".$params["new_emailUsuario"]."') UNION (SELECT id FROM tools_users where user_email='".$params["new_emailUsuario"]."')";
                        $queryEmail = mysqli_query($this->conn, $sqlEmail) or die("error to fetch employees data");

                        $count = mysqli_num_rows($queryEmail);

                        if($count == 0){                  
                            $sql = "INSERT INTO tools_users (nombre, apellidos, user_email, telefono, empresa, user_password, activo, role_id) VALUES ('".$params["new_nombreUsuario"]."', '".$params["new_apellidosUsuario"]."', '".$params["new_emailUsuario"]."', '".$params["new_tlfnoUsuario"]."', '".$params["new_empresaUsuario"]."',  '".$password."','".$activo."',".$params["new_accesosroles_roles"].")";
                            //$sql = "INSERT INTO tools_leads (nombre, apellido) VALUES('".$params["new_nombre"]."','".$params["new_apellido"]."')";

                            if ($activo == "on") {
                                $salto = chr(13).chr(10);
                                $mail = new PHPMailer;
                                $mail->CharSet = 'UTF-8';
                                $mail->setFrom('noreply@we-roi.com', 'WEROI');
                                $mail->addAddress($params["new_emailUsuario"], '');
                                $mail->Subject  = 'TOOLS WEROI // Alta de usuario';
                                $mail->Body     = 'El administrador ha dado de alta al usuario '.$params["new_emailUsuario"].' con la contraseña: '.$params["new_passwordUsuario"].' en la página https://tools.we-roi.com'.$salto.$salto.
                                                  'Al disponer de una cuenta verificada, puede proceder al login desde el siguiente enlace: https://tools.we-roi.com/login.php'.$salto.$salto.
                                                  'Para cualquier duda, póngase en contacto con <a href="mailto:urko.delatorre@we-roi.com">urko.delatorre@we-roi.com</a>';
                                if(!$mail->send()) {
                                  //echo 'Ha modificado la contraseña para el usuario '.$params["editclient_emailUsuario"].' en la página https://tools.we-roi.com. No ha podido enviarse la notificación al usuario.';
                                  //echo 'Mailer error: ' . $mail->ErrorInfo;
                                } else {
                                  //echo 'ok';
                                }
                            }

                            echo $result = mysqli_query($this->conn, $sql) or die("error to insert employee data");
                        }
                        else {
                            $mensaje = array("error" => "Email ya existente");
                        
                            echo json_encode($mensaje);
                        }
			
		}
	
	
		function getRecords($params) {
			$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
			
			if (isset($params['current'])) { 
				$page  = $params['current']; 
			} else { 
				$page=1; 
			}
			$start_from = ($page-1) * $rp;
			$sql = $sqlRec = $sqlTot = $where = '';
			
                    if( !empty($params['searchPhrase']) ) {
                        //$where .=" WHERE ";
                        $where .=" AND (tools_users.nombre LIKE '".$params['searchPhrase']."%' ";    
                        $where .=" OR user_name LIKE '".$params['searchPhrase']."%' ";
                        $where .=" OR user_email LIKE '".$params['searchPhrase']."%') ";
                    }
		   
		   if( !empty($params['sort']) ) {  
                        $where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
                    }
                    else {
                        $where .=" ORDER By tools_users.nombre ASC ";
                    }
		   // getting total number records without any search
			//$sql = "SELECT * FROM `tools_leads` ";
			$sql = "SELECT tools_users.id, tools_users.nombre, tools_users.apellidos, tools_users.user_email, tools_users.telefono, tools_users.empresa, tools_users.user_password, tools_roles.nombre role, tools_users.activo, tools_users.role_id 
					FROM tools_users, tools_roles
                                        WHERE tools_users.role_id = tools_roles.id ";
			$sqlTot .= $sql;
			$sqlRec .= $sql;
			
			//concatenate search sql if value exist
			if(isset($where) && $where != '') {
	
				$sqlTot .= $where;
				$sqlRec .= $where;
			}
			if ($rp!=-1)
			$sqlRec .= " LIMIT ". $start_from .",".$rp;
			
			$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot employees data");
			$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch employees data");
			
			while( $row = mysqli_fetch_assoc($queryRecords) ) { 
				$data[] = $row;
			}
                        
                        function utf8_converter($array)
                        {
                            array_walk_recursive($array, function(&$item, $key){
                                if(!mb_detect_encoding($item, 'utf-8', true)){
                                        $item = utf8_encode($item);
                                }
                            });

                            return $array;
                        }
                        
			$json_data = array(
				"current"            => intval($params['current']), 
				"rowCount"            => 10, 			
				"total"    => intval($qtot->num_rows),
				"rows"            => $data   // total data array
				);
			
                        $json_utf8 = utf8_converter($json_data);
                        
			return $json_utf8;
		}
		function updateEmployee($params) {
			$data = array();
			//print_R($_POST);die;
                        
                        $updPassword = "";
                        if ($params["edit_passwordUsuario"] != "") {
                            $password = md5($params["edit_passwordUsuario"]);
                            $updPassword = ", user_password='".$password."' ";
                        }
                        if ($params["chkactivo"] == "") {
                            $activo = "off";
                        }
                        else {
                            $activo = $params["chkactivo"];
                        }
                        
                        $sqlActivo = "SELECT activo FROM tools_users WHERE id=".$_POST["edit_id"];
                        $queryActivo = mysqli_query($this->conn, $sqlActivo) or die("error to fetch employees data");
			
			$rowActivo = mysqli_fetch_row($queryActivo);
                        $previoActivo = $rowActivo[0];
                        
			$sql = "UPDATE `tools_users` SET nombre = '" . $params["edit_nombreUsuario"] . "', apellidos = '".$params["edit_apellidosUsuario"]."', user_email = '".$params["edit_emailUsuario"]."', telefono = '".$params["edit_tlfnoUsuario"]."', empresa = '".$params["edit_empresaUsuario"]."' ".$updPassword.", role_id = ".$params["edit_accesosroles_roles"].", activo = '".$activo."' WHERE id=".$_POST["edit_id"];
                        		
                        if ($updPassword != "") {
                            $salto = chr(13).chr(10);
                            $mail = new PHPMailer;
                            $mail->CharSet = 'UTF-8';
                            $mail->setFrom('noreply@we-roi.com', 'WEROI');
                            $mail->addAddress($params["edit_emailUsuario"], '');
                            $mail->Subject  = 'TOOLS WEROI // Cambio de contraseña';
                            $mail->Body     = 'El administrador ha modificado la contraseña del usuario '.$params["edit_emailUsuario"].' en la página https://tools.we-roi.com'.$salto.$salto.
                                                'Su nueva contraseña es: '.$params["edit_passwordUsuario"].' '.$salto.$salto.
                                                'Para cualquier duda, póngase en contacto con <a href="mailto:urko.delatorre@we-roi.com">urko.delatorre@we-roi.com</a>';
                            if(!$mail->send()) {
                              //echo 'Ha modificado la contraseña para el usuario '.$params["edit_emailUsuario"].' en la página https://tools.we-roi.com. No ha podido enviarse la notificación al usuario.';
                              //echo 'Mailer error: ' . $mail->ErrorInfo;
                            } else {
                              //echo 'ok';
                            }
                        }
                        
                        //file_put_contents("activoantes.txt", $previoActivo);
                        if (($activo == "on") && ($previoActivo == "off")) {
                            $salto = chr(13).chr(10);
                            $mail = new PHPMailer;
                            $mail->CharSet = 'UTF-8';
                            $mail->setFrom('noreply@we-roi.com', 'WEROI');
                            $mail->addAddress($params["edit_emailUsuario"], '');
                            $mail->Subject  = 'TOOLS WEROI // Aceptación de solicitud de acceso';
                            $mail->Body     = 'El administrador ha aceptado al usuario '.$params["edit_emailUsuario"].' en la página https://tools.we-roi.com'.$salto.$salto.
                                              'Al disponer de una cuenta verificada, puede proceder al login desde el siguiente enlace: https://tools.we-roi.com/login.php'.$salto.$salto.
                                              'Para cualquier duda, póngase en contacto con <a href="mailto:urko.delatorre@we-roi.com">urko.delatorre@we-roi.com</a>';
                            if(!$mail->send()) {
                              //echo 'Ha modificado la contraseña para el usuario '.$params["editclient_emailUsuario"].' en la página https://tools.we-roi.com. No ha podido enviarse la notificación al usuario.';
                              //echo 'Mailer error: ' . $mail->ErrorInfo;
                            } else {
                              //echo 'ok';
                            }
                        }
                        
			echo $result = mysqli_query($this->conn, $sql) or die("error to update leads data");
		}
	
		function deleteEmployee($params) {
			$data = array();
			//print_R($_POST);die;
			$sql = "delete from `tools_users` WHERE id=".$params["id"];
			
			echo $result = mysqli_query($this->conn, $sql) or die("Error eliminando Lead");
		}
	} // class employees
?>
	