<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT'];
    require_once($pathraiz."/core/dbconfig.php");
    
    $cliente_id = $_GET['cliente'];
    
    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }
    
    try
    { 
       
        $stmt = $db_con->prepare("SELECT tools_proyectos.nombre , tools_proyectos.id, tools_proyectos_clientes.escritura FROM tools_proyectos_clientes, tools_proyectos WHERE tools_proyectos_clientes.proyecto_id = tools_proyectos.id AND tools_proyectos_clientes.cliente_id = ".$cliente_id." ORDER BY tools_proyectos.nombre ASC");
        
        //$stmt = $db_con->prepare("SELECT * from tools_proyectos_clientes WHERE tools_proyectos_clientes.cliente_id = ".$cliente_id);
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



?>
