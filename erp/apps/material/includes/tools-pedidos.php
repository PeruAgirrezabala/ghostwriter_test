<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-pedido" title="Crear Pedido"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="add-proveedor" title="Proveedores"><img src="/erp/img/proveedores.png" height="20"></button>
    <button class="button" id="add-material" title="Materiales"><img src="/erp/img/materiales.png" height="20"></button>
    <button class="button" id="refresh-pedidos" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
    <button class="button" id="clean-filters" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
    <button class="button" id="export_excel_ped_mat_tot" style="display: none;" title="Exportar a excel. Todos"><img src="/erp/img/excelT.png" height="20"></button>
    <button class="button" id="export_excel_ped_mat_nrec" style="display: none;" title="Exportar a excel. No recibidos"><img src="/erp/img/excelN.png" height="20"></button>
    <button class="button" id="print-mat-prov" title="Material Pedido por Proveedor" style="display: none;"><img src="/erp/img/mat-prov.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="addpedido_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PEDIDO NUEVO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_pedido">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Nº DE PEDIDO DEL CLIENTE (DE GENELEK):</label>
                                <input type="text" class="form-control" id="newpedido_ref" name="newpedido_ref">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Nº DE OFERTA DEL PROVEEDOR:</label>
                                <input type="text" class="form-control" id="newpedido_oferta_prov" name="newpedido_oferta_prov">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Título: <span class="requerido">*</span></label>
                                <input type="text" class="form-control required" id="newpedido_titulo" name="newpedido_titulo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newpedido_clientes" class="labelBefore">Cliente: </label>
                                <select id="newpedido_clientes" name="newpedido_clientes" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newpedido_proyectos" class="labelBefore">Proyecto: <span class="requerido">*</span></label>
                                <select id="newpedido_proyectos" name="newpedido_proyectos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newpedido_proyectos" class="labelBefore">Entrega: </label>
                                <select id="newpedido_entregas" name="newpedido_entregas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newpedido_proyectos" class="labelBefore">Proveedor: <span class="requerido">*</span></label>
                                <select id="newpedido_proveedores" name="newpedido_proveedores" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha: <span class="requerido">*</span></label>
                                <input type="date" class="form-control required" id="newpedido_fecha" name="newpedido_fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha de Entrega estimada:</label>
                                <input type="date" class="form-control" id="newpedido_fechaentrega" name="newpedido_fechaentrega">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Dirección de Entrega alternativa:</label>
                            <textarea class="form-control" id="newpedido_direntrega" name="newpedido_direntrega" placeholder="Dirección de entrega alternativa por si se quiere enviar al cliente directamente" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Forma de Pago:</label>
                                <input type="text" class="form-control" id="newpedido_formapago" name="newpedido_formapago">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newpedido_formaspago" class="labelBefore">Forma de Pago Interna: </label>
                                <select id="newpedido_formaspago" name="newpedido_formaspago" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Plazo de Entrega: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="newpedido_plazo" name="newpedido_plazo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Contacto:</label>
                                <input type="text" class="form-control" id="newpedido_contacto" name="newpedido_contacto">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newpedido_tecnicos" class="labelBefore">Técnico que realiza el Pedido: <span class="requerido">*</span></label>
                                <select id="newpedido_tecnicos" name="newpedido_tecnicos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newpedido_estados" class="labelBefore">Estado: </label>
                                <select id="newpedido_estados" name="newpedido_estados" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Programada:</label>
                                <input type="date" class="form-control" id="newpedido_fechaprog" name="newpedido_fechaprog">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newpedido_desc" name="newpedido_desc" placeholder="Descripción del Pedido" rows="5"></textarea>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Observaciones:</label>
                            <textarea class="form-control" id="newpedido_observ" name="newpedido_observ" placeholder="Observaciónes del Pedido" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--
                            <br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span> -->
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newpedido_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Pedido guardado</p>
                    </div>
                    <div class="alert-middle alert alert-danger alert-dismissable" id="newpedido_error" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Hay campos obligatorios sin rellenar</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_pedido" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- proyectos activos -->

<!-- PROVEEDORES -->

