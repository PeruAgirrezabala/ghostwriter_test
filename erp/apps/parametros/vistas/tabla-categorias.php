<table class="table table-hover" id="tabla-categorias">
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
                    ACTIVIDAD_CATEGORIAS.id,
                    ACTIVIDAD_CATEGORIAS.nombre 
                FROM 
                    ACTIVIDAD_CATEGORIAS
                ORDER BY 
                    ACTIVIDAD_CATEGORIAS.nombre ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Categorías");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $idCategoria = $registros[0];
            $nombreCategoria = $registros[1];
            
            echo "
                <tr data-id='".$idCategoria."' class='licencia'>
                    <td class='text-left'>".$nombreCategoria."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger del-categoria' data-id='".$idCategoria."' title='Eliminar Categoría'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>