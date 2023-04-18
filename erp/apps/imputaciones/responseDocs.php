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
            GRUPOS_DOC.id,
            GRUPOS_DOC.nombre 
        FROM 
            GRUPOS_DOC 
        WHERE 
            GRUPOS_DOC.proyecto_id = ".$_GET["id"].$filtro." 
        ORDER BY 
            GRUPOS_DOC.nombre ASC";
    
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
            PROYECTOS_DOC.id as docid,
            PROYECTOS_DOC.titulo,
            PROYECTOS_DOC.descripcion,
            PROYECTOS_DOC.doc_path as path, 
            GRUPOS_DOC.nombre 
        FROM 
            PROYECTOS_DOC, GRUPOS_DOC 
        WHERE 
            PROYECTOS_DOC.grupo_id = GRUPOS_DOC.id 
        AND
            PROYECTOS_DOC.grupo_id = ".$row[0]." 
        ORDER BY 
            PROYECTOS_DOC.id DESC";

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