<?php
//para ver posibles errores
ini_set('display_errors', true);
//funcion que devuelve el numero de actividades inportantes que estan pendientes
function inportant_activities($session_id)
{
  //ruta comun
  $pathraiz = $_SERVER['DOCUMENT_ROOT'];
  //conexion a la db
  require_once($pathraiz . "/erp/connection.php");
  //creamos nuevo objeto de conexion, esto es posible debido a que hemos incluido el archivo connection.php
  $db = new dbObj();
  //string de conexion
  $connString =  $db->getConnstring();
  //query
  $sql = "SELECT id,ref,nombre,prioridad_id,fecha_fin FROM ACTIVIDAD WHERE responsable = " . $session_id . " OR  tecnico_id = " . $session_id . ";";
  //ejecutamos la query
  $result = mysqli_query($connString, $sql);
  $rows=0;
  //bloque de codigo que se ejecutara siempre que haya otra row devuelta por la query
  while ($row = mysqli_fetch_assoc($result)) {
    //si los registros tienen cierto id de prioridad se ejecutara el bloque de codigo
    if ($row['prioridad_id'] == 3 || $row['prioridad_id'] == 4) {
      //se suma una linea nueva a la tabla
      $rows++;
    }
  }
  return $rows;

  mysqli_close($connString);
}

?>