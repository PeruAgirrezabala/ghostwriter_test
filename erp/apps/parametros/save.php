
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

    // PERFILES
    if ($_POST['newperfil_del'] != "") {
        deletePerfil();
    }
    else {
        if ($_POST['newperfil_id'] != "") {
            updatePerfil();
        }  
        else {
            if ($_POST['newperfil_nombre'] != "") {
                insertPerfil();
            }
        }
    }
    // CATEGORIAS
    if ($_POST['newCat_del'] != "") {   
        deleteCat();
    }
    else {
        if ($_POST['newCat_id'] != "") {
            updateCat();
        }  
        else {
            if ($_POST['newCat_nombre'] != "") {
                insertCat();
            }
        }
    }
    // TAREAS
    if ($_POST['newtarea_del'] != "") {
        deleteTarea();
    }
    else {
        if ($_POST['newtarea_id'] != "") {
            updateTarea();
        }  
        else {
            if ($_POST['newtarea_nombre'] != "") {
                insertTarea();
            }
        }
    }
    // HORAS
    if ($_POST['newhora_del'] != "") {
        deleteHora();
    }
    else {
        if ($_POST['newhora_id'] != "") {
            updateHora();
        }  
        else {
            if ($_POST['newhora_nombre'] != "") {
                insertHora();
            }
        }
    }
    // TIPOS HORA
    if ($_POST['newtipohora_del'] != "") {
        deleteTipoHora();
    }
    else {
        if ($_POST['newtipohora_id'] != "") {
            updateTipoHora();
        }  
        else {
            if ($_POST['newtipohora_nombre'] != "") {
                insertTipoHora();
            }
        }
    }
    
    // PERFILES
    function updatePerfil () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE PERFILES SET 
                        nombre = '".$_POST['newperfil_nombre']."' 
                    WHERE id =".$_POST['newperfil_id'];
        file_put_contents("updatePerfil.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Perfil");
    }
    function insertPerfil () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO PERFILES 
                            (nombre) 
                       VALUES (
                            '".$_POST['newperfil_nombre']."' 
                        )";
        file_put_contents("insertPerfil.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Perfil");
    }
    function deletePerfil () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM PERFILES WHERE id = ".$_POST['newperfil_del'];
        file_put_contents("delPerfil.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Perfil");
    }
    
    // CATEGORIAS
    function updateCat () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE ACTIVIDAD_CATEGORIAS SET 
                        nombre = '".$_POST['newCat_nombre']."' 
                    WHERE id =".$_POST['newCat_id'];
        file_put_contents("updateCat.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Categoría");
    }
    function insertCat () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO ACTIVIDAD_CATEGORIAS 
                            (nombre) 
                       VALUES (
                            '".$_POST['newCat_nombre']."' 
                        )";
        file_put_contents("insertCat.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Categoría");
    }
    function deleteCat () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM ACTIVIDAD_CATEGORIAS WHERE id = ".$_POST['newCat_del'];
        file_put_contents("delCat.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Categoría");
    }
    
    // TAREAS
    function updateTarea () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE TAREAS SET 
                        nombre = '".$_POST['newtarea_nombre']."',
                        descripcion = '".$_POST['newtarea_desc']."',
                        perfil_id = ".$_POST['newtarea_perfil']."
                    WHERE id =".$_POST['newtarea_id'];
        file_put_contents("updateTarea.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Tarea");
    }
    function insertTarea () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO TAREAS 
                            (nombre,
                            descripcion,
                            perfil_id) 
                       VALUES (
                            '".$_POST['newtarea_nombre']."',
                            '".$_POST['newtarea_desc']."',
                            ".$_POST['newtarea_perfil']."
                        )";
        file_put_contents("insertTarea.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Tarea");
    }
    function deleteTarea () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM TAREAS WHERE id = ".$_POST['newtarea_del'];
        file_put_contents("delTarea.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Tarea");
    }
    
    // HORAS
    function updateHora () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE PERFILES_HORAS SET 
                        nombre = '".$_POST['newhora_nombre']."',
                        precio = ".$_POST['newhora_tarifa'].",
                        perfil_id = ".$_POST['newhora_perfil'].",
                        precio_coste = ".$_POST['newhora_coste'].",
                        tipo_id = ".$_POST['newhora_tipo']."
                    WHERE id =".$_POST['newhora_id'];
        file_put_contents("updateHora.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Hora");
    }
    function insertHora () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO PERFILES_HORAS 
                            (nombre,
                            precio,
                            perfil_id,
                            precio_coste,
                            tipo_id) 
                       VALUES (
                            '".$_POST['newhora_nombre']."',
                            ".$_POST['newhora_tarifa'].",
                            ".$_POST['newhora_perfil'].",
                            ".$_POST['newhora_coste'].",
                            ".$_POST['newhora_tipo']."
                        )";
        file_put_contents("insertHora.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Hora");
    }
    function deleteHora () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM PERFILES_HORAS WHERE id = ".$_POST['newhora_del'];
        file_put_contents("delHora.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Hora");
    }
   
    // TIPOS HORA
    function updateTipoHora () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE TIPOS_HORA SET 
                        nombre = '".$_POST['newtipohora_nombre']."' 
                    WHERE id =".$_POST['newtipohora_id'];
        file_put_contents("updateTipoHora.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el TipoHora");
    }
    function insertTipoHora () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO TIPOS_HORA 
                            (nombre) 
                       VALUES (
                            '".$_POST['newtipohora_nombre']."' 
                        )";
        file_put_contents("insertTipoHora.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el TipoHora");
    }
    function deleteTipoHora () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM TIPOS_HORA WHERE id = ".$_POST['newtipohora_del'];
        file_put_contents("delTipoHora.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el TipoHora");
    }
?>
	