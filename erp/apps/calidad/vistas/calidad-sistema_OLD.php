<!-- proyectos seleccionado -->
<div class="alert-middle alert alert-success alert-dismissable" id="proyectos_success" style="display:none; margin: 0px auto 0px auto;">
    <button type="button" class="close" aria-hidden="true">&times;</button>
    <p>Proyecto guardado</p>
</div>
<div id="calidad-sistema" style="margin-bottom: 20px;">
    
    <?
        /* 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle'>Manual de Calidad:</label>
              </div>";
         */
    
        echo "<div class='form-group form-group-view'>
                <div class='col-md-6'>";
        // INSERTO TABLA CON LOS EXPEDIENTES RELACIONADOS
        $estilo = "class='info'";
        echo "      <table class='table table-striped table-hover tabla-mant-exp' style='margin-bottom: 5px !important;'>
                        <thead>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Norma-ISO_9001_2015.pdf'>Norma ISO 9001 - 2015</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Manual/CAL_MAN-CAL_01.pdf'>Manual de Calidad</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Plan Estrategico/CAL_MATR-ID-RIESG_01.doc'>Matriz de Identificación de Riesgos</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Plan Estrategico/CAL_MATR-RIESG_01.doc'>Matriz de Riesgos</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Formacion/CAL_MATR-RIESG_01.doc'>Plan de Formación</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Plan Estrategico/CAL_MATR-PART-INT_01.doc'>Matriz de Identificación Partes Interesadas</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Aplicación ISO 9001 2015 -2019/Formacion/CAL_PERF-PUEST_01.doc'>Perfil de los Puestos</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Comunicaciones/CAL_MATR-COM_01.doc'>Matriz de Comunicaciones</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Politica de Seguridad y Salud/CAL_POL-SEG-SALUD_01.doc'>Política de Seguridad y Salud</a></td> 
                            </tr>
                        </thead> 
                    </table>
                </div>
                <div class='col-md-6'>
                    <table class='table table-striped table-hover tabla-mant-exp' style='margin-bottom: 5px !important;'>
                        <thead>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Plan Estrategico/CAL_PLAN-ESTR-2018-20121_01.doc'>Plan Estratégico</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Aplicación ISO 9001 2015 -2020/Auditoria Interna/Plan anual de auditorías_2020.doc'>Plan Anual de Auditorías</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Aplicación ISO 9001 2015 -2019/Auditoria Interna/Informe Auditoría 2018.docx'>Último Informe de Auditoría Interna</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='http://192.168.3.109/erp/apps/empresas/?v=p'>Proveedores Homologados</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Plan Estrategico/CAL_MACR-PROC-EMPR_01.doc'>Macroproceso de la Empresa</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='http://192.168.3.109/erp/apps/documentacion/'>Mapa de Documentos</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Política de Calidad/CAL_POL-CAL_01.doc'>Política de Calidad</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='http://192.168.3.109/erp/apps/procedimientos/'>Procedimientos</a></td> 
                            </tr>
                            <tr ".$estilo.">
                                <td style='text-align:center;'><a href='file:////192.168.3.108/_DOCUMENTACION/Calidad/ISO-9001/Calibración/CAL_CALIB-EQUIP-MEDIDA_01.doc'>Calibración Equipos de Medida</a></td> 
                            </tr>
                        </thead> 
                    </table>
                </div>
              </div>
            ";
                
                
    ?>
</div>
