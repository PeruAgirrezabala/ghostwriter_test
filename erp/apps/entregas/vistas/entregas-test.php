<!-- proyectos activos -->
<div id='tabla-entregas-test' class='pre-scrollable' style='font-size:10px;'>
<table class="table table-striped table-hover tabla-entregas" id='tabla-entregas-mes'>
    <thead>
      <tr>
        <th>REF</th>
        <th>TITULO</th>
        <th>FECHA ENTREGA</th>
        <th>ESTADO</th>
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
                    ENTREGAS.id,
                    ENTREGAS.ref,
                    ENTREGAS.nombre,
                    ENTREGAS.fecha_entrega,
                    PROYECTOS.nombre, 
                    ESTADOS_ENTREGAS.nombre,
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    ESTADOS_ENTREGAS.color 
                FROM 
                    PROYECTOS, ESTADOS_ENTREGAS, ENTREGAS, CLIENTES  
                WHERE
                    PROYECTOS.cliente_id = CLIENTES.id
                AND
                    PROYECTOS.id = ENTREGAS.proyecto_id
                AND 
                    ENTREGAS.estado_id = ESTADOS_ENTREGAS.id 
                AND
                    ENTREGAS.estado_id = 2 
                ORDER BY 
                    ENTREGAS.fecha_entrega DESC
                LIMIT 10
            ";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Entregas del Mes");
    
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td title='".$registros[4]."'>".$registros[2]."</td>
                <td>".$registros[3]."</td>
                <td><span class='label label-".$registros[8]."'>".$registros[5]."</span></td>
            </tr>
        ";
    }
?>

    </tbody>
</table>
</div>