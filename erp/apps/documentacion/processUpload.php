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
    
    switch ($_POST['tipo']) {
        case "doc":
            $sql = "INSERT INTO DOCUMENTACION_VERSIONES 
                        (documento_id,
                        doc_path,
                        fecha_exp
                        )
                    VALUES (".$_POST['doc_id'].",
                    '".$_POST['pathFile'][0]."',
                    '".$_POST['fecha_exp']."')";
            break;
    }
    
    file_put_contents("insertVerDocumento.txt", $sql);
    echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Documento");
} //if isset btn_login



?>
