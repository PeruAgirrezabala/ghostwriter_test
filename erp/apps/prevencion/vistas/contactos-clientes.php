<!-- DOC Admon -->

<table class="table table-striped table-hover" id='tabla-doc-CLI'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">E</th>
            <th class="text-center">NOMBRE</th>
            <th class="text-center">TELÉFONO</th>
            <th class="text-center">MAIL</th>
            <th class="text-center">INSTALACION</th>
            <!--<th class="text-center">M</th>-->
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
                    CLIENTES_CONTACTOS.id,
                    CLIENTES_CONTACTOS.nombre,
                    CLIENTES_CONTACTOS.telefono,
                    CLIENTES_CONTACTOS.mail,
                    CLIENTES_CONTACTOS.descripcion,
                    CLIENTES_CONTACTOS.activo,
                    CLIENTES_CONTACTOS.cliente_id,
                    CLIENTES_CONTACTOS.instalacion_cliente_id,
                    CLIENTES_INSTALACIONES.id,
                    CLIENTES_INSTALACIONES.nombre
                FROM 
                    CLIENTES_CONTACTOS
                INNER JOIN
                    CLIENTES_INSTALACIONES ON CLIENTES_CONTACTOS.instalacion_cliente_id=CLIENTES_INSTALACIONES.id
                WHERE
                    CLIENTES_CONTACTOS.cliente_id = ".$_GET['cliente_id'];
        file_put_contents("selectcontactosCLI.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de contactos cliente");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $idClienteContacto = $registros[0];
            $nombreClienteContacto = $registros[1];
            $telefonoClienteContacto = $registros[2];
            $mailClienteContacto = $registros[3];
            $descClienteContacto = $registros[4];
            $activoClienteContacto = $registros[5];
            $clienteIdClienteContacto = $registros[6];
            $instalacionClienteContacto = $registros[9];
            
            
            if($activoClienteContacto == "on"){
                $iconoActivo = '<span class="dot-green" title=""></span>';
            }elseif($activoClienteContacto == "off"){
                $iconoActivo = '<span class="dot-red" title=""></span>';
            }
            
            $btnBorrar = '<button class="btn btn-circle btn-danger remove-contacto-cliente" data-id="'.$idClienteContacto.'" title="Eliminar Contacto" type="button"><img src="/erp/img/cross.png"></button>';
            $btnModificar = '<button type="button" class="btn btn-xs btn-default edit-contacto-cliente" data-id="'.$idClienteContacto.'" title="Editar"><span class="glyphicon glyphicon-edit"></span></button>';
            
            echo "
                <tr data-id='".$idClienteContacto."' data-tipo='cli' class='oferta' draggable='true' ondragstart='drag(event)' id='doc-cli-".$idClienteContacto."'>
                    <td class='text-center'>".$iconoActivo."</td>
                    <td class='text-left'>".$nombreClienteContacto."</td>
                    <td class='text-center'>".$telefonoClienteContacto."</td>
                    <td class='text-center'>".$mailClienteContacto."</td>
                    <td class='text-center'>".$instalacionClienteContacto."</td>
                    <!--<td class='text-center'>".$btnModificar."</td>-->
                    <td class='text-center'>".$btnBorrar."</td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- DOC Admon -->