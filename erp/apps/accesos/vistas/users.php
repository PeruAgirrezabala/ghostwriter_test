<table class="table table-hover table-striped" id="tabla-users">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">NOMBRE</th>
            <th class="text-center">APELLIDOS</th>
            <th class="text-center">USERNAME</th>
            <th class="text-center">EMAIL</th>
            <th class="text-center">ROLE</th>
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
        
        if ($_GET['empresa'] != "") {
            $empresa_id = $_GET['empresa'];
        }
        else {
            $empresa_id = "1";
        }
        $viewTrabajadores=$_GET['viewTrabajadores'];
        if($viewTrabajadores=='on'){
            $onofftrabajadores = " AND erp_users.activo='on' ";
        }else{
            $onofftrabajadores = "  ";
        }
        
        
        $sql = "SELECT 
                    erp_users.id,
                    erp_users.txartela,
                    erp_users.nombre,
                    erp_users.apellidos,
                    erp_users.user_name,
                    erp_users.user_email,
                    erp_roles.nombre,
                    erp_users.activo
                FROM 
                    erp_users, erp_roles
                WHERE 
                    erp_users.role_id = erp_roles.id 
                ".$onofftrabajadores."
                AND
                    erp_users.empresa_id = ".$empresa_id."
                ORDER BY 
                    erp_users.nombre ASC, erp_users.apellidos ASC";
        file_put_contents("queryUsers.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Trabajadores");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $txartela = $registros[1];
            $nombreTrabajador = $registros[2];
            $apellidosTrabajador = $registros[3];
            $user_name = $registros[4];
            $user_email = $registros[5];
            $user_role = $registros[6];
            $user_active = $registros[7];
           
            echo "
                <tr data-id='".$id."'>
                    <td class='text-center'>".$nombreTrabajador."</td>
                    <td class='text-center'>".$apellidosTrabajador."</td>
                    <td class='text-center'>".$user_name."</td>
                    <td class='text-center'>".$user_email."</td>
                    <td class='text-center'>".$user_role."</td>
                    <td class='text-center'><button class='btn btn-circle btn-info edit-user' data-id='".$id."' title='Editar Trabajador'><img src='/erp/img/edit.png'></button></td>
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-user' data-id='".$id."' title='Eliminar Trabajador'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>