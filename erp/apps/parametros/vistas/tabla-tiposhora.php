<table class="table table-hover" id="tabla-tiposhora">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">NOMBRE</th>
            <th class="text-center">E</th>
        </tr>
    </thead>
    <tbody>
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    TIPOS_HORA.id,
                    TIPOS_HORA.nombre 
                FROM 
                    TIPOS_HORA
                ORDER BY 
                    TIPOS_HORA.nombre ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Tipos de Hora");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $idTipohora = $registros[0];
            $nombreTipohora = $registros[1];
            
            echo "
                <tr data-id='".$idTipohora."' class='licencia'>
                    <td class='text-left'>".$nombreTipohora."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger del-tipohora' data-id='".$idTipohora."' title='Eliminar Tipo de Hora'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>