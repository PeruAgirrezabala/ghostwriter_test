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
    $campoWhere1 = trim($_GET['campowhere1']);
    $campoWhere2 = trim($_GET['campowhere2']);
    $campo1 = $_GET['campo1'];
    $campo2 = $_GET['campo2'];

    try
    { 
        
        //file_put_contents("loadselectPrecios.txt", "SELECT MATERIALES_PRECIOS.id, MATERIALES.nombre, MATERIALES_PRECIOS.fecha_val, PROVEEDORES.nombre as proveedor, MATERIALES_PRECIOS.pvp, MATERIALES_PRECIOS.dto_material  FROM ".$table.", MATERIALES, PROVEEDORES WHERE MATERIALES_PRECIOS.material_id = MATERIALES.id AND MATERIALES_PRECIOS.proveedor_id = PROVEEDORES.id AND MATERIALES_PRECIOS.material_id = ".$valor." ORDER BY PROVEEDORES.nombre ASC");
        /*
        "SELECT
                MATERIALES_PRECIOS.id, 
                MATERIALES.nombre, 
                MATERIALES_PRECIOS.fecha_val, 
                PROVEEDORES.nombre as proveedor, 
                MATERIALES_PRECIOS.pvp, 
                MATERIALES_PRECIOS.dto_material, 
                MATERIALES_PRECIOS.proveedor_id  
                FROM ".$table.", MATERIALES, PROVEEDORES
                WHERE 
                MATERIALES_PRECIOS.material_id = MATERIALES.id 
                AND 
                MATERIALES_PRECIOS.proveedor_id = PROVEEDORES.id 
                AND 
                MATERIALES_PRECIOS.material_id = ".$valor."
                ORDER BY PROVEEDORES.nombre ASC"
         *          */
        $stmt = $db_con->prepare("SELECT
                MATERIALES_PRECIOS.id, 
                MATERIALES.nombre, 
                MATERIALES_PRECIOS.fecha_val, 
                PROVEEDORES.nombre as proveedor, 
                MATERIALES_PRECIOS.pvp, 
                MATERIALES_PRECIOS.dto_material, 
                MATERIALES_PRECIOS.proveedor_id  
                FROM ".$table.", MATERIALES, PROVEEDORES
                WHERE 
                MATERIALES_PRECIOS.material_id = MATERIALES.id 
                AND 
                MATERIALES_PRECIOS.proveedor_id = PROVEEDORES.id 
                AND 
                MATERIALES_PRECIOS.".$campoWhere1." = ".$campo1."
                AND
                MATERIALES_PRECIOS.".$campoWhere2." = ".$campo2."
                ORDER BY PROVEEDORES.nombre ASC");
             
        
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
