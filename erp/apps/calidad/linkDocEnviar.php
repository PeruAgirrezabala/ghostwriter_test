
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['remove_doc'] != "") {
        delLinkDoc();
    }
    else {
        if ($_POST['sent_doc'] != "") {
            sentDoc();
        }
        else {
            linkDoc();
        }
    }
    
    function linkDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "INSERT INTO CLIENTES_DOC_ENVIAR 
                            (doc_id,
                            cliente_id,
                            tipo_doc) 
                       VALUES (
                            '".$_POST['id_doc']."', 
                            '".$_POST['cliente_id']."', 
                            '".$_POST['doc_type']."')";
        file_put_contents("linkDoc.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al linkar el Documento a Enviar al cliente");
    }
    
    function sentDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "UPDATE CLIENTES_DOC_ENVIAR 
                    SET 
                        enviado = ".$_POST['sent_doc']."
                    WHERE
                        id = ".$_POST['id_doc'];
        file_put_contents("sentDoc.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al enviar el Documento");
    }
   
    function delLinkDoc () {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "DELETE FROM CLIENTES_DOC_ENVIAR WHERE id = ".$_POST['id_doc'];
        //file_put_contents("delGrupo.txt", $sql);
        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar link el Documento a Enviar al cliente");
    }
?>
	