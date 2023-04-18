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
                PROYECTOS.cliente_final,
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
                PROYECTOS.ubicacion,
                PROYECTOS.dir_instalacion,
                PROYECTOS.coordgps_instalacion,
                ING.nombre,
                DIROBRA.nombre,
                PROMOTOR.nombre,
                PROYECTOS.jefeobra,
                PROYECTOS.tec1,
                PROYECTOS.tec2,
                ING.id,
                DIROBRA.id,
                PROMOTOR.id
            FROM 
                PROYECTOS
            INNER JOIN CLIENTES
                ON PROYECTOS.cliente_id = CLIENTES.id
            INNER JOIN PROYECTOS_ESTADOS
                ON PROYECTOS.estado_id = PROYECTOS_ESTADOS.id
            INNER JOIN TIPOS_PROYECTO
                ON PROYECTOS.tipo_proyecto_id = TIPOS_PROYECTO.id
            LEFT JOIN CLIENTES as ING
                ON PROYECTOS.ingenieria_id = ING.id
            LEFT JOIN CLIENTES as DIROBRA
                ON PROYECTOS.dir_obra_id = DIROBRA.id 
            LEFT JOIN CLIENTES as PROMOTOR  
                ON PROYECTOS.promotor_id = PROMOTOR.id 
            WHERE 
                PROYECTOS.id = ".$_GET['id'];

        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");

        $registros = mysqli_fetch_row($resultado);

        $id = $_GET['id'];
        $ref = $registros[1];
        $nombreProyecto = $registros[2];
        $cliente_final= $registros[3];
        $descripcion = $registros[4];
        $fecha_ini = $registros[5];
        $fecha_entrega = $registros[6];
        $fecha_fin = $registros[7];
        $fecha_mod = $registros[8];
        $estado = $registros[9];
        $cliente = $registros[10];
        $clientebrand = $registros[11];
        $estadocolor = $registros[12];
        $estado_id = $registros[13];
        $cliente_id = $registros[14];
        $proyectopath = $registros[15];
        $tipoproyecto = $registros[16];
        $tipoproyecto_id = $registros[17];
        $tipoproyectocolor = $registros[18];
        $parent_id = $registros[19];
        $ubicacion = $registros[20];
        $dir_instalacion = $registros[21];
        $coordgps_instalacion = $registros[22];
        $ing = $registros[23];
        $dirobra = $registros[24];
        $promotor = $registros[25];
        $jefeobra = $registros[26];
        $tec1 = $registros[27];
        $tec2 = $registros[28];
        $ingID = $registros[29];
        $dirobraid = $registros[30];
        $promotorID = $registros[31];

        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>Cliente:</label> <label id='view_ref' class='label-strong'>".$cliente."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
              <label class='viewTitle label-strong'>Cliente Final:</label> <label id='view_ref' class='label-strong'>".$cliente_final."</label>
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
                <label class='viewTitle'>Ingeniería:</label> <label id='view_ref'>".$ing."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Dirección Obra:</label> <label id='view_ref'>".$dirobra."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Promotor:</label> <label id='view_ref'>".$promotor."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Jefe Obra:</label> <label id='view_ref'>".$jefeobra."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Tecnico 1:</label> <label id='view_ref'>".$tec1."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Tecnico 2:</label> <label id='view_ref'>".$tec2."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>fecha inicio:</label> <label id='view_ref'>".$fecha_ini."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha entrega:</label> <label id='view_ref'>".$fecha_entrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha fin:</label> <label id='view_ref'>".$fecha_fin."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Estado:</label> <label id='view_ref' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Instalación:</label> <label id='view_ref'>".$ubicacion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Dirección:</label> <label id='view_ref'>".$dir_instalacion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Coord. GPS:</label> <label id='view_ref'>".$coordgps_instalacion." <span class='glyphicon glyphicon-map-marker' aria-hidden='true'></span> <a href='https://www.google.com/maps/search/?api=1&query=".$coordgps_instalacion."' target='_blank'>Ir al Mapa</a></label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Última modificación:</label> <label id='view_ref' style='padding-left: 8px; padding-right: 8px; background-color: #333; color: #ffffff;'>".$fecha_mod."</label>
              </div>";
    ?>
