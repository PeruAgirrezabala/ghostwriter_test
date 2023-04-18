<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['id'])) {   
    $html = "";
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
                    PROYECTOS.id = ".$_GET['id']."
                ORDER BY 
                    INTERVENCIONES.fecha DESC";
    
    

    //file_put_contents("array.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-partes-intervencion'>
                <thead>
                    <tr class='bg-dark'>
                        <th>REF</th>
                        <th>TITULO</th>
                        <th>CLIENTE</th>
                        <th>OFERTA</th>
                        <th>INSTALACIÓN</th>
                        <th class='text-center'>FECHA</th>
                        <th class='text-center'>TÉCNICO</th>
                        <th class='text-center'>ESTADO</th>
                    </tr>
                </thead>
                <tbody>";
    

    while( $row = mysqli_fetch_array($res) ) {
        $html .= "
                <tr data-id='".$row[0]."'>
                    <td>".$row[1]."</td>
                    <td>".$row[2]."</td>
                    <td>".$row[10]."</td>
                    <td>".$row[11]."</td>
                    <td>".$row[9]."</td>
                    <td class='text-center'>".$row[3]."</td>
                    <td class='text-center'>".$row[5]."</td>
                    <td class='text-center' ><span class='label label-".$row[8]."'>".$row[7]."</span></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    echo $html;
} //if isset btn_login

?>
<!-- /MATERIALES -->
