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
    $sql = "SELECT count(*) FROM ACTIVIDAD
            WHERE categoria_id=1
            AND fecha>='".$fechahoy."'
            AND fecha<='".$fechamas30."'";
    file_put_contents("logNext.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='form-group'>";
    echo "<span class='badge badge-warning' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros[0]."</span>";
    echo "<strong> Próximas Vititas (proximos 30 días)</strong>";
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
    // MANTINIMIENTOS PENDIENTES
    $sql="SELECT 
                count(*)
            FROM 
                ACTIVIDAD
            INNER JOIN PROYECTOS ON
                ACTIVIDAD.item_id=PROYECTOS.id
            INNER JOIN ACTIVIDAD_ESTADOS ON
                ACTIVIDAD.estado_id=ACTIVIDAD_ESTADOS.id
            INNER JOIN CLIENTES_INSTALACIONES ON
                ACTIVIDAD.estado_id=ACTIVIDAD_ESTADOS.id
            WHERE 
                categoria_id=1
            AND
                ACTIVIDAD.instalacion=CLIENTES_INSTALACIONES.id
            AND
                ACTIVIDAD.estado_id!=3
            AND 
                fecha<='".$fechahoy."'
            ORDER BY fecha DESC";
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    echo "<div class='form-group'>";
    echo "<span class='badge badge-error' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros[0]."</span>";
    echo "<strong>Visitas Atrasadas</strong>";
    echo "</div>";
    /**/
    /* Enregado 
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
     * */
    /**/
    
    //echo "</div>";
    
?>
</div>