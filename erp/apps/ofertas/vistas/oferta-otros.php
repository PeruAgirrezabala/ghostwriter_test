<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="ofertas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-ofertas-otros'>
    <thead>
      <tr class="bg-dark">
        <th class="text-center">TITULO</th>
        <th class="text-center">CANT</th>
        <th class="text-center">Unitario (€)</th>
        <th class="text-center">Coste (€)</th>
        <th class="text-center">Margen (%)</th>
        <th class="text-center">PVP (€)</th>
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
                OFERTAS_DETALLES_OTROS.cantidad,
                OFERTAS_DETALLES_OTROS.unitario,
                OFERTAS_DETALLES_OTROS.titulo,
                OFERTAS_DETALLES_OTROS.descripcion,
                OFERTAS_DETALLES_OTROS.incremento,
                OFERTAS_DETALLES_OTROS.pvp,
                OFERTAS_DETALLES_OTROS.pvp_total, 
                OFERTAS_DETALLES_OTROS.id as detalle,
                OFERTAS_DETALLES_OTROS.added
            FROM 
                OFERTAS_DETALLES_OTROS, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_OTROS.oferta_id = OFERTAS.id 
            AND 
                OFERTAS.id = ".$_GET['id']."
            ORDER BY 
                OFERTAS_DETALLES_OTROS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Otros");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $oferta_id = $_GET['id'];
            $cantidadOTR = $registros[0];
            $unitarioOTR = $registros[1];
            $tituloOTR = $registros[2];
            $descripcionOTR = $registros[3];
            $incrementoOTR = $registros[4];
            $pvp = $registros[5];
            $pvptotal = $registros[6];
            $id = $registros[7];
            $added = $registros[8];
            
            $totalPVP = $totalPVP + $pvp;
            $total = $total + $pvptotal;
            
            if($added==1){ // Horas añadidas (Pintados)
                // dbdbdb
                $style="style='background-color: #dbdbdb;'";
                $disable="disabled";
                $title="title='Borrar primero del proyecto'";
                $id=0;
            }else{ // Horas por añadir (Sin pintar)
                $style="";
                $title="title='Borrar Otros Gastos'";
                $disable="";
            }
            
            echo "
                <tr data-id='".$id."' class='oferta' ".$style.">
                    <td>".$tituloOTR."</td>
                    <td class='text-center'>".$cantidadOTR."</td>
                    <td class='text-center'>".$unitarioOTR."</td>
                    <td class='text-center'>".$pvp."</td>
                    <td class='text-center'>".$incrementoOTR."</td>
                    <td class='text-center'>".$pvptotal."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-detalle-otros' data-id='".$id."' ".$disable." ".$title."><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
        $totalGanancia = $total - $totalPVP;
    ?>
    </tbody>
</table>

<div class="row pvp_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>COSTE: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO CLI: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>MARGEN: </label> <label id='materiales_iva' class="precio_right_vistas"> <? echo number_format((float)$totalGanancia, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format((float)$total, 2, ',', '.'); ?> €</label></div>
</div>

    </tbody>
</table>

