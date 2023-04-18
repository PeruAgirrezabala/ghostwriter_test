<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-detallepedido" title="Añadir Detalle"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-material" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-material" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
    <button class="button" id="recibir-multi-mat" title="Recibir Material"><img src="/erp/img/recibido.png" height="20"></button>
    <button class="button" id="recibir-parte-mat" title="Recibir Parte de Material"><img src="/erp/img/dividido.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="detallepedido_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_pedidodetalle">
                        <input type="hidden" value="" name="pedidodetalle_detalle_id" id="pedidodetalle_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="pedidodetalle_pedido_id" id="pedidodetalle_pedido_id">
                        <input type="hidden" value="" name="pedidodetalle_material_id" id="pedidodetalle_material_id">

                        <div class="form-group">
                            <label class="labelBefore">Categorías: </label>
                            <select id="pedidodetalle_categorias1" name="pedidodetalle_categorias1" class="selectpicker pedidodetalle_categorias" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore"><span class="guia">1</span> Buscar:</label>
                                <input type="search" class="form-control" id="pedidodetalle_criterio" name="pedidodetalle_criterio" placeholder="Introduce un criterio para buscar">
                            </div>
                            <!--
                            <div class="col-xs-3">
                                <label class="labelBefore" style="color: #ffffff;">ooooooooooo</label>
                                <button type="button" id="btn_pedidodetalle_find" class="btn btn-primary">Buscar</button>
                            </div>
                            -->
                        </div>
                        <div class="form-group">
                            <label class="labelBefore"><span class="guia">2</span> Materiales: <span class="requerido">*</span></label>
                            <select id="pedidodetalle_materiales" name="pedidodetalle_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="pedidodetalle_nombre" name="pedidodetalle_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Modelo:</label>
                            <input type="text" class="form-control" id="pedidodetalle_modelo" name="pedidodetalle_modelo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Fabricante:</label>
                            <input type="text" class="form-control" id="pedidodetalle_fabricante" name="pedidodetalle_fabricante" disabled="true">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Detalle Libre:</label>
                            <textarea class="form-control" id="pedidodetalle_libre" name="pedidodetalle_libre" placeholder="Detalle libre" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">REF Proveedor:</label>
                            <input type="text" class="form-control" id="pedidodetalle_ref" name="pedidodetalle_ref">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Stock:</label>
                                <input type="text" class="form-control" id="pedidodetalle_stock" name="pedidodetalle_stock" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBefore"><span class="guia">3</span> Tarifas del Proveedor: <span class="requerido">*</span></label>
                                <select id="pedidodetalle_precios" name="pedidodetalle_precios" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore"></label>
                                <button type="button" class="btn btn-info" id="btn_addTarifaProv_modal" data-row-id="0">
                                    Añadir Tarifa
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Tarifa seleccionada:</label>
                                <input type="text" class="form-control" id="pedidodetalle_preciomat" name="pedidodetalle_preciomat">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore"><span class="guia">4</span> Cantidad: <span class="requerido">*</span></label>
                                <input type="text" class="form-control required" id="pedidodetalle_cantidad" name="pedidodetalle_cantidad" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3" style="margin-bottom: 15px;">
                                <label class="labelBefore">IVA: <span class="requerido">*</span></label>
                                <select id="pedidodetalle_ivas" name="pedidodetalle_ivas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore"><strong>DESCUENTOS</strong></label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore"><span class="guia">5</span> Descuentos Proveedor (%):</label>
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
                                <label class="labelBefore">Descuento Material (%):</label>
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
                                <label class="labelBefore">Descuento Adicional (%):</label>
                                <input type="text" class="form-control" id="pedidodetalle_dto" name="pedidodetalle_dto" data-descartar="0" value="0.00">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dto_desc" name="pedidodetalle_dto_desc">
                                    <label class="form-check-label" for="pedidodetalle_dto_desc">Aplicar</label>
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dto_sobretotal" name="pedidodetalle_dto_sobretotal">
                                    <label class="form-check-label" for="pedidodetalle_dto_sobretotal">Aplicar tras otros descuentos</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">PVP:</label>
                                <input type="text" class="form-control" id="pedidodetalle_pvp" name="pedidodetalle_pvp" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Descuento Total:</label>
                                <input type="text" class="form-control" id="pedidodetalle_totaldto" name="pedidodetalle_totaldto" value="0" disabled="true">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore">% Total:</label>
                                <input type="text" class="form-control" id="pedidodetalle_totaldtopercent" name="pedidodetalle_totaldtopercent" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">TOTAL:</label>
                                <input type="text" class="form-control" id="pedidodetalle_pvpdto" name="pedidodetalle_pvpdto" value="0" disabled="true" style="background-color: #0eace7; color: #ffffff !important;">
                            </div>
                        </div>
                        <!--* Establecer fecha de la cabecera * (hidden)-->
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha de Entrega Estimada:</label>
                                <input type="date" class="form-control" id="pedidodetalle_fecha_entrega" name="pedidodetalle_fecha_entrega" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Recibido:</label>
                                <input type="checkbox" name="edit_chkrecibido" id="edit_chkrecibido" checked data-size="mini">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha de Recepción:</label>
                                <input type="datetime-local" class="form-control" id="pedidodetalle_fecha_recepcion" name="pedidodetalle_fecha_recepcion" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="pedidodetalle_clientes" class="labelBefore"><span class="guia">6</span> Cliente: </label>
                                <select id="pedidodetalle_clientes" name="pedidodetalle_clientes" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore"></label>
                                <button type="button" class="btn btn-info2" id="btn_clienteProyecto" data-row-id="0">
                                    Cliente y Proyecto del Pedido
                                </button>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="pedidodetalle_proyectos" class="labelBefore"><span class="guia">7</span> Proyecto: <span class="requerido">*</span></label>
                                <select id="pedidodetalle_proyectos" name="pedidodetalle_proyectos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="pedidodetalle_proyectos" class="labelBefore">Entrega: </label>
                                <select id="pedidodetalle_entregas" name="pedidodetalle_entregas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore" for="pedidodetalle_tecnicos"><span class="guia">8</span> Técnico Interesado en el Material:</label>
                                <select id="pedidodetalle_tecnicos" name="pedidodetalle_tecnicos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Observaciones:</label>
                            <textarea class="form-control" id="pedidodetalle_desc" name="pedidodetalle_desc" placeholder="Observaciones" rows="5"></textarea>
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-danger alert-dismissable" id="pedidodetalle_error" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Hay campos obligatorios sin rellenar</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_pedidodetalle_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- MATERIALES -->

