<table class="table table-hover table-striped" id="tabla-permisos-roles">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">ROLE</th>
            <th class="text-center">APP</th>
            <th class="text-center">MENU</th>
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
                    erp_roles_apps.id,
                    erp_roles.nombre,
                    erp_apps.nombre,
                    erp_apps.ubicacion 
                FROM 
                    erp_roles_apps, erp_roles, erp_apps  
                WHERE 
                    erp_roles.id = erp_roles_apps.role_id 
                AND
                    erp_apps.id = erp_roles_apps.app_id 
                AND
                    erp_roles.id = ".$_GET['role_id']."
                ORDER BY 
                    erp_apps.ubicacion ASC, erp_apps.id ASC";
        file_put_contents("queryRolesApps.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Roles-Apps");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $nombreRole = $registros[1];
            $nombreApp = $registros[2];
            $ubicacionApp = $registros[3];
            
            echo "
                <tr data-id='".$id."'>
                    <td class='text-center'>".$nombreRole."</td>
                    <td class='text-center'>".$nombreApp."</td>
                    <td class='text-center'>".$ubicacionApp."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-permiso-app' data-id='".$id."' title='Eliminar Permiso de App'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>