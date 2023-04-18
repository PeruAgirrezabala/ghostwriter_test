<table class="table table-striped table-hover" id='tabla-vacaciones' style="margin: 0px auto 20px auto;">
    <tbody>
        <tr><td class="text-left" colspan="100%"><strong>January</strong></td></tr>
        <tr>
            <?
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");

                $db = new dbObj();
                $connString =  $db->getConnstring();
                
                $yearNum = $_GET['yearNum'];
                
                $sql = "SELECT 
                                CALENDARIO.id,
                                CALENDARIO.fecha, 
                                CALENDARIO.horas,
                                erp_users.nombre,
                                JORNADAS.id,
                                erp_users.firma_path,
                                CALENDARIO.festivo,
                                CALENDARIO.tipo_jornada, 
                                erp_users.color,
                                MONTH(CALENDARIO.fecha),
                                DAY(CALENDARIO.fecha)
                            FROM 
                                CALENDARIO, JORNADAS, erp_users 
                            WHERE 
                                CALENDARIO.id = JORNADAS.calendario_id 
                            AND
                                JORNADAS.user_id = erp_users.id 
                            AND 
                                YEAR(CALENDARIO.fecha) = ".$yearNum."
                            ORDER BY 
                                CALENDARIO.fecha ASC";

                //file_put_contents("queryCalendario.txt", $sql);
                $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Calendario de Vacaciones");

                $ultimoMes = 0;
                $ultimaFecha = "";
                while ($registros = mysqli_fetch_array($resultado)) { 
                    if (($ultimoMes == $registros[9]) || ($ultimoMes == 0)) {
                        if ($registros[6] == 1) {
                            $festivo = " danger ";
                        }
                        else {
                            $festivo = "";
                        }
                        if (($ultimaFecha == $registros[1]) || ($ultimaFecha = "")) {
                            // Solo pintaria colores
                        }
                        else {
                            echo "</td><td class='text-center ".$festivo."'>".$registros[10]."";
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
                                    JORNADAS.id = ".$registros[4]."
                                AND 
                                    JORNADAS_ACCESOS.tipo_horas = 3 
                                GROUP BY 
                                    JORNADAS.id
                                ORDER BY 
                                    JORNADAS_ACCESOS.hora_entrada ASC";
                        //file_put_contents("queryAccesos.txt", $sql);
                        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de los Días de Vacaciones");
                        if (mysqli_num_rows($resultado2) > 0) {
                            while ($registros2 = mysqli_fetch_array($resultado2)) { 
                                echo "<div class='vacacionesCuadro' style='background-color:".$registros2[4]."' title='".$registros2[5]." ".$registros2[6]." ".$registros[1]."'></div>";
                            }
                        }
                    }
                    else {
                        echo "</tr>";
                        $dateObj   = DateTime::createFromFormat('!m', $registros[9]);
                        $monthName = $dateObj->format('F'); // March
                        echo "<tr><td colspan='100%' class='text-left'><strong>".$monthName."</strong></td></tr>";
                        echo "<tr><td class='text-center'>".$registros[10]."";
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
                                    JORNADAS.id = ".$registros[4]."
                                AND 
                                    JORNADAS_ACCESOS.tipo_horas = 3 
                                GROUP BY 
                                    JORNADAS.id
                                ORDER BY 
                                    JORNADAS_ACCESOS.hora_entrada ASC";
                        //file_put_contents("queryAccesos.txt", $sql);
                        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de los Días de Vacaciones");
                        if (mysqli_num_rows($resultado2) > 0) {
                            while ($registros2 = mysqli_fetch_array($resultado2)) { 
                                echo "<div class='vacacionesCuadro' style='background-color:".$registros2[4]."' title='".$registros2[5]." ".$registros2[6]." ".$registros[1]."'></div>";
                            }
                        }
                    }
                    $ultimoMes = $registros[9];
                    $ultimaFecha = $registros[1];
                }
            ?>
        </tr>
    </tbody>
</table>
