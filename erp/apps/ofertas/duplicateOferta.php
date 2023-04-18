
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    // SELECT REFERENCIA DE ESTA OFERTA
//    $sql = "SELECT 
//                OFERTAS.ref,
//                OFERTAS.id
//            FROM
//                OFERTAS
//            WHERE
//                OFERTAS.id=".$_POST["versiones_oferta_copy"];
//    file_put_contents("selectOfertasREF.txt", $sql);
//    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Oferta REF");
//    $registros = mysqli_fetch_row ($resultado);
//    $REFActual=$registros[0];
//    $sql = "SELECT 
//                OFERTAS.id
//            FROM
//                OFERTAS
//            WHERE
//                OFERTAS.ref='".$REFActual."'
//            AND
//                OFERTAS.0_ver = 0
//            AND
//                OFERTAS.n_ver = ''
//            ORDER BY
//                OFERTAS.id DESC";
//    file_put_contents("selectOfertasVActual.txt", $sql);
//    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Oferta Version Actual");
//    $registros = mysqli_fetch_row ($resultado);  
    
    // Select del que tenga 0ver y nver a 0
    
    // ID DE LA VERSION ACTUAL
    //$idVersionActual=$registros[0];    
    $idVersionActual=$_POST["versiones_oferta_copy"];
    $idVersionActual2=$_POST["versiones_oferta_copy"];
    
    $idposicional=$idVersionActual;
    do{
        $sqlPadre="SELECT OFERTAS.0_ver FROM OFERTAS WHERE OFERTAS.id=".$idposicional;
        //file_put_contents("selectOfertasVersion.txt", $sqlPadre);
        $resPadre = mysqli_query($connString, $sqlPadre) or die("Error al ejecutar la consulta de Version Padre");
        $regPadre = mysqli_fetch_row ($resPadre);
        $version = $regPadre[0];
        if($version!=0){
            $idposicional=$version;
        }
    }while($version!=0);
    $idVersionActual=$idposicional;
    
    // SELECT MAYOR NUMERO DE VERSION DE ESTA OFERTA
    $sql = "SELECT 
                OFERTAS.n_ver
            FROM
                OFERTAS
            WHERE
                OFERTAS.0_ver=".$idVersionActual."
            ORDER BY
                OFERTAS.n_ver DESC LIMIT 1";
    //file_put_contents("selectOfertasVersion0.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Oferta Version");
    $registros = mysqli_fetch_row ($resultado); 
    $maxVersion = $registros[0];
    
    // COPIA DE OFERTAS //
    $sql ="SELECT 
        ref, titulo, descripcion, proyecto_id, estado_id, fecha, fecha_mod, fecha_validez, cliente_id, path, dto_final, forma_pago, plazo_entrega, ref_genelek, 0_ver, n_ver
    FROM 
        OFERTAS
    WHERE 
        OFERTAS.id = ".$idVersionActual;
    //file_put_contents("selectOfertaActualAll.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Select Oferta Actual All");
    $registros = mysqli_fetch_row ($resultado); 
    $REFActual=$registros[0];
    $estadoid=$registros[4];
    
    if($estadoid==4){
        $estadoid=1;
    }
    
    if($registros[3]!=""){
        $proyectoid=$registros[3];
    }else{
        $proyectoid="'NULL'";
    }
    if($registros[8]!=""){
        $clienteid=$registros[8];
    }else{
        $clienteid="'NULL'";
    }
    
    
    $basepath=$registros[9]."v".chr(($maxVersion+1)+65)."/";
    $ofertas_n_ver=$_POST['ofertas_n_ver'];
    $nombrenuevaref=substr($registros[0],0,5).chr(($maxVersion+1)+65)."-".substr($registros[0],6,8);
    $sql = "INSERT INTO OFERTAS (ref, titulo, descripcion, proyecto_id, estado_id, fecha, fecha_mod, fecha_validez, cliente_id, path, dto_final, forma_pago, plazo_entrega, ref_genelek, 0_ver, n_ver)
    VALUES
        ('".$nombrenuevaref."', '".$registros[1]."', '".$registros[2]."', ".$proyectoid.", ".$estadoid.", '".$registros[5]."', '".$registros[6]."', '".$registros[7]."', ".$clienteid.", '".$basepath."', ".$registros[10].", '".$registros[11]."', '".$registros[12]."', '".$registros[13]."', ".$idVersionActual.", '".($maxVersion+1)."')";
    //file_put_contents("insertCopiaVersionOferta.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de insert Copia Version Oferta");
    
    // SELECT ID DE LA OFERTA NUEVA
    $maxVersionID = mysqli_insert_id($connString);
    

    // Crear path de la versión
    $ftp_server = "192.168.3.108";
    $ftp_username = "admin";
    $ftp_password = "Sistemas2111";
    // connection to ftp
    $ftp_connection = ftp_connect($ftp_server);
    $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
    
