
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");
    

    $indicadorId = $_POST['indicador_id'];
    
    if ($_POST['anyo_anterior']!=""){
        addOtherYear();
    }else{
        if($_POST['edit_anyo']!=""){
            editValueYear();
        }else{
            if($_POST['del_anyo']!=""){
                delYear();
            }else{
                pintarTabla();
            }
        }
    }
    function editValueYear(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE 
                    CALIDAD_INDICADORES_VERSIONES
                SET
                    CALIDAD_INDICADORES_VERSIONES.valor=".$_POST['valor_nuevo']."
                WHERE
                    CALIDAD_INDICADORES_VERSIONES.id = ".$_POST['edit_anyo'];

        file_put_contents("editIndicadoresVersiones.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error Indicadores EDIT");
    }
    function delYear(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
                $sql = "DELETE 
                        FROM 
                            CALIDAD_INDICADORES_VERSIONES
                        WHERE 
                            CALIDAD_INDICADORES_VERSIONES.id = " . $_POST['del_anyo'];

        file_put_contents("delIndicadoresVersiones.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error Indicadores Versiones DEL");
    }
    function addOtherYear(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $indicadorId = $_POST['indicador_id'];
        $sql0 = "SELECT 
                CALIDAD_INDICADORES.id,
                CALIDAD_INDICADORES.nombre,  
                CALIDAD_INDICADORES.meta,
                CALIDAD_INDICADORES.proceso_id,
                CALIDAD_INDICADORES.objetivo,
                CALIDAD_INDICADORES.calculo,
                CALIDAD_INDICADORES.resultado,
                CALIDAD_INDICADORES.valor,
                CALIDAD_INDICADORES.tienehijos
            FROM 
                CALIDAD_INDICADORES
            WHERE
                CALIDAD_INDICADORES.id = " . $indicadorId;
        file_put_contents("selectIndicadorConcreto.txt", $sql0);
        $resu = mysqli_query($connString, $sql0) or die("Error al select INDICADOR concreto");
        while( $row = mysqli_fetch_array($resu) ) {
            $sql = "INSERT INTO CALIDAD_INDICADORES_VERSIONES
                    (nombre,
                    descripcion,
                    proceso_id,
                    objetivo,
                    calculo,
                    resultado,
                    valor,
                    tienehijos,
                    indicador_id,
                    anyo)
                    VALUES
                    ('".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."','".$_POST['anyo_anterior_valor']."','".$row[8]."',".$indicadorId.",".$_POST['anyo_anterior'].")";
            file_put_contents("InsertYerarsOLD.txt", $sql);
            echo $res = mysqli_query($connString, $sql) or die("Error al insertar OLD YEAR INDICADORES");
        }
        
        
    }
    
    function pintarTabla(){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $indicadorId = $_POST['indicador_id'];
        $sql = "SELECT 
                    CALIDAD_INDICADORES_VERSIONES.id,
                    CALIDAD_INDICADORES_VERSIONES.nombre,  
                    CALIDAD_INDICADORES_VERSIONES.descripcion,
                    CALIDAD_INDICADORES_VERSIONES.proceso_id,
                    CALIDAD_INDICADORES_VERSIONES.objetivo,
                    CALIDAD_INDICADORES_VERSIONES.calculo,
                    CALIDAD_INDICADORES_VERSIONES.resultado,
                    CALIDAD_INDICADORES_VERSIONES.valor,
                    CALIDAD_INDICADORES_VERSIONES.anyo
                FROM 
                    CALIDAD_INDICADORES_VERSIONES
                WHERE
                    CALIDAD_INDICADORES_VERSIONES.indicador_id = " . $indicadorId . " 
                ORDER BY 
                    CALIDAD_INDICADORES_VERSIONES.anyo ASC";

        file_put_contents("indicadores.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("Error Indicadores SELECT");

        $tabla_anyos = "<hr class='dash-underline'>
                        <button data-is='".$indicadorId."' class='button' id='indicador-anyos-anteriores' title='Añadir otros Años'><img src='/erp/img/add.png' height='20'></button>
                        <span class='stretch'></span>
                        <table class='table table-striped table-hover' id='tabl-indicadores-anteriores'>
                            <thead>
                                <tr class='bg-dark'>
                                    <th>AÑO</th>
                                    <th>VALOR</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>";
        
        while( $row = mysqli_fetch_array($res) ) {
            $inputvalor='<input type="text" class="form-control indicador_anteriores_valor_nuevo" id="indicador_anteriores_valor_nuevo'.$row[0].'" name="indicador_anteriores_valor_nuevo'.$row[0].'" value='.$row[7].'>';
            $textovalor='<p class="txt_indicador_anteriores_valor_nuevo" id="txt_indicador_anteriores_valor_nuevo'.$row[0].'">'.$row[7].'</p>';
            
            if(date("Y")<=$row[8]){
                $deshabilitado="disabled";
            }else{
                $deshabilitado="";
            }
            
            $botones="<button class='button save-editar-indicador-anyo' value=".$row[0]." id='save-editar-indicador-anyo".$row[0]."' title='Editar valor' ".$deshabilitado."><img src='/erp/img/save.png' height='20'></button>
                    <button class='button editar-indicador-anyo' value=".$row[0]." id='editar-indicador-anyo".$row[0]."' title='Editar valor' ".$deshabilitado."><img src='/erp/img/edit.png' height='20'></button>
                    <button class='button' value=".$row[0]." id='borrar-indicador-anyo' title='Borrar Año' ".$deshabilitado."><img src='/erp/img/bin.png' height='20'></button>";
            $tabla_anyos .= "
                                    <tr data-id='" . $row[8] . "'>
                                        <td class='text-left'>" . $row[8] . "</td>
                                        <td class='text-left'>" .$inputvalor. $textovalor . "</td>
                                        <td class='text-left'>" . $botones . "</td>
                                    </tr>";
        }
        $tabla_anyos .= "</tbody>
                        </table>";
        echo $tabla_anyos;
    }
?>
	