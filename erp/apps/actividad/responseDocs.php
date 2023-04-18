<?
    //file_put_contents("array.txt", "start");
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    //file_put_contents("array.txt", "second");
    

    
    $data = array();
    $states = array();
    
    
        
        $tmp = array();
        $states['expanded'] = false;
        
        $tmp['text'] = "DOCUMENTOS DE LA ACTIVIDAD";
        $tmp['state'] = $states;
        
        $sql = "SELECT 
            ACTIVIDAD_DOC.id as docid,
            ACTIVIDAD_DOC.nombre,
            ACTIVIDAD_DOC.descripcion,
            ACTIVIDAD_DOC.doc_path as path
        FROM 
            ACTIVIDAD_DOC
        WHERE 
            ACTIVIDAD_DOC.actividad_id = ".$_GET["id"]." 
        ORDER BY 
            ACTIVIDAD_DOC.id DESC";

        $res = mysqli_query($connString, $sql) or die("database error:");

        //iterate on results row and create new index array of data
        //file_put_contents("tree.txt", $sql);
        
        $datanodes = array();
        $tmpnodes = array();
        while( $row = mysqli_fetch_array($res) ) { 
                $tmpnodes['text'] = $row[1];
                $tmpnodes['icon'] = "glyphicon glyphicon-file";
                $tmpnodes['href'] = "file:////192.168.3.108/".$row[3];
                $tmpnodes['id'] = $row[0];
                $tmpnodes['path'] = $row[3];
                array_push($datanodes, $tmpnodes); 
        }
        $tmp['nodes'] = $datanodes;
        array_push($data, $tmp); 
    

    
    //file_put_contents("items.txt", json_encode($itemsByReference));
    echo json_encode($data);
?>