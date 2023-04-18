<!-- proyectos activos -->
<table class="table table-striped table-hover table-condensed" id='tabla-proyectos-nuevos' style="font-size: 9px !important;">
    <thead>
      <tr>
        <th>REF</th>
        <th>FECHA INICIO</th>
        <th>PROYECTO | CLIENTE</th>
        <th>CREADO</th>
      </tr>
    </thead>
    <tbody>
<?
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    if ($fechamod == 1) {
        $sql = "SELECT 
                PROYECTOS.id,
                PROYECTOS.ref,
                PROYECTOS.nombre,
                PROYECTOS.fecha_ini,
                PROYECTOS.fecha_entrega,
                PROYECTOS_ESTADOS.nombre, 
                CLIENTES.nombre, 
                CLIENTES.img,
                PROYECTOS_ESTADOS.color, 
                PROYECTOS.fecha_registro
            FROM 
                PROYECTOS, CLIENTES, PROYECTOS_ESTADOS 
            WHERE 
                PROYECTOS.cliente_id = CLIENTES.id
            AND 
                PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
            AND
                MONTH(PROYECTOS.fecha_registro) = MONTH(now())
            ORDER BY 
                PROYECTOS.fecha_mod DESC
            LIMIT 10";
    }
    else {
        $sql = "SELECT 
                    PROYECTOS.id,
                    PROYECTOS.ref,
                    PROYECTOS.nombre,
                    PROYECTOS.fecha_ini,
                    PROYECTOS.fecha_entrega,
                    PROYECTOS_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PROYECTOS_ESTADOS.color,
                    PROYECTOS.fecha_registro
                FROM 
                    PROYECTOS, CLIENTES, PROYECTOS_ESTADOS 
                WHERE 
                    PROYECTOS.cliente_id = CLIENTES.id
                AND 
                    PROYECTOS.estado_id = PROYECTOS_ESTADOS.id 
                AND
                    MONTH(PROYECTOS.fecha_registro) = MONTH(now())
                ORDER BY 
                    PROYECTOS.fecha_ini ASC
                LIMIT 10";
    }

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td>".$registros[3]."</td>
                <td>".$registros[2]."</td>
                <td>".$registros[9]."</td>
            </tr>
        ";
    }
?>

    </tbody>
</table>