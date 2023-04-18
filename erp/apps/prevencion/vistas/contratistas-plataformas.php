<!-- DOC Admon -->

<table class="table table-striped table-hover" id='tabla-contratistas-plataformas'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">N</th>
            <th class="text-center">INSTALACION</th>
            <th class="text-center">PLATAFORMA</th>
            <th class="text-center">USUARIO</th>
            <th class="text-center">CONTRASEÑA</th>
            <th class="text-center">E</th>
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
                    CONTRATISTAS_PLATAFORMAS.id,
                    CONTRATISTAS_PLATAFORMAS.url,
                    CONTRATISTAS_PLATAFORMAS.user,
                    CONTRATISTAS_PLATAFORMAS.pass,
                    CONTRATISTAS_PLATAFORMAS.instalacion
                FROM 
                    CONTRATISTAS_PLATAFORMAS
                WHERE
                    CONTRATISTAS_PLATAFORMAS.cliente_id = ".$_GET['cliente_id'];
        file_put_contents("selectContratistasPlataformas.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de contratistas plataformas");
        
        $count=0;
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $count++;
            $idContratistaPlataforma = $registros[0];
            $url = $registros[1];
            $user = $registros[2];
            $pass = $registros[3];
            $instalacion = $registros[4];
            
            $botonEliminar='<button class="btn btn-circle btn-danger remove-contratistas-plataformas" data-id="'.$idContratistaPlataforma.'" title="Eliminar Plataforma Contratista"><img src="/erp/img/cross.png"></button>';
            
            echo "
                <tr data-id='".$idContratistaPlataforma."' data-tipo='cli' class='oferta' draggable='true' ondragstart='drag(event)' id='contratista-plataforma-".$idContratistaPlataforma."'>
                    <td class='text-left'>".$count."</td>
                    <td class='text-center'>".$instalacion."</td>  
                    <td class='text-center'>".$url."</td>
                    <td class='text-center'>".$user."</td>
                    <td class='text-center'>".$pass."</td>
                    <td class='text-center'>".$botonEliminar."</td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- DOC Admon -->