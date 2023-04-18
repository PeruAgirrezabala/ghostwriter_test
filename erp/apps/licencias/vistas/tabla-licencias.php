<!-- DOC Admon -->

<table class="table table-hover" id="tabla-licencias">
    <thead>
        <tr>
            <th class="text-center">LICENCIA</th>
            <th class="text-center">PROYECTO</th>
            <th class="text-left">UBICACIÓN</th>
            <th class="text-center">USUARIO</th>
            <th class="text-center">FECHA</th>
            <th class="text-center">ESTADO</th>
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
                    LICENCIAS.id,
                    LICENCIAS.nombre,
                    LICENCIAS.ubicacion,
                    LICENCIAS.user_id,
                    LICENCIAS.fecha,
                    LICENCIAS.activada, 
                    erp_users.nombre,
                    erp_users.apellidos,
                    PROYECTOS.nombre,
                    PROYECTOS.REF
                FROM 
                    LICENCIAS 
                LEFT JOIN erp_users
                    ON LICENCIAS.user_id = erp_users.id 
                LEFT JOIN PROYECTOS
                    ON LICENCIAS.proyecto_id = PROYECTOS.id 
                ORDER BY 
                    LICENCIAS.nombre ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Licencias");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $nombreLic = $registros[1];
            $ubicacion = $registros[2];
            $user_id = $registros[3];
            $fecha = $registros[4];
            $activada = $registros[5];
            $nombreuser = $registros[6]." ".$registros[7];
            $proyecto = $registros[8];
            $proyectoref = $registros[9];
                 
            if ($activada == 1) {
                $label = "danger";
                $text = "Activada";
                $boton = "<button class='btn-default unlock-lic' data-id='".$id."' title='Desbloquear' ".$disableButton."><img src='/erp/img/unlock.png' style='height: 20px;'></button>";
            }
            else {
                $label = "success";
                $text = "Libre";
                $boton = "";
            }
            
            echo "
                <tr data-id='".$id."' class='licencia'>
                    <td class='text-center'>".$nombreLic."</td>
                    <td class='text-left'>".$proyectoref." ".$proyecto."</td>
                    <td class='text-left'>".$ubicacion."</td>
                    <td class='text-center'>".$nombreuser."</td>
                    <td class='text-center'>".$fecha."</td>
                    <td class='text-center'><span class='label label-".$label."'>".$text."</span></td>
                    <td class='text-center'>".$boton."</td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<!-- DOC Admon -->

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
                <button type="button" class="btn btn-default" id="vaciar_licencia" title="Vaciar Licencia"><img src="/erp/img/bin.png" height="20"></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>