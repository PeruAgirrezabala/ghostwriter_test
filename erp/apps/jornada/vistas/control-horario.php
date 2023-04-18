<!-- Accesos -->
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">1</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">2</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">3</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">4</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">5</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">6</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">7</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">8</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">9</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default" id="btn_ch_retroceder" style="width: 100%; height: 20vh;"><img src="/erp/img/retroceder.png" height="80"></button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default num" style="width: 100%; height: 20vh; font-size: 50px; font-weight: bolder;">0</button>
</div>
<div class="three-column" style="height: 20vh;">
    <button type="button" class="btn btn-default" id="btn_ch_acceso" style="width: 100%; height: 20vh;"><img src="/erp/img/tick.png" height="50"></button>
</div>
<span class="stretch"></span>
<div class="one-column" style="margin-bottom: 0px; padding-top: 10px; margin-top: -15px;">
    <div class="alert-middle alert alert-danger alert-dismissable" id="ch_error" style="display:none; margin: 0px auto 0px auto;">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <p>El número identificativo no corresponde a ningún trabajador</p>
    </div>
    <div class="alert-middle alert alert-success alert-dismissable" id="ch_success" style="display:none; margin: 0px auto 0px auto;">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <p id="mensaje-success"></p>
    </div>
    <div class="form-group" style="text-align: center; margin-bottom: 0px;">
        <div class="col-md-5" style="float: none; display: inline-block; margin-bottom: 0px;">
            <input type="text" class="form-control input-lg" id="ch_txartela" name="ch_txartela" disabled="true" style="text-align: center; font-size: 50px; color: #8c0909;">
        </div>
        <?
            if ($_SESSION['user_session'] != "") {
                $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
                include_once($pathraiz."/connection.php");

                $db = new dbObj();
                $connString =  $db->getConnstring();
                $sql = "SELECT 
                            JORNADAS_ACCESOS.hora_entrada,
                            JORNADAS_ACCESOS.hora_salida 
                        FROM
                            JORNADAS_ACCESOS, JORNADAS 
                        WHERE 
                            JORNADAS_ACCESOS.jornada_id = JORNADAS.ID
                        AND
                            JORNADAS.user_id = ".$_SESSION['user_session']."
                        ORDER BY 
                            JORNADAS_ACCESOS.id DESC
                        LIMIT 1";

                $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del último acceso registrado");
                $registros = mysqli_fetch_row($resultado);
                
                if ($registros[1] != "0000-00-00 00:00:00") {
                    $tipoacceso = "SALIDA";
                    $color = "#97002f";
                }
                else {
                    $tipoacceso = "ENTRADA";
                    $color = "#20b4eb";
                }
                
                echo "<div class='col-md-5' style='float: none; display: inline-block; margin-bottom: 0px;'>
                        <label class='labelBefore'>El último acceso registrado es una <span style='font-weight: bolder; color: ".$color.";'>".$tipoacceso."</span></label>
                      </div>
                     ";
                
            }
        ?>
    </div>
</div>
