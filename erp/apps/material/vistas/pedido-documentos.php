<!-- documentos del pedido seleccionado -->
<table class="table table-striped table-hover" id='tabla-pedido-docs'>
    <thead>
      <tr>
        <th></th>
        <th>NOMBRE</th>
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
            PEDIDOS_PROV_DOC.id as docid,
            PEDIDOS_PROV_DOC.nombre,
            PEDIDOS_PROV_DOC.descripcion,
            PEDIDOS_PROV_DOC.doc_path as path,
        FROM 
            PEDIDOS_PROV_DOC
        WHERE 
            PEDIDOS_PROV_DOC.pedido_id = ".$_GET['id']." 
        ORDER BY 
            PEDIDOS_PROV_DOC.id DESC";
    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos");
    
    while ($registros = mysqli_fetch_array($resultado)) {
        $id = $registros[0];
        $titulo = $registros[1];
        $descripcion = $registros[2];
        $docpath = $registros[3];
        $docversion = $registros[4];
        
        echo "
            <tr data-id='".$id."'>
                <td clas='text-center'><a href='".$docpath."'><img src='/erp/img/pdf.png' height='20'></a></td>
                <td>".$titulo."</td>
                <td class='text-center'>".$docversion."</td>
            </tr>
        ";
    }

?>
        
    </tbody>
</table>
<? echo $sql; ?>

<!-- ofertas del proyecto seleccionado -->