<script>
    $(document).ready(function() {
        var xhr = new XMLHttpRequest();
        var url = "<? echo "../actividad/includes/temp/".$ref.".pdf"; ?>";
        xhr.open('HEAD', url, false);
        xhr.send();

        if (xhr.status == "404") {
            console.log("kk");
            $("#download-documento").hide();
            // NO EXISTE
        } else {
            console.log("aa");
            $("#download-documento").show();
            // EXISTE
        }
    });
</script>

<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-documento" title="Añadir Documento"><img src="/erp/img/add.png" height="20" style="width: auto !important;"></button>
    <button class="button" id="search-documento" title="Buscar"><img src="/erp/img/search.png" height="20" style="width: auto !important;"></button>
    <button class="button" id="refresh-documento" title="Actualizar"><img src="/erp/img/refresh.png" height="20" style="width: auto !important;"></button>
    <!-- Check exists -->
    <button class="button" id="download-documento" title="Descargar Parte/Actividad"><a href='<? echo "../actividad/includes/temp/".$ref.".pdf" ?>' target='_blank'><img src="/erp/img/download.png" height="20" style="width: auto !important;"></a></button>
</div>

<div id="detalleact_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_actividaddocs">
                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="actividad_docnombre" name="actividad_docnombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripcion:</label>
                            <input type="text" class="form-control" id="actividad_docdesc" name="actividad_docdesc">
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <div class="file-loading">
                                <label class="labelBefore">Archivos</label>
                                <input id="uploaddocs" name="uploaddocs[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <!--
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_intdetalle_save" class="btn btn-primary">Guardar</button>
                
            </div>
            -->
        </div>
    </div>
</div>
<!-- tools proyectos -->

<!-- DELETE DOCUMENTO -->
<div id="confirm_del_doc_modal" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">BORRAR DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_doc_id" id="del_doc_id">
                    <p>¿Estas seguro de que desea borrar este documento?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_confirmar_del_doc" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>