
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['proyectomaterial_deldetalle'] != "") {
        delProyectoMat($_POST['proyectomaterial_deldetalle']);
    }    
    else {
        if ($_POST['proyectomaterial_detalle_id'] != "") {
            updateProyectoMat();
        }
        else {
            insertProyectoMat();
        }
    }
    
    function insertProyectoMat() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        if ($_POST['proyectomaterial_dtoprov'] != "") {
            $provdto_id_field = ", dto_prov_id ";
            $provdto_id = ", ".$_POST['proyectomaterial_dtoprov'];
        }
        else {
            $provdto_id_field = "";
            $provdto_id = "";
        }
        if ($_POST['proyectomaterial_dtoprov_desc'] == "") {
            $dtoprov_activo = 0;
        }
        else {
            $dtoprov_activo = 1;
        }
        if ($_POST['proyectomaterial_dtomat_desc'] == "") {
            $dtomat_activo = 0;
        }
        else {
            $dtomat_activo = 1;
        }
        if ($_POST['proyectomaterial_dto_desc'] == "") {
            $dtoad_activo = 0;
        }
        else {
            $dtoad_activo = 1;
        }
        
        $sql = "INSERT INTO PROYECTOS_MATERIALES
                    (
                        material_id,
                        proyecto_id,
                        unidades,
                        material_tarifa_id,
                        dto_prov_activo,
                        dto_mat_activo,
                        dto_ad_activo
                        ".$provdto_id_field."
                    )
                VALUES (".$_POST['proyectomaterial_material_id'].",
                ".$_POST['proyectomaterial_proyecto_id'].",
                ".$_POST['proyectomaterial_cantidad'].",
                ".$_POST['proyectomaterial_precios'].",
                ".$dtoprov_activo.", 
                ".$dtomat_activo.",
                ".$dtoad_activo." 
                ".$provdto_id.")";
        //file_put_contents("insertProyectoMat.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Material en el Proyecto");
        echo updateStock($_POST['proyectomaterial_material_id'], (0 - $_POST['proyectomaterial_cantidad']), "");
    }
    
    function updateProyectoMat() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['proyectomaterial_dtoprov'] != "") {
            $provdto_id = ", dto_prov_id = ".$_POST['proyectomaterial_dtoprov'];
        }
        else {
            $provdto_id = "";
        }
        
        if ($_POST['proyectomaterial_dtoprov_desc'] == "") {
            $dtoprov_activo = 0;
        }
        else {
            $dtoprov_activo = 1;
        }
        if ($_POST['proyectomaterial_dtomat_desc'] == "") {
            $dtomat_activo = 0;
        }
        else {
            $dtomat_activo = 1;
        }
        if ($_POST['proyectomaterial_dto_desc'] == "") {
            $dtoad_activo = 0;
        }
        else {
            $dtoad_activo = 1;
        }
        
        $sql = "UPDATE PROYECTOS_MATERIALES 
                SET material_id = ".$_POST['proyectomaterial_material_id'].", 
                    material_tarifa_id = ".$_POST['proyectomaterial_precios'].", 
                    proyecto_id = ".$_POST['proyectomaterial_oferta_id'].", 
                    cantidad = ".$_POST['proyectomaterial_cantidad'].",  
                    dto_prov_activo = ".$dtoprov_activo.",
                    dto_mat_activo = ".$dtomat_activo.",
                    dto_ad_activo = ".$dtoad_activo."
                    ".$provdto_id." 
                WHERE id = ".$_POST['proyectomaterial_detalle_id'];
        //file_put_contents("updateProyectoMat.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Material en el Proyecto");
        echo updateStock($_POST['proyectomaterial_material_id'], (0 - $_POST['proyectomaterial_cantidad']), "");
    }

    function updateStock($material_id, $incremento, $detalleid) {
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
    
    function delProyectoMat($detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "SELECT PROYECTOS_MATERIALES.pedido_detalle_id,
                PROYECTOS_MATERIALES.material_id,
                PROYECTOS_MATERIALES.unidades,
                PROYECTOS_MATERIALES.proyecto_id
                FROM PROYECTOS_MATERIALES WHERE id=".$detalle_id;
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el id del detalle");
        $registros = mysqli_fetch_array($result);
        // Si es originario de almacen enviar a 1
        // Si es originario de proyecto, mover a 2 
        $sql = "SELECT proyecto_id from PEDIDOS_PROV_DETALLES WHERE id=".$registros[0];
        $res = mysqli_query($connString, $sql) or die("Error al seleccionar el id del detalle");
        $reg = mysqli_fetch_array($res);
        
        if($reg[0]==11 || $reg[0]==10){
            updateStockUbicacion(1,$registros[0]);
        }else{
            updateStockUbicacion(2,$registros[0]);
        }
        
        $sql = "delete from PROYECTOS_MATERIALES WHERE id=".$detalle_id;
        //file_put_contents("deleteProyectoMat.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Material en el Proyecto");
        
        // Si se puede borrar: No hay envio o no esta enviado
        // Borrar si fuese necesario. ENVIOS_CLI_DETALLES // Y actualizar PEDIDOS PROV DETALLES recibido a 1!!!
        $sql = "DELETE FROM ENVIOS_CLI_DETALLES WHERE pedido_detalle_id=".$registros[0];
        //file_put_contents("deleteProyectoMat.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Envio Detalle");
        $sql = "UPDATE PEDIDOS_PROV_DETALLES SET recibido = 1 WHERE PEDIDOS_PROV_DETALLES.id =".$registros[0];
        //file_put_contents("deleteProyectoMat.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al actualizar PEDIDOS_PROV_DETALLES");
        // Realizar insert en MATERIALES_STOCK si es que no existe
//        $sql = "SELECT * FROM MATERIALES_STOCK WHERE pedido_detalle_id=".$registros[0];
//        //file_put_contents("deleteProyectoMat.txt", $sql);
//        $result = mysqli_query($connString, $sql) or die("Error al seleccionar MATERIALES_STOCK");
//        $reg = mysqli_fetch_array($result);
//        if($reg[0]!=""){
//            $sql = "INSERT INTO MATERIALES_STOCK
//                    (material_id, stock, ubicacion_id, proyecto_id, pedido_detalle_id) 
//                    VALUES 
//                    (".$registros[1].",".$registros[2].",2,".$registros[3].",".$registros[0].")";
//            $result = mysqli_query($connString, $sql) or die("Error al seleccionar Insert MATERIALES_STOCK");
//        }
        
        updateStock("", $_POST['proyectomaterial_cantidad'], $_POST['proyectomaterial_deldetalle']);       
    }
    function updateStockUbicacion($ubicacion_id, $detalle_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE MATERIALES_STOCK 
                SET ubicacion_id = ".$ubicacion_id."
                WHERE pedido_detalle_id = ".$detalle_id;
                
        file_put_contents("updateMaterialUbicacion.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar la ubicacion del Material");
        //updateStock($detalle_id, $cantidad, "",$check_pedido);
        //mysqli_set_charset($connString, "utf8");
    }
?>
	