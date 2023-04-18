
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['editacceso_del'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delAcceso();
    }    
    else {
        if ($_POST['editacceso_id'] != "") {
            updateAcceso();
        }
        else {
            if($_POST["editacceso_autojornada"] == 1) {
                autoAcceso();
            }
            else {
                if($_POST["txartela"] != "") {
                    insertAccesoTxartela();
                }
                else {
                    insertAcceso();
                }
            }
        }
    }
    
    function autoAcceso() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO JORNADAS_ACCESOS (
                    jornada_id,
                    hora_entrada,
                    hora_salida
                    )
                VALUES (
                    ".$_POST["editacceso_idjornada"].",
                    CONCAT(CURDATE(),' ','08:00:00'),
                    CONCAT(CURDATE(),' ','13:00:00')
                    )";
        //file_put_contents("insertAcceso1.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
        
        if ($_POST["editacceso_tipojornada"] != 2) {
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada,
                        hora_salida
                        )
                    VALUES (
                        ".$_POST["editacceso_idjornada"].",
                        CONCAT(CURDATE(),' ','14:30:00'),
                        CONCAT(CURDATE(),' ','17:30:00')
                        )";
            //file_put_contents("insertAcceso2.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
        }
        echo 1;
    }
    
    function insertAcceso() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if (($_POST["editacceso_horasalida"] != "") && ($_POST["editacceso_horasalida"] != "00:00")) {
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada,
                        hora_salida
                        )
                    VALUES (
                        '".$_POST["editacceso_idjornada"]."',
                        '".$_POST["editacceso_dia"]." ".$_POST["editacceso_horaentrada"]."',
                        '".$_POST["editacceso_dia"]." ".$_POST["editacceso_horasalida"]."'
                    )";
        }
        else {
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada
                        )
                    VALUES (
                        '".$_POST["editacceso_idjornada"]."',
                        '".$_POST["editacceso_dia"]." ".$_POST["editacceso_horaentrada"]."'
                    )";
        }
        
        //file_put_contents("insertAcceso.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Cliente");
    }
    
    function updateAcceso() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if (($_POST["editacceso_horasalida"] != "") && ($_POST["editacceso_horasalida"] != "00:00")) {
            $sql = "UPDATE JORNADAS_ACCESOS 
                    SET hora_entrada = '".$_POST["editacceso_dia"]." ".$_POST['editacceso_horaentrada']."', 
                        hora_Salida = '".$_POST["editacceso_dia"]." ".$_POST['editacceso_horasalida']."' 
                    WHERE id = ".$_POST['editacceso_id'];
        }
        else {
            $sql = "UPDATE JORNADAS_ACCESOS 
                    SET hora_entrada = '".$_POST["editacceso_dia"]." ".$_POST['editacceso_horaentrada']."' 
                    WHERE id = ".$_POST['editacceso_id'];
        }
        
        //file_put_contents("updateAcceso.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
    }
    
    function insertAccesoTxartela() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT JORNADAS.id 
                    FROM 
                        JORNADAS, CALENDARIO, erp_users  
                    WHERE
                        JORNADAS.calendario_id = CALENDARIO.id 
                    AND
                        JORNADAS.user_id = erp_users.id 
                    AND
                        CALENDARIO.fecha = CURDATE()
                    AND
                        erp_users.txartela = '".$_POST["txartela"]."'";
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Calendario");
    
        $registros = mysqli_fetch_row($resultado);
        $jornada_id = $registros[0];
        
        if ($jornada_id == "") {
            echo 99;
        }
        else {
            $sql = "SELECT hora_salida, id  
                        FROM 
                            JORNADAS_ACCESOS
                        WHERE
                            jornada_id = '".$jornada_id."' 
                        ORDER BY 
                            id DESC
                        LIMIT 1";

            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de los Accesos");
            $registros = mysqli_fetch_row($resultado);

            if ($registros[0] != '0000-00-00 00:00:00') {
                $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada
                        )
                    VALUES (
                        ".$jornada_id.",
                        now()
                        )";
            }
            else {
                $sql = "UPDATE JORNADAS_ACCESOS 
                        SET
                            hora_salida = now()
                        WHERE
                            id = ".$registros[1];
            }

            //file_put_contents("updateAccesoTxartela.txt", $sql);
            //mysqli_set_charset($connString, "utf8");
            echo $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
        }
    }

    function delAcceso() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from JORNADAS_ACCESOS WHERE id=".$_POST['editacceso_del'];

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Acceso");
    }
?>
	