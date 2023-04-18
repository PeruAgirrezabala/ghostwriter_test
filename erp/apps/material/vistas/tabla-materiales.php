<!-- MATERIALES -->
<!-- Tabla de materiales -->
<table id="materiales_grid" class="table table-condensed table-hover table-striped" cellspacing="0" data-toggle="bootgrid">
    <thead>
        <tr>
            <th data-column-id="material" data-type="numeric" data-identifier="true">Id</th>
            <th data-column-id="ref" title="asdd fsaf sadf " data-toggle="tooltip">REF</th>
            <th data-column-id="nombre_material">Material</th>
            <th data-column-id="fabricante">Fabricante</th>
            <th data-column-id="modelo">Modelo</th>
            <th data-column-id="precio">Último precio</th>
            <th data-column-id="DTO2">Descuento</th>
            <!--<th data-column-id="stock_old">Stock_old</th>-->
            <th data-column-id="stock">Stock</th>
            <th data-column-id="cad">Caducado</th>
            <th data-column-id="sustituto">Sustituto</th>
            <th data-column-id="categoria_id">Categoria id</th>
            <th data-column-id="descripcion">Categoria id</th>
            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
        </tr>
    </thead>
</table>
<div class="loading-div" id="loading-materiales"></div>
<!-- Tabla de materiales -->

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
                        <button type="button" class="btn btn-info" id="add-sn" title="Serial Number"><img src="/erp/img/serialnumber.png" height="20"></button>
                    </div>
                    <form method="post" id="frm_new_material">
                        <input type="hidden" name="newmaterial_idmaterial" id="newmaterial_idmaterial">
                        <input type="hidden" name="material_del" id="material_del">
                        <input type="hidden" name="material_categoria_id" id="material_categoria_id">
                        <input type="hidden" name="material_sn" id="material_sn" value="0">
                        <div class="form-group">
                            <label class="labelBefore"><span class="guia">1</span> Categoría: <span class="requerido">*</span></label>
                            <select id="materiales_categoria1" name="materiales_categoria1" class="selectpicker materiales_categorias" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Materiales:</label>
                            <select id="newmaterial_materiales" name="newmaterial_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div id="sn_container" style="display: none;">
                            <div class="form-group">
                                <label class="labelBefore">S/N:</label>
                                <input type="text" class="form-control" id="newmaterial_sn" name="newmaterial_sn">
                            </div>
                            <div class="form-group">
                                <label class="labelBefore">Proveedor:</label>
                                <select id="newmaterial_proveedores" name="newmaterial_proveedores" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="labelBefore">Cliente:</label>
                                <select id="newmaterial_clientes" name="newmaterial_clientes" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                            
                        <div id="mat_container">
                            <div class="form-group">
                                <label class="labelBefore"><span class="guia">2</span> REF: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="newmaterial_ref" name="newmaterial_ref" >
                            </div>
                            <div id="alerta-ref-duplicado" hidden>
                                <span class="requerido">Atencion, Referencia duplicada!</span>                                
                            </div>
                            <div class="form-group">
                                <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="newmaterial_nombre" name="newmaterial_nombre" >
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
                                <div class="col-xs-6">
                                    <label class="labelBefore">Stock:</label>
                                    <input type="number" class="form-control" id="newmaterial_stock" name="newmaterial_stock" value="0" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label class="labelBefore"></label>
                                    <button type="button" class="btn btn-info2" id="btn_add_stock_modal" data-row-id="0">
                                        Añadir Stock
                                    </button>
                                </div>
                            </div>
                            <div class="form-group" id="div-ultimoprecio">
                                <div class="col-xs-6">
                                    <label class="labelBefore"><span class="guia">3</span> Último Precio: <span class="requerido">*</span></label>
                                    <input type="text" class="form-control" id="newmaterial_lastprice" name="newmaterial_lastprice">
                                </div>
                                <div class="col-xs-6">
                                    <label class="labelBefore"></label>
                                    <button type="button" class="btn btn-info2" id="btn_tarifas" data-row-id="0">
                                        Tabla de Tarifas
                                    </button>
                                </div>
                                <label class="helper">Recuerda que tendrás que asociar posteriormente la tarifa introducida a un proveedor y estabelcer su vigencia.</label>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="labelBefore">Sustituto:</label>
                                <input type="text" class="form-control" id="newmaterial_sustituto" name="newmaterial_sustituto">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newmaterial_desc" name="newmaterial_desc" placeholder="Descripción" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--<br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newmaterial_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Material guardado</p>
                    </div>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newmaterial_error" style="display:none; margin: 0px auto 0px auto; background-color:red;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p style="color:black">Error:Rellena los campos requeridos</p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_material" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_material" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- AÑADIR SERIAL NUMBER -->

