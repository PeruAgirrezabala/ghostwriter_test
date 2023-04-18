<?php
    session_start();
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    include($pathraiz."/apps/actividad/correosActividad.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['act_edit_delact'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delAct($_POST['act_edit_delact']);
    } else {
        if ($_POST['act_edit_idact'] != "") {
            updateAct();
        } else {
            if ($_POST['act_edit_idact_fin'] != "") {
                updateActFin();
            } else {
                if ($_POST['get_act'] != "") {
                    getAct();
                } else {
                    if($_POST['dupli_act_id'] != ""){
                        dupliAct();
                    }else{
                        insertAct();
                    }
                }
            }
        }
    }
    
    function insertAct() {
        // Variable para controlar como están los datos necesarios (Asterisco rojo)
        $actID = false;
        // Control Fechas
        if($_POST['act_fecha']!=""){
            // 
        }else{
            $actID = false;
            goto fin;
        }
        if($_POST['act_fecha_fin']!=""){
            //
        }else{
            $actID = false;
            goto fin;
        }
        // Control Título
        if($_POST['act_nombre']!=""){
            //
        }else{
            $actID = false;
            goto fin;
        }
        // Control Estado
        if($_POST['act_estados']!=""){
            //
        }else{
            $actID = false;
            goto fin;
        }
        // Control Categorias
        if($_POST['act_categorias']!=""){
            //
        }else{
            $actID = false;
            goto fin;
        }
        // Control Tareas
        if($_POST['act_tareas']!=""){
            //
        }else{
            $actID = false;
            goto fin;
        }
        // Control Items
        if(($_POST['act_mantenimientos']!="") || ($_POST['act_proyectos']!="") || ($_POST['act_ofertas']!="")){
            //
        }else{
            $actID = false;
            goto fin;
        }
        // Control Prioridad
        if($_POST['act_prior']!=""){
            //
        }else{
            $actID = false;
            goto fin;
        }
        // PTE. Asignado
        /*
        if($_POST['act_addtecnicos']!=""){
            
        }else{
            
        }
        */
        
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT SUBSTR(ref,6,5) FROM ACTIVIDAD WHERE YEAR(fecha) = YEAR('".$_POST['act_fecha']."') order by SUBSTR(ref,6,5) desc LIMIT 1";
        file_put_contents("logSelectRef.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Actividades");
        $registros = mysqli_fetch_row ($result);
        $numEnvios = intval($registros[0])+1;
        
        
        if(date("Y",strtotime($_POST['act_fecha']))==1970){
            $fecha=date("Y-m-d");
        }else{
            $fecha=$_POST['act_fecha'];
        }
        
        $REF = "ACT".date("y",strtotime($fecha)).str_pad($numEnvios, 4, '0', STR_PAD_LEFT);
        $nombre = str_replace(" ", "_", $_POST['act_nombre']);
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
        
        
        if ($_POST['act_mantenimientos'] != "") {
            $itemid = $_POST['act_mantenimientos'];
        }
        else {
            if ($_POST['act_proyectos'] != "") {
                $itemid = $_POST['act_proyectos'];
            }
            else {
                if ($_POST['act_ofertas'] != "") {
                    $itemid = $_POST['act_ofertas'];
                }
                else {
                    $itemid = "null";
                }
            }
        }
        if ($_POST['act_clientes'] != "") {
            $clienteid = $_POST['act_clientes'];
        }
        else {
            $clienteid = "null"; // No se puede permitir clienteId NULL
            // Se puede sacar con el proyectoID!
            if($_POST['act_mantenimientos'] != ""){
                $id2=$_POST['act_mantenimientos'];                
            }elseif($_POST['act_proyectos'] != ""){
                $id2=$_POST['act_proyectos'];
            }else{
                $id2="";
                if($_POST['act_ofertas'] != ""){
                    $id3=$_POST['act_ofertas'];
                }else{
                    $id3="";
                }
            }
            if($id2!=""){                
                // Sacar cliente del Proyecto
                $sql="SELECT cliente_id FROM PROYECTOS WHERE id=".$id2;
                $result = mysqli_query($connString, $sql) or die("Error al hacer select del clienteid 1");
                $reg = mysqli_fetch_row($result);
                $clienteid=$reg[0];
            }elseif($id3!=""){
                $sql="SELECT proyecto_id FROM OFERTAS WHERE id=".$id3;
                $result = mysqli_query($connString, $sql) or die("Error al hacer select del proyectoid");
                $reg = mysqli_fetch_row($result);
                
                $sql="SELECT cliente_id FROM PROYECTOS WHERE id=".$reg[0];
                $result = mysqli_query($connString, $sql) or die("Error al hacer select del clienteid 2");
                $reg = mysqli_fetch_row($result);
                $clienteid=$reg[0];
            }else{
                $clienteid=215; // Si no se ha asignado ningún cliente, asignar a GENELEK.
                // Se evita error y seguramente sea para Gestión interna la actividad o trabajo.
            }
            
        }
        
        if ($_POST['act_tecnicos'] != "") {
            $tecnicoid = $_POST['act_tecnicos'];
        }
        else {
            $tecnicoid = "null";
        }
        if ($_POST['act_responsable'] != "") {
            $responsableid = $_POST['act_responsable'];
        }
        else {
            $responsableid = "null";
        }
        if ($_POST['act_estados'] != "") {
            $estadoid = $_POST['act_estados'];
        }
        else {
            $estadoid = "null";
        }        
        if ($_POST['act_prior'] != "") {
            $priorid = $_POST['act_prior'];
        }
        else {
            $priorid = "null";
        }    
        if ($_POST['act_categorias'] != "") {
            $categoriaid = $_POST['act_categorias'];
        }
        else {
            $categoriaid = "null";
        }  
        if ($_POST['act_tareas'] != "") {
            $tareaid = $_POST['act_tareas'];
        }
        else {
            $tareaid = "null";
        }  
        if ($_POST['act_chkfacturable'] == true) {
            $facturable = 1;
        }
        else {
            $facturable = 0;
        }
        if ($_POST['act_chkimputable'] == true) {
            $imputable = 1;
        }
        else {
            $imputable = 0;
        }
        if (($_POST['act_estados'] == 3) && ($_POST['act_fecha_solucion'] != "")) {
            $fecha_solucion = "now()";
            $realizada = 1;
        }
        else {
            $realizada = 0;
            $fecha_solucion = "'".$_POST['act_fecha_solucion']."'";
        }
        // Controlar las contrabarras \
        $act_desc = str_replace("\\", "\\\\", $_POST['act_desc']);
        
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
                    '".$_POST["act_nombre"]."',
                    '".$act_desc."',
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
                    ".$fecha_solucion.",
                    '".$_POST["act_fecha_solucion"]."',
                    '".$_POST["act_observ"]."',
                    now(),
                    '".$_POST["act_fecha_fin"]."'
                    )";
        file_put_contents("insertAct.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al insertar la Actividad");
        
        $sqlLastID = "SELECT LAST_INSERT_ID( )";
        $result = mysqli_query($connString, $sqlLastID) or die("Error al buscar el ultimo ID");
        $registro = mysqli_fetch_row($result);
        $actID = $registro[0];
        
        if($categoriaid==1){
            // Si es mantenimiento ingresar día de mantenimiento / visita en.... 
            if($_POST["act_fecha_fin"]==""){
                $fecha=$_POST["act_fecha_fin"];
            }
            $sqlInsertVisita="INSERT INTO PROYECTOS_VISITAS (proyecto_id, fecha, realizada,actividad_id) VALUES (".$id2.",'".$fecha."',".$realizada.",".$actID.")";
            file_put_contents("insertVisitaMant.txt", $sqlInsertVisita);
            $resultInsertVisita = mysqli_query($connString, $sqlInsertVisita) or die("Error al realizar el insert de PROYECTOS_VISITAS");
        }
        
        //file_put_contents("logsTecsInsert.txt", "No des vacio: ".$_POST['act_addtecnicos']);
        if ($_POST['act_addtecnicos'] != "") {
            foreach ($_POST['act_addtecnicos'] as $value) {
                // Asignaremos los expedientes al proyecto que estamos editando
                $sql = "INSERT INTO ACTIVIDAD_USUARIO (actividad_id, user_id) VALUES ('".$actID."', ".$value.")";
                $result = mysqli_query($connString, $sql) or die("Error al asignar Tecnicos");
                
                // $sqlUpdate = "UPDATE ACTIVIDAD SET tecnico_id=".$_SESSION['user_session']." WHERE id=".$actID;
                // $result = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar Tecnico.");
                
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
        fin:
        echo $actID;
    }
    
    function updateAct() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['act_edit_mantenimientos'] != "") {
            $itemid = $_POST['act_edit_mantenimientos'];
        }
        else {
            if ($_POST['act_edit_proyectos'] != "") {
                $itemid = $_POST['act_edit_proyectos'];
            }
            else {
                if ($_POST['act_edit_ofertas'] != "") {
                    $itemid = $_POST['act_edit_ofertas'];
                }
                else {
                    $itemid = "null";
                }
            }
        }
        if ($_POST['act_edit_responsable'] != "") {
            $responsableid = $_POST['act_edit_responsable'];
        }
        else {
            $responsableid = "null";
        }
        if ($_POST['act_edit_clientes'] != "") {
            $clienteid = $_POST['act_edit_clientes'];
        }
        else {
            $clienteid = "null";
        }
        if ($_POST['act_edit_estados'] != "") {
            $estadoid = $_POST['act_edit_estados'];
        }
        else {
            $estadoid = "null";
        } 
        if ($_POST['act_edit_prior'] != "") {
            $priorid = $_POST['act_edit_prior'];
        }
        else {
            $priorid = "null";
        } 
        if ($_POST['act_edit_tecnicos'] != "") {
            $tecnicoid = $_POST['act_edit_tecnicos'];    
        }
        else {
            $tecnicoid = "null";
        }     
        if ($_POST['act_edit_categorias'] != "") {
            $categoriaid = $_POST['act_edit_categorias'];
        }
        else {
            $categoriaid = "null";
        }  
        if ($_POST['act_edit_tareas'] != "") {
            $tareaid = $_POST['act_edit_tareas'];
        }
        else {
            $tareaid = "null";
        }  
        if ($_POST['act_edit_chkfacturable'] == true) {
            $facturable = 1;
        }
        else {
            $facturable = 0;
        }
        if ($_POST['act_edit_chkimputable'] == true) {
            $imputable = 1;
        }
        else {
            $imputable = 0;
        }
        if (($_POST['act_edit_estados'] == 3) && ($_POST['act_edit_solucion'] != "")) {
            $fecha_solucion = "now()";
        }
        else {
            $fecha_solucion = "'".$_POST['act_edit_fecha_solucion']."'";
        }
        // Controlar las contrabarras \
        $act_edit_desc = str_replace("\\", "\\\\", $_POST['act_edit_desc']);
        $sql = "UPDATE ACTIVIDAD 
                    SET
                        responsable = ".$responsableid.", 
                        fecha = '".$_POST['act_edit_fecha']."', 
                        cliente_id = ".$clienteid.",
                        instalacion = '".$_POST['act_edit_instalacion']."', 
                        nombre = '".$_POST['act_edit_nombre']."', 
                        descripcion = '".$act_edit_desc."',
                        estado_id = ".$estadoid.", 
                        categoria_id = ".$categoriaid.", 
                        tarea_id = ".$tareaid.", 
                        item_id = ".$itemid.", 
                        prioridad_id = ".$priorid.",
                        facturable = ".$facturable.", 
                        imputable = ".$imputable.", 
                        fecha_factu = '".$_POST['act_edit_fecha_factu']."',
                        observaciones = '".$_POST['act_edit_observ']."',
                        fecha_mod = now(),
                        fecha_fin = '".$_POST["act_edit_fecha_fin"]."'
                WHERE id = ".$_POST['act_edit_idact'];
        //file_put_contents("updateAct.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $resultado = mysqli_query($connString, $sql) or die("Error al guardar la Actividad");
        
        if($categoriaid==1){
            if($_POST["act_edit_fecha_fin"]==""){
                $fecha=$_POST["act_edit_fecha_fin"];
            }else{
                $fecha=$_POST['act_edit_fecha'];
            }
            
            $sqlUdateFecha="UPDATE PROYECTOS_VISITAS SET fecha='".$fecha."' WHERE actividad_id=".$_POST['act_edit_idact'];
            $resUdateFecha = mysqli_query($connString, $sqlUdateFecha) or die("Error al modificar la fecha de la visita");
        }
        
        // Eliminar primero los usuarios que estaban asignados anteriormente
        $sql = "DELETE FROM ACTIVIDAD_USUARIO WHERE actividad_id = ".$_POST['act_edit_idact'];
        $result = mysqli_query($connString, $sql) or die("Error al desasignar Técnicos");
        if ($_POST['act_edit_addtecnicos'] != "") {
            foreach ($_POST["act_edit_addtecnicos"] as $value) {
                // Asignaremos los tecnicos a la prevision que estamos editando
                $sql = "INSERT INTO ACTIVIDAD_USUARIO (actividad_id, user_id) VALUES (".$_POST['act_edit_idact'].", ".$value.")";
                //file_put_contents("logupdateUsers.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al asignar Tecnicos");
                
                // Enviar correo por cada uno!
                $sqlNotificacion = "SELECT user_email FROM erp_users WHERE erp_users.id =".$value;
                $result = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar user_email");
                $registro = mysqli_fetch_row($result);
                $para = $registro[0];
                $mensaje = "Actividad/Tarea asignada: <a href='http://192.168.3.109/erp/apps/actividad/editAct.php?id=".$_POST['act_edit_idact']."'>".$_POST['act_edit_ref']." - ".$_POST['act_edit_nombre']."</a>";
                //sendMail($para, "[UPDATE] Actividad/Tarea asignada - [".$_POST['act_edit_ref']."]", $mensaje, $de);
                sendMail("alex@genelek.com", "[UPDATE] Actividad/Tarea asignada - [".$_POST['act_edit_ref']."]", $mensaje.estructuraCorreoActividad($_POST['act_edit_idact']), $de);
            }
        }else{
            // No se ha introducito tecnicos.... Meter el usuario de la sesión (Sino no se vería en la lista desplegable)
            // *Si no se ha asignado tecnicos, se pondrá campoa NULL*
            $sql = "UPDATE ACTIVIDAD SET tecnico_id=NULL WHERE id=".$actID;
            $result = mysqli_query($connString, $sql) or die("Error al asignar Tecnicos");
        }
        
        
        echo $resultado;
    }
    
    function updateActFin() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['act_edit_estados_fin'] != "") {
            $estadoid = $_POST['act_edit_estados_fin'];
        }
        else {
            $estadoid = "null";
        } 
        
        $sql = "UPDATE ACTIVIDAD 
                    SET estado_id = ".$estadoid.", 
                        fecha_factu = '".$_POST['act_edit_fecha_factu']."',
                        fecha_solucion = '".$_POST['act_edit_fecha_solucion']."', 
                        solucion = '".$_POST['act_edit_solucion']."', 
                        observaciones = '".$_POST['act_edit_observ']."'
                WHERE id = ".$_POST['act_edit_idact_fin'];
        //file_put_contents("updateActFin.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $resultado = mysqli_query($connString, $sql) or die("Error al guardar la Actividad");
        
        // Por cada tecnico enviar un correo de FIN!
        $sqlSelect="SELECT ACTIVIDAD_USUARIO.user_id, ACTIVIDAD.categoria_id, ACTIVIDAD.item_id, ACTIVIDAD.fecha 
                    FROM ACTIVIDAD_USUARIO
                    INNER JOIN ACTIVIDAD ON ACTIVIDAD.id=ACTIVIDAD_USUARIO.actividad_id 
                    WHERE ACTIVIDAD_USUARIO.actividad_id=".$_POST['act_edit_idact_fin'];
        $result = mysqli_query($connString, $sqlSelect) or die("Error al guardar la Actividad");
        $mant_id="";
        $visitafecha="";
        while($reg = mysqli_fetch_row($result)){
            $sqlNotificacion = "SELECT user_email FROM erp_users WHERE erp_users.id =".$reg[0];
            $resultNotificacion = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar user_email");
            $registro = mysqli_fetch_row($resultNotificacion);
            $para = $registro[0];
            
            $mensaje = "Se ha modificado la Finalización de la Actividad/Tarea asignada: <a href='http://192.168.3.109/erp/apps/actividad/editAct.php?id=".$_POST['act_edit_idact_fin']."'>".$_POST['act_edit_ref_fin']." - ".$_POST['act_edit_nombre_fin']."</a>";
            //sendMail($para, "[UPDATE] Actividad/Tarea asignada - [".$_POST['act_edit_ref_fin']."]", $mensaje, $de);
            sendMail("alex@genelek.com", "[FIN] Actividad/Tarea asignada - [".$_POST['act_edit_ref_fin']."]", $mensaje.estructuraCorreoActividad($_POST['act_edit_idact_fin']), $de);   
            
            if($reg[1]==1){ // Si es categoria_id=1, Mantenimiento.
                $mant_id = $reg[2];
                $visitafecha = $reg[3];
            }
        }
        
        // Al realizar la actividad, dar como el mantinimiento como realizado
        if($mant_id!=""){
            $sqlUpdateVisita = "UPDATE PROYECTOS_VISITAS 
                    SET realizada = 1
                WHERE proyecto_id = ".$mant_id." AND fecha ='".$visitafecha."'";
            file_put_contents("log099.txt", $sqlUpdateVisita);
            $resultUpdateVisita = mysqli_query($connString, $sqlUpdateVisita) or die("Error al actualizar visita de Mantenimiento");
        }
        
        
        echo $resultado;
    }

    function delAct($act_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $sql = "SELECT id FROM ACTIVIDAD_DETALLES WHERE actividad_id=".$act_id;
        //file_put_contents("selectDetalles.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar los Detalles de la Actividad");
        while( $row = mysqli_fetch_array($result) ) {
            $sql = "DELETE FROM ACTIVIDAD_DETALLES_HORAS WHERE actividad_detalle_id=".$row[0];
            $result = mysqli_query($connString, $sql) or die("Error al eliminar las horas del Detalle de la Actividad");
        }
        
        $sql = "DELETE FROM ACTIVIDAD_DETALLES WHERE actividad_id=".$act_id;
        //file_put_contents("delDetalles.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Detalles de la Actividad");
        
        $sql = "DELETE FROM ACTIVIDAD_DOC WHERE actividad_id=".$act_id;
        //file_put_contents("delDocs.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Documentos");
        
        $sql = "DELETE FROM ACTIVIDAD_USUARIO WHERE actividad_id=".$act_id;
        //file_put_contents("delUsuarios.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar a los Usuarios");
        
        $sql = "DELETE FROM PROYECTOS_VISITAS WHERE actividad_id=".$act_id;
        //file_put_contents("delUsuarios.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar las visitas. Si es que las hubiese. (Mants)");
        
        $sql = "DELETE FROM ACTIVIDAD WHERE id=".$act_id;
        //file_put_contents("delAct.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Actividad");
    }
    // Con las nuevas funcionalidades esto da igual //
    // Se cambia nombre por si acaso getAct -> getAct777
    function getAct777() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        if ($_POST['soltar_act'] == 1) {
            $tecid = "null";
        }
        else {
            $tecid = $_SESSION['user_session'];
        }
        
        $sql = "UPDATE ACTIVIDAD
                SET tecnico_id = ".$tecid."
                WHERE id = ".$_POST['get_act'];
        //file_put_contents("getPlan.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al asignar la Actividad");
    }
    
    //********************//
    // Duplicar Actividad //
    function dupliAct(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // get next REF
        
        $fecha=date('Y');
        
        $sql = "SELECT SUBSTR(ref,6,5) FROM ACTIVIDAD WHERE YEAR(fecha) = '".$fecha."' order by SUBSTR(ref,6,5) desc LIMIT 1";
        file_put_contents("logSelectRef00.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Actividades");
        $registros = mysqli_fetch_row ($result);
        $numEnvios = intval($registros[0])+1;
        
        
        $REF = "ACT".date("y",strtotime($fecha)).str_pad($numEnvios, 4, '0', STR_PAD_LEFT);
        
        // Insertar/Duplicar Actividad
        $sql="INSERT INTO ACTIVIDAD (ref, categoria_id, item_id, tarea_id, nombre, descripcion, imputable, cliente_id, instalacion, responsable, fecha, fecha_mod, estado_id, prioridad_id, facturable, fecha_factu, tecnico_id, solucion, fecha_solucion, observaciones, path, fecha_fin)
                SELECT '".$REF."' as ref, categoria_id, item_id, tarea_id, nombre, descripcion, imputable, cliente_id, instalacion, responsable, fecha, fecha_mod, estado_id, prioridad_id, facturable, fecha_factu, tecnico_id, solucion, fecha_solucion, observaciones, path, fecha_fin
                FROM ACTIVIDAD WHERE id=".$_POST['dupli_act_id'];
        file_put_contents("logSelectInfertAct.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar/insertar la Actividad");
        
        //get selectedid
        $ultimoInsertadoID=mysqli_insert_id($connString);
        
        // Insertar/Duplicar usuarios asignados a actividad
        $sql="INSERT INTO ACTIVIDAD_USUARIO (actividad_id, user_id)
                SELECT ".$ultimoInsertadoID." as actividad_id, user_id
                FROM ACTIVIDAD_USUARIO WHERE actividad_id=".$_POST['dupli_act_id'];
        file_put_contents("logSelectInfertActUser.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al selectionar/insertar la Actividad Usuario");
        
        // Insertar/Duplicar Detalles de la Actividad
        $sql="INSERT INTO ACTIVIDAD_DETALLES (nombre, descripcion, fecha, fecha_mod, actividad_id, erpuser_id, completado)
                SELECT nombre, descripcion, fecha, fecha_mod, ".$ultimoInsertadoID." as actividad_id, erpuser_id, completado
                FROM ACTIVIDAD_DETALLES WHERE actividad_id=".$_POST['dupli_act_id'];
        file_put_contents("logSelectInfertActDetalle.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al selectionar/insertar la Actividad Detalles");
        
        // Insertar/Duplicar Actividad Doc
        $sql="INSERT INTO ACTIVIDAD_DOC (nombre, descripcion, actividad_id, doc_path)
                SELECT nombre, descripcion, ".$ultimoInsertadoID." as actividad_id, doc_path
                FROM ACTIVIDAD_DOC WHERE actividad_id=".$_POST['dupli_act_id'];
        file_put_contents("logSelectInfertActDoc.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al selectionar/insertar la Actividad Doc");
        
        echo $ultimoInsertadoID;
    }
?>
	