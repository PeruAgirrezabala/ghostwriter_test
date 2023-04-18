
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

        if ($_POST['newlicencia_idlic'] != "") {
            updateLicencia();
        }  
        else {
            if ($_POST['unlocklic_id'] != "") {
                unlockLicencia();
            }
            else {
                if($_POST['vaciar_lic'] != ""){
                    vaciarLicencia();
                }else{
                    insertLicencia();
                }
            }
        }
    
    function updateLicencia () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['newlicencia_activada'] == true) {
            $activada = 1;
        }
        else {
            $activada = 0;
        }
        if ($_POST['newlicencia_users'] != "") {
            $userid = ", user_id = ".$_POST['newlicencia_users'];
        }
        else {
            $userid = "";
        }
        if ($_POST['newlicencia_proyectos'] != "") {
            $proyectoid = ", proyecto_id = ".$_POST['newlicencia_proyectos'];
        }
        else {
            $proyectoid = "";
        }
        $sql = "UPDATE LICENCIAS SET 
                        nombre = '".$_POST['newlicencia_nombre']."', 
                        ubicacion = '".$_POST['newlicencia_ubicacion']."', 
                        fecha = '".$_POST['newlicencia_fecha']."',
                        activada = ".$activada."
                        ".$proyectoid."
                        ".$userid."
                    WHERE id =".$_POST['newlicencia_idlic'];
        file_put_contents("updateLicencia.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Licencia");
    }
    
    function unlockLicencia () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE LICENCIAS SET
                        activada = 0
                    WHERE id =".$_POST['unlocklic_id'];
        file_put_contents("unlockLicencia.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al liberar la Licencia");
    }
    
    function insertLicencia () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['newlicencia_activada'] == true) {
            $activada = 1;
        }
        else {
            $activada = 0;
        }
        
        $sql = "INSERT INTO LICENCIAS 
                            (nombre,
                            ubicacion,
                            user_id,
                            fecha,
                            activada) 
                       VALUES (
                            '".$_POST['newlicencia_nombre']."', 
                            '".$_POST['newlicencia_ubicacion']."', 
                            ".$_POST['newlicencia_users'].", 
                            '".$_POST['newlicencia_fecha']."', 
                            ".$activada."
                        )";
        file_put_contents("insertLicencia.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Licencia");
    }
    function vaciarLicencia(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE LICENCIAS SET 
                        ubicacion = '', 
                        fecha = '0000-00-00',
                        activada = 0,
                        proyecto_id = null,
                        user_id = null
                    WHERE id =".$_POST['vaciar_lic'];
        file_put_contents("vaciarLicencia.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al vaciar la Licencia");
    }
   
?>
	