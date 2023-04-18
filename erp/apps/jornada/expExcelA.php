<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz.'/apps/jornada/excel/PHPExcel.php');
    require_once($pathraiz.'/apps/jornada/excel/PHPExcel/IOFactory.php');
    require_once($pathraiz.'/apps/jornada/jornadasFunciones.php');

    // Create your database query
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    // Estilo bordes para tabla:
    $styleArray = array(
        'borders' => array(
          'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
          )
        )
      );
    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel(); 
    // Creamos array de los meses
    $arMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Dicciembre");
    for ($i = 0; $i < 12; $i++) {
        //echo $i;
        $mesActual=$i+1;
        $objWorkSheet = $objPHPExcel->createSheet($i);
        $objPHPExcel->setActiveSheetIndex($i); 
        $objWorkSheet->setTitle("$arMeses[$i]");
        // Initialise the Excel row number
        $rowCount = 1; 
        // Iterate through each result from the SQL query in turn
        // We fetch each database result row into $row in turn
        
        $sql = "SELECT 
            CALENDARIO.id,
            CALENDARIO.fecha, 
            CALENDARIO.horas,
            erp_users.nombre,
            JORNADAS.id,
            erp_users.firma_path,
            CALENDARIO.festivo,
            CALENDARIO.tipo_jornada,
            erp_users.apellidos
        FROM 
            CALENDARIO, JORNADAS, erp_users 
        WHERE 
            CALENDARIO.id = JORNADAS.calendario_id 
        AND
            JORNADAS.user_id = erp_users.id 
        AND 
            MONTH(CALENDARIO.fecha) = ".$mesActual." 
        AND 
            YEAR(CALENDARIO.fecha) = ".$_POST['yearNum']."
        AND
            erp_users.id = ".$_POST['idtrabajador']."
        ORDER BY 
            CALENDARIO.fecha ASC";
        file_put_contents("queryCalendario.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del Calendario");
        $horasOrdinariasMes = 0;
        $horasExtraMes = 0;
        $horasjornadaMes = 0;
        $horasDebidasMes = 0;
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Día");
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Accesos");
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "H.Laborales");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "H.Ordinarias");
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "H.Extra");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "H.Vacaciones");
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "H.Medico");
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "H.Debidas");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
        
        $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':H'.$rowCount)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('FF808080');
        
        $rowCount++;
        while ($registros = mysqli_fetch_array($resultado)) {
            $horasJornada = $registros[2];
            $user=str_replace(" ","",$registros[3].$registros[8]);
            $horasjornadaMes = ($horasjornadaMes + $horasJornada);
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $registros[1]);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
            
            
            $sql = "SELECT 
                    JORNADAS_ACCESOS.id,
                    JORNADAS_ACCESOS.hora_entrada, 
                    JORNADAS_ACCESOS.hora_salida,
                    JORNADAS_ACCESOS.tipo_horas 
                FROM 
                    JORNADAS, JORNADAS_ACCESOS  
                WHERE 
                    JORNADAS.id = JORNADAS_ACCESOS.jornada_id 
                AND
                    JORNADAS.id = ".$registros[4]."
                ORDER BY 
                    JORNADAS_ACCESOS.hora_entrada ASC";
            
            file_put_contents("queryAccesos.txt", $sql);
            $resultado2 = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de los Accesos");
            
            if (mysqli_num_rows($resultado2) > 0) {
                $horasTotales = 0;
                $horasExtra = 0;
                $horasVacaciones = 0;
                $horasMedico = 0;
                $horasDebidas = 0;
                $testVacacionesDiaCompleto = 0;
                while ($registros2 = mysqli_fetch_array($resultado2)) {
                    $tipo_horas = $registros2[3];
                    $valorAnterior=$objPHPExcel->getActiveSheet()->getCell('B'.$rowCount)->getValue();
                    $fecha1 = new DateTime($registros2[1]);
                    $fecha2 = new DateTime($registros2[2]);
                    $valorAnterior.="\nE: ".$fecha1->format('H:i').' S: '.$fecha2->format('H:i');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $valorAnterior);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
                    
                    if ($tipo_horas == 3) {
                        $testVacacionesDiaCompleto = $testVacacionesDiaCompleto + 1;
                    }
                    if ($registros2[2] != "0000-00-00 00:00:00") {
                        $intervalo = $fecha1->diff($fecha2);
                        $hours = round($intervalo->s / 3600 + $intervalo->i / 60 + $intervalo->h + $intervalo->days * 24, 2);
                        if (($tipo_horas == 1) || ($tipo_horas == 2)) {
                            $horasTotales = ($horasTotales + $hours);
                        }
                        if ($tipo_horas == 2) {
                            $horasMedico = ($horasMedico + $hours);
                        }
                        if ($tipo_horas == 3) {
                            
                            $horasVacaciones = ($horasVacaciones + $hours);
                        }
                    }
                    
                }
            }else{
                $horasTotales = 0;
                $horasVacaciones = 0;
                $horasMedico = 0;
                $horasDebidas = 0;
            }

            if ($horasTotales > $horasJornada) {
                $horasExtra = ($horasTotales - $horasJornada);
                $horasTotales = $horasJornada;
                $horasDebidas = 0;
            }else {
                $horasExtra = 0;
                if ($registros[1] > date("Y-m-d")) {
                    $horasDebidas = 0;
                }else{
                    $horasDebidas = $horasJornada - ($horasTotales + $horasExtra + $horasVacaciones);
                }

            }
            $horasOrdinariasMes = ($horasOrdinariasMes + $horasTotales);
            $horasExtraMes = ($horasExtraMes + $horasExtra);
            $horasDebidasMes = ($horasDebidasMes + $horasDebidas);
            $horasVacMes = ($horasVacMes + $horasVacaciones);
            $horasMedMes = ($horasMedMes + $horasMedico);
            $horasDebMes = ($horasDebMes + $horasDebidas);
            
            $horasExtraMesTot = $horasExtraMesTot+$horasExtraMes;
            $horasDebidasMesTot = $horasDebidasMesTot+$horasDebidasMes;
            
            //$horasTotalesTime = decimal2hours($horasTotales);
            
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, decimalHours($horasJornada));
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, decimalHours($horasTotales));
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, decimalHours($horasExtra));
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, decimalHours($horasVacaciones));
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, decimalHours($horasMedico));
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, decimalHours($horasDebidas));
            
            
            $objPHPExcel->getActiveSheet()->getStyle('A1:H'.$rowCount)->applyFromArray($styleArray);
            
            if($horasJornada==5){
                $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':H'.$rowCount)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('FFC4E3F3');
            }elseif ($horasJornada==0) {
                $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':H'.$rowCount)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('FFF2DEDE');
            }
            
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(40);
            // Increment the Excel row counter
            $rowCount++; 
        }
    
    /*/ Calculos de horas totales /*/
        $horasAtrabajarMes=0;
        $horasTrabajadasMes=0;
        $horasVacacionesTot=0;
        $horasVacacionesMes=0;
        $horasRegularizadasMes=0;
        $horasRegularizadasTot=0;
        // Calculo las horas que hay que trabajar al mes sin contar las vacaciones
        $registros = horasCalendarioMes($_POST['yearNum'],$mesActual,$_POST['idtrabajador']);
        $horasAtrabajarMes = $registros[2];
        // Calculo las horas trabajadas en el mes
        $registros = horasTrabajadasMes($_POST['yearNum'],$mesActual,$_POST['idtrabajador']);
        $horasTrabajadasMes = $registros[0]+($registros[1]/60);
        $registros = horasVacacionesHastaHoy($_POST['yearNum'],$_POST['idtrabajador']);
        $horasVacacionesTot = $registros[0];
        $registros = horasVacacionesEsteMes($_POST['yearNum'],$mesActual,$_POST['idtrabajador']);
        $horasVacacionesMes = $registros[0];
        $registros = horasRegularizadasMes($_POST['yearNum'],$mesActual,$_POST['idtrabajador']);
        $horasRegularizadasMes = $registros[0]+($registros[1]/60);
        $registros = horasRegularizadasHastaHoy($_POST['yearNum'],$_POST['idtrabajador']);
        $horasRegularizadasTot = $registros[0];
        
        $rowCount=1;
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(22);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
        $rowCount=$rowCount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "H.Calendario en el Mes");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, decimalHours($horasAtrabajarMes));
        $rowCount=$rowCount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "H.Trabajadas Mes");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, decimalHours($horasTrabajadasMes));
        $rowCount=$rowCount+1;
        /*
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "H.Regularizadas Mes");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, decimalHours($horasRegularizadasMes));
        $rowCount=$rowCount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "H.regularizadas Tot");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, decimalHours($horasRegularizadasTot));
        $rowCount=$rowCount+1;*/
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "H.Vacaciones Mes");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, decimalHours($horasVacacionesMes));
        $rowCount=$rowCount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "H.Vacaciones Tot");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, decimalHours($horasVacacionesTot));
        $rowCount=$rowCount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "H.Debidas Mes");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, decimalHours($horasDebidasMes));
        $rowCount=$rowCount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "H.Extra Mes");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, decimalHours($horasExtraMes));
        
        $objPHPExcel->getActiveSheet()->getStyle('J2:K'.$rowCount)->applyFromArray($styleArray);
        
    }
    //////////////////////////////////////////////////////////////////////////
    /********** Exportación del fichero ***********/
    $fecha=$_POST['monthNum']."_".$_POST['yearNum'];
    //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    //$fichero = $pathraiz.'/apps/jornada/excel/exports/jornada'.$user.$_POST['monthNum'].$_POST['yearNum'].'.xls';
    $fichero = $pathraiz.'/apps/jornada/excel/exports/jornadaAnual'.$user.'_'.$_POST['yearNum'].'.xls';

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    // Write the Excel file to filename some_excel_file.xlsx in the current directory
    $objWriter->save($fichero); 
    //echo '/apps/jornada/excel/exports/jornada'.$user.$_POST['monthNum'].$_POST['yearNum'].'.xls';
    echo "/erp/apps/jornada/excel/exports/jornadaAnual".$user."_".$_POST['yearNum'].".xls";
    
    function decimalHours($time){
        $horas= intval($time);
        $min = $time - intval($time);
        $minutos=floor($min*60);
        if(strlen($horas)==1){
            $horas="0".$horas;
        }
        if(strlen($minutos)==1){
            $minutos="0".$minutos;
        }
        return ($horas.":".$minutos);
    }
    function obtenerHoras($time){
        $horas= intval($time);
        $min = $time - intval($time);
        $minutos=floor($min*60);
        
        return ($horas."h".$minutos);
    }
?>