<div id="act-fin-view" style="padding-right: 10px;">
    <?
        echo "<legend class='col-form-label' style='padding-left: 15px; font-weight: 600;'>Finalización</legend>";
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>FECHA SOLUCIÓN:</label> <label id='view_titulo'>".$fecha_sol."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>FECHA FACTU.:</label> <label id='view_titulo'>".$fechaFactu."</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>SOLUCIÓN:</label> <label id='view_titulo'>".substr($solucionAct, 0, 300)."...</label>
              </div>"; 
        echo "<div class='form-group form-group-view'>
                <label class='viewTitle '>OBSERVACIONES:</label> <label id='view_titulo'>".$obsAct."</label>
              </div>"; 
    ?>
</div>
<div id="act-fin-edit" style="display: none; padding-right: 10px; color: #219ae0;">
    <form method="post" id="frm_editact_fin">
    <?
        echo "  <input type='hidden' name='act_edit_idact_fin' id='act_edit_idact_fin' value=".$id.">";
        echo "  <input type='hidden' name='act_edit_nombre_fin' id='act_edit_nombre_fin' value=".$tituloAct.">";
        echo "  <input type='hidden' name='act_edit_ref_fin' id='act_edit_ref_fin' value=".$ref.">";
        
        echo "  <legend class='col-form-label' style='display: inline-grid; padding-left: 15px; font-weight: 600;'>Finalización</legend>    
                <div class='form-group'>
                    <label for='act_edit_estados' class='col-xs-1-5' style='text-align: right;'>Estado:</label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <select id='act_edit_estados_fin' name='act_edit_estados_fin' class='selectpicker' data-live-search='true' data-width='33%'>
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class='form-group'></div>
                <div class='form-group'>
                    <label for='act_edit_fecha_solucion' class='col-xs-1-5' style='text-align: right;'>Fecha Solución:</label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <input type='date' class='form-control' id='act_edit_fecha_solucion' name='act_edit_fecha_solucion' value='".$fecha_sol."'>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='act_edit_solucion' class='col-xs-1-5' style='text-align: right;'>Solución:</label>
                    <div class='col-xs-10' style='float:left !important;'>
                        <textarea class='form-control' id='act_edit_solucion' name='act_edit_solucion' placeholder='Solución de la Actividad' rows='8'>".$solucionAct."</textarea>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='act_edit_fecha_factu' class='col-xs-1-5' style='text-align: right;'>Fecha Factu.:</label>
                    <div class='col-xs-3' style='float:left !important;'>
                        <input type='date' class='form-control' id='act_edit_fecha_factu' name='act_edit_fecha_factu' value='".$fechaFactu."'>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='act_edit_observ' class='col-xs-1-5' style='text-align: right;'>Observaciones:</label>
                    <div class='col-xs-10' style='float:left !important;'>
                        <textarea class='form-control' id='act_edit_observ' name='act_edit_observ' placeholder='Observaciones de la Actividad' rows='8'>".$obsAct."</textarea>
                    </div>
                </div>
                <div class='form-group'></div>";
        
    ?>
        <div class="form-group form-group-view" style="margin-top: 30px; margin-bottom: 30px !important;">
            <button type="button" class="btn btn-info" id="act_fin_edit_btn_save">
                <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
            </button>
        </div>
    </form>
</div>