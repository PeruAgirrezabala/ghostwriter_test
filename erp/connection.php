<?php
Class dbObj{
    /* Database connection start */
    var $servername = "127.0.0.1";
    var $username = "genelek_erp";
    var $password = "Sistemas2111";
    var $dbname = "erp";
    var $conn;
    function getConnstring() {
        $con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
        // 04/05/2022 Setear como utf8
        mysqli_set_charset($con, "utf8");
        /* check connection */
        if (mysqli_connect_errno()) {
                printf("Local DB: Connect failed: %s\n", mysqli_connect_error());
                exit();
        } else {
                $this->conn = $con;
        }
        return $this->conn;
    }
}


Class dbObjCorpo{
    // Database connection start
    // var $servernameCorpo = "mysql380.srv-acens.com"; // OLD
    var $servernameCorpo = "POAPMYSQL142.dns-servicio.com";
    // var $usernameCorpo = "u5918118_genelek";
    // var $passwordCorpo = "Lde2682k%"; // new = Lde2682k%
    var $usernameCorpo = "usr_genelekerp";
    var $passwordCorpo = "7Xvy19a#5";
    var $dbnameCorpo = "db5918118_newgenelek";
    var $connCorpo;
    function getConnstring() {
        $conCorpo = mysqli_connect($this->servernameCorpo, $this->usernameCorpo, $this->passwordCorpo, $this->dbnameCorpo) or die("Connection failed: " . mysqli_connect_error());

        // check connection
        if (mysqli_connect_errno()) {
                printf("DB Online: Connect failed: %s\n", mysqli_connect_error());
                exit();
        } else {
                $this->connCorpo = $conCorpo;
        }
        return $this->connCorpo;
    }
}

?>