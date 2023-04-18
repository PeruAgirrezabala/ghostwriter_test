
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['ensayos_delensayo'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delEnsayo($_POST['ensayos_delensayo']);
    } else {
        if ($_POST['newensayo_idensayo'] != "") {
            updateEnsayo();
        } else {
            if($_POST['ensayos_delensayodoc'] != ""){
                delEnsayoDoc();
            }else{
                if($_POST['ensayos_delinfoensayo'] != ""){
                    delEnsayoInfo();
                }else{
                    if(($_POST['add_ensayo'] != "") && ($_POST['add_ensayoinfo'] == "")){
                        addEnsayoInfo();
                    }else{
                        if($_POST['ensayospruebas_id'] != ""){
                            updateEnsayoInfo();
                        }else{
                            if($_POST['add_ensayoinfo'] != ""){
                                updateEnsayoInfo2();
                                }else{
                                    if($_POST['cambioesnayoid'] != ""){
                                        updateEnsayoDetalle();
                                    }else{
                                        insertEnsayo();
                                    }
                            }
                        }
                    }
                }
            }
        }
    }
    
    function insertEnsayo() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
                
        if ($_FILES["newensayo_adjunto"]["tmp_name"] != "") {
            $sql = "SELECT path FROM ENTREGAS WHERE id = ".$_POST["newensayo_identrega"];
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar el Path de la Entrega");
            $registros = mysqli_fetch_row ($result);
            $pathentrega = $registros[0];

            $nombre = str_replace(" ", "_", $_POST['newensayo_nombre']);        
            $path = $pathentrega."ENSAYOS/";


            // file paths to store
                $basepath = "PROYECTOS".$path;
                $ftp_server = "192.168.3.108";
                $ftp_username = "admin";
                $ftp_password = "Sistemas2111";
                ///share/MD0_DATA/Download/

            // connection to ftp
                $ftp_connection = ftp_connect($ftp_server);
                $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

            // crear path del pedido si no existiera
                if (ftp_nlist($ftp_connection, "PROYECTOS".$pathentrega."ENSAYOS/") === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, "PROYECTOS".$pathentrega."ENSAYOS/")) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        file_put_contents("errorEnsayo1.txt", "PROYECTOS".$pathentrega."ENSAYOS/");
                        //echo "Error while creating $basepath";
                        $success = false;
                    }
                }

                $source_directory = $_FILES["newensayo_adjunto"]["tmp_name"];
                $destination_directory = $basepath.$nombre."_".$_FILES["newensayo_adjunto"]["name"];

                $upload = ftp_put($ftp_connection, $destination_directory, $source_directory, FTP_ASCII);
        } // si se ha subido algun fichero
        else {
            $success = true;
        }
        
            
        if ($success == true) { 
            $sql = "INSERT INTO ENSAYOS (
                        entrega_id,
                        nombre,
                        descripcion,
                        fecha,
                        fecha_finalizacion,
                        estado_id,
                        erp_userid,
                        plantilla_id
                        )
                    VALUES (
                        ".$_POST["newensayo_identrega"].",
                        '".$_POST["newensayo_nombre"]."',
                        '".$_POST["newensayo_desc"]."',
                        '".$_POST["newensayo_fecha"]."',
                        '".$_POST["newensayo_fechafin"]."',
                        ".$_POST["newensayo_estados"].",
                        ".$_POST["newensayo_tecnico"].",
                        ".$_POST["newensayo_plantilla"]."
                        )";
            file_put_contents("insertEnsayo.txt", $sql);
            //insertActivity("Ensayo ".$_POST["newensayo_nombre"]." creado");
            $result = mysqli_query($connString, $sql) or die("Error al guardar la Ensayo (Insert)");
            
            if ($_FILES["newensayo_adjunto"]["tmp_name"] != "") {
                $sql = "INSERT INTO ENSAYOS_ADJUNTOS (
                            nombre,
                            ensayo_id,
                            path
                            )
                        VALUES (
                            '".$_FILES["newensayo_adjunto"]["name"]."',
                            LAST_INSERT_ID(),
                            '".$destination_directory."'
                            )";
                file_put_contents("insertEnsayoAdjunto.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al guardar el Adjunto");
            }

            echo 1;
        }
        else {
            echo "Error al generar el directorio de la Ensayo";
        }
    }
    
    function updateEnsayo() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        file_put_contents("debug0.txt", " ");
        if ($_POST['action'] != "") {
            
            $sql="SELECT ENSAYOS.erp_userid FROM ENSAYOS WHERE ENSAYOS.id=".$_POST['newensayo_idensayo'];
            $result = mysqli_query($connString, $sql) or die("Error al realizar el select del ensayo.");
            $registros = mysqli_fetch_array($result);
            if($registros[0]==""){
                $user_id=0;
            }else{
                $user_id=$registros[0];
            }
            
            $sql = "UPDATE ENSAYOS 
                        SET estado_id = ".$_POST['action'].", 
                            erp_userid = ".$user_id."
                        WHERE id = ".$_POST['newensayo_idensayo'];
            //$actividad = insertActivity("Ensayo ".$_POST['action']." actualizado");
            file_put_contents("updateEnsayo.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar la Ensayo (Update)");
        } else {
            file_put_contents("debug1.txt", $_FILES["newensayo_adjunto"]["tmp_name"]);
            if ($_FILES["newensayo_adjunto"]["tmp_name"] != "") {
                file_put_contents("debug2.txt", " ");
                $sql = "SELECT path FROM ENTREGAS WHERE id = ".$_POST["newensayo_identrega"];
                $result = mysqli_query($connString, $sql) or die("Error al seleccionar el Path de la Entrega");
                $registros = mysqli_fetch_row ($result);
                $pathentrega = $registros[0];

                $nombre = str_replace(" ", "_", $_POST['newensayo_nombre']);        
                $path = $pathentrega."ENSAYOS/";


                // file paths to store
                    $basepath = "PROYECTOS".$path;
                    $ftp_server = "192.168.3.108";
                    $ftp_username = "admin";
                    $ftp_password = "Sistemas2111";
                    ///share/MD0_DATA/Download/

                // connection to ftp
                    $ftp_connection = ftp_connect($ftp_server);
                    $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
                    file_put_contents("debug3.txt", " ");
                // crear path de los ensayos si no existiera
                    if (ftp_nlist($ftp_connection, "PROYECTOS".$pathentrega."ENSAYOS/") === false) {
                        // try to create directory $dir
                        if (ftp_mkdir($ftp_connection, "PROYECTOS".$pathentrega."ENSAYOS/")) {
                            //echo "Successfully created $basepath";
                            $success = true;
                        }
                        else
                        {
                            file_put_contents("errorEnsayo1.txt", "PROYECTOS".$pathentrega."ENSAYOS/");
                            //echo "Error while creating $basepath";
                            $success = false;
                        }
                    }
                    file_put_contents("debug4.txt", " ");
                    $source_directory = $_FILES["newensayo_adjunto"]["tmp_name"];
                    $destination_directory = $basepath.$nombre."_".$_FILES["newensayo_adjunto"]["name"];

                    $upload = ftp_put($ftp_connection, $destination_directory, $source_directory, FTP_ASCII);
            } // si se ha subido algun fichero
            else {
                $success = true;
            }
            
            if ($success == true) { 
                $sql = "UPDATE ENSAYOS 
                            SET nombre = '".$_POST['newensayo_nombre']."', 
                                descripcion = '".$_POST['newensayo_desc']."',  
                                fecha = '".$_POST['newensayo_fecha']."', 
                                fecha_finalizacion = '".$_POST['newensayo_fechafin']."',
                                estado_id = ".$_POST['newensayo_estados'].",
                                plantilla_id = ".$_POST['newensayo_plantilla'].",
                                erp_userid = ".$_POST['newensayo_tecnico']."
                            WHERE id = ".$_POST['newensayo_idensayo'];
                file_put_contents("updateEnsayos.txt", $sql);
                //$actividad = insertActivity("Ensayo ".$_POST['ensayos_edit_nombre']." actualizado");
                $result = mysqli_query($connString, $sql) or die("Error al guardar el Ensayo.");
                //file_put_contents("LOG11.txt", $_FILES["newensayo_adjunto"]);
                //$uploaddocs = $_FILES['newensayo_adjunto'];
                //file_put_contents("LOG13.txt", $uploaddocs["name"][0]);
                if ($_FILES["newensayo_adjunto"]["tmp_name"] != "") {
                    $sql = "INSERT INTO ENSAYOS_ADJUNTOS (
                                nombre,
                                ensayo_id,
                                path
                                )
                            VALUES (
                                '".$_FILES["newensayo_adjunto"]["name"]."',
                                LAST_INSERT_ID(),
                                '".$destination_directory."'
                                )";
                    file_put_contents("insertEnsayoAdjunto.txt", $sql);
                    $result = mysqli_query($connString, $sql) or die("Error al guardar el Adjunto");
                }
            }
        }
            
        //file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo 1;
    }

    function delEnsayo($ensayo_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        //$data = array();
        //print_R($_POST);die;
        
        // IMPLEMENTAR LA ELIMINACION DE UN PROYECTO DEFINIENDO QUE ES LO QUE SE QUIERE ELIMINAR Y QUE NO
        $sql = "DELETE FROM ENSAYOS_ADJUNTOS WHERE ensayo_id = ".$ensayo_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Ensayo");
        $sql = "DELETE FROM ENSAYOS WHERE id = ".$ensayo_id;
        
        //insertActivity("Ensayo ".$ensayo_id." eliminado");
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Ensayo");
    }
    
    function delEnsayoDoc(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM ENSAYOS_ADJUNTOS WHERE id = ".$_POST['ensayos_delensayodoc'];
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Ensayo Doc");
    }
    function delEnsayoInfo(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM ENSAYOS_INFO WHERE id = ".$_POST['ensayos_delinfoensayo'];
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Ensayo Info");
    }
    function addEnsayoInfo(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO ENSAYOS_INFO
                (ensayo_id, titulo, descripcion, estado, fecha) 
                VALUES 
                (".$_POST['add_ensayo'].",
                '".$_POST['add_tituloinfo']."',
                '".$_POST['add_descinfo']."',
                '".$_POST['add_estadoinfo']."',
                '".$_POST['add_fechainfo']."')";
        //file_put_contents("log00012.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al insertar el Ensayo Info9999");
    }
    function updateEnsayoInfo2(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE ENSAYOS_INFO
                SET titulo='".$_POST['add_tituloinfo']."',
                descripcion='".$_POST['add_descinfo']."', 
                estado='".$_POST['add_estadoinfo']."', 
                fecha='".$_POST['add_fechainfo']."'
                WHERE id=".$_POST['add_ensayoinfo'];
        file_put_contents("logInfoEnsayo2.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al update el Ensayo Info2");        
    }
    function updateEnsayoInfo(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        //ensayospruebas_id
        
        $sqlSel="SELECT estado_id FROM ENSAYOS_PRUEBAS WHERE id=".$_POST['ensayospruebas_id'];
        $resSel = mysqli_query($connString, $sqlSel) or die("Error al realizar select de ENSAYO_PRUEBA");
        $rowSel = mysqli_fetch_array($resSel);
        
        $estado=$rowSel[0];
        
        switch($estado){
            case 0:
                $estado++;
                $clase='dot-green';
                break;
            case 1:
                $estado++;
                $clase='dot-yellow';
                break;
            case 2:
                $estado=0;
                $clase='dot-red';
                break;
        }
        
        $sql="UPDATE ENSAYOS_PRUEBAS SET estado_id=".$estado." WHERE id=".$_POST['ensayospruebas_id'];
        file_put_contents("log9876.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error al realizar update de ENSAYOS_PRUEBAS.");
        
        
        echo $clase;
    }
    function updateEnsayoDetalle(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE ENSAYOS_PRUEBAS
                SET texto='".$_POST['valor']."'
                WHERE id=".$_POST['detalleid']."
                AND ensayo_id=".$_POST['cambioesnayoid'];
        $res = mysqli_query($connString, $sql) or die("Error al realizar update de ENSAYOS_PRUEBAS");
        
        echo $res;
    }
?>
	