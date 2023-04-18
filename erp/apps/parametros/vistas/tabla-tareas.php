<table class="table table-hover" id="tabla-tareas">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">NOMBRE</th>
            <th class="text-center">DESCRIPCION</th>
            <th class="text-center">PERFIL</th>
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
                    TAREAS.id,
                    TAREAS.nombre,
                    TAREAS.descripcion,
                    PERFILES.nombre
                FROM 
                    TAREAS, PERFILES
                WHERE
                    TAREAS.perfil_id = PERFILES.id  
                ORDER BY 
                    TAREAS.nombre ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Tareas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $idTarea = $registros[0];
            $nombreTarea = $registros[1];
            $descTarea = $registros[2];
            $nombreTareaPerfil = $registros[3];
            
            echo "
                <tr data-id='".$idTarea."' class='licencia'>
                    <td class='text-left'>".$nombreTarea."</td>
                    <td class='text-left'>".$descTarea."</td>
                    <td class='text-left'>".$nombreTareaPerfil."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger del-tarea' data-id='".$idTarea."' title='Eliminar Tarea'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>