<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="pedidos_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Pedido guardado</p>
</div>
<div id="pedido-view" style="padding-right: 10px;">
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
		mysqli_set_charset($connString,"utf8");
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.ref,
                    PEDIDOS_PROV.titulo,
                    PEDIDOS_PROV.descripcion,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    erp_users.nombre,
                    erp_users.apellidos,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre,
                    PEDIDOS_PROV_ESTADOS.color,
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV.contacto, 
                    PEDIDOS_PROV_ESTADOS.id,
                    PEDIDOS_PROV.proyecto_id,
                    PROVEEDORES.direccion,
                    PROVEEDORES.poblacion,
                    PROVEEDORES.provincia,
                    PROVEEDORES.cp,
                    PROVEEDORES.pais,
                    PROVEEDORES.telefono,
                    PROVEEDORES.descripcion,
                    PROVEEDORES.dto,
                    PROVEEDORES.email,
                    PROYECTOS.descripcion,
                    PROYECTOS.fecha_entrega,
                    CLIENTES.nombre, 
                    erp_users.id,
                    PEDIDOS_PROV.fecha_recepcion, 
                    PROVEEDORES.id, 
                    PEDIDOS_PROV.forma_pago, 
                    PEDIDOS_PROV.path, 
                    PEDIDOS_PROV.pedido_genelek, 
                    PEDIDOS_PROV.ref_oferta_prov, 
                    PEDIDOS_PROV.plazo,
                    PROVEEDORES.contacto,
                    PROVEEDORES.email_pedidos,
                    PROVEEDORES.formaPago,
                    PROYECTOS.ubicacion,
                    PROYECTOS.dir_instalacion,
                    PROYECTOS.coordgps_instalacion,
                    PROYECTOS.ref,
                    CLIENTES.img,
                    PEDIDOS_PROV.cliente_id,
                    CLIPEDIDO.nombre, 
                    FORMAS_PAGO.nombre,
                    PEDIDOS_PROV.dir_entrega,
                    PEDIDOS_PROV.fecha_mod,
                    PEDIDOS_PROV.observaciones,
                    PEDIDOS_PROV.fecha_prog
                FROM 
                    PEDIDOS_PROV
                INNER JOIN PROVEEDORES 
                    ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id
                INNER JOIN erp_users 
                    ON PEDIDOS_PROV.tecnico_id = erp_users.id  
                INNER JOIN PEDIDOS_PROV_ESTADOS 
                    ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                LEFT JOIN PROYECTOS 
                    ON PEDIDOS_PROV.proyecto_id = PROYECTOS.id 
                LEFT JOIN CLIENTES 
                    ON PROYECTOS.cliente_id = CLIENTES.id 
                LEFT JOIN CLIENTES CLIPEDIDO
                    ON PEDIDOS_PROV.cliente_id = CLIPEDIDO.id
                LEFT JOIN FORMAS_PAGO
                    ON FORMAS_PAGO.id = PEDIDOS_PROV.forma_pago_id 
                WHERE
                    PEDIDOS_PROV.id = ".$_GET['id'];
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Pedido");

        $registros = mysqli_fetch_row($resultado);

        $id = $_GET['id'];
        $ref = $registros[1];
        $tituloPedido = $registros[2];
        $descripcion = $registros[3];
        $nombreprov = $registros[4];
        $fecha = $registros[5];
        $fecha_entrega = $registros[6];
        $tecnico = $registros[7];
        $tecnico_apellido = $registros[8];
        $proyecto = $registros[9];
        $estado = $registros[10];
        $estadocolor = $registros[11];
        $total = $registros[12];
        $formapago = $registros[31];
        $contacto = $registros[13];
        $estado_id = $registros[14];
        $proyecto_id = $registros[15];
        $fecha_recepcion= $registros[29];
        $proveedor_id = $registros[30];
        
        $dirprov = $registros[16];
        $poblacionprov = $registros[17];
        $provinciaprov = $registros[18];
        $cpprov = $registros[19];
        $paisprov = $registros[20];
        $tlfnoprov = $registros[21];
        $descprov = $registros[22];
        $dtoprov = $registros[23];
        $emailprov = $registros[24];
        
        $descproyecto = $registros[25];
        $fecha_entregaproyecto = $registros[26];
        $clienteproyecto = $registros[27];
        
        $tecnico_id = $registros[28];
        
        $path = $registros[32];
        $pedido_genelek = $registros[33];
        $oferta_prov = $registros[34];
        $plazo = $registros[35];
        
        $contactoprov = $registros[36];
        $emailpedidosprov = $registros[37];
        $formapagoprov = $registros[38];
        
        $proyectoUbicacion = $registros[39];
        $proyectoDirInst = $registros[40];
        $proyectoGPSInst = $registros[41];
        $proyectoREF = $registros[42];
        $clienteIMG = $registros[43];
        
        $clientePedidoID = $registros[44];
        $clientePedidoNombre = $registros[45];
        
        $formaPagoNombre = $registros[46];
        $dirEntrega = $registros[47];
        
        $fecha_mod = $registros[48];
        $observ = $registros[49];
        $fecha_prog = $registros[50];
        
        if (($estado_id != 2) &&($estado_id != 7)) {
            $pedido_file_path = "file:////192.168.3.108/ERP/MATERIAL/PEDIDOS".$path.$pedido_genelek.".pdf";
        }
        else {
            $pedido_file_path = "";
        }
        
        if ($clienteproyecto == "") {
            $clienteproyecto = $clientePedidoNombre;
        }
        
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>Pedido Genelek:</label> <label id='view_ref'>".$pedido_genelek."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>Proyecto:</label> <label id='view_ref' class='label-strong'>".$proyecto."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Pedido Cliente:</label> <label id='view_ref'>".$ref."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Ref Oferta Prov:</label> <label id='view_ref'>".$oferta_prov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Expediente:</label> <label id='view_ref'>".$proyectoREF."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Cliente:</label> <label id='view_ref'>".$clientePedidoNombre."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Título:</label> <label id='view_titulo'>".$tituloPedido."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descripción:</label> <label id='view_desc'>".$descripcion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha:</label> <label id='view_fecha'>".$fecha."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Entrega:</label> <label id='view_entrega'>".$fecha_entrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Dirección Entrega:</label> <label id='view_entrega'>".$dirEntrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Recepción:</label> <label id='view_recepcion'>".$fecha_recepcion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Modificación:</label> <label id='view_recepcion'>".$fecha_mod."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>De:</label> <label id='view_tecnico'>".$tecnico." ".$tecnico_apellido."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Forma de Pago:</label> <label id='view_formapago'>".$formapago."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Forma de Pago Interna:</label> <label id='view_formapagoInterna'>".$formaPagoNombre."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Contacto:</label> <label id='view_contacto'>".$contacto."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Estado:</label> <label id='view_estado' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Programada:</label> <label id='view_recepcion'>".$fecha_prog."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Observaciones:</label> <label id='view_desc'>".$observ."</label>
              </div>";
    ?>
