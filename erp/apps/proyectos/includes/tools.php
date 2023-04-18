<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-proyecto"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh_proyectos"><img src="/erp/img/refresh.png" height="20"></button>
    <button class="button" id="clean-filters" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="addproyecto_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PROYECTO NUEVO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_proyecto">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">REF:</label>
                                <input type="text" class="form-control" id="newproyecto_ref" name="newproyecto_ref" disabled="true">
                                <label class="helper">La referencia la genera automáticamente</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore"><span class="guia">1</span> Nombre: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newproyecto_nombre" name="newproyecto_nombre">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newproyecto_estados" class="labelBefore"><span class="guia">2</span> Tipo: <span class="requerido">*</span></label>
                                <select id="newproyecto_tipoproyecto" name="newproyecto_tipoproyecto" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newproyecto_clientes" class="labelBefore"><span class="guia">3</span> Cliente: <span class="requerido" title="Cliente Final">*</span></label>
                                <select id="newproyecto_clientes" name="newproyecto_clientes" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label for="newproyecto_clientes" class="labelBefore" style="color: #ffffff;">oo </label>
                                <button type="button" id="btn_add_cliente" class="btn btn-info">Añadir Cliente</button>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newproyecto_cliente_final" class="labelBefore"><span class="guia">4</span> Cliente Final: <span class="requerido" title="Cliente Final">*</span></label>
                                <select id="newproyecto_cliente_final" name="newproyecto_cliente_final" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label for="newproyecto_cliente_final" class="labelBefore" style="color: #ffffff;">oo </label>
                                <button type="button" id="btn_add_cliente_final" class="btn btn-info">Añadir Cliente</button>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newproyecto_ing" class="labelBefore">Ingeniería: <span class="requerido2">*</span></label>
                                <select id="newproyecto_ing" name="newproyecto_ing" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newproyecto_dirobra" class="labelBefore">Dirección de Obra: <span class="requerido2" title="Documentacion PRL">*</span></label>
                                <select id="newproyecto_dirobra" name="newproyecto_dirobra" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newproyecto_promotor" class="labelBefore">Promotor: <span class="requerido2" title="El que nos contrata">*</span></label>
                                <select id="newproyecto_promotor" name="newproyecto_promotor" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore"><span class="guia">5</span> Fecha Inicio: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="newproyecto_fechaini" name="newproyecto_fechaini">
                            </div>
                            <label class="helper">Esta será la fecha que tendrá en cuenta para crear la estructura de carpetas en Últimos</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="newproyecto_fechaentrega" name="newproyecto_fechaentrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Fin:</label>
                                <input type="date" class="form-control" id="newproyecto_fechafin" name="newproyecto_fechafin">
                            </div>
                            <label class="helper">Fecha fin real. Fecha en la que se ha entregado el proyecto</label>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Instalación:</label>
                            <input type="text" class="form-control" id="newproyecto_ubicacion" name="newproyecto_ubicacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección Instalación:</label>
                            <input type="text" class="form-control" id="newproyecto_direccion" name="newproyecto_direccion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Coord. GPS Instalación:</label>
                            <input type="text" class="form-control" id="newproyecto_gps" name="newproyecto_gps">
                        </div>
                        <div class="form-group">
                            <label for="newproyecto_estados" class="labelBefore"><span class="guia">6</span> Estado: <span class="requerido">*</span></label>
                            <select id="newproyecto_estados" name="newproyecto_estados" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="newproyecto_parentproyecto" class="labelBefore">SubProyecto de: </label>
                            <select id="newproyecto_parentproyecto" name="newproyecto_parentproyecto" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newproyecto_desc" name="newproyecto_desc" placeholder="Descripción del Proyecto" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <br>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newproyecto_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Proyecto guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_proyecto" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- proyectos activos -->

<!-- CLIENTES -->

<div id="addcliente_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CLIENTES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_cliente" enctype="multipart/form-data">
                        <input type="hidden" name="newcliente_idcliente" id="newcliente_idcliente">
                        <input type="hidden" name="cliente_del" id="cliente_del">
                        <div class="form-group">
                            <label class="labelBefore">Clientes:</label>
                            <select id="proyectos_clientes" name="proyectos_clientes" class="selectpicker categorias_categorias" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newcliente_nombre" name="newcliente_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección:</label>
                            <input type="text" class="form-control" id="newcliente_direccion" name="newcliente_direccion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Población:</label>
                            <input type="text" class="form-control" id="newcliente_poblacion" name="newcliente_poblacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Provincia:</label>
                            <input type="text" class="form-control" id="newcliente_provincia" name="newcliente_provincia">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">CP:</label>
                            <input type="text" class="form-control" id="newcliente_cp" name="newcliente_cp">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">País:</label>
                            <input type="text" class="form-control" id="newcliente_pais" name="newcliente_pais">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Teléfono:</label>
                            <input type="text" class="form-control" id="newcliente_telefono" name="newcliente_telefono">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Email:</label>
                            <input type="text" class="form-control" id="newcliente_email" name="newcliente_email">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Web:</label>
                            <input type="text" class="form-control" id="newcliente_web" name="newcliente_web">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">NIF:</label>
                            <input type="text" class="form-control" id="newcliente_nif" name="newcliente_nif">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">URL PRL:</label>
                            <input type="text" class="form-control" id="newcliente_urlPRL" name="newcliente_urlPRL">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">URL PRL USER:</label>
                                <input type="text" class="form-control" id="newcliente_urlPRL_U" name="newcliente_urlPRL_U">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore">URL PRL PASSWORD:</label>
                                <input type="text" class="form-control" id="newcliente_urlPRL_P" name="newcliente_urlPRL_P">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Imagen:</label>
                                <input type="file" class="form-control" id="newcliente_logo" name="newcliente_logo">
                            </div>
                            <div class="col-xs-6">
                                <label for="newproyecto_clientes" class="labelBefore" style="color: #ffffff;">oo </label>
                                <img src="" style="display: none; height: 100px !important;" id="newcliente_imgprview">
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newcliente_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Cliente guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_cliente" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_cliente" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- /CLIENTES -->