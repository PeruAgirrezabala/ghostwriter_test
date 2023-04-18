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
        file_put_contents("queryPrev.txt", "SELECT
                                    PREVISIONES.id,
                                    PREVISIONES.nombre,
                                    PREVISIONES.descripcion,
                                    PREVISIONES.fecha_ini,
                                    PREVISIONES.fecha_fin,
                                    PREVISIONES.cliente_id,
                                    PREVISIONES.instalacion, 
                                    PREVISIONES.cliente_id, 
                                    PREVISIONES.item_id,
                                    PREVISIONES.tipo_prev,
                                    PREVISIONES.estado_id,
                                    (SELECT ref FROM INTERVENCIONES WHERE id = item) as ref_int,
                                    (SELECT ref FROM PROYECTOS WHERE id = item) as ref_proy,
                                    (SELECT ref FROM OFERTAS WHERE id = item) as ref_ofer
                                FROM 
                                    PREVISIONES
                                INNER JOIN PREVISIONES_ESTADOS
                                    ON PREVISIONES.estado_id = PREVISIONES_ESTADOS.id 
                                LEFT JOIN CLIENTES
                                    ON PREVISIONES.cliente_id = CLIENTES.id
                                WHERE 
                                    PREVISIONES.id = ".$id);
        $stmt = $db_con->prepare("SELECT
                                    PREVISIONES.id,
                                    PREVISIONES.nombre,
                                    PREVISIONES.descripcion,
                                    PREVISIONES.fecha_ini,
                                    PREVISIONES.fecha_fin,
                                    PREVISIONES.cliente_id,
                                    PREVISIONES.instalacion, 
                                    PREVISIONES.cliente_id, 
                                    PREVISIONES.item_id as item,
                                    PREVISIONES.tipo_prev,
                                    PREVISIONES.estado_id,
                                    (SELECT ref FROM INTERVENCIONES WHERE id = item) as ref_int,
                                    (SELECT ref FROM PROYECTOS WHERE id = item) as ref_proy,
                                    (SELECT ref FROM OFERTAS WHERE id = item) as ref_ofer
                                FROM 
                                    PREVISIONES
                                INNER JOIN PREVISIONES_ESTADOS
                                    ON PREVISIONES.estado_id = PREVISIONES_ESTADOS.id 
                                LEFT JOIN CLIENTES
                                    ON PREVISIONES.cliente_id = CLIENTES.id
                                WHERE 
                                    PREVISIONES.id = ".$id);

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
