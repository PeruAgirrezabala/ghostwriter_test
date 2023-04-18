
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");

    if ($_POST['indicador_delindicador'] != "") {
        deleteCalidadSistema();
    }
    else {
        if ($_POST['calidad_sistema_id'] != "") {
            updateCalidadSistema();
        }  
        else {
            insertCalidadSistema();
        }
    }
    
    
    function updateCalidadSistema() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if($_POST['calidad_sistema_habilitado']==true){
            $habilitado="on";
        }else{
            $habilitado="off";
        }
        
        $sql = "UPDATE CALIDAD_SISTEMA SET 
                        nombre = '".$_POST['calidad_sistema_nombre']."', 
                        organismo_id = '".$_POST['calidad_sistema_organismo']."',
                        habilitado = '".$_POST['txt_habilitado']."'    
                    WHERE id = ".$_POST['calidad_sistema_id'];
        file_put_contents("updateCaliadSistema.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar CALIDAD_SISTEMA. UPDATE");
    }
        
    function insertCalidadSistema() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if($_POST['calidad_sistema_habilitado'] == true){
            $habilitado="on";
        }else{
            $habilitado="off";
        }
        
        $sql = "INSERT INTO CALIDAD_SISTEMA 
                            (nombre,
                            organismo_id,
                            habilitado)
                       VALUES (
                            '".$_POST['calidad_sistema_nombre']."', 
                            '".$_POST['calidad_sistema_organismo']."',
                            '".$_POST['txt_habilitado']."'    
                        )";
        file_put_contents("insertCalidadSistema.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar CALIDAD_SISTEMA. INSERT");
    }
    
    function deleteCalidadSistema() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CALIDAD_INDICADORES WHERE id = ".$_POST['indicador_delindicador'];
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Indicador");
    }
   
?>
	