</div>
<div id="pedido-edit" style="display: none;">
    <form method="post" id="frm_editpedido">
    <?
        echo "  <input type='hidden' name='pedidos_edit_delpedido' id='pedidos_edit_delpedido' value=''>
                <input type='hidden' name='pedidos_edit_idpedido' id='pedidos_edit_idpedido' value=".$id.">
                <input type='hidden' name='pedidos_edit_path' id='pedidos_edit_path' value=".$path.">
                <input type='hidden' name='pedidos_edit_proyectoid' id='pedidos_edit_proyectoid' value=".$proyecto_id."> 
                <input type='hidden' name='pedidos_edit_estadoid' id='pedidos_edit_estadoid' value=".$estado_id.">";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Pedido Cliente:</label>
                <input type='text' class='form-control' id='pedidos_edit_ref' name='pedidos_edit_ref' placeholder='Pedido del Cliente' value='".$ref."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>OFERTA PROVEEDOR:</label>
                <input type='text' class='form-control' id='pedidos_edit_ofertaprov' name='pedidos_edit_ofertaprov' placeholder='Referencia de la Oferta del Proveedor' value='".$oferta_prov."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Título: <span class='requerido'>*</span></label>
                <input type='text' class='form-control prohibido' id='pedidos_edit_titulo' name='pedidos_edit_titulo' placeholder='Título del Pedido' value='".$tituloPedido."' disabled>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Descripción:</label>
                <textarea class='form-control' id='pedidos_edit_desc' name='pedidos_edit_desc' placeholder='Descripción del Pedido'>".$descripcion."</textarea>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Cliente: <span class='requerido2'>*</span></label>
                <select id='pedidos_edit_clientes' name='pedidos_edit_clientes' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Proyecto: <span class='requerido'>*</span></label>
                <select id='pedidos_edit_proyectos' name='pedidos_edit_proyectos' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Proveedor: <span class='requerido'>*</span></label>
                <select id='pedidos_edit_proveedores' name='pedidos_edit_proveedores' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha: <span class='requerido'>*</span></label>
                <input type='date' class='form-control' id='pedidos_edit_fecha' name='pedidos_edit_fecha' value='".$fecha."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha Entrega:</label>
                <input type='date' class='form-control' id='pedidos_edit_fechaentrega' name='pedidos_edit_fechaentrega' value='".$fecha_entrega."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Dirección Entrega:</label>
                <textarea class='form-control' id='pedidos_edit_direntrega' name='pedidos_edit_direntrega' rows='5' placeholder='Dirección Entrega'>".$dirEntrega."</textarea>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha Recepción:</label>
                <input type='datetime-local' class='form-control' id='pedidos_edit_fecharecepcion' name='pedidos_edit_fecharecepcion' value='".date_format(date_create($fecha_recepcion), 'd-m-Y H:i')."'>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>De: <span class='requerido'>*</span></label>
                <select id='pedidos_edit_tecnicos' name='pedidos_edit_tecnicos' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Forma de Pago:</label>
                <input type='text' class='form-control' id='pedidos_edit_formapago' name='pedidos_edit_formapago' placeholder='Forma de pago' value='".$formapago."'>
              </div>";
        echo "<div class='form-group form-group-view' style='margin-bottom: 15px !important;'>
                <label class='labelBefore'>Forma de Pago Interna:</label>
                <select id='pedidos_edit_formaspago' name='pedidos_edit_formaspago' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Plazo de Entrega:</label>
                <input type='text' class='form-control' id='pedidos_edit_plazo' name='pedidos_edit_plazo' placeholder='Plazo de entrega' value='".$plazo."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Contacto:</label>
                <input type='text' class='form-control' id='pedidos_edit_contacto' name='pedidos_edit_contacto' placeholder='Contacto' value='".$contacto."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Estado: <span class='requerido'>*</span></label>
                <select id='pedidos_edit_estados' name='pedidos_edit_estados' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group'></div>
              <div class='form-group form-group-view'>
                <label class='labelBefore'>Fecha Programada:</label>
                <input type='date' class='form-control' id='pedidos_edit_fechaprog' name='pedidos_edit_fechaprog' value='".$fecha_prog."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Observaciones:</label>
                <textarea class='textarea-cp form-control' id='pedidos_edit_observ' name='pedidos_edit_observ' placeholder='Observaciones del Pedido' rows='10'>".$observ."</textarea>
              </div>";
        echo "<div class='form-group'>
                <span class='requerido'>*Campo obligatorio</span>
                <br>
                <span class='requerido2'>*Uno de los campos que contienen este simbolo debe de estar completado</span>
              </div>";
    ?>
        <div class="form-group form-group-view" style="margin-top: 30px; margin-bottom: 30px !important;">
            <button type="button" class="btn btn-info" id="pedidos_edit_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

