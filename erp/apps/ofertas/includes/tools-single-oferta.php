<script>
    $.ajax({
        type: "POST",  
        url: "acceptOferta.php",  
        data: {
            id: <? echo $_GET["id"];?>
        },
        dataType: "text",       
        success: function(response){
            console.log("Check: "+response);
            if(response.trim()==1){
                $("#versiones_aceptar").attr('disabled', 'disabled');
                $("#versiones_aceptar").attr('title', 'Deshabilitado. Ya hay una version de la oferta aceptada');
                $("#versiones_oferta").attr('disabled', 'disabled');
                $("#versiones_oferta").attr('title', 'Deshabilitado. Ya hay una version de la oferta aceptada');
                $("#delete_oferta").attr('disabled', 'disabled');
                $("#delete_oferta").attr('title', 'Deshabilitado. Ya hay una version de la oferta aceptada');
            }else{
                $("#versiones_aceptar").removeAttr('disabled');
                $("#versiones_oferta").removeAttr('disabled');
                $("#delete_oferta").removeAttr('disabled');
            }
        }   
    });
</script>

<!-- filtros proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="edit_oferta" title="Editar Oferta"><img src="/erp/img/edit.png" height="30"></button>
    <button class="button" id="save_oferta" title="Guardar Oferta"><img src="/erp/img/save.png" height="30"></button>
    <button class="button" id="print_oferta" title="Imprimir Oferta"><img src="/erp/img/print.png" height="30"></button>
    <button class="button" id="delete_oferta" title="Eliminar Oferta"><img src="/erp/img/bin.png" height="30"></button>
    <button class="button" id="versiones_oferta" title="Versiones Oferta"><img src="/erp/img/historia.png" height="30"></button>
    <button class="button" id="versiones_aceptar" title="Aceptar Oferta"><img src="/erp/img/tick2.png" height="30"></button>
</div>

<!-- filtros proyectos -->

<div id="versionesoferta_model" class="modal fade">

</div>
<!-- DELETE VERSIONES -->
<div id="delete_versiones_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_versionoferta_id" id="del_versionoferta_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar esta versión?</label>
                    </div>
                    <div class="form-group">
                        <label class="labelBefore">Atención: No borrar la original</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_versionoferta_id" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div id="confirm_aceptoferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas aceptar esta oferta?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_versiones_aceptar" data-id="" class="btn btn-info">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>