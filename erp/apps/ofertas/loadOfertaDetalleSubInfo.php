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
                PROVEEDORES.id as tercero,
                OFERTAS_DETALLES_TERCEROS.cantidad,
                OFERTAS_DETALLES_TERCEROS.unitario,
                OFERTAS_DETALLES_TERCEROS.titulo,
                OFERTAS_DETALLES_TERCEROS.descripcion,
                OFERTAS_DETALLES_TERCEROS.incremento,
                OFERTAS_DETALLES_TERCEROS.dto1,
                OFERTAS_DETALLES_TERCEROS.pvp,
                OFERTAS_DETALLES_TERCEROS.pvp_dto,
                OFERTAS_DETALLES_TERCEROS.pvp_total, 
                OFERTAS_DETALLES_TERCEROS.id as detalle
            FROM 
                PROVEEDORES, OFERTAS_DETALLES_TERCEROS, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_TERCEROS.tercero_id = PROVEEDORES.id
            AND
                OFERTAS_DETALLES_TERCEROS.oferta_id = OFERTAS.id  
            AND 
                OFERTAS_DETALLES_TERCEROS.id = ".$id);
        
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
