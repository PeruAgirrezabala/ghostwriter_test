<script>
            $(".upload-doc-Formacion").click(function() {
                $("#adddocFormacion").val($(this).data("id"));
                console.log($(this).data("id"));
                $("#adddocFormacion_adddoc_model").modal('show');
            });
</script>
<?
    
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    
    $anyo=$_GET['year'];
    $nombre=$_GET['nombre'];
    $usuario=$_GET['user'];
    $anyousuario=$_GET['yearuser'];
    $condicion=0;
    $ands="";
    if($anyo == ""){
        $anyo="";
    }else{
        $condicion=1;
        $anyo="WHERE CALIDAD_FORMACION.fecha LIKE '".$_GET['year']."%'";
    }
    
    if($nombre == ""){
        $nombre="";
    }else{
        if($condicion==1){
            $nombre="AND CALIDAD_FORMACION.id = ".$_GET['nombre'];
        }else{
            $condicion=1;
            $nombre="WHERE CALIDAD_FORMACION.id = ".$_GET['nombre'];
        }
    }
    if($usuario == ""){
        $usuario="";
    }else{
        if($condicion==1){
            $usuario="AND CALIDAD_FORMACION_DETALLES.tecnico_id = ".$_GET['user'];
        }else{
            $condicion=1;
            $usuario="WHERE CALIDAD_FORMACION_DETALLES.tecnico_id = ".$_GET['user'];
        }
    }
    if($anyousuario == ""){
        $anyousuario="";
    }else{
        if($condicion==1){
            $anyousuario="AND CALIDAD_FORMACION_DETALLES.fecha LIKE '".$_GET['yearuser']."%'";
        }else{
            $condicion=1;
            $anyousuario="WHERE CALIDAD_FORMACION_DETALLES.fecha LIKE '".$_GET['yearuser']."%'";
        }
    }
    
    //$anyo="AND CALIDAD_NOCONFORMIDADES.fecha LIKE '".$_GET['year']."%'";
    $ands=$anyo." ".$nombre. " ".$usuario." ".$anyousuario;
    
    $sql = "SELECT DISTINCT
                CALIDAD_FORMACION.id,
                CALIDAD_FORMACION.nombre,
                CALIDAD_FORMACION.descripcion,
                CALIDAD_FORMACION.doc_path,
                CALIDAD_FORMACION.fecha
            FROM 
                CALIDAD_FORMACION 
            INNER JOIN
                CALIDAD_FORMACION_DETALLES ON CALIDAD_FORMACION.id=CALIDAD_FORMACION_DETALLES.formacion_id
            ".$ands;

    file_put_contents("calidadFormacion.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("Error en calidad formacion. SELECT");
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-formacion'>
                <thead>
                    <tr class='bg-dark'>
                        <th class='text-center'>P</th>
                        <th class='text-center'>NOMBRE</th>
                        <th class='text-center'>DESCRIPCIÓN</th>
                        <th class='text-center'>FECHA</th>
                        <th class='text-center'>V</th>
                        <th class='text-center'>S</th>
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $idCalidadFormacion = $row[0];
        $nombreCalidadFormacion = $row[1];
        $descripcionCalidadFormacion = $row[2];
        $pathdocCalidadFormacion = $row[3];
        $fechaCalidadFormacion = $row[4];
        
        //$file_Acta = "<a href='file:////192.168.3.108/".$pathdocCalidadActas."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a>";

        $html .= "
                <tr data-id='".$idCalidadFormacion."' id='doc-formacion-".$docPER_id."'>
                    <td class='text-center'><button class='btn btn-circle btn-default' title='Administrar Usuarios'><img src='/erp/img/user.png' style='height: 15px;' title='Administrar Usuarios'></button></td>
                    <td class='text-left'>".$nombreCalidadFormacion."</td>
                    <td class='text-center'>".$descripcionCalidadFormacion."</td>
                    <td class='text-center'>".$fechaCalidadFormacion."</td>
                    <td class='text-center'><a href='file:////192.168.3.108/".$pathdocCalidadFormacion."' target='_blank'><button class='btn btn-circle btn-default' title='Ver Documento'><img src='/erp/img/lupa.png'></button></a></td>
                    <td class='text-center'><button class='btn-default upload-doc-Formacion' data-id='".$idCalidadFormacion."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 15px;'></button></td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-formacion' data-id='".$idCalidadFormacion."' title='Eliminar Formacion'><img src='/erp/img/cross.png'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    $html .='<div id="delete_formacion_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                        <input type="hidden" value="" name="del_formacion_id" id="del_formacion_id">
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas eliminar la formación?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_formacion" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>';

            
    echo $html;

?>