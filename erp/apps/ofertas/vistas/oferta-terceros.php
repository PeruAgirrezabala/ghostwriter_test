<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="ofertas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-ofertas-sub'>
    <thead>
      <tr class="bg-dark">
        <th class="text-center">TITULO</th>
        <th class="text-center">PROV</th>
        <th class="text-center">CANT</th>
        <th class="text-center">Unitario (€)</th>
        <th class="text-center">Coste (€)</th>
        <th class="text-center">DTO CLI (%)</th>
        <th class="text-center">Coste Final (€)</th>
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
                PROVEEDORES.id as tercero,
                PROVEEDORES.nombre,
                OFERTAS_DETALLES_TERCEROS.cantidad,
                OFERTAS_DETALLES_TERCEROS.unitario,
                OFERTAS_DETALLES_TERCEROS.titulo,
                OFERTAS_DETALLES_TERCEROS.descripcion,
                OFERTAS_DETALLES_TERCEROS.incremento,
                OFERTAS_DETALLES_TERCEROS.dto1,
                OFERTAS_DETALLES_TERCEROS.pvp,
                OFERTAS_DETALLES_TERCEROS.pvp_dto,
                OFERTAS_DETALLES_TERCEROS.pvp_total, 
                OFERTAS_DETALLES_TERCEROS.id as detalle,
                OFERTAS_DETALLES_TERCEROS.added
            FROM 
                PROVEEDORES, OFERTAS_DETALLES_TERCEROS, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_TERCEROS.tercero_id = PROVEEDORES.id
            AND
                OFERTAS_DETALLES_TERCEROS.oferta_id = OFERTAS.id 
            AND 
                OFERTAS.id = ".$_GET['id']." 
            ORDER BY 
                OFERTAS_DETALLES_TERCEROS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $oferta_id = $_GET['id'];
            $nombrePROV = $registros[1];
            $cantidad = $registros[2];
            $unitario = $registros[3];
            $tituloSUB = $registros[4];
            $descripcionSUB = $registros[5];
            $incSUB = $registros[6];
            $dto = $registros[7];
            $pvp = $registros[8];
            $pvpdto = $registros[9];
            $pvptotal = $registros[10];
            $id = $registros[11];
            $added = $registros[12];
            
            $totalPVP = $totalPVP + $pvp;
            $totalDTO = $totalDTO + ($pvp - $pvpdto);
            $totalPVPdto = $totalPVPdto + $pvpdto;
            $total = $total + $pvptotal;
            
            if($added==1){ // Horas añadidas (Pintados)
                // a5dbff
                $style="style='background-color: #a5dbff;'";
                $disable="disabled";
                $title="title='Borrar primero del proyecto'";
                $id=0;
            }else{ // Horas por añadir (Sin pintar)
                $style="";
                $title="title='Borrar Subcontratación'";
                $disable="";
            }
            
            echo "
                <tr data-id='".$id."' class='oferta' ".$style.">
                    <td>".$tituloSUB."</td>
                    <td>".$nombrePROV."</td>
                    <td class='text-center'>".$cantidad."</td>
                    <td class='text-center'>".$unitario."</td>
                    <td class='text-center'>".$pvp."</td>
                    <td class='text-center'>".$dto."</td>
                    <td class='text-center'>".$pvpdto."</td>
                    <td class='text-center'>".$incSUB."</td>
                    <td class='text-center'>".$pvptotal."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-detalle-terceros' data-id='".$id."' ".$disable." ".$title."><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
        $totalGanancia = $total - $totalPVPdto;
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

