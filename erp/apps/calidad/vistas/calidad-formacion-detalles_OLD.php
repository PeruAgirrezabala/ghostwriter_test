    
    <?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    echo '<div id="formacionDetalles_add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">FORMACIÓN DETALLES</h4>
                <button class="button" id="add-formacion-persona" title="Añadir Persona"><img src="/erp/img/add.png" height="20"></button>
                <button class="button" id="add-formacion-todos" title="Añadir todos a Formacion"><img src="/erp/img/add2.png" height="20"></button>
            </div>
            <div class="modal-body" id="container-calidad-formacion-detalles">
            <form method="post" id="frm_add_formaciones_tecnicos" enctype="multipart/form-data">
            <input type="hidden" value='.$_POST["formacion_id"].' name="formacion_id" id="formacion_id">
            <table class="table table-striped table-hover" id="tabla-formacion-detalles">
            <thead>
                <tr class="bg-dark">
                    <th class="text-center">S</th>
                    <th class="text-center">FORMACIÓN</th>
                    <th class="text-center">NOMBRE</th>
                    <th class="text-center">DESC</th>
                    <th class="text-center">FECHA</th>
                    <th class="text-center">V</th>
                    <th class="text-center">E</th>
                </tr>
            </thead>
            <tbody>';

            $sql = "SELECT 
                        CALIDAD_FORMACION.id,
                        CALIDAD_FORMACION.nombre,
                        CALIDAD_FORMACION.descripcion,
                        CALIDAD_FORMACION.doc_path,
                        CALIDAD_FORMACION_DETALLES.id,
                        CALIDAD_FORMACION_DETALLES.tecnico_id,
                        CALIDAD_FORMACION_DETALLES.descripcion,
                        CALIDAD_FORMACION_DETALLES.fecha,
                        erp_users.nombre,
                        erp_users.apellidos,
                        erp_users.id
                    FROM 
                        CALIDAD_FORMACION, CALIDAD_FORMACION_DETALLES, erp_users
                    WHERE 
                        CALIDAD_FORMACION_DETALLES.formacion_id = CALIDAD_FORMACION.id
                    AND 
                        CALIDAD_FORMACION_DETALLES.formacion_id =".$_POST['formacion_id']."
                    AND
                        CALIDAD_FORMACION_DETALLES.tecnico_id=erp_users.id";
                    file_put_contents("selectCalidadFormacionDetalles.txt", $sql);                                                    
                    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Calidad Formacion Detalles");
                    $contador=0;
                    while ($registros = mysqli_fetch_array($resultado)) {
                        $idCalidadFormacion = $registros[0];
                        $nombreCalidadFormacion = $registros[1];
                        $descripcionCalidadFormacion = $registros[2];
                        $docpathCalidadFormacion = $registros[3];
                        $idCalidadFormacionDetalles = $registros[4];
                        $idtecnicoCalidadFormacionDetalles = $registros[5];
                        $descripcionCalidadFormacionDetalles = $registros[6];
                        $fechaCalidadFormacionDetalles = $registros[7];
                        $nombreTecnico = $registros[8];
                        $apellidosTecnico = $registros[9];
                        $idTecnico = $registros[10];

                        if($doc_path=="" or $doc_path==null){
                            $farolillo="<span class='dot-grey''></span>";
                        }else{
                            $farolillo="<span class='dot-green''></span>";
                        }
                        $contador++;
                        echo "<tr data-id=".$idCalidadFormacion.">
                                <td class='text-center'>
                                    <input type='checkbox' class='pos-to-formacion-detalles' data-matid='".$idCalidadFormacion."' value='".$idCalidadFormacion."' name='posiciones[".$contador."][pos-to-formacion-detalles]'>
                                    <input type='hidden' name='posiciones[".$contador."][pos_formacion_id]' value='".$idCalidadFormacion."'>
                                    <input type='hidden' name='posiciones[".$contador."][pos_tecnico_id]' value='".$idTecnico."'>
                                    <input type='hidden' name='posiciones[".$contador."][pos_descripcion]' value='".$descripcionCalidadFormacionDetalles."'>
                                    <input type='hidden' name='posiciones[".$contador."][pos_fecha]' value='".$fechaCalidadFormacionDetalles."'>
                                </td>
                                <td class='text-center'>".$nombreCalidadFormacion."</td>
                                <td class='text-center'>".$nombreTecnico." ".$apellidosTecnico."</td>
                                <td class='text-center'>".$descripcionCalidadFormacionDetalles."</td>
                                <td class='text-center'>".$fechaCalidadFormacionDetalles."</td>
                                <td class='text-center'><a href='$docpathCalidadFormacion' target='_blank'><button class='btn btn-circle btn-default' title='Ver Documento'><img src='/erp/img/lupa.png'></button></a></td>
                                <td class='text-center'><button class='btn btn-circle btn-danger remove-formacion-tecnico' data-id='".$idCalidadFormacionDetalles."' title='Eliminar Formacion'><img src='/erp/img/cross.png'></button></td>
                            </tr>";

                    }

                    echo " </tbody></table></form></div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
                <button type='button' id='btn_formacionTecnico_save' class='btn btn-primary'>Guardar</button>
            </div>
                </div>
            </div>
        </div>";     
    ?>                    