<div id="selectmaterial_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">MATERIALES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_material">
                        <input type="hidden" name="newmaterial_idmaterial" id="newmaterial_idmaterial">
                        <input type="hidden" name="material_del" id="material_del">
                        <div class="form-group">
                            <label class="labelBefore" style="color: #ffffff;">Material:</label>
                            <select id="materiales_categoria1" name="materiales_categoria1" class="selectpicker materiales_categorias" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales:</label>
                            <select id="newmaterial_materiales" name="newmaterial_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newmaterial_nombre" name="newmaterial_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Fabricante:</label>
                            <input type="text" class="form-control" id="newmaterial_fabricante" name="newmaterial_fabricante" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Modelo:</label>
                            <input type="text" class="form-control" id="newmaterial_modelo" name="newmaterial_modelo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Descuento:</label>
                            <input type="text" class="form-control" id="newmaterial_dto" name="newmaterial_dto" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Stock:</label>
                            <input type="text" class="form-control" id="newmaterial_stock" name="newmaterial_stock" disabled="true">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Unidades:</label>
                                <input type="text" class="form-control" id="unidades" name="unidades">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Plazo:</label>
                                <input type="text" class="form-control" id="plazo" name="plazo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Último Precio:</label>
                                <input type="text" class="form-control" id="newmaterial_lastprice" name="newmaterial_lastprice" disabled="true">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newmaterial_desc" name="newmaterial_desc" placeholder="Descripción" rows="5" disabled="true"></textarea>
                        </div>
                        
                        <div class="form-group">
                            
                        </div>
                        
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newmaterial_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Material guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_material" class="btn btn-info">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="delete_detalle_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas eliminar el detalle?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_detalle" data-id="" class="btn btn-info">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /MATERIALES -->

