
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['material_del'] != "") {
        deleteMaterial();
    }
    else {
        if ($_POST['material_sn'] == "1") {
            insertSN();
        }
        else {
            if ($_POST['newmaterial_idmaterial'] != "") {
                updateMaterial();
            }  
            else {
                if($_POST['add_material_stock'] == 1){
                    addMaterial();
                }else{
                    insertMaterial();
                }
            }
        }
    }
    
    function updateMaterial () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE MATERIALES SET 
                        ref = '".$_POST['newmaterial_ref']."',
                        nombre = '".$_POST['newmaterial_nombre']."', 
                        fabricante = '".$_POST['newmaterial_fabricante']."', 
                        modelo = '".$_POST['newmaterial_modelo']."', 
                        DTO2 = '".$_POST['newmaterial_dto']."', 
                        stock = '".$_POST['newmaterial_stock']."', 
                        descripcion = '".$_POST['newmaterial_desc']."', 
                        categoria_id = ".$_POST['materiales_categoria1'].",
                        sustituto = '".$_POST['newmaterial_sustituto']."'
                    WHERE id =".$_POST['newmaterial_idmaterial'];
        //file_put_contents("updateMat.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
    }
    
    function insertMaterial () {
        //conexion a la base de datos
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        //si el campo de stock esta vacio se fija el valor en 0
        if($_POST['newmaterial_stock'] == ""){
            $stock=0;
        }else{
            $stock=$_POST['newmaterial_stock'];
        }
        $str = "Hello PHP\n";
 
        system("echo ".$str);
        //secure the required fields are not empty
        //si el campo de referencia esta vacio la consulta muere, lo cual no va pasar dbido a las comprobaciones de los campos required
        if(empty($_POST["newmaterial_ref"])){
            die("Error:Required fields are missing");
      
        }
        
        //query
        $sql = "INSERT INTO MATERIALES 
                            (ref,
                            nombre,
                            fabricante,
                            modelo,
                            DTO2,
                            stock,
                            descripcion,
                            categoria_id,
                            sustituto)
                       VALUES (
                            '".$_POST['newmaterial_ref']."',  
                            '".$_POST['newmaterial_nombre']."',  
                            '".$_POST['newmaterial_fabricante']."', 
                            '".$_POST['newmaterial_modelo']."', 
                            ".$_POST['newmaterial_dto'].",  
                            ".$stock.", 
                            '".$_POST['newmaterial_desc']."',  
                            ".$_POST['material_categoria_id'].",
                            '".$_POST['newmaterial_sustituto']."'
                        )";
        //file_put_contents("insertMat.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
        //LAST_INSERT_ID()
        if ($_POST['newmaterial_lastprice'] != "") {
            $sql = "INSERT INTO MATERIALES_PRECIOS (material_id, fecha_val, pvp) VALUES (LAST_INSERT_ID(), '0000-00-00', ".$_POST['newmaterial_lastprice'].")";
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
        }
        echo $result;
    }
    
    function insertSN () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO SERIAL_NUMBERS 
                            (material_id,
                            proveedor_id,
                            cliente_id,
                            sn)
                       VALUES (
                            ".$_POST['newmaterial_materiales'].",  
                            ".$_POST['newmaterial_proveedores'].",  
                            ".$_POST['newmaterial_clientes'].", 
                            '".$_POST['newmaterial_sn']."' 
                        )";
        //file_put_contents("insertSN.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Material");
    }
    
    function deleteMaterial () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM MATERIALES_PRECIOS WHERE material_id=".$_POST['material_del'];
        $result = mysqli_query($connString, $sql) or die("Error al eliminar los Precios del Material");
        
        $sql = "DELETE FROM MATERIALES WHERE id=".$_POST['material_del'];
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Material");
    }
    
    function addMaterial(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        //$_POST["cantidad"];
        //$_POST["material_id"];
        
        // Pedido_prov_id = 6472 -> Sacar info??
        
        // Material informacion
        
        $sqlMaterial = "SELECT MATERIALES.id, MATERIALES.ref, MATERIALES.DTO2
            FROM MATERIALES
            WHERE MATERIALES.id =".$_POST["material_id"];
        //file_put_contents("selectMateriales.txt", $sqlMaterial);
        $resMaterial = mysqli_query($connString, $sqlMaterial) or die("Error al seleccionar el material");
        $rowMaterial = mysqli_fetch_row ($resMaterial);
        
        // Material -> Sacar info (last precio)
        $sqlLastPrecio = "SELECT MATERIALES_PRECIOS.id,
                            MATERIALES_PRECIOS.fecha_val,
                            MATERIALES_PRECIOS.pvp,
                            MATERIALES_PRECIOS.dto_material
                          FROM 
                            MATERIALES_PRECIOS 
                          WHERE 
                            MATERIALES_PRECIOS.material_id=".$_POST["material_id"]." 
                          ORDER BY MATERIALES_PRECIOS.fecha_val DESC LIMIT 1";
        //file_put_contents("selectMaterialesPrecios.txt", $sqlLastPrecio);
        $resLastPrecio = mysqli_query($connString, $sqlLastPrecio) or die("Error al seleccionar el precio");
        $rowLastPrecio = mysqli_fetch_row ($resLastPrecio);
        
        $fecha_recepcion = date("Y-m-d H:i:s");
        $fecha_entrega = date("Y-m-d");
        
        $sqlInsertDet = "INSERT INTO PEDIDOS_PROV_DETALLES 
                        (material_id,
                        material_tarifa_id,
                        pedido_id,
                        ref,
                        unidades,
                        dto,
                        fecha_recepcion,
                        fecha_entrega,
                        recibido, 
                        dto_prov_activo,
                        dto_mat_activo,
                        dto_ad_activo, 
                        dto_ad_prior,
                        iva_id,
                        cliente_id,
                        descripcion,
                        proyecto_id
                        )
                    VALUES (".$_POST["material_id"].",
                    ".$rowLastPrecio[0].", 
                    6472,
                    '".$rowMaterial[1]."',
                    ".$_POST['cantidad'].",
                    ".$rowMaterial[2].",
                    '".$fecha_recepcion."',
                    '".$fecha_entrega."',
                    1,
                    0, 
                    0,
                    0,
                    0,
                    4,
                    215,
                    'Material añadido en desglose almacen',
                    11)";
        //file_put_contents("insertPedidoProvDetalles.txt", $sqlInsertDet);
        $resInsertDet = mysqli_query($connString, $sqlInsertDet) or die("Error al insertar pedidos prov detalles");
        
        $ultimoId=mysqli_insert_id($connString);
        $sqlInsertMatStock = "INSERT INTO MATERIALES_STOCK(material_id, stock, ubicacion_id, proyecto_id, pedido_detalle_id) 
                VALUES (".$_POST["material_id"].",".$_POST['cantidad'].",1,11,".$ultimoId.")";
        //file_put_contents("insertMatStock.txt", $sqlInsertMatStock);
        $resInsertMatStock = mysqli_query($connString, $sqlInsertMatStock) or die("Error al insertar pedidos prov detalles");
        
        echo 1;
    }

?>
	