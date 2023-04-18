<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();

    $id = $_GET['newcontactoCLI_id'];

    $sqlInstalaciones = "SELECT
                            CLIENTES_INSTALACIONES.id,
                            CLIENTES_INSTALACIONES.cliente_id,
                            CLIENTES_INSTALACIONES.nombre,
                            CLIENTES_INSTALACIONES.direccion
                        FROM
                            CLIENTES_INSTALACIONES
                        WHERE
                            CLIENTES_INSTALACIONES.cliente_id = ".$id;
    file_put_contents("logInstalacionesCliente.txt", $sqlInstalaciones);
    $result = mysqli_query($connString, $sqlInstalaciones) or die("Error al buscar material_id");
    //$registro = mysqli_fetch_row($result);
            
    $tohtml='<table class="table table-striped table-hover" id="tabla-doc-CLI">
    <thead>
        <tr class="bg-dark">
            <th class="text-center">NOMBRE</th>
            <th class="text-center">DIRECCION</th>
            <th class="text-center">D</th>
        </tr>
    </thead>
    <tbody>';
    
            
    while ($registros = mysqli_fetch_array($result)) {
        
        $tohtml.='<tr data-id="'.$registros[0].'" data-tipo="cli" class="instalaciones_clientes">
                    <td class="text-center">'.$registros[2].'</td>
                    <td class="text-left">'.$registros[3].'</td>
                    <td class="text-center"><button class="btn btn-circle btn-danger remove-instalacion-cliente" data-id="15" title="Eliminar iNSTALACION" type="button"><img src="/erp/img/cross.png"></button></td>';
    }
    
    $tohtml.="</tbody></table>";
    
    echo $tohtml;
// } //if isset btn_login



?>
