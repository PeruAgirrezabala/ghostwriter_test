<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    //date_default_timezone_set('Europe/Madrid');
    if ($_POST['pedidodetalle_deldetalle'] != "") {
        delDetallePedido($_POST['pedidodetalle_deldetalle']);
    }else{
        if (($_POST['pedidodetalle_detalle_id'] != "") || ($_POST['pedidodetalle_recmat'] != "")) {
            updateDetallePedido();
        }else{
            if($_POST['mat_detalle_id'] != ""){
                multiInsertMaterialStock();
            }else{
                if($_POST['part_mat_detalle_id'] != "" && $_POST["part_mat"] !=""){
                    insertPartMaterialStock();
                }else{
                    if($_POST["parteMat_modal"] != ""){
                        insertPartMaterialStockModal();
                    }else{
                        insertDetallePedido();
                    }
                }
            }
        }
    }
    
    function insertDetallePedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        if ($_POST['pedidodetalle_proyectos'] != "") {
            $proyectoidfiled = ", proyecto_id";
            $proyectoid = ", ".$_POST['pedidodetalle_proyectos'];
        }
        else {
            $proyectoidfiled = "";
            $proyectoid = "";
        }
        if ($_POST['pedidodetalle_entregas'] != "") {
            $entregaidfiled = ", entrega_id";
            $entregaid = ", ".$_POST['pedidodetalle_entregas'];
        }
        else {
            $entregaidfiled = "";
            $entregaid = "";
        }
        
        if ($_POST['pedidodetalle_dtoprov'] != "") {
            $provdtoidfiled = ", dto_prov_id";
            $provdto_id = ", ".$_POST['pedidodetalle_dtoprov'];
        }
        else {
            $provdtoidfiled = "";
            $provdto_id = "";
        }
        if ($_POST['pedidodetalle_tecnicos'] != "") {
            $tecnicoidfiled = ", erp_userid";
            $tecnico_id = ", ".$_POST['pedidodetalle_tecnicos'];
        }
        else {
            $tecnicoidfiled = "";
            $tecnico_id = "";
        }
        if ($_POST['pedidodetalle_dtoprov_desc'] == "") {
            $dtoprov_activo = 0;
        }
        else {
            $dtoprov_activo = 1;
        }
        if ($_POST['pedidodetalle_dtomat_desc'] == "") {
            $dtomat_activo = 0;
        }
        else {
            $dtomat_activo = 1;
        }
        if ($_POST['pedidodetalle_dto_desc'] == "") {
            $dtoad_activo = 0;
        }
        else {
            $dtoad_activo = 1;
        }
        if ($_POST['pedidodetalle_dto_sobretotal'] == true) {
            $dto_ad_prior = 1;
        }
        else {
            $dto_ad_prior = 0;
        }
        if ($_POST['pedidodetalle_fecha_recepcion'] == "") {
            $fecha_recepcion = "null";
        }
        else {
            $fecha_recepcion = date("Y-m-d H:i:s",strtotime($_POST['pedidodetalle_fecha_recepcion']));
        }
        if ($_POST['pedidodetalle_clientes'] == "") {
            $cliente_id = "null";
        }
        else {
            $cliente_id = $_POST['pedidodetalle_clientes'];
        }
        if ($_POST['pedidodetalle_ivas'] == "") {
            $iva_sel = 4;
        }
        else {
            $iva_sel = $_POST['pedidodetalle_ivas'];
        }
        
        if ($_POST['edit_chkrecibido'] == true) {
            if (($_POST['pedidodetalle_precios'] != "") && ($_POST['pedidodetalle_materiales'] != "")) {
                $sql = "INSERT INTO PEDIDOS_PROV_DETALLES 
                        (material_id,
                        material_tarifa_id,
                        pedido_id,
                        ref,
                        unidades,
                        dto,
                        fecha_recepcion,
                        fecha_entrega,
                        recibido, 
                        dto_prov_activo,
                        dto_mat_activo,
                        dto_ad_activo, 
                        dto_ad_prior,
                        iva_id,
                        cliente_id,
                        descripcion
                        ".$tecnicoidfiled."
                        ".$proyectoidfiled."
                        ".$entregaidfiled."
                        ".$provdtoidfiled."
                        )
                    VALUES (".$_POST['pedidodetalle_material_id'].",
                    ".$_POST['pedidodetalle_precios'].", 
                    ".$_POST['pedidodetalle_pedido_id'].",
                    '".$_POST['pedidodetalle_ref']."',
                    ".$_POST['pedidodetalle_cantidad'].",
                    ".$_POST['pedidodetalle_dto'].",
                    '".$fecha_recepcion."',
                    '".$_POST['pedidodetalle_fecha_entrega']."',
                    1,
                    ".$dtoprov_activo.", 
                    ".$dtomat_activo.",
                    ".$dtoad_activo.",
                    ".$dto_ad_prior.",
                    ".$iva_sel.",
                    ".$cliente_id.",
                    '".$_POST['pedidodetalle_desc']."' 
                    ".$tecnico_id."
                    ".$proyectoid." 
                    ".$entregaid." 
                    ".$provdto_id.")";
            }
            else {
                //metemos el detalles libre con su precio metido a mano
                $sql = "INSERT INTO PEDIDOS_PROV_DETALLES 
                        (detalle_libre,
                        pvp,
                        pedido_id,
                        ref,
                        unidades,
                        dto,
                        fecha_recepcion,
                        fecha_entrega,
                        recibido,
                        dto_prov_activo,
                        dto_mat_activo,
                        dto_ad_activo,
                        dto_ad_prior,
                        iva_id,
                        cliente_id, 
                        descripcion 
                        ".$tecnicoidfiled."
                        ".$proyectoidfiled."
                        ".$entregaidfiled."
                        ".$provdtoidfiled."
                        )
                    VALUES ('".$_POST['pedidodetalle_libre']."',
                    ".trim($_POST['pedidodetalle_preciomat']).", 
                    ".$_POST['pedidodetalle_pedido_id'].",
                    '".$_POST['pedidodetalle_ref']."',
                    ".trim($_POST['pedidodetalle_cantidad']).",
                    ".$_POST['pedidodetalle_dto'].",
                    '".$fecha_recepcion."',
                    '".$_POST['pedidodetalle_fecha_entrega']."',
                    1,
                    ".$dtoprov_activo.", 
                    ".$dtomat_activo.",
                    ".$dtoad_activo.",
                    ".$dto_ad_prior.",
                    ".$iva_sel.",
                    ".$cliente_id.",
                    '".$_POST['pedidodetalle_desc']."' 
                    ".$tecnico_id." 
                    ".$proyectoid." 
                    ".$entregaid." 
                    ".$provdto_id.")";
            }
            
            //file_put_contents("insertpedidodetalle.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle. Insert Detalle Pedido");
            updateStock("", $_POST['pedidodetalle_cantidad'], $_POST['pedidodetalle_material_id'], false);
            // Insertar stock ?
            //insertMaterialesStock($_POST['pedidodetalle_material_id'],$cantidad,"0",$proyectoid,$detalle_id);
            //mysqli_set_charset($connString, "utf8");
        }
        else {
            if (($_POST['pedidodetalle_precios'] != "") && ($_POST['pedidodetalle_materiales'] != "")) {
                $sql = "INSERT INTO PEDIDOS_PROV_DETALLES 
                        (material_id,
                        material_tarifa_id,
                        pedido_id,
                        ref,
                        unidades,
                        dto,
                        fecha_recepcion,
                        fecha_entrega,
                        recibido, 
                        dto_prov_activo,
                        dto_mat_activo,
                        dto_ad_activo, 
                        dto_ad_prior,
                        iva_id,
                        cliente_id,
                        descripcion
                        ".$tecnicoidfiled."
                        ".$proyectoidfiled."
                        ".$entregaidfiled."
                        ".$provdtoidfiled."
                        )
                    VALUES (".$_POST['pedidodetalle_material_id'].",
                    ".$_POST['pedidodetalle_precios'].", 
                    ".$_POST['pedidodetalle_pedido_id'].",
                    '".$_POST['pedidodetalle_ref']."',
                    ".$_POST['pedidodetalle_cantidad'].",
                    ".$_POST['pedidodetalle_dto'].",
                    '".$fecha_recepcion."',
                    '".$_POST['pedidodetalle_fecha_entrega']."',
                    0,
                    ".$dtoprov_activo.", 
                    ".$dtomat_activo.",
                    ".$dtoad_activo.",
                    ".$dto_ad_prior.",
                    ".$iva_sel.",
                    ".$cliente_id.",
                    '".$_POST['pedidodetalle_desc']."' 
                    ".$tecnico_id."
                    ".$proyectoid." 
                    ".$entregaid." 
                    ".$provdto_id.")";
            }
            else {
                //metemos el detalles libre con su precio metido a mano
                $sql = "INSERT INTO PEDIDOS_PROV_DETALLES 
                        (material_id,
                        detalle_libre,
                        pvp,
                        pedido_id,
                        ref,
                        unidades,
                        dto,
                        fecha_recepcion,
                        fecha_entrega,
                        recibido,
                        dto_prov_activo,
                        dto_mat_activo,
                        dto_ad_activo,
                        dto_ad_prior,
                        iva_id,
                        cliente_id, 
                        descripcion 
                        ".$tecnicoidfiled."
                        ".$proyectoidfiled."
                        ".$entregaidfiled."
                        ".$provdtoidfiled."
                        )
                    VALUES ('".$_POST['pedidodetalle_material_id'].",
                    ".$_POST['pedidodetalle_libre']."',
                    ".trim($_POST['pedidodetalle_preciomat']).", 
                    ".$_POST['pedidodetalle_pedido_id'].",
                    '".$_POST['pedidodetalle_ref']."',
                    ".trim($_POST['pedidodetalle_cantidad']).",
                    ".$_POST['pedidodetalle_dto'].",
                    '".$fecha_recepcion."',
                    '".$_POST['pedidodetalle_fecha_entrega']."',
                    0,
                    ".$dtoprov_activo.", 
                    ".$dtomat_activo.",
                    ".$dtoad_activo.",
                    ".$dto_ad_prior.",
                    ".$iva_sel.",
                    ".$cliente_id.",
                    '".$_POST['pedidodetalle_desc']."' 
                    ".$tecnico_id." 
                    ".$proyectoid." 
                    ".$entregaid." 
                    ".$provdto_id.")";
            }
            //file_put_contents("insertpedidodetalleee.txt", $sql);
            echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle 2. Insert detalle pedido.");
        }       
    }
    
    function updateDetallePedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $check_pedido=false;
        if ($_POST['pedidodetalle_recmat'] != "") {
            $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                    SET recibido = 1,
                        fecha_recepcion = now()
                    WHERE id = ".$_POST['pedidodetalle_recmat'];
            $detalle_id = $_POST['pedidodetalle_recmat'];
            $cantidad = $_POST['cantidad'];
            
            $check_pedido=true;
            
            $sqlNotificacion = "SELECT user_email FROM erp_users WHERE erp_users.id = (SELECT erp_userid FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$_POST['pedidodetalle_recmat'].")";
            $result = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar user_email");
            $registro = mysqli_fetch_row($result);
            $para = $registro[0];
            $sqlNotificacion = "SELECT 
                                    MATERIALES.ref, 
                                    MATERIALES.nombre, 
                                    PEDIDOS_PROV.titulo, 
                                    PEDIDOS_PROV.pedido_genelek,
                                    PROYECTOS_DETALLE.ref, 
                                    PROYECTOS_DETALLE.nombre,
                                    PROYECTOS_PEDIDO.ref, 
                                    PROYECTOS_PEDIDO.nombre,
                                    MATERIALES.id,
                                    PROYECTOS_DETALLE.id,
                                    PEDIDOS_PROV.id
                                FROM 
                                     PEDIDOS_PROV
                                LEFT JOIN PROYECTOS AS PROYECTOS_PEDIDO
                                    ON PEDIDOS_PROV.proyecto_id = PROYECTOS_PEDIDO.id 
                                INNER JOIN PEDIDOS_PROV_DETALLES 
                                    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                                LEFT JOIN PROYECTOS AS PROYECTOS_DETALLE 
                                    ON PEDIDOS_PROV_DETALLES.proyecto_id = PROYECTOS_DETALLE.id 
                                INNER JOIN MATERIALES 
                                    ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
                                WHERE
                                    PEDIDOS_PROV_DETALLES.id = ".$_POST['pedidodetalle_recmat'];
            //file_put_contents("selectUpdateDetalle.txt", $sqlNotificacion);
            $result = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar material_id");
            $registro = mysqli_fetch_row($result);
            $pedi_id=$registro[10];
            date_default_timezone_set("Europe/Madrid");
            $salto = "<br>";
            $mensaje = "<b>Material:</b> ".$registro[1].$salto."<b>Ref.:</b> ".$registro[0].$salto."<b>Pedido:</b> ".$registro[3]." - ".$registro[2].$salto."<b>Expediente:</b> ".$registro[4]." - ".$registro[5].$salto."<b>Recibido:</b> ".date("Y-m-d H:i:s")." en las instalaciones de Genelek Sistemas.";
            sendMail($para, "[".$registro[4].". ".$registro[5]."] Material recibido", $mensaje, $de);
            insertMaterialesStock($registro[8],intval($cantidad),0,$registro[9],$detalle_id,$db,$connString);
            //insertMaterialesStock($registro[8],$cantidad,0,$registro[9],$detalle_id);
        }
        else {
            if ($_POST['pedidodetalle_proyectos'] != "") {
                $proyectoid = ", proyecto_id = ".$_POST['pedidodetalle_proyectos'];
            }
            else {
                $proyectoid = "";
            }
            if ($_POST['pedidodetalle_entregas'] != "") {
                $entregaid = ", entrega_id = ".$_POST['pedidodetalle_entregas'];
            }
            else {
                $entregaid = "";
            }
            if ($_POST['pedidodetalle_dtoprov'] != "") {
                $provdto_id = ", dto_prov_id = ".$_POST['pedidodetalle_dtoprov'];
            }
            else {
                $provdto_id = "";
            }
            if ($_POST['pedidodetalle_tecnicos'] != "") {
                $tecnico_id = ", erp_userid = ".$_POST['pedidodetalle_tecnicos'];
            }
            else {
                $tecnico_id = ", erp_userid = ''";
            }

            if ($_POST['pedidodetalle_dtoprov_desc'] == "") {
                $dtoprov_activo = 0;
            }
            else {
                $dtoprov_activo = 1;
            }
            if ($_POST['pedidodetalle_dtomat_desc'] == "") {
                $dtomat_activo = 0;
            }
            else {
                $dtomat_activo = 1;
            }
            if ($_POST['pedidodetalle_dto_desc'] == "") {
                $dtoad_activo = 0;
            }
            else {
                $dtoad_activo = 1;
            }
            if ($_POST['pedidodetalle_dto_sobretotal'] == true) {
                $dto_ad_prior = 1;
            }
            else {
                $dto_ad_prior = 0;
            }
            if ($_POST['pedidodetalle_fecha_recepcion'] == "") {
                $fecha_recepcion = "null";
            }
            else {
                $fecha_recepcion = date("Y-m-d H:i:s",strtotime($_POST['pedidodetalle_fecha_recepcion']));
            }
            if ($_POST['pedidodetalle_clientes'] == "") {
                $cliente_id = "null";
            }
            else {
                $cliente_id = $_POST['pedidodetalle_clientes'];
            }
            if ($_POST['pedidodetalle_ivas'] == "") {
                $iva_sel = 4;
            }
            else {
                $iva_sel = $_POST['pedidodetalle_ivas'];
            }

            if ($_POST['edit_chkrecibido'] == true) {
                if (($_POST['pedidodetalle_precios'] != "") && ($_POST['pedidodetalle_materiales'] != "")) {
                    $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                            SET material_id = ".$_POST['pedidodetalle_material_id'].", 
                                material_tarifa_id = ".$_POST['pedidodetalle_precios'].", 
                                pedido_id = ".$_POST['pedidodetalle_pedido_id'].",
                                ref = '".$_POST['pedidodetalle_ref']."',
                                unidades = ".trim($_POST['pedidodetalle_cantidad']).",  
                                dto = ".$_POST['pedidodetalle_dto'].", 
                                fecha_recepcion = '".$fecha_recepcion."', 
                                fecha_entrega = '".$_POST['pedidodetalle_fecha_entrega']."', 
                                recibido = 1,
                                dto_prov_activo = ".$dtoprov_activo.",
                                dto_mat_activo = ".$dtomat_activo.",
                                dto_ad_activo = ".$dtoad_activo.",
                                dto_ad_prior = ".$dto_ad_prior.",
                                iva_id = ".$iva_sel.",
                                cliente_id = ".$cliente_id.", 
                                descripcion = '".$_POST['pedidodetalle_desc']."' 
                                ".$tecnico_id."
                                ".$proyectoid."
                                ".$entregaid."
                                ".$provdto_id."
                            WHERE id = ".$_POST['pedidodetalle_detalle_id'];
                }
                else {
                    $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                            SET detalle_libre = '".$_POST['pedidodetalle_libre']."', 
                                pvp = ".trim($_POST['pedidodetalle_preciomat']).", 
                                pedido_id = ".$_POST['pedidodetalle_pedido_id'].",
                                ref = '".$_POST['pedidodetalle_ref']."',
                                unidades = ".trim($_POST['pedidodetalle_cantidad']).",  
                                dto = ".$_POST['pedidodetalle_dto'].", 
                                fecha_recepcion = '".$fecha_recepcion."', 
                                fecha_entrega = '".$_POST['pedidodetalle_fecha_entrega']."', 
                                recibido = 1,
                                dto_prov_activo = ".$dtoprov_activo.",
                                dto_mat_activo = ".$dtomat_activo.",
                                dto_ad_activo = ".$dtoad_activo.",
                                dto_ad_prior = ".$dto_ad_prior.",
                                iva_id = ".$iva_sel.",
                                cliente_id = ".$cliente_id.", 
                                descripcion = '".$_POST['pedidodetalle_desc']."' 
                                ".$tecnico_id."
                                ".$proyectoid."
                                ".$entregaid."
                                ".$provdto_id."
                            WHERE id = ".$_POST['pedidodetalle_detalle_id'];
                }
                $detalle_id = $_POST['pedidodetalle_detalle_id'];
                $cantidad = $_POST['pedidodetalle_cantidad'];
            } 
            else {
                if (($_POST['pedidodetalle_precios'] != "") && ($_POST['pedidodetalle_materiales'] != "")) {
                    $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                        SET material_id = ".$_POST['pedidodetalle_material_id'].", 
                            material_tarifa_id = ".$_POST['pedidodetalle_precios'].", 
                            pedido_id = ".$_POST['pedidodetalle_pedido_id'].", 
                            ref = '".$_POST['pedidodetalle_ref']."',
                            unidades = ".trim($_POST['pedidodetalle_cantidad']).",  
                            dto = ".$_POST['pedidodetalle_dto'].", 
                            fecha_recepcion = '".$fecha_recepcion."', 
                            fecha_entrega = '".$_POST['pedidodetalle_fecha_entrega']."', 
                            recibido = 0,
                            dto_prov_activo = ".$dtoprov_activo.",
                            dto_mat_activo = ".$dtomat_activo.",
                            dto_ad_activo = ".$dtoad_activo.",
                            dto_ad_prior = ".$dto_ad_prior.",
                            iva_id = ".$iva_sel.",
                            cliente_id = ".$cliente_id.", 
                            descripcion = '".$_POST['pedidodetalle_desc']."' 
                            ".$tecnico_id."
                            ".$proyectoid."
                            ".$entregaid."
                            ".$provdto_id."
                        WHERE id = ".$_POST['pedidodetalle_detalle_id'];
                }
                else {
                    $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                        SET detalle_libre = '".$_POST['pedidodetalle_libre']."', 
                            pvp = ".trim($_POST['pedidodetalle_preciomat']).", 
                            pedido_id = ".$_POST['pedidodetalle_pedido_id'].", 
                            ref = '".$_POST['pedidodetalle_ref']."',
                            unidades = ".trim($_POST['pedidodetalle_cantidad']).",  
                            dto = ".$_POST['pedidodetalle_dto'].", 
                            fecha_recepcion = '".$fecha_recepcion."', 
                            fecha_entrega = '".$_POST['pedidodetalle_fecha_entrega']."', 
                            recibido = 0,
                            dto_prov_activo = ".$dtoprov_activo.",
                            dto_mat_activo = ".$dtomat_activo.",
                            dto_ad_activo = ".$dtoad_activo.",
                            dto_ad_prior = ".$dto_ad_prior.",
                            iva_id = ".$iva_sel.",
                            cliente_id = ".$cliente_id.", 
                            descripcion = '".$_POST['pedidodetalle_desc']."' 
                            ".$tecnico_id."
                            ".$proyectoid."
                            ".$entregaid."
                            ".$provdto_id."
                        WHERE id = ".$_POST['pedidodetalle_detalle_id'];
                }
                $detalle_id = $_POST['pedidodetalle_detalle_id'];
                $cantidad = $_POST['pedidodetalle_cantidad'];
            }
        }
        $pedi_id=$_POST['pedidodetalle_pedido_id'];
        $detalle_id=$_POST['pedidodetalle_recmat'];
        file_put_contents("updateDet.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle. Update detalle Pedido");
        
        $sql = "SELECT PEDIDOS_PROV_DETALLES.recibido, PEDIDOS_PROV_DETALLES.id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.pedido_id=".$pedi_id;
        file_put_contents("selectRecibidos.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar los recibidos de los detalles");
        
        $countDetalles=0;
        $countAcept=0;
        $estado=0;
        while ($registros = mysqli_fetch_array($result)) {
            if($registros[0]==1){
                file_put_contents("logErr.txt", "recibido:"+$registros[0]+" id:"+$registros[1]);
                $countAcept++;
            }
            $countDetalles++;
        }
        if($countAcept==0){// Nada recepcionado
            $estado=1; // O nada o como antes... 1 tramitado
        }elseif($countDetalles==$countAcept){ // Todos recepcionados
            $estado=5;
        }else{ // A medias
            $estado=8;
        }
        
        $sql = "UPDATE PEDIDOS_PROV 
                        SET estado_id=".$estado."
                        WHERE id = ".$pedi_id;
        file_put_contents("updateEstadoPed.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar actualizar Estado del Pedido");
        
        updateStock($detalle_id, $cantidad, "",$check_pedido);
        // Restar stock
        delMaterialStock($detalle_id);
        insertMaterialesStock($registro[8],$cantidad,"0",$registro[9],$detalle_id,$db,$connString);
        // Actualizar estado pedido
        //checkStatusPed($detalle_id);
        
        
        // mysqli_set_charset($connString, "utf8");
    }

    function updateStock($detalle, $incremento, $material_id, $actualizapedido) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($detalle != "") {
            if($actualizapedido==true){
                $pedir = "SELECT pedido_id FROM PEDIDOS_PROV_DETALLES WHERE id ='".$detalle."' LIMIT 1"; 
                $sql = "SELECT 
                            PEDIDOS_PROV_DETALLES.recibido
                        FROM 
                            PEDIDOS_PROV_DETALLES
                        WHERE
                            PEDIDOS_PROV_DETALLES.pedido_id = (SELECT pedido_id FROM PEDIDOS_PROV_DETALLES WHERE id ='".$detalle."' LIMIT 1)
                        ORDER BY 
                            PEDIDOS_PROV_DETALLES.recibido ASC LIMIT 1";
                $emaitza = mysqli_query($connString, $sql) or die("Error al seleccionar pedidos");                
                $registro = mysqli_fetch_row($emaitza);
                // Check último detalle recibido
                if($registro[0]==1){
                    $sqlEstado = "UPDATE PEDIDOS_PROV SET estado_id = '5', fecha_recepcion = now() WHERE PEDIDOS_PROV.id = (".$pedir.")";
                    //file_put_contents("updatePedido1.txt", $sqlEstado);
                    echo $result = mysqli_query($connString, $sqlEstado) or die("Error al guardar el Pedido");
                }
            }else{
                $sqlStock = "UPDATE MATERIALES SET stock = stock + ".$incremento." WHERE id = (SELECT material_id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$detalle.")";
                //file_put_contents("updateStock01.txt", $sqlStock);
                $result = mysqli_query($connString, $sqlStock) or die("Error al actualizar el Stock 01");
            }
        }
        else {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + ".$incremento." WHERE id = ".$material_id;
            file_put_contents("updateStock02.txt", $sqlStock);
            $result = mysqli_query($connString, $sqlStock) or die("Error al actualizar el Stock 02");
        }
        
    }
    
    function delDetallePedido($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "DELETE from PEDIDOS_PROV_DETALLES WHERE id=".$detalle_id;
        //file_put_contents("delDetalle.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
        
        // ELIMINAR: MATERIALES_STOCK y para actualizar stock de MATERIALES!
        $sql = "DELETE from MATERIALES_STOCK WHERE pedido_detalle_id=".$detalle_id;
        //file_put_contents("delDetalle.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Material Stock con Detalle");
    }
    
    
    //////*****************************************************************//////
    function insertMaterialesStock($material_id,$stock,$ubicacion_id,$proyecto_id,$pedido_detalle_id,$db,$connString) {
        //$db = new dbObj();
        //$connString = $db->getConnstring();
        
        // COMPROBACIONES VARIAS
            /*
             ALM        1
             PRO        2
             MAN        3
             MON        4
             OUT/INS    0
              
             */ 
        // si tipo proyecto id = 2.......  Mantenimiento 3
        switch($proyecto_id){
            case 10:
                $ubicacion_id=1;
                break;
            case 11:
                $ubicacion_id=1;
                break;
            default:
                $ubicacion_id=2;
                break;
        }
        $sql = "SELECT tipo_proyecto_id FROM PROYECTOS WHERE id =".$proyecto_id;
        file_put_contents("selectTipoProyecto.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al buscar material_id 2.");
        $registro = mysqli_fetch_row($result);
        //file_put_contents("selectTipoProyectoVal.txt", $registro[0]);
        
        if($registro[0]==2){
            $ubicacion_id=3;
        }
        
        // SQL
        $sql = "INSERT INTO MATERIALES_STOCK 
                            (material_id,
                            stock,
                            ubicacion_id,
                            proyecto_id,
                            pedido_detalle_id)
                        VALUES (".$material_id.",
                        ".$stock.", 
                        ".$ubicacion_id.",
                        ".$proyecto_id.",
                        ".$pedido_detalle_id.")";

        //file_put_contents("insertMaterialesStock.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Stock");
    }
    
    function multiInsertMaterialStock(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        //str_split($string, strlen($string) - 1);
        
        $pedido_detalles_id = array_map('intval', explode('-', $_POST['mat_detalle_id']));
        
        foreach ($pedido_detalles_id as $detalle_id) {
             
            $sql = "SELECT * FROM MATERIALES_STOCK WHERE pedido_detalle_id =".$detalle_id;
            //file_put_contents("selectMatStock.txt",$sql);
            $resultado = mysqli_query($connString, $sql);
            if(mysqli_num_rows($resultado) == 0){
                $sql="SELECT
                        PEDIDOS_PROV_DETALLES.id,
                        PEDIDOS_PROV_DETALLES.material_id,
                        PEDIDOS_PROV_DETALLES.unidades,
                        PEDIDOS_PROV_DETALLES.proyecto_id,
                        PEDIDOS_PROV_DETALLES.pedido_id
                        FROM PEDIDOS_PROV_DETALLES 
                        WHERE PEDIDOS_PROV_DETALLES.id=".$detalle_id;
                file_put_contents("selectPedDet.txt",$sql);
                $resultado = mysqli_query($connString, $sql) or die("Error al hacer la select de detalles");
                
                $row = mysqli_fetch_row($resultado);
                
                
                //insertMaterialesStock($row[1],$row[2],0,$row[3],$row[0]);
                //insertMaterialesStock ($material_id,$stock,$ubicacion_id,$proyecto_id,$pedido_detalle_id) //
                
                $material_id=$row[1];
                $stock=$row[2];
                $ubicacion_id=9;
                $proyecto_id=$row[3];
                $pedido_detalle_id=$row[0];
                $pedido_id=$row[4];
                        
                switch($proyecto_id){
                    case 10:
                        $ubicacion_id=1;
                        break;
                    case 11:
                        $ubicacion_id=1;
                        break;
                    default:
                        $ubicacion_id=2;
                        break;
                }
                $sql = "SELECT tipo_proyecto_id FROM PROYECTOS WHERE id =".$proyecto_id;
                file_put_contents("selectTipoProyectoId.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al buscar material_id 3");
                $registro = mysqli_fetch_row($result);
                //file_put_contents("selectTipoProyecto.txt", $registro[0]);

                if($registro[0]==2){
                    $ubicacion_id=3;
                }

                // SQL
                $sql = "INSERT INTO MATERIALES_STOCK 
                                    (material_id,
                                    stock,
                                    ubicacion_id,
                                    proyecto_id,
                                    pedido_detalle_id)
                                VALUES (".$material_id.",
                                ".$stock.", 
                                ".$ubicacion_id.",
                                ".$proyecto_id.",
                                ".$pedido_detalle_id.")";

                //file_put_contents("insertMaterialesStock.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al guardar el Stock");
                date_default_timezone_set('Europe/Madrid');
                $ahora=date('Y-m-d H:i:s');
                
                $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                        SET recibido=1, fecha_recepcion='".$ahora."'
                        WHERE id = ".$pedido_detalle_id;
                //file_put_contents("updateRecibido.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al guardar actualizar Recibido");
                
                updateStock($pedido_detalle_id,$stock,$material_id,true);
            
            
                //file_put_contents("log00.txt", $sql);
                // Check status de estado pedido
                //checkStatusPed($pedido_detalle_id);
                $sql = "SELECT PEDIDOS_PROV_DETALLES.recibido, PEDIDOS_PROV_DETALLES.id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.pedido_id=".$pedido_id;
                file_put_contents("selectRecibidos.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al seleccionar los recibidos de los detalles");

                $countDetalles=0;
                $countAcept=0;
                $estado=0;
                while ($registros = mysqli_fetch_array($result)) {
                    if($registros[0]==1){
                        file_put_contents("logErr.txt", "recibido:"+$registros[0]+" id:"+$registros[1]);
                        $countAcept++;
                    }
                    $countDetalles++;
                }
                if($countAcept==0){// Nada recepcionado
                    $estado=1; // O nada o como antes... 1 tramitado
                }elseif($countDetalles==$countAcept){ // Todos recepcionados
                    $estado=5;
                }else{ // A medias
                    $estado=8;
                }

                $sql = "UPDATE PEDIDOS_PROV 
                                SET estado_id=".$estado."
                                WHERE id = ".$pedido_id;
                file_put_contents("updateEstadoPed.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al guardar actualizar Estado del Pedido");
            }
        }

        
        echo 1;
    }
    
    function insertPartMaterialStockModal(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $tohtml = '
                    <div class="modal-dialog dialog_mini">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" style="display: inline-block;">DIVIDIR MATERIAL</h4>
                            </div>
                            <div class="modal-body">
                                <div class="contenedor-form">
                                    <form method="post" id="frm_add_posiciones" enctype="multipart/form-data">';
        
        
        // Dividir pedidos 
        // Comporbar solo una selección!!
        $detalles_id = array_map('intval', explode('-', $_POST['parteMat_modal']));
        //Si hay mas de uno error. Selecciona solo uno!
        $count=-1;
        foreach ($detalles_id as $detalle_id) {
            $count++;
        }
        if ($count==1){
            $tohtml .= '<input type="hidden" name="id_detalle_partir" id="id_detalle_partir" value="">
                        <h3>Selecciona partes a dividir: </h3>
                        <div class="col-xs-3">
                        <select id="select_div_ped_alm" name="select_div_ped_alm" class="selectpicker" data-live-search="true" data-width="33%">';
                        
                            $sql = "SELECT
                                        PEDIDOS_PROV_DETALLES.unidades
                                    FROM 
                                        PEDIDOS_PROV_DETALLES
                                    WHERE
                                        PEDIDOS_PROV_DETALLES.id=".$detalles_id[0];
                            //file_put_contents("selectPedProvDet99.txt", $sql);
                            $res = mysqli_query($connString, $sql) or die("Error Select Pedidos Prov DETALLES.");
                            
                            $row = mysqli_fetch_array($res);
                            $num = intval($row[0]);
                            //$row[0];
                            for($i=1; $i<$num; $i++){
                                $tohtml.="<option id='opcion_".$i."' value=".$i.">".$i."</option>";
                            }
                            // From 1 to row0-1

                    $tohtml .= '</select></div></form>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top: 50px;">
                            <button type="button" id="btn_divi_mat_recepionado" class="btn btn-warning">Dividir y Recepcionar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>';
        }else{
            $tohtml .= '<p>Ha habido un error. Por favor selecciona solo un detalle. Has seleccionado: '.$count.'</p></form>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top: 50px;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>';
        }
                
        echo $tohtml;    
    }
    
    function insertPartMaterialStock(){
        $db = new dbObj();
        $connString =  $db->getConnstring();       
        
        $sql="SELECT
               PEDIDOS_PROV_DETALLES.id,
               PEDIDOS_PROV_DETALLES.pedido_id,
               PEDIDOS_PROV_DETALLES.material_id,
               PEDIDOS_PROV_DETALLES.almacen,
               PEDIDOS_PROV_DETALLES.unidades,
               PEDIDOS_PROV_DETALLES.detalle_libre,
               PEDIDOS_PROV_DETALLES.recibido,
               PEDIDOS_PROV_DETALLES.fecha_recepcion,
               PEDIDOS_PROV_DETALLES.plazo,
               PEDIDOS_PROV_DETALLES.dto,
               PEDIDOS_PROV_DETALLES.fecha_entrega,
               PEDIDOS_PROV_DETALLES.proyecto_id,
               PEDIDOS_PROV_DETALLES.material_tarifa_id,
               PEDIDOS_PROV_DETALLES.ref,
               PEDIDOS_PROV_DETALLES.pvp,
               PEDIDOS_PROV_DETALLES.descripcion,
               PEDIDOS_PROV_DETALLES.dto_prov_activo,
               PEDIDOS_PROV_DETALLES.dto_mat_activo,
               PEDIDOS_PROV_DETALLES.dto_ad_activo,
               PEDIDOS_PROV_DETALLES.dto_prov_id,
               PEDIDOS_PROV_DETALLES.entrega_id,
               PEDIDOS_PROV_DETALLES.dto_prov_prior,
               PEDIDOS_PROV_DETALLES.dto_mat_prior,
               PEDIDOS_PROV_DETALLES.dto_ad_prior,
               PEDIDOS_PROV_DETALLES.erp_userid,
               PEDIDOS_PROV_DETALLES.iva_id,
               PEDIDOS_PROV_DETALLES.cliente_id
            FROM
               PEDIDOS_PROV_DETALLES
             WHERE
               PEDIDOS_PROV_DETALLES.id=".$_POST["part_mat_detalle_id"];
        file_put_contents("selectPedidoDetalle.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al realizar select de pedido Detalle. Unidades");
        $registro = mysqli_fetch_row($result);
        
        $pedido_id=$registro[1];
        $pedido_detalle_id=$registro[0];
        $unidades=$registro[4];
        $proyecto_id=$registro[11];
        
        $unidadesParte = $_POST["part_mat"];
        
        $sqlUpdate="UPDATE
                        PEDIDOS_PROV_DETALLES 
                    SET 
                        PEDIDOS_PROV_DETALLES.unidades=".$unidadesParte.",
                        PEDIDOS_PROV_DETALLES.recibido= 1,
                        PEDIDOS_PROV_DETALLES.fecha_recepcion=now()
                    WHERE 
                        PEDIDOS_PROV_DETALLES.id=".$pedido_detalle_id;
        file_put_contents("updateDetallesPedidosUnidades.txt", $sqlUpdate);
        $result = mysqli_query($connString, $sqlUpdate) or die("Error al realizar update de detalle pedido. Unidades");
        
        if($registro[19]==""){
            $dto_prov_id=0;
        }else{
            $dto_prov_id=$registro[19];
        }
        if($registro[20]==""){
            $entrega_id=0;
        }else{
            $entrega_id=$registro[20];
        }
        if($registro[24]==""){
            $user_id=0;
        }else{
            $user_id=$registro[24];
        }
        
        $sqlInsert="INSERT INTO PEDIDOS_PROV_DETALLES
                (pedido_id, 
                material_id, 
                almacen, 
                unidades, 
                detalle_libre, 
                recibido, 
                fecha_recepcion, 
                plazo, 
                dto, 
                fecha_entrega, 
                proyecto_id, 
                material_tarifa_id, 
                ref, 
                pvp, 
                descripcion, 
                dto_prov_activo, 
                dto_mat_activo, 
                dto_ad_activo, 
                dto_prov_id, 
                entrega_id, 
                dto_prov_prior, 
                dto_mat_prior, 
                dto_ad_prior, 
                erp_userid, 
                iva_id, 
                cliente_id) 
                VALUES 
                (".$registro[1].",
                ".$registro[2].",
                '".$registro[3]."',
                ".($unidades-$unidadesParte).",
                '".$registro[5]."',
                ".$registro[6].",
                '".$registro[7]."',
                '".$registro[8]."',
                '".$registro[9]."',
                '".$registro[10]."',
                ".$registro[11].",
                ".$registro[12].",
                '".$registro[13]."',
                '".$registro[14]."',
                '".$registro[15]."',
                ".$registro[16].",
                ".$registro[17].",
                ".$registro[18].",
                ".$dto_prov_id.",
                ".$entrega_id.",
                ".$registro[21].",
                ".$registro[22].",
                ".$registro[23].",
                ".$user_id.",
                ".$registro[25].",
                ".$registro[26]."                
                )";
        file_put_contents("insertDetallesPedidosUnidades.txt", $sqlInsert);
        $result = mysqli_query($connString, $sqlInsert) or die("Error al realizar insert de detalle pedido. Unidades");
        
        $sql = "UPDATE PEDIDOS_PROV SET estado_id = 8, fecha_recepcion = now() WHERE id = ".$registro[1];
        $result = mysqli_query($connString, $sql) or die("Error al actualizar el Pedido");
        
        insertMaterialesStock($registro[2],$unidadesParte,0,$proyecto_id,$pedido_detalle_id,$db,$connString);
        
        echo 1;
    }
    
    function updateStockUbicacion($ubicacion_id, $detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                SET ubicacion_id = ".$ubicacion_id."
                WHERE id = ".$detalle_id;
                
        //file_put_contents("updateMaterialUbicacion.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar la ubicacion del Material");
        //updateStock($detalle_id, $cantidad, "",$check_pedido);
        //mysqli_set_charset($connString, "utf8");
    }
    
    function delMaterialStock($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE from MATERIALES_STOCK WHERE pedido_detalle_id=".$detalle_id;
        //file_put_contents("delDetalle.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Stock");
    }
    
    function checkStatusPed($pedido_detalle_id){
        //$db = new dbObj();
        //$connString =  $db->getConnstring();
        
        $sql = "SELECT PEDIDOS_PROV_DETALLES.pedido_id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id=".$pedido_detalle_id;
        $resultado = mysqli_query($connString, $sql) or die("Error al seleccionar el pedido id");
        $regis = mysqli_fetch_array($resultado);
        $pedido_id = $regis[0];
        
        $sql = "SELECT PEDIDOS_PROV_DETALLES.recibido, PEDIDOS_PROV_DETALLES.id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.pedido_id=".$pedido_id;
        file_put_contents("selectRecibidos.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar los recibidos de los detalles");
        
        $countDetalles=0;
        $countAcept=0;
        $estado=0;
        while ($registros = mysqli_fetch_array($result)) {
            if($registros[0]==1){
                file_put_contents("logErr.txt", "recibido:"+$registros[0]+" id:"+$registros[1]);
                $countAcept++;
            }
            $countDetalles++;
        }
        if($countAcept==0){// Nada recepcionado
            $estado=1; // O nada o como antes... 1 tramitado
        }elseif($countDetalles==$countAcept){ // Todos recepcionados
            $estado=5;
        }else{ // A medias
            $estado=8;
        }
        
        $sql = "UPDATE PEDIDOS_PROV 
                        SET estado_id=".$estado."
                        WHERE id = ".$pedido_id;
        file_put_contents("updateEstadoPed.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar actualizar Estado del Pedido");
    }
?>
	