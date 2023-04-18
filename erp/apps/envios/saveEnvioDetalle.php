<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['enviodetalle_deldetalle'] != "") {
        delDetalleEnvio($_POST['enviodetalle_deldetalle']);
    }    
    else {
        if (($_POST['enviodetalle_detalle_id'] != "") || ($_POST['enviodetalle_entmat'] != "")) {
            updateDetalleEnvio();
        }
        else {
            insertDetalleEnvio();
        }
    }
    
    function insertDetalleEnvio() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        if ($_POST['enviodetalle_proyectos'] != "") {
            $proyectoidfiled = ", proyecto_id";
            $proyectoid = ", ".$_POST['enviodetalle_proyectos'];
        }
        else {
            $proyectoidfiled = "";
            $proyectoid = "";
        }
        if ($_POST['enviodetalle_entregas'] != "") {
            $entregaidfiled = ", entrega_id";
            $entregaid = ", ".$_POST['enviodetalle_entregas'];
        }
        else {
            $entregaidfiled = "";
            $entregaid = "";
        }
        if ($_POST['edit_chkrecibido'] == false) {
            $entregado = "0";
        }else{
            $entregado = "1";
        }
        if ($_POST['edit_chkgarantia'] == false) {
            $garantia = "0";
        }else{
            $garantia = "1";
        }
        //
