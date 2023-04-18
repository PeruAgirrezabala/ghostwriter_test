<!-- proyectos activos -->
<table class="table table-striped table-hover" id='tabla-pedidos-ultimos'>
    <thead>
      <tr class="bg-dark">
        <th>REF. PED.</th>
        <th>MATERIAL</th>
        <th>ENTREGA</th>
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
                PEDIDOS_PROV_DETALLES.fecha_recepcion
            FROM 
                PEDIDOS_PROV_DETALLES, 
                PEDIDOS_PROV,
                MATERIALES
            WHERE
                PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id
            AND
                PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id
            AND
                PEDIDOS_PROV_DETALLES.fecha_recepcion <> '0000-00-00'
            ORDER BY 
                PEDIDOS_PROV_DETALLES.fecha_recepcion DESC
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