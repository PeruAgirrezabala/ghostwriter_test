<script>
    $.ajax({
        type: "POST",  
        url: "acceptOferta.php",  
        data: {
            thisid: <? echo $_GET["id"];?>
        },
        dataType: "text",       
        success: function(response){
            if(response.trim()==1){
                $("#add-costesubcontratas-topro").removeAttr('disabled');
            }else{
                $("#add-costesubcontratas-topro").attr('disabled', 'disabled');
                $("#add-costesubcontratas-topro").attr('title', 'Deshabilitado. Solo disponible cuando la oferta esta aceptada!');
            }
        }   
    });
</script>
<!-- tools subcontratas -->
<div class="form-group form-group-tools">
    <button class="button" id="add-costesubcontratas" title="Añadir Subcontratación"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-costesubcontratas" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="add-costesubcontratas-topro" title="Añadir Subcontrataciones al Proyecto"><img src="/erp/img/subcontrataciones.png" height="20"></button>
    <button class="button" id="refresh-costesubcontratas" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools subcontratas -->

<div id="subcontratacion_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR SUBCONTRATACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_ofertasub">
                        <input type="hidden" value="" name="ofertasub_detalle_id" id="ofertasub_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="ofertasub_oferta_id" id="ofertasub_oferta_id">
                        <input type="hidden" value="" name="ofertasub_tercero_id" id="ofertasub_tercero_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Proveedores:</label>
                            <select id="ofertasub_terceros" name="ofertasub_terceros" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="ofertasub_titulo" name="ofertasub_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="ofertasub_descripcion" name="ofertasub_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="ofertasub_cantidad" name="ofertasub_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Unitario:</label>
                                <input type="text" class="form-control" id="ofertasub_unitario" name="ofertasub_unitario">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Coste:</label>
                                <input type="text" class="form-control" id="ofertasub_pvp" name="ofertasub_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Cliente (%):</label>
                                <input type="text" class="form-control" id="ofertasub_dto" name="ofertasub_dto" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Coste - Descuento:</label>
                                <input type="text" class="form-control" id="ofertasub_pvpdto" name="ofertasub_pvpdto" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Margen Comercial (%):</label>
                                <input type="text" class="form-control" id="ofertasub_incremento" name="ofertasub_incremento" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP Venta Genelek:</label>
                                <input type="text" class="form-control" id="ofertasub_pvpinc" name="ofertasub_pvpinc" value="0" style="background-color: #5cb85c; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_ofertasub_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar add Subcontratas --> 
<div id="confirm_costesubcontratas_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN AÑADIR SUBCONTRATACIÓN AL PROYECTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas añadir la subcontratación de esta oferta al proyecto?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-costesubcontratas-topro" data-id="" class="btn btn-info">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Borrar Mano Oferta --> 
<div id="del_costesubcontratas_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_sub_id" id="del_sub_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar esta subcontratación?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-remove-detalle-sub" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>