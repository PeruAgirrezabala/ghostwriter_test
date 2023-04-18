<!-- FORMAS PAGO -->

<!-- Tabla de proveedores -->
<table id="formaspago_grid" class="table table-condensed table-hover table-striped" cellspacing="0" data-toggle="bootgrid">
    <thead>
        <tr>
            <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
            <th data-column-id="nombre">Nombre</th>
            <th data-column-id="datos">Datos</th>
            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
        </tr>
    </thead>
</table>
<!-- Tabla de proveedores -->

<!-- FORMAS PAGO -->

<div id="addformapago_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">FORMAS DE PAGO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_formapago">
                        <input type="hidden" name="newformapago_idforma" id="newformapago_idforma">
                        <input type="hidden" name="formapago_del" id="formapago_del">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newformapago_nombre" name="newformapago_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Datos:</label>
                            <input type="text" class="form-control" id="newformapago_datos" name="newformapago_datos">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Observaciones:</label>
                            <textarea class="form-control" id="newformapago_desc" name="newformapago_desc" placeholder="Observaciones" rows="5"></textarea>
                        </div>
                        
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newformapago_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Forma de Pago guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_formapago" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_formapago" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
