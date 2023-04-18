<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-envio" title="Crear Envío"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh-envios" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="addenvio_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ENVÍO NUEVO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_envio">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Título: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="newenvio_titulo" name="newenvio_titulo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_tipo" class="labelBefore">Tipo: <span class="requerido">*</span></label>
                                <select id="newenvio_tipo" name="newenvio_tipo" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_transportistas" class="labelBefore">Transportista: <span class="requerido">*</span></label>
                                <select id="newenvio_transportistas" name="newenvio_transportistas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_ref_trans" class="labelBefore">REF Transportista: </label>
                                <input type="text" class="form-control" id="newenvio_ref_trans" name="newenvio_ref_trans">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_clientes" class="labelBefore">Cliente: </label>
                                <select id="newenvio_clientes" name="newenvio_clientes" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <!--<div class="form-group"></div>-->
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_proveedores" class="labelBefore">Proveedor: </label>
                                <select id="newenvio_proveedores" name="newenvio_proveedores" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_dest" class="labelBefore">Destinatario: </label>
                                <input type="text" class="form-control" id="newenvio_dest" name="newenvio_dest" placeholder="Introducir sólo si no se ha seleccionado cliente.">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_att" class="labelBefore">Att: </label>
                                <input type="text" class="form-control" id="newenvio_att" name="newenvio_att" placeholder="Introducir sólo si no se ha seleccionado cliente.">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label for="newenvio_direnvio" class="labelBefore">Dirección de Envío: <span class="requerido2">*</span></label>
                            <textarea class="form-control" id="newenvio_direnvio" name="newenvio_direnvio" placeholder="Introduce la dirección de envío o déjalo en blanco para coger la del cliente" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_formaenvio" class="labelBefore">Forma Envío: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="newenvio_formaenvio" name="newenvio_formaenvio" value="NORMAL">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_portes" class="labelBefore">Portes: <span class="requerido">*</span></label>
                                <!--<input type="text" class="form-control" id="newenvio_portes" name="newenvio_portes" value="PAGADOS">-->
                                <select id="newenvio_portes" name="newenvio_portes" class="selectpicker" data-live-search="true">
                                    <option value=""></option>
                                    <option value="1">PAGADOS</option>
                                    <option value="0">NO PAGADOS</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_gastos" class="labelBefore">Gastos Envío: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="newenvio_gastos" name="newenvio_gastos" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_pedido_CLI" class="labelBefore">PEDIDO CLIENTE: </label>
                                <input type="text" class="form-control" id="newenvio_pedido_CLI" name="newenvio_pedido_CLI">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_oferta_prov" class="labelBefore">OFERTA PROVEEDOR: </label>
                                <input type="text" class="form-control" id="newenvio_oferta_prov" name="newenvio_oferta_prov">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_proyectos" class="labelBefore">Proyecto: </label>
                                <select id="newenvio_proyectos" name="newenvio_proyectos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_proyectos" class="labelBefore">Entrega: </label>
                                <select id="newenvio_entregas" name="newenvio_entregas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
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
                                <label for="newenvio_fecha" class="labelBefore">Fecha: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="newenvio_fecha" name="newenvio_fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_fechaentrega" class="labelBefore">Fecha Entrega: </label>
                                <input type="date" class="form-control" id="newenvio_fechaentrega" name="newenvio_fechaentrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_plazo" class="labelBefore">Plazo de Entrega: </label>
                                <input type="text" class="form-control" id="newenvio_plazo" name="newenvio_plazo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_contacto" class="labelBefore">Contacto: </label>
                                <input type="text" class="form-control" id="newenvio_contacto" name="newenvio_contacto">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_tecnicos" class="labelBefore">De: <span class="requerido">*</span></label>
                                <select id="newenvio_tecnicos" name="newenvio_tecnicos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newenvio_estados" class="labelBefore">Estado: <span class="requerido">*</span></label>
                                <select id="newenvio_estados" name="newenvio_estados" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group form-group-view">
                            <label for="newenvio_desc" class="labelBefore">Descripción: </label>
                            <textarea class="form-control" id="newenvio_desc" name="newenvio_desc" placeholder="Descripción del Envío" rows="5"></textarea>
                        </div>
                        
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newenvio_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Envío guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_envio" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Envios -->
