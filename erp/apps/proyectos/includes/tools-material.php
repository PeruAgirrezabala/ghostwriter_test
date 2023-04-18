<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <!--<button class="button" id="add-material" title="Añadir Material"><img src="/erp/img/add.png" height="20"></button>-->
    <button class="button" id="search-material" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-material" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
    <!--<button class="button" id="gen_albaran" title="Generar Albarán para Envío"><img src="/erp/img/albaran.png" height="20"></button>-->
</div>

<!--<div id="salida_material_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">SALIDA DE MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_salida_material">
                        <input type="hidden" id="to_albaran" name="to_albaran">
                        <div class="form-group">
                            <label class="labelBefore">Envios:</label>
                             <input type="text" class="form-control" id="proyectomaterial_dtoprov" name="proyectomaterial_dtoprov" value="0" disabled="true" data-descartar="0"> 
                            <select id="newenvio_envios" name="newenvio_envios" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Título:</label>
                            <input type="text" class="form-control" id="newenvio_titulo" name="newenvio_titulo">
                        </div>
                        <div class="form-group">
                            <label for="newenvio_transportistas" class="labelBefore">Transportista: </label>
                            <select id="newenvio_transportistas" name="newenvio_transportistas" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">REF Transportista:</label>
                                <input type="text" class="form-control" id="newenvio_ref_trans" name="newenvio_ref_trans">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newenvio_clientes" class="labelBefore">Cliente: </label>
                            <select id="newenvio_clientes" name="newenvio_clientes" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="newenvio_clientes" class="labelBefore">Proveedor: </label>
                            <select id="newenvio_proveedores" name="newenvio_proveedores" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección de Envío:</label>
                            <textarea class="form-control" id="newenvio_direnvio" name="newenvio_direnvio" placeholder="Introduce la dirección de envío o déjalo en blanco para coger la del cliente" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Forma Envío:</label>
                                <input type="text" class="form-control" id="newenvio_formaenvio" name="newenvio_formaenvio" value="NORMAL">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Portes:</label>
                                <input type="text" class="form-control" id="newenvio_portes" name="newenvio_portes" value="PAGADOS">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Gastos Envío:</label>
                                <input type="text" class="form-control" id="newenvio_gastos" name="newenvio_gastos" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">PEDIDO CLIENTE:</label>
                                <input type="text" class="form-control" id="newenvio_pedido_CLI" name="newenvio_pedido_CLI">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">OFERTA PROVEEDOR:</label>
                                <input type="text" class="form-control" id="newenvio_oferta_prov" name="newenvio_oferta_prov">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newenvio_proyectos" class="labelBefore">Proyecto: </label>
                            <select id="newenvio_proyectos" name="newenvio_proyectos" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label for="newenvio_proyectos" class="labelBefore">Entrega: </label>
                            <select id="newenvio_entregas" name="newenvio_entregas" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_ofertas_gen" class="labelBefore">Oferta Genelek: </label>
                                <select id="newenvio_ofertas_gen" name="newenvio_ofertas_gen" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha:</label>
                                <input type="date" class="form-control" id="newenvio_fecha" name="newenvio_fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="newenvio_fechaentrega" name="newenvio_fechaentrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Plazo de Entrega:</label>
                                <input type="text" class="form-control" id="newenvio_plazo" name="newenvio_plazo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Contacto:</label>
                                <input type="text" class="form-control" id="newenvio_contacto" name="newenvio_contacto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newenvio_tecnicos" class="labelBefore">De: </label>
                            <select id="newenvio_tecnicos" name="newenvio_tecnicos" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_estados" class="labelBefore">Estado: </label>
                                <select id="newenvio_estados" name="newenvio_estados" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newenvio_desc" name="newenvio_desc" placeholder="Descripción del Envío" rows="5"></textarea>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
                <div class="alert-middle alert alert-success alert-dismissable" id="newenvio_success" style="display:none; margin: 0px auto 0px auto;">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <p>Envío generado</p>
                </div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn_salidamaterial_save" class="btn btn-primary">Guardar</button>
        </div>
        </div>
    </div>
</div>-->
<!-- Modal Dividir -->
<div id="dividir_pedido_almacen_modal" class="modal fade">
</div>

<div id="selectmaterial_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">SELECCIONAR MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_material">
                        <input type="hidden" value="" name="proyectomaterial_detalle_id" id="proyectomaterial_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="proyectomaterial_proyecto_id" id="proyectomaterial_proyecto_id">
                        <input type="hidden" value="" name="proyectomaterial_material_id" id="proyectomaterial_material_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Categorías:</label>
                            <select id="proyectomaterial_categorias1" name="proyectomaterial_categorias1" class="selectpicker proyectomaterial_categorias" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Buscar:</label>
                                <input type="search" class="form-control" id="proyectomaterial_criterio" name="proyectomaterial_criterio" placeholder="Introduce un criterio para buscar">
                            </div>
                            <!--
                            <div class="col-xs-3">
                                <label class="labelBeforeBlack" style="color: #ffffff;">ooooooooooo</label>
                                <button type="button" id="btn_pedidodetalle_find" class="btn btn-primary">Buscar</button>
                            </div>
                            -->
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales:</label>
                            <select id="proyectomaterial_materiales" name="proyectomaterial_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="proyectomaterial_nombre" name="proyectomaterial_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Modelo:</label>
                            <input type="text" class="form-control" id="proyectomaterial_modelo" name="proyectomaterial_modelo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fabricante:</label>
                            <input type="text" class="form-control" id="proyectomaterial_fabricante" name="proyectomaterial_fabricante" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="proyectomaterial_descripcion" name="proyectomaterial_descripcion" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">REF Proveedor:</label>
                            <input type="text" class="form-control" id="proyectomaterial_ref" name="proyectomaterial_ref">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Stock:</label>
                                <input type="text" class="form-control" id="proyectomaterial_stock" name="proyectomaterial_stock" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBeforeBlack">Tarifas del Proveedor:</label>
                                <select id="proyectomaterial_precios" name="proyectomaterial_precios" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Tarifa seleccionada:</label>
                                <input type="text" class="form-control" id="proyectomaterial_preciomat" name="proyectomaterial_preciomat" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="proyectomaterial_cantidad" name="proyectomaterial_cantidad" value="0">
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
                                <!-- <input type="text" class="form-control" id="proyectomaterial_dtoprov" name="proyectomaterial_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                                <select id="proyectomaterial_dtoprov" name="proyectomaterial_dtoprov" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="proyectomaterial_dtoprov_desc" name="proyectomaterial_dtoprov_desc">
                                    <label class="form-check-label" for="proyectomaterial_dtoprov_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Material (%):</label>
                                <input type="text" class="form-control" id="proyectomaterial_dtomat" name="proyectomaterial_dtomat" disabled="true" data-descartar="0">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="proyectomaterial_dtomat_desc" name="proyectomaterial_dtomat_desc">
                                    <label class="form-check-label" for="proyectomaterial_dtomat_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;"">
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Neto:</label>
                                <input type="text" class="form-control" id="proyectomaterial_pvp" name="proyectomaterial_pvp" value="0.00" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Proveedor Total:</label>
                                <input type="text" class="form-control" id="proyectomaterial_totaldto" name="proyectomaterial_totaldto" value="0.00">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">% Total:</label>
                                <input type="text" class="form-control" id="proyectomaterial_totaldtopercent" name="proyectomaterial_totaldtopercent" value="0.00" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP Total:</label>
                                <input type="text" class="form-control" id="proyectomaterial_pvptotal" name="proyectomaterial_pvptotal" value="0.00" style="background-color: #d9534f; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_proyectomaterial_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>