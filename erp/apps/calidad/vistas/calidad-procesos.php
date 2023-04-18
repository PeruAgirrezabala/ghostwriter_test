<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "SELECT 
                CALIDAD_PROCESOS.id,
                CALIDAD_PROCESOS.nombre,  
                CALIDAD_PROCESOS.responsable,
                CALIDAD_PROCESOS.year,
                CALIDAD_PROCESOS.dptos,
                CALIDAD_PROCESOS.doc_path
            FROM 
                CALIDAD_PROCESOS
            ORDER BY 
                CALIDAD_PROCESOS.ID ASC";

    file_put_contents("procesos.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-procesos'>
                <thead>
                    <tr class='bg-dark'>
                        <th class='text-center'>PROCESO</th>
                        <th class='text-center'>RESPONSABLE</th>
                        <th class='text-center'>DEPARTAMENTOS</th>
                        <!--
                        <th class='text-center'>I</th>
                        <th class='text-center'>V</th>
                        <th class='text-center'>S</th>
                        -->
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $idproceso = $row[0];
        $nombreProceso = $row[1];
        $respProceso = $row[2];
        //$yearProceso = $row[3];
        $dptos = $row[4];
        $doc_path = $row[5];
        
        $html .= "
                <tr data-id='".$idproceso."'>
                    <td class='text-left'>".$nombreProceso."</td>
                    <td class='text-center'>".$respProceso."</td>
                    <td class='text-center'>".$dptos."</td>
                    <!--    
                    <td class='text-center'><button class='btn btn-circle btn-default indicadores-proceso' data-id='".$idproceso."' title='Ver Indicadores'><img src='/erp/img/informacion.png' style='height: 18px;'></button></td>
                    <td class='text-center'><a href='".$doc_path."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'><button class='btn-default upload-doc-Proceso' data-id='".$idproceso."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 15px;'></button></td>
                    -->
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-proceso' data-id='".$idproceso."' title='Eliminar Proceso'><img src='/erp/img/cross.png'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    $html .='<div id="delete_proceso_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR PROCESO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                        <input type="hidden" value="" name="del_proceso_id" id="del_proceso_id">
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas eliminar el proceso?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_proceso" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>';
    echo $html;

?>