<!-- ofertas seleccionado -->

<div id="project-view">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_GET['year'] != "") {
            $yearSelected = $_GET['year'];
        }
        else {
            $yearSelected = date("Y");
        }
        
        $totalesMeses = array();
        
        for ($i = 1; $i <= 12; $i++) {
            $totalMes = 0;
            $sql = "SELECT 
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.ref,
                    PEDIDOS_PROV.titulo,
                    PEDIDOS_PROV.descripcion,
                    PEDIDOS_PROV.proveedor_id,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    PEDIDOS_PROV.tecnico_id,
                    PEDIDOS_PROV.proyecto_id,
                    PEDIDOS_PROV.estado_id, 
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV.pedido_genelek
                FROM 
                    PEDIDOS_PROV 
                WHERE 
                    MONTH(fecha) = ".$i."
                AND
                    YEAR(fecha) = ".$yearSelected;
            
            $resultado = mysqli_query($connString, $sql) or die("database error:");
            while( $registros = mysqli_fetch_array($resultado) ) {            
                $sql = "SELECT 
                            PEDIDOS_PROV_DETALLES.id,
                            PEDIDOS_PROV_DETALLES.ref,  
                            MATERIALES.nombre,
                            MATERIALES.fabricante,
                            PEDIDOS_PROV_DETALLES.unidades,
                            MATERIALES_PRECIOS.pvp, 
                            PEDIDOS_PROV_DETALLES.recibido,
                            PEDIDOS_PROV_DETALLES.fecha_recepcion,
                            PROYECTOS.nombre,
                            PEDIDOS_PROV_DETALLES.pvp,
                            MATERIALES_PRECIOS.dto_material, 
                            PEDIDOS_PROV_DETALLES.dto_prov_activo, 
                            PEDIDOS_PROV_DETALLES.dto_mat_activo, 
                            PEDIDOS_PROV_DETALLES.dto_ad_activo, 
                            PROVEEDORES_DTO.dto_prov, 
                            PEDIDOS_PROV_DETALLES.dto, 
                            ENTREGAS.nombre,
                            PEDIDOS_PROV_DETALLES.dto_ad_prior,
                            PEDIDOS_PROV_DETALLES.iva_id,
                            IVAS.nombre
                        FROM 
                            PEDIDOS_PROV_DETALLES
                        INNER JOIN MATERIALES
                            ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
                        INNER JOIN IVAS
                            ON IVAS.id = PEDIDOS_PROV_DETALLES.iva_id 
                        LEFT JOIN MATERIALES_PRECIOS 
                            ON MATERIALES_PRECIOS.id = PEDIDOS_PROV_DETALLES.material_tarifa_id 
                        LEFT JOIN PROYECTOS 
                            ON PROYECTOS.id = PEDIDOS_PROV_DETALLES.proyecto_id 
                        LEFT JOIN PROVEEDORES_DTO 
                            ON PROVEEDORES_DTO.id = PEDIDOS_PROV_DETALLES.dto_prov_id
                        LEFT JOIN ENTREGAS
                            ON PEDIDOS_PROV_DETALLES.entrega_id = ENTREGAS.id
                        WHERE
                            PEDIDOS_PROV_DETALLES.pedido_id = ".$registros[0]." 
                        ORDER BY 
                            PEDIDOS_PROV_DETALLES.id ASC";

                file_put_contents("array.txt", $sql);
                $res = mysqli_query($connString, $sql) or die("database error:");
                
                $total = 0;
                $importe = 0;
                $totaldto = 0;
                $iva = 0;
                while( $row = mysqli_fetch_array($res) ) {
                    $unidades = $row[4];
                    if ($row[5] != "") {
                        $pvp = $row[5];
                    }
                    else {
                        $pvp = $row[9];
                    }
                    $recibido = $row[6];
                    $dtomat = $row[10];
                    $dto_prov_activo = $row[11];
                    $dto_mat_activo = $row[12];
                    $dto_ad_activo = $row[13];
                    $dtoprov = $row[14];
                    $dtoad = $row[15];
                    $dto_ad_prior = $row[17];
                    $ivaPercent = $row[19];

                    $dto_sum = 0;
                    $pvp_dto = 0;
                    if ($dto_prov_activo == 1) {
                        $dto_sum  = $dto_sum + $dtoprov;
                    }
                    if ($dto_mat_activo == 1) {
                        $dto_sum  = $dto_sum + $dtomat;
                    }
                    if ($dto_ad_activo == 1) {
                        if ($dto_ad_prior == 1) {
                            $dto_extra = $dtoad;
                        }
                        else {
                            $dto_sum  = $dto_sum + $dtoad;
                            $dto_extra = "";
                        }
                    }
                    
                    $subtotal = ($pvp*$unidades);
                    $dto = ($subtotal*$dto_sum)/100;
                    $subtotalDtoApli = $subtotal-$dto;
                    if ($dto_ad_prior == 1) {
                        $dtoNeto = ($subtotalDtoApli*$dto_extra)/100;
                        $subtotalDtoApli = $subtotalDtoApli-$dtoNeto;
                        $dto_extra =  " + ".number_format($dto_extra, 2);
                    }
                    else {
                        $dtoNeto = 0;
                    }
                    
                    $importe = $importe+$subtotal;
                    $totaldto = $totaldto + $dto + $dtoNeto;
                    $iva = $iva + number_format((($subtotal-($dto + $dtoNeto))*$ivaPercent/100),2);
                    
                    //file_put_contents("iva".str_replace("/","-",$registros[11]).".txt", $ivaPercent." ".$subtotal." ".$dto." ".$dtoNeto." ".$ivaPercent." - ".number_format((($subtotal-($dto + $dtoNeto))*$ivaPercent/100),2));
                    //$importe = $importe+$subtotal;
                    //$totaldto = $totaldto + $dto;
                } // while detalles proyecto
                
                $total = $importe + $iva;
                $totalMes = $totalMes + $total;
            }
            array_push($totalesMeses, $totalMes);
        } // For i = 1 to 12

    ?>
    <div id="chart_container" style="height: 250px">
        <canvas id="gastos-mat"></canvas>
    </div>
