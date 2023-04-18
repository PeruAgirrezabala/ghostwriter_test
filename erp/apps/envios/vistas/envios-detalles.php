<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['id'])) {    
    $sql = "SELECT 
                    ENVIOS_CLI.id,
                    ENVIOS_CLI.ref,
                    ENVIOS_CLI.nombre,
                    ENVIOS_CLI.descripcion,
                    ENVIOS_CLI.cliente_id,
                    ENVIOS_CLI.fecha,
                    ENVIOS_CLI.fecha_entrega,
                    ENVIOS_CLI.tecnico_id,
                    ENVIOS_CLI.proyecto_id,
                    ENVIOS_CLI.estado_id 
                FROM 
                    ENVIOS_CLI 
                WHERE 
                    id = ".$_GET["id"];
    
    $res = mysqli_query($connString, $sql) or die("database error:");
    $registros = mysqli_fetch_row($res);
            
    $sql = "SELECT 
                ENVIOS_CLI_DETALLES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                ENVIOS_CLI_DETALLES.unidades,
                ENVIOS_CLI_DETALLES.entregado,
                ENVIOS_CLI_DETALLES.fecha_recepcion,
                PROYECTOS.nombre,
                ENTREGAS.nombre,
                MATERIALES.id,
                ' ' as 'S/N',
                ENVIOS_CLI_DETALLES.garantia,
		PEDIDOS_PROV_DETALLES.recibido
            FROM 
                ENVIOS_CLI_DETALLES
            INNER JOIN MATERIALES
                ON ENVIOS_CLI_DETALLES.material_id = MATERIALES.id 
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = ENVIOS_CLI_DETALLES.proyecto_id 
            LEFT JOIN ENTREGAS
                ON ENVIOS_CLI_DETALLES.entrega_id = ENTREGAS.id
            INNER JOIN PEDIDOS_PROV_DETALLES
		ON ENVIOS_CLI_DETALLES.pedido_detalle_id=PEDIDOS_PROV_DETALLES.id
            WHERE
                ENVIOS_CLI_DETALLES.envio_id = ".$registros[0];

    file_put_contents("array.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-detalles-pedidos'>
                <thead>
                  <tr>
                    <th class='text-center'>A</th>
                    <th>REF</th>
                    <th>S/N</th>
                    <th>MATERIAL</th>
                    <th>FABRICANTE</th>
                    <th>UNIDADES</th>
                    <th>GARANTIA</th>
                    <th>ENTREGADO</th>
                    <th>FECHA RECEPCION</th>
                    <th>ENTREGA</th>
                    <th>PROYECTO</th>
                    <th class='text-center'>R</th>
                    <th class='text-center'>E</th>
                  </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        if ($row[6] == 0) {
            $recibidoDet = "NO";
        }
        else {
            $recibidoDet = "SI";
        }
        
        if ($recibidoDet == "SI") {
            $disableButton = " disabled ";
            $estilo = '';
            if($row[12]==2){ // Devolucion
                $estilo = 'style="background-color: #ffce89;"';
            }elseif($row[12]==3){ // Envio
                $estilo = 'style="background-color: #70a561;"';
            }           
        }
        else {
            $disableButton = " ";
            $estilo= '';
        }
        //$disableButton = " disabled "; // Por el momento deshabilitado....
        if ($row[11] == 0) {
            $garantia = "NO";
        }
        else {
            $garantia = "SI";
        }
        
        $html .= "
                <tr data-id='".$row[0]."' ".$estilo.">
                    <td class='text-center'><input type='checkbox' class='to-alb' data-matid='".$row[18]."' disabled></td>
                    <td>".$row[1]."</td>
                    <td>".$row[10]."</td>
                    <td>".$row[2]."</td>
                    <td>".$row[3]."</td>
                    <td class='text-center'>".$row[4]."</td>
                    <td>".$garantia."</td>
                    <td>".$recibidoDet."</td>
                    <td>".$row[6]."</td>
                    <td>".$row[8]."</td>
                    <td>".$row[7]."</td>
                    <td class='text-center'><button class='btn-default entregar-mat' data-id='".$row[0]."' title='Entregado' ".$disableButton."><img src='/erp/img/recibido.png' style='height: 20px;'></button></td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-detalle' data-id='".$row[0]."' title='Eliminar detalle' ><img src='/erp/img/cross.png'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    echo $html;
} //if isset btn_login

?>

<div id="detalleenvio_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_enviodetalle">
                        <input type="hidden" value="" name="enviodetalle_detalle_id" id="enviodetalle_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="enviodetalle_envio_id" id="enviodetalle_envio_id">
                        <input type="hidden" value="" name="enviodetalle_material_id" id="enviodetalle_material_id">
                        <input type="hidden" value="" name="tipo_envio_id" id="tipo_envio_id">
                        <input type="hidden" value="" name="pedido_detalle_id" id="pedido_detalle_id">
                        <!--
                        <div class="form-group">
                            <label class="labelBeforeBlack">Numeros de Serie:</label>
                            <select id="enviodetalle_sn" name="enviodetalle_sn" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div> 
                        
                        <div class="form-group">
                            <label class="labelBeforeBlack">Categorías: <span class="requerido">*</span></label>
                            <select id="enviodetalle_categorias1" name="enviodetalle_categorias1" class="selectpicker enviodetalle_categorias" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        -->
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="enviodetalle_mat_proce" class="labelBefore">Material procedencia: <span class="requerido">*</span></label>
                                <select id="enviodetalle_mat_proce" name="enviodetalle_mat_proce" class="selectpicker" data-live-search="true">
                                    <option></option>
                                    <option value="1">Asignado a Proyecto</option>
                                    <option value="2">Almacen / Oficina</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group" id="enviodetalle_proyectos_div">
                            <div class="col-xs-6">
                                <label for="enviodetalle_proyectos" class="labelBefore">Proyecto: <span class="requerido">*</span></label>
                                <select id="enviodetalle_proyectos" name="enviodetalle_proyectos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Buscar: </label>
                                <input type="search" class="form-control" id="enviodetalle_criterio" name="enviodetalle_criterio" placeholder="Introduce un criterio para buscar">
                            </div>
                            <!--
                            <div class="col-xs-3">
                                <label class="labelBeforeBlack" style="color: #ffffff;">ooooooooooo</label>
                                <button type="button" id="btn_pedidodetalle_find" class="btn btn-primary">Buscar</button>
                            </div>
                            -->
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales: <span class="requerido">*</span></label>
                            <select id="enviodetalle_materiales" name="enviodetalle_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="enviodetalle_nombre" name="enviodetalle_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Modelo:</label>
                            <input type="text" class="form-control" id="enviodetalle_modelo" name="enviodetalle_modelo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fabricante:</label>
                            <input type="text" class="form-control" id="enviodetalle_fabricante" name="enviodetalle_fabricante" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">S/N:</label>
                            <input type="text" class="form-control" id="enviodetalle_numserie" name="enviodetalle_numserie" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="enviodetalle_descripcion" name="enviodetalle_descripcion" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Detalle Libre:</label>
                            <input type="text" class="form-control" id="enviodetalle_articulo" name="enviodetalle_articulo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">REF Proveedor:</label>
                            <input type="text" class="form-control" id="enviodetalle_ref" name="enviodetalle_ref">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Stock:</label>
                                <input type="text" class="form-control" id="enviodetalle_stock" name="enviodetalle_stock" disabled="true">
                            </div>
                        </div><!--
                        <div class="form-group" id="enviodetalle_cantidad_div">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad: <span class="requerido">*</span></label>
                                <!--<input type="text" class="form-control" id="enviodetalle_cantidad" name="enviodetalle_cantidad" value="0">-->
                                <!--<select id="enviodetalle_cantidad" name="enviodetalle_cantidad" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                        </div>-->
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Garantia:</label>
                                <input type="checkbox" name="edit_chkgarantia" id="edit_chkgarantia" checked data-size="mini">
                            </div>
                        </div>
                        <!--<div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Recibido:</label>
                                <input type="checkbox" name="edit_chkrecibido" id="edit_chkrecibido" checked data-size="mini">
                            </div>
                        </div>-->
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha Recepción:</label>
                                <input type="datetime-local" class="form-control" id="enviodetalle_fecha_recepcion" name="enviodetalle_fecha_recepcion" value="0">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="enviodetalle_proyectos" class="labelBefore">Entrega: </label>
                                <select id="enviodetalle_entregas" name="enviodetalle_entregas" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción/Notas del envio:</label>
                            <textarea type="text" class="form-control" id="enviodetalle_descnota" name="enviodetalle_descnota" rows="5"></textarea>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_enviodetalle_save" class="btn btn-info">Guardar</button>
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
