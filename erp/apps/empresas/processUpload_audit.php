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

    $sql = "INSERT INTO AUDITORES_DOC 
                (nombre,
                descripcion,
                doc_path,
                fecha_subida,
                auditor_id
                )
            VALUES ('".$_POST['nombre']."',
            '".$_POST['descripcion']."',
            '".$_POST['pathFile'][0]."',
            now(),
            ".$_POST['auditor_id'].")";
    file_put_contents("insertAuditoresDOC.txt", $sql);
    echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento");
} //if isset btn_login
else {
    if(isset($_POST['delDoc'])) {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();

        $sql = "DELETE FROM AUDITORES_DOC WHERE id = ".$_POST['delDoc'];
        file_put_contents("deleteAuditoresDOC.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Documento");
    }
    else {
        echo 1;
    }
}


?>
