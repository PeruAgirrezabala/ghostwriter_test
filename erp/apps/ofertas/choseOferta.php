
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $id=$_POST["id"];
        
    $sqlCheck = "SELECT OFERTAS.0_ver FROM OFERTAS WHERE OFERTAS.id=".$id;
    //file_put_contents("log0.txt", $sqlCheck);
    $resCheck = mysqli_query($connString, $sqlCheck) or die("Error al ejecutar la consulta de Aceptado0");
    $regCheck = mysqli_fetch_row ($resCheck);
       
    if($regCheck[0]==0){
        $idpadre=$id;
    }else{
        $idpadre=$regCheck[0];
    }
        
    $sqlCheck2="SELECT OFERTAS.id FROM OFERTAS WHERE (OFERTAS.0_ver=".$idpadre." OR OFERTAS.id=".$idpadre.") AND OFERTAS.estado_id=4";
    //file_put_contents("log2.txt", $sqlCheck2);
    $resCheck2 = mysqli_query($connString, $sqlCheck2) or die("Error al ejecutar la consulta de Aceptado1");
    $regCheck2 = mysqli_fetch_row ($resCheck2);
    $num = mysqli_num_rows($resCheck2);
    //file_put_contents("log3.txt", $num);
    if($num>0){ // Hay un aceptado
        echo $regCheck2[0];
    }else{
        echo $id;
    }
?>
	