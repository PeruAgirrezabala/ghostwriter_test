<?php
    //include connection file 
    include_once("connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    if ($_POST['accion'] == "add") {
        $sql = "SELECT *
                FROM tools_proyectos_users 
                WHERE proyecto_id = ".$_POST['proyecto_id']."
                AND user_id = ".$_POST['user_id'];

        $queryRecords = mysqli_query($connString, $sql);

        $row = mysqli_fetch_row($queryRecords);

        if ($row[0]) {
            echo "Proyecto ya asignado";
        }
        else {
            if ($_POST['escritura'] == "true"){
                $editor = 1;
            }
            else {
                $editor = 0;
            }
            $sql = "INSERT INTO tools_proyectos_users (proyecto_id, user_id, escritura) VALUES( ".$_POST['proyecto_id'].", ".$_POST['user_id'].", ".$editor.")";
            mysqli_query($connString, $sql);
            echo "ok";
        }
    }
    else {
        $sql = "SELECT *
                FROM tools_proyectos_users 
                WHERE proyecto_id = ".$_POST['proyecto_id']." 
                AND user_id = ".$_POST['user_id'];

        $queryRecords = mysqli_query($connString, $sql);

        $row = mysqli_fetch_row($queryRecords);

        if ($row[0]) {
            $sql = "DELETE FROM tools_proyectos_users WHERE proyecto_id = ".$_POST['proyecto_id']." AND user_id = ".$_POST['user_id'];
            mysqli_query($connString, $sql);
            echo "ok";
        }
        else {
            echo "Proyecto no asignado";
        }
    }
?>
