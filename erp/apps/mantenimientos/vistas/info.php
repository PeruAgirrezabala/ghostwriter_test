<!-- proyectos activos -->
<div >
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    echo "<div class='form-group'>";
    
    /* Total */
    $sql = "SELECT 
                count(*)
            FROM 
                ACTIVIDAD
            WHERE
                categoria_id=1";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='col-md-3'>";
    echo "<div class='form-group'><span class='badge' style='font-size: 36px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Programadas</strong></div>";
    echo "</div>";
    /**/
    
    /* Pendientes */
    $sql = "SELECT 
                count(*)
            FROM 
                ACTIVIDAD
            WHERE
                categoria_id=1
            AND
                estado_id=3";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-3'>";
    echo "<div class='form-group'><span class='badge badge-success' style='font-size: 36px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Realizadas</strong></div>";
    echo "</div>";
    /**/
    
    /* Sin fecha */
    $sql = "SELECT 
                count(*)
            FROM 
                ACTIVIDAD
            WHERE 
                categoria_id=1
            AND fecha_fin='0000-00-00'";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    $sinfecha=$registros[0];
    echo "<div class='col-md-3'>";
    echo "<div class='form-group'><span class='badge badge-error' style='font-size: 36px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Sin Fecha</strong></div>";
    echo "</div>";
    /**/
    
    /* Pendientes */
    $sql = "SELECT 
                count(*)
            FROM 
                ACTIVIDAD
            WHERE 
                categoria_id=1
            AND
                estado_id <> 3";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='col-md-3'>";
    echo "<div class='form-group'><span class='badge badge-warning' style='font-size: 36px;'>".($registros[0]-$sinfecha)."</span></div>";
    echo "<div class='form-group'><strong>Pendientes</strong></div>";
    echo "</div>";
    /**/
    
    
    
    echo "</div>";
    
?>
</div>