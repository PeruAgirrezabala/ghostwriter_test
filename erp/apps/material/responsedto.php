<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();

    $params = $_REQUEST;

    $action = isset($params['action']) != '' ? $params['action'] : '';
    $dtoCls = new Dto($connString);

    //file_put_contents("queryTarifa.txt", $_POST['action']);

    switch($action) {
        case 'add':
                $dtoCls->insertDto($params);
                break;
        case 'edit':
                $dtoCls->updateDto($params);
                break;
        case 'delete':
                $dtoCls->deleteDto($params);
                break;
        default:
                $dtoCls->getDto($params);
                return;
    }
	
    class Dto {
        protected $conn;
        protected $data = array();
        function __construct($connString) {
            $this->conn = $connString;
        }

        public function getDto($params) {
            $this->data = $this->getRecords($params);
            echo json_encode($this->data);
        }
        
        function insertDto($params) {
            $data = array();
            $charsRemove = array(".", "€");
            $sql = "INSERT INTO PROVEEDORES_DTO 
                        (proveedor_id, 
                        fecha_val, 
                        dto_prov) 
                        VALUES 
                        (".$params["newdto_proveedorid"].", 
                        '".$params["newdto_fechaval"]."', 
                        ".$params["newdto_dto"].")";
            //file_put_contents("INSERT.txt", $sql);
            echo $result = mysqli_query($this->conn, $sql) or die("Error insertando un nuevo Descuento");
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

            if((!empty($_GET['proveedor_id']))) {
                $where .=" WHERE (PROVEEDORES_DTO.proveedor_id = ".$_GET['proveedor_id'];
            }

            if((!empty($_GET['proveedor_id']))) {
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
                $where .=" ORDER By PROVEEDORES_DTO.id ASC ";
            }

            $sql = "SELECT PROVEEDORES_DTO.id, fecha_val, dto_prov   
                        FROM PROVEEDORES_DTO 
                        LEFT JOIN PROVEEDORES 
                            ON PROVEEDORES_DTO.proveedor_id = PROVEEDORES.id ";

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
            //file_put_contents("queryDTO.txt", $sqlRec);

            $qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot descuento data");
            $queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch descuento data");

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
        function updateDto($params) {
                $data = array();

                $charsRemove = array(".", "€");

                $sql = "UPDATE PROVEEDORES_DTO 
                            SET fecha_val = '" . $params["dtoedit_fechaval"] . "',
                                dto_prov = ".$params["dtoedit_dto"]."
                            WHERE id=".$_POST["edit_dto_id"];

                //file_put_contents("updDto.txt", $sql);
                echo $result = mysqli_query($this->conn, $sql) or die("Error actualizando Descuento");
        }

        function deleteDto($params) {
            $data = array();
            //print_R($_POST);die;
            $sql = "DELETE FROM PROVEEDORES_DTO WHERE id=".$params["id"];

            echo $result = mysqli_query($this->conn, $sql) or die("Error eliminando Descuento");
        }
    } // class Tarifas    
?>
	