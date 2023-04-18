<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    $db = new dbObj();
    $connString =  $db->getConnstring();

    $params = $_REQUEST;

    $action = isset($params['action']) != '' ? $params['action'] : '';
    $provCls = new Proveedor($connString);

    file_put_contents("queryProv.txt", $_POST['action']);

    switch($action) {
        case 'add':
            $provCls->insertProveedor($params);
            break;
        case 'edit':
            $provCls->updateProveedor($params);
            break;
        case 'delete':
            $provCls->deleteProveedor($params);
            break;
        default:
            $provCls->getProveedor($params);
            return;
    }
	
    class Proveedor {
        protected $conn;
        protected $data = array();
        function __construct($connString) {
            $this->conn = $connString;
        }

        public function getProveedor($params) {
            $this->data = $this->getRecords($params);
            echo json_encode($this->data);
        }
        
        function insertProveedor($params) {
            $data = array();
            $charsRemove = array(".", "€");
            $sql = "INSERT INTO PROVEEDORES 
                        (nombre,
                        direccion,
                        poblacion,
                        provincia,
                        cp,
                        pais,
                        telefono,
                        descripcion,
                        dto,
                        email,
                        fax,
                        contacto,
                        web,
                        formaPago,
                        email_pedidos,
                        CIF) 
                        VALUES 
                        ('".$params["newproveedor_nombre"]."', 
                        '".$params["newproveedor_direccion"]."',
                        '".$params["newproveedor_poblacion"]."', 
                        '".$params["newproveedor_provincia"]."',
                        '".$params["newproveedor_cp"]."',
                        '".$params["newproveedor_pais"]."', 
                        '".$params["newproveedor_telefono"]."',
                        '".$params["newproveedor_descripcion"]."',
                        ".$params["newproveedor_dto"].", 
                        '".$params["newproveedor_email"]."',
                        '".$params["newproveedor_fax"]."',
                        '".$params["newproveedor_contacto"]."',
                        '".$params["newproveedor_web"]."', 
                        '".$params["newproveedor_formaPago"]."',
                        '".$params["newproveedor_email_pedidos"]."',
                        '".$params["newproveedor_cif"]."')";
            //file_put_contents("insertMaterial.txt", $sql);
            echo $result = mysqli_query($this->conn, $sql) or die("Error insertando un nuevo Proveedor");
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
                $where .=" WHERE (PROVEEDORES.id = ".$_GET['proveedor_id'];
            }

            if((!empty($_GET['proveedor_id']))) {
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
                        id as proveedor,
                        (SELECT dto_prov FROM PROVEEDORES_DTO WHERE PROVEEDORES_DTO.fecha_val < now() AND proveedor_id = proveedor ORDER BY PROVEEDORES_DTO.fecha_val DESC, PROVEEDORES_DTO.id DESC LIMIT 1 ) as dto,
                        descripcion,
                        email,
                        fax,
                        contacto,
                        email_pedidos,
                        web,
                        formaPago,
                        CIF,
                        homologado,
                        plataforma,
                        usuario,
                        password
                    FROM PROVEEDORES A
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
        function updateProveedor($params) {
                $data = array();

                $charsRemove = array(".", "€");

                $sql = "UPDATE PROVEEDORES 
                            SET
                                nombre = '".$params["newproveedor_nombre"]."',
                                direccion = '".$params["newproveedor_direccion"]."',
                                poblacion = '".$params["newproveedor_poblacion"]."',
                                provincia = '".$params["newproveedor_provincia"]."',
                                cp = '".$params["newproveedor_cp"]."',
                                pais = '".$params["newproveedor_pais"]."',
                                telefono = '".$params["newproveedor_telefono"]."',
                                descripcion = '".$params["newproveedor_desc"]."',
                                dto = ".$params["newproveedor_dto"].",
                                email = '".$params["newproveedor_email"]."',
                                fax = '".$params["newproveedor_fax"]."',
                                contacto = '".$params["newproveedor_contacto"]."',
                                web = '".$params["newproveedor_web"]."',
                                formaPago = '".$params["newproveedor_formaPago"]."',
                                CIF = '".$params["newproveedor_cif"]."' 
                            WHERE id=".$_POST["edit_id"];

                //file_put_contents("updateMAT.txt", $sql);
                echo $result = mysqli_query($this->conn, $sql) or die("Error actualizando Proveedor");
        }

        function deleteProveedor($params) {
            $data = array();
            //print_R($_POST);die;
            $sql = "DELETE FROM PROVEEDORES WHERE id=".$params["id"];

            echo $result = mysqli_query($this->conn, $sql) or die("Error eliminando Proveedor");
        }
    } // class Tarifas    
?>
	