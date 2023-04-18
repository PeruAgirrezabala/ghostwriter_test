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
                $("#add-ventamanoobra-topro").removeAttr('disabled');
            }else{
                $("#add-ventamanoobra-topro").attr('disabled', 'disabled');
                $("#add-ventamanoobra-topro").attr('title', 'Deshabilitado. Solo disponible cuando la oferta esta aceptada!');
            }
        }   
    });
</script>
<!-- tools manoobtra -->
<div class="form-group form-group-tools">
    <button class="button" id="add-ventamanoobra" title="Añadir Tarea"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="search-ventamanoobra" title="Buscar"><img src="/erp/img/search.png" height="20"></button>
    <button class="button" id="add-ventamanoobra-topro" title="Añadir mano de obra al proyecto"><img src="/erp/img/work2.png" height="20"></button>
    <button class="button" id="refresh-ventamanoobra" title="Actualizar"><img src="/erp/img/refresh.png" height="20"></button>
</div>

<!-- tools manoobra -->

<div id="manoobra_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR MANO DE OBRA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_ofertamano">
                        <input type="hidden" value="" name="ofertamano_detalle_id" id="ofertamano_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="ofertamano_oferta_id" id="ofertamano_oferta_id">
                        <input type="hidden" value="" name="ofertamano_tarea_id" id="ofertamano_tarea_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Tareas:</label>
                            <select id="ofertamano_tareas" name="ofertamano_tareas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Tipo de Horas:</label>
                            <select id="ofertamano_horas" name="ofertamano_horas" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="ofertamano_titulo" name="ofertamano_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="ofertamano_descripcion" name="ofertamano_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="ofertamano_cantidad" name="ofertamano_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio:</label>
                                <input type="text" class="form-control" id="ofertamano_preciohora" name="ofertamano_preciohora">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP:</label>
                                <input type="text" class="form-control" id="ofertamano_pvp" name="ofertamano_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento (%):</label>
                                <input type="text" class="form-control" id="ofertamano_dto" name="ofertamano_dto" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP Total:</label>
                                <input type="text" class="form-control" id="ofertamano_pvp_total" name="ofertamano_pvp_total" value="0" style="background-color: #5cb85c; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_ofertamano_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Borrar Mano Oferta --> 
<div id="del_manooferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_manof_id" id="del_manof_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar esta mano de obra?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-remove-detalle-mano" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmar add Mano Oferta --> 
<div id="confirm_ventamanoobra_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN AÑADIR MANO DE OBRA AL PROYECTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas añadir la mano de obra de esta oferta al proyecto?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-ventamanoobra-topro" data-id="" class="btn btn-info">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>