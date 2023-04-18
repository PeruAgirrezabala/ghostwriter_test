<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    if ($_POST['proyecto_id'] != "") {
        getMaterialesProyecto();
    }    
    else {
        // ?¿
    }
    
    function getMaterialesProyecto(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $tohtml="";
        
        $criterioinicial = " SELECT ENVIOS_CLI_DETALLES.pedido_detalle_id FROM ENVIOS_CLI_DETALLES WHERE pedido_detalle_id!=0 OR pedido_detalle_id!='' ";
        
        if($_POST['criterio']!=""){
            $criteriosql= " AND (MATERIALES.nombre LIKE '%".$_POST['criterio']."%' OR PEDIDOS_PROV.pedido_genelek LIKE '%".$_POST['criterio']."%' OR MATERIALES.ref LIKE '%".$_POST['criterio']."%')";
        }else{
            $criteriosql="";
        }
        $tohtml.="<option value='' data-stock='' ></option>";
        
        if($_POST['proyecto_id']<0){
            $sql="SELECT MATERIALES_STOCK.id, 
                    MATERIALES_STOCK.material_id, 
                    MATERIALES_STOCK.stock, 
                    MATERIALES_STOCK.ubicacion_id, 
                    MATERIALES_STOCK.proyecto_id, 
                    MATERIALES_STOCK.pedido_detalle_id, 
                    MATERIALES.ref, 
                    MATERIALES.nombre,
                    PEDIDOS_PROV.pedido_genelek
                    FROM 
                    MATERIALES_STOCK
                    INNER JOIN MATERIALES 
                    ON MATERIALES_STOCK.material_id = MATERIALES.id
                    INNER JOIN PEDIDOS_PROV_DETALLES
                    ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                    INNER JOIN PEDIDOS_PROV
                    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
                    WHERE (MATERIALES_STOCK.proyecto_id=10
                    OR MATERIALES_STOCK.proyecto_id=11) 
                    AND MATERIALES_STOCK.pedido_detalle_id NOT IN(".$criterioinicial.") ".$criteriosql;
            file_put_contents("selectMaterialesAlmacen.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
            //$row = mysqli_fetch_row ($result);
//            $tohtml.="<option value='' data-stock='' ></option>";
            while($row = mysqli_fetch_row ($result)){
                $tohtml.="<option value='".$row[5]."'>[".$row[8]."][".$row[2]."u.] - ".$row[7]."</option>";
            }
        }elseif($_POST['proyecto_id']==0){
            $sql="SELECT 
                    MATERIALES_STOCK.id, 
                    MATERIALES_STOCK.material_id, 
                    MATERIALES_STOCK.stock, 
                    MATERIALES_STOCK.ubicacion_id, 
                    MATERIALES_STOCK.proyecto_id, 
                    MATERIALES_STOCK.pedido_detalle_id, 
                    MATERIALES.ref, 
                    MATERIALES.nombre,
                    PEDIDOS_PROV.pedido_genelek
                    FROM 
                    MATERIALES_STOCK
                    INNER JOIN MATERIALES 
                    ON MATERIALES_STOCK.material_id = MATERIALES.id
                    INNER JOIN PEDIDOS_PROV_DETALLES
                    ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                    INNER JOIN PEDIDOS_PROV
                    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
                    AND MATERIALES_STOCK.pedido_detalle_id NOT IN(".$criterioinicial.") ".$criteriosql;
            file_put_contents("selectMaterialesProyecto0.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
            //$row = mysqli_fetch_row ($result);
//            $tohtml.="<option value='' data-stock='' >--------1---------</option>";
            while($row = mysqli_fetch_row ($result)){
                $tohtml.="<option value='".$row[5]."'>[".$row[8]."] - ".$row[7]."</option>";
            }
        }else{
            
            $criterioMaterialesAgrupados="SELECT 
                    MATERIALES_STOCK.id
                    FROM 
                    MATERIALES_STOCK
                    INNER JOIN MATERIALES 
                    ON MATERIALES_STOCK.material_id = MATERIALES.id
					INNER JOIN MATERIALES_GRUPOS
                    ON MATERIALES_GRUPOS.materiales_stock_id = MATERIALES_STOCK.id
					INNER JOIN MATERIALES_GRUPOS_NOMBRES
                    ON MATERIALES_GRUPOS.grupos_nombres_id = MATERIALES_GRUPOS_NOMBRES.id
                    WHERE MATERIALES_STOCK.proyecto_id=".$_POST['proyecto_id'];
        
            // Carga sin grupos
            $sql="SELECT 
                    MATERIALES_STOCK.id, 
                    MATERIALES_STOCK.material_id, 
                    MATERIALES_STOCK.stock, 
                    MATERIALES_STOCK.ubicacion_id, 
                    MATERIALES_STOCK.proyecto_id, 
                    MATERIALES_STOCK.pedido_detalle_id, 
                    MATERIALES.ref, 
                    MATERIALES.nombre,
                    PEDIDOS_PROV.pedido_genelek
                    FROM 
                    MATERIALES_STOCK
                    INNER JOIN MATERIALES 
                    ON MATERIALES_STOCK.material_id = MATERIALES.id
                    INNER JOIN PEDIDOS_PROV_DETALLES
                    ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                    INNER JOIN PEDIDOS_PROV
                    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
                    WHERE MATERIALES_STOCK.proyecto_id=".$_POST['proyecto_id']."
                    AND MATERIALES_STOCK.pedido_detalle_id NOT IN(".$criterioinicial.")
                    AND MATERIALES_STOCK.id NOT IN(".$criterioMaterialesAgrupados.") ".$criteriosql;
            
            file_put_contents("selectMaterialesProyecto.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Detalle");
            //$row = mysqli_fetch_row ($result);
//            $tohtml.="<option value='' data-stock='' >--------2---------</option>";
            while($row = mysqli_fetch_row ($result)){
                $tohtml.="<option value='".$row[5]."'>[".$row[8]."][".$row[2]."u.] - ".$row[7]."</option>";
            }
            // Cargar Grupos
            $sqlGrupos="SELECT 
                    MATERIALES_STOCK.id, 
                    MATERIALES_STOCK.material_id, 
                    MATERIALES_STOCK.stock, 
                    MATERIALES_STOCK.ubicacion_id, 
                    MATERIALES_STOCK.proyecto_id, 
                    MATERIALES_STOCK.pedido_detalle_id, 
                    MATERIALES.ref, 
                    MATERIALES.nombre,
                    PEDIDOS_PROV.pedido_genelek,
                    MATERIALES_GRUPOS.id as grupodetalle_id,
                    MATERIALES_GRUPOS_NOMBRES.id as grupo_id,
                    MATERIALES_GRUPOS_NOMBRES.nombre
                    FROM 
                    MATERIALES_STOCK
                    INNER JOIN MATERIALES 
                    ON MATERIALES_STOCK.material_id = MATERIALES.id
                    INNER JOIN PEDIDOS_PROV_DETALLES
                    ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                    INNER JOIN PEDIDOS_PROV
                    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
                    INNER JOIN MATERIALES_GRUPOS
                    ON MATERIALES_GRUPOS.materiales_stock_id = MATERIALES_STOCK.id
                    INNER JOIN MATERIALES_GRUPOS_NOMBRES
                    ON MATERIALES_GRUPOS.grupos_nombres_id = MATERIALES_GRUPOS_NOMBRES.id
                    WHERE MATERIALES_STOCK.proyecto_id=".$_POST['proyecto_id']."
                    AND MATERIALES_STOCK.pedido_detalle_id NOT IN(".$criterioinicial.") ".$criteriosql;
            file_put_contents("selectMaterialesProyectoGrupos.txt", $sqlGrupos);
            $resultGrupos = mysqli_query($connString, $sqlGrupos) or die("Error al guardar el Detalle");
            //$row = mysqli_fetch_row ($result);
//            $tohtml.="<option value='' data-stock='' >--------3---------</option>";
            while($row = mysqli_fetch_row ($resultGrupos)){
                $tohtml.="<option value='".$row[5]."'>[".$row[8]."][".$row[2]."u.][".$row[11]."] - ".$row[7]."</option>";
            }
            // Carga Material Añadido de almacen
//            $sqlAdded="SELECT 
//                    MATERIALES_STOCK.id, 
//                    MATERIALES_STOCK.material_id, 
//                    MATERIALES_STOCK.stock, 
//                    MATERIALES_STOCK.ubicacion_id, 
//                    MATERIALES_STOCK.proyecto_id, 
//                    MATERIALES_STOCK.pedido_detalle_id, 
//                    MATERIALES.ref, 
//                    MATERIALES.nombre,
//                    PEDIDOS_PROV.pedido_genelek
//                    FROM 
//                    MATERIALES_STOCK
//                    INNER JOIN MATERIALES 
//                    ON MATERIALES_STOCK.material_id = MATERIALES.id
//                    INNER JOIN PEDIDOS_PROV_DETALLES
//                    ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
//                    INNER JOIN PEDIDOS_PROV
//                    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
//                    WHERE MATERIALES_STOCK.proyecto_id=".$_POST['proyecto_id']."
//                    AND PEDIDOS_PROV_DETALLES.proyecto_id=11
//                    AND MATERIALES_STOCK.pedido_detalle_id NOT IN(".$criterioinicial.")
//                    AND MATERIALES_STOCK.id NOT IN(".$criterioMaterialesAgrupados.") ".$criteriosql;
//            file_put_contents("selectMaterialesAñadidosAlmacen.txt", $sqlAdded);
//            $resultGrupos = mysqli_query($connString, $sqlAdded) or die("Error al guardar el Detalle");
//            //$row = mysqli_fetch_row ($result);
//            $tohtml.="<option value='' data-stock='' >--------4---------</option>";
//            while($row = mysqli_fetch_row ($resultGrupos)){
//                $tohtml.="<option value='".$row[5]."'>[".$row[8]."][".$row[2]."u.] - ".$row[7]."</option>";
//            }
        }
        echo $tohtml;
    }
?>
