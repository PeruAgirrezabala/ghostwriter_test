<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="ofertas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-ofertas-mat'>
    <thead>
      <tr>
        <th class="text-center">CANT</th>
        <th>REF</th>
        <th>TITULO</th>
        <th class="text-center">Unitario (€)</th>
        <th class="text-center">PVP (€)</th>
        <th class="text-center">DTO (%)</th>
        <th class="text-center">PVP DTO (€)</th>
        <th class="text-center">INC (%)</th>
        <th class="text-center">TOTAL (€)</th>
        <th class="text-center"></th>
      </tr>
    </thead>
    <tbody>
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
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
                OFERTAS_DETALLES_MATERIALES.pvp,
                OFERTAS_DETALLES_MATERIALES.pvp_dto,
                OFERTAS_DETALLES_MATERIALES.pvp_total, 
                OFERTAS_DETALLES_MATERIALES.id 
                
            FROM 
                MATERIALES, MATERIALES_PRECIOS, OFERTAS_DETALLES_MATERIALES, OFERTAS  
            WHERE 
                MATERIALES_PRECIOS.id = OFERTAS_DETALLES_MATERIALES.material_tarifa_id 
            AND
                OFERTAS_DETALLES_MATERIALES.material_id = MATERIALES.id
            AND
                OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id 
            AND 
                OFERTAS.id = ".$_GET['id']." 
            ORDER BY 
                OFERTAS_DETALLES_MATERIALES.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $oferta_id = $_GET['id'];
            $id = $registros[14];
            $ref = $registros[1];
            $nombreMat = $registros[2];
            $modeloMat = $registros[3];
            $descMat = $registros[4];
            $pvpMat = $registros[5];
            $cantidad = $registros[6];
            $tituloMat = $registros[7];
            $descripcionMat = $registros[8];
            $incMat = $registros[9];
            $dto = $registros[10];
            $pvp = $registros[11];
            $pvpdto = $registros[12];
            $pvptotal = $registros[13];
            
            $totalPVP = $totalPVP + $pvp;
            $totalDTO = $totalDTO + ($pvp - $pvpdto);
            $totalPVPdto = $totalPVPdto + $pvpdto;
            $total = $total + $pvptotal;
            
            echo "
                <tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidad."</td>
                    <td>".$ref."</td>
                    <td>".$nombreMat." - ".$modeloMat."</td>
                    <td class='text-center'>".$pvpMat."</td>
                    <td class='text-center'>".$pvp."</td>
                    <td class='text-center'>".$dto."</td>
                    <td class='text-center'>".$pvpdto."</td>
                    <td class='text-center'>".$incMat."</td>
                    <td class='text-center'>".$pvptotal."</td>
                    <td class='text-center'><button class='btn-default remove-detalle' data-id='".$id."'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>
            ";
        }   
        $totalGanancia = $total - $totalPVPdto;
    ?>
    </tbody>
</table>

<div class="row pvp_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PLUS: </label> <label id='materiales_iva' class="precio_right_vistas"> <? echo number_format((float)$totalGanancia, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format((float)$total, 2, ',', '.'); ?> €</label></div>
</div>
   
<div id="material_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_ofertamat">
                        <input type="hidden" value="" name="ofertamat_detalle_id" id="ofertamat_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="ofertamat_oferta_id" id="ofertamat_oferta_id">
                        <input type="hidden" value="" name="ofertamat_material_id" id="ofertamat_material_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Categorías:</label>
                            <select id="ofertamat_categorias1" name="ofertamat_categorias1" class="selectpicker ofertamat_categorias" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales:</label>
                            <select id="ofertamat_materiales" name="ofertamat_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="ofertamat_nombre" name="ofertamat_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Modelo:</label>
                            <input type="text" class="form-control" id="ofertamat_modelo" name="ofertamat_modelo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fabricante:</label>
                            <input type="text" class="form-control" id="ofertamat_fabricante" name="ofertamat_fabricante" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="ofertamat_descripcion" name="ofertamat_descripcion" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">REF Proveedor:</label>
                            <input type="text" class="form-control" id="ofertamat_ref" name="ofertamat_ref">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Stock:</label>
                                <input type="text" class="form-control" id="ofertamat_stock" name="ofertamat_stock">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBeforeBlack">Tarifas del Proveedor:</label>
                                <select id="ofertamat_precios" name="ofertamat_precios" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Tarifa seleccionada:</label>
                                <input type="text" class="form-control" id="ofertamat_preciomat" name="ofertamat_preciomat" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="ofertamat_cantidad" name="ofertamat_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack"><strong>DESCUENTOS</strong></label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuentos Proveedor (%):</label>
                                <!-- <input type="text" class="form-control" id="ofertamat_dtoprov" name="ofertamat_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                                <select id="ofertamat_dtoprov" name="ofertamat_dtoprov" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="ofertamat_dtoprov_desc" name="ofertamat_dtoprov_desc">
                                    <label class="form-check-label" for="ofertamat_dtoprov_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Material (%):</label>
                                <input type="text" class="form-control" id="ofertamat_dtomat" name="ofertamat_dtomat" disabled="true" data-descartar="0">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="ofertamat_dtomat_desc" name="ofertamat_dtomat_desc">
                                    <label class="form-check-label" for="ofertamat_dtomat_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Adicional (%):</label>
                                <input type="text" class="form-control" id="ofertamat_dto" name="ofertamat_dto" data-descartar="0">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="ofertamat_dto_desc" name="ofertamat_dto_desc">
                                    <label class="form-check-label" for="ofertamat_dto_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;"">
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP:</label>
                                <input type="text" class="form-control" id="ofertamat_pvp" name="ofertamat_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Total:</label>
                                <input type="text" class="form-control" id="ofertamat_totaldto" name="ofertamat_totaldto" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">% Total:</label>
                                <input type="text" class="form-control" id="pedidodetalle_totaldtopercent" name="pedidodetalle_totaldtopercent" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Total:</label>
                                <input type="text" class="form-control" id="ofertamat_pvpdto" name="ofertamat_pvpdto" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Incremento (%):</label>
                                <input type="text" class="form-control" id="ofertamat_incremento" name="ofertamat_incremento" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP + Incremento:</label>
                                <input type="text" class="form-control" id="ofertamat_pvpinc" name="ofertamat_pvpinc" value="0" style="background-color: #5cb85c; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_ofertamat_save" class="btn btn-primary">Guardar</button>
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