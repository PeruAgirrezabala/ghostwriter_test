
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['editacceso_del'] != "") {
        //file_put_contents("insert.txt", $_POST['jornada_id']);
        delAcceso();
    } else {
        if ($_POST['editacceso_id'] != "") {
            updateAcceso();
        } else {
            if($_POST["editacceso_autojornada"] == 1) {
                autoAcceso();
            } else {
                if($_POST["editacceso_autovacaciones"] == 1) {
                    autoVacaciones ();
                } else {
                    if($_POST["editacceso_automedico"] == 1) {
                        autoMedico();
                    } else {
                        if($_POST["txartela"] != "") {
                            insertAccesoTxartela();
                        } else {
                            insertAcceso();
                        }
                    }
                }
            }
        }
    }
    
    function autoAcceso() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $dbCorpo = new dbObjCorpo();
        $connStringCorpo =  $dbCorpo->getConnstring();

        
        if ($_POST["editacceso_tipojornada"] != 2) {
            
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                    jornada_id,
                    hora_entrada,
                    hora_salida,
                    tipo_horas
                    )
                VALUES (
                    ".$_POST["editacceso_idjornada"].",
                    CONCAT('".$_POST["editacceso_dia"]."',' ','08:00:00'),
                    CONCAT('".$_POST["editacceso_dia"]."',' ','13:00:00'),
                    1
                    )";
            file_put_contents("insertAcceso1.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
            //$result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
            
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada,
                        hora_salida,
                        tipo_horas
                        )
                    VALUES (
                        ".$_POST["editacceso_idjornada"].",
                        CONCAT('".$_POST["editacceso_dia"]."',' ','14:30:00'),
                        CONCAT('".$_POST["editacceso_dia"]."',' ','17:30:00'),
                        1
                        )";
            file_put_contents("insertAcceso2.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
            $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
        }else{
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                    jornada_id,
                    hora_entrada,
                    hora_salida,
                    tipo_horas
                    )
                VALUES (
                    ".$_POST["editacceso_idjornada"].",
                    CONCAT('".$_POST["editacceso_dia"]."',' ','08:00:00'),
                    CONCAT('".$_POST["editacceso_dia"]."',' ','14:00:00'),
                    1
                    )";
            file_put_contents("insertAcceso1.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
            $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
        }
        echo 1;
    }
    
    function autoVacaciones() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $dbCorpo = new dbObjCorpo();
        $connStringCorpo =  $dbCorpo->getConnstring();
        
        $sql = "SELECT jornada_id  
                    FROM JORNADAS_ACCESOS 
                    WHERE 
                    jornada_id = ".$_POST["editacceso_idjornada"]."
                    AND tipo_horas = 3";
        //file_put_contents("insertAcceso1.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
        $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
        
        if (mysqli_num_rows($result) > 0) {
            $sql = "DELETE FROM JORNADAS_ACCESOS 
                    WHERE
                        jornada_id = ".$_POST["editacceso_idjornada"]." 
                    AND tipo_horas = 3";
            //file_put_contents("insertAcceso1.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
            $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
        }
        else {
            $sql = "DELETE FROM JORNADAS_ACCESOS 
                    WHERE
                        jornada_id = ".$_POST["editacceso_idjornada"];
            //file_put_contents("insertAcceso1.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
            $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
            
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada,
                        hora_salida,
                        tipo_horas
                        )
                    VALUES (
                        ".$_POST["editacceso_idjornada"].",
                        CONCAT('".$_POST["editacceso_dia"]."',' ','08:00:00'),
                        CONCAT('".$_POST["editacceso_dia"]."',' ','13:00:00'),
                        3
                        )";
            //file_put_contents("insertAcceso1.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
            $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");

            if ($_POST["editacceso_tipojornada"] != 2) {
                $sql = "INSERT INTO JORNADAS_ACCESOS (
                            jornada_id,
                            hora_entrada,
                            hora_salida,
                            tipo_horas
                            )
                        VALUES (
                            ".$_POST["editacceso_idjornada"].",
                            CONCAT('".$_POST["editacceso_dia"]."',' ','14:30:00'),
                            CONCAT('".$_POST["editacceso_dia"]."',' ','17:30:00'),
                            3
                            )";
                //file_put_contents("insertAcceso2.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
                $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
            }
        }
        echo 1;
    }
    
    function autoMedico() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $dbCorpo = new dbObjCorpo();
        $connStringCorpo =  $dbCorpo->getConnstring();
        
        $sql = "INSERT INTO JORNADAS_ACCESOS (
                    jornada_id,
                    hora_entrada,
                    hora_salida,
                    tipo_horas
                    )
                VALUES (
                    ".$_POST["editacceso_idjornada"].",
                    CONCAT('".$_POST["editacceso_dia"]."',' ','08:00:00'),
                    CONCAT('".$_POST["editacceso_dia"]."',' ','13:00:00'),
                    2
                    )";
        //file_put_contents("insertAcceso1.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
        $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");        
        
        if ($_POST["editacceso_tipojornada"] != 2) {
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada,
                        hora_salida,
                        tipo_horas
                        )
                    VALUES (
                        ".$_POST["editacceso_idjornada"].",
                        CONCAT('".$_POST["editacceso_dia"]."',' ','14:30:00'),
                        CONCAT('".$_POST["editacceso_dia"]."',' ','17:30:00'),
                        2
                        )";
            //file_put_contents("insertAcceso2.txt", $sql);
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
            $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
        }
        echo 1;
    }
    
    function insertAcceso() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $dbCorpo = new dbObjCorpo();
        $connStringCorpo =  $dbCorpo->getConnstring();
        
        if (($_POST["editacceso_horasalida"] != "") && ($_POST["editacceso_horasalida"] != "00:00")) {
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada,
                        hora_salida,
                        tipo_horas
                        )
                    VALUES (
                        '".$_POST["editacceso_idjornada"]."',
                        '".$_POST["editacceso_dia"]." ".$_POST["editacceso_horaentrada"]."',
                        '".$_POST["editacceso_dia"]." ".$_POST["editacceso_horasalida"]."',
                        ".$_POST["editacceso_tipohora"]."  
                    )";
        }
        else {
            $sql = "INSERT INTO JORNADAS_ACCESOS (
                        jornada_id,
                        hora_entrada,
                        tipo_horas
                        )
                    VALUES (
                        '".$_POST["editacceso_idjornada"]."',
                        '".$_POST["editacceso_dia"]." ".$_POST["editacceso_horaentrada"]."', 
                        ".$_POST["editacceso_tipohora"]."  
                    )";
        }
        
        file_put_contents("insertAcceso.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
        echo $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
    }
    
    function updateAcceso() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $dbCorpo = new dbObjCorpo();
        $connStringCorpo =  $dbCorpo->getConnstring();
        
        if (($_POST["editacceso_horasalida"] != "") && ($_POST["editacceso_horasalida"] != "00:00")) {
            $sql = "UPDATE JORNADAS_ACCESOS 
                    SET hora_entrada = '".$_POST["editacceso_dia"]." ".$_POST['editacceso_horaentrada']."', 
                        hora_Salida = '".$_POST["editacceso_dia"]." ".$_POST['editacceso_horasalida']."', 
                        tipo_horas = ".$_POST["editacceso_tipohora"]."  
                    WHERE id = ".$_POST['editacceso_id'];
        }
        else {
            $sql = "UPDATE JORNADAS_ACCESOS 
                    SET hora_entrada = '".$_POST["editacceso_dia"]." ".$_POST['editacceso_horaentrada']."',
                        hora_Salida = '00:00:00', 
                        tipo_horas = ".$_POST["editacceso_tipohora"]."  
                    WHERE id = ".$_POST['editacceso_id'];
        }
        
        file_put_contents("updateAcceso.txt", $sql);
        //mysqli_set_charset($connString, "utf8");
        $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
        echo $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
    }
    
    function insertAccesoTxartela() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $dbCorpo = new dbObjCorpo();
        $connStringCorpo =  $dbCorpo->getConnstring();
        
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
            $sql = "SELECT erp_users.nombre, erp_users.apellidos
                        FROM 
                            erp_users  
                        WHERE
                            erp_users.txartela = '".$_POST["txartela"]."'";
        
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Trabajador");
            $registros = mysqli_fetch_row($resultado);
            $trabajador = $registros[0]." ".$registros[1];
            
            $sql = "SELECT JORNADAS_ACCESOS.hora_salida, JORNADAS_ACCESOS.id, erp_users.nombre, erp_users.apellidos     
                        FROM 
                            JORNADAS_ACCESOS, JORNADAS, erp_users
                        WHERE
                            JORNADAS_ACCESOS.jornada_id = JORNADAS.id
                        AND
                            JORNADAS.user_id = erp_users.id
                        AND
                            JORNADAS_ACCESOS.jornada_id = ".$jornada_id." 
                        ORDER BY 
                            JORNADAS_ACCESOS.id DESC
                        LIMIT 1";

            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de los Accesos");
            $registros = mysqli_fetch_row($resultado);
            
            if ($registros[0] != '0000-00-00 00:00:00') {
                $trabajador = "Hola ".$trabajador.". Que tengas un buen día de trabajo.";
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
                $trabajador = "Agur ".$trabajador.". Descansa.";
                $sql = "UPDATE JORNADAS_ACCESOS 
                        SET
                            hora_salida = now()
                        WHERE
                            id = ".$registros[1];
            }

            //file_put_contents("updateAccesoTxartela.txt", $sql);
            //mysqli_set_charset($connString, "utf8");
            
            $result = mysqli_query($connStringCorpo, $sql) or die("Error al guardar el Acceso en el Front");
            $result = mysqli_query($connString, $sql) or die("Error al guardar el Acceso");
            if ($result == 1) {
                echo $trabajador;
            }
        }
    }

    function delAcceso() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $dbCorpo = new dbObjCorpo();
        $connStringCorpo =  $dbCorpo->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from JORNADAS_ACCESOS WHERE id=".$_POST['editacceso_del'];
        
        $result = mysqli_query($connStringCorpo, $sql) or die("Error al eliminar el Acceso en el Front");
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Acceso");
    }
?>
	