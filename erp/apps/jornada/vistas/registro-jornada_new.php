
<!-- Accesos -->
<table class="table table-striped table-hover" id='tabla-jornada' style="margin: 0px auto 20px auto;">
    <thead>
        <tr class="bg-dark">
        <th class="text-center">DÍA</th>
        <th class="text-center">ACCESOS</th>
        <th class="text-center">H.LABORABLES</th>
        <th class="text-center">H.ORDINARIAS</th>
        <th class="text-center">H.EXTRA</th>
        <th class="text-center">H.VACACIONES</th>
        <th class="text-center">H.MEDICO</th>
        <th class="text-center">H.DEBIDAS</th>
        <th class="text-center">PROYECTO/DONDE</th>
        <th class="text-center">AÑADIR</th>
      </tr>
    </thead>
    <tbody>
<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include_once($pathraiz."/common.php");
    include_once($pathraiz."/connection.php");
    $textoExcel="<table style='border: 1px solid black;' id='tabla-jornada' style='margin: 0px auto 20px auto;'>
    <thead>
        <tr class='bg-dark'>
            <th style='border: 1px solid black;' class='text-center'>DÍA</th>
            <th style='border: 1px solid black;' class='text-center'>ACCESOS</th>
            <th style='border: 1px solid black;' class='text-center'>H.LABORABLES</th>
            <th style='border: 1px solid black;' class='text-center'>H.ORDINARIAS</th>
            <th style='border: 1px solid black;' class='text-center'>H.EXTRA</th>
            <th style='border: 1px solid black;' class='text-center'>H.VACACIONES</th>
            <th style='border: 1px solid black;' class='text-center'>H.MEDICO</th>
            <th style='border: 1px solid black;' class='text-center'>H.DEBIDAS</th>
        </tr>
    </thead>
    <tbody>";
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    
        
    $yearNum = $_GET['year'];
    $monthNum = $_GET['month'];
    $idtrabajador = $_GET['idt'];
    
    
    // LAS HORAS POR CONVENIO AL AÑO SON 1697h pero se cogerá el parámetro de la tabla parametros
        $sql = "SELECT
                    EMPRESAS_CONVENIO.horas_convenio,
                    EMPRESAS_CONVENIO.vacaciones 
                FROM 
                    EMPRESAS_CONVENIO 
                WHERE
                    EMPRESAS_CONVENIO.empresa_id=1 
                AND
                    EMPRESAS_CONVENIO.ano=".$yearNum;
            $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de las horas a trabajar al año1");
            $registros = mysqli_fetch_row($resultado);
            $horasConvenio = $registros[0];
            $vacacionesAno = $registros[1];
    
    // Calculo las horas que hay que trabajar al año sin contar las vacaciones
        $sql = "SELECT 
                    erp_users.nombre, erp_users.apellidos, sum(CALENDARIO.horas)
                FROM 
                    CALENDARIO, JORNADAS, erp_users 
                WHERE 
                    CALENDARIO.id = JORNADAS.calendario_id 
                AND
                    JORNADAS.user_id = erp_users.id 
                AND
                    YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND
                    erp_users.id = ".$idtrabajador."
                GROUP BY 
                    YEAR(CALENDARIO.fecha)";
        file_put_contents("logkk.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las horas a trabajar al año2");
        $registros = mysqli_fetch_row($resultado);
        $horasAtrabajarAno = $registros[0];
    
    // Calculo las horas que hay que trabajar al mes sin contar las vacaciones
        $sql = "SELECT 
                    erp_users.nombre, erp_users.apellidos, sum(CALENDARIO.horas)
                FROM 
                    CALENDARIO, JORNADAS, erp_users 
                WHERE 
                    CALENDARIO.id = JORNADAS.calendario_id 
                AND
                    JORNADAS.user_id = erp_users.id 
                AND
                    YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND 
                    MONTH(CALENDARIO.fecha) = ".$monthNum." 
                AND
                    erp_users.id = ".$idtrabajador."
                GROUP BY 
                    YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las horas a trabajar al mes3");
        $registros = mysqli_fetch_row($resultado);
        $horasAtrabajarMes = $registros[2];
    
    // Calculo las horas que habia que haber trabajado  hasta la fecha
        $sql = "SELECT 
                    erp_users.nombre, erp_users.apellidos, sum(CALENDARIO.horas)
                FROM 
                    CALENDARIO, JORNADAS, erp_users 
                WHERE 
                    CALENDARIO.id = JORNADAS.calendario_id 
                AND
                    JORNADAS.user_id = erp_users.id 
                AND
                    YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND 
                    CALENDARIO.fecha BETWEEN '".$yearNum."-01-01' AND '".date("Y-m-d")."'  
                AND
                    erp_users.id = ".$idtrabajador."
                GROUP BY 
                    YEAR(CALENDARIO.fecha)";
        file_put_contents("queryHorasConvenioHastaHoy.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las horas a trabajar hasta la fecha4");
        $registros = mysqli_fetch_row($resultado);
        $horasAtrabajarHastaHoy = $registros[2];
    
    // Calculo las horas trabajadas hasta la fecha
        $sql = "SELECT
                        SUM(HOUR(TIMEDIFF(JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida)))  AS horas,
                        SUM(MINUTE(TIMEDIFF(JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida))) AS minutos
                FROM
                        JORNADAS, JORNADAS_ACCESOS, CALENDARIO
                WHERE
                        JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                        JORNADAS.calendario_id = CALENDARIO.id
                AND
                        JORNADAS.user_id = ".$idtrabajador."
                AND
                        YEAR( CALENDARIO.fecha ) >= '".$yearNum."-01-01' and YEAR( CALENDARIO.fecha ) <= curdate()
                AND
                        MONTH(CALENDARIO.fecha) <= MONTH( curdate()) 
                AND
                        JORNADAS_ACCESOS.tipo_horas <= 3
                AND 
                        JORNADAS_ACCESOS.hora_salida != '0000-00-00 00:00:00'
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las horas trabajadas hasta la fecha5");
        $registros = mysqli_fetch_row($resultado);
        $horasTrabajadasHastaHoy = $registros[0]+($registros[1]/60); // Puede haber un ligero cambio en cuanto a algunas horas o minutos... 
        
    // Calculo las horas trabajadas en el mes
        $sql = "SELECT
                        SUM(HOUR(TIMEDIFF(JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida)))  AS horas,
                        SUM(MINUTE(TIMEDIFF(JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida))) AS minutos
                FROM
                        JORNADAS, JORNADAS_ACCESOS, CALENDARIO
                WHERE
                        JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                        JORNADAS.calendario_id = CALENDARIO.id
                AND
                        JORNADAS.user_id = ".$idtrabajador."
                AND
                        MONTH(CALENDARIO.fecha) = ".$monthNum."
                AND
                        YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND
                        JORNADAS_ACCESOS.tipo_horas <= 2
                AND 
                        JORNADAS_ACCESOS.hora_salida != '0000-00-00 00:00:00'
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las horas trabajadas en el mes6");
        $registros = mysqli_fetch_row($resultado);
        $horasTrabajadasMes = $registros[0]+($registros[1]/60);
        
    // Calculo las vacaciones disfrutadas este mes
        $sql = "SELECT
                        sum(TIMESTAMPDIFF(HOUR, JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida)) as horas_trabajadas
                FROM
                        JORNADAS, JORNADAS_ACCESOS, CALENDARIO
                WHERE
                        JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                        JORNADAS.calendario_id = CALENDARIO.id
                AND
                        JORNADAS.user_id = ".$idtrabajador."
                AND
                        MONTH(CALENDARIO.fecha) = ".$monthNum."
                AND
                        YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND
                        JORNADAS_ACCESOS.tipo_horas = 3
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las vacaciones disfrutadas de este mes");
        $registros = mysqli_fetch_row($resultado);
        $horasVacacionesMes = $registros[0];
        // Sumar con las horas trabajadas:
        $horasTrabajadasMes = $horasTrabajadasMes+$horasVacacionesMes;
        
    // Calculo las vacaciones disfrutadas hasta la fecha
        $sql = "SELECT
                        sum(TIMESTAMPDIFF(HOUR, JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida)) as horas_trabajadas
                FROM
                        JORNADAS, JORNADAS_ACCESOS, CALENDARIO
                WHERE
                        JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                        JORNADAS.calendario_id = CALENDARIO.id
                AND
                        JORNADAS.user_id = ".$idtrabajador."
                AND
                        CALENDARIO.fecha >= '".$yearNum."-01-01'
                AND
                        CALENDARIO.fecha <= '".$yearNum."-12-31'
                AND
                        JORNADAS_ACCESOS.tipo_horas = 3
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las vacaciones disfrutadas hasta la fecha");
        $registros = mysqli_fetch_row($resultado);
        $horasVacacionesHastaHoy = $registros[0];
        
    // Calculo las horas en médico este mes
        $sql = "SELECT
                        sum(TIMESTAMPDIFF(HOUR, JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida)) as horas_trabajadas
                FROM
                        JORNADAS, JORNADAS_ACCESOS, CALENDARIO
                WHERE
                        JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                        JORNADAS.calendario_id = CALENDARIO.id
                AND
                        JORNADAS.user_id = ".$idtrabajador."
                AND
                        MONTH(CALENDARIO.fecha) = ".$monthNum."
                AND
                        JORNADAS_ACCESOS.tipo_horas = 2
                AND
                        CALENDARIO.fecha >= '".$yearNum."-01-01'
                AND
                        CALENDARIO.fecha <= '".$yearNum."-12-31'
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de las horas de médico de este mes");
        $registros = mysqli_fetch_row($resultado);
        $horasMedicoMes = $registros[0];
        
    // Calculo las horas de medico hasta la fecha
        $sql = "SELECT
                        sum(TIMESTAMPDIFF(HOUR, JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida)) as horas_trabajadas
                FROM
                        JORNADAS, JORNADAS_ACCESOS, CALENDARIO
                WHERE
                        JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                        JORNADAS.calendario_id = CALENDARIO.id
                AND
                        JORNADAS.user_id = ".$idtrabajador."
                AND
                        CALENDARIO.fecha >= '".$yearNum."-01-01'
                AND
                        CALENDARIO.fecha <= '".$yearNum."-12-31'
                AND
                        JORNADAS_ACCESOS.tipo_horas = 2
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de las horas de medico hasta la fecha");
        $registros = mysqli_fetch_row($resultado);
        $horasMedicoTotal = $registros[0];
        
        // Saco las horas a trabajar por convenio hasta hoy sin tener en cuenta el calendario: (diasTranscurridos*horasConvenioAño)/diasDelAño
            $startTimeStamp = strtotime(date("Y")."/01/01");
            $endTimeStamp = strtotime(date("Y/m/d"));
            $timeDiff = abs($endTimeStamp - $startTimeStamp);
            $numeroDias = $timeDiff/86400;  // 86400 seconds in one day
            $numeroDias = intval($numeroDias);

            function cal_days_in_year($year){
                $days=0; 
                for($month=1;$month<=12;$month++){ 
                    $days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
                 }
             return $days;
            }
            $numeroDiasAño = cal_days_in_year(date("yy"));

            $horasConvenioHastaHoy = ($numeroDias*$horasConvenio)/$numeroDiasAño;
            if($yearNum!=date("Y")){
                $horasConvenioHastaHoy = 0;
            }
    
        $sql = "SELECT 
                    CALENDARIO.id,
                    CALENDARIO.fecha, 
                    CALENDARIO.horas,
                    erp_users.nombre,
                    JORNADAS.id,
                    erp_users.firma_path,
                    CALENDARIO.festivo,
                    CALENDARIO.tipo_jornada,
                    JORNADAS.proyecto_id,
                    PROYECTOS.nombre 
                FROM 
                    CALENDARIO, JORNADAS, erp_users, PROYECTOS
                WHERE 
                    CALENDARIO.id = JORNADAS.calendario_id 
                AND
                    JORNADAS.user_id = erp_users.id 
                AND 
                    MONTH(CALENDARIO.fecha) = ".$monthNum." 
                AND 
                    YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND
                    erp_users.id = ".$idtrabajador."
                AND
                    JORNADAS.proyecto_id=PROYECTOS.id
                ORDER BY 
                    CALENDARIO.fecha ASC";
    
    file_put_contents("queryCalendario.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del Calendario");
    
    $horasOrdinariasMes = 0;
    $horasExtraMes = 0;
    $horasjornadaMes = 0;
    while ($registros = mysqli_fetch_array($resultado)) { 
        $horasJornada = $registros[2];
        $horasjornadaMes = ($horasjornadaMes + $horasJornada);
        if ($registros[6] == 1) {
            $festivo = "class='danger'";
        }elseif($registros[6] == 2) {
            $festivo = "class='warning'";
        }elseif($registros[6] == 3) {
            $festivo = "class='success'";
        }else{
            $festivo = "";
        }
        if ($registros[7] == 2) {
            $festivo = "class='info'";
        }
        if ($date = date('Y-m-d', time()) == $registros[1]) {
            $festivo = "class='bg-second2'";
        }
        $textoExcel.= "
            <tr ".$festivo." data-id='".$registros[0]."'>
                <td>".$registros[1]."</td> 
                <td>";
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
        file_put_contents("queryAccesos1.txt", $sql);
        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de los Accesos");
        $firma = "";
        if (mysqli_num_rows($resultado2) > 0) {
            if ($registros[5] != "") {
                $firma = "<img src='".$registros[5]."' style='max-height: 80px; max-width:80px; height: 70px;'>";
            }
            else {
                $firma = "";
            }
            /*
            echo "<table class='table table-striped table-hover tabla-detalles-acceso' style='margin-bottom: 5px !important;'>
                    <thead>";
             */
            $horasTotales = 0;
            $horasExtra = 0;
            $horasVacaciones = 0;
            $horasMedico = 0;
            $horasDebidas = 0;
            $testVacacionesDiaCompleto = 0;
            $tablaDias = "<table class='table table-striped table-hover tabla-detalles-acceso' style='margin-bottom: 5px !important;'>
                            <thead>";
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
                    $testVacacionesDiaCompleto = $testVacacionesDiaCompleto + 1;
                }
                if ($tipo_horas == 4) {
                    $estilo = "class='success'";
                    //$horasregularizadas = $horasregularizadas + 1;
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
                        if (($fecha1->format('H') >= "14") && ($testVacacionesDiaCompleto <= 1)) {
                            $estilo = "class='info-warning'";
                        }else{
                            if ($testVacacionesDiaCompleto > 1) {
                                $estilo = "class='success'";
                                $tablaDias = str_replace("warning-info","success",$tablaDias);
                            }else {
                                $estilo = "class='warning-info'";
                            }
                        }
                        $horasVacaciones = ($horasVacaciones + $hours);
                    }
                }
                $tablaDias .= "
                        <tr ".$estilo." data-id='".$registros2[0]."'>
                            <td style='text-align:center;'><strong>E:</strong> ".$fecha1->format('H:i')." <strong>S:</strong> ".$fecha2->format('H:i')."</td> 
                        </tr>";
                //$intervalo->format('H');// horas de diferencia entre las dos fechas
                //$horasTotales = $horasTotales + $intervalo;
            } // fin del while de los accesos por dia
            $tablaDias .= "  </thead> 
                  </table>";
            echo $tablaDias;
            $textoExcel.=$tablaDias;
        }else{
            $horasTotales = 0;
            $horasVacaciones = 0;
            $horasMedico = 0;
            $horasDebidas = 0;
        }
            
        if ($horasTotales > $horasJornada) {
            $horasExtra = ($horasTotales - $horasJornada);
            $horasTotales = $horasJornada;
            $horasDebidas = 0;
        }else {
            $horasExtra = 0;
            if ($registros[1] > date("Y-m-d")) {
                $horasDebidas = 0;
            }else{
                $horasDebidas = $horasJornada - ($horasTotales + $horasExtra + $horasVacaciones);
            }
            
        }
        $horasOrdinariasMes = ($horasOrdinariasMes + $horasTotales);
        $horasExtraMes = ($horasExtraMes + $horasExtra);
        $horasDebidasMes = ($horasDebidasMes + $horasDebidas);
        $horasVacMes = ($horasVacMes + $horasVacaciones);
        $horasMedMes = ($horasMedMes + $horasMedico);
        $horasDebMes = ($horasDebMes + $horasDebidas);
        
        $horasTotalesTime = decimal2hours($horasTotales);
        
        if($festivo == "class='danger'"){
            $txtproyectojornada="";
        }else{
            $txtproyectojornada=$registros[9];
        }
        
        $textoExcel.="  </td>
                <td class='text-center'>".decimal2hours($horasJornada)."h</td>
                <td class='text-center'>".decimal2hours($horasTotales)."h</td>
                <td class='text-center'>".decimal2hours($horasExtra)."h</td>
                <td class='text-center'>".decimal2hours($horasVacaciones)."h</td>
                <td class='text-center'>".decimal2hours($horasMedico)."h</td>
                <td class='text-center'>".decimal2hours($horasDebidas)."h</td>
            </tr>
        ";
        echo "  </td>
                <td class='text-center'>".decimal2hours($horasJornada)."h</td>
                <td class='text-center'>".decimal2hours($horasTotales)."h</td>
                <td class='text-center'>".decimal2hours($horasExtra)."h</td>
                <td class='text-center'>".decimal2hours($horasVacaciones)."h</td>
                <td class='text-center'>".decimal2hours($horasMedico)."h</td>
                <td class='text-center'>".decimal2hours($horasDebidas)."h</td>
                <td class='text-center proyecto_jornada_td'>
                    <label class='proyecto_jornada' data-text='".$registros[9]."' data-id='".$registros[8]."'>".$txtproyectojornada."</label>
                </td>
                <td>
                    <div class='form-group form-group-tools'>
                        <button class='button add-acceso btn-default' data-jornadaid='".$registros[4]."' data-fecha='".$registros[1]."'><img src='/erp/img/add.png' height='30' title='Insertar Acceso'></button>
                        <button class='button add-autoacceso btn-default' data-jornadaid='".$registros[4]."' data-tipojornada='".$registros[7]."' data-fecha='".$registros[1]."' title='Jornada Automática'><strong>A</strong></button>
                        <button class='button add-autovacaciones btn-success' data-jornadaid='".$registros[4]."' data-tipojornada='".$registros[7]."' data-fecha='".$registros[1]."' title='Jornada Vacaciones'><strong>V</strong></button>
                        <button class='button add-automedico' data-jornadaid='".$registros[4]."' data-tipojornada='".$registros[7]."' data-fecha='".$registros[1]."' title='Jornada Médico'><strong>M</strong></button>
                    </div>
                </td>
            </tr>
        ";
    } // fin del while de los dias
    /*************************/
    $sql = "SELECT
                        SUM(HOUR(TIMEDIFF(JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida)))  AS horas,
                        SUM(MINUTE(TIMEDIFF(JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida))) AS minutos
                FROM
                        JORNADAS, JORNADAS_ACCESOS, CALENDARIO
                WHERE
                        JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                        JORNADAS.calendario_id = CALENDARIO.id
                AND
                        JORNADAS.user_id = ".$idtrabajador."
                AND
                        MONTH(CALENDARIO.fecha) = ".$monthNum."
                AND
                        YEAR(CALENDARIO.fecha) = ".$yearNum."
                AND
                        JORNADAS_ACCESOS.tipo_horas = 4
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de las horas trabajadas en el mes");
    $registros = mysqli_fetch_row($resultado);
    $horasRegularizadasMes = $registros[0]+($registros[1]/60);
    
    $sql = "SELECT
                        SUM(HOUR(TIMEDIFF(JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida)))  AS horas,
                        SUM(MINUTE(TIMEDIFF(JORNADAS_ACCESOS.hora_entrada, JORNADAS_ACCESOS.hora_salida))) AS minutos
                FROM
                        JORNADAS, JORNADAS_ACCESOS, CALENDARIO
                WHERE
                        JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                        JORNADAS.calendario_id = CALENDARIO.id
                AND
                        JORNADAS.user_id = ".$idtrabajador."
                AND
                        CALENDARIO.fecha >= '".$yearNum."-01-01'
                AND
                        CALENDARIO.fecha <= '".$yearNum."-12-31'
                AND
                        JORNADAS_ACCESOS.tipo_horas = 4
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las vacaciones disfrutadas hasta la fecha");
        $registros = mysqli_fetch_row($resultado);
        $horasRegularizadasHastaHoy = $registros[0];
    
    $saldo = $horasExtraMes - $horasDebMes;
    $textoExcel.="</tbody></table>
        <br>
    <table style='border: 1px solid black;'>
    <tr style='border: 1px solid black;'>
        <td>H.CALENDARIO EN EL MES:</td>
        <td>".intval($horasAtrabajarMes)."h</td>
    </tr>
    <tr style='border: 1px solid black;'>
        <td>H.CALENDARIO HASTA HOY:</td>
        <td>".intval($horasAtrabajarHastaHoy)."h</td>
    </tr>
    <tr style='border: 1px solid black;'>
        <td>H.CONVENIO HASTA HOY:</td>
        <td>".intval($horasConvenioHastaHoy)."h</td>
    </tr>
    <tr style='border: 1px solid black;'>
        <td>H.VACACIONES DISFRUTADAS:</td>
        <td>".intval($horasVacacionesHastaHoy)."h</td>
    </tr>
    <tr style='border: 1px solid black;'>
        <td>H.TRABAJADAS/MES:</td>
        <td>".intval($horasTrabajadasMes)."h</td>
    </tr>
    <tr style='border: 1px solid black;'>
        <td>H. TRABAJADAS HASTA HOY:</td>
        <td>".intval($horasTrabajadasHastaHoy)."h</td>
    </tr>
    <!--
    <tr style='border: 1px solid black;'>
        <td>H. REGULARIZADAS/MES:</td>
        <td>".intval($horasRegularizadasMes)."h</td>
    </tr>
    <tr style='border: 1px solid black;'>
        <td>H. REGULARIZADAS HASTA HOY:</td>
        <td>".intval($horasRegularizadasHastaHoy)."h</td>
    </tr>
    -->
    <tr style='background-color:#adadad; border: 1px solid black;'>
        <td>H. CONVENIO/AÑO:</td>
        <td>".intval($horasConvenio)."h</td>
    </tr>
    <tr style='background-color:#adadad; border: 1px solid black;'>
        <td>DIAS-H.VACACIONES/AÑO:</td>
        <td>".intval($vacacionesAno).'-'.intval($vacacionesAno*8)."</td>
    </tr>
    <tr style='background-color:#adadad; border: 1px solid black;'>
        <td>HORAS EXTRA TOTALES:</td>
        <td>".intval($saldo_horas)."h</td>
    </tr>
