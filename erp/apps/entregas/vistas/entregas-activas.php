<!-- entregas activos -->
<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
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
    
    if ((($_GET['year'] != "") && ($_GET['year'] != "undefined")) || (($_GET['cli'] != "") && ($_GET['cli'] != "undefined")) || (($_GET['proyecto'] != "") && ($_GET['proyecto'] != ""))) {
        $criteria = "";
        $and = "";
    }
    if (($_GET['year'] != "") && ($_GET['year'] != "undefined")) {
        $criteria = " AND SUBSTR(ENTREGAS.ref,2,2) = ".substr($_GET['year'],2,4);
    }elseif($_GET['year'] == 0){
        $criteria = " ";
    }else{
        $criteria = " AND SUBSTR(ENTREGAS.ref,2,2) = ".date("y");
    }
    if (($_GET['cli'] != "") && ($_GET['cli'] != "undefined")) {
        $criteria .= " AND CLIENTES.id = ".$_GET['cli'];
    }
    if (($_GET['proyecto'] != "") && ($_GET['proyecto'] != "undefined")) {
        $criteria .= " AND PROYECTOS.id = ".$_GET['proyecto'];
    }
    if (($_GET['estado'] != "") && ($_GET['estado'] != "undefined")) {
        $criteria .= " AND ENTREGAS.estado_id = ".$_GET['estado'];
    }
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    /*
                AND
                    ENTREGAS.estado_id <> 5 
                AND 
                    ENTREGAS.estado_id <> 6 
     *      */
    $sql = "SELECT 
                    ENTREGAS.id,
                    ENTREGAS.ref,
                    ENTREGAS.nombre,
                    ENTREGAS.fecha_entrega,
                    PROYECTOS.nombre, 
                    ESTADOS_ENTREGAS.nombre,
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    ESTADOS_ENTREGAS.color 
                FROM 
                    PROYECTOS, ESTADOS_ENTREGAS, ENTREGAS, CLIENTES  
                WHERE
                    PROYECTOS.cliente_id = CLIENTES.id
                AND
                    PROYECTOS.id = ENTREGAS.proyecto_id
                AND 
                    ENTREGAS.estado_id = ESTADOS_ENTREGAS.id 
                    ".$criteria."
                ORDER BY 
                    ENTREGAS.fecha_entrega DESC";
    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");
    $numregistros = mysqli_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);
    
    if ($fechamod == 1) {
        $sql = "SELECT 
                    ENTREGAS.id,
                    ENTREGAS.ref,
                    ENTREGAS.nombre,
                    ENTREGAS.fecha_entrega,
                    PROYECTOS.nombre, 
                    ESTADOS_ENTREGAS.nombre,
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    ESTADOS_ENTREGAS.color 
                FROM 
                    PROYECTOS, ESTADOS_ENTREGAS, ENTREGAS, CLIENTES 
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND
                    PROYECTOS.id = ENTREGAS.proyecto_id
                AND 
                    ENTREGAS.estado_id = ESTADOS_ENTREGAS.id 
                    ".$criteria."
                ORDER BY 
                    ENTREGAS.fecha_entrega DESC 
                LIMIT ".$from.", ".$limit;
    }
    else {
        $sql = "SELECT 
                    ENTREGAS.id,
                    ENTREGAS.ref,
                    ENTREGAS.nombre,
                    ENTREGAS.fecha_entrega,
                    PROYECTOS.nombre, 
                    ESTADOS_ENTREGAS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    ESTADOS_ENTREGAS.color 
                FROM 
                    PROYECTOS, ESTADOS_ENTREGAS, ENTREGAS, CLIENTES 
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND
                    PROYECTOS.id = ENTREGAS.proyecto_id
                AND 
                    ENTREGAS.estado_id = ESTADOS_ENTREGAS.id 
                    ".$criteria."
                ORDER BY 
                    ENTREGAS.fecha_entrega DESC 
                LIMIT ".$from.", ".$limit;
    }
    file_put_contents("queryProyectos.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Entregas");
    
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
                        <li class='page-item ".$disabledFirst."'><a class='page-link' href='#tabla-entregas' data-pag='1'>Primera</a></li>
                        <li class='page-item $disabledFirst'>
                          <a class='page-link' data-pag='".($curpage-1)."' href='#tabla-entregas' aria-label='Anterior' title='Anterior'>
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
        $pagination .= "<li class='page-item ".$activo."'><a class='page-link' href='#tabla-entregas' data-pag='".($index+1)."'>".($index+1)."</a></li>";
    }
    $pagination .= "<li class='page-item ".$disabledLast."'>
                            <a class='page-link' data-pag='".($curpage+1)."' href='#tabla-entregas' aria-label='Siguiente' title='Siguiente'>
                              <span aria-hidden='true'>&raquo;</span>
                              <span class='sr-only'>Siguiente</span>
                            </a>
                        </li>
                        <li class='page-item ".$disabledLast."'><a class='page-link' href='#tabla-entregas' data-pag='".$numpaginas."'>Última</a></li>
                      </ul>
                    </nav>
                  </div>";
    
    echo $pagination;
?>

<table class="table table-striped table-hover" id='tabla-entregas'>
    <thead>
      <tr class="bg-dark">
        <th>REF</th>
        <th>NOMBRE</th>
        <th>FECHA ENTREGA.</th>
        <th>PROYECTO | CLIENTE</th>
        <th>ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?    
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td>".$registros[2]."</td>
                <td>".$registros[3]."</td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$registros[7]."'>
                    </div> 
                        <div class='tabla-texto'>
                            ".$registros[4]."<span class='bajotexto'>".$registros[6]."</span>
                        </div>
                </td>
                <td><span class='label label-".$registros[8]."'>".$registros[5]."</span></td>
            </tr>
        ";
    }
?>
    </tbody>
</table>

<? echo $pagination; ?>

<!-- entregas activos -->