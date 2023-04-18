<!-- datos trabajador -->
<div id="accesos-datostrabajador" style="padding-left: 10px;">
    <div class="form-group">
    <?
        //include connection file 
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        $sql = "SELECT 
                    nombre,
                    apellidos,
                    nif,
                    id
                FROM 
                    erp_users
                WHERE
                    id = ".$idtrabajador;
        
        $resultado = mysqli_query($connString, $sql) or die("Error al ejcutar la consulta del Trabajador");

        $registros = mysqli_fetch_row($resultado);

        $nombre = $registros[0];
        $apellidos = $registros[1];
        $nif = $registros[2];
        $tecnico_id = $registros[3];
        echo "<div class='col-md-4'>";
        echo '<input type="hidden" class="form-control" id="iddattrabajador" name="iddattrabajador" value='.$tecnico_id.'>';
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Nombre:</label> <label id='view_ref' class='label-strong'>".$nombre."</label>
              </div>";   
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Apellidos:</label> <label id='view_ref'>".$apellidos."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>NIF:</label> <label id='view_titulo'>".$nif."</label>
              </div>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Ver documentos:</label>
                <button class='button' id='view-tabla-excels-div' title='Ver documentos excel'><img src='/erp/img/ojo.png' height='20'></a></button>
              </div>";
        echo "</div>";
        
        $pathfind = '/jornada'.str_replace(" ","",$nombre.$apellidos);
        $pathfind2 = '/jornadaAnual'.str_replace(" ","",$nombre.$apellidos);
        
    ?>
        <div class='col-md-8'>
            <div id='tabla-excels-div' style='display: none;'>
            <table class='table table-striped table-hover' id='tabla-excels' style='margin: 0px auto 20px auto;'>
                <thead>
                    <tr class='bg-dark'>
                        <th class='text-center'>MES</th>
                        <th class='text-center'>DOC</th>
                        <th class='text-center'>MES</th>
                        <th class='text-center'>DOC</th>                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class='text-center'>ENE</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_1_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?>                            
                        </td>
                        <td class='text-center'>FEB</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_2_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td class='text-center'>MAR</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_3_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                        <td class='text-center'>ABR</td>
                        <td class='text-center'>
                           <?
                            $doc = $pathfind."_4_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?>  
                        </td>
                    </tr>
                    <tr>
                        <td class='text-center'>MAY</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_5_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                        <td class='text-center'>JUN</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_6_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td class='text-center'>JUL</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_7_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                        <td class='text-center'>AGO</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_8_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td class='text-center'>SEP</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_9_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                        <td class='text-center'>OCT</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_10_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td class='text-center'>NOV</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_11_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                        <td class='text-center'>DIC</td>
                        <td class='text-center'>
                            <?
                            $doc = $pathfind."_12_".$yearNum.".xls";
                            if(file_exists($pathraiz."/plugins/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/plugins/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr style='border-top: solid 0.3em grey'>
                        <td class='text-center' colspan="2">ANUAL</td>
                        <td class='text-center' colspan="2">
                            <?
                            $doc = $pathfind2."_".$yearNum.".xls";
                            if(file_exists($pathraiz."/apps/jornada/excel/exports".$doc)){
                                echo "<button class='button' title='Descargar jornadas Enero'><a href='file:////192.168.3.108/web/erp/apps/jornada/excel/exports".$doc."'><img src='/erp/img/excel.png' height='20'></a>";
                            }else{
                                echo "";
                            }
                            ?>                          
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        
    </div>
</div>

<!-- datos trabajador -->