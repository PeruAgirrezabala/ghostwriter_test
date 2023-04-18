<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/live";
    require_once($pathraiz."/core/dbconfig.php");
    
if(isset($_GET['id'])) {
    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = iconv('ISO-8859-1', 'UTF-8', $item);;
            }
        });

        return $array;
    }

    /*
    if ($_SESSION['user_rol'] == "CLIENTE") {
        switch ($table) {
            case "tools_proyectos":
                $criteria = " cliente_id=".$_SESSION['user_session'];
                break;  
            case "tools_comerciales":
                $criteria = " cliente_id=".$_SESSION['user_session'];
                break;
        }
    }
    else {
        $criteria = "";
    }
    */
    
    try
    {

        $stmt = $db_con->prepare("SELECT num_jornada, DATE_FORMAT(start_datetime, '%Y-%m-%dT%H:%i') as start_datetime, DATE_FORMAT(end_datetime, '%Y-%m-%dT%H:%i') as end_datetime, estado  
                              FROM tenis_jornadas 
                              WHERE id = ".$_GET['id']."
                              ORDER BY tenis_jornadas.num_jornada ASC");

        $stmt->execute(array(":valor"=>$valor));
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
