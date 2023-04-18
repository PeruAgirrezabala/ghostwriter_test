
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");

    if ($_POST['newprocedimiento_delproc'] != "") {
        deleteProc();
    }
    else {
        if ($_POST['newprocedimiento_idproc'] != "") {
            updateProc();
        }  
        else {
            insertProc();
        }
    }
    
    
    function updateProc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE PROCEDIMIENTOS SET 
                        nombre = '".$_POST['newprocedimiento_nombre']."', 
                        descripcion = '".$_POST['newprocedimiento_desc']."', 
                        ref = '".$_POST['newprocedimiento_REF']."',
                        tipodoc_id = ".$_POST['newprocedimiento_tipo']."
                    WHERE id =".$_POST['newprocedimiento_idproc'];
        file_put_contents("updateProcedimiento.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Procedimiento");
    }
        
    function insertProc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO PROCEDIMIENTOS 
                            (nombre,
                            descripcion,
                            ref,
                            tipodoc_id) 
                       VALUES (
                            '".$_POST['newprocedimiento_nombre']."', 
                            '".$_POST['newprocedimiento_desc']."', 
                            '".$_POST['newprocedimiento_REF']."',
                            ".$_POST['newprocedimiento_tipo']."
                        )";
        file_put_contents("insertProcedimiento.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Procedimiento");
    }
    
    function deleteProc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM PROCEDIMIENTOS_VERSIONES WHERE proc_id = ".$_POST['newprocedimiento_delproc'];
        file_put_contents("delProcedimientoVer.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al eliminar las versiones de el Procedimiento");

        $sql = "DELETE FROM PROCEDIMIENTOS WHERE id = ".$_POST['newprocedimiento_delproc'];
        file_put_contents("delProcedimiento.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Procedimiento");
    }
   
?>
	