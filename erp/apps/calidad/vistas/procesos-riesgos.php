<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['id'])) {    
    $sql = "SELECT 
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.ref,
                    PEDIDOS_PROV.titulo,
                    PEDIDOS_PROV.descripcion,
                    PEDIDOS_PROV.proveedor_id,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    PEDIDOS_PROV.tecnico_id,
                    PEDIDOS_PROV.proyecto_id,
                    PEDIDOS_PROV.estado_id, 
                    PEDIDOS_PROV.total 
                FROM 
                    PEDIDOS_PROV 
                WHERE 
                    id = ".$_GET["id"];
    
    $res = mysqli_query($connString, $sql) or die("database error:");
    $registros = mysqli_fetch_row($res);
            
    $sql = "SELECT 
                PEDIDOS_PROV_DETALLES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                PEDIDOS_PROV_DETALLES.unidades,
                MATERIALES_PRECIOS.pvp, 
                PEDIDOS_PROV_DETALLES.recibido,
                PEDIDOS_PROV_DETALLES.fecha_recepcion,
                PROYECTOS.nombre,
                PEDIDOS_PROV_DETALLES.pvp,
                MATERIALES_PRECIOS.dto_material, 
                PEDIDOS_PROV_DETALLES.dto_prov_activo, 
                PEDIDOS_PROV_DETALLES.dto_mat_activo, 
                PEDIDOS_PROV_DETALLES.dto_ad_activo, 
                PROVEEDORES_DTO.dto_prov, 
                PEDIDOS_PROV_DETALLES.dto, 
                ENTREGAS.nombre,
                erp_users.nombre, 
                MATERIALES.id,
                PEDIDOS_PROV_DETALLES.dto_ad_prior,
                PEDIDOS_PROV_DETALLES.iva_id,
                IVAS.nombre,
                PEDIDOS_PROV_DETALLES.detalle_libre,
                PEDIDOS_PROV_DETALLES.ref 
            FROM 
                PEDIDOS_PROV_DETALLES
            LEFT JOIN MATERIALES
                ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
            INNER JOIN IVAS
                ON IVAS.id = PEDIDOS_PROV_DETALLES.iva_id 
            LEFT JOIN MATERIALES_PRECIOS 
                ON MATERIALES_PRECIOS.id = PEDIDOS_PROV_DETALLES.material_tarifa_id 
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = PEDIDOS_PROV_DETALLES.proyecto_id 
            LEFT JOIN PROVEEDORES_DTO 
                ON PROVEEDORES_DTO.id = PEDIDOS_PROV_DETALLES.dto_prov_id
            LEFT JOIN ENTREGAS
                ON PEDIDOS_PROV_DETALLES.entrega_id = ENTREGAS.id
            LEFT JOIN erp_users 
                ON PEDIDOS_PROV_DETALLES.erp_userid = erp_users.id 
            WHERE
                PEDIDOS_PROV_DETALLES.pedido_id = ".$registros[0]." 
            ORDER BY 
                PEDIDOS_PROV_DETALLES.id ASC";

    file_put_contents("array.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-detalles-pedidos'>
                <thead>
                  <tr>
                    <th class='text-center'>A</th>
                    <th>REF</th>
                    <th>MATERIAL</th>
                    <th>FABRICANTE</th>
                    <th>UNID.</th>
                    <th>PVP</th>
                    <th>DTO %</th>
                    <th>IMPORTE</th>
                    <th>IVA %</th>
                    <th>RECIBIDO</th>
                    <th>FECHA RECEPCION</th>
                    <th>ENTREGA</th>
                    <th>PROYECTO</th>
                    <th class='text-center'>R</th>
                    <th class='text-center'>E</th>
                  </tr>
                </thead>
                <tbody>";
    
    $iva = 0;
    while( $row = mysqli_fetch_array($res) ) {
        if ($row[5] != "") {
            $pvp = $row[5];
        }
        else {
            $pvp = $row[9];
        }
        
        $dto_sum = 0;
        $pvp_dto = 0;
        if ($row[11] == 1) {
            $dto_sum  = $dto_sum + $row[14];
        }
        if ($row[12] == 1) {
            $dto_sum  = $dto_sum + $row[10];
        }
        if ($row[13] == 1) {
            if ($row[19] == 1) {
                $dto_extra = $row[15];
            }
            else {
                $dto_sum  = $dto_sum + $row[15];
                $dto_extra = "";
            }
        }       
        
        $ivaPercent = $row[21];
        $subtotal = ($pvp*$row[4]);
        $dto = ($subtotal*$dto_sum)/100;
        $subtotalDtoApli = $subtotal-$dto;
        if ($row[19] == 1) {
            $dtoNeto = ($subtotalDtoApli*$dto_extra)/100;
            $subtotalDtoApli = $subtotalDtoApli-$dtoNeto;
            $dto_extra =  " + ".number_format($dto_extra, 2);
        }
        else {
            $dtoNeto = 0;
        }
        
        if ($row[6] == 0) {
            $recibidoDet = "NO";
        }
        else {
            $recibidoDet = "SI";
        }
        
        if ($recibidoDet == "SI") {
            $disableButton = " disabled ";
        }
        else {
            $disableButton = " ";
        }
        
        if ($row[2] != "") {
            $material = $row[2];
        }
        else {
            $material = $row[22];
        }
        
        if ($row[1] != "") {
            $ref = $row[1];
        }
        else {
            $ref = $row[23];
        }
        
        $html .= "
                <tr data-id='".$row[0]."'>
                    <td class='text-center'><input type='checkbox' class='to-alb' data-matid='".$row[18]."'></td>
                    <td>".$ref."</td>
                    <td>".$material."</td>
                    <td>".$row[3]."</td>
                    <td class='text-center'>".$row[4]."</td>
                    <td class='text-right'>".$pvp."</td>
                    <td class='text-right'>".number_format($dto_sum, 2).$dto_extra."</td>
                    <td class='text-right'>".number_format($subtotalDtoApli, 2)."</td>
                    <td class='text-right'>".$ivaPercent."</td>
                    <td>".$recibidoDet."</td>
                    <td>".$row[7]."</td>
                    <td>".$row[16]."</td>
                    <td>".$row[8]."</td>
                    <td class='text-center'><button class='btn-default recibir-mat' data-id='".$row[0]."' title='Recibido' ".$disableButton."><img src='/erp/img/recibido.png' style='height: 20px;'></button></td>
                    <td class='text-center'><button class='btn-default remove-detalle' data-id='".$row[0]."' title='Eliminar detalle'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>";
        $importe = $importe+$subtotal;
        $totaldto = $totaldto + $dto + $dtoNeto;
        $iva = $iva + (($subtotal-($dto + $dtoNeto))*$ivaPercent/100);
    }
    $html .= "      </tbody>
                </table>";
    
    //$iva = (($importe-$totaldto)*21)/100;
    $totalPVP = ($importe-$totaldto);
    $total = ($importe-$totaldto) + $iva;
    
    echo $html;
} //if isset btn_login

?>

<div class="row pvp_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-2"><label class='viewTitle resumen-title-vistas'>IMPORTE: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format($importe, 2); ?> €</label> </div>
    <div class="col-sm-2"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format($totaldto, 2); ?> €</label> </div>
    <div class="col-sm-2"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format($totalPVP, 2); ?> €</label> </div>
    <div class="col-sm-2"><label class='viewTitle resumen-title-vistas'>IVA: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format($iva, 2); ?> €</label></div>
    <div class="col-sm-2" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format($total, 2); ?> €</label></div>
</div>

<div id="detallepedido_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_pedidodetalle">
                        <input type="hidden" value="" name="pedidodetalle_detalle_id" id="pedidodetalle_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="pedidodetalle_pedido_id" id="pedidodetalle_pedido_id">
                        <input type="hidden" value="" name="pedidodetalle_material_id" id="pedidodetalle_material_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Categorías:</label>
                            <select id="pedidodetalle_categorias1" name="pedidodetalle_categorias1" class="selectpicker pedidodetalle_categorias" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Buscar:</label>
                                <input type="search" class="form-control" id="pedidodetalle_criterio" name="pedidodetalle_criterio" placeholder="Introduce un criterio para buscar">
                            </div>
                            <!--
                            <div class="col-xs-3">
                                <label class="labelBeforeBlack" style="color: #ffffff;">ooooooooooo</label>
                                <button type="button" id="btn_pedidodetalle_find" class="btn btn-primary">Buscar</button>
                            </div>
                            -->
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales:</label>
                            <select id="pedidodetalle_materiales" name="pedidodetalle_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="pedidodetalle_nombre" name="pedidodetalle_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Modelo:</label>
                            <input type="text" class="form-control" id="pedidodetalle_modelo" name="pedidodetalle_modelo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fabricante:</label>
                            <input type="text" class="form-control" id="pedidodetalle_fabricante" name="pedidodetalle_fabricante" disabled="true">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Detalle Libre:</label>
                            <textarea class="form-control" id="pedidodetalle_libre" name="pedidodetalle_libre" placeholder="Detalle libre" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">REF Proveedor:</label>
                            <input type="text" class="form-control" id="pedidodetalle_ref" name="pedidodetalle_ref">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Stock:</label>
                                <input type="text" class="form-control" id="pedidodetalle_stock" name="pedidodetalle_stock" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBeforeBlack">Tarifas del Proveedor:</label>
                                <select id="pedidodetalle_precios" name="pedidodetalle_precios" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Tarifa seleccionada:</label>
                                <input type="text" class="form-control" id="pedidodetalle_preciomat" name="pedidodetalle_preciomat">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="pedidodetalle_cantidad" name="pedidodetalle_cantidad" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3" style="margin-bottom: 15px;">
                                <label class="labelBeforeBlack">IVA:</label>
                                <select id="pedidodetalle_ivas" name="pedidodetalle_ivas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack"><strong>DESCUENTOS</strong></label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuentos Proveedor (%):</label>
                                <!-- <input type="text" class="form-control" id="pedidodetalle_dtoprov" name="pedidodetalle_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                                <select id="pedidodetalle_dtoprov" name="pedidodetalle_dtoprov" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dtoprov_desc" name="pedidodetalle_dtoprov_desc">
                                    <label class="form-check-label" for="pedidodetalle_dtoprov_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Material (%):</label>
                                <input type="text" class="form-control" id="pedidodetalle_dtomat" name="pedidodetalle_dtomat" disabled="true" data-descartar="0">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dtomat_desc" name="pedidodetalle_dtomat_desc">
                                    <label class="form-check-label" for="pedidodetalle_dtomat_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Adicional (%):</label>
                                <input type="text" class="form-control" id="pedidodetalle_dto" name="pedidodetalle_dto" data-descartar="0" value="0.00">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dto_desc" name="pedidodetalle_dto_desc">
                                    <label class="form-check-label" for="pedidodetalle_dto_desc">Aplicar</label>
                                    <input type="checkbox" class="form-check-input" id="pedidodetalle_dto_sobretotal" name="pedidodetalle_dto_sobretotal">
                                    <label class="form-check-label" for="pedidodetalle_dto_sobretotal">Aplicar tras otros descuentos</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;"">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP:</label>
                                <input type="text" class="form-control" id="pedidodetalle_pvp" name="pedidodetalle_pvp" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Total:</label>
                                <input type="text" class="form-control" id="pedidodetalle_totaldto" name="pedidodetalle_totaldto" value="0" disabled="true">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">% Total:</label>
                                <input type="text" class="form-control" id="pedidodetalle_totaldtopercent" name="pedidodetalle_totaldtopercent" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">TOTAL:</label>
                                <input type="text" class="form-control" id="pedidodetalle_pvpdto" name="pedidodetalle_pvpdto" value="0" disabled="true" style="background-color: #0eace7; color: #ffffff !important;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="pedidodetalle_fecha_entrega" name="pedidodetalle_fecha_entrega" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Recibido:</label>
                                <input type="checkbox" name="edit_chkrecibido" id="edit_chkrecibido" checked data-size="mini">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha Recepción:</label>
                                <input type="datetime-local" class="form-control" id="pedidodetalle_fecha_recepcion" name="pedidodetalle_fecha_recepcion" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="pedidodetalle_clientes" class="labelBefore">Cliente: </label>
                                <select id="pedidodetalle_clientes" name="pedidodetalle_clientes" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="pedidodetalle_proyectos" class="labelBefore">Proyecto: </label>
                                <select id="pedidodetalle_proyectos" name="pedidodetalle_proyectos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="pedidodetalle_proyectos" class="labelBefore">Entrega: </label>
                                <select id="pedidodetalle_entregas" name="pedidodetalle_entregas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore" for="pedidodetalle_tecnicos">Técnico:</label>
                                <select id="pedidodetalle_tecnicos" name="pedidodetalle_tecnicos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Observaciones:</label>
                            <textarea class="form-control" id="pedidodetalle_desc" name="pedidodetalle_desc" placeholder="Observaciones" rows="5"></textarea>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_pedidodetalle_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- MATERIALES -->

<div id="selectmaterial_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">MATERIALES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_material">
                        <input type="hidden" name="newmaterial_idmaterial" id="newmaterial_idmaterial">
                        <input type="hidden" name="material_del" id="material_del">
                        <div class="form-group">
                            <label class="labelBefore" style="color: #ffffff;">Material:</label>
                            <select id="materiales_categoria1" name="materiales_categoria1" class="selectpicker materiales_categorias" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales:</label>
                            <select id="newmaterial_materiales" name="newmaterial_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newmaterial_nombre" name="newmaterial_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Fabricante:</label>
                            <input type="text" class="form-control" id="newmaterial_fabricante" name="newmaterial_fabricante" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Modelo:</label>
                            <input type="text" class="form-control" id="newmaterial_modelo" name="newmaterial_modelo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Descuento:</label>
                            <input type="text" class="form-control" id="newmaterial_dto" name="newmaterial_dto" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Stock:</label>
                            <input type="text" class="form-control" id="newmaterial_stock" name="newmaterial_stock" disabled="true">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Unidades:</label>
                                <input type="text" class="form-control" id="unidades" name="unidades">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Plazo:</label>
                                <input type="text" class="form-control" id="plazo" name="plazo">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Último Precio:</label>
                                <input type="text" class="form-control" id="newmaterial_lastprice" name="newmaterial_lastprice" disabled="true">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newmaterial_desc" name="newmaterial_desc" placeholder="Descripción" rows="5" disabled="true"></textarea>
                        </div>
                        
                        <div class="form-group">
                            
                        </div>
                        
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newmaterial_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Material guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_material" class="btn btn-info">Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- /MATERIALES -->
