<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="int_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Intervención guardada</p>
</div>
<div id="int-view" style="padding-right: 10px;">
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    INTERVENCIONES.id,
                    INTERVENCIONES.ref,
                    INTERVENCIONES.nombre,
                    INTERVENCIONES.descripcion,
                    INTERVENCIONES.fecha,
                    INTERVENCIONES.fecha_mod,
                    INTERVENCIONES.instalacion,
                    INTERVENCIONES.solucion,
                    INTERVENCIONES.fecha_solucion,
                    INTERVENCIONES.observaciones,
                    INTERVENCIONES.proyecto_id,
                    INTERVENCIONES.fecha_factu,
                    INTERVENCIONES_ESTADOS.nombre,
                    INTERVENCIONES_ESTADOS.color,
                    erp_users.nombre,
                    erp_users.apellidos,
                    erp_users.firma_path,
                    CLIENTES.id,
                    CLIENTES.nombre,
                    CLIENTES.direccion,
                    CLIENTES.poblacion,
                    CLIENTES.provincia,
                    CLIENTES.cp,
                    CLIENTES.pais,
                    CLIENTES.telefono,
                    CLIENTES.nif,
                    CLIENTES.email,
                    OFERTAS.ref,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.descripcion,
                    PROYECTOS.fecha_entrega,
                    erp_users.id,
                    INTERVENCIONES.facturable,
                    INTERVENCIONES.estado_id
                FROM 
                    INTERVENCIONES
                LEFT JOIN CLIENTES 
                    ON INTERVENCIONES.cliente_id = CLIENTES.id
                LEFT JOIN OFERTAS 
                    ON INTERVENCIONES.oferta_id = OFERTAS.id
                INNER JOIN erp_users  
                    ON INTERVENCIONES.tecnico_id = erp_users.id  
                LEFT JOIN INTERVENCIONES_ESTADOS 
                    ON INTERVENCIONES.estado_id = INTERVENCIONES_ESTADOS.id 
                LEFT JOIN PROYECTOS 
                    ON INTERVENCIONES.proyecto_id = PROYECTOS.id 
                WHERE
                    INTERVENCIONES.id = ".$_GET['id'];
        file_put_contents("datosGen.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de la Itervención");

        $registros = mysqli_fetch_row($resultado);

        $id = $_GET['id'];
        $ref = $registros[1];
        $tituloInt = $registros[2];
        $descripcionInt = $registros[3];
        $fechaInt = $registros[4];
        $fecha_mod = $registros[5];
        $instalacionInt = $registros[6];
        $solucionInt = $registros[7];
        $fecha_sol = $registros[8];
        $obsInt = $registros[9];
        $proyecto_id = $registros[10];
        $fecha_factu = $registros[11];
        $estado = $registros[12];
        $estadocolor = $registros[13];
        $tecnico = $registros[14];
        $tecnico_apellido = $registros[15];
        $tecnico_firma = $registros[16];
        $idcli = $registros[17];
        $nombrecli = $registros[18];
        $dircli = $registros[19];
        $poblacioncli = $registros[20];
        $provinciacli = $registros[21];
        $cpcli = $registros[22];
        $paiscli = $registros[23];
        $tlfnocli = $registros[24];
        $nifcli = $registros[25];
        $emailcli = $registros[26];
        $ofertaid = $registros[27];
        $proyecto_ref = $registros[28];
        $proyecto_nombre = $registros[29];
        $proyecto_desc = $registros[30];
        $proyecto_fechaentrega = $registros[31];
        $tecnico_id = $registros[32];
        $facturable = $registros[33];
        $estado_id = $registros[34];
        
        if ($facturable == 1) {
            $facturable = "checked";
            $facturableView = "SI";
        }
        else {
            $facturable = "";
            $facturableView = "NO";
        }
        
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>REF:</label> <label id='view_ref' class='label-strong'>".$ref."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>TÍTULO:</label> <label id='view_titulo'>".$tituloInt."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>DESCRIPCIÓN:</label> <label id='view_titulo'>".$descripcionInt."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>FECHA:</label> <label id='view_titulo'>".$fechaInt."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>INSTALACIÓN:</label> <label id='view_titulo'>".$instalacionInt."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>FACTURABLE:</label> <label id='view_titulo'>".$facturableView."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>FECHA FACTURACIÓN:</label> <label id='view_titulo'>".$fecha_factu."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>TÉCNICOS:</label>
              </div>"; 
        $sqlTec = "SELECT 
                        erp_users.id, erp_users.nombre, erp_users.apellidos
                    FROM 
                        erp_users, INTERVENCIONES_TECNICOS  
                    WHERE 
                        INTERVENCIONES_TECNICOS.erpuser_id = erp_users.id 
                    AND
                        INTERVENCIONES_TECNICOS.int_id = ".$id."
                    ORDER BY 
                        erp_users.nombre ASC";
        file_put_contents("querTec.txt", $sqlTec);
        $resultadoTec = mysqli_query($connString, $sqlTec) or die("Error al ejcutar la consulta de los Tecnicos");
            
        echo "<div class='form-group form-group-view'>
                    <div class='col-xs-4'>";
        // INSERTO TABLA CON LOS TÉCNICOS ASOCIADOS
            echo "      <table class='table table-striped table-hover tabla-mant-exp' style='margin-bottom: 5px !important;'>
                            <thead>";
            while ($registrosTec = mysqli_fetch_array($resultadoTec)) { 
                $estilo = "class='info'";
                echo "
                                <tr ".$estilo." data-id='".$registrosTec[0]."'>
                                    <td style='text-align:center;'>".$registrosTec[1]." ".$registrosTec[2]."</td> 
                                </tr>";
            }
            echo "          </thead> 
                        </table>";
            // ************ TÉCNICOS *******************

        echo "      </div>
                </div>
            ";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>ESTADO:</label> <label id='view_estado' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Última modificación:</label> <label id='view_ref' style='padding-left: 8px; padding-right: 8px; background-color: #333; color: #ffffff;'>".$fecha_mod."</label>
              </div>";
    ?>
