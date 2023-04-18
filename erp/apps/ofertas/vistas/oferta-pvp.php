<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="ofertas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardado</p>
</div>
<div id="project-view">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // MATERIAL
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
                    PROVEEDORES_DTO.dto_prov, 
                    MATERIALES.dto2 
                FROM 
                    MATERIALES
                INNER JOIN MATERIALES_PRECIOS
                    ON MATERIALES_PRECIOS.material_id = MATERIALES.id  
                INNER JOIN OFERTAS_DETALLES_MATERIALES
                    ON OFERTAS_DETALLES_MATERIALES.material_tarifa_id = MATERIALES_PRECIOS.id
                INNER JOIN OFERTAS 
                    ON OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id  
                LEFT JOIN PROVEEDORES_DTO 
                    ON PROVEEDORES_DTO.id = OFERTAS_DETALLES_MATERIALES.dto_prov_id
                WHERE 
                    OFERTAS.id = ".$_GET['id']." 
                ORDER BY 
                    OFERTAS_DETALLES_MATERIALES.id ASC";
        
        //file_put_contents("queryMat.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Material");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        $pvpincremento = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $oferta_id = $_GET['id'];
            $id = $registros[0];
            $ref = $registros[2];
            $nombreMat = $registros[3];
            $modeloMat = $registros[4];
            $descMat = $registros[5];
            $pvpMat = $registros[6];
            $cantidad = $registros[7];
            $tituloMat = $registros[8];
            $descripcionMat = $registros[9];
            $incMat = $registros[10];
            $dtoProvActivo = $registros[12];
            $dtoMatActivo = $registros[13];
            $dtoCliActivo = $registros[14];
            $dtoProv = $registros[15];
            $dtoMat = $registros[16];
            $dto_sum = 0;
            $pvp_dto = 0;
            
            if ($dtoProvActivo == 1) {
                $dto_sum  = $dto_sum + $dtoProv;
            }
            if ($dtoMatActivo == 1) {
                $dto_sum  = $dto_sum + $dtoMat;
            }
            if ($dtoCliActivo == 1) {
                $dtoAcliente = $registros[11];
            }
            else {
                $dtoAcliente = 0.00;
            }       

            $subtotal = ($pvpMat*$cantidad);
            $dto = ($subtotal*$dto_sum)/100;
            $subtotalDTOPROVapli = $subtotal-$dto;
            $dtoCliPVP = ($subtotalDTOPROVapli*$dtoAcliente)/100;
            $subtotalDTOCLIapli = $subtotalDTOPROVapli - $dtoCliPVP;
            $inc = "1.".$incMat;
            $pvpTOTAL = $inc*$subtotalDTOCLIapli;
            $pvpincremento = ($pvpTOTAL - $subtotalDTOCLIapli);
            
            $totalPVP = $totalPVP + $subtotalDTOCLIapli;
            $totalINC = $totalINC + $pvpincremento;
            $totalPVPdto = $totalPVPdto + $pvpdto;
            $total = $total + $pvpTOTAL;
            
        }   
        //file_put_contents("materialesPVP.txt", $total);
        
        // SUBCONTRATACIONES
        $sql = "SELECT 
                OFERTAS_DETALLES_TERCEROS.pvp,
                OFERTAS_DETALLES_TERCEROS.pvp_dto,
                OFERTAS_DETALLES_TERCEROS.incremento,
                OFERTAS_DETALLES_TERCEROS.pvp_total
            FROM 
                OFERTAS_DETALLES_TERCEROS 
            WHERE 
                OFERTAS_DETALLES_TERCEROS.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[3] - $registros[1]);
            $pvptotal = $registros[3];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $total = $total + $pvptotal;
        }   
        //file_put_contents("tercerosINC.txt", $totalINC);
        
        
        // MANO DE OBRA
        $sql = "SELECT 
                OFERTAS_DETALLES_HORAS.pvp,
                OFERTAS_DETALLES_HORAS.pvp_total
            FROM 
                OFERTAS_DETALLES_HORAS 
            WHERE 
                OFERTAS_DETALLES_HORAS.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvptotal = $registros[1];

            $totalPVP = $totalPVP + $pvp;
            $total = $total + $pvptotal;

        }   
        //file_put_contents("horasPVP.txt", $total);
        
        // VIAJES
        $sql = "SELECT 
                OFERTAS_DETALLES_VIAJES.pvp,
                OFERTAS_DETALLES_VIAJES.incremento,
                OFERTAS_DETALLES_VIAJES.pvp_total
            FROM 
                OFERTAS_DETALLES_VIAJES 
            WHERE 
                OFERTAS_DETALLES_VIAJES.oferta_id = ".$_GET['id'];
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[2] - $registros[0]);
            $pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $total = $total + $pvptotal;

        }   
        //file_put_contents("viajesINC.txt", $totalINC);
        
        // OTROS
        $sql = "SELECT 
                OFERTAS_DETALLES_OTROS.pvp,
                OFERTAS_DETALLES_OTROS.incremento,
                OFERTAS_DETALLES_OTROS.pvp_total
            FROM 
                OFERTAS_DETALLES_OTROS 
            WHERE 
                OFERTAS_DETALLES_OTROS.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Otros");
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[2] - $registros[0]);
            $pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $total = $total + $pvptotal;

        }   
        //file_put_contents("otrosPVP.txt", $total);
        
        $totalGanancia = $total - $totalPVPdto;

        
    ?>
    <div class='form-group form-group-view'>
        <label class='viewTitle resumen-title'>NETO: </label> <label id='costes_pvp' class="precio_right"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label>
    </div>
    <div class='form-group form-group-view'>
        <label class='viewTitle resumen-title'>INCREMENTO: </label> <label id='costes_dto' class="precio_right"> <? echo number_format((float)$totalINC, 2, ',', '.'); ?> €</label>
    </div>
    <!--
    <div class='form-group form-group-view'>
        <label class='viewTitle resumen-title'>IVA: </label> <label id='costes_iva' class="precio_right"> xx €</label>
    </div>
    -->
    <div class='form-group form-group-view pvp_total'>
        <label class='viewTitle resumen-title'>TOTAL VENTA: </label> <label id='costes_total' class="precio_right_total"> <? echo number_format((float)$total, 2, ',', '.'); ?> €</label>
    </div>
    <?
        if ($dto_final != "") {
            $dto = ($total*$dto_final)/100;
            $total = $total - $dto;
        }
    ?>
    <div class='form-group form-group-view pvp_total'>
        <label class='viewTitle resumen-title'>TOTAL VENTA - DTO NETO (<? echo $dto_final." %"; ?>): </label> <label id='costes_total' class="precio_right_total"> <? echo number_format((float)$total, 2, ',', '.'); ?> €</label>
    </div>
    <? 
        $total=$total+($total*0.21);
    ?>
    <div class='form-group form-group-view pvp_total'>
        <label class='viewTitle resumen-title'>TOTAL VENTA + IVA (21%): </label> <label id='costes_total_iva' class="precio_right_total"> <? echo number_format((float)$total, 2, ',', '.'); ?> €</label>
    </div>
