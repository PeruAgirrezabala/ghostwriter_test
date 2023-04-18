<!-- proyectos activos -->
<div >
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    //echo "<div class='form-group'>";
    $fechahoy=date("Y-m-d");
    
    // 86400 un día => 2592000, 30 días
    $fechamas30 = $tomorrow = date("Y-m-d", time() + 2592000);
    /* Total */
    $sql = "SELECT 
                    count(*)
                FROM 
                    PROYECTOS, ESTADOS_ENTREGAS, ENTREGAS, CLIENTES  
                WHERE
                    PROYECTOS.cliente_id = CLIENTES.id
                AND
                    PROYECTOS.id = ENTREGAS.proyecto_id
                AND 
                    ENTREGAS.estado_id = ESTADOS_ENTREGAS.id 
                AND
                    ENTREGAS.estado_id <> 5 
                AND 
                    ENTREGAS.estado_id <> 6 
                AND
                    ENTREGAS.fecha_entrega < now()
                ORDER BY 
                    ENTREGAS.fecha_entrega DESC";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas Atrasadas");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='form-group'>";
    echo "<span class='badge badge-warning' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros[0]."</span>";
    echo "<strong>Entregas Atrasadas</strong>";
    echo "</div>";
    /**/
    
    /* Pendientes 
    $sql = "SELECT count(*)
            FROM ACTIVIDAD
            WHERE categoria_id =1
            AND fecha_fin <= '".$fechahoy."'
            AND estado_id !=3
            AND fecha_fin != '0000-00-00'";
     * 
     */
    $sql = "SELECT 
                    count(*)
                FROM 
                    PROYECTOS, ESTADOS_ENTREGAS, ENTREGAS, CLIENTES  
                WHERE
                    PROYECTOS.cliente_id = CLIENTES.id
                AND
                    PROYECTOS.id = ENTREGAS.proyecto_id
                AND 
                    ENTREGAS.estado_id = ESTADOS_ENTREGAS.id 
                AND
                    ENTREGAS.estado_id = 6
                ORDER BY 
                    ENTREGAS.fecha_entrega DESC";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas Rechazadas");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='form-group'>";
    echo "<span class='badge badge-error' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros[0]."</span>";
    echo "<strong>Entregas Rechazadas</strong>";
    echo "</div>";

    
?>
</div>