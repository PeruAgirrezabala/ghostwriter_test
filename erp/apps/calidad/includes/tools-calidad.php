<!-- tools crear proceso -->
<div class="form-group form-group-tools">
    <button class="button" id="add-sistema-calidad" title="Crear Sistema de Calidad"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="ver-sistema-calidad-todos" title="Ver todos"><img src="/erp/img/ojo.png" height="20"></button>
</div>
<!-- tools crear proceso -->

<div id="calidad_sistema_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">FICHA DE CALIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_calidad_sistema">
                        <input type="hidden" value="" name="calidad_sistema_id" id="calidad_sistema_id">

                        <div class="form-group">
                            <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="calidad_sistema_nombre" name="calidad_sistema_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Organismo: <span class="requerido">*</span></label>
                            <select id="calidad_sistema_organismo" name="calidad_sistema_organismo" class="selectpicker" data-live-search="true">
                                <?php 
                                    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                    include_once($pathraiz."/connection.php");

                                    $db = new dbObj();
                                    $connString =  $db->getConnstring();

                                     $sql = "SELECT 
                                                ORGANISMOS.id,
                                                ORGANISMOS.nombre
                                            FROM ORGANISMOS";
                                    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Organismos");

                                    while ($registros = mysqli_fetch_array($resultado)) {
                                        $id = $registros[0];
                                        $nombre = $registros[1];

                                        echo "<option id='proceso-".$id."' value=".$id.">".$nombre."</option>";

                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Habilitado:</label>
                            <input type="checkbox" name="calidad_sistema_habilitado" id="calidad_sistema_habilitado" checked data-size="mini">
                            <input type="text" name="txt_habilitado" id="txt_habilitado" hidden>                            
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="labelBefore">Habilitado:</label>
                            <input class='form-control' name='calidad_sistema_habilitado' type='checkbox' title='Activar Desactivar Sistema' id='calidad_sistema_habilitado'>
                            <span class="requerido" id="aviso_desactivar_calidad_sistema">Atención: Desapecerá de la vista pero no de la base de datos</span>
                        </div>
                        -->
                        <span class="stretch"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_sistema_calidad_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!--* Visualizar TODOS Calidad Sistema *-->
<div id="SistemaCal_todos_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">SISTEMA CALIDAD TODOS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_SisCalidad">
                        <table class="table table-striped table-hover" id='tabla-siscal-todos'>
                            <thead>
                                <tr class="bg-dark">
                                    <th class="text-center">E</th>
                                    <th class="text-center">NOMBRE</th>
                                    <th class="text-center">ORG</th>
                                    <th class="text-center">V</th>
                                    <th class="text-center">HABI</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?

                                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                include_once($pathraiz."/connection.php");

                                $db = new dbObj();
                                $connString =  $db->getConnstring();

                                $sql = "SELECT 
                                            CALIDAD_SISTEMA.id,
                                            CALIDAD_SISTEMA.nombre,
                                            CALIDAD_SISTEMA.organismo_id,
                                            ORGANISMOS.nombre,
                                            CALIDAD_SISTEMA.doc_path,
                                            CALIDAD_SISTEMA.habilitado
                                        FROM 
                                            CALIDAD_SISTEMA, ORGANISMOS
                                        WHERE
                                            CALIDAD_SISTEMA.organismo_id=ORGANISMOS.id";
                                file_put_contents("selectCalidadSistema.txt", $sql);
                                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Calidad Sistema");

                                while ($registros = mysqli_fetch_array($resultado)) {
                                    $id = $registros[0];
                                    $nombre = $registros[1];
                                    $organismo_id = $registros[2];
                                    $organismo = $registros[3];
                                    $doc_path = $registros[4];
                                    $habilitado = $registros[5];

                                    if($doc_path=="" or $doc_path==null){
                                        $farolillo="<span class='dot-grey''></span>";
                                    }else{
                                        $farolillo="<span class='dot-green''></span>";
                                    }

                                    if($habilitado=="on"){
                                        $habi_pint="<span class='label label-success'>SI</span>";
                                    }else{
                                        $habi_pint="<span class='label label-danger'>NO</span>";
                                    }

                                    echo "<tr data-id=".$id.">
                                            <td class='text-center'>".$farolillo."</td>
                                            <td style='text-align:center;'>".$nombre."</td> 
                                            <td class='text-center'>".$organismo."</td>
                                            <td class='text-center'><a href='".$doc_path."' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                                            <td class='text-center'>".$habi_pint."</td>    
                                        </tr>";

                                }    
                                echo " </tbody></table>";  
                                ?>
                    </form>
                </div>
            </div>
            <!--
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_pedidodetalle_save" class="btn btn-primary">Guardar</button>
                
            </div>
            -->
        </div>
    </div>
</div>
<div id="siscal_cambiar_habilitado" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <input type="hidden" value="" name="calsis_id" id="calsis_id">
                    <div class="form-group">
                        <label class="labelBefore">¿Estas seguro de que deseas cambiar el estado del documento?</label>
                    </div>
                    <div class="form-group"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_siscal_habil" data-id="" class="btn btn-info2">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>