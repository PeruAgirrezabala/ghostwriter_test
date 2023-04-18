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
    
<div id="project-edit" style="display: none;">
    <form method="post" id="frm_oferta">
    <?
        echo "  <input type='hidden' name='ofertas_deloferta' id='ofertas_deloferta' value=''>
                <input type='hidden' name='ofertas_idoferta' id='ofertas_idoferta' value=".$oferta_id.">
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
            <button type="button" class="btn btn-primary" id="ofertas_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

    </tbody>
</table>

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
                            <input type="text" class="form-control" id="pedidodetalle_fabricante" name="pedidodetalle_fabricante" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="ofertamat_descripcion" name="ofertamat_descripcion" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">REF Proveedor:</label>
                            <input type="text" class="form-control" id="pedidodetalle_ref" name="pedidodetalle_ref">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Stock:</label>
                                <input type="text" class="form-control" id="pedidodetalle_stock" name="pedidodetalle_stock">
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
                                <!-- <input type="text" class="form-control" id="pedidodetalle_dtoprov" name="pedidodetalle_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                                <select id="pedidodetalle_dtoprov" name="pedidodetalle_dtoprov" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dtoprov_desc" name="pedidodetalle_dtoprov_desc">
                                    <label class="form-check-label" for="pedidodetalle_dtoprov_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Material (%):</label>
                                <input type="text" class="form-control" id="pedidodetalle_dtomat" name="pedidodetalle_dtomat" disabled="true" data-descartar="0">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dtomat_desc" name="pedidodetalle_dtomat_desc">
                                    <label class="form-check-label" for="pedidodetalle_dtomat_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Adicional (%):</label>
                                <input type="text" class="form-control" id="pedidodetalle_dto" name="pedidodetalle_dto" data-descartar="0">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dto_desc" name="pedidodetalle_dto_desc">
                                    <label class="form-check-label" for="pedidodetalle_dto_desc">Aplicar</label>
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
                                <label class="labelBeforeBlack">Descuento (%):</label>
                                <input type="text" class="form-control" id="ofertamat_totaldto" name="ofertamat_totaldto" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP - Descuento:</label>
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