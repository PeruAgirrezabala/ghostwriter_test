<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="pedidos_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Pedido guardado</p>
</div>
<div id="envio-view" style="padding-right: 10px;">
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    ENVIOS_CLI.id,
                    ENVIOS_CLI.ref,
                    ENVIOS_CLI.nombre,
                    ENVIOS_CLI.descripcion,
                    CLIENTES.nombre,
                    ENVIOS_CLI.fecha,
                    ENVIOS_CLI.fecha_entrega,
                    erp_users.nombre,
                    erp_users.apellidos,
                    PROYECTOS.ref,
                    PEDIDOS_PROV_ESTADOS.nombre,
                    PEDIDOS_PROV_ESTADOS.color,
                    ENVIOS_CLI.contacto, 
                    PEDIDOS_PROV_ESTADOS.id,
                    ENVIOS_CLI.proyecto_id,
                    ENVIOS_CLI.fecha_recepcion,
                    CLIENTES.id,
                    CLIENTES.direccion,
                    CLIENTES.poblacion,
                    CLIENTES.provincia,
                    CLIENTES.cp,
                    CLIENTES.pais,
                    CLIENTES.telefono,
                    CLIENTES.nif,
                    CLIENTES.email,
                    PROYECTOS.descripcion,
                    PROYECTOS.fecha_entrega,
                    erp_users.id,
                    ENVIOS_CLI.path, 
                    ENVIOS_CLI.ref_pedido_cliente, 
                    ENVIOS_CLI.ref_oferta_proveedor, 
                    ENVIOS_CLI.plazo,
                    ENVIOS_CLI.gastos_envio,
                    OFERTAS.ref,
                    OFERTAS.ID,
                    
                    TRANSPORTISTAS.nombre,
                    TRANSPORTISTAS.id,
                    ENVIOS_CLI.ref_transportista,
                    
                    ENTREGAS.ref,
                    ENTREGAS.id, 
                    ENVIOS_CLI.direccion_envio,
                    ENVIOS_CLI.forma_envio,
                    ENVIOS_CLI.portes,
                    
                    PROVEEDORES.id,
                    PROVEEDORES.direccion,
                    PROVEEDORES.poblacion,
                    PROVEEDORES.provincia,
                    PROVEEDORES.cp,
                    PROVEEDORES.pais,
                    PROVEEDORES.telefono,
                    PROVEEDORES.CIF,
                    PROVEEDORES.email,
                    PROVEEDORES.nombre,
                    
                    ENVIOS_CLI.destinatario,
                    ENVIOS_CLI.att,
                    ENVIOS_CLI.proveedor_id,
                    
                    PROVEEDORES.contacto,
                    CLIENTES.contacto,
                    
                    ENVIOS_CLI.tipo_envio_id,
                    ENVIOS_CLI_TIPOS.nombre
                FROM 
                    ENVIOS_CLI
                LEFT JOIN CLIENTES 
                    ON ENVIOS_CLI.cliente_id = CLIENTES.id
                LEFT JOIN PROVEEDORES 
                    ON ENVIOS_CLI.proveedor_id = PROVEEDORES.id
                INNER JOIN erp_users 
                    ON ENVIOS_CLI.tecnico_id = erp_users.id  
                INNER JOIN PEDIDOS_PROV_ESTADOS 
                    ON ENVIOS_CLI.estado_id = PEDIDOS_PROV_ESTADOS.id 
                LEFT JOIN PROYECTOS 
                    ON ENVIOS_CLI.proyecto_id = PROYECTOS.id 
                LEFT JOIN ENTREGAS
                    ON ENTREGAS.id = ENVIOS_CLI.entrega_id 
                LEFT JOIN OFERTAS 
                    ON ENVIOS_CLI.oferta_id = OFERTAS.id 	
                INNER JOIN TRANSPORTISTAS 
                    ON TRANSPORTISTAS.id = ENVIOS_CLI.transportista_id 
                INNER JOIN ENVIOS_CLI_TIPOS
                    ON ENVIOS_CLI.tipo_envio_id = ENVIOS_CLI_TIPOS.id
                WHERE
                    ENVIOS_CLI.id = ".$_GET['id'];
        file_put_contents("datosGen.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Envío");

        $registros = mysqli_fetch_row($resultado);

        $id = $_GET['id'];
        $ref = $registros[1];
        $tituloEnvio = $registros[2];
        $descripcion = $registros[3];
        $nombrecli = $registros[4];
        $fecha = $registros[5];
        $fecha_entrega = $registros[6];
        $tecnico = $registros[7];
        $tecnico_apellido = $registros[8];
        $proyecto = $registros[9];
        $estado = $registros[10];
        $estadocolor = $registros[11];
        $contacto = $registros[12];
        $estado_id = $registros[13];
        $proyecto_id = $registros[14];
        $fecha_recepcion = $registros[15];
        $cliente_id = $registros[16];
        
        $dircli = $registros[17];
        $poblacioncli = $registros[18];
        $provinciacli = $registros[19];
        $cpcli = $registros[20];
        $paiscli = $registros[21];
        $tlfnocli = $registros[22];
        $desccli = $registros[23];
        $emailcli = $registros[24];
        $clicontacto = $registros[57];
        
        $descproyecto = $registros[25];
        $fecha_entregaproyecto = $registros[26];
        
        $tecnico_id = $registros[27];
        
        $path = $registros[28];
        $ref_pedido_cli = $registros[29];
        $oferta_prov = $registros[30];
        $plazo = $registros[31];
        $gastos_envio = $registros[32];
        $ref_oferta = $registros[33];
        $oferta_id = $registros[34];
        $trans_nombre = $registros[35];
        $trans_id = $registros[36];
        $trans_ref = $registros[37];
        
        $entrega_ref = $registros[38];
        $entrega_id = $registros[39];
        
        $direccionEnvio = $registros[40];
        $formaEnvio = $registros[41];
        $envioPortes = $registros[42];
        
        $provid = $registros[43];
        $provdir = $registros[44];
        $provpobl = $registros[45];
        $provprov = $registros[46];
        $provcp = $registros[47];
        $provpais = $registros[48];
        $provtlfno = $registros[49];
        $provcif = $registros[50];
        $provemail = $registros[51];
        $provnombre = $registros[52];
        $provcontacto = $registros[56];
        
        $destinatario = $registros[53];
        $att = $registros[54];
        
        $tipoenvioid = $registros[58];
        $tipoenvionombre = $registros[59];
        
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>REF:</label> <label id='view_ref' class='label-strong'>".$ref."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>TÍTULO:</label> <label id='view_titulo'>".$tituloEnvio."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>TIPO:</label> <label id='view_tipo'>".$tipoenvionombre."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>CLIENTE:</label> <label id='view_nombrecli' class='label-strong'>".$nombrecli."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>PROVEEDOR:</label> <label id='view_nombreprov' class='label-strong'>".$provnombre."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>DESTINATARIO:</label> <label id='view_dest' class='label-strong'>".$destinatario."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>ATT:</label> <label id='view_att' class='label-strong'>".$att."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>OFERTA GENELEK:</label> <label id='view_oferta'><a href='/erp/apps/ofertas/editoferta.php?id='".$oferta_id." target='_blank'>".$ref_oferta."</a></label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>PEDIDO CLIENTE:</label> <label id='view_ref_pedidocli'>".$ref_pedido_cli."</label>
              </div>";  
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>OFERTA PROVEEDOR:</label> <label id='view_ref_ofertaprov'>".$oferta_prov."</label>
              </div>";  
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>TRANSPORTISTA:</label> <label id='view_trans_nombre' >".$trans_nombre."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>DIRECCIÓN DE ENVÍO:</label> <label id='view_direnvio'>".$direccionEnvio."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>FORMA DE ENVÍO:</label> <label id='view_formaenvio'>".$formaEnvio."</label>
              </div>"; 
        if($envioPortes==1){
            $envioPortesTexto="PAGADOS";
        }elseif($envioPortes==0){
            $envioPortesTexto="NO-PAGADOS";
        }
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>PORTES:</label> <label id='view_portes'>".$envioPortesTexto."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>REF TRANSPORTISTA:</label> <label id='view_trans_ref'>".$trans_ref."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>FECHA:</label> <label id='view_fecha'>".$fecha."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>PLAZO:</label> <label id='view_plazo'>".$plazo."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>FECHA ENTREGA:</label> <label id='view_fecha_entrega'>".$fecha_entrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>FECHA RECEPCIÓN:</label> <label id='view_fecha_recepcion'>".$fecha_recepcion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>GASTOS DE ENVÍO:</label> <label id='view_gastos'>".$gastos_envio."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>CONTACTO:</label> <label id='view_contacto'>".$contacto."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>PROYECTO:</label> <label id='view_entrega'>".$proyecto."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>ENTREGA:</label> <label id='view_recepcion'>".$entrega_ref."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Estado:</label> <label id='view_estado' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
    ?>
