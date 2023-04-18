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
    $styleArray = array(
        'borders' => array(
          'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
          )
        )
      );
    
    $matid=$_GET['matid'];
    $criteria=" WHERE PEDIDOS_PROV_DETALLES.material_id = ".$_GET['matid'];
    
    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel(); 
    $rowCount=1;   
    // Select de los detalles que los pedidos que contengan ese material
    $sql = $sql = "SELECT 
                    PEDIDOS_PROV.id,
                    PEDIDOS_PROV.pedido_genelek,
                    PEDIDOS_PROV.titulo,
                    PROVEEDORES.nombre,
                    PEDIDOS_PROV.fecha,
                    PEDIDOS_PROV.fecha_entrega,
                    erp_users.nombre,
                    PROYECTOS.nombre,
                    PEDIDOS_PROV_ESTADOS.nombre, 
                    CLIENTES.nombre, 
                    CLIENTES.img,
                    PEDIDOS_PROV_ESTADOS.color,
                    PEDIDOS_PROV.total,
                    PEDIDOS_PROV.ref_oferta_prov,
                    PEDIDOS_PROV.estado_id
                FROM 
                    PEDIDOS_PROV
                INNER JOIN PEDIDOS_PROV_ESTADOS
                    ON PEDIDOS_PROV.estado_id = PEDIDOS_PROV_ESTADOS.id 
                INNER JOIN PROVEEDORES 
                    ON PEDIDOS_PROV.proveedor_id = PROVEEDORES.id 
                INNER JOIN erp_users 
                    ON PEDIDOS_PROV.tecnico_id = erp_users.id 
		LEFT JOIN PEDIDOS_PROV_DETALLES
		    ON PEDIDOS_PROV_DETALLES.pedido_id = PEDIDOS_PROV.id 
                LEFT JOIN PROYECTOS
                    ON PEDIDOS_PROV.proyecto_id = PROYECTOS.id  
                LEFT JOIN CLIENTES
                    ON PROYECTOS.cliente_id = CLIENTES.id
                ".$criteria."
                GROUP BY 
                    PEDIDOS_PROV.id 
                ORDER BY 
                    PEDIDOS_PROV.fecha DESC, PEDIDOS_PROV.pedido_genelek DESC";
        
    file_put_contents("queryPedMat.txt", $sql);
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de los pedidos del material: ".$matid);
        
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REF");
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Titulo");
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Proveedor");
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Proyecto | Cliente");
    $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':H'.$rowCount);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "Fecha");
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "Entrega");
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "De");
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Estado");
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(35);
    
    // Establecer color
    $objPHPExcel->getActiveSheet()
            ->getStyle('A'.$rowCount.':M'.$rowCount)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF5F9EFF');
    $rowCount++; // Ir a siguiente Fila
    while ($registros = mysqli_fetch_array($resultado)) {
        
        // si es mayor que 2 el rowcount meter el titulo?¿?¿
        if($rowCount>2){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REF");
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Titulo");
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Proveedor");
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Proyecto | Cliente");
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':H'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "Fecha");
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "Entrega");
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "De");
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Estado");
            
            // Establecer color
            $objPHPExcel->getActiveSheet()
                    ->getStyle('A'.$rowCount.':M'.$rowCount)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF5F9EFF');
            
            $rowCount++;
        }
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $registros[1]);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
        
        if (($registros[15] <> 0) && ($registros[16] <> 0) && ($registros[17] <> 8)) {
            $colorestado = "primary-warning";
            $estadotitle = "A medias";
            $sql2 = "UPDATE PEDIDOS_PROV SET estado_id = 8 WHERE id = ".$registros[0];
            $resultadoAmedias = mysqli_query($connString, $sql2) or die("Error al actualizar Pedidos");
        } else {
            $colorestado = $registros[11];
            $estadotitle = $registros[8];
        }
            
        $fecha_entrega = strtotime($registros[5]);
        $fecha_entrega = date("Y-m-d", $fecha_entrega);
        if ((date("Y-m-d") > $fecha_entrega) && (($registros[17] < 4) || ($registros[17] > 7))) {
            $fecha_entrega = $registros[5]."<span class='blink_me' title='Pedido Retrasado'><img src='/erp/img/warning-test.png'></span>";
        } else {
            $fecha_entrega = $registros[5];
        }
        
        // Titulo Detalles
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $registros[2]);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $registros[3]);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $registros[7]."".$registros[9]);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':H'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $registros[4]);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $fecha_entrega);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $registros[6]." ".substr($registros[18],0,1));
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $estadotitle); // $colorestado
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
           
        $objPHPExcel->getActiveSheet()->getStyle('A1:M'.$rowCount)->applyFromArray($styleArray);
            
            /* COLORES?¿
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
            }*/
            
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
                    PEDIDOS_PROV_DETALLES.ref 
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
                 ".$criteria."
                AND PEDIDOS_PROV_DETALLES.pedido_id =".$registros[0]."
                 ORDER BY 
                    PEDIDOS_PROV_DETALLES.id ASC";
            file_put_contents("queryPedMatDetalle.txt", $sql);
            $resultado2 = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de materiales detalles");
            
            $rowCount++;
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REF");
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Material");
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Fabricante");
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Unidad");
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "PVP");
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "DTO");
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Importe");
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "IVA");
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "Recibido");
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "F. Rerecepcionado");
            $objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':K'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "F. Entrega");
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Proyecto");
            
            $objPHPExcel->getActiveSheet()->getStyle('A1:M'.$rowCount)->applyFromArray($styleArray);
            
            $objPHPExcel->getActiveSheet()
            ->getStyle('A'.$rowCount.':M'.$rowCount)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFA6A6A6');
                
            while ($registros2 = mysqli_fetch_array($resultado2)) {
                
                $rowCount++;
                
                // Calculos
                if($registros2[6]==0){
                    $recibido="NO";
                }else{
                    $recibido="SI";
                }
                
                $pvp = $registros2[5];
                $dto = $registros2[14];
                $dto_precio = ($pvp*$dto)/100;
                $importe = $pvp-$dto_precio;
                
                
                //$objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $registros2[1]); // REF                
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $registros2[2]); // Material               
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $registros2[3]); // Fabricante    
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $registros2[4]); // Unidad    
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $pvp); // PVP
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $dto); // DTO         
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $importe); // Importe          
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $registros2[21]); // IVA            
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $recibido); // Recibido               
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $registros2[7]); // F. Recepcionado
                $objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':K'.$rowCount);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $registros2[16]); // F. Entrega               
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $registros2[8]); // Proyecto               
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
                
                $objPHPExcel->getActiveSheet()->getStyle('A1:M'.$rowCount)->applyFromArray($styleArray);
                
            } 
            
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
            // Increment the Excel row counter
            $rowCount++; 
    }
     
    //////////////////////////////////////////////////////////////////////////
    /********** Exportación del fichero ***********/
    $fecha=$_POST['monthNum']."_".$_POST['yearNum'];
    //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    //$fichero = $pathraiz.'/apps/jornada/excel/exports/jornada'.$user.$_POST['monthNum'].$_POST['yearNum'].'.xls';
    $fichero = $pathraiz.'/plugins/excel/exports/Pedidos_Material_'.$matid.'.xls';

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    // Write the Excel file to filename some_excel_file.xlsx in the current directory
    $objWriter->save($fichero); 
    //echo '/apps/jornada/excel/exports/jornada'.$user.$_POST['monthNum'].$_POST['yearNum'].'.xls';
    echo '/erp/plugins/excel/exports/Pedidos_Material_'.$matid.'.xls';
    
    //return '/erp/plugins/excel/exports/Pedidos_Material_'.$matid.'.xls';
    
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