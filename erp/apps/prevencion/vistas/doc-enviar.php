<!-- Contratista seleccionado -->
<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
?>

<table class="table table-striped table-hover" id="tabla-doc-enviar" ondrop="drop(event)" ondragover="allowDrop(event)">
    <thead>
      <tr class="bg-dark">
        <th class="text-center">TIPO</th>
        <th class="text-left">DOCUMENTO</th>
        <th class="text-center">ORGANISMO</th>
        <th class="text-center">S</th>
        <th class="text-center">D</th>
        <th class="text-center">E</th>
      </tr>
    </thead>
    <tbody>
        <?
            //DOC ADMON
            $sql = "SELECT 
                            A.id, 
                            'ADMON_DOC' as tipo, 
                            ADMON_DOC.nombre, 
                            ORGANISMOS.nombre, 
                            A.enviado,
                            ADMON_DOC.id as file,
                            (SELECT doc_path FROM ADMON_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC LIMIT 1) as path
                        FROM 
                            CLIENTES_DOC_ENVIAR A, ADMON_DOC, ORGANISMOS, PERIODICIDADES
                        WHERE 
                            ADMON_DOC.id = A.doc_id
                        AND
                            A.cliente_id = ".$_GET['cliente_id']."
                        AND
                            A.tipo_doc = 'admon'
                        AND
                            ORGANISMOS.id = ADMON_DOC.org_id 
                        AND
                            PERIODICIDADES.id = ADMON_DOC.periodicidad_id
                       ";
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos a enviar");
            while ($registros = mysqli_fetch_array($resultado)) {
                $docid = $registros[0];
                $tipodoc = $registros[1];
                $nombredoc = $registros[2];
                $orgdoc = $registros[3];
                $path = $registros[6];
                if ($registros[4] == 0) {
                    $boton = "<button class='btn-default enviar-doc' data-id='".$docid."' title='Marcar como Enviado'><img src='/erp/img/enviar.png' style='height: 15px;'></button>";
                }
                else {
                    $boton = "<button class='btn-default enviado-doc' data-id='".$docid."' title='Marcar como no Enviado'><img src='/erp/img/enviado.png' style='height: 15px;'></button>";
                }
                
                $file = "<a href='file:////192.168.3.108/".$path."' target='_blank'><img src='/erp/img/download.png' style='height: 15px;' title='Download'></a>";
                
                echo "
                        <tr data-id='".$docid."' class='oferta'>
                            <td class='text-center'>".$tipodoc."</td>
                            <td class='text-left'>".$nombredoc."</td>
                            <td class='text-center'>".$orgdoc."</td>
                            <td class='text-center'>".$boton."</td>
                            <td class='text-center'>".$file."</td>
                            <td class='text-center'><button class='btn-default remove-doc-cli' data-id='".$docid."' title='Eliminar'><img src='/erp/img/remove.png' style='height: 15px;'></button></td>
                        </tr>
                    ";
            }
            
            // DOC PREVENCION
            $sql = "SELECT 
                            A.id, 
                            'PRL_DOC' as tipo, 
                            PRL_DOC.nombre, 
                            ORGANISMOS.nombre, 
                            A.enviado,
                            PRL_DOC.id as file,
                            (SELECT doc_path FROM PRL_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC LIMIT 1) as path
                        FROM 
                            CLIENTES_DOC_ENVIAR A, PRL_DOC, ORGANISMOS, PERIODICIDADES
                        WHERE 
                            PRL_DOC.id = A.doc_id
                        AND
                            A.cliente_id = ".$_GET['cliente_id']."
                        AND
                            A.tipo_doc = 'prl'
                        AND
                            ORGANISMOS.id = PRL_DOC.org_id 
                        AND
                            PERIODICIDADES.id = PRL_DOC.periodicidad_id 
                       ";
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos a enviar");
            while ($registros = mysqli_fetch_array($resultado)) {
                
                $docid = $registros[0];
                $tipodoc = $registros[1];
                $nombredoc = $registros[2];
                $orgdoc = $registros[3];
                $path = $registros[6];
                if ($registros[4] == 0) {
                    $boton = "<button class='btn-default enviar-doc' data-id='".$docid."' title='Marcar como Enviado'><img src='/erp/img/enviar.png' style='height: 15px;'></button>";
                }
                else {
                    $boton = "<button class='btn-default enviado-doc' data-id='".$docid."' title='Marcar como no Enviado'><img src='/erp/img/enviado.png' style='height: 15px;'></button>";
                }
                $file = "<a href='file:////192.168.3.108/".$path."' target='_blank'><img src='/erp/img/download.png' style='height: 15px;' title='Download'></a>";
                echo "
                        <tr data-id='".$docid."' class='oferta'>
                            <td class='text-center'>".$tipodoc."</td>
                            <td class='text-left'>".$nombredoc."</td>
                            <td class='text-center'>".$orgdoc."</td>
                            <td class='text-center'>".$boton."</td>
                            <td class='text-center'>".$file."</td>
                            <td class='text-center'><button class='btn-default remove-doc-cli' data-id='".$docid."' title='Eliminar'><img src='/erp/img/remove.png' style='height: 15px;'></button></td>
                        </tr>
                    ";
            }
            
            // DOC PERSONAL
            $sql = "SELECT 
                            A.id, 
                            'USERS_DOC' as tipo, 
                            USERS_DOC.nombre, 
                            ORGANISMOS.nombre, 
                            A.enviado,
                            USERS_DOC.id as file,
                            (SELECT doc_path FROM USERS_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC LIMIT 1) as path,
                            erp_users.nombre,
                            erp_users.apellidos 
                        FROM 
                            CLIENTES_DOC_ENVIAR A, USERS_DOC, ORGANISMOS, PERIODICIDADES, erp_users
                        WHERE 
                            USERS_DOC.id = A.doc_id
                        AND
                            A.cliente_id = ".$_GET['cliente_id']."
                        AND
                            A.tipo_doc = 'per'
                        AND
                            ORGANISMOS.id = USERS_DOC.org_id 
                        AND
                            PERIODICIDADES.id = USERS_DOC.periodicidad_id 
                        AND
                            erp_users.id = USERS_DOC.erpuser_id
                        ORDER BY 
                            erp_users.nombre ASC,
                            ORGANISMOS.nombre ASC
                       ";
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos a enviar");
            while ($registros = mysqli_fetch_array($resultado)) {
                
                $docid = $registros[0];
                $tipodoc = $registros[1];
                $nombredoc = $registros[2];
                $orgdoc = $registros[3];
                $path = $registros[6];
                $usernombre = $registros[7];
                $userapellido = $registros[8];
                if ($registros[4] == 0) {
                    $boton = "<button class='btn-default enviar-doc' data-id='".$docid."' title='Marcar como Enviado'><img src='/erp/img/enviar.png' style='height: 15px;'></button>";
                }
                else {
                    $boton = "<button class='btn-default enviado-doc' data-id='".$docid."' title='Marcar como no Enviado'><img src='/erp/img/enviado.png' style='height: 15px;'></button>";
                }
                
                $file = "<a href='file:////192.168.3.108/".$path."' target='_blank'><img src='/erp/img/download.png' style='height: 15px;' title='Download'></a>";
                echo "
                        <tr data-id='".$docid."' class='oferta'>
                            <td class='text-center'>".$usernombre." ".$userapellido."</td>
                            <td class='text-left'>".$nombredoc."</td>
                            <td class='text-center'>".$orgdoc."</td>
                            <td class='text-center'>".$boton."</td>
                            <td class='text-center'>".$file."</td>
                            <td class='text-center'><button class='btn-default remove-doc-cli' data-id='".$docid."' title='Eliminar'><img src='/erp/img/remove.png' style='height: 15px;'></button></td>
                        </tr>
                    ";
            }
            
            // DOC CLIENTES
            $sql = "SELECT 
                            A.id, 
                            'CLIENTES_DOC' as tipo, 
                            CLIENTES_DOC.nombre, 
                            ORGANISMOS.nombre, 
                            A.enviado,
                            CLIENTES_DOC.id as file,
                            (SELECT doc_path FROM CLIENTES_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC LIMIT 1) as path
                        FROM 
                            CLIENTES_DOC_ENVIAR A, CLIENTES_DOC, ORGANISMOS, PERIODICIDADES
                        WHERE 
                            CLIENTES_DOC.id = A.doc_id
                        AND
                            A.cliente_id = ".$_GET['cliente_id']."
                        AND
                            A.tipo_doc = 'cli'
                        AND
                            ORGANISMOS.id = CLIENTES_DOC.org_id 
                        AND
                            PERIODICIDADES.id = CLIENTES_DOC.periodicidad_id
                       ";
            file_put_contents("selectCLIenviar.txt", $sql);
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos a enviar");
            while ($registros = mysqli_fetch_array($resultado)) {
                
                $docid = $registros[0];
                $tipodoc = $registros[1];
                $nombredoc = $registros[2];
                $orgdoc = $registros[3];
                $path = $registros[6];
                if ($registros[4] == 0) {
                    $boton = "<button class='btn-default enviar-doc' data-id='".$docid."' title='Marcar como Enviado'><img src='/erp/img/enviar.png' style='height: 15px;'></button>";
                }
                else {
                    $boton = "<button class='btn-default enviado-doc' data-id='".$docid."' title='Marcar como no Enviado'><img src='/erp/img/enviado.png' style='height: 15px;'></button>";
                }
                
                $file = "<a href='file:////192.168.3.108/".$path."' target='_blank'><img src='/erp/img/download.png' style='height: 15px;' title='Download'></a>";
                echo "
                        <tr data-id='".$docid."' class='oferta'>
                            <td class='text-center'>".$tipodoc."</td>
                            <td class='text-left'>".$nombredoc."</td>
                            <td class='text-center'>".$orgdoc."</td>
                            <td class='text-center'>".$boton."</td>
                            <td class='text-center'>".$file."</td>
                            <td class='text-center'><button class='btn-default remove-doc-cli' data-id='".$docid."' title='Eliminar'><img src='/erp/img/remove.png' style='height: 15px;'></button></td>
                        </tr>
                    ";
            }

        ?>
    </tbody>
</table>


<!-- contratistas seleccionado -->