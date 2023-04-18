
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");

    if ($_POST['calibraciones_delcalibraciones'] != "") {
        deleteCalibraciones();
    }
    else {
        if ($_POST['addCalibraciones_id'] != "") {
            updateCalibraciones();
        }  
        else {
            if($_POST['antiguascalibraciones_id'] != ""){
                updateCalibracionesAntiguos();
            }else{
                if($_POST['loadantiguascalibraciones_id'] != ""){
                    loadantiguascalibraciones();
                }else{
                    insertCalibraciones();
                }
                
            }
        }
    }
    
    
    function updateCalibraciones () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if($_POST['txt_activado']=="on"){
            $activo=1;
        }else{
            $activo=0;
        }
        
        $sql = "UPDATE CALIDAD_CALIBRACIONES SET 
                        equipo = '".$_POST['addCalibraciones_equipo']."', 
                        num_serie = '".$_POST['addCalibraciones_numserie']."', 
                        tecnico_id = ".$_POST['addCalibraciones_tecnico'].", 
                        labor = '".$_POST['addCalibraciones_labor']."', 
                        periodo = '".$_POST['addCalibraciones_periodo']."', 
                        proced = '".$_POST['addCalibraciones_proced']."', 
                        ult_cali = '".$_POST['addCalibraciones_lastcalibracion']."', 
                        next_cali = '".$_POST['addCalibraciones_nextcalibracion']."', 
                        activo = ".$activo."
                    WHERE id =".$_POST['addCalibraciones_id'];
        file_put_contents("updateCalibraciones.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Calibración. UPDATE");
    }
    
    function updateCalibracionesAntiguos(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CALIDAD_CALIBRACIONES SET 
                        activo = 1
                    WHERE id =".$_POST['antiguascalibraciones_id'];
        
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la calibración. UPDATE ACTIVO");
    }
        
    function insertCalibraciones () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
