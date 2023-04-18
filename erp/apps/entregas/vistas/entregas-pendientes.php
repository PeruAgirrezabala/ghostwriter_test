<!-- proyectos activos -->
<div style='text-align: center;'>
    
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
                ENTREGAS";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Entregas</strong></div>";
    echo "</div>";
    /**/
    
    /* Pendientes */
    $sql = "SELECT 
                count(*)
            FROM 
                ENTREGAS
            WHERE 
                estado_id <> 5";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge badge-info' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Pendientes</strong></div>";
    echo "</div>";
    /**/
    
    /* Enregado */
    $sql = "SELECT 
                count(*)
            FROM 
                ENTREGAS
            WHERE 
                estado_id = 5";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge badge-success' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Entregado</strong></div>";
    echo "</div>";
    /**/
    
    echo "</div>";
    
?>
</div>