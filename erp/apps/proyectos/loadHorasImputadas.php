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
                                    PROYECTOS_HORAS_IMPUTADAS.id,
                                    PROYECTOS_HORAS_IMPUTADAS.tarea_id,
                                    PROYECTOS_HORAS_IMPUTADAS.proyecto_id,
                                    PROYECTOS_HORAS_IMPUTADAS.descripcion,
                                    PROYECTOS_HORAS_IMPUTADAS.fecha,
                                    PROYECTOS_HORAS_IMPUTADAS.estado_id,
                                    PROYECTOS_HORAS_IMPUTADAS.tecnico_id,
                                    PROYECTOS_HORAS_IMPUTADAS.tipo_hora_id,
                                    PROYECTOS_HORAS_IMPUTADAS.cantidad,
                                    PROYECTOS_HORAS_IMPUTADAS.titulo
                                FROM 
                                    PROYECTOS_HORAS_IMPUTADAS  
                                WHERE
                                    PROYECTOS_HORAS_IMPUTADAS.id = ".$id);
        
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
