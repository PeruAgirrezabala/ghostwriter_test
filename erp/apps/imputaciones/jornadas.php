<!-- jornadas -->
<div id="jornadas">
    <div class="buttonContainer">
        <label style="display: block; margin-bottom: 20px;color: #ffffff;">¿Qué acción deseas realizar?</label>
        <button type="button" class="btn btn-default" id="jornadas_btn_newjornada">
            <span class="glyphicon glyphicon-plus"></span> Nueva Jornada
        </button>
        <button type="button" class="btn btn-default" id="jornadas_btn_editjornada">
            <span class="glyphicon glyphicon-edit"></span> Editar Jornada 
        </button>
    </div>
    
    <form method="post" id="frm_jornadas" style="display: none;">
        <input type="hidden" name="jornadas_deljornada" id="jornadas_deljornada">
        <input type="hidden" name="jornadas_idjornada" id="jornadas_idjornada" value="0">
        <input type="hidden" name="finalizar" id="finalizar">
        <input type="hidden" name="iniciar" id="iniciar">
        <div class="form-group">
            <div class="col-xs-4">
                <div class="selectors" id="select-jornadas-jornadas" style="display: none;">
                    <div class="selectorJornadas">
                        <label class="labelBefore">Jornadas</label>
                        <select id="jornadas_jornadas" name="jornadas_jornadas" class="selectpicker" data-live-search="true" data-width="33%">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <img src="/live/img/live.gif" height="30" style="display: none;" id="live">
        </div>
        
        <div class="form-group">
            <div class="col-xs-4">
                <label class="labelBefore">Nombre:</label>
                <input type="text" class="form-control" id="jornadas_edit_nombre" name="jornadas_edit_nombre" placeholder="Nombre o número de la jornada">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-3">
                <label class="labelBefore">Fecha Inicio:</label>
                <input type="datetime-local" class="form-control" id="start_fecha" name="start_fecha"> 
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-3">
                <label class="labelBefore">Fecha Fin:</label>
                <input type="datetime-local" class="form-control" id="end_fecha" name="end_fecha">
            </div>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-default" id="jornadas_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
            <button type="button" class="btn btn-default" id="jornadas_btn_iniciar">
                <span class="glyphicon glyphicon-open"></span> Iniciar
            </button>
            <button type="button" class="btn btn-default" id="jornadas_btn_finalizar">
                <span class="glyphicon glyphicon-download-alt"></span> Finalizar
            </button>
            <button type="button" class="btn btn-default" id="jornadas_btn_clean">
                <span class="glyphicon glyphicon-erase"></span> Limpiar
            </button>
            <button type="button" class="btn btn-default" id="jornadas_btn_del" disabled="true">
                <span class="glyphicon glyphicon-remove"></span> Eliminar
            </button>
        </div>
        
        <div class="alert-middle alert alert-success alert-dismissable" id="jornadas_success" style="display:none;">
            <button type="button" class="close" aria-hidden="true">&times;</button>
            <p>Jornada guardada</p>
        </div>
        <div class="alert-middle alert alert-danger alert-dismissable" id="jornadas_delsuccess" style="display:none;">
            <button type="button" class="close" aria-hidden="true">&times;</button>
            <p>Jornada eliminada</p>
        </div>
        <div class="alert-middle alert alert-danger alert-dismissable" id="jornadas_error" style="display:none;">
            <button type="button" class="close" aria-hidden="true">&times;</button>
            <p>Por favor, selecciona la jornada que desea editar</p>
        </div>
    </form>
</div>
<!-- jornadas -->
