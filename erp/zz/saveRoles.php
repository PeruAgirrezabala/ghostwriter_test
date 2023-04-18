
<?php
    //include connection file 
    include_once("connection.php");

    

    $params = $_REQUEST;

    if ($params["accesosroles_roles"] != "") {
        updateRole($params);
    }
    else {
        insertRole($params);
    }
    
    if (($params["accesosroles_delrole"] != "") && ($params["accesosroles_roles"] != "")) {
        deleteRole($params);
    }
    
    
    function insertRole($params) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        $sql = "INSERT INTO tools_roles (nombre) VALUES ('".$params["accesosroles_edit_nombre"]."')";

        echo $result = mysqli_query($connString, $sql) or die("Error al guardar un nuevo Role");

    }

    function updateRole($params) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        $sql = "UPDATE tools_roles SET nombre = '" . $params["accesosroles_edit_nombre"] . "' WHERE id=".$params["accesosroles_roles"];

        $result = mysqli_query($connString, $sql) or die("Error al actualizar el Role");
        
        $sql = "DELETE FROM tools_roles_apps WHERE role_id =".$params["accesosroles_roles"];
        $result = mysqli_query($connString, $sql) or die("Error al actualizar el Role");
        
        if ($params["app_bitly_id"] != "") {
            $sql = "INSERT INTO tools_roles_apps (role_id, app_id) VALUES (".$params["accesosroles_roles"].",".$params["app_bitly_id"].")";
            $result = mysqli_query($connString, $sql) or die("Error al actualizar el Role");
        }
        if ($params["app_boolean_id"] != "") {
            $sql = "INSERT INTO tools_roles_apps (role_id, app_id) VALUES (".$params["accesosroles_roles"].",".$params["app_boolean_id"].")";
            $result = mysqli_query($connString, $sql) or die("Error al actualizar el Role");
        }
        if ($params["app_crm_id"] != "") {
            $sql = "INSERT INTO tools_roles_apps (role_id, app_id) VALUES (".$params["accesosroles_roles"].",".$params["app_crm_id"].")";
            $result = mysqli_query($connString, $sql) or die("Error al actualizar el Role");
        }
        if ($params["app_eventos_id"] != "") {
            $sql = "INSERT INTO tools_roles_apps (role_id, app_id) VALUES (".$params["accesosroles_roles"].",".$params["app_eventos_id"].")";
            $result = mysqli_query($connString, $sql) or die("Error al actualizar el Role");
        }
        if ($params["app_juntador_id"] != "") {
            $sql = "INSERT INTO tools_roles_apps (role_id, app_id) VALUES (".$params["accesosroles_roles"].",".$params["app_juntador_id"].")";
            $result = mysqli_query($connString, $sql) or die("Error al actualizar el Role");
        }
        if ($params["app_tracking_id"] != "") {
            $sql = "INSERT INTO tools_roles_apps (role_id, app_id) VALUES (".$params["accesosroles_roles"].",".$params["app_tracking_id"].")";
            $result = mysqli_query($connString, $sql) or die("Error al actualizar el Role");
        }
        echo $result;
    }

    function deleteRole($params) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        $sql = "delete from tools_roles WHERE id='".$params["accesosroles_roles"]."'";

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Role");
    }
?>
	