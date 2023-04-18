<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT'];
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
        $stmt = $db_con->prepare("SELECT tools_roles.id roleid, tools_apps.id appid, tools_apps.nombre_html, tools_roles.nombre FROM tools_roles, tools_apps, tools_roles_apps WHERE tools_roles.id = tools_roles_apps.role_id AND tools_apps.id = tools_roles_apps.app_id AND role_id = ".$id);
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
