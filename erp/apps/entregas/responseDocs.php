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
            ENTREGAS.id,
            ENTREGAS.nombre 
        FROM 
            ENTREGAS 
        WHERE 
            ENTREGAS.id = ".$_GET["id"].$filtro." 
        ORDER BY 
            ENTREGAS.nombre ASC";
    
    $data = array();
    $states = array();
    $res = mysqli_query($connString, $sql) or die("database error:");
    while( $row = mysqli_fetch_array($res) ) { 
        //file_put_contents("array.txt", "in");
        $tmp = array();
        $states['expanded'] = false;
        $tmp['text'] = $row[1];
        $tmp['state'] = $states;
        $sql2 = "SELECT 
            ENTREGAS_DOC.id as docid,
            ENTREGAS_DOC.titulo,
            ENTREGAS_DOC.descripcion,
            ENTREGAS_DOC.doc_path as path
        FROM 
            ENTREGAS_DOC 
        WHERE 
            ENTREGAS_DOC.entrega_id = ".$row[0]." 
        ORDER BY 
            ENTREGAS_DOC.id DESC";

        $res2 = mysqli_query($connString, $sql2) or die("database error:");
        //iterate on results row and create new index array of data
        $datanodes = array();
        $tmpnodes = array();
        while( $row2 = mysqli_fetch_array($res2) ) { 
                $tmpnodes['text'] = $row2[1];
                $tmpnodes['icon'] = "glyphicon glyphicon-file";
                $tmpnodes['href'] = "file:////192.168.3.108".$row2[3];
                $tmpnodes['id'] = $row2[0];
                array_push($datanodes, $tmpnodes); 
        }
        $tmp['nodes'] = $datanodes;
        array_push($data, $tmp); 
    }

    
    //file_put_contents("items.txt", json_encode($itemsByReference));
    echo json_encode($data);
?>