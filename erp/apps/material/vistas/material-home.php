<?  
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    include($pathraiz."/common.php");
    
    checkPedidosEstados();
    
    $limit = 20;
    
    if (($_GET['year'] != "") || ($_GET['month'] != "") || ($_GET['prov'] != "") || ($_GET['matid'] != "") || ($_GET['estado'] != "") || ($_GET['proyecto'] != "") || ($_GET['cliente'] != "")) {
        $criteria = "";
        $and = "";
        $criteriaLink = "";
    }
    else {
        $criteriaLink = "";
        $criteria = "";
        $and = " AND ";
    }
    
    if ($_GET['year'] != "") {
        $criteriaLink = "&year=".$_GET['year'];
        $criteria .= " WHERE YEAR(fecha) = ".$_GET['year'];
        $and = " AND ";
        if ($_GET['month'] != "") {
            $criteriaLink .= "&month=".$_GET['month'];
            $criteria .= " AND MONTH(fecha) = ".$_GET['month'];
        }
    }
    if ($_GET['prov'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&prov=".$_GET['prov'];
        $criteria .= $and." PEDIDOS_PROV.proveedor_id = ".$_GET['prov'];
        $and = " AND ";
    }
    if ($_GET['proyecto'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&proyecto=".$_GET['proyecto'];
        $criteria .= $and." PEDIDOS_PROV.proyecto_id = ".$_GET['proyecto'];
        $and = " AND ";
    }
    if ($_GET['cliente'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&cliente=".$_GET['cliente'];
        $criteria .= $and." PEDIDOS_PROV_DETALLES.cliente_id = ".$_GET['cliente'];
        $and = " AND ";
    }
    
    if ($_GET['estado'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        
        if ($_GET['estado'] == 99) {
            $criteriaLink .= "&estado=".$_GET['estado'];
            $criteria .= $and." PEDIDOS_PROV.estado_id <> 2 AND PEDIDOS_PROV.estado_id <> 4 AND PEDIDOS_PROV.estado_id <> 5 AND PEDIDOS_PROV.estado_id <> 6 AND PEDIDOS_PROV.estado_id <> 7 ";
            $and = " AND ";
        }
        else {
            $criteriaLink .= "&estado=".$_GET['estado'];
            $criteria .= $and." PEDIDOS_PROV.estado_id = ".$_GET['estado'];
            $and = " AND ";
        }
    }
    if ($_GET['matid'] != "") {
        if ($criteria != "") {
            $criteriaLink .= "&matid=".$_GET['matid'];
            $criteria .= $and." PEDIDOS_PROV_DETALLES.material_id = ".$_GET['matid'];
        }
        else {
            $criteriaLink .= "&matid=".$_GET['matid'];
            $criteria .= " WHERE PEDIDOS_PROV_DETALLES.material_id = ".$_GET['matid'];
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
    if ($fechamod == 1) {
        $sql = "SELECT 
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.pedido_genelek,
                    PEDIDOS_PROV.titulo,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV.ref_oferta_prov
                    PEDIDOS_PROV.estado_id
                FROM 
                    PEDIDOS_PROV
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN PROVEEDORES 
                    ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id 
                INNER JOIN erp_users 
                    ON PEDIDOS_PROV.tecnico_id = erp_users.id 
		LEFT JOIN PEDIDOS_PROV_DETALLES
		    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                LEFT JOIN PROYECTOS
                    ON PEDIDOS_PROV.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES
                    ON PEDIDOS_PROV_DETALLES.cliente_id = CLIENTES.id
                ".$criteria."
                GROUP BY 
                    PEDIDOS_PROV.id 
                ORDER BY 
                    PEDIDOS_PROV.fecha DESC, PEDIDOS_PROV.pedido_genelek DESC";
    }
    else {
        $sql = "SELECT 
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.pedido_genelek,
                    PEDIDOS_PROV.titulo,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV.ref_oferta_prov,
                    PEDIDOS_PROV.estado_id
                FROM 
                    PEDIDOS_PROV
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN PROVEEDORES 
                    ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id 
                INNER JOIN erp_users 
                    ON PEDIDOS_PROV.tecnico_id = erp_users.id 
		LEFT JOIN PEDIDOS_PROV_DETALLES
		    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                LEFT JOIN PROYECTOS
                    ON PEDIDOS_PROV.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES
                    ON PEDIDOS_PROV_DETALLES.cliente_id = CLIENTES.id
                ".$criteria."
                GROUP BY 
                    PEDIDOS_PROV.id 
                ORDER BY 
                    PEDIDOS_PROV.fecha DESC, PEDIDOS_PROV.pedido_genelek DESC";
    }
    file_put_contents("queryPedidos.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Pedidos");
    $numregistros = mysqli_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);
    
    if ($fechamod == 1) {
        $sql = "SELECT 
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.pedido_genelek,
                    PEDIDOS_PROV.titulo,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV.ref_oferta_prov,
                    PEDIDOS_PROV.estado_id
                FROM 
                    PEDIDOS_PROV
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN PROVEEDORES 
                    ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id 
                INNER JOIN erp_users 
                    ON PEDIDOS_PROV.tecnico_id = erp_users.id 
		LEFT JOIN PEDIDOS_PROV_DETALLES
		    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                LEFT JOIN PROYECTOS
                    ON PEDIDOS_PROV.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES
                    ON PROYECTOS.cliente_id = CLIENTES.id
                ".$criteria."
                GROUP BY 
                    PEDIDOS_PROV.id 
                ORDER BY 
                    PEDIDOS_PROV.fecha DESC, PEDIDOS_PROV.pedido_genelek DESC
                LIMIT ".$from.", ".$limit;
    }
    else {
        $sql = "SELECT 
                    PEDIDOS_PROV.id pedido,
                    PEDIDOS_PROV.pedido_genelek,
                    PEDIDOS_PROV.titulo,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV.ref_oferta_prov,
                    (SELECT GROUP_CONCAT(DISTINCT PROYECTOS.nombre) FROM PROYECTOS, PEDIDOS_PROV_DETALLES WHERE PEDIDOS_PROV_DETALLES.proyecto_id = PROYECTOS.id AND PEDIDOS_PROV_DETALLES.pedido_id = pedido) as expedientes,
                    (SELECT count(*) as pendientes FROM `PEDIDOS_PROV_DETALLES` WHERE pedido_id = pedido AND recibido = 0),
                    (SELECT count(*) as recibidos FROM `PEDIDOS_PROV_DETALLES` WHERE pedido_id = pedido AND recibido = 1),
                    PEDIDOS_PROV.estado_id,
                    erp_users.apellidos
                FROM 
                    PEDIDOS_PROV
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN PROVEEDORES 
                    ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id 
                INNER JOIN erp_users 
                    ON PEDIDOS_PROV.tecnico_id = erp_users.id 
		LEFT JOIN PEDIDOS_PROV_DETALLES
		    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                LEFT JOIN PROYECTOS
                    ON PEDIDOS_PROV.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES
                    ON PROYECTOS.cliente_id = CLIENTES.id
                ".$criteria."
                GROUP BY 
                    PEDIDOS_PROV.id 
                ORDER BY 
                    PEDIDOS_PROV.fecha DESC, PEDIDOS_PROV.pedido_genelek DESC
                LIMIT ".$from.", ".$limit;
    }
    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Pedidos");
    
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
                        <li class='page-item ".$disabledFirst."'><a class='page-link' data-pag='1' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-prov='".$_GET['prov']."' data-estado='".$_GET['estado']."' href='#'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' data-pag='".($curpage-1)."' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-prov='".$_GET['prov']."' data-estado='".$_GET['estado']."' href='#' aria-label='Anterior' title='Anterior'>
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
        $pagination .= "<li class='page-item ".$activo."'><a class='page-link' data-pag='".($index+1)."' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-prov='".$_GET['prov']."' data-estado='".$_GET['estado']."' href='#'>".($index+1)."</a></li>";
    }
    $pagination .= "    <li class='page-item ".$disabledLast."'>
                            <a class='page-link' data-pag='".($curpage+1)."' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-prov='".$_GET['prov']."' data-estado='".$_GET['estado']."' href='#' aria-label='Siguiente' title='Siguiente'>
                              <span aria-hidden='true'>&raquo;</span>
                              <span class='sr-only'>Siguiente</span>
                            </a>
                        </li>
                        <li class='page-item ".$disabledLast."'><a class='page-link' data-pag='".$numpaginas."' data-year='".$_GET['year']."' data-month='".$_GET['month']."' data-prov='".$_GET['prov']."' data-estado='".$_GET['estado']."' href='#'>Última</a></li>
                      </ul>
                    </nav>
                  </div>";
    
    echo $pagination;
?>
    
<table class="table table-striped table-hover" id='tabla-pedidos'>
    <thead>
      <tr class="bg-dark">
        <th class="text-center">REF</th>
        <th class="text-center">TITULO</th>
        <th class="text-center">PROVEEDOR</th>
        <th class="text-center" style="min-width: 35%;">PROYECTO | CLIENTE</th>
        <th class="text-center">FECHA</th>
        <th class="text-center">ENTREGA</th>
        <th class="text-center">DE</th>
        <th class="text-center">ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?

    while ($registros = mysqli_fetch_array($resultado)) { 
        if (($registros[15] <> 0) && ($registros[16] <> 0) && ($registros[17] <> 8)) {
            $colorestado = "primary-warning";
            $estadotitle = "A medias";
            $sql2 = "UPDATE PEDIDOS_PROV SET estado_id = 8 WHERE id = ".$registros[0];
            $resultadoAmedias = mysqli_query($connString, $sql2) or die("Error al actualizar Pedidos");
        }
        else {
            $colorestado = $registros[11];
            $estadotitle = $registros[8];
        }
        
        $fecha_entrega = strtotime($registros[5]);
        $fecha_entrega = date("Y-m-d", $fecha_entrega);
        if ((date("Y-m-d") > $fecha_entrega) && (($registros[17] < 4) || ($registros[17] > 7))) {
            $fecha_entrega = $registros[5]."<span class='blink_me' title='Pedido Retrasado'><img src='/erp/img/warning-test.png'></span>";
        }
        else {
            $fecha_entrega = $registros[5];
        }
        
        echo "<tr data-id='".$registros[0]."' data-toggle='tooltip' data-container='body' title='EXP: ".$registros[14]."'>
                <td>".$registros[1]."</td>
                <td>".$registros[2]."</td>
                <td>".$registros[3]."</td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$registros[10]."'>
                    </div> 
                    <div class='tabla-texto'>
                        ".$registros[7]."<span class='bajotexto'>".$registros[9]."</span>
                    </div>
                </td>
                <td class='text-center'>".$registros[4]."</td>
                <td class='text-center'>".$fecha_entrega."</td>
                <td class='text-center'>".$registros[6]." ".substr($registros[18],0,1).".</td>
                <td class='text-center'><span class='label label-".$colorestado."'>".$estadotitle."</span></td>
            </tr>";
    }
?>

    </tbody>
</table>

<? echo $pagination; ?>

