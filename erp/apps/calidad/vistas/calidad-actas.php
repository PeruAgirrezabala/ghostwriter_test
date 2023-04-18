<script>
            $(".upload-doc-Acta").click(function() {
                $("#adddocActa").val($(this).data("id"));
                console.log($(this).data("id"));
                $("#adddocActa_adddoc_model").modal('show');
            });
</script>
<?
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $anyo=$_GET['year'];
    $month=$_GET['month'];
    
    if($anyo == ""){
        $anyo="";
    }else{
        $anyo="WHERE CALIDAD_ACTAS.fecha LIKE '".$_GET['year']."%'";
    }
    
    if($month == ""){
        $mes="";
    }else{
        if($anyo == ""){
            $mes="WHERE CALIDAD_ACTAS.fecha LIKE '%-".$_GET['month']."-%'";
        }else{
            $mes="AND CALIDAD_ACTAS.fecha LIKE '%-".$_GET['month']."-%'";
        }
    }
    $ands=$anyo." ".$mes;
    
    $sql = "SELECT 
                CALIDAD_ACTAS.id,
                CALIDAD_ACTAS.nombre,
                CALIDAD_ACTAS.descripcion,
                CALIDAD_ACTAS.path_doc,
                CALIDAD_ACTAS.fecha
            FROM 
                CALIDAD_ACTAS ".$ands."
            ORDER BY 
                CALIDAD_ACTAS.fecha DESC";

    file_put_contents("CalidadActas.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error en calidad actas. SELECT");
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-actas'>
                <thead>
                    <tr class='bg-dark'>
                        <th class='text-center'>FECHA</th>
                        <th class='text-center'>NOMBRE</th>
                        <th class='text-center'>DESCRIPCIÓN</th>
                        <th class='text-center'>V</th>
                        <th class='text-center'>S</th>
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $idCalidadActas = $row[0];
        $nombreCalidadActas = $row[1];
        $descripcionCalidadActas = $row[2];
        $pathdocCalidadActas = $row[3];
        $fechaCalidadActas = $row[4];
        
        $file_Acta = "<a href='file:////192.168.3.108/".$pathdocCalidadActas."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a>";

        $html .= "
                <tr data-id='".$idCalidadActas."' id='doc-acta-".$docPER_id."'>
                    <td class='text-center'>".$fechaCalidadActas."</td>
                    <td class='text-left'>".$nombreCalidadActas."</td>
                    <td class='text-center'>".$descripcionCalidadActas."</td>
                    <td class='text-center'><a href='file:////192.168.3.108/".$pathdocCalidadActas."' target='_blank'><button class='btn btn-circle btn-default' title='Ver Actas'><img src='/erp/img/lupa.png'></button></a></td>
                    <td class='text-center'><button class='btn-default upload-doc-Acta' data-id='".$idCalidadActas."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 15px;'></button></td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-acta' data-id='".$idCalidadActas."' title='Eliminar Acta'><img src='/erp/img/cross.png'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    $html .='<div id="delete_acta_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR ACTA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                        <input type="hidden" value="" name="del_acta_id" id="del_acta_id">
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas eliminar el acta?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_acta" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>';
    
    echo $html;

?>