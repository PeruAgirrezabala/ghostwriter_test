
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['idcalendariojornada'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        updateProyectoJornada();
    }


    function updateProyectoJornada() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
//        $sqlSel="SELECT jornada_id FROM JORNADAS_ACCESOS WHERE id=".$_POST['idaccesojornada'];
//        file_put_contents("log03.txt", $sqlSel);
//        $result = mysqli_query($connString, $sqlSel) or die("Error al seleccionar la jornada desde el acceso.");
//        $registros = mysqli_fetch_array($result);
        
        $sql = "UPDATE JORNADAS 
                SET proyecto_id = ".$_POST['proyectojornada_proyectos']."
                WHERE calendario_id =".$_POST["idcalendariojornada"]. "
                AND user_id=".$_POST["idtrabajadorjornada"];
        file_put_contents("updateProyectoJornada.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al actualizar el proyecto de la jornada");
    }
    
?>
	