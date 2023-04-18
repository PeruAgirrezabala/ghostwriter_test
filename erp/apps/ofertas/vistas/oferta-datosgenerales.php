<!-- ofertas seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="ofertas_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Oferta guardada</p>
</div>
<div id="oferta-view">
    
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                OFERTAS.id,
                OFERTAS.ref,
                OFERTAS.titulo,
                OFERTAS.descripcion,
                OFERTAS.fecha,
                OFERTAS.fecha_validez,
                OFERTAS.fecha_mod,
                OFERTAS_ESTADOS.nombre, 
                PROYECTOS.nombre, 
                OFERTAS_ESTADOS.color, 
                OFERTAS_ESTADOS.id,
                OFERTAS.proyecto_id, 
                CLI1.nombre, 
                CLI1.img,
                CLI2.nombre, 
                CLI2.img, 
                CLI2.id,
                CLI1.id,
                OFERTAS.dto_final,
                OFERTAS.forma_pago,
                OFERTAS.plazo_entrega,
                OFERTAS.ref_genelek,
                PROYECTOS.id
            FROM 
                OFERTAS
            INNER JOIN OFERTAS_ESTADOS
                ON OFERTAS.estado_id = OFERTAS_ESTADOS.id 
            LEFT JOIN PROYECTOS
                ON OFERTAS.proyecto_id = PROYECTOS.id 
            LEFT JOIN CLIENTES as CLI1
                ON PROYECTOS.cliente_id = CLI1.id
            LEFT JOIN CLIENTES as CLI2
                ON OFERTAS.cliente_id = CLI2.id  
            WHERE OFERTAS.id = ".$_GET['id']."
            ORDER BY 
                OFERTAS.fecha_mod DESC";

        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Ofertas");

        $registros = mysqli_fetch_row($resultado);

        $id = $_GET['id'];
        $ref = $registros[1];
        $nombreOferta = $registros[2];
        $descripcion = $registros[3];
        $fecha = $registros[4];
        $fecha_val = $registros[5];
        $fecha_mod = $registros[6];
        $estado = $registros[7];
        $proyecto = $registros[8];
        $proyectoId = $registros[22];
        if($proyecto!=""){
            $btnLink='<button type="button" class="btn btn-success btn-circle" title="Ir a Proyecto"><a href="/erp/apps/proyectos/view.php?id='.$proyectoId.'" target="_blank"><img src="/erp/img/link-w.png"></a></button>';
            $proyecto=$proyecto." ".$btnLink;
        }
        $estadocolor = $registros[9];
        $estado_id = $registros[10];
        $proyecto_id = $registros[11];
        if (($proyecto_id != "") || ($proyecto_id != 12)) {
            $cliente = $registros[14];
            $clienteimg = $registros[15];
            $cliente_id = $registros[16];
        }
        else {
            $cliente = $registros[12];
            $clienteimg = $registros[13];
            $cliente_id = $registros[17];
        }
        $dto_final = $registros[18];
        $forma_pago = $registros[19];
        $plazo_entrega = $registros[20];
        $ref_genelek = $registros[21];

        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Ref:</label> <label id='view_ref'>".$ref."</label>
              </div>";
        echo '<div class="form-group form-group-view">
                <label class="viewTitle">Nombre Oferta:</label> <label id="view_ref">'.$nombreOferta.'</label>
              </div>';
        echo '<div class="form-group form-group-view">
            <div class="col-md-2">
                <label class="viewTitle">Versión:</label>
            </div>
            <div class="col-md-2">
                <select id="versiones_oferta" name="versiones_oferta" class="selectpicker selectversion" data-live-search="true">';
                                $sql = "SELECT 
                                            OFERTAS.ref,
                                            OFERTAS.id,
                                            OFERTAS.titulo,
                                            OFERTAS.n_ver,
                                            OFERTAS.0_ver
                                        FROM 
                                            OFERTAS
                                        WHERE
                                            OFERTAS.id=".$_GET["id"];
                                file_put_contents("selectOfertaRef.txt", $sql);
                                $res = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de SELECT OFERTA");
                                $reg = mysqli_fetch_array($res);
                                echo "<option id='versiones_oferta_".$reg[1]."' value=".$reg[1].">".chr($reg[3]+65)."</option>";
                                
                                $idposicional=$_GET["id"];
                                do{
                                    $sqlPadre="SELECT OFERTAS.0_ver FROM OFERTAS WHERE OFERTAS.id=".$idposicional;
                                    //file_put_contents("selectOfertasVersion.txt", $sqlPadre);
                                    $resPadre = mysqli_query($connString, $sqlPadre) or die("Error al ejecutar la consulta de Version Padre");
                                    $regPadre = mysqli_fetch_row ($resPadre);
                                    $version = $regPadre[0];
                                    if($version!=0){
                                        $idposicional=$version;
                                    }
                                }while($version!=0);
                                $idVersionActual=$idposicional;
                                
                                $sql = "SELECT 
                                            OFERTAS.id,
                                            OFERTAS.titulo,
                                            n_ver
                                        FROM 
                                            OFERTAS
                                        WHERE
                                            OFERTAS.0_ver=".$idVersionActual."
                                        AND NOT
                                            OFERTAS.id=".$_GET["id"]." ORDER BY OFERTAS.id ASC ";
                                file_put_contents("selectOfertasVersiones.txt", $sql);
                                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de CALIDAD_FORMACION");
                                $encontrado=false;
                                while ($registros = mysqli_fetch_array($resultado)) {
                                    $id_version = $registros[0];
                                    $titulo = $registros[1];
                                    $version = $registros[2];
                                    echo "<option id='versiones_oferta_".$id_version."' value=".$id_version.">".chr($version+65)."</option>";
                                }
                                if($idVersionActual!=0 && $reg[4]!=0){
                                    echo "<option id='versiones_oferta_".$idVersionActual."' value=".$idVersionActual.">A</option>";
                                }
                                
                        echo '</select></div></div>';
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Ref Genelek:</label> <label id='view_ref'>".$ref_genelek."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Título:</label> <label id='view_ref'>".$nombreOferta."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descripción:</label> <label id='view_ref'>".$descripcion."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Cliente:</label> <label id='view_ref'>".$cliente."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Proyecto:</label> <label id='view_ref'>".$proyecto."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha:</label> <label id='view_ref'>".$fecha."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Fecha Validez:</label> <label id='view_ref'>".$fecha_val."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Descuento final:</label> <label id='view_ref'>".$dto_final." %</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Forma de Pago:</label> <label id='view_ref'>".$forma_pago."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Plazo de Entrega:</label> <label id='view_ref'>".$plazo_entrega."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Última modificación:</label> <label id='view_ref'>".$fecha_mod."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Estado:</label> <label id='view_ref' class='label label-".$estadocolor."'>".$estado."</label>
              </div>";
    ?>
