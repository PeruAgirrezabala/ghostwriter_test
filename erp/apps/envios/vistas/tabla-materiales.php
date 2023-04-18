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
            <th data-column-id="stock">Stock</th>
            <th data-column-id="cad">Caducado</th>
            <th data-column-id="relacionado_nombre">Sustituto</th>
            <th data-column-id="categoria_id">Categoria id</th>
            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
        </tr>
    </thead>
</table>
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
                            <label class="labelBefore">REF:</label>
                            <input type="text" class="form-control" id="newmaterial_ref" name="newmaterial_ref">
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
                <button type="button" id="btn_save_material" class="btn btn-info">Guardar</button>
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