<!-- ofertas seleccionado -->

<div id="project-view">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        if ($_GET['year'] != "") {
            $yearSelected = $_GET['year'];
        }
        else {
            $yearSelected = date("Y");
        }
        
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    OFERTAS_DETALLES_MATERIALES.id,
                    MATERIALES.id as material,
                    MATERIALES.ref,
                    MATERIALES.nombre,
                    MATERIALES.modelo,
                    MATERIALES.descripcion,
                    MATERIALES_PRECIOS.pvp as precio,
                    OFERTAS_DETALLES_MATERIALES.cantidad,
                    OFERTAS_DETALLES_MATERIALES.titulo,
                    OFERTAS_DETALLES_MATERIALES.descripcion,
                    OFERTAS_DETALLES_MATERIALES.incremento,
                    OFERTAS_DETALLES_MATERIALES.dto1, 
                    OFERTAS_DETALLES_MATERIALES.dto_prov_activo, 
                    OFERTAS_DETALLES_MATERIALES.dto_mat_activo, 
                    OFERTAS_DETALLES_MATERIALES.dto_ad_activo, 
                    PROVEEDORES_DTO.dto_prov, 
                    MATERIALES.dto2 
                FROM 
                    MATERIALES
                INNER JOIN MATERIALES_PRECIOS
                    ON MATERIALES_PRECIOS.material_id = MATERIALES.id  
                INNER JOIN OFERTAS_DETALLES_MATERIALES
                    ON OFERTAS_DETALLES_MATERIALES.material_tarifa_id = MATERIALES_PRECIOS.id
                INNER JOIN OFERTAS 
                    ON OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id  
                LEFT JOIN PROVEEDORES_DTO 
                    ON PROVEEDORES_DTO.id = OFERTAS_DETALLES_MATERIALES.dto_prov_id 
                WHERE 
                    YEAR(OFERTAS.fecha) = ".$yearSelected."
                AND
                    (OFERTAS.estado_id = 4
                OR
                    OFERTAS.estado_id = 5)";
        file_put_contents("log.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalPVPdto = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvpMat = $registros[6];
            $cantidad = $registros[7];
            $incMat = $registros[10];
            $dtoProvActivo = $registros[12];
            $dtoMatActivo = $registros[13];
            $dtoCliActivo = $registros[14];
            $dtoProv = $registros[15];
            $dtoMat = $registros[16];
            $dto_sum = 0;
            $pvp_dto = 0;
            
            if ($dtoProvActivo == 1) {
                $dto_sum  = $dto_sum + $dtoProv;
            }
            if ($dtoMatActivo == 1) {
                $dto_sum  = $dto_sum + $dtoMat;
            }
            if ($dtoCliActivo == 1) {
                $dtoAcliente = $registros[11];
            }
            else {
                $dtoAcliente = 0.00;
            }       

            $subtotal = ($pvpMat*$cantidad);
            $dto = ($subtotal*$dto_sum)/100;
            $subtotalDTOPROVapli = $subtotal-$dto;
            $dtoCliPVP = ($subtotalDTOPROVapli*$dtoAcliente)/100;
            $subtotalDTOCLIapli = $subtotalDTOPROVapli - $dtoCliPVP;
            
            $totalPVP = $totalPVP + $subtotalDTOPROVapli;
            $totalDTO = $totalDTO + $dtoCliPVP;
            $totalPVPdto = $totalPVPdto + $subtotalDTOCLIapli;
        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_TERCEROS.pvp,
                OFERTAS_DETALLES_TERCEROS.pvp_dto,
                OFERTAS_DETALLES_TERCEROS.pvp_total
            FROM 
                OFERTAS_DETALLES_TERCEROS, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_TERCEROS.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                (OFERTAS.estado_id = 4
            OR
                OFERTAS.estado_id = 5)";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalDTO = $totalDTO + ($pvp - $pvpdto);
            $totalPVPdto = $totalPVPdto + $pvpdto;
            //$total = $total + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_VIAJES.pvp,
                OFERTAS_DETALLES_VIAJES.pvp_total
            FROM 
                OFERTAS_DETALLES_VIAJES, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_VIAJES.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                (OFERTAS.estado_id = 4
            AND
                OFERTAS.estado_id = 5)";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            //$pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalPVPdto = $totalPVPdto + $pvp;
            //$total = $total + $pvptotal;

        }  
        
        $sql = "SELECT 
                OFERTAS_DETALLES_OTROS.pvp,
                OFERTAS_DETALLES_OTROS.pvp_total
            FROM 
                OFERTAS_DETALLES_OTROS, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_OTROS.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                (OFERTAS.estado_id = 4
            OR
                OFERTAS.estado_id = 5)";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            //$pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalPVPdto = $totalPVPdto + $pvp;
            //$total = $total + $pvptotal;

        }  
        
        $totalCoste = $totalPVPdto;
        
        // PVP VENTA
        $totalPVP = 0;
        $totalINC = 0;
        $totalPVPdto = 0;
        $total = 0;
        
        $sql = "SELECT 
                OFERTAS_DETALLES_MATERIALES.pvp,
                OFERTAS_DETALLES_MATERIALES.pvp_dto,
                OFERTAS_DETALLES_MATERIALES.incremento,
                OFERTAS_DETALLES_MATERIALES.pvp_total
            FROM 
                OFERTAS_DETALLES_MATERIALES, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                (OFERTAS.estado_id = 4
            OR
                OFERTAS.estado_id = 5)";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalPVPdto = 0;
        $pvpincremento = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[3] - $registros[1]);
            $pvptotal = $registros[3];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $totalPVPdto = $totalPVPdto + $pvpdto;
            $total = $total + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_TERCEROS.pvp,
                OFERTAS_DETALLES_TERCEROS.pvp_dto,
                OFERTAS_DETALLES_TERCEROS.incremento,
                OFERTAS_DETALLES_TERCEROS.pvp_total
            FROM 
                OFERTAS_DETALLES_TERCEROS, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_TERCEROS.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                (OFERTAS.estado_id = 4
            OR
                OFERTAS.estado_id = 5)";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[3] - $registros[1]);
            $pvptotal = $registros[3];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $totalPVPdto = $totalPVPdto + $pvpdto;
            $total = $total + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_HORAS.pvp,
                OFERTAS_DETALLES_HORAS.pvp_total
            FROM 
                OFERTAS_DETALLES_HORAS, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_HORAS.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                (OFERTAS.estado_id = 4
            OR
                OFERTAS.estado_id = 5)";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvptotal = $registros[1];

            $totalPVP = $totalPVP + $pvp;
            $total = $total + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_VIAJES.pvp,
                OFERTAS_DETALLES_VIAJES.incremento,
                OFERTAS_DETALLES_VIAJES.pvp_total
            FROM 
                OFERTAS_DETALLES_VIAJES, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_VIAJES.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                (OFERTAS.estado_id = 4
            OR
                OFERTAS.estado_id = 5)";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[2] - $registros[1]);
            $pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $total = $total + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_OTROS.pvp,
                OFERTAS_DETALLES_OTROS.incremento,
                OFERTAS_DETALLES_OTROS.pvp_total
            FROM 
                OFERTAS_DETALLES_OTROS, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_OTROS.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                (OFERTAS.estado_id = 4
            OR
                OFERTAS.estado_id = 5)";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[2] - $registros[1]);
            $pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $total = $total + $pvptotal;

        }   
        
        $totalVenta = $total;
        
        
    ?>
    <div id="chart_container" style="height: 250px">
        <canvas id="ofertas-costes"></canvas>
    </div>
</div>

<script>
    $( document ).ready(function() {
        var ctx = document.getElementById('ofertas-costes');
        
        ctx.heigth = 250;
        
        data = {
            datasets: [{
                data: [<? echo $totalVenta; ?>, <? echo $totalCoste; ?>],
                backgroundColor:["rgb(54, 162, 235)","rgb(255, 99, 132)"],
                label: 'Total Ofertado frente al Total de Costes de <? echo $yearSelected; ?>'
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Total Ventas',
                'Total Costes'
            ]
        };

        var costesChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    });
</script>

<!-- grafico oferta -->