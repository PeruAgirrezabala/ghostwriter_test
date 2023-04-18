<!-- proyectos activos -->

<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $limit = 20;
    
    if (($_GET['year'] != "") || ($_GET['month'] != "") || ($_GET['prov'] != "")) {
        $criteria = " ";
        $and = "";
    }
    else {
        $criteriaLink = "";
        $criteria = "";
    }
    
    if ($_GET['year'] != "") {
        $criteriaLink = "&year=".$_GET['year'];
        $criteria .= "AND  YEAR(fecha) = ".$_GET['year'];
        $and = " AND ";
        if ($_GET['month'] != "") {
            $criteriaLink .= "&month=".$_GET['month'];
            $criteria .= " AND MONTH(fecha) = ".$_GET['month'];
        }
    }else{
        $criteria = "  AND YEAR(fecha) = YEAR(CURDATE()) ";
    }
    if (($_GET['cli'] != "") && ($_GET['cli'] != "undefined")) {
        $criteriaLink .= "&cli=".$_GET['cli'];
        $criteria .= " AND OFERTAS.cliente_id = ".$_GET['cli'];
    }
    //file_put_contents("anyoSeleccionado.txt", $_GET['year']);
    //file_put_contents("criteriaOpcion.txt", $criteria);
//    if (($_GET['estado'] != "") && ($_GET['estado'] != "undefined")) {
//        $criteriaLink .= "&estado=".$_GET['estado'];
//        $criteria .= " AND OFERTAS.estado_id = ".$_GET['estado'];
//    }

    
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
    
    // Seleccionar todas las ofertas padre. 
    // Los criterios principales, serán los mismos... 
    // Dependiendo de esto, ver los estados.
    $sqlSelId="SELECT id, estado_id FROM OFERTAS WHERE 0_ver=0 AND n_ver=0".$criteria;
    file_put_contents("logOfertasSelID.txt", $sqlSelId);
    $resSelId = mysqli_query($connString, $sqlSelId) or die("Error al ejcutar la consulta de Ofertas ID padres.");   
    
    // Criteria para proximos filtros:
    if($criteria!=""){
        $wherecriteria = " WHERE".substr($criteria,5,strlen($criteria));
    }
    
    
    $idOfIn = ""; // Cadena de texto para establecer el IN ID
    $count=0; // Contador para establecer el limite de hojas
    while($regSelId = mysqli_fetch_array($resSelId)){
        
        // $registros[1]; // Estado del padre
        
        $sqlEst="SELECT OFERTAS_ESTADOS.nombre, OFERTAS_ESTADOS.color, OFERTAS.n_ver, OFERTAS.estado_id, OFERTAS.id
                FROM OFERTAS
                 INNER JOIN OFERTAS_ESTADOS
                 ON OFERTAS.estado_id = OFERTAS_ESTADOS.id 
                 WHERE OFERTAS.0_ver=".$regSelId[0]. " AND OFERTAS.estado_id=4";
        $resEst = mysqli_query($connString, $sqlEst) or die("Error al ejecutar la consulta de Ofertas.0");
        $num = mysqli_num_rows($resEst);
        
        // Obtener cual es el estado correspondiente dependiendo de las vesiones.
        // Predomina siempre si el estado es Aceptado.
        if($num > 0){ // Aceptada una version
            $regEst = mysqli_fetch_array($resEst);
            $estado = 4;
            $idOferta = $regEst[4];
            file_put_contents("logkk.txt", $idOferta);
        }elseif($regSelId[1]==4){ // Sino estado del principal (Tambien puede ser aceptado)
            $idOferta = $regSelId[0];
            $estado = 4;
        }elseif($regSelId[1]!=4){
            $idOferta = $regSelId[0];
            $estado = $regSelId[1];
        }
        // Si el estado del filtro y de la oferta coninciden
        // Puede ser que la oferta no se haya filtrado, entonces siempre entra.
        if(($_GET['estado']==$estado)){
            // Establecer un contrador para el límite de hojas.
            $count++;
            // Anidar a la cadena de texto del IN
            if($idOfIn != ""){
                $idOfIn .= ", ".$idOferta;
            }else{
                $idOfIn .=$idOferta;
            }
        }elseif($_GET['estado']==""){
            $count++;
        } 
    }
    // Estructurar correctamente la clausula IN
    if(($_GET['estado'] == "") || ($_GET['estado']=="undefined")){
        $idOfIn = "";
    }else{
        if($idOfIn == ""){ // Por si existe alguna casuistica sin ningún estado seleccionado
            $idOfIn = " AND OFERTAS.estado_id=".$_GET['estado'];
        }else{
            $idOfIn = " AND OFERTAS.id IN (".$idOfIn.")";
        }
    }

    // Ver numero de registros y sacar el número de páginas.
    $numregistros = $count;
    $numpaginas = ceil($numregistros/$limit);

    // Sacar las páginas correspondientes.
    if ($fechamod == 1) {
        // $idOfIn
        $sql = "SELECT 
                    OFERTAS.id,
                    OFERTAS.ref,
                    OFERTAS.titulo,
                    OFERTAS.fecha,
                    OFERTAS.fecha_validez,
                    OFERTAS_ESTADOS.nombre, 
                    CLI1.nombre, 
                    CLI1.img,
                    OFERTAS_ESTADOS.color,
                    CLI2.nombre, 
                    CLI2.img,
                    PROYECTOS.nombre,
                    OFERTAS.estado_id
                FROM 
                    OFERTAS
                INNER JOIN OFERTAS_ESTADOS
                    ON OFERTAS.estado_id = OFERTAS_ESTADOS.id 
                LEFT JOIN PROYECTOS
                    ON OFERTAS.proyecto_id = PROYECTOS.id
                LEFT JOIN CLIENTES as CLI1
                    ON PROYECTOS.cliente_id = CLI1.id
                LEFT JOIN CLIENTES as CLI2
                    ON OFERTAS.cliente_id = CLI2.id  
                ".$wherecriteria."
                ORDER BY 
                    OFERTAS.ref DESC
                LIMIT ".$from.", ".$limit;
    }else{
        $sql = "SELECT 
                    OFERTAS.id,
                    OFERTAS.ref,
                    OFERTAS.titulo,
                    OFERTAS.fecha,
                    OFERTAS.fecha_validez,
                    OFERTAS_ESTADOS.nombre, 
                    CLI1.nombre, 
                    CLI1.img,
                    OFERTAS_ESTADOS.color, 
                    CLI2.nombre, 
                    CLI2.img,
                    PROYECTOS.nombre,
                    OFERTAS.estado_id
                FROM 
                    OFERTAS
                INNER JOIN OFERTAS_ESTADOS
                    ON OFERTAS.estado_id = OFERTAS_ESTADOS.id 
                LEFT JOIN PROYECTOS
                    ON OFERTAS.proyecto_id = PROYECTOS.id
                LEFT JOIN CLIENTES as CLI1
                    ON PROYECTOS.cliente_id = CLI1.id
                LEFT JOIN CLIENTES as CLI2
                    ON OFERTAS.cliente_id = CLI2.id   
                ".$wherecriteria."
                ORDER BY 
                    OFERTAS.ref DESC
                LIMIT ".$from.", ".$limit;
    }
    file_put_contents("logOfertas0.txt", $sql."...............".$wherecriteria);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Ofertas. No hay nada que mostrar para estos filtros.");
    
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
                        <li class='page-item ".$disabledFirst."'><a class='page-link' data-pag='1' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#tabla-ofertas-container'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' data-pag='".($curpage-1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#tabla-ofertas-container' aria-label='Anterior' title='Anterior'>
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
        $pagination .= "<li class='page-item ".$activo."'><a class='page-link' data-pag='".($index+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#tabla-ofertas-container'>".($index+1)."</a></li>";
    }
    $pagination .= "    <li class='page-item ".$disabledLast."'>
                            <a class='page-link' data-pag='".($curpage+1)."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#tabla-ofertas-container' aria-label='Siguiente' title='Siguiente'>
                              <span aria-hidden='true'>&raquo;</span>
                              <span class='sr-only'>Siguiente</span>
                            </a>
                        </li>
                        <li class='page-item ".$disabledLast."'><a class='page-link' data-pag='".$numpaginas."' data-year='".$_GET['year']."' data-cli='".$_GET['cli']."' data-estado='".$_GET['estado']."' href='#tabla-ofertas-container'>Última</a></li>
                      </ul>
                    </nav>
                  </div>";
    echo $pagination;
