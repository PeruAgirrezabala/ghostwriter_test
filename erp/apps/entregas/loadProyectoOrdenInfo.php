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
                                    PROYECTOS_TAREAS.cantidad,
                                    PROYECTOS_TAREAS.titulo,
                                    PROYECTOS_TAREAS.descripcion,
                                    erp_users.id as tecnico,
                                    PROYECTOS_TAREAS.id as detalle,
                                    PROYECTOS_TAREAS.fecha_entrega,
                                    PERFILES_HORAS.id as tipohora,
                                    PERFILES.id as perfil
                                FROM 
                                    TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_TAREAS, PROYECTOS, erp_users  
                                WHERE 
                                    PROYECTOS_TAREAS.tarea_id = TAREAS.id
                                AND
                                    TAREAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.id = PROYECTOS_TAREAS.tipo_hora_id
                                AND
                                    PROYECTOS_TAREAS.proyecto_id = PROYECTOS.id 
                                AND 
                                    PROYECTOS_TAREAS.tecnico_id = erp_users.id 
                                AND 
                                    PROYECTOS_TAREAS.id = ".$id);
        
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
