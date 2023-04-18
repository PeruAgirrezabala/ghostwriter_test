<?
    //session_start();
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");
    include($pathraiz."/common.php");
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    $anyo=$_GET['year'];
    $month=$_GET['month'];
    $detectado=$_GET['detectado'];
    $por=$_GET['por'];
    $proyecto=$_GET['proyecto'];
    
    if($anyo == ""){
        $anyo="";
    }else{
        $anyo="AND CALIDAD_NOCONFORMIDADES.fecha LIKE '".$_GET['year']."%'";
    }
    
    if($month == ""){
        $mes="";
    }else{
        $mes="AND CALIDAD_NOCONFORMIDADES.fecha LIKE '%-".$_GET['month']."-%'";
    }
    
    if(($detectado == "") || ($detectado == null)){
        $detectado="";
    }else{
        $detectado="AND CALIDAD_NOCONFORMIDADES.detectado_por='".$_GET['detectado']."'";
    }
    
    if(($por == "")|| ($por == undefined)){
        $por="";
    }else{
        $por="AND CALIDAD_NOCONFORMIDADES.detectado=".$_GET['por'];
    }
    
    if($proyecto == ""){
        $proyecto="";
    }else{
        $proyecto="AND CALIDAD_NOCONFORMIDADES.proyecto_id=".$_GET['proyecto'];
    }
    
    //$anyo="AND CALIDAD_NOCONFORMIDADES.fecha LIKE '".$_GET['year']."%'";
    $ands=$anyo." ".$mes." ".$detectado." ".$por." ".$proyecto;
    
    
    $sql = "SELECT 
                CALIDAD_NOCONFORMIDADES.id,
                CALIDAD_NOCONFORMIDADES.ref,  
                CALIDAD_NOCONFORMIDADES.detectado_por,
                CALIDAD_NOCONFORMIDADES.detectado,
                CALIDAD_NOCONFORMIDADES.proyecto_id,
                PROYECTOS.nombre,
                CLIENTES.nombre,
                CLIENTES.img, 
                CALIDAD_NOCONFORMIDADES.fecha,
                CALIDAD_NOCONFORMIDADES.descripcion,
                CALIDAD_NOCONFORMIDADES.resolucion,
                CALIDAD_NOCONFORMIDADES.causa,
                CALIDAD_NOCONFORMIDADES.cierre,
                CALIDAD_NOCONFORMIDADES.fecha_cierre
            FROM 
                CALIDAD_NOCONFORMIDADES, PROYECTOS, CLIENTES, erp_users, PROVEEDORES
            WHERE 
                CALIDAD_NOCONFORMIDADES.proyecto_id = PROYECTOS.id
            AND
                PROYECTOS.cliente_id = CLIENTES.id
                ".$ands."
            GROUP BY
		CALIDAD_NOCONFORMIDADES.id ASC
            ORDER BY 
                CALIDAD_NOCONFORMIDADES.fecha DESC";

    file_put_contents("NoConformidades.txt", $sql);
    $res = mysqli_query($connString, $sql) or die("ERROR SELECT NO CONFORMIDAD");
    
    $html .= "<table class='table table-striped table-hover' id='tabla-calidad-conformidades'>
                <thead>
                    <tr class='bg-dark'>
                        <th class='text-center'>REF</th>
                        <th class='text-center'>DETECTADO</th>
                        <th class='text-center'>POR</th>
                        <th class='text-center'>PROYECTO</th>
                        <th class='text-center'>DESCRIPCIÓN</th>
                        <th class='text-center'>FECHA DETECTADO</th>
                        <th class='text-center'>FECHA CIERRE</th>
                        <th class='text-center'>E</th>
                    </tr>
                </thead>
                <tbody>";
    
    while( $row = mysqli_fetch_array($res) ) {
        $idConformidad = $row[0];
        $refConformidad = $row[1];
        $detectadoConformidadPor = $row[2];
        $detectadoConformidad = $row[3];        
        $proyectoidConformidad = $row[4];
        $proyectoConformidad = $row[5];
        $clienteConformidad = $row[6];
        $clienteImgConformidad = $row[7];
        $fechaConformidad = $row[8];
        $descConformidad = $row[9];
        $resolucionConformidad = $row[10];
        $causaConformidad = $row[11];
        $cierreConformidad = $row[12];
        $fecha_cierreConformidad = $row[13];
        
        switch ($detectadoConformidadPor){
            case "genelek":
                $sql="SELECT 
                        erp_users.id,
                        erp_users.nombre,
                        erp_users.apellidos
                      FROM 
                        erp_users
                      WHERE 
                        erp_users.id=".$detectadoConformidad;
                file_put_contents("selectUsuarios.txt", $sql);
                $res2 = mysqli_query($connString, $sql) or die("Error Select usuarios");
                $row2 = mysqli_fetch_array($res2);
                $detectadoConformidad = $row2[1]." ".$row2[2];
                break;
            case "cliente":
                $sql="SELECT 
                        CLIENTES.id,
                        CLIENTES.nombre
                      FROM 
                        CLIENTES
                      WHERE 
                        CLIENTES.id=".$detectadoConformidad;
                $res2 = mysqli_query($connString, $sql) or die("Error Select clientes");
                $row2 = mysqli_fetch_array($res2);
                $detectadoConformidad = $row2[1];
                break;
            case "proveedor":
                $sql="SELECT 
                        PROVEEDORES.id,
                        PROVEEDORES.nombre
                      FROM 
                        PROVEEDORES
                      WHERE 
                        PROVEEDORES.id=".$detectadoConformidad;
                $res2 = mysqli_query($connString, $sql) or die("Error Select proveedores");
                $row2 = mysqli_fetch_array($res2);
                $detectadoConformidad = $row2[1];
                break;
            case "auditor":
                $sql="SELECT 
                        AUDITORES.id,
                        AUDITORES.nombre
                      FROM 
                        AUDITORES
                      WHERE 
                        AUDITORES.id=".$detectadoConformidad;
                $res2 = mysqli_query($connString, $sql) or die("Error Select auditores");
                $row2 = mysqli_fetch_array($res2);
                $detectadoConformidad = $row2[1];
                break;
        }
        $detectadoConformidadPor = ucfirst($detectadoConformidadPor);
        if(strlen($descConformidad)>80){
            $trespuntos="...";
        }else{
            $trespuntos="";
        }
        $html .= "
                <tr data-id='".$idConformidad."'>
                    <td class='text-left'>".$refConformidad."</td>
                    <td class='text-center'>".$detectadoConformidadPor."</td>
                    <td class='text-center'>".$detectadoConformidad."</td>
                    <td>
                        <div class='tabla-img'>
                            <img src='".$clienteImgConformidad."'>
                        </div> 
                        <div class='tabla-texto'>
                            ".$proyectoConformidad."<span class='bajotexto'>".$clienteConformidad."</span>
                        </div>
                    </td>
                    <td class='text-center'>".substr($descConformidad, 0, 80).$trespuntos."</td>
                    <td class='text-center'>".$fechaConformidad."</td>
                    <td class='text-center'>".$fecha_cierreConformidad."</td>      
                    <td class='text-center'><button class='btn btn-circle btn-danger remove-conformidad' data-id='".$idConformidad."' title='Eliminar No Conformidad'><img src='/erp/img/cross.png' style='height: 20px;'></button></td>
                </tr>";
    }
    $html .= "      </tbody>
                </table>";
    $html .='<div id="delete_conformidad_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho" style="width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CONFIRMACIÓN ELIMINAR CONFORMIDAD</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                        <input type="hidden" value="" name="del_conformidad_id" id="del_conformidad_id">
                        <div class="form-group">
                            <label class="labelBefore">¿Estas seguro de que deseas eliminar la no conformidad?</label>
                        </div>
                        <div class="form-group">
                            
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_del_conformidad" data-id="" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>';
    echo $html;

?>