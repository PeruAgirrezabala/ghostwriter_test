<!-- proyectos activos -->
<div >
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    // OFERTAS SIN RESPUESTA CON MAS DE 30 DIAS DE ANTIGUEDAD
//    $sql = "SELECT 
//                count(*)
//            FROM 
//                OFERTAS 
//            WHERE 
//                estado_id <> 4
//            AND
//                estado_id <> 5
//            AND
//                now() > DATE_ADD(fecha, INTERVAL 30 DAY)";
//
//    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
//    $registros = mysqli_fetch_row($resultado);
    
    
    
    $sql="SELECT OFERTAS.id FROM OFERTAS WHERE OFERTAS.0_ver=0 AND (DATE_ADD(fecha, INTERVAL 30 DAY) > now())";
    $result = mysqli_query($connString, $sql) or die("Error al seleccionar Ofertas padres");
    
    $count=0;
    
    while($registros = mysqli_fetch_array($result)){
        $sqlCheck="SELECT OFERTAS.id
                FROM OFERTAS 
                WHERE (OFERTAS.0_ver=".$registros[0]." OR OFERTAS.id=".$registros[0].")
                AND (OFERTAS.estado_id=4 OR OFERTAS.estado_id=5)";
        $resCheck = mysqli_query($connString, $sqlCheck) or die("Error al seleccionar Oferta");
        $num = mysqli_num_rows($resCheck);
        if($num==0){ // No esta cerrado
            $count++;
        }        
    }
    
    
    if ($count > 0) {
        echo "<div class='form-group' title='Ofertas de menos de 30 días que no tengan el estado Aceptado o Rechazado'><span class='badge badge-error' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$count."</span> <strong>Ofertas con mas de 30 días de antigüedad sin cerrar* </strong></div>";
    }
    
    $sql="SELECT OFERTAS.id FROM OFERTAS WHERE OFERTAS.0_ver=0 AND (DATE_ADD(fecha, INTERVAL 60 DAY) > now())";
    $result = mysqli_query($connString, $sql) or die("Error al seleccionar Ofertas padres");
    
    $count=0;
    
    while($registros = mysqli_fetch_array($result)){
        $sqlCheck="SELECT OFERTAS.id
                FROM OFERTAS 
                WHERE (OFERTAS.0_ver=".$registros[0]." OR OFERTAS.id=".$registros[0].")
                AND (OFERTAS.estado_id=4 OR OFERTAS.estado_id=5)";
        $resCheck = mysqli_query($connString, $sqlCheck) or die("Error al seleccionar Oferta");
        $num = mysqli_num_rows($resCheck);
        if($num==0){ // No esta cerrado
            $count++;
        }        
    }
    
    
    if ($count > 0) {
        echo "<div class='form-group' title='Ofertas de menos de 30 días que no tengan el estado Aceptado o Rechazado'><span class='badge badge-error' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$count."</span> <strong>Ofertas con mas de 60 días de antigüedad sin cerrar* </strong></div>";
    }
    
    // Ofertas que estan aceptadas pero no tienen ningún proyecto asignado
    $sqlAcSin="SELECT *
                FROM OFERTAS
                WHERE OFERTAS.estado_id =4
                AND OFERTAS.proyecto_id =12";
    $resAcSin = mysqli_query($connString, $sqlAcSin) or die("Error al seleccionar Oferta");
    $num = mysqli_num_rows($resAcSin);
    
    if ($num > 0) {
        echo "<div class='form-group' title='Ofertas Aceptadas que no tengan Asignado un Proyecto'><span class='badge badge-warning' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$num."</span> <strong>Ofertas Aceptadas sin Proyecto </strong></div>";
    }
    
?>
</div>