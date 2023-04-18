<!-- proyectos activos -->
<div style="text-align: center;">
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                count(*)
            FROM 
                PROYECTOS WHERE tipo_proyecto_id = 1";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='form-group'><div class='col-md-4'><div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div><div class='form-group'> <strong>Proyectos</strong></div></div>";
    
    $sql = "SELECT 
                count(*)
            FROM 
                PROYECTOS WHERE tipo_proyecto_id = 2";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Mantenimientos");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'><div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div><div class='form-group'> <strong>Mantenimientos</strong></div></div>";
    
    $sql = "SELECT 
                count(*)
            FROM 
                ENTREGAS";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'><div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div><div class='form-group'> <strong>Entregas</strong></div></div></div>";
    
    $sql = "SELECT 
                count(*)
            FROM 
                OFERTAS";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='form-group'><div class='col-md-4'><div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div><div class='form-group'> <strong>Ofertas</strong></div></div>";
    
    $sql = "SELECT 
                count(*)
            FROM 
                PEDIDOS_PROV";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Pedidos");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='col-md-4'><div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div><div class='form-group'> <strong>Pedidos</strong></div></div></div>";
?>
</div>