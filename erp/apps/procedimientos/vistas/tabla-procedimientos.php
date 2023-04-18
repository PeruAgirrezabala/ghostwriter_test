<!-- PROCEDIMIENTOS -->

<table class="table table-hover" id="tabla-procedimientos">
    <thead>
        <tr>
            <th class="text-center">REF</th>
            <th class="text-center">NOMBRE</th>
            <th class="text-center">DESCRIPCION</th>
            <th class="text-center">FECHA CREACIÓN</th>
            <th class="text-center">TIPO</th>
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
                    PROCEDIMIENTOS.id plan,
                    PROCEDIMIENTOS.nombre,
                    PROCEDIMIENTOS.descripcion,
                    PROCEDIMIENTOS.ref,
                    (SELECT doc_path FROM PROCEDIMIENTOS_VERSIONES WHERE procedimiento_id = plan ORDER BY fecha_exp DESC, id DESC LIMIT 1) as path,
                    (SELECT fecha_exp FROM PROCEDIMIENTOS_VERSIONES WHERE procedimiento_id = plan ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_exp,
                    (SELECT id FROM PROCEDIMIENTOS_VERSIONES WHERE procedimiento_id = plan ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                    PROCEDIMIENTOS.tipodoc_id,
                    TIPOS_DOCISO.nombre
                FROM 
                    PROCEDIMIENTOS 
                LEFT JOIN
                    TIPOS_DOCISO
                ON 
                    TIPOS_DOCISO.id = PROCEDIMIENTOS.tipodoc_id 
                ORDER BY 
                    PROCEDIMIENTOS.ref ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Procedimientos");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $nombrePlan = $registros[1];
            $descPlan = $registros[2];
            $ref = $registros[3];
            $doc_path = $registros[4];
            $fecha_exp = $registros[5];
            $planver_id = $registros[6];
            $tipodoc_id = $registros[7];
            $tipodoc = $registros[8];
            
            $file_PLAN = "<a href='file:////192.168.3.108/".$doc_path."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a>";
            
            echo "
                <tr data-id='".$id."' class='licencia'>
                    <td class='text-left'>".$ref."</td>
                    <td class='text-left'>".$nombrePlan."</td>
                    <td class='text-left'>".$descPlan."</td>
                    <td class='text-center'>".$fecha_exp."</td>
                    <td class='text-center'>".$tipodoc."</td>
                    <td class='text-center'>".$file_PLAN."</td>
                    <td class='text-center'><button class='btn-default upload-doc-PROC' data-id='".$id."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 15px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- PROCEDIMIENTOS -->