</div>
<div id="int-edit" style="display: none; padding-right: 10px;">
    <form method="post" id="frm_editint">
    <?
        echo "  <input type='hidden' name='int_edit_delint' id='int_edit_delint' value=''>
                <input type='hidden' name='int_edit_idint' id='int_edit_idint' value=".$id.">
                <input type='hidden' name='int_edit_path' id='int_edit_path' value=".$path.">
                <input type='hidden' name='int_edit_proyectoid' id='int_edit_proyectoid' value=".$proyecto_id."> 
                <input type='hidden' name='int_edit_estadoid' id='int_edit_estadoid' value=".$estado_id.">";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>TÍTULO:</label>
                <input type='text' class='form-control' id='int_edit_titulo' name='int_edit_titulo' placeholder='Título de la Intervención' value='".$tituloInt."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>DESCRIPCIÓN:</label>
                <textarea class='form-control' id='int_edit_desc' name='int_edit_desc' placeholder='Descripción de la Intervención' rows='8'>".$descripcionInt."</textarea>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>FECHA:</label>
                <input type='date' class='form-control' id='int_edit_fecha' name='int_edit_fecha' value='".$fechaInt."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>FECHA FACTURACIÓN:</label>
                <input type='date' class='form-control' id='int_edit_fecha_factu' name='int_edit_fecha_factu' value='".$fecha_factu."'>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>CLIENTE:</label>
                <select id='int_edit_clientes' name='int_edit_clientes' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>PROYECTO:</label>
                <select id='int_edit_proyectos' name='int_edit_proyectos' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>OFERTA GENELEK:</label>
                <select id='int_edit_ofertas' name='int_edit_ofertas' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>INSTALACIÓN:</label>
                <input type='text' class='form-control' id='int_edit_instalacion' name='int_edit_instalacion' value='".$instalacionInt."'>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>RESPONSABLE GENELEK:</label>
                <select id='int_edit_tecnicos' name='int_edit_tecnicos' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
         
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>TÉCNICOS:</label>
                    <select id='int_edit_tecnicossel' name='int_edit_tecnicossel' class='selectpicker' data-live-search='true' data-width='33%'>
                        <option></option>
                    </select>
                </div>";
        echo "  <div class='col-xs-6'>
                    <label for='newproyecto_clientes' class='labelBefore' style='color: #ffffff;'>oo </label>
                    <button type='button' id='btn_add_tec' class='btn btn-info2'>Añadir Técnico</button>
                    <button type='button' id='btn_clear_tec' class='btn btn-primary'>Quitar Técnico</button>
                </div>
              </div>
              
              <div class='form-group'></div>
              <div class='form-group form-group-view'>
                <label class='labelBefore'>TÉCNICOS: </label>
                <select class='form-control' id='int_edit_tecnicosint' name='int_edit_tecnicosint[]' multiple readonly>";
        $resultadoTec = mysqli_query($connString, $sqlTec) or die("Error al ejcutar la consulta de los Técnicos");
        while ($registrosTec = mysqli_fetch_array($resultadoTec)) { 
            echo "
                    <option value='".$registrosTec[0]."'>".$registrosTec[1]." ".$registrosTec[2]."</option>";
        }
        echo "  </select>
              </div>  
           ";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>ESTADO:</label>
                <select id='int_edit_estados' name='int_edit_estados' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>
              <div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>FACTURABLE:</label>
                <input type='checkbox' name='int_edit_chkfacu' id='int_edit_chkfacu' ".$facturable." data-size='mini'>
              </div>
              <div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>OBSERVACIONES:</label>
                <textarea class='form-control' id='int_edit_observ' name='int_edit_observ' placeholder='Observaciones' rows='8'>".$obsInt."</textarea>
              </div>";
    ?>
        <div class="form-group form-group-view" style="margin-top: 30px; margin-bottom: 30px !important;">
            <button type="button" class="btn btn-info" id="int_edit_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    $("#int-title").html('<? echo $ref." - ".$tituloInt; ?>');
    $("#int-titulo").html('<? echo $ref." - ".$tituloInt; ?>');
    $("#current-page").html('<? echo $ref." - ".$tituloInt; ?>');
    setTimeout(function(){
        $("#int_edit_proyectos").selectpicker("val",<? echo $proyecto_id; ?>);
        $("#int_edit_proyectos").selectpicker("refresh");
        $("#int_edit_estados").selectpicker("val",<? echo $estado_id; ?>);
        $("#int_edit_estados").selectpicker("refresh");
        $("#int_edit_tecnicos").selectpicker("val",<? echo $tecnico_id; ?>);
        $("#int_edit_tecnicos").selectpicker("refresh");
        $("#int_edit_clientes").selectpicker("val",<? echo $idcli; ?>);
        $("#int_edit_clientes").selectpicker("refresh");
        $("#int_edit_ofertas").selectpicker("val",<? echo $ofertaid; ?>);
        $("#int_edit_ofertas").selectpicker("refresh");
    }, 1000);
</script>

<!-- mispartidos -->