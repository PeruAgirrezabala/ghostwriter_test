<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }
    
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    

    $id = $_GET['id'];
    $criteria = "";
    
    
    try
    {   
        // Sacar Clientes
        $sql = "SELECT PROYECTOS.cliente_id,
                                    PROYECTOS.ingenieria_id,
                                    PROYECTOS.dir_obra_id,
                                    PROYECTOS.promotor_id
                                    FROM PROYECTOS WHERE id=".$id;
        file_put_contents("querySelectInstalacionesProyecto.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar los Clientes");
        $registros = mysqli_fetch_row ($result);
        
        $or=" ";
        if($registros[1]!=""){
            $or.=" OR cliente_id=".$registros[1];
        }
        if($registros[2]!=""){
            $or.=" OR cliente_id=".$registros[2];
        }
        if($registros[3]!=""){
            $or.=" OR cliente_id=".$registros[3];
        }
        
        
        $sql = "SELECT CLIENTES_INSTALACIONES.id, CLIENTES.nombre as nombrecliente, CLIENTES_INSTALACIONES.nombre as nombreinstalacion 
                                    FROM CLIENTES_INSTALACIONES
                                    INNER JOIN CLIENTES
                                    ON CLIENTES_INSTALACIONES.cliente_id=CLIENTES.id
                                    WHERE cliente_id=".$registros[0].$or;
        file_put_contents("queryKK.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar las instalaciones");
        
        $emparray = array();
        while($results = mysqli_fetch_assoc ($result)){
            $emparray[] = $results;
        }
        
        
            //$result_utf8 = utf8_converter($results);
            $json=json_encode($emparray);
            
            echo $json;
        
            
            /*
            $stmt->execute(array(":valor"=>valor));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
        
            $result_utf8 = utf8_converter($result);
            $json=json_encode($result_utf8);
            
            echo $json;


             */
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }



?>