<div id="addproveedor_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PROVEEDORES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_proveedor">
                        <input type="hidden" name="newproveedor_idproveedor" id="newproveedor_idproveedor">
                        <input type="hidden" name="proveedor_del" id="proveedor_del">
                        <div class="form-group">
                                <label class="labelBefore" style="color: #ffffff;">Proveedor:</label>
                                <select id="cmbproveedores_proveedores" name="cmbproveedores_proveedores" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">Nombre:</label>
                                <input type="text" class="form-control" id="newproveedor_nombre" name="newproveedor_nombre">
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">Dirección:</label>
                                <input type="text" class="form-control" id="newproveedor_direccion" name="newproveedor_direccion">
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">Población:</label>
                                <input type="text" class="form-control" id="newproveedor_poblacion" name="newproveedor_poblacion">
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">Provincia:</label>
                                <input type="text" class="form-control" id="newproveedor_provincia" name="newproveedor_provincia">
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">CP:</label>
                                <input type="text" class="form-control" id="newproveedor_cp" name="newproveedor_cp">
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">País:</label>
                                <input type="text" class="form-control" id="newproveedor_pais" name="newproveedor_pais">
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">Teléfono:</label>
                                <input type="text" class="form-control" id="newproveedor_telefono" name="newproveedor_telefono">
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">Email:</label>
                                <input type="text" class="form-control" id="newproveedor_email" name="newproveedor_email">
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">Web:</label>
                                <input type="text" class="form-control" id="newproveedor_web" name="newproveedor_web">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Descuento:</label>
                                <input type="text" class="form-control" id="newproveedor_dto" name="newproveedor_dto" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore"></label>
                                <button type="button" class="btn btn-primary" id="btn_descuentos" data-row-id="0">
                                    Tabla de Descuentos
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newproveedor_desc" name="newproveedor_desc" placeholder="Descripción" rows="5"></textarea>
                        </div>
                        
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newproveedor_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Proveedor guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_save_proveedor" class="btn btn-primary">Guardar</button>
                <button type="button" id="btn_del_proveedor" class="btn btn-primary">Elimnar</button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de descuentos -->
<div id="dto_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">TABLA DE DESCUENTOS</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="dto_grid" class="table table-condensed table-hover table-striped" cellspacing="0" data-toggle="bootgrid">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
                            <th data-column-id="fecha_val">Fecha Validez</th>
                            <th data-column-id="dto_prov">Dto</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="command-add-dto" data-row-id="0" disabled="true">
                    <span class="glyphicon glyphicon-plus"></span> Nuevo  Descuento
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Tabla de descuentos -->
<!-- Edit Descuento -->
<div id="edit_dto_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">EDITAR DESCUENTO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit_dto" name="frm_edit_dto">
                    <input type="hidden" value="edit" name="action" id="action">
                    <input type="hidden" value="0" name="edit_dto_id" id="edit_dto_id">
                    <div class="form-group">
                        <label class="labelBefore white">Fecha Validez:</label>
                        <input type="date" class="form-control" id="dtoedit_fechaval" name="dtoedit_fechaval">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Dto (%):</label>
                        <input type="text" class="form-control" id="dtoedit_dto" name="dtoedit_dto">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-primary" id="btn_edit_dto">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Descuento -->
<!-- New Descuento -->
<div id="add_dto_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">NUEVO DESCUENTO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form method="post" id="frm_add_dto" name="frm_add_dto">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="" name="newdto_proveedorid" id="newdto_proveedorid">
                    <div class="form-group">
                        <label class="labelBefore white">Fecha Validez:</label>
                        <input type="date" class="form-control" id="newdto_fechaval" name="newdto_fechaval">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Dto (%):</label>
                        <input type="text" class="form-control" id="newdto_dto" name="newdto_dto">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-primary" id="btn_new_dto">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- New Descuento -->

<!-- /PROVEEDORES -->

<!-- MATERIALES -->

<div id="addmaterial_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">MATERIALES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group" style="margin-bottom: 0px !important;">
                        <button type="button" id="btn_add_categoria" class="btn btn-primary">+ Categoría</button>
                    </div>
                    <form method="post" id="frm_new_material">
                        <input type="hidden" name="newmaterial_idmaterial" id="newmaterial_idmaterial">
                        <input type="hidden" name="material_del" id="material_del">
                        <input type="hidden" name="material_categoria_id" id="material_categoria_id">
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
                            <input type="text" class="form-control" id="newmaterial_nombre" name="newmaterial_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Fabricante:</label>
                            <input type="text" class="form-control" id="newmaterial_fabricante" name="newmaterial_fabricante">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Modelo:</label>
                            <input type="text" class="form-control" id="newmaterial_modelo" name="newmaterial_modelo">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Descuento:</label>
                            <input type="number" class="form-control" id="newmaterial_dto" name="newmaterial_dto" value="0">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Stock:</label>
                            <input type="number" class="form-control" id="newmaterial_stock" name="newmaterial_stock" value="0">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Último Precio:</label>
                                <input type="text" class="form-control" id="newmaterial_lastprice" name="newmaterial_lastprice">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore"></label>
                                <button type="button" class="btn btn-primary" id="btn_tarifas" data-row-id="0">
                                    Tabla de Tarifas
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newmaterial_desc" name="newmaterial_desc" placeholder="Descripción" rows="5"></textarea>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newmaterial_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Material guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_material" class="btn btn-primary">Guardar</button>
                <button type="button" id="btn_del_material" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de tarifas -->
