
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_GET['id'] != "") {
        extMant($_GET['id']);
    }
    
    function extMant() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // MANTENIMIENTO ORIGEN
            $sql = "SELECT 
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
                            tipo_proyecto_id,
                            proyecto_id 
                        FROM PROYECTOS WHERE id = ".$_GET['id'];
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar el Mantenimiento Origen");
            $registros = mysqli_fetch_row ($result);
            $nombreMant = $registros[0];
            $descripcion = $registros[1];
            $date = DateTime::createFromFormat("Y-m-d", $registros[2]);
            $oldYear = $date->format("Y");
            $newYear = $oldYear + 1;
            $newDate = $newYear."/".$date->format("m")."/".$date->format("d");
            $fecha_entrega = $registros[3];
            $fecha_fin = $registros[4];
            $cliente_id = $registros[9];
            $estado_id = 1;
            $ubicacion = $registros[11];
            $fecha_registro = $newDate;
            $tipo_proyecto_id = $registros[14];
            $proyecto_id = $registros[15];
        
        //MANTENIMIENTOS
            $sql = "SELECT COUNT(*) FROM PROYECTOS WHERE tipo_proyecto_id = 2";
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Mantenimientos");
            $registros = mysqli_fetch_row ($result);
            $numMantenis = $registros[0];
            $numManteniNew = $numMantenis + 1;

            $REF = "M".date("y",strtotime($newDate)).str_pad($numManteniNew, 4, '0', STR_PAD_LEFT);
        
        $nombre = str_replace(" ", "_", $nombreMant);        
        $path = "/".date('Y', strtotime($newDate))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($newDate))."/";
        
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
            $sql = "INSERT INTO PROYECTOS (
                        ref, 
                        nombre,
                        descripcion,
                        fecha_ini,
                        fecha_entrega,
                        fecha_fin,
                        fecha_mod,
                        cliente_id,
                        estado_id,
                        ubicacion,
                        fecha_registro, 
                        path, 
                        tipo_proyecto_id,
                        proyecto_id
                        )
                    VALUES (
                        '".$REF."',
                        '".$nombreMant."',
                        '".$descripcion."',
                        '".$newDate."',
                        '".$fecha_entrega."',
                        '".$fecha_fin."',
                        now(),
                        ".$cliente_id.",
                        1,
                        '".$ubicacion."',
                        '".$newDate."',
                        '".$path."',
                        ".$tipo_proyecto_id.", 
                        ".$proyecto_id."
                        )";
            file_put_contents("insertExpMant.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Proyecto");
            
            $sql = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar el ultimo  Mantenimiento");
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
?>
	