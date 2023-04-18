<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    include("../../../common.php");
    
    
    if ($_GET['tipo_prevision'] != "") {
        $filtro=" AND ACTIVIDAD.categoria_id=".$_GET['tipo_prevision'];
    }
    else {
        $filtro="";
    }
    
    if ($_GET['tecnico'] != "") {
        $filtro.=" AND ACTIVIDAD_USUARIO.user_id=".$_GET['tecnico'];
        $join=" INNER JOIN ACTIVIDAD_USUARIO ON ACTIVIDAD.id=ACTIVIDAD_USUARIO.actividad_id ";
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
    $currentdate = $currentyear."-".date("m")."-".$currentday;
    
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
    $tohtml .= '<div class="modal-header"><h3>Mes: '.$mesesdelano[($currentmounth-1)].'</h3></div>';
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
    
    $tohtml.= "<tr data-id='' style='height: 100px;'>";
    $diadelasemanaNumero = date("N", strtotime($currentyear."-".$currentmounth."-1")); // Dia de la semana en número
    // introducir días antes del 1 (Por si no empieza en lunes)
    for($j=1;$j<=($diadelasemanaNumero-1);$j++){
        $tohtml.="<td class='text-center'></td>";
    }
    for($i=1;$i<=$diasdelmes;$i++){
        $diadelasemanaNumero = date("N", strtotime($currentyear."-".$currentmounth."-".$i)); // Dia de la semana en número   
        $strFechaHoy = strtotime($currentyear."-".$currentmounth."-".$i);
        $fechaHoy = $currentyear."-".$currentmounth."-".$i; // 
        $fechaFin = $currentyear."-".$currentmounth."-".($i+(7-$diadelasemanaNumero));
        $diafindelasemanaNumero = date("N", strtotime($currentyear."-".$currentmounth."-".($i+(7-$diadelasemanaNumero)))); // Dia de la semana en número
        
        if($i+(7-$diadelasemanaNumero)>$diasdelmes){
            $fechaFin = $currentyear."-".$currentmounth."-".$diasdelmes;
        }
        $estiloHoy=" ";
        if($fechaHoy==$currentdate){
            $estiloHoy=" border: 1px solid green;";
        }else{
            $estiloHoy=" ";
        }
        file_put_contents("logFechaHoy.txt", "FechaHoy: ".$fechaHoy." CurrentDate: ".$currentdate." Estilo Hoy: ".$estiloHoy);
        
        if($diadelasemanaNumero==1){
            $arraydim=getActividades($fechaHoy,$fechaFin,$join,$filtro,$i); // Actividades de la semana
        }
        $tohtml.="<td class='' style='padding: 0; margin: 0; ".$estiloHoy."'>
                    <div class='one-column' style='margin-bottom:0px; width:30px;'>
                        <p class='' style='float:left; margin-left:10px;'>
                            ".$i."
                        </p>
                    </div>";
        if(is_array($arraydim) || is_object($arraydim)){
            /*
            foreach($array as $objeto){
                $texto="";
                $style="";
                $target="";
                $titulo="";
                if($strFechaHoy>=strtotime($objeto[3]) && $strFechaHoy<=strtotime($objeto[4])){
                    $color=getColorTipoPrevision($objeto[2]);
                    if(strlen($objeto[0])>25){
                        $txtadd="...";
                    }else{
                        $txtadd="";
                    }
                    $texto=substr($objeto[0],0,25).$txtadd;    
                    $style="padding-left: 20px; background-color:".$color.";";
                    $arrTecs=getTecnicos($objeto[1]);
                    $titulo="title='".$objeto[0]."&#10;";
                    $conttec=0;
                    foreach($arrTecs as $tec){
                        $conttec++;
                        $titulo.="Tec.".$conttec.": ".$tec[0]." ".$tec[1]."&#10;";
                    }
                    $titulo.="'";                    
                    $target="class='view-prevision' data-id='".$objeto[1]."' data-type='".$objeto[2]."'";
                }
                
                $tohtml.="<div ".$target.">
                        <p style='height: 18px; ".$style."' ".$titulo.">
                                ".$texto."
                              </p></div>";
            }*/
            
            // Largo Y
            for($z=0;$z<$GLOBALS["maxY"];$z++){
                // Días de la semana (X)
                //for($a=0;$a<=6;$a++){
                    $a=$diadelasemanaNumero-1;
                    $color=getColorTipoPrevision($arraydim[$a][$z][2]);
                    
                    if(strlen($arraydim[$a][$z][0])>25){
                        $txtadd="...";
                    }else{
                        $txtadd="";
                    }
                    $texto=substr($arraydim[$a][$z][0],0,25).$txtadd;    
                    $style="padding-left: 20px; background-color:".$color.";";
                    if($arraydim[$a][$z][1]!=""){
                        $arrTecs=getTecnicos($arraydim[$a][$z][1]);
                    }else{
                        $arrTecs=array();
                    }
                    $titulo="title='".$arraydim[$a][$z][0]."&#10;";
                    $conttec=0;
                    foreach($arrTecs as $tec){
                        $conttec++;
                        $titulo.="Tec.".$conttec.": ".$tec[0]." ".$tec[1]."&#10;";
                    }
                    $titulo.="'";                    
                    $target="class='view-prevision' data-id='".$arraydim[$a][$z][1]."' data-type='".$arraydim[$a][$z][2]."'";                    
                    
                    $tohtml.="<div ".$target.">
                        <p style='height: 18px; ".$style."' ".$titulo.">
                                ".$texto."
                              </p></div>";
                //}
                //$txtlog.="\n";
                
            }
            $tohtml.="</td>";
            
            //$tohtml.= "</tr>";
        }
        
        //$tohtml.= "</tr>";
        //$diasdelmes;
        if($diadelasemanaNumero/7==1){
            $tohtml.= "</tr>
                <tr data-id='' style='height: 100px;'>";
        }
        //$i=$i+(7-$diadelasemanaNumero);
    }
    //$tohtml.= "</tr>";
    
    
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
    function getActividades($fechaini,$fechafin,$join,$filtro,$numini){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $array = array();
        $arraydim = array(array(),array(),array());
        $arrayX = array(0,1,2,3,4,5,6);
        $arrayY = array();
        // Array tridimensional: PosX, PosY, Obj
        
        $sql="SELECT ACTIVIDAD.nombre, ACTIVIDAD.id, ACTIVIDAD.categoria_id, ACTIVIDAD.fecha, ACTIVIDAD.fecha_fin 
                FROM ACTIVIDAD ".$join."
                WHERE ((ACTIVIDAD.fecha >= '".$fechaini."' AND ACTIVIDAD.fecha_fin <= '".$fechafin."')
                OR (ACTIVIDAD.fecha >= '".$fechaini."' AND ACTIVIDAD.fecha <= '".$fechafin."')
                OR (ACTIVIDAD.fecha_fin >= '".$fechaini."' AND ACTIVIDAD.fecha_fin <= '".$fechafin."'))
                ".$filtro."
                AND NOT (ACTIVIDAD.fecha_fin='0000-00-00')
                ORDER BY ACTIVIDAD.fecha ASC";
        file_put_contents("selectActividadInDATE.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de ACTIVIDAD");
        $rowcount=mysqli_num_rows($resultado);
        for($p=0;$p<$rowcount;$p++){
            array_push($arrayY,$p);
        }
        $max=0;
        $countlog=0;
        while($registros = mysqli_fetch_array($resultado)){
            $y=0;
            $num=substr($registros[3],8,2);
            $num2=substr($registros[4],8,2);
            file_put_contents("logNum".$countlog.".txt", $num);
            // +1 semana de actividad
            if($num<$numini){
                $num=$numini;
            }
            switch($numini-$num){
                case 0: 
                    while($arraydim[0][$y][0]!=""){
                        $y++;
                    }
                    $arraydim[0][$y][0] = $registros[0];
                    $arraydim[0][$y][1] = $registros[1];
                    $arraydim[0][$y][2] = $registros[2];
                    $arraydim[0][$y][3] = $registros[3];
                    $arraydim[0][$y][4] = $registros[4];
                    if($num==$num2){
                        break;
                    }else{
                        $num++;
                    }
                case -1:
                    while($arraydim[1][$y][0]!=""){
                        $y++;
                    }
                    $arraydim[1][$y][0] = $registros[0];
                    $arraydim[1][$y][1] = $registros[1];
                    $arraydim[1][$y][2] = $registros[2];
                    $arraydim[1][$y][3] = $registros[3];
                    $arraydim[1][$y][4] = $registros[4];
                     if($num==$num2){
                        break;
                    }else{
                        $num++;
                    }
                case -2:
                    while($arraydim[2][$y][0]!=""){
                        $y++;
                    }
                    $arraydim[2][$y][0] = $registros[0];
                    $arraydim[2][$y][1] = $registros[1];
                    $arraydim[2][$y][2] = $registros[2];
                    $arraydim[2][$y][3] = $registros[3];
                    $arraydim[2][$y][4] = $registros[4];
                    if($num==$num2){
                        break;
                    }else{
                        $num++;
                    }
                case -3:
                    while($arraydim[3][$y][0]!=""){
                        $y++;
                    }
                    $arraydim[3][$y][0] = $registros[0];
                    $arraydim[3][$y][1] = $registros[1];
                    $arraydim[3][$y][2] = $registros[2];
                    $arraydim[3][$y][3] = $registros[3];
                    $arraydim[3][$y][4] = $registros[4];
                    if($num==$num2){
                        break;
                    }else{
                        $num++;
                    }
                case -4:
                    while($arraydim[4][$y][0]!=""){
                        $y++;
                    }
                    $arraydim[4][$y][0] = $registros[0];
                    $arraydim[4][$y][1] = $registros[1];
                    $arraydim[4][$y][2] = $registros[2];
                    $arraydim[4][$y][3] = $registros[3];
                    $arraydim[4][$y][4] = $registros[4];
                    if($num==$num2){
                        break;
                    }else{
                        $num++;
                    }
                case -5:
                    while($arraydim[5][$y][0]!=""){
                        $y++;
                    }
                    $arraydim[5][$y][0] = $registros[0];
                    $arraydim[5][$y][1] = $registros[1];
                    $arraydim[5][$y][2] = $registros[2];
                    $arraydim[5][$y][3] = $registros[3];
                    $arraydim[5][$y][4] = $registros[4];
                    if($num==$num2){
                        break;
                    }else{
                        $num++;
                    }
                case -6:
                    while($arraydim[6][$y][0]!=""){
                        $y++;
                    }
                    $arraydim[6][$y][0] = $registros[0];
                    $arraydim[6][$y][1] = $registros[1];
                    $arraydim[6][$y][2] = $registros[2];
                    $arraydim[6][$y][3] = $registros[3];
                    $arraydim[6][$y][4] = $registros[4];
                    if($num==$num2){
                        break;
                    }else{
                        $num++;
                    }
            }
            
            if($y>$max){
                $max=$y;
            }
            // Array antiguo +-bien
            array_push($array, array($registros[0], $registros[1], $registros[2], $registros[3], $registros[4]));
            $countlog++;
        }
        $max++;
        /**
        SELECT PREVISIONES.nombre, PREVISIONES.id, PREVISIONES.tipo_prev, PREVISIONES.fecha_ini, PREVISIONES.fecha_fin 
                FROM PREVISIONES ".$join."
                WHERE ((PREVISIONES.fecha_ini >= '".$fechaini."' AND PREVISIONES.fecha_fin <= '".$fechafin."')
                OR (PREVISIONES.fecha_ini >= '".$fechaini."' AND PREVISIONES.fecha_ini <= '".$fechafin."')
                OR (PREVISIONES.fecha_fin >= '".$fechaini."' AND PREVISIONES.fecha_fin <= '".$fechafin."'))
                ".$filtro."
                ORDER BY PREVISIONES.id ASC
        **/
        $txtlog="";
        for($z=0;$z<$max;$z++){
            for($a=0;$a<=6;$a++){
                $txtlog.=$arraydim[$a][$z][0]."*".$arraydim[$a][$z][1]."*".$arraydim[$a][$z][2]."*".$arraydim[$a][$z][3]."*".$arraydim[$a][$z][4]."|";
            }
            $txtlog.="\n";
        }
        foreach($arraydim as $arr){
            $count++;
        }
        $GLOBALS["maxY"]=$max;
        //file_put_contents("logArrayDims".$numini.".txt", $txtlog);
        return $arraydim;
    }
    function getTecnicos($id_act){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $array = array();
        
        $sql="SELECT erp_users.nombre, erp_users.apellidos FROM erp_users 
              INNER JOIN ACTIVIDAD_USUARIO 
              ON erp_users.id=ACTIVIDAD_USUARIO.user_id 
              WHERE ACTIVIDAD_USUARIO.actividad_id=".$id_act;
        file_put_contents("logTecs.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de TECS de ACT");
        while($registros = mysqli_fetch_array($resultado)){
            array_push($array, array($registros[0], $registros[1]));
        }       
        return $array;
    }
    function getColorTipoPrevision($tipo_id){
        switch ($tipo_id){
            case 1:  // Mantenimiento
                $color="#f0ad4e"; // Naranja #f0ad4e
                break;
            case 2: // Intervención
                $color="#CD6155"; // Rojo #CD6155
                break;
            case 3: // Proyecto
                $color="#5cb85c"; // Verde Oscuro #5cb85c
                break;
            case 4: // Oferta
                $color="#fcff6b"; // Amarillo #fcff6b
                break;
            case 5: // Administración
                $color="#AED6F1"; // Azul ##AED6F1
                break;
            case 6: // Calidad
                $color="#c789d3"; // Morado #c789d3
                break;
            case 7: // Formación
                $color="#e7e7e7"; // Gris #e7e7e7
                break;
            case 8: // I+D
                $color="#FF9DE7"; // Rosa FF9DE7
                break;
            case 9: // Marketing
                $color="#8682DA"; // Azul Oscuro #8682DA
                break;
            case 10: // Organización
                $color="#5bc0de"; // Verde Claro #91FF91
                break;
            case 11: // PRL
                $color="#8C8C8C"; // Gris Oscuro #8C8C8C
                break;
        }
        return $color;
    }
?>