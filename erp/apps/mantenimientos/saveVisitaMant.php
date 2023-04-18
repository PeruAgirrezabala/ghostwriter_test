<?php
    session_start();
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT SUBSTR(ref,6,5) FROM ACTIVIDAD WHERE YEAR(fecha) = YEAR('".$_POST['visita_fecha_mant']."') order by SUBSTR(ref,6,5) desc LIMIT 1";
        file_put_contents("00logSelectRef.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Actividades");
        $registros = mysqli_fetch_row ($result);
        $numEnvios = intval($registros[0])+1;
        
        $fecha=$_POST['visita_fecha_mant'];
        
        $REF = "ACT".date("y",strtotime($fecha)).str_pad($numEnvios, 4, '0', STR_PAD_LEFT);
        $nombre = str_replace(" ", "_", $_POST['visita_nombre_mant']);
        $nombre = str_replace("", "(", $nombre); 
        $nombre = str_replace("", ")", $nombre); 
        $nombre = str_replace("", "'", $nombre); 
        $nombre = str_replace("", "?", $nombre); 
        $nombre = str_replace("", "¿", $nombre);         
        $path = "/".date('Y', strtotime($fecha))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($fecha))."/";
        
        
        // file paths to store
            $basepath = "ERP/ACTIVIDAD".$path;
            $ftp_server = "192.168.3.108";
            $ftp_username = "admin";
            $ftp_password = "Sistemas2111";
            ///share/MD0_DATA/Download/

        // connection to ftp
            $ftp_connection = ftp_connect($ftp_server);
            $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

        // crear path del año si no existiera
            if (ftp_nlist($ftp_connection, "ERP/ACTIVIDAD".$pathYear) === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, "ERP/ACTIVIDAD".$pathYear)) {
                    //echo "Successfully created $basepath";
                    $success = true;
                }
                else
                {
                    //echo "Error while creating $basepath";
                    $success = false;
                }
            }
                
        // crear path del pedido si no existiera
            if (ftp_nlist($ftp_connection, $basepath) === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, $basepath)) {
                    //echo "Successfully created $basepath";
                    $success = true;
                }
                else
                {
                    //echo "Error while creating $basepath";
                    $success = false;
                }
            }
        
        // Tengo id de mantenimiento/proyecto
            $itemid=$_POST["mantenimiento_id"];
            $categoriaid=1;
            $tareaid=23;
            $nombreVisitaMant=$_POST["visita_nombre_mant"];
            
            $sql="SELECT cliente_id FROM PROYECTOS WHERE id=".$itemid;
            $result = mysqli_query($connString, $sql) or die("Error al hacer select del clienteid 1");
            $reg = mysqli_fetch_row($result);
            $clienteid=$reg[0];
            
        
        if ($_POST['act_edit_tecnicos'] != "") {
            $tecnicoid = $_POST['act_edit_tecnicos'];
        }
        else {
            $tecnicoid = "null";
        }
        if ($_POST['visita_responsable_mant'] != "") {
            $responsableid = $_POST['visita_responsable_mant'];
        }
        else {
            $responsableid = "null";
        }
        if ($_POST['visita_estado_mant'] != "") {
            $estadoid = $_POST['visita_estado_mant'];
        }
        else {
            $estadoid = "null";
        }        
        if ($_POST['visita_prioridad_mant'] != "") {
            $priorid = $_POST['visita_prioridad_mant'];
        }
        else {
            $priorid = "null";
        }
        $facturable = 0;
        $imputable = 0;
        if ($_POST['visita_estado_mant'] == 3) {
            $realizada=1;
            $fecha_solucion = "now()";
            $fechasolucion=$fecha;
        }
        else {
            $realizada=0;
            $fechasolucion='';
            $fecha_solucion = "'".$_POST['act_fecha_solucion']."'";
        }
        $sql = "INSERT INTO ACTIVIDAD (
                    ref,
                    responsable,
                    fecha,
                    cliente_id,
                    instalacion,
                    nombre,
                    descripcion,
                    estado_id,
                    categoria_id,
                    tarea_id,
                    tecnico_id,
                    item_id,
                    prioridad_id,
                    path,
                    facturable,
                    imputable,
                    fecha_factu,
                    solucion,
                    fecha_solucion,
                    observaciones,
                    fecha_mod,
                    fecha_fin
                    )
                VALUES (
                    '".$REF."',
                    ".$responsableid.",
                    '".$fecha."',
                    ".$clienteid.",
                    '".$_POST["act_instalacion"]."',
                    '".$nombreVisitaMant."',
                    '',
                    ".$estadoid.",
                    ".$categoriaid.",
                    ".$tareaid.",
                    0,    
                    ".$itemid.",
                    ".$priorid.",
                    '".$path."',
                    ".$facturable.",
                    ".$imputable.",
                    '".$_POST["act_fecha_factu"]."',
                    '',
                    '".$fechasolucion."',
                    '".$_POST["act_observ"]."',
                    now(),
                    '".$fecha."'
                    )";
        file_put_contents("00insertAct.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al insertar la Actividad");
        
        $sqlLastID = "SELECT LAST_INSERT_ID( )";
        $result = mysqli_query($connString, $sqlLastID) or die("Error al buscar el ultimo ID");
        $registro = mysqli_fetch_row($result);
        $actID = $registro[0];
        
        // Si es mantenimiento ingresar día de mantenimiento / visita en.... 
        $sqlInsertVisita="INSERT INTO PROYECTOS_VISITAS (proyecto_id, fecha, realizada,actividad_id) VALUES (".$itemid.",'".$fecha."',".$realizada.",".$actID.")";
        file_put_contents("00insertProyectoVisitas.txt", $sqlInsertVisita);
        $resultInsertVisita = mysqli_query($connString, $sqlInsertVisita) or die("Error al realizar el insert de PROYECTOS_VISITAS");
        
        //file_put_contents("logsTecsInsert.txt", "No des vacio: ".$_POST['act_addtecnicos']);
        if ($_POST['visita_addtecnicos_mant'] != "") {
            foreach ($_POST['visita_addtecnicos_mant'] as $value) {
                // Asignaremos los expedientes al proyecto que estamos editando
                $sql = "INSERT INTO ACTIVIDAD_USUARIO (actividad_id, user_id) VALUES ('".$actID."', ".$value.")";
                $result = mysqli_query($connString, $sql) or die("Error al asignar Tecnicos");
                
                $sqlUpdate = "UPDATE ACTIVIDAD SET tecnico_id=".$value." WHERE id=".$actID;
                $result = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar Tecnico.");
                
                $sqlNotificacion = "SELECT user_email FROM erp_users WHERE erp_users.id =".$value;
                $result = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar user_email");
                $registro = mysqli_fetch_row($result);
                $para = $registro[0];
                $mensaje = "Actividad/Tarea asignada: <a href='http://192.168.3.109/erp/apps/actividad/editAct.php?id=".$actID."'>".$REF." - ".$_POST["act_nombre"]."</a>";
                //sendMail($para, "[NUEVA] Actividad/Tarea asignada - [".$REF."]", $mensaje, $de);
                sendMail("alex@genelek.com", "[NUEVA] Actividad/Tarea asignada - [".$REF."]", $mensaje.estructuraCorreoActividad($actID), $de);
                
            }
        }else{
            // No se ha introducito tecnicos.... Meter el usuario de la sesión (Sino no se vería en la lista desplegable)
            // *Si no se ha asignado tecnicos, se pondrá campoa NULL*
            $sql = "UPDATE ACTIVIDAD SET tecnico_id=NULL WHERE id=".$actID;
            $result = mysqli_query($connString, $sql) or die("Error al asignar Tecnicos");
        }
        
        echo $actID;
?>
	