//    if (!file_exists($basepath)) {
//        mkdir($basepath, 0777, true);
//    }
    
    // crear path de OFERTAS
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
    
    // COPIAR DATOS ACTUALES Y PONERLOS EN LA CARPETA DE VERSIÓN /************************************************/ PENDIENTE
    
    
    // Hacer copias de las rows correspondientes cambiando y poniendo la id nueva de la oferta (version)
    
    $sql = "INSERT INTO OFERTAS_DETALLES_HORAS
            ( tarea_id, 
            tipo_hora_id,
            cantidad,
            titulo,
            descripcion,
            dto,
            pvp,
            pvp_total,
            oferta_id 
            )
            SELECT tarea_id, 
            tipo_hora_id,
            cantidad,
            titulo,
            descripcion,
            dto,
            pvp,
            pvp_total,
            ".$maxVersionID."
            FROM OFERTAS_DETALLES_HORAS WHERE oferta_id =".$idVersionActual2;
    //file_put_contents("insertDetallesHoras.txt", $sql);
    $resultado = mysqli_query($connString, $sql);
    //$resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de insert Ofertas Detalles Horas");
    $sql = "INSERT INTO OFERTAS_DETALLES_MATERIALES
            ( material_id, 
            oferta_id,
            titulo,
            descripcion,
            cantidad,
            dto1,
            incremento,
            pvp,
            pvp_dto,
            pvp_total,
            material_tarifa_id,
            dto_mat_activo,
            dto_ad_activo,
            dto_prov_id,
            origen
            )
            SELECT material_id, 
            ".$maxVersionID.",
            titulo,
            descripcion,
            cantidad,
            dto1,
            incremento,
            pvp,
            pvp_dto,
            pvp_total,
            material_tarifa_id,
            dto_mat_activo,
            dto_ad_activo,
            dto_prov_id,
            origen
            FROM OFERTAS_DETALLES_MATERIALES WHERE oferta_id =".$idVersionActual2;
    //file_put_contents("insertDetallesMateriales.txt", $sql);
    $resultado = mysqli_query($connString, $sql);
    //$resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de insert Ofertas Detalles Materiales");
    $sql = "INSERT INTO OFERTAS_DETALLES_OTROS
            ( 
            oferta_id,
            titulo,
            descripcion,
            cantidad,
            unitario,
            incremento,
            pvp,
            pvp_total
            )
            SELECT ".$maxVersionID.",
            titulo,
            descripcion,
            cantidad,
            unitario,
            incremento,
            pvp,
            pvp_total
            FROM OFERTAS_DETALLES_OTROS WHERE oferta_id =".$idVersionActual2;
    //file_put_contents("insertDetallesOtros.txt", $sql);
    $resultado = mysqli_query($connString, $sql);
    //$resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de insert Ofertas Detalles Otros");
    $sql = "INSERT INTO OFERTAS_DETALLES_TERCEROS
            ( tercero_id,
            oferta_id,
            titulo,
            descripcion,
            cantidad,
            unitario,
            dto1,
            incremento,
            pvp,
            pvp_dto,
            pvp_total
            )
            SELECT tercero_id,
            ".$maxVersionID.",
            titulo,
            descripcion,
            cantidad,
            unitario,
            dto1,
            incremento,
            pvp,
            pvp_dto,
            pvp_total
            FROM OFERTAS_DETALLES_TERCEROS WHERE oferta_id =".$idVersionActual2;
    //file_put_contents("insertDetallesTerceros.txt", $sql);
    $resultado = mysqli_query($connString, $sql);
    //$resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de insert Ofertas Detalles Terceros");
    $sql = "INSERT INTO OFERTAS_DETALLES_VIAJES
            ( oferta_id,
            titulo,
            descripcion,
            cantidad,
            unitario,
            incremento,
            pvp,
            pvp_total
            )
            SELECT ".$maxVersionID.",
            titulo,
            descripcion,
            cantidad,
            unitario,
            incremento,
            pvp,
            pvp_total
            FROM OFERTAS_DETALLES_VIAJES WHERE oferta_id =".$idVersionActual2;
    //file_put_contents("insertDetallesViajes.txt", $sql);
    $resultado = mysqli_query($connString, $sql);
    //$resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de insert Ofertas Detalles Viajes");
    $sql = "INSERT INTO OFERTAS_DOC
            ( titulo, 
            descripcion,
            oferta_id,
            doc_path
            )
            SELECT titulo, 
            descripcion,
            ".$maxVersionID.",
            doc_path
            FROM OFERTAS_DOC WHERE oferta_id =".$idVersionActual2;
    file_put_contents("insertDetallesDocs.txt", $sql);
    $resultado = mysqli_query($connString, $sql);
    //$resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de insert Ofertas Detalles Horas");
    
    //hacer un echo del ID NUEVO INTRODUCIDO
    echo $maxVersionID;
    
?>
	