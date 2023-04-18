<!-- Contratista seleccionado -->
<?
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    include_once($pathraiz."/connection.php");

    $db = new dbObj();
    $connString =  $db->getConnstring();
?>
<div class="table-responsive">
<table class="table table-striped table-hover" id="tabla-doc-riesgos" ondrop="drop(event)" ondragover="allowDrop(event)">
    <thead>
      <tr class="bg-dark">
        <th class="text-center">E</th>
        <th class="text-center">TIPO</th>
        <th class="text-center">CLIENTE</th>
        <th class="text-left">DOCUMENTO</th>
        <th class="text-center">ORG</th>
        <th class="text-center">EXP.</th>
        <th class="text-center">P</th>
      </tr>
    </thead>
    <tbody>
        <?
            //DOC ADMON
            $sql = "SELECT * 
                        FROM (SELECT 
                            ADMON_DOC.id as docid,
                            'ADMON_DOC' as tipo, 
                            ADMON_DOC.nombre nombredoc, 
                            ORGANISMOS.nombre orgnombre, 
                            A.enviado,
                            (SELECT doc_path FROM ADMON_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC LIMIT 1) as path,
                            (SELECT fecha_exp FROM ADMON_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_expe,
                            (SELECT fecha_cad FROM ADMON_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                            (SELECT id FROM ADMON_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                            PERIODICIDADES.intervalo as inter, 
                            PERIODICIDADES.nombre perio,
                            CLIENTES.nombre cliente
                        FROM 
                            CLIENTES_DOC_ENVIAR A, ADMON_DOC, ORGANISMOS, PERIODICIDADES, CLIENTES
                        WHERE 
                            ADMON_DOC.id = A.doc_id
                        AND
                            ORGANISMOS.id = ADMON_DOC.org_id 
                        AND
                            A.cliente_id = CLIENTES.id 
                        AND
                            PERIODICIDADES.id = ADMON_DOC.periodicidad_id
                        AND
                            A.tipo_doc = 'admon') Q
                        WHERE DATE_ADD(Q.fecha_expe, INTERVAL +Q.inter DAY) <= CURDATE() 
                        AND Q.inter > 0 
                       ";
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos a enviar");
            while ($registros = mysqli_fetch_array($resultado)) {
                $docid = $registros[0];
                $tipodoc = $registros[1];
                $nombredoc = $registros[2];
                $orgdoc = $registros[3];
                $path = $registros[5];

                $fecha_exp = $registros[6];
                $fecha_cad = $registros[7];
                $docver_id = $registros[8];
                $intervalo = $registros[9];
                $intervaloNombre = substr($registros[10], 0, 1);
                $cliente = $registros[11];
                
                $fechaSUM = date('Y-m-d', strtotime($fecha_exp. ' + '.$intervalo.' days'));
                $todaySUM7 = date('Y-m-d', strtotime(date("Y-m-d"). ' + 7 days'));

                if ($intervalo == 0) {
                    $estado = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                }
                else {
                    if ($fecha_exp != "") {
                        if (date('Y-m-d') > $fechaSUM) {
                            $estado = "<span class='dot-red' title='Expirado el día ".$fechaSUM."'></span>";
                        }
                        else {
                            if ($todaySUM7 >= $fechaSUM) {
                                $fecha2 = new DateTime($fechaSUM);
                                $fecha1 = new DateTime(date('Y-m-d'));
                                $diasexp = $fecha1->diff($fecha2);
                                $estado = "<span class='dot-yellow' title='Expira en los próximos ".$diasexp->format('%R%a')." días'></span>";
                            }
                            else {
                                $estado = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                            }
                        }
                    }
                    else {
                        $estado = "<span class='dot-red' title='No hay ningún fichero subido para este documento'></span>";
                    } 
                }
                
                echo "
                        <tr data-id='".$docid."' class='oferta'>
                            <td class='text-center'>".$estado."</td>
                            <td class='text-center'>".utf8_encode($tipodoc)."</td>
                            <td class='text-center'>".utf8_encode($cliente)."</td>
                            <td class='text-left'>".utf8_encode($nombredoc)."</td>
                            <td class='text-center'>".utf8_encode($orgdoc)."</td>
                            <td class='text-center'>".utf8_encode($fecha_exp)."</td>
                            <td class='text-center'>".$intervaloNombre."</td>
                        </tr>
                    ";
            }
            
            // DOC PREVENCION
            $sql = "SELECT 
                            A.id as file, 
                            'PRL_DOC' as tipo, 
                            PRL_DOC.nombre, 
                            ORGANISMOS.nombre, 
                            A.enviado,
                            (SELECT doc_path FROM PRL_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC LIMIT 1) as path
                        FROM 
                            CLIENTES_DOC_ENVIAR A, PRL_DOC, ORGANISMOS, PERIODICIDADES
                        WHERE 
                            PRL_DOC.id = A.doc_id
                        AND
                            A.cliente_id = ".$_GET['cliente_id']."
                        AND
                            A.tipo_doc = 'prl'
                        AND
                            ORGANISMOS.id = PRL_DOC.org_id 
                        AND
                            PERIODICIDADES.id = PRL_DOC.periodicidad_id 
                       ";
            $sql = "SELECT * 
                        FROM (SELECT 
                            PRL_DOC.id as docid,
                            'PRL_DOC' as tipo, 
                            PRL_DOC.nombre nombredoc, 
                            ORGANISMOS.nombre orgnombre, 
                            A.enviado,
                            (SELECT doc_path FROM PRL_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC LIMIT 1) as path,
                            (SELECT fecha_exp FROM PRL_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_expe,
                            (SELECT fecha_cad FROM PRL_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                            (SELECT id FROM PRL_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                            PERIODICIDADES.intervalo as inter, 
                            PERIODICIDADES.nombre perio,
                            CLIENTES.nombre cliente
                        FROM 
                            CLIENTES_DOC_ENVIAR A, PRL_DOC, ORGANISMOS, PERIODICIDADES, CLIENTES
                        WHERE 
                            PRL_DOC.id = A.doc_id
                        AND
                            ORGANISMOS.id = PRL_DOC.org_id 
                        AND
                            A.cliente_id = CLIENTES.id 
                        AND
                            PERIODICIDADES.id = PRL_DOC.periodicidad_id
                        AND
                            A.tipo_doc = 'prl') Q
                        WHERE DATE_ADD(Q.fecha_expe, INTERVAL +Q.inter DAY) <= CURDATE() 
                        AND Q.inter > 0 
                       ";
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos a enviar");
            while ($registros = mysqli_fetch_array($resultado)) {
                $docid = $registros[0];
                $tipodoc = $registros[1];
                $nombredoc = $registros[2];
                $orgdoc = $registros[3];
                $path = $registros[5];

                $fecha_exp = $registros[6];
                $fecha_cad = $registros[7];
                $docver_id = $registros[8];
                $intervalo = $registros[9];
                $intervaloNombre = substr($registros[10], 0, 1);
                $cliente = $registros[11];
                
                $fechaSUM = date('Y-m-d', strtotime($fecha_exp. ' + '.$intervalo.' days'));
                $todaySUM7 = date('Y-m-d', strtotime(date("Y-m-d"). ' + 7 days'));

                if ($intervalo == 0) {
                    $estado = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                }
                else {
                    if ($fecha_exp != "") {
                        if (date('Y-m-d') > $fechaSUM) {
                            $estado = "<span class='dot-red' title='Expirado el día ".$fechaSUM."'></span>";
                        }
                        else {
                            if ($todaySUM7 >= $fechaSUM) {
                                $fecha2 = new DateTime($fechaSUM);
                                $fecha1 = new DateTime(date('Y-m-d'));
                                $diasexp = $fecha1->diff($fecha2);
                                $estado = "<span class='dot-yellow' title='Expira en los próximos ".$diasexp->format('%R%a')." días'></span>";
                            }
                            else {
                                $estado = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                            }
                        }
                    }
                    else {
                        $estado = "<span class='dot-red' title='No hay ningún fichero subido para este documento'></span>";
                    } 
                }
                
                echo "
                        <tr data-id='".$docid."' class='oferta'>
                            <td class='text-center'>".$estado."</td>
                            <td class='text-center'>".utf8_encode($tipodoc)."</td>
                            <td class='text-center'>".utf8_encode($cliente)."</td>
                            <td class='text-left'>".utf8_encode($nombredoc)."</td>
                            <td class='text-center'>".utf8_encode($orgdoc)."</td>
                            <td class='text-center'>".utf8_encode($fecha_exp)."</td>
                            <td class='text-center'>".$intervaloNombre."</td>
                        </tr>
                    ";
            }
            
            // DOC PERSONAL
            $sql = "SELECT 
                            A.id as file, 
                            'USERS_DOC' as tipo, 
                            USERS_DOC.nombre, 
                            ORGANISMOS.nombre, 
                            A.enviado,
                            (SELECT doc_path FROM USERS_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC LIMIT 1) as path,
                            erp_users.nombre,
                            erp_users.apellidos 
                        FROM 
                            CLIENTES_DOC_ENVIAR A, USERS_DOC, ORGANISMOS, PERIODICIDADES, erp_users
                        WHERE 
                            USERS_DOC.id = A.doc_id
                        AND
                            A.cliente_id = ".$_GET['cliente_id']."
                        AND
                            A.tipo_doc = 'per'
                        AND
                            ORGANISMOS.id = USERS_DOC.org_id 
                        AND
                            PERIODICIDADES.id = USERS_DOC.periodicidad_id 
                        AND
                            erp_users.id = USERS_DOC.erpuser_id
                        ORDER BY 
                            erp_users.nombre ASC,
                            ORGANISMOS.nombre ASC
                       ";
            $sql = "SELECT * 
                        FROM (SELECT 
                            USERS_DOC.id as docid,
                            'USERS_DOC' as tipo, 
                            USERS_DOC.nombre nombredoc, 
                            ORGANISMOS.nombre orgnombre, 
                            A.enviado,
                            (SELECT doc_path FROM USERS_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC LIMIT 1) as path,
                            (SELECT fecha_exp FROM USERS_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_expe,
                            (SELECT fecha_cad FROM USERS_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                            (SELECT id FROM USERS_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                            PERIODICIDADES.intervalo as inter, 
                            PERIODICIDADES.nombre perio,
                            CLIENTES.nombre cliente,
                            erp_users.nombre,
                            erp_users.apellidos
                        FROM 
                            CLIENTES_DOC_ENVIAR A, USERS_DOC, ORGANISMOS, PERIODICIDADES, CLIENTES, erp_users 
                        WHERE 
                            USERS_DOC.id = A.doc_id
                        AND
                            ORGANISMOS.id = USERS_DOC.org_id 
                        AND
                            A.cliente_id = CLIENTES.id 
                        AND
                            PERIODICIDADES.id = USERS_DOC.periodicidad_id
                        AND
                            erp_users.id = USERS_DOC.erpuser_id
                        AND
                            A.tipo_doc = 'per') Q
                        WHERE DATE_ADD(Q.fecha_expe, INTERVAL +Q.inter DAY) <= CURDATE() 
                        AND Q.inter > 0 
                       ";
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos a enviar");
            while ($registros = mysqli_fetch_array($resultado)) {
                $docid = $registros[0];
                $tipodoc = $registros[1];
                $nombredoc = $registros[2];
                $orgdoc = $registros[3];
                $path = $registros[5];

                $fecha_exp = $registros[6];
                $fecha_cad = $registros[7];
                $docver_id = $registros[8];
                $intervalo = $registros[9];
                $intervaloNombre = substr($registros[10], 0, 1);
                $cliente = $registros[11];
                $nombreTec = $registros[12];
                $apellidoTec = $registros[13];
                
                $fechaSUM = date('Y-m-d', strtotime($fecha_exp. ' + '.$intervalo.' days'));
                $todaySUM7 = date('Y-m-d', strtotime(date("Y-m-d"). ' + 7 days'));

                if ($intervalo == 0) {
                    $estado = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                }
                else {
                    if ($fecha_exp != "") {
                        if (date('Y-m-d') > $fechaSUM) {
                            $estado = "<span class='dot-red' title='Expirado el día ".$fechaSUM."'></span>";
                        }
                        else {
                            if ($todaySUM7 >= $fechaSUM) {
                                $fecha2 = new DateTime($fechaSUM);
                                $fecha1 = new DateTime(date('Y-m-d'));
                                $diasexp = $fecha1->diff($fecha2);
                                $estado = "<span class='dot-yellow' title='Expira en los próximos ".$diasexp->format('%R%a')." días'></span>";
                            }
                            else {
                                $estado = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                            }
                        }
                    }
                    else {
                        $estado = "<span class='dot-red' title='No hay ningún fichero subido para este documento'></span>";
                    } 
                }
                
                echo "
                        <tr data-id='".$docid."' class='oferta'>
                            <td class='text-center'>".$estado."</td>
                            <td class='text-center'>".utf8_encode($nombreTec)." ".utf8_encode($apellidoTec)."</td>
                            <td class='text-center'>".utf8_encode($cliente)."</td>
                            <td class='text-left'>".utf8_encode($nombredoc)."</td>
                            <td class='text-center'>".utf8_encode($orgdoc)."</td>
                            <td class='text-center'>".utf8_encode($fecha_exp)."</td>
                            <td class='text-center'>".$intervaloNombre."</td>
                        </tr>
                    ";
            }
            
            // DOC CLIENTES
            $sql = "SELECT 
                            A.id as file, 
                            'CLIENTES_DOC' as tipo, 
                            CLIENTES_DOC.nombre, 
                            ORGANISMOS.nombre, 
                            A.enviado,
                            (SELECT doc_path FROM CLIENTES_DOC_VERSIONES WHERE doc_id = file ORDER BY fecha_exp DESC LIMIT 1) as path
                        FROM 
                            CLIENTES_DOC_ENVIAR A, CLIENTES_DOC, ORGANISMOS, PERIODICIDADES
                        WHERE 
                            CLIENTES_DOC.id = A.doc_id
                        AND
                            A.cliente_id = ".$_GET['cliente_id']."
                        AND
                            A.tipo_doc = 'cli'
                        AND
                            ORGANISMOS.id = CLIENTES_DOC.org_id 
                        AND
                            PERIODICIDADES.id = CLIENTES_DOC.periodicidad_id
                       ";
            $sql = "SELECT * 
                        FROM (SELECT 
                            A.id as file, 
			                CLIENTES_DOC.id as docid,
                            'CLIENTES_DOC' as tipo, 
                            CLIENTES_DOC.nombre nombredoc, 
                            ORGANISMOS.nombre orgnombre, 
                            A.enviado,
                            (SELECT doc_path FROM CLIENTES_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC LIMIT 1) as path,
                            (SELECT fecha_exp FROM CLIENTES_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_expe,
                            (SELECT fecha_cad FROM CLIENTES_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as fecha_cad,
                            (SELECT id FROM CLIENTES_DOC_VERSIONES WHERE doc_id = docid ORDER BY fecha_exp DESC, id DESC LIMIT 1) as ver_id,
                            PERIODICIDADES.intervalo as inter, 
                            PERIODICIDADES.nombre perio,
                            CLIENTES.nombre cliente
                        FROM 
                            CLIENTES_DOC_ENVIAR A, CLIENTES_DOC, ORGANISMOS, PERIODICIDADES, CLIENTES
                        WHERE 
                            CLIENTES_DOC.id = A.doc_id
                        AND
                            ORGANISMOS.id = CLIENTES_DOC.org_id 
                        AND
                            A.cliente_id = CLIENTES.id 
                        AND
                            PERIODICIDADES.id = CLIENTES_DOC.periodicidad_id
                        AND
                            A.tipo_doc = 'cli') Q
                        WHERE DATE_ADD(Q.fecha_expe, INTERVAL +Q.inter DAY) <= CURDATE() 
                        AND Q.inter > 0 
                       ";
            file_put_contents("selectCLIenviar.txt", $sql);
            $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de Documentos a enviar");
            while ($registros = mysqli_fetch_array($resultado)) {
                
                $docid = $registros[0];
                $tipodoc = $registros[1];
                $nombredoc = $registros[2];
                $orgdoc = $registros[3];
                $path = $registros[5];

                $fecha_exp = $registros[6];
                $fecha_cad = $registros[7];
                $docver_id = $registros[8];
                $intervalo = $registros[9];
                $intervaloNombre = substr($registros[10], 0, 1);
                $cliente = $registros[11];
                
                $fechaSUM = date('Y-m-d', strtotime($fecha_exp. ' + '.$intervalo.' days'));
                $todaySUM7 = date('Y-m-d', strtotime(date("Y-m-d"). ' + 7 days'));

                if ($intervalo == 0) {
                    $estado = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                }
                else {
                    if ($fecha_exp != "") {
                        if (date('Y-m-d') > $fechaSUM) {
                            $estado = "<span class='dot-red' title='Expirado el día ".$fechaSUM."'></span>";
                        }
                        else {
                            if ($todaySUM7 >= $fechaSUM) {
                                $fecha2 = new DateTime($fechaSUM);
                                $fecha1 = new DateTime(date('Y-m-d'));
                                $diasexp = $fecha1->diff($fecha2);
                                $estado = "<span class='dot-yellow' title='Expira en los próximos ".$diasexp->format('%R%a')." días'></span>";
                            }
                            else {
                                $estado = "<span class='dot-green' title='Válido hasta ".$fechaSUM."'></span>";
                            }
                        }
                    }
                    else {
                        $estado = "<span class='dot-red' title='No hay ningún fichero subido para este documento'></span>";
                    } 
                }
                
                echo "
                        <tr data-id='".$docid."' class='oferta'>
                            <td class='text-center'>".$estado."</td>
                            <td class='text-center'>".utf8_encode($tipodoc)."</td>
                            <td class='text-center'>".utf8_encode($cliente)."</td>
                            <td class='text-left'>".utf8_encode($nombredoc)."</td>
                            <td class='text-center'>".utf8_encode($orgdoc)."</td>
                            <td class='text-center'>".utf8_encode($fecha_exp)."</td>
                            <td class='text-center'>".$intervaloNombre."</td>
                        </tr>
                    ";
            }

        ?>
    </tbody>
</table>
</div>

<!-- contratistas seleccionado -->