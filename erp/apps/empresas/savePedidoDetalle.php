<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['pedidodetalle_deldetalle'] != "") {
        delDetallePedido($_POST['pedidodetalle_deldetalle']);
    }    
    else {
        if (($_POST['pedidodetalle_detalle_id'] != "") || ($_POST['pedidodetalle_recmat'] != "")) {
            updateDetallePedido();
        }
        else {
            insertDetallePedido();
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
            $provdtoidfiled = "";
            $provdto_id = "";
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
        
        if ($_POST['edit_chkrecibido'] == true) {
            if ($_POST['pedidodetalle_precios'] != "") {
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
                        dto_ad_activo 
                        ".$tecnicoidfiled."
                        ".$entregaidfiled."
                        ".$provdtoidfiled."
                        )
                    VALUES (".$_POST['pedidodetalle_material_id'].",
                    ".$_POST['pedidodetalle_precios'].", 
                    ".$_POST['pedidodetalle_pedido_id'].",
                    '".$_POST['pedidodetalle_ref']."',
                    ".$_POST['pedidodetalle_cantidad'].",
                    ".$_POST['pedidodetalle_dto'].",
                    '".$_POST['pedidodetalle_fecha_recepcion']."',
                    '".$_POST['pedidodetalle_fecha_entrega']."',
                    1,
                    ".$dtoprov_activo.", 
                    ".$dtomat_activo.",
                    ".$dtoad_activo." 
                    ".$tecnico_id."
                    ".$proyectoid." 
                    ".$entregaid." 
                    ".$provdto_id.")";
            }
            else {
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
                        dto_ad_activo 
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
                    '".$_POST['pedidodetalle_fecha_recepcion']."',
                    '".$_POST['pedidodetalle_fecha_entrega']."',
                    1,
                    ".$dtoprov_activo.", 
                    ".$dtomat_activo.",
                    ".$dtoad_activo." 
                    ".$tecnico_id." 
                    ".$proyectoid." 
                    ".$entregaid." 
                    ".$provdto_id.")";
            }
            
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
            updateStock("", $_POST['pedidodetalle_cantidad'], $_POST['pedidodetalle_material_id']);
            //file_put_contents("insertpedidodetalle.txt", $sql);
            //mysqli_set_charset($connString, "utf8");
        }
        else {
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
                        dto_ad_activo 
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
                    '".$_POST['pedidodetalle_fecha_recepcion']."',
                    '".$_POST['pedidodetalle_fecha_entrega']."',
                    0,
                    ".$dtoprov_activo.", 
                    ".$dtomat_activo.",
                    ".$dtoad_activo." 
                    ".$tecnico_id."
                    ".$proyectoid." 
                    ".$entregaid." 
                    ".$provdto_id.")";
            //file_put_contents("insertpedidodetalleee.txt", $sql);
            echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        }       
    }
    
    function updateDetallePedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['pedidodetalle_recmat'] != "") {
            $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                    SET recibido = 1,
                        fecha_recepcion = now()
                    WHERE id = ".$_POST['pedidodetalle_recmat'];
            $detalle_id = $_POST['pedidodetalle_recmat'];
            $cantidad = $_POST['cantidad'];
            
            $sqlNotificacion = "SELECT user_email FROM erp_users WHERE erp_users.id = (SELECT erp_userid FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$_POST['pedidodetalle_recmat'].")";
            $result = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar user_email");
            $registro = mysqli_fetch_row($result);
            $para = $registro[0];
            $sqlNotificacion = "SELECT ref, nombre FROM MATERIALES WHERE id = (SELECT material_id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$_POST['pedidodetalle_recmat'].")";
            $result = mysqli_query($connString, $sqlNotificacion) or die("Error al buscar material_id");
            $registro = mysqli_fetch_row($result);
            
            $salto = "<br>";
            $mensaje = "Artículo: ".$registro[1].$salto."Referencia: ".$registro[0].$salto."Recibido el: ".date("Y-m-d H:i:s").$salto.$salto."En las instalaciones de Genelek Sistemas.";
            sendMail($para, "Artículo recibido", $mensaje, $de);
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

            if ($_POST['edit_chkrecibido'] == true) {
                $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                    SET material_id = ".$_POST['pedidodetalle_material_id'].", 
                        material_tarifa_id = ".$_POST['pedidodetalle_precios'].", 
                        pedido_id = ".$_POST['pedidodetalle_pedido_id'].",
                        ref = '".$_POST['pedidodetalle_ref']."',
                        unidades = ".$_POST['pedidodetalle_cantidad'].",  
                        dto = ".$_POST['pedidodetalle_dto'].", 
                        fecha_recepcion = '".date("Y-m-d H:i:s",strtotime($_POST['pedidodetalle_fecha_recepcion']))."', 
                        fecha_entrega = '".$_POST['pedidodetalle_fecha_entrega']."', 
                        recibido = 1,
                        dto_prov_activo = ".$dtoprov_activo.",
                        dto_mat_activo = ".$dtomat_activo.",
                        dto_ad_activo = ".$dtoad_activo."  
                        ".$tecnico_id."
                        ".$proyectoid."
                        ".$entregaid."
                        ".$provdto_id."
                    WHERE id = ".$_POST['pedidodetalle_detalle_id'];
                $detalle_id = $_POST['pedidodetalle_detalle_id'];
                $cantidad = $_POST['pedidodetalle_cantidad'];
            } 
            else {
                $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                    SET material_id = ".$_POST['pedidodetalle_material_id'].", 
                        material_tarifa_id = ".$_POST['pedidodetalle_precios'].", 
                        pedido_id = ".$_POST['pedidodetalle_pedido_id'].", 
                        ref = '".$_POST['pedidodetalle_ref']."',
                        unidades = ".$_POST['pedidodetalle_cantidad'].",  
                        dto = ".$_POST['pedidodetalle_dto'].", 
                        fecha_recepcion = '".date("Y-m-d H:i:s",strtotime($_POST['pedidodetalle_fecha_recepcion']))."', 
                        fecha_entrega = '".$_POST['pedidodetalle_fecha_entrega']."', 
                        recibido = 0,
                        dto_prov_activo = ".$dtoprov_activo.",
                        dto_mat_activo = ".$dtomat_activo.",
                        dto_ad_activo = ".$dtoad_activo." 
                        ".$tecnico_id."
                        ".$proyectoid."
                        ".$entregaid."
                        ".$provdto_id."
                    WHERE id = ".$_POST['pedidodetalle_detalle_id'];
                $detalle_id = $_POST['pedidodetalle_detalle_id'];
                $cantidad = $_POST['pedidodetalle_cantidad'];
            }
        }
        
        //file_put_contents("updateDet.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        updateStock($detalle_id, $cantidad, "");
        //mysqli_set_charset($connString, "utf8");
        
    }

    function updateStock($detalle, $incremento, $material_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($detalle != "") {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + ".$incremento." WHERE id = (SELECT material_id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$detalle.")";
        }
        else {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + ".$incremento." WHERE id = ".$material_id;
        }
        //file_put_contents("updateStock.txt", $sqlStock);
        echo $result = mysqli_query($connString, $sqlStock) or die("Error al actualizar el Stock");
    }
    
    function delDetallePedido($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from PEDIDOS_PROV_DETALLES WHERE id=".$detalle_id;
        //file_put_contents("delDetalle.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
    }
?>
	