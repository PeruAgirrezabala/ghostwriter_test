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
                                <label id='view_ref'>".$cpcli." - ".$poblacioncli."</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$provinciacli."</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$paiscli."</label>
                              </div>";
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
                                <label id='view_ref'>".$provcp." - ".$provpobl."</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$provprov."</label>
                              </div>
                              <div class='form-group form-group-view-etiqueta'>
                                <label id='view_ref'>".$provpais."</label>
                              </div>";
            }
        }
        else {
            $printEnvio = $direccionEnvio;
        }
        $printFormaEnvioPortes = "<div class='form-group form-group-view-etiqueta'>
                                    <label id='view_ref'>ENVÍO: ".strtoupper($formaEnvio)."</label>
                                  </div>
                                  <div class='form-group form-group-view-etiqueta'>
                                    <label id='view_ref'>PORTES: ".strtoupper($envioPortes)."</label>
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
                    <label class='viewTitle'>Teléfono:</label> <label id='view_ref'>".$tlfnocli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Email:</label> <label id='view_ref'>".$emailcli."</label>
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
                    <label class='viewTitle'>Teléfono:</label> <label id='view_ref'>".$provtlfno."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Email:</label> <label id='view_ref'>".$provemail."</label>
                  </div>"; 
         
        }
    ?>
</div>
