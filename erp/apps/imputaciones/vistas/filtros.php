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
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
            <option value="2028">2028</option>
            <option value="2029">2029</option>
            <option value="2030">2030</option>
            <option value="2031">2031</option>
            <option value="2032">2032</option>
            <option value="2033">2033</option>
            <option value="2034">2034</option>
            <option value="2035">2035</option>
            <option value="2036">2036</option>
            <option value="2037">2037</option>
            <option value="2038">2038</option>
            <option value="2039">2039</option>
            <option value="2040">2040</option>
            <option value="2041">2041</option>
            <option value="2042">2042</option>
            <option value="2043">2043</option>
            <option value="2044">2044</option>
            <option value="2045">2045</option>
            <option value="2046">2046</option>
            <option value="2047">2047</option>
            <option value="2048">2048</option>
            <option value="2049">2049</option>
            <option value="2050">2050</option>
            <option value="2051">2051</option>
            <option value="2052">2052</option>
            <option value="2053">2053</option>
            <option value="2054">2054</option>
            <option value="2055">2055</option>
            <option value="2056">2056</option>
            <option value="2057">2057</option>
            <option value="2058">2058</option>
            <option value="2059">2059</option>
            <option value="2060">2060</option>
            <option value="2061">2061</option>
            <option value="2062">2062</option>
            <option value="2063">2063</option>
            <option value="2064">2064</option>
            <option value="2065">2065</option>
            <option value="2066">2066</option>
            <option value="2067">2067</option>
            <option value="2068">2068</option>
            <option value="2069">2069</option>
            <option value="2070">2070</option>
            <option value="2071">2071</option>
            <option value="2072">2072</option>
            <option value="2073">2073</option>
            <option value="2074">2074</option>
            <option value="2075">2075</option>
            <option value="2076">2076</option>
            <option value="2077">2077</option>
            <option value="2078">2078</option>
            <option value="2079">2079</option>
            <option value="2080">2080</option>
            <option value="2081">2081</option>
            <option value="2082">2082</option>
            <option value="2083">2083</option>
            <option value="2084">2084</option>
            <option value="2085">2085</option>
            <option value="2086">2086</option>
            <option value="2087">2087</option>
            <option value="2088">2088</option>
            <option value="2089">2089</option>
            <option value="2090">2090</option>
            <option value="2091">2091</option>
            <option value="2092">2092</option>
            <option value="2093">2093</option>
            <option value="2094">2094</option>
            <option value="2095">2095</option>
            <option value="2096">2096</option>
            <option value="2097">2097</option>
            <option value="2098">2098</option>
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