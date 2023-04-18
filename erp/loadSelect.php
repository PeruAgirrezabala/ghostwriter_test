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
    $campoBase = "nombre";
    if($_GET['orden']!=""){
        $ordenCampo=$_GET['orden'];
        $orden=" DESC";
    }else{
        $ordenCampo=$campoBase;
        $orden=" ASC";
    }
    $campo = trim($_GET['campo']);
    if ($_GET['campo2']) {
        $campo2 = ", ".trim($_GET['campo2'])." as campo2 ";
    }
    else {
        $campo2 = "";
    }
    if ($_GET['campo3']) {
        $campo3 = ", ".trim($_GET['campo3'])." as campo3 ";
    }
    else {
        $campo3 = "";
    }
    $campoWhere = trim($_GET['campowhere']);
    $valor = $_GET['valor'];
    $campoWhere2 = trim($_GET['campowhere2']);
    $valor2 = $_GET['valor2'];
    
    if ($_SESSION['user_rol'] == "CLIENTE") {
        switch ($table) {
            case "tools_proyectos":
                $table .= ", tools_proyectos_clientes ";
                $criteria = " tools_proyectos_clientes.proyecto_id = tools_proyectos.id AND tools_proyectos_clientes.cliente_id=".$_SESSION['user_session'];
                break;  
        }
    }
    else {
        switch ($table) {
            case "MATERIALES_PRECIOS":
                $table .= ", PROVEEDORES ";
                $criteria = " MATERIALES_PRECIOS.proveedor_id = PROVEEDORES.id ";
                $campo = "MATERIALES_PRECIOS.".$campo; 
                $campoBase = "pvp";
                break;
            case "PROVEEDORES_DTO":
                $table .= ", PROVEEDORES ";
                $criteria = " PROVEEDORES_DTO.proveedor_id = PROVEEDORES.id ";
                $campo = "PROVEEDORES_DTO.".$campo; 
                $campoBase = "dto_prov";
                break;
            case "PEDIDOS_PROV":
                $campoBase = "titulo";
                $criteria = "";
                break;
            case "OFERTAS":
                $campoBase = "titulo";
                $criteria = "";
                break;
            case "SERIAL_NUMBERS":
                $table .= ", MATERIALES ";
                $criteria = " MATERIALES.id = SERIAL_NUMBERS.material_id ";
                $campo = "SERIAL_NUMBERS.".$campo; 
                $campoBase = "sn";
                break;
            case "erp_apps":
                $campoBase = "ubicacion";
                break;
            default:
                $criteria = "";
                break;
        }
    }
    
    try
    { 
        if (($valor == "") && ($valor2 == "")) {  
            if ($criteria != "") {
                $criteria = " WHERE".$criteria;
            }
            
            $stmt = $db_con->prepare("SELECT ".$campo.", ".$campoBase." ".$campo2." ".$campo3." FROM ".$table.$criteria." ORDER BY ".$campoBase." ASC");
            if ($table == "GRUPOS_DOC") {
                //file_put_contents("loadselectGRUPOS.txt", "SELECT ".$campo.", ".$campoBase." ".$campo2." ".$campo3." FROM ".$table.$criteria." ORDER BY ".$campoBase." ASC");
            }
        }
        else {
            if ($criteria) {
                $criteria = " AND".$criteria;
            }
            if ($campoWhere2 != "") {
                if ($_GET['likeOrEqual'] == 1) {
                    $campoWhere2 = " OR ".$campoWhere2." LIKE '%".$valor2."%' ";
                }
                else {
                    $campoWhere2 = " AND ".$campoWhere2." = ".$valor2;
                }
            }
            if ($campoWhere != "") {
                if ($_GET['likeOrEqual'] == 1) {
                    $campoWhere = $campoWhere." LIKE '%".$valor."%' ";
                }
                else {
                    $campoWhere = $campoWhere." = ".$valor;
                }
            }
            
//            if ($_GET['tabla'] == "CLIENTES") {
//                //file_put_contents("loadselect0.txt", "GET['tabla']==> ".$_GET['tabla']."   table===>".$table);
//                file_put_contents("loadselect.txt", "SELECT ".$campo.", ".$campoBase." ".$campo2." ".$campo3." FROM ".$table." WHERE ".$campoWhere.$campoWhere2.$criteria." ORDER BY ".$ordenCampo.$orden);
//            }
            // file_put_contents("loadselect.txt", "SELECT ".$campo.", ".$campoBase." ".$campo2." ".$campo3." FROM ".$table." WHERE ".$campoWhere.$campoWhere2.$criteria." ORDER BY ".$ordenCampo.$orden);
            // file_put_contents("loadselect.txt", $_GET['orden']);
            $stmt = $db_con->prepare("SELECT ".$campo.", ".$campoBase." ".$campo2." ".$campo3." FROM ".$table." WHERE ".$campoWhere.$campoWhere2.$criteria." ORDER BY ".$ordenCampo.$orden);
             
        }
        
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
