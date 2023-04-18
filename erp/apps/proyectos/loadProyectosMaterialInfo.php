<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");

if(isset($_GET['tabla'])) {
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
                                    MATERIALES.id as material, 
                                    MATERIALES.nombre, 
                                    MATERIALES.fabricante,
                                    MATERIALES.modelo, 
                                    MATERIALES.descripcion, 
                                    MATERIALES.DTO2,
                                    MATERIALES.stock, 
                                    (SELECT pvp FROM MATERIALES_PRECIOS WHERE MATERIALES_PRECIOS.fecha_val > now() AND material_id = material ORDER BY MATERIALES_PRECIOS.fecha_val ASC LIMIT 1 ) as precio 
                                    FROM MATERIALES, MATERIALES_PRECIOS 
                                    WHERE MATERIALES_PRECIOS.material_id = MATERIALES.id 
                                    AND MATERIALES.id = ".$id);
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
