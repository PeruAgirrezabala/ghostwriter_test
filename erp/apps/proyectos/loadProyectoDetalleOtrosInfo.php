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
                PROYECTOS_DETALLES_OTROS.cantidad,
                PROYECTOS_DETALLES_OTROS.unitario,
                PROYECTOS_DETALLES_OTROS.titulo,
                PROYECTOS_DETALLES_OTROS.descripcion,
                PROYECTOS_DETALLES_OTROS.iva,
                PROYECTOS_DETALLES_OTROS.pvp,
                PROYECTOS_DETALLES_OTROS.pvp_total, 
                PROYECTOS_DETALLES_OTROS.id as detalle
            FROM 
                PROYECTOS_DETALLES_OTROS, PROYECTOS  
            WHERE 
                PROYECTOS_DETALLES_OTROS.PROYECTO_id = PROYECTOS.id 
            AND 
                PROYECTOS_DETALLES_OTROS.id = ".$id);
        
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
