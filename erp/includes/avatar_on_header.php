<?php
//funcion que devuelve la ruta del avatr actual
function get_avatar_routes(){
    $db = new dbObj();
    $connString =  $db->getConnstring();
    $sql = "SELECT avatar FROM erp_users WHERE id = ".$_SESSION["user_session"].";";
    $result = mysqli_query($connString, $sql) or die("Error al encontrar el avatar");
    $row = mysqli_fetch_assoc($result);
    if($row['avatar']=='' || $row['avatar']==null){
        return "/erp/img/avatares/default.png";
    }else{
        return "/erp/img/avatares/" . $row['avatar']; 
        
    }

}
?>
<img style="width: 20px;height:20px;" src=<?php echo get_avatar_routes() ?> alt="">