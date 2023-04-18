<!-- tools doc admon -->
<div class="form-group form-group-tools">
    <button class="button" id="add-acta" title="Crear Acta"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="clean-filters-actas" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
</div>
<span class="stretch"></span>
<div id="proyectos-filterbar" class="one-column">
     <? include($pathraiz."/apps/calidad/vistas/filtros-actas.php"); ?>
</div>
<!-- tools

<!-- tools doc admon -->

<div id="acta_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ACTA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_addActa">
                        <input type="hidden" value="" name="addActa_id" id="addActa_id">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                                <input type="text" class="form-control" id="addActa_nombre" name="addActa_nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="labelBefore">Descripción: <span class="requerido">*</span></label>
                                <textarea type="text" class="form-control" id="addActa_descripcion" name="addActa_descripcion" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="addActa_fecha" name="addActa_fecha">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_acta_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- POP-UP Subir fichero-->

<div id="adddocActa_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_adddocActa">
                        <input type="hidden" id="adddocActa">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha hoy: </label>
                                <input type="date" class="form-control" id="adddocActa_fecha" name="adddocActa_fecha">
                            </div>
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <label class="labelBefore">Archivo: </label>
                            <div class="file-loading">
                                <label class="labelBefore">Archivo</label>
                                <input id="uploaddocsACTA" name="uploaddocsACTA[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <!--
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_pedidodetalle_save" class="btn btn-primary">Guardar</button>
                
            </div>
            -->
        </div>
    </div>
</div>