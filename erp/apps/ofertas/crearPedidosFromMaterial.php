
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
            
    if ($_POST['oferta_id'] != "") {
        createPedido();
    }
    else {
        echo 0;
    }
       
    function generatePedidoREF ($counter,$proyectoNombre) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        refIterator:
        $sql = "SELECT SUBSTRING(pedido_genelek,5,length(pedido_genelek)) 
                FROM PEDIDOS_PROV 
                WHERE pedido_genelek LIKE 'P".date("y")."%'
                ORDER BY 1 DESC LIMIT 1";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $registros = mysqli_fetch_row ($result);
        $numPedidos = $registros[0] + $counter;
        $REF = "P".date("y").str_pad($numPedidos, 4, '0', STR_PAD_LEFT);
        
        $sql = "SELECT pedido_genelek FROM PEDIDOS_PROV WHERE pedido_genelek = '".$REF."'";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
        $numRegistros = mysqli_num_rows ($result);
        
        if ($numRegistros > 0) {
            $counter = $counter + 1;
            goto refIterator;
        }else{
            return $REF;
        }
        
//        refIterator:
//        $sql = "SELECT COUNT(*) FROM PEDIDOS_PROV WHERE YEAR(fecha) = YEAR(now())";
//        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
//        $registros = mysqli_fetch_row ($result);
//        $numPedidos = $registros[0] + $counter;
//        $REF = "P".date("y").str_pad($numPedidos, 4, '0', STR_PAD_LEFT);
//        
//        
//        $sql = "SELECT pedido_genelek FROM PEDIDOS_PROV WHERE pedido_genelek = '".$REF."'";
//        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de Pedidos");
//        $numRegistros = mysqli_num_rows ($result);
        
        if ($numRegistros > 0) {
            $counter = $counter + 1;
            goto refIterator;
        }
        else {
            // Si la REF creada no existe, creamos el directorio y devolvemos la referencia
                $nombre = str_replace(" ", "_", $proyectoNombre);        
                $path = "/".date('Y')."/".$REF."_".$nombre."/";
                $pathYear = "/".date('Y')."/";
                
            // file paths to store
                $basepath = "ERP/MATERIAL/PEDIDOS".$path;
                $ftp_server = "192.168.3.108";
                $ftp_username = "admin";
                $ftp_password = "Sistemas2111";
                ///share/MD0_DATA/Download/

            // connection to ftp
                $ftp_connection = ftp_connect($ftp_server);
                $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

            // crear path del año si no existiera
                if (ftp_nlist($ftp_connection, "ERP/MATERIAL/PEDIDOS".$pathYear) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, "ERP/MATERIAL/PEDIDOS".$pathYear)) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        //echo "Error while creating $basepath";
                        $success = false;
                    }
                }
                
            //file_put_contents("01_crear_dir.txt", $basepath);
            
            // crear path del pedido si no existiera
                if (ftp_nlist($ftp_connection, $basepath) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, $basepath)) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        //echo "Error while creating $basepath";
                        $success = false;
                    }
                }
                
            return $REF;
        }
    }
    
    function createPedido() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $tecnico=$_POST["tecnico_id"];
        // Obtener de cuántos proveedores distintos hay material
        $sql = "SELECT 
                    OFERTAS_DETALLES_MATERIALES.id,
                    MATERIALES.id as material,
                    MATERIALES.ref,
                    MATERIALES.nombre,
                    MATERIALES.modelo,
                    MATERIALES.descripcion,
                    MATERIALES_PRECIOS.pvp as precio,
                    OFERTAS_DETALLES_MATERIALES.cantidad,
                    OFERTAS_DETALLES_MATERIALES.titulo,
                    OFERTAS_DETALLES_MATERIALES.descripcion,
                    OFERTAS_DETALLES_MATERIALES.incremento,
                    OFERTAS_DETALLES_MATERIALES.dto1, 
                    OFERTAS_DETALLES_MATERIALES.dto_prov_activo, 
                    OFERTAS_DETALLES_MATERIALES.dto_mat_activo, 
                    OFERTAS_DETALLES_MATERIALES.dto_ad_activo, 
                    PROVEEDORES_DTO.id, 
                    MATERIALES.dto2,
                    OFERTAS_DETALLES_MATERIALES.origen,
                    PROVEEDORES.id,
                    PROVEEDORES.nombre,
                    OFERTAS.proyecto_id,
                    PROYECTOS.nombre,
                    CLI1.id,
                    OFERTAS_DETALLES_MATERIALES.material_tarifa_id
                FROM 
                    MATERIALES
                INNER JOIN MATERIALES_PRECIOS
                    ON MATERIALES_PRECIOS.material_id = MATERIALES.id  
                INNER JOIN PROVEEDORES
                    ON MATERIALES_PRECIOS.proveedor_id = PROVEEDORES.id 
                INNER JOIN OFERTAS_DETALLES_MATERIALES
                    ON OFERTAS_DETALLES_MATERIALES.material_tarifa_id = MATERIALES_PRECIOS.id
                INNER JOIN OFERTAS 
                    ON OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id  
                LEFT JOIN PROVEEDORES_DTO 
                    ON PROVEEDORES_DTO.id = OFERTAS_DETALLES_MATERIALES.dto_prov_id
                LEFT JOIN PROYECTOS
                    ON OFERTAS.proyecto_id = PROYECTOS.id 
                LEFT JOIN CLIENTES as CLI1
                    ON PROYECTOS.cliente_id = CLI1.id
                WHERE 
                    OFERTAS.id = ".$_POST['oferta_id']." 
                AND 
                    OFERTAS_DETALLES_MATERIALES.origen = 0 
                AND 
                    OFERTAS_DETALLES_MATERIALES.pedcreado = 0 
                ORDER BY 
                    PROVEEDORES.id ASC";
        
        //file_put_contents("debug0.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error al consultar el material de la Oferta");
        
        $pedidoGroup = "";
        $contador = 0;
        $idGenerado = 0;
        while( $registros = mysqli_fetch_array($res) ) {
            $materialId = $registros[0];
            $tarifaId = $registros[6];
            $cantidad = $registros[7];
            $dto = $registros[11];
            $dto_prov_activo = $registros[12];
            $dto_mat_activo = $registros[13];
            $dto_ad_activo = $registros[14];
            if ($registros[15] != "") {
                $dto_prov = $registros[15];
            }
            else {
                $dto_prov = "null";
            }
            $proveedorId = $registros[18];
            $proveedorNombre = $registros[19];
            if ($registros[20] != "") {
                $proyectoId = $registros[20];
            }
            else {
                $proyectoId = "null";
            }
            
            $proyectoNombre = $registros[21];
            if ($registros[22] != "") {
                $clienteId = $registros[22];
            }
            else {
                $clienteId = "null";
            }
            
            if ($pedidoGroup != $proveedorId) {
                // Recojo los datos generales del pedido y lo inserto, recibiendo el ID del mismo para insertar los detalles
                    $pedidoGroup = $proveedorId;
                    $REF = generatePedidoREF(1,$proyectoNombre);
                    $nombre = "MATERIAL_".$proyectoNombre;        
                    $path = "/".date('Y')."/".$REF."_".$nombre."/";
                    $pathYear = "/".date('Y')."/";
                    $nombre=$_POST["ped_nom"];
                // Inserto el pedido nuevo
                    //$idGenerado = insertPedido($REF,$nombre,$proveedorId,$proyectoId, $clienteId, $path, $contador,$tecnico);
                    //($pedido_genelek, $titulo, $proveedor_id, $proyecto_id, $cliente_id, $path, $contador, $tecnico)
                    $sqlPed = "INSERT INTO PEDIDOS_PROV
                            (
                                pedido_genelek,
                                titulo,
                                proveedor_id,
                                proyecto_id,
                                cliente_id,
                                fecha,
                                fecha_mod,
                                path,
                                tecnico_id,
                                descripcion,
                                ref,
                                forma_pago,
                                contacto,
                                plazo,
                                dir_entrega,
                                observaciones,
                                ref_oferta_prov
                            )
                            VALUES
                            (
                                '".$REF."',
                                '".$nombre."',
                                ".$proveedorId.",
                                ".$proyectoId.",
                                ".$clienteId.",
                                now(),
                                now(),
                                '".$path."',
                                ".$tecnico.",
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                ''
                            )
                            ";
                    //file_put_contents($contador."_crear_pedido.txt", $sql);
                    //file_put_contents("debug1.txt", $sqlPed);

                    $resPed = mysqli_query($connString, $sqlPed) or die("Error al insertar el Pedido");
                    //$sql = "SELECT id FROM PEDIDOS_PROV ORDER BY id DESC LIMIT 1";
                    //$resultPedido = mysqli_query($connString, $sql) or die("Error al consultar el Pedido");
                    //$row = mysqli_fetch_row($resultPedido);
                    $idGenerado=mysqli_insert_id($connString);
                    
            }
            // Inserto los detalles de los materiales ofertados
                $sqlPedDet = "INSERT INTO PEDIDOS_PROV_DETALLES 
                            (material_id,
                            material_tarifa_id,
                            pedido_id,
                            unidades,
                            dto,
                            dto_prov_activo,
                            dto_mat_activo,
                            dto_ad_activo, 
                            dto_prov_id,
                            proyecto_id,
                            cliente_id,
                            descripcion,
                            ref,
                            erp_userid
                            )
                        VALUES (".$registros[1].",
                        ".$registros[23].", 
                        ".$idGenerado.",
                        ".$cantidad.",
                        ".$dto.",
                        ".$dto_prov_activo.",
                        ".$dto_mat_activo.",
                        ".$dto_ad_activo.",
                        ".$dto_prov.", 
                        ".$proyectoId.",
                        ".$clienteId.",
                        '',
                        '".$registros[2]."',
                        ".$tecnico.")";
                //file_put_contents("debug2.txt", $sqlPedDet);
                $resPedDet = mysqli_query($connString, $sqlPedDet) or die("Error al insertar el Detalle del Pedido");
                //file_put_contents($contador."_insert_detalle.txt", $sql);
                $lastId=mysqli_insert_id($connString);
                
                // UPDATE $materialId set pedcreado=1
                $sqlUpdate="UPDATE OFERTAS_DETALLES_MATERIALES SET pedcreado=".$lastId." WHERE id=".$materialId;
                $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar pedido creado");
                
                
            $contador = $contador + 1;
        } // While de los materiales de la oferta
        
        // Devuelvo 1 cuanto termine el bucle
        echo $idGenerado;
    }
    
    
    // No se usa ahora la funcion!
    function insertPedido00($pedido_genelek, $titulo, $proveedor_id, $proyecto_id, $cliente_id, $path, $contador, $tecnico) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO PEDIDOS_PROV
                (
                    pedido_genelek,
                    titulo,
                    proveedor_id,
                    proyecto_id,
                    cliente_id,
                    fecha,
                    fecha_mod,
                    path,
                    tecnico_id,
                    descripcion,
                    ref,
                    forma_pago,
                    contacto,
                    plazo,
                    dir_entrega,
                    observaciones,
                    ref_oferta_prov
                )
                VALUES
                (
                    '".$pedido_genelek."',
                    '".$titulo."',
                    ".$proveedor_id.",
                    ".$proyecto_id.",
                    ".$cliente_id.",
                    now(),
                    now(),
                    '".$path."',
                    ".$tecnico.",
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                )
                ";
        //file_put_contents($contador."_crear_pedido.txt", $sql);
        //file_put_contents("debug1.txt", $sql);
        
        $res = mysqli_query($connString, $sql) or die("Error al insertar el Pedido");
        $sql = "SELECT id FROM PEDIDOS_PROV ORDER BY id DESC LIMIT 1";
        $resultPedido = mysqli_query($connString, $sql) or die("Error al consultar el Pedido");
        $row = mysqli_fetch_row($resultPedido);
        $lastID=mysqli_insert_id($connString);
        
        // Devuelvo el id del pedido generado para poder usarlo en la inercion de sus detalles
        return $lastID;
        //return 999999;
    }

?>
	