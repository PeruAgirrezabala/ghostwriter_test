<!-- proyectos seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="proyectos_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Proyecto guardado</p>
</div>
<div id="project-view" style="margin-bottom: 20px;">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                PROYECTOS.id,
                PROYECTOS.ref,
                PROYECTOS.nombre,
                PROYECTOS.descripcion,
                PROYECTOS.fecha_ini,
                PROYECTOS.fecha_entrega,
                PROYECTOS.fecha_fin,
                PROYECTOS.fecha_mod,
                PROYECTOS_ESTADOS.nombre, 
                CLIENTES.nombre, 
                CLIENTES.img,
                PROYECTOS_ESTADOS.color, 
                PROYECTOS_ESTADOS.id,
                CLIENTES.id,
                PROYECTOS.path, 
                TIPOS_PROYECTO.nombre,
                TIPOS_PROYECTO.id, 
                TIPOS_PROYECTO.color,
                PROYECTOS.proyecto_id, 
                PROYECTOS.mant_year_visits,
                PROYECTOS.mant_days_visit,
                PROYECTOS.mant_tecs_visit,
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
                PROYECTOS.id = ".$_GET['id'];

        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Proyectos");

        $registros = mysqli_fetch_row($resultado);
        
        $id = $_GET['id'];
        $ref = $registros[1];
        $nombreProyecto = $registros[2];
        $descripcion = $registros[3];
        $fecha_ini = $registros[4];
        $fecha_entrega = $registros[5];
        $fecha_fin = $registros[6];
        $fecha_mod = $registros[7];
        $estado = $registros[8];
        $cliente = $registros[9];
        $clientebrand = $registros[10];
        $estadocolor = $registros[11];
        $estado_id = $registros[12];
        $cliente_id = $registros[13];
        $proyectopath = $registros[14];
        $tipoproyecto = $registros[15];
        $tipoproyecto_id = $registros[16];
        $tipoproyectocolor = $registros[17];
        $parent_id = $registros[18];
        $visitas_year = $registros[19];
        $dias_visita = $registros[20];
        $tecnicos_visita = $registros[21];
        $facturado = $registros[22];        
        if ($tipoproyecto_id == 2) {
            $display = "style='display:none;'";
        }
        else {
            $display = "";
        }
        $sqlVisitas = "SELECT 
                        PROYECTOS_VISITAS.fecha, PROYECTOS.id, PROYECTOS_VISITAS.id, PROYECTOS_VISITAS.realizada, PROYECTOS_VISITAS.actividad_id
                    FROM 
                        PROYECTOS_VISITAS, PROYECTOS 
                    WHERE 
                        PROYECTOS_VISITAS.proyecto_id = PROYECTOS.id 
                    AND
                        PROYECTOS_VISITAS.proyecto_id = ".$registros[0]."
                    ORDER BY 
                        PROYECTOS_VISITAS.fecha DESC";
        file_put_contents("queryAccesos.txt", $sqlVisitas);
        $resultadoVisitas = mysqli_query($connString, $sqlVisitas) or die("Error al ejecutar la consulta de los Accesos");
        $sqlExp = "SELECT 
                    A.ref, A.id, A.nombre 
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
        file_put_contents("queryExp.txt", $sqlExp);
        $resultadoExp = mysqli_query($connString, $sqlExp) or die("Error al ejecutar la consulta de los Expedientes");

        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>Cliente:</label> <label id='view_ref' class='label-strong'>".$cliente."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Ref:</label> <label id='view_ref'>".$ref."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Nombre:</label> <label id='view_ref'>".$nombreProyecto."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Tipo:</label> <label id='view_ref' class='label label-".$tipoproyectocolor."'>".$tipoproyecto."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descripción:</label> <label id='view_ref'>".$descripcion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>fecha inicio:</label> <label id='view_ref'>".$fecha_ini."</label>
              </div>";
        echo "<div class='form-group form-group-view' ".$display.">
                <label class='viewTitle'>Fecha entrega:</label> <label id='view_ref'>".$fecha_entrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha fin:</label> <label id='view_ref'>".$fecha_fin."</label>
              </div>";
        if ($tipoproyecto_id == 2) {
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Visitas al año:</label> <label id='view_ref'>".$visitas_year."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Días de visita:</label> <label id='view_ref'>".$dias_visita."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Técnicos por visita:</label> <label id='view_ref'>".$tecnicos_visita."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Expedientes:</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <div class='col-xs-4'>";
            // INSERTO TABLA CON LOS EXPEDIENTES RELACIONADOS
                echo "      <table class='table table-striped table-hover tabla-mant-exp' style='margin-bottom: 5px !important;'>
                                <thead>";
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

            echo "      </div>
                    </div>
                ";
                
                echo "<div class='form-group form-group-view'>
                        <label class='viewTitle'>Visitas:</label>
                      </div>";
                echo "<div class='form-group form-group-view'>
                        <div class='col-xs-4'>";
                // INSERTO TABLA CON LAS FECHAS DEL MANTENIMIENTO
                echo "      <table class='table table-striped table-hover tabla-mant-visitas' style='margin-bottom: 5px !important;'>
                                <thead>";
                while ($registrosVisitas = mysqli_fetch_array($resultadoVisitas)) { 
                    $date = date('Y-m-d', time());
                    if (($registrosVisitas[3] == 0)) { // ($date > $registrosVisitas[0]) && 
                        $estilo = "class='danger'";
                    }
                    else {
                        $estilo = "class='info'";
                    }
                    $sqlInst="SELECT
                            ACTIVIDAD.id, 
                            CLIENTES_INSTALACIONES.id, 
                            CLIENTES_INSTALACIONES.nombre 
                            FROM ACTIVIDAD 
                            INNER JOIN CLIENTES_INSTALACIONES 
                            ON ACTIVIDAD.instalacion=CLIENTES_INSTALACIONES.id 
                            WHERE ACTIVIDAD.id=".$registrosVisitas[4];
                    $resultadoInstalacion = mysqli_query($connString, $sqlInst) or die("Error al ejecutar la consulta de la ionstalacion");
                    $registrosInstalacion = mysqli_fetch_array($resultadoInstalacion);
                    if($registrosInstalacion[2]==""){
                        $nombreInstalacion="SIN ASIGNAR";
                    }else{
                        $nombreInstalacion=$registrosInstalacion[2];
                    }
                    
                    echo "
                                    <tr ".$estilo." data-id='".$registrosVisitas[4]."'>
                                        <td style='text-align:center;'>".$registrosVisitas[0]." [".$nombreInstalacion."]</td> 
                                    </tr>";
                }
                echo "          </thead> 
                            </table>";
                // ************ FECHAS *******************
        echo "      </div>
                </div>
            ";
        
        echo "  </td>
                <td class='text-center'><span class='label label-".$registros[9]."'>".$registros[6]."</span></td>
            </tr>
        ";
        }
        // COLOR LABEL VERDE/SUCCESS ROJO/DANGER FACTURADO NO FACTURADO
        if($facturado==0){
            $txtfacturado="No Facturado";
            $colorfacturado="label-danger";
        }elseif($facturado==1){
            $txtfacturado="Facturado";
            $colorfacturado="label-success";
        }
        
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Estado:</label> <label id='view_ref' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Facturado:</label> <label id='view_ref' class='label ".$colorfacturado."'>".$txtfacturado."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Última modificación:</label> <label id='view_ref' style='padding-left: 8px; padding-right: 8px; background-color: #333; color: #ffffff;'>".$fecha_mod."</label>
              </div>";
        
        
    ?>
