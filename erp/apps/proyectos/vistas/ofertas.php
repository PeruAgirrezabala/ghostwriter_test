<!-- ofertas del proyecto seleccionado -->
<table class="table table-striped table-hover" id='tabla-ofertas'>
    <thead>
      <tr class="bg-dark">
        <th>REF</th>
        <th>FECHA</th>
        <th>OFERTA|CLIENTE</th>
        <th>ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                OFERTAS.id,
                OFERTAS.ref,
                OFERTAS.titulo,
                OFERTAS.fecha,
                OFERTAS.fecha_validez,
                OFERTAS_ESTADOS.nombre, 
                CLI1.nombre, 
                CLI1.img,
                OFERTAS_ESTADOS.color,
                CLI2.nombre, 
                CLI2.img,
                PROYECTOS.nombre                
            FROM 
                OFERTAS
            INNER JOIN OFERTAS_ESTADOS
                ON OFERTAS.estado_id = OFERTAS_ESTADOS.id 
            LEFT JOIN PROYECTOS
                ON OFERTAS.proyecto_id = PROYECTOS.id
            LEFT JOIN CLIENTES as CLI1
                ON PROYECTOS.cliente_id = CLI1.id
            LEFT JOIN CLIENTES as CLI2
                ON OFERTAS.cliente_id = CLI2.id  
            WHERE 
                OFERTAS.proyecto_id = ".$_GET['id']."
            ORDER BY 
                OFERTAS.fecha_mod DESC";
    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Ofertas");
    
    while ($registros = mysqli_fetch_array($resultado)) {
        $id = $registros[0];
        $ref = $registros[1];
        $titulo = $registros[2];
        $fecha = $registros[3];
        if ($registros[11] != "") {
            $cliente = $registros[6];
            $clienteimg = $registros[7];
        }
        else {
            $cliente = $registros[9];
            $clienteimg = $registros[10];
        }
        
        echo "
            <tr data-id='".$id."' class='oferta'>
                <td>".$ref."</td>
                <td>".$fecha."</td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$clienteimg."'>
                    </div> 
                        <div class='tabla-texto'>
                            ".$registros[2]."<span class='bajotexto'>".$cliente."</span>
                        </div>
                </td>
                <td><span class='label label-".$registros[8]."'>".$registros[5]."</span></td>
            </tr>
        ";
    }

?>
        
    </tbody>
</table>

<!-- ofertas del proyecto seleccionado -->

<!-- ventana modal para ver/editar la oferta -->

<div id="add_oferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AGREGAR OFERTA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="oferta_id" id="oferta_id">
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label class="labelBeforeBlack">Ref:</label>
                            <input type="text" class="form-control" id="oferta_ref" name="oferta_ref">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="labelBeforeBlack">Título:</label>
                        <input type="text" class="form-control" id="oferta_titulo" name="oferta_titulo">
                    </div>
                    
                    <div class="form-group">
                        <label class="labelBeforeBlack">Descripción:</label>
                        <input type="text" class="form-control" id="oferta_desc" name="oferta_desc">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_oferta" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="docs_oferta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DOCUMENTOS DE LA OFERTA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <div class="form-group">
                        <div id="treeview_json_docsOfertas">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        /*
        $("#tabla-ofertas tr").click(function() {
            location.href = "editoferta.php?id=" + $(this).data("id");
        });
        */
    });
</script>

<!-- -->