<?
    // Selecciono tantos proyectos distintos como tengan los detalles del pedido para luego dar opcion a seleccionar 
    $sql = "SELECT DISTINCT 
                PROYECTOS.nombre, 
                PROYECTOS.ref, 
                CLIENTES.nombre, 
                CLIENTES.img, 
                PROYECTOS.ubicacion, 
                PROYECTOS.coordgps_instalacion,
                PROYECTOS.dir_instalacion
            FROM 
                PEDIDOS_PROV_DETALLES, PEDIDOS_PROV, CLIENTES, PROYECTOS 
            WHERE 
                PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
            AND
                PEDIDOS_PROV_DETALLES.proyecto_id = PROYECTOS.id
            AND
                PROYECTOS.cliente_id = CLIENTES.id
            AND 
                PEDIDOS_PROV.id = ".$_GET['id'];
    
    $resultado = mysqli_query($connString, $sql) or die("Error seleccionando los Proyectos de los Detalles");
    
    $botoneraSelect = "<div class='form-group form-group-view'>
                            <label class='labelBefore'>Proyectos:</label>
                            <select id='pedidos_detalles_proyectos' name='pedidos_detalles_proyectos' class='selectpicker' data-live-search='true' data-width='33%'>
                                <option></option>";
    $contador = 1;
    $textareaSelect = "";
    while ($registros = mysqli_fetch_array($resultado)) { 
        $proyectoTmp = $registros[0];
        $proyectoRefTmp = $registros[1];
        $clienteTmp = $registros[2];
        $clienteImgTmp = $registros[3];
        $proyectoUbicacionTmp = $registros[4];
        $proyectoGPSTmp = $registros[5];
        $proyectoDirTmp = $registros[6];
        $etiquetaHTML = "<div class='form-group form-group-view-etiqueta'>
                            <label id='view_ref' class='label-strong'>".$proyectoTmp."</label>
                         </div>
                         <div class='form-group form-group-view-etiqueta'>
                            <hr>
                         </div>
                         <div class='form-group form-group-view-etiqueta'>
                            <label id='view_ref'>EXPEDIENTE: <strong>".$proyectoRefTmp."</strong></label>
                         </div>
                         <div class='form-group form-group-view-etiqueta'>
                            <label id='view_ref'>CLIENTE: ".$clienteTmp."</label>
                         </div>
                         <div class='form-group form-group-view-etiqueta'>
                            <label id='view_ref'>INSTALACION: ".$proyectoUbicacionTmp."</label>
                         </div>
                         <div class='form-group form-group-view-etiqueta'>
                            <label id='view_ref'>DIRECCIÓN: ".$proyectoDirTmp."</label>
                         </div>
                         <div class='form-group form-group-view-etiqueta'>
                            <label id='view_ref'>COORD GPS: ".$proyectoGPSTmp."</label>
                         </div>
                         <div class='form-group form-group-view-etiqueta'>
                            <label id='view_ref'>PEDIDO Nº: <strong>".$pedido_genelek."</strong></label>
                         </div>
                         <div class='form-group form-group-view-etiqueta'>
                            <label id='view_ref'>PROV.: <strong>".$nombreprov."</strong></label>
                         </div>

                         <img class='imgPrint' src='".$clienteImgTmp."'>
                        ";
        $textareaSelect .= "<textarea id='printEtiqueta".$contador."' style='display:none;'>".$etiquetaHTML."</textarea>";
        $botoneraSelect .= "<option value='printEtiqueta".$contador."'>".$proyectoTmp."</option>";
        $contador = $contador + 1;
    }
    $botoneraSelect .= "    </select>
                        </div>";
    
    /*
    if ($proyecto == "") {
        $proyecto = $tituloPedido;
    }
    */
    if ($proyecto != "") {
        $printRecibido = "<div class='form-group form-group-view-etiqueta'>
                        <label id='view_ref' class='label-strong'>".$proyecto."</label>
                      </div>
                      <div class='form-group form-group-view-etiqueta'>
                        <hr>
                      </div>
                      <div class='form-group form-group-view-etiqueta'>
                        <label id='view_ref'>EXPEDIENTE: <strong>".$proyectoREF."</strong></label>
                      </div>
                      <div class='form-group form-group-view-etiqueta'>
                        <label id='view_ref'>CLIENTE: ".$clienteproyecto."</label>
                      </div>
                      <div class='form-group form-group-view-etiqueta'>
                        <label id='view_ref'>INSTALACION: ".$proyectoUbicacion."</label>
                      </div>
                      <div class='form-group form-group-view-etiqueta'>
                        <label id='view_ref'>DIRECCIÓN: ".$proyectoDirInst."</label>
                      </div>
                      <div class='form-group form-group-view-etiqueta'>
                        <label id='view_ref'>COORD GPS: ".$proyectoGPSInst."</label>
                      </div>
                      <div class='form-group form-group-view-etiqueta'>
                        <label id='view_ref'>PEDIDO Nº: <strong>".$pedido_genelek."</strong></label>
                      </div>
                      <div class='form-group form-group-view-etiqueta'>
                        <label id='view_ref'>PROV.: <strong>".$nombreprov."</strong></label>
                      </div>
                      
                        <img class='imgPrint' src='".$clienteIMG."'>
                      ";
     
    }
    else {
        $printRecibido = "";
    }
    
