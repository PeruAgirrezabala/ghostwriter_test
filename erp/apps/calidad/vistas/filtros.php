<!-- filtros proyectos -->
<div class="form-group form-group-filtros">
    <label for="filter_conformidades_years" class="col-sm-1 control-label labelFiltros">Año: </label>
    <div class="col-xs-1">
        <select id="filter_conformidades_years" name="filter_conformidades_years" class="selectpicker" data-live-search="true">
            <option value=""></option>
            <? 
                for($i=2016;$i<=date("Y")+1;$i++){
                    echo "<option value='".$i."'>".$i."</option>";
                }
            ?>
        </select>
    </div>
    <label for="filter_conformidades_mes" class="col-sm-1 control-label labelFiltros">Mes: </label>
    <div class="col-xs-1">
        <select id="filter_conformidades_mes" name="filter_conformidades_mes" class="selectpicker" data-live-search="true">
            <option value=""></option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
    </div>
    <label for="filter_pedidos" class="col-sm-1 control-label labelFiltros">Detectado: </label>
    <div class="col-xs-2">
        <select id="filter_conformidades_detectado" name="filter_conformidades_detectado" class="selectpicker" data-live-search="true">
            <option value=""></option>
            <option value="genelek">Genelek</option>
            <option value="cliente">Cliente</option>
            <option value="proveedor">Proveedor</option>
            <option value="auditor">Auditor</option>
        </select>
    </div>
    <label for="filter_proveedores" class="col-sm-1 control-label labelFiltros">Por: </label>
    <div class="col-xs-3">
        <select id="filter_conformidades_por_" name="filter_conformidades_por_" class="selectpicker" data-live-search="true">
            <option value=""></option>
        </select>
        <select id="filter_conformidades_por_genelek" name="filter_conformidades_por_genelek" class="selectpicker" data-live-search="true">
            <option value=""></option>
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
        <select id="filter_conformidades_por_cliente" name="filter_conformidades_por_cliente" class="selectpicker" data-live-search="true">
            <option value=""></option>
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
        <select id="filter_conformidades_por_proveedor" name="filter_conformidades_por_proveedor" class="selectpicker" data-live-search="true">
            <option value=""></option>
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
        <select id="filter_conformidades_por_auditor" name="filter_conformidades_por_auditor" class="selectpicker" data-live-search="true">
            <option value=""></option>
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
    <label for="filter_proyecto" class="col-sm-1 control-label labelFiltros">Proyecto: </label>
    <div class="col-xs-2">
        <select id="filter_conformidades_proyecto" name="filter_conformidades_proyecto" class="selectpicker" data-live-search="true">
            <option value=""></option>
            <?php 
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");

                $db = new dbObj();
                $connString =  $db->getConnstring();

                $sql = "SELECT 
                            PROYECTOS.id,
                            PROYECTOS.nombre
                        FROM PROYECTOS";
                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Docs Calidad Sistema");

                while ($registros = mysqli_fetch_array($resultado)) {
                    $id = $registros[0];
                    $nombre = $registros[1];

                echo "<option id='detectado_proveedor_".$id."' value=".$id.">".$nombre."</option>";
                }
            ?>
        </select>
    </div>
    <div class="col-xs-1">
        
    </div>
</div>

<!-- filtros proyectos -->