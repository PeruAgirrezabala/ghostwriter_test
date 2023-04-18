<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    include("../../../common.php");
    
    
    if ($_GET['tipo_prevision'] != "") {
        $filtro=" AND PREVISIONES.tipo_prev=".$_GET['tipo_prevision'];
    }
    else {
        $filtro="";
    }
    
    if ($_GET['tecnico'] != "") {
        $filtro.=" AND PREVISIONES_TECNICOS.erpuser_id=".$_GET['tecnico'];
        $join=" INNER JOIN PREVISIONES_TECNICOS ON PREVISIONES.id=PREVISIONES_TECNICOS.prevision_id";
    }
    else {
        $filtro.="";
        $join="";
    }
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $diasdelasemana = array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
    $mesesdelano = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Dicciembre");
    $diadelasemana = 0; // 1-7
    $mesdelano = 0; // 1-12
    
    $currentyear = $_GET["year"];
    $currentmounth = $_GET["mes"];
    $currentday = date("d");
    
    if($currentmounth==""){
        $currentmounth=date("m");
    }
    
    // Cargar Opciones meses
//    for($i=0;$i<12;$i++){
//        $mesesOpciones.='<option value='.$i.'>'.$mesesdelano[$i].'</option>';
//    }
    
//    $tohtml='<div class="one-column">
//                <div class="form-group form-group-calendario-meses">
//                    <div class="col-md-2">
//                        <ul class="pagination">
//                            <li class="page-item"><a class="calendar-link" data-id="1" href="#">Año</a></li>
//                            <li class="page-item"><a class="calendar-link" data-id="2" href="#">Mes</a></li>
//                            <li class="page-item"><a class="calendar-link" data-id="3" href="#">Semana</a></li>
//                            <li class="page-item"><a class="calendar-link" data-id="4" href="#">Día</a></li>
//                        </ul>
//                    </div>
//                    <div class="col-md-2"></div>
//                    <div class="col-md-1" style="margin-top:15px">
//                        <button class="button" style="float:right;"><img src="/erp/img/anterior.png" height="28"></button>
//                    </div>
//                    <div class="col-md-2" style="margin-top:15px">
//                        <select id="calendario_mes" name="calendario_mes" class="selectpicker" data-live-search="true">
//                            '.$mesesOpciones.'
//                        </select>
//                    </div>
//                    <div class="col-md-1" style="margin-top:15px">
//                        <button class="button" style="float:left;"><img src="/erp/img/siguiente.png" height="28"></button>
//                    </div>
//                    <div class="col-md-4"></div>
//                </div>
//            </div>
//            <br/>';
    $tohtml .='<div class="modal-header"><h3>Mes: '.$mesesdelano[($currentmounth-1)].'</h3></div>';
    $tohtml .= '<table class="table" id="tabla-previsiones-calendario">
    <thead>
      <tr class="bg-dark">
        <th class="text-center" style="width:14%">LUNES</th>
        <th class="text-center" style="width:14%">MARTES</th>
        <th class="text-center" style="width:14%">MIÉRCOLES</th>
        <th class="text-center" style="width:14%">JUEVES</th>
        <th class="text-center" style="width:14%">VIERNES</th>
        <th class="text-center" style="width:14%">SÁBADO</th>
        <th class="text-center" style="width:14%">DOMINGO</th>
      </tr>
    </thead>
    <tbody>';
    //$currentmounth = 3;
    $diasdelmes = cal_days_in_month(CAL_GREGORIAN, $currentmounth, $currentyear);
    
    //$diadelasemana = date("l", strtotime("2021-02-22")); // dia de la semana en inglés
    //$diadelasemana=diadelasemanaa($diadelasemana); // Pasarlo a Español
    
    $diadelasemanaNumero = date("N", strtotime("2021-02-22")); // Dia de la semana en número
    
    $tohtml.= "<tr data-id='' style='height: 200px;'>";
    $diadelasemanaNumero = date("N", strtotime($currentyear."-".$currentmounth."-1")); // Dia de la semana en número
    // introducir días antes del 1 (Por si no empieza en lunes)
    for($j=1;$j<=($diadelasemanaNumero-1);$j++){
        $tohtml.="<td class='text-center'></td>";
    }
    for($i=1;$i<=$diasdelmes;$i++){
        $diadelasemanaNumero = date("N", strtotime($currentyear."-".$currentmounth."-".$i)); // Dia de la semana en número   
        $strFechaHoy = strtotime($currentyear."-".$currentmounth."-".$i);
        $fechaHoy = $currentyear."-".$currentmounth."-".$i;
        $fechaFin = $currentyear."-".$currentmounth."-".($i+(7-$diadelasemanaNumero));
        $diafindelasemanaNumero = date("N", strtotime($currentyear."-".$currentmounth."-".($i+(7-$diadelasemanaNumero)))); // Dia de la semana en número
        
        if($diadelasemanaNumero==1){
            $array=getPrevisiones($fechaHoy,$fechaFin,$join,$filtro); // Previsiones de la semana
        }
        $tohtml.="<td class='' style='padding: 0; margin: 0;'>
                    <div class='one-column' style='margin-bottom:0px; width:30px;'>
                        <p class='' style='float:left; margin-left: 10px;'>
                            ".$i."
                        </p>
                    </div>";
        if(is_array($array) || is_object($array)){
            foreach($array as $objeto){
                $texto="";
                $style="";
                $target="";
                if($strFechaHoy>=strtotime($objeto[3]) && $strFechaHoy<=strtotime($objeto[4])){
                    $color=getColorTipoPrevision($objeto[2]);
                    if(strlen($objeto[0])>25){
                        $txtadd="...";
                    }else{
                        $txtadd="";
                    }
                    $texto=substr($objeto[0],0,25).$txtadd;    
                    $style="padding-left: 20px; background-color:".$color.";";
                    $target="class='view-prevision' data-id='".$objeto[1]."' data-type='".$objeto[2]."'";
                }
                $tohtml.="<div ".$target.">
                        <p style='height: 18px; ".$style."' title='".$objeto[0]."'>
                                ".$texto."
                              </p></div>";
            }
        }
        $tohtml.="</td>";
        
        $diasdelmes;
        if($diadelasemanaNumero/7==1){
            $tohtml.= "</tr>
                <tr data-id='' style='height: 100px;'>";
        }
        //$i=$i+(7-$diadelasemanaNumero);
    }
    $tohtml.= "</tr>";
    
    
    $tohtml.='</tbody></table>
            <span class="stretch"></span>';
    
    echo $tohtml;
    
    function diadelasemanaa($diaeningles){
        switch($diaeningles){
            case "Monday":
                $dia = "Lunes";
                break;
            case "Tuesday":
                $dia = "Martes";
                break;
            case "Wednesday":
                $dia = "Miércoles";
                break;
            case "Thursday":
                $dia = "Jueves";
                break;
            case "Friday":
                $dia = "Viernes";
                break;
            case "Saturday":
                $dia = "Sábado";
                break;
            case "Sunday":
                $dia = "Domingo";
                break;
        }
        return $dia;
    }
    function getPrevisiones($fechaini,$fechafin,$join,$filtro){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $array = array();
        
        $sql="SELECT PREVISIONES.nombre, PREVISIONES.id, PREVISIONES.tipo_prev, PREVISIONES.fecha_ini, PREVISIONES.fecha_fin 
                FROM PREVISIONES ".$join."
                WHERE ((PREVISIONES.fecha_ini >= '".$fechaini."' AND PREVISIONES.fecha_fin <= '".$fechafin."')
                OR (PREVISIONES.fecha_ini >= '".$fechaini."' AND PREVISIONES.fecha_ini <= '".$fechafin."')
                OR (PREVISIONES.fecha_fin >= '".$fechaini."' AND PREVISIONES.fecha_fin <= '".$fechafin."'))
                ".$filtro."
                ORDER BY PREVISIONES.id ASC";
        file_put_contents("selectPrevisionInDATE.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Pevisiones");
        while($registros = mysqli_fetch_array($resultado)){
            array_push($array, array($registros[0], $registros[1], $registros[2], $registros[3], $registros[4]));
        }
        /**
        SELECT PREVISIONES.nombre, PREVISIONES.id, PREVISIONES.tipo_prev, PREVISIONES.fecha_ini, PREVISIONES.fecha_fin 
        FROM PREVISIONES 
        WHERE (PREVISIONES.fecha_ini >= '2021-02-01' AND PREVISIONES.fecha_fin <= '2021-02-07')
        OR (PREVISIONES.fecha_ini >= '2021-02-01' AND PREVISIONES.fecha_ini <= '2021-02-07')
        OR (PREVISIONES.fecha_fin >= '2021-02-01' AND PREVISIONES.fecha_fin <= '2021-02-07')
        ORDER BY PREVISIONES.id ASC
        **/
        return $array;
    }
    function getColorTipoPrevision($tipo_id){
        switch ($tipo_id){
            case 1:
                $color="#f0ad4e";
                break;
            case 2:
                $color="#e7e7e7";
                break;
            case 3:
                $color="#5cb85c";
                break;
            case 4:
                $color="#fcff6b";
                break;
            case 5:
                $color="#c789d3";
                break;
            case 6:
                $color="#5bc0de";
                break;
        }
        return $color;
    }
?>