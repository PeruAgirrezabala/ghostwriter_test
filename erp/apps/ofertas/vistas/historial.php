<!-- proyectos activos -->
<div style="text-align: center;">
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    echo "<div class='form-group'>";
    
    /* Ofertas Totales */
    $sql = "SELECT 
                count(*)
            FROM 
                OFERTAS
            WHERE
                0_ver=0 AND n_ver=0";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Ofertas</strong></div>";
    echo "</div>";
    
    /* Ofertas Aceptadas */
    $sql = "SELECT 
                count(*), 0_ver
            FROM 
                OFERTAS
            WHERE
                estado_id=2
            GROUP BY 0_ver";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge badge-info' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Ofertado</strong></div>";
    echo "</div>";    
    /**/
    
    /* Ofertas Aceptadas */
    $sql = "SELECT 
                count(*)
            FROM 
                OFERTAS
            WHERE
                estado_id=4";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'><span class='badge badge-success' style='font-size: 52px;'>".$registros[0]."</span></div>";
    echo "<div class='form-group'> <strong>Aceptadas</strong></div>";
    echo "</div>";
    
    echo "</div>";
?>
</div>