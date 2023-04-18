
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['newcontactoCLI_id'] != "" && $_POST["newcontactoCLI_id_update"] == "") {
        insertContactoCLI();
    }
    else {
        if($_POST["remove_contacto_cli"] != ""){
            deleteContactoCLI();
        }else{
            if($_POST["newcontactoCLI_id_update"] != ""){
                updateContactoCLI();
            }else{
                
            }
        }
    }
    
    function updateContactoCLI () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CLIENTES_CONTACTOS SET 
                        nombre = '".$_POST['newcontactoCLI_nombre']."', 
                        mail = '".$_POST['newcontactoCLI_mail']."', 
                        telefono = '".$_POST['newcontactoCLI_telefono']."', 
                        descripcion = '".$_POST['newcontactoCLI_desc']."', 
                        activo = '".$_POST['txt_activo']."', 
                        cliente_id = ".$_POST['newcontactoCLI_id'].",
                        instalacion_cliente_id = ".$_POST['newcontactoCLI_instalacion']."    
                    WHERE id =".$_POST['newcontactoCLI_id_update'];
        file_put_contents("updateContactoCLI.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento Contratista");
    }
    
    function insertContactoCLI () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO CLIENTES_CONTACTOS 
                            (nombre,
                            telefono,
                            mail,
                            descripcion,
                            activo,
                            cliente_id,
                            instalacion_cliente_id) 
                       VALUES (
                            '".$_POST['newcontactoCLI_nombre']."', 
                            '".$_POST['newcontactoCLI_telefono']."', 
                            '".$_POST['newcontactoCLI_mail']."', 
                            '".$_POST['newcontactoCLI_desc']."', 
                            '".$_POST['txt_activo']."',
                            ".$_POST['newcontactoCLI_id'].",
                            ".$_POST['newcontactoCLI_instalacion'].")";
        file_put_contents("insertContactoCLI.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al añadir el Contacto Cliente");
    }
    
    function deleteContactoCLI () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CLIENTES_CONTACTOS WHERE CLIENTES_CONTACTOS.id = ".$_POST['id_contacto_cli'];
        file_put_contents("delContactoCLI.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Contacto Contratista");
    }
?>
	