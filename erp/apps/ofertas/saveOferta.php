
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['oferta_deloferta'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delOferta();
    }    
    else {
        if ($_POST['ofertas_idoferta'] != "") {
            updateOferta();
        }
        else {
            insertOferta();
        }
    }
    
    function insertOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $ftp_server = "192.168.3.108";
        $ftp_username = "admin";
        $ftp_password = "Sistemas2111";
        
        if (($_POST['newoferta_proyectos'] == "") && ($_POST['proyecto_id'] == "")) {
            $proyectoField = ", proyecto_id";
            $proyecto = ", 12"; // Proyecto sin asignar
            $basepath = "ERP/OFERTAS/";
        }
        else {
            if ($_POST['newoferta_proyectos'] != "") {
                $proyecto_id = $_POST['newoferta_proyectos'];
            }
            else {
                $proyecto_id = $_POST['proyecto_id'];
            }
            $proyectoField = ", proyecto_id";
            $proyecto = ", ".$proyecto_id;
            $sql = "SELECT path FROM PROYECTOS WHERE id = ".$proyecto_id;
            //file_put_contents("queryProyecto.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar el path del Proyecto");
            $registros = mysqli_fetch_row ($result);
            $pathProyecto = $registros[0];
            if($pathProyecto==""){
                $pathProyecto="/";
            }
            //?¿
            $basepath = "PROYECTOS".$pathProyecto."OFERTAS/";
            
            // connection to ftp
            $ftp_connection = ftp_connect($ftp_server);
            $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

            // crear path de OFERTAS
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
        }
        if ($_POST['newoferta_clientes'] == "") {
            // Si no se ha introducido un cliente, asociar SIN ASIGNAR
            $clienteField = ", cliente_id";
            $cliente = ", 0";
        }
        else {
            $clienteField = ", cliente_id";
            $cliente = ", ".$_POST['newoferta_clientes'];
        }
        
        if ($_POST['newoferta_dtoTotal'] != "") {
            $dto_final = $_POST['newoferta_dtoTotal'];
        }   
        else {
            $dto_final = 0;
        }
        
        if ($_POST['newoferta_ref'] == "") {            
            //OFERTAS
            // date('y')
            $sql = "SELECT substr(ref,3,3) FROM OFERTAS
                    WHERE substr(ref,-2) = ".substr($_POST['newoferta_fecha'],2,2)."
                    ORDER BY ref DESC
                    LIMIT 1";
            file_put_contents("queryOfertas.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Ofertas");
            $registros = mysqli_fetch_row ($result);
            $numOfertas = $registros[0];
            $numOfertaNew = $numOfertas + 1;

            $refField = ", ref";
            $REF = "OF".str_pad($numOfertaNew,3,"0",STR_PAD_LEFT)."-".substr($_POST['newoferta_fecha'],2,2); // date("y")
            $refData = ", '".$REF."'";
        }
        else {
            $REF = $_POST['newoferta_ref'];
            $refField = ", ref";
            $refData = ", '".$_POST['newoferta_ref']."'";
        }
        
        
            $ftp_connection = ftp_connect($ftp_server);
            $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
        // file paths to store
            $nombre = str_replace(" ", "_", $_POST['newoferta_titulo']);        
            $basepath .= $REF."_".$nombre."/";
            file_put_contents("logbasepath.txt", $basepath);
            
        // crear path del año si no existiera
            if (ftp_nlist($ftp_connection, $basepath) === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, $basepath)) {
                    //echo "Successfully created $basepath";
                    $success = true;
                }else{
                    //echo "Error while creating $basepath";
                    $success = false;
                }
            }
        
        $sql = "INSERT INTO OFERTAS 
                (
                ref_genelek,
                titulo,
                descripcion,
                fecha,
                fecha_mod,
                fecha_validez,
                path,
                dto_final,
                forma_pago,
                plazo_entrega
                ".$refField."
                ".$clienteField."
                ".$proyectoField."
                )
            VALUES (
                '".$_POST['newoferta_ref_genelek']."',
                '".$_POST['newoferta_titulo']."',
                '".$_POST['newoferta_desc']."',
                '".$_POST['newoferta_fecha']."',
                now(),
                '".$_POST['newoferta_fechaval']."',
                '".$basepath."',
                ".$dto_final.",
                '".$_POST['newoferta_formapago']."',
                '".$_POST['newoferta_plazoentrega']."' 
                ".$refData."
                ".$cliente."
                ".$proyecto."
            )";
        
        //file_put_contents("insertOferta.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar la Oferta");
        
        $sql = "SELECT id FROM OFERTAS ORDER BY id DESC LIMIT 1";
        //file_put_contents("selectOferta.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar la Oferta");
        $registros = mysqli_fetch_row($result);
        echo $registros[0];
    }
    
    function updateOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        if ($_POST['ofertas_proyectos'] == "") {
            $proyecto = "";
        }
        else {
            $proyecto = ", proyecto_id = ".$_POST['ofertas_proyectos'];
        }
        if ($_POST['ofertas_clientes'] == "") {
            $cliente = "";
        }
        else {
            $cliente = ", cliente_id = ".$_POST['ofertas_clientes'];
        }
        // Si esta vesión ya esta aceptada, no cambiar su estado
