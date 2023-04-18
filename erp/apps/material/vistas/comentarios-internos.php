<?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    PEDIDOS_PROV.com_interno
                FROM PEDIDOS_PROV
                WHERE
                    PEDIDOS_PROV.id = ".$_GET['id'];
        file_put_contents("logComentarioInterno.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta del Pedido. Get Comentario Interno");

        $registros = mysqli_fetch_row($resultado);

        $comInterno = $registros[0];
        
        // View Comentario Interno
        echo '<div id="view-comentario-interno">
                <div class="form-group form-group-view">
                    <label id="view_com_inter">'.$comInterno.'</label>
                </div>
            </div>';
        
        // Edit Comentario Interno
        echo '<div id="editar-comentario-interno" style="display: none;">
                <div class="form-group form-group-view">
                    <textarea class="form-control" id="editar_com_inter" name="editar_comentario_interno" placeholder="Editar Comentario Interno" rows="10">'.$comInterno.'</textarea>
                </div>
            </div>';
        
?>

