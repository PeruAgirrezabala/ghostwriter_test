
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $datos_old=file_get_contents('awsDel.txt');
    
    $datos = $datos . " \r\n aws glacier delete-archive --vault-name Genelek_Sistemas_Backup --account-id 404923956885 --archive-id " . $_POST['id'];
    
    file_put_contents("awsDel.txt", $datos);
    
?>
	