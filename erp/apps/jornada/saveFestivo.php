
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    
    updateCalendario();
    
    function updateCalendario() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CALENDARIO 
                SET festivo = 1, 
                    tipo_jornada = 1,
                    horas = 0.00
                WHERE fecha = '".$_POST['festivos_dia']."'";
        
        file_put_contents("updateCalendario.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Calendario");
    }

?>
	