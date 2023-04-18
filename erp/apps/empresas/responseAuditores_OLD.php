<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();

    $params = $_REQUEST;

    $action = isset($params['action']) != '' ? $params['action'] : '';
    $provCls = new Auditor($connString);

    file_put_contents("queryAudit.txt", $_POST['action']);

    switch($action) {
        case 'add':
            $provCls->insertAuditor($params);
            break;
        case 'edit':
            $provCls->updateAuditor($params);
            break;
        case 'delete':
            $provCls->deleteAuditor($params);
            break;
        default:
            $provCls->getAuditor($params);
            return;
    }
	
    class Auditor {
        protected $conn;
        protected $data = array();
        function __construct($connString) {
            $this->conn = $connString;
        }

        public function getAuditor($params) {
            $this->data = $this->getRecords($params);
            echo json_encode($this->data);
        }
        
        function insertAuditor($params) {
            $data = array();
            $charsRemove = array(".", "€");
            $sql = "INSERT INTO AUDITORES 
                        (nombre,
                        direccion,
                        poblacion,
                        provincia,
                        cp,
                        pais,
                        telefono,
                        descripcion,
                        email,
                        fax,
                        contacto,
                        web,
                        CIF) 
                        VALUES 
                        ('".$params["newauditor_nombre"]."', 
                        '".$params["newauditor_direccion"]."',
                        '".$params["newauditor_poblacion"]."', 
                        '".$params["newauditor_provincia"]."',
                        '".$params["newauditor_cp"]."',
                        '".$params["newauditor_pais"]."', 
                        '".$params["newauditor_telefono"]."',
                        '".$params["newauditor_descripcion"]."',
                        '".$params["newauditor_email"]."',
                        '".$params["newauditor_fax"]."',
                        '".$params["newauditor_contacto"]."',
                        '".$params["newauditor_web"]."', 
                        '".$params["newauditor_cif"]."')";
            file_put_contents("insertAuditor.txt", $sql);
            echo $result = mysqli_query($this->conn, $sql) or die("Error insertando un nuevo Auditor");
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

            if((!empty($_GET['auditor_id']))) {
                $where .=" WHERE (AUDITORES.id = ".$_GET['auditor_id'];
            }

            if((!empty($_GET['auditor_id']))) {
                $where .=") ";
            }

            if( !empty($params['searchPhrase']) ) {
                $where .=" WHERE ";
                $where .=" ( A.nombre LIKE '%".$params['searchPhrase']."%' ) ";
                $where .=" OR ( A.poblacion LIKE '%".$params['searchPhrase']."%' ) ";
                $where .=" OR ( A.provincia LIKE '%".$params['searchPhrase']."%' ) ";
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
                        direccion,
                        poblacion,
                        provincia,
                        cp,
                        pais,
                        telefono,
                        descripcion,
                        email,
                        fax,
                        contacto,
                        web,
                        CIF,
                        plataforma,
                        usuario,
                        password
                    FROM AUDITORES A";

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
            file_put_contents("queryAudit.txt", $sqlRec);

            $qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot auditores data");
            $queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch auditores data");

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
        function updateAuditor($params) {
                $data = array();

                $charsRemove = array(".", "€");

                $sql = "UPDATE AUDITORES 
                            SET
                                nombre = '".$params["newauditor_nombre"]."',
                                direccion = '".$params["newauditor_direccion"]."',
                                poblacion = '".$params["newauditor_poblacion"]."',
                                provincia = '".$params["newauditor_provincia"]."',
                                cp = '".$params["newauditor_cp"]."',
                                pais = '".$params["newauditor_pais"]."',
                                telefono = '".$params["newauditor_telefono"]."',
                                descripcion = '".$params["newauditor_desc"]."',
                                email = '".$params["newauditor_email"]."',
                                fax = '".$params["newauditor_fax"]."',
                                contacto = '".$params["newauditor_contacto"]."',
                                web = '".$params["newauditor_web"]."',
                                formaPago = '".$params["newauditor_formaPago"]."',
                                CIF = '".$params["newauditor_cif"]."' 
                            WHERE id=".$_POST["edit_id"];

                file_put_contents("updateAuditor.txt", $sql);
                echo $result = mysqli_query($this->conn, $sql) or die("Error actualizando Auditor");
        }

        function deleteAuditor($params) {
            $data = array();
            //print_R($_POST);die;
            $sql = "DELETE FROM AUDITORES WHERE id=".$params["id"];

            echo $result = mysqli_query($this->conn, $sql) or die("Error eliminando Auditor");
        }
    } // class Tarifas    
?>
	