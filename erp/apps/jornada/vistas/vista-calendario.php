<table class="table table-striped table-hover" id='tabla-vacaciones' style="margin: 0px auto 20px auto;">
    <tbody>
        <tr><td class="text-left" colspan="100%"><strong>Enero</strong></td></tr>
        <tr>
            <?
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");

                $db = new dbObj();
                $connString =  $db->getConnstring();
                
                $yearNum = $_GET['yearNum'];
                
                // SELECT DISTINCT
                $sql = "SELECT
                                CALENDARIO.id,
                                CALENDARIO.fecha, 
                                CALENDARIO.festivo,
                                CALENDARIO.tipo_jornada, 
                                MONTH(CALENDARIO.fecha),
                                DAY(CALENDARIO.fecha)
                            FROM 
                                CALENDARIO 
                            WHERE 
                                YEAR(CALENDARIO.fecha) = ".$yearNum."
                            ORDER BY 
                                CALENDARIO.fecha ASC";

                file_put_contents("queryCalendario.txt", $sql);
                $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Calendario de Vacaciones");

                $ultimoMes = 0;
                $ultimaFecha = "";
                while ($registros = mysqli_fetch_array($resultado)) { 
                    if (($ultimoMes == $registros[4]) || ($ultimoMes == 0)) {
                        if ($registros[2] == 1) {
                            $festivo = " danger ";
                        }
                        else {
                            $festivo = "";
                        }
                        if (($ultimaFecha == $registros[1]) || ($ultimaFecha = "")) {
                            // Solo pintaria colores
                        }else{
                            echo "</td><td class='text-center ".$festivo."'>".$registros[5]."";
                        }

                        // Ahora consulto la gente que está de vacaciones. Por cada día
                        $sql = "SELECT 
                                    JORNADAS_ACCESOS.id,
                                    JORNADAS_ACCESOS.hora_entrada, 
                                    JORNADAS_ACCESOS.hora_salida,
                                    JORNADAS_ACCESOS.tipo_horas,
                                    erp_users.color, 
                                    erp_users.nombre, 
                                    erp_users.apellidos,
                                    erp_users.avatar,
                                    erp_users.id
                                FROM 
                                    JORNADAS, JORNADAS_ACCESOS, erp_users   
                                WHERE 
                                    JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                                AND 
                                    JORNADAS.user_id = erp_users.id 
                                AND
                                    JORNADAS.calendario_id = ".$registros[0]."
                                AND 
                                    JORNADAS_ACCESOS.tipo_horas = 3 
                                GROUP BY 
                                    JORNADAS.id
                                ORDER BY 
                                    JORNADAS_ACCESOS.hora_entrada ASC";
                        file_put_contents("queryAccesos1.txt", $sql);
                        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de los Días de Vacaciones");
                        if (mysqli_num_rows($resultado2) > 0) {
                            while ($registros2 = mysqli_fetch_array($resultado2)) { 
                                $iconoAvatar="";
                                file_put_contents("androides.txt",$registros2);
                                if(($registros2[7]!="")&&($registros2[7]!="NULL")){
                                    $iconoAvatar ='<img class="imguser_'.$registros2[8].'" style="max-height:20px !important; max-width:20px !important" src="/erp/img/avatares/'.$registros2[7].'">';
                                    echo "<div class='vacacionesCuadro' style='background-color:".$registros2[4]."' title='".$registros2[5]." ".$registros2[6]." ".$registros[1]."'>".$iconoAvatar."</div>";
                            
                                }else{
                                    file_put_contents("route1.txt",$registros2[7]);
                                    $iconoAvatardefault ='<img class="imguser_'.$registros2[8].'" style="max-height:20px !important; max-width:20px !important" src="../../img/avatares/default.png">';
                                    echo "<div class='vacacionesCuadro' style='background-color:".$registros2[4]."' title='".$registros2[5]." ".$registros2[6]." ".$registros[1]."'>".$iconoAvatardefault."</div>";
                                }
                            }
                        }
                    }else{
                        echo "</tr>";
                        $dateObj   = DateTime::createFromFormat('!m', $registros[4]);
                        $monthName = $dateObj->format('F'); // March
                        $nombreMes = nombreMes($monthName);
                        echo "<tr><td colspan='100%' class='text-left'><strong>".$nombreMes."</strong></td></tr>";
                        if ($registros[2] == 1) {
                            $festivo = " danger ";
                        }
                        else {
                            $festivo = "";
                        }
                        if (($ultimaFecha == $registros[1]) || ($ultimaFecha = "")) {
                            // Solo pintaria colores
                        }else{
                            echo "</td><td class='text-center ".$festivo."'>".$registros[5];
                        }
                        if(strlen($registros[4])==1){
                            $mes="0".$registros[4];
                        }else{
                            $mes=$registros[4];
                        }
                        // Ahora consulto la gente que está de vacaciones
                        $sql = "SELECT 
                                    JORNADAS_ACCESOS.id,
                                    JORNADAS_ACCESOS.hora_entrada, 
                                    JORNADAS_ACCESOS.hora_salida,
                                    JORNADAS_ACCESOS.tipo_horas,
                                    erp_users.color, 
                                    erp_users.nombre, 
                                    erp_users.apellidos
                                FROM 
                                    JORNADAS, JORNADAS_ACCESOS, erp_users   
                                WHERE 
                                    JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                                AND 
                                    JORNADAS.user_id = erp_users.id 
                                AND 
                                    JORNADAS_ACCESOS.tipo_horas = 3 
				AND
                                    JORNADAS_ACCESOS.hora_entrada like '%".$yearNum."-".$mes."-0".$registros[5]."%'
                                GROUP BY 
                                    JORNADAS.id
                                ORDER BY 
                                    JORNADAS_ACCESOS.hora_entrada ASC";
                        file_put_contents("queryAccesos2.txt", $sql);
                        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de los Días de Vacaciones");
                        if (mysqli_num_rows($resultado2) > 0) {
                            while ($registros2 = mysqli_fetch_array($resultado2)) { 
                                $iconoAvatar="";
                                if(($registros2[7]!="")&&($registros2[7]!="NULL")){
                                    $iconoAvatar ='<img class="imguser_'.$registros2[8].'" style="max-height:20px !important; max-width:20px !important" src="/erp/img/avatares/'.$registros2[7].'">';
                                    echo "<div class='vacacionesCuadro' style='background-color:".$registros2[4]."' title='".$registros2[5]." ".$registros2[6]." ".$registros[1]."'>".$iconoAvatar."</div>";
                            
                                }else{

                                    $iconoAvatardefault ='<img class="imguser_'.$registros2[8].'" style="max-height:20px !important; max-width:20px !important" src="../../img/avatares/default.png">';
                                    echo "<div class='vacacionesCuadro' style='background-color:".$registros2[4]."' title='".$registros2[5]." ".$registros2[6]." ".$registros[1]."'>".$iconoAvatardefault."</div>";
                                }
                            }
                        }
                    }
                    $ultimoMes = $registros[4];
                    $ultimaFecha = $registros[1];
                }
                function nombreMes($monthName){
                    switch($monthName){
                        case "February":
                            $nombremes="Febrero";
                            break;
                        case "March":
                            $nombremes="Marzo";
                            break;
                        case "April":
                            $nombremes="Abril";
                            break;
                        case "May":
                            $nombremes="Mayo";
                            break;
                        case "June":
                            $nombremes="Junio";
                            break;
                        case "July":
                            $nombremes="Julio";
                            break;
                        case "August":
                            $nombremes="Agosto";
                            break;
                        case "September":
                            $nombremes="Septiembre";
                            break;
                        case "October":
                            $nombremes="Octubre";
                            break;
                        case "November":
                            $nombremes="Noviembre";
                            break;
                        case "December":
                            $nombremes="Dicciembre";
                            break;
                        default:
                            break;
                    }
                    return $nombremes;
                }
            ?>
        </tr>
    </tbody>
</table>
