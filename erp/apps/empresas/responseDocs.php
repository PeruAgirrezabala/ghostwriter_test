<?
    //file_put_contents("array.txt", "start");
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    file_put_contents("array.txt", "second");
    

    
    $data = array();
    $states = array();
    
    
        
        $tmp = array();
        $states['expanded'] = false;
        
        $tmp['text'] = "DOCUMENTOS DEL PROVEEDOR";
        $tmp['state'] = $states;
        
        $sql = "SELECT 
            PROVEEDORES_DOC.id as docid,
            PROVEEDORES_DOC.nombre,
            PROVEEDORES_DOC.descripcion,
            PROVEEDORES_DOC.doc_path as path
        FROM 
            PROVEEDORES_DOC
        WHERE 
            PROVEEDORES_DOC.proveedor_id = ".$_GET["id"]." 
        ORDER BY 
            PROVEEDORES_DOC.id DESC";
        
        file_put_contents("tree.txt", $sql);
        $res = mysqli_query($connString, $sql) or die("database error. tree");

        //iterate on results row and create new index array of data
        
        
        $datanodes = array();
        //$datanodes['img'] = "suerte";
        $tmpnodes = array();
        while( $row = mysqli_fetch_array($res) ) { 
                $tmpnodes['text'] = $row[1];
                $tmpnodes['icon'] = "glyphicon glyphicon-file";
                $tmpnodes['href'] = "file:////192.168.3.108/".$row[3];
                $tmpnodes['id'] = $row[0];
                array_push($datanodes, $tmpnodes); 
        }
        $tmp['nodes'] = $datanodes;
        array_push($data, $tmp); 
    

    
    //file_put_contents("items.txt", json_encode($itemsByReference));
    echo json_encode($data);
?>