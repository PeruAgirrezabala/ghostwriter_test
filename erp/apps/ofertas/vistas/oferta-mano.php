<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="ofertas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>

<table class="table table-striped table-hover" id='tabla-ofertas-mano'>
    <thead>
      <tr class="bg-dark">
        <th class="text-center">TAREA</th>
        <th class="text-center">TITULO</th>
        <th class="text-center">CANT</th>
        <th class="text-center">Unitario (€)</th>
        <th class="text-center">PVP (€)</th>
        <th class="text-center">DTO (%)</th>
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
                TAREAS.id as tarea,
                TAREAS.nombre,
                OFERTAS_DETALLES_HORAS.cantidad,
                PERFILES_HORAS.precio,
                OFERTAS_DETALLES_HORAS.titulo,
                OFERTAS_DETALLES_HORAS.descripcion,
                OFERTAS_DETALLES_HORAS.dto,
                OFERTAS_DETALLES_HORAS.pvp,
                OFERTAS_DETALLES_HORAS.pvp_total, 
                OFERTAS_DETALLES_HORAS.id as detalle,
                OFERTAS_DETALLES_HORAS.added
            FROM 
                TAREAS, PERFILES, PERFILES_HORAS, OFERTAS_DETALLES_HORAS, OFERTAS  
            WHERE 
                OFERTAS_DETALLES_HORAS.tarea_id = TAREAS.id
            AND
                TAREAS.perfil_id = PERFILES.id
            AND
                PERFILES_HORAS.perfil_id = PERFILES.id
			AND
                PERFILES_HORAS.id = OFERTAS_DETALLES_HORAS.tipo_hora_id
            AND
                OFERTAS_DETALLES_HORAS.oferta_id = OFERTAS.id 
            AND 
                OFERTAS.id = ".$_GET['id']."
            ORDER BY 
                OFERTAS_DETALLES_HORAS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Mano de Obra");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalIVA = 0;
        $totalPVPdto = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $oferta_id = $_GET['id'];
            $nombreTAR = $registros[1];
            $cantidadMANO = $registros[2];
            $unitarioMANO = $registros[3];
            $tituloMANO = $registros[4];
            $descripcionMANO = $registros[5];
            $dto = $registros[6];
            $pvp = $registros[7];
            $pvptotal = $registros[8];
            $id = $registros[9];
            $added = $registros[10];
            
            $totalPVP = $totalPVP + $pvp;
            $totalDTO = $totalDTO + ($pvp - $pvptotal);
            $total = $total + $pvptotal;
            
            if($added==1){ // Horas añadidas (Pintados)
                // ffe8b5
                $style="style='background-color: #fee8b5;'";
                $disable="disabled";
                $title="title='Borrar primero del proyecto'";
                $id=0;
            }else{ // Horas por añadir (Sin pintar)
                $style="";
                $title="title='Borrar Mano de Obra'";
                $disable="";
            }
            
            echo "<tr data-id='".$id."' class='oferta' ".$style.">
                    <td>".$nombreTAR."</td>
                    <td>".$tituloMANO."</td>
                    <td class='text-center'>".$cantidadMANO."</td>
                    <td class='text-center'>".$unitarioMANO."</td>
                    <td class='text-center'>".$pvp."</td>
                    <td class='text-center'>".$dto."</td>
                    <td class='text-center'>".$pvptotal."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-detalle-mano' data-id='".$id."' ".$disable." ".$title."><img src='/erp/img/cross.png'></button></td>
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


