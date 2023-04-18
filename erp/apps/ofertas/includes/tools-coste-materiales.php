<script>
    $.ajax({
        type: "POST",  
        url: "acceptOferta.php",  
        data: {
            thisid: <? echo $_GET["id"];?>
        },
        dataType: "text",       
        success: function(response){
            if(response.trim()==1){
                $("#add-pedidos").removeAttr('disabled');
            }else{
                $("#add-pedidos").attr('disabled', 'disabled');
                $("#add-pedidos").attr('title', 'Deshabilitado. Solo disponible cuando la oferta esta aceptada!');
            }
        }   
    });
</script>
<!-- tools material oferta -->
<div class="form-group form-group-tools">
    <button class="button" id="add-costematerial" title="Añadir Material"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="print-materiales" title="Listado de Materiales"><img src="/erp/img/mat-prov.png" height="20"></button>
    <button class="button" id="ver-stock-almacen" title="Ver Stock del Almacen"><img src="/erp/img/almacen.png" height="20"></button>
    <button class="button" id="add-pedidos" title="Crear Pedido"><img src="/erp/img/proveedores.png" height="20"></button>
    <button class="button" id="refresh-materiales" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools material oferta -->

<div id="matOferta_view_model" class="modal fade">
    <div class="modal-dialog dialog_mediano">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">
                    MATERIAL OFERTADO 
                    <button class="btn button" id="print_matOferta" title="Imprimir Material"><img src="/erp/img/print.png" height="30"></button> 
                </h4>
            </div>
            <div class="modal-body">
                <div class="loading-div"></div>
                <div class="contenedor-form" id="tabla-matOferta" style="color: #333333; font-weight: 500;">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
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
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Buscar:</label>
                                <input type="search" class="form-control" id="ofertamat_criterio" name="ofertamat_criterio" placeholder="Introduce un criterio para buscar">
                            </div>
                            <!--
                            <div class="col-xs-3">
                                <label class="labelBeforeBlack" style="color: #ffffff;">ooooooooooo</label>
                                <button type="button" id="btn_pedidodetalle_find" class="btn btn-primary">Buscar</button>
                            </div>
                            -->
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales: <span class="requerido">*</span></label>
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
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBeforeBlack">Proveedor: <span class="requerido">*</span></label>
                                <select id="ofertamat_proveedor" name="ofertamat_proveedor" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBeforeBlack">REF Proveedor:</label>
                                <input type="text" class="form-control" id="ofertamat_ref" name="ofertamat_ref" disabled="true">
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Stock:</label>
                                <input type="text" class="form-control" id="ofertamat_stock" name="ofertamat_stock">
                            </div>
                        </div>
                        -->
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBeforeBlack">Tarifas del Proveedor: <span class="requerido">*</span></label>
                                <select id="ofertamat_precios" name="ofertamat_precios" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6" style="margin-top: 30px;">
                                <button type="button" id="addtarifa_material" class="btn btn-primary">Añadir Tarifa</button>
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
                                <label class="labelBeforeBlack">Cantidad: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="ofertamat_cantidad" name="ofertamat_cantidad">
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Almacén:</label>
                                <input type="checkbox" name="ofertamat_chkalmacen" id="ofertamat_chkalmacen" checked data-size="mini">
                            </div>
                        </div>
                        -->
                        <div class="form-group"></div>
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
                                <input type="text" class="form-control" id="ofertamat_dtomat" name="ofertamat_dtomat" disabled="true" data-descartar="0" value="0.00">
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
                                <input type="text" class="form-control" id="ofertamat_dto" name="ofertamat_dto" data-descartar="0" value="0.00">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="ofertamat_dto_desc" name="ofertamat_dto_desc">
                                    <label class="form-check-label" for="ofertamat_dto_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;">
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Tarifa:</label>
                                <input type="text" class="form-control" id="ofertamat_pvp" name="ofertamat_pvp" value="0.00" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento (Importe total):</label>
                                <input type="text" class="form-control" id="ofertamat_totaldto" name="ofertamat_totaldto" value="0.00">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento (% total):</label>
                                <input type="text" class="form-control" id="ofertamat_totaldtopercent" name="ofertamat_totaldtopercent" value="0.00" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Coste:</label>
                                <input type="text" class="form-control" id="ofertamat_pvpdto" name="ofertamat_pvpdto" value="0.00" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Margen Comercial (%):</label>
                                <input type="text" class="form-control" id="ofertamat_incremento" name="ofertamat_incremento" value="0.00">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP Venta Genelek:</label>
                                <input type="text" class="form-control" id="ofertamat_pvpinc" name="ofertamat_pvpinc" value="0.00" style="background-color: #5cb85c; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_ofertamat_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="add_materialoferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore">Introduce el nombre del pedido</label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control required" name="nom_pedidooferta" id="nom_pedidooferta" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-add-pedidos" data-id="" class="btn btn-info">Crear</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Borrar Material Oferta --> 
<div id="del_materialoferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_matof_id" id="del_matof_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar este material?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_matof" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Tarifa nueva -->
<div id="addtarifa_modal" class="modal fade">
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
                        <label class="labelBefore white">Fecha Validez: <span class="requerido">*</span></label>
                        <input type="date" class="form-control" id="newtarifa_fechaval" name="newtarifa_fechaval">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Tarifa (€): <span class="requerido">*</span></label>
                        <input type="text" class="form-control" id="newtarifa_tarifa" name="newtarifa_tarifa">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Dto (%): <span class="requerido">*</span></label>
                        <input type="text" class="form-control" id="newtarifa_dto" name="newtarifa_dto" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-info" id="btn_new_tarifa">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>