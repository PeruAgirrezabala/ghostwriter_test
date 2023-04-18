<!-- proveedor seleccionado -->
<div id="proveedor-view">
    
    <?
        // Consulta origen generada en pedidos-datosgenerales.php
		file_put_contents("kklogs.txt", $nombreprov);
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Nombre:</label> <label id='view_ref'>".$nombreprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Dirección:</label> <label id='view_ref'>".$dirprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Población:</label> <label id='view_ref'>".$poblacionprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Provincia:</label> <label id='view_ref'>".$provinciaprov."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>CP:</label> <label id='view_ref'>".$cpprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>País:</label> <label id='view_ref'>".$paisprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Teléfono:</label> <label id='view_ref'>".$tlfnoprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Contacto:</label> <label id='view_ref'>".$contactoprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Email Pedidos:</label> <label id='view_ref'>".$emailpedidosprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Email:</label> <label id='view_ref'>".$emailprov."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Forma Pago:</label> <label id='view_ref'>".$formapagoprov."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Observaciones:</label> <label id='view_ref'>".$descprov."</label>
              </div>"; 
    ?>
    
    <div id="dash-documentos-add" class="one-column" style="margin-bottom: 0px;">
        <hr class="dash-underline">
        <div id="treeview_json_docprov">
            <? //include($pathraiz."/apps/material/vistas/pedido-documentos.php"); ?>
        </div>
    </div>
    <script>
        // CARGA DEL ARBOL DE DOCUMENTOS
        var treeData;
        console.log("start");
        $.ajax({
            type: "GET",  
            url: "/erp/apps/empresas/responseDocs.php",
            data: {
                id: <? echo $proveedor_id; ?>
            },
            dataType: "json",       
            success: function(response)  
            {
                  console.log("ok");
                  initTree(response, "treeview_json_docprov");
            }   
        });

        function initTree(treeData, treeElement) {
            //console.log(treeData);
            $('#' + treeElement).treeview({
                data: treeData,
                enableLinks: true,
                state: {
                    checked: true,
                    disabled: true,
                    expanded: true,
                    selected: true
                },
            });
        }
    </script>
</div>