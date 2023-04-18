<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");

if(isset($_GET['campo'])) {
    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }
    
    $table = trim($_GET['tabla']);
    $id = $_GET['id'];

    try
    { 
        $stmt = $db_con->prepare("SELECT
                                        MATERIALES.id,
                                        MATERIALES.ref,
                                        MATERIALES.nombre,
                                        MATERIALES.fabricante,
                                        MATERIALES.modelo,
                                        MATERIALES.DTO2,
                                        MATERIALES_STOCK.stock,
                                        MATERIALES.cad,
                                        MATERIALES.sustituto,
                                        MATERIALES_STOCK.pedido_detalle_id,
                                        MATERIALES_STOCK.id as id_stock
                                    FROM 
                                        MATERIALES, MATERIALES_STOCK
                                    WHERE
                                        MATERIALES.id=MATERIALES_STOCK.material_id
                                    AND
                                        MATERIALES_STOCK.ubicacion_id=1
                                    AND  
                                        MATERIALES_STOCK.proyecto_id=11");
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
