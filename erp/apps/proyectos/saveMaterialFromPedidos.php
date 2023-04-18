
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    //file_put_contents("debug0.txt", $_POST['proyecto_id']);
    
    if ($_POST['mat_deldetalle'] != "") {
        delMat();
    }
    else {
        if (($_POST['proyecto_id'] != "") || ($_POST['posiciones_proyecto_id'] != "")) {
            if ($_POST['pedidos_id'] != "") {
                insertMatFromPedidosIDs();
            }
            else {
                if ($_POST['posiciones_proyecto_id'] != "") {
                    insertMatFromPosiciones();
                }
                else {
                    insertMatFromPedidos();
                }
            }
        }else{
            if($_POST['nombre_grupo'] != ""){
                insertMaterialesGrupos();
            }else{
                if($_POST['pedidos_id2'] != ""){
                    insertMatFromPosiciones();
                }
            }
        }
    }    
       
    function insertMatFromPosiciones_OLD() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        //file_put_contents("insertPosiciones.txt", $_POST['posiciones_proyecto_id']);
        
        $proyecto_id = $_POST['posiciones_proyecto_id'];
        $contador = 0;
        $posiciones = $_POST['posiciones'];
        
        
        foreach ($posiciones as $posicion) {
            if ($posicion['pos-to-project'] != "") {
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
                                 ".$posicion['pos-to-project'].",
                                 ".$posicion['pos_unidades'].",
                                 ".$posicion['pos_tarifa_id'].",
                                 ".$posicion['pos_dto_prov_id'].",
                                 ".$posicion['pos_dto_prov_activo'].",
                                 ".$posicion['pos_dto_mat_activo'].",
                                 ".$posicion['pos_dto_ad_activo'].",
                                 ".$proyecto_id.",
                                 ".$posicion['pos_prov_detalle_id']."
                                 )";
                //file_put_contents("insertPosiciones".$contador.".txt", $sqlIn);
                if($posicion['pos_mat_stock_id'] != ""){
                    updateStock($posicion['pos-to-project'], (0 - $posicion['pos_unidades']));
                    updateStockUbicacionAlmacen(0,$posicion['pos_mat_stock_id']);
                }else{
                    updateStock($posicion['pos-to-project'], (0 - $posicion['pos_unidades']));
                    updateStockUbicacion(0,$posicion['pos_prov_detalle_id']);
                }
                
                $resultadoIn = mysqli_query($connString, $sqlIn) or die("Error al guardar Material");
            }
            //file_put_contents("insertPosiciones".$contador.".txt", $posicion['pos-to-project']."-".$posicion['pos_unidades']);
            $contador = $contador + 1;
        }
        //file_put_contents("contador12.txt", $contador);
        echo 1;
    }

    function insertMatFromPosiciones() {
        // Insertar desde Posiciones (Agregar/ Realizar envío)
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        //file_put_contents("kkk.txt", $_POST['pedidos_id2']);
        
        $pedidos_id = array_map('intval', explode('-', $_POST['pedidos_id2']));
        $log="";
        foreach ($pedidos_id as $pedido) {
            if($pedido!=0){
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
                        PEDIDOS_PROV_DETALLES.id = ".$pedido."
                    ORDER BY 
                        PEDIDOS_PROV.id ASC ";
            /*SE HA QUITADO ESTO DE LA SELECT:
             *                     AND
                        PEDIDOS_PROV_DETALLES.proyecto_id = ".$_POST['posiciones_proyecto_id']."
             */
            $log.=$pedido;
            //file_put_contents("selectBig0.txt",$sql);
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del detalle de Pedidos");
            while ($registros = mysqli_fetch_array($resultado)) {
                // Ahora por cada detalle encontrado, independientemente del pedido que provenga, añado ese material con el precio seleccionado, unidades, etc... a la tabla PROYECTOS_MATERIALES
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
                                 ".$_POST['posiciones_proyecto_id'].",
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
                             ".$_POST['posiciones_proyecto_id'].",
                             ".$registros[0]."
                             )";
                }
                //file_put_contents("insertMatFromPosiciones.txt",$sqlIn);
                updateStock($registros[17], (0 - $registros[4]));
                $resultadoIn = mysqli_query($connString, $sqlIn) or die("Error al guardar Material");
                if($registros[19]!=10 || $registros[19]!=11){
                    updateStockUbicacion(0,$registros[0]);
                }
            } //fin del while de los detalles de cada pedido
            } //fin del if
        } //fin del foreach pedidos_id
        //file_put_contents("log.txt",$log);
        
        
        // Queda pendiente realizar un envío con esto!!
        $nombreenvio=$_POST["nombre_envio"];
        $trabajadorid=$_POST["envio_idtrabajador"];
        $proyectoid=$_POST["envio_proyecto_id"];
        
        // Generar REF AUTOMÁTICAMENTE!!
        $sqlRef="SELECT SUBSTRING( ENVIOS_CLI.ref, 6, 4 ) AS anyo
                    FROM ENVIOS_CLI
                    WHERE SUBSTRING( ENVIOS_CLI.ref, 4, 2 ) =".substr(Date("Y"),2,4)." ORDER BY anyo DESC LIMIT 1";
        //file_put_contents("selectLastRef.txt", $sqlRef);
        $resultado = mysqli_query($connString, $sqlRef) or die("Error al seleccionar ultimo valor de ref del año.");
        $registros = mysqli_fetch_array($resultado);
        $ref = "ALB".substr(Date("Y"),2,4).str_pad(($registros[0]+1), 4, '0', STR_PAD_LEFT);  // Añadir ALB+AÑO+XXXX
                
        //creamos envio
        $sqlCrearEnvio='INSERT INTO ENVIOS_CLI
                    (
                    transportista_id, 
                    nombre, 
                    descripcion, 
                    tecnico_id, 
                    fecha, 
                    ref, 
                    estado_id, 
                    proyecto_id, 
                    path,
                    gastos_envio,
                    portes,
                    tipo_envio_id) 
                    VALUES 
                    (
                    1,"'.$nombreenvio.'","",'.$trabajadorid.',"'.date("Y-m-d").'","'.$ref.'",2,'.$proyectoid.',"/'.date("Y").'/'.$ref.'",0,1,1
                    )';
        //file_put_contents("insertEnviosCli.txt", $sqlCrearEnvio);
        $resultado = mysqli_query($connString, $sqlCrearEnvio) or die("Error al crear el envío. ENVIOS_CLI.");
        $idenvio=mysqli_insert_id($connString);
        // Añadimos detalles del envio
        $pedidos_id = array_map('intval', explode('-', $_POST['pedidos_id2']));
        foreach ($pedidos_id as $pedido) {
            if($pedido!=0){
            $sqlSelPedDet="SELECT
                            MATERIALES_STOCK.material_id,
                            MATERIALES_STOCK.stock
                          FROM MATERIALES_STOCK WHERE MATERIALES_STOCK.pedido_detalle_id=".$pedido;
            //file_put_contents("selectMaterialesStock.txt", $sqlSelPedDet);
            $resSel = mysqli_query($connString, $sqlSelPedDet) or die("Error al reealizar sleect de los pedidos detalles.");
            $row = mysqli_fetch_array($resSel);
            $sqlInsertDetalle = "INSERT INTO ENVIOS_CLI_DETALLES
                                    (envio_id, 
                                    material_id, 
                                    unidades, 
                                    entregado,
                                    proyecto_id,
                                    pedido_detalle_id)
                                VALUES
                                    (".$idenvio.",".$row[0].",".$row[1].",0,".$proyectoid.",".$pedido.")";
            //file_put_contents("insertEnviosCliDetalles.txt", $sqlInsertDetalle);
            $resInsert = mysqli_query($connString, $sqlInsertDetalle) or die("Error realizar insert de detalles del envío.");
            
            $sqlUpdatePedDet ="UPDATE PEDIDOS_PROV_DETALLES SET PEDIDOS_PROV_DETALLES.recibido=3 WHERE PEDIDOS_PROV_DETALLES.id=".$pedido;
            //file_put_contents("updatePedidosProvDetalles.txt", $sqlUpdatePedDet);
            $resUpdate = mysqli_query($connString, $sqlUpdatePedDet) or die("Error realizar el update de pedidos detalles a recibido=3 envio.");  
            }
        }
        
        echo $idenvio;
    }
    
    function insertMatFromPedidos() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
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
                    PEDIDOS_PROV_DETALLES.material_tarifa_id 
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
                    PEDIDOS_PROV_DETALLES.proyecto_id = ".$_POST['proyecto_id']." 
                ORDER BY 
                    PEDIDOS_PROV.id ASC ";
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del detalle de Pedidos");
        while ($registros = mysqli_fetch_array($resultado)) {
            // Ahora por cada detalle encontrado, independientemente del pedido que provenga, añado ese material con el precio seleccionado, unidades, etc... a la tabla PROYECTOS_MATERIALES
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
                             ".$_POST['proyecto_id'].",
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
                         ".$_POST['proyecto_id'].",
                         ".$registros[0]."
                         )";
            }
            //file_put_contents("insertMatFromPedido.txt",$sqlIn);
            updateStock($registros[17], (0 - $registros[4]));
            updateStockUbicacion(0,$registros[0]);
            $resultadoIn = mysqli_query($connString, $sqlIn) or die("Error al guardar Material");
        }
        echo 1;
    }
    
    function insertMatFromPedidosIDs() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $pedidos_id = array_map('intval', explode('-', $_POST['pedidos_id']));
        
        foreach ($pedidos_id as $pedido) {
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
                        PEDIDOS_PROV.id = ".$pedido."
                    AND
                        PEDIDOS_PROV_DETALLES.proyecto_id = ".$_POST['proyecto_id']."
                    ORDER BY 
                        PEDIDOS_PROV.id ASC ";
            //file_put_contents("selectBig.txt",$sql);
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del detalle de Pedidos");
            while ($registros = mysqli_fetch_array($resultado)) {
                // Ahora por cada detalle encontrado, independientemente del pedido que provenga, añado ese material con el precio seleccionado, unidades, etc... a la tabla PROYECTOS_MATERIALES
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
                                 ".$_POST['proyecto_id'].",
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
                             ".$_POST['proyecto_id'].",
                             ".$registros[0]."
                             )";
                }
                //file_put_contents("insertMatFromPedido.txt",$sqlIn);
                updateStock($registros[17], (0 - $registros[4]));
                $resultadoIn = mysqli_query($connString, $sqlIn) or die("Error al guardar Material");
                if($registros[19]!=10 || $registros[19]!=11){
                    updateStockUbicacion(0,$registros[0]);
                }
            } //fin del while de los detalles de cada pedido
        } //fin del foreach pedidos_id
        echo 1;
    }
    
    function updateStock($material_id, $incremento) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
       
        if ($detalleid != "") {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + (".$incremento.") WHERE id = (SELECT material_id FROM PROYECTOS_MATERIALES WHERE id = ".$detalleid.")";
        }
        else {
            $sqlStock = "UPDATE MATERIALES SET stock = stock + (".$incremento.") WHERE id = ".$material_id;
        }
        //file_put_contents("updateStock.txt", $sqlStock);
        return $result = mysqli_query($connString, $sqlStock) or die("Error al actualizar el Stock");
    }
    
    function updateStockUbicacion($ubicacion_id, $detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE MATERIALES_STOCK 
                SET ubicacion_id = ".$ubicacion_id."
                WHERE pedido_detalle_id = ".$detalle_id;
                
        //file_put_contents("updateMaterialUbicacion.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar la ubicacion del Material");
        //updateStock($detalle_id, $cantidad, "",$check_pedido);
        //mysqli_set_charset($connString, "utf8");
    }
    
    function updateStockUbicacionAlmacen($ubicacion_id, $stockmatid) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE MATERIALES_STOCK 
                SET ubicacion_id = ".$ubicacion_id."
                WHERE id = ".$stockmatid;
                
        //file_put_contents("updateMaterialUbicacionAlmacen.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar la ubicacion del Material Almacen");
        //updateStock($detalle_id, $cantidad, "",$check_pedido);
        //mysqli_set_charset($connString, "utf8");
    }
    
    function insertMaterialesGrupos(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        //$proyecto_id = $_POST['posiciones_proyecto_id'];
        $contador = 0;
        //$pos = $_POST['datos'];
        //$posiciones = $pos[0];
        
        $sql="INSERT INTO MATERIALES_GRUPOS_NOMBRES
                    (nombre) VALUES ('".$_POST['nombre_grupo']."')";
        $resultadoIn = mysqli_query($connString, $sql) or die("Error al guardar Grupos Nombre");
        $idGrupoMaterial = mysqli_insert_id($connString);
        
        $peddets_id = array_map('intval', explode('-', $_POST['detalles_id']));
        $largoArray = count($peddets_id);
        
        //for($i=0; $i<= count($pos); $i++){
        foreach ($peddets_id as $peddet_id) {
            //if ($pos[0]['value'] != "") {
                //if($contador < ($largoArray-1)){
                    //$posi.=$pos[$i];
            if($peddet_id!=0){
                    $sqlSel = "SELECT 
                                MATERIALES_STOCK.id,
                                MATERIALES_STOCK.pedido_detalle_id
                               FROM 
                                MATERIALES_STOCK
                               WHERE
                                MATERIALES_STOCK.pedido_detalle_id=".$peddet_id;
                    //file_put_contents("selectMatStock.txt", $sqlSel);
                    $resultado = mysqli_query($connString, $sqlSel) or die("Error al realizar select de Materiales stock");
                    $registros = mysqli_fetch_array($resultado);

                    //file_put_contents("log.txt", $posis['value']);
                    $sqlIn = "INSERT INTO MATERIALES_GRUPOS 
                                     (materiales_stock_id,
                                     pedido_detalle_id,
                                     grupos_nombres_id
                                     )
                                     VALUES (
                                     ".$registros[0].",
                                     ".$registros[1].",
                                     ".$idGrupoMaterial.")";
                    //file_put_contents("insertMaterialesGrupo.txt", $sqlIn);
                    $resultadoIn = mysqli_query($connString, $sqlIn) or die("Error al guardar Material en el Grupo");                   
                    $contador = $contador + 1;
            }
            //}
            //file_put_contents("insertPosiciones".$contador.".txt", $posicion['pos-to-project']."-".$posicion['pos_unidades']);
        }
        //file_put_contents("contador22.txt", $contador);
        
        // CREAR ENTREGA
        // Crear Automaticamente REF!!
        $sqlRef="SELECT SUBSTRING( ENTREGAS.ref, 4, 4 ) AS anyo
                    FROM ENTREGAS
                    WHERE SUBSTRING( ENTREGAS.ref, 2, 2 ) =".substr(Date("Y"),2,4)." ORDER BY anyo DESC LIMIT 1";
        //file_put_contents("selectLastRef.txt", $sqlRef);
        $resultado = mysqli_query($connString, $sqlRef) or die("Error al seleccionar ultimo valor de ref del año.");
        $registros = mysqli_fetch_array($resultado);
        $ref = "E".substr(Date("Y"),2,4).str_pad(($registros[0]+1), 4, '0', STR_PAD_LEFT);  // Añadir ALB+AÑO+XXXX
        
        $sql = "SELECT path FROM PROYECTOS WHERE id = ".$_POST['grupo_proyecto_id'];
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el Path del Proyecto");
        $registros = mysqli_fetch_row ($result);
        $pathproyecto = $registros[0];
        
        $sqlInsertEntrega="INSERT INTO ENTREGAS
                            (ref, nombre, descripcion, proyecto_id, fecha_entrega, fecha_pruebas, fecha_realentrega, estado_id, path, fecha_mod, grupos_nombres_id) 
                            VALUES ('".$ref."',
                            '".$_POST['nombre_grupo']."',
                            '',
                            ".$_POST['grupo_proyecto_id'].",
                            '0000-00-00',
                            '0000-00-00',
                            '0000-00-00',
                            1,
                            '".$pathproyecto."/ENTREGAS/".$ref."/',
                            '0000-00-00 00:00:00',
                            ".$idGrupoMaterial.")";
        //file_put_contents("insertEntrega.txt", $sqlInsertEntrega);
        $result = mysqli_query($connString, $sqlInsertEntrega) or die("Error al insertar Entregas!");
        // Asignar Ensayos (detalles)
        $idEntrega=mysqli_insert_id($connString);
        
        
        $peddets_id = array_map('intval', explode('-', $_POST['detalles_id']));
        
        //for($i=0; $i<= count($pos); $i++){
        foreach ($peddets_id as $peddet_id) {
            // Actualizar tabla PEDIDOS_PROV_DETALLES
            $sqlUpdatePedDet = "UPDATE PEDIDOS_PROV_DETALLES SET entrega_id=".$idEntrega." WHERE id=".$peddet_id;
            $result = mysqli_query($connString, $sqlUpdatePedDet) or die("Error al actualizar entrega_id en PED_PROV_DET !");
        }
        echo $idEntrega;
    }
?>
	