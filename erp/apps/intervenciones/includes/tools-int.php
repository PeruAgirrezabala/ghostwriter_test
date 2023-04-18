<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-int" title="Nueva Intervención"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-int" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="addint_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PARTE DE INTERVENCIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_int_addint">
                        <input type="hidden" name="int_idint" id="int_idint">
                        <input type="hidden" name="int_del" id="int_del">
                        <!--
                        <div class="form-group">
                            <label class="labelBefore">REF:</label>
                            <input type="text" class="form-control" id="int_ref" name="int_ref">
                        </div>
                        -->
                        <div class="form-group">
                            <label class="labelBefore">Titulo:</label>
                            <input type="text" class="form-control" id="int_nombre" name="int_nombre">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">DESCRIPCIÓN:</label>
                            <textarea class="form-control" id="int_desc" name="int_desc" placeholder="Descripción de la Intervención" rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha:</label>
                                <input type="date" class="form-control" id="int_fecha" name="int_fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Facturación:</label>
                                <input type="date" class="form-control" id="int_fecha_factu" name="int_fecha_factu">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Responsable Genelek:</label>
                                <select id="int_responsable" name="int_responsable" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Técnicos:</label>
                                <select id="int_tecnicos" name="int_tecnicos" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label for="prev_oo" class="labelBefore" style="color: #ffffff;">oo </label>
                                <button type="button" id="btn_add_tec" class="btn btn-info2">Añadir Técnico</button>
                                <button type="button" id="btn_clear_tec" class="btn btn-primary">Quitar Técnico</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="int_addtecnicos" name="int_addtecnicos[]" multiple readonly>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Oferta:</label>
                            <select id="int_ofertas" name="int_ofertas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Proyecto:</label>
                            <select id="int_proyectos" name="int_proyectos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Cliente:</label>
                            <select id="int_clientes" name="int_clientes" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Instalación:</label>
                            <input type="text" class="form-control" id="int_instalacion" name="int_instalacion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Facturable:</label>
                                <input type="checkbox" name="int_chkfacu" id="int_chkfacu" checked data-size="mini">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Estado:</label>
                                <select id="int_estados" name="int_estados" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">OBSERVACIONES:</label>
                            <textarea class="form-control" id="int_observ" name="int_observ" placeholder="Observaciones de la Intervención" rows="8"></textarea>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="int_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Parte guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_int_save" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_int" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>