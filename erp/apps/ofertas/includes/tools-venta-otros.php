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
                $("#add-ventaotros-topro").removeAttr('disabled');
            }else{
                $("#add-ventaotros-topro").attr('disabled', 'disabled');
                $("#add-ventaotros-topro").attr('title', 'Deshabilitado. Solo disponible cuando la oferta esta aceptada!');
            }
        }   
    });
</script>
<!-- tools otros -->
<div class="form-group form-group-tools">
    <button class="button" id="add-ventaotros" title="Añadir Otro concepto"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-ventaotros" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="add-ventaotros-topro" title="Añadir Otros al Proyecto"><img src="/erp/img/otros.png" height="20"></button>
    <button class="button" id="refresh-ventaotros" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools otros -->

<div id="otros_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR OTROS CONCEPTOS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_ofertaotros">
                        <input type="hidden" value="" name="ofertaotros_detalle_id" id="ofertaotros_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="ofertaotros_oferta_id" id="ofertaotros_oferta_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="ofertaotros_titulo" name="ofertaotros_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="ofertaotros_descripcion" name="ofertaotros_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="ofertaotros_cantidad" name="ofertaotros_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Unitario:</label>
                                <input type="text" class="form-control" id="ofertaotros_unitario" name="ofertaotros_unitario">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Coste:</label>
                                <input type="text" class="form-control" id="ofertaotros_pvp" name="ofertaotros_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Margen Comercial (%):</label>
                                <input type="text" class="form-control" id="ofertaotros_inc" name="ofertaotros_inc" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP Venta Genelek:</label>
                                <input type="text" class="form-control" id="ofertaotros_pvp_total" name="ofertaotros_pvp_total" value="0" style="background-color: #5cb85c; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_ofertaotros_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<!-- Confirmar add Subcontratas --> 
<div id="confirm_costeotros_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN AÑADIR OTROS CONCEPTOS AL PROYECTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas añadir costes de otros conceptos de esta oferta al proyecto?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-costeotros-topro" data-id="" class="btn btn-info">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Borrar Venta Otros --> 
<div id="del_otrosoferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_otrosof_id" id="del_otrosof_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar este otro coste de venta?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-remove-detalle-otros" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>