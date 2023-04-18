
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    
    autoCalendario();
        
    
    function autoCalendario() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
                
        $begin = new DateTime($_GET['start_date']);
        $end = new DateTime($_GET['end_date']);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            //echo $dt->format("Y-m-d H:i:s");
            //echo "<br>";
            if($dt->format('D') == 'Sat' || $dt->format('D') == 'Sun') { 
                //echo "Today is Saturday or Sunday.";
                $horas = "0.00";
                $festivo = 1;
                $tipoJornada = 0;
            } else {
                $inicioJornada = new DateTime('2019-06-07');
                $finJornada = new DateTime('2019-09-27');
                if (($dt->format("Y-m-d") >= $inicioJornada->format("Y-m-d")) && ($dt->format("Y-m-d") <= $finJornada->format("Y-m-d"))) {
                    $horas = "5.00";   
                    $festivo = 0;
                    $tipoJornada = 2;
                }
                else {
                    $horas = "8.00";   
                    $festivo = 0;
                    $tipoJornada = 1;
                }
                //echo "Today is not Saturday or Sunday.";
                //echo $dt->format("Y-m-d H:i:s")." - ".$dt->format('D');
                
            }
            $sql = "INSERT INTO CALENDARIO (
                        fecha,
                        horas,
                        festivo,
                        tipo_jornada
                        )
                    VALUES (
                        '".$dt->format("Y-m-d H:i:s")."',
                        ".$horas.",
                        ".$festivo.",
                        ".$tipoJornada."
                        )";
            mysqli_set_charset($connString, "utf8");
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Calendario");
            //echo "<br>";
        }
        
        //file_put_contents("insertAcceso.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        //$result = mysqli_query($connString, $sql) or die("Error al guardar el Cliente");
        echo 1;
    }
    
?>
	