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
                                    ACTIVIDAD_DETALLES.id,
                                    ACTIVIDAD_DETALLES.nombre,  
                                    ACTIVIDAD_DETALLES.descripcion,
                                    ACTIVIDAD_DETALLES.fecha,
                                    ACTIVIDAD_DETALLES.fecha_mod,
                                    ACTIVIDAD_DETALLES.erpuser_id,
                                    ACTIVIDAD_DETALLES.actividad_id,
                                    ACTIVIDAD_DETALLES.completado
                                FROM 
                                    ACTIVIDAD_DETALLES
                                INNER JOIN ACTIVIDAD_DETALLES_ESTADOS
                                ON ACTIVIDAD_DETALLES.completado = ACTIVIDAD_DETALLES_ESTADOS.id
                                WHERE
                                    ACTIVIDAD_DETALLES.id = ".$id);

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