//        $sqlPedDet = "SELECT PEDIDOS_PROV_DETALLES.id, PEDIDOS_PROV_DETALLES.pedido_id, PEDIDOS_PROV_DETALLES.material_id, PEDIDOS_PROV_DETALLES.almacen, PEDIDOS_PROV_DETALLES.unidades, PEDIDOS_PROV_DETALLES.detalle_libre, PEDIDOS_PROV_DETALLES.recibido, PEDIDOS_PROV_DETALLES.fecha_recepcion, PEDIDOS_PROV_DETALLES.plazo, PEDIDOS_PROV_DETALLES.dto, PEDIDOS_PROV_DETALLES.fecha_entrega, PEDIDOS_PROV_DETALLES.proyecto_id, PEDIDOS_PROV_DETALLES.material_tarifa_id, PEDIDOS_PROV_DETALLES.ref, PEDIDOS_PROV_DETALLES.pvp, PEDIDOS_PROV_DETALLES.descripcion, PEDIDOS_PROV_DETALLES.dto_prov_activo, PEDIDOS_PROV_DETALLES.dto_mat_activo, PEDIDOS_PROV_DETALLES.dto_ad_activo, PEDIDOS_PROV_DETALLES.dto_prov_id, PEDIDOS_PROV_DETALLES.entrega_id, PEDIDOS_PROV_DETALLES.dto_prov_prior, PEDIDOS_PROV_DETALLES.dto_mat_prior, PEDIDOS_PROV_DETALLES.dto_ad_prior, PEDIDOS_PROV_DETALLES.erp_userid, PEDIDOS_PROV_DETALLES.iva_id, PEDIDOS_PROV_DETALLES.cliente_id 
//                FROM PEDIDOS_PROV_DETALLES 
//                WHERE PEDIDOS_PROV_DETALLES.id=".$_POST['pedido_detalle_id'];
//        $sqlInsertPedDet = "INSERT INTO PEDIDOS_PROV_DETALLES(id, pedido_id, material_id, almacen, unidades, detalle_libre, recibido, fecha_recepcion, plazo, dto, fecha_entrega, proyecto_id, material_tarifa_id, ref, pvp, descripcion, dto_prov_activo, dto_mat_activo, dto_ad_activo, dto_prov_id, entrega_id, dto_prov_prior, dto_mat_prior, dto_ad_prior, erp_userid, iva_id, cliente_id) ".$sqlPedDet;
//                
        $sql = "INSERT INTO ENVIOS_CLI_DETALLES 
                (material_id,
                envio_id,
                unidades,
                fecha_recepcion,
                pedido_detalle_id,
                garantia,
                entregado 
                ".$entregaidfiled."
                ".$proyectoidfiled."
                )
                VALUES (".$_POST['enviodetalle_material_id'].",
                ".$_POST['enviodetalle_envio_id'].",
                ".$_POST['enviodetalle_stock'].", 
                '".$_POST['enviodetalle_fecha_recepcion']."',
                ".$_POST['pedido_detalle_id'].", 
                ".$garantia.",
                ".$entregado."
                ".$entregaid." 
                ".$proyectoid.")";
        file_put_contents("insertenviodetalle.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        $ultimoid=mysqli_insert_id($connString);
        
        $sqlSelEnvio="SELECT ENVIOS_CLI.tipo_envio_id, ENVIOS_CLI.proyecto_id FROM ENVIOS_CLI WHERE ENVIOS_CLI.id=".$_POST['enviodetalle_envio_id'];
        file_put_contents("electEnvioTipo.txt", $sqlSelEnvio);
        $result = mysqli_query($connString, $sqlSelEnvio) or die("Error al guardar el Detalle");
        $row = mysqli_fetch_row ($result);
        
        if($row[0]==1){
            // Envio
            $recibido=3;
        }elseif($row[0]==2){
            // Devolucion
            $recibido=2;
        }
        
        $sql = "UPDATE PEDIDOS_PROV_DETALLES 
                    SET recibido = ".$recibido."
                    WHERE id = ".$_POST['pedido_detalle_id'];
        file_put_contents("updatePedProvDetalle.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar el update de recibido a 2 o 3 (envio o devolucion)");        
        
        /* AÑADIR A PROYECTOS_MATERIALES  */
        // Solo si es un ENVIO!
        // Solo si estan asignados a un proyecto... (Control materiales añadidos de almacen a proyecto)
        $sql = "SELECT PEDIDOS_PROV_DETALLES.proyecto_id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id=".$_POST['pedido_detalle_id'];
        file_put_contents("selectProyectoDetalles.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar el update de recibido a 2 o 3 (envio o devolucion)");     
        $rowPro = mysqli_fetch_row ($resultado);
        
        if($row[0]==1){
            if($rowPro[0]==11){
                $proyectoid=$rowPro[0];
            }else{
                $proyectoid=$row[1];
            }
            
            $sql = "SELECT 
                        PEDIDOS_PROV_DETALLES.id,
                        PEDIDOS_PROV_DETALLES.ref,  
                        MATERIALES.nombre,
                        MATERIALES.fabricante,
                        PEDIDOS_PROV_DETALLES.unidades,
                        MATERIALES_PRECIOS.pvp, 
                        PEDIDOS_PROV_DETALLES.recibido,
                        PEDIDOS_PROV_DETALLES.fecha_recepcion,
                        PROYECTOS.nombre,
                        PEDIDOS_PROV_DETALLES.pvp,
                        MATERIALES_PRECIOS.dto_material, 
                        PEDIDOS_PROV_DETALLES.dto_prov_activo, 
                        PEDIDOS_PROV_DETALLES.dto_mat_activo, 
                        PEDIDOS_PROV_DETALLES.dto_ad_activo, 
                        PROVEEDORES_DTO.id, 
                        PEDIDOS_PROV_DETALLES.dto, 
                        ENTREGAS.nombre, 
                        PEDIDOS_PROV_DETALLES.material_id,
                        PEDIDOS_PROV_DETALLES.material_tarifa_id,
                        PROYECTOS.id
                    FROM 
                        PEDIDOS_PROV_DETALLES
                    INNER JOIN PEDIDOS_PROV 
                        ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                    INNER JOIN MATERIALES
                        ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
                    LEFT JOIN MATERIALES_PRECIOS 
                        ON MATERIALES_PRECIOS.id = PEDIDOS_PROV_DETALLES.material_tarifa_id 
                    LEFT JOIN PROYECTOS 
                        ON PROYECTOS.id = PEDIDOS_PROV_DETALLES.proyecto_id 
                    LEFT JOIN PROVEEDORES_DTO 
                        ON PROVEEDORES_DTO.id = PEDIDOS_PROV_DETALLES.dto_prov_id
                    LEFT JOIN ENTREGAS
                        ON PEDIDOS_PROV_DETALLES.entrega_id = ENTREGAS.id
                    WHERE
                        PEDIDOS_PROV_DETALLES.id = ".$_POST['pedido_detalle_id']."
                    AND
                        PEDIDOS_PROV_DETALLES.proyecto_id = ".$proyectoid."
                    ORDER BY 
                        PEDIDOS_PROV.id ASC ";
            file_put_contents("selectBig01.txt",$sql);
            $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del detalle de Pedidos");
            $registros = mysqli_fetch_array($resultado);
            $proyectoid=$row[1]; // Corregir proyecto si viene de almacen!
                if ($registros[14] != "") {
                    $sqlIn = "INSERT INTO PROYECTOS_MATERIALES 
                                 (material_id,
                                 unidades,
                                 material_tarifa_id,
                                 dto_prov_id,
                                 dto_prov_activo,
                                 dto_mat_activo,
                                 dto_ad_activo,
                                 proyecto_id,
                                 pedido_detalle_id
                                 )
                                 VALUES (
                                 ".$registros[17].",
                                 ".$registros[4].",
                                 ".$registros[18].",
                                 ".$registros[14].",
                                 ".$registros[11].",
                                 ".$registros[12].",
                                 ".$registros[13].",
                                 ".$proyectoid.",
                                 ".$registros[0]."
                                 )";
                }
                else {
                    $sqlIn = "INSERT INTO PROYECTOS_MATERIALES 
                             (material_id,
                             unidades,
                             material_tarifa_id,
                             dto_prov_activo,
                             dto_mat_activo,
                             dto_ad_activo,
                             proyecto_id,
                             pedido_detalle_id
                             )
                             VALUES (
                             ".$registros[17].",
                             ".$registros[4].",
                             ".$registros[18].",
                             ".$registros[11].",
                             ".$registros[12].",
                             ".$registros[13].",
                             ".$proyectoid.",
                             ".$registros[0]."
                             )";
                }
                file_put_contents("insertMatProyectos.txt",$sqlIn);
                $resultadoIn = mysqli_query($connString, $sqlIn) or die("Error al guardar Material PROYECTOS_MATERIALES");
        }
        // Cambiar MATERIALES_STOCK de ubicaion a 5 o 6 dependiendo de tipo de envio!
        updateStockTrack($ultimoid);
        updateStock("", -$_POST['enviodetalle_stock'], $_POST['enviodetalle_material_id']);
        
        echo 1;
    }
    
    function updateDetalleEnvio() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['enviodetalle_entmat'] != "") {
            $sql = "UPDATE ENVIOS_CLI_DETALLES 
                    SET entregado = 1,
                        fecha_recepcion = now()
                    WHERE id = ".$_POST['enviodetalle_entmat'];
            $detalle_id = $_POST['enviodetalle_entmat'];
            $cantidad = $_POST['cantidad'];
            $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del Envío");
            
            $sql = "SELECT pedido_detalle_id FROM ENVIOS_CLI_DETALLES WHERE id = ".$detalle_id;
            $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del Envío");
            $row = mysqli_fetch_row ($resultado);
            
            // Borrar del Materiales Stock al RECEPCIONAR (Para realizar buen contaje)
            // $sqlDel = "delete from MATERIALES_STOCK WHERE pedido_detalle_id=".$row[0];
            // file_put_contents("delPedDetalle1.txt", $sqlDel);
            // $result = mysqli_query($connString, $sqlDel) or die("Error al eliminar el Ped Detalle1");
            // FALLO AL VISUALIZAR?¿¿? MATERIAL AÑADIDO DESDE EL ALMACEN. Cambiado a UPDATE: 
            $sqlUpd = "UPDATE MATERIALES_STOCK SET ubicacion_id=2 WHERE pedido_detalle_id=".$row[0];
            file_put_contents("delPedDetalle1.txt", $sqlUpd);
            $result = mysqli_query($connString, $sqlUpd) or die("Error al actualizar el Ped Detalle1");
        }
        else {
            if ($_POST['enviodetalle_proyectos'] != "") {
                $proyectoid = ", proyecto_id = ".$_POST['enviodetalle_proyectos'];
            }
            else {
                $proyectoid = "";
            }
            if ($_POST['enviodetalle_entregas'] != "") {
                $entregaid = ", entrega_id = ".$_POST['enviodetalle_entregas'];
            }
            else {
                $entregaid = "";
            }
            if ($_POST['enviodetalle_dtoprov'] != "") {
                $provdto_id = ", dto_prov_id = ".$_POST['enviodetalle_dtoprov'];
            }
            else {
                $provdto_id = "";
            }
            if ($_POST['enviodetalle_tecnicos'] != "") {
                $tecnico_id = ", erp_userid = ".$_POST['enviodetalle_tecnicos'];
            }
            else {
                $tecnico_id = "";
            }
            if ($_POST['enviodetalle_fecha_recepcion'] == "") {
                $fecha_recepcion = "null";
            }
            else {
                $fecha_recepcion = date("Y-m-d H:i:s",strtotime($_POST['enviodetalle_fecha_recepcion']));
            }
            if ($_POST['edit_chkgarantia'] == false) {
                $garantia = ", garantia=0";
            }
            else {
                $garantia = ", garantia=1";
            }

            if ($_POST['edit_chkrecibido'] == true) {
                $sql = "UPDATE ENVIOS_CLI_DETALLES 
                        SET material_id = ".$_POST['enviodetalle_material_id'].", 
                            envio_id = ".$_POST['enviodetalle_envio_id'].",
                            unidades = ".$_POST['enviodetalle_stock'].",  
                            descripcion = '".$_POST['enviodetalle_descnota']."',  
                            fecha_recepcion = '".$fecha_recepcion."', 
                            entregado = 1 
                            ".$tecnico_id."
                            ".$proyectoid."
                            ".$entregaid."
                            ".$garantia."
                        WHERE id = ".$_POST['enviodetalle_detalle_id'];
                $detalle_id = $_POST['enviodetalle_detalle_id'];
                $cantidad = $_POST['enviodetalle_cantidad'];
                $result = mysqli_query($connString, $sql) or die("Error al actualizar ENVIO CLI DETALLE 1");
                
                // Borrar del Materiales Stock al RECEPCIONAR (Para realizar bune contaje)
                $sqlDel = "delete from MATERIALES_STOCK WHERE id=".$_POST['pedido_detalle_id'];
                file_put_contents("delPedDetalle.txt", $sqlDel);
                $result = mysqli_query($connString, $sqlDel) or die("Error al eliminar el Ped Detalle2");
            } 
            else {
                $sql = "UPDATE ENVIOS_CLI_DETALLES 
                        SET material_id = ".$_POST['enviodetalle_material_id'].", 
                                envio_id = ".$_POST['enviodetalle_envio_id'].",
                                unidades = ".$_POST['enviodetalle_stock'].",
                                descripcion = '".$_POST['enviodetalle_descnota']."',  
                                fecha_recepcion = '".$fecha_recepcion."', 
                                entregado = 0 
                                ".$tecnico_id."
                                ".$proyectoid."
                                ".$entregaid."
                                ".$garantia."
                            WHERE id = ".$_POST['enviodetalle_detalle_id'];
                file_put_contents("updateEnviosCliDetalles.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al actualizar ENVIO CLI DETALLE 2");
                $detalle_id = $_POST['enviodetalle_detalle_id'];
                $cantidad = $_POST['enviodetalle_cantidad'];
                
                $sql = "SELECT pedido_detalle_id, unidades FROM ENVIOS_CLI_DETALLES WHERE id = ".$detalle_id;
                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del Envío");
                $rowDat = mysqli_fetch_row ($resultado);
                
                $sql = "SELECT PROYECTOS_MATERIALES.proyecto_id FROM PROYECTOS_MATERIALES WHERE PROYECTOS_MATERIALES.pedido_detalle_id = ".$rowDat[0];
                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de PROYECTOS_MATERIALES");
                $row = mysqli_fetch_row ($resultado);
                if($row[0]!=""){
                    //EXISTE
                    $ubicacion=0;
                }else{
                    $sql = "SELECT PEDIDOS_PROV_DETALLES.proyecto_id FROM PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id = ".$rowDat[0];
                    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del Envío");
                    $rowPedDet = mysqli_fetch_row ($resultado);
                    if($rowPedDet[0]==11 || $rowPedDet[0]==10){
                        $ubicacion=1;
                    }else{
                        $ubicacion=2;
                    }
                }
                // Check si este material ya estaba asignado al proyecto y asignarlo si es asi.
                
                
                // Insertar MAT_STOCK (Borrado al insertar)
                $sql = "INSERT INTO MATERIALES_STOCK 
                        (material_id,
                        stock,
                        ubicacion_id,
                        proyecto_id,
                        pedido_detalle_id)
                        VALUES (".$_POST['enviodetalle_material_id'].",
                        ".$rowDat[1].",
                        ".$ubicacion.", 
                        ".$rowPedDet[0].",
                        ".$rowDat[0].")";
                file_put_contents("reInsertMatStock1.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al reinsertar MAT_STOCK 1");
                
            }
        }
        
        //file_put_contents("updateDet.txt", $sql);
        //$result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
        updateStock($detalle_id, -$cantidad, ""); 
        //mysqli_set_charset($connString, "utf8");
        
        // Check if all detalles recibidos
        updateEnvioEstado($_POST['enviodetalle_entmat']);
        
        // Pendiente actualizar stock de trazabilidad
        // updateStockTrack($_POST['enviodetalle_detalle_id']);
        
    }

    function updateStock($detalle, $incremento, $material_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($detalle != "") {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + ".$incremento." WHERE id = (SELECT material_id FROM ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI_DETALLES.id = ".$detalle.")";
        }
        else {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + ".$incremento." WHERE id = ".$material_id;
        }
        file_put_contents("updateStock.txt", $sqlStock);
        echo $result = mysqli_query($connString, $sqlStock) or die("Error al actualizar el Stock");
    }
    
    function updateStockTrack($enviodetalle_detalle_id){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sqlSelect="SELECT
                        ENVIOS_CLI_DETALLES.pedido_detalle_id, 
                        ENVIOS_CLI_DETALLES.envio_id, 
                        ENVIOS_CLI.tipo_envio_id,
                        ENVIOS_CLI_DETALLES.entregado
                    FROM 
                        ENVIOS_CLI_DETALLES 
                    INNER JOIN ENVIOS_CLI ON 
                        ENVIOS_CLI_DETALLES.ENVIO_ID=ENVIOS_CLI.id 
                    WHERE 
                        ENVIOS_CLI_DETALLES.id=".$enviodetalle_detalle_id;
        file_put_contents("selectPedidoDetalle.txt", $sqlSelect);
        $result = mysqli_query($connString, $sqlSelect) or die("Error al seleccionar Envios detalles");
        $row = mysqli_fetch_row ($result);
        
        $sql = "SELECT * FROM PROYECTOS_MATERIALES WHERE pedido_detalle_id = ".$row[0];
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de PROYECTOS_MATERIALES");
        $row = mysqli_fetch_row ($resultado);
        if($row[0]!=""){
            //EXISTE
            $ubicacion=0;
        }else{
            if($_POST['enviodetalle_proyectos']==11 || $_POST['enviodetalle_proyectos']==10){
                $ubicacion=1;
            }else{
                $ubicacion=2;
            }
        }
        
        $sqlUpdate = "UPDATE MATERIALES_STOCK SET MATERIALES_STOCK.ubicacion_id = ".$ubicacion." WHERE MATERIALES_STOCK.pedido_detalle_id = ".$row[0];
        file_put_contents("selectUpdateUbicacion.txt", $sqlUpdate);
        $result = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar la ubicacion de Envio o devolucion");
    }
    
    function delDetalleEnvio($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "SELECT unidades, material_id, proyecto_id, pedido_detalle_id FROM ENVIOS_CLI_DETALLES WHERE id = ".$detalle_id;
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del Envío");
        $registros = mysqli_fetch_row($resultado);
        $cantidad = $registros[0];
        $mat_id = $registros[1];
        $proyecto_id = $registros[2];
        $ped_det_id = $registros[3];
        
        $sql = "delete from ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI_DETALLES.id=".$detalle_id;
        file_put_contents("delDetalle.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
        updateStock("", $cantidad, $mat_id);
        
        $sql = "UPDATE PEDIDOS_PROV_DETALLES
                        SET recibido = 1
                WHERE id = ".$ped_det_id;
        file_put_contents("updatePedidosProvDetalles.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al actualizar ENVIO CLI DETALLE 2");
        
        // Se debe hacer solo si es envio.... Pero teoricamente no hay material en esa tabla que no sea envio.....
        // PARA QUE BORRAR? MATERIALGES COGIDOS DE ALMACEN ENVIO?!?!?
//        $sql = "delete from PROYECTOS_MATERIALES WHERE PROYECTOS_MATERIALES.pedido_detalle_id=".$ped_det_id;
//        file_put_contents("delProyectosMateriales.txt", $sql);
//        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Detalle");
        
        echo 1;
    }
    
    function updateEnvioEstado($envio_cli_id){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $pedir = "SELECT envio_id FROM ENVIOS_CLI_DETALLES WHERE id ='".$envio_cli_id."' LIMIT 1"; 

        $sql = "SELECT 
                    ENVIOS_CLI_DETALLES.entregado
                FROM
                    ENVIOS_CLI_DETALLES 
                WHERE
                    ENVIOS_CLI_DETALLES.envio_id = (".$pedir.")
                ORDER BY    
                    ENVIOS_CLI_DETALLES.entregado asc limit 1";
        file_put_contents("selectEnvCliDet1.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al SELECCIONAR ENVIO");
        $row = mysqli_fetch_row ($result);
        
        if($row[0]==1){
            $sql = "UPDATE ENVIOS_CLI SET estado_id = '5', fecha_recepcion = now() WHERE ENVIOS_CLI.id = (".$pedir.")";
            //$sql = "UPDATE ENVIOS_CLI SET estado_id= '5' WHERE id=".$envio_cli_id;
            file_put_contents("updateEnviosCliEstado.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al actualizar estado");
        }
    }
?>
	