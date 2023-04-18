<!-- accesosroles -->
<div id="accesosroles">
    <form method="post" id="frm_roles">
        <input type="hidden" name="accesosroles_delrole" id="accesosroles_delrole">
        <div class="selectors">
            <div id="accesosroles_selectorRol">
                <label class="labelBefore">ROLES</label>
                <select id="accesosroles_roles" name="accesosroles_roles" class="selectpicker" data-live-search="true" data-width="33%">
                    <option></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-4">
                <label class="labelBefore">Nombre:</label>
                <input type="text" class="form-control" id="accesosroles_edit_nombre" name="accesosroles_edit_nombre">
            </div>
        </div>
        
        <div class="accesosroles-apps">
            <h5 class="tituloBlanco">
                APLICACIONES
            </h5>
            <div class="form-group appsSelector">
                <img src="/img/bitly-icon.png" width="80" data-id="1" data-app="app_bitly_id">
                <input type="hidden" name="app_bitly_id" id="app_bitly_id" value="">
                <img src="/img/boolean-search.png" width="80" data-id="4" data-app="app_boolean_id">
                <input type="hidden" name="app_boolean_id" id="app_boolean_id" value="">
                <img src="/img/crm.png" width="80" data-id="6" data-app="app_crm_id">
                <input type="hidden" name="app_crm_id" id="app_crm_id" value="">
                <img src="/img/eventos.png" width="80" data-id="3" data-app="app_eventos_id">
                <input type="hidden" name="app_eventos_id" id="app_eventos_id" value="">
                <img src="/img/juntador.png" width="80" data-id="5" data-app="app_juntador_id">
                <input type="hidden" name="app_juntador_id" id="app_juntador_id" value="">
                <img src="/img/tracking.png" width="80" data-id="2" data-app="app_tracking_id">
                <input type="hidden" name="app_tracking_id" id="app_tracking_id" value="">
            </div>
        </div>
        
        <div class="alert-middle alert alert-success alert-dismissable" id="accesosroles_success" style="display:none;">
            <button type="button" class="close" aria-hidden="true">&times;</button>
            <p>Rol guardado</p>
        </div>
        <div class="alert-middle alert alert-danger alert-dismissable" id="accesosroles_delsuccess" style="display:none;">
            <button type="button" class="close" aria-hidden="true">&times;</button>
            <p>Rol eliminado</p>
        </div>
        
        <div class="buttonContainer">
            <button type="button" class="btn btn-default" id="accesosroles_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
            <button type="button" class="btn btn-default" id="accesosroles_btn_clean">
                <span class="glyphicon glyphicon-retweet"></span> Limpiar
            </button>
            <button type="button" class="btn btn-default" id="accesosroles_btn_del" disabled="true">
                <span class="glyphicon glyphicon-remove"></span> Eliminar
            </button>
        </div>
    </form>
</div>
<!-- accesosroles -->
