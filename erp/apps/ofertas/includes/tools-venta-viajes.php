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
                $("#add-ventaviajes-topro").removeAttr('disabled');
            }else{
                $("#add-ventaviajes-topro").attr('disabled', 'disabled');
                $("#add-ventaviajes-topro").attr('title', 'Deshabilitado. Solo disponible cuando la oferta esta aceptada!');
            }
        }   
    });
</script>
<!-- tools viajes -->
<div class="form-group form-group-tools">
    <button class="button" id="add-ventaviajes" title="Añadir Viaje/Desplazamiento"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-ventaviajes" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="add-ventaviajes-topro" title="Añadir Viajes al Proyecto"><img src="/erp/img/viajes-desplazamientos.png" height="20"></button>
    <button class="button" id="refresh-ventaviajes" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools viajes -->
<div id="viajes_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR VIAJE/DESPLAZAMIENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_ofertaviajes">
                        <input type="hidden" value="" name="ofertaviajes_detalle_id" id="ofertaviajes_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="ofertaviajes_oferta_id" id="ofertaviajes_oferta_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="ofertaviajes_titulo" name="ofertaviajes_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="ofertaviajes_descripcion" name="ofertaviajes_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="ofertaviajes_cantidad" name="ofertaviajes_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Unitario:</label>
                                <input type="text" class="form-control" id="ofertaviajes_unitario" name="ofertaviajes_unitario">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Coste:</label>
                                <input type="text" class="form-control" id="ofertaviajes_pvp" name="ofertaviajes_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Margen Comercial (%):</label>
                                <input type="text" class="form-control" id="ofertaviajes_inc" name="ofertaviajes_inc" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP Venta Genelek:</label>
                                <input type="text" class="form-control" id="ofertaviajes_pvp_total" name="ofertaviajes_pvp_total" value="0" style="background-color: #5cb85c; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_ofertaviajes_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmar add viajes --> 
<div id="confirm_costevieje_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN AÑADIR VIAJES/DESPLAZAMIENTOS AL PROYECTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas añadir el viaje/desplazamiento de esta oferta al proyecto?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-costevieje-topro" data-id="" class="btn btn-info">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Borrar Venta Viajes --> 
<div id="del_viajeoferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_viajeof_id" id="del_viajeof_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar este viaje?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-remove-detalle-viaje" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>