<!-- actividad erp -->
<table class="table table-striped table-hover" id="tabla-actividad">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>User</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
<?
    //include connection file 
    include_once("connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                erp_users.nombre,
                erp_activity.fecha,
                erp_activity.descripcion
            FROM 
                erp_users, erp_activity 
            WHERE 
                erp_activity.user_id = erp_users.id
            ORDER BY 
                erp_activity.fecha DESC
            LIMIT 20";

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Proyectos");
    
    while ($registros = mysqli_fetch_array($resultado)) { 
        echo "
            <tr>
                <td>".$registros[1]."</td>
                <td>".$registros[0]."</td>
                <td>".$registros[2]."</td>
            </tr>
        ";
    }
?>

    </tbody>
</table>

<!-- actividad erp -->