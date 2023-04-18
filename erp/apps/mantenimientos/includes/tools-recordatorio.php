<!-- tools proyectos -->
<?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                PROYECTOS.id,
                PROYECTOS.ref,
                PROYECTOS.nombre,
                PROYECTOS.path,
                PROYECTOS.recordatorio
            FROM 
                PROYECTOS
            WHERE
                PROYECTOS.id = ".$_GET['id'];
        file_put_contents("getRecordatorio.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Proyectos-Recordatorio");
        $registros = mysqli_fetch_row ($resultado);
        $recordatorio=$registros[4];
        $doc_path=$recordatorio;
        
?>
<div class="form-group form-group-tools">
    <button class="button" id="edit-documento-recordatorio" title="Editar Documento"><img src="/erp/img/edit.png" height="20"></button>
    <button class="button" id="save-documento-recordatorio" title="Guardar Documento"><img src="/erp/img/save.png" height="20"></button>
    <button class="button" id="view-documento-recordatorio" title="Ver Documento"><a href='<? echo $doc_path ?>' target='_blank'><img src="/erp/img/search.png" height="20"></a></button>   
</div>