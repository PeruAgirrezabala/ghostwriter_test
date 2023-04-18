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
                                    ENVIOS_CLI_DETALLES.id as detalle,
                                    MATERIALES.ref,  
                                    MATERIALES.nombre,
                                    MATERIALES.fabricante,
                                    MATERIALES.categoria_id,
                                    ENVIOS_CLI_DETALLES.unidades,
                                    ENVIOS_CLI_DETALLES.entregado,
                                    ENVIOS_CLI_DETALLES.fecha_recepcion,
                                    ENVIOS_CLI_DETALLES.garantia,
                                    ENVIOS_CLI_DETALLES.descripcion as descnota,
                                    ENVIOS_CLI_DETALLES.pedido_detalle_id,
                                    MATERIALES.id as material,
                                    PROYECTOS.id as proyecto,
                                    ENTREGAS.id as entregaid,
                                    ENVIOS_CLI_DETALLES.serialnumber_id,
                                    SERIAL_NUMBERS.id as sn,
                                    MATSN.ref as refsn,  
                                    MATSN.nombre nombresn,
                                    MATSN.fabricante fabricantesn,
                                    MATSN.modelo modelosn,
                                    MATSN.id materialsn,
                                    MATERIALES_STOCK.stock,
                                    PEDIDOS_PROV.pedido_genelek
                                FROM 
                                    ENVIOS_CLI_DETALLES
                                LEFT JOIN MATERIALES
                                    ON ENVIOS_CLI_DETALLES.material_id = MATERIALES.id 
                                LEFT JOIN PROYECTOS 
                                    ON PROYECTOS.id = ENVIOS_CLI_DETALLES.proyecto_id 
                                LEFT JOIN ENTREGAS
                                    ON ENVIOS_CLI_DETALLES.entrega_id = ENTREGAS.id
                                LEFT JOIN SERIAL_NUMBERS 
                                    ON SERIAL_NUMBERS.id = ENVIOS_CLI_DETALLES.serialnumber_id 
                                LEFT JOIN MATERIALES MATSN
                                    ON MATSN.id = SERIAL_NUMBERS.material_id
                                LEFT JOIN MATERIALES_STOCK
                                    ON ENVIOS_CLI_DETALLES.pedido_detalle_id = MATERIALES_STOCK.pedido_detalle_id
                                LEFT JOIN PEDIDOS_PROV_DETALLES
                                    ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                                LEFT JOIN PEDIDOS_PROV
                                    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
                                WHERE
                                    ENVIOS_CLI_DETALLES.id = ".$id);

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
