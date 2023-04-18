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

    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<div class='form-group'><div class='col-md-4'><div class='form-group'><span class='badge' style='font-size: 52px;'>".$registros[0]."</span></div><div class='form-group'> <strong>Proyectos</strong></div></div>";
    
    $sql="SELECT 
                count(*)
            FROM 
                PROYECTOS WHERE tipo_proyecto_id = 1
            AND estado_id=1";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Proyectos Activos");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='col-md-4'><div class='form-group'><span class='badge badge-info' style='font-size: 52px;'>".$registros[0]."</span></div><div class='form-group'> <strong>Activo</strong></div></div>";
    
    $sql="SELECT 
                count(*)
            FROM 
                PROYECTOS WHERE tipo_proyecto_id = 1
            AND estado_id=3";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Proyectos Activos");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='col-md-4'><div class='form-group'><span class='badge badge-success' style='font-size: 52px;'>".$registros[0]."</span></div><div class='form-group'> <strong>Entregado</strong></div></div></div>";
    
    
?>
</div>