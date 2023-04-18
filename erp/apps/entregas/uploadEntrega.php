<?

    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    // upload.php
    // 'csvs' refers to your file input name attribute
    if (empty($_FILES['newentrega_adjunto'])) {
        echo json_encode(['error'=>'No files found for upload.']); 
        // or you can throw an exception 
        return; // terminate
    }

    // get the files posted
    $uploaddocs = $_FILES['newentrega_adjunto'];
    
    $nombreDOC = str_replace("/","-",str_replace(" ", "_", $_GET["nombredoc"])); 
    
    $sql = "SELECT path FROM ENTREGAS WHERE id = ".$_GET["entregaid"];
    file_put_contents("LOG13-2.txt", $sql);
    $result = mysqli_query($connString, $sql) or die("Error al seleccionar el Path de la Entrega");
    $registros = mysqli_fetch_row ($result);
    
    // a flag to see if everything is ok
    $success = null;
    function ftp_mksubdirs($ftpcon,$ftpbasedir,$ftpath){
        @ftp_chdir($ftpcon, $ftpbasedir); // /var/www/uploads
        $parts = explode('/',$ftpath); // 2013/06/11/username
        foreach($parts as $part){
           if(!@ftp_chdir($ftpcon, $part)){
              if ($part != "") {
                ftp_mkdir($ftpcon, $part);
                ftp_chdir($ftpcon, $part);
              }
              //ftp_chmod($ftpcon, 0777, $part);
           }
        }
     }
     
    // file paths to store
        $paths= [];
        $year = date("Y",strtotime($_GET["fecha"]));
        $month = date("m",strtotime($_GET["fecha"]));
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
        $day = date("d",strtotime($_GET["fecha"]));
        $basepath = "/PROYECTOS/".$registros[0];
        //file_put_contents("path.txt", $basepath);
        $ftp_server = "192.168.3.108";
        $ftp_username = "admin";
        $ftp_password = "Sistemas2111";
        ///share/MD0_DATA/Download/
    
    // connection to ftp
        $ftp_connection = ftp_connect($ftp_server);
        $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
    
    // crear path si no existiera
        ftp_mksubdirs($ftp_connection,"",$basepath);
    
    // get file names
    $filenames = $uploaddocs['name'];

    // loop and process files
    for($i=0; $i < count($filenames); $i++){
        //file_put_contents($filenames[$i].".txt", $filenames[$i]);
        $ext = explode('.', basename($filenames[$i]));
        //$target = "uploads" . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
        //$name = basename($filenames[$i], ".".$ext);
        //$target = $basepath.$filenames[$i];
        $target = $basepath.$nombreDOC."_".$day."_".$month."_".$year.".".array_pop($ext);
        $destination_directory=$target;
        $source_directory=$uploaddocs['tmp_name'][$i];
        
        $upload = ftp_put($ftp_connection, $destination_directory, $source_directory, FTP_ASCII);
        if ($upload == 1) {
            $success = true;
            $paths[] = $target;
        }
        else {
            $success = false;
        }       
        
        /*
        if(move_uploaded_file($uploaddocs['tmp_name'][$i], $target)) {
            $success = true;
            $paths[] = $target;
        } else {
            $success = false;
            break;
        }
        */
    }

    // check and process based on successful status 
    if ($success === true) {
        // call the function to save all data to database
        // code for the following function `save_data` is not 
        // mentioned in this example
        //save_data($userid, $username, $paths);

        // store a successful response (default at least an empty array). You
        // could return any additional response info you need to the plugin for
        // advanced implementations.
        $output = [];
        // for example you can get the list of files uploaded this way
        $output = ['uploaded' => $paths];
    } elseif ($success === false) {
        $output = ['error'=>'Error subiendo los ficheros.'];
        // delete any uploaded files
        foreach ($paths as $file) {
            unlink($file);
        }
    } else {
        $output = ['error'=>'Ningún fichero procesado.'];
    }

    // return a json encoded response for plugin to process successfully
    echo json_encode($output);
?>