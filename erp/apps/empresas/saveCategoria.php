
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['categoria_del'] != "") {
        //deleteCategoria();
    }
    else {
        if ($_POST['newcategoria_idcategoria'] != "") {
            updateCategoria();
        }  
        else {
            insertCategoria();
        }
    }
    
    
    
    function updateCategoria () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['categorias_categoriasparent'] != "") {
            $sql = "UPDATE MATERIALES_CATEGORIAS SET 
                        nombre = '".$_POST['categorias_nombre']."', 
                        parent_id = ".$_POST['categorias_categoriasparent']." 
                    WHERE id =".$_POST['categorias_idcategoria'];
        }
        else {
            $sql = "UPDATE MATERIALES_CATEGORIAS SET 
                        nombre = '".$_POST['categorias_nombre']."', 
                        parent_id = 0
                    WHERE id =".$_POST['newcategoria_idcategoria'];
        }
        
        //file_put_contents("updateCat.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
    }
    
    function insertCategoria () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['categorias_categoriasparent'] != "") {
            $sql = "INSERT INTO MATERIALES_CATEGORIAS 
                            (nombre,
                            parent_id)
                       VALUES (
                            '".$_POST['categorias_nombre']."',  
                            ".$_POST['categorias_categoriasparent']." 
                        )";
        }
        else {
            $sql = "INSERT INTO MATERIALES_CATEGORIAS 
                            (nombre,
                            parent_id)
                       VALUES (
                            '".$_POST['categorias_nombre']."',  
                            0 
                        )";
        }
        
        //file_put_contents("insertCat.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
    }
   
   

    function deleteCategoria () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM MATERIALES_CATEGORIAS WHERE parent_id=".$_POST['categoria_del'];
        $result = mysqli_query($connString, $sql) or die("Error al eliminar la Categoria");
        
        $sql = "DELETE FROM MATERIALES_CATEGORIAS WHERE id=".$_POST['categoria_del'];
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Categoria");
    }
?>
	