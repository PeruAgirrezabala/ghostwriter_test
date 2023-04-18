<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    //require('includes/excel2/php-excel-reader/excel_reader2.php');
    //require('includes/excel2/SpreadsheetReader_CSV.php');
    
    //date_default_timezone_set('UTC');
    //$StartMem = memory_get_usage();
    
    //$datos = fgetcsv($_POST['pathCSV'][0], 1000, ";");
    //file_put_contents("csv.txt", $datos);
    //$prueba = file_get_contents($_POST['pathCSV'][0]);
    //file_put_contents("csv.txt", $prueba);
    
if(isset($_POST['pathFile'])) {
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $data = array();
    
    switch ($_POST['tipo']){
        case "PROCESOS":
            $sqlResetDocEnviar = "UPDATE CALIDAD_PROCESOS 
                                    SET 
                                      doc_path = '".$_POST['pathFile'][0]."' 
                                    WHERE id = ".$_POST['doc_id'];
            file_put_contents("insertDoc.txt", $sqlResetDocEnviar);
            echo $result = mysqli_query($connString, $sqlResetDocEnviar) or die("Error al actualizar doc_path. PROCESOS");
            break;
        case "ACTA":
            $sqlResetDocEnviar = "UPDATE CALIDAD_ACTAS 
                                    SET 
                                      path_doc = '".$_POST['pathFile'][0]."' 
                                    WHERE id = ".$_POST['doc_id'];
            file_put_contents("insertDoc.txt", $sqlResetDocEnviar);
            echo $result = mysqli_query($connString, $sqlResetDocEnviar) or die("Error al actualizar doc_path. ACTAS");
            break;
        case "CALIBRACIONES":
            $sqlResetDocEnviar = "UPDATE CALIDAD_CALIBRACIONES 
                                    SET 
                                      doc_path = '".$_POST['pathFile'][0]."' 
                                    WHERE id = ".$_POST['doc_id'];
            file_put_contents("insertDoc.txt", $sqlResetDocEnviar);
            echo $result = mysqli_query($connString, $sqlResetDocEnviar) or die("Error al actualizar doc_path. CALIBRACIONES");
            break;
        case "FORMACION":
            $sqlResetDocEnviar = "UPDATE CALIDAD_FORMACION 
                                    SET 
                                      doc_path = '".$_POST['pathFile'][0]."' 
                                    WHERE id = ".$_POST['doc_id'];
            file_put_contents("insertDoc.txt", $sqlResetDocEnviar);
            echo $result = mysqli_query($connString, $sqlResetDocEnviar) or die("Error al actualizar doc_path. FORMACION");
            break;
        case "SIS_CALIDAD":
            $sqlResetDocEnviar = "UPDATE CALIDAD_SISTEMA 
                                    SET 
                                      doc_path = 'file:////192.168.3.108".$_POST['pathFile'][0]."' 
                                    WHERE id = ".$_POST['doc_id'];
            file_put_contents("insertDoc.txt", $sqlResetDocEnviar);
            echo $result = mysqli_query($connString, $sqlResetDocEnviar) or die("Error al actualizar doc_path. SIS_CALIDAD");
            break;
    }

} //if isset btn_login



?>
