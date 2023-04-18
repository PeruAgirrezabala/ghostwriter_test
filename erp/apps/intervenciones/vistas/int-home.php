<!-- proyectos activos -->
<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $limit = 10;
    
    if (($_GET['year'] != "") || ($_GET['month'] != "") || ($_GET['cli'] != "") || ($_GET['matid'] != "")) {
        $criteria = "";
        $and = "";
        $criteriaLink = "";
    }
    else {
        $criteriaLink = "";
        $criteria = " WHERE YEAR(INTERVENCIONES.fecha) = ".date("Y");
        $and = " AND ";
    }
    
    if ($_GET['year'] != "") {
        $criteriaLink = "&year=".$_GET['year'];
        $criteria .= " WHERE YEAR(INTERVENCIONES.fecha) = ".$_GET['year'];
        $and = " AND ";
        if ($_GET['month'] != "") {
            $criteriaLink .= "&month=".$_GET['month'];
            $criteria .= " AND MONTH(INTERVENCIONES.fecha) = ".$_GET['month'];
        }
    }
    if ($_GET['cli'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&cli=".$_GET['cli'];
        $criteria .= $and." INTERVENCIONES.cliente_id = ".$_GET['prov'];
        $and = " AND ";
    }
    
    if ($_GET['estado'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&estado=".$_GET['estado'];
        $criteria .= $and." INTERVENCIONES.estado_id = ".$_GET['estado'];
        $and = " AND ";
    }
    if ($_GET['matid'] != "") {
        if ($criteria != "") {
            $criteriaLink .= "&matid=".$_GET['matid'];
            $criteria .= $and." INTERVENCIONES_DETALLES.material_id = ".$_GET['matid'];
        }
        else {
            $criteriaLink .= "&matid=".$_GET['matid'];
            $criteria .= " WHERE INTERVENCIONES_DETALLES.material_id = ".$_GET['matid'];
        }
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
                    INTERVENCIONES.id,
                    INTERVENCIONES.ref,
                    INTERVENCIONES.nombre,
                    INTERVENCIONES.fecha,
                    INTERVENCIONES.fecha_mod,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    INTERVENCIONES_ESTADOS.nombre, 
                    INTERVENCIONES_ESTADOS.color,
                    INTERVENCIONES.instalacion,
                    CLIENTES.nombre,
                    OFERTAS.titulo
                FROM 
                    INTERVENCIONES
                LEFT JOIN CLIENTES
                    ON CLIENTES.id = INTERVENCIONES.cliente_id
                INNER JOIN INTERVENCIONES_ESTADOS
                    ON INTERVENCIONES.estado_id = INTERVENCIONES_ESTADOS.id 
                INNER JOIN erp_users 
                    ON INTERVENCIONES.tecnico_id = erp_users.id 
                LEFT JOIN OFERTAS
                    ON OFERTAS.id = INTERVENCIONES.oferta_id 
                LEFT JOIN PROYECTOS
                    ON INTERVENCIONES.proyecto_id = PROYECTOS.id  
                ".$criteria."
                ORDER BY 
                    INTERVENCIONES.fecha DESC";
    file_put_contents("queryInt.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Intervenciones");
    $numregistros = mysqli_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);
    
    $sql = "SELECT 
                    INTERVENCIONES.id,
                    INTERVENCIONES.ref,
                    INTERVENCIONES.nombre,
                    INTERVENCIONES.fecha,
                    INTERVENCIONES.fecha_mod,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    INTERVENCIONES_ESTADOS.nombre, 
                    INTERVENCIONES_ESTADOS.color,
                    INTERVENCIONES.instalacion,
                    A.nombre,
                    OFERTAS.titulo,
                    B.nombre,
                    B.img
                FROM 
                    INTERVENCIONES
                LEFT JOIN CLIENTES A
                    ON A.id = INTERVENCIONES.cliente_id
                INNER JOIN INTERVENCIONES_ESTADOS
                    ON INTERVENCIONES.estado_id = INTERVENCIONES_ESTADOS.id 
                INNER JOIN erp_users 
                    ON INTERVENCIONES.tecnico_id = erp_users.id 
                LEFT JOIN OFERTAS
                    ON OFERTAS.id = INTERVENCIONES.oferta_id 
                LEFT JOIN PROYECTOS
                    ON INTERVENCIONES.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES B
                    ON B.id = PROYECTOS.cliente_id 
                ".$criteria."
                ORDER BY 
                    INTERVENCIONES.fecha DESC
                LIMIT ".$from.", ".$limit;
    
    file_put_contents("queryIntervenciones.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Intervenciones");
    
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
                        <li class='page-item ".$disabledFirst."'><a class='page-link' href='?pag=1".$criteriaLink."'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' href='?pag=".($curpage-1).$criteriaLink."' aria-label='Anterior' title='Anterior'>
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
        $pagination .= "<li class='page-item ".$activo."'><a class='page-link' href='?pag=".($index+1).$criteriaLink."'>".($index+1)."</a></li>";
    }
    $pagination .= "    <li class='page-item ".$disabledLast."'>
                            <a class='page-link' href='?pag=".($curpage+1).$criteriaLink."' aria-label='Siguiente' title='Siguiente'>
                              <span aria-hidden='true'>&raquo;</span>
                              <span class='sr-only'>Siguiente</span>
                            </a>
                        </li>
                        <li class='page-item ".$disabledLast."'><a class='page-link' href='?pag=".$numpaginas.$criteriaLink."'>Última</a></li>
                      </ul>
                    </nav>
                  </div>";
    
    echo $pagination;
?>
<table class="table table-striped table-hover" id='tabla-int'>
    <thead>
      <tr>
        <th>REF</th>
        <th>TITULO</th>
        <th>CLIENTE</th>
        <th>OFERTA</th>
        <th style="min-width: 35%;">PROYECTO | CLIENTE</th>
        <th>INSTALACIÓN</th>
        <th class="text-center">FECHA</th>
        <th class="text-center">TÉCNICO</th>
        <th class="text-center">ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td>".$registros[2]."</td>
                <td>".$registros[10]."</td>
                <td>".$registros[11]."</td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$registros[13]."'>
                    </div> 
                    <div class='tabla-texto'>
                        ".$registros[6]."<span class='bajotexto'>".$registros[12]."</span>
                    </div>
                </td>
                <td>".$registros[9]."</td>
                <td class='text-center'>".$registros[3]."</td>
                <td class='text-center'>".$registros[5]."</td>
                <td class='text-center' ><span class='label label-".$registros[8]."'>".$registros[7]."</span></td>
            </tr>
        ";
    }
?>

    </tbody>
</table>

<? echo $pagination; ?>