<div id="tarifas_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">TABLA DE TARIFAS</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tarifas_grid" class="table table-condensed table-hover table-striped" cellspacing="0" data-toggle="bootgrid">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
                            <th data-column-id="nombre_proveedor">Proveedor</th>
                            <th data-column-id="fecha_val">Fecha Validez</th>
                            <th data-column-id="pvp">Tarifa</th>
                            <th data-column-id="dto_material">Dto</th>
                            <th data-column-id="proveedor_id">Proveedor Id</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="command-add" data-row-id="0" disabled="true">
                    <span class="glyphicon glyphicon-plus"></span> Nueva  Tarifa
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Tabla de tarifas -->
<!-- Edit Tarifa -->
<div id="edit_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">EDITAR TARIFA</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit" name="frm_edit">
                    <input type="hidden" value="edit" name="action" id="action">
                    <input type="hidden" value="0" name="edit_id" id="edit_id">
                    <div class="form-group">
                        <label class="labelBeforeBlack">Proveedor:</label>
                        <select id="tarifaedit_proveedor" name="tarifaedit_proveedor" class="selectpicker" data-live-search="true" data-width="33%">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Fecha Validez:</label>
                        <input type="date" class="form-control" id="tarifaedit_fechaval" name="tarifaedit_fechaval">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Tarifa (€):</label>
                        <input type="text" class="form-control" id="tarifaedit_tarifa" name="tarifaedit_tarifa">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Dto (%):</label>
                        <input type="text" class="form-control" id="tarifaedit_dto" name="tarifaedit_dto">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-primary" id="btn_edit_tarifa">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Tarifa -->
<!-- New Tarifa -->
<div id="add_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">NUEVA TARIFA</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form method="post" id="frm_add" name="frm_add">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="" name="newtarifa_materialid" id="newtarifa_materialid">
                    <div class="form-group">
                        <label class="labelBeforeBlack">Proveedor:</label>
                        <select id="newtarifa_proveedor" name="newtarifa_proveedor" class="selectpicker" data-live-search="true" data-width="33%">
                            <option></option>
                        </select>
                    </div>
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
                        <input type="text" class="form-control" id="newtarifa_dto" name="newtarifa_dto">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-primary" id="btn_new_tarifa">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Tarifa -->

<!-- /MATERIALES -->

<!-- CATEGORIAS -->

<div id="addcategoria_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CATEGORIAS DE MATERIALES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_categoria">
                        <input type="hidden" name="newcategoria_idcategoria" id="newcategoria_idcategoria">
                        <input type="hidden" name="categoria_del" id="categoria_del">
                        <div class="form-group">
                            <label class="labelBefore">Categoría:</label>
                            <select id="categorias_categorias" name="categorias_categorias" class="selectpicker categorias_categorias" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="categorias_nombre" name="categorias_nombre">
                        </div>
                        <div class="form-group" id="group-parentcat">
                            <label class="labelBefore">Categoría Padre:</label>
                            <select id="categorias_categoriasparent" name="categorias_categoriasparent" class="selectpicker categorias_categorias" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="categorias_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Material guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_save_categoria" class="btn btn-primary">Guardar</button>
                <button type="button" id="btn_del_categoria" class="btn btn-primary">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- /CATEGORIAS -->

<div id="matProv_view_model" class="modal fade">
    <div class="modal-dialog dialog_mediano">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">
                    MATERIAL PEDIDO POR PROVEEDOR 
                    <button class="btn button" id="print_matProveedor" title="Imprimir Material en PDF"><img src="/erp/img/print.png" height="30"></button>
                    <button class="btn button" id="printExcel_matProveedor" title="Imprimir Material en Excel"><img src="/erp/img/excel.png" height="30"></button>
                    <label class="labelBefore">Recibido:</label>
                    <select class="selectpicker custom-select-sm" id="select_recibido">
                        <option value="" selected>Todos</option>
                        <option value="1">Recibidos</option>
                        <option value="0">Pendientes de Recibir</option>
                    </select>
                </h4>
            </div>
            <div class="modal-body">
                <div class="loading-div"></div>
                <div class="contenedor-form" id="tabla-matProveedor" style="color: #333333; font-weight: 500;">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
