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
                OFERTAS_DETALLES_MATERIALES.pvp,
                OFERTAS_DETALLES_MATERIALES.pvp_dto,
                OFERTAS_DETALLES_MATERIALES.pvp_total
            FROM 
                OFERTAS_DETALLES_MATERIALES, OFERTAS 
            WHERE 
                OFERTAS_DETALLES_MATERIALES.oferta_id = OFERTAS.id 
            AND
                YEAR(OFERTAS.fecha) = ".$yearSelected."
            AND
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        $totalPVP = 0;
        $totalDTO = 0;
        $total = 0;
        $totalPVPdto = 0;
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalDTO = $totalDTO + ($pvp - $pvpdto);
            $totalCosteMateriales = $totalCosteMateriales + $pvpdto;
            //$total = $total + $pvptotal;
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
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalDTO = $totalDTO + ($pvp - $pvpdto);
            $totalCosteTerceros = $totalCosteTerceros + $pvpdto;
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
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            //$pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalCosteViajes = $totalCosteViajes + $pvp;
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
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            //$pvpdto = $registros[1];
            //$pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalCosteOtros = $totalCosteOtros + $pvp;
            //$total = $total + $pvptotal;

        }  
        
        $totalCosteHoras = 0;
        
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
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
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
            $totalVentaMateriales = $totalVentaMateriales + $pvpdto;
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
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[3] - $registros[1]);
            $pvptotal = $registros[3];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $totalVentaTerceros = $totalVentaTerceros + $pvpdto;
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
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvptotal = $registros[1];

            $totalPVP = $totalPVP + $pvp;
            $totalVentaHoras = $totalVentaHoras + $pvptotal;

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
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[2] - $registros[1]);
            $pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $totalVentaViajes = $totalVentaViajes + $pvptotal;

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
                OFERTAS.estado_id <> 4
            AND
                OFERTAS.estado_id <> 5";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvp = $registros[0];
            $pvpincremento = ($registros[2] - $registros[1]);
            $pvptotal = $registros[2];

            $totalPVP = $totalPVP + $pvp;
            $totalINC = $totalINC + $pvpincremento;
            $totalVentaOtros = $totalVentaOtros + $pvptotal;

        }   
        
    ?>
    <div id="chart_container" style="height: 250px">
        <canvas id="ofertas-costes-tipo"></canvas>
    </div>
</div>

<script>
    $( document ).ready(function() {
        var ctx = document.getElementById('ofertas-costes-tipo');
        
        ctx.heigth = 250;
        
        data = {
            labels: [
                'Materiales',
                'Subcontrataciones',
                'Mano de Obra',
                'Viajes',
                'Otros'          
            ],
            datasets: [{
                data: [<? echo $totalCosteMateriales; ?>, <? echo $totalCosteTerceros; ?>, <? echo $totalCosteHoras; ?>, <? echo $totalCosteViajes; ?>, <? echo $totalCosteOtros; ?>],
                backgroundColor:["rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)","rgba(255, 99, 132, 0.5)"],
                label: 'Costes del año <? echo $yearSelected; ?>'
            },
            {
                data: [<? echo $totalVentaMateriales; ?>, <? echo $totalVentaTerceros; ?>, <? echo $totalVentaHoras; ?>, <? echo $totalVentaViajes; ?>, <? echo $totalVentaOtros; ?>],
                backgroundColor:["rgba(92,184,92, 0.5)","rgba(92,184,92, 0.5)","rgba(92,184,92, 0.5)","rgba(92,184,92, 0.5)","rgba(92,184,92, 0.5)"],
                label: 'Ventas del año <? echo $yearSelected; ?>'
            }]
        };

        var gastosChart = new Chart(ctx, {
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
                maintainAspectRatio: false
            }
        });
    });
</script>

<!-- grafico oferta -->