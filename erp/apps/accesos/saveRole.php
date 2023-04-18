
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

    if ($_POST['newrole_delrole'] != "") {
        deleteRole();
    }
    else {
        if ($_POST['newrole_idrole'] != "") {
            updateRole();
        }  
        else {
            insertRole();
        }
    }
    
    
    function updateRole () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE erp_roles SET 
                        nombre = '".$_POST['newrole_nombre']."'  
                    WHERE id =".$_POST['newrole_idrole'];
        file_put_contents("updateRole.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Role");
    }
        
    function insertRole () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO erp_roles 
                            (nombre)
                       VALUES (
                            '".$_POST['newrole_nombre']."' 
                        )";
        file_put_contents("insertRole.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Role");
    }
    
    function deleteRole () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM erp_roles WHERE id = ".$_POST['newrole_delrole'];
        file_put_contents("delRole.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Role");
    }
   
?>
	