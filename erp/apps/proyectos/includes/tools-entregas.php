<!-- tools entregas -->
<div class="form-group form-group-tools">
    <button class="button" id="add-entrega" title="Añadir Entrega"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh-entregas" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools entregas -->

<div id="addentrega_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ENTREGA NUEVA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_entrega">
                        <input type="hidden" class="form-control" id="newentrega_proyecto" name="newentrega_proyecto" value="<? echo $_GET['id']; ?>">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">REF:</label>
                                <input type="text" class="form-control" id="newentrega_ref" name="newentrega_ref" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newentrega_nombre" name="newentrega_nombre">
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="newentrega_fechaentrega" name="newentrega_fechaentrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Pruebas:</label>
                                <input type="date" class="form-control" id="newentrega_fechatest" name="newentrega_fechatest">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Entrega Real:</label>
                                <input type="date" class="form-control" id="newentrega_fechareal" name="newentrega_fechareal">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newentrega_estados" class="labelBefore">Estado: </label>
                                <select id="newentrega_estados" name="newentrega_estados" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newentrega_desc" name="newentrega_desc" placeholder="Descripción de la Entrega" rows="5"></textarea>
                        </div>
                        
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newentrega_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Entrega guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_entrega" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>