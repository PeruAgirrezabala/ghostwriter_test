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
                    OFERTAS_DETALLES_MATERIALES.oferta_id = ".$_GET['id'];
        file_put_contents("logCostes.txt", $sql);
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalPVPdto = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvpMat = $registros[6];
            $cantidad = $registros[7];
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

            $totalPVP = $totalPVP + $subtotalDTOPROVapli;
            $totalDTO = $totalDTO + $dtoCliPVP;
            $totalPVPdto = $totalPVPdto + $subtotalDTOCLIapli;
        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_TERCEROS.pvp,
                OFERTAS_DETALLES_TERCEROS.pvp_dto,
                OFERTAS_DETALLES_TERCEROS.pvp_total
            FROM 
                OFERTAS_DETALLES_TERCEROS 
            WHERE 
                OFERTAS_DETALLES_TERCEROS.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalDTO = $totalDTO + ($pvp - $pvpdto);
            $totalPVPdto = $totalPVPdto + $pvpdto;
            //$total = $total + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_VIAJES.pvp,
                OFERTAS_DETALLES_VIAJES.pvp_total
            FROM 
                OFERTAS_DETALLES_VIAJES 
            WHERE 
                OFERTAS_DETALLES_VIAJES.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            //$pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalPVPdto = $totalPVPdto + $pvp;
            //$total = $total + $pvptotal;

        }  
        
        $sql = "SELECT 
                OFERTAS_DETALLES_OTROS.pvp,
                OFERTAS_DETALLES_OTROS.pvp_total
            FROM 
                OFERTAS_DETALLES_OTROS 
            WHERE 
                OFERTAS_DETALLES_OTROS.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            //$pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalPVPdto = $totalPVPdto + $pvp;
            //$total = $total + $pvptotal;

        }  
        
        $totalGanancia = $total - $totalPVPdto;

        /*
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");

        $registros = mysqli_fetch_row($resultado);

        $id = $_GET['id'];
        $ref = $registros[1];
        $nombreOferta = $registros[2];
        $descripcion = $registros[3];
        $fecha = $registros[4];
        $fecha_val = $registros[5];
        $fecha_mod = $registros[6];
        $estado = $registros[7];
        $proyecto = $registros[8];
        $estadocolor = $registros[9];
        $estado_id = $registros[10];
        $proyecto_id = $registros[11];

        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Ref:</label> <label id='view_ref'>".$ref."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Título:</label> <label id='view_ref'>".$nombreOferta."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descripción:</label> <label id='view_ref'>".$descripcion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Proyecto:</label> <label id='view_ref'>".$proyecto."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha:</label> <label id='view_ref'>".$fecha."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Validez:</label> <label id='view_ref'>".$fecha_val."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Última modificación:</label> <label id='view_ref'>".$fecha_mod."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Estado:</label> <label id='view_ref' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
         
         */
    ?>
    <div class='form-group form-group-view'>
        <label class='viewTitle resumen-title'>NETO: </label> <label id='costes_pvp' class="precio_right"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label>
    </div>
    <div class='form-group form-group-view'>
        <label class='viewTitle resumen-title'>DESCUENTO: </label> <label id='costes_dto' class="precio_right"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label>
    </div>
    <!--
    <div class='form-group form-group-view'>
        <label class='viewTitle resumen-title'>IVA: </label> <label id='costes_iva' class="precio_right"> xx €</label>
    </div>
    -->
    <div class='form-group form-group-view costes_total'>
        <label class='viewTitle resumen-title'>TOTAL COSTE: </label> <label id='costes_total' class="precio_right_total"> <? echo number_format((float)$totalPVPdto, 2, ',', '.'); ?> €</label>
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

<div id="programar_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PROGRAMAR PARTIDO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="partido_id" id="partido_id">

                    <div class="form-group">
                        <div class="col-xs-6">
                            <label class="labelBeforeBlack">Fecha:</label>
                            <input type="datetime-local" class="form-control" id="partido_fecha" name="partido_fecha">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="labelBeforeBlack">Lugar:</label>
                        <input type="text" class="form-control" id="partido_lugar" name="partido_lugar">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_programar" class="btn btn-info2">Programar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#oferta-title").html("<? echo $ref." - ".$nombreOferta; ?>");
    $("#current-page").html("<? echo $ref." - ".$nombreOferta; ?>");
    $("#ofertas_proyectos").val("<? echo $proyecto_id; ?>");
    $("#ofertas_estados").val("<? echo $estado_id; ?>");
</script>

<!-- mispartidos -->