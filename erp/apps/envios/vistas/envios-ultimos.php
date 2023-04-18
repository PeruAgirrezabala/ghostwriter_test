<!-- proyectos activos -->
<table class="table table-striped table-hover" id='tabla-envios-ultimos'>
    <thead>
      <tr>
        <th>REF. PED.</th>
        <th>MATERIAL</th>
        <th>ENVÍO</th>
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
                ENVIOS_CLI.id,
                ENVIOS_CLI.ref,
                MATERIALES.nombre,
                ENVIOS_CLI.fecha 
            FROM 
                ENVIOS_CLI_DETALLES, 
                ENVIOS_CLI,
                MATERIALES
            WHERE
                ENVIOS_CLI_DETALLES.material_id = MATERIALES.id
            AND
                ENVIOS_CLI_DETALLES.envio_id = ENVIOS_CLI.id
            ORDER BY 
                ENVIOS_CLI.fecha DESC
            LIMIT 10
            ";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Envíos");
    
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