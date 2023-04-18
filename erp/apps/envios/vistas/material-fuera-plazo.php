<!-- proyectos activos -->
<table class="table table-striped table-hover" id='tabla-pedidos-fueraplazo'>
    <thead>
      <tr>
        <th>REF. PED.</th>
        <th>MATERIAL</th>
        <th>ENTREGA PREV.</th>
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
                PEDIDOS_PROV.pedido_genelek,
                MATERIALES.nombre,
                PEDIDOS_PROV_DETALLES.fecha_entrega
            FROM 
                PEDIDOS_PROV_DETALLES, 
                PEDIDOS_PROV,
                MATERIALES
            WHERE
                PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id
            AND
                PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
            AND
                PEDIDOS_PROV_DETALLES.fecha_entrega < now()
            AND 
                PEDIDOS_PROV_DETALLES.recibido = 0
            ORDER BY 
                PEDIDOS_PROV_DETALLES.fecha_entrega DESC
            LIMIT 10
            ";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Pedidos");
    
    while ($registros = mysqli_fetch_array($resultado)) { 
        $mat = $descPF = substr($registros[2],0,55)."...";
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td title='".$registros[2]."'>".$mat."</td>
                <td>".$registros[3]."</td>
            </tr>
        ";
    }
?>

    </tbody>
</table>