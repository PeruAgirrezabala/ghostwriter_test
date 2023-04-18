<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    
    function horasCalendarioMes($year,$month,$idtrabajador){
        $db = new dbObj();
        $connString =  $db->getConnstring();
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
                    YEAR(CALENDARIO.fecha) = ".$year."
                AND 
                    MONTH(CALENDARIO.fecha) = ".$month." 
                AND
                    erp_users.id = ".$idtrabajador."
                GROUP BY 
                    YEAR(CALENDARIO.fecha)";
        file_put_contents("selectcalendariomeshoras.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las horas calendario mes");
        return $registros = mysqli_fetch_row($resultado);
        //$horasAtrabajarMes = $registros[2];
    }
    function horasTrabajadasMes($year,$month,$idtrabajador){
        $db = new dbObj();
        $connString =  $db->getConnstring();
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
                        MONTH(CALENDARIO.fecha) = ".$month."
                AND
                        YEAR(CALENDARIO.fecha) = ".$year."
                AND
                        JORNADAS_ACCESOS.tipo_horas <= 2
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de las horas trabajadas en el mes");
        return $registros = mysqli_fetch_row($resultado);
        //$horasTrabajadasMes = $registros[0]+($registros[1]/60);
    }
    function horasTrabajadasHastaHoy($yearNum,$idtrabajador){
        $db = new dbObj();
        $connString =  $db->getConnstring();
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
                        JORNADAS_ACCESOS.tipo_horas <= 2
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las horas trabajadas hasta la fecha");
        return $registros = mysqli_fetch_row($resultado);
        //$horasTrabajadasHastaHoy = $registros[0]+($registros[1]/60);
    }
    function horasRegularizadasHastaHoy($yearNum,$idtrabajador){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
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
                        YEAR(CALENDARIO.fecha) BETWEEN ".$yearNum."-01-01 AND now()
                AND
                        JORNADAS_ACCESOS.tipo_horas = 4
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las vacaciones disfrutadas hasta la fecha");
        return $registros = mysqli_fetch_row($resultado);
        //$horasRegularizadasHastaHoy = $registros[0];
    }
    function horasRegularizadasMes($yearNum,$monthNum,$idtrabajador){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
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
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las horas regularizadas en el mes");
        return $registros = mysqli_fetch_row($resultado);
        //$horasRegularizadasMes = $registros[0]+($registros[1]/60);
    }
    function horasVacacionesHastaHoy($yearNum,$idtrabajador){
        $db = new dbObj();
        $connString =  $db->getConnstring();
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
                        YEAR(CALENDARIO.fecha) BETWEEN ".$yearNum."-01-01 AND now()
                AND
                        JORNADAS_ACCESOS.tipo_horas = 3
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las vacaciones disfrutadas hasta la fecha");
        return $registros = mysqli_fetch_row($resultado);
        //$horasVacacionesHastaHoy = $registros[0];
    }
    function horasVacacionesEsteMes($yearNum,$monthNum,$idtrabajador){
        $db = new dbObj();
        $connString =  $db->getConnstring();
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
                        MONTH(CALENDARIO.fecha) = ".$monthNum."
                AND
                        YEAR(CALENDARIO.fecha) BETWEEN ".$yearNum."-01-01 AND now()
                AND
                        JORNADAS_ACCESOS.tipo_horas = 3
                GROUP BY
                        YEAR(CALENDARIO.fecha)";
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de las vacaciones disfrutadas hasta la fecha");
        return$registros = mysqli_fetch_row($resultado);
        //$horasVacacionesHastaHoy = $registros[0];
    }

?>