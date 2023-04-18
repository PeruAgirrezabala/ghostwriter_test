<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="int_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Actificación guardada</p>
</div>
<div id="act-view" style="padding-right: 10px; ">
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    ACTIVIDAD.id as actid,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.nombre,
                    ACTIVIDAD.descripcion,
                    ACTIVIDAD.fecha,
                    ACTIVIDAD.fecha_mod,
                    ACTIVIDAD.instalacion,
                    ACTIVIDAD.solucion,
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.observaciones,
                    ACTIVIDAD.item_id,
                    ACTIVIDAD_ESTADOS.nombre,
                    ACTIVIDAD_ESTADOS.color,
                    ACTIVIDAD_PRIORIDADES.nombre,
                    ACTIVIDAD_PRIORIDADES.color,
                    CREADA.nombre,
                    CREADA.apellidos,
                    ASIGNADO.nombre,
                    ASIGNADO.apellidos,
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
                    ACTIVIDAD.item_id as item,
                    (SELECT PROYECTOS.ref FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.nombre FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.descripcion FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.fecha_ini FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.ref FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.titulo FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.descripcion FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.fecha FROM OFERTAS WHERE id = item),
                    ASIGNADO.id,
                    ACTIVIDAD.estado_id,
                    ACTIVIDAD.prioridad_id,
                    TAREAS.nombre,
                    ACTIVIDAD.tarea_id,
                    ACTIVIDAD.imputable,
                    ACTIVIDAD.facturable,
                    ACTIVIDAD_CATEGORIAS.nombre,
                    ACTIVIDAD.categoria_id,
                    ACTIVIDAD.fecha_factu,
                    TAREAS.perfil_id,
                    (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    ACTIVIDAD.path,
                    ACTIVIDAD.fecha_fin,
                    CREADA.id
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES 
                    ON ACTIVIDAD.cliente_id = CLIENTES.id
                INNER JOIN ACTIVIDAD_PRIORIDADES  
                    ON ACTIVIDAD.prioridad_id = ACTIVIDAD_PRIORIDADES.id 
                INNER JOIN erp_users CREADA  
                    ON ACTIVIDAD.responsable = CREADA.id 
                LEFT JOIN erp_users AS ASIGNADO
                    ON ACTIVIDAD.tecnico_id = ASIGNADO.id  
                LEFT JOIN ACTIVIDAD_ESTADOS 
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                LEFT JOIN ACTIVIDAD_CATEGORIAS 
                    ON ACTIVIDAD.categoria_id = ACTIVIDAD_CATEGORIAS.id
                LEFT JOIN TAREAS 
                    ON ACTIVIDAD.tarea_id = TAREAS.id
                WHERE
                    ACTIVIDAD.id = ".$_GET['id'];
        //file_put_contents("datosGen.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de la Actividad1");

        $registros = mysqli_fetch_row($resultado);
        
        if($registros[6]!=""){
            $sqlInstalaciones="SELECT CLIENTES_INSTALACIONES.nombre FROM CLIENTES_INSTALACIONES WHERE CLIENTES_INSTALACIONES.id=".$registros[6];
            file_put_contents("instalacionesCliente.txt", $sqlInstalaciones);
            $resInst = mysqli_query($connString, $sqlInstalaciones) or die("Error al ejcutar la consulta de la Actividad2");
            $regInst = mysqli_fetch_row($resInst);
            $nameInstalacion = $regInst[0];
        }else{
            $nameInstalacion ="";
        }
        
        
        
        $id = $_GET['id'];
        $ref = $registros[1];
        $tituloAct = $registros[2];
        $descripcionAct = $registros[3];
        $fechaAct = $registros[4];
        $fecha_mod = $registros[5];
        $instalacionAct = $registros[6];
        $solucionAct = $registros[7];
        $dateSol = new DateTime($registros[8]);
        $fecha_sol = $dateSol->format('Y-m-d');;
        $obsAct = $registros[9];
        $proyecto_id = $registros[10];
        $estado = $registros[11];
        $estadocolor = $registros[12];
        $prior = $registros[13];
        $priorcolor = $registros[14];
        $creadapor = $registros[15];
        $creadapor_apellido = $registros[16];
        $tecnico = $registros[17];
        $tecnico_apellido = $registros[18];
        $idcli = $registros[19];
        $nombrecli = $registros[20];
        $dircli = $registros[21];
        $poblacioncli = $registros[22];
        $provinciacli = $registros[23];
        $cpcli = $registros[24];
        $paiscli = $registros[25];
        $tlfnocli = $registros[26];
        $nifcli = $registros[27];
        $emailcli = $registros[28];
        $itemId = $registros[29];
        $categoriaId = $registros[46];
        $fecha_fin = $registros[51];
        $creadorId = $registros[52];
        
        $mantId = "";
        $proyId = "";
        $oferId = "";
        switch ($categoriaId) {
            case "1":
                $tipoItemLink = "/erp/apps/mantenimientos/view.php?id=".$itemId;
                $objItemlink ='<button type="button" class="btn btn-success btn-circle" title="Ir a"><a href="'.$tipoItemLink.'" target="_blank"><img src="/erp/img/link-w.png"></a></button>';
                $itemTipo = "MANTENIMIENTO";
                $item_ref = $registros[30];
                $item_nombre = $registros[31];
                $item_desc = $registros[32];
                $item_fecha = $registros[33];
                $mantId = $itemId;
                break;
            case "2":
                $tipoItemLink = "/erp/apps/proyectos/view.php?id=".$itemId;
                $objItemlink ='<button type="button" class="btn btn-success btn-circle" title="Ir a"><a href="'.$tipoItemLink.'" target="_blank"><img src="/erp/img/link-w.png"></a></button>';
                $itemTipo = "INTERVENCIÓN";
                $item_ref = $registros[30];
                $item_nombre = $registros[31];
                $item_desc = $registros[32];
                $item_fecha = $registros[33];
                $proyId = $itemId;
                break;
            case "3":
                $tipoItemLink = "/erp/apps/proyectos/view.php?id=".$itemId;
                $objItemlink ='<button type="button" class="btn btn-success btn-circle" title="Ir a"><a href="'.$tipoItemLink.'" target="_blank"><img src="/erp/img/link-w.png"></a></button>';
                $itemTipo = "PROYECTO";
                $item_ref = $registros[30];
                $item_nombre = $registros[31];
                $item_desc = $registros[32];
                $item_fecha = $registros[33];
                $proyId = $itemId;
                break;
            case "4":
                $tipoItemLink = "/erp/apps/ofertas/editOferta.php?id=".$itemId;
                $objItemlink ='<button type="button" class="btn btn-success btn-circle" title="Ir a"><a href="'.$tipoItemLink.'" target="_blank"><img src="/erp/img/link-w.png"></a></button>';
                $itemTipo = "OFERTA";
                $item_ref = $registros[34];
                $item_nombre = $registros[35];
                $item_desc = $registros[36];
                $item_fecha = $registros[37];
                $oferId = $itemId;
                break;
            default:
                $item_ref = "";
                $objItemlink ='';
                $item_nombre = "";
                $item_desc = "";
                $item_fecha = "";
                break;
        }
        if($_SESSION['user_role_id']==1 || $_SESSION['user_role_id']==12 || $_SESSION['user_role_id']==14){
            //$objItemlink=$objItemlink;
        }else{
            $objItemlink="";
        }
        
        $tecnico_id = $registros[38];
        $estado_id = $registros[39];
        $prior_id = $registros[40];
        $tareaNombre = $registros[41];
        $tareaId = $registros[42];
        if ($registros[43] == 1) {
            $imputable = "SI";
        }
        else {
            $imputable = "NO";
        }
        if ($registros[44] == 1) {
            $facturable = "SI";
        }
        else {
            $facturable = "NO";
        }
        $categoriaNombre = $registros[45];
        $fechaFactu = $registros[47];
        $tareaPerfilID = $registros[48];
        $totalHoras = $registros[49];
        $path = $registros[50];
        
        echo "<legend class='col-form-label' style='padding-left: 15px; font-weight: 600;'>Registro</legend>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>RESPONSABLE:</label> <label id='view_titulo'>".$creadapor." ".$creadapor_apellido."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>FECHA:</label> <label id='view_titulo'>".$fechaAct."</label><label class='viewTitle' style='padding-left:5em'>FECHA FIN:</label> <label id='view_titulo'>".$fecha_fin."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>CLIENTE:</label> <label id='view_titulo'>".$nombrecli."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>INSTALACIÓN:</label> <label id='view_titulo'>".$nameInstalacion."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>TÍTULO:</label> <label id='view_titulo'>".$tituloAct."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>DESCRIPCIÓN:</label> <label id='view_titulo'>".substr($descripcionAct, 0, 300)."...</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>TOTAL HORAS:</label> <label id='view_titulo' class='label label-warning'>".$totalHoras."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>ESTADO:</label> <label id='view_estado' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
        echo "<div class='form-group'></div>";
        
        echo "<legend class='col-form-label' style='padding-left: 15px; font-weight: 600;'>Clasificación</legend>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>CATEGORÍA:</label> <label id='view_titulo'>".$categoriaNombre."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>TAREA:</label> <label id='view_titulo'>".$tareaNombre."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>ELEMENTO:</label> <label id='view_titulo'>".$itemTipo." - ".$item_ref." ".$objItemlink."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>PRIORIDAD:</label> <label id='view_prior' class='label label-".$priorcolor."'>".$prior."</label>
              </div>";
        echo "<div class='form-group form-group-view' id='act_tecs'>
                <label class='viewTitle '>TÉCNICO/S:</label>";
            echo "<label id='view_titulo'></label>";
        
        echo "</div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>FACTURABLE:</label> <label id='view_titulo'>".$facturable."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>IMPUTABLE:</label> <label id='view_titulo'>".$imputable."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>Última modificación:</label> <label id='view_ref' style='padding-left: 8px; padding-right: 8px; background-color: #333; color: #ffffff;'>".$fecha_mod."</label>
              </div>";
    ?>
</div>
<div id="act-edit" style="display: none; padding-right: 10px; color: #219ae0;">
    <form method="post" id="frm_editact">
    <?
        echo "  <input type='hidden' name='act_edit_delact' id='act_edit_delact' value=''>
                <input type='hidden' name='act_edit_idact' id='act_edit_idact' value=".$id.">
                <input type='hidden' name='act_edit_path' id='act_edit_path' value=".$path.">
                <input type='hidden' name='act_edit_proyectoid' id='act_edit_proyectoid' value=".$proyecto_id."> 
                <input type='hidden' name='act_edit_ref' id='act_edit_ref' value=".$ref.">
                <input type='hidden' name='act_edit_tarea_perfilid' id='act_edit_tarea_perfilid' value=".$tareaPerfilID."> 
                <input type='hidden' name='act_edit_estadoid' id='act_edit_estadoid' value=".$estado_id.">";
        
        echo "  <legend class='col-form-label' style='padding-left: 15px; font-weight: 600;'>Registro</legend>
                <div class='form-group'>
                    <label for='act_responsable' class='col-xs-1-5' style='text-align: right;'>Origen/Fechas<span class='requerido'>*</span>:</label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_responsable' name='act_edit_responsable' class='selectpicker' data-live-search='true' data-width='33%'>
                            <option></option>
                        </select>
                    </div>
                    <div class='col-xs-3' style='float:left !important;'>
                        <input type='date' class='form-control' id='act_edit_fecha' name='act_edit_fecha' value='".$fechaAct."'>
                    </div>
                    <div class='col-xs-3' style='float:left !important;'>
                        <input type='date' class='form-control' id='act_edit_fecha_fin' name='act_edit_fecha_fin' value='".$fecha_fin."'>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='act_edit_clientes' class='col-xs-1-5' style='text-align: right;'>Cliente/Inst.:</label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_clientes' name='act_edit_clientes' class='selectpicker' data-live-search='true' data-width='33%'>
                            <option></option>
                        </select>
                    </div>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_instalacion' name='act_edit_instalacion' class='selectpicker' placeholder='Instalación' data-live-search='true' data-width='33%'>
                            <option></option>
                        </select>
                        <!--<input type='text' class='form-control' id='act_edit_instalacion' name='act_edit_instalacion' placeholder='Instalación' value='".$instalacionAct."'>-->
                    </div>
                    <div class='col-xs-3' style='float:left !important;'>
                        <button class='button' type='button' id='add-instalacion' title='Añadir Instalación'>
                            <img src='/erp/img/add.png' height='28'>
                        </button>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'>
                    <label for='act_edit_categorias' class='col-xs-1-5' style='text-align: right;'>Título: <span class='requerido'>*</span></label>
                    <div class='col-xs-10' style='float:left !important;'>
                        <input type='text' class='form-control' id='act_edit_nombre' name='act_edit_nombre' value='".$tituloAct."'>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='act_edit_desc' class='col-xs-1-5' style='text-align: right;'>Descripción:</label>
                    <div class='col-xs-10' style='float:left !important;'>
                        <textarea class='form-control' id='act_edit_desc' name='act_edit_desc' placeholder='Descripción de la Actividad' rows='8'>".$descripcionAct."</textarea>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='act_edit_estados' class='col-xs-1-5' style='text-align: right;'>Estado: <span class='requerido'>*</span></label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_estados' name='act_edit_estados' class='selectpicker' data-live-search='true' data-width='33%'>
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'></div>

                <legend class='col-form-label' style='display: inline-grid; padding-left: 15px; font-weight: 600;'>Clasificación</legend>
                <div class='form-group'>
                    <label for='act_edit_categorias' class='col-xs-1-5' style='text-align: right;'>Cat.<span class='requerido'>*</span>/Tarea<span class='requerido'>*</span>:</label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_categorias' name='act_edit_categorias' class='selectpicker' data-live-search='true' data-width='33%' placeholder='Categorías' title='Categorías'>
                            <option></option>
                        </select>
                    </div>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_tareas' name='act_edit_tareas' class='selectpicker' data-live-search='true' data-width='33%' placeholder='Tareas' title='Tareas'>
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'>
                    <label for='act_edit_mantenimientos' class='col-xs-1-5' style='text-align: right;'>Item: <span class='requerido'>1*</span></label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_mantenimientos' name='act_edit_mantenimientos' class='selectpicker' data-live-search='true' data-width='33%' placeholder='Mantenimientos' title='Mantenimientos'>
                            <option></option>
                        </select>
                    </div>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_proyectos' name='act_edit_proyectos' class='selectpicker' data-live-search='true' data-width='33%' placeholder='Proyectos' title='Proyectos'>
                            <option></option>
                        </select>
                    </div>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_ofertas' name='act_edit_ofertas' class='selectpicker' data-live-search='true' data-width='33%' placeholder='Ofertas' title='Ofertas'>
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'>
                    <label for='act_edit_prior' class='col-xs-1-5' style='text-align: right;'>Prioridad: <span class='requerido'>*</span></label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_prior' name='act_edit_prior' class='selectpicker' data-live-search='true' data-width='33%'>
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'>
                    <label for='act_edit_tecnicos' class='col-xs-1-5' style='text-align: right;'>Asignado: <span class='requerido'>*</span></label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_tecnicos' name='act_edit_tecnicos' class='selectpicker' data-live-search='true' data-width='33%' title='Técnico Asignado'>
                            <option></option>
                        </select>
                    </div>
                    <div class='col-xs-3' style='float:left !important;'>
                        <button type='button' id='btn_add_tec' class='btn btn-info'>Añadir Técnico</button>
                        <button type='button' id='btn_clear_tec' class='btn btn-primary'>Quitar Técnico</button>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'>
                    <div class='col-xs-1-5'></div>
                    <div class='col-xs-3' id='div_act_edit_addtecnicos'>
                            <select class='form-control' id='act_edit_addtecnicos' name='act_edit_addtecnicos[]' multiple readonly>
                            </select>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'>
                    <label for='act_edit_chkfacturable' class='col-xs-1-5' style='text-align: right;'>Facturable:</label>
                    <div class='col-xs-1' style='float:left !important;'>
                        <input type='checkbox' name='act_edit_chkfacturable' id='act_edit_chkfacturable' data-size='mini'>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'>
                    <label for='act_edit_chkimputable' class='col-xs-1-5' style='text-align: right;'>Imputable:</label>
                    <div class='col-xs-1' style='float:left !important;'>
                        <input type='checkbox' name='act_edit_chkimputable' id='act_edit_chkimputable' data-size='mini'>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'></div>
                ";
        
    ?>
        <div class="form-group form-group-view" style="margin-top: 30px; margin-bottom: 30px !important;">
            <button type="button" class="btn btn-primary" id="act_edit_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    $("#act-title").html('<? echo $ref." - ".$tituloAct; ?>');
    $("#act-titulo").html('<? echo $ref." - ".$tituloAct; ?>');
    $("#current-page").html('<? echo $ref." - ".$tituloAct; ?>');
    setTimeout(function(){
        $("#act_edit_mantenimientos").selectpicker("val",<? echo $mantId; ?>);
        $("#act_edit_mantenimientos").selectpicker("refresh");
        $("#act_edit_proyectos").selectpicker("val",<? echo $proyId; ?>);
        $("#act_edit_proyectos").selectpicker("refresh");
        $("#act_edit_ofertas").selectpicker("val",<? echo $oferId; ?>);
        $("#act_edit_ofertas").selectpicker("refresh");
        $("#act_edit_estados").selectpicker("val",<? echo $estado_id; ?>);
        $("#act_edit_estados").selectpicker("refresh");
        $("#act_edit_estados_fin").selectpicker("val",<? echo $estado_id; ?>);
        $("#act_edit_estados_fin").selectpicker("refresh");
        $("#act_edit_prior").selectpicker("val",<? echo $prior_id; ?>);
        $("#act_edit_prior").selectpicker("refresh");
        $("#act_edit_tecnicos").selectpicker("val",<? echo $tecnico_id; ?>);
        $("#act_edit_tecnicos").selectpicker("refresh");
        $("#act_edit_responsable").selectpicker("val",<? echo $creadorId; ?>);
        $("#act_edit_responsable").selectpicker("refresh");
        $("#act_edit_clientes").selectpicker("val",<? echo $idcli; ?>);
        $("#act_edit_clientes").selectpicker("refresh");
        $("#act_edit_instalacion").selectpicker("val",<? echo $instalacionAct; ?>);
        $("#act_edit_instalacion").selectpicker("refresh");
        $("#act_edit_categorias").selectpicker("val",<? echo $categoriaId; ?>);
        $("#act_edit_categorias").selectpicker("refresh");
        $("#act_edit_tareas").selectpicker("val",<? echo $tareaId; ?>);
        $("#act_edit_tareas").selectpicker("refresh");
        $('#act_edit_chkfacturable').bootstrapSwitch('state',parseInt(<? echo $registros[44]; ?>));
        $('#act_edit_chkimputable').bootstrapSwitch('state',parseInt(<? echo $registros[43]; ?>));
        $(".selectpicker").selectpicker("render");
    }, 2000);
    // Seleccionar TODOS los tecnicos de esa actividad;
    loadActTecnico("act_tecs", "div_act_edit_addtecnicos",  <? echo $id; ?>);
    $("#act_edit_addtecnicos").selectpicker("refresh");
    
</script>

<!-- mispartidos -->