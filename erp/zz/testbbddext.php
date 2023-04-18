<?php
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    Class dbObj{
	/* Database connection start */
	//var $servername = "mysql380int.srv-acens.com";
        var $servername = "mysql380.srv-acens.com";
	var $username = "u5918118_genelek";
	var $password = "q_tjN8Y";
	var $dbname = "db5918118_newgenelek";
	var $conn;
	function getConnstring() {
            $con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());

            /* check connection */
            if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
            } else {
                    $this->conn = $con;
            }
            return $this->conn;
	}
    }   

    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT 
                user_login
            FROM 
                wp_users";
    //file_put_contents("queryPedidos.txt", $sql);

    $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Usuarios WP");
    
    while ($registros = mysqli_fetch_array($resultado)) {
        echo $registros[0];
        echo "<br>";
    }
?>