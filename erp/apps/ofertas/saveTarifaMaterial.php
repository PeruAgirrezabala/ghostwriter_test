
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
   
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        
        $matid=$_POST["newtarifa_materialid"];
        $provid=$_POST["newtarifa_proveedorid"];
        
        $fechavalidez=$_POST["newtarifa_fechaval"];
        $tarifa=$_POST["newtarifa_tarifa"];
        $dto=$_POST["newtarifa_dto"];
        
        $sql = "INSERT INTO MATERIALES_PRECIOS 
                    (material_id,
                    proveedor_id,
                    fecha_val,
                    pvp,
                    dto_material
                    )
                VALUES (".$matid.",
                ".$provid.",
                '".$fechavalidez."',
                ".$tarifa.",
                ".$dto.")";
        //file_put_contents("insertmatprecio.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Precio del Material");
        
?>
	