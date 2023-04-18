<!-- proveedor seleccionado -->
<div id="proyecto-view">
    
    <?
        // Consulta origen generada en pedidos-datosgenerales.php
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Tipo:</label> <label id='view_ref'>".$itemTipo."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>REF:</label> <label id='view_ref'>".$item_ref."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Título:</label> <label id='view_ref'>".$item_nombre."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha:</label> <label id='view_ref'>".$item_fecha."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descripción:</label> <label id='view_ref'>".$item_desc."</label>
              </div>";
    ?>
</div>


<!-- mispartidos -->