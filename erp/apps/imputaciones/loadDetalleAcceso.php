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
                    JORNADAS_ACCESOS.id,
                    CALENDARIO.fecha,
                    JORNADAS_ACCESOS.hora_entrada, 
                    JORNADAS_ACCESOS.hora_salida,
                    JORNADAS.id as jornadaid
                FROM 
                    JORNADAS_ACCESOS, JORNADAS, CALENDARIO  
                WHERE 
                    CALENDARIO.id = JORNADAS.calendario_id 
                AND
                    JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                    JORNADAS_ACCESOS.id = ".$id);

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
