<!-- proyectos activos -->
<div style="text-align: center;">
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    echo "<div class='form-group'>";
    
    /* Mantenimientos Totales*/
    $sql = "SELECT 
                count(*)
            FROM 
                PROYECTOS 
            WHERE 
                tipo_proyecto_id = 2";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Mantenimientos</strong></div>";
    echo "</div>";
    /**/
    
    /* Mantenientos Activos */
    $sql = "SELECT 
                count(*)
            FROM 
                PROYECTOS 
            WHERE 
                tipo_proyecto_id = 2
            AND estado_id=1";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge badge-info' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Activos</strong></div>";
    echo "</div>";
    /**/
    
    /* Mantenimientos Finalizados */
    $sql = "SELECT 
                count(*)
            FROM 
                PROYECTOS 
            WHERE 
                tipo_proyecto_id = 2
            AND estado_id=3";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge badge-success' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Finalizados</strong></div>";
    echo "</div>";
    
    echo "</div>";
?>
</div>