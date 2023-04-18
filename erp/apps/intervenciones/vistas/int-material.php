<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['id'])) {     
    $html = "";
    $sql = "SELECT 
                INTERVENCIONES_MATERIALES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.modelo,
                MATERIALES.fabricante,
                INTERVENCIONES_MATERIALES.unidades,
                INTERVENCIONES_MATERIALES.sustituido,
                INTERVENCIONES_MATERIALES.reparado,
                INTERVENCIONES.id,
                SERIAL_NUMBERS.sn,
                PROVEEDORES.nombre 
            FROM 
                INTERVENCIONES_MATERIALES
            INNER JOIN SERIAL_NUMBERS
                ON INTERVENCIONES_MATERIALES.material_id = SERIAL_NUMBERS.id 
            INNER JOIN MATERIALES
                ON MATERIALES.id = SERIAL_NUMBERS.material_id 
            LEFT JOIN PROVEEDORES 
                ON PROVEEDORES.id = SERIAL_NUMBERS.proveedor_id 
            INNER JOIN INTERVENCIONES 
                ON INTERVENCIONES.id = INTERVENCIONES_MATERIALES.int_id  
            WHERE
                INTERVENCIONES_MATERIALES.int_id = ".$_GET['id']." 
            ORDER BY 
                INTERVENCIONES_MATERIALES.id ASC";

    //file_put_contents("array.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover table-condensed' id='tabla-int-materiales'>
                <thead>
                  <tr>
                    <th class='text-center'>UNID.</th>
                    <th class='text-center'>REF</th>
                    <th class='text-center'>MATERIAL</th>
                    <th class='text-center'>FABRICANTE</th>
                    <th class='text-center'>MODELO</th>
                    <th class='text-center'>S/N</th>
                    <th class='text-center'></th>
                  </tr>
                </thead>
                <tbody>";
    
    $total = 0;
    $totalDTO = 0;
    $totalPVP = 0;
    while( $row = mysqli_fetch_array($res) ) {
        $id = $row[0];
        $ref = $row[1];
        $nombre = $row[2];
        $modelo = $row[3];
        $fabricante = $row[4];
        $cantidad = $row[5];
        $sustituido = $row[6];
        $reparado = $row[7];
        $int_id = $row[8];
        $sn = $row[9];
        $proveedor = $row[10];
        
        
        $html .= "
                <tr data-id='".$id."' ".$trEnviado.">
                    <td class='text-center'>".$cantidad."</td>
                    <td class='text-center'>".$ref."</td>
                    <td class='text-left'>".$nombre."</td>
                    <td class='text-center'>".$fabricante."</td>
                    <td class='text-center'>".$modelo."</td>
                        <td class='text-center'>".$sn."</td>
                    <td class='text-center'><button class='btn-default remove-mat' data-id='".$row[0]."' title='Eliminar Material'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    echo $html;
} //if isset btn_login

?>

<div id="selectmaterial_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">SELECCIONAR MATERIAL</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_add_material">
                        <input type="hidden" value="" name="intmaterial_detalle_id" id="intmaterial_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="intmaterial_int_id" id="intmaterial_int_id">
                        <input type="hidden" value="" name="intmaterial_material_id" id="intmaterial_material_id">

                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Buscar:</label>
                                <input type="search" class="form-control" id="intmaterial_criterio" name="intmaterial_criterio" placeholder="Introduce un criterio para buscar">
                            </div>
                            <!--
                            <div class="col-xs-3">
                                <label class="labelBeforeBlack" style="color: #ffffff;">ooooooooooo</label>
                                <button type="button" id="btn_pedidodetalle_find" class="btn btn-primary">Buscar</button>
                            </div>
                            -->
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Materiales:</label>
                            <select id="intmaterial_materiales" name="intmaterial_materiales" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="labelBeforeBlack">Nombre:</label>
                            <input type="text" class="form-control" id="intmaterial_nombre" name="intmaterial_nombre" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Fabricante:</label>
                            <input type="text" class="form-control" id="intmaterial_fabricante" name="intmaterial_fabricante" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Modelo:</label>
                            <input type="text" class="form-control" id="intmaterial_modelo" name="intmaterial_modelo" disabled="true">
                        </div>                       
                        <div class="form-group">
                            <label class="labelBeforeBlack">REF:</label>
                            <input type="text" class="form-control" id="intmaterial_ref" name="intmaterial_ref" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Proveedor:</label>
                            <input type="text" class="form-control" id="intmaterial_proveedor" name="intmaterial_proveedor" disabled="true">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Cliente:</label>
                            <input type="text" class="form-control" id="intmaterial_cliente" name="intmaterial_cliente" disabled="true">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">S/N:</label>
                                <input type="text" class="form-control" id="intmaterial_sn" name="intmaterial_sn" disabled="true">
                            </div>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_intmaterial_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- /MATERIALES -->

