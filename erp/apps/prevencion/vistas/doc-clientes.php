<!-- DOC Admon -->

<table class="table table-striped table-hover" id='tabla-doc-CLIDOC'>
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
                    CLIENTES_DOC.id as file, 
                    CLIENTES_DOC.nombre, 
                    ORGANISMOS.nombre, 
                    (SELECT doc_path FROM CLIENTES_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as path,
                    (SELECT fecha_exp FROM CLIENTES_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_exp,
                    (SELECT fecha_cad FROM CLIENTES_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                    (SELECT id FROM CLIENTES_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id, 
                    PERIODICIDADES.intervalo,
                    PERIODICIDADES.nombre
                FROM 
                    CLIENTES_DOC  
                INNER JOIN ORGANISMOS
                    ON ORGANISMOS.id = CLIENTES_DOC.org_id 
                INNER JOIN PERIODICIDADES
                    ON PERIODICIDADES.id = CLIENTES_DOC.periodicidad_id 
                WHERE
                    CLIENTES_DOC.cliente_id = ".$_GET['cliente_id']."
                ORDER BY 
                    ORGANISMOS.nombre ASC, 
                    CLIENTES_DOC.nombre ASC";
        file_put_contents("selectCLI.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Doc Contratista");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $docCLI_id = $registros[0];
            $nombreCLI = $registros[1];
            $orgCLI = $registros[2];
            $docpath_CLI = $registros[3];
            $fecha_exp_CLI = $registros[4];
            $fecha_cad_CLI = $registros[5];
            $docverCLI_id = $registros[6];
            $intervaloCLI = $registros[7];
            $intervaloCLInombre = substr($registros[8], 0, 1);
                    
            $fechaSUM = date('Y-m-d', strtotime($fecha_exp_CLI. ' + '.$intervaloCLI.' days'));
            $todaySUM7 = date('Y-m-d', strtotime(date("Y-m-d"). ' + 7 days'));
            
            if ($intervaloCLI == 0) {
                $estado_CLI = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
            }
            else {
                if ($fecha_exp_CLI != "") {
                    if (date('Y-m-d') > $fechaSUM) {
                        $estado_CLI = "<span class='dot-red' title='Expirado el día ".$fechaSUM."'></span>";
                    }
                    else {
                        if ($todaySUM7 >= $fechaSUM) {
                            $fecha2 = new DateTime($fechaSUM);
                            $fecha1 = new DateTime(date('Y-m-d'));
                            $diasexp = $fecha1->diff($fecha2);
                            $estado_CLI = "<span class='dot-yellow' title='Expira en los próximos ".$diasexp->format('%R%a')." días'></span>";
                        }
                        else {
                            $estado_CLI = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                        }
                    }
                }
                else {
                    $estado_CLI = "<span class='dot-red' title='No hay ningún fichero subido para este documento'></span>";
                } 
            }
            
            $file_CLI = "<a href='file:////192.168.3.108/".$docpath_CLI."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a>";
            
            echo "
                <tr data-id='".$docCLI_id."' data-tipo='cli' class='oferta' draggable='true' ondragstart='drag(event)' id='doc-cli-".$docCLI_id."'>
                    <td class='text-center'>".$estado_CLI."</td>
                    <td class='text-left'>".$nombreCLI."</td>
                    <td class='text-center'>".$orgCLI."</td>
                    <td class='text-center'>".$fecha_exp_CLI."</td>
                    <td class='text-center' title='".$registros[10]."'>".$intervaloCLInombre."</td>
                    <td class='text-center'>".$file_CLI."</td>
                    <td class='text-center'><button class='btn-default upload-doc-CLI' data-id='".$docCLI_id."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 15px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- DOC Admon -->