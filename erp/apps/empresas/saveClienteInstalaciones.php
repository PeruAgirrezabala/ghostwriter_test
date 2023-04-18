
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $_POST['id_cli'];
    $_POST['id_inst'];
    
    if($_POST['id_cli'] !="" && $_POST['id_inst']!=""){
        updateClienteInstalacion();
    }elseif($_POST['id_cli'] !=""){
        insertClienteInstalacion();
    }else{
        deleteClienteInstalacion();
    }
    
    
    
    function updateClienteInstalacion () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CLIENTES_INSTALACIONES SET 
                        cliente_id = '".$_POST['id_cli']."', 
                        nombre = '".$_POST['inst_cli_nom']."', 
                        direccion = '".$_POST['inst_cli_direc']."'
                    WHERE id =".$_POST['id_inst'];
        //file_put_contents("updateCliente.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la instalacion del cliente");
    }
    
    function insertClienteInstalacion () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO CLIENTES_INSTALACIONES 
                            (cliente_id,
                            direccion,
                            nombre) 
                       VALUES (
                            '".$_POST['id_cli']."', 
                            'Direccion 00', 
                            'Nombre 00'
                        )";
        file_put_contents("insertClienteInstalacion.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Cliente");
    }
   
   

    function deleteClienteInstalacion () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CLIENTES_INSTALACIONES WHERE id=".$_POST['id_inst_bor'];
        file_put_contents("delClienteInstalacion.txt", $sql);

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la instalacion del Cliente");
    }
?>
	