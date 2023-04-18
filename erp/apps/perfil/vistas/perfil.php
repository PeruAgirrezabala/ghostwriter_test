<div id="perfil-view" style="padding-right: 10px;">
  <?
  //include connection file 
  $pathraiz = $_SERVER['DOCUMENT_ROOT'] . "/erp";
  include_once($pathraiz . "/connection.php");
  $pathimg="../../img/avatares/";

  $db = new dbObj();
  $connString =  $db->getConnstring();

  if ($_GET['empresa'] != "") {
    $empresa_id = $_GET['empresa'];
  } else {
    $empresa_id = "1";
  }

  $sql = "SELECT erp_users.id,
                    erp_users.nombre,
                    erp_users.apellidos,
                    erp_users.user_name,
                    erp_users.user_email,
                    erp_users.telefono,
                    EMPRESAS.nombre,
                    erp_users.NIF,
                    erp_roles.nombre,
                    erp_users.firma_path,
                    erp_users.txartela,
                    erp_users.color,
                    erp_users.avatar

                FROM 
                    erp_users, erp_roles, EMPRESAS 
                WHERE
                    erp_roles.id = erp_users.role_id 
                AND
                    EMPRESAS.id = erp_users.empresa_id 
                AND
                    erp_users.id = " . $_SESSION['user_session'];

  $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Perfil");

  $registros = mysqli_fetch_row($resultado);

  $id = $registros[0];
  $nombreTrabajador = $registros[1];
  $apellidosTrabajador = $registros[2];
  $user_name = $registros[3];
  $user_email = $registros[4];
  $telefono = $registros[5];
  $empresa = $registros[6];
  $NIF = $registros[7];
  $role = $registros[8];
  $firma_path = $registros[9];
  $txartela = $registros[10];
  $avatar = $registros[12];
  if($avatar==''||$avatar==null){
    $avatar="default.png";

  }
  $color = "<div style='width: 30px; height: 30px; display: inline-block: margin-left:15px; background-color: " . $registros[11] . "; border-radius: 5px; vertical-align: middle;'></div>";

  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Nombre:</label> <label id='view_ref' class='label-strong'>" . $nombreTrabajador . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Apellidos:</label> <label id='view_ref' class='label-strong'>" . $apellidosTrabajador . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Username:</label> <label id='view_ref'>" . $user_name . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Email:</label> <label id='view_ref'>" . $user_email . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Teléfono:</label> <label id='view_ref'>" . $telefono . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Empresa:</label> <label id='view_ref'>" . $empresa . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>NIF:</label> <label id='view_titulo'>" . $NIF . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Firma:</label> <label id='view_desc'>" . $firma_path . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Identificador:</label> <label id='view_fecha'>" . $txartela . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Role:</label> <label id='view_entrega'>" . $role . "</label>
              </div>";
  echo "<div class='form-group form-group-view'>
              <label class='viewTitle'>Avatar:</label> <img id='view_avatar' src='".$pathimg.$avatar."' style='height:80px;width:80px; margin: 30px;'></img>
        </div>" ;             
  echo "<div class='form-group form-group-view'>
                " . $color . "
              </div>";
          
  ?>
</div>
<div id="perfil-edit" style="display: none;" class="container p-4">
  <form method="post" id="frm_editperfil">
    <?
    echo "<input type='hidden' name='perfil_edit_iduser' id='perfil_edit_iduser' value=" . $id . ">";
    echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Nombre:</label>
                <input type='text' class='form-control' id='perfil_edit_nombre' name='perfil_edit_nombre' placeholder='Nombre del Trabajador' value='" . $nombreTrabajador . "'>
              </div>";
    echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Apellidos:</label>
                <input type='text' class='form-control' id='perfil_edit_apellidos' name='perfil_edit_apellidos' value='" . $apellidosTrabajador . "'>
              </div>";
    echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>NIF:</label>
                <input type='text' class='form-control' id='perfil_edit_nif' name='perfil_edit_nif' value='" . $NIF . "'>
              </div>";
    echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Teléfono:</label>
                <input type='text' class='form-control' id='perfil_edit_tlfno' name='perfil_edit_tlfno' value='" . $telefono . "'>
              </div>";
    echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Email:</label>
                <input type='text' class='form-control' id='perfil_edit_email' name='perfil_edit_email' value='" . $user_email . "'>
              </div>";
    echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Firma:</label>
                <input type='text' class='form-control' id='perfil_edit_firma' name='perfil_edit_firma' placeholder='Plazo de entrega' value='" . $firma_path . "'>
              </div>";
    echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Username:</label>
                <input type='text' class='form-control' id='perfil_edit_username' name='perfil_edit_username' value='" . $user_name . "'>
              </div>";
    echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Pasword:</label>
                <input type='password' class='form-control' id='perfil_edit_pass' name='perfil_edit_pass' value=''>
              </div>";
    echo "<div class='form-group form-group-view'>
              <label sstyle class='labelBefore'>Avatar:</label>
              <img id='update_avatar_target'  name='update_avatar_target' style='height:80px;width:80px; margin:40px;'src='".$pathimg.$avatar."'></img>
              <input type='hidden' name='avatar_src' id='avatar_src_input' class='form-control' value='".$avatar."'>
          </div>";          
    echo  "<div id='addavatar_model' class='modal fade'>
            <div class='modal-dialog dialog_estrecho'>
              <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' >AVATARES</h4>
                </div>
                  <div id='image-container' style='display:flex; flex-wrap:wrap'>
                  </div>
              </div>
            </div>
          </div>";


    ?>
    <div class='form-group form-group-view'>
      <button type='button' class='btn btn-info' id='perfil_edit_btn_avatar'>
        <span class='	glyphicon glyphicon-user'></span> Avatares
    </div>
    <div class="form-group form-group-view" style="margin-top: 30px; margin-bottom: 30px !important;">
      <button type="button" class="btn btn-info" id="perfil_edit_btn_save">
        <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
      </button>
    </div>

  </form>
