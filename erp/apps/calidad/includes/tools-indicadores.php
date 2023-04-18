<!-- tools doc admon -->
<div class="form-group form-group-tools">
    <button class="button" id="add-indicador" title="Crear Indicador"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="ver-indicadores-todos" title="Ver todos"><img src="/erp/img/ojo.png" height="20"></button>    
</div>

<!-- tools doc admon -->

<div id="indicador_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">INDICADOR</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_indicador">
                        <input type="hidden" value="" name="indicador_id" id="indicador_id">
                        <input type="hidden" value="" name="indicador_tienehijos" id="indicador_tienehijos">
                        <!-- Esto debe de ser un combo box!
                        <input type="hidden" value="" name="indicador_proceso_id" id="indicador_proceso_id"> -->
                        <div class="form-group">
                            <label class="labelBefore">Nombre: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="indicador_nombre" name="indicador_nombre">
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Objetivo: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="indicador_objetivo" name="indicador_objetivo" placeholder="Objetivo" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Proceso: <span class="requerido">*</span></label>
                            <select id="indicador_proceso_id" name="indicador_proceso_id" class="selectpicker" data-live-search="true">
                                <?php 
                                    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                    include_once($pathraiz."/connection.php");

                                    $db = new dbObj();
                                    $connString =  $db->getConnstring();

                                     $sql = "SELECT 
                                                CALIDAD_PROCESOS.id,
                                                CALIDAD_PROCESOS.year,
                                                CALIDAD_PROCESOS.nombre,
                                                CALIDAD_PROCESOS.responsable,
                                                CALIDAD_PROCESOS.dptos
                                            FROM CALIDAD_PROCESOS";
                                    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Docs Calidad Sistema");

                                    while ($registros = mysqli_fetch_array($resultado)) {
                                        $id = $registros[0];
                                        $year = $registros[1];
                                        $nombre = $registros[2];
                                        $responsable = $registros[3];
                                        $dptos = $registros[4];

                                        echo "<option id='proceso-".$id."' value=".$id.">".$nombre."</option>";

                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Calculo: <span class="requerido">*</span></label>
                            <textarea class="form-control" id="indicador_calculo" name="indicador_calculo" placeholder="Objetivo" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Valor Objetivo: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="indicador_valor" name="indicador_valor">
                        </div>
                        <!--<div class="form-group">
                            <label class="labelBefore">Operación: <span class="requerido">*</span></label>
                            <select id="indicador_proceso_id" name="indicador_proceso_id" class="selectpicker" data-live-search="true">
                                <option id='mayor' value=">">Mayor que</option>
                                <option id='mayorigual' value=">=">Mayor o igual que</option>
                                <option id='igual' value="=">Igual que</option>
                                <option id='menorigual' value="<=">Menor o igual que</option>
                                <option id='menor' value="<">Menor que</option>
                            </select>
                        </div>--><!--
                        <div class="form-group">
                            <label class="labelBefore">Meta: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="indicador_meta" name="indicador_meta" placeholder="Meta">
                        </div>-->
                        <div class="form-group" id="indicador_resultado_div">
                            <label class="labelBefore">Resultado: <span class="requerido">1/0</span></label>
                            <input type="text" class="form-control" id="indicador_resultado" name="indicador_resultado">
                        </div>
                        <!--
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Resultado: <span class="requerido">*</span></label>
                            <input class="form-control" id="indicador_resultado" name="indicador_resultado">
                        </div>
                        -->
                        <div class="form-group"></div>
                    </form>
                </div>
                <span class="stretch"></span>
                <div class="form-group">
                    <button type="button" id="btn_indicador_anteriores" class="btn btn-info2">Ver valores años anteriores</button>
                </div>
                <span class="stretch"></span>
                <div id="indicadores-anyos-anteriores" style="display: none">
                    <!-- <? //include($pathraiz."/apps/calidad/indicadoresAnyosAnteriores.php"); ?> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_indicador_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AÑADIR AÑOS ANTERIORES -->
<div id="indicador_add_anyos_anteriores_model" class="modal fade" tabindex="-1">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">INDICADOR</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_indicador_anyos_anteriores">
                        <input type="hidden" value="" name="indicador_anteriores_id" id="indicador_anteriores_id">
                        <div class="form-group">
                            <label class="labelBefore">Año: <span class="requerido">*</span></label>
                            <select id="indicador_anteriores_anyo" name="indicador_anteriores_anyo" class="selectpicker" data-live-search="true">
                                <?
                                for($i=2016;$i<=date("Y");$i++){
                                    echo "<option value=".$i.">".$i."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Valor: <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="indicador_anteriores_valor" name="indicador_anteriores_valor">
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="btnadd-indicador-anyos-anteriores" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>