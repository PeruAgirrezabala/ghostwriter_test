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
                                    INTERVENCIONES_DETALLES.id,
                                    INTERVENCIONES_DETALLES.titulo,  
                                    INTERVENCIONES_DETALLES.descripcion,
                                    INTERVENCIONES_DETALLES.fecha,
                                    INTERVENCIONES_DETALLES.fecha_mod,
                                    INTERVENCIONES_DETALLES.H820,
                                    INTERVENCIONES_DETALLES.H208,
                                    INTERVENCIONES_DETALLES.Hviaje,
                                    INTERVENCIONES_DETALLES.coste_H820,
                                    INTERVENCIONES_DETALLES.coste_H208,
                                    INTERVENCIONES_DETALLES.erpuser_id,
                                    INTERVENCIONES_DETALLES.int_id
                                FROM 
                                    INTERVENCIONES_DETALLES
                                WHERE
                                    INTERVENCIONES_DETALLES.id = ".$id);

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
