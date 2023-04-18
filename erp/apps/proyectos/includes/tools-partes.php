<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-parte" title="Añadir Parte"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-parte" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="refresh-partes" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="proyecto_addparte_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PARTE DE TRABAJO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_proyecto_addparte">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="proyectoparte_proyecto_id" id="proyectoparte_proyecto_id">
                        <input type="hidden" name="proyectoparte_idparte" id="proyectoparte_idparte">
                        <input type="hidden" name="proyectoparte_del" id="proyectoparte_del">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Tipo:</label>
                            <select id="proyecto_partetipos" name="proyecto_partetipos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">REF:</label>
                            <input type="text" class="form-control" id="proyecto_parteref" name="proyecto_parteref">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Titulo:</label>
                            <input type="text" class="form-control" id="proyecto_partenombre" name="proyecto_partenombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fecha:</label>
                            <input type="text" class="form-control" id="proyecto_partefecha" name="proyecto_partefecha">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fecha Facturación:</label>
                            <input type="text" class="form-control" id="proyecto_partefecha_factu" name="proyecto_partefecha_factu">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Técnicos:</label>
                            <select id="proyecto_partetecnicos" name="proyecto_partetecnicos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Instalación:</label>
                            <input type="text" class="form-control" id="proyecto_parteinstalacion" name="proyecto_parteinstalacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Estado:</label>
                            <select id="proyecto_parteestados" name="proyecto_parteestados" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="proyecto_partesuccess" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Parte guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_proyecto_parte_save" class="btn btn-primary">Guardar</button>
                <button type="button" id="btn_del_proyectoparte" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>