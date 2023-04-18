<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();

    $params = $_REQUEST;

    $action = isset($params['action']) != '' ? $params['action'] : '';
    $provCls = new Formapago($connString);

    //file_put_contents("queryProv.txt", $_POST['action']);

    switch($action) {
        case 'add':
            $provCls->insertFormapago($params);
            break;
        case 'edit':
            $provCls->updateFormapago($params);
            break;
        case 'delete':
            $provCls->deleteFormapago($params);
            break;
        default:
            $provCls->getFormapago($params);
            return;
    }
	
    class Formapago {
        protected $conn;
        protected $data = array();
        function __construct($connString) {
            $this->conn = $connString;
        }

        public function getFormapago($params) {
            $this->data = $this->getRecords($params);
            echo json_encode($this->data);
        }
        
        function insertFormapago($params) {
            $data = array();
            $sql = "INSERT INTO FORMAS_PAGO 
                        (nombre,
                        datos,
                        observaciones) 
                        VALUES 
                        ('".$params["newformapago_nombre"]."', 
                        '".$params["newformapago_datos"]."',
                        '".$params["newformapago_desc"]."')";
            //file_put_contents("insertMaterial.txt", $sql);
            echo $result = mysqli_query($this->conn, $sql) or die("Error insertando una nueva Forma de Pago");
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

            if((!empty($_GET['formapago_id']))) {
                $where .=" WHERE (FORMAS_PAGO.id = ".$_GET['formapago_id'];
            }

            if((!empty($_GET['formapago_id']))) {
                $where .=") ";
            }

            if( !empty($params['searchPhrase']) ) {
                $where .=" WHERE ";
                $where .=" ( A.nombre LIKE '%".$params['searchPhrase']."%' ) ";
            }

            if( !empty($params['sort']) ) {  
                $where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
            }
            else {
                $where .=" ORDER By A.nombre ASC ";
            }

            $sql = "SELECT 
                        id,
                        nombre,
                        datos,
                        observaciones
                    FROM FORMAS_PAGO A
                        ";

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
            file_put_contents("queryProv.txt", $sqlRec);

            $qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot proveedores data");
            $queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch proveedores data");

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
        function updateFormapago($params) {
                $data = array();

                $charsRemove = array(".", "€");

                $sql = "UPDATE FORMAS_PAGO  
                            SET
                                nombre = '".$params["newformapago_nombre"]."',
                                datos = '".$params["newformapago_datos"]."',
                                observaciones = '".$params["newformapago_desc"]."'  
                            WHERE id=".$_POST["newformapago_idforma"];

                //file_put_contents("updateMAT.txt", $sql);
                echo $result = mysqli_query($this->conn, $sql) or die("Error actualizando la Forma de Pago");
        }

        function deleteFormapago($params) {
            $data = array();
            //print_R($_POST);die;
            $sql = "DELETE FROM FORMAS_PAGO WHERE id=".$_POST["formapago_del"];

            echo $result = mysqli_query($this->conn, $sql) or die("Error eliminando la Forma de Pago");
        }
    } // class Tarifas    
?>
	