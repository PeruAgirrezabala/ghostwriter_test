<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                CLIENTES_INSTALACIONES.id,
                CLIENTES_INSTALACIONES.cliente_id,
                CLIENTES_INSTALACIONES.nombre,
                CLIENTES_INSTALACIONES.direccion
            FROM 
                CLIENTES_INSTALACIONES
            WHERE 
                CLIENTES_INSTALACIONES.cliente_id = ".$_POST['cliente_id'];
    file_put_contents("selectClientesInstalaciones.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de CLIENTES_INSTALACIONES");    
    $tohtml="<option value=''></option>";
    while ($registros = mysqli_fetch_array($resultado)) {
        $tohtml.="<option value='".$registros[0]."'>".$registros[2]."</option>";
    }
    echo $tohtml;
?>
	