<!-- pedidos del proyecto -->

<table class="table table-striped table-hover" id='tabla-pedidos-proyecto'>
    <thead>
      <tr>
        <th>REF</th>
        <th>TITULO</th>
        <th class="text-center">PROV</th>
        <th class="text-center">FECHA</th>
        <th class="text-center">TOTAL</th>
        <th class="text-center">ESTADO</th>
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
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.ref,
                    PEDIDOS_PROV.titulo,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV_ESTADOS.color
                FROM 
                    PROYECTOS, CLIENTES, PEDIDOS_PROV, PEDIDOS_PROV_ESTADOS, PROVEEDORES, erp_users  
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND 
                    PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                AND
                    PEDIDOS_PROV.proyecto_id = PROYECTOS.id  
                AND
                    PEDIDOS_PROV.tecnico_id = erp_users.id
                AND
                    PEDIDOS_PROV.proveedor_id = PROVEEDORES.id  
                AND 
                    PEDIDOS_PROV.proyecto_id = ".$_GET['id']."
                ORDER BY 
                    PEDIDOS_PROV.fecha DESC ";

        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Pedidos");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $pedido_id = $registros[0];
            $refPedido = $registros[1];
            $tituloPedido = $registros[2];
            $proveedorPedido = $registros[3];
            $fechaPedido = $registros[4];
            $estadoPedido = $registros[5];
            $totalPedido = $registros[6];
            $estadoPedidoColor = $registros[7];

            echo "
                <tr data-id='".$pedido_id."' class='oferta'>
                    <td>".$refPedido."</td>
                    <td>".$tituloPedido."</td>
                    <td>".$proveedorPedido."</td>
                    <td class='text-center'>".$fechaPedido."</td>
                    <td class='text-center'>".$totalPedido."</td>
                    <td class='text-center'><span class='label label-".$estadoPedidoColor."'>".$estadoPedido."</span></td>
                </tr>
            ";
        }   
        $totalGanancia = $total - $totalPVPdto;
    ?>
    </tbody>
</table>

<!-- pedidos del proyecto -->