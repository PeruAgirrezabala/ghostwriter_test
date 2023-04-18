<!-- Otros Gastos Proyecto -->
<div class="alert-middle alert alert-success alert-dismissable" id="proyectos-otros_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-proyectos-otros'>
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
                PROYECTOS_DETALLES_OTROSGASTOS.cantidad,
                PROYECTOS_DETALLES_OTROSGASTOS.unitario,
                PROYECTOS_DETALLES_OTROSGASTOS.titulo,
                PROYECTOS_DETALLES_OTROSGASTOS.descripcion,
                PROYECTOS_DETALLES_OTROSGASTOS.iva,
                PROYECTOS_DETALLES_OTROSGASTOS.pvp,
                PROYECTOS_DETALLES_OTROSGASTOS.pvp_total, 
                PROYECTOS_DETALLES_OTROSGASTOS.id as detalle
            FROM 
                PROYECTOS_DETALLES_OTROSGASTOS, PROYECTOS  
            WHERE 
                PROYECTOS_DETALLES_OTROSGASTOS.proyecto_id = PROYECTOS.id 
            AND 
                PROYECTOS.id = ".$_GET['id']."
            ORDER BY 
                PROYECTOS_DETALLES_OTROSGASTOS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Otros");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        $totalCosteOtros = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $proyecto_id = $_GET['id'];
            $cantidadOTR = $registros[0];
            $unitarioOTR = $registros[1];
            $tituloOTR = $registros[2];
            $descripcionOTR = $registros[3];
            $ivaOTR = $registros[4];
            $pvp = $registros[5];
            $pvptotal = $registros[6];
            $id = $registros[7];
            
            $totalPVP = $totalPVP + $pvp;
            $totalCosteOtros = $totalCosteOtros + $pvptotal;
            
            echo "
                <tr data-id='".$id."' class='oferta'>
                    <td class='text-center'>".$cantidadOTR."</td>
                    <td>".$tituloOTR."</td>
                    <td class='text-center'>".$unitarioOTR."</td>
                    <td class='text-center'>".$pvp."</td>
                    <td class='text-center'>".$ivaOTR."</td>
                    <td class='text-center'>".$pvptotal."</td>
                    <td class='text-center'><button class='btn-default remove-detalle-otros' data-id='".$id."'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='otros_total' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteOtros, 2, ',', '.'); ?> €</label></div>
</div>
    
<div id="otros_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">IMPUTAR OTROS GASTOS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_proyectootros">
                        <input type="hidden" value="" name="proyectootros_detalle_id" id="proyectootros_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="proyectootros_proyecto_id" id="proyectootros_proyecto_id">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="proyectootros_titulo" name="proyectootros_titulo">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <input type="text" class="form-control" id="proyectootros_descripcion" name="proyectootros_descripcion">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Cantidad:</label>
                                <input type="text" class="form-control" id="proyectootros_cantidad" name="proyectootros_cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Precio:</label>
                                <input type="text" class="form-control" id="proyectootros_unitario" name="proyectootros_unitario">
                            </div>
                        </div>
                        <div class="form-group">
                            <hr style="width:100%; border-width: 1px;">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">PVP:</label>
                                <input type="text" class="form-control" id="proyectootros_pvp" name="proyectootros_pvp" value="0" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">IVA:</label>
                                <input type="text" class="form-control" id="proyectootros_iva" name="proyectootros_iva" value="0">
                            </div>
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">TOTAL:</label>
                                <input type="text" class="form-control" id="proyectootros_pvp_total" name="proyectootros_pvp_total" value="0" style="background-color: #d9534f; color: #ffffff !important;" disabled="true">
                            </div>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_proyectootros_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Otros Gastos Proyecto -->

<!-- CREACION DEL GRAFICO -->
<script>
    $( document ).ready(function() {
        
        
        
        var ctx = document.getElementById('proyecto-chart').getContext('2d');
        
        data = {
            datasets: [{
                data: [<? echo $totalCosteMaterial; ?>, <? echo $totalCosteSub; ?>, <? echo $totalCosteHoras; ?>, <? echo $totalCosteViajes; ?>, <? echo $totalCosteOtros; ?>],
                backgroundColor:["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)","rgb(92, 184, 92)","rgb(150, 150, 150)"]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Materiales',
                'Subcontrataciones',
                'Horas Imputadas',
                'Viajes',
                'Otros'
            ]
        };
        
        var totalGastos = <? echo $totalCosteMaterial; ?> + <? echo $totalCosteSub; ?> + <? echo $totalCosteHoras; ?> + <? echo $totalCosteViajes; ?> + <? echo $totalCosteOtros; ?>;
        
        $("#total_gastos").html(parseFloat(totalGastos).toFixed(2));
        
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                
            }
        });
    });
</script>