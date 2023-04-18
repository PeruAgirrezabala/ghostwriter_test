<!-- DOC Admon -->
<? 
    // empresaid==1; // Genelek
    if ($_GET['tecnicoid'] != "") {
        $criteriaPER = " AND USERS_DOC.erpuser_id = ".$_GET['tecnicoid']." ";
        $empresa_id = $_GET['empresaid'];
    }
    else {
        $criteriaPER = "";
        $empresa_id = $_GET['empresaid'];
    }
    if ($_GET['criterio'] != "") {
        $criteriaPER .= " AND USERS_DOC.nombre like '%".$_GET['criterio']."%' ";
        $empresa_id = $_GET['empresaid'];
    }
?>
<table class="table table-striped table-hover" id='tabla-doc-PER'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">E</th>
            <th class="text-center">TRABAJADOR</th>
            <th class="text-center">NOMBRE</th>
            <th class="text-center">ORG</th>
            <th class="text-center">EXPEDIDO</th>
            <th class="text-center">P</th>
            <th class="text-center">V</th>
            <th class="text-center">S</th>
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
                    USERS_DOC.id as file, 
                    USERS_DOC.nombre, 
                    ORGANISMOS.nombre, 
                    (SELECT doc_path FROM USERS_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as path,
                    (SELECT fecha_exp FROM USERS_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_exp,
                    (SELECT fecha_cad FROM USERS_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                    (SELECT id FROM USERS_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id, 
                    erp_users.nombre,
                    erp_users.apellidos, 
                    PERIODICIDADES.intervalo, 
                    erp_users.id,
                    PERIODICIDADES.nombre
                FROM 
                    USERS_DOC 
                INNER JOIN erp_users
                    ON erp_users.id = USERS_DOC.erpuser_id 
                INNER JOIN ORGANISMOS
                    ON ORGANISMOS.id = USERS_DOC.org_id 
                INNER JOIN PERIODICIDADES
                    ON PERIODICIDADES.id = USERS_DOC.periodicidad_id 
                WHERE
                    erp_users.empresa_id = 1
                    AND erp_users.activo = 'on'
                ".$criteriaPER."
                ORDER BY 
                    ORGANISMOS.nombre ASC, 
                    USERS_DOC.nombre ASC,
                    erp_users.nombre ASC";
        file_put_contents("selectPER.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Doc PER");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $docPER_id = $registros[0];
            $nombrePER = $registros[1];
            $orgPER = $registros[2];
            $docpath_PER = $registros[3];
            $fecha_exp_PER = $registros[4];
            $fecha_cad_PER = $registros[5];
            $docverPER_id = $registros[6];
            $trabajadorPER = $registros[7]." ".$registros[8];
            $intervaloPER = $registros[9];
            $trabajadoridPER = $registros[10];
            $intervaloPERnombre = substr($registros[11], 0, 1);
                    
            $fechaSUM = date('Y-m-d', strtotime($fecha_exp_PER. ' + '.$intervaloPER.' days'));
            $todaySUM7 = date('Y-m-d', strtotime(date("Y-m-d"). ' + 7 days'));
            
            if ($intervaloPER == 0) {
                if ($fecha_exp_PER != "") {
                    $estado_PER = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                }
                else {
                    $estado_PER = "<span class='dot-grey' title='No hay ningún fichero subido para este documento'></span>";
                }
            }
            else {
                if ($fecha_exp_PER != "") {
                    if (date('Y-m-d') > $fechaSUM) {
                        $estado_PER = "<span class='dot-red' title='Expirado el día ".$fechaSUM."'></span>";
                    }
                    else {
                        if ($todaySUM7 >= $fechaSUM) {
                            $fecha2 = new DateTime($fechaSUM);
                            $fecha1 = new DateTime(date('Y-m-d'));
                            $diasexp = $fecha1->diff($fecha2);
                            $estado_PER = "<span class='dot-yellow' title='Expira en los próximos ".$diasexp->format('%R%a')." días'></span>";
                        }
                        else {
                            $estado_PER = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                        }
                    }
                }
                else {
                    $estado_PER = "<span class='dot-grey' title='No hay ningún fichero subido para este documento'></span>";
                } 
            }
            
            $sqlVersiones="SELECT
                        USERS_DOC_VERSIONES.id,
                        USERS_DOC_VERSIONES.doc_path
                        FROM USERS_DOC_VERSIONES WHERE USERS_DOC_VERSIONES.doc_id =".$docPER_id;
            file_put_contents("selectPER2.txt", $sqlVersiones);
            $resVersiones = mysqli_query($connString, $sqlVersiones) or die("Error al ejcutar la consulta de Doc PER");
            $row_cnt = mysqli_num_rows($resVersiones);
            
            if($row_cnt>1){
                $file_PER = "<button type='button' class='btn-link ver-docs-personal' data-id='".$docPER_id."' data-userid='".$trabajadoridPER."' title='Ver Documentos'><img src='/erp/img/lupa.png' style='height: 10px;'></button>";
            }else{ // Si es solo uno 
                $file_PER = "<a href='file:////192.168.3.108/".$docpath_PER."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a>";
            }
            
            echo "
                <tr data-id='".$docPER_id."' data-tipo='per' class='oferta' draggable='true' ondragstart='drag(event)' id='doc-per-".$docPER_id."'>
                    <td class='text-center'>".$estado_PER."</td>
                    <td class='text-left'>".$trabajadorPER."</td>
                    <td class='text-left'>".$nombrePER."</td>
                    <td class='text-left'>".$orgPER."</td>
                    <td class='text-center'>".$fecha_exp_PER."</td>
                    <td class='text-center' title='".$registros[11]."'>".$intervaloPERnombre."</td>
                    <td class='text-center'>".$file_PER."</td>
                    <td class='text-center'><button class='btn-default upload-doc-PER' data-id='".$docPER_id."' data-userid='".$trabajadoridPER."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 15px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- DOC Admon -->

<!-- -->
<div id="multiDocPersonal_modal" class="modal fade">
</div>

<!-- -->
<div id="confirm_del_version_personal" class="modal fade">
    <div class="modal-dialog dialog_mini">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMAR ELIMINAR DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="del_version_per_id" id="del_version_per_id">
                    <p>¿Estas seguro de que desea eliminar este documento?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_confirmar_del_personal" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>