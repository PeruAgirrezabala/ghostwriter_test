<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz.'/plugins/excel/PHPExcel.php');
    require_once($pathraiz.'/plugins/excel/PHPExcel/IOFactory.php');
    //require_once($pathraiz.'/apps/jornada/jornadasFunciones.php');

    // Create your database query
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    // Estilo bordes para tabla:
    //
    
    $styleArray = array(
        'borders' => array(
          'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
          )
        )
      );
    
        $filtros = "";
    if ($_GET['proveedor_id'] != "") {
        $criteria .= " WHERE PEDIDOS_PROV.proveedor_id = ".$_GET['proveedor_id'];
        $and = " AND ";
    }
    if ($_GET['year'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteria .= $and." YEAR(PEDIDOS_PROV.fecha) = ".$_GET['year'];
        $and = " AND ";
        $filtros .= $separator." <strong>Año:</strong> ".$_GET['year']." ";
        $separator = "|";
    }
    if ($_GET['estado'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        if($_GET['estado'] == 99){ // Pendiente de recibir, es un estado que engloba varios estados.
            $criteria .= $and." PEDIDOS_PROV.estado_id <> 2 AND PEDIDOS_PROV.estado_id <> 4 AND PEDIDOS_PROV.estado_id <> 5 AND PEDIDOS_PROV.estado_id <> 6 AND PEDIDOS_PROV.estado_id <> 7 ";
        }else{
        $criteria .= $and." PEDIDOS_PROV.estado_id = ".$_GET['estado'];
        $and = " AND ";
        }
        $filtros .= $separator." <strong>Estado:</strong> ".$_GET['estado']." ";
    }
    if ($_GET['recibido'] == "1") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteria .= $and." PEDIDOS_PROV_DETALLES.recibido = ".$_GET['recibido'];
        $and = " AND ";
        $filtros .= $separator." <strong> Pedidos Recibidos </strong> ";
    }elseif($_GET['recibido'] == "0"){
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteria .= $and." PEDIDOS_PROV_DETALLES.recibido = ".$_GET['recibido'];
        $and = " AND ";
        $filtros .= $separator." <strong> Pedidos Pendientes de recibir </strong> ";
    }
    if ($_GET['proyecto'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteria .= $and." PEDIDOS_PROV.proyecto_id = ".$_GET['proyecto'];  
        $and = " AND ";
    }
    if ($_GET['cliente'] != "") {
        if ($criteria == "") {
            $criteria = " WHERE ";
        }
        $criteria .= $and." PEDIDOS_PROV.cliente_id = ".$_GET['cliente'];  
        $and = " AND ";
    }
    
    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel(); 
    $rowCount=1;   
    // Select de los detalles que los pedidos que contengan ese material
    $sql = "SELECT DISTINCT
                PEDIDOS_PROV.id,
                PEDIDOS_PROV.pedido_genelek,
                PEDIDOS_PROV.titulo,
                PEDIDOS_PROV.fecha,
                PEDIDOS_PROV.plazo,
                PEDIDOS_PROV.fecha_entrega,
                PEDIDOS_PROV.proveedor_id,
                PROVEEDORES.nombre
            FROM 
                PEDIDOS_PROV_DETALLES
            INNER JOIN PEDIDOS_PROV
                ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
            INNER JOIN PROVEEDORES 
                ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id
            ".$criteria."
            ORDER BY 
                PEDIDOS_PROV.fecha DESC, PEDIDOS_PROV_DETALLES.id ASC";

    file_put_contents("array.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("database error:");
        
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REF");
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "MATERIAL");
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "FABRICANTE");
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "UNIDAD");
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "PVP");
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "DTO");
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "IMPORTE");
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "RECIBIDO");
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "FECHA");
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "F.ENTREGA");
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(130);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
    
    
    // Establecer color
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('777777');
    $rowCount++; // Ir a siguiente Fila
    while ($registros = mysqli_fetch_array($resultado)) {
        $proveedor=$registros[7];
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REF: ".$registros[1]." Tilulo: ".$registros[2]." Fecha: ".$registros[3]." Plazo: ".$registros[4]." Fecha estimada de Entrega: ".$registros[5]." Proveedor: ".$registros[7]);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A'.$rowCount.':J'.$rowCount)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('219AE0');
            
            
            //////////////////////////////////////////////////////
            /////////////////// DETALLES DEL PEDIDO //////////////
            //////////////////////////////////////////////////////
            // Sacar pedidos Prov detalles
            $sql = "SELECT 
                PEDIDOS_PROV_DETALLES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                PEDIDOS_PROV_DETALLES.unidades,
                MATERIALES_PRECIOS.pvp, 
                PEDIDOS_PROV_DETALLES.recibido,
                PEDIDOS_PROV_DETALLES.fecha_recepcion,
                PROYECTOS.nombre,
                PEDIDOS_PROV_DETALLES.pvp,
                MATERIALES_PRECIOS.dto_material, 
                PEDIDOS_PROV_DETALLES.dto_prov_activo, 
                PEDIDOS_PROV_DETALLES.dto_mat_activo, 
                PEDIDOS_PROV_DETALLES.dto_ad_activo, 
                PROVEEDORES_DTO.dto_prov, 
                PEDIDOS_PROV_DETALLES.dto, 
                PEDIDOS_PROV_DETALLES.fecha_entrega,
                erp_users.nombre, 
                MATERIALES.id,
                PEDIDOS_PROV_DETALLES.dto_ad_prior,
                PEDIDOS_PROV_DETALLES.iva_id,
                IVAS.nombre,
                PEDIDOS_PROV_DETALLES.detalle_libre,
                PEDIDOS_PROV_DETALLES.ref,
                PEDIDOS_PROV.id,
                PEDIDOS_PROV.pedido_genelek,
                PEDIDOS_PROV.fecha,
                PROVEEDORES.nombre,
                PEDIDOS_PROV.estado_id,
                PEDIDOS_PROV.plazo
            FROM 
                PEDIDOS_PROV_DETALLES
            LEFT JOIN MATERIALES
                ON PEDIDOS_PROV_DETALLES.material_id = MATERIALES.id 
            INNER JOIN IVAS
                ON IVAS.id = PEDIDOS_PROV_DETALLES.iva_id 
            LEFT JOIN MATERIALES_PRECIOS 
                ON MATERIALES_PRECIOS.id = PEDIDOS_PROV_DETALLES.material_tarifa_id 
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = PEDIDOS_PROV_DETALLES.proyecto_id 
            LEFT JOIN PROVEEDORES_DTO 
                ON PROVEEDORES_DTO.id = PEDIDOS_PROV_DETALLES.dto_prov_id
            LEFT JOIN erp_users 
                ON PEDIDOS_PROV_DETALLES.erp_userid = erp_users.id 
            INNER JOIN PEDIDOS_PROV
                ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
            INNER JOIN PROVEEDORES 
                ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id
            WHERE
                PEDIDOS_PROV_DETALLES.pedido_id =".$registros[0]."
            ".str_replace('WHERE','AND',$criteria)."
            ORDER BY 
                PEDIDOS_PROV.fecha DESC, PEDIDOS_PROV_DETALLES.id ASC";
            file_put_contents("queryPedMatDetalle.txt", $sql);
            $resultado2 = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de materiales detalles");
                
            $iva = 0;
            $contador = 0;
            
            while ($row = mysqli_fetch_array($resultado2)) {
                
                $rowCount++;
                
                $pvp = $row[5];
                $dto = $row[14];
                $dto_precio = ($pvp*$dto)/100;
                $importe = $pvp-$dto_precio;
                
                if ($row[6] == 0) {
                    $recibidoDet = "NO";
                    $pintar="Blanco";
                } else {
                    $recibidoDet = "SI";
                    $pintar="Verde";
                }
                
                switch($pintar){
                    case "Verde":
                        $objPHPExcel->getActiveSheet()
                    ->getStyle('A'.$rowCount.':J'.$rowCount)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('b7fca4');
                        break;
                    case "Blanco":
                        $objPHPExcel->getActiveSheet()
                    ->getStyle('A'.$rowCount.':J'.$rowCount)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor();
                        break;
                    case "":
                        break;
                }
                //file_put_contents("logColorAPintar.txt", $pintar);
                
                $fecha_entrega = strtotime($row[16]);
                $fecha_entrega = date("Y-m-d", $fecha_entrega);
                if ((date("Y-m-d") > $fecha_entrega) && (($row[28] < 4) || ($row[28] > 7))) {
                    $fecha_entrega = $row[16]."<span class='blink_me' title='Pedido Retrasado'><img src='/erp/img/warning-test.png'></span>";
                }
                else {
                    $fecha_entrega = $row[16];
                }
//                if ($contador%2==0) {
//                    $bgcolor = "style='background-color:#ffffff;'";
//                }
//                else {
//                    $bgcolor = "style='background-color:#f9f9f9;'";
//                }
                if ($row[5] != "") {
                    $pvp = $row[5];
                }
                else {
                    $pvp = $row[9];
                }

                $dto_sum = 0;
                $pvp_dto = 0;
                if ($row[11] == 1) {
                    $dto_sum  = $dto_sum + $row[14];
                }
                if ($row[12] == 1) {
                    $dto_sum  = $dto_sum + $row[10];
                }
                if ($row[13] == 1) {
                    if ($row[19] == 1) {
                        $dto_extra = $row[15];
                    }
                    else {
                        $dto_sum  = $dto_sum + $row[15];
                        $dto_extra = "";
                    }
                }       

                $ivaPercent = $row[21];
                $subtotal = ($pvp*$row[4]);
                $dto = ($subtotal*$dto_sum)/100;
                $subtotalDtoApli = $subtotal-$dto;
                if ($row[19] == 1) {
                    $dtoNeto = ($subtotalDtoApli*$dto_extra)/100;
                    $subtotalDtoApli = $subtotalDtoApli-$dtoNeto;
                    $dto_extra =  " + ".number_format($dto_extra, 2);
                }
                else {
                    $dtoNeto = 0;
                }

                if ($row[6] == 0) {
                    $recibidoDet = "NO";
                }
                else {
                    $recibidoDet = "SI";
                }

//                if ($recibidoDet == "SI") {
//                    $disableButton = " disabled ";
//                    $trcolor = "style='background-color: #b7fca4 !important;'";
//                    $bgcolor = "";
//                }
//                else {
//                    $disableButton = " ";
//                    $trcolor = "";
//                }

                if ($row[2] != "") {
                    $material = $row[2];
                }
                else {
                    $material = $row[22];
                }

                if ($row[1] != "") {
                    $ref = $row[1];
                }
                else {
                    $ref = $row[23];
                }
        
                
                
                //$proyecto = $row[8];
                //$fecha = $row[16];
                
                //$objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $ref); // REF                
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $material); // MATERIAL               
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row[3]); // FABRICANTE
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row[4]); // UNIDAD
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $pvp); // PVP
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($dto_sum, 2).$dto_extra); // DTO %
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($subtotalDtoApli, 2)); // IMPORTE          
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $recibidoDet); // RECIBIDO          
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row[26]); // FECHA          
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row[16]); // F.ENTREGA
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
                
                // Poner bordes
                //$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$rowCount)->applyFromArray($styleArray);
                
            } 
            
            // $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
            // Incrementar el contador del Excel
            $rowCount++; 
    }
     
    //////////////////////////////////////////////////////////////////////////
    /********** Exportación del fichero ***********/
    $fecha=$_POST['monthNum']."_".$_POST['yearNum'];
    //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    //$fichero = $pathraiz.'/apps/jornada/excel/exports/jornada'.$user.$_POST['monthNum'].$_POST['yearNum'].'.xls';
    $fichero = $pathraiz.'/plugins/excel/exports/Pedidos_Material_'.$proveedor.'.xls';

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    // Write the Excel file to filename some_excel_file.xlsx in the current directory
    $objWriter->save($fichero); 
    //echo '/apps/jornada/excel/exports/jornada'.$user.$_POST['monthNum'].$_POST['yearNum'].'.xls';
    echo '/erp/plugins/excel/exports/Pedidos_Material_'.$proveedor.'.xls';
    
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