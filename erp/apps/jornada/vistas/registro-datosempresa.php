<!-- ofertas seleccionado -->
<div id="datosempresa-view" style="padding-left: 10px;">
    <div class="form-group">
    <div class="col-md-8">
        <div class='form-group form-group-view'>
            <label class='viewTitle'>Razón social:</label> <label id='view_ref' class='label-strong'>Genelek Sistemas S.L.</label>
        </div>  
        <div class='form-group form-group-view'>
            <label class='viewTitle'>CIF:</label> <label id='view_ref'>B75057778</label>
        </div>
        <div class='form-group form-group-view'>
            <label class='viewTitle'>Dirección:</label> <label id='view_titulo'>POL ADU 21 UROLA PLAZA - ZUMAIA, 20750 (GIPUZKOA)</label>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class='form-group form-group-view'>
            <label class='viewTitle'>CALENDARIO:</label> <label id='view_ref' class='label-strong'><? echo $yearNum; ?></label>
        </div>
        <div class='form-group form-group-view'>
            <button class="button" id="view-calendar" title="Ver calendario">
                <? echo '<a href="file:////192.168.3.108//_DOCUMENTACION/Genelek/Control_Horario/CAL'.trim($yearNum,' ').'.pdf" target="_blank"><img src="/erp/img/pdf.png" height="20"></a>'?>
            </button>
        </div>
    </div>
    </div>
    
</div>

<!-- mispartidos -->