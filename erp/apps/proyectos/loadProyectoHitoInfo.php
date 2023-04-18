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
                    PROYECTOS_HITOS.id as hito,
                    PROYECTOS_HITOS.nombre,
                    PROYECTOS_HITOS.descripcion,
                    PROYECTOS_HITOS.fecha_entrega,
                    PROYECTOS_HITOS.fecha_realizacion,
                    PROYECTOS_HITOS.observaciones,
                    PROYECTOS_HITOS.estado_id,
                    PROYECTOS_HITOS.erpuser_id
                FROM 
                    PROYECTOS_HITOS 
                WHERE 
                    PROYECTOS_HITOS.id = ".$id);
        
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
