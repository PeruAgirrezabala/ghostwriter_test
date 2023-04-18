<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    //include($pathraiz."/common.php");
    require_once($pathraiz."/connection.php");


    $db = new dbObj();
    $connString = $db->getConnstring();
    
    $cliente_id= $_POST['id_cli'];

    $sql = "SELECT 
                CLIENTES_INSTALACIONES.id,
                CLIENTES_INSTALACIONES.cliente_id,
                CLIENTES_INSTALACIONES.nombre,
                CLIENTES_INSTALACIONES.direccion
            FROM 
                CLIENTES_INSTALACIONES 
            WHERE 
                CLIENTES_INSTALACIONES.cliente_id =" . $cliente_id;
    file_put_contents("clientesInstalaciones.txt", $sql);
    $resultado = mysqli_query($connString, $sql);
    
    
    $tablaInstalaciones = "<hr class='dash-underline'>
                        <button data-id='".$indicadorId."' class='button' id='add-instalacion-cliente' title='Añadir otra Instalación' type='button'><img src='/erp/img/add.png' height='20'></button>
                        <span class='stretch'></span>
                        <table class='table table-striped table-hover' id='tabla-clientes-instalaciones'>
                            <thead>
                                <tr class='bg-dark'>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>";
    
    while( $row = mysqli_fetch_array($resultado) ) {
            $inputvalornombre='<input hidden class="form-control cliente_instalacion_nombre_nuevo" id="cliente_instalacion_nombre_nuevo'.$row[0].'" name="cliente_instalacion_nombre_nuevo'.$row[0].'" value='.$row[2].'>';
            $textovalornombre='<p class="txt_cliente_instalacion_nombre_nuevo" id="txt_cliente_instalacion_nombre_nuevo'.$row[0].'">'.$row[2].'</p>';
        
            $inputvalor='<input hidden class="form-control cliente_instalacion_nuevo" id="cliente_instalacion_nuevo'.$row[0].'" name="cliente_instalacion_nuevo'.$row[0].'" value='.$row[3].'>';
            $textovalor='<p class="txt_indicador_anteriores_valor_nuevo" id="txt_indicador_anteriores_valor_nuevo'.$row[0].'">'.$row[3].'</p>';
            
//            if(date("Y")<=$row[8]){
//                $deshabilitado="disabled";
//            }else{
//                $deshabilitado="";
//            }
            
            $botones="<button class='button save-editar-cliente-instalacion' value=".$row[0]." id='save-editar-cliente-instalacion".$row[0]."' type='button' title='Guardar valor' hidden><img src='/erp/img/save.png' height='20'></button>
                    <button class='button editar-cliente-instalacion' value=".$row[0]." id='editar-cliente-instalacion".$row[0]."' type='button' title='Editar valor' ><img src='/erp/img/edit.png' height='20'></button>
                    <button class='button' value=".$row[0]." id='borrar-cliente-instalacion' title='Borrar Instalación' type='button' ><img src='/erp/img/bin.png' height='20'></button>";
            $tablaInstalaciones .= "
                                    <tr data-id='" . $row[0] . "'>
                                        <td class='text-left'>" . $inputvalornombre. $textovalornombre . "</td>
                                        <td class='text-left'>" .$inputvalor. $textovalor . "</td>
                                        <td class='text-left'>" . $botones . "</td>
                                    </tr>";
        }
        $tablaInstalaciones .= "</tbody>
                        </table>";
        echo $tablaInstalaciones;

                        
                        
    
    
    
?>
	