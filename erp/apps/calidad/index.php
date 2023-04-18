<?
    include("../../common.php");

    if(!isset($_SESSION['user_session']))
    {
        $logeado = checkCookie();
        if ($logeado == "no") {
            header("Location: /erp/login.php");
        }
    }
    else {
        if ($_GET['empresa_id'] != "") {
            $empresa_id = $_GET['empresa_id'];
        }
        else {
            $empresa_id = "1";
        }
    }
    include($pathraiz."/apps/calidad/vistas/indicadores-grafico.php");
//    $dataPoints = obtenerGrafica();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link href="/erp/css/tools.css" rel="stylesheet">

<!-- <link rel="shortcut icon" href="/img/favicon.ico"> -->
<link rel="icon" type="image/png" href="/erp/img/favicon.png" />

<!--<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script> 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-es_ES.js"></script>

<!-- CHARTS -->
    <script src="/erp/includes/plugins/chart/dist/Chart.bundle.js"></script>

<!-- custom js -->
<script src="/erp/functions.js"></script>

<!-- Bootstrap switch -->
<link href="/erp/plugins/bootstrap-switch.min.css" rel="stylesheet">
<script src="/erp/plugins/bootstrap-switch.min.js"></script>

<!-- File input -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="/erp/includes/plugins/fileinput/js/locales/es.js"></script>

