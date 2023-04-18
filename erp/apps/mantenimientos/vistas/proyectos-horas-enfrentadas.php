<!-- Horas Vendidas/Ordenes --> 
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");
        include_once($pathraiz."/apps/proyectos/includes/RandomColor.php");

        use \Colors\RandomColor;
        
        function random_color_part() {
            return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
        }

        function random_color() {
            return random_color_part() . random_color_part() . random_color_part();
        }        
        
        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sqlVendidas = "SELECT 
                            sum(PROYECTOS_TAREAS.cantidad)
                        FROM 
                            TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_TAREAS, PROYECTOS, erp_users  
                        WHERE 
                            PROYECTOS_TAREAS.tarea_id = TAREAS.id
                        AND
                            TAREAS.perfil_id = PERFILES.id
                        AND
                            PERFILES_HORAS.perfil_id = PERFILES.id
                        AND
                            PERFILES_HORAS.id = PROYECTOS_TAREAS.tipo_hora_id
                        AND
                            PROYECTOS_TAREAS.proyecto_id = PROYECTOS.id 
                        AND 
                            PROYECTOS_TAREAS.tecnico_id = erp_users.id 
                        AND 
                            PROYECTOS.id = ".$_GET['id']."
                        GROUP BY 
                            PROYECTOS.id";
        $sqlColoresVendidas = "SELECT 
                                    PERFILES.nombre, PERFILES_HORAS.nombre, PROYECTOS_TAREAS.cantidad 
                                FROM 
                                    TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_TAREAS, PROYECTOS, erp_users  
                                WHERE 
                                    PROYECTOS_TAREAS.tarea_id = TAREAS.id
                                AND
                                    TAREAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.id = PROYECTOS_TAREAS.tipo_hora_id
                                AND
                                    PROYECTOS_TAREAS.proyecto_id = PROYECTOS.id 
                                AND 
                                    PROYECTOS_TAREAS.tecnico_id = erp_users.id 
                                AND 
                                    PROYECTOS.id = ".$_GET['id']." ORDER BY PROYECTOS_TAREAS.cantidad";
        //file_put_contents("vendidas.txt", $sqlVendidas);
        $resultadoVendidas = mysqli_query($connString, $sqlVendidas) or die("Error al ejcutar la consulta de Horas Vendidas");
        $registrosVendidas = mysqli_fetch_row ($resultadoVendidas);
        
        $max = $registrosVendidas[0];
        $min = 0;
        $value = $registrosVendidas[0];
        $low = 0;
        $high = $max;
        $optimum = $max;
        
        //file_put_contents("coloresVendidas.txt", $sqlColoresVendidas);
        $resultadoColoresVendidas = mysqli_query($connString, $sqlColoresVendidas) or die("Error al ejcutar la consulta de Horas Vendidas");
    ?>

