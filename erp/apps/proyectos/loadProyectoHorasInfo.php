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
                                    PROYECTOS_HORAS_IMPUTADAS.id as detalle, 
                                    TAREAS.id as tarea,
                                    TAREAS.nombre,
                                    PROYECTOS_HORAS_IMPUTADAS.cantidad,
                                    PROYECTOS_HORAS_IMPUTADAS.titulo,
                                    PROYECTOS_HORAS_IMPUTADAS.descripcion,
                                    erp_users.id as tecnico,
                                    PROYECTOS_HORAS_IMPUTADAS.id as detalle,
                                    PROYECTOS_HORAS_IMPUTADAS.fecha,
                                    PERFILES_HORAS.id as tipohora,
                                    PERFILES.id as perfil, 
                                    PROYECTOS.id as proyecto
                                FROM 
                                    TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_HORAS_IMPUTADAS, PROYECTOS, erp_users  
                                WHERE 
                                    PROYECTOS_HORAS_IMPUTADAS.tarea_id = TAREAS.id
                                AND
                                    TAREAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.id = PROYECTOS_HORAS_IMPUTADAS.tipo_hora_id
                                AND
                                    PROYECTOS_HORAS_IMPUTADAS.proyecto_id = PROYECTOS.id 
                                AND 
                                    PROYECTOS_HORAS_IMPUTADAS.tecnico_id = erp_users.id 
                                AND 
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
