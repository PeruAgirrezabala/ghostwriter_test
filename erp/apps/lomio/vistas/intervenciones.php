<!-- proyectos activos -->
<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $limit = 10;
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                    INTERVENCIONES.id,
                    INTERVENCIONES.ref,
                    INTERVENCIONES.nombre,
                    INTERVENCIONES.fecha,
                    INTERVENCIONES.fecha_mod,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    INTERVENCIONES_ESTADOS.nombre, 
                    INTERVENCIONES_ESTADOS.color,
                    INTERVENCIONES.instalacion,
                    CLIENTES.nombre,
                    OFERTAS.titulo
                FROM 
                    INTERVENCIONES
                LEFT JOIN CLIENTES
                    ON CLIENTES.id = INTERVENCIONES.cliente_id
                INNER JOIN INTERVENCIONES_ESTADOS
                    ON INTERVENCIONES.estado_id = INTERVENCIONES_ESTADOS.id 
                INNER JOIN erp_users 
                    ON INTERVENCIONES.tecnico_id = erp_users.id 
                LEFT JOIN OFERTAS
                    ON OFERTAS.id = INTERVENCIONES.oferta_id 
                LEFT JOIN PROYECTOS
                    ON INTERVENCIONES.proyecto_id = PROYECTOS.id  
                WHERE
                    erp_users.id = ".$_SESSION['user_session']." 
                ORDER BY 
                    INTERVENCIONES.fecha DESC";
    file_put_contents("queryInt.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Intervenciones");
    $numregistros = mysqli_num_rows($resultado);
    $numpaginas = ceil($numregistros/$limit);
    
    $sql = "SELECT 
                    INTERVENCIONES.id,
                    INTERVENCIONES.ref,
                    INTERVENCIONES.nombre,
                    INTERVENCIONES.fecha,
                    INTERVENCIONES.fecha_mod,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    INTERVENCIONES_ESTADOS.nombre, 
                    INTERVENCIONES_ESTADOS.color,
                    INTERVENCIONES.instalacion,
                    A.nombre,
                    OFERTAS.titulo,
                    B.nombre,
                    B.img
                FROM 
                    INTERVENCIONES
                LEFT JOIN CLIENTES A
                    ON A.id = INTERVENCIONES.cliente_id
                INNER JOIN INTERVENCIONES_ESTADOS
                    ON INTERVENCIONES.estado_id = INTERVENCIONES_ESTADOS.id 
                INNER JOIN erp_users 
                    ON INTERVENCIONES.tecnico_id = erp_users.id 
                LEFT JOIN OFERTAS
                    ON OFERTAS.id = INTERVENCIONES.oferta_id 
                LEFT JOIN PROYECTOS
                    ON INTERVENCIONES.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES B
                    ON B.id = PROYECTOS.cliente_id 
                WHERE 
                    erp_users.id = ".$_SESSION['user_session']." 
                ORDER BY 
                    INTERVENCIONES.fecha DESC";
    
    file_put_contents("queryIntervenciones.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Intervenciones");
    
    
?>
<table class="table table-striped table-hover table-condensed" id='tabla-int' style='font-size: 9px !important;'>
    <thead>
      <tr>
        <th>REF</th>
        <th>TITULO</th>
        <th>CLIENTE</th>
        <th>OFERTA</th>
        <th style="min-width: 35%;">PROYECTO | CLIENTE</th>
        <th>INSTALACIÓN</th>
        <th class="text-center">FECHA</th>
        <th class="text-center">TÉCNICO</th>
        <th class="text-center">ESTADO</th>
      </tr>
    </thead>
    <tbody>
<?
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr data-id='".$registros[0]."'>
                <td>".$registros[1]."</td>
                <td>".$registros[2]."</td>
                <td>".$registros[10]."</td>
                <td>".$registros[11]."</td>
                <td>
                    <div class='tabla-img'>
                        <img src='".$registros[13]."'>
                    </div> 
                    <div class='tabla-texto'>
                        ".$registros[6]."<span class='bajotexto'>".$registros[12]."</span>
                    </div>
                </td>
                <td>".$registros[9]."</td>
                <td class='text-center'>".$registros[3]."</td>
                <td class='text-center'>".$registros[5]."</td>
                <td class='text-center' ><span class='label label-".$registros[8]."'>".$registros[7]."</span></td>
            </tr>
        ";
    }
?>

    </tbody>
</table>

<? echo $pagination; ?>

