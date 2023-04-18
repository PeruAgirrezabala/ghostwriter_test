<!-- proveedor seleccionado -->
<div id="cliente-view">
    
    <?
        
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Nombre:</label> <label id='view_ref'>".$nombrecli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Dirección:</label> <label id='view_ref'>".$dircli."</label>
                  </div>"; // ?encode¿
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
                  </div>"; // encode ?¿
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Teléfono:</label> <label id='view_ref'>".$tlfnocli."</label>
                  </div>";
            echo "<div class='form-group form-group-view'>
                    <label class='viewTitle'>Email:</label> <label id='view_ref'>".$emailcli."</label>
                  </div>"; 
      
    ?>
</div>
