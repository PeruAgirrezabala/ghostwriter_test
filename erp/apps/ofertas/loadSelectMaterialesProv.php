<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");
    
if(isset($_GET['valor'])) {
    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }
    $mat_id = $_GET['valor'];

    try
    { 
        
        //file_put_contents("loadselectPrecios.txt", "SELECT MATERIALES_PRECIOS.id, MATERIALES.nombre, MATERIALES_PRECIOS.fecha_val, PROVEEDORES.nombre as proveedor, MATERIALES_PRECIOS.pvp, MATERIALES_PRECIOS.dto_material  FROM ".$table.", MATERIALES, PROVEEDORES WHERE MATERIALES_PRECIOS.material_id = MATERIALES.id AND MATERIALES_PRECIOS.proveedor_id = PROVEEDORES.id AND MATERIALES_PRECIOS.material_id = ".$valor." ORDER BY PROVEEDORES.nombre ASC");
        $stmt = $db_con->prepare("SELECT DISTINCT
                    PROVEEDORES.id,
                    PROVEEDORES.nombre
                    FROM PROVEEDORES
                    INNER JOIN MATERIALES_PRECIOS
                    ON PROVEEDORES.id = MATERIALES_PRECIOS.proveedor_id
                    WHERE MATERIALES_PRECIOS.material_id=".$mat_id);
             
        
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
