<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    try
    { 
        $campo = $_GET['campoWhere'];
        $valor = $_GET['valor'];
        $prev_id = $_GET['valor2'];
        
        $sql = "SELECT EXISTS(SELECT * FROM PREVISIONES_INSTALACIONES WHERE prevision_id =".$prev_id.")";
        file_put_contents("selectClientesInstalaciones0.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de PREVISIONES_INSTALACIONES 0");    
        $registros = mysqli_fetch_array($resultado);
        
        
        if($registros[0]>=1){
            $sql = "SELECT * FROM PREVISIONES_INSTALACIONES WHERE prevision_id =".$prev_id;
            file_put_contents("selectClientesInstalaciones1.txt", $sql);
            $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de PREVISIONES_INSTALACIONES 1");    
            $registros = mysqli_fetch_array($resultado);
            
            $stmt = $db_con->prepare("SELECT CLIENTES_INSTALACIONES.id, CLIENTES_INSTALACIONES.cliente_id, CLIENTES_INSTALACIONES.nombre, CLIENTES_INSTALACIONES.direccion FROM CLIENTES_INSTALACIONES WHERE CLIENTES_INSTALACIONES.cliente_id = ".$valor." ORDER BY CLIENTES_INSTALACIONES.id = ".$registros[2]." DESC");
            $stmt->execute(array(":valor"=>valor));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } else{
            $stmt = $db_con->prepare("SELECT CLIENTES_INSTALACIONES.id, CLIENTES_INSTALACIONES.cliente_id, CLIENTES_INSTALACIONES.nombre, CLIENTES_INSTALACIONES.direccion FROM CLIENTES_INSTALACIONES WHERE CLIENTES_INSTALACIONES.cliente_id = ".$valor);
            $stmt->execute(array(":valor"=>valor));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }
        
        
        $count = $stmt->rowCount();
        
            $json=json_encode($result);
            
            echo $json;
        
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }



?>