</div>
<div id="project-edit" style="display: none;">
    <form method="post" id="frm_oferta">
    <?
        echo "  <input type='hidden' name='ofertas_deloferta' id='ofertas_deloferta' value=''>
                <input type='hidden' name='ofertas_idoferta' id='ofertas_idoferta' value=".$id.">
                <input type='hidden' name='ofertas_clienteid' id='ofertas_proyectoid' value=".$proyecto_id."> 
                <input type='hidden' name='ofertas_estadoid' id='ofertas_estadoid' value=".$estado_id.">";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Ref:</label>
                <input type='text' class='form-control' id='ofertas_edit_ref' name='ofertas_edit_ref' placeholder='Referencia de la Oferta' value='".$ref."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Nombre:</label>
                <input type='text' class='form-control' id='ofertas_edit_nombre' name='ofertas_edit_nombre' placeholder='Título de la Oferta' value='".$nombreOferta."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Descripción:</label>
                <textarea class='form-control' id='ofertas_edit_desc' name='ofertas_edit_desc' placeholder='Descripción de la Oferta'>".$descripcion."</textarea>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Proyecto:</label>
                <select id='ofertas_proyectos' name='ofertas_proyectos' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha:</label>
                <input type='date' class='form-control' id='ofertas_edit_fecha' name='ofertas_edit_fecha' value='".$fecha."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha Validez:</label>
                <input type='date' class='form-control' id='ofertas_edit_fechaval' name='ofertas_edit_fechaval' value='".$fecha_val."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Última modificación:</label> <label id='view_ref'>".$fecha_mod."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Estado:</label>
                <select id='ofertas_estados' name='ofertas_estados' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
    ?>
        <div class="form-group form-group-view" style="margin-top: 30px; margin-bottom: 30px !important;">
            <button type="button" class="btn btn-info" id="ofertas_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

    </tbody>
</table>

<!-- mispartidos -->