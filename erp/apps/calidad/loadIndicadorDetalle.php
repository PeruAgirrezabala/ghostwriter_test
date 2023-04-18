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
                                    id,
                                    nombre,
                                    meta,
                                    proceso_id,
                                    objetivo,
                                    calculo,
                                    resultado,
                                    valor,
                                    tienehijos,
                                    (SELECT COUNT(*) FROM OFERTAS WHERE OFERTAS.estado_id =4 AND YEAR( OFERTAS.fecha ) =".date("Y").") AS aceptados,
                                    (SELECT COUNT(*) FROM OFERTAS WHERE YEAR(OFERTAS.fecha)=".date("Y")." AND OFERTAS.0_ver=0) AS num_ofertas_total
                                FROM 
                                    CALIDAD_INDICADORES
                                WHERE
                                    id = ".$id);
        
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