</div>

<script>
    $( document ).ready(function() {
        var ctx = document.getElementById('gastos-mat');
        
        ctx.heigth = 250;
        
        data = {
            datasets: [{
                data: [<? echo $totalesMeses[0]; ?>, <? echo $totalesMeses[1]; ?>, <? echo $totalesMeses[2]; ?>, <? echo $totalesMeses[3]; ?>, <? echo $totalesMeses[4]; ?>, <? echo $totalesMeses[5]; ?>, <? echo $totalesMeses[6]; ?>, <? echo $totalesMeses[7]; ?>, <? echo $totalesMeses[8]; ?>, <? echo $totalesMeses[9]; ?>, <? echo $totalesMeses[10]; ?>, <? echo $totalesMeses[11]; ?>],
                backgroundColor:["rgba(255, 99, 132, 0.5)","rgba(255, 159, 64, 0.5)","rgba(255, 205, 86, 0.5)","rgba(75, 192, 192, 0.5)","rgba(54, 162, 235, 0.5)","rgba(79, 102, 65, 0.5)","rgba(201, 203, 45, 0.5)" ,"rgba(12, 145, 97, 0.5)" ,"rgba(84, 87, 207, 0.5)" ,"rgba(211, 54, 207, 0.5)" ,"rgba(88, 203, 65, 0.5)" ,"rgba(79, 103, 207, 0.5)"],
                label: 'Gastos de materiales por mes del año <? echo $yearSelected; ?>'
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'            ]
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
                maintainAspectRatio: false,
            }
        });
    });
</script>

<!-- grafico oferta -->