<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/common.php");
    
    $limit = 20;
    
    if ((($_GET['year'] != "") && ($_GET['year'] != "undefined")) || (($_GET['cli'] != "") && ($_GET['cli'] != "undefined")) || (($_GET['estado'] != "") && ($_GET['undefined'] != ""))) {
        $criteria = "";
        $and = "";
    }
    else {
        $criteria = " AND
                        PROYECTOS.estado_id <> 3 
                      AND 
                        PROYECTOS.estado_id <> 6";
    }
    
    if (($_GET['year'] != "") && ($_GET['year'] != "undefined")) {
        $criteria = " AND YEAR(fecha_ini) = ".$_GET['year'];
    }
    if (($_GET['cli'] != "") && ($_GET['cli'] != "undefined")) {
        $criteria .= " AND PROYECTOS.cliente_id = ".$_GET['cli'];
    }
    if (($_GET['estado'] != "") && ($_GET['estado'] != "undefined")) {
        $criteria .= " AND PROYECTOS.estado_id = ".$_GET['estado'];
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
    
    //$db = new dbObj();
    //$connString =  $db->getConnstring();
    
    $sql = "SELECT 
                    PROYECTOS.id,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.fecha_ini,
                    PROYECTOS.fecha_entrega,
                    PROYECTOS_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PROYECTOS_ESTADOS.color 
                FROM 
                    PROYECTOS, CLIENTES, PROYECTOS_ESTADOS 
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND 
                    PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
                AND
                    PROYECTOS.tipo_proyecto_id = 1 
                ".$criteria."
                ORDER BY 
                    PROYECTOS.fecha_mod DESC,
                    PROYECTOS.fecha_ini DESC";
    
    file_put_contents("queryProyectos1.txt", $sql);
    $resultado = query_bd($sql, "Error al ejcutar la consulta de Proyectos");
    $numregistros = query_bd_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);
    
    if ($fechamod == 1) {
        $sql = "SELECT 
                PROYECTOS.id,
                PROYECTOS.ref,
                PROYECTOS.nombre,
                PROYECTOS.fecha_ini,
                PROYECTOS.fecha_entrega,
                PROYECTOS_ESTADOS.nombre, 
                CLIENTES.nombre, 
                CLIENTES.img,
                PROYECTOS_ESTADOS.color, 
                TIPOS_PROYECTO.nombre, 
                TIPOS_PROYECTO.color,
                PROYECTOS.fecha_mod
            FROM 
                PROYECTOS, CLIENTES, PROYECTOS_ESTADOS, TIPOS_PROYECTO
            WHERE 
                PROYECTOS.cliente_id = CLIENTES.id
            AND 
                PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
            AND 
                PROYECTOS.tipo_proyecto_id = TIPOS_PROYECTO.id 
            AND
                PROYECTOS.tipo_proyecto_id = 1 
            ".$criteria."
            ORDER BY 
                PROYECTOS.ref DESC,
                PROYECTOS.fecha_ini DESC 
            LIMIT ".$from.", ".$limit;
    }
    else {
        $sql = "SELECT 
                    PROYECTOS.id,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.fecha_ini,
                    PROYECTOS.fecha_entrega,
                    PROYECTOS_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PROYECTOS_ESTADOS.color, 
                    TIPOS_PROYECTO.nombre, 
                    TIPOS_PROYECTO.color,
                    PROYECTOS.fecha_mod
                FROM 
                    PROYECTOS, CLIENTES, PROYECTOS_ESTADOS, TIPOS_PROYECTO 
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND 
                    PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
                AND 
                    PROYECTOS.tipo_proyecto_id = TIPOS_PROYECTO.id  
                AND
                    PROYECTOS.tipo_proyecto_id = 1
                ".$criteria."
                ORDER BY 
                    PROYECTOS.ref DESC,
                    PROYECTOS.fecha_ini DESC 
                LIMIT ".$from.", ".$limit;
    }
    file_put_contents("queryProyectos2.txt", $sql);
    $resultado = query_bd($sql, "Error al ejcutar la consulta de Proyectos");
    
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
                        <li class='page-item ".$disabledFirst."'><a class='page-link' data-pag='1' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' data-pag='".($curpage-1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#' aria-label='Anterior' title='Anterior'>
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
        $pagination .= "<li class='page-item ".$activo."'><a class='page-link' data-pag='".($index+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#'>".($index+1)."</a></li>";
    }
    $pagination .= "    <li class='page-item ".$disabledLast."'>
                            <a class='page-link' data-pag='".($curpage+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#' aria-label='Siguiente' title='Siguiente'>
                              <span aria-hidden='true'>&raquo;</span>
                              <span class='sr-only'>Siguiente</span>
                            </a>
                        </li>
                        <li class='page-item ".$disabledLast."'><a class='page-link' data-pag='".$numpaginas."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#'>Última</a></li>
                      </ul>
                    </nav>
                  </div>";
    
    echo $pagination;
?>

<table class="table table-striped table-hover" id='tabla-proyectos'>
    <thead>
      <tr class="bg-dark">
        <th class="text-center">REF</th>
        <th class="text-center">FECHA INICIO</th>
        <th class="text-center">PROYECTO | CLIENTE</th>
        <th class="text-center">TIPO</th>
        <th class="text-center">FECHA ENTREGA</th>
        <th class="text-center">FECHA MOD.</th>
        <th class="text-center">ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?    
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td class='text-center'>".$registros[3]."</td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$registros[7]."'>
                    </div> 
                        <div class='tabla-texto'>
                            ".$registros[2]."<span class='bajotexto'>".$registros[6]."</span>
                        </div>
                </td>
                <td class='text-center'><span class='label label-".$registros[10]."'>".$registros[9]."</span></td>
                <td class='text-center'>".$registros[4]."</td>
                <td class='text-center'>".$registros[11]."</td>
                <td class='text-center'><span class='label label-".$registros[8]."'>".$registros[5]."</span></td>
            </tr>
        ";
    }
?>
    </tbody>
</table>

<? echo $pagination; ?>