//        if($_POST['calidad_sistema_habilitado'] == true){
//            $habilitado="on";
//        }else{
//            $habilitado="off";
//        }
        if($_POST['txt_activado']=="on"){
            $activo=1;
        }else{
            $activo=0;
        }
        $sql = "INSERT INTO CALIDAD_CALIBRACIONES 
                            (equipo,
                            num_serie,
                            tecnico_id,
                            labor,
                            periodo,
                            proced,
                            ult_cali,
                            next_cali,
                            activo
                            ) 
                       VALUES (
                            '".$_POST['addCalibraciones_equipo']."', 
                            '".$_POST['addCalibraciones_numserie']."',
                            ".$_POST['addCalibraciones_tecnico'].",
                            '".$_POST['addCalibraciones_labor']."', 
                            '".$_POST['addCalibraciones_periodo']."', 
                            '".$_POST['addCalibraciones_proced']."', 
                            '".$_POST['addCalibraciones_lastcalibracion']."', 
                            '".$_POST['addCalibraciones_nextcalibracion']."', 
                            '".$activo."'                                                    
                        )";
        file_put_contents("insertCalibraciones.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la Calibración. INSERT");
    }
    function deleteCalibraciones () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CALIDAD_CALIBRACIONES WHERE id = ".$_POST['calibraciones_delcalibraciones'];        
        file_put_contents("delCalibraciones.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la Calibración");
    }
    function loadantiguascalibraciones(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        
        $html.='
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CALIBRACIONES ANTIGUAS</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_CalibracionesOLD">
                        <table class="table table-striped table-hover" id="tabla-calibraciones-old">
                            <thead>
                                <tr class="bg-dark">
                                    <th class="text-center">EQUIPO</th>
                                    <th class="text-center">NºSERIE</th>
                                    <th class="text-center">TÉCNICO</th>
                                    <th class="text-center">LABOR.CALIBR.</th>
                                    <th class="text-center">PERIODO CALIBR.</th>
                                    <th class="text-center">PROCED CALIBRACIÓN</th>
                                    <th class="text-center">FECHA ULTIMA CALIBRACIÓN</th>
                                    <th class="text-center">FECHA PRÓXIMA CALIBRACION</th>
                                    <th class="text-center">ANTIGUO</th>
                                    <th class="text-center">V</th>
                                </tr>
                            </thead>
                            <tbody>';

                                $sql = "SELECT 
                                            CALIDAD_CALIBRACIONES.id,
                                            CALIDAD_CALIBRACIONES.equipo,
                                            CALIDAD_CALIBRACIONES.num_serie,
                                            CALIDAD_CALIBRACIONES.tecnico_id,
                                            CALIDAD_CALIBRACIONES.labor,
                                            CALIDAD_CALIBRACIONES.periodo,
                                            CALIDAD_CALIBRACIONES.proced,
                                            CALIDAD_CALIBRACIONES.ult_cali,
                                            CALIDAD_CALIBRACIONES.next_cali,
                                            CALIDAD_CALIBRACIONES.activo,
                                            CALIDAD_CALIBRACIONES.doc_path,
                                            erp_users.nombre,
                                            erp_users.apellidos
                                        FROM 
                                            CALIDAD_CALIBRACIONES, erp_users
                                        WHERE
                                            CALIDAD_CALIBRACIONES.tecnico_id=erp_users.id
                                        AND
                                            CALIDAD_CALIBRACIONES.activo=0";
                                file_put_contents("selectOLDCalibraciones.txt", $sql);
                                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de OLD Calibraciones");

                                while ($row = mysqli_fetch_array($resultado)) {
                                    $idCalidadCalibraciones = $row[0];
                                    $equipoCalidadCalibraciones2 = $row[1];
                                    $numserieCalidadCalibraciones2 = $row[2];
                                    $tecidCalidadCalibraciones = $row[3];
                                    $laborCalidadCalibraciones = $row[4];
                                    $periodoCalidadCalibraciones = $row[5];
                                    $procedCalidadCalibraciones = $row[6];
                                    $ultcaliCalidadCalibraciones = $row[7];
                                    $nextcaliCalidadCalibraciones = $row[8];
                                    $activoCalidadCalibraciones = $row[9];
                                    $docpathCalidadCalibraciones = $row[10];
                                    $nombretecCalidadCalibraciones = $row[11];
                                    $apellidotecCalidadCalibraciones = $row[12];

                                    if($docpathCalidadCalibraciones=="" or $docpathCalidadCalibraciones==null){
                                        $farolillo="<span class='dot-grey''></span>";
                                    }else{
                                        $farolillo="<span class='dot-green''></span>";
                                    }

                                    if($docpathCalidadCalibraciones=="on"){
                                        $habi_pint="<span class='label label-success'>SI</span>";
                                    }else{
                                        $habi_pint="<span class='label label-danger'>NO</span>";
                                    }

                                    $html.= "<tr data-id='".$idCalidadCalibraciones."' id='doc-calibraciones-".$idCalidadCalibraciones."'>
                                        <td class='text-left'>".$equipoCalidadCalibraciones2."</td>
                                        <td class='text-center'>".$numserieCalidadCalibraciones2."</td>
                                        <td class='text-center'>".$nombretecCalidadCalibraciones." ".$apellidotecCalidadCalibraciones."</td>
                                        <td class='text-center'>".$laborCalidadCalibraciones."</td>
                                        <td class='text-center'>".$periodoCalidadCalibraciones."</td>
                                        <td class='text-center'>".$procedCalidadCalibraciones."</td>
                                        <td class='text-center'>".$ultcaliCalidadCalibraciones."</td>
                                        <td class='text-center'>".$nextcaliCalidadCalibraciones."</td>
                                        <td class='text-center'><span class='label label-danger'>NO</span></td>
                                        <td class='text-center'><a href='file:////192.168.3.108/".$docpathCalidadCalibraciones."' target='_blank'><img src='/erp/img/lupa.png' title='Ver Calibración' style='height: 10px;'></a></td>
                                    </tr>";

                                }    
                                $html.= " </tbody></table>          
                    </form>
                </div>
            </div>
        </div>
    </div>";
        
        echo $html;
    }
   
?>
	