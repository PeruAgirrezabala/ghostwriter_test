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
                                    INTERVENCIONES_HORAS_IMPUTADAS.id as detalle, 
                                    TAREAS.id as tarea,
                                    TAREAS.nombre,
                                    INTERVENCIONES_HORAS_IMPUTADAS.cantidad,
                                    INTERVENCIONES_HORAS_IMPUTADAS.titulo,
                                    INTERVENCIONES_HORAS_IMPUTADAS.descripcion,
                                    erp_users.id as tecnico,
                                    INTERVENCIONES_HORAS_IMPUTADAS.id as detalle,
                                    INTERVENCIONES_HORAS_IMPUTADAS.fecha,
                                    PERFILES_HORAS.id as tipohora,
                                    PERFILES.id as perfil, 
                                    INTERVENCIONES.id as intervencion 
                                FROM 
                                    TAREAS, PERFILES, PERFILES_HORAS, INTERVENCIONES_HORAS_IMPUTADAS, INTERVENCIONES, erp_users  
                                WHERE 
                                    INTERVENCIONES_HORAS_IMPUTADAS.tarea_id = TAREAS.id
                                AND
                                    TAREAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.id = INTERVENCIONES_HORAS_IMPUTADAS.tipo_hora_id
                                AND
                                    INTERVENCIONES_HORAS_IMPUTADAS.int_id = INTERVENCIONES.id 
                                AND 
                                    INTERVENCIONES_HORAS_IMPUTADAS.tecnico_id = erp_users.id 
                                AND 
                                    INTERVENCIONES_HORAS_IMPUTADAS.id = ".$id);
        
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
