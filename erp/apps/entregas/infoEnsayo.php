
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    switch($_POST["plantilla_id"]){
        case "5": // 5 PROTOCOLO DE PRUEBAS RELES PROTECCIÓN
            getInfoReles();
            break;
        case "40": // 40 PROTOCOLO DE PRUEBAS DE ARMARIOS EN INGLES
            getInfoArmarios();
            break;
        case "44": // 44 PROTOCOLO DE PRUEBAS EN ARMARIO
            getInfoArmarios();
            break;
        case "99": // 99 PROTOCOLO DE PRUEBAS
            getInfoPruebas();
            break;
        default:
            alert("No se puede imprimir para esa plantilla!");
            break;
    }
    
    
    function getInfoReles() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sqlSelectInfo="SELECT id, ensayo_id, titulo, descripcion, estado, fecha FROM ENSAYOS_INFO WHERE ensayo_id=".$_POST["ensayo_id"];
        $resSelectInfo = mysqli_query($connString, $sqlSelectInfo) or die("Error al reealizar select de INFO Ensayos (Reles).");    
        
        $htmlboton='<button type="button" id="add-ensayo-info" style="margin-bottom:5px;"><img src="/erp/img/add.png" height="20"></button>';
        
        $html=$htmlboton.'<table class="table table-striped table-hover" id="tabla-ensayos-info5">
                <thead>
                  <tr class="bg-dark">
                    <th>TITULO</th>
                    <th class="text-center">DESCRIPCION</th>
                    <th class="text-center">ESTADO</th>
                    <th class="text-center">FECHA</th>
                    <th class="text-center" style="width:5%;">E</th>
                  </tr>
                </thead>
                <tbody>';
          
        
        while ($row = mysqli_fetch_array($resSelectInfo)) {
        $html.='<tr data-id="'.$row[0].'">
                <td class="text-left">'.$row[2].'</td>
                <td class="text-center">'.$row[3].'</td>
                <td class="text-center">'.$row[4].'</td>
                <td class="text-center">'.$row[5].'</td>
                <td class="text-center" style="width:5%;"><button type="button" class="btn btn-circle btn-danger remove-ensayo-info" data-id="'.$row[0].'" title="Eliminar Ensayo Info"><img src="/erp/img/cross.png"></button></td>
            </tr>';
        }
        
        $html.='</tbody></table>';
        
        echo $html;
    }
    
    function getInfoArmarios() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // Si no esta creado, crear para este ensayo_id => ENSAYOS_PLANTILLA
        // 
        // 
        //
        $sqlCheck="SELECT * FROM ENSAYOS_PRUEBAS WHERE ensayo_id=".$_POST["ensayo_id"]." AND plantilla_id=".$_POST["plantilla_id"];
        $res = mysqli_query($connString, $sqlCheck) or die("Error al realizar check ENSAYOS PRUEBAS (InfoArmario).");
        /* determinar el número de filas del resultado */
        $row_cnt = mysqli_num_rows($res);
        if($row_cnt==0){ // Crear puntos para este ensayo
            $numini=1;
            $numfin=52;
            if($_POST["plantilla_id"]==40){
                $numini=27;
                $numfin=52;
            }elseif($_POST["plantilla_id"]==44){
                $numini=1;
                $numfin=26;
            }
            while($numini<=$numfin){
                $sqlCreate="INSERT INTO ENSAYOS_PRUEBAS
                            (ensayoplantilla_id, ensayo_id, estado_id, plantilla_id, texto)
                            VALUES (".$numini.",".$_POST["ensayo_id"].",0,".$_POST["plantilla_id"].", '')";
                $res = mysqli_query($connString, $sqlCreate) or die("Error al realizar insert de puntos faltantes.");
                $numini++;
            }
        }
        
        // Select de los puntos.... (nombres y nombres grupos)
        $sql="SELECT 
                ENSAYOS_PLANTILLAS.id,
                ENSAYOS_PLANTILLAS.plantilla_id,
                ENSAYOS_PLANTILLAS.nombre,
                ENSAYOS_PLANTILLAS.grupo_id,
                ENSAYOS_PLANTILLA_GRUPO.nombre,
                ENSAYOS_PRUEBAS.estado_id,
                ENSAYOS_PRUEBAS.id
              FROM ENSAYOS_PLANTILLAS, ENSAYOS_PLANTILLA_GRUPO, ENSAYOS_PRUEBAS
              WHERE ENSAYOS_PLANTILLAS.plantilla_id =".$_POST["plantilla_id"]."
              AND ENSAYOS_PLANTILLAS.grupo_id = ENSAYOS_PLANTILLA_GRUPO.id
              AND ENSAYOS_PLANTILLAS.id = ENSAYOS_PRUEBAS.ensayoplantilla_id
              AND ENSAYOS_PRUEBAS.ensayo_id=".$_POST["ensayo_id"]."
              ORDER BY ENSAYOS_PLANTILLAS.id ASC ,ENSAYOS_PLANTILLAS.grupo_id ASC";
        //file_put_contents("log00099.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error al realizar select de INFO Ensayos (Armarios).");
        
        $count=0;
        $grupoanterior=0;
        // Hacer un while y comparar cada uno. ENSAYOS_PRUEBAS where ensayo_id=X.
        while ($row = mysqli_fetch_array($res)) {
            if($row[5]==1){
                $estado='<span class="dot-green estado-info" title="Realizado"></span>';
            }elseif($row[5]==0){
                $estado='<span class="dot-red estado-info" title="Pendiente"></span>';
            }elseif($row[5]==2){
                $estado='<span class="dot-yellow estado-info" title="A Medias"></span>';
            }
            
            if($count==0){ // La primera vez:
                $html="<h4>".$row[4]."</h4>";
                $html.='<table class="table table-striped table-hover" id="tabla-ensayos-info">
                        <tbody>
                        <tr data-id="'.$row[6].'">
                            <td class="text-center">'.$row[2].'</td>
                            <td class="text-center">'.$estado.'</td>
                        </tr>';
                $grupoanterior=$row[3];
            }
            if($grupoanterior!=$row[3]){ // Si hay que iniciar otro grupo
                $html.='</tbody></table>
                        <h4>'.$row[4].'</h4>
                        <table class="table table-striped table-hover" id="tabla-ensayos-info">
                        <tbody>
                        <tr data-id="'.$row[6].'">
                            <td class="text-center">'.$row[2].'</td>
                            <td class="text-center">'.$estado.'</td>
                        </tr>';
            }elseif($count!=0){
                $html.='<tr data-id="'.$row[6].'">
                            <td class="text-center">'.$row[2].'</td>
                            <td class="text-center">'.$estado.'</td>
                        </tr>';
            }
            $grupoanterior=$row[3];
            $count++;
        }
        $html.='</tbody></table>';
        echo $html;
    }
    
    function getInfoPruebas(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        // Obtener nombres de detalles de la plantilla.
        
        $sqlExist="SELECT id, ensayoplantilla_id, ensayo_id, estado_id, plantilla_id, texto
                    FROM ENSAYOS_PRUEBAS WHERE ensayo_id=".$_POST["ensayo_id"]; // **
        file_put_contents("log001.txt", $sqlExist);
        $resExist = mysqli_query($connString, $sqlExist);
        $row_cnt = mysqli_num_rows($resExist);
        // Si hay uno, Cargar datos.
        // Sino, Insertar en ENSAYOS_PRUEBAS
        if($row_cnt==0){
            // No existe
            // Insert. primero select de la plantilla
            $sqlSelectInfo="SELECT id, plantilla_id, nombre, grupo_id FROM ENSAYOS_PLANTILLAS WHERE plantilla_id=".$_POST["plantilla_id"];
            $resSelectInfo = mysqli_query($connString, $sqlSelectInfo) or die("Error al reealizar select de INFO de Pruebas");
            
            while($row = mysqli_fetch_array($resSelectInfo)){
                $sqlCreate="INSERT INTO ENSAYOS_PRUEBAS
                            (ensayoplantilla_id, ensayo_id, estado_id, plantilla_id, texto)
                            VALUES (".$row[0].",".$_POST["ensayo_id"].",0,".$_POST["plantilla_id"].",'')";
                file_put_contents("log999.txt", $sqlCreate);
                $res = mysqli_query($connString, $sqlCreate) or die("Error al realizar insert de ensayo pruebas.");
            }
            
        }
        // Ahora seguro que Existe. 
        // Cargar Datos
        $sqlSelect="SELECT 
                ENSAYOS_PLANTILLAS.id,
                ENSAYOS_PLANTILLAS.plantilla_id,
                ENSAYOS_PLANTILLAS.nombre,
                ENSAYOS_PLANTILLAS.grupo_id,
                ENSAYOS_PLANTILLA_GRUPO.nombre,
                ENSAYOS_PRUEBAS.estado_id,
                ENSAYOS_PRUEBAS.id,
                ENSAYOS_PRUEBAS.texto
              FROM ENSAYOS_PLANTILLAS, ENSAYOS_PLANTILLA_GRUPO, ENSAYOS_PRUEBAS
              WHERE ENSAYOS_PLANTILLAS.plantilla_id =".$_POST["plantilla_id"]."
              AND ENSAYOS_PLANTILLAS.grupo_id = ENSAYOS_PLANTILLA_GRUPO.id
              AND ENSAYOS_PLANTILLAS.id = ENSAYOS_PRUEBAS.ensayoplantilla_id
              AND ENSAYOS_PRUEBAS.ensayo_id=".$_POST["ensayo_id"]."
              ORDER BY ENSAYOS_PLANTILLAS.id ASC ,ENSAYOS_PLANTILLAS.grupo_id ASC";
        $resSelect = mysqli_query($connString, $sqlSelect) or die("Error al reealizar select de ENSAYO PRUEBAS.");
        
        $count=0;
        $grupoanterior=0;
        $html="";
        while($row = mysqli_fetch_array($resSelect)){
            if($count==0){ // La primera vez:
                $html="<h4>".$row[4]."</h4>";
                $html.='<table class="table table-striped table-hover tabla-ensayos-info" id="">
                        <tbody>
                        <tr data-id="'.$row[6].'">
                            <td class="text-left" style="width:30px;"></td>
                            <td class="text-left">'.$row[2].'</td>
                            <td class="text-center" style="width:100px;">
                                <input type="text" class="form-control valor_prueba" id="" name="valor_prueba" placeholder="Valor" value="'.$row[7].'" style="margin-bottom: 0; height: 25px;">
                            </td>
                        </tr>';
                $grupoanterior=$row[3];
            }
            if($grupoanterior!=$row[3]){ // Si hay que iniciar otro grupo
                $html.='</tbody></table>
                        <h4>'.$row[4].'</h4>
                        <table class="table table-striped table-hover tabla-ensayos-info" id="">
                        <tbody>
                        <tr data-id="'.$row[6].'">
                            <td class="text-left" style="width:30px;"></td>
                            <td class="text-left">'.$row[2].'</td>
                            <td class="text-center" style="width:100px;">
                                <input type="text" class="form-control valor_prueba" id="" name="valor_prueba" placeholder="Valor" value="'.$row[7].'" style="margin-bottom: 0; height: 25px;">
                            </td>
                        </tr>';
            }elseif($count!=0){
                $html.='<tr data-id="'.$row[6].'">
                            <td class="text-left" style="width:30px;"></td>
                            <td class="text-left">'.$row[2].'</td>
                            <td class="text-center" style="width:100px;">
                                <input type="text" class="form-control valor_prueba" id="" name="valor_prueba" placeholder="Valor" value="'.$row[7].'" style="margin-bottom: 0; height: 25px;">
                            </td>
                        </tr>';
            }
            $grupoanterior=$row[3];
            $count++;
        }
        
        $html.='</tbody></table>';
        echo $html;
        
    }
?>
	