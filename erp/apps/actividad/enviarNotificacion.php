<?php
    session_start();
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    include($pathraiz."/apps/actividad/correosActividad.php");
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    //Get nombre y apellidos de ID dSession
    $sql = "SELECT id, nombre, apellidos, user_email
                    FROM erp_users
                WHERE id=".$_SESSION['user_session'];
    file_put_contents("logGetTecnicosName0.txt", $sql);
    $result = mysqli_query($connString, $sql) or die("Error al seleccionar el nombre del Tecnico");
    $reg = mysqli_fetch_row($result);
    $tecnico0=$reg[1]. " " .$reg[2]. "( ".$reg[3]." )";
    
    $msgNotificacion = "Mensaje de ".$tecnico0." :<br>";
    $msgNotificacion .= $_POST["msgNotificacion"];
    
    // Get datos Actividad
    $sql = "SELECT ACTIVIDAD.id, ACTIVIDAD.ref, ACTIVIDAD.nombre
                    FROM ACTIVIDAD
                WHERE id=".$_POST['idActividad'];
    file_put_contents("logGetActividad.txt", $sql);
    $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Actividades");
    $reg = mysqli_fetch_row($result);
    $idActividad=$reg[0];
    $refActividad=$reg[1];
    $nombreActividad=$reg[2];
    
    // Get list Mail a enviar
    $sql = "SELECT ACTIVIDAD_USUARIO.actividad_id, erp_users.id, erp_users.nombre, erp_users.apellidos, erp_users.user_email
                    FROM ACTIVIDAD_USUARIO
                    INNER JOIN erp_users
                    ON ACTIVIDAD_USUARIO.user_id = erp_users.id
                WHERE actividad_id=".$_POST['idActividad'];
    file_put_contents("logGetTecnicosActividad2.txt", $sql);
    $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Actividades");
    
    $mensaje = "Actividad/Tarea asignada: <a href='http://192.168.3.108/erp/apps/actividad/editAct.php?id=".$idActividad."'>".$refActividad." - ".$nombreActividad."</a>";
                
    while($reg = mysqli_fetch_row($result)){
        $mail=$reg[4]; // Mail de cada persona...
        sendMail("alex@genelek.com", "[NOTIFICACIÓN] Actividad/Tarea - [".$refActividad."]", $mensaje.notificacionActividad($idActividad,$msgNotificacion), $de);
    }
    
    echo true;
?>
	