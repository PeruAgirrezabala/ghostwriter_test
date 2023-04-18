<table class="table table-hover table-condensed table-striped" id="tabla-roles">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">NOMBRE</th>
            <th class="text-center">E</th>
            <th class="text-center">D</th>
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
                    erp_roles.id,
                    erp_roles.nombre
                FROM 
                    erp_roles
                ORDER BY 
                    erp_roles.nombre ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Roles");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $nombreRole = $registros[1];
            
            echo "
                <tr data-id='".$id."' class='licencia'>
                    <td class='text-center'>".$nombreRole."</td>
                    <td class='text-center'><button class='btn btn-circle btn-info edit-role' data-id='".$id."' title='Editar Role'><img src='/erp/img/edit.png'></button></td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-role' data-id='".$id."' title='Eliminar Role'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>