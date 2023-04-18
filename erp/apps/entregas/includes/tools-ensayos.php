<!-- tools entregas -->
<div class="form-group form-group-tools">
    <button class="button" id="add-ensayo"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh_ensayos"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools entregas -->

<div id="addensayo_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ENSAYO NUEVO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_ensayo" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" id="newensayo_identrega" name="newensayo_identrega" value="<? echo $_GET['id']; ?>">
                        <input type="hidden" class="form-control" id="newensayo_idensayo" name="newensayo_idensayo" value="">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newensayo_nombre" name="newensayo_nombre">
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha:</label>
                                <input type="date" class="form-control" id="newensayo_fecha" name="newensayo_fecha">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Finalización:</label>
                                <input type="date" class="form-control" id="newensayo_fechafin" name="newensayo_fechafin">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newensayo_plantilla" class="labelBefore">Plantilla: </label>
                                <select id="newensayo_plantilla" name="newensayo_plantilla" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label for="print_ensayo" class="labelBefore">Imprimir: </label>
                                <button type="button" id="print_ensayo"><img src="/erp/img/print.png" height="25"></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newensayo_estados" class="labelBefore">Estado: </label>
                                <select id="newensayo_estados" name="newensayo_estados" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newensayo_tecnico" class="labelBefore">Técnico: </label>
                                <select id="newensayo_tecnico" name="newensayo_tecnico" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newensayo_desc" name="newensayo_desc" placeholder="Descripción de la Entrega" rows="5"></textarea>
                        </div>
                        <!-- SUBIR FICHERO?!!?
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Documento: </label>
                                <input type="date" class="form-control" id="adddocEnsayo_fecha" name="adddocEnsayo_fecha">
                                <label class="labelBefore">Archivo: </label>
                                <div class="file-loading">
                                    <label class="labelBefore">Adjunto:</label>
                                    <input type="file" id="newensayo_adjunto" name="newensayo_adjunto[]" data-show-preview="true" data-browse-on-zone-click="true">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore">Archivos de ensayos:</label>
                                <div class="form-group" id="newensayo_archivos">
                                    
                                </div>
                            </div>
                        </div>-->
                        <div class="form-group"></div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Información Adicional: <button type="button" id="view_info"><img src="/erp/img/ojo.png" height="20"></button></label>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group form-group-view" id="info-ensayo" style="display:none;">
                            
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newensayo_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Ensayo guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_ensayo" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar Delete Ensayo--> 
<div id="confirm_del_ensayo_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR ENSAYO</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_ensayoid" id="del_ensayoid" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>¿Estas seguro que quieres eliminar este ensayo?</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_ensayo" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar Delete Ensayo Doc--> 
<div id="confirm_del_ensayodoc_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR DOCUMENTO DEL ENSAYO</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_ensayoiddoc" id="del_ensayoiddoc" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>¿Estas seguro que quieres eliminar este documento del ensayo?</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_ensayo_doc" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar Delete Ensayo Info--> 
<div id="confirm_del_infoensayo_model" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR ENSAYO INFORMACIÓN</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_infoensayoid" id="del_infoensayoid" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_grupos" enctype="multipart/form-data">
                        <p>¿Estas seguro que quieres eliminar esta linea de información del ensayo?</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_del_infoensayo" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Ensayo Info--> 
<div id="confirm_add_infoensayo_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ENSAYO INFORMACIÓN</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="add_ensayoid" id="add_ensayoid" value="">
                <input type="hidden" name="add_infoensayoid" id="add_infoensayoid" value="">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_infoensayo" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="labelBefore">Titulo:</label>
                            <input type="text" class="form-control" id="newensayoinfo_titulo" name="newensayoinfo_titulo">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newensayoinfo_desc" name="newensayoinfo_desc" placeholder="Descripción" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Estado:</label>
                            <input type="text" class="form-control" id="newensayoinfo_estado" name="newensayoinfo_estado">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Fecha:</label>
                            <input type="date" class="form-control" id="newensayoinfo_fecha" name="newensayoinfo_fecha">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 50px;">
                <button type="button" id="btn_add_infoensayo" class="btn btn-info">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
