    
    <?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql = "SELECT 
                CALIDAD_FORMACION.id,
                CALIDAD_FORMACION.nombre,
                CALIDAD_FORMACION.descripcion,
                CALIDAD_FORMACION.doc_path,
                CALIDAD_FORMACION_DETALLES.id,
                CALIDAD_FORMACION_DETALLES.tecnico_id,
                CALIDAD_FORMACION_DETALLES.descripcion,
                CALIDAD_FORMACION_DETALLES.fecha,
                erp_users.id,
                erp_users.nombre,
                erp_users.apellidos
            FROM 
                CALIDAD_FORMACION, CALIDAD_FORMACION_DETALLES, erp_users
            WHERE 
                CALIDAD_FORMACION_DETALLES.formacion_id = CALIDAD_FORMACION.id
            AND 
                CALIDAD_FORMACION_DETALLES.formacion_id =".$_POST['formacion_id']."
            AND
                CALIDAD_FORMACION_DETALLES.tecnico_id=erp_users.id
            ORDER BY
                erp_users.id ASC";
            file_put_contents("selectCalidadFormacionDetalles.txt", $sql);                                                    
            $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Calidad Formacion Detalles");
            $contador=0;
                    
            $sqlUsrs = "SELECT 
                        erp_users.id,
                        erp_users.nombre,
                        erp_users.apellidos
                    FROM 
                        erp_users
                    WHERE
                        erp_users.empresa_id=1
                    ORDER BY
                        erp_users.id ASC";
            file_put_contents("selectTodosUsuarios.txt", $sqlUsrs);                                                    
            $resultadoUsrs = mysqli_query($connString, $sqlUsrs) or die("Error al ejecutar la consulta de Select todos los usuarios");
            $numRows=mysqli_num_rows($resultado);
            
            $sqlFormacion = "SELECT 
                                CALIDAD_FORMACION.id,
                                CALIDAD_FORMACION.nombre,
                                CALIDAD_FORMACION.descripcion,
                                CALIDAD_FORMACION.doc_path,
                                CALIDAD_FORMACION.fecha
                            FROM 
                                CALIDAD_FORMACION
                            WHERE 
                                CALIDAD_FORMACION.id =".$_POST['formacion_id'];
            file_put_contents("selectCALIDADFORMACION.txt", $sqlFormacion);                                                    
            $resultadoFromacion = mysqli_query($connString, $sqlFormacion) or die("Error al ejecutar la consulta de Select CALIDAD FORMACION especifico");
            $regist = mysqli_fetch_array($resultadoFromacion);
                   
            echo '<div id="formacionDetalles_add_model" class="modal fade">
                  <div class="modal-dialog dialog_estrecho">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" style="display: inline-block;">FORMACIÓN DETALLES</h4><!--
                            <button class="button" id="add-formacion-persona" title="Añadir Persona"><img src="/erp/img/add.png" height="20"></button>
                            <button class="button" id="add-formacion-todos" title="Añadir todos a Formacion"><img src="/erp/img/add2.png" height="20"></button>-->
                            <div>
                                <h5 class="modal-title" style="display: inline-block;">'.$regist[1].'</h5>
                            </div>
                        </div>
                        <div class="modal-body" id="container-calidad-formacion-detalles">
                            <form method="post" id="frm_add_formaciones_tecnicos" enctype="multipart/form-data">
                            <input type="hidden" value='.$_POST["formacion_id"].' name="formacion_id" id="formacion_id">
                            <table class="table table-striped table-hover" id="tabla-formacion-detalles">
                                <thead>
                                    <tr class="bg-dark">
                                        <th class="text-center">S</th>
                                        <th class="text-center">NOMBRE</th>
                                        <th class="text-center">FECHA</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    
                    if($numRows==0){
                        
                        while ($registros = mysqli_fetch_array($resultadoUsrs)) { 
                            $contador++;
                            $idTecnico = $registros[0];
                            $nombreTecnico = $registros[1];
                            $apellidosTecnico = $registros[2];
                            echo "<tr data-id=".$_POST['formacion_id'].">
                                 <td class='text-center'>
                                    <input type='checkbox' class='pos-to-formacion-detalles' data-matid='".$_POST['formacion_id']."' value='".$_POST['formacion_id']."' name='posiciones[".$contador."][pos-to-formacion-detalles]'>
                                    <input type='hidden' name='posiciones[".$contador."][pos_formacion_id]' value='".$_POST['formacion_id']."'>
                                    <input type='hidden' name='posiciones[".$contador."][pos_tecnico_id]' value='".$idTecnico."'>
                                    <input type='hidden' name='posiciones[".$contador."][pos_fecha]' value='".$regist[4]."'>
                                </td>
                                    <td class='text-center'>".$nombreTecnico." ".$apellidosTecnico."</td>
                                    <td class='text-center'>".$regist[4]."</td>
                                </tr>";
                        }
                    }else{
                        while ($registros2 = mysqli_fetch_array($resultado)) {
                            $counter++;
                            while ($registros = mysqli_fetch_array($resultadoUsrs)) { 
                                $contador++;
                                $idCalidadFormacion = $registros2[0];
                                $nombreCalidadFormacion = $registros2[1];
                                $descripcionCalidadFormacion = $registros2[2];
                                $docpathCalidadFormacion = $registros2[3];
                                $idCalidadFormacionDetalles = $registros2[4];
                                $idtecnicoCalidadFormacionDetalles = $registros2[5];
                                $descripcionCalidadFormacionDetalles = $registros2[6];
                                $fechaCalidadFormacionDetalles = $registros2[7];
                                $idTecnico2 = $registros2[8];
                                $nombreTecnico2 = $registros2[9];
                                $apellidosTecnico2 = $registros2[10];

                                $idTecnico = $registros[0];
                                $nombreTecnico = $registros[1];
                                $apellidosTecnico = $registros[2];
                                if($idTecnico==$idTecnico2){
                                    echo "<tr data-id=".$_POST['formacion_id'].">
                                        <td class='text-center'>
                                            <input type='checkbox' class='pos-to-formacion-detalles' data-matid='".$_POST['formacion_id']."' value='".$_POST['formacion_id']."' name='posiciones[".$contador."][pos-to-formacion-detalles]' checked='checked'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_formacion_id]' value='".$_POST['formacion_id']."'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_tecnico_id]' value='".$idTecnico."'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_fecha]' value='".$fechaCalidadFormacionDetalles."'>
                                        </td>
                                        <td class='text-center'>".$nombreTecnico." ".$apellidosTecnico."</td>
                                        <td class='text-center' data-id='1' style='cursor:pointer' title='Cambiar Fecha' >".$fechaCalidadFormacionDetalles."</td>
                                    </tr>";
                                    break 1;
                                }else{
                                    echo "<tr data-id=".$_POST['formacion_id'].">
                                        <td class='text-center'>
                                            <input type='checkbox' class='pos-to-formacion-detalles' data-matid='".$_POST['formacion_id']."' value='".$_POST['formacion_id']."' name='posiciones[".$contador."][pos-to-formacion-detalles]'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_formacion_id]' value='".$_POST['formacion_id']."'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_tecnico_id]' value='".$idTecnico."'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_fecha]' value=''>
                                        </td>
                                        <td class='text-center'>".$nombreTecnico." ".$apellidosTecnico."</td>
                                        <td class='text-center' data-id='0' style='cursor:pointer' title='Para cambiar fecha primero añadir el usuario.' ></td>
                                    </tr>";  
                                }
                            }
                            if($numRows==$counter){
                                $sqlRestantes = "SELECT erp_users.id, erp_users.nombre, erp_users.apellidos
                                                FROM erp_users
                                                WHERE erp_users.empresa_id =1
                                                AND erp_users.id >".$registros2[8]."
                                                ORDER BY erp_users.id ASC";
                                file_put_contents("selectCALIDADFORMACION.txt", $sqlRestantes);                                                    
                                $resultadoRestantes = mysqli_query($connString, $sqlRestantes) or die("Error al ejecutar la consulta de Select CALIDAD FORMACION especifico");
                                while ($registros = mysqli_fetch_array($resultadoRestantes)) { 
                                    $contador++;
                                    $idTecnico = $registros[0];
                                    $nombreTecnico = $registros[1];
                                    $apellidosTecnico = $registros[2];
                                    echo "<tr data-id=".$_POST['formacion_id'].">
                                         <td class='text-center'>
                                            <input type='checkbox' class='pos-to-formacion-detalles' data-matid='".$_POST['formacion_id']."' value='".$_POST['formacion_id']."' name='posiciones[".$contador."][pos-to-formacion-detalles]'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_formacion_id]' value='".$_POST['formacion_id']."'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_tecnico_id]' value='".$idTecnico."'>
                                            <input type='hidden' name='posiciones[".$contador."][pos_fecha]' value='".$registros2[7]."'>
                                        </td>
                                            <td class='text-center'>".$nombreTecnico." ".$apellidosTecnico."</td>
                                            <td class='text-center'></td>
                                        </tr>";
                                }    
                            }
                        }
                    }
                    
                    
                    //file_put_contents("contadorDetalles.txt", $contador." ".$contador2);
                    echo " </tbody></table></form></div>
            <div class='modal-footer'>
                <button type='button' id='btn_formacionTecnico_save' class='btn btn-info'>Guardar</button>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
            </div>
                </div>
            </div>
        </div>";     
    ?>                    