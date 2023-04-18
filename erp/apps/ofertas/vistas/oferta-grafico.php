<!-- ofertas seleccionado -->

<div id="project-view">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

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
                    OFERTAS_DETALLES_MATERIALES.oferta_id = ".$_GET['id'];

        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        $totalMat = 0;
        $totalSub = 0;
        $totalMano = 0;
        $totalVi = 0;
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
            $inc = "1.".$incMat;
            $pvpTOTAL = $inc*$subtotalDTOCLIapli;
            
            $totalPVP = $totalPVP + $subtotalDTOCLIapli;
            $totalDTO = $totalDTO + $dtoCliPVP;

            $totalMat = $totalMat + $pvpTOTAL;
        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_TERCEROS.pvp_total
            FROM 
                OFERTAS_DETALLES_TERCEROS 
            WHERE 
                OFERTAS_DETALLES_TERCEROS.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvptotal = $registros[0];
            $totalSub = $totalSub + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_HORAS.pvp_total
            FROM 
                OFERTAS_DETALLES_HORAS 
            WHERE 
                OFERTAS_DETALLES_HORAS.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvptotal = $registros[0];
            $totalMano = $totalMano + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_VIAJES.pvp_total
            FROM 
                OFERTAS_DETALLES_VIAJES 
            WHERE 
                OFERTAS_DETALLES_VIAJES.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvptotal = $registros[0];
            $totalVi = $totalVi + $pvptotal;

        }   
        
        $sql = "SELECT 
                OFERTAS_DETALLES_OTROS.pvp_total
            FROM 
                OFERTAS_DETALLES_OTROS 
            WHERE 
                OFERTAS_DETALLES_OTROS.oferta_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pvptotal = $registros[0];
            $totalOtros = $totalOtros + $pvptotal;

        }   
        $totalGanancia = $total - $totalPVPdto;

    ?>
    <div id="chart_container">
            <canvas id="oferta-chart"></canvas>
    </div>
</div>

<script>
    $( document ).ready(function() {
        
        // Script Oferta-grafico
        
        var ctx = document.getElementById('oferta-chart').getContext('2d');
        
        data = {
            datasets: [{
                data: [<? echo $totalMat; ?>, <? echo $totalSub; ?>, <? echo $totalMano; ?>, <? echo $totalVi; ?>, <? echo $totalOtros; ?>],
                backgroundColor:["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)","rgb(92, 184, 92)","rgb(150, 150, 150)"]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Materiales',
                'Subcontrataciones',
                'Manode Obra',
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
    });
</script>

<!-- grafico oferta -->