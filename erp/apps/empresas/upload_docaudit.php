<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    // upload.php
    // 'csvs' refers to your file input name attribute
    if (empty($_FILES['uploaddocs_audit'])) {
        echo json_encode(['error'=>'No files found for upload.']); 
        // or you can throw an exception 
        return; // terminate
    }

    // get the files posted
    $uploaddocs = $_FILES['uploaddocs_audit'];

    // get user id posted
    //$userid = empty($_POST['userid']) ? '' : $_POST['userid'];

    // get user name posted
    //$username = empty($_POST['username']) ? '' : $_POST['username'];

    // a flag to see if everything is ok
    $success = null;

    $db = new dbObj();
    $connString =  $db->getConnstring();
    $data = array();

    $sql = "SELECT nombre FROM AUDITORES WHERE id = ".$_GET['id_auditor'];
    file_put_contents("selectAUDIT.txt", $sql);
    $result = mysqli_query($connString, $sql) or die("Error al seleccionar el nombre del Proveedor");
    $registros = mysqli_fetch_row ($result);
    $nombre = str_replace(".","",str_replace("/","-",str_replace(" ", "_", $registros[0])));        
    $path = "/".$nombre;
    
    // file paths to store
        $paths= [];
        $basepath = "ERP/AUDITORES".$path."/";
        $ftp_server = "192.168.3.108";
        $ftp_username = "admin";
        $ftp_password = "Sistemas2111";
        ///share/MD0_DATA/Download/
    
    // connection to ftp
        $ftp_connection = ftp_connect($ftp_server);
        $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
    
    // crear path del proveedor si no existiera
        if (ftp_nlist($ftp_connection, $basepath) === false) {
            // try to create directory $dir
            if (ftp_mkdir($ftp_connection, $basepath)) {
                //echo "Successfully created $basepath";
                $success = true;
            }
            else
            {
                //echo "Error while creating $basepath";
                $success = false;
            }
        }
    
    // get file names
    $filenames = $uploaddocs['name'];

    // loop and process files
    for($i=0; $i < count($filenames); $i++){
        //file_put_contents($filenames[$i].".txt", $filenames[$i]);
        $ext = explode('.', basename($filenames[$i]));
        //$target = "uploads" . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
        $target = $basepath.$filenames[$i];
        
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
    
    ftp_close($ftp_connection);

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