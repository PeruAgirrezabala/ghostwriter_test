<script>
            $(".upload-doc-Calibraciones").click(function() {
                $("#adddocCalibraciones").val($(this).data("id"));
                console.log($(this).data("id"));
                $("#adddocCalibraciones_adddoc_model").modal('show');
            });
</script>
<?
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
//    $anyo=$_GET['year'];
//    $month=$_GET['month'];
//    
//    if($anyo == ""){
//        $anyo="";
//    }else{
//        $anyo="WHERE CALIDAD_ACTAS.fecha LIKE '".$_GET['year']."%'";
//    }
//    
//    if($month == ""){
//        $mes="";
//    }else{
//        if($anyo == ""){
//            $mes="WHERE CALIDAD_ACTAS.fecha LIKE '%-".$_GET['month']."-%'";
//        }else{
//            $mes="AND CALIDAD_ACTAS.fecha LIKE '%-".$_GET['month']."-%'";
//        }
//    }
//    $ands=$anyo." ".$mes;
    
    $sql = "SELECT 
                CALIDAD_CALIBRACIONES.id,
                CALIDAD_CALIBRACIONES.equipo,
                CALIDAD_CALIBRACIONES.num_serie,
                CALIDAD_CALIBRACIONES.tecnico_id,
                CALIDAD_CALIBRACIONES.labor,
                CALIDAD_CALIBRACIONES.periodo,
                CALIDAD_CALIBRACIONES.proced,
                CALIDAD_CALIBRACIONES.ult_cali,
                CALIDAD_CALIBRACIONES.next_cali,
                CALIDAD_CALIBRACIONES.activo,
                CALIDAD_CALIBRACIONES.doc_path,
                erp_users.nombre,
		erp_users.apellidos
            FROM 
                CALIDAD_CALIBRACIONES, erp_users
            WHERE
                CALIDAD_CALIBRACIONES.tecnico_id=erp_users.id
            AND
                CALIDAD_CALIBRACIONES.activo=1";

    file_put_contents("CalidadCalibraciones.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error en calidad calibraciones. SELECT");
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-calibraciones'>
                <thead>
                    <tr class='bg-dark'>
                        <th class='text-center'>EQUIPO</th>
                        <th class='text-center'>NºSERIE</th>
                        <th class='text-center'>TÉCNICO</th>
                        <th class='text-center'>LABOR.CALIBR.</th>
                        <th class='text-center'>PERIODO CALIBR.</th>
                        <th class='text-center'>PROCED. CALIBRACIÓN</th>
                        <th class='text-center'>FECHA ULTIMA CALIBRACIÓN</th>
                        <th class='text-center'>FECHA PRÓXIMA CALIBRACIÓN</th>
                        <th class='text-center'>V</th>
                        <th class='text-center'>S</th>
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $idCalidadCalibraciones = $row[0];
        $equipoCalidadCalibraciones = $row[1];
        $numserieCalidadCalibraciones = $row[2];
        $tecidCalidadCalibraciones = $row[3];
        $laborCalidadCalibraciones = $row[4];
        $periodoCalidadCalibraciones = $row[5];
        $procedCalidadCalibraciones = $row[6];
        $ultcaliCalidadCalibraciones = $row[7];
        $nextcaliCalidadCalibraciones = $row[8];
        $activoCalidadCalibraciones = $row[9];
        $docpathCalidadCalibraciones = $row[10];
        $nombretecCalidadCalibraciones = $row[11];
        $apellidotecCalidadCalibraciones = $row[12];
        
        $file_Acta = "<a href='file:////192.168.3.108/".$docpathCalidadCalibraciones."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a>";

        $html .= "
                <tr data-id='".$idCalidadCalibraciones."' id='doc-acta-".$docPER_id."'>
                    <td class='text-left'>".$equipoCalidadCalibraciones."</td>
                    <td class='text-center'>".$numserieCalidadCalibraciones."</td>
                    <td class='text-center'>".$nombretecCalidadCalibraciones." ".$apellidotecCalidadCalibraciones."</td>
                    <td class='text-center'>".$laborCalidadCalibraciones."</td>
                    <td class='text-center'>".$periodoCalidadCalibraciones."</td>
                    <td class='text-center'>".$procedCalidadCalibraciones."</td>
                    <td class='text-center'>".$ultcaliCalidadCalibraciones."</td>
                    <td class='text-center'>".$nextcaliCalidadCalibraciones."</td>
                    <td class='text-center'><a href='file:////192.168.3.108/".$docpathCalidadCalibraciones."' target='_blank'><button class='btn btn-circle btn-default' title='Ver Actas'><img src='/erp/img/lupa.png'></button></a></td>
                    <td class='text-center'><button class='btn-default upload-doc-Calibraciones' data-id='".$idCalidadCalibraciones."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 15px;'></button></td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-calibraciones' data-id='".$idCalidadCalibraciones."' title='Eliminar Calibración'><img src='/erp/img/cross.png'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    $html .='<div id="delete_calibraciones_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR CALIBRACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                        <input type="hidden" value="" name="del_calibraciones_id" id="del_calibraciones_id">
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas eliminar la Calibración?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_calibracion" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>';
    
    echo $html;
    
    

?>