<!-- ofertas seleccionado -->

<div id="grafico-view">
    <div id="chart_container" style="width: 65%; margin: 0px auto 0px auto;">
        <canvas id="proyecto-chart"></canvas>
    </div>
</div>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px; margin-top: 10px;">
    <div class="col-sm-3" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='total_gastos' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteOtros, 2, ',', '.'); ?> €</label></div>
</div>

<!-- grafico oferta -->