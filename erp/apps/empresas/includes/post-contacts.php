<?php
//para ver posibles errores

//ruta comun
$pathraiz = $_SERVER['DOCUMENT_ROOT'];
//conexion a la db
require_once($pathraiz . "/erp/connection.php");
//creamos nuevo objeto de conexion, esto es posible debido a que hemos incluido el archivo connection.php
$db = new dbObj();
//string de conexion
$connString =  $db->getConnstring();
file_put_contents("tttttarget.txt",$_POST);
// Get the form values from the $_POST array
$nombre = $_POST['name'];
$cargo = $_POST['job'];
$mail = $_POST['mail'];
$telefono = $_POST['phone'];
$descripcion = $_POST['description'];
$id=$_POST['id'];

//query
$sql = "INSERT INTO ".$_POST['tipo']." (nombre,cargo, mail, telefono, descripcion, cliente_id) VALUES ('$nombre','$cargo', '$mail', '$telefono', '$descripcion', '$id');";

//ejecutamos la query
$result = mysqli_query($connString, $sql);

//array para almacenar los resultados de la consulta
if ($result) {
  echo json_encode(array('success' => true));
} else {
  echo json_encode(array('success' => false, 'error' => mysqli_error($connString)));
}

?>