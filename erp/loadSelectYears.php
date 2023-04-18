<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");
    
if(isset($_GET['tabla'])) {    
    try
    { 
        $campo = $_GET['campo'];
        $table = $_GET['tabla'];
        $stmt = $db_con->prepare("SELECT distinct year(".$campo.") as year FROM ".$table." ORDER BY year DESC");
        $stmt->execute(array(":valor"=>valor));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        
            $json=json_encode($result);
            
            echo $json;
        
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
} //if isset btn_login



?>
