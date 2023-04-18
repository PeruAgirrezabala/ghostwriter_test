<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");

if(isset($_GET['intdetalle_id'])) {
    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }
    
    $detalleid = $_GET['intdetalle_id'];
    $tecid = $_GET['tecnico_id'];

    try
    { 
        $stmt = $db_con->prepare("SELECT 
                                        INTERVENCIONES_DETALLES_TECNICOS.id,

                                        INTERVENCIONES_DETALLES_TECNICOS.H820,
                                        INTERVENCIONES_DETALLES_TECNICOS.H208,
                                        INTERVENCIONES_DETALLES_TECNICOS.Hviaje,
                                        INTERVENCIONES_DETALLES_TECNICOS.coste_H820,
                                        INTERVENCIONES_DETALLES_TECNICOS.coste_H208,
                                        INTERVENCIONES_DETALLES_TECNICOS.erpuser_id
                                    FROM 
                                        INTERVENCIONES_DETALLES_TECNICOS
                                    WHERE
                                        INTERVENCIONES_DETALLES_TECNICOS.erpuser_id = ".$tecid."
                                    AND
                                        INTERVENCIONES_DETALLES_TECNICOS.intdetalle_id = ".$detalleid);
        
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
