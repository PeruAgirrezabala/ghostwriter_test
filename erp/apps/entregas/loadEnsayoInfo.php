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
    
    $table = trim($_GET['tabla']);
    $id = $_GET['id'];
    try
    { 
        file_put_contents("loadEnsayoInfo.txt", "SELECT 
                                    ENSAYOS_INFO.id as ensayoinfoid,
                                    ENSAYOS_INFO.ensayo_id as ensayoid,
                                    ENSAYOS_INFO.titulo,
                                    ENSAYOS_INFO.descripcion,
                                    ENSAYOS_INFO.estado,
                                    ENSAYOS_INFO.fecha
                                FROM 
                                    ENSAYOS_INFO 
                                WHERE
                                    ENSAYOS_INFO.id = ".$id."
                                LIMIT 1");
        $stmt = $db_con->prepare("SELECT 
                                    ENSAYOS_INFO.id as ensayoinfoid,
                                    ENSAYOS_INFO.ensayo_id as ensayoid,
                                    ENSAYOS_INFO.titulo,
                                    ENSAYOS_INFO.descripcion,
                                    ENSAYOS_INFO.estado,
                                    ENSAYOS_INFO.fecha
                                FROM 
                                    ENSAYOS_INFO 
                                WHERE
                                    ENSAYOS_INFO.id = ".$id."
                                LIMIT 1");
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
