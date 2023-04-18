<!-- Hitos de Trabajo -->

<div class="alert-middle alert alert-success alert-dismissable" id="hitos_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Hito guardado</p>
</div>

<table class="table table-striped table-hover" id='tabla-hitos'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">E</th>
            <th>HITO</th>
            <th class="text-center">FECHA ENTREGA</th>
            <th class="text-center">FECHA REALIZACION</th>
            <th class="text-center">TÉCNICO</th>
            <th class="text-center"></th>
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
                    PROYECTOS_HITOS.id as hito,
                    PROYECTOS_HITOS.nombre,
                    PROYECTOS_HITOS.descripcion,
                    PROYECTOS_HITOS.fecha_entrega,
                    PROYECTOS_HITOS.fecha_realizacion,
                    PROYECTOS_HITOS.observaciones,
                    HITOS_ESTADOS.nombre,
                    HITOS_ESTADOS.color,
                    erp_users.nombre,
                    erp_users.apellidos 
                FROM 
                    PROYECTOS 
                INNER JOIN PROYECTOS_HITOS
                    ON PROYECTOS_HITOS.proyecto_id = PROYECTOS.id 
                INNER JOIN HITOS_ESTADOS
                    ON PROYECTOS_HITOS.estado_id = HITOS_ESTADOS.id 
                LEFT JOIN erp_users  
                    ON PROYECTOS_HITOS.erpuser_id = erp_users.id 
                WHERE 
                    PROYECTOS.id = ".$_GET['id']."
                ORDER BY 
                    PROYECTOS_HITOS.id ASC";

        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Hitos");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $proyecto_id = $_GET['id'];
            $idHIT = $registros[0];
            $nombreHIT = $registros[1];
            $descHIT = $registros[2];
            $fecha_entrega = $registros[3];
            $fecha_realizacion = $registros[4];
            $observ = $registros[5];
            $estado = $registros[6];
            $estado_color = $registros[7];
            $tecnicoNombre = $registros[8];
            $tecnicoApellidos = $registros[9];
            
            echo "
                <tr data-id='".$idHIT."' class='oferta'>
                    <td class='text-center'><span class='label label-".$estado_color."'>".$estado."</span></td>
                    <td class='text-left'>".$nombreHIT."</td>
                    <td class='text-center'>".$fecha_entrega."</td>
                    <td class='text-center'>".$fecha_realizacion."</td>
                    <td class='text-center'>".$tecnicoNombre." ".$tecnicoApellidos."</td>
                    <td class='text-center'><button class='btn-default remove-hito' data-id='".$idHIT."'><img src='/erp/img/remove.png' style='height: 20px;'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>

<div id="hito_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CREAR HITO</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_edit_hito">
                        <input type="hidden" value="" name="hito_detalle_id" id="hito_detalle_id">
                        <input type="hidden" value="<? echo $_GET["id"]; ?>" name="hito_proyecto_id" id="hito_proyecto_id">
                        <input type="hidden" value="" name="hito_deldetalle" id="hito_deldetalle">

                        <div class="form-group">
                            <label class="labelBeforeBlack">Título:</label>
                            <input type="text" class="form-control" id="hito_nombre" name="hito_nombre">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBeforeBlack">Descripción:</label>
                            <textarea class="form-control" id="hito_descripcion" name="hito_descripcion" placeholder="Descripción del Hito" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBeforeBlack">Fecha Entrega:</label>
                                <input type="date" class="form-control" id="hito_fecha_entrega" name="hito_fecha_entrega">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBeforeBlack">Fecha Realización:</label>
                                <input type="date" class="form-control" id="hito_fecha_realizacion" name="hito_fecha_realizacion">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Técnico:</label>
                                <select id="hito_tecnicos" name="hito_tecnicos" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label class="labelBeforeBlack">Estado:</label>
                                <select id="hito_estados" name="hito_estados" class="selectpicker" data-live-search="true" data-width="33%">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Observaciones:</label>
                            <textarea class="form-control" id="hito_observ" name="hito_observ" placeholder="Observaciones" rows="8"></textarea>
                        </div>
                        
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_hito_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Hitos de Trabajo -->