?>

<table class="table table-striped table-hover" id='tabla-proyectos'>
    <thead>
      <tr>
        <th>REF</th>
        <th>FECHA</th>
        <th>OFERTA | CLIENTE</th>
        <th>FECHA VALIDEZ</th>
        <th>ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?
    while ($registros = mysqli_fetch_array($resultado)) { 
        if ($registros[11] != "") {
            $cliente = $registros[6];
            $clienteimg = $registros[7];
        }else{
            $cliente = $registros[9];
            $clienteimg = $registros[10];
        }
        
        /****/
        // Se comprueba si la vesión aceptada es la versión A u es otra.
        $sqlEst="SELECT OFERTAS_ESTADOS.nombre, OFERTAS_ESTADOS.color, OFERTAS.n_ver FROM OFERTAS
                 INNER JOIN OFERTAS_ESTADOS
                 ON OFERTAS.estado_id = OFERTAS_ESTADOS.id 
                 WHERE OFERTAS.id=".$registros[0]." and OFERTAS.estado_id=4";
        $resEst = mysqli_query($connString, $sqlEst) or die("Error al ejcutar la consulta de Ofertas");
        $num = mysqli_num_rows($resEst);
        
        $ok=true;
        $regEst=mysqli_fetch_array($resEst);
        if($regEst[2] > 0){ // Aceptada una version
            $titulo="Esta aceptado en la versión: ".chr($regEst[1]+65+$regEst[2]);
            $nombre=$regEst[0];
            $color=$regEst[1];
            if($_GET['estado']!=4){
                $ok=false;
            }
        }else{ // Sino estado del principal (Tambien puede ser aceptado)
            $nombre=$registros[5];
            $color=$registros[8];
            if($registros[12]==4){
                $titulo="Esta aceptada le versión: A";
            }else{
                $titulo=$registros[5]."-";
            }
        }
        
        if($ok){
        echo "<tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td>".$registros[3]."</td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$clienteimg."'>
                    </div> 
                        <div class='tabla-texto'>
                            ".$registros[2]."<span class='bajotexto'>".$cliente."</span>
                        </div>
                </td>
                <td>".$registros[4]."</td>
                <td><span class='label label-".$color."' title='".$titulo."'>".$nombre."</span></td>
            </tr>";
        }
    }
?>

    </tbody>
</table>

<? echo $pagination; ?>

<!-- proyectos activos -->