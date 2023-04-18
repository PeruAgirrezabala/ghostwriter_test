<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");
    
    try
    { 
        $campo = $_GET['campoWhere'];
        $valor = $_GET['valor'];
        $stmt = $db_con->prepare("SELECT erp_users.id, erp_users.nombre, erp_users.apellidos FROM PREVISIONES_TECNICOS, erp_users WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = ".$valor." ORDER BY erp_users.nombre ASC");
        $stmt->execute(array(":valor"=>valor));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        
            $json=json_encode($result);
            
            echo $json;
        
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }



?>