</div>
<div id="envio-edit" style="display: none; padding-right: 10px;">
    <form method="post" id="frm_editenvio">
    <?
        echo "  <input type='hidden' name='envios_edit_delenvio' id='envios_edit_delenvio' value=''>
                <input type='hidden' name='envios_edit_idenvio' id='envios_edit_idenvio' value=".$id.">
                <input type='hidden' name='envios_edit_path' id='envios_edit_path' value=".$path.">
                <input type='hidden' name='envios_edit_proyectoid' id='envios_edit_proyectoid' value=".$proyecto_id."> 
                <input type='hidden' name='envios_edit_estadoid' id='envios_edit_estadoid' value=".$estado_id.">
                <input type='hidden' name='tipoenvio_id' id='tipoenvio_id' value=".$tipoenvioid.">";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Título:</label>
                <input type='text' class='form-control' id='envios_edit_titulo' name='envios_edit_titulo' placeholder='Título del Pedido' value='".$tituloEnvio."'>
              </div>";
        $sql = "SELECT 
                    ENVIOS_CLI.id,
                    ENVIOS_CLI.nombre,
                    ENVIOS_CLI.tipo_envio_id                    
                FROM 
                    ENVIOS_CLI
                WHERE
                    ENVIOS_CLI.id = ".$_GET['id'];
        file_put_contents("datosGen.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Envío");

        $registros = mysqli_fetch_row($resultado);

        $id = $_GET['id'];
        $id_tipo_envio = $registros[2];
        echo "<input type='hidden' name='envios_edit_tipo' id='envios_edit_idenvio' value=".$id_tipo_envio.">";
        /*echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Tipo:</label>
                <select id='envios_edit_tipo' name='envios_edit_tipo' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";*/
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Transportista:</label>
                <select id='envios_edit_transportistas' name='envios_edit_transportistas' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Ref Transportista:</label>
                <input type='text' class='form-control' id='envios_edit_reftrans' name='envios_edit_reftrans' value='".$trans_ref."'>
              </div>";
        
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Cliente:</label>
                <select id='envios_edit_clientes' name='envios_edit_clientes' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Proveedor:</label>
                <select id='envios_edit_proveedores' name='envios_edit_proveedores' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Destinatario:</label>
                <small class='text-muted'>Introducir sólo si no se ha seleccionado cliente.</small>
                <input type='text' class='form-control' id='envios_edit_dest' name='envios_edit_dest' placeholder='Destinatario' value='".$destinatario."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Att:</label>
                <small class='text-muted'>Introducir sólo si no se ha seleccionado cliente.</small>
                <input type='text' class='form-control' id='envios_edit_att' name='envios_edit_att' placeholder='Att' value='".$att."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Dirección Envío:</label>
                <textarea class='form-control' id='envios_edit_direnvio' name='envios_edit_direnvio' placeholder='Introduce la dirección de envío o déjalo en blanco para coger la del cliente'>".$direccionEnvio."</textarea>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Forma Envío:</label>
                <input type='text' class='form-control' id='envios_edit_formaenvio' name='envios_edit_formaenvio' value='".$formaEnvio."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Portes:</label>
                <!--<input type='text' class='form-control' id='envios_edit_portes' name='envios_edit_portes' value='".$envioPortes."'>-->
                <select id='envios_edit_portes' name='envios_edit_portes' class='selectpicker' data-live-search='true'>
                    <option value=''></option>
                    <!--<option value=''>HAY QUE HCER MEJOR LA SELECT....</option>
                    <option value='1'>PAGADOS</option>
                    <option value='0'>NO PAGADOS</option>-->
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Gastos Envío:</label>
                <input type='text' class='form-control' id='envios_edit_gastos' name='envios_edit_gastos' value='".$gastos_envio."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Pedido Cliente:</label>
                <input type='text' class='form-control' id='envios_edit_pedido_CLI' name='envios_edit_pedido_CLI' value='".$ref_pedido_cli."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Oferta Proveedor:</label>
                <input type='text' class='form-control' id='envios_edit_ofertaprov' name='envios_edit_ofertaprov' value='".$oferta_prov."'>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Proyecto:</label>
                <select id='envios_edit_proyectos' name='envios_edit_proyectos' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Entrega:</label>
                <select id='envios_edit_entregas' name='envios_edit_entregas' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Oferta Genelek:</label>
                <select id='envios_edit_ofertas' name='envios_edit_ofertas' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha:</label>
                <input type='date' class='form-control' id='envios_edit_fecha' name='envios_edit_fecha' value='".$fecha."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha Entrega:</label>
                <input type='date' class='form-control' id='envios_edit_fechaentrega' name='envios_edit_fechaentrega' value='".$fecha_entrega."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha Recepción:</label>
                <input type='datetime-local' class='form-control' id='envios_edit_fecharecepcion' name='envios_edit_fecharecepcion' value='".$fecha_recepcion."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Plazo de Entrega:</label>
                <input type='text' class='form-control' id='envios_edit_plazo' name='envios_edit_plazo' placeholder='Plazo de entrega' value='".$plazo."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Contacto:</label>
                <input type='text' class='form-control' id='envios_edit_contacto' name='envios_edit_contacto' placeholder='Contacto' value='".$contacto."'>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>De:</label>
                <select id='envios_edit_tecnicos' name='envios_edit_tecnicos' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Estado:</label>
                <select id='envios_edit_estados' name='envios_edit_estados' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Descripción:</label>
                <textarea class='form-control' id='envios_edit_desc' name='envios_edit_desc' placeholder='Descripción de la Oferta'>".$descripcion."</textarea>
              </div>";
    ?>
        <div class="form-group form-group-view" style="margin-top: 30px; margin-bottom: 30px !important;">
            <button type="button" class="btn btn-info" id="envios_edit_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    $("#envio-title").html('<? echo $ref." - ".$tituloEnvio; ?>');
    $("#envio-titulo").html('<? echo $ref." - ".$tituloEnvio; ?>');
    $("#current-page").html('<? echo $ref." - ".$tituloEnvio; ?>');
    setTimeout(function(){
        $("#envios_edit_transportistas").selectpicker("val",<? echo $trans_id; ?>);
        $("#envios_edit_transportistas").selectpicker("refresh");
        $("#envios_edit_portes").selectpicker("val",<? echo $envioPortes; ?>);
        $("#envios_edit_portes").selectpicker("refresh");
        if(<? echo $envioPortes; ?>==1){
            $("#envios_edit_gastos").prop("disabled", true);
        }
        $("#envios_edit_proyectos").selectpicker("val",<? echo $proyecto_id; ?>);
        $("#envios_edit_proyectos").selectpicker("refresh");
        $("#envios_edit_estados").selectpicker("val",<? echo $estado_id; ?>);
        $("#envios_edit_estados").selectpicker("refresh");
        $("#envios_edit_tecnicos").selectpicker("val",<? echo $tecnico_id; ?>);
        $("#envios_edit_tecnicos").selectpicker("refresh");
        $("#envios_edit_clientes").selectpicker("val",<? echo $cliente_id; ?>);
        $("#envios_edit_clientes").selectpicker("refresh");
        $("#envios_edit_proveedores").selectpicker("val",<? echo $provid; ?>);
        $("#envios_edit_proveedores").selectpicker("refresh");
        $("#envios_edit_entregas").selectpicker("val",<? echo $entrega_id; ?>);
        $("#envios_edit_entregas").selectpicker("refresh");
        $("#envios_edit_ofertas").selectpicker("val",<? echo $oferta_id; ?>);
        $("#envios_edit_ofertas").selectpicker("refresh");
    }, 1000);
</script>

<!-- mispartidos -->