//        $sqlCheck="SELECT OFERTAS.estado_id FROM OFERTAS WHERE OFERTAS.id=".$_POST['ofertas_idoferta'];
//        $result = mysqli_query($connString, $sqlCheck) or die("Error al seleccionar estado de oferta");
//        $registros = mysqli_fetch_row($result);
//        if($registros[0] == 4){
//            $estadoid=4;
//        }else{
//            $estadoid=$_POST['ofertas_estados'];
//        }
        if($_POST['ofertas_estados']==""){
            $estadoid=4;
        }else{
            $estadoid=$_POST['ofertas_estados'];
        }
        
//        $sqlCheck="SELECT * FROM OFERTAS WHERE (OFERTAS.0_ver=".$row[0]." OR OFERTAS.id=".$row[0].") AND OFERTAS.estado_id=4";
//        file_put_contents("seleectCheck.txt", $sqlCheck);
//        $result = mysqli_query($connString, $sqlCheck) or die("Error al seleccionar si hay una oferta aceptada");
//        if(mysqli_num_rows($result) == 0) {
//            $estadoid=$_POST['ofertas_estados'];
//        }else{
//            $estadoid=1;
//        }
        
        $sql = "UPDATE OFERTAS 
                SET ref = '".$_POST['ofertas_edit_ref']."', 
                    ref_genelek = '".$_POST['ofertas_edit_ref_genelek']."',
                    titulo = '".$_POST['ofertas_edit_nombre']."', 
                    descripcion = '".$_POST['ofertas_edit_desc']."',  
                    fecha = '".$_POST['ofertas_edit_fecha']."', 
                    fecha_validez = '".$_POST['ofertas_edit_fechaval']."', 
                    fecha_mod = now(),
                    estado_id = ".$estadoid.", 
                    plazo_entrega = '".$_POST['ofertas_edit_plazoentrega']."',
                    forma_pago = '".$_POST['ofertas_edit_formapago']."',
                    dto_final = ".$_POST['ofertas_edit_dtofinal']." 
                    ".$proyecto."
                    ".$cliente."
                WHERE id = ".$_POST['ofertas_idoferta'];
        
        //file_put_contents("updateOferta.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Oferta");
    }

    function delOferta() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM OFERTAS_DETALLES_HORAS WHERE oferta_id=".$_POST['oferta_deloferta'];
        $result = mysqli_query($connString, $sql);
        $sql = "DELETE FROM OFERTAS_DETALLES_MATERIALES WHERE oferta_id=".$_POST['oferta_deloferta'];
        $result = mysqli_query($connString, $sql);
        $sql = "DELETE FROM OFERTAS_DETALLES_OTROS WHERE oferta_id=".$_POST['oferta_deloferta'];
        $result = mysqli_query($connString, $sql);
        $sql = "DELETE FROM OFERTAS_DETALLES_TERCEROS WHERE oferta_id=".$_POST['oferta_deloferta'];
        $result = mysqli_query($connString, $sql);
        $sql = "DELETE FROM OFERTAS_DETALLES_VIAJES WHERE oferta_id=".$_POST['oferta_deloferta'];
        $result = mysqli_query($connString, $sql);
        $sql = "DELETE FROM OFERTAS_DOC WHERE oferta_id=".$_POST['oferta_deloferta'];
        $result = mysqli_query($connString, $sql);
        $sql = "DELETE FROM OFERTAS WHERE id=".$_POST['oferta_deloferta'];

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Oferta");
    }
?>
	