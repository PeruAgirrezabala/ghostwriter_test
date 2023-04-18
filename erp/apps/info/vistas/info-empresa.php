
<div id="info-view" style="padding-right: 10px;">
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        if ($_GET['empresa'] != "") {
            $empresa_id = $_GET['empresa'];
        }
        else {
            $empresa_id = "1";
        }
        
        $sql = "SELECT 
                    id, 
                    nombre, 
                    direccion, 
                    cp, 
                    poblacion, 
                    provincia, 
                    pais, 
                    telefono, 
                    web, 
                    email, 
                    CIF, 
                    logo, 
                    CIF2, 
                    IAE1, 
                    IAE2, 
                    CNAE1, 
                    CNAE2,
                    horas_convenio,
                    vacaciones_ano
                 FROM EMPRESAS 
                 WHERE id = ".$empresa_id;
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta de la Info");

        $registros = mysqli_fetch_row($resultado);

        $id = $registros[0];
        $nombre =  $registros[1];
        $direccion =  $registros[2];
        $cp =  $registros[3];
        $poblacion =  $registros[4];
        $provincia =  $registros[5];
        $pais =  $registros[6];
        $telefono =  $registros[7];
        $web =  $registros[8];
        $email =  $registros[9];
        $CIF =  $registros[10];
        $logo =  $registros[11];
        $CIF2 =  $registros[12];
        $IAE1 =  $registros[13];
        $IAE2 =  $registros[14];
        $CNAE1 =  $registros[15];
        $CNAE2 = $registros[16];
        $horas_convenio = $registros[17];
        $vacaciones_ano = $registros[18];
        
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle label-strong'>Empresa:</label> <label id='view_ref' class='label-strong'>".$nombre."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Dirección:</label> <label id='view_ref'>".$direccion."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>CP:</label> <label id='view_ref'>".$cp."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Población:</label> <label id='view_ref'>".$poblacion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Provincia:</label> <label id='view_ref'>".$provincia."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Pais:</label> <label id='view_ref'>".$pais."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Telefono:</label> <label id='view_titulo'>".$telefono."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Web:</label> <label id='view_desc'>".$web."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Email:</label> <label id='view_fecha'>".$email."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>NIF:</label> <label id='view_entrega'>".$CIF."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>NIF ADU 21:</label> <label id='view_recepcion'>".$CIF2."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>IAE 1:</label> <label id='view_tecnico'>".$IAE1."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>CNAE 1:</label> <label id='view_formapago'>".$CNAE1."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>IAE 2:</label> <label id='view_formapagoInterna'>".$IAE2."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>CNAE 2:</label> <label id='view_contacto'>".$CNAE2."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Horas Convenio:</label> <label id='view_contacto'>".$horas_convenio."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Vacaciones Año:</label> <label id='view_contacto'>".$vacaciones_ano."</label>
              </div>"; 
       
    ?>
</div>
<div id="info-edit" style="display: none;" class="container p-4">
    <form method="post" id="frm_editinfo">
    <?
        echo "<input type='hidden' name='info_edit_idempresa' id='info_edit_idempresa' value=".$id.">";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Nombre:</label>
                <input type='text' class='form-control' id='info_edit_nombre' name='info_edit_nombre' placeholder='Nombre de la Empresa' value='".$nombre."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>DIRECCION:</label>
                <input type='text' class='form-control' id='info_edit_direccion' name='info_edit_direccion' value='".$direccion."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>CP:</label>
                <input type='text' class='form-control' id='info_edit_cp' name='info_edit_cp' value='".$cp."'>
              </div>";
       
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>POBLACION:</label>
                <input type='text' class='form-control' id='info_edit_poblacion' name='info_edit_poblacion' value='".$poblacion."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>PROVINCIA:</label>
                <input type='text' class='form-control' id='info_edit_provincia' name='info_edit_provincia' value='".$provincia."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>PAIS:</label>
                <input type='text' class='form-control' id='info_edit_pais' name='info_edit_pais' value='".$pais."'>
              </div>";
       
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>TELEFONO:</label>
                <input type='text' class='form-control' id='info_edit_tlfno' name='info_edit_tlfno' placeholder='Forma de pago' value='".$telefono."'>
              </div>";
       
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>WEB:</label>
                <input type='text' class='form-control' id='info_edit_web' name='info_edit_web' placeholder='Plazo de entrega' value='".$web."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>EMAIL:</label>
                <input type='text' class='form-control' id='info_edit_email' name='info_edit_email' placeholder='Contacto' value='".$email."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>NIF:</label>
                <input type='text' class='form-control' id='info_edit_nif1' name='info_edit_nif1' placeholder='Contacto' value='".$CIF."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>NIF ADU 21:</label>
                <input type='text' class='form-control' id='info_edit_nif2' name='info_edit_nif2' placeholder='Contacto' value='".$CIF2."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>IAE 1:</label>
                <input type='text' class='form-control' id='info_edit_iae1' name='info_edit_iae1' placeholder='Contacto' value='".$IAE1."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>CNAE 1:</label>
                <input type='text' class='form-control' id='info_edit_cnae1' name='info_edit_cnae1' placeholder='Contacto' value='".$CNAE1."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>IAE 2:</label>
                <input type='text' class='form-control' id='info_edit_iae2' name='info_edit_iae2' placeholder='Contacto' value='".$IAE2."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>CNAE 2:</label>
                <input type='text' class='form-control' id='info_edit_cnae2' name='info_edit_cnae2' placeholder='Contacto' value='".$CNAE2."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Horas Convenio:</label>
                <input type='text' class='form-control' id='info_horas_convenio' name='info_horas_convenio' placeholder='Horas al año por convenio' value='".$horas_convenio."'>
              </div>";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Vacaciones al año:</label>
                <input type='text' class='form-control' id='info_vacaciones_ano' name='info_vacaciones_ano' placeholder='Vacaciones totales al año' value='".$vacaciones_ano."'>
              </div>";

    ?>
        <div class="form-group form-group-view" style="margin-top: 30px; margin-bottom: 30px !important;">
            <button type="button" class="btn btn-info" id="info_edit_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>