<!-- DRAG & DROP -->
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("Text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            //alert($("#" + data).data("id"));
            //alert($("#" + data).data("tipo"));
            var iddoc = $("#" + data).data("id");
            var doctype = $("#" + data).data("tipo");
            // INSERTAR PROCEDIMIENTO AJAX PARA GUARDAR EL REGISTRO DEL DOCUMENTO EN LA TABLA CLIENTES_DOC_ENVIAR
            $.ajax({
                type: "POST",  
                url: "linkDocEnviar.php",  
                data: {
                        id_doc: iddoc,
                        doc_type: doctype,
                        cliente_id: $("#contratistas_contratistas").val()
                      },
                dataType: "text",       
                success: function(response)  
                {
                    setTimeout(function(){
                        loadContent("doc-enviar-container", "/erp/apps/prevencion/vistas/doc-enviar.php?cliente_id=" + $('#contratistas_contratistas').val() + "&empresa_id=" + <? echo $empresa_id; ?>);
                    }, 500);
                }   
            });
            
            
            //var isLeft = 'drag1' == data || "drag2" == data;
            //var nodeCopy = document.getElementById(data).cloneNode(true);
            //nodeCopy.id = "img" + ev.target.id;
            //if (!isLeft) {
              //sourceNode = document.getElementById(data);
              //sourceNode.parentNode.removeChild(sourceNode);
            //}
            
            //ev.target.appendChild(nodeCopy);
            //ev.stopPropagation();
            //return false;
        }
    </script>

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            $("#conformidad_detectado_cliente").selectpicker('hide');
            $("#conformidad_detectado_proveedor").selectpicker('hide');
            $("#conformidad_detectado_auditor").selectpicker('hide');
            $("#filter_conformidades_por_cliente").selectpicker('hide');
            $("#filter_conformidades_por_proveedor").selectpicker('hide');
            $("#filter_conformidades_por_auditor").selectpicker('hide');
            $("#filter_conformidades_por_genelek").selectpicker('hide');
            $("#menuitem-calidad").addClass("active");
            $("#menuitem-procesos").addClass("active");
            
            $('#filter_conformidades_detectado').on('change', function() {
                $("#filter_conformidades_por_genelek").selectpicker('hide');
                $("#filter_conformidades_por_cliente").selectpicker('hide');
                $("#filter_conformidades_por_proveedor").selectpicker('hide');
                $("#filter_conformidades_por_auditor").selectpicker('hide');
                $("#filter_conformidades_por_").selectpicker('hide');
                $("#filter_conformidades_por_"+this.value).selectpicker('show');
            });
            $('#filter_conformidades_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                var quien="";
                switch($('#filter_conformidades_detectado').val()){
                    case "genelek":
                        quien="filter_conformidades_por_genelek";
                        break;
                    case "cliente":
                        quien="filter_conformidades_por_cliente";
                        break;
                    case "proveedor":
                        quien="filter_conformidades_por_proveedor";
                        break;
                }
                loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php?year=" + $(this).val() + "&month=" + $('#filter_conformidades_mes').val() + "&detectado=" + $('#filter_conformidades_detectado').val() + "&por=" + $('#'+quien).val()+ "&proyecto=" + $('#filter_conformidades_proyecto').val());
            });
            $('#filter_conformidades_mes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                var quien="";
                switch($('#filter_conformidades_detectado').val()){
                    case "genelek":
                        quien="filter_conformidades_por_genelek";
                        break;
                    case "cliente":
                        quien="filter_conformidades_por_cliente";
                        break;
                    case "proveedor":
                        quien="filter_conformidades_por_proveedor";
                        break;
                }
                loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php?year=" + $('#filter_conformidades_years').val() + "&month=" + $(this).val() + "&detectado=" + $('#filter_conformidades_detectado').val() + "&por=" + $('#'+quien).val()+ "&proyecto=" + $('#filter_conformidades_proyecto').val());
            });
            $('#filter_conformidades_detectado').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                var quien="";
                switch($('#filter_conformidades_detectado').val()){
                    case "genelek":
                        quien="filter_conformidades_por_genelek";
                        break;
                    case "cliente":
                        quien="filter_conformidades_por_cliente";
                        break;
                    case "proveedor":
                        quien="filter_conformidades_por_proveedor";
                        break;
                }
                loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php?year=" + $('#filter_conformidades_years').val() + "&month=" + $('#filter_conformidades_mes').val() + "&detectado=" + $(this).val() + "&por=" + $('#'+quien).val()+ "&proyecto=" + $('#filter_conformidades_proyecto').val());
            });
            $('#filter_conformidades_por_genelek').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php?year=" + $('#filter_conformidades_years').val() + "&month=" + $('#filter_conformidades_mes').val() + "&detectado=" + $('#filter_conformidades_detectado').val() + "&por=" + $(this).val()+ "&proyecto=" + $('#filter_conformidades_proyecto').val());
            });
            $('#filter_conformidades_por_cliente').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php?year=" + $('#filter_conformidades_years').val() + "&month=" + $('#filter_conformidades_mes').val() + "&detectado=" + $('#filter_conformidades_detectado').val() + "&por=" + $(this).val()+ "&proyecto=" + $('#filter_conformidades_proyecto').val());
            });
            $('#filter_conformidades_por_proveedor').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php?year=" + $('#filter_conformidades_years').val() + "&month=" + $('#filter_conformidades_mes').val() + "&detectado=" + $('#filter_conformidades_detectado').val() + "&por=" + $(this).val()+ "&proyecto=" + $('#filter_conformidades_proyecto').val());
            });
            $('#filter_conformidades_proyecto').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                var quien="";
                switch($('#filter_conformidades_detectado').val()){
                    case "genelek":
                        quien="filter_conformidades_por_genelek";
                        break;
                    case "cliente":
                        quien="filter_conformidades_por_cliente";
                        break;
                    case "proveedor":
                        quien="filter_conformidades_por_proveedor";
                        break;
                }
                loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php?year=" + $('#filter_conformidades_years').val() + "&month=" + $('#filter_conformidades_mes').val() + "&detectado=" + $('#filter_conformidades_detectado').val() + "&por=" + $('#'+quien).val()+ "&proyecto=" + $(this).val());
            });
            $('#clean-filters').click(function () {
               loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php");
               $("#filter_conformidades_years").selectpicker("val", "");
               $("#filter_conformidades_mes").selectpicker("val", "");
               $("#filter_conformidades_detectado").selectpicker("val", "");
               $("#filter_conformidades_por_genelek").selectpicker("val", "");
               $("#filter_conformidades_por_cliente").selectpicker("val", "");
               $("#filter_conformidades_por_proveedor").selectpicker("val", "");
               $("#filter_conformidades_por_auditor").selectpicker("val", "");
               $("#filter_conformidades_proyecto").selectpicker("val", "");
               $("#filter_conformidades_years").parent().children("button").removeClass("filter-selected");
               $("#filter_conformidades_mes").parent().children("button").removeClass("filter-selected");
               $("#filter_conformidades_detectado").parent().children("button").removeClass("filter-selected");
               $("#filter_conformidades_por_genelek").parent().children("button").removeClass("filter-selected");
               $("#filter_conformidades_por_cliente").parent().children("button").removeClass("filter-selected");
               $("#filter_conformidades_por_proveedor").parent().children("button").removeClass("filter-selected");
               $("#filter_conformidades_por_auditor").parent().children("button").removeClass("filter-selected");
               $("#filter_conformidades_proyecto").parent().children("button").removeClass("filter-selected");
            });
            $('#clean-filters-formacion').click(function () {
               loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php");
               $("#filter_formacion_years").selectpicker("val", "");
               $("#filter_formacion_nombre").selectpicker("val", "");
               $("#filter_formacion_users").selectpicker("val", "");
               $("#filter_formacion_yearsuser").selectpicker("val", "");
               $("#filter_formacion_years").parent().children("button").removeClass("filter-selected");
               $("#filter_formacion_nombre").parent().children("button").removeClass("filter-selected");
               $("#filter_formacion_users").parent().children("button").removeClass("filter-selected");
               $("#filter_formacion_yearsuser").parent().children("button").removeClass("filter-selected");
            });
            $('#filter_actas_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("actas-container", "/erp/apps/calidad/vistas/calidad-actas.php?year=" + $(this).val() + "&month=" + $('#filter_actas_mes').val());
            });
            $('#filter_actas_mes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("actas-container", "/erp/apps/calidad/vistas/calidad-actas.php?year=" + $('#filter_actas_years').val() + "&month=" + $(this).val());
            });
            $('#clean-filters-actas').click(function () {
               loadContent("actas-container", "/erp/apps/calidad/vistas/calidad-actas.php");
               $("#filter_actas_years").selectpicker("val", "");
               $("#filter_actas_mes").selectpicker("val", "");
               $("#filter_actas_years").parent().children("button").removeClass("filter-selected");
               $("#filter_actas_mes").parent().children("button").removeClass("filter-selected");
            });
            $(document).on("changed.bs.select", "#filter_indicadores_years" , function(e) {
            //$('#filter_indicadores_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                var valorid=$(this).parent().parent().parent().parent().data('id');
                //console.log(valor);
                $.ajax({
                    type: "GET",  
                    url: "vistas/generar-tabla-indicadores.php",  
                    data: {
                        linked:valorid,
                        year: $(this).val(),
                        resultado: $('#filter_indicadores_resultado').val(),
                        proyecto: $('#filter_indicadores_proyectos').val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        // Por mejorar
                        $('#indicador-detalle-7').html(response);
                        setTimeout(function(){
                            
                            //window.location.reload();                            
                            
                        }, 1000);
                    }   
                });
            });
            $(document).on("changed.bs.select", "#filter_indicadores_resultado" , function(e) {
            //$('#filter_indicadores_resultado').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                var valorid=$(this).parent().parent().parent().parent().data('id');
                //console.log(valor);
                $.ajax({
                    type: "GET",  
                    url: "vistas/generar-tabla-indicadores.php",  
                    data: {
                        linked:valorid,
                        year: $('#filter_indicadores_years').val(),
                        resultado: $(this).val(),
                        proyecto: $('#filter_indicadores_proyectos').val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        // Por mejorar
                        $('#indicador-detalle-7').html(response);
                        setTimeout(function(){
                            
                            //window.location.reload();                            
                            
                        }, 1000);
                    }   
                });
            });
            $(document).on("changed.bs.select", "#filter_indicadores_proyectos" , function(e) {
            //$('#filter_indicadores_proyectos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                var valorid=$(this).parent().parent().parent().parent().data('id');
                //console.log($('#filter_indicadores_years').val()+$('#filter_indicadores_resultado').val()+$(this).val());
                $.ajax({
                    type: "GET",  
                    url: "vistas/generar-tabla-indicadores.php",  
                    data: {
                        linked:valorid,
                        year: $('#filter_indicadores_years').val(),
                        resultado: $('#filter_indicadores_resultado').val(),
                        proyecto: $(this).val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        // Por mejorar
                        $('#indicador-detalle-7').html(response);
                        setTimeout(function(){
                            
                            //window.location.reload();                            
                            
                        }, 1000);
                    }   
                });
            });
            $(document).on("click", "#clean-filters-indicador-detalles" , function() {
            //$('#clean-filters-indicador-detalles').click(function () {
            //console.log("asassa");
                $("#filter_indicadores_years").selectpicker("val", "");
                $("#filter_indicadores_resultado").selectpicker("val", "");
                $("#filter_indicadores_proyectos").selectpicker("val", "");
                $("#filter_indicadores_years").parent().children("button").removeClass("filter-selected");
                $("#filter_indicadores_resultado").parent().children("button").removeClass("filter-selected");
                $("#filter_indicadores_proyectos").parent().children("button").removeClass("filter-selected");
                $.ajax({
                    type: "GET",  
                    url: "vistas/generar-tabla-indicadores.php",  
                    data: {
                        linked:$(this).data("id")
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        // Por mejorar
                        $('#indicador-detalle-7').html(response);
                        setTimeout(function(){
                            
                            //window.location.reload();                            
                            
                        }, 1000);
                    }   
                });
               //loadContent("indicador-detalle-X", "/erp/apps/calidad/vistas/generar-tabla-indicadores.php?linked="+$(this).data("id"));
               
            });
            loadSelect("conformidad_proyectos","PROYECTOS","id","","","ref");
            loadSelect("conformidad_detectado","erp_users","id","","","apellidos");
            
            $('input[name="calidad_sistema_habilitado"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
                
            });
            $('input[name="addCalibraciones_activado"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
                
            });
            
            $('#ver-sistema-calidad-todos').click(function () {
                $("#SistemaCal_todos_model").modal('show');
            });
            $('#ver-calibraciones-old').click(function () {
                $.ajax({
                    type : 'POST',
                    url : 'saveCalibraciones.php',
                    dataType : 'text',
                    data: {
                        loadantiguascalibraciones_id : 1
                    },
                    success : function(data){
                        //console.log("ok");
                        $("#Calibraciones_old_model").html(data);
                        $("#Calibraciones_old_model").modal('show');
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", "#tabla-siscal-todos tr > td:not(:nth-child(4))" , function() {
                $("#calsis_id").val($(this).parent("tr").data("id"));
                $("#siscal_cambiar_habilitado").modal('show');
            });
            $(document).on("click", "#tabla-calibraciones-old tr > td:not(:nth-child(10))" , function() {
                $("#antiguascalibraciones_id").val($(this).parent("tr").data("id"));
                $("#antiguascalibraciones_habilitado").modal('show');
            });
            $("#btn_siscal_habil").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'editHabilitado.php',
                    dataType : 'text',
                    data: {
                        calsis_id : $("#calsis_id").val()
                    },
                    success : function(data){
                        //console.log("ok");
                        //$("#siscal_cambiar_habilitado").modal('hide');
                        //$("#SistemaCal_todos_model").modal('hide');
                        //loadContent("doc-admon-container", "/apps/calidad/vistas/calidad-sistema.php");
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", "#btn_antiguascalibraciones_habilitado" , function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveCalibraciones.php',
                    dataType : 'text',
                    data: {
                        antiguascalibraciones_id : $("#antiguascalibraciones_id").val()
                    },
                    success : function(data){
                        //console.log("ok");
                        
                        $("#antiguascalibraciones_habilitado").modal('hide');
                        $("#Calibraciones_old_model").modal('hide');
                        loadContent("calibraciones-container", "/erp/apps/calidad/vistas/calidad-calibraciones.php");
                        //window.location.reload();
                        // kk
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $("#adddocProcesos_fecha").focusout(function() {
                $("#uploaddocsProcesos").fileinput('destroy');
                $("#uploaddocsProcesos").fileinput({
                    uploadUrl: "upload.php?tipo=PROCESOS&iddoc=" + $("#adddocProcesos").val() + "&fecha=" + $("#adddocProcesos_fecha").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $("#adddocActa_fecha").focusout(function() {
                $("#uploaddocsACTA").fileinput('destroy');
                $("#uploaddocsACTA").fileinput({
                    uploadUrl: "upload.php?tipo=ACTA&iddoc=" + $("#adddocActa").val() + "&fecha=" + $("#adddocActa_fecha").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $("#adddocCalibraciones_fecha").focusout(function() {
                $("#uploaddocsCALIBRACIONES").fileinput('destroy');
                $("#uploaddocsCALIBRACIONES").fileinput({
                    uploadUrl: "upload.php?tipo=CALIBRACIONES&iddoc=" + $("#adddocCalibraciones").val() + "&fecha=" + $("#adddocCalibraciones_fecha").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $("#adddocSisCalidad_fecha").focusout(function() {
                $("#uploaddocsSisCalidad").fileinput('destroy');
                $("#uploaddocsSisCalidad").fileinput({
                    uploadUrl: "upload.php?tipo=SIS_CALIDAD&iddoc=" + $("#adddocSisCalidad").val() + "&fecha=" + $("#adddocSisCalidad_fecha").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $("#adddocFormacion_fecha").focusout(function() {
                $("#uploaddocsFORMACION").fileinput('destroy');
                $("#uploaddocsFORMACION").fileinput({
                    uploadUrl: "upload.php?tipo=FORMACION&iddoc=" + $("#adddocFormacion").val() + "&fecha=" + $("#adddocFormacion_fecha").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            filesUpload = [];
            
            $('#uploaddocsProcesos').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "PROCESOS",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocProcesos").val()
                })
                .done(function( data1 ) {
                    console.log(data1);
                    //alert( "ok" );
                    //window.location.reload();
                    loadContent("procesos-container", "/erp/apps/calidad/vistas/calidad-procesos.php");
                    $("#adddocProcesos_adddoc_model").modal('hide');
                }); 
            });
            $('#uploaddocsACTA').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "ACTA",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocActa").val()
                })
                .done(function( data1 ) {
                    console.log(data1);
                    //alert( "ok" );
                    //window.location.reload();
                    loadContent("actas-container", "/erp/apps/calidad/vistas/calidad-actas.php");
                    $("#adddocActa_adddoc_model").modal('hide');
                }); 
            });
            $('#uploaddocsCALIBRACIONES').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "CALIBRACIONES",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocCalibraciones").val()
                })
                .done(function( data1 ) {
                    console.log(data1);
                    //alert( "ok" );
                    //window.location.reload();
                    loadContent("calibraciones-container", "/erp/apps/calidad/vistas/calidad-calibraciones.php");
                    $("#adddocCalibraciones_adddoc_model").modal('hide');
                }); 
            });
            $('#uploaddocsFORMACION').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "FORMACION",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocFormacion").val()
                })
                .done(function( data1 ) {
                    console.log(data1);
                    //alert( "ok" );
                    loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php");
                    $("#adddocFormacion_adddoc_model").modal('hide');
                    //window.location.reload();
                }); 
            });
            $('#uploaddocsSisCalidad').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "SIS_CALIDAD",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocSisCalidad").val()
                })
                .done(function( data1 ) {
                    console.log(data1);
                    //alert( "ok" );
                    window.location.reload();
                }); 
            });
            $(".upload-doc-Proceso").click(function() {
                $("#adddocProcesos").val($(this).data("id"));
                //console.log($(this).data("id"));
                $("#adddocProcesos_adddoc_model").modal('show');
            });
            /** NO CARGA SCRIPT POR CARGAS DE VENTANAS
            $(".upload-doc-Acta").click(function() {
                $("#adddocActa").val($(this).data("id"));
                console.log($(this).data("id"));
                $("#adddocActa_adddoc_model").modal('show');
            });
            */
            $(".upload-doc-SisCalidad").click(function() {
                $("#adddocSisCalidad").val($(this).data("id"));
                console.log($(this).data("id"));
                $("#adddocSisCalidad_adddoc_model").modal('show');
            });
            // OPEN MODALS 
            $("#add-sistema-calidad").click(function() {
                //Vaciado del formulario
                $("#calidad_sistema_id").val("");
                $("#calidad_sistema_nombre").val("");
                $("#calidad_sistema_organismo").val("");
                $('input[name="calidad_sistema_habilitado"]').bootstrapSwitch('state',parseInt(0));
                //Mostrar el pop-up
                $("#calidad_sistema_add_model").modal('show');
            });
            $("#add-proceso").click(function() {
                //Vaciado del formulario
                $("#proceso_id").val("");
                $("#proceso_nombre").val("");
                $("#proceso_resp").val("");
                $("#proceso_dptos").val("");
                $("#proceso_objeto").val("");
                $("#proceso_recursos").val("");
                $("#proceso_entradas").val("");
                $("#proceso_salidas").val("");
                $("#proceso_registros").val("");
                $("#proceso_procedimientos").val("");
                $("#proceso_actividades").val("");
                //Mostrar el pop-up
                $("#proceso_add_model").modal('show');
            });
            $("#add-indicador").click(function() {
                //Vaciado de Formulario
                $("#indicador_id").val("");
                $("#indicador_nombre").val("");
                $("#indicador_desc").val("");
                $("#indicador_calculo").val("");
                $("#indicador_valor").val("");
                $("#indicador_objetivo").val("");
                $("#indicador_resultado").val("1");
                //Mostrar Pop-Up
                $("#indicador_add_model").modal('show');
            });
            $("#add-conformidad").click(function() {
                //Vaciado de datos del Pop-Up
                $("#conformidad_id").val("");
                $("#conformidad_nombre").val("");
                $("#conformidad_desc").val("");
                $("#conformidad_fecha").val("");
                $("#conformidad_resolucion").val("");
                $("#conformidad_causa").val("");
                $("#conformidad_cierre").val("");
                $("#conformidad_fecha_cierre").val("");
                $("#conformidad_detectado").selectpicker("val", "");
                $("#conformidad_proyectos").selectpicker("val", "");
                //Mostramos el Pop-Up
                $("#conformidad_add_model").modal('show');
            });
            $("#add-acta").click(function() {
                //Vaciado de Formulario
                $("#addActa_id").val("");
                $("#addActa_nombre").val("");
                $("#addActa_descripcion").val("");
                //Mostrar Pop-Up
                $("#acta_add_model").modal('show');                
            });
            $("#add-calibraciones").click(function() {
                //Vaciado de Formulario
                $("#frm_addCalibraciones").trigger("reset");
                $("#addCalibraciones_id").val("");
                $('input[name="addCalibraciones_activado"]').bootstrapSwitch('state',parseInt(0));
                //Mostrar Pop-Up
                $("#calibraciones_add_model").modal('show');                
            });
            $("#add-formacion").click(function() {
                //Vaciado de Formulario
                $("#addFormacion_id").val("");
                $("#addFormacion_nombre").val("");
                $("#addFormacion_descripcion").val("");
                $("#addFormacion_fecha").val("");
                //Mostrar Pop-Up
                $("#formacion_add_model").modal('show');                
            });      
            $(".indicadores-proceso").click(function() {
                event.preventDefault();
                loadContent("indicadores-container", "/erp/apps/calidad/vistas/procesos-indicadores.php");
                $("#titulo-indicadores").html("TODOS LOS INDICADORES");
                $("#item-actas").hide();
                $("#item-calibraciones").hide();
                $("#item-conformidades").hide();
                $("#item-procesos").show();
                $("#item-indicadores").show();
                $("#item-formacion").hide();
                pintarGrafico6();
                pintarGrafico5();
                $("#item-indicadores-grafico").show();
                /*
                loadContent("indicadores-container", "/erp/apps/calidad/vistas/procesos-indicadores.php?idproceso=" + $(this).data("id"));
                $("#indicador_proceso_id").val($(this).data("id"));
                $("#titulo-indicadores").html("INDICADORES DEL PROCESO DE " + $(this).parent("td").parent("tr").children("td:first-child").html());
                $(this).parent("td").parent("tr").parent("tbody").children("tr").removeClass("success");
                $(this).parent("td").parent("tr").addClass("success");
                $("#item-indicadores").show();
                $("#item-indicadores-grafico").show();
                */
            });
                        
            $(document).on("click", "#tabla-calidad-procesos tr > td:not(:nth-child(4)):not(:nth-child(5)):not(:nth-child(6)):not(:nth-child(7))" , function() {
                //location.href = "view.php?id=" + $(this).data("id");
                //loadPERInfo($(this).parent("tr").data("id"));
                loadProcesoDetalle($(this).parent("tr").data("id"));
                $("#proceso_add_model").modal('show');
            });
            
            $(document).on("click", "#tabla-calidad-indicadores tr > td:not(:nth-child(6)):not(:nth-child(7))" , function() {
                $("#indicador_id").val("");
                $("#indicador_nombre").val("");
                $("#indicador_desc").val("");
                $("#indicador_calculo").val("");
                $("#indicador_valor").val("");
                $("#indicador_objetivo").val("");
                //$("#indicador_tienehijos").val("");
                $("#indicador_resultado").val("1");
                $("#indicadores-anyos-anteriores").hide();
                
                loadIndicadorDetalle($(this).parent("tr").data("id"));
                
                $("#indicador_add_model").modal('show');
            });
            $("#btn_indicador_anteriores").click(function() {
                if($("#indicadores-anyos-anteriores").is(':visible')){
                    $("#indicadores-anyos-anteriores").hide();
                }else{
                    data = $("#frm_indicador").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "indicadoresAnyosAnteriores.php",  
                        data: data,
                        dataType: "text",       
                        success: function(response)  
                        {
                            //console.log(response);
                            $("#indicadores-anyos-anteriores").html(response);
                            $(".save-editar-indicador-anyo").hide();
                            $(".indicador_anteriores_valor_nuevo").hide();
                            $("#indicadores-anyos-anteriores").show();
                            //$('#frm_proceso').trigger("reset");
                            //$("#btn_proceso_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            setTimeout(function(){
                                //window.location.reload();
                            }, 1000);
                        }   
                    });
                }
            });
            $(document).on("click", "#indicador-anyos-anteriores" , function() {
                $("#indicador_add_anyos_anteriores_model").modal('show');  
            });
            $(document).on("click", "#btnadd-indicador-anyos-anteriores" , function() {
                data = $("#frm_indicador").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "indicadoresAnyosAnteriores.php",  
                    data: {
                        data,
                        anyo_anterior: $("#indicador_anteriores_anyo").val(),
                        indicador_id:$("#indicador_id").val(),
                        anyo_anterior_valor: $("#indicador_anteriores_valor").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        // POR MEJORAR REFRESHCO!!!
                        $("#indicador_add_anyos_anteriores_model").modal('hide');
                        $("#indicador_add_model").modal('hide');

                        $("#indicadores-anyos-anteriores").hide();
                        
                        
                        
                        setTimeout(function(){
                            //window.location.reload();
                        }, 500);
                    }   
                 });        
            });
            $(document).on("click", ".editar-indicador-anyo" , function() {
                //console.log($(this).val());
                $("#save-editar-indicador-anyo"+$(this).val()).show();
                $("#indicador_anteriores_valor_nuevo"+$(this).val()).show();
                $("#txt_indicador_anteriores_valor_nuevo"+$(this).val()).hide();
                $("#editar-indicador-anyo"+$(this).val()).hide();
            });
            $(document).on("click", ".save-editar-indicador-anyo" , function() {
                $("#save-editar-indicador-anyo"+$(this).val()).hide();
                $("#indicador_anteriores_valor_nuevo"+$(this).val()).hide();
                $("#txt_indicador_anteriores_valor_nuevo"+$(this).val()).show();
                $("#editar-indicador-anyo"+$(this).val()).show();
                var obj = $("#indicador_anteriores_valor_nuevo"+$(this).val());
                var txt_obj = $("#txt_indicador_anteriores_valor_nuevo"+$(this).val());
                data = $("#frm_indicador").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "indicadoresAnyosAnteriores.php",  
                    data: {
                        data,
                        edit_anyo: $(this).val(),
                        indicador_id:$("#indicador_id").val(),
                        valor_nuevo:$(obj).val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        
                        // NO REPINTA BIEN EN LA ACTUALIZACION
                        //$("#indicador_add_model").modal('hide');
                        
                        //NO FUNCIONA REEMPLAZAR: MEJORA REFRESCO
                        $("#indicadores-anyos-anteriores").hide();
                        //$(txt_obj).val($(obj).val());
                        
                        // Refrescar datos gráfica
                        if($('#opcion-grafico-indicador').val()==6){
                            pintarGrafico6();
                        }
                        if($('#opcion-grafico-indicador').val()==5){
                            pintarGrafico5();
                        }
                        setTimeout(function(){
                            //window.location.reload();
                        }, 500);
                    }   
                 });        
            });
            $(document).on("click", "#borrar-indicador-anyo" , function() {
                data = $("#frm_indicador").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "indicadoresAnyosAnteriores.php",  
                    data: {
                        data,
                        del_anyo: $(this).val(),
                        indicador_id:$("#indicador_id").val(),
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        
                        // NO RECARGA LA GRAFICA
                        // ?¿
                        // NO RECARGA BIEN EL REFRESCO
                        //$("#indicador_add_model").modal('hide');
                        $("#indicadores-anyos-anteriores").hide();
                        $(this).html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp;');
                        setTimeout(function(){
                            //window.location.reload();
                        }, 500);
                    }   
                 });        
            });
            $(document).on("click", ".vermas" , function() {
                //console.log("hola?");
                 $.ajax({
                    type: "GET",  
                    url: "vistas/procesos-indicadores-detalles.php",  
                    data: {
                        detalleid:$(this).data("id")
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $('#indicadores-container-detalle').html(response);
                        $('.selectpicker').selectpicker();
                        $('.selectpicker').selectpicker('render');
                        $('.selectpicker').selectpicker('refresh');
                        setTimeout(function(){
                            //window.location.reload();                            
                        }, 1000);
                    }   
                });       
                        
            });
            $(document).on("click", ".page-link" , function() {
                var obj_id="indicador-detalle-"+$(this).closest("div").parent().data('id');
                var indicadorDetalleId = $(this).closest("div").parent().data('id');
                $.ajax({
                    type: "GET",  
                    url: "vistas/generar-tabla-indicadores.php",  
                    data: {
                        pag:$(this).data("pag"),
                        linked:indicadorDetalleId
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $('#'+obj_id).html(response);
                        //$('.selectpicker').selectpicker();
                        //$('.selectpicker').selectpicker('render');
                        //$('.selectpicker').selectpicker('refresh');
                        setTimeout(function(){
                            
                            //window.location.reload();                            
                            
                        }, 1000);
                    }   
                });
                /* ESTO FUNCIONABA REGULIN (display:none)
                var indicadorDetalleId = $(this).closest("div").parent().data('id');
                loadContent("indicador-detalle-X", "/erp/apps/calidad/vistas/generar-tabla-indicadores.php?pag=" + $(this).data("pag")+ "&linked="+indicadorDetalleId);
                */
           });
            $("#menuitem-indicadores > a").click(function(event) {
                event.preventDefault();
                loadContent("indicadores-container", "/erp/apps/calidad/vistas/procesos-indicadores.php");
                $("#titulo-indicadores").html("TODOS LOS INDICADORES");
                $("#item-actas").hide();
                $("#item-calibraciones").hide();
                $("#item-conformidades").hide();
                $("#item-procesos").show();
                $("#item-indicadores").show();
                $("#item-formacion").hide();
                pintarGrafico6();
                pintarGrafico5();
                $('#grafico-indicadores5').hide();
                $("#item-indicadores-grafico").show();
            });
            $("#ver-indicadores-todos").click(function() {
                var objeto = "#dash-content";
                if(($(objeto).is(":hidden"))==true){
                    $(objeto).attr("hidden",false);
                    $(this).children().attr("src","/erp/img/noojo.png");
                    for (var i = 1; i < 20; i++) {
                        var objeto_h = "#dash-indic-"+i;
                        $(objeto_h).attr("hidden",false);
                    }
                }else{
                    $(objeto).attr("hidden",true);
                    $(this).children().attr("src","/erp/img/ojo.png");
                    for (var i = 1; i < 20; i++) {
                        var objeto_h = "#dash-indic-"+i;
                        $(objeto_h).attr("hidden",true);
                    }
                }
            });
            
            $("#menuitem-conformidades > a").click(function(event) {
                event.preventDefault();
                loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php");
                $("#item-procesos").hide();
                $("#item-indicadores").hide();
                $("#item-actas").hide();
                $("#item-calibraciones").hide();
                $("#item-conformidades").show();
                $("#item-formacion").hide();
                $("#item-indicadores-grafico").hide();
            });
            
            $("#menuitem-procesos > a").click(function(event) {
                event.preventDefault();
                $("#item-conformidades").hide();
                $("#item-procesos").show(); 
                $("#item-indicadores").hide();
                $("#item-actas").hide();
                $("#item-calibraciones").hide();
                $("#item-formacion").hide();
                $("#item-indicadores-grafico").hide();
            });
            
            $("#menuitem-actas > a").click(function(event) {
                event.preventDefault();
                loadContent("actas-container", "/erp/apps/calidad/vistas/calidad-actas.php");
                $("#item-procesos").hide();
                $("#item-indicadores").hide();
                $("#item-actas").show();
                $("#item-formacion").hide();
                $("#item-conformidades").hide();
                $("#item-calibraciones").hide();
                $("#item-indicadores-grafico").hide();
            });
            $("#menuitem-calibraciones > a").click(function(event) {
                event.preventDefault();
                loadContent("calibraciones-container", "/erp/apps/calidad/vistas/calidad-calibraciones.php");
                $("#item-procesos").hide();
                $("#item-indicadores").hide();
                $("#item-actas").hide();
                $("#item-calibraciones").show();
                $("#item-formacion").hide();
                $("#item-conformidades").hide();
                $("#item-indicadores-grafico").hide();
            });
            $("#menuitem-formacion > a").click(function(event) {
                event.preventDefault();
                loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php");
                $("#item-procesos").hide();
                $("#item-indicadores").hide();
                $("#item-actas").hide();
                $("#item-calibraciones").hide();
                $("#item-formacion").show();
                $("#item-conformidades").hide();
                $("#item-indicadores-grafico").hide();
            });
            $('#calidad_sistema_habilitado').on('switchChange.bootstrapSwitch', function (event, state) {
                //console.log(this);
                //console.log(event);
                //console.log(state);
                if(state==true){
                    //$('input[name="calidad_sistema_habilitado"]').bootstrapSwitch('state',true);
                    $("#txt_habilitado").val("on");
                }else{
                    //$('input[name="calidad_sistema_habilitado"]').bootstrapSwitch('state',false);
                    $("#txt_habilitado").val("off");
                }
                event.preventDefault();
            });
            $('#addCalibraciones_activado').on('switchChange.bootstrapSwitch', function (event, state) {
                //console.log(this);
                //console.log(event);
                //console.log(state);
                if(state==true){
                    //$('input[name="calidad_sistema_habilitado"]').bootstrapSwitch('state',true);
                    $("#txt_activado").val("on");
                }else{
                    //$('input[name="calidad_sistema_habilitado"]').bootstrapSwitch('state',false);
                    $("#txt_activado").val("off");
                }
                event.preventDefault();
            });
            $(document).on("click", "#tabla-calidad-formacion tr > td:not(:nth-child(2)):not(:nth-child(3)):not(:nth-child(4)):not(:nth-child(5)):not(:nth-child(6)):not(:nth-child(7))" , function() {
                $("#Formacion_id").val($(this).parent("tr").data("id"));
                // console.log("dato es: "+$(this).parent("tr").data("id"));
                // $("#btn_indicador_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                // data = $("#frm_indicador").serializeArray(); NO ES NECESARIO?
                $.ajax({
                    type: "POST",  
                    url: "vistas/calidad-formacion-detalles.php",  
                    data: {
                        formacion_id:$(this).parent("tr").data("id")
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        //loadContent("#container-para-model-detalles", response);
                        $("#container-para-model-detalles").html(response);
                        $("#formacionDetalles_add_model").modal('show');
                        //$('#frm_indicador').trigger("reset");
                        //$("#btn_indicador_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        setTimeout(function(){
                            //window.location.reload();                            
                            //loadContent("indicadores-container", "/erp/apps/calidad/vistas/procesos-indicadores.php?idproceso=" + $("#indicador_proceso_id").val());
                        }, 1000);
                    }   
                });
            });
            /***** Editar Formación [DE MOMENTO HABILITADO] */ 
            $(document).on("click", "#tabla-calidad-formacion tr > td:not(:nth-child(1)):not(:nth-child(5)):not(:nth-child(6)):not(:nth-child(7))" , function() {
                $("#addFormacion_id").val($(this).parent("tr").data("id"));
                loadFormacion($(this).parent("tr").data("id"));
                $("#formacion_add_model").modal('show');
            }); 
            $(document).on("click", "#tabla-formacion-detalles tr > td:not(:nth-child(1)):not(:nth-child(2))" , function() {
                //console.log("Dato debe de ser 1:"+$(this).data('id'));
                if($(this).data('id')==1){ // Comprobar que sea 1 el valor para que se cambie o no. Dependiendo de si está el usuario ya asignado o no
                    var idFormacion = $(this).parent().data('id');
                    var idTrabajador = $(this).parent().first().find("input:nth-child(3)").val();
                    //console.log("ID de la formacion: "+idFormacion);
                    //console.log("ID del trabajador: "+idTrabajador);
                    $("#tecnicoId").val(idTrabajador);
                    $("#formacionId").val(idFormacion);
                    $("#cambiar_fecha_model").modal('show');
                }                
            });
            $("#btn_formacionFecha_save").click(function() {
                $("#btn_formacionFecha_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                //data = $("#frm_addFormacion").serializeArray();
                console.log("Boton pulsado");
                $.ajax({
                    type: "POST",  
                    url: "saveFormacionDetalles.php",  
                    data: {
                        changeDate: $("#addFomacionDetalle_fecha").val(),
                        tecnicoId: $("#tecnicoId").val(),
                        formacionId: $("#formacionId").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        //$('#frm_new_doc_PRL').trigger("reset");
                        $("#btn_formacionFecha_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        //$("#newdocPRL_success").slideDown();
                        setTimeout(function(){
                            //$("#newdocPRL_success").fadeOut("slow");
                            //console.log(?¿);
                            //$("#btn_formacion_save").html('Guardar');
                            $("#cambiar_fecha_model").modal('hide');
                            $("#formacionDetalles_add_model").modal('hide');
                            //loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php");
                            //window.location.reload();                           
                            
                        }, 1000);
                    }   
                });
            });
            $(document).on("click", "#add-formacion-persona" , function() {
                $("#addTecnicoFormacion").val($("#Formacion_id").val());
                //console.log($(this).data("id"));
                $("#addTecnicoFormacion_adddoc_model").modal('show');
            });
            $(document).on("click", "#add-formacion-todos" , function() {
                $("#addTodosTecnicosFormacion").val($("#Formacion_id").val());
                //console.log($(this).data("id"));
                $("#addTodosTecnicoFormacion_adddoc_model").modal('show');
            });
            $(document).on("click", "#tabla-doc-ADMON tr > td:not(:nth-child(4)):not(:nth-child(5))" , function() {
                $("#calidad_sistema_id").val($(this).parent("tr").data("id"));
                loadSistemaCalidad($(this).parent("tr").data("id"));
                $('input[name="calidad_sistema_habilitado"]').bootstrapSwitch('state',true);
                $("#calidad_sistema_add_model").modal('show');
            }); 
            $(document).on("click", "#tabla-calidad-actas tr > td:not(:nth-child(4)):not(:nth-child(5)):not(:nth-child(6))" , function() {
                $("#addActa_id").val($(this).parent("tr").data("id"));
                loadActasDetalle($(this).parent("tr").data("id"));
                $("#acta_add_model").modal('show');
            });
            $(document).on("click", "#tabla-calidad-calibraciones tr > td:not(:nth-child(9)):not(:nth-child(10)):not(:nth-child(11))" , function() {
                $("#addCalibraciones_id").val($(this).parent("tr").data("id"));
                loadCalibraciones($(this).parent("tr").data("id"));
                $('input[name="addCalibraciones_activado"]').bootstrapSwitch('state',true);
                $("#calibraciones_add_model").modal('show');
            });
            
            $(document).on("click", "#tabla-calidad-conformidades tr > td:not(:nth-child(7))" , function() {
                //Mostrar Pop-Up
                $("#conformidad_id").val($(this).parent("tr").data("id"));
                //console.log($(this).parent("tr").data("id"));
                loadConformidadDetalle($(this).parent("tr").data("id"));
                $("#conformidad_add_model").modal('show');
            });
            $('#conformidad_detectado1').on('change', function() {
                $("#conformidad_detectado_genelek").selectpicker('hide');
                $("#conformidad_detectado_cliente").selectpicker('hide');
                $("#conformidad_detectado_proveedor").selectpicker('hide');
                $("#conformidad_detectado_auditor").selectpicker('hide');
                $("#conformidad_detectado_"+this.value).selectpicker('show');
            });
            $("#btn_sistema_calidad_save").click(function() {
                $('input[name="edit_chkrecibido"]').bootstrapSwitch('state',parseInt(0));
                //console.log($('input[name="calidad_sistema_habilitado"]').val());
                //console.log($('#calidad_sistema_habilitado').val());
                $("#btn_sistema_calidad_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_calidad_sistema").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveCalidadSistema.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $('#frm_calidad_sistema').trigger("reset");
                        $("#btn_sistema_calidad_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#btn_proceso_save").click(function() {
                $("#btn_proceso_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_proceso").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveProceso.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $('#frm_proceso').trigger("reset");
                        $("#btn_proceso_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            $("#btn_conformidad_save").click(function() {
                $("#btn_conformidad_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_conformidad").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveConformidad.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        //$('#frm_indicador').trigger("reset");
                        $("#btn_conformidad_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        setTimeout(function(){
                            
                            $("#conformidad_add_model").modal('hide');
                            loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php");
                           //window.location.reload();
                            //loadContent("indicadores-container", "/erp/apps/calidad/vistas/procesos-indicadores.php?idproceso=" + $("#indicador_proceso_id").val());
                        }, 1000);
                    }   
                });
            });
            $("#btn_indicador_save").click(function() {
            //console.log("objet: "+$("#indicador_objetivo").val()+" actual: "+$("#indicador_actual").val());
                $("#btn_indicador_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_indicador").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveIndicador.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        //$('#frm_indicador').trigger("reset");
                        $("#btn_indicador_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        setTimeout(function(){
                            
                            // NO REFRESCA LAS GRÁFICAS!
                            // $("#indicador_add_model").modal('hide');
                            // loadContent("indicadores-container", "/erp/apps/calidad/vistas/procesos-indicadores.php");
                            window.location.reload();                            
                            //loadContent("indicadores-container", "/erp/apps/calidad/vistas/procesos-indicadores.php?idproceso=" + $("#indicador_proceso_id").val());
                        }, 1000);
                    }   
                });
            });
            
            $("#btn_acta_save").click(function() {
                $("#btn_acta_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_addActa").serializeArray();
                //console.log(data);
                $.ajax({
                    type: "POST",  
                    url: "saveActa.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        //$('#frm_new_doc_PRL').trigger("reset");
                        $("#btn_acta_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardado');
                        //$("#newdocPRL_success").slideDown();
                        setTimeout(function(){
                            //$("#newdocPRL_success").fadeOut("slow");
                            $("#btn_acta_save").html('Guardar');
                            $("#acta_add_model").modal('hide');
                            loadContent("actas-container", "/erp/apps/calidad/vistas/calidad-actas.php");
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#btn_calibraciones_save").click(function() {
                $("#btn_calibraciones_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_addCalibraciones").serializeArray();
                //console.log(data);
                $.ajax({
                    type: "POST",  
                    url: "saveCalibraciones.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        //$('#frm_new_doc_PRL').trigger("reset");
                        $("#btn_calibraciones_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardado');
                        //$("#newdocPRL_success").slideDown();
                        setTimeout(function(){
                            //$("#newdocPRL_success").fadeOut("slow");
                            $("#btn_calibraciones_save").html('Guardar');
                            $("#calibraciones_add_model").modal('hide');
                            loadContent("calibraciones-container", "/erp/apps/calidad/vistas/calidad-calibraciones.php");
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            $("#btn_formacion_save").click(function() {
                $("#btn_formacion_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_addFormacion").serializeArray();
                //console.log(data);
                $.ajax({
                    type: "POST",  
                    url: "saveFormacion.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        //$('#frm_new_doc_PRL').trigger("reset");
                        $("#btn_formacion_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardado');
                        //$("#newdocPRL_success").slideDown();
                        setTimeout(function(){
                            //$("#newdocPRL_success").fadeOut("slow");
                            //console.log(?¿);
                            $("#btn_formacion_save").html('Guardar');
                            $("#formacion_add_model").modal('hide');
                            loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php");
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $('#filter_formacion_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php?year=" + $(this).val() + "&nombre=" + $('#filter_formacion_nombre').val() + "&user=" + $('#filter_formacion_users').val()+ "&yearuser=" + $('#filter_formacion_yearsuser').val());
            });
            $('#filter_formacion_nombre').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php?year=" + $('#filter_formacion_years').val() + "&nombre=" + $(this).val() + "&user=" + $('#filter_formacion_users').val()+ "&yearuser=" + $('#filter_formacion_yearsuser').val());
            });
            $('#filter_formacion_users').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php?year=" + $('#filter_formacion_years').val() + "&nombre=" + $('#filter_formacion_nombre').val() + "&user=" + $(this).val()+ "&yearuser=" + $('#filter_formacion_yearsuser').val());
            });
            $('#filter_formacion_yearsuser').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php?year=" + $('#filter_formacion_years').val() + "&nombre=" + $('#filter_formacion_nombre').val() + "&user=" + $('#filter_formacion_users').val() + "&yearuser=" + $(this).val());
            });
            $("#btn_save_doc_PER").click(function() {
                $("#btn_save_doc_PER").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_doc_PER").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveDocPER.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_doc_PER').trigger("reset");
                        $("#btn_save_doc_PER").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newdocPER_success").slideDown();
                        setTimeout(function(){
                            $("#newdocPER_success").fadeOut("slow");
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });    
            
            $("#btn_save_doc_CLI").click(function() {
                $("#btn_save_doc_CLI").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_doc_CLI").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveDocCLI.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_doc_CLI').trigger("reset");
                        $("#newdocCLI_organismo").val("");
                        $("#newdocCLI_periodicidades").val("");
                        $("#newdocCLI_organismo").selectpicker("refresh");
                        $("#newdocCLI_periodicidades").selectpicker("refresh");
                        $("#btn_save_doc_CLI").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardado');
                        $("#newdocCLI_success").slideDown();
                        setTimeout(function(){
                            $("#newdocCLI_success").fadeOut("slow");
                            //window.location.reload();
                            $("#btn_save_doc_CLI").html('Guardar');
                            $('#adddocCLI_model').modal('hide')
                            loadContent("doc-clientes-container", "/erp/apps/prevencion/vistas/doc-clientes.php?cliente_id=" + $('#contratistas_contratistas').val());
                        }, 2000);
                    }   
                });
            });
            $(document).on("click", "#btn_formacionTecnico_save" , function() {
            // $("#btn_formacionTecnico_save").click(function() { OLD CODE
                //console.log("Pasa algo. hAY QUE CHECKEAR CHECKEADOS!");
                // 
                //console.log($( ".pos-to-formacion-detalles:checked" ).length);
                $("#btn_formacionTecnico_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                // data = $("#frm_addTecnicoFormacion").serializeArray(); OLD CODE
                data = $("#frm_add_formaciones_tecnicos").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveFormacionDetalles.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $('#frm_proceso').trigger("reset");
                        $("#btn_proceso_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        setTimeout(function(){
                           //window.location.reload();
                           //console.log(response);
                           // MEJORA DE REFRESCO DE MODALS
                           $("#formacionDetalles_add_model").modal('hide');
                           loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php");
                        }, 1000);
                    }   
                });
            });
            $(document).on("click", ".remove-formacion-tecnico" , function() {
                //Mostrar Pop-Up
                $("#formacion_detalle_id").val($(this).data("id"));
                //console.log($(this).data("id"));
                //console.log($(this).parent("tr").data("id"));
                $("#delete_formacion_detalle_model").modal('show');
            });
            $("#btn_del_detalle_formacion").click(function() {
                $("#btn_del_detalle_formacion").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Borrando ...');
                //data = $("#frm_addTecnicoFormacion").serializeArray();
                //console.log("kk: "+$("#formacion_detalle_id").val());
                $.ajax({
                    type: "POST",  
                    url: "saveFormacionDetalles.php",  
                    data: {
                        del_tecnico_id: $("#formacion_detalle_id").val()
                        },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $('#frm_proceso').trigger("reset");
                        $("#btn_proceso_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#btn_formacionTecnicoTodos_save").click(function() {
                //console.log($("#addTecnicoFormacion").val());
                $("#btn_formacionTecnicoTodos_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_addTodosTecnicoFormacion").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveFormacionDetalles.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $('#frm_proceso').trigger("reset");
                        $("#btn_proceso_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        setTimeout(function(){
                           window.location.reload();
                           //console.log("Se han añadido todos: "+response);
                           // MEJORA DE REFRESCO DE MODALS
                           //$("#addTecnicoFormacion_adddoc_model").modal('hide');
                           //loadContent("container-calidad-formacion-detalles", "/erp/apps/calidad/vistas/calidad-formacion-detalles.php");
                        }, 1000);
                    }   
                });
            });
            $(document).on("click", ".remove-proceso" , function() {
                //Mostrar Pop-Up
                $("#del_proceso_id").val($(this).data("id"));
                //console.log($(this).data("id"));
                //console.log($(this).parent("tr").data("id"));
                $("#delete_proceso_model").modal('show');
            });
            $(document).on("click", "#btn_del_proceso", function(){
                $.ajax({
                    type: "POST",  
                    url: "saveProceso.php",  
                    data: {
                            proceso_delproceso: $("#del_proceso_id").val()
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            $(document).on("click", ".remove-indicador" , function() {
                //Mostrar Pop-Up
                $("#del_indicador_id").val($(this).data("id"));
                //console.log($(this).data("id"));
                //console.log($(this).parent("tr").data("id"));
                $("#delete_indicadores_model").modal('show');
            });
            $(document).on("click", "#btn_del_indicador", function(){
                $.ajax({
                    type: "POST",  
                    url: "saveIndicador.php",  
                    data: {
                            indicador_delindicador: $("#del_indicador_id").val()
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        loadContent("indicadores-container", "/erp/apps/calidad/vistas/procesos-indicadores.php");
                        //window.location.reload();
                        $("#delete_indicadores_model").modal('hide');
                    }   
                });
            });
            $(document).on("click", ".remove-conformidad" , function() {
                //Mostrar Pop-Up
                $("#del_conformidad_id").val($(this).data("id"));
                //console.log($(this).data("id"));
                //console.log($(this).parent("tr").data("id"));
                $("#delete_conformidad_model").modal('show');
            });
            $(document).on("click", "#btn_del_conformidad", function(){
                $.ajax({
                    type: "POST",  
                    url: "saveConformidad.php",  
                    data: {
                            conformidad_delconformidad: $("#del_conformidad_id").val()
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        loadContent("conformidades-container", "/erp/apps/calidad/vistas/calidad-conformidades.php");
                        //window.location.reload();
                        $("#delete_conformidad_model").modal('hide');
                    }   
                });
            });
            $(document).on("click", ".remove-acta" , function() {
                //Mostrar Pop-Up
                $("#del_acta_id").val($(this).data("id"));
                //console.log($(this).data("id"));
                //console.log($(this).parent("tr").data("id"));
                $("#delete_acta_model").modal('show');
            });
            $(document).on("click", ".remove-calibraciones" , function() {
                //Mostrar Pop-Up
                $("#del_calibraciones_id").val($(this).data("id"));
                //console.log($(this).data("id"));
                //console.log($(this).parent("tr").data("id"));
                $("#delete_calibraciones_model").modal('show');
            });
            $(document).on("click", "#btn_del_acta", function(){
                $.ajax({
                    type: "POST",  
                    url: "saveActa.php",  
                    data: {
                           acta_delacta: $("#del_acta_id").val()
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        loadContent("actas-container", "/erp/apps/calidad/vistas/calidad-actas.php");
                        //window.location.reload();
                        $("#delete_acta_model").modal('hide');
                    }   
                });
            });
            $(document).on("click", "#btn_del_calibracion", function(){
                $.ajax({
                    type: "POST",  
                    url: "saveCalibraciones.php",  
                    data: {
                           calibraciones_delcalibraciones: $("#del_calibraciones_id").val()
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        loadContent("calibraciones-container", "/erp/apps/calidad/vistas/calidad-calibraciones.php");
                        //window.location.reload();
                        $("#delete_calibraciones_model").modal('hide');
                    }   
                });
            });
           $(document).on("click", ".remove-formacion" , function() {
                //Mostrar Pop-Up
                $("#del_formacion_id").val($(this).data("id"));
                //console.log($(this).data("id"));
                //console.log($(this).parent("tr").data("id"));
                $("#delete_formacion_model").modal('show');
            });
            $(document).on("click", "#btn_del_formacion", function(){
                //console.log("kk: "+$("#del_formacion_id").val());
                $.ajax({
                    type: "POST",  
                    url: "saveFormacion.php",  
                    data: {
                           acta_delformacion: $("#del_formacion_id").val()
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        loadContent("formacion-container", "/erp/apps/calidad/vistas/calidad-formacion.php");
                        //window.location.reload();
                        $("#delete_formacion_model").modal('hide');
                    }   
                });
            });
            $("#btn_del_plantilla").click(function() {
                $("#btn_del_plantilla").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#newplantilla_delplan").val($("#newplantilla_idplan").val());
                data = $("#frm_new_plantilla").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "savePlantilla.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_new_plantilla').trigger("reset");
                        window.location.href = "/erp/apps/plantillas/";
                    }   
                });
            });
            // Combo box de Fráficos Indicadores
            $('#opcion-grafico-indicador').on('change', function() {
                if($('#opcion-grafico-indicador').val()==6){
                    pintarGrafico6();
                    $('#grafico-indicadores5').hide();
                    $('#grafico-indicadores6').show();
                }
                if($('#opcion-grafico-indicador').val()==5){
                    pintarGrafico5();
                    $('#grafico-indicadores5').show();
                    $('#grafico-indicadores6').hide();
                }
            });
            // Refrescar gráficas
            $('#refresh-graficos').on('click', function() {
                if($('#opcion-grafico-indicador').val()==6){
                    pintarGrafico6();
                    $('#grafico-indicadores5').hide();
                    $('#grafico-indicadores6').show();
                }
                if($('#opcion-grafico-indicador').val()==5){
                    pintarGrafico5();
                    $('#grafico-indicadores5').show();
                    $('#grafico-indicadores6').hide();
                }    
            });
	});
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
        function pintarGrafico6(){
            $.ajax({
                    type: "POST",  
                    url: "vistas/indicadores-grafico.php",  
                    data: {
                        indicador_id: $("#opcion-grafico-indicador").val()
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        var chart = new CanvasJS.Chart("grafico-indicadores6", {
                            animationEnabled: true,
                            title: {
                                    text: "% Ofertas aceptadas"
                            },
                            axisY: {
                                    title: "Valores"
                            },
                            axisX: {
                                    title: "Años"
                            },
                            legend:{
                                    cursor: "pointer",
                                    fontSize: 16,
                                    itemclick: toggleDataSeries
                            },
                            toolTip:{
                                shared: true
                            },
                            data: response
                        });
                        //console.log(response);
                        //console.log(<?php echo json_encode($objetivePoints6, JSON_NUMERIC_CHECK); ?>);
                        chart.render();
                    }   
                });
        }
        function pintarGrafico5(){
            $.ajax({
                    type: "POST",  
                    url: "vistas/indicadores-grafico.php",  
                    data: {
                        indicador_id: $("#opcion-grafico-indicador").val()
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        var chart = new CanvasJS.Chart("grafico-indicadores5", {
                            animationEnabled: true,
                            title: {
                                    text: "Nº contratos nuevos mantto."
                            },
                            axisY: {
                                    title: "Valores"
                            },
                            axisX: {
                                    title: "Años"
                            },
                            legend:{
                                    cursor: "pointer",
                                    fontSize: 16,
                                    itemclick: toggleDataSeries
                            },
                            toolTip:{
                                shared: true
                            },
                            data: response
                        });
                        //console.log(response);
                        chart.render();
                        
                    }   
                });
        }
        function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
            }
            else{
                    e.dataSeries.visible = true;
            }
            chart.render();
        }

	
</script>

<title>CALIDAD | Erp GENELEK</title>
</head>

<body>
    <div id="cover">
        <div class="box">
            <img src="/erp/img/logo.png" class="spinnerlogo">
            <img src="/erp/img/loading.gif" class="spinner">
        </div>
    </div>
    <!--rest of the page... -->
    <? include($pathraiz."/includes/header.php"); ?>
    
    <section id="contenido">
        <div id="erp-titulo" class="one-column">
            <h3>
                CALIDAD
            </h3>
        </div>
        <div id="dash-header">
            <div  class="one-column" style="height: 420px !important;">
                <h4 class="dash-title">
                    SISTEMA DE CALIDAD
                    <? include($pathraiz."/apps/calidad/includes/tools-calidad.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="doc-admon-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/calidad/vistas/calidad-sistema.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div  class="one-column" style="height: 70px;">
                <ul class="nav navbar-nav">
                    <li id="menuitem-procesos"><a href="" >PROCESOS</a></li>
                    <li id="menuitem-conformidades"><a href="" >NO CONFORMIDADES</a></li>
                    <li id="menuitem-indicadores"><a href="">INDICADORES</a></li>
                    <li id="menuitem-actas"><a href="" >ACTAS</a></li>
                    <li id="menuitem-calibraciones"><a href="" >CALIBRACIONES</a></li>
                    <li id="menuitem-formacion"><a href="" >FORMACIÓN</a></li>
                </ul>
            </div>
            <div class="one-column" id="item-procesos">
                <h4 class="dash-title">
                    PROCESOS
                    <? include($pathraiz."/apps/calidad/includes/tools-procesos.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="procesos-container">
                    <? include($pathraiz."/apps/calidad/vistas/calidad-procesos.php"); ?>
                </div>
            </div>
            <!-- <span class="stretch"></span> -->
            <div class="one-column" id="item-indicadores" style="display: none;">
                <h4 class="dash-title">
                    <span id="titulo-indicadores">INDICADORES</span>
                    <? include($pathraiz."/apps/calidad/includes/tools-indicadores.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="indicadores-container">
                    <? //include($pathraiz."/apps/prevencion/vistas/admon.php"); ?>
                </div>
                <hr class="dash-underline">
                <div id="indicadores-container-detalle">
                    <? //include($pathraiz."/apps/calidad/vistas/procesos-indicadores-detalles.php"); ?>
                </div>
            </div>
            <div class="one-column" id="item-indicadores-grafico" style="display: none;">
                <div class="dash-title" id="control-grafico">
                    <? include($pathraiz."/apps/calidad/includes/tools-indicadores-grafico.php"); ?>
                </div>
                <hr class="dash-underline">
                <div id="grafico-indicadores6" style="height: 420px; width: 100%;"></div>
                <div id="grafico-indicadores5" style="height: 420px; width: 100%;"></div>
                <? //include($pathraiz."/apps/calidad/vistas/indicadores-grafico.php"); ?>
            </div>
            <!-- <span class="stretch"></span> -->
            <div class="one-column" id="item-conformidades" style="display: none;">
                <h4 class="dash-title">
                    NO CONFORMIDADES
                    <? include($pathraiz."/apps/calidad/includes/tools-conformidades.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="conformidades-container" >
                    <?  
                        //include($pathraiz."/apps/prevencion/vistas/admon.php"); ?>
                </div>
            </div>
            <!-- <span class="stretch"></span> -->
            <div class="one-column" id="item-actas" style="display: none;">
                <h4 class="dash-title">
                    ACTAS
                    <? include($pathraiz."/apps/calidad/includes/tools-actas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="actas-container">
                    <? //include($pathraiz."/apps/calidad/vistas/calidad-actas.php"); ?>
                </div>
            </div>
            <!-- <span class="stretch"></span> -->
            <div class="one-column" id="item-formacion" style="display: none;">
                <h4 class="dash-title">
                    FORMACIÓN
                    <? include($pathraiz."/apps/calidad/includes/tools-formacion.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="formacion-container">
                    <? //include($pathraiz."/apps/calidad/vistas/calidad-formacion.php"); ?>
                </div>
            </div>
            <!-- <span class="stretch"></span> -->
            <div class="one-column" id="item-calibraciones" style="display: none;">
                <h4 class="dash-title">
                    CALIBRACIONES
                    <? include($pathraiz."/apps/calidad/includes/tools-calibraciones.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="calibraciones-container">
                    <? //include($pathraiz."/apps/calidad/vistas/calidad-actas.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
</body>
</html>