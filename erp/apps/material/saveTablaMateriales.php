
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['actualizar'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        updateTablaMateriales();
    }    
    else {
        
    }
    
    function updateTablaMateriales() {
        $tohtml ="";
        $tohtml= ' <form method="post" id="frm_ViewStock">
                        <table class="table table-striped table-hover" id="tabla-stock">
                            <thead>
                                <tr class="bg-dark">
                                    <th class="text-center">ID</th>
                                    <th class="text-center">REF</th>
                                    <th class="text-center" style="max-width: 600px;">MATERIAL</th>
                                    <th class="text-center">FABRICANTE</th>
                                    <th class="text-center">MODELO</th>
                                    <th class="text-center">STOCK TOT.</th>
                                    <th class="text-center">STOCK ALM.</th>
                                    <th class="text-center">STOCK PTE.</th>
                                    <th class="text-center">VER</th>
                                </tr>
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
                                            SUM(MATERIALES_STOCK.stock) as stock
                                        FROM 
                                            MATERIALES, MATERIALES_STOCK
                                        WHERE
                                            MATERIALES.id=MATERIALES_STOCK.material_id
                                        AND
                                            MATERIALES_STOCK.ubicacion_id=1
                                        AND  
                                            MATERIALES_STOCK.proyecto_id=11
                                         ".$condicion."
                                        GROUP BY 
                                            MATERIALES.id,
                                            MATERIALES.ref";
                            
                            //file_put_contents("SelectMaterialesRefresh.txt", $sql);
                            $res = mysqli_query($connString, $sql) or die("Error Select Materiales");
                           while ($row = mysqli_fetch_array($res)) {
                                    $idMaterialStock = $row[0];
                                    $refMaterial = $row[1];
                                    $nombreMaterialStock = $row[2];
                                    $fabricanteMaterialStock = $row[3];
                                    $modeloMaterialStock = $row[4];
                                    $stockMaterialStock = $row[5];
                                    
                                    //$sql1 = "SELECT SUM(unidades) FROM PEDIDOS_PROV_DETALLES WHERE material_id=".$idMaterialStock." AND recibido=0";
                                    $sql1 = "SELECT SUM(STOCK) FROM MATERIALES_STOCK WHERE material_id=".$idMaterialStock." AND MATERIALES_STOCK.proyecto_id=11";
                                    file_put_contents("selectMaterialNoRecepcionadoEnAlmacen.txt", $sql1);
                                    $res1 = mysqli_query($connString, $sql1) or die("Error al ejecutar la consulta de material asignado al proyecto no recepcionado.");
                                    
                                    $row1 = mysqli_fetch_array($res1);
                                    $cantMatTot = $row1[0];
                                    
                                    $sql2 = "SELECT SUM(unidades) FROM PEDIDOS_PROV_DETALLES WHERE material_id=".$idMaterialStock." AND recibido=0";
                                    //$sql2 = "SELECT SUM(STOCK) FROM MATERIALES_STOCK WHERE material_id=".$idMaterialStock." AND ubicacion_id=0 AND MATERIALES_STOCK.proyecto_id=11";
                                    file_put_contents("selectMaterialRecepcionadoEnAlmacen.txt", $sql2);
                                    $res2 = mysqli_query($connString, $sql2) or die("Error al ejecutar la consulta de material asignado al proyecto recepcionado.");
                                    
                                    $row2 = mysqli_fetch_array($res2);
                                    if($row2[0]==""){
                                        $cantMatPte = 0;
                                    }else{
                                        $cantMatPte = $row2[0];
                                    }
                                    
                                    
                                    $tohtml.= "<tr data-id='".$idMaterialStock."' id='doc-calibraciones-".$idMaterialStock."'>
                                        <td class='text-left'>".$idMaterialStock."</td>
                                        <td class='text-center'>".$refMaterial."</td>
                                        <td class='text-center' style='max-width: 600px;'>".$nombreMaterialStock."</td>
                                        <td class='text-center'>".$fabricanteMaterialStock."</td>
                                        <td class='text-center'>".$modeloMaterialStock."</td>
                                        <td class='text-center'>".$cantMatTot."</td>
                                        <td class='text-center'>".$stockMaterialStock."</td>
                                        <td class='text-center'>".$cantMatPte."</td>
                                        <td class='text-center'><button class='button' id='btn_view_mat_ped_alm' title='Ver Stock del Almacen' data-id='".$idMaterialStock."'><img src='/erp/img/random.png' height='15'></button></td>
                                    </tr>";
                                    
                                }
                            
                        $tohtml.='</tbody></table></div></form>';
                        echo $tohtml;
    
    }
?>
	