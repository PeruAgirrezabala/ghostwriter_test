<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $limit = 15;
    
    if ((($_GET['year'] != "") && ($_GET['year'] != "undefined"))  || (($_GET['month'] != "") && ($_GET['month'] != "undefined")) || (($_GET['cli'] != "") && ($_GET['cli'] != "undefined")) || (($_GET['estado'] != "") && ($_GET['estado'] != "undefined")) || (($_GET['prior'] != "") && ($_GET['prior'] != "undefined")) || (($_GET['tec'] != "") && ($_GET['tec'] != "undefined")) || (($_GET['cat'] != "") && ($_GET['cat'] != "undefined")) || (($_GET['ffin'] != "") && ($_GET['ffin'] != "undefined")) || (($_GET['fsol'] != "") && ($_GET['fsol'] != "undefined"))) {
        
    }
    else {
        
    }
    
    if (($_GET['year'] != "") && ($_GET['year'] != "undefined")) {
        $criteriaLink = "&year=".$_GET['year'];
        $criteria .= " WHERE YEAR(ACTIVIDAD.fecha) = ".$_GET['year'];
        $and = " AND ";
        if ($_GET['month'] != "") {
            $criteriaLink .= "&month=".$_GET['month'];
            $criteria .= " AND MONTH(ACTIVIDAD.fecha) = ".$_GET['month'];
        }
    }
    if (($_GET['cli'] != "") && ($_GET['cli'] != "undefined")) {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&cli=".$_GET['cli'];
        $criteria .= $and." ACTIVIDAD.cliente_id = ".$_GET['cli'];
        $and = " AND ";
    }
    
    if (($_GET['estado'] != "") && ($_GET['estado'] != "undefined")) {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&estado=".$_GET['estado'];
        $criteria .= $and." ACTIVIDAD.estado_id = ".$_GET['estado'];
        $and = " AND ";
    }
    if (($_GET['prior'] != "") && ($_GET['prior'] != "undefined")) {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&prior=".$_GET['prior'];
        $criteria .= $and." ACTIVIDAD.prioridad_id = ".$_GET['prior'];
        $and = " AND ";
    }
    if (($_GET['tec'] != "") && ($_GET['tec'] != "undefined")) {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&tec=".$_GET['tec'];
        $criteria .= $and." ACTIVIDAD_USUARIO.user_id = ".$_GET['tec'];
        $and = " AND ";
    }
    if (($_GET['cat'] != "") && ($_GET['cat'] != "undefined")) {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&tec=".$_GET['cat'];
        $criteria .= $and." ACTIVIDAD.categoria_id = ".$_GET['cat'];
        $and = " AND ";
    }
    if (($_GET['ffin'] != "") && ($_GET['ffin'] != "undefined")) {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&ffin=".$_GET['ffin'];
        $criteria .= $and." ACTIVIDAD.fecha_fin = '".$_GET['ffin']."'";
        $and = " AND ";
    }
    if (($_GET['fsol'] != "") && ($_GET['fsol'] != "undefined")) {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&fsol=".$_GET['fsol'];
        $criteria .= $and.' ACTIVIDAD.fecha_solucion = CAST( "0000-00-00 00:00:00" AS DATETIME )';
        $and = " AND ";
    }
    
    if ($_GET['pag'] != "") {
        $from = ($limit*$_GET['pag']) - $limit;
        $to = $limit*$_GET['pag'];
        $curpage = $_GET['pag'];
    }   
    else {
        $from = 0;
        $to = $limit;
        $curpage = 1;
    }
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                    ACTIVIDAD.id,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.categoria_id,
                    ACTIVIDAD_CATEGORIAS.nombre,
                    ACTIVIDAD.item_id as item,
                    ACTIVIDAD.nombre AS titulo,
                    ACTIVIDAD.fecha,
                    ACTIVIDAD.fecha_mod,
                    CREADA.nombre,
                    ACTIVIDAD_ESTADOS.nombre, 
                    ACTIVIDAD_ESTADOS.color,
                    ACTIVIDAD_PRIORIDADES.nombre, 
                    ACTIVIDAD_PRIORIDADES.color,
                    CLIENTES.nombre,
                    ASIGNADO.nombre,
                    ASIGNADO.id,
                    (SELECT PROYECTOS.ref FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.ref FROM OFERTAS WHERE id = item),
                    (SELECT PROYECTOS.nombre FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.titulo FROM OFERTAS WHERE id = item),
                    TAREAS.nombre,
                    TAREAS.id,
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.fecha_fin
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES
                    ON CLIENTES.id = ACTIVIDAD.cliente_id
                INNER JOIN ACTIVIDAD_CATEGORIAS
                    ON ACTIVIDAD.categoria_id = ACTIVIDAD_CATEGORIAS.id 
                INNER JOIN TAREAS
                    ON ACTIVIDAD.tarea_id = TAREAS.id 
                INNER JOIN ACTIVIDAD_ESTADOS
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                INNER JOIN ACTIVIDAD_PRIORIDADES 
                    ON ACTIVIDAD_PRIORIDADES.id = ACTIVIDAD.prioridad_id
                INNER JOIN erp_users AS CREADA
                    ON ACTIVIDAD.responsable = CREADA.id 
                LEFT JOIN erp_users AS ASIGNADO
                    ON ACTIVIDAD.tecnico_id = ASIGNADO.id 
                INNER JOIN ACTIVIDAD_USUARIO 
                    ON ACTIVIDAD.id=ACTIVIDAD_USUARIO.actividad_id
                ".$criteria."
                ORDER BY 
                    ACTIVIDAD.fecha DESC, ACTIVIDAD.ref DESC";
    file_put_contents("queryAct.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Actividad1");
    $numregistros = mysqli_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);
    
    $sql = "SELECT DISTINCT
                    ACTIVIDAD.id actid,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.categoria_id,
                    ACTIVIDAD_CATEGORIAS.nombre,
                    ACTIVIDAD.item_id as item,
                    ACTIVIDAD.nombre AS titulo,
                    ACTIVIDAD.fecha,
                    ACTIVIDAD.fecha_mod,
                    CREADA.nombre,
                    ACTIVIDAD_ESTADOS.nombre, 
                    ACTIVIDAD_ESTADOS.color,
                    ACTIVIDAD_PRIORIDADES.nombre, 
                    ACTIVIDAD_PRIORIDADES.color,
                    CLIENTES.nombre,
                    ASIGNADO.nombre,
                    ASIGNADO.id,
                    (SELECT PROYECTOS.ref FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.ref FROM OFERTAS WHERE id = item),
                    (SELECT PROYECTOS.nombre FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.titulo FROM OFERTAS WHERE id = item),
                    TAREAS.nombre,
                    TAREAS.id,
                    CREADA.apellidos,
                    ASIGNADO.apellidos,
                    (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.fecha_fin
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES
                    ON CLIENTES.id = ACTIVIDAD.cliente_id
                INNER JOIN ACTIVIDAD_CATEGORIAS
                    ON ACTIVIDAD.categoria_id = ACTIVIDAD_CATEGORIAS.id 
                INNER JOIN TAREAS
                    ON ACTIVIDAD.tarea_id = TAREAS.id 
                INNER JOIN ACTIVIDAD_ESTADOS
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                INNER JOIN ACTIVIDAD_PRIORIDADES 
                    ON ACTIVIDAD_PRIORIDADES.id = ACTIVIDAD.prioridad_id
                INNER JOIN erp_users AS CREADA
                    ON ACTIVIDAD.responsable = CREADA.id 
                LEFT JOIN erp_users AS ASIGNADO
                    ON ACTIVIDAD.tecnico_id = ASIGNADO.id
                INNER JOIN ACTIVIDAD_USUARIO 
                    ON ACTIVIDAD.id=ACTIVIDAD_USUARIO.actividad_id
                ".$criteria."
                ORDER BY 
                    ACTIVIDAD.fecha DESC, ACTIVIDAD.ref DESC
                LIMIT ".$from.", ".$limit;
    
    file_put_contents("queryActividades.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Actividad2");
    
    if ($from == 0) {
        $disabledFirst = "disabled";
    }
    else {
        $disabledFirst = "";
    }
    
    if ($to >= $numregistros) {
        $disabledLast = "disabled";
    }
    else {
        $disabledLast = "";
    }
    
    $pagination = "<div class='one-column' style='padding-left: 20px; padding-top: 0px; padding-bottom: 0px; min-height: 20px;'>
                    <nav aria-label='Page navigation example'>
                      <ul class='pagination'>
                        <li class='page-item ".$disabledFirst."'><a class='page-link' data-pag='1' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-cli='".$_GET['cli']."' data-prior='".$_GET['prior']."' data-estado='".$_GET['estado']."'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' data-pag='".($curpage-1)."' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-cli='".$_GET['cli']."' data-prior='".$_GET['prior']."' data-estado='".$_GET['estado']."' aria-label='Anterior' title='Anterior'>
                            <span aria-hidden='true'>&laquo;</span>
                            <span class='sr-only'>Anterior</span>
                          </a>
                        </li>";
    if ($numpaginas > 10) {
        $dif = 10;
        $index = $curpage;
        $dif = $curpage + $dif;
    }
    else {
        $dif = $numpaginas;
    }
    for ($index = ($curpage-1); $index < $dif; $index++) {
        if (($index+1) == $curpage) {
            $activo = "disabled";
        }
        else {
            $activo = "";
        }
        $pagination .= "<li class='page-item ".$activo."'><a class='page-link' data-pag='".($index+1)."' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-cli='".$_GET['cli']."' data-prior='".$_GET['prior']."' data-estado='".$_GET['estado']."'>".($index+1)."</a></li>";
    }
    $pagination .= "    <li class='page-item ".$disabledLast."'>
                            <a class='page-link' data-pag='".($curpage+1)."' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-cli='".$_GET['cli']."' data-prior='".$_GET['prior']."' data-estado='".$_GET['estado']."' aria-label='Siguiente' title='Siguiente'>
                              <span aria-hidden='true'>&raquo;</span>
                              <span class='sr-only'>Siguiente</span>
                            </a>
                        </li>
                        <li class='page-item ".$disabledLast."'><a class='page-link' data-pag='".$numpaginas."' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-cli='".$_GET['cli']."' data-prior='".$_GET['prior']."' data-estado='".$_GET['estado']."'>Última</a></li>
                      </ul>
                    </nav>
                  </div>";
    
    echo $pagination;
    
    
    
    
?>
<table class="table table-striped table-hover" id='tabla-act'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">REF</th>
            <th class="text-center">F.INI</th>
            <th class="text-center">F.FIN</th>
            <th class="text-center">F.SOLUCIÓN</th>
            <th class="text-center">CATEGORÍA</th>
            <th class="text-center">TITULO</th>
            <th class="text-center">CLIENTE</th>
            <th class="text-center">CÓDIGO</th>
            <th class="text-center">TAREA</th>
            <th class="text-center">ASIGNADO</th>
            <th class="text-center">HORAS</th>
            <th class="text-center">PRIORIDAD</th>
            <th class="text-center">ESTADO</th>
            <th class="text-center">ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
<?
    while ($registros = mysqli_fetch_array($resultado)) { 
        switch ($registros[2]) {
            case 1: // Mantenimiento
                $tipoItemLink = "/erp/apps/mantenimientos/view.php?id=".$registros[4];
                $ref = $registros[16];
                $nombreItem = $registros[18];
                $button = "<button type='button' class='btn btn-info btn-circle get-plan' data-id='".$registros[0]."' data-soltar='0' title='Ir a mantenimiento'><a href=".$tipoItemLink." target='_blank'><img src='/erp/img/link-w.png'></a></button>";
                break;
            case 2: // Intervención
                $tipoItemLink = "/erp/apps/proyecto/view.php?id=".$registros[4];
                $ref = $registros[16];
                $nombreItem = $registros[18];
                $button = "<button type='button' class='btn btn-info btn-circle get-plan' data-id='".$registros[0]."' data-soltar='0' title='Ir a mantenimiento'><a href=".$tipoItemLink." target='_blank'><img src='/erp/img/link-w.png'></a></button>";
                break;
            case 3: // Proyecto
                $tipoItemLink = "/erp/apps/proyectos/view.php?id=".$registros[4];
                $ref = $registros[16];
                $nombreItem = $registros[18];
                $button = "<button type='button' class='btn btn-info btn-circle get-plan' data-id='".$registros[0]."' data-soltar='0' title='Ir a Proyecto'><a href=".$tipoItemLink." target='_blank'><img src='/erp/img/link-w.png'></a></button>";
                break;
            case 4: // Oferta
                $tipoItemLink = "/erp/apps/ofertas/editOferta.php?id=".$registros[4];
                $ref = $registros[17];
                $nombreItem = $registros[19];
                $button = "<button type='button' class='btn btn-info btn-circle get-plan' data-id='".$registros[0]."' data-soltar='0' title='Ir a Oferta'><a href=".$tipoItemLink." target='_blank'><img src='/erp/img/link-w.png'></a></button>";
                break;
            default: // Otro
                $nombreItem = "";
                $tipoItemLink = "";
                $ref = "";
                $button = "";
                break;
        }
        
        /** No se para que esta?¿
        if ($registros[15] == $_SESSION['user_session']) {
            $button = "<button type='button' class='btn btn-success btn-circle get-plan' data-id='".$registros[0]."' data-soltar='1' title='Soltar Tarea'><a href=".$tipoItemLink." target='_blank'><img src='/erp/img/check.png'></a></button>";
        }
        else {
            $button = "<button type='button' class='btn btn-info btn-circle get-plan' data-id='".$registros[0]."' data-soltar='0' title='Coger Tarea'><a href=".$tipoItemLink." target='_blank'><img src='/erp/img/link-w.png'></a></button>";
        }
        */
        $cellPriorStyle = "label-".$registros[12];
        $cellStateStyle = "label-".$registros[10];
        
        if($registros[24] != "") {
            $totalHoras = $registros[24];
        }
        else {
            $totalHoras = 0;
        }
        $dateFin = new DateTime($registros[25]);
        $fecha_fin = $dateFin->format('Y-m-d');;
        $usuariostxt ="";
        // Sacamos los usuarios asignados a la actividad
        $sqlUsers = "SELECT erp_users.id, erp_users.nombre, erp_users.apellidos
                FROM erp_users
                INNER JOIN ACTIVIDAD_USUARIO 
                ON erp_users.id=ACTIVIDAD_USUARIO.user_id
                WHERE ACTIVIDAD_USUARIO.actividad_id=".$registros[0];
        //file_put_contents("usuariosAct.txt", $sqlUsers);
        $resUsers = mysqli_query($connString, $sqlUsers) or die("Error al ejcutar la consulta de usuarios de la actividad");
        while($regUsers = mysqli_fetch_array($resUsers)){
            $usuariostxt.="<p>".$regUsers[1]." ".substr($regUsers[2],0,1).".</p>";
        }
                
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td class='text-center'>".$registros[6]."</td>
                <td class='text-center'>".$registros[26]."</td>
                <td class='text-center'>".$fecha_fin."</td>
                <td>".$registros[3]."</td>
                <td>".$registros[5]."</td>
                <td class='text-center'>".$registros[13]."</td>
                <td>".$ref." - ".$nombreItem."</td>
                <td class='text-center'>".$registros[20]."</td>
                <td class='text-center'>".$usuariostxt."</td>
                <td class='text-center'>".$totalHoras."</td>
                <td class='text-center ".$cellPriorStyle."' ><span class='label ".$cellPriorStyle."'>".$registros[11]."</span></td>
                <td class='text-center ".$cellStateStyle."' ><span class='label ".$cellStateStyle."'>".$registros[9]."</span></td>
                <td class='text-center'>".$button."</td>
            </tr>
        ";
    }
?>

    </tbody>
</table>

<? echo $pagination; ?>

