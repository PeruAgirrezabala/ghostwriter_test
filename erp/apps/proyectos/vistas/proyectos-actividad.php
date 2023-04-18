<!-- proyectos activos -->
<table class="table table-striped table-hover">
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
                erp_activity.fecha DESC";

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

<div id="programar_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">PROGRAMAR PARTIDO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="partido_id" id="partido_id">

                    <div class="form-group">
                        <div class="col-xs-6">
                            <label class="labelBeforeBlack">Fecha:</label>
                            <input type="datetime-local" class="form-control" id="partido_fecha" name="partido_fecha">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="labelBeforeBlack">Lugar:</label>
                        <input type="text" class="form-control" id="partido_lugar" name="partido_lugar">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_programar" class="btn btn-info">Programar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- mispartidos -->