
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['cliente_del'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delCliente();
    }    
    else {
        if ($_POST['newcliente_idcliente'] != "") {
            updateCliente();
        }
        else {
            insertCliente();
        }
    }
    
    function insertCliente() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        $target_dir = $pathraiz."/img/";
        $target_file = $target_dir . basename(preg_replace("[\s+]","",$_POST["newcliente_nombre"])."_".$_FILES["newcliente_logo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        //
        // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                //echo "No se h apodido subir el fichero";
        // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["newcliente_logo"]["tmp_name"], $target_file)) {
                    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    $target_file = "'/erp/img/".preg_replace("[\s+]","",$_POST["newcliente_nombre"])."_".$_FILES["newcliente_logo"]["name"]."'";
                } else {
                    //echo "No se h apodido subir el fichero";
                    $target_file = "'/erp/img/default.png'";
                }
            }
        
        $sql = "INSERT INTO CLIENTES (
                    nombre,
                    direccion,
                    poblacion,
                    provincia,
                    cp,
                    pais,
                    telefono,
                    nif,
                    web,
                    email,
                    img
                    )
                VALUES (
                    '".$_POST["newcliente_nombre"]."',
                    '".$_POST["newcliente_direccion"]."',
                    '".$_POST["newcliente_poblacion"]."',
                    '".$_POST["newcliente_provincia"]."',
                    '".$_POST["newcliente_cp"]."',
                    '".$_POST["newcliente_pais"]."',
                    '".$_POST["newcliente_telefono"]."',
                    '".$_POST["newcliente_nif"]."',
                    '".$_POST["newcliente_web"]."',
                    '".$_POST["newcliente_email"]."',
                    ".$target_file." 
                    )";
        
        //file_put_contents("insertCliente.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Cliente");
    }
    
    function updateCliente() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        if ($_FILES["newcliente_logo"]["name"] != "") {
            $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
            $target_dir = $pathraiz."/img/";
            $target_file = $target_dir . basename(preg_replace("[\s+]","",$_POST["newcliente_nombre"])."_".$_FILES["newcliente_logo"]["name"]);
            $uploadOk = 1;
            //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


            // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    //echo "No se h apodido subir el fichero";
                    
            // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["newcliente_logo"]["tmp_name"], $target_file)) {
                        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                        $target_file = ", img = '/erp/img/".preg_replace("[\s+]","",$_POST["newcliente_nombre"])."_".$_FILES["newcliente_logo"]["name"]."'";
                    } else {
                        //echo "No se h apodido subir el fichero";
                        file_put_contents("targetfile.txt", $target_file);
                        $target_file = "";
                    }
                }
        }
        else {
            $target_file = "";
        }
        
        $sql = "UPDATE CLIENTES 
                SET nombre = '".$_POST['newcliente_nombre']."', 
                    direccion = '".$_POST['newcliente_direccion']."', 
                    poblacion = '".$_POST['newcliente_poblacion']."',  
                    provincia = '".$_POST['newcliente_provincia']."', 
                    cp = '".$_POST['newcliente_cp']."', 
                    pais = '".$_POST['newcliente_pais']."', 
                    telefono = '".$_POST['newcliente_telefono']."', 
                    nif = '".$_POST['newcliente_nif']."',  
                    web = '".$_POST['newcliente_web']."',
                    email = '".$_POST['newcliente_email']."'
                    ".$target_file."     
                WHERE id = ".$_POST['newcliente_idcliente'];
        
        //file_put_contents("updateCliente.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Cliente");
    }

    function delCliente() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from CLIENTES WHERE id=".$_POST['cliente_del'];

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Cliente");
    }
?>
	