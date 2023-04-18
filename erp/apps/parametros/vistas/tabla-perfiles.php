<table class="table table-hover" id="tabla-perfiles">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">NOMBRE</th>
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
                    PERFILES.id,
                    PERFILES.nombre 
                FROM 
                    PERFILES
                ORDER BY 
                    PERFILES.nombre ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Perfiles");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $idPerfil = $registros[0];
            $nombrePerfil = $registros[1];
            
            echo "
                <tr data-id='".$idPerfil."' class='licencia'>
                    <td class='text-left'>".$nombrePerfil."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger del-perfil' data-id='".$idPerfil."' title='Eliminar Perfil'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>