<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "SELECT CALIDAD_SISTEMA.habilitado FROM CALIDAD_SISTEMA WHERE CALIDAD_SISTEMA.id=".$_POST['calsis_id'].";";
    $result = mysqli_query($connString, $sql) or die("Error al Seleccionar CALIDAD_SISTEMA");
    $registros = mysqli_fetch_row($result);
    $registros[0];
    
    if($registros[0]=="on"){
        $habilitado="off";
    }else{
        $habilitado="on";
    }
    
    $sql = "UPDATE CALIDAD_SISTEMA 
                SET habilitado = '".$habilitado."' 
                WHERE id = ".$_POST['calsis_id'];
    file_put_contents("updateHabilitado.txt", $sql);
    //mysqli_set_charset($connString, "utf8");
    echo $result = mysqli_query($connString, $sql) or die("Error al actualizar Habilitado");
    
?>

