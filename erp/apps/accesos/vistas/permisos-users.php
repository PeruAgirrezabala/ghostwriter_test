<table class="table table-hover table-striped" id="tabla-permisos-users">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">TRABAJADOR</th>
            <th class="text-center">ROLE</th>
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
                    erp_users_roles.id,
                    erp_users.nombre,
                    erp_users.apellidos,
                    erp_roles.nombre
                FROM 
                    erp_users, erp_users_roles, erp_roles
                WHERE 
                    erp_roles.id = erp_users_roles.rol_id 
                AND
                    erp_users_roles.toolsuser_id = erp_users.id 
                AND
                    erp_users.id = ".$_GET['user_id']."
                ORDER BY 
                    erp_roles.nombre ASC";
        file_put_contents("queryRolesUsers.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Roles-Users");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $trabajador = $registros[1]." ".$registros[2];
            $role = $registros[3];
            
            echo "
                <tr data-id='".$id."'>
                    <td class='text-center'>".$trabajador."</td>
                    <td class='text-center'>".$role."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-permiso-role' data-id='".$id."' title='Eliminar Role'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>