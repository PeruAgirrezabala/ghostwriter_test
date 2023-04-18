<!-- proyectos activos -->
<div >
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    // PEDIDOS CADUCADOS
    $sql = "SELECT 
                count(*)
            FROM 
                PEDIDOS_PROV 
            WHERE 
                now() > fecha_entrega 
            AND
                fecha_entrega <> 0000-00-00 
            AND 
                estado_id < 3";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    if ($registros[0] > 0) {
        echo "<div class='form-group'><span class='badge badge-error' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros[0]."</span> <strong>Pedidos atrasados </strong></div>";
    }
    
?>
</div>