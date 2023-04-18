
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
      
    if($_GET["idmat"]==''){
        $and='';
    }else{
        $and=' AND NOT MATERIALES.id='.$_GET["idmat"];
    }
    
    $sql = "SELECT MATERIALES.ref
                FROM
                MATERIALES
                WHERE
                MATERIALES.ref='".$_GET["textonuevo"]."'".$and;
    file_put_contents("buscarREF.txt", $sql);
    $result = mysqli_query($connString, $sql) or die("Error al buscar referencia del Material");
    $rowcount=mysqli_num_rows($result);
    
    if($rowcount>=1){
        echo 1;
    }else{
        echo 0;
    }
    
?>
	