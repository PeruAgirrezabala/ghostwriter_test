<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-oferta" title="Añadir Oferta"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh-ofertas" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
    <button class="button" id="clean-filters" title="Borrar Filtros"><img src="/erp/img/clean.png" height="20"></button>
</div>

<div id="addoferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">OFERTA NUEVA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_oferta">
                        <input type="hidden" value="" name="proyecto_id" id="proyecto_id">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">REF:</label>
                                <input type="text" class="form-control" id="newoferta_ref" name="newoferta_ref" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Referencia Genelek:</label>
                                <input type="text" class="form-control" id="newoferta_ref_genelek" name="newoferta_ref_genelek">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Título: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="newoferta_titulo" name="newoferta_titulo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newoferta_proyectos" class="labelBefore">Proyecto: <span class="requerido2">*</span></label>
                                <select id="newoferta_proyectos" name="newoferta_proyectos" class="selectpicker" data-live-search="true" data-width='33%'>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newoferta_clientes" class="labelBefore">Cliente: <span class="requerido2">*</span></label>
                                <select id="newoferta_clientes" name="newoferta_clientes" class="selectpicker" data-live-search="true" data-width='33%'>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="newoferta_fecha" name="newoferta_fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Validez:</label>
                                <input type="text" class="form-control" id="newoferta_fechaval" name="newoferta_fechaval">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Descuento neto total %:</label>
                                <input type="text" class="form-control" id="newoferta_dtoTotal" name="newoferta_dtoTotal">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Forma de Pago:</label>
                                <input type="text" class="form-control" id="newoferta_formapago" name="newoferta_formapago">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Plazo de Entrega:</label>
                                <input type="text" class="form-control" id="newoferta_plazoentrega" name="newoferta_plazoentrega">
                            </div>
                        </div>

                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newoferta_desc" name="newoferta_desc" placeholder="Descripción de la Oferta" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newoferta_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Oferta guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_oferta" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- tools proyectos -->