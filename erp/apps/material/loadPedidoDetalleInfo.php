<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");

if(isset($_GET['id'])) {
    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }
    
    $id = $_GET['id'];

    try
    { 
        $stmt = $db_con->prepare("SELECT 
                                    MATERIALES.id as material,
                                    PEDIDOS_PROV_DETALLES.ref,
                                    MATERIALES.nombre,
                                    MATERIALES.fabricante,
                                    MATERIALES.modelo,
                                    MATERIALES.descripcion,
                                    MATERIALES.categoria_id, 
                                    MATERIALES.stock,
                                    MATERIALES_PRECIOS.pvp as precio,
                                    MATERIALES_PRECIOS.id as precioid,
                                    PEDIDOS_PROV_DETALLES.unidades,
                                    PEDIDOS_PROV_DETALLES.recibido,
                                    PEDIDOS_PROV_DETALLES.fecha_recepcion,
                                    PEDIDOS_PROV_DETALLES.fecha_entrega,
                                    PEDIDOS_PROV_DETALLES.dto as dto_adicional,
                                    PEDIDOS_PROV_DETALLES.id as detalle,
                                    PEDIDOS_PROV_DETALLES.proyecto_id as proyecto,
                                    MATERIALES_PRECIOS.dto_material,
                                    PEDIDOS_PROV_DETALLES.dto_prov_id,
                                    PEDIDOS_PROV_DETALLES.dto_prov_activo,
                                    PEDIDOS_PROV_DETALLES.dto_mat_activo,
                                    PEDIDOS_PROV_DETALLES.dto_ad_activo,
                                    PROVEEDORES_DTO.dto_prov, 
                                    ENTREGAS.id as entregaid, 
                                    PEDIDOS_PROV_DETALLES.erp_userid,
                                    PEDIDOS_PROV_DETALLES.dto_ad_prior,
                                    PEDIDOS_PROV_DETALLES.iva_id,
                                    PEDIDOS_PROV_DETALLES.descripcion as observaciones,
                                    PEDIDOS_PROV_DETALLES.detalle_libre,
                                    PEDIDOS_PROV_DETALLES.pvp,
                                    PEDIDOS_PROV_DETALLES.cliente_id
                                FROM 
                                    PEDIDOS_PROV
                                INNER JOIN PROVEEDORES
                                    ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id 
                                INNER JOIN PEDIDOS_PROV_DETALLES 
                                    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                                LEFT JOIN MATERIALES
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
                                    PEDIDOS_PROV_DETALLES.id = ".$id);

        $stmt->execute(array(":valor"=>valor));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        
            $result_utf8 = utf8_converter($result);
            $json=json_encode($result_utf8);
            
            echo $json;
        
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
} //if isset btn_login



?>
