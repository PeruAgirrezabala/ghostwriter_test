<?php

  //ruta comun
  $pathraiz = $_SERVER['DOCUMENT_ROOT'];
  //conexion a la db
  require_once($pathraiz . "/erp/connection.php");
  //creamos nuevo objeto de conexion, esto es posible debido a que hemos incluido el archivo connection.php
  $db = new dbObj();
  //string de conexion
  $connString =  $db->getConnstring();
  //query

  $sql = "SELECT id,nombre,cargo,mail,telefono FROM ".$_GET['tipo']." WHERE cliente_id= ".$_GET['id'].";";
  //ejecutamos la query
  $result = mysqli_query($connString, $sql);
//array para almacenar los resultados de la consulta
$data = array();

//recorremos el resultado y lo agregamos al array $data
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

//devolvemos los resultados en formato JSON
echo json_encode($data);

//cerramos la conexion a la base de datos
mysqli_close($connString);

?>


