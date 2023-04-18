
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    file_put_contents("log.txt", "Respuesta, (entregas_identrega): ".$_POST['entregas_identrega']);
    if ($_POST['entregas_delentrega'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delEntrega($_POST['entregas_delentrega']);
    }    
    else {
        if ($_POST['entregas_identrega'] != "") {
            updateEntrega();
        }
        else {
            if($_POST["realizar_envio"] != ""){
                realizarEnvio();
            }else{
                if($_POST["deldoc_entrega"] != ""){
                    deldocEntrega();
                }else{
                    if($_POST["entregas_duplientrega"] != ""){
                        dupliEntrega();
                    }else{
                        insertEntrega();
                    }
                }
            }
        }
    }
    
    function insertEntrega() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
                
        $sql = "SELECT path FROM PROYECTOS WHERE id = ".$_POST["newentrega_proyecto"];
        file_put_contents("selectPath.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el Path del Proyecto");
        $registros = mysqli_fetch_row ($result);
        $pathproyecto = $registros[0];
        
        $sql = "SELECT SUBSTR( ref, 4 ) AS nume
                FROM ENTREGAS
                WHERE YEAR( fecha_entrega ) = YEAR( NOW( ) )
                ORDER BY nume DESC
                LIMIT 1";
        file_put_contents("SelectCount.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el Path del Proyecto");
        $registros = mysqli_fetch_row ($result);
        $numEntregas = $registros[0];
        $numEntregasNew = $numEntregas + 1;
        
        $REF = "E".date("y",strtotime($_POST["newentrega_fechaentrega"])).str_pad($numEntregasNew, 4, '0', STR_PAD_LEFT);
        $nombre = str_replace(" ", "_", $_POST['newentrega_nombre']);        
        $path = $pathproyecto."ENTREGAS/".$REF."_".$nombre."/";
        
        
        // file paths to store
            $basepath = "PROYECTOS".$path;
            $ftp_server = "192.168.3.108";
            $ftp_username = "admin";
            $ftp_password = "Sistemas2111";
            ///share/MD0_DATA/Download/

        // connection to ftp
            $ftp_connection = ftp_connect($ftp_server);
            $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

        // crear path del pedido si no existiera
            if (ftp_nlist($ftp_connection, "PROYECTOS".$pathproyecto."ENTREGAS/") === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, "PROYECTOS".$pathproyecto."ENTREGAS/")) {
                    //echo "Successfully created $basepath";
                    $success = true;
                }
                else
                {
                    file_put_contents("errorEntrega1.txt", "PROYECTOS".$pathproyecto."ENTREGAS/");
                    //echo "Error while creating $basepath";
                    $success = false;
                }
            }
            if (ftp_nlist($ftp_connection, $basepath) === false) {
                // try to create directory $dir
                if (ftp_mkdir($ftp_connection, $basepath)) {
                    //echo "Successfully created $basepath";
                    $success = true;
                }
                else
                {
                    file_put_contents("errorEntrega.txt", $basepath);
                    //echo "Error while creating $basepath";
                    $success = false;
                }
            }
            
        if ($success == true) {            
            $sql = "INSERT INTO ENTREGAS (
                        ref,
                        nombre,
                        descripcion,
                        fecha_entrega,
                        fecha_pruebas,
                        fecha_realentrega,
                        estado_id,
                        proyecto_id,
                        path 
                        )
                    VALUES (
                        '".$REF."',
                        '".$nombre."',
                        '".$_POST["newentrega_desc"]."',
                        '".$_POST["newentrega_fechaentrega"]."',
                        '".$_POST["newentrega_fechatest"]."',
                        '".$_POST["newentrega_fechareal"]."',
                        ".$_POST["newentrega_estados"].",
                        ".$_POST["newentrega_proyecto"].",
                        '".$path."'
                        )";
            file_put_contents("insertEntrega.txt", $sql);
            //insertActivity("Entrega ".$nombre." creada");
            $result = mysqli_query($connString, $sql) or die("Error al guardar la Entrega");
            $insertedId=mysqli_insert_id($connString);
            
            // Creamos el directorio 
                $basepath5 = $basepath."ENSAYOS/";
                if (ftp_nlist($ftp_connection, $basepath5) === false) {
                    // try to create directory $dir
                    if (ftp_mkdir($ftp_connection, $basepath5)) {
                        //echo "Successfully created $basepath";
                        $success = true;
                    }
                    else
                    {
                        //echo "Error while creating $basepath";
                        $success = false;
                    }
                }

            echo $insertedId;
        }
        else {
            echo "Error al generar el directorio de la Entrega";
        }
    }
    
    function updateEntrega() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE ENTREGAS 
                SET descripcion = '".$_POST['entregas_edit_desc']."',  
                    fecha_pruebas = '".$_POST['entregas_edit_fecha']."', 
                    fecha_entrega = '".$_POST['entregas_edit_fechaentrega']."', 
                    fecha_realentrega = '".$_POST['entregas_edit_fecharealentrega']."',  
                    estado_id = ".$_POST['entregas_estados'].",
                    instalacion_id = ".$_POST['entregas_instalacion']."
                WHERE id = ".$_POST['entregas_identrega'];
        file_put_contents("updateEntrega.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        //insertActivity("Entrega ".$_POST['entregas_edit_nombre']." actualizada");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Entrega");
    }

    function delEntrega($entrega_id) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        //$data = array();
        //print_R($_POST);die;
        
        $sqlSel = "SELECT ENTREGAS.grupos_nombres_id FROM ENTREGAS WHERE ENTREGAS.id=".$entrega_id;
        $result = mysqli_query($connString, $sqlSel) or die("Error al seleccionar id de grupos");
        $registros = mysqli_fetch_array($result);
        
        // UPDATE PEDIDOS_PROV_DETALLES
        $sqlUpdate = "UPDATE PEDIDOS_PROV_DETALLES SET entrega_id=0 WHERE entrega_id=".$entrega_id;
        file_put_contents("updateEntregaId.txt", $sqlUpdate);
        $result = mysqli_query($connString, $sqlUpdate) or die("Error al actualizar entregas_id de PED_PROV_DET");
        
        $sqlDelGrupos = "DELETE FROM MATERIALES_GRUPOS WHERE grupos_nombres_id=".$registros[0];
        $result = mysqli_query($connString, $sqlDelGrupos) or die("Error al borrar MATERIALES_GRUPOS");
        
        $sqlDelGruposNombres = "DELETE FROM MATERIALES_GRUPOS_NOMBRES WHERE id=".$registros[0];
        $result = mysqli_query($connString, $sqlDelGruposNombres) or die("Error al borrar MATERIALES_GRUPOS_NOMBRES");
        
        $sql = "DELETE FROM ENSAYOS WHERE entrega_id = ".$entrega_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Ensayo");
        $sql = "DELETE FROM ENTREGAS WHERE id = ".$entrega_id;
        $result = mysqli_query($connString, $sql) or die("Error al eliminar el Entregas");
        
        //insertActivity("Entrega ".$entrega_id." eliminada");
        echo 1;
    }
    
    function realizarEnvio(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sqlEntregas="SELECT ENTREGAS.proyecto_id, ENTREGAS.grupos_nombres_id, MATERIALES_GRUPOS_NOMBRES.nombre
                        FROM ENTREGAS
                        INNER JOIN MATERIALES_GRUPOS_NOMBRES ON
                        ENTREGAS.grupos_nombres_id = MATERIALES_GRUPOS_NOMBRES.id
                        WHERE ENTREGAS.id=".$_POST["envio_id_entrega"];
        $resEntregas = mysqli_query($connString, $sqlEntregas) or die("Error al seleccionar ultimo valor de ref del año.");
        $regEntregas = mysqli_fetch_array($resEntregas);
        $proyectoid=$regEntregas[0];
        $grupoosnombres_id=$regEntregas[1];
        $nombre_grupos=$regEntregas[2];    
        $trabajadorid=$_POST["envio_idtrabajador"];
        
        
        $sqlGetClienteId="SELECT PROYECTOS.cliente_id FROM PROYECTOS WHERE PROYECTOS.id=".$proyectoid;
        $resGetClienteId = mysqli_query($connString, $sqlGetClienteId) or die("Error al seleccionar ultimo valor de ref del año.");
        $regGetClienteId = mysqli_fetch_array($resGetClienteId);
        
        // Generar REF AUTOMÁTICAMENTE!!
        $sqlRef="SELECT SUBSTRING( ENVIOS_CLI.ref, 6, 4 ) AS anyo
                    FROM ENVIOS_CLI
                    WHERE SUBSTRING( ENVIOS_CLI.ref, 4, 2 ) =".substr(Date("Y"),2,4)." ORDER BY anyo DESC LIMIT 1";
        file_put_contents("selectLastRef.txt", $sqlRef);
        $resultado = mysqli_query($connString, $sqlRef) or die("Error al seleccionar ultimo valor de ref del año.");
        $registros = mysqli_fetch_array($resultado);
        $ref = "ALB".substr(Date("Y"),2,4).str_pad(($registros[0]+1), 4, '0', STR_PAD_LEFT);  // Añadir ALB+AÑO+XXXX
                
        //creamos envio
        $sqlCrearEnvio='INSERT INTO ENVIOS_CLI
                    (
                    transportista_id, 
                    nombre, 
                    descripcion, 
                    tecnico_id, 
                    fecha, 
                    ref,
                    cliente_id,
                    estado_id, 
                    proyecto_id, 
                    path,
                    gastos_envio,
                    portes,
                    tipo_envio_id) 
                    VALUES 
                    (
                    1,"'.$nombre_grupos.'","",'.$trabajadorid.',"'.date("Y-m-d").'","'.$ref.'",'.$regGetClienteId[0].',2,'.$proyectoid.',"/'.date("Y").'/'.$ref.'",0,1,1
                    )';
        file_put_contents("insertEnviosCli.txt", $sqlCrearEnvio);
        $resultado = mysqli_query($connString, $sqlCrearEnvio) or die("Error al crear el envío. ENVIOS_CLI.");
        $idenvio=mysqli_insert_id($connString);
        // Añadimos detalles del envio
        $sqlMaterialesGrupos="SELECT MATERIALES_GRUPOS.pedido_detalle_id FROM MATERIALES_GRUPOS WHERE MATERIALES_GRUPOS.grupos_nombres_id=".$grupoosnombres_id;
        file_put_contents("selectPedDetIDs.txt", $sqlMaterialesGrupos);
        $resSel = mysqli_query($connString, $sqlMaterialesGrupos) or die("Error al reealizar sleect de los pedidos detalles.");        
        
        while ($rowDet = mysqli_fetch_array($resSel)) {
            $sqlSelPedDet="SELECT
                            MATERIALES_STOCK.material_id,
                            MATERIALES_STOCK.stock
                          FROM MATERIALES_STOCK WHERE MATERIALES_STOCK.pedido_detalle_id=".$rowDet[0];
            file_put_contents("selectMaterialesStock.txt", $sqlSelPedDet);
            $resSelPedDet = mysqli_query($connString, $sqlSelPedDet) or die("Error al reealizar sleect de los pedidos detalles.");
            $row = mysqli_fetch_array($resSelPedDet);
            $sqlInsertDetalle = "INSERT INTO ENVIOS_CLI_DETALLES
                                    (envio_id, 
                                    material_id, 
                                    unidades, 
                                    entregado,
                                    proyecto_id,
                                    pedido_detalle_id)
                                VALUES
                                    (".$idenvio.",".$row[0].",".$row[1].",0,".$proyectoid.",".$rowDet[0].")";
            file_put_contents("insertEnviosCliDetalles.txt", $sqlInsertDetalle);
            $resInsert = mysqli_query($connString, $sqlInsertDetalle) or die("Error realizar insert de detalles del envío.");
            
            $sqlUpdatePedDet ="UPDATE PEDIDOS_PROV_DETALLES SET PEDIDOS_PROV_DETALLES.recibido=3 WHERE PEDIDOS_PROV_DETALLES.id=".$rowDet[0];
            file_put_contents("updatePedidosProvDetalles.txt", $sqlUpdatePedDet);
            $resUpdate = mysqli_query($connString, $sqlUpdatePedDet) or die("Error realizar el update de pedidos detalles a recibido=3 envio.");  
            
            // AÑADIR A PROYECTOS MATERIALES
            
            $sql = "SELECT 
                        PEDIDOS_PROV_DETALLES.id,
                        PEDIDOS_PROV_DETALLES.ref,  
                        MATERIALES.nombre,
                        MATERIALES.fabricante,
                        PEDIDOS_PROV_DETALLES.unidades,
                        MATERIALES_PRECIOS.pvp, 
                        PEDIDOS_PROV_DETALLES.recibido,
                        PEDIDOS_PROV_DETALLES.fecha_recepcion,
                        PROYECTOS.nombre,
                        PEDIDOS_PROV_DETALLES.pvp,
                        MATERIALES_PRECIOS.dto_material, 
                        PEDIDOS_PROV_DETALLES.dto_prov_activo, 
                        PEDIDOS_PROV_DETALLES.dto_mat_activo, 
                        PEDIDOS_PROV_DETALLES.dto_ad_activo, 
                        PROVEEDORES_DTO.id, 
                        PEDIDOS_PROV_DETALLES.dto, 
                        ENTREGAS.nombre, 
                        PEDIDOS_PROV_DETALLES.material_id,
                        PEDIDOS_PROV_DETALLES.material_tarifa_id,
                        PROYECTOS.id
                    FROM 
                        PEDIDOS_PROV_DETALLES
                    INNER JOIN PEDIDOS_PROV 
                        ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                    INNER JOIN MATERIALES
                        ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
                    LEFT JOIN MATERIALES_PRECIOS 
                        ON MATERIALES_PRECIOS.id = PEDIDOS_PROV_DETALLES.material_tarifa_id 
                    LEFT JOIN PROYECTOS 
                        ON PROYECTOS.id = PEDIDOS_PROV_DETALLES.proyecto_id 
                    LEFT JOIN PROVEEDORES_DTO 
                        ON PROVEEDORES_DTO.id = PEDIDOS_PROV_DETALLES.dto_prov_id
                    LEFT JOIN ENTREGAS
                        ON PEDIDOS_PROV_DETALLES.entrega_id = ENTREGAS.id
                    WHERE
                        PEDIDOS_PROV_DETALLES.id = ".$rowDet[0]."
                    ORDER BY 
                        PEDIDOS_PROV.id ASC ";
            /* SE HA QUITADO ESTO DEL SQL:
             * AND
               PEDIDOS_PROV_DETALLES.proyecto_id = ".$proyectoid."
             * Para que se puedan coger los materiales que sean del almacen....
             */
            file_put_contents("selectBig01.txt",$sql);
            $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del detalle de Pedidos");
            $registros = mysqli_fetch_array($resultado);
            
            if( $registros[14]==null || $registros[14]=="" ){
                $dto_prov_id=0;
            }else{
                $dto_prov_id=$registros[14];
            }
            
            // Añadir En proyectos Materiales
            $sqlIn = "INSERT INTO PROYECTOS_MATERIALES 
                                     (material_id,
                                     unidades,
                                     material_tarifa_id,
                                     dto_prov_id,
                                     dto_prov_activo,
                                     dto_mat_activo,
                                     dto_ad_activo,
                                     proyecto_id,
                                     pedido_detalle_id
                                     )
                                     VALUES (
                                     ".$registros[17].",
                                     ".$registros[4].",
                                     ".$registros[18].",
                                     ".$dto_prov_id.",
                                     ".$registros[11].",
                                     ".$registros[12].",
                                     ".$registros[13].",
                                     ".$proyectoid.",
                                     ".$registros[0]."
                                     );";
            file_put_contents("insertMaterialesProyectos.txt",$sqlIn);
            $resUpdate = mysqli_query($connString, $sqlIn) or die("Error realizar el Insert de PROYECTOS_MATERIALES");
            
        }
        
        echo $idenvio;
    }
    
    function deldocEntrega(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sqlEntregas="DELETE FROM ENTREGAS_DOC WHERE ENTREGAS_DOC.id=".$_POST["deldoc_entrega"];
        echo $resEntregas = mysqli_query($connString, $sqlEntregas) or die("Error al eliminar ENTREGAS_DOC.");        
    }
    function dupliEntrega(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        // Seleccionar Entrega a duplicar
        $sqlEntregas="SELECT 
                        ref,
                        nombre,
                        descripcion,
                        proyecto_id,
                        fecha_entrega,
                        fecha_pruebas,
                        fecha_realentrega,
                        estado_id,
                        path,
                        fecha_mod,
                        grupos_nombres_id,
                        instalacion_id
                      FROM
                        ENTREGAS
                      WHERE ENTREGAS.id=".$_POST["entregas_duplientrega"];
        $resEntregas = mysqli_query($connString, $sqlEntregas) or die("Error al seleccionar ENTREGAS (duplicado).");
        $registros = mysqli_fetch_array($resEntregas);
        
        // Calcular Ref Libre
        $sql = "SELECT SUBSTR( ref, 4 ) AS nume
                FROM ENTREGAS
                WHERE YEAR( fecha_entrega ) = YEAR( NOW( ) )
                ORDER BY nume DESC
                LIMIT 1";
        file_put_contents("SelectCount.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el Path del Proyecto");
        $reg = mysqli_fetch_row ($result);
        $numEntregas = $reg[0];
        $numEntregasNew = $numEntregas + 1;
        
        $REF = "E".date("y",strtotime(date("Y-m-d"))).str_pad($numEntregasNew, 4, '0', STR_PAD_LEFT);
        
        // Insertar entrega a duplicar
        $sqlInsertEntrega="INSERT INTO ENTREGAS
                    (ref, 
                    nombre, 
                    descripcion, 
                    proyecto_id, 
                    fecha_entrega, 
                    fecha_pruebas, 
                    fecha_realentrega, 
                    estado_id, 
                    path, 
                    fecha_mod, 
                    grupos_nombres_id, 
                    instalacion_id) 
                    VALUES 
                    ('".$REF."',
                    '".$registros[1]."',
                    '".$registros[2]."',
                    ".$registros[3].",
                    '".$registros[4]."',
                    '".$registros[5]."',
                    '".$registros[6]."',
                    ".$registros[7].",
                    '".$registros[8]."',
                    '".$registros[9]."',
                    ".$registros[10].",
                    ".$registros[11].")";
        $resEntregas = mysqli_query($connString, $sqlInsertEntrega) or die("Error al duplicar ENTREGAS (insert-duplicado).");
        $nuevaEntrega = mysqli_insert_id($connString);
        
        // Duplicar ENTREGAS_DOC
        $sqlInsertEntregaDoc="INSERT INTO ENTREGAS_DOC
                (titulo, descripcion, entrega_id, doc_path) 
                SELECT titulo, descripcion, '".$nuevaEntrega."' as entrega_id, doc_path FROM ENTREGAS_DOC WHERE entrega_id=".$_POST["entregas_duplientrega"];
        $resInsertEntregaDoc = mysqli_query($connString, $sqlInsertEntregaDoc) or die("Error al duplicar ENTREGAS_DOC (insert-duplicado).");
        
        // Duplicar ENSAYOS
        $sqlInsertEnsayo="INSERT INTO ENSAYOS
                (entrega_id, nombre, descripcion, fecha, fecha_finalizacion, estado_id, erp_userid, plantilla_id)
                SELECT '".$nuevaEntrega."' as entrega_id, nombre, descripcion, fecha, fecha_finalizacion, estado_id, erp_userid, plantilla_id FROM ENSAYOS
                WHERE entrega_id=".$_POST["entregas_duplientrega"];
        $resInsertEnsayo = mysqli_query($connString, $sqlInsertEnsayo) or die("Error al duplicar ENSAYOS (insert-duplicado).");
        
        echo $nuevaEntrega;
    }
?>
	