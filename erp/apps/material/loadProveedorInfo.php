<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");

if(isset($_GET['tabla'])) {
    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }
    
    $table = trim($_GET['tabla']);
    $id = $_GET['id'];

    try
    { 
        $stmt = $db_con->prepare("SELECT 
                                    id, 
                                    nombre, 
                                    direccion,
                                    poblacion,
                                    provincia,
                                    cp,
                                    pais,
                                    telefono,
                                    email,
                                    contacto,
                                    web,
                                    CIF,
                                    id as proveedor,
                                    (SELECT dto_prov FROM PROVEEDORES_DTO WHERE PROVEEDORES_DTO.fecha_val < now() AND proveedor_id = proveedor ORDER BY PROVEEDORES_DTO.fecha_val DESC, PROVEEDORES_DTO.id DESC LIMIT 1 ) as dto,
                                    descripcion,
                                    formaPago,
                                    email_pedidos,
                                    homologado,
                                    fecha_aprob,
                                    plataforma,
                                    usuario,
                                    password
                                    FROM PROVEEDORES 
                                    WHERE id = ".$id);
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
