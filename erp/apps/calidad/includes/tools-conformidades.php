<!-- tools doc admon -->
<div class="form-group form-group-tools">
    <button class="button" id="add-conformidad" title="Crear No Conformidad"><img src="/erp/img/add.png" height="20"></button>
    <button class="button" id="clean-filters" title="Limpiar Filtros"><img src="/erp/img/clean.png" height="20"></button>
</div>
<span class="stretch"></span>
<div id="proyectos-filterbar" class="one-column">
     <? include($pathraiz."/apps/calidad/vistas/filtros.php"); ?>
</div>
<!-- tools doc admon -->

<div id="conformidad_add_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">NO CONFORMIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_conformidad">
                        <input type="hidden" value="" name="conformidad_id" id="conformidad_id">

                        <div class="form-group" hidden>
                            <label class="labelBefore">REF:</label>
                            <input type="text" class="form-control" id="conformidad_nombre" name="conformidad_nombre">
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Detectado por: <span class="requerido">*</span></label>
                            <select id="conformidad_detectado1" name="conformidad_detectado1" class="selectpicker" data-live-search="true" data-width="33%">
                                <option value="genelek">Genelek</option>
                                <option value="cliente">Cliente</option>
                                <option value="proveedor">Proveedor</option>
                                <option value="auditor">Auditor</option>
                            </select>
                            <div class="form-group"></div>
                            <select id="conformidad_detectado_genelek" name="conformidad_detectado_genelek" class="selectpicker" data-live-search="true" data-width="33%">
                                <?php 
                                    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                    include_once($pathraiz."/connection.php");

                                    $db = new dbObj();
                                    $connString =  $db->getConnstring();

                                     $sql = "SELECT 
                                                erp_users.id,
                                                erp_users.nombre,
                                                erp_users.apellidos
                                            FROM erp_users";
                                    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de USUARIOS_ERP");

                                    while ($registros = mysqli_fetch_array($resultado)) {
                                        $id = $registros[0];
                                        $nombre = $registros[1];
                                        $apellido = $registros[2];

                                        echo "<option id='detectado_genelek_".$id."' value=".$id.">".$nombre." ".$apellido."</option>";

                                    }
                                ?>
                            </select>
                            <select id="conformidad_detectado_cliente" name="conformidad_detectado_cliente" class="selectpicker" data-live-search="true" data-width="33%">
                                <?php 
                                    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                    include_once($pathraiz."/connection.php");

                                    $db = new dbObj();
                                    $connString =  $db->getConnstring();

                                     $sql = "SELECT 
                                                CLIENTES.id,
                                                CLIENTES.nombre
                                            FROM CLIENTES";
                                    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Docs Calidad Sistema");

                                    while ($registros = mysqli_fetch_array($resultado)) {
                                        $id = $registros[0];
                                        $nombre = $registros[1];

                                        echo "<option id='detectado_cliente_".$id."' value=".$id.">".$nombre."</option>";

                                    }
                                ?>
                            </select>
                            <select id="conformidad_detectado_proveedor" name="conformidad_detectado_proveedor" class="selectpicker" data-live-search="true" data-width="33%">
                                <?php 
                                    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                    include_once($pathraiz."/connection.php");

                                    $db = new dbObj();
                                    $connString =  $db->getConnstring();

                                     $sql = "SELECT 
                                                PROVEEDORES.id,
                                                PROVEEDORES.nombre
                                            FROM PROVEEDORES";
                                    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Docs Calidad Sistema");

                                    while ($registros = mysqli_fetch_array($resultado)) {
                                        $id = $registros[0];
                                        $nombre = $registros[1];

                                        echo "<option id='detectado_proveedor_".$id."' value=".$id.">".$nombre."</option>";
                                    }
                                ?>
                            </select>
                            <select id="conformidad_detectado_auditor" name="conformidad_detectado_auditor" class="selectpicker" data-live-search="true" data-width="33%">
                                <?php 
                                    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                                    include_once($pathraiz."/connection.php");

                                    $db = new dbObj();
                                    $connString =  $db->getConnstring();

                                     $sql = "SELECT 
                                                AUDITORES.id,
                                                AUDITORES.nombre
                                            FROM AUDITORES";
                                    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de AUDITORES");

                                    while ($registros = mysqli_fetch_array($resultado)) {
                                        $id = $registros[0];
                                        $nombre = $registros[1];

                                        echo "<option id='detectado_auditor_".$id."' value=".$id.">".$nombre."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="labelBefore">Proyecto: <span class="requerido">*</span></label>
                            <select id="conformidad_proyectos" name="conformidad_proyectos" class="selectpicker" data-live-search="true" data-width="33%">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Detectado:</label>
                                <input type="date" class="form-control" id="conformidad_fecha" name="conformidad_fecha">
                            </div>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Descripción:</label>
                            <textarea class="form-control" id="conformidad_desc" name="conformidad_desc" placeholder="Descripción" rows="5"></textarea>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Resolución:</label>
                            <textarea class="form-control" id="conformidad_resolucion" name="conformidad_resolucion" placeholder="Resolución" rows="5"></textarea>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Causa:</label>
                            <textarea class="form-control" id="conformidad_causa" name="conformidad_causa" placeholder="Causa" rows="5"></textarea>
                        </div>
                        <div class="form-group form-group-view">
                            <label class="labelBefore">Cierre:</label>
                            <textarea class="form-control" id="conformidad_cierre" name="conformidad_cierre" placeholder="Cierre" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBefore">Fecha Cierre:</label>
                                <input type="date" class="form-control" id="conformidad_fecha_cierre" name="conformidad_fecha_cierre">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_conformidad_save" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>