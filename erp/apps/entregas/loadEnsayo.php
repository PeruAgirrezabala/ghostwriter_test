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
        file_put_contents("loadEnsayo.txt", "SELECT 
                                    ENSAYOS.id as ensayoid,
                                    ENSAYOS.nombre as ensayonombre,
                                    ENSAYOS.descripcion,
                                    ENSAYOS.fecha,
                                    ENSAYOS.fecha_finalizacion,
                                    ENTREGAS.id as entregaid, 
                                    ENSAYOS.estado_id,
                                    ENSAYOS.plantilla_id,
                                    (SELECT path FROM ENSAYOS_ADJUNTOS WHERE ensayo_id = ensayoid LIMIT 1) as adjunto,
                                    erp_users.id as tecnico
                                FROM 
                                    ENTREGAS 
                                INNER JOIN ENSAYOS
                                    ON  ENTREGAS.id = ENSAYOS.entrega_id 
                                INNER JOIN ESTADOS_ENSAYOS
                                    ON  ENSAYOS.estado_id = ESTADOS_ENSAYOS.id 
                                LEFT JOIN erp_users 
                                    ON ENSAYOS.erp_userid = erp_users.id 
                                WHERE
                                    ENSAYOS.id = ".$id."
                                LIMIT 1");
        $stmt = $db_con->prepare("SELECT 
                                    ENSAYOS.id as ensayoid,
                                    ENSAYOS.nombre as ensayonombre,
                                    ENSAYOS.descripcion,
                                    ENSAYOS.fecha,
                                    ENSAYOS.fecha_finalizacion,
                                    ENTREGAS.id as entregaid, 
                                    ENSAYOS.estado_id,
                                    ENSAYOS.plantilla_id,
                                    (SELECT path FROM ENSAYOS_ADJUNTOS WHERE ensayo_id = ensayoid LIMIT 1) as adjunto,
                                    erp_users.id as tecnico
                                FROM 
                                    ENTREGAS 
                                INNER JOIN ENSAYOS
                                    ON  ENTREGAS.id = ENSAYOS.entrega_id 
                                INNER JOIN ESTADOS_ENSAYOS
                                    ON  ENSAYOS.estado_id = ESTADOS_ENSAYOS.id 
                                LEFT JOIN erp_users 
                                    ON ENSAYOS.erp_userid = erp_users.id 
                                WHERE
                                    ENSAYOS.id = ".$id."
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
