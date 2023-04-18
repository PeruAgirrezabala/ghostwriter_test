<!-- proyectos activos -->
<div >
    
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
                tipo_proyecto_id = 1 
            AND
                now() > DATE_ADD(fecha_entrega, INTERVAL 7 DAY)";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    if ($registros[0] > 0) {
        echo "<div class='form-group'><span class='badge badge-warning' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros[0]."</span> <strong>Proyectos a punto de caducar </strong></div>";
    }
    
    // PROYECTOS CON MAS DEL 80% DE HORAS CONSUMIDAS
    $sql = "SELECT id as proyecto, ref, (SELECT 
                sum(PROYECTOS_HORAS_IMPUTADAS.cantidad) as trabajadas
                FROM 
                TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_HORAS_IMPUTADAS, PROYECTOS, erp_users  
                WHERE 
                PROYECTOS_HORAS_IMPUTADAS.tarea_id = TAREAS.id
                AND
                TAREAS.perfil_id = PERFILES.id
                AND
                PERFILES_HORAS.perfil_id = PERFILES.id
                AND
                PERFILES_HORAS.id = PROYECTOS_HORAS_IMPUTADAS.tipo_hora_id
                AND
                PROYECTOS_HORAS_IMPUTADAS.proyecto_id = PROYECTOS.id 
                AND 
                PROYECTOS_HORAS_IMPUTADAS.tecnico_id = erp_users.id 
                AND PROYECTOS.id = proyecto                     
                GROUP BY 
                PROYECTOS.id
            ) as trabajadas,(
                    SELECT 
                sum(PROYECTOS_TAREAS.cantidad) as vendidas
                FROM 
                TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_TAREAS, PROYECTOS, erp_users  
                WHERE 
                PROYECTOS_TAREAS.tarea_id = TAREAS.id
                AND
                TAREAS.perfil_id = PERFILES.id
                AND
                PERFILES_HORAS.perfil_id = PERFILES.id
                AND
                PERFILES_HORAS.id = PROYECTOS_TAREAS.tipo_hora_id
                AND
                PROYECTOS_TAREAS.proyecto_id = PROYECTOS.id 
                AND 
                PROYECTOS_TAREAS.tecnico_id = erp_users.id 
                AND PROYECTOS.id = proyecto
                GROUP BY 
                PROYECTOS.id
            ) as vendidas
            FROM PROYECTOS 
            WHERE PROYECTOS.tipo_proyecto_id = 1 
            HAVING vendidas IS NOT NULL 
            AND trabajadas > ((vendidas*80)/100) 
            ORDER BY vendidas DESC";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Horas");
    $registros = mysqli_num_rows($resultado);
    
    if ($registros > 0) {
        echo "<div class='form-group'><span class='badge badge-warning' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros."</span> <strong>Proyectos con más del 80% de horas consumidas </strong></div>";
    }
    
    // ENTREGAS A MENOS DE 1 SEMANA DE SER ENTREGADAS
    $sql = "SELECT 
                count(*)
            FROM 
                ENTREGAS 
            WHERE 
                now() > DATE_ADD(fecha_entrega, INTERVAL 7 DAY)";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    
    if ($registros[0] > 0) {
        echo "<div class='form-group'><span class='badge badge-warning' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros[0]."</span> <strong>Proyectos a punto de caducar </strong></div>";
    }
    
    // VISITAS DE MANTENIMIENTO EN MENOS DE 1 SEMANA
    $sql = "SELECT 
                PROYECTOS_VISITAS.fecha as visita, PROYECTOS_VISITAS.realizada
            FROM 
                PROYECTOS, PROYECTOS_VISITAS
            WHERE 
                PROYECTOS.id = PROYECTOS_VISITAS.proyecto_id 
            AND
                tipo_proyecto_id = 2 
            AND 
                PROYECTOS_VISITAS.realizada = 0 
            AND
                DATE_ADD(now(), INTERVAL 7 DAY) > PROYECTOS_VISITAS.fecha
            AND 
                PROYECTOS_VISITAS.fecha > now()";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Mantenimientos");
    $registros = mysqli_num_rows($resultado);
    
    if ($registros > 0) {
        echo "<div class='form-group'><span class='badge badge-warning' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros."</span> <strong>Visitas de mantenimiento en menos de una semana </strong></div>";
    }
    
    
?>
</div>