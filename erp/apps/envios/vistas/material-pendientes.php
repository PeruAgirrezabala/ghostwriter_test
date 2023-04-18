<!-- proyectos activos -->
<table class="table table-striped table-hover" id='tabla-pedidos-ultimos'>
    <thead>
      <tr>
        <th>REF</th>
        <th>TITULO</th>
        <th>PROVEEDOR</th>
        <th>FECHA</th>
        <th>PROYECTO</th>
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
                PROYECTOS.nombre 
            FROM 
                PEDIDOS_PROV
            INNER JOIN PEDIDOS_PROV_ESTADOS
                ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
            INNER JOIN PROVEEDORES 
                ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id 
            INNER JOIN erp_users 
                ON PEDIDOS_PROV.tecnico_id = erp_users.id 
            LEFT JOIN PROYECTOS
                ON PEDIDOS_PROV.proyecto_id = PROYECTOS.id  
            LEFT JOIN CLIENTES
                ON PROYECTOS.cliente_id = CLIENTES.id
            WHERE 
                PEDIDOS_PROV_ESTADOS.id <> 5
            ORDER BY 
                PEDIDOS_PROV.fecha DESC
            LIMIT 10
            ";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Pedidos");
    
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td>".$registros[2]."</td>
                <td>".$registros[3]."</td>
                <td>".$registros[4]."</td>
                <td>".$registros[5]."</td>
            </tr>
        ";
    }
?>

    </tbody>
</table>