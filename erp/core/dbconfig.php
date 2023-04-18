<?php
 $db_host = "127.0.0.1";
 $db_name = "erp";
 $db_user = "genelek_erp";
 $db_pass = "Sistemas2111";
 
 try{
  
    $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 04/05/2022 Setear como utf8
    $db_con->exec("set names utf8");
 }
 catch(PDOException $e){
    echo $e->getMessage();
 }
?>