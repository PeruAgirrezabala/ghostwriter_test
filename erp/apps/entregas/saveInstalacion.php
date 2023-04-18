
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['clienteid'] != "") {
        insertInstalacion();
    } else {
      
    }
    
    function insertInstalacion() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
                
        $sql = "INSERT INTO CLIENTES_INSTALACIONES (
                        cliente_id,
                        nombre,
                        direccion
                        )
                    VALUES (
                        ".$_POST["clienteid"].",
                        '".$_POST["instalacionnombre"]."',
                        '".$_POST["instalaciondireccion"]."'
                        )";
        file_put_contents("insertInstalacion.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al insertar instalacion del cliente");
    }
    
?>
	