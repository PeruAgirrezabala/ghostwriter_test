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
    file_put_contents("LOG15-2.txt", $_POST['tipo']);
    
if(isset($_POST['pathFile'])) {
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $data = array();
    
    switch ($_POST['tipo']){
        case "ENSAYO":
            
            $sqlSelect="SELECT ENSAYOS.nombre FROM ENSAYOS WHERE id=".$_POST["ensayo_id"];
            file_put_contents("selectEnsayos.txt", $sqlSelect);
            $result = mysqli_query($connString, $sqlSelect) or die("Error al realizar select de Nombre de ensayo");
            $registros = mysqli_fetch_row ($result);
            $nombreDOC = str_replace("/","-",str_replace(" ", "_", $registros[0])); 
            $sqlResetDocEnviar = "INSERT INTO ENSAYOS_ADJUNTOS 
                                    (nombre,ensayo_id,path) VALUES
                                      ('".$nombreDOC.$_POST["doc_fecha"]."',".$_POST["ensayo_id"].",'".$_POST['pathFile'][0]."')";
            file_put_contents("insertDocEnsayo.txt", $sqlResetDocEnviar);
            echo $result = mysqli_query($connString, $sqlResetDocEnviar) or die("Error al insertar ENSAYOS_ADJUNTOS");
            break;
        case "ENTREGA":
            $sqlResetDocEnviar = "INSERT INTO ENTREGAS_DOC 
                                    (titulo,descripcion,entrega_id,doc_path) VALUES
                                      ('".$_POST["titulo"]."','".$_POST["descripcion"]."',".$_POST["entrega_id"].",'".$_POST['pathFile'][0]."')";
            file_put_contents("insertDocEntrega.txt", $sqlResetDocEnviar);
            echo $result = mysqli_query($connString, $sqlResetDocEnviar) or die("Error al insertar ENSAYOS_ADJUNTOS");
            break;
    }

} //if isset btn_login



?>