</div>
<div id="oferta-edit" style="display: none;">
    <form method="post" id="frm_oferta">
    <?
        echo "  <input type='hidden' name='ofertas_deloferta' id='ofertas_deloferta' value=''>
                <input type='hidden' name='ofertas_idoferta' id='ofertas_idoferta' value=".$id.">
                <input type='hidden' name='ofertas_proyectoid' id='ofertas_proyectoid' value=".$proyecto_id."> 
                <input type='hidden' name='ofertas_clienteid' id='ofertas_clienteid' value=".$cliente_id."> 
                <input type='hidden' name='ofertas_estadoid' id='ofertas_estadoid' value=".$estado_id.">";
        
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Ref:</label>
                <input type='text' class='form-control' id='ofertas_edit_ref' name='ofertas_edit_ref' placeholder='Referencia de la Oferta' value='".$ref."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Ref Genelek:</label>
                <input type='text' class='form-control' id='ofertas_edit_ref_genelek' name='ofertas_edit_ref_genelek' placeholder='Referencia de Genelek' value='".$ref_genelek."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Nombre:</label>
                <input type='text' class='form-control' id='ofertas_edit_nombre' name='ofertas_edit_nombre' placeholder='Título de la Oferta' value='".$nombreOferta."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Descripción:</label>
                <textarea class='form-control' id='ofertas_edit_desc' name='ofertas_edit_desc' placeholder='Descripción de la Oferta'>".$descripcion."</textarea>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Proyecto:</label>
                <select id='ofertas_proyectos' name='ofertas_proyectos' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Clientes:</label>
                <select id='ofertas_clientes' name='ofertas_clientes' class='selectpicker' data-live-search='true' data-width='33%'>
                    <option></option>
                </select>
              </div>";
        echo "<div class='form-group'></div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Fecha:</label>
                    <input type='date' class='form-control' id='ofertas_edit_fecha' name='ofertas_edit_fecha' value='".$fecha."'>
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Validez:</label>
                    <input type='text' class='form-control' id='ofertas_edit_fechaval' name='ofertas_edit_fechaval' value='".$fecha_val."'>
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Descuento Final %:</label>
                    <input type='text' class='form-control' id='ofertas_edit_dtofinal' name='ofertas_edit_dtofinal' value='".$dto_final."'>
                </div>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Forma de Pago:</label>
                <input type='text' class='form-control' id='ofertas_edit_formapago' name='ofertas_edit_formapago' value='".$forma_pago."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Plazo de Entrega:</label>
                <input type='text' class='form-control' id='ofertas_edit_plazoentrega' name='ofertas_edit_plazoentrega' value='".$plazo_entrega."'>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='labelBefore'>Última modificación:</label> <label id='view_ref'>".$fecha_mod."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <div class='col-xs-6'>
                    <label class='labelBefore'>Estado:</label>
                    <select id='ofertas_estados' name='ofertas_estados' class='selectpicker' data-live-search='true' data-width='33%'>
                        <option></option>
                    </select>
                </div>
              </div>";
        echo "<div class='form-group'></div>";
    ?>
        <div class="form-group form-group-view" style="margin-top: 30px;">
            <button type="button" class="btn btn-info" id="ofertas_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    $("#oferta-title3").html("<? echo $ref." - ".$nombreOferta; ?>");
    $("#current-page3").html("<? echo $ref." - ".$nombreOferta; ?>");
    $("#titulo3").html("<? echo $ref." - ".$nombreOferta; ?>");
    $("#ofertas_proyectos").val("<? echo $proyecto_id; ?>");
    $("#ofertas_estados").val("<? echo $estado_id; ?>");
</script>

<!-- mispartidos -->