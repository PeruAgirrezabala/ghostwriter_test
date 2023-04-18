<!-- filtros proyectos -->
<div class="form-group form-group-filtros">
    <label for="filter_formacion_years" class="col-sm-1 control-label labelFiltros">
        Año Formación: 
        <span>
            <img class="infoicon" src="/erp/img/info_ico_16.png" title="Año de formación. NO del trabajador." style="height: 12px; margin-top: -20px;" />
        </span>
    </label>
    <div class="col-xs-1">
        <select id="filter_formacion_years" name="filter_formacion_years" class="selectpicker" data-live-search="true">
            <option value=""></option>
            <? 
                for($i=2019;$i<=date("Y")+1;$i++){
                    echo "<option value='".$i."'>".$i."</option>";
                }
            ?>
        </select>
    </div>
    <label for="filter_formacion_nombre" class="col-sm-1 control-label labelFiltros">Formacion: </label>
    <div class="col-xs-2">
        <select id="filter_formacion_nombre" name="filter_formacion_nombre" class="selectpicker" data-live-search="true">
            <option value=""></option>
            <?php 
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");
                //include($pathraiz."/config.php");

                $db = new dbObj();
                $connString =  $db->getConnstring();

                $sql = "SELECT 
                            CALIDAD_FORMACION.id,
                            CALIDAD_FORMACION.nombre
                        FROM 
                            CALIDAD_FORMACION";
                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de CALIDAD_FORMACION");

                while ($registros = mysqli_fetch_array($resultado)) {
                    $id = $registros[0];
                    $nombre = $registros[1];

                    echo "<option id='tecnicos_formacion_".$id."' value=".$id.">".$nombre."</option>";

                }
            ?>
        </select>
    </div>
    <label for="filter_formacion_nombre" class="col-sm-1 control-label labelFiltros">Técnico: </label>
    <div class="col-xs-2">
        <select id="filter_formacion_users" name="filter_formacion_users" class="selectpicker" data-live-search="true">
            <option value=""></option>
            <?php 
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");
                //include($pathraiz."/config.php");

                $db = new dbObj();
                $connString =  $db->getConnstring();

                $sql = "SELECT 
                            erp_users.id,
                            erp_users.nombre,
                            erp_users.apellidos
                        FROM 
                            erp_users
                        ORDER BY nombre ASC";
                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de CALIDAD_FORMACION");

                while ($registros = mysqli_fetch_array($resultado)) {
                    $id = $registros[0];
                    $nombre = $registros[1];
                    $apellidos = $registros[2];

                    echo "<option value=".$id.">".$nombre." ".$apellidos."</option>";

                }
            ?>
        </select>
    </div>
    <label for="filter_formacion_years" class="col-sm-1 control-label labelFiltros">
        Año Formación Tec.: 
        <span>
            <img class="infoicon" src="/erp/img/info_ico_16.png" title="Año de formación del técnico. NO de la formación." style="height: 12px; margin-top: -20px;" />
        </span>
    </label>
    <div class="col-xs-1">
        <select id="filter_formacion_yearsuser" name="filter_formacion_yearsuser" class="selectpicker" data-live-search="true">
            <option value=""></option>
            <? 
                for($i=2019;$i<=date("Y")+1;$i++){
                    echo "<option value='".$i."'>".$i."</option>";
                }
            ?>
        </select>
    </div>    
</div>

<!-- filtros proyectos -->