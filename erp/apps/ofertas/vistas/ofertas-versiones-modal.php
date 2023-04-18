<?php
    //include connection file 
    $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
    require_once($pathraiz."/connection.php");
    
    
    $db = new dbObj();
    $connString =  $db->getConnstring();
    
    echo '<div class="modal-dialog dialog_mini">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="display: inline-block;">VERSIONES OFERTA</h4>
                </div>
                <div class="modal-body">
                    <div class="contenedor-form">
                        <form method="post" id="frm_cp_oferta">
                            <!--<input type="hidden" value="" name="proyecto_id" id="proyecto_id">-->
                            <label class="viewTitle">Versión a copiar:</label>
                            <select id="versiones_oferta_copy" name="versiones_oferta_copy" class="selectpicker cp_v_oferta" data-live-search="true">
                                <option value=""></option>';
                                $sql = "SELECT 
                                            OFERTAS.ref,
                                            OFERTAS.id,
                                            OFERTAS.titulo,
                                            OFERTAS.n_ver,
                                            OFERTAS.0_ver
                                        FROM 
                                            OFERTAS
                                        WHERE
                                            OFERTAS.id=".$_POST["oferta_id"];
                                file_put_contents("selectOfertaRef.txt", $sql);
                                $res = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de SELECT OFERTA");
                                $reg = mysqli_fetch_array($res);
                                echo "<option id='versiones_oferta_".$reg[1]."' value=".$reg[1].">".$reg[2]." - ".chr($reg[3]+65)."</option>";
                                $idposicional=$_POST["oferta_id"];
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
                                            OFERTAS.id=".$_POST["oferta_id"]." ORDER BY OFERTAS.id ASC ";
                                file_put_contents("selectOfertasVersiones.txt", $sql);
                                $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de CALIDAD_FORMACION");
                                $encontrado=false;
                                while ($registros = mysqli_fetch_array($resultado)) {
                                    $id_version = $registros[0];
                                    $titulo = $registros[1];
                                    $version = $registros[2];
                                     echo "<option id='versiones_oferta_".$id_version."' value=".$id_version.">".$titulo." - ".chr($version+65)."</option>";
                                }
                                if($idVersionActual!=0 && $reg[4]!=0){
                                    echo "<option id='versiones_oferta_".$idVersionActual."' value=".$idVersionActual.">".$reg[2]." - A</option>";
                                }

//                                while ($registros = mysqli_fetch_array($resultado)) {
//                                    $id = $registros[0];
//                                    $titulo = $registros[1];
//                                    $version = $registros[2];
//                                    echo "<option id='versiones_oferta_".$id."' value=".$id.">".$titulo." - ".chr($version+65)."</option>";
//                                }
                                
                        echo '</select>
                            <div class="form-group"></div>
                            <div class="form-group" style="text-align: center;">
                            <span class="badge badge-pill badge-info">Se generará una copia con número de versión <br> automáticamente.</span></div>
                            <!--<label class="viewTitle">Nombre de Versión:</label>
                            <input type="text" class="form-control" id="ofertas_n_ver" name="ofertas_n_ver" placeholder="Nombre de Versión">-->
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_add_version_oferta" class="btn btn-success">Crear Copia</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>';
        
?>