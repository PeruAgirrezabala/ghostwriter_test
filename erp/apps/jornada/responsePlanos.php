<?
    //file_put_contents("array.txt", "start");
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    //file_put_contents("array.txt", "second");
    
    $sql = "SELECT 
            GRUPOS_PLANOS.id,
            GRUPOS_PLANOS.nombre 
        FROM 
            GRUPOS_PLANOS 
        WHERE 
            GRUPOS_PLANOS.proyecto_id = ".$_GET["id"]." 
        ORDER BY 
            GRUPOS_PLANOS.nombre ASC";
    
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
            PLANOS.id as planoid,
            PLANOS.titulo,
            PLANOS.descripcion,
            (SELECT plano_path FROM PLANOS_VERSIONES WHERE PLANOS_VERSIONES.plano_id = planoid LIMIT 1) as path,
            (SELECT version FROM PLANOS_VERSIONES WHERE PLANOS_VERSIONES.plano_id = planoid ORDER BY PLANOS_VERSIONES.version DESC LIMIT 1) as version, 
            GRUPOS_PLANOS.nombre 
        FROM 
            PLANOS, GRUPOS_PLANOS 
        WHERE 
            PLANOS.grupo_id = GRUPOS_PLANOS.id 
        AND
            PLANOS.grupo_id = ".$row[0]." 
        ORDER BY 
            PLANOS.id DESC";

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

    
    file_put_contents("items.txt", json_encode($itemsByReference));
    echo json_encode($data);
?>