<!-- grafico ensayos -->

<div id="project-view">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // EN PROCESO
        $sql = "SELECT 
                    ID
                FROM 
                    ENSAYOS 
                WHERE 
                    estado_id = 1
                AND
                    entrega_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ensayos");
        
        $totalEnProceso = mysqli_num_rows($resultado);
        
        // APROBADOS
        $sql = "SELECT 
                    ID
                FROM 
                    ENSAYOS 
                WHERE 
                    estado_id = 2
                AND
                    entrega_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ensayos");
        
        $totalAprobados = mysqli_num_rows($resultado);
        
        // FALLIDOS
        $sql = "SELECT 
                    ID
                FROM 
                    ENSAYOS 
                WHERE 
                    estado_id = 3
                AND
                    entrega_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ensayos");
        
        $totalFallidos = mysqli_num_rows($resultado);
        
        // AVISO
        $sql = "SELECT 
                    ID
                FROM 
                    ENSAYOS 
                WHERE 
                    estado_id = 4
                AND
                    entrega_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ensayos");
        
        $totalAviso = mysqli_num_rows($resultado);
        
        // PENDIENTES
        $sql = "SELECT 
                    ID
                FROM 
                    ENSAYOS 
                WHERE 
                    estado_id = 5
                AND
                    entrega_id = ".$_GET['id'];

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ensayos");
        
        $totalPendientes = mysqli_num_rows($resultado);

    ?>
    <div id="chart_container">
            <canvas id="entrega-chart"></canvas>
    </div>
</div>

<script>
    $( document ).ready(function() {
        
        
        
        var ctx = document.getElementById('entrega-chart').getContext('2d');
        
        data = {
            datasets: [{
                data: [<? echo $totalAprobados; ?>, <? echo $totalEnProceso; ?>, <? echo $totalFallidos; ?>, <? echo $totalAviso; ?>, <? echo $totalPendientes; ?>],
                backgroundColor:["rgb(92,184,92)","rgb(51,122,183)","rgb(217,83,79)","rgb(240,173,78)","rgb(119,119,119)"]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Aprobado',
                'En Proceso',
                'Fallido',
                'Aviso',
                'Pendiente'
            ]
        };

        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                circumference: Math.PI,
                rotation: -Math.PI
            }
        });
    });
</script>

<!-- grafico ensayos -->