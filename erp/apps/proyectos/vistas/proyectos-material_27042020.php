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
    
    $sql = "SELECT 
                PROYECTOS_MATERIALES.id as idmat,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                PROYECTOS_MATERIALES.unidades,
                MATERIALES_PRECIOS.pvp, 
                PROYECTOS.nombre,
                MATERIALES_PRECIOS.dto_material, 
                PROYECTOS_MATERIALES.dto_prov_activo, 
                PROYECTOS_MATERIALES.dto_mat_activo, 
                PROYECTOS_MATERIALES.dto_ad_activo, 
                PROVEEDORES_DTO.dto_prov, 
                PROYECTOS_MATERIALES.dto, 
                PROYECTOS_MATERIALES.material_id,
                PROYECTOS_MATERIALES.material_tarifa_id,
                (SELECT GROUP_CONCAT(ENVIOS_CLI.ref) FROM ENVIOS_CLI, ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI.id = ENVIOS_CLI_DETALLES.envio_id AND ENVIOS_CLI_DETALLES.material_proyecto_id = idmat) as albREF,
                (SELECT GROUP_CONCAT(CONCAT(ENVIOS_CLI_DETALLES.envio_id,'-', ENVIOS_CLI_DETALLES.unidades)) FROM ENVIOS_CLI, ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI.id = ENVIOS_CLI_DETALLES.envio_id AND ENVIOS_CLI_DETALLES.material_proyecto_id = idmat) as envios
            FROM 
                PROYECTOS_MATERIALES
            INNER JOIN MATERIALES
                ON PROYECTOS_MATERIALES.material_id = MATERIALES.id 
            LEFT JOIN MATERIALES_PRECIOS 
                ON MATERIALES_PRECIOS.id = PROYECTOS_MATERIALES.material_tarifa_id 
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = PROYECTOS_MATERIALES.proyecto_id 
            LEFT JOIN PROVEEDORES_DTO 
                ON PROVEEDORES_DTO.id = PROYECTOS_MATERIALES.dto_prov_id
            WHERE
                PROYECTOS_MATERIALES.proyecto_id = ".$_GET['id']." 
            ORDER BY 
                MATERIALES_PRECIOS.proveedor_id ASC, MATERIALES.ref ASC";

    //file_put_contents("array.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover table-condensed' id='tabla-detalles-pedidos'>
                <thead>
                  <tr>
                    <th class='text-center'>A</th>
                    <th class='text-center'>REF</th>
                    <th class='text-center'>MATERIAL</th>
                    <th class='text-center'>FABRICANTE</th>
                    <th class='text-center'>UNID.</th>
                    <th class='text-center'>PRECIO TARIFA</th>
                    <th class='text-center'>DTO %</th>
                    <th class='text-center'>COSTE</th>
                    <th class='text-center'>COSTE TOTAL</th>
                    <th class='text-center'></th>
                    <th class='text-center'>AL</th>
                  </tr>
                </thead>
                <tbody>";
    
    $total = 0;
    $totalDTO = 0;
    $totalPVP = 0;
    while( $row = mysqli_fetch_array($res) ) {
        $cantidad = $row[4];
        $pvpMat = $row[5];
        $dtoProvActivo = $row[8];
        $dtoMatActivo = $row[9];
        $dtoProv = $row[11];
        $dtoMat = $row[12];
        $albREFs = explode(",",$row[15]);
        
        if ($row[16] != "") {
            $envioDatos = explode(",",$row[16]);
            
            
            $sumUnidadesEnvios = 0;
            $contador = 0;
            foreach ($envioDatos as $value) {
                $envioUnidades = explode("-",$value);
                $sumUnidadesEnvios = $sumUnidadesEnvios + $envioUnidades[1];
                
                //$botonEnviado = "<button class='btn-default view-envio' data-id='".$envioID."' title='Ver Albarán'><img src='/erp/img/proveedores.png' style='height: 20px;'></button>";
                $botonEnviado = "<a class='view-envio' data-id='".$envioUnidades[0]."' title='Ver Albarán'>".$albREFs[$contador]."</a><br>";
                $contador = $contador + 1;
            }
            
            // si las unidades totales de todos los envios para este material son mayores o iguales que las utilizadas en el proyecto par aeste material, pintamos de verde, sino, de amarillo
            if ($sumUnidadesEnvios >= $cantidad) {
                $difUnidades = $cantidad - $sumUnidadesEnvios;
                $trEnviado = " style='background-color: #b8fccc !important;' title='Unidades restantes por enviar: ".$difUnidades."'";
            }
            else {
                $difUnidades = $cantidad - $sumUnidadesEnvios;
                $trEnviado = " style='background-color: #ffd29c !important;' title='Unidades restantes por enviar: ".$difUnidades."'";
            }
        }
        else {
            $trEnviado = "";
            $botonEnviado = "";
        }
        
        
        
        $envioID = $row[16];
        $envioUD = $row[17];
        $dto_sum = 0;
        $pvp_dto = 0;
        
        if ($dtoProvActivo == 1) {
            $dto_sum  = $dto_sum + $dtoProv;
        }
        if ($dtoMatActivo == 1) {
            $dto_sum  = $dto_sum + $dtoMat;
        }
                    
        if ($row[6] == 0) {
            $recibidoDet = "NO";
        }
        else {
            $recibidoDet = "SI";
        }
        
        $subtotal = ($pvpMat*$cantidad);
        $dto = ($subtotal*$dto_sum)/100;
        $subtotalDTOPROVapli = $subtotal-$dto;
        
        $totalPVP = $totalPVP + $subtotal;
        $totalDTO = $totalDTO + $dto;
        $totalCosteMaterial = $totalCosteMaterial + $subtotalDTOPROVapli;
        
        $html .= "
                <tr data-id='".$row[0]."' ".$trEnviado.">
                    <td class='text-center'><input type='checkbox' class='to-alb' data-matprojid='".$row[0]."'></td>
                    <td>".$row[1]."</td>
                    <td>".$row[2]."</td>
                    <td>".$row[3]."</td>
                    <td class='text-center'>".$row[4]."</td>
                    <td class='text-right'>".$row[5]."</td>
                    <td class='text-right'>".number_format($dto_sum, 2)."</td>
                    <td class='text-right'>".number_format($subtotal, 2)."</td>
                    <td class='text-right'>".number_format($subtotalDTOPROVapli, 2)."</td>
                    <td class='text-center'><button class='btn-default remove-mat' data-id='".$row[0]."' title='Eliminar Material'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                    <td class='text-center'>".$botonEnviado."</td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    echo $html;
} //if isset btn_login

