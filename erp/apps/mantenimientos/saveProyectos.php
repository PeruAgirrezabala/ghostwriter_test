
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    //file_put_contents("debug0.txt", "AQUI");
    
    if ($_POST['proyectos_delproyecto'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delProyecto($_POST['proyectos_delproyecto']);
    }    
    else {
        if ($_POST['proyectos_idproyecto'] != "") {
            updateProyecto();
        }
        else {
            insertProyecto();
        }
    }
    
    function insertProyecto() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        //file_put_contents("debug1.txt", "AQUI");
        
        if ($_POST["newproyecto_parentproyecto"] != "") {
            $parentproject = ", proyecto_id ";
            $parentprojectvalue = ", ".$_POST["newproyecto_parentproyecto"];
        }
        else {
            $parentproject = "";
            $parentprojectvalue = "";
        }
        
        //PROYECTOS
        if ($_POST["newproyecto_tipoproyecto"] == 1) {
            $sql = "SELECT COUNT(*) FROM PROYECTOS WHERE tipo_proyecto_id = 1";
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Proyectos");
            $registros = mysqli_fetch_row ($result);
            $numProyectos = $registros[0];
            $numProyectoNew = $numProyectos + 1;

            $REF = "G".date("y",strtotime($_POST["newproyecto_fechaini"])).str_pad($numProyectoNew, 4, '0', STR_PAD_LEFT);
        }
        
        //MANTENIMIENTOS
        if ($_POST["newproyecto_tipoproyecto"] == 2) {
            $sql = "SELECT COUNT(*) FROM PROYECTOS WHERE tipo_proyecto_id = 2";
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Mantenimientos");
            $registros = mysqli_fetch_row ($result);
            $numMantenis = $registros[0];
            $numManteniNew = $numMantenis + 1;

            $REF = "M".date("y",strtotime($_POST["newproyecto_fechaini"])).str_pad($numManteniNew, 4, '0', STR_PAD_LEFT);
        }
        
        $nombre = str_replace(" ", "_", $_POST['newproyecto_nombre']);        
        $path = "/".date('Y', strtotime($_POST["newproyecto_fechaini"]))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($_POST["newproyecto_fechaini"]))."/";
        
            // file paths to store
                $basepath = "ERP/MANTENIMIENTOS".$path;
                $ftp_server = "192.168.3.108";
                $ftp_username = "admin";
                $ftp_password = "Sistemas2111";
                ///share/MD0_DATA/Download/

            // connection to ftp
                $ftp_connection = ftp_connect($ftp_server);
                $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

            // crear path del año si no existiera
                if (ftp_nlist($ftp_connection, "ERP/MANTENIMIENTOS".$pathYear) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, "ERP/MANTENIMIENTOS".$pathYear)) {
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
                //file_put_contents("PATHProyecto.txt", $basepath);
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
        
        if ($success == true) {
            if ($_POST["newproyecto_mant_year_visits"] == "") {
                $mant_year_visits = 0;
            }
            else {
                $mant_year_visits = $_POST["newproyecto_mant_year_visits"];
            }
            if ($_POST["newproyecto_mant_days_visit"] == "") {
                $mant_days_visit = 0;
            }
            else {
                $mant_days_visit = $_POST["newproyecto_mant_days_visit"];
            }
            if ($_POST["newproyecto_mant_tecs_visit"] == "") {
                $mant_tecs_visit = 0;
            }
            else {
                $mant_tecs_visit = $_POST["newproyecto_mant_tecs_visit"];
            }
            $sql = "INSERT INTO PROYECTOS (
                        ref, 
                        nombre,
                        descripcion,
                        fecha_ini,
                        fecha_entrega,
                        fecha_fin,
                        mant_year_visits,
                        mant_days_visit,
                        mant_tecs_visit,
                        fecha_mod,
                        cliente_id,
                        estado_id,
                        ubicacion,
                        fecha_registro, 
                        path, 
                        tipo_proyecto_id
                        ".$parentproject."
                        )
                    VALUES (
                        '".$REF."',
                        '".$nombre."',
                        '".$_POST["newproyecto_desc"]."',
                        '".$_POST["newproyecto_fechaini"]."',
                        '".$_POST["newproyecto_fechaentrega"]."',
                        '".$_POST["newproyecto_fechafin"]."',
                        ".$mant_year_visits.",
                        ".$mant_days_visit.",
                        ".$mant_tecs_visit.",
                        now(),
                        ".$_POST["newproyecto_clientes"].",
                        ".$_POST["newproyecto_estados"].",
                        '".$_POST["newproyecto_ubicacion"]."',
                        now(),
                        '".$path."',
                        ".$_POST["newproyecto_tipoproyecto"]." 
                        ".$parentprojectvalue."
                        )";
            file_put_contents("insertProyecto.txt", $sql);
            //mysqli_set_charset($connString, "utf8");

            // Creamos el directorio 

            $result = mysqli_query($connString, $sql) or die("Error al guardar el Proyecto");
            
            $sql = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Proyecto");
            $registros = mysqli_fetch_row ($result);
            $idproyecto = $registros[0];
            // Creo los grupos d documentos estandar
            $sql = "INSERT INTO GRUPOS_DOC (
                        nombre,
                        descripcion,
                        proyecto_id
                        )
                    VALUES (
                        'DOCUMENTACION',
                        'Grupo de documentos para la Documentación relacionada con el Proyecto',
                        ".$idproyecto."
                        )";
            $result = mysqli_query($connString, $sql) or die("Error al guardar los Grupos de documentos");

            // file paths to store
                $ftp_server = "192.168.3.108";
                $ftp_username = "admin";
                $ftp_password = "Sistemas2111";
                ///share/MD0_DATA/Download/

            // connection to ftp
                $ftp_connection = ftp_connect($ftp_server);
                $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

            // crear path del pedido si no existiera
                $basepath4 = $basepath."DOCUMENTACION/";
                if (ftp_nlist($ftp_connection, $basepath4) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, $basepath4)) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        //echo "Error while creating $basepath";
                        $success = false;
                    }
                }
            echo 1;
        }
        else {
            echo "Error al generar el directorio del Mantenimiento";
        }
    }
    
    function updateProyecto() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST["proyectos_parent"] != "") {
            $parentproject = ", proyecto_id = ".$_POST["proyectos_parent"];
        }
        else {
            $parentproject = "";
        }
        
        // Guardariamos los expedientes asociados a este proyecto si los tuviera
        
        
        $sql = "DELETE FROM MANTENIMIENTOS_EXP WHERE proyecto_id = ".$_POST['proyectos_idproyecto'];
        $result = mysqli_query($connString, $sql) or die("Error al desasignar Expedientes");
        if ($_POST["proyectos_expedientes"] != "") {
            foreach ($_POST["proyectos_expedientes"] as $value) {
                // Asignaremos los expedientes al proyecto que estamos editando
                $sql = "INSERT INTO MANTENIMIENTOS_EXP (expediente_id, proyecto_id) VALUES (".$value.", ".$_POST['proyectos_idproyecto'].")";
                echo $result = mysqli_query($connString, $sql) or die("Error al asignar Expedientes");
            }
        }
        
        /* Se ha borrado por el nuevo tema de visitas con actividades.
         * 
        $sql = "DELETE FROM PROYECTOS_VISITAS WHERE proyecto_id = ".$_POST['proyectos_idproyecto'];
        $result = mysqli_query($connString, $sql) or die("Error al desasignar Visitas");
        if ($_POST["proyectos_visitas"] != "") {
            foreach ($_POST["proyectos_visitas"] as $value) {
                // Asignaremos los expedientes al proyecto que estamos editando
                $sql = "INSERT INTO PROYECTOS_VISITAS (fecha, proyecto_id) VALUES ('".$value."', ".$_POST['proyectos_idproyecto'].")";
                echo $result = mysqli_query($connString, $sql) or die("Error al asignar Visitas");
            }
        }
        */
        $sql = "UPDATE PROYECTOS 
                SET ref = '".$_POST['proyectos_edit_ref']."', 
                    nombre = '".$_POST['proyectos_edit_nombre']."', 
                    descripcion = '".$_POST['proyectos_edit_desc']."',
                    fecha_ini = '".$_POST['proyectos_edit_fechaini']."', 
                    fecha_entrega = '".$_POST['proyectos_edit_fechaentrega']."', 
                    mant_year_visits = ".$_POST['proyectos_mant_year_visits'].",
                    mant_days_visit = ".$_POST['proyectos_mant_days_visit'].",
                    mant_tecs_visit = ".$_POST['proyectos_mant_tecs_visit'].",
                    fecha_fin = '".$_POST['proyectos_edit_fechafin']."', 
                    fecha_mod = now(), 
                    cliente_id = ".$_POST['proyectos_clientes'].", 
                    estado_id = ".$_POST['proyectos_estados'].",     
                    descripcion = '".$_POST['proyectos_edit_desc']."',
                    tipo_proyecto_id = ".$_POST['proyectos_tipoproyecto'].",
                    facturado = ".$_POST['proyectos_facturado']."
                    ".$parentproject."
                WHERE id = ".$_POST['proyectos_idproyecto'];
        file_put_contents("updateProyectos.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Proyecto");
    }

    function delProyecto($proyecto_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        // IMPLEMENTAR LA ELIMINACION DE UN PROYECTO DEFINIENDO QUE ES LO QUE SE QUIERE ELIMINAR Y QUE NO
        $sql = "DELETE FROM PROYECTOS_DOC WHERE proyecto_id = ".$proyecto_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Proyecto 1");
        $sql = "DELETE FROM PROYECTOS_HORAS_IMPUTADAS WHERE proyecto_id = ".$proyecto_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Proyecto 2");
        $sql = "DELETE FROM PROYECTOS_TAREAS WHERE proyecto_id = ".$proyecto_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Proyecto 3");
        
        $sql = "DELETE FROM PROYECTOS WHERE id = ".$proyecto_id;

        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Proyecto 4");
        echo 0;
    }
?>
	