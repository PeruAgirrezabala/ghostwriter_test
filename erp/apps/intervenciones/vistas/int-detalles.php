<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['id'])) {    
    $sql = "SELECT 
                INTERVENCIONES_DETALLES.id as detid,
                INTERVENCIONES_DETALLES.titulo,  
                INTERVENCIONES_DETALLES.descripcion,
                INTERVENCIONES_DETALLES.fecha,
                INTERVENCIONES_DETALLES.fecha_mod,
                (SELECT SUM(INTERVENCIONES_DETALLES_TECNICOS.H820) FROM INTERVENCIONES_DETALLES_TECNICOS WHERE intdetalle_id = detid GROUP BY intdetalle_id),
                (SELECT SUM(INTERVENCIONES_DETALLES_TECNICOS.H208) FROM INTERVENCIONES_DETALLES_TECNICOS WHERE intdetalle_id = detid GROUP BY intdetalle_id),
                (SELECT SUM(INTERVENCIONES_DETALLES_TECNICOS.Hviaje) FROM INTERVENCIONES_DETALLES_TECNICOS WHERE intdetalle_id = detid GROUP BY intdetalle_id),
                erp_users.nombre,
                erp_users.apellidos
            FROM 
                INTERVENCIONES_DETALLES, erp_users
            WHERE
                INTERVENCIONES_DETALLES.erpuser_id = erp_users.id
            AND
                INTERVENCIONES_DETALLES.int_id = ".$_GET["id"]." 
            ORDER BY 
                INTERVENCIONES_DETALLES.id ASC";

    //file_put_contents("queryIntDetalles.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error seleccionando los detalles de la Intervención");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-detalles-int'>
                <thead>
                  <tr>
                    <th>TÍTULO</th>
                    <th class='text-center'>FECHA</th>
                    <th class='text-center'>H. 8-20</th>
                    <th class='text-center'>H. 20-8 </th>
                    <th class='text-center'>H. VIAJE</th>
                    <th>TÉCNICO</th>
                    <th class='text-center'>E</th>
                  </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $html .= "
                <tr data-id='".$row[0]."'>
                    <td>".$row[1]."</td>
                    <td class='text-center'>".$row[3]."</td>
                    <td class='text-center'>".$row[5]."</td>
                    <td class='text-center'>".$row[6]."</td>
                    <td class='text-center'>".$row[7]."</td>
                    <td>".$row[8]." ".$row[9]."</td>
                    <td class='text-center'><button class='btn-default remove-detalle' data-id='".$row[0]."' title='Eliminar detalle'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    echo $html;
} //if isset btn_login

?>

<div id="detalleint_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">DETALLE DE INTERVENCIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_intdetalle" enctype="multipart/form-data">
                        <input type="hidden" value="" name="intdetalle_detalle_id" id="intdetalle_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="intdetalle_int_id" id="intdetalle_int_id">
                        <input type="hidden" value="" name="intdetalle_horas" id="intdetalle_horas">

                        <div class="form-group">
                            <label class="labelBeforeBlack">TÍTULO:</label>
                            <input type="text" class="form-control" id="intdetalle_nombre" name="intdetalle_nombre">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">DESCRIPCIÓN:</label>
                            <textarea class="textarea-cp form-control" id="intdetalle_desc" name="intdetalle_desc" placeholder="Descripción de la Intervención" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBeforeBlack">FECHA:</label>
                                <input type="date" class="form-control" id="intdetalle_fecha" name="intdetalle_fecha">
                            </div>
                        </div>
                        <div id="cuadro-horas" style="display: none;">
                            <div class="form-group">
                                <div class="col-xs-2">
                                    <label class="labelBeforeBlack">HORAS 8-20:</label>
                                    <input type="text" class="form-control" id="intdetalle_H820" name="intdetalle_H820" value="0">
                                </div>
                                <div class="col-xs-2">
                                    <label class="labelBeforeBlack">COSTE:</label>
                                    <input type="text" class="form-control" id="intdetalle_costeH820" name="intdetalle_costeH820" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-2">
                                    <label class="labelBeforeBlack">HORAS 20-8:</label>
                                    <input type="text" class="form-control" id="intdetalle_H208" name="intdetalle_H208" value="0">
                                </div>
                                <div class="col-xs-2">
                                    <label class="labelBeforeBlack">COSTE:</label>
                                    <input type="text" class="form-control" id="intdetalle_costeH208" name="intdetalle_costeH208" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-2">
                                    <label class="labelBeforeBlack">HORAS VIAJE:</label>
                                    <input type="text" class="form-control" id="intdetalle_Hviaje" name="intdetalle_Hviaje" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <button type="button" id="btn_intdetalle_saveHoras" class="btn btn-info2">Guardar Horas</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="intdetalle_tecnicos" class="labelBefore">TÉCNICO: </label>
                                <select id="intdetalle_tecnicos" name="intdetalle_tecnicos" class="selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_intdetalle_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- DETALLE -->