<!-- Añadir Stock -->
<div id="addstock_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_mini" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">AÑADIR STOCK</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="0" name="add_material_id" id="add_material_id">
                <label class="helper">Esta opción añadirá directamente material a un pedido previamente creado.</label>
                <input type="number" class="form-control" id="add_stock" name="add_stock" value="0">
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_stock" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /Añadir Stock -->


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
                <button type="button" class="btn btn-info" id="command-add" data-row-id="0" disabled="true">
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
                        <input type="text" class="form-control" id="tarifaedit_dto" name="tarifaedit_dto" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-info" id="btn_edit_tarifa">Guardar</button>
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
                        <input type="text" class="form-control" id="newtarifa_dto" name="newtarifa_dto" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-info" id="btn_new_tarifa">Guardar</button>
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
                <button type="button" id="btn_save_categoria" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_categoria" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- /CATEGORIAS -->

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
                            <label class="labelBefore">CIF:</label>
                            <input type="text" class="form-control" id="newproveedor_CIF" name="newproveedor_CIF">
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
                                <button type="button" class="btn btn-info2" id="btn_descuentos" data-row-id="0">
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
                <button type="button" id="btn_save_proveedor" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_proveedor" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
                <button type="button" class="btn btn-info" id="command-add-dto" data-row-id="0" disabled="true">
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
                <button type="button" class="btn btn-info" id="btn_edit_dto">Guardar</button>
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
                <button type="button" class="btn btn-info" id="btn_new_dto">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- New Descuento -->
<!-- Modal Stock -->
<div id="view_stock_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">STOCK ALMACÉN</h4>
            </div>
            <div class="modal-body">
                <? include("vistas/filtros-material-almacen.php"); ?>
                <div class="contenedor-form" id="tabla_stock">
                    <form method="post" id="frm_ViewStock">
                        <table class="table table-striped table-hover" id="tabla-stock">
                            <thead>
                                <tr class="bg-dark">
                                    <th class="text-center">ID</th>
                                    <th class="text-center">REF</th>
                                    <th class="text-center" style='max-width: 600px;'>MATERIAL</th>
                                    <th class="text-center">FABRICANTE</th>
                                    <th class="text-center">MODELO</th>
                                    <th class="text-center">STOCK TOT.</th>
                                    <th class="text-center">STOCK ALM.</th>
                                    <th class="text-center">STOCK PTE.</th>
                                    <th class="text-center">VER</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?
                                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                include_once($pathraiz."/connection.php");

                                $db = new dbObj();
                                $connString =  $db->getConnstring();
                            
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
                                        GROUP BY 
                                            MATERIALES.id,
                                            MATERIALES.ref";
                                file_put_contents("selectModalStockAlmacen.txt", $sql);
                                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de OLD Calibraciones");

                                while ($row = mysqli_fetch_array($resultado)) {
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
                                    
                                    
                                    echo "<tr data-id='".$idMaterialStock."' id='doc-calibraciones-".$idMaterialStock."'>
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
                                echo " </tbody></table>";
                                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
