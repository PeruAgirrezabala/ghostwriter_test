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
                MATERIALES.ref,
                MATERIALES.nombre,
                MATERIALES.modelo,
                MATERIALES.descripcion,
                MATERIALES.categoria_id, 
                MATERIALES_PRECIOS.pvp as precio,
                OFERTAS_DETALLES_MATERIALES.cantidad,
                OFERTAS_DETALLES_MATERIALES.titulo,
                OFERTAS_DETALLES_MATERIALES.descripcion,
                OFERTAS_DETALLES_MATERIALES.incremento,
                OFERTAS_DETALLES_MATERIALES.dto1,
                OFERTAS_DETALLES_MATERIALES.pvp,
                OFERTAS_DETALLES_MATERIALES.pvp_dto,
                OFERTAS_DETALLES_MATERIALES.pvp_total, 
                OFERTAS_DETALLES_MATERIALES.id as detalle,
                OFERTAS_DETALLES_MATERIALES.origen, 
                OFERTAS_DETALLES_MATERIALES.material_tarifa_id,
                MATERIALES_PRECIOS.proveedor_id,
                OFERTAS_DETALLES_MATERIALES.dto_prov_id
            FROM 
                MATERIALES, MATERIALES_PRECIOS, OFERTAS_DETALLES_MATERIALES, OFERTAS  
            WHERE 
                MATERIALES_PRECIOS.material_id = MATERIALES.id 
            AND
                OFERTAS_DETALLES_MATERIALES.material_id = MATERIALES.id
            AND
                OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id 
            AND 
                OFERTAS_DETALLES_MATERIALES.material_tarifa_id = MATERIALES_PRECIOS.id 
            AND 
                OFERTAS_DETALLES_MATERIALES.id = ".$id);
        
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
