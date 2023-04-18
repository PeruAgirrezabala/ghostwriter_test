<!-- DOC Admon -->

<table class="table table-striped table-hover" id='tabla-doc-ADMON'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">E</th>
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
                    ADMON_DOC.id as file, 
                    ADMON_DOC.nombre, 
                    ORGANISMOS.nombre, 
                    (SELECT doc_path FROM ADMON_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as path,
                    (SELECT fecha_exp FROM ADMON_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_exp,
                    (SELECT fecha_cad FROM ADMON_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                    (SELECT id FROM ADMON_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id, 
                    PERIODICIDADES.intervalo, 
                    PERIODICIDADES.nombre
                FROM 
                    ADMON_DOC 
                INNER JOIN ORGANISMOS
                    ON ORGANISMOS.id = ADMON_DOC.org_id 
                INNER JOIN PERIODICIDADES
                    ON PERIODICIDADES.id = ADMON_DOC.periodicidad_id 
                WHERE
                    ADMON_DOC.empresa_id = ".$empresa_id."
                ORDER BY 
                    ORGANISMOS.nombre ASC, 
                    ADMON_DOC.nombre ASC";
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Doc Admon");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $docADMON_id = $registros[0];
            $nombreADMON = $registros[1];
            $orgADMON = $registros[2];
            $docpath_ADMON = $registros[3];
            $fecha_exp_ADMON = $registros[4];
            $fecha_cad_ADMON = $registros[5];
            $docverADMON_id = $registros[6];
            $intervaloADMON = $registros[7];
            $intervaloPERnombre = substr($registros[8], 0, 1);
                    
            $fechaSUM = date('Y-m-d', strtotime($fecha_exp_ADMON. ' + '.$intervaloADMON.' days'));
            $todaySUM7 = date('Y-m-d', strtotime(date("Y-m-d"). ' + 7 days'));
            
            if ($intervaloADMON == 0) {
                $estado_ADMON = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
            }
            else {
                if ($fecha_exp_ADMON != "") {
                    if (date('Y-m-d') > $fechaSUM) {
                        $estado_ADMON = "<span class='dot-red' title='Expirado el día ".$fechaSUM."'></span>";
                    }
                    else {
                        if ($todaySUM7 >= $fechaSUM) {
                            $fecha2 = new DateTime($fechaSUM);
                            $fecha1 = new DateTime(date('Y-m-d'));
                            $diasexp = $fecha1->diff($fecha2);
                            $estado_ADMON = "<span class='dot-yellow' title='Expira en los próximos ".$diasexp->format('%R%a')." días'></span>";
                        }
                        else {
                            $estado_ADMON = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                        }
                    }
                }
                else {
                    $estado_ADMON = "<span class='dot-grey' title='No hay ningún fichero subido para este documento'></span>";
                } 
            }
                
            
            $file_ADMON = "<a href='file:////192.168.3.108/".$docpath_ADMON."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a>";
            
            echo "
                <tr data-id='".$docADMON_id."' data-tipo='admon' class='oferta' draggable='true' ondragstart='drag(event)' id='doc-admon-".$docADMON_id."'>
                    <td class='text-center'>".$estado_ADMON."</td>
                    <td class='text-left'>".$nombreADMON."</td>
                    <td class='text-left'>".$orgADMON."</td>
                    <td class='text-center'>".$fecha_exp_ADMON."</td>
                    <td class='text-center' title='".$registros[8]."'>".$intervaloPERnombre."</td>
                    <td class='text-center'>".$file_ADMON."</td>
                    <td class='text-center'><button class='btn-default upload-doc-ADMON' data-id='".$docADMON_id."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 15px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- DOC Admon -->