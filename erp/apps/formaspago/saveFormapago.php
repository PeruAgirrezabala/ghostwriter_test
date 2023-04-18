
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['formapago_del'] != "") {
        deleteFormapago();
    }
    else {
        if ($_POST['newformapago_idforma'] != "") {
            updateFormapago();
        }  
        else {
            insertFormapago();
        }
    }
    
    
    
    function updateFormapago () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE FORMAS_PAGO SET 
                        nombre = '".$_POST['newformapago_nombre']."', 
                        datos = '".$_POST['newformapago_datos']."', 
                        observaciones = '".$_POST['newformapago_desc']."'
                    WHERE id =".$_POST['newformapago_idforma'];
        file_put_contents("updateProveedor.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Forma de Pago");
    }
    
    function insertFormapago () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO FORMAS_PAGO 
                            (nombre,
                            datos,
                            observaciones) 
                       VALUES (
                            '".$_POST['newformapago_nombre']."', 
                            '".$_POST['newformapago_datos']."', 
                            '".$_POST['newformapago_desc']."')";
        //file_put_contents("insertFormaPago.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Forma de Pago");
    }
   
   

    function deleteFormapago () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM FORMAS_PAGO WHERE id=".$_POST['formapago_del'];

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Forma de Pago");
    }
?>
	