<!-- Recepcion parcial Model -->
<div id="recepcionMaterialParcial_model" class="modal fade">
    
</div>
<!-- -->

<!-- Add new Tarifa -->
<div id="add_new_tarifa_modal" class="modal fade">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" style="display: inline-block;">NUEVA TARIFA</h3>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add" name="frm_add">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="" name="newtarifa_materialid" id="newtarifa_materialid">
                    <input type="hidden" value="" name="newtarifa_proveedorid" id="newtarifa_proveedorid">
                    <div class="form-group">
                        <label class="labelBefore white">Fecha Validez:</label>
                        <input type="date" class="form-control" id="newtarifa_fechaval" name="newtarifa_fechaval">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Tarifa (€):</label>
                        <input type="text" class="form-control" id="newtarifa_tarifa" name="newtarifa_tarifa">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Dto (%):</label>
                        <input type="text" class="form-control" id="newtarifa_dto" name="newtarifa_dto" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-info" id="btn_addTarifaProv">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- -->

<div id="confirm_multi_detalle_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas recepcionar los detalles seleccionados?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_confirm_multi_detalle" data-id="" class="btn btn-info">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Realizar Envio/Devolución desde Materiales detalles del pedido. Debe de estar recepcionado primero. -->
<div id="add_envio_modal" class="modal fade">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" style="display: inline-block;">REALIZAR ENVÍO/DEVOLUCIÓN</h3>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_addEnvio" name="frm_addEnvio">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="" name="materialdetalle_id" id="materialdetalle_id">
                    <input type="hidden" value="" name="envio_usuario_id" id="envio_usuario_id">
                    <div class="form-group">
                        <label class="labelBefore white">Nombre Material:</label>
                        <input type="text" class="form-control" id="materialdetalle_nombre" name="materialdetalle_nombre" disabled>
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">REF:</label>
                        <input type="text" class="form-control" id="materialdetalle_ref" name="materialdetalle_ref" disabled>
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Tipo Envio: <span class="requerido">*</span></label>
                        <select id="envio_tipo" name="envio_tipo" class="selectpicker" data-live-search="true">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Nombre envío/devolución: <span class="requerido">*</span></label>
                        <input type="text" class="form-control" id="envio_nombre" name="envio_nombre">
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label class="labelBefore white">Dirección: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="envio_direccion" name="envio_direccion">
                        </div>
                        <div class="col-xs-6">
                            <label class="labelBefore white">Portes: <span class="requerido">*</span></label>
                            <select id="envio_portes" name="envio_portes" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label class="labelBefore white">Cant: <span class="requerido">*</span></label>
                            <select id="envio_cant" name="envio_cant" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <label class="labelBefore white">Transportista:</label>
                            <select id="envio_transportistas" name="envio_transportistas" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label class="labelBefore white">Fecha Envío:</label>
                            <input type="date" class="form-control" id="envio_fecha" name="envio_fecha" value="">
                        </div>
                        <div class="col-xs-6">
                            <label class="labelBefore white">Fecha Prevista Entrega:</label>
                            <input type="date" class="form-control" id="envio_fechaentrega" name="envio_fechaentrega" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="requerido">*Campo obligatorio</span>
                        <!--<br/>
                        <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                    </div>
                    <div class="form-group"></div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-info" id="btn_addEnvio">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- [FIN] Realizar Envio/Devolución -->