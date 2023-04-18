<?php
    //ruta a la capeta de avatares
    $dir = "../../../img/avatares";
    //se confirma que el directorio esta en la ruta especificada
    if (is_dir($dir)) {
        //se usa la funcion para guardar el contenido de toda la carpeta de avatares
        $a = scandir($dir);
        //al haber mas archivos en el mismo directorio de los avatares se van a filtrar en base a la extension 
        foreach ($a as $key => $route) {
            $extension = pathinfo($route, PATHINFO_EXTENSION);
            if ($extension !== "png") {
                unset($a[intval($key)]);
            }

        }
        //se codifican como Json para enviar los datos de vuelta de la peticion de ajax
        echo json_encode($a);
    //en caso de que no exista salta el mensaje de error
    } else {
        echo "Error: directory does not exist";
    }




?>