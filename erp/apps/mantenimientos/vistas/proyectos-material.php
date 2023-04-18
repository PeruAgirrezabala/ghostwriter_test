<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['id'])) {                
    $sql = "SELECT 
                PROYECTOS_MATERIALES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                PROYECTOS_MATERIALES.unidades,
                MATERIALES_PRECIOS.pvp, 
                PROYECTOS.nombre
            FROM 
                PROYECTOS_MATERIALES
            INNER JOIN MATERIALES
                ON PROYECTOS_MATERIALES.material_id = MATERIALES.id 
            INNER JOIN MATERIALES_PRECIOS 
                ON MATERIALES_PRECIOS.material_id = MATERIALES.id
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = PROYECTOS_MATERIALES.proyecto_id  
            WHERE
                PROYECTOS_MATERIALES.proyecto_id = ".$_GET['id']." 
            ORDER BY 
                PROYECTOS_MATERIALES.id ASC";

    //file_put_contents("array.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-detalles-pedidos'>
                <thead>
                  <tr>
                    <th>REF</th>
                    <th>MATERIAL</th>
                    <th>FABRICANTE</th>
                    <th>UNIDADES</th>
                    <th>PVP</th>
                    <th>IMPORTE</th>
                    <th>PROYECTO</th>
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
        $html .= "
                <tr data-id='".$row[0]."'>
                    <td>".$row[1]."</td>
                    <td>".$row[2]."</td>
                    <td>".$row[3]."</td>
                    <td>".$row[4]."</td>
                    <td>".$row[5]."</td>
                        <td>".($row[4]*$row[5])."</td>
                    <td>".$row[6]."</td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    echo $html;
} //if isset btn_login

?>

<div id="material_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_proyectomaterial">
                        <input type="hidden" value="" name="proyectomaterial_detalle_id" id="proyectomaterial_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="proyectomaterial_pedido_id" id="proyectomaterial_pedido_id">
                        <input type="hidden" value="" name="proyectomaterial_material_id" id="proyectomaterial_material_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Categorías:</label>
                            <select id="proyectomaterial_categorias1" name="proyectomaterial_categorias1" class="selectpicker proyectomaterial_categorias" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales:</label>
                            <select id="proyectomaterial_materiales" name="proyectomaterial_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="proyectomaterial_nombre" name="proyectomaterial_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Modelo:</label>
                            <input type="text" class="form-control" id="proyectomaterial_modelo" name="proyectomaterial_modelo" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fabricante:</label>
                            <input type="text" class="form-control" id="proyectomaterial_fabricante" name="proyectomaterial_fabricante" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="proyectomaterial_descripcion" name="proyectomaterial_descripcion" disabled="true">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Stock:</label>
                                <input type="text" class="form-control" id="proyectomaterial_stock" name="proyectomaterial_stock">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="proyectomaterial_cantidad" name="proyectomaterial_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio:</label>
                                <input type="text" class="form-control" id="proyectomaterial_preciomat" name="proyectomaterial_preciomat">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP:</label>
                                <input type="text" class="form-control" id="proyectomaterial_pvp" name="proyectomaterial_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento (%):</label>
                                <input type="text" class="form-control" id="proyectomaterial_dto" name="proyectomaterial_dto" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP - Descuento:</label>
                                <input type="text" class="form-control" id="proyectomaterial_pvpdto" name="proyectomaterial_pvpdto" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_proyectomaterial_save" class="btn btn-info">Guardar</button>
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
