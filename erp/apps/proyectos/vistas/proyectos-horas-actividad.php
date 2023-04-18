<!-- ofertas seleccionado -->

<div id="project-view">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $totalVendidas = 0;
        $totalTrabajadas = 0;
        
        $sqlTrabajadas = "SELECT 
                                sum(ACTIVIDAD_DETALLES_HORAS.cantidad) as trabajadas
                            FROM 
                                TAREAS, PERFILES, PERFILES_HORAS, ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD, ACTIVIDAD_DETALLES, PROYECTOS, erp_users  
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
                                ACTIVIDAD_DETALLES_HORAS.tecnico_id = erp_users.id 
                            AND 
                                ACTIVIDAD_DETALLES.actividad_id = ACTIVIDAD.id
                            AND
                                ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id 
                            AND
                                ACTIVIDAD.imputable = 1       
                            AND 
                                PROYECTOS.estado_id <> 3 
                            AND 
                                PROYECTOS.estado_id <> 6 ";
        $resultado = mysqli_query($connString, $sqlTrabajadas) or die("Error al ejcutar la consulta de Horas Trabajadas");
        $registros = mysqli_fetch_row($resultado);
        $totalTrabajadas = $registros[0];
        
        $sqlVendidas = "SELECT 
                                sum(PROYECTOS_TAREAS.cantidad) as vendidas
                            FROM 
                                TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_TAREAS, PROYECTOS, erp_users  
                            WHERE 
                                PROYECTOS_TAREAS.tarea_id = TAREAS.id
                            AND
                                TAREAS.perfil_id = PERFILES.id
                            AND
                                PERFILES_HORAS.perfil_id = PERFILES.id
                            AND
                                PERFILES_HORAS.id = PROYECTOS_TAREAS.tipo_hora_id
                            AND
                                PROYECTOS_TAREAS.proyecto_id = PROYECTOS.id 
                            AND 
                                PROYECTOS_TAREAS.tecnico_id = erp_users.id 
                            AND 
                                PROYECTOS.estado_id <> 3 
                            AND 
                                PROYECTOS.estado_id <> 6";
        $resultado = mysqli_query($connString, $sqlVendidas) or die("Error al ejcutar la consulta de Horas Vendidas");
        $registros = mysqli_fetch_row($resultado);
        $totalVendidas = $registros[0];

    ?>
    <div id="chart_container" style="height: 250px">
        <canvas id="horas-chart"></canvas>
    </div>
</div>

<script>
    $( document ).ready(function() {
        var ctx = document.getElementById('horas-chart');
        
        data = {
            datasets: [{
                data: [<? echo $totalVendidas; ?>, <? echo $totalTrabajadas; ?>],
                backgroundColor:["rgb(54, 162, 235)","rgb(255, 99, 132)"],
                label: 'Cómputo total de horas de Proyectos activos'
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'H. Vendidas',
                'H. Imputadas'
            ]
        };

        var horasChart = new Chart(ctx, {
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