</div>
<div id="project-edit" style="display: none;">
    <form method="post" id="frm_proyecto">
    <?
        echo "  <input type='hidden' name='proyectos_delproyceto' id='proyectos_delproyceto' value=''>
                <input type='hidden' name='proyectos_idproyecto' id='proyectos_idproyecto' value=".$id.">
                <input type='hidden' name='proyectos_clienteid' id='proyectos_clienteid' value=".$cliente_id."> 
                <input type='hidden' name='proyectos_parentid' id='proyectos_parentid' value=".$parent_id."> 
                <input type='hidden' name='proyectos_tipoid' id='proyectos_tipoid' value=".$tipoproyecto_id."> 
                <input type='hidden' name='proyectos_path' id='proyectos_path' value=".$proyectopath.">
                <input type='hidden' name='proyectos_estadoid' id='proyectos_estadoid' value=".$estado_id.">";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Cliente:</label>
                <select id='proyectos_clientes' name='proyectos_clientes' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Ref:</label>
                <input type='text' class='form-control' id='proyectos_edit_ref' name='proyectos_edit_ref' placeholder='Referencia del Proyecto' value='".$ref."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Nombre:</label>
                <input type='text' class='form-control' id='proyectos_edit_nombre' name='proyectos_edit_nombre' placeholder='Nombre del Proyecto' value='".$nombreProyecto."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Tipo:</label>
                    <select id='proyectos_tipoproyecto' name='proyectos_tipoproyecto' class='selectpicker' data-live-search='true' data-width='33%'>
                        <option></option>
                    </select>
                </div>
              </div>";
        echo "<div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Descripción:</label>
                <textarea class='form-control' id='proyectos_edit_desc' name='proyectos_edit_desc' placeholder='Descripción del Proyecto'>".$descripcion."</textarea>
              </div>";        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>fecha inicio:</label>
                <input type='date' class='form-control' id='proyectos_edit_fechaini' name='proyectos_edit_fechaini' value='".$fecha_ini."'>
              </div>";
        echo "<div class='form-group form-group-view' ".$display.">
                <label class='labelBefore'>Fecha entrega:</label>
                <input type='date' class='form-control' id='proyectos_edit_fechaentrega' name='proyectos_edit_fechaentrega' value='".$fecha_entrega."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha fin:</label>
                <input type='date' class='form-control' id='proyectos_edit_fechafin' name='proyectos_edit_fechafin' value='".$fecha_fin."'>
              </div>";
        if ($tipoproyecto_id == 2) {
            echo "<div class='form-group form-group-view'>
                    <label class='labelBefore'>Visitas al año:</label>
                    <input type='number' class='form-control' id='proyectos_mant_year_visits' name='proyectos_mant_year_visits' value='".$visitas_year."'>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='labelBefore'>Días de visita:</label>
                    <input type='number' class='form-control' id='proyectos_mant_days_visit' name='proyectos_mant_days_visit' value='".$dias_visita."'>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='labelBefore'>Técnicos por visita:</label>
                    <input type='number' class='form-control' id='proyectos_mant_tecs_visit' name='proyectos_mant_tecs_visit' value='".$tecnicos_visita."'>
                  </div>";
        }
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Subproyecto de:</label>
                    <select id='proyectos_parent' name='proyectos_parent' class='selectpicker' data-live-search='true' data-width='33%'>
                        <option></option>
                    </select>
                </div>";
        if ($tipoproyecto_id == 2) {
            echo "<div class='col-xs-6'>
                    <label for='newproyecto_clientes' class='labelBefore' style='color: #ffffff;'>oo </label>
                    <button type='button' id='btn_add_exp' class='btn btn-info'>Añadir Expediente</button>
                    <button type='button' id='btn_clear_exp' class='btn btn-primary'>Quitar Expediente</button>
                  </div>
              </div>
              <div class='form-group'></div>
                
                <div class='form-group form-group-view'>
                    <label class='labelBefore'>Expedientes".mysqli_num_rows($resultadoExp)."</label>
                    <select class='form-control' id='proyectos_expedientes' name='proyectos_expedientes[]' multiple readonly>";
            $resultadoExp = mysqli_query($connString, $sqlExp) or die("Error al ejcutar la consulta de los Expedientes");
            while ($registrosExp = mysqli_fetch_array($resultadoExp)) { 
                echo "
                        <option value='".$registrosExp[1]."'>".$registrosExp[0]." - ".$registrosExp[2]."</option>";
            }
            echo "  </select>
                </div>  
               ";
        }
        else {
            echo "</div>";
        }
        if ($tipoproyecto_id == 2) {
            echo "  <div class='form-group form-group-view'>
                        <div class='col-xs-6'>
                            <label class='labelBefore'>Fecha Visita:</label>
                            <input type='date' class='form-control' id='proyectos_edit_fechavisita' name='proyectos_edit_fechavisita'>
                        </div>
                        <div class='col-xs-6'>
                          <label for='newproyecto_clientes' class='labelBefore' style='color: #ffffff;'>oo </label>
                          <button type='button' id='btn_add_visita' class='btn btn-info'>Añadir Visita</button>
                          <!-- <button type='button' id='btn_clear_visita' class='btn btn-primary'>Quitar Visita</button>
                          <button type='button' id='btn_clear_visita' class='btn btn-primary'>REALIZADA</button> -->
                        </div>

                    </div>

                    <div class='form-group form-group-view'>
                        <label class='labelBefore'>Visitas</label>
                        <select class='form-control' id='proyectos_visitas' name='proyectos_visitas[]' multiple readonly>";
            $resultadoVisitas = mysqli_query($connString, $sqlVisitas) or die("Error al ejcutar la consulta de los Accesos");
            while ($registrosVisitas = mysqli_fetch_array($resultadoVisitas)) { 
                echo "
                            <option value='".$registrosVisitas[0]."' data-id='".$registrosVisitas[2]."'>$registrosVisitas[0]</option>";
            }
            echo "      </select>
                    </div>  
                   ";
        }
        echo "<div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Estado:</label>
                    <select id='proyectos_estados' name='proyectos_estados' class='selectpicker' data-live-search='true' data-width='33%'>
                        <option></option>
                    </select>
                </div>
              </div>";
        if($facturado==0){
            $optionfacturado="<option value='0'>NO FACTURADO</option><option value='1'>FACTURADO</option>";
        }elseif($facturado==1){
            $optionfacturado="<option value='1'>FACTURADO</option><option value='0'>NO FACTURADO</option>";
        }
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Facturado:</label>
                    <select id='proyectos_facturado' name='proyectos_facturado' class='selectpicker' data-live-search='true' data-width='33%'>
                        ".$optionfacturado."
                    </select>
                </div>
              </div>";
        echo "<div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Última modificación:</label> <label id='view_ref' style='padding-left: 8px; padding-right: 8px; background-color: #333; color: #ffffff;'>".$fecha_mod."</label>
              </div>";
        
    ?>
        <div class="form-group form-group-view" style="margin-top: 30px; ">
            <button type="button" class="btn btn-info" id="proyectos_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

    </tbody>
</table>

<div id="programar_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PROGRAMAR PARTIDO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="partido_id" id="partido_id">

                    <div class="form-group">
                        <div class="col-xs-6">
                            <label class="labelBeforeBlack">Fecha:</label>
                            <input type="datetime-local" class="form-control" id="partido_fecha" name="partido_fecha">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="labelBeforeBlack">Lugar:</label>
                        <input type="text" class="form-control" id="partido_lugar" name="partido_lugar">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_programar" class="btn btn-info">Programar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#project-title").html("<? echo $ref." - ".$nombreProyecto; ?>")
</script>

<!-- mispartidos -->