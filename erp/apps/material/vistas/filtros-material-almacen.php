<!-- filtros proyectos -->
<div class="one-column" id="materialalmacen-filterbar" style="background-color: #5cb85c;">
    <div class="form-group form-group-filtros">
        <label for="filter_material_ref" class="col-sm-1 control-label labelFiltros">Ref: </label>
        <div class="col-xs-2">
            <select id="filter_material_ref" name="filter_material_ref" class="selectpicker" data-live-search="true">
                <option></option>
            </select>
        </div>
        <label for="filter_material_nombre" class="col-sm-1 control-label labelFiltros">Material: </label>
        <div class="col-xs-3">
            <select id="filter_material_nombre" name="filter_material_nombre" class="selectpicker" data-live-search="true">
                <option></option>
            </select>
        </div>
    </div>
</div>
<div class="one-column">
    <h6>
        MATERIALES DEL ALMACEN
        <? include($pathraiz."/apps/proyectos/includes/tools-material-almacen.php"); ?>
    </h6>
    <hr class="dash-underline">
</div>  
<!-- filtros proyectos -->