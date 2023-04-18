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
        
        $basepath = $registros[3];
        if(($recordatorio!="")||($recordatorio!=null)){
            //file_put_contents("path.txt", $basepath);
        $ftp_server = "192.168.3.108";
        $ftp_username = "admin";
        $ftp_password = "Sistemas2111";
        $ftp_connection = ftp_connect($ftp_server);
        $connection_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
        
        $filename = "ftp://$ftp_username:$ftp_password@$ftp_server$recordatorio";  
        $contents = file_get_contents($filename);
        }
        

?>

<div id="proyecto-recordatorio-texto" class="two-column">
    <form id="form-recordatorio-texto">
        <textarea class="form-control" id="texto-recodatorio" rows="10"><? echo $contents; ?></textarea>
    </form>
</div>
<div id="proyecto-recordatorio-fichero" class="two-column">
     <input id="uploaddocMantenimiento" name="uploaddocsMAN[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
</div>