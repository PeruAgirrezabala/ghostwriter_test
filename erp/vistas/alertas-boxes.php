<!-- proyectos activos -->
<div >
    
<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    // PROYECTOS CADUCADOS
    $sql = "SELECT 
                count(*)
            FROM 
                PROYECTOS 
            WHERE 
                tipo_proyecto_id = 1 
            AND
                now() > fecha_entrega
            AND
                fecha_entrega <> 0000-00-00 
            AND
                estado_id <> 3 
            AND 
                estado_id <> 6";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    if ($registros[0] >= 0) {
        $colorBox = "dash-warning-box";
    }
    else {
        $colorBox = "dash-success-box";
    }
    
    if($_SESSION['user_rol']==1 || $_SESSION['user_rol']==12 || $_SESSION['user_rol']==14){
        $ippro="proyectos-cad";
    }else{
        $ippro="";
    }
    echo "<div class='".$colorBox."' id='".$ippro."' title='Ir a Proyectos'>
                <div class='form-group'>
                    <div class='col-md-6'>
                        <img src='img/projects-white.png' height=30>
                    </div>
                    <div class='col-md-6'>
                        <p class='text-primary text-right'>".$registros[0]."</p>
                    </div> 
                    
                </div>
                <div class='form-group'>
                    <p class='text-small text-right'>PROYECTOS VENCIDOS</p>
                </div>
              </div>";
    
    // PROYECTOS CON MAS DEL 100% DE HORAS CONSUMIDAS
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
            AND trabajadas > vendidas 
            ORDER BY vendidas DESC";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Horas");
    $registros = mysqli_num_rows($resultado);
    
    if ($registros > 0) {
        //echo "<div class='form-group'><span class='badge badge-error' style='font-size: 22px; margin-right: 10px; margin-left: 10px;'>".$registros."</span> <strong>Proyectos con más del 100% de horas consumidas </strong></div>";
        $colorBox = "dash-danger-box";
    }
    else {
        $colorBox = "dash-success-box";
    }
    
    if($_SESSION['user_rol']==1 || $_SESSION['user_rol']==12 || $_SESSION['user_rol']==14){
        $ippro="proyectos-horas";
    }else{
        $ippro="";
    }
    echo "<div class='".$colorBox."' id='".$ippro."' title='Ir a Proyectos'>
                <div class='form-group'>
                    <div class='col-md-6'>
                        <img src='img/projects-white.png' height=30>
                    </div>
                    <div class='col-md-6'>
                        <p class='text-primary text-right'>".$registros."</p>
                    </div> 
                    
                </div>
                <div class='form-group'>
                    <p class='text-small text-right'>PROYECTOS OVERFLOW</p>
                </div>
              </div>";
    
    // ENTREGAS CADUCADAS
    $sql = "SELECT 
                count(*)
            FROM 
                ENTREGAS 
            WHERE 
                now() > fecha_entrega
            AND
                fecha_entrega <> 0000-00-00 
            AND
                estado_id <> 5 
            AND 
                estado_id <> 6";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $registros = mysqli_fetch_row($resultado);
    
    if ($registros[0] > 0) {
        $colorBox = "dash-danger-box";
    }
    else {
        $colorBox = "dash-success-box";
    }
    
    echo "<div class='".$colorBox."' id='entregas-cad' title='Ir a Entregas'>
                <div class='form-group'>
                    <div class='col-md-6'>
                        <img src='img/entregas-white.png' height=30>
                    </div>
                    <div class='col-md-6'>
                        <p class='text-primary text-right'>".$registros[0]."</p>
                    </div> 
                    
                </div>
                <div class='form-group'>
                    <p class='text-small text-right'>ENTREGAS VENCIDAS</p>
                </div>
              </div>";
    
    // VISITAS DE MANTENIMIENTO FUERA DE FECHA
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
                PROYECTOS_VISITAS.fecha < now() 
            AND
                PROYECTOS_VISITAS.fecha <> 0000-00-00 ";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Mantenimientos");
    $registros = mysqli_num_rows($resultado);
    
    if ($registros > 0) {
        $colorBox = "dash-danger-box";
    }
    else {
        $colorBox = "dash-success-box";
    }
    
    echo "<div class='".$colorBox."' id='mant-cad' title='Ir a Mantenimientos'>
                <div class='form-group'>
                    <div class='col-md-6'>
                        <img src='img/mant-white.png' height=30>
                    </div>
                    <div class='col-md-6'>
                        <p class='text-primary text-right'>".$registros."</p>
                    </div> 
                    
                </div>
                <div class='form-group'>
                    <p class='text-small text-right'>MANTENIMIENTOS VENCIDOS</p>
                </div>
              </div>";
    
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
                estado_id <> 5";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $registros = mysqli_fetch_row($resultado);
    
    if ($registros[0] > 0) {
        $colorBox = "dash-warning-box";
    }
    else {
        $colorBox = "dash-success-box";
    }
    
    echo "<div class='".$colorBox."' id='pedidos-cad' title='Ir a Pedidos'>
                <div class='form-group'>
                    <div class='col-md-6'>
                        <img src='img/pedidos-white.png' height=30>
                    </div>
                    <div class='col-md-6'>
                        <p class='text-primary text-right'>".$registros[0]."</p>
                    </div> 
                    
                </div>
                <div class='form-group'>
                    <p class='text-small text-right'>PEDIDOS ATRASADOS</p>
                </div>
              </div>";
    
    // DOCUMENTOS PRL CADUCADOS
    $sql = "SELECT sum(total) FROM (
                SELECT count(*)  as total
                        FROM (SELECT 
                            ADMON_DOC.id as docid,
                            'ADMON_DOC' as tipo, 
                            ADMON_DOC.nombre nombredoc, 
                            ORGANISMOS.nombre orgnombre, 
                            (SELECT doc_path FROM ADMON_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC LIMIT 1) as path,
                            (SELECT fecha_exp FROM ADMON_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_expe,
                            (SELECT fecha_cad FROM ADMON_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                            (SELECT id FROM ADMON_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                            PERIODICIDADES.intervalo as inter, 
                            PERIODICIDADES.nombre perio 
                        FROM 
                           ADMON_DOC, ORGANISMOS, PERIODICIDADES
                        WHERE 

                            ORGANISMOS.id = ADMON_DOC.org_id 
                        AND
                            PERIODICIDADES.id = ADMON_DOC.periodicidad_id
                        ) Q
                        WHERE 
                            DATE_ADD(Q.fecha_expe, INTERVAL +Q.inter DAY) <= CURDATE() 
                        AND 
                            Q.inter > 0     
            UNION ALL
                SELECT count(*) as total 
                        FROM (SELECT 
                                PRL_DOC.id as docid,
                                'PRL_DOC' as tipo, 
                                PRL_DOC.nombre nombredoc, 
                                ORGANISMOS.nombre orgnombre, 
                                (SELECT doc_path FROM PRL_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC LIMIT 1) as path,
                                (SELECT fecha_exp FROM PRL_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_expe,
                                (SELECT fecha_cad FROM PRL_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                                (SELECT id FROM PRL_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                                PERIODICIDADES.intervalo as inter, 
                                PERIODICIDADES.nombre perio 
                            FROM 
                                PRL_DOC, ORGANISMOS, PERIODICIDADES 
                            WHERE 
                                ORGANISMOS.id = PRL_DOC.org_id 
                            AND
                                PERIODICIDADES.id = PRL_DOC.periodicidad_id
                            ) R
                        WHERE 
                            DATE_ADD(R.fecha_expe, INTERVAL +R.inter DAY) <= CURDATE() 
                        AND 
                            R.inter > 0
            UNION ALL
                SELECT count(*) as total  
                        FROM (SELECT 
                                USERS_DOC.id as docid,
                                'USERS_DOC' as tipo, 
                                USERS_DOC.nombre nombredoc, 
                                ORGANISMOS.nombre orgnombre, 
                                (SELECT doc_path FROM USERS_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC LIMIT 1) as path,
                                (SELECT fecha_exp FROM USERS_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_expe,
                                (SELECT fecha_cad FROM USERS_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                                (SELECT id FROM USERS_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                                PERIODICIDADES.intervalo as inter, 
                                PERIODICIDADES.nombre perio 
                            FROM 
                                USERS_DOC, ORGANISMOS, PERIODICIDADES   
                            WHERE 
                                ORGANISMOS.id = USERS_DOC.org_id 
                            AND
                                PERIODICIDADES.id = USERS_DOC.periodicidad_id
                            ) S
                        WHERE 
                            DATE_ADD(S.fecha_expe, INTERVAL +S.inter DAY) <= CURDATE() 
                        AND 
                            S.inter > 0
            UNION ALL
                SELECT count(*) as total   
                        FROM (SELECT 
                                CLIENTES_DOC.id as docid,
                                'CLIENTES_DOC' as tipo, 
                                CLIENTES_DOC.nombre nombredoc, 
                                ORGANISMOS.nombre orgnombre, 
                                (SELECT doc_path FROM CLIENTES_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC LIMIT 1) as path,
                                (SELECT fecha_exp FROM CLIENTES_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_expe,
                                (SELECT fecha_cad FROM CLIENTES_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                                (SELECT id FROM CLIENTES_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                                PERIODICIDADES.intervalo as inter, 
                                PERIODICIDADES.nombre perio 
                            FROM 
                                CLIENTES_DOC, ORGANISMOS, PERIODICIDADES 
                            WHERE 
                                ORGANISMOS.id = CLIENTES_DOC.org_id 
                            AND
                                PERIODICIDADES.id = CLIENTES_DOC.periodicidad_id
                            ) T
                        WHERE 
                            DATE_ADD(T.fecha_expe, INTERVAL +T.inter DAY) <= CURDATE() 
                        AND 
                            T.inter > 0
            ) M
            ";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Mantenimientos");
    $registros = mysqli_fetch_row($resultado);
    
    if ($registros > 0) {
        $colorBox = "dash-danger-box";
    }
    else {
        $colorBox = "dash-success-box";
    }
    
    echo "<div class='".$colorBox."' id='prl-cad' title='Ir a Prevención'>
                <div class='form-group'>
                    <div class='col-md-6'>
                        <img src='img/entregas-white.png' height=30>
                    </div>
                    <div class='col-md-6'>
                        <p class='text-primary text-right'>".$registros[0]."</p>
                    </div> 
                    
                </div>
                <div class='form-group'>
                    <p class='text-small text-right'>DOCS PRL CADUCADOS</p>
                </div>
              </div>";
    
    
?>
</div>