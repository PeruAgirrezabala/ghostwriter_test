
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
        $nombre = str_replace(".", "_", $nombre);
        $path = "/".date('Y', strtotime($_POST["newproyecto_fechaini"]))."/".$REF."_".$nombre."/";
        $pathYear = "/".date('Y', strtotime($_POST["newproyecto_fechaini"]))."/";
        
            // file paths to store
                $basepath = "PROYECTOS".$path;
                $ftp_server = "192.168.3.108";
                $ftp_username = "admin";
                $ftp_password = "Sistemas2111";
                ///share/MD0_DATA/Download/

            // connection to ftp
                $ftp_connection = ftp_connect($ftp_server);
                $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

            // crear path del año si no existiera
                if (ftp_nlist($ftp_connection, "PROYECTOS".$pathYear) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, "PROYECTOS".$pathYear)) {
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
            if ($_POST['newproyecto_ing'] != "") {
                $ingid = $_POST['newproyecto_ing'];
            }
            else {
                $ingid = "null";
            }
            if ($_POST['newproyecto_dirobra'] != "") {
                $dirobraid = $_POST['newproyecto_dirobra'];
            }
            else {
                $dirobraid = "null";
            }
            if ($_POST['newproyecto_promotor'] != "") {
                $promotorid = $_POST['newproyecto_promotor'];
            }
            else {
                $promotorid = "null";
            }
            $sql = "INSERT INTO PROYECTOS (
                        ref, 
                        nombre,
                        cliente_final,
                        descripcion,
                        fecha_ini,
                        fecha_entrega,
                        fecha_fin,
                        fecha_mod,
                        cliente_id,
                        ingenieria_id,
                        dir_obra_id,
                        promotor_id,
                        estado_id,
                        ubicacion,
                        dir_instalacion,
                        coordgps_instalacion,
                        fecha_registro, 
                        path, 
                        tipo_proyecto_id
                        ".$parentproject."
                        )
                    VALUES (
                        '".$REF."',
                        '".$nombre."',
                        '".$_POST['newproyecto_cliente_final']."',
                        '".$_POST["newproyecto_desc"]."',
                        '".$_POST["newproyecto_fechaini"]."',
                        '".$_POST["newproyecto_fechaentrega"]."',
                        '".$_POST["newproyecto_fechafin"]."',
                        now(),
                        ".$_POST["newproyecto_clientes"].",
                        ".$ingid.",
                        ".$dirobraid.",
                        ".$promotorid.",
                        ".$_POST["newproyecto_estados"].",
                        '".$_POST["newproyecto_ubicacion"]."',
                        '".$_POST["newproyecto_direccion"]."',
                        '".$_POST["newproyecto_gps"]."',
                        now(),
                        '".$path."',
                        ".$_POST["newproyecto_tipoproyecto"]." 
                        ".$parentprojectvalue."
                        )";
            //file_put_contents("insertProyecto.txt", $sql);
            //mysqli_set_charset($connString, "utf8");
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Proyecto");
            // Creamos el directorio 

            $idproyecto=mysqli_insert_id($connString);
            
            // De momento se comenta. Da errores y no ejecuta nada mas.... 04/01/2022
            // insertActivity ("Proyecto ".$idproyecto." creado");
            
            // Creo los grupos d documentos estandar
            $sql = "INSERT INTO GRUPOS_DOC (
                        nombre,
                        descripcion,
                        proyecto_id
                        )
                    VALUES (
                        'OFERTAS',
                        'Grupo de documentos para las Ofertas relacionadas con el Proyecto',
                        ".$idproyecto."
                        )";
            $result = mysqli_query($connString, $sql) or die("Error al guardar los Grupos de documentos");
            $sql = "INSERT INTO GRUPOS_DOC (
                        nombre,
                        descripcion,
                        proyecto_id
                        )
                    VALUES (
                        'ESPECIFICACIONES',
                        'Grupo de documentos para las Especificaciones relacionadas con el Proyecto',
                        ".$idproyecto."
                        )";
            $result = mysqli_query($connString, $sql) or die("Error al guardar los Grupos de documentos");
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
            $sql = "INSERT INTO GRUPOS_DOC (
                        nombre,
                        descripcion,
                        proyecto_id
                        )
                    VALUES (
                        'PARTES',
                        'Grupo de documentos para los Partes relacionados con el Proyecto',
                        ".$idproyecto."
                        )";
            $result = mysqli_query($connString, $sql) or die("Error al guardar los Grupos de documentos");
            $sql = "INSERT INTO GRUPOS_DOC (
                        nombre,
                        descripcion,
                        proyecto_id
                        )
                    VALUES (
                        'ENTREGAS',
                        'Grupo de documentos para las Entregas del Proyecto',
                        ".$idproyecto."
                        )";
            $result = mysqli_query($connString, $sql) or die("Error al guardar los Grupos de documentos");
            
            // file paths to store
                $basepath2 = $basepath."OFERTAS/";
                $ftp_server = "192.168.3.108";
                $ftp_username = "admin";
                $ftp_password = "Sistemas2111";
                ///share/MD0_DATA/Download/

            // connection to ftp
                $ftp_connection = ftp_connect($ftp_server);
                $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
                
            file_put_contents("log00.txt", "kk: ".$ftp_connection);
            // crear path del pedido si no existiera
                if (ftp_nlist($ftp_connection, $basepath2) === false) {
                    // try to create directory $dir
                    file_put_contents("log001.txt", "kk: ".ftp_nlist($ftp_connection, $basepath2));
                    if (ftp_mkdir($ftp_connection, $basepath2)) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        //echo "Error while creating $basepath";
                        $success = false;
                        file_put_contents("log01.txt", "kk: ".$basepath2);
                    }
                }
                $basepath3 = $basepath."ESPECIFICACIONES/";
                if (ftp_nlist($ftp_connection, $basepath3) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, $basepath3)) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        //echo "Error while creating $basepath";
                        $success = false;
                        file_put_contents("log02.txt", "kk: ".$basepath3);
                    }
                }
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
                $basepath5 = $basepath."PARTES/";
                if (ftp_nlist($ftp_connection, $basepath5) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, $basepath5)) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        //echo "Error while creating $basepath";
                        $success = false;
                    }
                }
                $basepath6 = $basepath."PARTES/";
                if (ftp_nlist($ftp_connection, $basepath6) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, $basepath6)) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        //echo "Error while creating $basepath";
                        $success = false;
                    }
                }
                $basepath7 = $basepath."PRL/";
                if (ftp_nlist($ftp_connection, $basepath7) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, $basepath7)) {
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
            file_put_contents("err_genDirProyecto.txt", "Error al generar el directorio del proyecto");
            echo "Error al generar el directorio del proyecto";
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
        
        if ($_POST["proyectos_expedientes"] != "") {
            $sql = "DELETE FROM MANTENIMIENTOS_EXP WHERE proyecto_id = ".$_POST['proyectos_idproyecto'];
            $result = mysqli_query($connString, $sql) or die("Error al desasignar Expedientes");
            foreach ($_POST["proyectos_expedientes"] as $value) {
                // Asignaremos los expedientes al proyecto que estamos editando
                $sql = "INSERT INTO MANTENIMIENTOS_EXP (expediente_id, proyecto_id) VALUES (".$value.", ".$_POST['proyectos_idproyecto'].")";
                $result = mysqli_query($connString, $sql) or die("Error al asignar Expedientes");
            }
        }
        
        if ($_POST['proyectos_ing'] != "") {
            $ingid = $_POST['proyectos_ing'];
        }
        else {
            $ingid = "null";
        }
        if ($_POST['proyectos_dirobra'] != "") {
            $dirobraid = $_POST['proyectos_dirobra'];
        }
        else {
            $dirobraid = "null";
        }
        if ($_POST['proyectos_promotor'] != "") {
            $promotorid = $_POST['proyectos_promotor'];
        }
        else {
            $promotorid = "null";
        }
        
        $sql = "UPDATE PROYECTOS 
                SET ref = '".$_POST['proyectos_edit_ref']."', 
                    nombre = '".$_POST['proyectos_edit_nombre']."', 
                    descripcion = '".$_POST['proyectos_edit_desc']."',  
                    fecha_ini = '".$_POST['proyectos_edit_fechaini']."', 
                    fecha_entrega = '".$_POST['proyectos_edit_fechaentrega']."', 
                    fecha_fin = '".$_POST['proyectos_edit_fechafin']."', 
                    fecha_mod = now(), 
                    cliente_id = ".$_POST['proyectos_clientes'].", 
                    ingenieria_id = ".$ingid.", 
                    dir_obra_id = ".$dirobraid.", 
                    promotor_id = ".$promotorid.", 
                    estado_id = ".$_POST['proyectos_estados'].",     
                    descripcion = '".$_POST['proyectos_edit_desc']."',
                    ubicacion = '".$_POST['proyectos_edit_ubicacion']."',
                    dir_instalacion = '".$_POST['proyectos_edit_direccion']."',
                    coordgps_instalacion = '".$_POST['proyectos_edit_gps']."',
                    tipo_proyecto_id = ".$_POST['proyectos_tipoproyecto'].",
                    jefeobra = '".$_POST['proyectos_edit_jefeobra']."',
                    tec1 = '".$_POST['proyectos_edit_tec1']."',
                    tec2 = '".$_POST['proyectos_edit_tec2']."'                        
                    ".$parentproject."
                WHERE id = ".$_POST['proyectos_idproyecto'];
        //file_put_contents("update.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Proyecto");
        insertActivity ("Proyecto ".$_POST['proyectos_idproyecto']." modificado");
        
        echo 1;
    }

    function delProyecto($proyecto_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        // IMPLEMENTAR LA ELIMINACION DE UN PROYECTO DEFINIENDO QUE ES LO QUE SE QUIERE ELIMINAR Y QUE NO
        $sql = "DELETE FROM PROYECTOS_DOC WHERE proyecto_id = ".$proyecto_id;
        $sql = "DELETE FROM PROYECTOS_HORAS_IMPUTADAS WHERE proyecto_id = ".$proyecto_id;
        $sql = "DELETE FROM PROYECTOS_TAREAS WHERE proyecto_id = ".$proyecto_id;
        
        $sql = "DELETE FROM PROYECTOS WHERE id = ".$proyecto_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Proyecto");
        
        insertActivity ("Proyecto ".$proyecto_id." eliminado");
        echo 1;
    }
?>
	