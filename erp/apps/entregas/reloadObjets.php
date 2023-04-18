
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $sql="SELECT ENSAYOS.estado_id FROM ENSAYOS WHERE ENSAYOS.entrega_id=".$_POST["entrega_id"];
    $result = mysqli_query($connString, $sql) or die("Error al seleccionar estados de los ensayos");
    $habilitado=1;    
    $numfilas = mysqli_num_rows($result);
    if($numfilas==0){
        echo 3;
    }else{
        while ($row = mysqli_fetch_array($result)) {
            if($row[0]!=2){
                $habilitado=2;
                break;
            }
        }
        if($habilitado==1){
            // En caso de que ya se haya creado un envio para esta entrega no permitir que se haga otro!
            $sql="SELECT ENTREGAS.grupos_nombres_id FROM ENTREGAS WHERE ENTREGAS.id=".$_POST["entrega_id"];
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar estados de los ensayos");
            $row = mysqli_fetch_array($result);

            $sql="SELECT MATERIALES_GRUPOS.pedido_detalle_id FROM MATERIALES_GRUPOS WHERE MATERIALES_GRUPOS.grupos_nombres_id=".$row[0];
            $result = mysqli_query($connString, $sql) or die("Error al seleccionar los ped_det_ids del grupo");

            while ($row = mysqli_fetch_array($result)) {
                $sql="SELECT ENVIOS_CLI_DETALLES.envio_id FROM ENVIOS_CLI_DETALLES WHERE ENVIOS_CLI_DETALLES.pedido_detalle_id=".$row[0];
                $result = mysqli_query($connString, $sql) or die("Error CHECKEAR SI EXISTE EN ENVIOS EL PED_DET_ID");
                $rowEnvId = mysqli_fetch_array($result);
                if($rowEnvId[0]==""){
                    // No existe, OK
                }else{
                    // Existe, NOOK
                    $habilitado=$rowEnvId[0];
                    break;
                }
            }
        }
        echo $habilitado;
    }
    
?>
	