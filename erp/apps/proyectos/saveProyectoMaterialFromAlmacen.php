
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    //file_put_contents("debug0.txt", "AQUI");
    
    if($_POST["materiales_stock_ids"] != ""){
        addFromAlmacen();
    }else{
        if($_POST["mat_stock_id"] != ""){
            divideFromAlmacenModal();
        }else{
            if($_POST["cant_divi"] != ""){
                divideFromAlmacen();
            }else{
                if($_POST["actualizar"] != ""){
                    reloadMaterialAlmacen();
                }else{
                    if($_POST["del_mat_alm"] != ""){
                        delMatAlmacen();
                    }else{
                        if($_POST["del_mat_grup"] != ""){
                            delMatGroup();
                        }else{
                            if($_POST["load_grupo_detalles"] != ""){
                                loadDetallesGrupo();
                            }else{
                                if($_POST["del_mat1_grup"] != ""){
                                    delMat1Group();
                                }else{
                                    if($_POST["check_materiales"] != ""){
                                        checkMatExistGroup();
                                    }else{
                                        if($_POST["load_divi_mat_asign"] != ""){
                                            loadModalDiviMatAsignado();
                                        }else{
                                            if($_POST["divi_mat_asign"] != ""){
                                                diviMatAsignado();
                                            }else{
                                                if($_POST["devolver_materiales"] != ""){
                                                    devolverMateriales();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    function addFromAlmacen(){
        $db = new dbObj();
        $connString =  $db->getConnstring();

        $materiales_stock_ids_array =$_POST["materiales_stock_ids"];
        //file_put_contents("logs.txt", count($materiales_stock_ids_array));
        foreach($materiales_stock_ids_array as $material_stock_id){
            $sql = "UPDATE MATERIALES_STOCK 
                    SET proyecto_id = ".$_POST['proyecto_id']."
                    WHERE id = ".$material_stock_id;
            //file_put_contents("updateMaterialesStock.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al actualizar valores de material stock");
        }


        //mysqli_set_charset($connString, "utf8");

        echo 1;
    }
    
    function divideFromAlmacenModal(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
                // Dividir pedidos del Almacén
               $tohtml = '
                    <div class="modal-dialog dialog_mini">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" style="display: inline-block;">DIVIDIR MATERIAL DEL ALMACÉN AL PROYECTO</h4>
                            </div>
                            <div class="modal-body">
                                <div class="contenedor-form">
                                    <form method="post" id="frm_add_posiciones" enctype="multipart/form-data">
                                        <input type="hidden" name="materiales_stock_id" id="materiales_stock_id" value="">
                                        <h3>Indica las unidades a añadir: </h3>
                                        <div class="col-xs-3">
                                       <select id="select_div_ped_alm" name="select_div_ped_alm" class="selectpicker" data-live-search="true" data-width="33%">
                            ';
                        
                            $sql = "SELECT
                                        MATERIALES_STOCK.stock
                                    FROM 
                                        MATERIALES_STOCK
                                    WHERE
                                        MATERIALES_STOCK.id=".$_POST["mat_stock_id"];
                            //file_put_contents("selectMaterialesStockN.txt", $sql);
                            $res = mysqli_query($connString, $sql) or die("Error Select Materiales Stock.");
                            
                            $row = mysqli_fetch_array($res);
                            $num = intval($row[0]);
                            //$row[0];
                            for($i=1; $i<$num; $i++){
                                $tohtml.="<option id='opcion_".$i."' value=".$i.">".$i."</option>";
                            }
                            // From 1 to row0-1

                    $tohtml .= '</select></div></form>
                            </div>
                        </div>
                        <div class="modal-footer" style="margin-top: 50px;">
                            <button type="button" id="btn_divi_stock_from_almacen" class="btn btn-warning">Dividir y Agregar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            ';
                    
                    echo $tohtml;
    
    }
    
    function divideFromAlmacen(){
        
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT
                    MATERIALES_STOCK.id,
                    MATERIALES_STOCK.material_id,
                    MATERIALES_STOCK.stock,
                    MATERIALES_STOCK.ubicacion_id,
                    MATERIALES_STOCK.proyecto_id,
                    MATERIALES_STOCK.pedido_detalle_id
                FROM
                    MATERIALES_STOCK
                WHERE
                    MATERIALES_STOCK.id=".$_POST["mat_stock_id2"];
        //file_put_contents("selectMaterialesStockN.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error Select Materiales Stock.");                
        $row = mysqli_fetch_array($res);
        
        $newStock=$row[2]-$_POST["cant_divi"];
        
        $sqlUpdate="UPDATE MATERIALES_STOCK
                    SET MATERIALES_STOCK.stock=".$newStock." WHERE MATERIALES_STOCK.id=".$_POST["mat_stock_id2"];
        //file_put_contents("updateMaterialesStockDiv.txt", $sqlUpdate);
        $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error Update Materiales Stock.");
        
        $sqlInsert="INSERT INTO
                MATERIALES_STOCK ( material_id, stock, ubicacion_id, proyecto_id, pedido_detalle_id) 
                VALUES (".$row[1].",".$_POST["cant_divi"].",".$row[3].",".$row[4].",".$row[5].")";
        //file_put_contents("insertMaterialesStockDiv.txt", $sqlInsert);
        $resInsert = mysqli_query($connString, $sqlInsert) or die("Error Insert Materiales Stock.");
        
        $idMatStockNew = mysqli_insert_id($connString);
        $sql = "UPDATE MATERIALES_STOCK 
                    SET proyecto_id = ".$_POST['proyecto_id']."
                    WHERE id = ".$idMatStockNew;
        //file_put_contents("updateMaterialesStock2.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al actualizar valores de material stock");
    }
    // Borrar cuando se ponga el filtro nuevo (04/02/2021)
    function reloadMaterialAlmacenOLD(){
        
        
        $tohtml= '<form method="post" id="frm_add_posiciones" enctype="multipart/form-data">
                        <input type="hidden" name="posiciones_proyecto_id" id="posiciones_proyecto_id" value="'.$_GET["id"].'">

                        <div class="form-group" id="tabla-materiales">
                            <table class="table table-striped table-condensed table-hover" id="tabla-materiales-almacen">
                                <thead>
                                    <tr class="bg-dark">
                                        <th class="text-center">S</th>
                                        <th class="text-center">REF</th>
                                        <th class="text-center">MATERIAL</th>
                                        <th class="text-center">FABRICANTE</th>
                                        <th class="text-center">MODELO</th>
                                        <th class="text-center">DESCUENTO</th>
                                        <th class="text-center">STOCK</th>
                                        <th class="text-center">PVP</th>
                                        <th class="text-center">CADUCIDAD</th>
                                        <th class="text-center">SUSTITUTO</th>
                                        <th class="text-center">D</th>
                                </thead>
                                <tbody>';
        
                            $db = new dbObj();
                            $connString =  $db->getConnstring();
                            
                            if($_POST["valor"]==0){
                                $condicion="";
                            }else{
                                $condicion="AND MATERIALES_STOCK.id=".$_POST["valor"];
                            }
                            
                            
                            $sql = "SELECT
                                        MATERIALES.id,
                                        MATERIALES.ref,
                                        MATERIALES.nombre,
                                        MATERIALES.fabricante,
                                        MATERIALES.modelo,
                                        MATERIALES.DTO2,
                                        MATERIALES_STOCK.stock,
                                        MATERIALES.cad,
                                        MATERIALES.sustituto,
                                        MATERIALES_STOCK.pedido_detalle_id,
                                        MATERIALES_STOCK.id
                                    FROM 
                                        MATERIALES, MATERIALES_STOCK
                                    WHERE
                                        MATERIALES.id = MATERIALES_STOCK.material_id
                                    AND
                                        MATERIALES_STOCK.ubicacion_id = 1
                                    AND  
                                        MATERIALES_STOCK.proyecto_id = 11 ".$condicion;
                            //file_put_contents("SelectMateriales.txt", $sql);
                            $res = mysqli_query($connString, $sql) or die("Error Select Materiales");
                            while( $row = mysqli_fetch_array($res) ) {
                                // SELECT MATERIALES_PRECIOS.pvp FROM MATERIALES_PRECIOS WHERE material_id = 3837 ORDER BY fecha_val DESC LIMIT 1
                            
                                $sql2 = "SELECT MATERIALES_PRECIOS.pvp, MATERIALES_PRECIOS.id FROM MATERIALES_PRECIOS WHERE MATERIALES_PRECIOS.material_id = ".$row[0]." ORDER BY fecha_val DESC LIMIT 1";
                                //file_put_contents("SelectMaterialesPrecios.txt", $sql2);
                                $res2 = mysqli_query($connString, $sql2) or die("Error Select Materiales Precios");
                                
                                //file_put_contents("stock.txt", $sql);
                                //$res = mysqli_query($connString, $sql) or die("database error:");
                                $contador=0;
                                    while( $row2 = mysqli_fetch_array($res2) ) {
                                        $contador++;
                                        // if count 1 no
                                        if($row[6]>1){
                                            $imgDividir='<img src="/erp/img/dividido.png" height="20" id="ver_dividir_pedido_almacen" title="Dividir Pedido del Almacén">';
                                        }else{
                                            $imgDividir='';
                                        }
                                        
                                        $tohtml .= "
                                                <tr data-id='".$row[9]."' data-id2='".$row[10]."'>
                                                    <td class='text-center atributos-material'>
                                                        <input type='checkbox' class='pos-to-project' data-matid='".$row[0]."' value='".$row[0]."' name='posiciones[".$contador."][pos-to-project]'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_unidades]' value='".$row[6]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_tarifa_id]' value='".$row2[1]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_prov_detalle_id]' value='".$row[9]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_mat_stock_id]' value='".$row[10]."'>
                                                    </td>
                                                    <td class='text-left'>".$row[1]."</td>
                                                    <td class='text-left'>".$row[2]."</td>
                                                    <td class='text-center'>".$row[3]."</td>
                                                    <td class='text-center'>".$row[4]."</td>
                                                    <td class='text-right'>".$row[5]."%</td>
                                                    <td class='text-center'>".$row[6]."</td>
                                                    <td class='text-center'>".$row2[0]."</td>
                                                    <td class='text-center'>".$row[8]."</td>
                                                    <td class='text-center'>".$row[9]."</td>
                                                    <td class='text-center'>".$imgDividir."</td>
                                                </tr>";
                                    }
                            
                            }
                            
                        $tohtml.='</tbody></table></div></form>';
                        echo $tohtml;
    }
    
    function reloadMaterialAlmacen(){
        
        
        $tohtml= '<form method="post" id="frm_add_posiciones" enctype="multipart/form-data">
                        <input type="hidden" name="posiciones_proyecto_id" id="posiciones_proyecto_id" value="'.$_GET["id"].'">

                        <div class="form-group" id="tabla-materiales">
                            <table class="table table-striped table-condensed table-hover" id="tabla-materiales-almacen">
                                <thead>
                                    <tr class="bg-dark">
                                        <th class="text-center">S</th>
                                        <th class="text-center">REF</th>
                                        <th class="text-center">MATERIAL</th>
                                        <th class="text-center">FABRICANTE</th>
                                        <th class="text-center">MODELO</th>
                                        <th class="text-center">DESCUENTO</th>
                                        <th class="text-center">STOCK</th>
                                        <th class="text-center">PVP</th>
                                        <th class="text-center">CADUCIDAD</th>
                                        <th class="text-center">SUSTITUTO</th>
                                        <th class="text-center">D</th>
                                </thead>
                                <tbody>';
        
                            $db = new dbObj();
                            $connString =  $db->getConnstring();
                            
                            if($_POST["valor"]==""){
                                $condicion="";
                            }else{
                                $condicion="AND ( MATERIALES.ref LIKE '%".$_POST["valor"]."%' OR MATERIALES.nombre LIKE '%".$_POST["valor"]."%')";
                            }
                            
                            
                            $sql = "SELECT
                                        MATERIALES.id,
                                        MATERIALES.ref,
                                        MATERIALES.nombre,
                                        MATERIALES.fabricante,
                                        MATERIALES.modelo,
                                        MATERIALES.DTO2,
                                        MATERIALES_STOCK.stock,
                                        MATERIALES.cad,
                                        MATERIALES.sustituto,
                                        MATERIALES_STOCK.pedido_detalle_id,
                                        MATERIALES_STOCK.id
                                    FROM 
                                        MATERIALES, MATERIALES_STOCK
                                    WHERE
                                        MATERIALES.id = MATERIALES_STOCK.material_id
                                    AND
                                        MATERIALES_STOCK.ubicacion_id = 1
                                    AND  
                                        MATERIALES_STOCK.proyecto_id = 11 ".$condicion;
                            //file_put_contents("SelectMateriales.txt", $sql);
                            $res = mysqli_query($connString, $sql) or die("Error Select Materiales");
                            while( $row = mysqli_fetch_array($res) ) {
                                // SELECT MATERIALES_PRECIOS.pvp FROM MATERIALES_PRECIOS WHERE material_id = 3837 ORDER BY fecha_val DESC LIMIT 1
                            
                                $sql2 = "SELECT MATERIALES_PRECIOS.pvp, MATERIALES_PRECIOS.id FROM MATERIALES_PRECIOS WHERE MATERIALES_PRECIOS.material_id = ".$row[0]." ORDER BY fecha_val DESC LIMIT 1";
                                //file_put_contents("SelectMaterialesPrecios.txt", $sql2);
                                $res2 = mysqli_query($connString, $sql2) or die("Error Select Materiales Precios");
                                
                                //file_put_contents("stock.txt", $sql);
                                //$res = mysqli_query($connString, $sql) or die("database error:");
                                $contador=0;
                                    while( $row2 = mysqli_fetch_array($res2) ) {
                                        $contador++;
                                        // if count 1 no
                                        if($row[6]>1){
                                            $imgDividir='<img src="/erp/img/dividido.png" height="20" id="ver_dividir_pedido_almacen" title="Dividir Pedido del Almacén">';
                                        }else{
                                            $imgDividir='';
                                        }
                                        
                                        $tohtml .= "
                                                <tr data-id='".$row[9]."' data-id2='".$row[10]."'>
                                                    <td class='text-center atributos-material'>
                                                        <input type='checkbox' class='pos-to-project' data-matid='".$row[0]."' value='".$row[0]."' name='posiciones[".$contador."][pos-to-project]'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_unidades]' value='".$row[6]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_tarifa_id]' value='".$row2[1]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_prov_detalle_id]' value='".$row[9]."'>
                                                        <input type='hidden' name='posiciones[".$contador."][pos_mat_stock_id]' value='".$row[10]."'>
                                                    </td>
                                                    <td class='text-left'>".$row[1]."</td>
                                                    <td class='text-left'>".$row[2]."</td>
                                                    <td class='text-center'>".$row[3]."</td>
                                                    <td class='text-center'>".$row[4]."</td>
                                                    <td class='text-right'>".$row[5]."%</td>
                                                    <td class='text-center'>".$row[6]."</td>
                                                    <td class='text-center'>".$row2[0]."</td>
                                                    <td class='text-center'>".$row[8]."</td>
                                                    <td class='text-center'>".$row[9]."</td>
                                                    <td class='text-center'>".$imgDividir."</td>
                                                </tr>";
                                    }
                            
                            }
                            
                        $tohtml.='</tbody></table></div></form>';
                        echo $tohtml;
    }
    
    function delMatAlmacen(){
        // Desasignar Material previamente asignado desde almacen al proyecto
        $db = new dbObj();
        $connString =  $db->getConnstring();
        //file_put_contents("logs.txt", count($materiales_stock_ids_array));
        $sql = "UPDATE MATERIALES_STOCK 
                SET proyecto_id = 11
                WHERE pedido_detalle_id = ".$_POST["del_mat_alm"];
        //file_put_contents("updateMaterialesStock.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al actualizar valores de material stock");
        //mysqli_set_charset($connString, "utf8");
        echo 1;
    }
    
    function delMatGroup(){
        // Borrar el grupo y todas las referencias del grupo (2 tablas a del)
        // $_POST["del_mat_grup"];
        $db = new dbObj();
        $connString =  $db->getConnstring();
        //file_put_contents("logs.txt", count($materiales_stock_ids_array));
        $sql = "DELETE FROM MATERIALES_GRUPOS_NOMBRES 
                WHERE MATERIALES_GRUPOS_NOMBRES.id = ".$_POST["del_mat_grup"];
        //file_put_contents("deleteMatGrupNom.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al borrar material grupos nombres");
        
        $sql = "DELETE FROM MATERIALES_GRUPOS 
                WHERE MATERIALES_GRUPOS.grupos_nombres_id = ".$_POST["del_mat_grup"];
        //file_put_contents("deleteMatGrup.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al borrar material grupos");
        
        echo 1;
    }
    
    function delMat1Group(){
        // Borrar el material del grupo
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // Sacar su pedido_detalle_id
        $sqlSel = "SELECT MATERIALES_GRUPOS.pedido_detalle_id FROM MATERIALES_GRUPOS WHERE MATERIALES_GRUPOS.id=".$_POST["del_mat1_grup"];
        //file_put_contents("selectMaterialesGrupos.txt", $sqlSel);
        $result = mysqli_query($connString, $sqlSel) or die("Error al seleccionar detalles del grupo");
        $row = mysqli_fetch_array($result);
        // Actualizar entrega_id
        $sqlSel = "UPDATE PEDIDOS_PROV_DETALLES SET PEDIDOS_PROV_DETALLES.entrega_id=0 WHERE PEDIDOS_PROV_DETALLES.id=".$row[0];
        $result = mysqli_query($connString, $sqlSel) or die("Error al actualizar entrega_id de PEDIDOS_PROV_DETALLES");
        
        $sql = "DELETE FROM MATERIALES_GRUPOS 
                WHERE MATERIALES_GRUPOS.id = ".$_POST["del_mat1_grup"];
        //file_put_contents("deleteMat1GrupNom.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al borrar material del grupo");
        
        echo 1;
    }
    
    function loadDetallesGrupo(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql="SELECT MATERIALES_GRUPOS.pedido_detalle_id FROM MATERIALES_GRUPOS WHERE MATERIALES_GRUPOS.grupos_nombres_id=".$_POST["id_grupo"];
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar detalles del grupo");
        
        while( $row = mysqli_fetch_array($result) ) {
            $id_detalles.=$row[0]."-";
        }
        echo $id_detalles;
    }
    
    function checkMatExistGroup(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $checkMateriales = array_map('intval', explode('-', $_POST['check_materiales']));
        $proyecto = $_POST["check_proyecto_id"];
        
        $existe=false;        
        $arrayNuevos = [];
        
        // Check si existe
        foreach ($checkMateriales as $det_id) {
            $sqlCheck = "SELECT
                        MATERIALES_GRUPOS.id,
                        MATERIALES_GRUPOS.materiales_stock_id,
                        MATERIALES_GRUPOS.pedido_detalle_id,
                        MATERIALES_GRUPOS.grupos_nombres_id
                        FROM MATERIALES_GRUPOS WHERE MATERIALES_GRUPOS.pedido_detalle_id=".$det_id;
            //file_put_contents("selectExisteGrupo.txt", $sqlCheck);
            $resultado = mysqli_query($connString, $sqlCheck) or die("Error al seleccionar si existe grupo.");
            $numfilas=mysqli_num_rows($resultado);
            if($numfilas==1){
                $row = mysqli_fetch_array($resultado);
                $existe=true;
                $numGrup=$row[3];
            }else{
                array_push($arrayNuevos, $det_id);
            }
        }
        // En base al check insertar o no!
        if($existe){
            foreach ($arrayNuevos as $idnuevos) {
                $sqlGetId="SELECT MATERIALES_STOCK.id FROM MATERIALES_STOCK WHERE MATERIALES_STOCK.pedido_detalle_id=".$idnuevos;
                //file_put_contents("selectIDStock.txt", $sqlGetId);
                $resGetId = mysqli_query($connString, $sqlGetId) or die("Error al seleccionar id de Stock.");
                $rowGetId = mysqli_fetch_array($resGetId);
                
                $sqlInsert="INSERT INTO MATERIALES_GRUPOS 
                            (materiales_stock_id, pedido_detalle_id, grupos_nombres_id) 
                            VALUES (".$rowGetId[0].",".$idnuevos.",".$numGrup.")";
                //file_put_contents("updateGrupos.txt", $sqlInsert);
                $resInsert = mysqli_query($connString, $sqlInsert) or die("Error al realizar update");
            }
            echo "SI";
        }else{
            echo "NO";
        }
        
        
    }
    
    function loadModalDiviMatAsignado(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $tohtml='<div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DIVIDIR MATERIAL ASIGNADO</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="divi_mat_asign" id="divi_mat_asign" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">';
        
                    $tohtml .= '<h3>Selecciona partes a dividir: </h3>
                        <div class="col-xs-3">
                        <select id="select_div_ped_asig" name="select_div_ped_asig" class="selectpicker" data-live-search="true" data-width="33%">';
                        
                            $sql = "SELECT MATERIALES_STOCK.stock
                                    FROM MATERIALES_STOCK
                                    WHERE MATERIALES_STOCK.pedido_detalle_id =".$_POST["load_divi_mat_asign"];
                            //file_put_contents("selectStockMat.txt", $sql);
                            $res = mysqli_query($connString, $sql) or die("Error Select Pedidos Prov DETALLES.");
                            
                            $row = mysqli_fetch_array($res);
                            $num = intval($row[0]);
                            //$row[0];
                            for($i=1; $i<$num; $i++){
                                $tohtml.="<option id='opcion_".$i."' value=".$i.">".$i."</option>";
                            }
                            // From 1 to row0-1
                        $tohtml.='</select></div></form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_divi_mat_asign" class="btn btn-warning">Dividir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>';
        
        
        echo $tohtml;
        
    }
    
    function diviMatAsignado(){
        $id_detalle=$_POST["divi_mat_asign"];
        $cant=$_POST["cant"];
        
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        
        // ACTUALIZAR PEDIDOS DETALLES
        $sql="SELECT 
            PEDIDOS_PROV_DETALLES.pedido_id, 
            PEDIDOS_PROV_DETALLES.material_id, 
            PEDIDOS_PROV_DETALLES.almacen, 
            PEDIDOS_PROV_DETALLES.unidades, 
            PEDIDOS_PROV_DETALLES.detalle_libre, 
            PEDIDOS_PROV_DETALLES.recibido, 
            PEDIDOS_PROV_DETALLES.fecha_recepcion, 
            PEDIDOS_PROV_DETALLES.plazo, 
            PEDIDOS_PROV_DETALLES.dto, 
            PEDIDOS_PROV_DETALLES.fecha_entrega, 
            PEDIDOS_PROV_DETALLES.proyecto_id, 
            PEDIDOS_PROV_DETALLES.material_tarifa_id, 
            PEDIDOS_PROV_DETALLES.ref, 
            PEDIDOS_PROV_DETALLES.pvp, 
            PEDIDOS_PROV_DETALLES.descripcion, 
            PEDIDOS_PROV_DETALLES.dto_prov_activo, 
            PEDIDOS_PROV_DETALLES.dto_mat_activo, 
            PEDIDOS_PROV_DETALLES.dto_ad_activo, 
            PEDIDOS_PROV_DETALLES.dto_prov_id, 
            PEDIDOS_PROV_DETALLES.entrega_id, 
            PEDIDOS_PROV_DETALLES.dto_prov_prior, 
            PEDIDOS_PROV_DETALLES.dto_mat_prior, 
            PEDIDOS_PROV_DETALLES.dto_ad_prior, 
            PEDIDOS_PROV_DETALLES.erp_userid, 
            PEDIDOS_PROV_DETALLES.iva_id, 
            PEDIDOS_PROV_DETALLES.cliente_id
            FROM 
            PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.id=".$id_detalle;
        //file_put_contents("selectDetalles.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error Select Pedidos Prov DETALLES.");
        $row = mysqli_fetch_array($res);
        
        
        $sqlUpdate="UPDATE PEDIDOS_PROV_DETALLES SET PEDIDOS_PROV_DETALLES.unidades=".($row[3]-$cant)." WHERE PEDIDOS_PROV_DETALLES.id=".$id_detalle;
        //file_put_contents("updateDetalles.txt", $sqlUpdate);
        $resUpdate = mysqli_query($connString, $sqlUpdate) or die("Error Update Pedidos Prov DETALLES.");
        
        if($row[2]==""){
            $almacen=null;
        }else{
            $almacen=$row[2];
        }
        if($row[4]==""){
            $detalle_libre=null;
        }else{
            $detalle_libre=$row[4];
        }
        if($row[7]==""){
            $plazo=null;
        }else{
            $plazo=$row[7];
        }
        if($row[13]==""){
            $pvp=0;
        }else{
            $pvp=$row[13];
        }
        if($row[14]==""){
            $desc=null;
        }else{
            $desc=$row[14];
        }
        if($row[18]==""){
            $dto_prov_id=0;
        }else{
            $dto_prov_id=$row[18];
        }
        if($row[19]==""){
            $entrega_id=0;
        }else{
            $entrega_id=$row[19];
        }
        
        $sqlInsert= "INSERT INTO
                    PEDIDOS_PROV_DETALLES
                    (pedido_id, 
                    material_id, 
                    almacen, 
                    unidades, 
                    detalle_libre, 
                    recibido, 
                    fecha_recepcion, 
                    plazo, 
                    dto, 
                    fecha_entrega, 
                    proyecto_id, 
                    material_tarifa_id, 
                    ref, 
                    pvp, 
                    descripcion, 
                    dto_prov_activo, 
                    dto_mat_activo, 
                    dto_ad_activo, 
                    dto_prov_id, 
                    entrega_id, 
                    dto_prov_prior, 
                    dto_mat_prior, 
                    dto_ad_prior, 
                    erp_userid, 
                    iva_id, 
                    cliente_id) 
                    VALUES (
                    ".$row[0].",
                    ".$row[1].",
                    '".$almacen."',
                    ".$cant.",
                    '".$detalle_libre."',
                    ".$row[5].",
                    '".$row[6]."',
                    '".$plazo."',
                    ".$row[8].",
                    '".$row[9]."',
                    ".$row[10].",
                    ".$row[11].",
                    '".$row[12]."',
                    ".$pvp.",
                    '".$desc."',
                    ".$row[15].",
                    ".$row[16].",
                    ".$row[17].",
                    ".$dto_prov_id.",
                    ".$entrega_id.",
                    ".$row[20].",
                    ".$row[21].",
                    ".$row[22].",
                    ".$row[23].",
                    ".$row[24].",
                    ".$row[25].")";
        //file_put_contents("insertDetalles.txt", $sqlInsert);
        $resInsert = mysqli_query($connString, $sqlInsert) or die("Error Insert Pedidos Prov DETALLES.");
        
        $idInsertado=mysqli_insert_id($connString);
        // / ACTULIZAR DETALLES
        
        // ACTUALIZAR MATERIALES
        $sql="SELECT 
            MATERIALES_STOCK.material_id,
            MATERIALES_STOCK.stock,
            MATERIALES_STOCK.ubicacion_id,
            MATERIALES_STOCK.proyecto_id,
            MATERIALES_STOCK.pedido_detalle_id
            FROM 
            MATERIALES_STOCK
            WHERE MATERIALES_STOCK.pedido_detalle_id =".$id_detalle;
        //file_put_contents("selectMatStock.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error Select Materiales STOCK.");
        $row = mysqli_fetch_array($res);
        
        $sqlUpdate="UPDATE MATERIALES_STOCK SET MATERIALES_STOCK.stock=".($row[1]-$cant)." WHERE MATERIALES_STOCK.pedido_detalle_id=".$id_detalle;
        //file_put_contents("updateMatStock.txt", $sqlUpdate);
        $res = mysqli_query($connString, $sqlUpdate) or die("Error Update Materiales STOCK.");
        
        $sqlInsert="INSERT INTO MATERIALES_STOCK(material_id, stock, ubicacion_id, proyecto_id, pedido_detalle_id)
                    VALUES (".$row[0].",".$cant.",".$row[2].",".$row[3].",".$idInsertado.")";
        //file_put_contents("insertMatStock.txt", $sql);
        $res = mysqli_query($connString, $sqlInsert) or die("Error Insert Materiales STOCK.");
        
        echo 1;
        
        
    }
    
    function devolverMateriales(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $devMateriales = array_map('intval', explode('-', $_POST['devolver_materiales']));
        $proyectoid = $_POST["devolver_proyecto_id"];
        $trabajadorid = $_POST["devolver_idtrabajador"];
        $nombre = $_POST["devolver_nombre"];
        
        // Generar REF AUTOMÁTICAMENTE!!
        $sqlRef="SELECT SUBSTRING( ENVIOS_CLI.ref, 6, 4 ) AS anyo
                    FROM ENVIOS_CLI
                    WHERE SUBSTRING( ENVIOS_CLI.ref, 4, 2 ) =".substr(Date("Y"),2,4)." ORDER BY anyo DESC LIMIT 1";
        //file_put_contents("selectLastRef.txt", $sqlRef);
        $resultado = mysqli_query($connString, $sqlRef) or die("Error al seleccionar ultimo valor de ref del año.");
        $registros = mysqli_fetch_array($resultado);
        $ref = "ALB".substr(Date("Y"),2,4).str_pad(($registros[0]+1), 4, '0', STR_PAD_LEFT);  // Añadir ALB+AÑO+XXXX
        
        //creamos devolucion
        $sqlCrearDev='INSERT INTO ENVIOS_CLI
                    (
                    transportista_id, 
                    nombre, 
                    descripcion, 
                    tecnico_id, 
                    fecha, 
                    ref, 
                    estado_id, 
                    proyecto_id, 
                    path,
                    gastos_envio,
                    portes,
                    tipo_envio_id) 
                    VALUES 
                    (
                    1,"'.$nombre.'","",'.$trabajadorid.',"'.date("Y-m-d").'","'.$ref.'",2,'.$proyectoid.',"/'.date("Y").'/'.$ref.'",0,1,2
                    )';
        //file_put_contents("insertEnviosCli.txt", $sqlCrearDev);
        $resultado = mysqli_query($connString, $sqlCrearDev) or die("Error al crear la devolucion. ENVIOS_CLI.");
        
        $iddevolucion=mysqli_insert_id($connString);
        
        // Insertar detalles de envios y UPDATE de PEDIDO_PROV_DETALLE recibido=2
        foreach ($devMateriales as $det_id) {
            //$det_id;
            $sqlSelPedDet="SELECT
                            MATERIALES_STOCK.material_id,
                            MATERIALES_STOCK.stock
                          FROM MATERIALES_STOCK WHERE MATERIALES_STOCK.pedido_detalle_id=".$det_id;
            //file_put_contents("selectMaterialesStock.txt", $sqlSelPedDet);
            $resSel = mysqli_query($connString, $sqlSelPedDet) or die("Error al reealizar sleect de los pedidos detalles.");
            $row = mysqli_fetch_array($resSel);
            
            $sqlInsertDetalle = "INSERT INTO ENVIOS_CLI_DETALLES
                                    (envio_id, 
                                    material_id, 
                                    unidades, 
                                    entregado,
                                    proyecto_id,
                                    pedido_detalle_id)
                                VALUES
                                    (".$iddevolucion.",".$row[0].",".$row[1].",0,".$proyectoid.",".$det_id.")";
            //file_put_contents("insertEnviosCliDetalles.txt", $sqlInsertDetalle);
            $resInsert = mysqli_query($connString, $sqlInsertDetalle) or die("Error reealizar insert de detalles de la devolucion.");
            
            $sqlUpdatePedDet ="UPDATE PEDIDOS_PROV_DETALLES SET PEDIDOS_PROV_DETALLES.recibido=2 WHERE PEDIDOS_PROV_DETALLES.id=".$det_id;
            //file_put_contents("updatePedidosProvDetalles.txt", $sqlUpdatePedDet);
            $resUpdate = mysqli_query($connString, $sqlUpdatePedDet) or die("Error realizar el update de pedidos detalles a recibido=2 devolucion.");            
        }
        echo $iddevolucion;
    }
?>
	