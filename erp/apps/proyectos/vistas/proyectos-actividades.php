<?
    session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
if(isset($_GET['id'])) {   
    $html = "";
    $sql = "SELECT 
                    ACTIVIDAD.id actid,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.categoria_id,
                    ACTIVIDAD_CATEGORIAS.nombre,
                    ACTIVIDAD.item_id as item,
                    ACTIVIDAD.nombre AS titulo,
                    ACTIVIDAD.fecha,
                    ACTIVIDAD.fecha_mod,
                    CREADA.nombre,
                    ACTIVIDAD_ESTADOS.nombre, 
                    ACTIVIDAD_ESTADOS.color,
                    ACTIVIDAD_PRIORIDADES.nombre, 
                    ACTIVIDAD_PRIORIDADES.color,
                    CLIENTES.nombre,
                    ASIGNADO.nombre,
                    ASIGNADO.id,
                    (SELECT PROYECTOS.ref FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.ref FROM OFERTAS WHERE id = item),
                    (SELECT PROYECTOS.nombre FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.titulo FROM OFERTAS WHERE id = item),
                    TAREAS.nombre,
                    TAREAS.id,
                    CREADA.apellidos,
                    ASIGNADO.apellidos,
                    (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    ACTIVIDAD.instalacion,
                    CLIENTES_INSTALACIONES.nombre
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES
                    ON CLIENTES.id = ACTIVIDAD.cliente_id
                INNER JOIN ACTIVIDAD_CATEGORIAS
                    ON ACTIVIDAD.categoria_id = ACTIVIDAD_CATEGORIAS.id 
                INNER JOIN TAREAS
                    ON ACTIVIDAD.tarea_id = TAREAS.id 
                INNER JOIN ACTIVIDAD_ESTADOS
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                INNER JOIN ACTIVIDAD_PRIORIDADES 
                    ON ACTIVIDAD_PRIORIDADES.id = ACTIVIDAD.prioridad_id
                INNER JOIN erp_users AS CREADA
                    ON ACTIVIDAD.responsable = CREADA.id 
                LEFT JOIN erp_users AS ASIGNADO
                    ON ACTIVIDAD.tecnico_id = ASIGNADO.id 
                INNER JOIN PROYECTOS
                    ON PROYECTOS.id = ACTIVIDAD.item_id 
                INNER JOIN CLIENTES_INSTALACIONES
                    ON ACTIVIDAD.instalacion = CLIENTES_INSTALACIONES.id 
                WHERE 
                    PROYECTOS.id = ".$_GET['id']."
                ORDER BY 
                    ACTIVIDAD.fecha DESC";

    file_put_contents("arrayActis.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("database error:");
    
    echo "<table class='table table-striped table-hover table-responsive' id='tabla-act'>
                <thead>
                    <tr class='bg-dark'>
                        <th class='text-center'>REF</th>
                        <th class='text-center'>FECHA</th>
                        <th class='text-center'>TITULO</th>
                        <th class='text-center'>INSTALACIÓN</th>
                        <th class='text-center'>TAREA</th>
                        <th class='text-center'>ASIGNADO</th>
                        <th class='text-center'>HORAS</th>
                        <th class='text-center'>PRIORIDAD</th>
                        <th class='text-center'>ESTADO</th>
                        <th class='text-center'>ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>";
    

    while( $row = mysqli_fetch_array($res) ) {
        if ($row[15] == $_SESSION['user_session']) {
            $button = "<button class='btn btn-success btn-circle get-plan' data-id='".$row[0]."' data-soltar='1' title='Soltar Tarea'><img src='/erp/img/check.png'></button>";
        }
        else {
            $button = "<button class='btn btn-info btn-circle get-plan' data-id='".$row[0]."' data-soltar='0' title='Coger Tarea'><img src='/erp/img/link-w.png'></button>";
        }
        $cellPriorStyle = "label-".$row[12];
        $cellStateStyle = "label-".$row[10];
        
        if($row[24] != "") {
            $totalHoras = $row[24];
        }
        else {
            $totalHoras = 0;
        }
        $strUsers="";
        $sqlTecAsig="SELECT erp_users.nombre, erp_users.apellidos
                     FROM erp_users
                     INNER JOIN ACTIVIDAD_USUARIO ON 
                     erp_users.id=ACTIVIDAD_USUARIO.user_id 
                     WHERE ACTIVIDAD_USUARIO.actividad_id=".$row[0];
        $resTecAsig = mysqli_query($connString, $sqlTecAsig) or die("error select tecnicos asignados actividad");
        while( $rowTecAsig = mysqli_fetch_array($resTecAsig) ) {
            $strUsers.=$rowTecAsig[0]." ".substr($rowTecAsig[1],0,1).".\n";
        }
        
        echo "
            <tr data-id='".$row[0]."'>
                <td>".$row[1]."</td>
                <td class='text-center'>".$row[6]."</td>
                <td>".$row[5]."</td>
                <td class='text-center'>".$row[26]."</td>
                <td class='text-center'>".$row[20]."</td>
                <td class='text-center'>".$strUsers."</td>
                <td class='text-center'>".$totalHoras."</td>
                <td class='text-center ".$cellPriorStyle."' ><span class='label ".$cellPriorStyle."'>".$row[11]."</span></td>
                <td class='text-center ".$cellStateStyle."' ><span class='label ".$cellStateStyle."'>".$row[9]."</span></td>
                <td class='text-center'>".$button."</td>
            </tr>
        ";
    }
    echo "      </tbody>
                </table>";
    
    echo $html;
} //if isset btn_login

?>
<!-- /MATERIALES -->
