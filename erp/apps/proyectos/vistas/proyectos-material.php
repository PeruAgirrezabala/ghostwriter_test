<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['id'])) {                
    $sql = "SELECT 
                PROYECTOS_MATERIALES.id,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                PROYECTOS_MATERIALES.unidades,
                MATERIALES_PRECIOS.pvp, 
                PROYECTOS.nombre
            FROM 
                PROYECTOS_MATERIALES
            INNER JOIN MATERIALES
                ON PROYECTOS_MATERIALES.material_id = MATERIALES.id 
            INNER JOIN MATERIALES_PRECIOS 
                ON MATERIALES_PRECIOS.material_id = MATERIALES.id
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = PROYECTOS_MATERIALES.proyecto_id  
            WHERE
                PROYECTOS_MATERIALES.proyecto_id = ".$_GET['id']." 
            ORDER BY 
                PROYECTOS_MATERIALES.id ASC";
    
    $sql = "SELECT DISTINCT
                PROYECTOS_MATERIALES.id as idmat,
                MATERIALES.ref,  
                MATERIALES.nombre,
                MATERIALES.fabricante,
                PROYECTOS_MATERIALES.unidades,
                MATERIALES_PRECIOS.pvp, 
                PROYECTOS.nombre,
                MATERIALES_PRECIOS.dto_material, 
                PROYECTOS_MATERIALES.dto_prov_activo, 
                PROYECTOS_MATERIALES.dto_mat_activo, 
                PROYECTOS_MATERIALES.dto_ad_activo, 
                PROVEEDORES_DTO.dto_prov, 
                PROYECTOS_MATERIALES.dto, 
                PROYECTOS_MATERIALES.material_id,
                PROYECTOS_MATERIALES.material_tarifa_id,
                (SELECT GROUP_CONCAT(ENVIOS_CLI.ref) FROM ENVIOS_CLI, ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI.id = ENVIOS_CLI_DETALLES.envio_id AND ENVIOS_CLI_DETALLES.material_proyecto_id = idmat) as albREF,
                PROYECTOS_MATERIALES.pedido_detalle_id
            FROM 
                PROYECTOS_MATERIALES
            INNER JOIN MATERIALES
                ON PROYECTOS_MATERIALES.material_id = MATERIALES.id 
            LEFT JOIN MATERIALES_PRECIOS 
                ON MATERIALES_PRECIOS.id = PROYECTOS_MATERIALES.material_tarifa_id 
            LEFT JOIN PROYECTOS 
                ON PROYECTOS.id = PROYECTOS_MATERIALES.proyecto_id 
            LEFT JOIN PROVEEDORES_DTO 
                ON PROVEEDORES_DTO.id = PROYECTOS_MATERIALES.dto_prov_id
            INNER JOIN ENVIOS_CLI_DETALLES
                ON PROYECTOS.id = ENVIOS_CLI_DETALLES.proyecto_id 
            WHERE
                PROYECTOS_MATERIALES.proyecto_id = ".$_GET['id']." 
            ORDER BY 
                MATERIALES_PRECIOS.proveedor_id ASC, MATERIALES.ref ASC";

    file_put_contents("array0M.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    $html .= "<table class='table table-striped table-hover table-condensed' id='tabla-detalles-pedidos'>
                <thead>
                    <tr class='bg-dark'>
                        <!--<th class='text-center'>A</th>-->
                        <th class='text-center'>REF</th>
                        <th class='text-center'>MATERIAL</th>
                        <th class='text-center'>FABRICANTE</th>
                        <th class='text-center'>UNID.</th>
                        <th class='text-center'>PRECIO TARIFA</th>
                        <th class='text-center'>DTO %</th>
                        <th class='text-center'>COSTE</th>
                        <th class='text-center'>COSTE TOTAL</th>
                        <th class='text-center'>E</th>
                        <th class='text-center'>AL</th>
                    </tr>
                </thead>
                <tbody>";
    
    $total = 0;
    $totalDTO = 0;
    $totalPVP = 0;
    while( $row = mysqli_fetch_array($res) ) {
        $cantidad = $row[4];
        $pvpMat = $row[5];
        $dtoProvActivo = $row[8];
        $dtoMatActivo = $row[9];
        $dtoProv = $row[11];
        $dtoMat = $row[12];
        //$albREFs = explode(",",$row[15]);
        
//        if ($row[16] != "") {
//            $envioDatos = explode(",",$row[16]);
//            
//            
//            $sumUnidadesEnvios = 0;
//            $contador = 0;
//            foreach ($envioDatos as $value) {
//                $envioUnidades = explode("-",$value);
//                $sumUnidadesEnvios = $sumUnidadesEnvios + $envioUnidades[1];
//                
//                //$botonEnviado = "<button class='btn-default view-envio' data-id='".$envioID."' title='Ver Albarán'><img src='/erp/img/proveedores.png' style='height: 20px;'></button>";
//                $botonEnviado = "<a class='view-envio' data-id='".$envioUnidades[0]."' title='Ver Albarán'>".$albREFs[$contador]."</a><br>";
//                $contador = $contador + 1;
//            }
//            
//            // si las unidades totales de todos los envios para este material son mayores o iguales que las utilizadas en el proyecto par aeste material, pintamos de verde, sino, de amarillo
//            if ($sumUnidadesEnvios >= $cantidad) {
//                $difUnidades = $cantidad - $sumUnidadesEnvios;
//                $trEnviado = " style='background-color: #b8fccc !important;' title='Unidades restantes por enviar: ".$difUnidades."'";
//            }
//            else {
//                $difUnidades = $cantidad - $sumUnidadesEnvios;
//                $trEnviado = " style='background-color: #ffd29c !important;' title='Unidades restantes por enviar: ".$difUnidades."'";
//            }
//        }
//        else {
//            $trEnviado = "";
//            $botonEnviado = "";
//        }
        
        $ped_det_id = $row[16];
        $sqlEnvioID = "SELECT ENVIOS_CLI_DETALLES.envio_id FROM ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI_DETALLES.pedido_detalle_id=".$ped_det_id;
        file_put_contents("selectEnvioID.txt", $sqlEnvioID);
        $resEnvioID = mysqli_query($connString, $sqlEnvioID) or die("Error Select Envio ID");
        $rowEnvioID = mysqli_fetch_array($resEnvioID);
        
        $envioID = $rowEnvioID[0]; // Recalcular el envio ID dependiendo del pedido_detalle_id y el ENVIOS_CLI_DETALLES
        
        //$envioUD = $row[16];
        $dto_sum = 0;
        $pvp_dto = 0;
        
        // Solo si existe envio!?
        if($envioID!=""){
            $botonEnviado="<button class='btn-default view-envio' data-id='".$envioID."' title='Ver Envío'><img src='/erp/img/proveedores.png' style='height: 20px;'></button>";
        }else{
            $botonEnviado="";
        }
        
        
        if ($dtoProvActivo == 1) {
            $dto_sum  = $dto_sum + $dtoProv;
        }
        if ($dtoMatActivo == 1) {
            $dto_sum  = $dto_sum + $dtoMat;
        }
                    
        if ($row[6] == 0) {
            $recibidoDet = "NO";
        }
        else {
            $recibidoDet = "SI";
        }
        
        $subtotal = ($pvpMat*$cantidad);
        $dto = ($subtotal*$dto_sum)/100;
        $subtotalDTOPROVapli = $subtotal-$dto;
        
        $totalPVP = $totalPVP + $subtotal;
        $totalDTO = $totalDTO + $dto;
        $totalCosteMaterial = $totalCosteMaterial + $subtotalDTOPROVapli;
        
        $ped_det_id=$row[16];
        $sqlEntregado = "SELECT ENVIOS_CLI_DETALLES.entregado FROM ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI_DETALLES.pedido_detalle_id=".$ped_det_id;
        file_put_contents("selectEntregado.txt", $sqlEntregado);
        $resEntregado = mysqli_query($connString, $sqlEntregado) or die("error select entregado 1/0");
        $rowEntregado = mysqli_fetch_array($resEntregado);
        
        if($rowEntregado[0]==1){
            // entregado
            $habilitado="disabled";
        }else{
            // no entregado
            $habilitado="";
        }
        // Ver envio Boton: Link!
        $html .= "
                <tr data-id='".$row[0]."' ".$trEnviado.">
                    <!--<td class='text-center'><input type='checkbox' class='to-alb' data-matprojid='".$row[0]."'></td>-->
                    <td>".$row[1]."</td>
                    <td>".$row[2]."</td>
                    <td>".$row[3]."</td>
                    <td class='text-center'>".$row[4]."</td>
                    <td class='text-right'>".$row[5]."</td>
                    <td class='text-right'>".number_format($dto_sum, 2)."</td>
                    <td class='text-right'>".number_format($subtotal, 2)."</td>
                    <td class='text-right'>".number_format($subtotalDTOPROVapli, 2)."</td>
                    <td class='text-center'><button ".$habilitado." class='btn btn-circle btn-danger remove-mat' data-id='".$row[0]."' title='Eliminar Material.'><img src='/erp/img/cross.png'></button></td>
                    <td class='text-center'>".$botonEnviado."</td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    $totalCosteMaterial=$totalPVP-$totalDTO;
    echo $html;
} //if isset btn_login

?>

<div class="row pvp_gastos_total" style="margin-left: 0px; margin-right: 0px;">
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>PVP: </label> <label id='materiales_pvp' class="precio_right_vistas"> <? echo number_format((float)$totalPVP, 2, ',', '.'); ?> €</label> </div>
    <div class="col-sm-3"><label class='viewTitle resumen-title-vistas'>DTO: </label> <label id='materiales_dto' class="precio_right_vistas"> <? echo number_format((float)$totalDTO, 2, ',', '.'); ?> €</label></div>
    <div class="col-sm-3" style="background-color: #000000; float: right;"><label class='viewTitle resumen-title-vistas'>TOTAL: </label> <label id='materiales_total' class="precio_right_total_vistas"> <? echo number_format((float)$totalCosteMaterial, 2, ',', '.'); ?> €</label></div>
</div>



<!-- /MATERIALES -->
