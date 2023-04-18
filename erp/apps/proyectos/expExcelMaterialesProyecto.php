<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz.'/plugins/excel/PHPExcel.php');
    require_once($pathraiz.'/plugins/excel/PHPExcel/IOFactory.php');
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
        $rowCount=1;

        $db = new dbObj();
        $connString = $db->getConnstring();
        ////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////// SELECT MATERIAL ASIGNADO AL PROYECTO ////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////
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
                                        PEDIDOS_PROV_DETALLES.material_tarifa_id,
                                        PEDIDOS_PROV_DETALLES.dto_prov_id,
                                        PEDIDOS_PROV.estado_id,
                                        PEDIDOS_PROV.plazo,
                                        PEDIDOS_PROV_DETALLES.material_id
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
                                        PEDIDOS_PROV_DETALLES.proyecto_id = " . $_POST['proyecto_id'] . " 
                                    AND
                                        PEDIDOS_PROV.estado_id <> 4
                                    ORDER BY 
                                        PEDIDOS_PROV.pedido_genelek ASC, PEDIDOS_PROV_DETALLES.id ASC";

        //file_put_contents("array.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("database error:");
        
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REF");
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "MATERIAL");
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "FABRICANTE");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "UNIDAD");
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "PVP");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "DTO %");
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "IMPORTE");
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "F. RECEPCIONADO");
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "F. ENTREGA PREVISTA");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(130);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('777777');
        
        $iva = 0;
        $pedidoGroup = "";
        $contador = 0;
        $ref="";
        while ($row = mysqli_fetch_array($res)) {
            $rowCount++;
            $fecha_entrega = strtotime($row[16]);
            $fecha_entrega = date("Y-m-d", $fecha_entrega);
            
            if($refPed!=$row[25]){
                $refPed=$row[25];
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REF: ".$refPed." Fecha: ".$row[26]." Plazo: ".$row[31]." Fecha estimada de Entrega: ".$fecha_entrega." Proveedor: ".$row[27]);
                $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':I'.$rowCount)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('219AE0');
                $rowCount++;
            }
            
            if ($row[5] != "") {
                $pvp = $row[5];
            } else {
                $pvp = $row[9];
            }

            $dto_sum = 0;
            $pvp_dto = 0;
            $dto_extra = "";
            if ($row[11] == 1) {
                $dto_sum = $dto_sum + $row[14];
            }
            if ($row[12] == 1) {
                $dto_sum = $dto_sum + $row[10];
            }
            if ($row[13] == 1) {
                if ($row[19] == 1) {
                    $dto_extra = $row[15];
                } else {
                    $dto_sum = $dto_sum + $row[15];
                    $dto_extra = "";
                }
            }

            $ivaPercent = $row[21];
            $subtotal = ($pvp * $row[4]);
            $dto = ($subtotal * $dto_sum) / 100;
            $subtotalDtoApli = $subtotal - $dto;
            if ($row[19] == 1) {
                $dtoNeto = ($subtotalDtoApli * $dto_extra) / 100;
                $subtotalDtoApli = $subtotalDtoApli - $dtoNeto;
                $dto_extra = " + " . number_format($dto_extra, 2);
            } else {
                $dtoNeto = 0;
            }

            if ($row[6] == 0) {
                $recibidoDet = "NO";
            } else {
                $recibidoDet = "SI";
            }
            // pintas'??
            $pintar="";
            if ($recibidoDet == "SI") {
                $trcolor = "style='background-color: #b7fca4;'";
                $pintar = "Verde";
            } else {
                $disableButton = " ";
                $trcolor = "";
                $habilitado = "";
            }

            $sqlMaterial = "SELECT *
                                                FROM PROYECTOS_MATERIALES
                                                WHERE proyecto_id = " . $_POST['proyecto_id'] . "
                                                AND material_id = " . $row[18];
            //file_put_contents("log.txt", $sqlMaterial);
            $resMat = mysqli_query($connString, $sqlMaterial);
            $row_cnt_mat = mysqli_num_rows($resMat);

            if ($row_cnt_mat >= 1) {
                $trcolor = "style='background-color: #70a561;'";
                // Deshabiitar check
                $pintar = "Verde Oscuro";
            }

            if ($row[2] != "") {
                $material = $row[2];
            } else {
                $material = $row[22];
            }

            if ($row[1] != "") {
                $ref = $row[1];
            } else {
                $ref = $row[23];
            }
            switch($pintar){
                case "Verde":
                    $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':I'.$rowCount)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('b7fca4');
                    break;
                case "Verde Oscuro":
                    $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':I'.$rowCount)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('70a561');
                    break;
                case "":
                    
                    break;
            }
            // Comprobar si las fechas de recepción existen
            if($row[7]=="0000-00-00 00:00:00"){
                $frecep="";
            }else{
                $frecep=$row[7];
            }
            if($row[16]=="0000-00-00"){
                $fprevista="";
            }else{
                $fprevista=$row[16];
            }
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $ref);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $material);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row[3]);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row[4]);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $pvp);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($dto_sum, 2) . $dto_extra );
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $subtotalDtoApli);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $frecep); // Fecha recepcionado => PEDIDOS_PROV_DETALLES.fecha_recepcionado
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $fprevista); // Fecha Entrega prevista => PEDIDOS_PROV_DETALLES.fecha_entrega
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
            
            $importe = $importe + $subtotal;
            $totaldto = $totaldto + $dto + $dtoNeto;
            $iva = $iva + (($subtotal - ($dto + $dtoNeto)) * $ivaPercent / 100);
            $contador = $contador + 1;
            
            
        }
        ////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////// SELECT MATERIAL AÑADIDO DESDE ALMACEN ///////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////
        // Materiales añadidos desde el almacen        
        $sqlDet = "SELECT MATERIALES_STOCK.id,
                                            MATERIALES_STOCK.material_id,
                                            MATERIALES_STOCK.stock,
                                            MATERIALES_STOCK.ubicacion_id,
                                            MATERIALES_STOCK.proyecto_id,
                                            MATERIALES_STOCK.pedido_detalle_id
                                        FROM MATERIALES_STOCK
                                            INNER JOIN PEDIDOS_PROV_DETALLES
                                        ON MATERIALES_STOCK.pedido_detalle_id = PEDIDOS_PROV_DETALLES.id
                                        WHERE MATERIALES_STOCK.proyecto_id=".$_POST['proyecto_id']."
                                        AND PEDIDOS_PROV_DETALLES.proyecto_id=11";
        file_put_contents("arrayAlmacen.txt", $sqlDet);
        $resDet = mysqli_query($connString, $sqlDet) or die("database error:");
        
        while($rowDet = mysqli_fetch_array($resDet)){
                                    // SELECT cada uno para pintar
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
                                        PEDIDOS_PROV_DETALLES.material_tarifa_id,
                                        PEDIDOS_PROV_DETALLES.dto_prov_id,
                                        PEDIDOS_PROV.estado_id,
                                        PEDIDOS_PROV.plazo,
                                        PEDIDOS_PROV_DETALLES.material_id,
                                        MATERIALES_STOCK.stock,
                                        MATERIALES_STOCK.id
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
                                    INNER JOIN MATERIALES_STOCK 
                                        ON PEDIDOS_PROV_DETALLES.id = MATERIALES_STOCK.pedido_detalle_id
                                    WHERE
                                        PEDIDOS_PROV_DETALLES.id = ".$rowDet[5]." 
                                    AND
					MATERIALES_STOCK.ID = ".$rowDet[0]."
                                    ORDER BY 
                                        PEDIDOS_PROV.pedido_genelek ASC, PEDIDOS_PROV_DETALLES.id ASC";

                                file_put_contents("array3Almacen.txt", $sql);
                                $res = mysqli_query($connString, $sql) or die("database error:");
        
            while ($row = mysqli_fetch_array($res)) {
                $rowCount++;
                $fecha_entrega = strtotime($row[16]);
                $fecha_entrega = date("Y-m-d", $fecha_entrega);

                if($refPed!=$row[25]){
                    $refPed=$row[25];
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REF: ".$refPed." Fecha: ".$row[26]." Plazo: ".$row[31]." Fecha estimada de Entrega: ".$fecha_entrega." Proveedor: ".$row[27]);
                    $objPHPExcel->getActiveSheet()
                    ->getStyle('A'.$rowCount.':I'.$rowCount)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('219AE0');
                    $rowCount++;
                }

                if ($row[5] != "") {
                    $pvp = $row[5];
                } else {
                    $pvp = $row[9];
                }

                $dto_sum = 0;
                $pvp_dto = 0;
                $dto_extra = "";
                if ($row[11] == 1) {
                    $dto_sum = $dto_sum + $row[14];
                }
                if ($row[12] == 1) {
                    $dto_sum = $dto_sum + $row[10];
                }
                if ($row[13] == 1) {
                    if ($row[19] == 1) {
                        $dto_extra = $row[15];
                    } else {
                        $dto_sum = $dto_sum + $row[15];
                        $dto_extra = "";
                    }
                }

                $ivaPercent = $row[21];
                $subtotal = ($pvp * $row[4]);
                $dto = ($subtotal * $dto_sum) / 100;
                $subtotalDtoApli = $subtotal - $dto;
                if ($row[19] == 1) {
                    $dtoNeto = ($subtotalDtoApli * $dto_extra) / 100;
                    $subtotalDtoApli = $subtotalDtoApli - $dtoNeto;
                    $dto_extra = " + " . number_format($dto_extra, 2);
                } else {
                    $dtoNeto = 0;
                }

                if ($row[6] == 0) {
                    $recibidoDet = "NO";
                } else {
                    $recibidoDet = "SI";
                }
                // pintas'??
                $pintar="";
                if ($recibidoDet == "SI") {
                    $trcolor = "style='background-color: #b7fca4;'";
                    $pintar = "Verde";
                } else {
                    $disableButton = " ";
                    $trcolor = "";
                    $habilitado = "";
                }

                $sqlMaterial = "SELECT *
                                                    FROM PROYECTOS_MATERIALES
                                                    WHERE proyecto_id = " . $_POST['proyecto_id'] . "
                                                    AND material_id = " . $row[18];
                //file_put_contents("log.txt", $sqlMaterial);
                $resMat = mysqli_query($connString, $sqlMaterial);
                $row_cnt_mat = mysqli_num_rows($resMat);

                if ($row_cnt_mat >= 1) {
                    $trcolor = "style='background-color: #70a561;'";
                    // Deshabiitar check
                    $pintar = "Verde Oscuro";
                }

                if ($row[2] != "") {
                    $material = $row[2];
                } else {
                    $material = $row[22];
                }

                if ($row[1] != "") {
                    $ref = $row[1];
                } else {
                    $ref = $row[23];
                }
                switch($pintar){
                    case "Verde":
                        $objPHPExcel->getActiveSheet()
                    ->getStyle('A'.$rowCount.':I'.$rowCount)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('b7fca4');
                        break;
                    case "Verde Oscuro":
                        $objPHPExcel->getActiveSheet()
                    ->getStyle('A'.$rowCount.':I'.$rowCount)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('70a561');
                        break;
                    case "":

                        break;
                }
                // Comprobar si las fechas de recepción existen
                if($row[7]=="0000-00-00 00:00:00"){
                    $frecep="";
                }else{
                    $frecep=$row[7];
                }
                if($row[16]=="0000-00-00"){
                    $fprevista="";
                }else{
                    $fprevista=$row[16];
                }
                
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $ref);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $material);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row[3]);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row[33]); // UNIDADES => MATERIALES_STOCK.stock
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $pvp);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($dto_sum, 2) . $dto_extra );
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $subtotalDtoApli);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $frecep); // Fecha recepcionado => PEDIDOS_PROV_DETALLES.fecha_recepcionado
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $fprevista); // Fecha entrega prevista => PEDIDOS_PROV_DETALLES.fecha_entrega
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);


                $importe = $importe + $subtotal;
                $totaldto = $totaldto + $dto + $dtoNeto;
                $iva = $iva + (($subtotal - ($dto + $dtoNeto)) * $ivaPercent / 100);
                $contador = $contador + 1;

            }
        
        }
        
        $sqlProyecto = "SELECT nombre
                                                FROM PROYECTOS
                                                WHERE id = " . $_POST['proyecto_id'];
        //file_put_contents("log.txt", $sqlProyecto);
        $resProyecto = mysqli_query($connString, $sqlProyecto);
        $rowProyecto = mysqli_fetch_array($resProyecto);
        
        
        $fichero = $pathraiz.'/plugins/excel/exports/materialesProyecto_'.$rowProyecto[0].'.xls';
        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // Write the Excel file to filename some_excel_file.xlsx in the current directory
        $objWriter->save($fichero); 

        echo "/erp/plugins/excel/exports/materialesProyecto_".$rowProyecto[0].".xls";
?>