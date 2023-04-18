<!-- partes del proyecto seleccionado -->
<table class="table table-striped table-hover" id='tabla-partes'>
    <thead>
      <tr>
        <th>TIPO</th>
        <th>REF</th>
        <th>TITULO</th>
        <th>FECHA</th>
        <th>INST</th>
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
            PARTES.id as parteid,
            TIPOS_PARTES.nombre,
            PARTES.ref,
            PARTES.titulo,
            PARTES.fecha,
            PARTES.instalacion,
            ESTADOS_PARTES.nombre 
        FROM 
            PARTES, TIPOS_PARTES, erp_users, ESTADOS_PARTES  
        WHERE 
            PARTES.tipo_parte_id = TIPOS_PARTES.id 
        AND
            PARTES.tecnico_id = erp_users.id
        AND 
            PARTES.parte_estado_id = ESTADOS_PARTES.id
        AND
            PARTES.proyecto_id = ".$_GET['id'];
    //file_put_contents("query.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de los Partes");
    
    while ($registros = mysqli_fetch_array($resultado)) {
        $id = $registros[0];
        $tipo = $registros[1];
        $ref = $registros[2];
        $titulo = $registros[3];
        $fecha = $registros[4];
        $instalacion = $registros[5];
        $estado = $registros[6];

        echo "
            <tr data-id='".$id."' class='parte'>
                <td>".$tipo."</td>
                <td>".$ref."</td>
                <td>".$titulo."</td>
                <td class='text-center'>".$fecha."</td>
                <td>".$instalacion."</td>
                <td class='text-center'>".$estado."</td>
            </tr>
        ";
    }

?>
        
    </tbody>
</table>

<!-- partes del proyecto seleccionado -->
