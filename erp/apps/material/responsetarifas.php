<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();

    $params = $_REQUEST;

    $action = isset($params['action']) != '' ? $params['action'] : '';
    $tarifaCls = new Tarifa($connString);

    //file_put_contents("queryTarifa.txt", $_POST['action']);

    switch($action) {
        case 'add':
                $tarifaCls->insertTarifa($params);
                break;
        case 'edit':
                $tarifaCls->updateTarifa($params);
                break;
        case 'delete':
                $tarifaCls->deleteTarifa($params);
                break;
        default:
                $tarifaCls->getTarifas($params);
                return;
    }
	
    class Tarifa {
        protected $conn;
        protected $data = array();
        function __construct($connString) {
            $this->conn = $connString;
        }

        public function getTarifas($params) {
            $this->data = $this->getRecords($params);
            echo json_encode($this->data);
        }
        
        function insertTarifa($params) {
            $data = array();
            $charsRemove = array(".", "€");
            $sql = "INSERT INTO MATERIALES_PRECIOS 
                        (material_id,
                        proveedor_id, 
                        fecha_val, 
                        pvp,
                        dto_material) 
                        VALUES 
                        (".$params["newtarifa_materialid"].", 
                        ".$params["newtarifa_proveedor"].",
                        '".$params["newtarifa_fechaval"]."', 
                        ".$params["newtarifa_tarifa"].",
                        ".$params["newtarifa_dto"].")";
            //file_put_contents("insertTarifa.txt", $sql);
            echo $result = mysqli_query($this->conn, $sql) or die("Error insertando una nueva Tarifa");
        }

        function getRecords($params) {
            $rp = isset($params['rowCount']) ? $params['rowCount'] : 10;

            if (isset($params['current'])) { 
                $page  = $params['current']; 
            } else { 
                $page=1; 
            }
            $start_from = ($page-1) * $rp;
            $sql = $sqlRec = $sqlTot = $where = '';

            $addOR = "";

            if((!empty($_GET['material_id']))) {
                $where .=" WHERE (MATERIALES_PRECIOS.material_id = ".$_GET['material_id'];
            }

            if((!empty($_GET['material_id']))) {
                $where .=") ";
            }

            if( !empty($params['searchPhrase']) ) {
                //$where .=" WHERE ";
                $where .=" AND ( PROVEEDORES.nombre LIKE '%".$params['searchPhrase']."%' ) ";    
            }

            if( !empty($params['sort']) ) {  
                $where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
            }
            else {
                $where .=" ORDER By MATERIALES_PRECIOS.id ASC ";
            }

            $sql = "SELECT MATERIALES_PRECIOS.id, PROVEEDORES.nombre as nombre_proveedor, fecha_val, pvp, dto_material, proveedor_id  
                        FROM MATERIALES_PRECIOS 
                        LEFT JOIN PROVEEDORES 
                            ON MATERIALES_PRECIOS.proveedor_id = PROVEEDORES.id ";

            $sqlTot .= $sql;
            $sqlRec .= $sql;

            //concatenate search sql if value exist
            if(isset($where) && $where != '') {
                $sqlTot .= $where;
                $sqlRec .= $where;
            }
            if ($rp!=-1) {
                $sqlRec .= " LIMIT ". $start_from .",".$rp;
            }

            // Verificar query
            //file_put_contents("queryTarifas.txt", $sqlRec);

            $qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot tarifas data");
            $queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch tarifas data");

            while( $row = mysqli_fetch_assoc($queryRecords) ) { 
                $data[] = $row;
            }

            function utf8_converter($array)
            {
                array_walk_recursive($array, function(&$item, $key){
                    if(!mb_detect_encoding($item, 'utf-8', true)){
                            $item = utf8_encode($item);
                    }
                });

                return $array;
            }

            if ($qtot->num_rows > 0) {
                $json_data = array(
                        "current"=>intval($params['current']), 
                        "rowCount"=> 10, 			
                        "total"=> intval($qtot->num_rows),
                        "rows"=>$data);
            }
            else {
                $json_data = array();
            }

            $json_utf8 = utf8_converter($json_data);
            if ($json_utf8 == "") {
                return $json_data;
            }
            else {
                return $json_utf8;
            }

        }
        function updateTarifa($params) {
                $data = array();

                $charsRemove = array(".", "€");

                $sql = "UPDATE MATERIALES_PRECIOS 
                            SET proveedor_id = '" . $params["tarifaedit_proveedor"] . "', 
                                fecha_val = '" . $params["tarifaedit_fechaval"] . "',
                                pvp = ".$params["tarifaedit_tarifa"].",
                                dto_material = ".$params["tarifaedit_dto"]." 
                            WHERE id=".$_POST["edit_id"];

                //file_put_contents("updateTarifa.txt", $sql);
                echo $result = mysqli_query($this->conn, $sql) or die("Error actualizando Tarifa");
        }

        function deleteTarifa($params) {
            $data = array();
            //print_R($_POST);die;
            $sql = "DELETE FROM MATERIALES_PRECIOS WHERE id=".$params["id"];

            echo $result = mysqli_query($this->conn, $sql) or die("Error eliminando Tarifa");
        }
    } // class Tarifas    
?>
	