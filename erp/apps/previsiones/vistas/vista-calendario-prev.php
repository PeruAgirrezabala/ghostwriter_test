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
                
                $sql = "SELECT DISTINCT
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
                $contador = 0;
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
                        }
                        else {
                            echo "</td><td class='text-center ".$festivo."'>".$registros[5]."";
                        }

                        // Ahora consulto la gente que tiene visita
                        $sql = "SELECT 
                                    PREVISIONES.id as prev,
                                    PREVISIONES.fecha_ini, 
                                    PREVISIONES.fecha_fin,
                                    PREVISIONES.nombre,
                                    PREVISIONES.descripcion,
                                    PREVISIONES.instalacion,
                                    CLIENTES.nombre,
                                    (SELECT GROUP_CONCAT(CONCAT(erp_users.nombre,' ', erp_users.apellidos,'-',erp_users.color)) FROM erp_users, PREVISIONES_TECNICOS WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = prev) as tecnicos
                                FROM 
                                    PREVISIONES
                                LEFT JOIN CLIENTES   
                                    ON PREVISIONES.cliente_id = CLIENTES.id
                                WHERE
                                    '".$registros[1]."' >= PREVISIONES.fecha_ini
                                AND
                                    '".$registros[1]."' <= PREVISIONES.fecha_fin";
                        
                        file_put_contents("queryPrevisiones.txt", $sql);
                        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las Previsiones");
                        if (mysqli_num_rows($resultado2) > 0) {
                            while ($registros2 = mysqli_fetch_array($resultado2)) { 
                                $tecnicos = explode(",",$registros2[7]);
                                //file_put_contents("arrayTecs.txt", sizeof($tecnicos));
                                
                                foreach ($tecnicos as $value) {
                                    $datosTecnico = explode("-",$value);
                                    echo "<div class='vacacionesCuadro' style='background-color:".$datosTecnico[1]."' title='".$datosTecnico[0]." - ".$registros2[3]." - ".$registros2[5]." - ".$registros2[6]."'></div>";
                                    $contador = $contador +1;
                                }
                            }
                        }
                    }
                    else {
                        echo "</tr>";
                        $dateObj   = DateTime::createFromFormat('!m', $registros[4]);
                        $monthName = $dateObj->format('F'); // March
                        $monthName = nombreMes($monthName);
                        echo "<tr><td colspan='100%' class='text-left'><strong>".$monthName."</strong></td></tr>";
                        echo "<tr><td class='text-center'>".$registros[5]."";
                        // Ahora consulto la gente que tiene visita
                        $sql = "SELECT 
                                    PREVISIONES.id as prev,
                                    PREVISIONES.fecha_ini, 
                                    PREVISIONES.fecha_fin,
                                    PREVISIONES.nombre,
                                    PREVISIONES.descripcion,
                                    PREVISIONES.instalacion,
                                    CLIENTES.nombre,
                                    (SELECT GROUP_CONCAT(CONCAT(erp_users.nombre,' ', erp_users.apellidos,'-',erp_users.color)) FROM erp_users, PREVISIONES_TECNICOS WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = prev) as tecnicos
                                FROM 
                                    PREVISIONES, CLIENTES   
                                WHERE
                                    PREVISIONES.cliente_id = CLIENTES.id
                                AND
                                    '".$registros[1]."' >= PREVISIONES.fecha_ini
                                AND
                                    '".$registros[1]."' <= PREVISIONES.fecha_fin";
                        
                        file_put_contents("queryPrevisiones.txt", $sql);
                        $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las Previsiones");
                        if (mysqli_num_rows($resultado2) > 0) {
                            while ($registros2 = mysqli_fetch_array($resultado2)) { 
                                $tecnicos = explode(",",$registros2[7]);
                                //file_put_contents("arrayTecs.txt", sizeof($tecnicos));
                                foreach ($tecnicos as $value) {
                                    $datosTecnico = explode("-",$value);
                                    echo "<div class='vacacionesCuadro' style='background-color:".$datosTecnico[1]."' title='".$datosTecnico[0]." - ".$registros2[3]." - ".$registros2[5]." - ".$registros2[6]."'></div>";
                                    $contador = $contador +1;
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
