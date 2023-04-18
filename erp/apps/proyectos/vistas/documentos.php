<!-- ofertas del proyecto seleccionado -->
<table class="table table-striped table-hover" id='tabla-ofertas'>
    <thead>
      <tr>
        <th></th>
        <th>TITULO</th>
        <th class="text-center">VERSION</th>
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
            PROYECTOS_DOC.id as docid,
            PROYECTOS_DOC.titulo,
            PROYECTOS_DOC.descripcion,
            (SELECT doc_path FROM PROYECTOS_DOC_VERSIONES WHERE PROYECTOS_DOC_VERSIONES.proyecto_doc_id = docid LIMIT 1) as path,
            (SELECT version FROM PROYECTOS_DOC_VERSIONES WHERE PROYECTOS_DOC_VERSIONES.proyecto_doc_id = docid ORDER BY PROYECTOS_DOC_VERSIONES.version DESC LIMIT 1) as version, 
            GRUPOS_DOC.nombre 
        FROM 
            PROYECTOS_DOC, GRUPOS_DOC 
        WHERE 
            PROYECTOS_DOC.grupo_id = GRUPOS_DOC.id 
        AND
            PROYECTOS_DOC.proyecto_id = ".$_GET['id']." 
        ORDER BY 
            PROYECTOS_DOC.id DESC";
    
    $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de los documentos.");
    
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