<!-- Accesos -->

<?
    if ($_GET['year']) {
        $yearNum = $_GET['year'];
    }
    else {
        $yearNum  = date('Y');
    }

    if ($_GET['mes']) {
        $monthNum = $_GET['mes'];
    }
    else {
        $monthNum  = date('m');
    }
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F'); // March
?>

<table class="table table-striped table-hover table-condensed" id='tabla-jornada' style="margin: 0px auto 20px auto; font-size: 9px !important;">
    <thead>
      <tr>
        <th class="text-center">DÍA</th>
        <th class="text-center">ACCESOS</th>
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
                    CALENDARIO.id,
                    CALENDARIO.fecha, 
                    CALENDARIO.horas,
                    erp_users.nombre,
                    JORNADAS.id,
                    erp_users.firma_path,
                    CALENDARIO.festivo,
                    CALENDARIO.tipo_jornada 
                FROM 
                    CALENDARIO, JORNADAS, erp_users 
                WHERE 
                    CALENDARIO.id = JORNADAS.calendario_id 
                AND
                    JORNADAS.user_id = erp_users.id 
                AND 
                    MONTH(CALENDARIO.fecha) = ".$monthNum." 
                AND 
                    YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND
                    erp_users.id = ".$_SESSION['user_session']." 
                ORDER BY 
                    CALENDARIO.fecha ASC";
    
    //file_put_contents("queryCalendario.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Calendario");
    
    $horasOrdinariasMes = 0;
    $horasExtraMes = 0;
    $horasjornadaMes = 0;
    while ($registros = mysqli_fetch_array($resultado)) { 
        $horasJornada = $registros[2];
        $horasjornadaMes = ($horasjornadaMes + $horasJornada);
        if ($registros[6] == 1) {
            $festivo = "class='danger'";
        }
        else {
            $festivo = "";
        }
        if ($registros[7] == 2) {
            $festivo = "class='info'";
        }
        if ($date = date('Y-m-d', time()) == $registros[1]) {
            $festivo = "class='success'";
        }
        echo "
            <tr ".$festivo." data-id='".$registros[0]."'>
                <td>".$registros[1]."</td> 
                <td>";
        
        $sql = "SELECT 
                    JORNADAS_ACCESOS.id,
                    JORNADAS_ACCESOS.hora_entrada, 
                    JORNADAS_ACCESOS.hora_salida,
                    JORNADAS_ACCESOS.tipo_horas 
                FROM 
                    JORNADAS, JORNADAS_ACCESOS  
                WHERE 
                    JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                    JORNADAS.id = ".$registros[4]."
                ORDER BY 
                    JORNADAS_ACCESOS.hora_entrada ASC";
        //file_put_contents("queryAccesos.txt", $sql);
        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de los Accesos");
        $firma = "";
        if (mysqli_num_rows($resultado2) > 0) {
            if ($registros[5] != "") {
                $firma = "<img src='".$registros[5]."' style='max-height: 80px; max-width:80px; height: 70px;'>";
            }
            else {
                $firma = "";
            }
            echo "<table class='table table-striped table-hover tabla-detalles-acceso' style='margin-bottom: 5px !important;'>
                    <thead>";
            $horasTotales = 0;
            $horasExtra = 0;
            $horasVacaciones = 0;
            $horasMedico = 0;
            $horasDebidas = 0;
            while ($registros2 = mysqli_fetch_array($resultado2)) { 
                $tipo_horas = $registros2[3];
                $fecha1 = new DateTime($registros2[1]);//fecha inicial
                if (($registros2[1] != "0000-00-00 00:00:00") && ($registros2[2] != "0000-00-00 00:00:00")) {
                    $estilo = "class='info'";
                } 
                else {
                    $estilo = "class='danger'";
                }
                if ($tipo_horas == 2) {
                    $estilo = "class='active'";
                }
                if ($tipo_horas == 3) {
                    $estilo = "class='warning'";
                }
                
                $fecha2 = new DateTime($registros2[2]);//fecha de cierre
                if ($registros2[2] != "0000-00-00 00:00:00") {
                    $intervalo = $fecha1->diff($fecha2);
                    $hours = round($intervalo->s / 3600 + $intervalo->i / 60 + $intervalo->h + $intervalo->days * 24, 2);
                    if (($tipo_horas == 1) || ($tipo_horas == 2)) {
                        $horasTotales = ($horasTotales + $hours);
                    }
                    if ($tipo_horas == 2) {
                        $horasMedico = ($horasMedico + $hours);
                    }
                    if ($tipo_horas == 3) {
                        $horasVacaciones = ($horasVacaciones + $hours);
                    }
                }
                echo "
                        <tr ".$estilo." data-id='".$registros2[0]."'>
                            <td style='text-align:center;'><strong>E:</strong> ".$fecha1->format('H:i')." <strong>S:</strong> ".$fecha2->format('H:i')."</td> 
                        </tr>";
                //$intervalo->format('H');// horas de diferencia entre las dos fechas
                //$horasTotales = $horasTotales + $intervalo;
            }
            echo "  </thead> 
                  </table>";
        }
        else {
            $horasTotales = 0;
            $horasVacaciones = 0;
            $horasMedico = 0;
            $horasDebidas = 0;
        }
            
        if ($horasTotales > $horasJornada) {
            $horasExtra = ($horasTotales - $horasJornada);
            $horasTotales = $horasJornada;
            $horasDebidas = 0;
        }
        else {
            $horasExtra = 0;
            if ($registros[1] > date("Y-m-d")) {
                $horasDebidas = 0;
            }
            else {
                if ($horasVacaciones == $horasJornada) {
                    $horasDebidas = 0;
                }
                else {
                    $horasDebidas = $horasJornada - ($horasTotales + $horasExtra);
                }
            }
            
        }
        $horasOrdinariasMes = ($horasOrdinariasMes + $horasTotales);
        $horasExtraMes = ($horasExtraMes + $horasExtra);
        $horasDebidasMes = ($horasDebidasMes + $horasDebidas);
        $horasVacMes = ($horasVacMes + $horasVacaciones);
        $horasMedMes = ($horasMedMes + $horasMedico);
        $horasDebMes = ($horasDebMes + $horasDebidas);
        
        $horasTotalesTime = decimal2hours($horasTotales);
        
        
        echo "  </td>
            </tr>
        ";
    }
    $saldo = $horasExtraMes - $horasDebMes;
    
?>
    </tbody>
</table>

