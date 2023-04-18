
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
            
    if ($_POST['manoobra_id'] != "") {
        createManoObra();
    }elseif($_POST['otros_id'] != ""){
        createOtros();
    }elseif($_POST['subcon_id'] != ""){
        createSubCon();
    }elseif($_POST['viajes_id'] != ""){
        createViajes();
    }
       
    
    
    function createManoObra() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $ofertaid=$_POST["manoobra_id"];
        
        $sqlSelPro="SELECT OFERTAS.proyecto_id FROM OFERTAS WHERE OFERTAS.id=".$ofertaid;
        //file_put_contents("select0.txt", $sqlSelPro);
        $resSelPro = mysqli_query($connString, $sqlSelPro) or die("Error al seleccionar proyecto de la Oferta");
        $regSelPro = mysqli_fetch_array($resSelPro);
        $proyectoid=$regSelPro[0];
        
        $sqlSelMano = " SELECT 
                            OFERTAS_DETALLES_HORAS.tarea_id,
                            OFERTAS_DETALLES_HORAS.descripcion,
                            OFERTAS_DETALLES_HORAS.tipo_hora_id,
                            OFERTAS_DETALLES_HORAS.cantidad,
                            OFERTAS_DETALLES_HORAS.titulo,
                            OFERTAS_DETALLES_HORAS.id
                        FROM 
                            OFERTAS_DETALLES_HORAS 
                        WHERE
                            OFERTAS_DETALLES_HORAS.oferta_id=".$ofertaid."
                        AND
                            OFERTAS_DETALLES_HORAS.added=0";
        //file_put_contents("select.txt", $sqlSelMano);
        $resSelMano = mysqli_query($connString, $sqlSelMano) or die("Error al seleccionar Mano de obra de la Oferta");
        //$regSelMano = mysqli_fetch_row ($resSelMano);
        
        while($regSelMano = mysqli_fetch_array($resSelMano)) {
            $sqlInsert = "INSERT INTO PROYECTOS_TAREAS 
                            (
                            tarea_id,
                            proyecto_id,
                            descripcion,
                            fecha_entrega,
                            estado_id,
                            tecnico_id,
                            tipo_hora_id,
                            cantidad,
                            titulo,
                            of_det_h_id
                            ) VALUES 
                            (
                            ".$regSelMano[0].",
                            ".$proyectoid.",
                            '".$regSelMano[1]."',
                            '".date('y-m-d')."',
                            NULL,
                            0,
                            ".$regSelMano[2].",
                            ".$regSelMano[3].",
                            '".$regSelMano[4]."',
                            ".$regSelMano[5]."    
                            )";
            //file_put_contents("insert.txt", $sqlInsert);
            $resInsert = mysqli_query($connString, $sqlInsert) or die("Error al realizar el Insert de Proyectos Tareas");
            
            $sqlUpdate = "UPDATE OFERTAS_DETALLES_HORAS SET added=1 WHERE id=".$regSelMano[5];
            //file_put_contents("insert.txt", $sqlUpdate);
            $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al realizar el Update de Ofertas Detalles Horas");
        }    
        echo 1;
    }
    
    function createSubCon() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $ofertaid=$_POST["subcon_id"];
        $iva=21;
        
        $sqlSelPro="SELECT OFERTAS.proyecto_id FROM OFERTAS WHERE OFERTAS.id=".$ofertaid;
        //file_put_contents("select0.txt", $sqlSelPro);
        $resSelPro = mysqli_query($connString, $sqlSelPro) or die("Error al seleccionar proyecto de la Oferta");
        $regSelPro = mysqli_fetch_array($resSelPro);
        $proyectoid=$regSelPro[0];
        
        $sqlSelSub = " SELECT 
                            OFERTAS_DETALLES_TERCEROS.id,
                            OFERTAS_DETALLES_TERCEROS.tercero_id,
                            OFERTAS_DETALLES_TERCEROS.oferta_id,
                            OFERTAS_DETALLES_TERCEROS.titulo,
                            OFERTAS_DETALLES_TERCEROS.descripcion,
                            OFERTAS_DETALLES_TERCEROS.cantidad,
                            OFERTAS_DETALLES_TERCEROS.unitario,
                            OFERTAS_DETALLES_TERCEROS.dto1,
                            OFERTAS_DETALLES_TERCEROS.incremento,
                            OFERTAS_DETALLES_TERCEROS.pvp,
                            OFERTAS_DETALLES_TERCEROS.pvp_dto,
                            OFERTAS_DETALLES_TERCEROS.pvp_total,
                            OFERTAS_DETALLES_TERCEROS.added
                        FROM 
                            OFERTAS_DETALLES_TERCEROS 
                        WHERE
                            OFERTAS_DETALLES_TERCEROS.oferta_id=".$ofertaid."
                        AND
                            OFERTAS_DETALLES_TERCEROS.added=0";
        //file_put_contents("select.txt", $sqlSelSub);
        $resSelSub = mysqli_query($connString, $sqlSelSub) or die("Error al seleccionar terceros");
        //$regSelMano = mysqli_fetch_row ($resSelMano);
        
        while($regSelSub = mysqli_fetch_array($resSelSub)) {
            $sqlInsert = "INSERT INTO PROYECTOS_DETALLES_TERCEROS 
                            (
                            tercero_id,
                            proyecto_id,
                            titulo,
                            descripcion,
                            cantidad,
                            unitario,
                            dto1,
                            incremento,
                            pvp,
                            pvp_dto,
                            pvp_total,
                            iva,
                            of_det_id
                            ) VALUES 
                            (
                            ".$regSelSub[1].",
                            ".$proyectoid.",
                            '".$regSelSub[3]."',
                            '".$regSelSub[4]."',
                            ".$regSelSub[5].",
                            ".$regSelSub[6].",
                            ".$regSelSub[7].",
                            ".$regSelSub[8].",
                            ".$regSelSub[9].",
                            ".$regSelSub[10].",
                            ".($regSelSub[11]+($regSelSub[10]*($iva/100))).",
                            ".($regSelSub[10]*($iva/100)).",
                            ".$regSelSub[0]."
                            )";
            //file_put_contents("insert.txt", $sqlInsert);
            $resInsert = mysqli_query($connString, $sqlInsert) or die("Error al realizar el Insert de Proyectos Detalles Terceros");
            
            $sqlUpdate = "UPDATE OFERTAS_DETALLES_TERCEROS SET added=1 WHERE id=".$regSelSub[0];
            //file_put_contents("update.txt", $sqlUpdate);
            $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al realizar el Update de Ofertas Detalles Terceros");
        }
        echo 1;
    }
    function createViajes() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $ofertaid=$_POST["viajes_id"];
        $iva=21;
        
        $sqlSelPro="SELECT OFERTAS.proyecto_id FROM OFERTAS WHERE OFERTAS.id=".$ofertaid;
        //file_put_contents("select0.txt", $sqlSelPro);
        $resSelPro = mysqli_query($connString, $sqlSelPro) or die("Error al seleccionar proyecto de la Oferta");
        $regSelPro = mysqli_fetch_array($resSelPro);
        $proyectoid=$regSelPro[0];
        
        $sqlSelViaje = " SELECT 
                            OFERTAS_DETALLES_VIAJES.id,
                            OFERTAS_DETALLES_VIAJES.oferta_id,
                            OFERTAS_DETALLES_VIAJES.titulo,
                            OFERTAS_DETALLES_VIAJES.descripcion,
                            OFERTAS_DETALLES_VIAJES.cantidad,
                            OFERTAS_DETALLES_VIAJES.unitario,
                            OFERTAS_DETALLES_VIAJES.incremento,
                            OFERTAS_DETALLES_VIAJES.pvp,
                            OFERTAS_DETALLES_VIAJES.pvp_total,
                            OFERTAS_DETALLES_VIAJES.added
                        FROM 
                            OFERTAS_DETALLES_VIAJES 
                        WHERE
                            OFERTAS_DETALLES_VIAJES.oferta_id=".$ofertaid."
                        AND
                            OFERTAS_DETALLES_VIAJES.added=0";
        //file_put_contents("select.txt", $sqlSelViaje);
        $resSelViaje = mysqli_query($connString, $sqlSelViaje) or die("Error al seleccionar viajes");
        //$regSelMano = mysqli_fetch_row ($resSelMano);
        
        while($regSelViaje = mysqli_fetch_array($resSelViaje)) {
            $sqlInsert = "INSERT INTO PROYECTOS_DETALLES_VIAJES 
                            (
                            proyecto_id,
                            titulo,
                            descripcion,
                            cantidad,
                            unitario,
                            incremento,
                            pvp,
                            pvp_total,
                            iva,
                            of_det_id
                            ) VALUES 
                            (
                            ".$proyectoid.",
                            '".$regSelViaje[2]."',
                            '".$regSelViaje[3]."',
                            ".$regSelViaje[4].",
                            ".$regSelViaje[5].",
                            ".$regSelViaje[6].",
                            ".$regSelViaje[7].",
                            ".(($regSelViaje[7]*($iva/100))+$regSelViaje[7]).",
                            ".($regSelViaje[7]*($iva/100)).",
                            ".$regSelViaje[0]."
                            )";
            //file_put_contents("insert.txt", $sqlInsert);
            $resInsert = mysqli_query($connString, $sqlInsert) or die("Error al realizar el Insert de Proyectos Detalles viajes");
            
            $sqlUpdate = "UPDATE OFERTAS_DETALLES_VIAJES SET added=1 WHERE id=".$regSelViaje[0];
            //file_put_contents("update.txt", $sqlUpdate);
            $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al realizar el Update de Ofertas Detalles Terceros");
        }
        echo 1;
    }
    function createOtros() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $ofertaid=$_POST["otros_id"];
        $iva=21;
        
        $sqlSelPro="SELECT OFERTAS.proyecto_id FROM OFERTAS WHERE OFERTAS.id=".$ofertaid;
        //file_put_contents("select0.txt", $sqlSelPro);
        $resSelPro = mysqli_query($connString, $sqlSelPro) or die("Error al seleccionar proyecto de la Oferta");
        $regSelPro = mysqli_fetch_array($resSelPro);
        $proyectoid=$regSelPro[0];
        
        $sqlSelOtros = " SELECT 
                            OFERTAS_DETALLES_OTROS.id,
                            OFERTAS_DETALLES_OTROS.oferta_id,
                            OFERTAS_DETALLES_OTROS.titulo,
                            OFERTAS_DETALLES_OTROS.descripcion,
                            OFERTAS_DETALLES_OTROS.cantidad,
                            OFERTAS_DETALLES_OTROS.unitario,
                            OFERTAS_DETALLES_OTROS.incremento,
                            OFERTAS_DETALLES_OTROS.pvp,
                            OFERTAS_DETALLES_OTROS.pvp_total,
                            OFERTAS_DETALLES_OTROS.added
                        FROM 
                            OFERTAS_DETALLES_OTROS 
                        WHERE
                            OFERTAS_DETALLES_OTROS.oferta_id=".$ofertaid."
                        AND
                            OFERTAS_DETALLES_OTROS.added=0";
        //file_put_contents("select.txt", $sqlSelOtros);
        $resSelOtros = mysqli_query($connString, $sqlSelOtros) or die("Error al seleccionar viajes");
        //$regSelMano = mysqli_fetch_row ($resSelMano);
        
        while($regSelOtros = mysqli_fetch_array($resSelOtros)) {
            $sqlInsert = "INSERT INTO PROYECTOS_DETALLES_OTROSGASTOS 
                            (
                            proyecto_id,
                            titulo,
                            descripcion,
                            cantidad,
                            unitario,
                            incremento,
                            pvp,
                            pvp_total,
                            iva,
                            of_det_id
                            ) VALUES 
                            (
                            ".$proyectoid.",
                            '".$regSelOtros[2]."',
                            '".$regSelOtros[3]."',
                            ".$regSelOtros[4].",
                            ".$regSelOtros[5].",
                            ".$regSelOtros[6].",
                            ".$regSelOtros[7].",
                            ".($regSelOtros[7]+($regSelOtros[7]*($iva/100))).",
                            ".($regSelOtros[7]*($iva/100)).",
                            ".$regSelOtros[0]."
                            )";
            //file_put_contents("insert.txt", $sqlInsert);
            $resInsert = mysqli_query($connString, $sqlInsert) or die("Error al realizar el Insert de Proyectos Detalles Otros");
            
            $sqlUpdate = "UPDATE OFERTAS_DETALLES_OTROS SET added=1 WHERE id=".$regSelOtros[0];
            //file_put_contents("update.txt", $sqlUpdate);
            $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al realizar el Update de Ofertas Detalles Otros");
        }
        echo 1;
    }

?>
	