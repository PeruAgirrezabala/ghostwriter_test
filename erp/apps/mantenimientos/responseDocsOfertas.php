<?
    //file_put_contents("array.txt", "start");
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    //file_put_contents("array.txt", "second");
    
    if ($_POST["filtro"]) {
        $filtro = " AND nombre LIKE '%".$_POST["filtro"]."%' ";
    }
    else {
        $filtro = " ";
    }
    
    $sql = "SELECT 
            OFERTAS.id,
            OFERTAS.titulo  
        FROM 
            OFERTAS 
        WHERE 
            OFERTAS.id = ".$_GET["id"]." 
        LIMIT 1";
    
    $data = array();
    $states = array();
    $res = mysqli_query($connString, $sql) or die("database error:");
    while( $row = mysqli_fetch_array($res) ) { 
        file_put_contents("array.txt", "in");
        $tmp = array();
        $states['expanded'] = false;
        $tmp['text'] = $row[1];
        $tmp['state'] = $states;
        $sql2 = "SELECT 
            OFERTAS_DOC.id as docid,
            OFERTAS_DOC.titulo,
            OFERTAS_DOC.descripcion,
            (SELECT doc_path FROM OFERTAS_DOC_VERSIONES WHERE OFERTAS_DOC_VERSIONES.oferta_doc_id = docid LIMIT 1) as path,
            (SELECT version FROM OFERTAS_DOC_VERSIONES WHERE OFERTAS_DOC_VERSIONES.oferta_doc_id = docid ORDER BY OFERTAS_DOC_VERSIONES.version DESC LIMIT 1) as version, 
            OFERTAS.titulo  
        FROM 
            OFERTAS_DOC, OFERTAS  
        WHERE 
            OFERTAS_DOC.oferta_id = OFERTAS.id 
        AND
            OFERTAS_DOC.oferta_id = ".$row[0]."  
        ORDER BY 
            OFERTAS_DOC.id DESC";

        $res2 = mysqli_query($connString, $sql2) or die("database error:");
        //iterate on results row and create new index array of data
        $datanodes = array();
        $tmpnodes = array();
        while( $row2 = mysqli_fetch_array($res2) ) { 
                $tmpnodes['text'] = $row2[1];
                $tmpnodes['icon'] = "glyphicon glyphicon-file";
                $tmpnodes['href'] = $row2[3];
                array_push($datanodes, $tmpnodes); 
        }
        $tmp['nodes'] = $datanodes;
        array_push($data, $tmp); 
    }

    
    //file_put_contents("items.txt", json_encode($itemsByReference));
    echo json_encode($data);
?>