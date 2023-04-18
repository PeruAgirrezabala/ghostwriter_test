<!-- proveedor seleccionado -->
<div id="cliente-view">
    
    <?
        // Consulta origen generada en pedidos-datosgenerales.php
    
        if ($direccionEnvio == "") {
            if ($nombrecli != "") {
                $direccionEnvio = "La dirección del cliente";
                $printEnvio = "<div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref' class='label-strong'>".$nombrecli."</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <hr>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$dircli."</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$cpcli." - ".$poblacioncli." (".$provinciacli.")</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$paiscli."</label>
                              </div>";
                if ($contacto == "") {
                    $contacto = $clicontacto;
                }   
            }
            else {
                $direccionEnvio = "La dirección del proveedor";
                $printEnvio = "<div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref' class='label-strong'>".$provnombre."</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <hr>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$provdir."</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$provcp." - ".$provpobl." (".$provprov.")</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$provpais."</label>
                              </div>";
                if ($contacto == "") {
                    $contacto = $provcontacto;
                }   
            }
        }
        else {
            $printEnvio = "<div class='form-group form-group-view-etiqueta'><label id='view_ref'>".$direccionEnvio."</label></div>";
        }
        
        $printFormaEnvioPortes = "<div class='form-group form-group-view-etiqueta'>
                                    <label id='view_ref'>ENVÍO: ".strtoupper($formaEnvio)."</label>
                                  </div>
                                  <div class='form-group form-group-view-etiqueta'>
                                    <label id='view_ref'>PORTES: ".strtoupper($envioPortes)."</label>
                                  </div>
                                  <div class='form-group form-group-view-etiqueta'>
                                    <label id='view_ref_att'>ATT: ".strtoupper($contacto)."</label>
                                  </div>";
        
        if ($nombrecli != "") {
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Nombre:</label> <label id='view_ref'>".$nombrecli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Dirección:</label> <label id='view_ref'>".$dircli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Población:</label> <label id='view_ref'>".$poblacioncli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>CP:</label> <label id='view_ref'>".$cpcli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Provincia:</label> <label id='view_ref'>".$provinciacli."</label>
                  </div>";   
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>País:</label> <label id='view_ref'>".$paiscli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Contacto:</label> <label id='view_ref'>".$clicontacto."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Teléfono:</label> <label id='view_ref'>".$tlfnocli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Email:</label> <label id='view_ref'>".$emailcli."</label>
                  </div>"; 
            echo "<div class='form-group form-group-view'>
                    <hr width='100%' style='margin-top:10px; height:1px;'>
                  </div>"; 
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Enviado a la dirección:</label>
                  </div>"; 

            echo "<div class='form-group form-group-view'>
                    <label id='view_ref'>".$direccionEnvio."</label>
                  </div>"; 
        }
        else {
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Nombre:</label> <label id='view_ref'>".$provnombre."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Dirección:</label> <label id='view_ref'>".$provdir."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Población:</label> <label id='view_ref'>".$provpobl."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>CP:</label> <label id='view_ref'>".$provcp."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Provincia:</label> <label id='view_ref'>".$provprov."</label>
                  </div>";   
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>País:</label> <label id='view_ref'>".$provpais."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Contacto:</label> <label id='view_ref'>".$provcontacto."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Teléfono:</label> <label id='view_ref'>".$provtlfno."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Email:</label> <label id='view_ref'>".$provemail."</label>
                  </div>"; 
            echo "<div class='form-group form-group-view'>
                    <hr width='100%' style='margin-top:10px; height:1px;'>
                  </div>"; 
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Enviado a la dirección:</label>
                  </div>"; 

            echo "<div class='form-group form-group-view'>
                    <label id='view_ref'>".$direccionEnvio."</label>
                  </div>"; 
        }
    ?>
</div>

<div id="etiqueta_transportista_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">ETIQUETA TRANSPORTISTA</h4>
            </div>
            <div class="modal-body">
                
                <div class="contenedor-form" id="etiqueta_transportista">
                    <div id="aside-transportista">
                        <div class="inner rotate">DESTINATARIO</div>
                    </div>
                    <? echo $printEnvio; ?>
                    <? echo $printFormaEnvioPortes; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_print_etiqueta" class="btn btn-info">Imprimir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>