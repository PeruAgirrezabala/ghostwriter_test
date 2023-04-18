<!-- proyectos activos -->
<div>
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                count(*)
            FROM 
                PROYECTOS 
            WHERE 
                tipo_proyecto_id = 1";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    echo "<span class='badge badge-info'>".$registros[0]."</span>";
    
?>
</div>