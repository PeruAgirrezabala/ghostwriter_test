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
    $criteria = "";
    
    
    try
    {   
        $stmt = $db_con->prepare("SELECT 
                                    ENTREGAS.nombre,
                                    ENTREGAS.ref
                                    FROM ENTREGAS  
                                    WHERE ENTREGAS.id = ".$id);
        $sql = "SELECT 
                                    ENTREGAS.nombre,
                                    ENTREGAS.ref
                                    FROM ENTREGAS  
                                    WHERE ENTREGAS.id = ".$id;
        file_put_contents("queryTtituloEntrega.txt", $sql);
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
