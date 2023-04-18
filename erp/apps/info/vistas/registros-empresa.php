<table class="table table-hover" id="tabla-registros">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">PLATAFORMA</th>
            <th class="text-center">USUARIO</th>
            <th class="text-center">CONTRASEÑA</th>
            <th class="text-center">DESCRIPCION</th>
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
        
        if ($_GET['empresa'] != "") {
            $empresa_id = $_GET['empresa'];
        }
        else {
            $empresa_id = "1";
        }
        
        $sql = "SELECT 
                    EMPRESAS_REGISTROS.id,
                    EMPRESAS_REGISTROS.plataforma,
                    EMPRESAS_REGISTROS.usuario,
                    EMPRESAS_REGISTROS.password,
                    EMPRESAS_REGISTROS.descripcion
                FROM 
                    EMPRESAS, EMPRESAS_REGISTROS
                WHERE 
                    EMPRESAS_REGISTROS.empresa_id = EMPRESAS.id
                AND
                    EMPRESAS.id = ".$empresa_id."
                ORDER BY 
                    EMPRESAS_REGISTROS.plataforma ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Registros");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $plataforma = $registros[1];
            $usuario = $registros[2];
            $pass = $registros[3];
            $descripcion = $registros[4];
            
            echo "
                <tr data-id='".$id."' class='licencia'>
                    <td class='text-left'><a href='".$plataforma."' target='_blank'>".$plataforma."</a></td>
                    <td class='text-center'>".$usuario."</td>
                    <td class='text-center'>".$pass."</td>
                    <td class='text-left'>".$descripcion."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-registro' data-id='".$id."' title='Eliminar Registro'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>