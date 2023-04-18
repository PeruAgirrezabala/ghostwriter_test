
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_GET['trabajadorid'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        genJornadas();
    }    
    else {
        echo 0;
    }
    
    function genJornadas() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT 
                    CALENDARIO.id
                FROM 
                    CALENDARIO
                ORDER BY 
                    CALENDARIO.fecha ASC";

        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Calendario");

        while ($registros = mysqli_fetch_array($resultado)) { 
            $sql = "SELECT 
                        JORNADAS.id
                    FROM 
                        JORNADAS
                    WHERE
                        calendario_id = ".$registros[0]."
                    AND
                        user_id = ".$_GET['trabajadorid'];

            $resultado2 = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de las Jornadas");
            $numresultados = mysqli_num_rows($resultado2);
            
            if ($numresultados == 0) {
                // creo la jornada para el trabajador y el dia del calendario
                $sql = "INSERT INTO JORNADAS (
                            calendario_id,
                            user_id
                            )
                        VALUES (
                            ".$registros[0].",
                            ".$_GET['trabajadorid']."
                            )";
                $result = mysqli_query($connString, $sql) or die("Error al insertar la Jornada");
            }
        }
        
        echo 1;
    }
?>
	