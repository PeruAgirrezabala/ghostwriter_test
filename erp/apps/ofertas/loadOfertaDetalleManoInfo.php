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
                TAREAS.id as tarea,
                TAREAS.nombre,
                OFERTAS_DETALLES_HORAS.cantidad,
                PERFILES_HORAS.precio,
                OFERTAS_DETALLES_HORAS.titulo,
                OFERTAS_DETALLES_HORAS.descripcion,
                OFERTAS_DETALLES_HORAS.dto,
                OFERTAS_DETALLES_HORAS.pvp,
                OFERTAS_DETALLES_HORAS.pvp_total, 
                OFERTAS_DETALLES_HORAS.id as detalle,
                PERFILES_HORAS.id as tipohora,
                PERFILES.id as perfil
            FROM 
                TAREAS, PERFILES, PERFILES_HORAS, OFERTAS_DETALLES_HORAS, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_HORAS.tarea_id = TAREAS.id
            AND
                TAREAS.perfil_id = PERFILES.id
            AND
                PERFILES_HORAS.perfil_id = PERFILES.id
            AND
                PERFILES_HORAS.id = OFERTAS_DETALLES_HORAS.tipo_hora_id
            AND
                OFERTAS_DETALLES_HORAS.oferta_id = OFERTAS.id  
            AND 
                OFERTAS_DETALLES_HORAS.id = ".$id);
        
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