?>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteMaterial, 2, ',', '.'); ?> €</label></div>
</div>

<div id="selectmaterial_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">SELECCIONAR MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_material">
                        <input type="hidden" value="" name="proyectomaterial_detalle_id" id="proyectomaterial_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="proyectomaterial_proyecto_id" id="proyectomaterial_proyecto_id">
                        <input type="hidden" value="" name="proyectomaterial_material_id" id="proyectomaterial_material_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Categorías:</label>
                            <select id="proyectomaterial_categorias1" name="proyectomaterial_categorias1" class="selectpicker proyectomaterial_categorias" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Buscar:</label>
                                <input type="search" class="form-control" id="proyectomaterial_criterio" name="proyectomaterial_criterio" placeholder="Introduce un criterio para buscar">
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
                            <label class="labelBeforeBlack">REF Proveedor:</label>
                            <input type="text" class="form-control" id="proyectomaterial_ref" name="proyectomaterial_ref">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Stock:</label>
                                <input type="text" class="form-control" id="proyectomaterial_stock" name="proyectomaterial_stock" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6" style="margin-bottom: 15px;">
                                <label class="labelBeforeBlack">Tarifas del Proveedor:</label>
                                <select id="proyectomaterial_precios" name="proyectomaterial_precios" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Tarifa seleccionada:</label>
                                <input type="text" class="form-control" id="proyectomaterial_preciomat" name="proyectomaterial_preciomat" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="proyectomaterial_cantidad" name="proyectomaterial_cantidad" value="0">
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
                                <!-- <input type="text" class="form-control" id="proyectomaterial_dtoprov" name="proyectomaterial_dtoprov" value="0" disabled="true" data-descartar="0"> -->
                                <select id="proyectomaterial_dtoprov" name="proyectomaterial_dtoprov" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="proyectomaterial_dtoprov_desc" name="proyectomaterial_dtoprov_desc">
                                    <label class="form-check-label" for="proyectomaterial_dtoprov_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Material (%):</label>
                                <input type="text" class="form-control" id="proyectomaterial_dtomat" name="proyectomaterial_dtomat" disabled="true" data-descartar="0">
                            </div>
                            <div class="col-xs-6" style="min-height: 64px;">
                                <div class="form-group" style="margin-bottom: 0px; bottom: 0; position: absolute;">
                                    <input type="checkbox" class="form-check-input" id="proyectomaterial_dtomat_desc" name="proyectomaterial_dtomat_desc">
                                    <label class="form-check-label" for="proyectomaterial_dtomat_desc">Aplicar</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px; border-color: #0eace7;"">
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio Neto:</label>
                                <input type="text" class="form-control" id="proyectomaterial_pvp" name="proyectomaterial_pvp" value="0.00" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento Proveedor Total:</label>
                                <input type="text" class="form-control" id="proyectomaterial_totaldto" name="proyectomaterial_totaldto" value="0.00">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">% Total:</label>
                                <input type="text" class="form-control" id="proyectomaterial_totaldtopercent" name="proyectomaterial_totaldtopercent" value="0.00" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP Total:</label>
                                <input type="text" class="form-control" id="proyectomaterial_pvptotal" name="proyectomaterial_pvptotal" value="0.00" style="background-color: #d9534f; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_proyectomaterial_save" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- /MATERIALES -->
