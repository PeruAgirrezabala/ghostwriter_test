
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
        

    $sql = "UPDATE PEDIDOS_PROV SET 
                com_interno = '".$_POST['view_com_inter']."'
            WHERE id =".$_POST['prov_det_id'];
    
    file_put_contents("logUpdateComentarioInterno.txt", $sql);
    echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Comentario Interno");
    
?>
	