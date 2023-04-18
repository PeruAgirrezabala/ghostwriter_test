<!-- DOC Admon -->

<table class="table table-striped table-hover" id='tabla-doc-PRL'>
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
                    PRL_DOC.id as file, 
                    PRL_DOC.nombre, 
                    ORGANISMOS.nombre, 
                    (SELECT doc_path FROM PRL_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as path,
                    (SELECT fecha_exp FROM PRL_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_exp,
                    (SELECT fecha_cad FROM PRL_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                    (SELECT id FROM PRL_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id, 
                    PERIODICIDADES.intervalo, 
                    PERIODICIDADES.nombre
                FROM 
                    PRL_DOC 
                INNER JOIN ORGANISMOS
                    ON ORGANISMOS.id = PRL_DOC.org_id 
                INNER JOIN PERIODICIDADES
                    ON PERIODICIDADES.id = PRL_DOC.periodicidad_id 
                WHERE
                    PRL_DOC.empresa_id = ".$empresa_id."
                ORDER BY 
                    ORGANISMOS.nombre ASC, 
                    PRL_DOC.nombre ASC";
        //file_put_contents("selectPRL.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Doc PRL");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $docPRL_id = $registros[0];
            $nombrePRL = $registros[1];
            $orgPRL = $registros[2];
            $docpath_PRL = $registros[3];
            $fecha_exp_PRL = $registros[4];
            $fecha_cad_PRL = $registros[5];
            $docverPRL_id = $registros[6];
            $intervaloPRL = $registros[7];
            $intervaloPRLnombre = substr($registros[8], 0, 1);
                    
            $fechaSUM = date('Y-m-d', strtotime($fecha_exp_PRL. ' + '.$intervaloPRL.' days'));
            $todaySUM7 = date('Y-m-d', strtotime(date("Y-m-d"). ' + 7 days'));
            
            if ($intervaloPRL == 0) {
                $estado_PRL = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
            }
            else {
                if ($fecha_exp_PRL != "") {
                    if (date('Y-m-d') > $fechaSUM) {
                        $estado_PRL = "<span class='dot-red' title='Expirado el día ".$fechaSUM."'></span>";
                    }
                    else {
                        if ($todaySUM7 >= $fechaSUM) {
                            $fecha2 = new DateTime($fechaSUM);
                            $fecha1 = new DateTime(date('Y-m-d'));
                            $diasexp = $fecha1->diff($fecha2);
                            $estado_PRL = "<span class='dot-yellow' title='Expira en los próximos ".$diasexp->format('%R%a')." días'></span>";
                        }
                        else {
                            $estado_PRL = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                        }
                    }
                }
                else {
                    $estado_PRL = "<span class='dot-grey' title='No hay ningún fichero subido para este documento'></span>";
                } 
            }
            
            $file_PRL = "<a href='file:////192.168.3.108/".$docpath_PRL."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a>";
            
            echo "
                <tr data-id='".$docPRL_id."' data-tipo='prl' class='oferta' draggable='true' ondragstart='drag(event)' id='doc-prl-".$docPRL_id."'>
                    <td class='text-center'>".$estado_PRL."</td>
                    <td class='text-left'>".$nombrePRL."</td>
                    <td class='text-left'>".$orgPRL."</td>
                    <td class='text-center'>".$fecha_exp_PRL."</td>
                    <td class='text-center' title='".$registros[8]."'>".$intervaloPRLnombre."</td>
                    <td class='text-center'>".$file_PRL."</td>
                    <td class='text-center'><button class='btn-default upload-doc-PRL' data-id='".$docPRL_id."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 10px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- DOC Admon -->