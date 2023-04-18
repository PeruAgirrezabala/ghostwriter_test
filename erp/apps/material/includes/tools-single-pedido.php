<!-- filtros proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="edit_pedido" title="Editar Pedido"><img src="/erp/img/edit.png" height="30"></button>
    <button class="button" id="print_pedido" title="Imprimir Pedido"><img src="/erp/img/print.png" height="30"></button>
    <button class="button" id="print_recibido" title="Imprimir Etiqueta Material recibido"><img src="/erp/img/etiqueta.png" height="30"></button>
    <button class="button" id="gen_albaran" title="Generar Albarán para Cliente"><img src="/erp/img/albaran.png" height="30"></button>
    <button class="button" id="delete_pedido" title="Eliminar Pedido"><img src="/erp/img/bin.png" height="30"></button>
    <button class="button" id="duplicar_pedido" title="Duplicar Pedido"><img src="/erp/img/duplicar.png" height="30"></button>
    <button class="button" id="recibir_pedido" title="Recibir Pedido"><img src="/erp/img/recibido.png" height="30"></button>
    <input type="hidden" id="to_albaran">
</div>

<div id="pedido_duplicar_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DUPLICAR PEDIDO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_duplicar_pedido" name="frm_duplicar_pedido">
                        <input type="hidden" name="duplicar_pedido_id" id="duplicar_pedido_id" value="<? echo $_GET['id']; ?>">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">PEDIDO CLIENTE:</label>
                                <input type="text" class="form-control" id="newduplicado_pedidocliente" name="newduplicado_pedidocliente">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">OFERTA PROVEEDOR:</label>
                                <input type="text" class="form-control" id="newduplicado_oferta_prov" name="newduplicado_oferta_prov">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">TÍTULO: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newduplicado_titulo" name="newduplicado_titulo">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">DESCRIPCIÓN:</label>
                            <textarea class="form-control" id="newduplicado_desc" name="newduplicado_desc" placeholder="Descripción del Pedido" rows="5"></textarea>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newduplicado_clientes" class="labelBefore">CLIENTE: <span class="requerido">*</span></label>
                                <select id="newduplicado_clientes" name="newduplicado_clientes" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">PROYECTO:</label>
                                <!-- <input type="text" class="form-control" id="proyectomaterial_dtoprov" name="proyectomaterial_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                                <select id="duplicar_pedido_proyectos" name="duplicar_pedido_proyectos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="newduplicado_fecha" name="newduplicado_fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="newduplicado_fechaentrega" name="newduplicado_fechaentrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--
                            <br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_duplicarpedido_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- filtros proyectos -->
<!-- Borrar Pedido -->
<div id="delete_pedido_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas eliminar el pedido?</label>
                    </div>
                    <div class="form-group"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_pedido" data-id="" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>