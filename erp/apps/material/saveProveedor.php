
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
        
        $sql = "UPDATE PROVEEDORES SET 
                        nombre = '".$_POST['newproveedor_nombre']."', 
                        direccion = '".$_POST['newproveedor_direccion']."', 
                        poblacion = '".$_POST['newproveedor_poblacion']."', 
                        provincia = '".$_POST['newproveedor_provincia']."', 
                        cp = '".$_POST['newproveedor_cp']."', 
                        pais = '".$_POST['newproveedor_pais']."', 
                        telefono = '".$_POST['newproveedor_telefono']."', 
                        descripcion = '".$_POST['newproveedor_desc']."', 
                        dto = ".$_POST['newproveedor_dto'].", 
                        email = '".$_POST['newproveedor_email']."', 
                        web = '".$_POST['newproveedor_web']."',
                        CIF = '".$_POST['newproveedor_CIF']."' 
                    WHERE id =".$_POST['newproveedor_idproveedor'];
        //file_put_contents("updateProveedor.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Proveedor");
    }
    
    function insertProveedor () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
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
                            dto,
                            email,
                            web) 
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
                            ".$_POST['newproveedor_dto'].", 
                            '".$_POST['newproveedor_email']."', 
                            '".$_POST['newproveedor_web']."' 
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
	