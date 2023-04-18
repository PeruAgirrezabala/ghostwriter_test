<!-- proyectos seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="entregas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Entrega guardada</p>
</div>
<div id="entrega-view" style="margin-bottom: 20px;">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    ENTREGAS.id,
                    ENTREGAS.ref,
                    ENTREGAS.nombre,
                    ENTREGAS.descripcion,
                    PROYECTOS.nombre, 
                    ENTREGAS.fecha_entrega,
                    ENTREGAS.fecha_pruebas,
                    ENTREGAS.fecha_realentrega,
                    ESTADOS_ENTREGAS.nombre,
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    ESTADOS_ENTREGAS.color, 
                    ESTADOS_ENTREGAS.id, 
                    PROYECTOS.path, 
                    PROYECTOS.id,
                    ENTREGAS.fecha_mod,
                    CLIENTES.id,
                    ENTREGAS.instalacion_id,
                    CLIENTES_INSTALACIONES.nombre
                FROM 
                    PROYECTOS, ESTADOS_ENTREGAS, ENTREGAS, CLIENTES, CLIENTES_INSTALACIONES 
                WHERE
                    PROYECTOS.cliente_id = CLIENTES.id
                AND
                    PROYECTOS.id = ENTREGAS.proyecto_id
                AND 
                    ENTREGAS.estado_id = ESTADOS_ENTREGAS.id 
                AND 
                    ENTREGAS.instalacion_id = CLIENTES_INSTALACIONES.id
                AND
                    ENTREGAS.id = ".$_GET['id'];

        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas");

        $registros = mysqli_fetch_row($resultado);

        $id = $_GET['id'];
        $ref = $registros[1];
        $nombreEntrega = $registros[2];
        $descripcion = $registros[3];
        $proyecto = $registros[4];
        $fecha_entrega = $registros[5];
        $fecha_pruebas = $registros[6];
        $fecha_realentrega = $registros[7];
        $estado = $registros[8];
        $cliente = $registros[9];
        $clientebrand = $registros[10];
        $estadocolor = $registros[11];
        $estado_id = $registros[12];
        $proyectopath = $registros[13];
        $proyecto_id = $registros[14];
        $fecha_mod = $registros[15];
        $cliente_id = $registros[16];
        $instalacion_id = $registros[17];
        $instalacion_nombre = $registros[18];

        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>Cliente:</label> <label id='view_ref' class='label-strong'>".$cliente."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Instalacion:</label> <label id='view_ref'>".$instalacion_nombre."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>Proyecto:</label> <label id='view_ref' class='label-strong'>".$proyecto."</label>
              </div>";  
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Ref:</label> <label id='view_ref'>".$ref."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Nombre:</label> <label id='view_ref'>".$nombreEntrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descripción:</label> <label id='view_ref'>".$descripcion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Entrega:</label> <label id='view_ref'>".$fecha_entrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Pruebas:</label> <label id='view_ref'>".$fecha_pruebas."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha real Entrega:</label> <label id='view_ref'>".$fecha_realentrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Estado:</label> <label id='view_ref' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Última modificación:</label> <label id='view_ref' style='padding-left: 8px; padding-right: 8px; background-color: #333; color: #ffffff;'>".$fecha_mod."</label>
              </div>";
    ?>
</div>
<div id="entrega-edit" style="display: none;">
    <form method="post" id="frm_entrega">
    <?
        echo "  <input type='hidden' name='entregas_delentrega' id='entregas_delentrega' value=''>
                <input type='hidden' name='entregas_identrega' id='entregas_identrega' value=".$id.">
                <input type='hidden' name='entregas_idproyecto' id='entregas_idproyecto' value=".$proyecto_id.">
                <input type='hidden' name='entregas_clienteid' id='entregas_clienteid' value=".$cliente_id."> 
                <input type='hidden' name='entregas_proyectopath' id='entregas_proyectopath' value=".$proyectopath.">
                <input type='hidden' name='entregas_estadoid' id='entregas_estadoid' value=".$estado_id.">
                <input type='hidden' name='entregas_instalacionid' id='entregas_instalacionid' value=".$instalacion_id.">";
        
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Cliente:</label>
                    <select id='entregas_clientes' name='entregas_clientes' class='selectpicker' data-live-search='true' data-width='33%' disabled>
                        <option>".$cliente."</option>
                    </select>
                </div>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Instalación: <span class='requerido'>*</span></label>
                    <div class='col-xs-2'>
                        <button class='button' type='button' id='add-instalacion' title='Añadir Instalación'>
                            <img src='/erp/img/add.png' height='28'>
                        </button>
                    </div>
                    <div class='col-xs-10'>
                        <select id='entregas_instalacion' name='entregas_instalacion' class='selectpicker' data-live-search='true' data-width='33%'>
                            <option></option>
                        </select>
                    </div>
                    
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Proyecto:</label> 
                    <input disabled type='text' class='form-control' id='entregas_edit_proyecto' class='label-strong' value='".$proyecto."'>
                </div>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Ref:</label>
                    <input disabled type='text' class='form-control' id='entregas_edit_ref' name='entregas_edit_ref' placeholder='Referencia del Proyecto' value='".$ref."' >
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Nombre:</label>
                    <input disabled type='text' class='form-control' id='entregas_edit_nombre' name='entregas_edit_nombre' placeholder='Nombre del Proyecto' value='".$nombreEntrega."'>
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-10'>
                    <label class='labelBefore'>Descripción:</label>
                    <textarea class='form-control' id='entregas_edit_desc' name='entregas_edit_desc' placeholder='Descripción de la Entrega'>".$descripcion."</textarea>
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Fecha entrega:</label>
                    <input type='date' class='form-control' id='entregas_edit_fechaentrega' name='entregas_edit_fechaentrega' value='".$fecha_entrega."'>
                </div>
              </div>";        
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Fecha Inicio Pruebas:</label>
                    <input type='date' class='form-control' id='entregas_edit_fecha' name='entregas_edit_fecha' value='".$fecha_pruebas."'>
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Fecha real Entrega:</label>
                    <input type='date' class='form-control' id='entregas_edit_fecharealentrega' name='entregas_edit_fecharealentrega' value='".$fecha_realentrega."'>
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Estado:</label>
                    <select id='entregas_estados' name='entregas_estados' class='selectpicker' data-live-search='true' data-width='33%'>
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
            <button type="button" class="btn btn-info" id="entregas_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

    </tbody>
</table>

<script>
    $("#entrega-title").html("<? echo $ref." - ".$nombreEntrega; ?>");
</script>

<!-- mispartidos -->