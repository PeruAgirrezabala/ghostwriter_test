<!-- proveedor seleccionado -->
<div id="proyecto-view">
    
    <?
        // Consulta origen generada en pedidos-datosgenerales.php
        
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Proyecto:</label> <label id='view_ref'>".$proyecto_nombre."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Entrega:</label> <label id='view_ref'>".$fecha_entregaproyecto."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descripción:</label> <label id='view_ref'>".$proyecto_desc."</label>
              </div>";
    ?>
</div>


<!-- mispartidos -->