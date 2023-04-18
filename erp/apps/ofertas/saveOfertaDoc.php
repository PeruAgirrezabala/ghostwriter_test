
<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    if ($_POST['ofertadoc_del'] != "") {
        delOfertaDoc();
    }    
    else {
        // ?¿
    }    

    function delOfertaDoc() {
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $data = array();
        //print_R($_POST);die;
        
        $sql = "delete from OFERTAS_DOC WHERE id=".$_POST['ofertadoc_del'];

        echo $result = mysqli_query($connString, $sql) or die("Error al eliminar el Documento");
    }
?>
	