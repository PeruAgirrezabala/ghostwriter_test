<!-- tools ofertas -->
<div class="form-group form-group-tools">
    <!-- . TEMPORALMENTE DESHABILITADO. AÑADIR DESDE OFERTAS!" disabled -->
    <button class="button" id="add-oferta" title="Añadir Oferta"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-oferta" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-ofertas" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools ofertas -->

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
                        <input type="hidden" value="<? echo $_GET['id'] ?>" name="proyecto_id" id="proyecto_id">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">REF:</label>
                                <input type="text" class="form-control" id="newoferta_ref" name="newoferta_ref" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Título:</label>
                                <input type="text" class="form-control" id="newoferta_titulo" name="newoferta_titulo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newoferta_clientes" class="labelBefore">Cliente: </label>
                                <select id="newoferta_clientes" name="newoferta_clientes" class="selectpicker" data-live-search="true" data-width='33%' disabled>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha:</label>
                                <input type="date" class="form-control" id="newoferta_fecha" name="newoferta_fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Validez:</label>
                                <input type="date" class="form-control" id="newoferta_fechaval" name="newoferta_fechaval">
                            </div>
                        </div>

                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newoferta_desc" name="newoferta_desc" placeholder="Descripción de la Oferta" rows="10"></textarea>
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