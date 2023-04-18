<!-- tools proveedores -->
<div class="form-group form-group-tools">
    <button class="button" id="add-proveedor" title="Añadir Proveedor"><img src="/erp/img/add.png" height="20"></button>
</div>

<!-- tools proveedores -->
<!-- PROVEEDORES -->

<div id="addproveedor_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PROVEEDORES</h4>
                
            </div>
            <div class="modal-body">
                <div id="dash-documentos-add" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTOS 
                        <? include($pathraiz."/apps/empresas/includes/tools-documentos-prov.php"); ?>
                    </h4>
                    <div id="treeview_json">
                        <? //include($pathraiz."/apps/material/vistas/pedido-documentos.php"); ?>
                    </div>
                </div>
                <div class="contenedor-form">
                    <form method="post" id="frm_new_proveedor">
                        <input type="hidden" name="newproveedor_idproveedor" id="newproveedor_idproveedor">
                        <input type="hidden" name="proveedor_del" id="proveedor_del">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newproveedor_nombre" name="newproveedor_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">CIF:</label>
                            <input type="text" class="form-control" id="newproveedor_CIF" name="newproveedor_CIF">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección:</label>
                            <input type="text" class="form-control" id="newproveedor_direccion" name="newproveedor_direccion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Población:</label>
                            <input type="text" class="form-control" id="newproveedor_poblacion" name="newproveedor_poblacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Provincia:</label>
                            <input type="text" class="form-control" id="newproveedor_provincia" name="newproveedor_provincia">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">CP:</label>
                            <input type="text" class="form-control" id="newproveedor_cp" name="newproveedor_cp">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">País:</label>
                            <input type="text" class="form-control" id="newproveedor_pais" name="newproveedor_pais">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Teléfono:</label>
                            <input type="text" class="form-control" id="newproveedor_telefono" name="newproveedor_telefono">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Email:</label>
                            <input type="text" class="form-control" id="newproveedor_email" name="newproveedor_email">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Contacto:</label>
                            <input type="text" class="form-control" id="newproveedor_contacto" name="newproveedor_contacto">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Email Pedidos:</label>
                            <input type="text" class="form-control" id="newproveedor_email_pedidos" name="newproveedor_email_pedidos">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Web:</label>
                            <input type="text" class="form-control" id="newproveedor_web" name="newproveedor_web">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Forma Pago:</label>
                            <input type="text" class="form-control" id="newproveedor_formapago" name="newproveedor_formapago">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">URL PLATAFORMA:</label>
                            <input type="text" class="form-control" id="newproveedor_urlPLAT" name="newproveedor_urlPLAT">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">PLATAFORMA USER:</label>
                                <input type="text" class="form-control" id="newproveedor_urlPLAT_U" name="newproveedor_urlPLAT_U">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore">PLATAFORMA PASSWORD:</label>
                                <input type="text" class="form-control" id="newproveedor_urlPLAT_P" name="newproveedor_urlPLAT_P">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Descuento:</label>
                                <input type="text" class="form-control" id="newproveedor_dto" name="newproveedor_dto" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore"></label>
                                <button type="button" class="btn btn-info2" id="btn_descuentos" data-row-id="0">
                                    Tabla de Descuentos
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Homologado:</label>
                                <input type="checkbox" name="newproveedor_chkhomo" id="newproveedor_chkhomo" checked data-size="mini">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Aprobación:</label>
                                <input type="date" class="form-control" id="newproveedor_fecha_aprobación" name="newproveedor_fecha_aprobación" value="0">
                            </div>
                        </div>
                        
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Observaciones:</label>
                            <textarea class="form-control" id="newproveedor_desc" name="newproveedor_desc" placeholder="Descripción" rows="5"></textarea>
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newproveedor_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Proveedor guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_proveedor" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_proveedor" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div id="contacts_modal" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">Contactos</h4>
            </div>
            <div id="contact-content">
                <div id="add-contact">
                    <div style="margin:3%;width:95%;padding:0.5%;">
                    <button id="show-more-add-contact"><span class="glyphicon glyphicon-plus-sign"></span></button>
                    <button id="show-less-add-contact"><span class="glyphicon glyphicon-minus-sign"></span></button>
                    </div>
                    <div id="add_contact_form" style="display:none; margin: 3%;">
                        <form action="post" id="new-contact" >
                            <div class="form-group">
                                <label class="labelBefore">Nombre:</label>
                                <input type="text" class="form-control" id="newcontacto_nombre" name="newcontacto_nombre">
                            </div>
                            <div class="form-group">
                                <label class="labelBefore">Cargo:</label>
                                <input type="text" class="form-control" id="newcontacto_cargo" name="newcontacto_cargo">
                            </div>
                            <div class="form-group">
                                <label class="labelBefore">Mail:</label>
                                <input type="text" class="form-control" id="newcontacto_mail" name="newcontacto_mail">
                            </div>
                            <div class="form-group">
                                <label class="labelBefore">Teléfono:</label>
                                <input type="text" class="form-control" id="newcliente_telefono" name="newcliente_telefono">
                            </div>
                            <div class="form-group">
                                <label class="labelBefore">Descripcion:</label>
                                <input type="text" class="form-control" id="newcontacto_descripcion" name="newcontacto_descripcion">
                            </div>
                        </form>
                        <div style="width:95%;padding:0.5%;">
                        <button type="button" id="btn_save_contacto" class="btn btn-info" style="text-align: left;">Guardar</button>
                        <button type="button" id="btn_del_contacto" class="btn btn-primary" style="text-align: center;">Eliminar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="text-align: right;">Cancelar</button>
                        </div>
                    </div>
                </div>
                <table style="width: 95%; border: black 2px solid; height: fit-content; margin: 3%;">
                    <thead style="background-color:#b0b7c2">
                        <td style="border: 1px solid black; text-align: center;"><b style="color:black;">Id</b></td>
                        <td style="border: 1px solid black; text-align: center;"><b style="color:black;">Nombre</b></td>
                        <td style="border: 1px solid black; text-align: center;"><b style="color:black;">Cargo</b></td>
                        <td style="border: 1px solid black; text-align: center;"><b style="color:black;">Mail</b></td>
                        <td style="border: 1px solid black; text-align: center;"><b style="color:black;">Telefono</b></td>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de descuentos -->
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
                <button type="button" class="btn btn-info2" id="command-add-dto" data-row-id="0" disabled="true">
                    <span class="glyphicon glyphicon-plus"></span> Nuevo  Descuento
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Tabla de descuentos -->
<!-- Edit Descuento -->
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
                <button type="button" class="btn btn-info" id="btn_edit_dto">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Descuento -->
<!-- New Descuento -->
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
                <button type="button" class="btn btn-info" id="btn_new_dto">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
<!-- Confirmar borrado -->
<div id="confirm_delete_proveedor" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">eliminar PROVEEDOR</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idprovedor_del" id="idprovedor_del">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore text-center">Esta Opción eliminará el proveedor y toda la información correspondiente.</label>
                        <label class="labelBefore text-center">¿Estas seguro de que lo quieres eliminar?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="delete_proveedor" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>