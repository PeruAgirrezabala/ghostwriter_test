<!-- proyectos activos -->
<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $limit = 10;
    

        $criteriaLink = "";
        $criteria = "AND
                        PROYECTOS.estado_id = 3 
                     AND 
                        PROYECTOS.estado_id = 6";
    
    
//    if(){
//        $_GET['cli'];
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
    
    $sql = "SELECT 
                    PROYECTOS.id,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.mant_year_visits,
                    PROYECTOS.mant_days_visit,
                    PROYECTOS.mant_tecs_visit,
                    PROYECTOS_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PROYECTOS_ESTADOS.color, 
                    TIPOS_PROYECTO.nombre, 
                    TIPOS_PROYECTO.color
                FROM 
                    PROYECTOS, CLIENTES, PROYECTOS_ESTADOS, TIPOS_PROYECTO  
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND 
                    PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
                AND 
                    PROYECTOS.tipo_proyecto_id = TIPOS_PROYECTO.id 
                AND
                    PROYECTOS.tipo_proyecto_id = 2 
                ".$criteria."
                ORDER BY 
                    PROYECTOS.fecha_mod DESC,
                    PROYECTOS.fecha_ini DESC";    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    $numregistros = mysqli_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);
    
    if ($fechamod == 1) {
        $sql = "SELECT 
                    PROYECTOS.id,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.mant_year_visits,
                    PROYECTOS.mant_days_visit,
                    PROYECTOS.mant_tecs_visit,
                    PROYECTOS_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PROYECTOS_ESTADOS.color, 
                    TIPOS_PROYECTO.nombre, 
                    TIPOS_PROYECTO.color,
                    PROYECTOS.recordatorio
                FROM 
                    PROYECTOS, CLIENTES, PROYECTOS_ESTADOS, TIPOS_PROYECTO
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND 
                    PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
                AND 
                    PROYECTOS.tipo_proyecto_id = TIPOS_PROYECTO.id 
                AND
                    PROYECTOS.tipo_proyecto_id = 2 
                ".$criteria."
                ORDER BY 
                    PROYECTOS.fecha_mod DESC,
                    PROYECTOS.fecha_ini DESC 
                LIMIT ".$from.", ".$limit;
    }
    else {
        $sql = "SELECT 
                    PROYECTOS.id,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.mant_year_visits,
                    PROYECTOS.mant_days_visit,
                    PROYECTOS.mant_tecs_visit,
                    PROYECTOS_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PROYECTOS_ESTADOS.color, 
                    TIPOS_PROYECTO.nombre, 
                    TIPOS_PROYECTO.color,
                    PROYECTOS.recordatorio
                FROM 
                    PROYECTOS, CLIENTES, PROYECTOS_ESTADOS, TIPOS_PROYECTO 
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND 
                    PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
                AND 
                    PROYECTOS.tipo_proyecto_id = TIPOS_PROYECTO.id 
                AND
                    PROYECTOS.tipo_proyecto_id = 2  
                ".$criteria."
                ORDER BY 
                    PROYECTOS.fecha_mod DESC,
                    PROYECTOS.fecha_ini DESC 
                LIMIT ".$from.", ".$limit;
    }
    file_put_contents("queryMantenimientos.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    
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
    for ($index = 0; $index < $numpaginas; $index++) {
        if (($index+1) == $curpage) {
            $activo = "disabled";
        }
        else {
            $activo = "";
        }
        $pagination .= "<li class='page-item ".$activo."'><a class='page-link' href='?pag=".($index+1)."'>".($index+1)."</a></li>";
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

<table class="table table-striped table-hover" id='tabla-proyectos'>
    <thead>
      <tr class="bg-dark">
        <th>REF</th>
        <th class='text-center'>EXPEDIENTES</th>
        <th>MANTENIMIENTO | CLIENTE</th>
        <th></th>
        <th class='text-center'>VISITAS AÑO</th>
        <th class='text-center'>DÍAS VISITAS</th>
        <th class='text-center'>TÉCNICOS VISITA</th>
        <th class='text-center'>FECHAS</th>
        <th class='text-center'>ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?    
    while ($registros = mysqli_fetch_array($resultado)) { 
        $sqlExp = "SELECT 
                    A.ref, A.id 
                FROM
                    MANTENIMIENTOS_EXP, PROYECTOS A, PROYECTOS B   
                WHERE 
                    MANTENIMIENTOS_EXP.expediente_id = A.id 
                AND
                    MANTENIMIENTOS_EXP.proyecto_id = B.id 
                AND
                    MANTENIMIENTOS_EXP.proyecto_id = ".$registros[0]."
                ORDER BY 
                    B.ref ASC";
        //file_put_contents("queryAccesos.txt", $sql);
        $resultadoExp = mysqli_query($connString, $sqlExp) or die("Error al ejcutar la consulta de los Expedientes");
        $sqlVisitas = "SELECT 
                        PROYECTOS_VISITAS.fecha, PROYECTOS.id
                    FROM 
                        PROYECTOS_VISITAS, PROYECTOS 
                    WHERE 
                        PROYECTOS_VISITAS.proyecto_id = PROYECTOS.id 
                    AND
                        PROYECTOS_VISITAS.proyecto_id = ".$registros[0]."
                    ORDER BY 
                        PROYECTOS_VISITAS.fecha DESC";
        //file_put_contents("queryAccesos.txt", $sql);
        $resultadoVisitas = mysqli_query($connString, $sqlVisitas) or die("Error al ejcutar la consulta de los Accesos");
        
        
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td> 
                <td class='text-center'>";
        
        // INSERTO TABLA CON LOS EXPEDIENTES RELACIONADOS
        echo "      <table class='table table-striped table-hover tabla-mant-exp' style='margin-bottom: 5px !important;'>
                        <thead>";
        $titulocorto="";
        while ($registrosExp = mysqli_fetch_array($resultadoExp)) { 
            $estilo = "class='info'";
            echo "
                            <tr ".$estilo." data-id='".$registrosExp[1]."'>
                                <td style='text-align:center;'>".$registrosExp[0]."</td> 
                            </tr>";
        }
        echo "          </thead> 
                    </table>";
        // ************ EXPEDIENTES *******************
        
        echo "  </td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$registros[8]."'>
                    </div> 
                        <div class='tabla-texto'>
                            ".$registros[2]."<span class='bajotexto'>".$registros[7]."</span>
                        </div>
                </td>";
        if (($registros[12]!="")||($registros[12]!=null)){
            echo "<td class='text-center'><span class='blink_me' title='Hay un recordatorio pendiente'><img src='/erp/img/warning-test.png'></span></td>";
        }else{
            echo "<td class='text-center'></td>";
        }
            
        echo "<td class='text-center'>".$registros[3]."</td>
                <td class='text-center'>".$registros[4]."</td>
                <td class='text-center'>".$registros[5]."</td>
                <td class='text-center'>";
        
        // INSERTO TABLA CON LAS FECHAS DEL MANTENIMIENTO
        echo "      <table class='table table-striped table-hover' style='margin-bottom: 5px !important;'>
                        <thead>";
        while ($registrosVisitas = mysqli_fetch_array($resultadoVisitas)) { 
            $date = date('Y-m-d', time());
            if ($date > $registrosVisitas[0]) {
                $estilo = "class='danger'";
            }
            else {
                $estilo = "class='info'";
            }
            echo "
                            <tr ".$estilo." data-id='".$registrosVisitas[1]."'>
                                <td style='text-align:center;'>".$registrosVisitas[0]."</td> 
                            </tr>";
        }
        echo "          </thead> 
                    </table>";
        // ************ FECHAS *******************
        
        echo "  </td>
                <td class='text-center'><span class='label label-".$registros[9]."'>".$registros[6]."</span></td>
            </tr>
        ";
    }
?>
    </tbody>
</table>

<? echo $pagination; ?>

