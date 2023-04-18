<!-- proveedor seleccionado -->
<div id="proyecto-view">
    
    <?
        // Consulta origen generada en pedidos-datosgenerales.php
        
        echo "<div class='form-group form-group-view'>
                    <label class='viewTitle label-strong'>Cliente:</label> <label id='view_ref' class='label-strong'>".$clienteproyecto."</label>
                  </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Proyecto:</label> <label id='view_ref'>".$proyecto."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Entrega:</label> <label id='view_ref'>".$fecha_entregaproyecto."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descripción:</label> <label id='view_ref'>".$descproyecto."</label>
              </div>";
    ?>
</div>


<!-- mispartidos -->