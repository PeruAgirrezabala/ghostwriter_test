<!-- filtros accesos -->
<div class="form-group form-group-filtros">
    <? 
        if ($_SESSION['user_rol'] == "SUPERADMIN") {
    ?>
    <label for="filter_trabajadores" class="col-sm-1 control-label labelFiltros">Trabajadores: </label>
    <div class="col-xs-3">
        <select id="filter_trabajadores" name="filter_trabajadores" class="selectpicker" data-live-search="true">
            <option></option>
        </select>
    </div>
    <?
        }
    ?>
    <label for="filter_mes" class="col-sm-1 control-label labelFiltros">Año: </label>
    <div class="col-xs-1">
        <select id="filter_year" name="filter_year" class="selectpicker" data-live-search="true">
            <?
                $anoIni = 2019;
                $yearNum  = date('Y');
                for($anoIni; $anoIni <= $yearNum+1 ;$anoIni++){
                    echo '<option value="'.$anoIni.'">'.$anoIni.'</option>';
                }
            ?>
        </select>
    </div>
    <label for="filter_mes" class="col-sm-1 control-label labelFiltros">Mes: </label>
    <div class="col-xs-3">
        <select id="filter_mes" name="filter_mes" class="selectpicker" data-live-search="true">
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>
    </div>
</div>
<!-- filtros accesos -->