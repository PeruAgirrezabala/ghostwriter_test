<!-- EQUIPOS -->

<table class="table table-hover" id="tabla-pcs">
    <thead>
        <tr>
            <th class="text-center">HOSTNAME</th>
            <th class="text-center">DESCRIPCION</th>
            <th class="text-center">PROYECTO</th>
            <th class="text-center">FECHA INI</th>
            <th class="text-center">TÉCNICO</th>
            <th class="text-center">IP</th>
            <th class="text-center">NET</th>
            <th class="text-center">ESTADO</th>
            <th class="text-center">DELETE</th>
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
                    EQUIPOS_TALLER.id,
                    EQUIPOS_TALLER.hostname,
                    EQUIPOS_TALLER.descripcion,
                    EQUIPOS_TALLER.proyecto_id,
                    EQUIPOS_TALLER.fecha_inicio,
                    PROYECTOS.nombre,
                    PROYECTOS.ref,
                    erp_users.nombre,
                    erp_users.apellidos,
                    erp_users.id,
                    ESTADOS_EQUIPOS.nombre,
                    ESTADOS_EQUIPOS.color
                FROM 
                    EQUIPOS_TALLER 
                LEFT JOIN PROYECTOS
                    ON EQUIPOS_TALLER.proyecto_id = PROYECTOS.id 
                LEFT JOIN erp_users 
                    ON EQUIPOS_TALLER.erpuser_id = erp_users.id 
                LEFT JOIN ESTADOS_EQUIPOS
                    ON EQUIPOS_TALLER.estado_id = ESTADOS_EQUIPOS.id
                ORDER BY 
                    EQUIPOS_TALLER.hostname ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Equipos");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $hostname = $registros[1];
            $descripcion = $registros[2];
            $proyecto_id = $registros[3];
            $fecha_ini = $registros[4];
            $proyecto = $registros[5];
            $proyectoref = $registros[6];
            $tecnico = $registros[7]." ".$registros[8];
            $tecnico_id = $registros[9];
            $estado = $registros[10];
            $estado_color = $registros[11];
            $botonRemove = "<button class='btn-default remove-pc' data-id='".$id."' title='Eliminar'><img src='/erp/img/remove.png' style='height: 20px;'></button>";
               
            echo "
                <tr data-id='".$id."' class='licencia'>
                    <td class='text-center hostnames'>".$hostname."</td>
                    <td class='text-left'>".$descripcion."</td>
                    <td class='text-left'>".$proyectoref." ".$proyecto."</td>
                    <td class='text-center'>".$fecha_ini."</td>
                    <td class='text-center'>".$tecnico."</td>
                    <td class='text-center pc-ip' style='background-color:#000000;color:#ffffff;'></td>
                    <td class='text-center pc-states'></td>
                    <td class='text-center'><span class='label label-".$estado_color."'>".$estado."</span></td>
                    <td class='text-center'>".$botonRemove."</td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- EQUIPOS -->

<div id="detallelic_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">EDITAR LICENCIA</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_new_lic">
                        <input type="hidden" class="form-control" id="newlicencia_idlic" name="newlicencia_idlic">
                        <div class="form-group">
                            <label class="labelBefore">Nombre:</label>
                            <input type="text" class="form-control" id="newlicencia_nombre" name="newlicencia_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Proyectos:</label>
                            <select id="newlicencia_proyectos" name="newlicencia_proyectos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Ubicación:</label>
                            <textarea class="form-control" id="newlicencia_ubicacion" name="newlicencia_ubicacion" placeholder="Ubicación donde esté activada" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="labelBeforeBlack">Trabajador:</label>
                            <select id="newlicencia_users" name="newlicencia_users" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="labelBefore">Fecha:</label>
                            <input type="date" class="form-control" id="newlicencia_fecha" name="newlicencia_fecha">
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Activada:</label>
                                <input type="checkbox" name="newlicencia_activada" id="newlicencia_activada" data-size="mini">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                    <div class="alert-middle alert alert-success alert-dismissable" id="newlicencia_success" style="display:none; margin: 0px auto 0px auto;">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <p>Lilcencia guardada</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_licencia" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>