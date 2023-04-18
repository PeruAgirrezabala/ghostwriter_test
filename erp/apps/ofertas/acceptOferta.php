
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['accept_id'] != "") {
        aceptarOferta();
    }elseif($_POST['thisid'] != "") {
        checkThisAceptado();
    }else{
        checkAceptado();
    }
    function aceptarOferta(){
        $db = new dbObj();
        $connString =  $db->getConnstring();

        $id=$_POST["accept_id"];

        $sqlUpdate="UPDATE OFERTAS SET estado_id = 4 WHERE id =".$id;
        $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar Oferta");
        
        
        // TO-DO MORE!
    }
    
    function checkAceptado(){
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
        
        $sqlCheck2="SELECT * FROM OFERTAS WHERE (OFERTAS.0_ver=".$idpadre." OR OFERTAS.id=".$idpadre.") AND OFERTAS.estado_id=4";
        //file_put_contents("log2.txt", $sqlCheck2);
        $resCheck2 = mysqli_query($connString, $sqlCheck2) or die("Error al ejecutar la consulta de Aceptado1");
        $num = mysqli_num_rows($resCheck2);
        //file_put_contents("log3.txt", $num);
        if($num>0){ // Hay un aceptado
            echo 1;
        }else{
            echo 0;
        }
    }
    
    function checkThisAceptado(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $id=$_POST["thisid"];
        
        $sqlCheck = "SELECT OFERTAS.estado_id FROM OFERTAS WHERE OFERTAS.id=".$id;
        //file_put_contents("log00.txt", $sqlCheck);
        $resCheck = mysqli_query($connString, $sqlCheck) or die("Error al ejecutar la consulta de This Aceptado");
        $regCheck = mysqli_fetch_row ($resCheck);
        
        if($regCheck[0]==4){
            echo 1;
        }else{
            echo 0;
        }
    }
    
?>
	