
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");

    if ($_POST['conformidad_delconformidad'] != "") {
        deleteConformidad();
    }
    else {
        if ($_POST['conformidad_id'] != "") {
            updateConformidad();
        }  
        else {
            insertConformidad();
        }
    }
    
    
    function updateConformidad () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        switch ($_POST['conformidad_detectado1']){
            case "genelek":
                $detectado_id=$_POST['conformidad_detectado_genelek'];
                break;
            case "cliente":
                $detectado_id=$_POST['conformidad_detectado_cliente'];
                break;
            case "proveedor":
                $detectado_id=$_POST['conformidad_detectado_proveedor'];
                break;
            case "auditor":
                $detectado_id=$_POST['conformidad_detectado_auditor'];
                break;
        }
        
        $sql = "UPDATE CALIDAD_NOCONFORMIDADES SET 
                        detectado = ".$detectado_id.",
                        detectado_por = '".$_POST['conformidad_detectado1']."',
                        proyecto_id = ".$_POST['conformidad_proyectos'].", 
                        fecha = '".$_POST['conformidad_fecha']."', 
                        descripcion = '".$_POST['conformidad_desc']."',
                        resolucion = '".$_POST['conformidad_resolucion']."', 
                        causa = '".$_POST['conformidad_causa']."', 
                        cierre = '".$_POST['conformidad_cierre']."',
                        fecha_cierre = '".$_POST['conformidad_fecha_cierre']."' 
                    WHERE id = ".$_POST['conformidad_id'];
        file_put_contents("updateConformidad.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la No Conformidad. UPDATE");
    }
        
    function insertConformidad () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT COUNT(*) FROM CALIDAD_NOCONFORMIDADES WHERE YEAR(fecha) = YEAR(now())";
        $result = mysqli_query($connString, $sql) or die("Error al seleccionar el numero de No Conformidades");
        $registros = mysqli_fetch_row ($result);
        $numConformidades = $registros[0] + 1;
        
        $REF = "NC".date("y",strtotime($_POST["conformidad_fecha"])).str_pad($numConformidades, 4, '0', STR_PAD_LEFT);
        
        switch ($_POST['conformidad_detectado1']){
            case "genelek":
                $detectado_id=$_POST['conformidad_detectado_genelek'];
                break;
            case "cliente":
                $detectado_id=$_POST['conformidad_detectado_cliente'];
                break;
            case "proveedor":
                $detectado_id=$_POST['conformidad_detectado_proveedor'];
                break;
            case "auditor":
                $detectado_id=$_POST['conformidad_detectado_auditor'];
                break;
        }
        
        $sql = "INSERT INTO CALIDAD_NOCONFORMIDADES 
                            (ref,
                            detectado_por,
                            detectado,
                            proyecto_id,
                            fecha,
                            descripcion,
                            resolucion,
                            causa,
                            cierre,
                            fecha_cierre)
                       VALUES (
                            '".$REF."',
                            '".$_POST['conformidad_detectado1']."',
                            ".$detectado_id." ,
                            ".$_POST['conformidad_proyectos'].", 
                            '".$_POST['conformidad_fecha']."', 
                            '".$_POST['conformidad_desc']."',
                            '".$_POST['conformidad_resolucion']."',
                            '".$_POST['conformidad_causa']."',
                            '".$_POST['conformidad_cierre']."',
                            '".$_POST['conformidad_fecha_cierre']."' 
                        )";
        file_put_contents("insertConformidad.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar la No Conformidad. INSERT");
    }
    
    function deleteConformidad () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        //echo $_POST['indicador_delindicador'];
        $sql = "DELETE FROM CALIDAD_NOCONFORMIDADES WHERE id = ".$_POST['conformidad_delconformidad'];
        file_put_contents("deleteConformidad.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la No Conformidad");
        //echo $_POST['indicador_delindicador'];
    }
   
?>
	