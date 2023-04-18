<!-- tools clientes -->
<div class="form-group form-group-tools">
    <button class="button" id="add-cliente" title="Añadir Cliente"><img src="/erp/img/add.png" height="20"></button>
</div>
<!-- tools clientes -->
<div id="addcliente_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CLIENTES</h4>
            </div>
            <div class="modal-body">
                <div id="dash-documentos-add" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTOS
                        <? include($pathraiz . "/apps/empresas/includes/tools-documentos-cli.php"); ?>
                    </h4>
                    <div id="treeview_json">
                        <? //include($pathraiz."/apps/material/vistas/pedido-documentos.php"); 
                        ?>
                    </div>
                </div>
                <div class="contenedor-form">
                    <form method="post" id="frm_new_cliente" enctype="multipart/form-data">
                        <input type="hidden" name="newcliente_idcliente" id="newcliente_idcliente">
                        <input type="hidden" name="cliente_del" id="cliente_del">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newcliente_nombre" name="newcliente_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección:</label>
                            <input type="text" class="form-control" id="newcliente_direccion" name="newcliente_direccion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Población:</label>
                            <input type="text" class="form-control" id="newcliente_poblacion" name="newcliente_poblacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Provincia:</label>
                            <input type="text" class="form-control" id="newcliente_provincia" name="newcliente_provincia">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">CP:</label>
                            <input type="text" class="form-control" id="newcliente_cp" name="newcliente_cp">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">País:</label>
                            <input type="text" class="form-control" id="newcliente_pais" name="newcliente_pais">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Teléfono:</label>
                            <input type="text" class="form-control" id="newcliente_telefono" name="newcliente_telefono">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Email:</label>
                            <input type="text" class="form-control" id="newcliente_email" name="newcliente_email">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Web:</label>
                            <input type="text" class="form-control" id="newcliente_web" name="newcliente_web">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">NIF:</label>
                            <input type="text" class="form-control" id="newcliente_nif" name="newcliente_nif">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">CONTACTO:</label>
                            <input type="text" class="form-control" id="newcliente_contacto" name="newcliente_contacto">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">URL PRL:</label>
                            <input type="text" class="form-control" id="newcliente_urlPRL" name="newcliente_urlPRL">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">URL PRL USER:</label>
                                <input type="text" class="form-control" id="newcliente_urlPRL_U" name="newcliente_urlPRL_U">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBefore">URL PRL PASSWORD:</label>
                                <input type="text" class="form-control" id="newcliente_urlPRL_P" name="newcliente_urlPRL_P">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Imagen:</label>
                                <input type="file" class="form-control" id="newcliente_logo" name="newcliente_logo">
                            </div>
                            <div class="col-xs-6">
                                <label for="newcliente_imgprview" class="labelBefore" style="color: #ffffff;">oo </label>
                                <img src="" style="display: none; height: 100px !important;" id="newcliente_imgprview">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Instalaciones:</label>
                            <button type="button" class="btn btn-default" title="Ver instalaciones" id="btn-ver-instalaciones"><img src="/erp/img/ojo.png" style="height: 15px;"></button>
                        </div>

                        <div id="cliente_instalaciones" style="display:none">
                            <!-- -->
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newcliente_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Cliente guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_cliente" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_cliente" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
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

<!-- Confirmar borrado -->
<div id="confirm_delete_cliente" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ELIMINAR CLIENTE</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idcliente_del" id="idcliente_del">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore text-center">Esta Opción eliminará el cliente y toda la información correspondiente.</label>
                        <label class="labelBefore text-center">¿Estas seguro de que lo quieres eliminar?</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="del_cliente" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>