</table>";

    
    
    file_put_contents("exportarExcelMesPropio.txt", $textoExcel);
    // El saldo de horas según calendario se calcula restándole a las horas segun calendario hasta hoy las trabajadas - las vacaciones disfrutadas
    //$saldo_horas = ($horasTrabajadasHastaHoy + $horasVacacionesHastaHoy) - $horasAtrabajarHastaHoy - $horasRegularizadasHastaHoy;
    $saldo_horas = $horasTrabajadasHastaHoy - $horasAtrabajarHastaHoy;
    
    
    /////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////// Descripciones de las Horas //////////////////////////////
    $descHCalendarioMes="Horas a trabajar este més";
    $descHCalendarioHastaHoy="Sumatorio de horas a trabajar hasta hoy";
    $descHConvenioHastaHoy="Más o menos cuantas horas hay que ir trabajadas hasta hoy";
    $descHConvenioAño="Horas a trabajar según el convenio del año ".$yearNum;
    $descHTrabajadasMes="Horas imputadas en el sistema este mes";
    $descHTabajadasHastaHoy="Horas totales imputadas en el sistema";
    $descHRegularizadasMes="Horas regularizadas este mes";
    $descHRegularizadasHastaHoy="Horas regularizadas totales este mes";
    $descHVacacionesMes="Horas de las vacaciones disfrutadas este mes";
    $descHVacacionesDisfrutadas="Horas de Vacaciones disfrutadas totales";
    $descDHVacacionesAño="Días/Horas a distrutar durante todo el año";
    $descBolsaHorasCalendario="Balance de horas debidas u horas extra";
    $descHMedicoMes="Horas de Médico este mes";
    $descHMedicoTotales="Horas totales de medico hasta ahora";
    /////////////////////////////////////////////////////////////////////////////////////////
    
    
    function decimal2hours($decimal) {
        $decimalParts = explode(".", $decimal);
        $hours2 = "0.".$decimalParts[1];
        $hours2time = round((double)$hours2*60);
        $hours1 = $decimalParts[0];
        $hours = sprintf("%02d", $hours1).":".sprintf("%02d", $hours2time);
        return $hours;
    }
    
