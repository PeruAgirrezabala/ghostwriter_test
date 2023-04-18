
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['proveedor_del'] != "") {
        deleteProveedor();
    }
    else {
        if ($_POST['newproveedor_idproveedor'] != "") {
            updateProveedor();
        }  
        else {
            insertProveedor();
        }
    }
    
    function updateProveedor () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['newproveedor_chkhomo'] == true) {
            $homologado = "1";
        }
        else {
            $homologado = "0";
        }
        
        // Quitar caracteres que puedan dar problemas
        $newproveedor_email = str_replace("<", "", $_POST['newproveedor_email']);
        $newproveedor_email = str_replace(">", "", $newproveedor_email);
        
        $newproveedor_email_pedidos = str_replace("<", "", $_POST['newproveedor_email_pedidos']);
        $newproveedor_email_pedidos = str_replace(">", "", $newproveedor_email_pedidos);
        
        $sql = "UPDATE PROVEEDORES SET 
                        nombre = '".$_POST['newproveedor_nombre']."', 
                        direccion = '".$_POST['newproveedor_direccion']."', 
                        poblacion = '".$_POST['newproveedor_poblacion']."', 
                        provincia = '".$_POST['newproveedor_provincia']."', 
                        cp = '".$_POST['newproveedor_cp']."', 
                        pais = '".$_POST['newproveedor_pais']."', 
                        telefono = '".$_POST['newproveedor_telefono']."', 
                        descripcion = '".$_POST['newproveedor_desc']."', 
                        email = '".$newproveedor_email."', 
                        contacto = '".$_POST['newproveedor_contacto']."', 
                        email_pedidos = '".$newproveedor_email_pedidos."', 
                        web = '".$_POST['newproveedor_web']."',
                        formaPago = '".$_POST['newproveedor_formapago']."',
                        CIF = '".$_POST['newproveedor_CIF']."',
                        homologado = ".$homologado.",
                        fecha_aprob = '".$_POST['newproveedor_fecha_aprob']."',
                        plataforma = '".$_POST['newproveedor_urlPLAT']."',
                        usuario = '".$_POST['newproveedor_urlPLAT_U']."',
                        password = '".$_POST['newproveedor_urlPLAT_P']."'
                    WHERE id =".$_POST['newproveedor_idproveedor'];
        file_put_contents("updateProveedor.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Proveedor");
    }
    
    function insertProveedor () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['newproveedor_chkhomo'] == true) {
            $homologado = "1";
        }
        else {
            $homologado = "0";
        }
        
        // Quitar caracteres que puedan dar problemas
        $newproveedor_email = str_replace("<", "", $_POST['newproveedor_email']);
        $newproveedor_email = str_replace(">", "", $newproveedor_email);
        
        $newproveedor_email_pedidos = str_replace("<", "", $_POST['newproveedor_email_pedidos']);
        $newproveedor_email_pedidos = str_replace(">", "", $newproveedor_email_pedidos);
        
        $sql = "INSERT INTO PROVEEDORES 
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
                            contacto,
                            email_pedidos,
                            web,
                            formaPago,
                            homologado,
                            fecha_aprob,
                            plataforma,
                            usuario,
                            password) 
                       VALUES (
                            '".$_POST['newproveedor_nombre']."', 
                            '".$_POST['newproveedor_CIF']."', 
                            '".$_POST['newproveedor_direccion']."', 
                            '".$_POST['newproveedor_poblacion']."', 
                            '".$_POST['newproveedor_provincia']."',  
                            '".$_POST['newproveedor_cp']."', 
                            '".$_POST['newproveedor_pais']."', 
                            '".$_POST['newproveedor_telefono']."',  
                            '".$_POST['newproveedor_desc']."', 
                            '".$newproveedor_email."', 
                            '".$_POST['newproveedor_contacto']."',
                            '".$newproveedor_email_pedidos."',
                            '".$_POST['newproveedor_web']."', 
                            '".$_POST['newproveedor_formaPago']."',
                            ".$homologado.",
                            '".$_POST['newproveedor_fecha_aprob']."',
                            '".$_POST['newproveedor_urlPLAT']."',
                            '".$_POST['newproveedor_urlPLAT_U']."',
                            '".$_POST['newproveedor_urlPLAT_P']."'
                        )";
        //file_put_contents("insertProveedor.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Proveedor");
    }
    
    function deleteProveedor () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM PROVEEDORES WHERE id=".$_POST['proveedor_del'];

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Proveedor");
    }
?>
	