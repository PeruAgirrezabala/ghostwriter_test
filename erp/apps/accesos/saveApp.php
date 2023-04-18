
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

    if ($_POST['app_delapp'] != "") {
        deleteApp();
    }
    else {
        if ($_POST['app_id'] != "") {
            insertApp();
        }
    }
    
    function insertApp () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_POST['app_id'] == "all") {
            $sql = "DELETE FROM erp_roles_apps WHERE role_id = ".$_POST['role_id'];
            $res = mysqli_query($connString, $sql) or die("Error al eliminar los Permisos del Role");
            
            $sql = "INSERT INTO erp_roles_apps 
                        (role_id,
                        app_id)
                    SELECT                         
                        ".$_POST['role_id'].",
                        id
                    FROM
                        erp_apps 
                    ORDER BY id ASC
                    ";
            echo $result = mysqli_query($connString, $sql) or die("Error al guardar la App");
        }
            else {
            $sql = "SELECT id FROM erp_roles_apps WHERE role_id = ".$_POST['role_id']." AND app_id = ".$_POST['app_id'];
            file_put_contents("queryPermiso.txt", $sql);
            $res = mysqli_query($connString, $sql) or die("Error al seleccionar el Permiso");
            $numrows = mysqli_num_rows($res);

            if ($numrows == 0) {
                $sql = "INSERT INTO erp_roles_apps 
                                    (role_id,
                                    app_id)
                               VALUES (
                                    ".$_POST['role_id'].", 
                                    ".$_POST['app_id']."
                                )";
                file_put_contents("insertApp.txt", $sql);
                echo $result = mysqli_query($connString, $sql) or die("Error al guardar la App");
            }
        }
        echo -1;
    }
    
    function deleteApp () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM erp_roles_apps WHERE id = ".$_POST['app_delapp'];
        file_put_contents("delApp.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la App");
    }
   
?>
	