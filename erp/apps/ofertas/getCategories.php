<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");
    
if(isset($_POST['id'])) {    
    function arboldeCategoriasLista($parent = 0, $user_tree_array = '', $conn) 
    {
        if (!is_array($user_tree_array))
        $user_tree_array = array();

        $sql = "SELECT id, nombre, parent_id FROM MATERIALES_CATEGORIAS WHERE 1 AND parent_id = ".$parent." ORDER BY id ASC";
        $query = $conn->prepare($sql);
        $query->execute();
        $total = $query->rowCount();

        if ($total > 0) 
        {
            $user_tree_array[] = "<ul>";
            while ($row = $query->fetch(PDO::FETCH_OBJ)) 
            {
              $user_tree_array[] = "<li>". $row->nombre."</li>";
              $user_tree_array = arboldeCategoriasLista($row->id, $user_tree_array, $conn);
            }
            $user_tree_array[] = "</ul>";
        }
        return $user_tree_array;
    }
    function arboldeCategoriasListaFilter ($parent = 0, $user_tree_array = '', $conn) 
    {
        //file_put_contents("parent.txt", $parent." - ".$user_tree_array);
        
        if ($parent != 0) {
            $sql = "SELECT id, nombre, parent_id FROM MATERIALES_CATEGORIAS WHERE 1 AND id = ".$parent." ORDER BY id ASC";
            //file_put_contents("cat.txt", $user_tree_array);
            $query = $conn->prepare($sql);
            $query->execute();
            $total = $query->rowCount();

            if ($total > 0) 
            {
                //$user_tree_array[] = "<ul>";
                while ($row = $query->fetch(PDO::FETCH_OBJ)) 
                {
                  $user_tree_array = "<span>". $row->nombre."</span> ".$user_tree_array;
                  $user_tree_array = arboldeCategoriasListaFilter($row->parent_id, $user_tree_array, $conn);
                }
                //$user_tree_array[] = "</ul>";
            }
            return $user_tree_array;
        }
        else {
            return $user_tree_array;
            //return;
        }
    }
    

    /*
    if ($_SESSION['user_rol'] == "CLIENTE") {
        switch ($table) {
            case "tools_proyectos":
                $criteria = " cliente_id=".$_SESSION['user_session'];
                break;  
            case "tools_comerciales":
                $criteria = " cliente_id=".$_SESSION['user_session'];
                break;
        }
    }
    else {
        $criteria = "";
    }
    */
    
    try
    {
        //$result = "<ul>";
        $res = arboldeCategoriasListaFilter(8, '', $db_con);
        /*
        foreach ($res as $r) {
            $result .= $r;
        }
        $result .= "</ul>";
        echo $result;
         * 
         */
        echo $res;
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
} //if isset btn_login

?>