?>

<div id="etiqueta_recibido_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ETIQUETA PARA MATERIAL RECIBIDO</h4>
            </div>
            <div class="modal-body">
                <? echo $textareaSelect; ?>
                <? echo $botoneraSelect; ?> 
                <div class="form-group"></div>
                <div class="contenedor-form" id="etiqueta_recibido">
                    <? echo $printRecibido; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_print_recibido" class="btn btn-info2">Imprimir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#pedido-title").html('<? echo $pedido_genelek." - ".$tituloPedido; ?>');
    $("#pagina-titulo").html('<? echo $pedido_genelek." | Erp GENELEK"; ?>');
    $("#current-page").html('<? echo $pedido_genelek." - ".$tituloPedido; ?>');
    setTimeout(function(){
        $("#pedidos_edit_clientes").selectpicker("val",<? echo $clientePedidoID; ?>);
        $("#pedidos_edit_clientes").selectpicker("refresh");
        $("#pedidos_edit_proyectos").selectpicker("val",<? echo $proyecto_id; ?>);
        $("#pedidos_edit_proyectos").selectpicker("refresh");
        $("#pedidos_edit_estados").selectpicker("val",<? echo $estado_id; ?>);
        $("#pedidos_edit_estados").selectpicker("refresh");
        $("#pedidos_edit_tecnicos").selectpicker("val",<? echo $tecnico_id; ?>);
        $("#pedidos_edit_tecnicos").selectpicker("refresh");
        $("#pedidos_edit_proveedores").selectpicker("val",<? echo $proveedor_id; ?>);
        $("#pedidos_edit_proveedores").selectpicker("refresh");
        $("#pedidos_edit_formaspago").selectpicker("val",<? echo $formaPagoId; ?>);
        $("#pedidos_edit_formaspago").selectpicker("refresh");
    }, 1300);
</script>

