<!-- AUDITORES -->

<!-- Tabla de auditores -->
<table id="auditores_grid" class="table table-condensed table-hover table-striped" cellspacing="0" data-toggle="bootgrid">
    <thead>
        <tr>
            <th data-column-id="auditor" data-type="numeric" data-identifier="true">Id</th>
            <th data-column-id="nombre">Nombre</th>
            <th data-column-id="direccion">Dirección</th>
            <th data-column-id="poblacion">Población</th>
            <th data-column-id="provincia">Provincia</th>
            <th data-column-id="cp">CP</th>
            <th data-column-id="pais">País</th>
            <th data-column-id="telefono">Teléfono</th>
            <th data-column-id="descripcion">Descripción</th>
            <th data-column-id="email">Email</th>
            <th data-column-id="fax">Fax</th>
            <th data-column-id="contacto">Contactos</th>
            <th data-column-id="web">Web</th>
            <th data-column-id="cif">CIF</th>
            <th data-column-id="plataforma">Plataforma</th>
            <th data-column-id="usuario">Usuario</th>
            <th data-column-id="password">Password</th>
            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
        </tr>
    </thead>
</table>
<!-- Tabla de auditores -->

<!-- AUDITORES -->

<div id="addauditor_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AUDITORES</h4>
                
            </div>
            <div class="modal-body">
                <div id="dash-documentos-add" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTOS 
                        <? include($pathraiz."/apps/empresas/includes/tools-documentos-audit.php"); ?>
                    </h4>
                    <div id="treeview_json">
                        <? //include($pathraiz."/apps/material/vistas/pedido-documentos.php"); ?>
                    </div>
                </div>
                <div class="contenedor-form">
                    <form method="post" id="frm_new_auditor">
                        <input type="hidden" name="newauditor_idauditor" id="newauditor_idauditor">
                        <input type="hidden" name="auditor_del" id="auditor_del">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newauditor_nombre" name="newauditor_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">CIF:</label>
                            <input type="text" class="form-control" id="newauditor_CIF" name="newauditor_CIF">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección:</label>
                            <input type="text" class="form-control" id="newauditor_direccion" name="newauditor_direccion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Población:</label>
                            <input type="text" class="form-control" id="newauditor_poblacion" name="newauditor_poblacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Provincia:</label>
                            <input type="text" class="form-control" id="newauditor_provincia" name="newauditor_provincia">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">CP:</label>
                            <input type="text" class="form-control" id="newauditor_cp" name="newauditor_cp">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">País:</label>
                            <input type="text" class="form-control" id="newauditor_pais" name="newauditor_pais">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Teléfono:</label>
                            <input type="text" class="form-control" id="newauditor_telefono" name="newauditor_telefono">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Email:</label>
                            <input type="text" class="form-control" id="newauditor_email" name="newauditor_email">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Fax:</label>
                            <input type="text" class="form-control" id="newauditor_fax" name="newauditor_fax">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Contacto:</label>
                            <input type="text" class="form-control" id="newauditor_contacto" name="newauditor_contacto">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Web:</label>
                            <input type="text" class="form-control" id="newauditor_web" name="newauditor_web">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">URL PLATAFORMA:</label>
                            <input type="text" class="form-control" id="newauditor_urlPLAT" name="newauditor_urlPLAT">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">PLATAFORMA USER:</label>
                                <input type="text" class="form-control" id="newauditor_urlPLAT_U" name="newauditor_urlPLAT_U">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore">PLATAFORMA PASSWORD:</label>
                                <input type="text" class="form-control" id="newauditor_urlPLAT_P" name="newauditor_urlPLAT_P">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Aprobación:</label>
                                <input type="date" class="form-control" id="newauditor_fecha_aprobación" name="newauditor_fecha_aprobación" value="">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Observaciones:</label>
                            <textarea class="form-control" id="newauditor_desc" name="newauditor_desc" placeholder="Descripción" rows="5"></textarea>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newauditor_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Auditor guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_auditor" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_auditor" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de descuentos
<div id="dto_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">TABLA DE DESCUENTOS</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="dto_grid" class="table table-condensed table-hover table-striped" cellspacing="0" data-toggle="bootgrid">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric" data-identifier="true">Id</th>
                            <th data-column-id="fecha_val">Fecha Validez</th>
                            <th data-column-id="dto_prov">Dto</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="command-add-dto" data-row-id="0" disabled="true">
                    <span class="glyphicon glyphicon-plus"></span> Nuevo  Descuento
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Tabla de descuentos -->
<!-- Edit Descuento
<div id="edit_dto_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">EDITAR DESCUENTO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit_dto" name="frm_edit_dto">
                    <input type="hidden" value="edit" name="action" id="action">
                    <input type="hidden" value="0" name="edit_dto_id" id="edit_dto_id">
                    <div class="form-group">
                        <label class="labelBefore white">Fecha Validez:</label>
                        <input type="date" class="form-control" id="dtoedit_fechaval" name="dtoedit_fechaval">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Dto (%):</label>
                        <input type="text" class="form-control" id="dtoedit_dto" name="dtoedit_dto">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-primary" id="btn_edit_dto">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Descuento -->
<!-- New Descuento
<div id="add_dto_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog dialog_estrecho" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="display: inline-block;">NUEVO DESCUENTO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form method="post" id="frm_add_dto" name="frm_add_dto">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="" name="newdto_proveedorid" id="newdto_proveedorid">
                    <div class="form-group">
                        <label class="labelBefore white">Fecha Validez:</label>
                        <input type="date" class="form-control" id="newdto_fechaval" name="newdto_fechaval">
                    </div>
                    <div class="form-group">
                        <label class="labelBefore white">Dto (%):</label>
                        <input type="text" class="form-control" id="newdto_dto" name="newdto_dto">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #ffffff !important;">
                <button type="button" class="btn btn-primary" id="btn_new_dto">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- New Descuento -->
<!-- confirm del doc -->
<div id="confirm_del_doc_modal" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" name="del_doc_id" id="del_doc_id" value="">
                    <p>¿Estas seguro de que quieres eliminar este documento?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-del-doc" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>