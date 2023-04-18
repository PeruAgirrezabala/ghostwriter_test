
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

        if ($_POST['newPC_delid'] != "") {
            delPC();
        }  
        else {
            if ($_POST['newPC_idpc'] != "") {
                updatePC();
            }
            else {
                insertPC();
            }
        }
    
    function updatePC () {
        $db = new dbObj();
        $connString =  $db->getConnstring();

        if ($_POST['newPC_tecnicos'] != "") {
            $userid = ", erpuser_id = ".$_POST['newPC_tecnicos'];
        }
        else {
            $userid = "";
        }
        if ($_POST['newPC_proyectos'] != "") {
            $proyectoid = ", proyecto_id = ".$_POST['newPC_proyectos'];
        }
        else {
            $proyectoid = "";
        }
        if ($_POST['newPC_estados'] != "") {
            $estadoid = $_POST['newPC_estados'];
        }
        else {
            $estadoid = "null";
        }
        $sql = "UPDATE EQUIPOS_TALLER SET 
                        hostname = '".$_POST['newPC_hostname']."', 
                        descripcion = '".$_POST['newPC_desc']."', 
                        fecha_inicio = '".$_POST['newPC_fecha_ini']."',
                        estado_id = ".$estadoid."
                        ".$proyectoid."
                        ".$userid."
                    WHERE id =".$_POST['newPC_idpc'];
        file_put_contents("updatePC.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la PC");
    }
    
    function delPC () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM EQUIPOS_TALLER WHERE id =".$_POST['newPC_delid'];
        file_put_contents("deletePC.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al elilminar el PC");
    }
    
    function insertPC () {
        $db = new dbObj();
        $connString =  $db->getConnstring();

        if ($_POST['newPC_tecnicos'] != "") {
            $userid = $_POST['newPC_tecnicos'];
        }
        else {
            $userid = "null";
        }
        if ($_POST['newPC_proyectos'] != "") {
            $proyectoid = $_POST['newPC_proyectos'];
        }
        else {
            $proyectoid = "null";
        }
        if ($_POST['newPC_estados'] != "") {
            $estadoid = $_POST['newPC_estados'];
        }
        else {
            $estadoid = "null";
        }
        
        $sql = "INSERT INTO EQUIPOS_TALLER 
                            (hostname,
                            proyecto_id,
                            descripcion,
                            fecha_inicio,
                            erpuser_id,
                            estado_id
                            ) 
                       VALUES (
                            '".$_POST['newPC_hostname']."', 
                            ".$proyectoid.",
                            '".$_POST['newPC_descripcion']."', 
                            '".$_POST['newPC_fecha_ini']."', 
                            ".$userid.",
                            ".$estadoid."
                        )";
        file_put_contents("insertPC.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el PC");
    }
   
?>
	