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
                        PEDIDOS_PROV.id,
                        PEDIDOS_PROV.ref,
                        PEDIDOS_PROV.titulo,
                        PEDIDOS_PROV.descripcion,
                        PEDIDOS_PROV.proveedor_id,
                        PEDIDOS_PROV.fecha,
                        PEDIDOS_PROV.fecha_entrega,
                        PEDIDOS_PROV.tecnico_id,
                        PEDIDOS_PROV.proyecto_id,
                        PEDIDOS_PROV.estado_id, 
                        PEDIDOS_PROV.total,
                        PEDIDOS_PROV.contacto
                    FROM 
                        PEDIDOS_PROV 
                    WHERE 
                        id = ".$id);

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
