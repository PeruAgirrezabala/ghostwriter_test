<table class="table table-hover" id="tabla-horas">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">NOMBRE</th>
            <th class="text-center">TARIFA VENTA</th>
            <th class="text-center">COSTE</th>
            <th class="text-center">TIPO HORA</th>
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
                    PERFILES_HORAS.id,
                    PERFILES_HORAS.nombre,
                    PERFILES_HORAS.precio as precio_venta,
                    PERFILES_HORAS.precio_coste,
                    TIPOS_HORA.nombre
                FROM 
                    PERFILES_HORAS, TIPOS_HORA
                WHERE
                    TIPOS_HORA.id = PERFILES_HORAS.tipo_id
                ORDER BY 
                    TIPOS_HORA.nombre ASC";
        //file_put_contents("queryLic.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Horas");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $idHora = $registros[0];
            $nombreHora = $registros[1];
            $precioVenta = $registros[2];
            $precioCoste = $registros[3];
            $tipoHora = $registros[4];

            echo "
                <tr data-id='".$idHora."' class='licencia'>
                    <td class='text-left'>".$nombreHora."</td>
                    <td class='text-right'>".$precioVenta."</td>
                    <td class='text-right'>".$precioCoste."</td>
                    <td class='text-center'>".$tipoHora."</td>
                    <td class='text-center'><button class='btn btn-circle btn-danger del-hora' data-id='".$idHora."' title='Eliminar Hora'><img src='/erp/img/cross.png'></button></td>
                </tr>
            ";
        }   
    ?>
    </tbody>
</table>