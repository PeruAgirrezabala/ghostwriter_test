<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz.'/apps/jornada/excel/PHPExcel.php');
    require_once($pathraiz.'/apps/jornada/excel/PHPExcel/IOFactory.php');

    // Create your database query
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel(); 
    // Creamos array de los meses
    $arMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Dicciembre");
    for ($i = 1; $i <= 12; $i++) {
        //echo $i;
    
        $objWorkSheet = $objPHPExcel->createSheet($i);
        $objPHPExcel->setActiveSheetIndex($i); 
        $objWorkSheet->setTitle("$arMeses[$i]");
        // Initialise the Excel row number
        $rowCount = 1; 
        // Iterate through each result from the SQL query in turn
        // We fetch each database result row into $row in turn
        
        $sql = "SELECT 
                    erp_users.nombre, erp_users.apellidos
                FROM 
                    erp_users";  

        // Execute the database query
        $result = mysqli_query($connString, $sql) or die("Error al recoger nombre y apellido");
        
        while($row = mysqli_fetch_array($result)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row[0]); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row[1]); 
            // Increment the Excel row counter
            $rowCount++; 
        } 
    }

    //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
    $fichero = $pathraiz.'/apps/jornada/excel/exports/exportExcel.xls';

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    // Write the Excel file to filename some_excel_file.xlsx in the current directory
    $objWriter->save($fichero); 
    echo "/erp/apps/jornada/excel/exports/exportExcel.xls";
?>