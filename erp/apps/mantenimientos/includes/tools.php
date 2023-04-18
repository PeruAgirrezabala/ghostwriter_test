<!-- tools proyectos -->
<div class="form-group form-group-tools">
    <button class="button" id="add-proyecto"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="refresh_mantenimientos"><img src="/erp/img/refresh.png" height="20"></button>
    <button class="button" id="clean-filters" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
    <button class="button" id="ver-historicos" title="Ver Historicos"><img src="/erp/img/historial-black.png" height="20"></button>
</div>

<!-- tools proyectos -->

<div id="addproyecto_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">MANTENIMIENTO NUEVO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_proyecto">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">REF:</label>
                                <input type="text" class="form-control" id="newproyecto_ref" name="newproyecto_ref" disabled="true">
                                <label class="helper">La referencia la genera automáticamente</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore"><span class="guia">1</span> Nombre: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="newproyecto_nombre" name="newproyecto_nombre">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newproyecto_estados" class="labelBefore"><span class="guia">2</span> Tipo: <span class="requerido">*</span></label>
                                <select id="newproyecto_tipoproyecto" name="newproyecto_tipoproyecto" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="newproyecto_clientes" class="labelBefore"><span class="guia">3</span> Cliente: <span class="requerido">*</span></label>
                                <select id="newproyecto_clientes" name="newproyecto_clientes" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label for="newproyecto_clientes" class="labelBefore" style="color: #ffffff;">oo </label>
                                <button type="button" id="btn_add_cliente" class="btn btn-info">Añadir Cliente</button>
                            </div>
                            <label class="helper">Cuidado al añadir un cliente ya que al guardarlo refresca la página y no guarda el Mantenimiento</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore"><span class="guia">4</span> Fecha Inicio: <span class="requerido">*</span></label>
                                <input type="date" class="form-control" id="newproyecto_fechaini" name="newproyecto_fechaini">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="newproyecto_fechaentrega" name="newproyecto_fechaentrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Fin:</label>
                                <input type="date" class="form-control" id="newproyecto_fechafin" name="newproyecto_fechafin">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Visitas al año:</label>
                            <input type="number" class="form-control" id="newproyecto_mant_year_visits" name="newproyecto_mant_year_visits">
                        </div>

                        <div class="form-group form-group-view">
                            <label class="labelBefore">Días de visita:</label>
                            <input type="number" class="form-control" id="newproyecto_mant_days_visit" name="newproyecto_mant_days_visit">
                        </div>

                        <div class="form-group form-group-view">
                            <label class="labelBefore">Técnicos por visita:</label>
                            <input type="number" class="form-control" id="newproyecto_mant_tecs_visit" name="newproyecto_mant_tecs_visit">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Ubicación:</label>
                            <input type="text" class="form-control" id="newproyecto_ubicacion" name="newproyecto_ubicacion">
                        </div>
                        <div class="form-group">
                            <label for="newproyecto_estados" class="labelBefore"><span class="guia">5</span> Estado: <span class="requerido">*</span></label>
                            <select id="newproyecto_estados" name="newproyecto_estados" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="newproyecto_parentproyecto" class="labelBefore">SubProyecto de: </label>
                            <select id="newproyecto_parentproyecto" name="newproyecto_parentproyecto" class="selectpicker" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="newproyecto_desc" name="newproyecto_desc" placeholder="Descripción del Proyecto" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="requerido">*Campo obligatorio</span>
                            <!--<br/>
                            <span class="requerido2">*Uno de los campos que contienen este simbolo debe de estar completado</span>-->
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newproyecto_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Proyecto guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_proyecto" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- / proyectos activos -->

<!-- Proyectos Historico -->

<div id="mantenimientos_historico_model" class="modal fade">
    <div class="modal-dialog" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">HISTORIAL MANTENIMIENTOS</h4>
            </div>
            <div class="modal-body">
                <?

    
    $limit = 10;
    

        $criteriaLink = "";
        $criteria = "AND
                        (PROYECTOS.estado_id = 3 
                     OR 
                        PROYECTOS.estado_id = 6)";
    
    
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
                    TIPOS_PROYECTO.color,
                    PROYECTOS.facturado
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
                    PROYECTOS.facturado,
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
                    PROYECTOS.facturado,
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
    file_put_contents("queryMantenimientos2.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Proyectos");
    
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
        <th class='text-center'>FACTURADO</th>
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
        if (($registros[13]!="")||($registros[13]!=null)){
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
                <td class='text-center'><span class='label label-".$registros[9]."'>".$registros[6]."</span></td>";
        if($registros[12]==0){
            $txtfacturado="No Facturado";
            $colorfacturado="label-danger";
        }elseif($registros[12]==1){
            $txtfacturado="Facturado";
            $colorfacturado="label-success";
        }
        echo "<td class='text-center'><span class='label ".$colorfacturado."'>".$txtfacturado."</span></td>
            </tr>";
    }
?>
    </tbody>
</table>

<? echo $pagination; ?>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_proyecto" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- /Proyectos Historico -->



<!-- CLIENTES -->

<div id="addcliente_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CLIENTES</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_cliente" enctype="multipart/form-data">
                        <input type="hidden" name="newcliente_idcliente" id="newcliente_idcliente">
                        <input type="hidden" name="cliente_del" id="cliente_del">
                        <div class="form-group">
                            <label class="labelBefore">Clientes:</label>
                            <select id="proyectos_clientes" name="proyectos_clientes" class="selectpicker categorias_categorias" data-live-search="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newcliente_nombre" name="newcliente_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Dirección:</label>
                            <input type="text" class="form-control" id="newcliente_direccion" name="newcliente_direccion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Población:</label>
                            <input type="text" class="form-control" id="newcliente_poblacion" name="newcliente_poblacion">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Provincia:</label>
                            <input type="text" class="form-control" id="newcliente_provincia" name="newcliente_provincia">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">CP:</label>
                            <input type="text" class="form-control" id="newcliente_cp" name="newcliente_cp">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">País:</label>
                            <input type="text" class="form-control" id="newcliente_pais" name="newcliente_pais">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Teléfono:</label>
                            <input type="text" class="form-control" id="newcliente_telefono" name="newcliente_telefono">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Email:</label>
                            <input type="text" class="form-control" id="newcliente_email" name="newcliente_email">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Web:</label>
                            <input type="text" class="form-control" id="newcliente_web" name="newcliente_web">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">NIF:</label>
                            <input type="text" class="form-control" id="newcliente_nif" name="newcliente_nif">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Imagen:</label>
                                <input type="file" class="form-control" id="newcliente_logo" name="newcliente_logo">
                            </div>
                            <div class="col-xs-6">
                                <label for="newproyecto_clientes" class="labelBefore" style="color: #ffffff;">oo </label>
                                <img src="" style="display: none; height: 100px !important;" id="newcliente_imgprview">
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newcliente_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Cliente guardado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_cliente" class="btn btn-info">Guardar</button>
                <button type="button" id="btn_del_cliente" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- /CLIENTES -->