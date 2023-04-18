<!-- ofertas seleccionado -->

<div id="grafico-view">
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        
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
                    MATERIALES.nombre ASC";

        //file_put_contents("array.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("database error:");

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
            $totalCosteMateriales = $totalCosteMateriales + $subtotalDTOPROVapli;

        }
        
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
            $totalCosteTerceros = $totalCosteTerceros + $pvptotal;

        }   
        
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

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
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
            //$total = $total + $pvptotal;

        }  
        
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

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
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
            //$total = $total + $pvptotal;

        }
        
        // Recalcular Materiales y Horas?
        // $totalCosteMateriales y $totalCosteHoras
        // $totalCosteMaterial y $totalCosteHoras
        
        // Coste horas
        $sql = "SELECT 
                    ACTIVIDAD.id as actid,
                    TAREAS.id as tarea,
                    TAREAS.nombre,
                    (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id AND ACTIVIDAD_DETALLES.actividad_id = actid) as totalHoras,
                    ACTIVIDAD.nombre,
                    ACTIVIDAD_DETALLES.nombre,
                    erp_users.nombre,
                    erp_users.apellidos,
                    ACTIVIDAD_DETALLES_HORAS.id as detalle,
                    ACTIVIDAD_DETALLES_HORAS.fecha,
                    PERFILES_HORAS.precio_coste,
                    ACTIVIDAD_DETALLES_HORAS.cantidad,
                    ACTIVIDAD_DETALLES.fecha
                FROM 
                    TAREAS, PERFILES, PERFILES_HORAS, ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES, ACTIVIDAD, PROYECTOS, erp_users  
                WHERE 
                    ACTIVIDAD.tarea_id = TAREAS.id
                AND
                    TAREAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.perfil_id = PERFILES.id
                AND
                    PERFILES_HORAS.id = ACTIVIDAD_DETALLES_HORAS.tipo_hora_id
                AND
                    ACTIVIDAD.item_id = PROYECTOS.id 
                AND
                    ACTIVIDAD_DETALLES.actividad_id = ACTIVIDAD.id
                AND
                    ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id 
                AND 
                    ACTIVIDAD_DETALLES_HORAS.tecnico_id = erp_users.id 
                AND
                    ACTIVIDAD.imputable = 1 
                AND
                    PROYECTOS.id = ".$_GET['id']."
                ORDER BY 
                    ACTIVIDAD_DETALLES_HORAS.id ASC";

        file_put_contents("viewHoras.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Actividad Imputable");
        
        $totalCosteHoras = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $cantidadORD = $registros[11];
            $pvpHora = $registros[10];
            
            $costeHoras = $cantidadORD*$pvpHora;
          
            $totalCosteHoras = $totalCosteHoras + $costeHoras;
        }
        
        // Coste Materiales
        
        $sql = "SELECT DISTINCT
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
                PROYECTOS_MATERIALES.pedido_detalle_id
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
            INNER JOIN ENVIOS_CLI_DETALLES
                ON PROYECTOS.id = ENVIOS_CLI_DETALLES.proyecto_id 
            WHERE
                PROYECTOS_MATERIALES.proyecto_id = ".$_GET['id']." 
            ORDER BY 
                MATERIALES_PRECIOS.proveedor_id ASC, MATERIALES.ref ASC";

    file_put_contents("array0.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $totalCosteMaterial=0;
    while( $row = mysqli_fetch_array($res) ) {
        $cantidad = $row[4];
        $pvpMat = $row[5];
        $dtoProvActivo = $row[8];
        $dtoMatActivo = $row[9];
        $dtoProv = $row[11];
        $dtoMat = $row[12];

        $dto_sum = 0;
        $pvp_dto = 0;        
        
        if ($dtoProvActivo == 1) {
            $dto_sum  = $dto_sum + $dtoProv;
        }
        if ($dtoMatActivo == 1) {
            $dto_sum  = $dto_sum + $dtoMat;
        }
        
        $subtotal = ($pvpMat*$cantidad);
        $dto = ($subtotal*$dto_sum)/100;
        $subtotalDTOPROVapli = $subtotal-$dto;
        
        $totalCosteMaterial = $totalCosteMaterial + $subtotalDTOPROVapli;
        
        
    }
        // $totalCosteMaterial
        
    //?¿?¿ Pendiente buena revision
        //$totalCosteMaterial=number_format((float)$totalCosteMaterial, 2);
        //$totalCosteTerceros=number_format((float)$totalCosteTerceros, 2);
        //$totalCosteHoras=number_format((float)$totalCosteHoras, 2);
        //$totalCosteViajes=number_format((float)$totalCosteViajes, 2);
        //$totalCosteOtros=number_format((float)$totalCosteOtros, 2);
        
        $totalCosteTotal=$totalCosteMaterial+$totalCosteTerceros+$totalCosteHoras+$totalCosteViajes+$totalCosteOtros;
    
    ?>
    <div id="chart_container" style="width: 65%; margin: 0px auto 0px auto;">
        <canvas id="proyecto-chart2"></canvas>
    </div>
</div>

<script>
    $( document ).ready(function() {
        var ctx = document.getElementById('proyecto-chart2').getContext('2d');
        
        //ctx.heigth = 250;
        
        console.log("num: "+<? echo number_format((float)$totalCosteHoras, 2); ?>);
        
        data = {
            datasets: [{
                data: [<? echo $totalCosteMaterial; ?>, <? echo $totalCosteTerceros; ?>, <? echo $totalCosteHoras; ?>, <? echo $totalCosteViajes; ?>, <? echo $totalCosteOtros; ?>],
                backgroundColor:["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)","rgb(92, 184, 92)","rgb(150, 150, 150)"]
            }],
            labels: [
                'Materiales',
                'Subcontrataciones',
                'Mano de Obra',
                'Viajes',
                'Otros'          
            ]
        };
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                
            }
        });
//        var gastosChart = new Chart(ctx, {
//            type: 'bar',
//            data: data,
//            options: {
//                scales: {
//                    yAxes: [{
//                        ticks: {
//                            beginAtZero: true
//                        }
//                    }]
//                },
//                responsive: true,
//                maintainAspectRatio: false
//            }
//        });
    });
</script>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px; margin-top: 10px;">
    <div class="col-sm-3" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='total_gastos' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteTotal, 2, ',', '.'); ?> €</label></div>
</div>

<!-- grafico oferta -->