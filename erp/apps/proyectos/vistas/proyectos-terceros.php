<!-- Subcontrataciones Proyecto -->
<div class="alert-middle alert alert-success alert-dismissable" id="proyectos-terceros_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-proyectos-sub'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">CANT</th>
            <th>PROV</th>
            <th>TITULO</th>
            <th class="text-center">Unitario (€)</th>
            <th class="text-center">PVP (€)</th>
            <th class="text-center">DTO (%)</th>
            <th class="text-center">PVP DTO (€)</th>
            <th class="text-center">IVA (€)</th>
            <th class="text-center">TOTAL (€)</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                PROVEEDORES.id as tercero,
                PROVEEDORES.nombre,
                PROYECTOS_DETALLES_TERCEROS.cantidad,
                PROYECTOS_DETALLES_TERCEROS.unitario,
                PROYECTOS_DETALLES_TERCEROS.titulo,
                PROYECTOS_DETALLES_TERCEROS.descripcion,
                PROYECTOS_DETALLES_TERCEROS.iva,
                PROYECTOS_DETALLES_TERCEROS.dto1,
                PROYECTOS_DETALLES_TERCEROS.pvp,
                PROYECTOS_DETALLES_TERCEROS.pvp_dto,
                PROYECTOS_DETALLES_TERCEROS.pvp_total, 
                PROYECTOS_DETALLES_TERCEROS.id as detalle
            FROM 
                PROVEEDORES, PROYECTOS_DETALLES_TERCEROS, PROYECTOS  
            WHERE 
                PROYECTOS_DETALLES_TERCEROS.tercero_id = PROVEEDORES.id
            AND
                PROYECTOS_DETALLES_TERCEROS.proyecto_id = PROYECTOS.id 
            AND 
                PROYECTOS.id = ".$_GET['id']." 
            ORDER BY 
                PROYECTOS_DETALLES_TERCEROS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        $totalCosteSub = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $oferta_id = $_GET['id'];
            $nombrePROV = $registros[1];
            $cantidad = $registros[2];
            $unitario = $registros[3];
            $tituloSUB = $registros[4];
            $descripcionSUB = $registros[5];
            $ivaSUB = $registros[6];
            $dto = $registros[7];
            $pvp = $registros[8];
            $pvpdto = $registros[9];
            $pvptotal = $registros[10];
            $id = $registros[11];
            
            $totalPVP = $totalPVP + $pvp;
            $totalDTO = $totalDTO + ($pvp - $pvpdto);
            $totalPVPdto = $totalPVPdto + $pvpdto;
            $totalCosteSub = $totalCosteSub + $pvptotal;
            
            echo "
                <tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidad."</td>
                    <td>".$nombrePROV."</td>
                    <td>".$tituloSUB."</td>
                    <td class='text-center'>".$unitario."</td>
                    <td class='text-center'>".$pvp."</td>
                    <td class='text-center'>".$dto."</td>
                    <td class='text-center'>".$pvpdto."</td>
                    <td class='text-center'>".$ivaSUB."</td>
                    <td class='text-center'>".$pvptotal."</td>
                    <td class='text-center'><button class='btn-default remove-detalle-terceros' data-id='".$id."'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='terceros_total' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteSub, 2, ',', '.'); ?> €</label></div>
</div>

<div id="subcontratacion_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">IMPUTAR SUBCONTRATACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_proyectosub">
                        <input type="hidden" value="" name="proyectosub_detalle_id" id="proyectosub_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="proyectosub_proyecto_id" id="proyectosub_proyecto_id">
                        <input type="hidden" value="" name="proyectosub_tercero_id" id="proyectosub_tercero_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Proveedores:</label>
                            <select id="proyectosub_terceros" name="proyectosub_terceros" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="proyectosub_titulo" name="proyectosub_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="proyectosub_descripcion" name="proyectosub_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="proyectosub_cantidad" name="proyectosub_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio:</label>
                                <input type="text" class="form-control" id="proyectosub_unitario" name="proyectosub_unitario">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP:</label>
                                <input type="text" class="form-control" id="proyectosub_pvp" name="proyectosub_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Descuento (%):</label>
                                <input type="text" class="form-control" id="proyectosub_dto" name="proyectosub_dto" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP - Descuento:</label>
                                <input type="text" class="form-control" id="proyectosub_pvpdto" name="proyectosub_pvpdto" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Iva:</label>
                                <input type="text" class="form-control" id="proyectosub_iva" name="proyectosub_iva" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">TOTAL:</label>
                                <input type="text" class="form-control" id="proyectosub_pvp_total" name="proyectosub_pvp_total" value="0" style="background-color: #d9534f; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_proyectosub_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Subcontrataciones Proyecto -->