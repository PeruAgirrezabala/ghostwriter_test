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
        $criteria = " WHERE YEAR(fecha) = ".date("Y");
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
    if ($_GET['cli'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&cli=".$_GET['cli'];
        $criteria .= $and." ENVIOS_CLI.cliente_id = ".$_GET['prov'];
        $and = " AND ";
    }
    
    if ($_GET['estado'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&estado=".$_GET['estado'];
        $criteria .= $and." ENVIOS_CLI.estado_id = ".$_GET['estado'];
        $and = " AND ";
    }
    if ($_GET['matid'] != "") {
        if ($criteria != "") {
            $criteriaLink .= "&matid=".$_GET['matid'];
            $criteria .= $and." ENVIOS_CLI_DETALLESss.material_id = ".$_GET['matid'];
        }
        else {
            $criteriaLink .= "&matid=".$_GET['matid'];
            $criteria .= " WHERE ENVIOS_CLI_DETALLES.material_id = ".$_GET['matid'];
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
                    ENVIOS_CLI.id,
                    ENVIOS_CLI.ref_pedido_cliente,
                    ENVIOS_CLI.nombre,
                    ENVIOS_CLI.fecha,
                    ENVIOS_CLI.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    B.nombre, 
                    B.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    ENVIOS_CLI.ref_oferta_proveedor,
                    ENVIOS_CLI.transportista_id,
                    A.nombre,
                    A.id, 
                    ENVIOS_CLI.ref,
                    TRANSPORTISTAS.nombre,
                    PROVEEDORES.nombre 
                FROM 
                    ENVIOS_CLI
                LEFT JOIN CLIENTES A
                    ON A.id = ENVIOS_CLI.cliente_id
                LEFT JOIN PROVEEDORES
                    ON PROVEEDORES.id = ENVIOS_CLI.proveedor_id
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON ENVIOS_CLI.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN erp_users 
                    ON ENVIOS_CLI.tecnico_id = erp_users.id 
                INNER JOIN TRANSPORTISTAS
                    ON TRANSPORTISTAS.id = ENVIOS_CLI.transportista_id 
		LEFT JOIN ENVIOS_CLI_DETALLES
		    ON ENVIOS_CLI_DETALLES.envio_id = ENVIOS_CLI.id 
                LEFT JOIN PROYECTOS
                    ON ENVIOS_CLI.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES B
                    ON PROYECTOS.cliente_id = B.id
                ".$criteria."
                GROUP BY 
                    ENVIOS_CLI.id 
                ORDER BY 
                    ENVIOS_CLI.fecha DESC";
    }
    else {
        $sql = "SELECT 
                    ENVIOS_CLI.id,
                    ENVIOS_CLI.ref_pedido_cliente,
                    ENVIOS_CLI.nombre,
                    ENVIOS_CLI.fecha,
                    ENVIOS_CLI.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    B.nombre, 
                    B.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    ENVIOS_CLI.ref_oferta_proveedor,
                    ENVIOS_CLI.transportista_id,
                    A.nombre,
                    A.id, 
                    ENVIOS_CLI.ref,
                    TRANSPORTISTAS.nombre,
                    PROVEEDORES.nombre
                FROM 
                    ENVIOS_CLI
                LEFT JOIN CLIENTES A
                    ON A.id = ENVIOS_CLI.cliente_id
                LEFT JOIN PROVEEDORES
                    ON PROVEEDORES.id = ENVIOS_CLI.proveedor_id
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON ENVIOS_CLI.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN erp_users 
                    ON ENVIOS_CLI.tecnico_id = erp_users.id 
                INNER JOIN TRANSPORTISTAS
                    ON TRANSPORTISTAS.id = ENVIOS_CLI.transportista_id 
		LEFT JOIN ENVIOS_CLI_DETALLES
		    ON ENVIOS_CLI_DETALLES.envio_id = ENVIOS_CLI.id 
                LEFT JOIN PROYECTOS
                    ON ENVIOS_CLI.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES B
                    ON PROYECTOS.cliente_id = B.id
                ".$criteria."
                GROUP BY 
                    ENVIOS_CLI.id 
                ORDER BY 
                    ENVIOS_CLI.fecha DESC";
    }
    file_put_contents("queryEnvios.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Envíos");
    $numregistros = mysqli_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);
    
    if ($fechamod == 1) {
        $sql = "SELECT 
                    ENVIOS_CLI.id,
                    ENVIOS_CLI.ref_pedido_cliente,
                    ENVIOS_CLI.nombre,
                    ENVIOS_CLI.fecha,
                    ENVIOS_CLI.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    B.nombre, 
                    B.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    ENVIOS_CLI.ref_oferta_proveedor,
                    ENVIOS_CLI.transportista_id,
                    A.nombre,
                    A.id, 
                    ENVIOS_CLI.ref,
                    TRANSPORTISTAS.nombre,
                    PROVEEDORES.nombre
                FROM 
                    ENVIOS_CLI
                LEFT JOIN CLIENTES A
                    ON A.id = ENVIOS_CLI.cliente_id
                LEFT JOIN PROVEEDORES
                    ON PROVEEDORES.id = ENVIOS_CLI.proveedor_id
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON ENVIOS_CLI.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN erp_users 
                    ON ENVIOS_CLI.tecnico_id = erp_users.id 
                INNER JOIN TRANSPORTISTAS
                    ON TRANSPORTISTAS.id = ENVIOS_CLI.transportista_id 
		LEFT JOIN ENVIOS_CLI_DETALLES
		    ON ENVIOS_CLI_DETALLES.envio_id = ENVIOS_CLI.id 
                LEFT JOIN PROYECTOS
                    ON ENVIOS_CLI.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES B
                    ON PROYECTOS.cliente_id = B.id
                ".$criteria."
                GROUP BY 
                    ENVIOS_CLI.id 
                ORDER BY 
                    ENVIOS_CLI.fecha DESC
                LIMIT ".$from.", ".$limit;
    }
    else {
        $sql = "SELECT 
                    ENVIOS_CLI.id,
                    ENVIOS_CLI.ref_pedido_cliente,
                    ENVIOS_CLI.nombre,
                    ENVIOS_CLI.fecha,
                    ENVIOS_CLI.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    B.nombre, 
                    B.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    ENVIOS_CLI.ref_oferta_proveedor,
                    ENVIOS_CLI.transportista_id,
                    A.nombre,
                    A.id, 
                    ENVIOS_CLI.ref,
                    TRANSPORTISTAS.nombre,
                    PROVEEDORES.nombre
                FROM 
                    ENVIOS_CLI
                LEFT JOIN CLIENTES A
                    ON A.id = ENVIOS_CLI.cliente_id
                LEFT JOIN PROVEEDORES
                    ON PROVEEDORES.id = ENVIOS_CLI.proveedor_id
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON ENVIOS_CLI.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN erp_users 
                    ON ENVIOS_CLI.tecnico_id = erp_users.id 
                INNER JOIN TRANSPORTISTAS
                    ON TRANSPORTISTAS.id = ENVIOS_CLI.transportista_id 
		LEFT JOIN ENVIOS_CLI_DETALLES
		    ON ENVIOS_CLI_DETALLES.envio_id = ENVIOS_CLI.id 
                LEFT JOIN PROYECTOS
                    ON ENVIOS_CLI.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES B
                    ON PROYECTOS.cliente_id = B.id
                ".$criteria."
                GROUP BY 
                    ENVIOS_CLI.id 
                ORDER BY 
                    ENVIOS_CLI.fecha DESC
                LIMIT ".$from.", ".$limit;
    }
    file_put_contents("queryEnvios.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Envíos");
    
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
<table class="table table-striped table-hover" id='tabla-envios'>
    <thead>
      <tr>
        <th>ALBARÁN</th>
        <th>TITULO</th>
        <th>CLIENTE | PROVEEDOR</th>
        <th>TRANSP.</th>
        <th style="min-width: 35%;">PROYECTO | CLIENTE</th>
        <th>FECHA</th>
        <th>ENTREGA</th>
        <th>POR</th>
        <th>ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?
    while ($registros = mysqli_fetch_array($resultado)) { 
        if ($registros[13] == "") {
            $empresa = "P: ".$registros[17];
        }
        else {
            $empresa = "C: ".$registros[13];
        }
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[15]."</td>
                <td>".$registros[2]."</td>
                <td>".$empresa."</td>
                <td>".$registros[16]."</td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$registros[9]."'>
                    </div> 
                    <div class='tabla-texto'>
                        ".$registros[6]."<span class='bajotexto'>".$registros[8]."</span>
                    </div>
                </td>
                <td>".$registros[3]."</td>
                <td>".$registros[4]."</td>
                <td>".$registros[5]."</td>
                <td><span class='label label-".$registros[10]."'>".$registros[7]."</span></td>
            </tr>
        ";
    }
?>

    </tbody>
</table>

<? echo $pagination; ?>

