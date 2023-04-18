<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql="SELECT * FROM PEDIDOS_PROV_DETALLES WHERE pedido_id=".$_POST['id'];
    $result = mysqli_query($connString, $sql);
    $row_count = mysqli_num_rows($result);
    
    echo $row_count;
    
    
?>

