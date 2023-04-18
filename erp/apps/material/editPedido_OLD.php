<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_POST['id'])) {    
    $sql = "SELECT 
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.ref,
                    PEDIDOS_PROV.titulo,
                    PEDIDOS_PROV.descripcion,
                    PEDIDOS_PROV.proveedor_id,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    PEDIDOS_PROV.tecnico_id,
                    PEDIDOS_PROV.proyecto_id,
                    PEDIDOS_PROV.estado_id, 
                    PEDIDOS_PROV.total 
                FROM 
                    PEDIDOS_PROV 
                WHERE 
                    id = ".$_POST["id"];
    
    $res = mysqli_query($connString, $sql) or die("database error:");
    $registros = mysqli_fetch_row($res);
            
    $sql = "SELECT 
                PEDIDOS_PROV_DETALLES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                PEDIDOS_PROV_DETALLES.unidades,
                MATERIALES_PRECIOS.pvp, 
                PEDIDOS_PROV_DETALLES.recibido,
                PEDIDOS_PROV_DETALLES.fecha_recepcion 
            FROM 
                PEDIDOS_PROV_DETALLES, MATERIALES, MATERIALES_PRECIOS 
            WHERE 
                PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
            AND 
                MATERIALES_PRECIOS.material_id = MATERIALES.id
            AND
                PEDIDOS_PROV_DETALLES.pedido_id = ".$registros[0]." 
            ORDER BY 
                PEDIDOS_PROV_DETALLES.id ASC";
    file_put_contents("array.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-detalles-pedidos'>
                <thead>
                  <tr>
                    <th>REF</th>
                    <th>MATERIAL</th>
                    <th>FABRICANTE</th>
                    <th>UNIDADES</th>
                    <th>PVP</th>
                    <th>IMPORTE</th>
                    <th>RECIBIDO</th>
                    <th>FECHA RECEPCION</th>
                  </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $html .= "
                <tr data-id='".$row[0]."'>
                    <td>".$row[1]."</td>
                    <td>".$row[2]."</td>
                    <td>".$row[3]."</td>
                    <td>".$row[4]."</td>
                    <td>".$row[5]."</td>
                        <td>".($row[4]*$row[5])."</td>
                    <td>".$row[6]."</td>
                    <td>".$row[7]."</td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    
    echo $html;
} //if isset btn_login

?>
