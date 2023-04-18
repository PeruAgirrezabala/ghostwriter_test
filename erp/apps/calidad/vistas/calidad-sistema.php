<!-- proyectos seleccionado 
<div class="alert-middle alert alert-success alert-dismissable" id="proyectos_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Proyecto guardado</p>
</div>   --> 
    <!-- Nuevo codigo -->
    <table class="table table-striped table-hover" id='tabla-doc-ADMON'>
    <thead>
        <tr class="bg-dark">
            <th class="text-center">E</th>
            <th class="text-center">NOMBRE</th>
            <th class="text-center">ORG</th>
            <th class="text-center">V</th>
            <th class="text-center">S</th>
        </tr>
    </thead>
    <tbody>
    <?
    
        $pathraiz = $_SERVER['DOCUMENT_ROOT']."/erp";
        include_once($pathraiz."/connection.php");

        $db = new dbObj();
        $connString =  $db->getConnstring();
        
        $sql = "SELECT 
                    CALIDAD_SISTEMA.id,
                    CALIDAD_SISTEMA.nombre,
                    CALIDAD_SISTEMA.organismo_id,
                    ORGANISMOS.nombre,
                    CALIDAD_SISTEMA.doc_path                    
                FROM 
                    CALIDAD_SISTEMA, ORGANISMOS
                WHERE
                    CALIDAD_SISTEMA.organismo_id=ORGANISMOS.id
                AND
                    CALIDAD_SISTEMA.habilitado='on'";
        file_put_contents("selectCalidadSistema.txt", $sql);
        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de Calidad Sistema");
        
        while ($registros = mysqli_fetch_array($resultado)) {
            $id = $registros[0];
            $nombre = $registros[1];
            $organismo_id = $registros[2];
            $organismo = $registros[3];
            $doc_path = $registros[4];
            
            if($doc_path=="" or $doc_path==null){
                $farolillo="<span class='dot-grey''></span>";
            }else{
                $farolillo="<span class='dot-green''></span>";
            }
            //<a href='".$doc_path."' target='_blank'>".$nombre."</a>
            if(substr( $doc_path, 0, 7 ) === "file://"){
                $img="/erp/img/lupa.png";
            }else{
                $img="/erp/img/link.png";
            }
            echo "<tr data-id=".$id.">
                    <td class='text-center'>".$farolillo."</td>
                    <td style='text-align:center;'>".$nombre."</td> 
                    <td class='text-center'>".$organismo."</td>
                    <td class='text-center'><a href='".$doc_path."' target='_blank'><img src='".$img."' style='height: 10px;'></a></td>
                    <td class='text-center'><button class='btn-default upload-doc-SisCalidad' data-id='".$id."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 10px;'></button></td>
                </tr>";
            
        }
        /*
          echo "<tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Norma-ISO_9001_2015.pdf'>Norma ISO 9001 - 2015</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Norma-ISO_9001_2015.pdf' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Manual/CAL_MAN-CAL_01.pdf'>Manual de Calidad</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Manual/CAL_MAN-CAL_01.pdf' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_MATR-ID-RIESG_01.doc'>Matriz de Identificación de Riesgos</a></td>  
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_MATR-ID-RIESG_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_MATR-RIESG_01.doc'>Matriz de Riesgos</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_MATR-RIESG_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Formacion/CAL_MATR-RIESG_01.doc'>Plan de Formación</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Formacion/CAL_MATR-RIESG_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_MATR-PART-INT_01.doc'>Matriz de Identificación Partes Interesadas</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_MATR-PART-INT_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Aplicación ISO 9001 2015 -2019/Formacion/CAL_PERF-PUEST_01.doc'>Perfil de los Puestos</a></td>  
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Aplicación ISO 9001 2015 -2019/Formacion/CAL_PERF-PUEST_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Comunicaciones/CAL_MATR-COM_01.doc'>Matriz de Comunicaciones</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Comunicaciones/CAL_MATR-COM_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Politica de Seguridad y Salud/CAL_POL-SEG-SALUD_01.doc'>Política de Seguridad y Salud</a></td>  
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Politica de Seguridad y Salud/CAL_POL-SEG-SALUD_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_PLAN-ESTR-2018-20121_01.doc'>Plan Estratégico</a></td>  
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_PLAN-ESTR-2018-20121_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Aplicación ISO 9001 2015 -2020/Auditoria Interna/Plan anual de auditorías_2020.doc'>Plan Anual de Auditorías</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Aplicación ISO 9001 2015 -2020/Auditoria Interna/Plan anual de auditorías_2020.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Aplicación ISO 9001 2015 -2019/Auditoria Interna/Informe Auditoría 2018.docx'>Último Informe de Auditoría Interna</a></td>  
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Aplicación ISO 9001 2015 -2019/Auditoria Interna/Informe Auditoría 2018.docx' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='http://192.168.3.109/erp/apps/empresas/?v=p'>Proveedores Homologados</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='http://192.168.3.109/erp/apps/empresas/?v=p' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_MACR-PROC-EMPR_01.doc'>Macroproceso de la Empresa</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Plan Estrategico/CAL_MACR-PROC-EMPR_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='http://192.168.3.108/erp/apps/documentacion/'>Mapa de Documentos</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='http://192.168.3.108/erp/apps/documentacion/' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Política de Calidad/CAL_POL-CAL_01.doc'>Política de Calidad</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Política de Calidad/CAL_POL-CAL_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='http://192.168.3.108/erp/apps/procedimientos/'>Procedimientos</a></td> 
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='http://192.168.3.108/erp/apps/procedimientos/' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'>Por implementar</td>
                </tr>
                <tr>
                    <td class='text-center'><span class='dot-green''></span></td>
                    <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Calibración/CAL_CALIB-EQUIP-MEDIDA_01.doc'>Calibración Equipos de Medida</a></td>
                    <td class='text-center'>Organismo Privado</td>
                    <td class='text-center'>0000-00-00</td>
                    <td class='text-center'></td>
                    <td class='text-center'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ERP/ISO-9001/Calibración/CAL_CALIB-EQUIP-MEDIDA_01.doc' target='_blank'><img src='/erp/img/lupa.png' style='height: 10px;'></a></td>
                    <td class='text-center'><button class='btn-default upload-doc-PRL' data-id='".$docPRL_id."' title='Subir Documento'><img src='/erp/img/upload.png' style='height: 10px;'></button></td>
                </tr>
                </tbody>
                </table>
                ";*/
           echo " </tbody>
                </table>";     
    ?>
<!-- POP-UP Subir fichero-->

<div id="adddocSisCalidad_adddoc_model" class="modal fade">
    <div class="modal-dialog dialog_estrecho">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">AÑADIR DOCUMENTACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="contenedor-form">
                    <form method="post" id="frm_adddocSisCalidad">
                        <input type="hidden" id="adddocSisCalidad">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="labelBeforeBlack">Fecha hoy: </label>
                                <input type="date" class="form-control" id="adddocSisCalidad_fecha" name="adddocSisCalidad_fecha">
                            </div>
                        </div>
                        <div class="form-group" style=" margin-top: 15px;">
                            <label class="labelBefore">Archivo: </label>
                            <div class="file-loading">
                                <label class="labelBefore">Archivo</label>
                                <input id="uploaddocsSisCalidad" name="uploaddocsSisCalidad[]" type="file" data-show-preview="true" data-browse-on-zone-click="true">
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </form>
                </div>
            </div>
            <!--
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_pedidodetalle_save" class="btn btn-primary">Guardar</button>
                
            </div>
            -->
        </div>
    </div>
</div>