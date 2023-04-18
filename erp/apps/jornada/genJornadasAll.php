
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    genJornadas();
    
    function genJornadas() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sqlTrabajadores = "SELECT 
                    id
                FROM 
                    erp_users
                ORDER BY 
                    id ASC";

        $resultadoTrabajadores = mysqli_query($connString, $sqlTrabajadores) or die("Error al ejcutar la consulta de los Trabajadores");
        $sqlCalendario = "SELECT 
                        CALENDARIO.id
                    FROM 
                        CALENDARIO
                    WHERE
                        CALENDARIO.fecha >= '".$_GET["start_date"]."'
                    AND 
                        CALENDARIO.fecha <= '".$_GET["end_date"]."'
                    ORDER BY 
                        CALENDARIO.fecha ASC";
        file_put_contents("SelectCalendarui.txt", $sqlCalendario);
            
        while ($registrosTrabajadores = mysqli_fetch_array($resultadoTrabajadores)) { 
            $resultadoCalendario = mysqli_query($connString, $sqlCalendario) or die("Error al ejcutar la consulta del Calendario");
            while ($registrosCalendario = mysqli_fetch_array($resultadoCalendario)) { 
                $sql = "SELECT 
                            JORNADAS.id
                        FROM 
                            JORNADAS
                        WHERE
                            calendario_id = ".$registrosCalendario[0]."
                        AND
                            user_id = ".$registrosTrabajadores[0];

                $resultado2 = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de las Jornadas");
                $numresultados = mysqli_num_rows($resultado2);

                if ($numresultados == 0) {
                    // creo la jornada para el trabajador y el dia del calendario
                    $sql = "INSERT INTO JORNADAS (
                                calendario_id,
                                user_id
                                )
                            VALUES (
                                ".$registrosCalendario[0].",
                                ".$registrosTrabajadores[0]."
                                )";
                    $result = mysqli_query($connString, $sql) or die("Error al insertar la Jornada");
                }
            } // loop calendario
        } // loop trabajadores
        
        echo 1;
    }
?>
	