<?php
    session_start();
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/core/dbconfig.php");
    require_once($pathraiz."/connection.php");

    function estructuraCorreoActividad($id_act){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT 
                    ACTIVIDAD.id as actid,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.nombre,
                    ACTIVIDAD.descripcion,
                    ACTIVIDAD.fecha,
                    ACTIVIDAD.fecha_mod,
                    ACTIVIDAD.instalacion,
                    ACTIVIDAD.solucion,
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.observaciones,
                    ACTIVIDAD.item_id,
                    ACTIVIDAD_ESTADOS.nombre,
                    ACTIVIDAD_ESTADOS.color,
                    ACTIVIDAD_PRIORIDADES.nombre,
                    ACTIVIDAD_PRIORIDADES.color,
                    CREADA.nombre,
                    CREADA.apellidos,
                    ASIGNADO.nombre,
                    ASIGNADO.apellidos,
                    CLIENTES.id,
                    CLIENTES.nombre,
                    CLIENTES.direccion,
                    CLIENTES.poblacion,
                    CLIENTES.provincia,
                    CLIENTES.cp,
                    CLIENTES.pais,
                    CLIENTES.telefono,
                    CLIENTES.nif,
                    CLIENTES.email,
                    ACTIVIDAD.item_id as item,
                    (SELECT PROYECTOS.ref FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.nombre FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.descripcion FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.fecha_ini FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.ref FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.titulo FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.descripcion FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.fecha FROM OFERTAS WHERE id = item),
                    ASIGNADO.id,
                    ACTIVIDAD.estado_id,
                    ACTIVIDAD.prioridad_id,
                    TAREAS.nombre,
                    ACTIVIDAD.tarea_id,
                    ACTIVIDAD.imputable,
                    ACTIVIDAD.facturable,
                    ACTIVIDAD_CATEGORIAS.nombre,
                    ACTIVIDAD.categoria_id,
                    ACTIVIDAD.fecha_factu,
                    TAREAS.perfil_id,
                    (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    ACTIVIDAD.path,
                    ACTIVIDAD.fecha_fin,
                    CREADA.id
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES 
                    ON ACTIVIDAD.cliente_id = CLIENTES.id
                INNER JOIN ACTIVIDAD_PRIORIDADES  
                    ON ACTIVIDAD.prioridad_id = ACTIVIDAD_PRIORIDADES.id 
                INNER JOIN erp_users CREADA  
                    ON ACTIVIDAD.responsable = CREADA.id 
                LEFT JOIN erp_users AS ASIGNADO
                    ON ACTIVIDAD.tecnico_id = ASIGNADO.id  
                LEFT JOIN ACTIVIDAD_ESTADOS 
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                LEFT JOIN ACTIVIDAD_CATEGORIAS 
                    ON ACTIVIDAD.categoria_id = ACTIVIDAD_CATEGORIAS.id
                LEFT JOIN TAREAS 
                    ON ACTIVIDAD.tarea_id = TAREAS.id
                WHERE
                    ACTIVIDAD.id = ".$id_act;
        $result = mysqli_query($connString, $sql) or die("Error al guardar la Actividad");
        $registros = mysqli_fetch_row($result);
        
        $id = $id_act;
        $ref = $registros[1];
        $tituloAct = $registros[2];
        $descripcionAct = $registros[3];
        $fechaAct = $registros[4];
        $fecha_mod = $registros[5];
        $instalacionAct = $registros[6];
        $solucionAct = $registros[7];
        $dateSol = new DateTime($registros[8]);
        $fecha_sol = $dateSol->format('Y-m-d');;
        $obsAct = $registros[9];
        $proyecto_id = $registros[10];
        $estado = $registros[11];
        $estadocolor = $registros[12];
        $prior = $registros[13];
        $priorcolor = $registros[14];
        $creadapor = $registros[15];
        $creadapor_apellido = $registros[16];
        $tecnico = $registros[17];
        $tecnico_apellido = $registros[18];
        $idcli = $registros[19];
        $nombrecli = $registros[20];
        $dircli = $registros[21];
        $poblacioncli = $registros[22];
        $provinciacli = $registros[23];
        $cpcli = $registros[24];
        $paiscli = $registros[25];
        $tlfnocli = $registros[26];
        $nifcli = $registros[27];
        $emailcli = $registros[28];
        $itemId = $registros[29];
        $categoriaId = $registros[46];
        $fecha_fin = $registros[51];
        $creadorId = $registros[52];
        $tecnico_id = $registros[38];
        $estado_id = $registros[39];
        $prior_id = $registros[40];
        $tareaNombre = $registros[41];
        $tareaId = $registros[42];
        if ($registros[43] == 1) {
            $imputable = "SI";
        }
        else {
            $imputable = "NO";
        }
        if ($registros[44] == 1) {
            $facturable = "SI";
        }
        else {
            $facturable = "NO";
        }
        $categoriaNombre = $registros[45];
        $fechaFactu = $registros[47];
        $tareaPerfilID = $registros[48];
        $totalHoras = $registros[49];
        $path = $registros[50];
                switch ($categoriaId) {
            case "1":
                $itemTipo = "MANTENIMIENTO";
                $item_ref = $registros[30];
                $item_nombre = $registros[31];
                $item_desc = $registros[32];
                $item_fecha = $registros[33];
                $mantId = $itemId;
                break;
            case "3":
                $itemTipo = "PROYECTO";
                $item_ref = $registros[30];
                $item_nombre = $registros[31];
                $item_desc = $registros[32];
                $item_fecha = $registros[33];
                $proyId = $itemId;
                break;
            case "4":
                $itemTipo = "OFERTA";
                $item_ref = $registros[34];
                $item_nombre = $registros[35];
                $item_desc = $registros[36];
                $item_fecha = $registros[37];
                $oferId = $itemId;
                break;
            default:
                $item_ref = "";
                $objItemlink ='';
                $item_nombre = "";
                $item_desc = "";
                $item_fecha = "";
                break;
        }
        //$id_act;
        $tecnicos="";
        $sqlUsrAct="SELECT erp_users.nombre, erp_users.apellidos, erp_users.id
                    FROM ACTIVIDAD_USUARIO 
                    INNER JOIN erp_users 
                    ON ACTIVIDAD_USUARIO.user_id=erp_users.id 
                    WHERE actividad_id=".$id_act;
        $resUsrAct = mysqli_query($connString, $sqlUsrAct) or die("Error al guardar la Actividad");
        
        while($regUsrAct = mysqli_fetch_array($resUsrAct)){
            $tecnicos.=$regUsrAct[0]." ".$regUsrAct[1].", ";
            file_put_contents("logs.txt", $regUsrAct);
        }
        file_put_contents("logTecs.txt", $tecnicos);
        
        $mensajeCorreo='<div id="act-view" style="padding-right: 10px; ">
               <h3>Registro</h3>
                <label class="viewTitle "><u>RESPONSABLE:</u></label> <label id="view_titulo">'.$creadapor.' '.$creadapor_apellido.'</label>
              <div class="form-group form-group-view">
                <label class="viewTitle "><u>FECHA:</u></label> <label id="view_titulo">'.$fechaAct.'</label> <label class="viewTitle" style="padding-left:5em"> <u>FECHA FIN:</u></label> <label id="view_titulo">'.$fecha_fin.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>CLIENTE:</u></label> <label id="view_titulo">'.$nombrecli.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>INSTALACIÓN:</u></label> <label id="view_titulo">'.$nameInstalacion.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>TÍTULO:</u></label> <label id="view_titulo">'.$tituloAct.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>DESCRIPCIÓN:</u></label> <label id="view_titulo">'.$descripcionAct.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>TOTAL HORAS:</u></label> <label id="view_titulo" class="label label-warning">'.$totalHoras.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>ESTADO:</u></label> <label id="view_estado" class="label label-'.$estadocolor.'">'.$estado.'</label>
              </div></div>';
        
        $mensajeCorreo.="<div id='act-view' style='padding-right: 10px; '>
              <h3>Clasificación</h3>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>CATEGORÍA:</u></label> <label id='view_titulo'>".$categoriaNombre."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>TAREA:</u></label> <label id='view_titulo'>".$tareaNombre."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>ELEMENTO:</u></label> <label id='view_titulo'>".$itemTipo." - ".$item_ref."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>PRIORIDAD:</u></label> <label id='view_prior' class='label label-".$priorcolor."'>".$prior."</label>
              </div>
              <div class='form-group form-group-view' id='act_tecs'>
                <label class='viewTitle '><u>TÉCNICO/S:</u></label>
                <label id='view_titulo'>".$tecnicos."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>FACTURABLE:</u></label> <label id='view_titulo'>".$facturable."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>IMPUTABLE:</u></label> <label id='view_titulo'>".$imputable."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>Última modificación:</u></label> <label id='view_ref' style='padding-left: 8px; padding-right: 8px; background-color: #333; color: #ffffff;'>".$fecha_mod."</label>
              </div>
              </div>";
        
        $sqlActividades="SELECT 
                    ACTIVIDAD_DETALLES.nombre,
                    ACTIVIDAD_DETALLES.descripcion, 
                    ACTIVIDAD_DETALLES.fecha, 
                    erp_users.nombre,
                    erp_users.apellidos,
                    ACTIVIDAD_DETALLES.completado 
                    FROM ACTIVIDAD_DETALLES INNER JOIN erp_users ON ACTIVIDAD_DETALLES.erpuser_id=erp_users.id WHERE actividad_id =".$id_act;
        $result = mysqli_query($connString, $sqlActividades) or die("Error al guardar la Actividad");
        $actividades="<table>
                        <thead>
                            <tr>
                                <th>ESTADO</th>
                                <th>TITULO</th>
                                <th>FECHA</th>
                                <th>TECNICO</th>
                            </tr>
                        </thead>
                        <tbody>";
        while($registros = mysqli_fetch_row($result)){
            
            $actividades.="<tr>
                            <td> ".getColorEstado($registros[5])."</td>
                            <td> ".$registros[0]."</td>
                            <td> ".$registros[2]."</td>
                            <td> ".$registros[3]." ".$registros[4]."</td>
                           </tr>";
        }
        $actividades.="</tbody></table>";
        $mensajeCorreo.='<div style="padding-right: 10px; ">
               <h3>Actividades</h3>
               <div>'.$actividades.'</div>
               </div>';
        
        $sqlActividades2="SELECT 
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.fecha_factu, 
                    ACTIVIDAD.solucion, 
                    ACTIVIDAD.observaciones
                    FROM ACTIVIDAD WHERE ACTIVIDAD.id =".$id_act;
        $result2 = mysqli_query($connString, $sqlActividades2) or die("Error al guardar la Actividad");
        $registros2 = mysqli_fetch_row($result2);
        
        
        $mensajeCorreo.='<div style="padding-right: 10px; ">
                <h3>Finalicación</h3>
                </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>FECHA SOLUCIÓN:</u></label> <label id="view_titulo">'.$registros2[0].'</label>
                </div>
                </div><div class="form-group form-group-view">
                  <label class="viewTitle "><u>FECHA FACTURACIÓN:</u></label> <label id="view_titulo">'.$registros2[1].'</label>
                </div>
                </div><div class="form-group form-group-view">
                  <label class="viewTitle "><u>SOLUCIÓN:</u></label> <label id="view_titulo">'.$registros2[2].'</label>
                </div>
                </div><div class="form-group form-group-view">
                  <label class="viewTitle "><u>OBSERVACIONES:</u></label> <label id="view_titulo">'.$registros2[3].'</label>
                </div>
               </div>';
        
        return $mensajeCorreo;
        
    }
    
    function notificacionActividad($id_act,$msgactividad){
        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT 
                    ACTIVIDAD.id as actid,
                    ACTIVIDAD.ref,
                    ACTIVIDAD.nombre,
                    ACTIVIDAD.descripcion,
                    ACTIVIDAD.fecha,
                    ACTIVIDAD.fecha_mod,
                    ACTIVIDAD.instalacion,
                    ACTIVIDAD.solucion,
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.observaciones,
                    ACTIVIDAD.item_id,
                    ACTIVIDAD_ESTADOS.nombre,
                    ACTIVIDAD_ESTADOS.color,
                    ACTIVIDAD_PRIORIDADES.nombre,
                    ACTIVIDAD_PRIORIDADES.color,
                    CREADA.nombre,
                    CREADA.apellidos,
                    ASIGNADO.nombre,
                    ASIGNADO.apellidos,
                    CLIENTES.id,
                    CLIENTES.nombre,
                    CLIENTES.direccion,
                    CLIENTES.poblacion,
                    CLIENTES.provincia,
                    CLIENTES.cp,
                    CLIENTES.pais,
                    CLIENTES.telefono,
                    CLIENTES.nif,
                    CLIENTES.email,
                    ACTIVIDAD.item_id as item,
                    (SELECT PROYECTOS.ref FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.nombre FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.descripcion FROM PROYECTOS WHERE id = item),
                    (SELECT PROYECTOS.fecha_ini FROM PROYECTOS WHERE id = item),
                    (SELECT OFERTAS.ref FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.titulo FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.descripcion FROM OFERTAS WHERE id = item),
                    (SELECT OFERTAS.fecha FROM OFERTAS WHERE id = item),
                    ASIGNADO.id,
                    ACTIVIDAD.estado_id,
                    ACTIVIDAD.prioridad_id,
                    TAREAS.nombre,
                    ACTIVIDAD.tarea_id,
                    ACTIVIDAD.imputable,
                    ACTIVIDAD.facturable,
                    ACTIVIDAD_CATEGORIAS.nombre,
                    ACTIVIDAD.categoria_id,
                    ACTIVIDAD.fecha_factu,
                    TAREAS.perfil_id,
                    (SELECT sum(cantidad) FROM ACTIVIDAD_DETALLES_HORAS, ACTIVIDAD_DETALLES WHERE ACTIVIDAD_DETALLES_HORAS.actividad_detalle_id = ACTIVIDAD_DETALLES.id AND ACTIVIDAD_DETALLES.actividad_id = actid),
                    ACTIVIDAD.path,
                    ACTIVIDAD.fecha_fin,
                    CREADA.id
                FROM 
                    ACTIVIDAD
                LEFT JOIN CLIENTES 
                    ON ACTIVIDAD.cliente_id = CLIENTES.id
                INNER JOIN ACTIVIDAD_PRIORIDADES  
                    ON ACTIVIDAD.prioridad_id = ACTIVIDAD_PRIORIDADES.id 
                INNER JOIN erp_users CREADA  
                    ON ACTIVIDAD.responsable = CREADA.id 
                LEFT JOIN erp_users AS ASIGNADO
                    ON ACTIVIDAD.tecnico_id = ASIGNADO.id  
                LEFT JOIN ACTIVIDAD_ESTADOS 
                    ON ACTIVIDAD.estado_id = ACTIVIDAD_ESTADOS.id 
                LEFT JOIN ACTIVIDAD_CATEGORIAS 
                    ON ACTIVIDAD.categoria_id = ACTIVIDAD_CATEGORIAS.id
                LEFT JOIN TAREAS 
                    ON ACTIVIDAD.tarea_id = TAREAS.id
                WHERE
                    ACTIVIDAD.id = ".$id_act;
        file_put_contents("log00.txt", $sql);
        $result = mysqli_query($connString, $sql) or die("Error al guardar la Actividad");
        $registros = mysqli_fetch_row($result);
        
        $id = $id_act;
        $ref = $registros[1];
        $tituloAct = $registros[2];
        $descripcionAct = $registros[3];
        $fechaAct = $registros[4];
        $fecha_mod = $registros[5];
        $instalacionAct = $registros[6];
        $solucionAct = $registros[7];
        $dateSol = new DateTime($registros[8]);
        $fecha_sol = $dateSol->format('Y-m-d');;
        $obsAct = $registros[9];
        $proyecto_id = $registros[10];
        $estado = $registros[11];
        $estadocolor = $registros[12];
        $prior = $registros[13];
        $priorcolor = $registros[14];
        $creadapor = $registros[15];
        $creadapor_apellido = $registros[16];
        $tecnico = $registros[17];
        $tecnico_apellido = $registros[18];
        $idcli = $registros[19];
        $nombrecli = $registros[20];
        $dircli = $registros[21];
        $poblacioncli = $registros[22];
        $provinciacli = $registros[23];
        $cpcli = $registros[24];
        $paiscli = $registros[25];
        $tlfnocli = $registros[26];
        $nifcli = $registros[27];
        $emailcli = $registros[28];
        $itemId = $registros[29];
        $categoriaId = $registros[46];
        $fecha_fin = $registros[51];
        $creadorId = $registros[52];
        $tecnico_id = $registros[38];
        $estado_id = $registros[39];
        $prior_id = $registros[40];
        $tareaNombre = $registros[41];
        $tareaId = $registros[42];
        if ($registros[43] == 1) {
            $imputable = "SI";
        }
        else {
            $imputable = "NO";
        }
        if ($registros[44] == 1) {
            $facturable = "SI";
        }
        else {
            $facturable = "NO";
        }
        $categoriaNombre = $registros[45];
        $fechaFactu = $registros[47];
        $tareaPerfilID = $registros[48];
        $totalHoras = $registros[49];
        $path = $registros[50];
                switch ($categoriaId) {
            case "1":
                $itemTipo = "MANTENIMIENTO";
                $item_ref = $registros[30];
                $item_nombre = $registros[31];
                $item_desc = $registros[32];
                $item_fecha = $registros[33];
                $mantId = $itemId;
                break;
            case "3":
                $itemTipo = "PROYECTO";
                $item_ref = $registros[30];
                $item_nombre = $registros[31];
                $item_desc = $registros[32];
                $item_fecha = $registros[33];
                $proyId = $itemId;
                break;
            case "4":
                $itemTipo = "OFERTA";
                $item_ref = $registros[34];
                $item_nombre = $registros[35];
                $item_desc = $registros[36];
                $item_fecha = $registros[37];
                $oferId = $itemId;
                break;
            default:
                $item_ref = "";
                $objItemlink ='';
                $item_nombre = "";
                $item_desc = "";
                $item_fecha = "";
                break;
        }
        //$id_act;
        $tecnicos="";
        $sqlUsrAct="SELECT erp_users.nombre, erp_users.apellidos, erp_users.id
                    FROM ACTIVIDAD_USUARIO 
                    INNER JOIN erp_users 
                    ON ACTIVIDAD_USUARIO.user_id=erp_users.id 
                    WHERE actividad_id=".$id_act;
        $resUsrAct = mysqli_query($connString, $sqlUsrAct) or die("Error al guardar la Actividad");
        
        while($regUsrAct = mysqli_fetch_array($resUsrAct)){
            $tecnicos.=$regUsrAct[0]." ".$regUsrAct[1].", ";
            file_put_contents("logs.txt", $regUsrAct);
        }
        file_put_contents("logTecs.txt", $tecnicos);
        
        $mensajeCorreo='<div><p>'.$msgactividad.'</p></div>';
        
        $mensajeCorreo.='<div id="act-view" style="padding-right: 10px; ">
               <h3>Registro</h3>
                <label class="viewTitle "><u>RESPONSABLE:</u></label> <label id="view_titulo">'.$creadapor.' '.$creadapor_apellido.'</label>
              <div class="form-group form-group-view">
                <label class="viewTitle "><u>FECHA:</u></label> <label id="view_titulo">'.$fechaAct.'</label> <label class="viewTitle" style="padding-left:5em"> <u>FECHA FIN:</u></label> <label id="view_titulo">'.$fecha_fin.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>CLIENTE:</u></label> <label id="view_titulo">'.$nombrecli.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>INSTALACIÓN:</u></label> <label id="view_titulo">'.$nameInstalacion.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>TÍTULO:</u></label> <label id="view_titulo">'.$tituloAct.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>DESCRIPCIÓN:</u></label> <label id="view_titulo">'.$descripcionAct.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>TOTAL HORAS:</u></label> <label id="view_titulo" class="label label-warning">'.$totalHoras.'</label>
              </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>ESTADO:</u></label> <label id="view_estado" class="label label-'.$estadocolor.'">'.$estado.'</label>
              </div></div>';
        
        $mensajeCorreo.="<div id='act-view' style='padding-right: 10px; '>
              <h3>Clasificación</h3>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>CATEGORÍA:</u></label> <label id='view_titulo'>".$categoriaNombre."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>TAREA:</u></label> <label id='view_titulo'>".$tareaNombre."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>ELEMENTO:</u></label> <label id='view_titulo'>".$itemTipo." - ".$item_ref."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>PRIORIDAD:</u></label> <label id='view_prior' class='label label-".$priorcolor."'>".$prior."</label>
              </div>
              <div class='form-group form-group-view' id='act_tecs'>
                <label class='viewTitle '><u>TÉCNICO/S:</u></label>
                <label id='view_titulo'>".$tecnicos."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>FACTURABLE:</u></label> <label id='view_titulo'>".$facturable."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>IMPUTABLE:</u></label> <label id='view_titulo'>".$imputable."</label>
              </div>
              <div class='form-group form-group-view'>
                <label class='viewTitle '><u>Última modificación:</u></label> <label id='view_ref' style='padding-left: 8px; padding-right: 8px; background-color: #333; color: #ffffff;'>".$fecha_mod."</label>
              </div>
              </div>";
        
        $sqlActividades="SELECT 
                    ACTIVIDAD_DETALLES.nombre,
                    ACTIVIDAD_DETALLES.descripcion, 
                    ACTIVIDAD_DETALLES.fecha, 
                    erp_users.nombre,
                    erp_users.apellidos,
                    ACTIVIDAD_DETALLES.completado 
                    FROM ACTIVIDAD_DETALLES INNER JOIN erp_users ON ACTIVIDAD_DETALLES.erpuser_id=erp_users.id WHERE actividad_id =".$id_act;
        $result = mysqli_query($connString, $sqlActividades) or die("Error al guardar la Actividad");
        $actividades="<table>
                        <thead>
                            <tr>
                                <th>ESTADO</th>
                                <th>TITULO</th>
                                <th>FECHA</th>
                                <th>TECNICO</th>
                            </tr>
                        </thead>
                        <tbody>";
        while($registros = mysqli_fetch_row($result)){
            
            $actividades.="<tr>
                            <td> ".getColorEstado($registros[5])."</td>
                            <td> ".$registros[0]."</td>
                            <td> ".$registros[2]."</td>
                            <td> ".$registros[3]." ".$registros[4]."</td>
                           </tr>";
        }
        $actividades.="</tbody></table>";
        $mensajeCorreo.='<div style="padding-right: 10px; ">
               <h3>Actividades</h3>
               <div>'.$actividades.'</div>
               </div>';
        
        $sqlActividades2="SELECT 
                    ACTIVIDAD.fecha_solucion,
                    ACTIVIDAD.fecha_factu, 
                    ACTIVIDAD.solucion, 
                    ACTIVIDAD.observaciones
                    FROM ACTIVIDAD WHERE ACTIVIDAD.id =".$id_act;
        $result2 = mysqli_query($connString, $sqlActividades2) or die("Error al guardar la Actividad");
        $registros2 = mysqli_fetch_row($result2);
        
        
        $mensajeCorreo.='<div style="padding-right: 10px; ">
                <h3>Finalicación</h3>
                </div><div class="form-group form-group-view">
                <label class="viewTitle "><u>FECHA SOLUCIÓN:</u></label> <label id="view_titulo">'.$registros2[0].'</label>
                </div>
                </div><div class="form-group form-group-view">
                  <label class="viewTitle "><u>FECHA FACTURACIÓN:</u></label> <label id="view_titulo">'.$registros2[1].'</label>
                </div>
                </div><div class="form-group form-group-view">
                  <label class="viewTitle "><u>SOLUCIÓN:</u></label> <label id="view_titulo">'.$registros2[2].'</label>
                </div>
                </div><div class="form-group form-group-view">
                  <label class="viewTitle "><u>OBSERVACIONES:</u></label> <label id="view_titulo">'.$registros2[3].'</label>
                </div>
               </div>';
        
        return $mensajeCorreo;
        
    }
    
    function getColorEstado($estado){
        switch($estado){
            case 0:
                $color='No completado';
                break;
            case 1:
                $color='A Medias';
                break;
            case 2:
                $color='Completado';
                break;
        }
        return $color;
    }
    
    
?>