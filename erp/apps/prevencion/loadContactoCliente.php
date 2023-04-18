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
                                        CLIENTES_CONTACTOS.id, 
                                        CLIENTES_CONTACTOS.nombre as nombre, 
                                        CLIENTES_CONTACTOS.mail,
                                        CLIENTES_CONTACTOS.telefono,
                                        CLIENTES_CONTACTOS.descripcion,
                                        CLIENTES_CONTACTOS.activo,
                                        CLIENTES_CONTACTOS.cliente_id,
                                        CLIENTES_CONTACTOS.instalacion_cliente_id,
                                        CLIENTES_INSTALACIONES.nombre as nombre_instalacion
                                    FROM CLIENTES_CONTACTOS 
                                        INNER JOIN CLIENTES_INSTALACIONES
                                        ON CLIENTES_CONTACTOS.instalacion_cliente_id=CLIENTES_INSTALACIONES.id
                                    WHERE CLIENTES_CONTACTOS.id = ".$id);
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
