<?php 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "SELECT 
                    erp_users.nombre, erp_users.apellidos
                FROM 
                    erp_users
                WHERE
                    erp_users.id=".$_GET['idt'];
    
    $resultado = mysqli_query($connString, $sql) or die("Error al recoger nombre y apellido");
    $registros = mysqli_fetch_row($resultado);
    $nombre=$registros[0].$registros[1];    
    $nombre.=$_GET['year']."_".$_GET['mes'];
    
    /* Generar el Excel */
    header("Pragma: public");
    header("Expires: 0");
    $filename = "Horas ".$nombre.".xls";
    header("Content-type: application/x-msdownload");
    //header("Content-type: text/html; charset=utf-8");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    //include($pathraiz."/apps/jornada/pruebaExcel.html"); 
    $página_inicio = file_get_contents($pathraiz."/apps/jornada/exportarExcelMesPropio.txt");
    echo $página_inicio;
?>