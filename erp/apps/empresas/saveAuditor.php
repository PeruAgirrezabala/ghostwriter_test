
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['auditor_del'] != "") {
        deleteAuditor();
    }
    else {
        if ($_POST['newauditor_idauditor'] != "") {
            updateAuditor();
        }  
        else {
            insertAuditor();
        }
    }
    
    function updateAuditor () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE AUDITORES SET 
                        nombre = '".$_POST['newauditor_nombre']."', 
                        direccion = '".$_POST['newauditor_direccion']."', 
                        poblacion = '".$_POST['newauditor_poblacion']."', 
                        provincia = '".$_POST['newauditor_provincia']."', 
                        cp = '".$_POST['newauditor_cp']."', 
                        pais = '".$_POST['newauditor_pais']."', 
                        telefono = '".$_POST['newauditor_telefono']."', 
                        descripcion = '".$_POST['newauditor_desc']."', 
                        email = '".$_POST['newauditor_email']."', 
                        fax = '".$_POST['newauditor_fax']."', 
                        contacto = '".$_POST['newauditor_contacto']."', 
                        web = '".$_POST['newauditor_web']."',
                        CIF = '".$_POST['newauditor_CIF']."',
                        fecha_aprob = '".$_POST['newauditor_fecha_aprob']."',
                        plataforma = '".$_POST['newauditor_urlPLAT']."',
                        usuario = '".$_POST['newauditor_urlPLAT_U']."',
                        password = '".$_POST['newauditor_urlPLAT_P']."'
                    WHERE id =".$_POST['newauditor_idauditor'];
        file_put_contents("updateAuditor.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Auditor");
    }
    
    function insertAuditor () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO AUDITORES 
                            (nombre,
                            CIF,
                            direccion,
                            poblacion,
                            provincia,
                            cp,
                            pais,
                            telefono,
                            descripcion,
                            email,
                            fax,
                            contacto,
                            web,
                            fecha_aprob,
                            plataforma,
                            usuario,
                            password) 
                       VALUES (
                            '".$_POST['newauditor_nombre']."', 
                            '".$_POST['newauditor_CIF']."', 
                            '".$_POST['newauditor_direccion']."', 
                            '".$_POST['newauditor_poblacion']."', 
                            '".$_POST['newauditor_provincia']."',  
                            '".$_POST['newauditor_cp']."', 
                            '".$_POST['newauditor_pais']."', 
                            '".$_POST['newauditor_telefono']."',  
                            '".$_POST['newauditor_desc']."', 
                            '".$_POST['newauditor_email']."', 
                            '".$_POST['newauditor_fax']."', 
                            '".$_POST['newauditor_contacto']."',
                            '".$_POST['newauditor_web']."', 
                            '".$_POST['newauditor_fecha_aprob']."',
                            '".$_POST['newauditor_urlPLAT']."',
                            '".$_POST['newauditor_urlPLAT_U']."',
                            '".$_POST['newauditor_urlPLAT_P']."'
                        )";
        file_put_contents("insertAuditor.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Auditor");
    }
   
   

    function deleteAuditor () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM AUDITORES WHERE id=".$_POST['auditor_del'];

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Auditor");
    }
?>
	