?>
    </tbody>
</table>



<div class="row pvp_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHCalendarioMes ?>">H.CALENDARIO EN EL MES: </label> <label id='horas_mes' class="precio_right_vistas"> <? echo intval($horasAtrabajarMes); ?> h</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHCalendarioHastaHoy ?>">H.CALENDARIO HASTA HOY: </label> <label id='horas_calendario_hasta_hoy' class="precio_right_vistas"> <? echo intval($horasAtrabajarHastaHoy); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHConvenioHastaHoy ?>">H.CONVENIO HASTA HOY: </label> <label id='horas_convenio_hasta_hoy' class="precio_right_vistas"> <? echo intval($horasConvenioHastaHoy); ?> h</label></div>
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas' title="<? echo $descHConvenioAño ?>">H. CONVENIO/AÑO: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo intval($horasConvenio); ?> h</label></div>
    
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHTrabajadasMes ?>">H.TRABAJADAS/MES: </label> <label id='horas_trabajadas_mes' class="precio_right_vistas"> <? echo intval($horasTrabajadasMes); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHTabajadasHastaHoy ?>">H. TRABAJADAS HASTA HOY: </label> <label id='horas_trabajadas_hasta_hoy' class="precio_right_vistas"> <? echo intval($horasTrabajadasHastaHoy); ?> h</label></div>
    <!-- No hay regularizaciones
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHRegularizadasMes ?>">H. REGULARIZADAS/MES: </label> <label id='horas_trabajadas_hasta_hoy' class="precio_right_vistas"> <? echo intval($horasRegularizadasMes); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHRegularizadasHastaHoy ?>">H. REGULARIZADAS HASTA HOY: </label> <label id='horas_trabajadas_hasta_hoy' class="precio_right_vistas"> <? echo intval($horasRegularizadasHastaHoy); ?> h</label></div>
    -->
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHVacacionesMes ?>">H.VACACIONES MES: </label> <label id='horas_vacaciones_mes' class="precio_right_vistas"> <? echo intval($horasVacacionesMes); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHVacacionesDisfrutadas ?>">H.VACACIONES DISFRUTADAS: </label> <label id='horas_vacaciones_disfuratadas' class="precio_right_vistas"> <? echo intval($horasVacacionesHastaHoy); ?> h</label></div>
    
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHMedicoMes ?>">H.MEDICO MES: </label> <label id='horas_medico_mes' class="precio_right_vistas"> <? echo intval($horasMedicoMes); ?> h</label></div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas' title="<? echo $descHMedicoTotales ?>">H.MEDICO TOTALES: </label> <label id='horas_medico_total' class="precio_right_vistas"> <? echo intval($horasMedicoTotal); ?> h</label></div>
    <!--<div class="col-sm-3" style="background-color: #000000; height: 30px;"><label class='viewTitle resumen-title-vistas' title=""> </label> <label id='' class="precio_right_total_vistas"></label></div>-->
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas' title="<? echo $descBolsaHorasCalendario ?>">HORAS EXTRA TOTALES: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo round($saldo_horas); ?> h</label></div>
    <div class="col-sm-3" style="background-color: #000000;"><label class='viewTitle resumen-title-vistas' title="<? echo $descDHVacacionesAño ?>">DIAS-H.VACACIONES/AÑO: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo intval($vacacionesAno)."-".intval($vacacionesAno*8); ?></label></div>
    
    
    
</div>




