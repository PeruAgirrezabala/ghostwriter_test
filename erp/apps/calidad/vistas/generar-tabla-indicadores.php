<?
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    
    if(($_GET['linked']) != ""){
        echo generarTabla($_GET['linked']);
    }
    
    function generarTabla($id){
        switch ($id){
            case 7: // DESVIACIÓN ECONOMICA
                
                $db = new dbObj();
                $connString =  $db->getConnstring();
                
                
                    //////////////////////////////////////////////
                    // control de que meter
                    /////////////////////////////////////////////
                     
                    /* Control de páginas */
                    $limit = 20;
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
                    
                    $criteria="";
                    if (($_GET['year'] != "")) {
                        $criteria .= " AND YEAR(PROYECTOS.fecha_ini) = ".$_GET['year'];
                    }
                    if (($_GET['resultado'] != "")) {
                        if($_GET['resultado']==1){
                            $resultadook=1;
                        }
                        if($_GET['resultado']==0){
                            $resultadook="NO";
                        }
                        // ?¿?¿ como?¿
                        //$criteria .= " AND PROYECTOS.cliente_id = ".$_GET['cli'];
                    }else{
                        $resultadook="";
                    }
                    if (($_GET['proyecto'] != "")) {
                        $criteria .= " AND PROYECTOS.id = ".$_GET['proyecto'];
                    }
                    
                    /**************/
                
                
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
                    AND
                        PROYECTOS.estado_id <> 3 
                    AND 
                        PROYECTOS.estado_id <> 6
                    AND
                        YEAR(PROYECTOS.fecha_ini)>=2020
                    ".$criteria."
                    ORDER BY 
                        PROYECTOS.fecha_mod DESC,
                        PROYECTOS.fecha_ini DESC";
                    file_put_contents("selectProyectos.txt", $sql);
                    $res = mysqli_query($connString, $sql) or die("Error al seleccionar proyectos");
                    //$numregistros = query_bd_num_rows($res);
                    $numregistros = mysqli_num_rows($res);
                    $numpaginas = ceil($numregistros/$limit);
                    
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
                        <li class='page-item ".$disabledFirst."'><a class='page-link' data-pag='1' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' data-pag='".($curpage-1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' aria-label='Anterior' title='Anterior'>
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
                            $pagination .= "<li class='page-item ".$activo."'><a class='page-link' data-pag='".($index+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' >".($index+1)."</a></li>";
                        }
                        $pagination .= "    <li class='page-item ".$disabledLast."'>
                                                <a class='page-link' data-pag='".($curpage+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' aria-label='Siguiente' title='Siguiente'>
                                                  <span aria-hidden='true'>&raquo;</span>
                                                  <span class='sr-only'>Siguiente</span>
                                                </a>
                                            </li>
                                            <li class='page-item ".$disabledLast."'><a class='page-link' data-pag='".$numpaginas."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' >Última</a></li>
                                          </ul>
                                        </nav>
                                      </div>";
                    
                    
                    
                    $ahtml=$pagination."<table class='table table-striped table-hover' id='tabla-calidad-indicadorX'>
                    <thead>
                        <tr class='bg-dark'>
                            <th>FECHA</th>
                            <th>PROYECTO</th>
                            <th>INDICADOR/VALOR</th>
                            <th>META</th>
                            <th>ESTADO</th>
                            <th>FECHA CIERRE</th>
                        </tr>
                    </thead>
                    <tbody>";
                    
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
                    AND
                        PROYECTOS.estado_id <> 3 
                    AND 
                        PROYECTOS.estado_id <> 6
                    ".$criteria."
                    ORDER BY 
                        PROYECTOS.fecha_ini DESC
                        LIMIT ".$from.", ".$limit;
                    file_put_contents("selectProyectosLimits.txt", $sql);
                    $res = mysqli_query($connString, $sql) or die("Error al seleccionar proyectos con limites");
                    
                    
                    $meta="<=1";  // HAY QUE COGERLO AUTOMÁTICAMENTE DE LA BASE DE DATOS.... Pendiente
                    preg_match_all('!\d+!', $meta, $numerometa);
                    $condicion=str_replace($numerometa[0], '', $meta);
                    $num=str_replace($condicion, '', $meta);
                    // Valores utiles: $condicion y $num
                    /////////////////////////////////////////////
                    while ($row = mysqli_fetch_array($res)) {
                        // Generar rumero random 0.9-1.1
                        $valor_random = mt_rand(0.9*1000000,1.1*1000000)/1000000;
                        $valor=number_format($valor_random,2);
                        switch ($resultadook){
                            case "":
                                if($valor <= $num){
                                    $estado='<span class="label label-success">OK</span>';
                                    $ahtml.="<tr data-id='??' value='00'>
                                    <td class='text-left'>".$row[3]."</td>
                                    <td class='text-left'>".$row[2]."</td>
                                    <td class='text-left'>".number_format($valor_random,2)."</td>
                                    <td class='text-left'>".$meta."</td>
                                    <td class='text-left'>".$estado."</td>
                                    <td class='text-left'>Fecha cierre</td>
                                </tr>";
                                }else{
                                    $estado='<span class="label label-danger">NO-OK</span>';
                                    $ahtml.="<tr data-id='??' value='00'>
                                    <td class='text-left'>".$row[3]."</td>
                                    <td class='text-left'>".$row[2]."</td>
                                    <td class='text-left'>".number_format($valor_random,2)."</td>
                                    <td class='text-left'>".$meta."</td>
                                    <td class='text-left'>".$estado."</td>
                                    <td class='text-left'>Fecha cierre</td>
                                </tr>";
                                }
                                
                                break;
                            case 1:
                                if($valor <= $num){
                                    $estado='<span class="label label-success">OK</span>';
                                    $ahtml.="<tr data-id='??' value='00'>
                                    <td class='text-left'>".$row[3]."</td>
                                    <td class='text-left'>".$row[2]."</td>
                                    <td class='text-left'>".number_format($valor_random,2)."</td>
                                    <td class='text-left'>".$meta."</td>
                                    <td class='text-left'>".$estado."</td>
                                    <td class='text-left'>Fecha cierre</td>
                                    </tr>";
                                }
                                
                                break;
                            case "NO":
                                if($valor <= $num){
                                    
                                }else{
                                    $estado='<span class="label label-danger">NO-OK</span>';
                                    $ahtml.="<tr data-id='??' value='00'>
                                    <td class='text-left'>".$row[3]."</td>
                                    <td class='text-left'>".$row[2]."</td>
                                    <td class='text-left'>".number_format($valor_random,2)."</td>
                                    <td class='text-left'>".$meta."</td>
                                    <td class='text-left'>".$estado."</td>
                                    <td class='text-left'>Fecha cierre</td>
                                    </tr>";
                                }
                                break;
                            default:
                                break;
                        }
                        
                    }
                    
                $ahtml.="</tbody>
                </table>";
                break;
            case 8: // NO CONFORMIDADES
                
                $db = new dbObj();
                $connString =  $db->getConnstring();
                
                
                    //////////////////////////////////////////////
                    // control de que meter
                    /////////////////////////////////////////////
                     
                    /* Control de páginas */
                    $limit = 20;
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
                    
                    $criteria="";
                    if (($_GET['year'] != "")) {
                        $criteria .= " AND YEAR(PROYECTOS.fecha_ini) = ".$_GET['year'];
                    }
                    if (($_GET['resultado'] != "")) {
                        if($_GET['resultado']==1){
                            $resultadook=1;
                        }
                        if($_GET['resultado']==0){
                            $resultadook="NO";
                        }
                        // ?¿?¿ como?¿
                        //$criteria .= " AND PROYECTOS.cliente_id = ".$_GET['cli'];
                    }else{
                        $resultadook="";
                    }
                    if (($_GET['proyecto'] != "")) {
                        $criteria .= " AND PROYECTOS.id = ".$_GET['proyecto'];
                    }
                    
                    /**************/
                
                
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
                    AND
                        PROYECTOS.estado_id <> 3 
                    AND 
                        PROYECTOS.estado_id <> 6
                    ".$criteria."
                    ORDER BY 
                        PROYECTOS.fecha_mod DESC,
                        PROYECTOS.fecha_ini DESC";
                    file_put_contents("selectProyectos.txt", $sql);
                    $res = mysqli_query($connString, $sql) or die("Error al seleccionar proyectos");
                    //$numregistros = query_bd_num_rows($res);
                    $numregistros = mysqli_num_rows($res);
                    $numpaginas = ceil($numregistros/$limit);
                    
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
                        <li class='page-item ".$disabledFirst."'><a class='page-link' data-pag='1' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' data-pag='".($curpage-1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' aria-label='Anterior' title='Anterior'>
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
                            $pagination .= "<li class='page-item ".$activo."'><a class='page-link' data-pag='".($index+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' >".($index+1)."</a></li>";
                        }
                        $pagination .= "    <li class='page-item ".$disabledLast."'>
                                                <a class='page-link' data-pag='".($curpage+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' aria-label='Siguiente' title='Siguiente'>
                                                  <span aria-hidden='true'>&raquo;</span>
                                                  <span class='sr-only'>Siguiente</span>
                                                </a>
                                            </li>
                                            <li class='page-item ".$disabledLast."'><a class='page-link' data-pag='".$numpaginas."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' >Última</a></li>
                                          </ul>
                                        </nav>
                                      </div>";
                    
                    
                    
                    $ahtml=$pagination."<table class='table table-striped table-hover' id='tabla-calidad-indicadorX'>
                    <thead>
                        <tr class='bg-dark'>
                            <th>FECHA</th>
                            <th>PROYECTO</th>
                            <th>CANTIDAD</th>
                            <th>META</th>
                            <th>ESTADO</th>
                            <th>FECHA CIERRE</th>
                        </tr>
                    </thead>
                    <tbody>";
                    
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
                    AND
                        PROYECTOS.estado_id <> 3 
                    AND 
                        PROYECTOS.estado_id <> 6
                    ".$criteria."
                    ORDER BY 
                        PROYECTOS.fecha_ini DESC
                        LIMIT ".$from.", ".$limit;
                    file_put_contents("selectProyectosLimits.txt", $sql);
                    $res = mysqli_query($connString, $sql) or die("Error al seleccionar proyectos con limites");
                    
                    
                    $meta="=0";  // HAY QUE COGERLO AUTOMÁTICAMENTE DE LA BASE DE DATOS.... Pendiente
                    preg_match_all('!\d+!', $meta, $numerometa);
                    $condicion=str_replace($numerometa[0], '', $meta);
                    $num=str_replace($condicion, '', $meta);
                    // Valores utiles: $condicion y $num
                    /////////////////////////////////////////////
                    while ($row = mysqli_fetch_array($res)) {
                        // Generar rumero random 0.9-1.1
                        $valor_random = mt_rand(0.9*1000000,1.1*1000000)/1000000;
                        $valor=number_format($valor_random,2);
                        
                        $sqlNoConf="SELECT CALIDAD_NOCONFORMIDADES.proyecto_id, COUNT(CALIDAD_NOCONFORMIDADES.id) as cant
                                FROM CALIDAD_NOCONFORMIDADES 
                                WHERE CALIDAD_NOCONFORMIDADES.proyecto_id=".$row[0]."
                                GROUP BY CALIDAD_NOCONFORMIDADES.proyecto_id";
                        file_put_contents("selectProyectosNoConf.txt", $sqlNoConf);
                        $resNoConf = mysqli_query($connString, $sqlNoConf);
                        $row_cnt = mysqli_num_rows($resNoConf);
                        $rowNoConf = mysqli_fetch_array($resNoConf);
                        
                        if($row_cnt >=1){
                            $estado='<span class="label label-danger">NO-OK</span>';
                            $ahtml.="<tr data-id='??' value='00'>
                                    <td class='text-left'>".$row[3]."</td>
                                    <td class='text-left'>".$row[2]."</td>
                                    <td class='text-left'>".$rowNoConf[1]."</td>
                                    <td class='text-left'>".$meta."</td>
                                    <td class='text-left'>".$estado."</td>
                                    <td class='text-left'>Fecha cierre</td>
                                </tr>";
                        }else{
                            $estado='<span class="label label-success">OK</span>';
                            $ahtml.="<tr data-id='??' value='00'>
                                    <td class='text-left'>".$row[3]."</td>
                                    <td class='text-left'>".$row[2]."</td>
                                    <td class='text-left'>0</td>
                                    <td class='text-left'>".$meta."</td>
                                    <td class='text-left'>".$estado."</td>
                                    <td class='text-left'>Fecha cierre</td>
                                </tr>";
                        }
                    }
                    
                $ahtml.="</tbody>
                </table>";
                break;
            case 9: // AVERIAS
                
                $db = new dbObj();
                $connString =  $db->getConnstring();
                
                
                    //////////////////////////////////////////////
                    // control de que meter
                    /////////////////////////////////////////////
                     
                    /* Control de páginas */
                    $limit = 20;
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
                    
                    $criteria="";
                    if (($_GET['year'] != "")) {
                        $criteria .= " AND YEAR(PROYECTOS.fecha_ini) = ".$_GET['year'];
                    }
                    if (($_GET['resultado'] != "")) {
                        if($_GET['resultado']==1){
                            $resultadook=1;
                        }
                        if($_GET['resultado']==0){
                            $resultadook="NO";
                        }
                        // ?¿?¿ como?¿
                        //$criteria .= " AND PROYECTOS.cliente_id = ".$_GET['cli'];
                    }else{
                        $resultadook="";
                    }
                    if (($_GET['proyecto'] != "")) {
                        $criteria .= " AND PROYECTOS.id = ".$_GET['proyecto'];
                    }
                    
                    /**************/
                
                
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
                    AND
                        PROYECTOS.estado_id <> 3 
                    AND 
                        PROYECTOS.estado_id <> 6
                    AND
                        YEAR(PROYECTOS.fecha_ini)>=2020
                    ".$criteria."
                    ORDER BY 
                        PROYECTOS.fecha_mod DESC,
                        PROYECTOS.fecha_ini DESC";
                    file_put_contents("selectProyectos.txt", $sql);
                    $res = mysqli_query($connString, $sql) or die("Error al seleccionar proyectos");
                    //$numregistros = query_bd_num_rows($res);
                    $numregistros = mysqli_num_rows($res);
                    $numpaginas = ceil($numregistros/$limit);
                    
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
                        <li class='page-item ".$disabledFirst."'><a class='page-link' data-pag='1' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' data-pag='".($curpage-1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' aria-label='Anterior' title='Anterior'>
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
                            $pagination .= "<li class='page-item ".$activo."'><a class='page-link' data-pag='".($index+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' >".($index+1)."</a></li>";
                        }
                        $pagination .= "    <li class='page-item ".$disabledLast."'>
                                                <a class='page-link' data-pag='".($curpage+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' aria-label='Siguiente' title='Siguiente'>
                                                  <span aria-hidden='true'>&raquo;</span>
                                                  <span class='sr-only'>Siguiente</span>
                                                </a>
                                            </li>
                                            <li class='page-item ".$disabledLast."'><a class='page-link' data-pag='".$numpaginas."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' >Última</a></li>
                                          </ul>
                                        </nav>
                                      </div>";
                    
                    
                    
                    $ahtml=$pagination."<table class='table table-striped table-hover' id='tabla-calidad-indicadorX'>
                    <thead>
                        <tr class='bg-dark'>
                            <th>FECHA</th>
                            <th>PROYECTO</th>
                            <th>NºAVERIAS</th>
                            <th>META</th>
                            <th>ESTADO222</th>
                            <th>FECHA CIERRE</th>
                        </tr>
                    </thead>
                    <tbody>";
                    
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
                    AND
                        PROYECTOS.estado_id <> 3 
                    AND 
                        PROYECTOS.estado_id <> 6
                    ".$criteria."
                    ORDER BY 
                        PROYECTOS.fecha_ini DESC
                        LIMIT ".$from.", ".$limit;
                    file_put_contents("selectProyectosLimits.txt", $sql);
                    $res = mysqli_query($connString, $sql) or die("Error al seleccionar proyectos con limites");
                    
                    
                    $meta="=0";  // HAY QUE COGERLO AUTOMÁTICAMENTE DE LA BASE DE DATOS.... Pendiente
                    preg_match_all('!\d+!', $meta, $numerometa);
                    $condicion=str_replace($numerometa[0], '', $meta);
                    $num=str_replace($condicion, '', $meta);
                    // Valores utiles: $condicion y $num
                    /////////////////////////////////////////////
                    while ($row = mysqli_fetch_array($res)) {
                        // Generar rumero random 0.9-1.1
                        //$valor_random = random_int(0,4);
                        $valor_random = round(mt_rand(0.1*1000000,0.54*1000000)/1000000); // La mayoría serán 0                        
                        
                        $valor=$valor_random;
                        if($valor == 0){
                            $estado='<span class="label label-success">OK</span>';
                            $ahtml.="<tr data-id='??' value='00'>
                            <td class='text-left'>".$row[3]."</td>
                            <td class='text-left'>".$row[2]."</td>
                            <td class='text-left'>".$valor."</td>
                            <td class='text-left'>".$meta."</td>
                            <td class='text-left'>".$estado."</td>
                            <td class='text-left'>Fecha cierre</td>
                            </tr>";
                        }else{
                            $estado='<span class="label label-danger">NO-OK</span>';
                            $ahtml.="<tr data-id='??' value='00'>
                            <td class='text-left'>".$row[3]."</td>
                            <td class='text-left'>".$row[2]."</td>
                            <td class='text-left'>".$valor."</td>
                            <td class='text-left'>".$meta."</td>
                            <td class='text-left'>".$estado."</td>
                            <td class='text-left'>Fecha cierre</td>
                            </tr>";
                        }
                    }
                    
                $ahtml.="</tbody>
                </table>";
                break;
            default :
                $ahtml="No hay nada creado: ".$id;
                break;
        }
             return $ahtml;
    }
?>