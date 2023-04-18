
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

    if ($_POST['newregistro_delreg'] != "") {
        deleteReg();
    }
    else {
        if ($_POST['newregistro_idreg'] != "") {
            updateReg();
        }  
        else {
            insertReg();
        }
    }
    
    
    function updateReg () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE EMPRESAS_REGISTROS SET 
                        plataforma = '".$_POST['newregistro_plataforma']."', 
                        usuario = '".$_POST['newregistro_usuario']."', 
                        password = '".$_POST['newregistro_pass']."',
                        descripcion = '".$_POST['newregistro_desc']."',
                        empresa_id = ".$_POST['newregistro_empresa']."
                    WHERE id =".$_POST['newregistro_idreg'];
        file_put_contents("updateRegistro.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Registro");
    }
        
    function insertReg () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO EMPRESAS_REGISTROS 
                            (plataforma,
                            usuario,
                            password,
                            descripcion,
                            empresa_id) 
                       VALUES (
                            '".$_POST['newregistro_plataforma']."', 
                            '".$_POST['newregistro_usuario']."', 
                            '".$_POST['newregistro_pass']."',
                            '".$_POST['newregistro_desc']."',
                            ".$_POST['newregistro_empresa']."
                        )";
        file_put_contents("insertRegistro.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Registro");
    }
    
    function deleteReg () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM EMPRESAS_REGISTROS WHERE id = ".$_POST['newregistro_delreg'];
        file_put_contents("delRegistro.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Registro");
    }
   
?>
	