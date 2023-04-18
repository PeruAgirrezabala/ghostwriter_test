
<?php

//include connection file 
$pathraiz = $_SERVER['DOCUMENT_ROOT'] . "/erp";
//include($pathraiz."/common.php");
require_once($pathraiz . "/connection.php");

if ($_POST['formacion_id'] != "") {
    addFormacionDetalles();
} else {
    if ($_POST['del_tecnico_id'] != "") {
        deleteFormacionDetalles();
    } else {
        if ($_POST['addTodosTecnicosFormacion'] != "") {
            addFormacionDetallesTodos();
        } else {
            if ($_POST['changeDate'] != ""){
                changeDateFormacionDetalles();
            }else{
                
            }
        }
    }
}

function addFormacionDetalles() {
    $db = new dbObj();
    $connString = $db->getConnstring();
    $posiciones = $_POST['posiciones'];

//    $sqlDelUsrs = "DELETE FROM 
//                        CALIDAD_FORMACION_DETALLES
//                   WHERE 
//                        CALIDAD_FORMACION_DETALLES.formacion_id =" . $_POST['formacion_id'];
//    file_put_contents("deleteTodosUsuarios.txt", $sqlDelUsrs);
//    $resultadoUsrs = mysqli_query($connString, $sqlDelUsrs) or die("Error al borrar todos los ususarios para esta formacion");
    $arrayUsers = array();
    $arrayUsersUpdated = array();
    $sql = "SELECT 
                CALIDAD_FORMACION_DETALLES.tecnico_id
            FROM 
                CALIDAD_FORMACION, CALIDAD_FORMACION_DETALLES, erp_users
            WHERE 
                CALIDAD_FORMACION_DETALLES.formacion_id = CALIDAD_FORMACION.id
            AND 
               CALIDAD_FORMACION_DETALLES.formacion_id =".$_POST['formacion_id']."
            AND
                CALIDAD_FORMACION_DETALLES.tecnico_id=erp_users.id
            ORDER BY
                erp_users.id ASC";
    file_put_contents("selectCalidadFormacionDetalles.txt", $sql);                                                    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Calidad Formacion Detalles");    
    while ($registros = mysqli_fetch_array($resultado)) {
        array_push($arrayUsers,$registros[0]);
    }
    foreach ($posiciones as $posicion) {
        if ($posicion['pos-to-formacion-detalles'] != "") {
            $idtrabajador = $posicion['pos_tecnico_id'];
            
            $sqlSel = "SELECT 
                        CALIDAD_FORMACION_DETALLES.id,
                        CALIDAD_FORMACION_DETALLES.formacion_id,
                        CALIDAD_FORMACION_DETALLES.tecnico_id,
                        CALIDAD_FORMACION_DETALLES.descripcion,
                        CALIDAD_FORMACION_DETALLES.fecha
                       FROM 
                        CALIDAD_FORMACION_DETALLES
                       WHERE 
                        CALIDAD_FORMACION_DETALLES.formacion_id=" . $posicion['pos_formacion_id'] . " 
                       AND 
                        CALIDAD_FORMACION_DETALLES.tecnico_id=" . $posicion['pos_tecnico_id'];
            file_put_contents("selectFormacion.txt", $sqlSel);
            $resultado = mysqli_query($connString, $sqlSel) or die("Error al seleccionar la formación. SELECT");
            $row = mysqli_fetch_array($resultado);
            $numResults = mysqli_num_rows($resultado);
            //$hola.="|".$numResults;
            if($numResults==1){
                $sql = "UPDATE CALIDAD_FORMACION_DETALLES
                        SET descripcion = '".$row[3]."', 
                            fecha = '".$row[4]."'
                        WHERE CALIDAD_FORMACION_DETALLES.formacion_id=" . $posicion['pos_formacion_id'] . " 
                        AND CALIDAD_FORMACION_DETALLES.tecnico_id=" . $posicion['pos_tecnico_id'];
                file_put_contents("updateFormacion.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al acualizar la formación. UPDATE");
                array_push($arrayUsersUpdated,$posicion['pos_tecnico_id']);
            }
            if($numResults==0){
                //$hola.="0";
                $sql = "INSERT INTO CALIDAD_FORMACION_DETALLES 
                            (formacion_id,
                            tecnico_id,
                            descripcion,
                            fecha) 
                            VALUES (
                            '" . $posicion['pos_formacion_id'] . "', 
                            '" . $posicion['pos_tecnico_id'] . "',
                            '',
                            '" . $posicion['pos_fecha'] . "'
                            )";
                file_put_contents("insertFormacion.txt", $sql);
                $result = mysqli_query($connString, $sql) or die("Error al guardar la formación. INSERT");
            }
            
        }
        $contador++;
    }
    
    $diffUsers = array_diff($arrayUsers,$arrayUsersUpdated);
    foreach ($diffUsers as $diff){
        $sqlDelUsrs = "DELETE FROM 
                        CALIDAD_FORMACION_DETALLES
                   WHERE 
                       CALIDAD_FORMACION_DETALLES.tecnico_id =" . $diff."
                   AND 
                       CALIDAD_FORMACION_DETALLES.formacion_id=" .$_POST['formacion_id'];
        file_put_contents("deleteUsuarios.txt", $sqlDelUsrs);
        $resultadoUsrs = mysqli_query($connString, $sqlDelUsrs) or die("Error al borrar todos los ususarios para esta formacion");
    }
    
    //echo $posiciones;
    //file_put_contents("contador.txt", $res1);
    echo 1;
}

function addFormacionDetallesTodos() {
    $db = new dbObj();
    $connString = $db->getConnstring();

    $sql1 = "SELECT
                erp_users.id,
                erp_users.nombre
                FROM
                erp_users";
    file_put_contents("selectAllUsuarios.txt", $sql1);
    $res = mysqli_query($connString, $sql1) or die("Error al seleccionar todos los usuarios.");

    while ($row = mysqli_fetch_array($res)) {
        $sql = "INSERT INTO CALIDAD_FORMACION_DETALLES 
                                (formacion_id,
                                tecnico_id,
                                descripcion,
                                fecha) 
                           VALUES (
                                '" . $_POST['addTodosTecnicosFormacion'] . "', 
                                '" . $row[0] . "',
                                '',
                                '" . $_POST['addTodosTecnicoFormacion_fecha'] . "'
                            )";
        file_put_contents("insertFormacionTodos.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar la formación todos. INSERT");
    }
    echo 1;
}

function deleteFormacionDetalles() {
    $db = new dbObj();
    $connString = $db->getConnstring();

    $sql = "DELETE FROM CALIDAD_FORMACION_DETALLES WHERE id = " . $_POST['del_tecnico_id'];
    file_put_contents("delFormacionDetalle.txt", $sql);
    echo $result = mysqli_query($connString, $sql) or die("Error al eliminar la formación Detalle");
}

function changeDateFormacionDetalles(){
    $db = new dbObj();
    $connString = $db->getConnstring();
    
    $sql = "UPDATE CALIDAD_FORMACION_DETALLES
            SET CALIDAD_FORMACION_DETALLES.fecha = '".$_POST['changeDate']."'
            WHERE CALIDAD_FORMACION_DETALLES.formacion_id=" . $_POST['formacionId']. "
            AND CALIDAD_FORMACION_DETALLES.tecnico_id=".$_POST['tecnicoId'];
    file_put_contents("updateFechaFormacionDetalle.txt", $sql);
    $result = mysqli_query($connString, $sql) or die("Error al acualizar la formación. UPDATE Fecha Formacion Detalle");
    
}

?>
	