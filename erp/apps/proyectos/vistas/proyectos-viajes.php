<!-- Viajes Proyecto -->
<div class="alert-middle alert alert-success alert-dismissable" id="ofertas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-proyectos-viajes'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">CANT</th>
            <th>TITULO</th>
            <th class="text-center">Unitario (€)</th>
            <th class="text-center">PVP (€)</th>
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
                PROYECTOS_DETALLES_VIAJES.cantidad,
                PROYECTOS_DETALLES_VIAJES.unitario,
                PROYECTOS_DETALLES_VIAJES.titulo,
                PROYECTOS_DETALLES_VIAJES.descripcion,
                PROYECTOS_DETALLES_VIAJES.iva,
                PROYECTOS_DETALLES_VIAJES.pvp,
                PROYECTOS_DETALLES_VIAJES.pvp_total, 
                PROYECTOS_DETALLES_VIAJES.id as detalle
            FROM 
                PROYECTOS_DETALLES_VIAJES, PROYECTOS  
            WHERE 
                PROYECTOS_DETALLES_VIAJES.proyecto_id = PROYECTOS.id 
            AND 
                PROYECTOS.id = ".$_GET['id']."
            ORDER BY 
                PROYECTOS_DETALLES_VIAJES.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Viajes");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        $totalCosteViajes = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $proyecto_id = $_GET['id'];
            $cantidadVI = $registros[0];
            $unitarioVI = $registros[1];
            $tituloVI = $registros[2];
            $descripcionVI = $registros[3];
            $ivaVI = $registros[4];
            $pvp = $registros[5];
            $pvptotal = $registros[6];
            $id = $registros[7];
            
            $totalPVP = $totalPVP + $pvp;
            $totalCosteViajes = $totalCosteViajes + $pvptotal;
            
            echo "
                <tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidadVI."</td>
                    <td>".$tituloVI."</td>
                    <td class='text-center'>".$unitarioVI."</td>
                    <td class='text-center'>".$pvp."</td>
                    <td class='text-center'>".$ivaVI."</td>
                    <td class='text-center'>".$pvptotal."</td>
                    <td class='text-center'><button class='btn-default remove-detalle-viaje' data-id='".$id."'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>
            ";
        }   
        
    ?>
    </tbody>
</table>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='viajes_total' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteViajes, 2, ',', '.'); ?> €</label></div>
</div>
  
<div id="viajes_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">IMPUTAR VIAJE/DESPLAZAMIENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_proyectoviajes">
                        <input type="hidden" value="" name="proyectoviajes_detalle_id" id="proyectoviajes_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="proyectoviajes_proyecto_id" id="proyectoviajes_proyecto_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="proyectoviajes_titulo" name="proyectoviajes_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="proyectoviajes_descripcion" name="proyectoviajes_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="proyectoviajes_cantidad" name="proyectoviajes_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio:</label>
                                <input type="text" class="form-control" id="proyectoviajes_unitario" name="proyectoviajes_unitario">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP:</label>
                                <input type="text" class="form-control" id="proyectoviajes_pvp" name="proyectoviajes_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">IVA:</label>
                                <input type="text" class="form-control" id="proyectoviajes_iva" name="proyectoviajes_iva" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">TOTAL:</label>
                                <input type="text" class="form-control" id="proyectoviajes_pvp_total" name="proyectoviajes_pvp_total" value="0" style="background-color: #d9534f; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_proyectoviajes_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Viajes Proyecto -->