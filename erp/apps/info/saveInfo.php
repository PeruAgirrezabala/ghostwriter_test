
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");


    if ($_POST['info_edit_idempresa'] != "") {
        updateInfo();
    }  
    else {
        //insertInfo();
    }
    
    
    
    function updateInfo () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE EMPRESAS SET 
                        nombre = '".$_POST['info_edit_nombre']."', 
                        direccion = '".$_POST['info_edit_direccion']."', 
                        cp = ".$_POST['info_edit_cp'].",
                        poblacion = '".$_POST['info_edit_poblacion']."',
                        provincia = '".$_POST['info_edit_provincia']."',
                        pais = '".$_POST['info_edit_pais']."',
                        telefono = '".$_POST['info_edit_tlfno']."',
                        web = '".$_POST['info_edit_web']."',
                        email = '".$_POST['info_edit_email']."',
                        CIF = '".$_POST['info_edit_nif1']."',
                        CIF2 = '".$_POST['info_edit_nif2']."',
                        IAE1 = '".$_POST['info_edit_iae1']."',
                        IAE2 = '".$_POST['info_edit_iae2']."',
                        CNAE1 = '".$_POST['info_edit_cnae1']."',
                        CNAE2 = '".$_POST['info_edit_cnae2']."',
                        horas_convenio = ".$_POST['info_horas_convenio'].",
                        vacaciones_ano = ".$_POST['info_vacaciones_ano']."
                    WHERE id =".$_POST['info_edit_idempresa'];
        file_put_contents("updateInfo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Información");
    }
        
    function insertInfo () {
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
	