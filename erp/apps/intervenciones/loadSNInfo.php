<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");

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
                                        SERIAL_NUMBERS.id,
                                        MATERIALES.ref,  
                                        MATERIALES.nombre,
                                        MATERIALES.fabricante,
                                        MATERIALES.modelo,
                                        SERIAL_NUMBERS.sn,
                                        PROVEEDORES.nombre as prov, 
                                        CLIENTES.nombre as cli
                                    FROM 
                                        SERIAL_NUMBERS
                                    INNER JOIN MATERIALES
                                        ON MATERIALES.id = SERIAL_NUMBERS.material_id 
                                    LEFT JOIN PROVEEDORES 
                                        ON PROVEEDORES.id = SERIAL_NUMBERS.proveedor_id 
                                    LEFT JOIN CLIENTES
                                        ON SERIAL_NUMBERS.cliente_id = CLIENTES.id
                                    WHERE 
                                        SERIAL_NUMBERS.id = ".$id);
        $sql = "SELECT 
                                        INTERVENCIONES_MATERIALES.id,
                                        MATERIALES.ref,  
                                        MATERIALES.nombre,
                                        MATERIALES.fabricante,
                                        INTERVENCIONES_MATERIALES.unidades,
                                        INTERVENCIONES_MATERIALES.sustituido,
                                        INTERVENCIONES_MATERIALES.reparado,
                                        INTERVENCIONES.id as intid,
                                        SERIAL_NUMBERS.sn,
                                        PROVEEDORES.nombre as prov, 
                                        CLIENTES.nombre as cli
                                    FROM 
                                        INTERVENCIONES_MATERIALES
                                    INNER JOIN SERIAL_NUMBERS
                                        ON INTERVENCIONES_MATERIALES.material_id = SERIAL_NUMBERS.id 
                                    INNER JOIN MATERIALES
                                        ON MATERIALES.id = SERIAL_NUMBERS.material_id 
                                    LEFT JOIN PROVEEDORES 
                                        ON PROVEEDORES.id = SERIAL_NUMBERS.proveedor_id 
                                    LEFT JOIN CLIENTES
                                        ON SERIAL_NUMBERS.cliente_id = CLIENTES.id
                                    INNER JOIN INTERVENCIONES 
                                        ON INTERVENCIONES.id = INTERVENCIONES_MATERIALES.int_id  
                                    WHERE 
                                        SERIAL_NUMBERS.id = ".$id;
        file_put_contents("querySN.txt", $sql);
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