</div>
<div id="project-edit" style="display: none;">
    <form method="post" id="frm_proyecto">
    <?
        echo "  <input type='hidden' name='proyectos_delproyecto' id='proyectos_delproyecto' value=''>
                <input type='hidden' name='proyectos_idproyecto' id='proyectos_idproyecto' value=".$id.">
                <input type='hidden' name='proyectos_clienteid' id='proyectos_clienteid' value=".$cliente_id."> 
                <input type='hidden' name='proyectos_parentid' id='proyectos_parentid' value=".$parent_id."> 
                <input type='hidden' name='proyectos_tipoid' id='proyectos_tipoid' value=".$tipoproyecto_id."> 
                <input type='hidden' name='proyectos_path' id='proyectos_path' value=".$proyectopath.">
                <input type='hidden' name='proyectos_estadoid' id='proyectos_estadoid' value=".$estado_id.">
                <input type='hidden' name='proyectos_ingid' id='proyectos_ingid' value=".$ingID.">
                <input type='hidden' name='proyectos_dirobraid' id='proyectos_dirobraid' value=".$dirobraID.">
                <input type='hidden' name='proyectos_promotorid' id='proyectos_promotorid' value=".$promotorID.">";
                
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Cliente:</label>
                <select id='proyectos_clientes' name='proyectos_clientes' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group'></div>";
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
                <label class='labelBefore'>Ingeniería:</label>
                <select id='proyectos_ing' name='proyectos_ing' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Dirección Obra:</label>
                <select id='proyectos_dirobra' name='proyectos_dirobra' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Promotor:</label>
                <select id='proyectos_promotor' name='proyectos_promotor' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Jefe de Obra:</label>
                <textarea class='form-control' id='proyectos_edit_jefeobra' name='proyectos_edit_jefeobra' placeholder='Descripción del Proyecto'>".$jefeobra."</textarea>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Tecnico 1:</label>
                <textarea class='form-control' id='proyectos_edit_tec1' name='proyectos_edit_tec1' placeholder='Descripción del Proyecto'>".$tec1."</textarea>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Tecnico 2:</label>
                <textarea class='form-control' id='proyectos_edit_tec2' name='proyectos_edit_tec2' placeholder='Descripción del Proyecto'>".$tec2."</textarea>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Descripción:</label>
                <textarea class='form-control' id='proyectos_edit_desc' name='proyectos_edit_desc' placeholder='Descripción del Proyecto'>".$descripcion."</textarea>
              </div>";        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Instalación:</label>
                <input type='text' class='form-control' id='proyectos_edit_ubicacion' name='proyectos_edit_ubicacion' placeholder='Instalación del Cliente' value='".$ubicacion."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Dirección:</label>
                <input type='text' class='form-control' id='proyectos_edit_direccion' name='proyectos_edit_direccion' placeholder='Dirección de la Instalación' value='".$dir_instalacion."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Coord. GPS:</label>
                <input type='text' class='form-control' id='proyectos_edit_gps' name='proyectos_edit_gps' placeholder='Coordenadas GPSde la Instalación' value='".$coordgps_instalacion."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>fecha inicio:</label>
                <input type='date' class='form-control' id='proyectos_edit_fechaini' name='proyectos_edit_fechaini' value='".$fecha_ini."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha entrega:</label>
                <input type='date' class='form-control' id='proyectos_edit_fechaentrega' name='proyectos_edit_fechaentrega' value='".$fecha_entrega."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha fin:</label>
                <input type='date' class='form-control' id='proyectos_edit_fechafin' name='proyectos_edit_fechafin' value='".$fecha_fin."'>
              </div>";
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
                    <button type='button' id='btn_add_exp' class='btn btn-info2'>Añadir Expediente</button>
                  </div>
              </div>
              <div class='form-group'></div>
                
                <div class='form-group form-group-view'>
                    <label class='labelBefore'>Expedientes</label>
                    <select class='form-control' id='proyectos_expedientes' name='proyectos_expedientes' multiple readonly>
                    </select>
                </div>  
               ";
        }
        else {
            echo "</div>";
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

<script>
    $("#project-titulo").html("<? echo $ref." - ".$nombreProyecto; ?>")
    $("#project-title").html("<? echo $ref." - ".$nombreProyecto." - PROYECTOS"; ?>")
    $("#current-page").html("<? echo $ref." - ".$nombreProyecto; ?>");
</script>

<!-- mispartidos -->