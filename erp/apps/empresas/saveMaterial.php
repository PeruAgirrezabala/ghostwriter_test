
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['material_del'] != "") {
        deleteMaterial();
    }
    else {
        if ($_POST['newmaterial_idmaterial'] != "") {
            updateMaterial();
        }  
        else {
            insertMaterial();
        }
    }
    
    function updateMaterial () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE MATERIALES SET 
                        ref = '".$_POST['newmaterial_ref']."',
                        nombre = '".$_POST['newmaterial_nombre']."', 
                        fabricante = '".$_POST['newmaterial_fabricante']."', 
                        modelo = '".$_POST['newmaterial_modelo']."', 
                        DTO2 = '".$_POST['newmaterial_dto']."', 
                        stock = '".$_POST['newmaterial_stock']."', 
                        descripcion = '".$_POST['newmaterial_desc']."', 
                        categoria_id = ".$_POST['material_categoria_id']." 
                    WHERE id =".$_POST['newmaterial_idmaterial'];
        //file_put_contents("updateMat.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
    }
    
    function insertMaterial () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO MATERIALES 
                            (ref,
                            nombre,
                            fabricante,
                            modelo,
                            DTO2,
                            stock,
                            descripcion,
                            categoria_id)
                       VALUES (
                            '".$_POST['newmaterial_ref']."',  
                            '".$_POST['newmaterial_nombre']."',  
                            '".$_POST['newmaterial_fabricante']."', 
                            '".$_POST['newmaterial_modelo']."', 
                            ".$_POST['newmaterial_dto'].",  
                            ".$_POST['newmaterial_stock'].", 
                            '".$_POST['newmaterial_desc']."',  
                            ".$_POST['material_categoria_id']." 
                        )";
        //file_put_contents("insertMat.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
        //LAST_INSERT_ID()
        $sql = "INSERT INTO MATERIALES_PRECIOS (material_id, fecha_val, pvp) VALUES (LAST_INSERT_ID(), '0000-00-00', ".$_POST['newmaterial_lastprice'].")";

        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
    }
    
    function deleteMaterial () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM MATERIALES_PRECIOS WHERE material_id=".$_POST['material_del'];
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Precios del Material");
        
        $sql = "DELETE FROM MATERIALES WHERE id=".$_POST['material_del'];
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Material");
    }
?>
	