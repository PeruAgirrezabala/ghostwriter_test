<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    include("../../../common.php");
    
    $limit = 20;
    file_put_contents("month.txt", $_GET['year']);
    
    if (($_GET['year'] != "") || ($_GET['month'] != "") || ($_GET['cli'] != "") || ($_GET['tec'] != "") || ($_GET['estado'] != "")) {
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
        $criteria .= " WHERE YEAR(fecha_ini) = ".$_GET['year'];
        $and = " AND ";
        $anyo=$_GET['year'];
        if ($_GET['month'] != "") {
            $criteriaLink .= "&month=".$_GET['month'];
            $criteria .= " AND MONTH(fecha_ini) = ".$_GET['month'];
        }
    }else{
        $anyo="";
    }
    if ($_GET['cli'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteriaLink .= "&cli=".$_GET['cli'];
        $criteria .= $and." PREVISIONES.cliente_id = ".$_GET['cli'];
        $and = " AND ";
    }
    
    if ($_GET['tec'] != "") {
        $criteriaLink .= "&tec=".$_GET['tec'];
        $criteriaTec .= " AND PREVISIONES_TECNICOS.erpuser_id = ".$_GET['tec'];
    }
    else {
        $criteriaTec = "";
    }
    
    if ($_GET['estado'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        
        if ($_GET['estado'] == 99) {
            $criteriaLink .= "&estado=".$_GET['estado'];
            $criteria .= $and." PREVISIONES.estado_id <> 2 AND PREVISIONES.estado_id <> 4 AND PREVISIONES.estado_id <> 5 AND PREVISIONES.estado_id <> 6 AND PREVISIONES.estado_id <> 7 ";
            $and = " AND ";
        }
        else {
            $criteriaLink .= "&estado=".$_GET['estado'];
            $criteria .= $and." PREVISIONES.estado_id = ".$_GET['estado'];
            $and = " AND ";
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
    
    $sql = "SELECT DISTINCT
                PREVISIONES.id as prev,
                PREVISIONES.nombre,
                PREVISIONES.fecha_ini,
                PREVISIONES.fecha_fin,
                PREVISIONES.cliente_id,
                PREVISIONES.instalacion, 
                PREVISIONES.item_id item,
                PREVISIONES.tipo_prev,
                PREVISIONES_ESTADOS.nombre,
                PREVISIONES_ESTADOS.color,
                (SELECT GROUP_CONCAT(CONCAT(erp_users.nombre,' ', erp_users.apellidos)) FROM erp_users, PREVISIONES_TECNICOS WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = prev ".$criteriaTec.") as tecnicos,
                (SELECT ref FROM INTERVENCIONES WHERE id = item),
                (SELECT ref FROM PROYECTOS WHERE id = item),
                (SELECT ref FROM OFERTAS WHERE id = item)
            FROM 
                PREVISIONES
            INNER JOIN PREVISIONES_ESTADOS
                ON PREVISIONES.estado_id = PREVISIONES_ESTADOS.id 
            ".$criteria."
            ORDER BY 
                PREVISIONES.fecha_ini DESC";
    file_put_contents("queryPrevisiones1.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Pevisiones 1");
    $numregistros = mysqli_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);

    if($criteriaTec==""){
        $sql = "SELECT DISTINCT
                PREVISIONES.id prev,
                PREVISIONES.nombre,
                PREVISIONES.fecha_ini,
                PREVISIONES.fecha_fin,
                PREVISIONES.cliente_id,
                PREVISIONES.instalacion, 
                PREVISIONES.item_id item,
                PREVISIONES.tipo_prev,
                PREVISIONES_ESTADOS.nombre,
                PREVISIONES_ESTADOS.color,
                (SELECT GROUP_CONCAT(CONCAT(erp_users.nombre,' ', erp_users.apellidos)) FROM erp_users, PREVISIONES_TECNICOS WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = prev) as tecnicos,
                (SELECT ref FROM INTERVENCIONES WHERE id = item),
                (SELECT ref FROM PROYECTOS WHERE id = item),
                (SELECT ref FROM OFERTAS WHERE id = item)
            FROM 
                PREVISIONES
            INNER JOIN PREVISIONES_ESTADOS
                ON PREVISIONES.estado_id = PREVISIONES_ESTADOS.id 
            ".$criteria."
            ORDER BY 
                PREVISIONES.fecha_ini DESC
            LIMIT ".$from.", ".$limit;
        //file_put_contents("queryPrevisiones2.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Previsiones 2");
        
    }else{
        $sql = "SELECT DISTINCT
                PREVISIONES.id prev,
                PREVISIONES.nombre,
                PREVISIONES.fecha_ini,
                PREVISIONES.fecha_fin,
                PREVISIONES.cliente_id,
                PREVISIONES.instalacion, 
                PREVISIONES.item_id item,
                PREVISIONES.tipo_prev,
                PREVISIONES_ESTADOS.nombre,
                PREVISIONES_ESTADOS.color,
                (SELECT GROUP_CONCAT(CONCAT(erp_users.nombre,' ', erp_users.apellidos)) FROM erp_users, PREVISIONES_TECNICOS WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = prev ".$criteriaTec.") as tecnicos,
                (SELECT ref FROM INTERVENCIONES WHERE id = item),
                (SELECT ref FROM PROYECTOS WHERE id = item),
                (SELECT ref FROM OFERTAS WHERE id = item)
            FROM 
                PREVISIONES
            INNER JOIN PREVISIONES_ESTADOS
                ON PREVISIONES.estado_id = PREVISIONES_ESTADOS.id 
            ".$criteria."
            ORDER BY 
                PREVISIONES.fecha_ini DESC";
        //file_put_contents("queryPrevisionesID.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Previsiones ID");
        
        
        
        if($anyo==""){ 
            $criteria2="WHERE (";
            $count=0;
            while ($registros = mysqli_fetch_array($resultado)) { 
                if($registros[12]!=null){
                    $count++;
                    if($count==1){
                        $criteria2.=" PREVISIONES.id =".$registros[0];
                    }else{
                        $criteria2.=" OR PREVISIONES.id =".$registros[0];
                    }
                }
            }
            $criteria2.=")";
            
            $sqlselect=",IF((SELECT GROUP_CONCAT(CONCAT(erp_users.nombre,' ', erp_users.apellidos)) FROM erp_users, PREVISIONES_TECNICOS WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = prev) IS NULL, 0, 1) as existe";
            $criteria2.=" HAVING existe = 1";
        }else{
            $criteria2="AND (";
            $count=0;
            while ($registros = mysqli_fetch_array($resultado)) { 
                if($registros[12]!=null){
                    $count++;
                    if($count==1){
                        $criteria2.=" PREVISIONES.id =".$registros[0];
                    }else{
                        $criteria2.=" OR PREVISIONES.id =".$registros[0];
                    }
                }
            }
            $criteria2.=")";
        }
        if($criteria2=="AND ()"){
            $criteria2="";
            $criteria="WHERE PREVISIONES.nombre=999";
        }
        
        $sql = "SELECT DISTINCT
                PREVISIONES.id prev,
                PREVISIONES.nombre,
                PREVISIONES.fecha_ini,
                PREVISIONES.fecha_fin,
                PREVISIONES.cliente_id,
                PREVISIONES.instalacion,
                PREVISIONES.item_id item,
                PREVISIONES.tipo_prev,
                PREVISIONES_ESTADOS.nombre,
                PREVISIONES_ESTADOS.color,
                (SELECT GROUP_CONCAT(CONCAT(erp_users.nombre,' ', erp_users.apellidos)) FROM erp_users, PREVISIONES_TECNICOS WHERE PREVISIONES_TECNICOS.erpuser_id = erp_users.id AND PREVISIONES_TECNICOS.prevision_id = prev) as tecnicos,
                (SELECT ref FROM INTERVENCIONES WHERE id = item),
                (SELECT ref FROM PROYECTOS WHERE id = item),
                (SELECT ref FROM OFERTAS WHERE id = item)".$sqlselect."
            FROM 
                PREVISIONES
            INNER JOIN PREVISIONES_ESTADOS
                ON PREVISIONES.estado_id = PREVISIONES_ESTADOS.id 
            ".$criteria." ".$criteria2."
            ORDER BY 
                PREVISIONES.fecha_ini DESC
            LIMIT ".$from.", ".$limit;
        file_put_contents("queryPrevisiones3.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Previsiones 3");
        $numregistros = mysqli_num_rows($resultado);
        $numpaginas = ceil($numregistros/$limit);
    }
    
    
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

<!-- proyectos activos -->
<table class="table table-hover" id="tabla-previsiones">
    <thead>
      <tr class="bg-dark">
        <th class="text-center">FECHAS</th>
        <th class="text-center">PREVISIÓN</th>
        <th class="text-center">TIPO</th>
        <th class="text-center">DETALLE</th>
        <th class="text-center">REF.</th>
        <th class="text-center">TÉCNICOS</th>
        <th class="text-center">ESTADO</th>
        <th class="text-center"></th>
      </tr>
    </thead>
    <tbody>
    
<?    
    while ($registros = mysqli_fetch_array($resultado)) { 
        switch ($registros[7]) {
            case "0":
                $tipoprev = "¿?";
                $tipoprevLink = "";
                break;
            case "1":
                $tipoprev = "Mantenimiento";
                $tipoprevLink = "/erp/apps/mantenimientos/view.php?id=".$registros[6];
                $ref = $registros[12];
                $sql="SELECT PROYECTOS.nombre FROM PROYECTOS where PROYECTOS.id=".$registros[6];
                file_put_contents("selectNombreMantenimiento.txt", $sql);
                $resul = mysqli_query($connString, $sql) or die("Error al seleccionar nombre del Mantenimiento");
                $regis = mysqli_fetch_array($resul);
                $detalle=$regis[0];
                break;
            case "2":
                $tipoprev = "Intervención";
                $tipoprevLink = "/erp/apps/intervenciones/editInt.php?id=".$registros[6];
                $ref = $registros[11];
                $sql="SELECT CLIENTES.nombre FROM CLIENTES where CLIENTES.id=".$registros[6];
                file_put_contents("selectNombreIntervencion.txt", $sql);
                $resul = mysqli_query($connString, $sql) or die("Error al seleccionar nombre del Proyecto");
                $regis = mysqli_fetch_array($resul);
                $detalle=$regis[0];
                break;
            case "3":
                $tipoprev = "Proyecto";
                $tipoprevLink = "/erp/apps/proyectos/view.php?id=".$registros[6];
                $ref = $registros[12];
                $sql="SELECT PROYECTOS.nombre FROM PROYECTOS where PROYECTOS.id=".$registros[6];
                file_put_contents("selectNombreProyecto.txt", $sql);
                $resul = mysqli_query($connString, $sql) or die("Error al seleccionar nombre del Proyecto");
                $regis = mysqli_fetch_array($resul);
                $detalle=$regis[0];
                break;
            case "4":
                $tipoprev = "Visita";
                $tipoprevLink = "/erp/apps/proyectos/view.php?id=".$registros[6];
                $ref = $registros[13];
                $sql="SELECT PROYECTOS.nombre FROM PROYECTOS where PROYECTOS.id=".$registros[6];
                file_put_contents("selectNombreVisita.txt", $sql);
                $resul = mysqli_query($connString, $sql) or die("Error al seleccionar nombre del Proyecto");
                $regis = mysqli_fetch_array($resul);
                $detalle=$regis[0];
                break;
            case "5":
                $tipoprev = "Gestión Interna";
                $tipoprevLink = "";
                $ref = "";
                $detalle = "GENELEK SISTEMAS";
                break;
            case "6":
                $tipoprev = "Oferta";
                $tipoprevLink = "";
                $ref = "";
                break;
        }
        echo "
            <tr data-id='".$registros[0]."' data-type='".$registros[7]."'>
                <td class='text-center'>".$registros[2]." - ".$registros[3]."</td>
                <td class='text-center'>".$registros[1]."</td>
                <td class='text-center'>".$tipoprev."</td>
                <td class='text-center'><!--".$registros[6]." - !-->".$detalle."</td>
                <td class='text-center'><a href='".$tipoprevLink."' target='_blank'>".$ref."</a></td>
                <td class='text-center'>".$registros[10]."</td>
                <td class='text-center'><span class='label label-".$registros[9]."'>".$registros[8]."</span></td>
                <td class='text-center'><button class='btn btn-circle btn-danger remove-prev' data-id='".$registros[0]."' title='Eliminar Previsión'><img src='/erp/img/cross.png'></button></td>
            </tr>
        ";
        echo '<div id="delete_prevision_model" class="modal fade">
                <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
                        </div>
                        <div class="modal-body">
                            <div class="contenedor-form">
                                    <input type="hidden" value="" name="del_prevision_id" id="del_prevision_id">
                                    <div class="form-group">
                                        <label class="labelBefore">¿Estas seguro de que deseas eliminar esta previsión?</label>
                                    </div>
                                    <div class="form-group">

                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn_del_prevision" data-id="" class="btn btn-info">Aceptar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>';
    }
?>

    </tbody>
</table>

<? echo $pagination; ?>