<!-- fuente: https://css-tricks.com/html5-meter-element/ Para darle estilos al tipo de horas y dibujarlas con diferentes colores -->
<style>
    
    <? 
        $contador = 0;
        $leyenda = "<ul class='swatch'>";
        $cssMeter = "meter.metervendidas::-webkit-meter-optimum-value {
                        background-image: linear-gradient(
                            to right, ";
       
        while ($registrosColoresVendidas = mysqli_fetch_array ($resultadoColoresVendidas)) {
            $contador = $contador + 1;
            //$color = random_color();
            $color = RandomColor::one(array(
                        'luminosity' => 'light',
                        'hue' => 'random'
                     ));

            if ($contador == 1) {
                $percent = ($registrosColoresVendidas[2]*100)/$value;
                $cssMeter .= $color." ".$percent."% ";
            }
            else {
                $cssMeter .= $color." ".$percent."%, ";
                $percent = ($registrosColoresVendidas[2]*100)/$value;
                $cssMeter .= $color." ".$percent."% ";
            }
            if ($contador != mysqli_num_rows($resultadoColoresVendidas)) {
                $cssMeter .= ",";
            }
            $leyenda .= "<li class='swatch__elem'><div class='leyenda-color' style='background-color:".$color.";'></div>".$registrosColoresVendidas[0]." ".$registrosColoresVendidas[1]." <span class='leyenda-texto'>".$registrosColoresVendidas[2]." h</span></li>";
        }     
        $leyenda .= "</ul>";
        $cssMeter .= "); }";

        echo $cssMeter;
    ?>
</style>
<p style="margin: 0 auto;width: 70%;line-height: 2.5;text-align: left;">
    Horas Vendidas <strong><? echo $max; ?></strong>
</p>

<meter class="metervendidas" min="<? echo $min; ?>" max="<? echo $max; ?>" low="<? echo $low; ?>" high="<? echo $high; ?>" optimum="<? echo $optimum; ?>" value="<? echo $value; ?>" style="margin: 0px auto 0px auto; width: 70%; height: 30px;">

</meter>

<?
    echo $leyenda;
?>

<!-- Horas Imputadas --> 
    
    <?
        $sqlTrabajadas = "SELECT 
                            sum(PROYECTOS_HORAS_IMPUTADAS.cantidad)
                        FROM 
                            TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_HORAS_IMPUTADAS, PROYECTOS, erp_users  
                        WHERE 
                            PROYECTOS_HORAS_IMPUTADAS.tarea_id = TAREAS.id
                        AND
                            TAREAS.perfil_id = PERFILES.id
                        AND
                            PERFILES_HORAS.perfil_id = PERFILES.id
                        AND
                            PERFILES_HORAS.id = PROYECTOS_HORAS_IMPUTADAS.tipo_hora_id
                        AND
                            PROYECTOS_HORAS_IMPUTADAS.proyecto_id = PROYECTOS.id 
                        AND 
                            PROYECTOS_HORAS_IMPUTADAS.tecnico_id = erp_users.id 
                        AND 
                            PROYECTOS.id = ".$_GET['id']."
                        GROUP BY 
                            PROYECTOS.id";
        $sqlColoresTrabajadas = "SELECT 
                                    TAREAS.nombre, PERFILES_HORAS.nombre, PROYECTOS_HORAS_IMPUTADAS.cantidad 
                                FROM 
                                    TAREAS, PERFILES, PERFILES_HORAS, PROYECTOS_HORAS_IMPUTADAS, PROYECTOS, erp_users  
                                WHERE 
                                    PROYECTOS_HORAS_IMPUTADAS.tarea_id = TAREAS.id
                                AND
                                    TAREAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.perfil_id = PERFILES.id
                                AND
                                    PERFILES_HORAS.id = PROYECTOS_HORAS_IMPUTADAS.tipo_hora_id
                                AND
                                    PROYECTOS_HORAS_IMPUTADAS.proyecto_id = PROYECTOS.id 
                                AND 
                                    PROYECTOS_HORAS_IMPUTADAS.tecnico_id = erp_users.id 
                                AND 
                                    PROYECTOS.id = ".$_GET['id']." ORDER BY PROYECTOS_HORAS_IMPUTADAS.cantidad ASC";
        
        
        $resultadoTrabajadas = mysqli_query($connString, $sqlTrabajadas) or die("Error al ejcutar la consulta de Horas Vendidas");
        $registrosTrabajadas = mysqli_fetch_row ($resultadoTrabajadas);
        
        
        
        $max = $registrosVendidas[0];
        $min = 0;
        $value = $registrosTrabajadas[0];
        $low = ($max*50)/100;
        $high = ($max*80)/100;
        $optimum = ($max*25)/100;
        
        //file_put_contents("coloresTrabajadas.txt", $sqlColoresTrabajadas);
        $resultadoColoresTrabajadas = mysqli_query($connString, $sqlColoresTrabajadas) or die("Error al ejcutar la consulta de Horas Vendidas");
    ?>

<!-- fuente: https://css-tricks.com/html5-meter-element/ Para darle estilos al tipo de horas y dibujarlas con diferentes colores -->
<style>
    
    <? 
        $contador = 0;
        $leyenda = "<ul class='swatch'>";
        $cssMeter = "meter.metertrabajadas::-webkit-meter-optimum-value {
                        background-image: linear-gradient(
                            to right, ";
       
        while ($registrosColoresTrabajadas = mysqli_fetch_array ($resultadoColoresTrabajadas)) {
            $contador = $contador + 1;
            //$color = random_color();
            $color = RandomColor::one(array(
                        'luminosity' => 'light',
                        'hue' => 'random'
                     ));

            if ($contador == 1) {
                $percent = ($registrosColoresTrabajadas[2]*100)/$value;
                $cssMeter .= $color." ".$percent."% ";
            }
            else {
                $cssMeter .= $color." ".$percent."%, ";
                $percent = ($registrosColoresTrabajadas[2]*100)/$value;
                $cssMeter .= $color." ".$percent."% ";
            }
            if ($contador != mysqli_num_rows($resultadoColoresTrabajadas)) {
                $cssMeter .= ",";
            }
            $leyenda .= "<li class='swatch__elem'><div class='leyenda-color' style='background-color:".$color.";'></div>".$registrosColoresTrabajadas[0]." ".$registrosColoresTrabajadas[1]." <span class='leyenda-texto'>".$registrosColoresTrabajadas[2]." h</span></li>";
        }     
        $leyenda .= "</ul>";
        $cssMeter .= "); }";

        echo $cssMeter;
    ?>
</style>
<p style="margin: 70px auto 0px;width: 70%;line-height: 2.5;text-align: left;">
    Horas Imputadas <strong><? echo $value; ?></strong>
</p>

<meter class="metertrabajadas" min="<? echo $min; ?>" max="<? echo $max; ?>" low="<? echo $low; ?>" high="<? echo $high; ?>" optimum="<? echo $optimum; ?>" value="<? echo $value; ?>" style="margin: 0px auto 0px auto; width: 70%; height: 30px;">

</meter>

<?
    echo $leyenda;
?>