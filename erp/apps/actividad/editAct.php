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
            //aqui hago una select para verificar el tipo de usuario que es los proyectos a los que tiene acceso
    }
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

<!-- Editor -->
<script src='/erp/includes/plugins/tinymce/js/tinymce/tinymce.min.js'></script>

<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-es_ES.js"></script>

<!-- Bootstrap Treeview
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
    -->
    <link rel="stylesheet" href="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.js"></script>


<!-- CHARTS -->
    <script src="/erp/includes/plugins/chart/dist/Chart.bundle.js"></script>
    <!--<script src="includes/chart/dist/Chart.bundle.min.js"></script>-->

<!-- Add fancyBox -->
    <link rel="stylesheet" href="/erp/includes/plugins/fancybox/source/jquery.fancybox.css?v=2.1.7" type="text/css" media="screen" />
    <script type="text/javascript" src="/erp/includes/plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.7"></script>
    
<!-- custom js -->
<script src="/erp/functions.js"></script>

<!-- Bootstrap switch -->
<link href="/erp/plugins/bootstrap-switch.min.css" rel="stylesheet">
<script src="/erp/plugins/bootstrap-switch.min.js"></script>

<!-- File input -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="/erp/includes/plugins/fileinput/js/locales/es.js"></script>

<style>
    .mce-container {
        z-index: 999999 !important;
    }
</style>

<title id="act-title">Actividad | Erp GENELEK</title>
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
        <div class="form-group">
            <h5><a href="/erp/apps/actividad/">Actividad / Internvención</a> > <span id="current-page"></span></h5>
        </div>
        <div id="erp-titulo" class="one-column">
            <h3 id="act-titulo">
                ACTIVIDAD xxxx
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-datosgenerales-add" class="three-column-two-merged" style="min-height: 370px;">
                <h4 class="dash-title">
                    DATOS GENERALES <? include($pathraiz."/apps/actividad/includes/tools-single-act.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/act-datosgenerales.php"); 
                ?>
            </div>
            <div id="dash-resumen-ventas" class="three-column box-info" style="background-color: transparent; min-height: 370px;">
                <div id="dash-cliente" class="one-column">
                    <h4 class="dash-title">
                        CLIENTE
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/act-cliente.php");  
                    ?>
                </div>
                <div id="dash-proyecto" class="one-column">
                    <h4 class="dash-title">
                        PERTENECIENTE AL ELEMENTO
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/act-proyecto.php");  
                    ?>
                </div>
                
                <div id="dash-subcontrata-add" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTOS 
                        <? include($pathraiz."/apps/actividad/includes/tools-documentos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="treeview_json">
                        <? //include($pathraiz."/apps/material/vistas/pedido-documentos.php"); ?>
                    </div>
                </div>
            </div>
            
            <span class="stretch"></span>
            
            <div id="dash-detalles-add" class="one-column">
                <h4 class="dash-title">
                    TIMELINE DE LA ACTIVIDAD/TAREA
                    <? include($pathraiz."/apps/actividad/includes/tools-detalles-act.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="div-tareas">
                <? 
                    $fechamod = 1;
                    //include("vistas/act-detalles.php"); 
                ?>
                </div>
            </div>
            
            <span class="stretch"></span>
            
            <div id="dash-detalles-add" class="one-column">
                <h4 class="dash-title">
                    FINALIZACIÓN
                    <? include($pathraiz."/apps/actividad/includes/tools-single-act-fin.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/act-finalizacion.php"); 
                ?>
            </div>
            
            <span class="stretch"></span>
        </div>
    </section>
</body>
</html>

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            tinymce.init({
                selector: '.textarea-cp',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                },
                editor_deselector : "mceNoEditor",
                height: 250,
                width : '100%',
                autoresize_max_width: 600,
                theme: 'modern',
                plugins: [
                      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                      'searchreplace wordcount visualblocks visualchars code fullscreen',
                      'insertdatetime media nonbreaking save table contextmenu directionality',
                      'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager ',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
                relative_urls: false,
                image_advtab: true ,
                external_filemanager_path:"/erp/includes/plugins/filemanager/",
                filemanager_title:"Gestor de imágenes para ACTIVIDAD/INTERVENCIONES" ,
                external_plugins: { "filemanager" : "/erp/includes/plugins/filemanager/plugin.min.js"},
                templates: [
                      { title: 'Test template 1', content: 'Test 1' },
                      { title: 'Test template 2', content: 'Test 2' }
                ],
                content_css: [
                      '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                      '//www.tinymce.com/css/codepen.min.css'
                ]
            });
            
            $("#menuitem-actividad").addClass("active");
            
            $("#uploaddocs").fileinput({
                uploadUrl: "upload.php?actpath=" + $("#act_edit_path").val() + "&id_act=<? echo $_GET['id']; ?>",
                dropZoneEnabled: true,
                maxFileCount: 500, 
                language: "es"
            });
            console.log("path::::"+$("#act_edit_path").val());
            filesUpload = [];
            
            $('#uploaddocs').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    pathFile: data.response.uploaded,
                    nombre: $("#actividad_docnombre").val(),
                    descripcion: $("#actividad_docdesc").val(),
                    act_id: <? echo $_GET['id'] ?> 
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
                
            });
            
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            // ######## LOAD SELECTS #######
            loadSelectActividadUser("actdetalle_tecnicos",<? echo $_GET["id"]; ?>);
            //loadSelect("actdetalle_tecnicos","erp_users","id","","", "apellidos");
            
            loadSelect("act_edit_categorias","ACTIVIDAD_CATEGORIAS","id","","","");
            loadSelect("act_edit_tareas","TAREAS","id","","","");
            loadSelect("act_edit_mantenimientos","PROYECTOS","id","tipo_proyecto_id","2","ref");
            loadSelect("act_edit_proyectos","PROYECTOS","id","tipo_proyecto_id","1","ref");
            loadSelect("act_edit_ofertas","OFERTAS","id","","","ref");
            loadSelect("act_edit_prior","ACTIVIDAD_PRIORIDADES","id","","","");
            loadSelect("act_edit_clientes","CLIENTES","id","","","");
            loadSelect("act_edit_estados","ACTIVIDAD_ESTADOS","id","","","");
            loadSelect("act_edit_estados_fin","ACTIVIDAD_ESTADOS","id","","","");
            loadSelect("act_edit_responsable","erp_users","id","empresa_id","1","apellidos","activo","'on'","",0); // Selecciona los trabajadores activos
            //loadSelect("act_edit_responsable","erp_users","id","","","apellidos"); // Selecciona todos los trabajadores
            loadSelect("act_edit_tecnicos","erp_users","id","","","apellidos");
            loadSelectActividadUser("actdetallehoras_tecnicos",<? echo $_GET["id"]; ?>);
            //loadSelect("actdetallehoras_tecnicos","erp_users","id","","","apellidos");
            loadSelect("actdetallehoras_tipo","PERFILES_HORAS","id","perfil_id",$("#act_edit_tarea_perfilid").val(),"");
            loadSelect("act_edit_instalacion","CLIENTES_INSTALACIONES","id","cliente_id",<? echo $idcli; ?>,"");
            loadSelect("actdetalle_completado","ACTIVIDAD_DETALLES_ESTADOS","id","","","");
            
            loadContent("div-tareas", "/erp/apps/actividad/vistas/act-detalles.php?id="+<? echo $_GET["id"]; ?>); // Cargar las tareas de la actividad
            
            
            setTimeout(function(){
                $("#actdetalle_tecnicos").selectpicker("val", "<? echo $_SESSION['user_session']; ?>");
                $("#actdetallehoras_tecnicos").selectpicker("val", "<? echo $_SESSION['user_session']; ?>");
            }, 4000);
            
            $('input[name="act_edit_chkimputable"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            $('input[name="act_edit_chkfacturable"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            // ######## OPEN MODALS #######
            $("#add-detalleact").click(function() {
                $('#frm_edit_actdetalle').trigger("reset");
                $("#actdetalle_detalle_id").val("");
                //console.log("Seleccionado: "+ $("#act_edit_tecnicos").val() + $("#act_edit_tecnicos").find("option:selected").text());
                $("#actdetalle_tecnicos").selectpicker("val", $("#act_edit_tecnicos").val());
                $("#bloque-horas").hide();
                $("#detalleact_add_model").modal('show');
            });
            $("#add-detalleact-horas").click(function() {
                $('#frm_edit_actdetalle_horas').trigger("reset");
                $("#detalleact_horas_add_model").modal('show');
            });
            $("#add-documento").click(function() {
                $("#detalleact_adddoc_model").modal('show');
            });
            $("#edit_act").click(function() {
                //$('#act_edit_addtecnicos').empty();
                $("#act-view").hide();
                $("#act-edit").show();
            });
            $("#edit_act_fin").click(function() {
                $("#act-fin-view").hide();
                $("#act-fin-edit").show();
            });
            $("#cancel_act").click(function() {
                $("#act-view").show();
                $("#act-edit").hide();
            });
            $("#cancel_act_fin").click(function() {
                $("#act-fin-view").show();
                $("#act-fin-edit").hide();
            });
            
            // ######## SAVE GENERAL #######
            $("#act_edit_btn_save").click(function() {
                $("#act_edit_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#act_edit_addtecnicos option").prop("selected", true);
                data = $("#frm_editact").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveAct.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        //alert(response);
                        //$('#frm_editact').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            $("#act_fin_edit_btn_save").click(function() {
                $("#act_fin_edit_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_editact_fin").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveAct.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        //alert(response);
                        //$('#frm_editact').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            $("#dupli_act").click(function() {
                $("#dupli_act_id").val(<? echo $_GET["id"]; ?>);
                $("#confirm_dupli_act_modal").modal("show");
            });
            $("#btn_dupli_act").click(function() {
                console.log("Seleccionado: "+$("#dupli_act_id").val());
                $.ajax({
                    type: "POST",  
                    url: "saveAct.php",  
                    data: {
                        dupli_act_id : $("#dupli_act_id").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log("response: "+response);
                        window.open("/erp/apps/actividad/editAct.php?id="+response,'_blank');
                        window.location.reload();
                    }   
                });
            });
            // ENVIAR NOTIFICACIÓN
            $("#notificacion_act").click(function() {
                $("#notificacion_act_modal").modal("show");
            });
            $("#btn_notificacion_act").click(function() {
                console.log("Botón enviar pulsado");
                var idActividad = <? echo $_GET['id']; ?>;
                $.ajax({
                    type: "POST",  
                    url: "enviarNotificacion.php",  
                    data: {
                        idActividad: idActividad,
                        msgNotificacion : $("#textarea_mensaje").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log("response: "+response);
                        console.log("Se ha enviado la notificación vía mail.");
                        //window.location.reload();
                        if(response==1){
                            $("#act_not_success").fadeOut("slow");
                        }else{
                            $("#act_not_error").fadeOut("slow");
                        }
                        setTimeout(function(){
                            $("#act_not_success").fadeOut("slow");                             
                            // Realizar comprobaciones!!
                            if(response==1){
                                $("#act_not_success").slideDown();
                            }else{
                                $("#act_not_error").slideDown();
                            }
                        }, 1000);
                        setTimeout(function(){
                            $("#textarea_mensaje").val("");
                            $("#act_not_success").hide();
                            $("#act_not_error").hide();
                            $("#notificacion_act_modal").modal("hide");
                        }, 2500);
                    }   
                });
            });
            
            $("#btn_add_tec").click(function() {
                console.log("Seleccionado: "+ $("#act_edit_tecnicos").val() + $("#act_edit_tecnicos").find("option:selected").text());
                $("#div_act_edit_addtecnicos").find("select").append($('<option>', {value:$("#act_edit_tecnicos").val(), text:$("#act_edit_tecnicos").find("option:selected").text()}));
                //$('#act_edit_addtecnicos').append($('<option>', {value:$("#act_edit_tecnicos").val(), text:$("#act_edit_tecnicos").find("option:selected").text()}));
            });
            $("#btn_clear_tec").click(function() {
                console.log("Seleccionado: "+ $("#act_edit_tecnicos").val() + $("#act_edit_tecnicos").find("option:selected").text());
                $("#div_act_edit_addtecnicos").find("select").find("option:selected").remove();
                //$('#act_edit_addtecnicos option:selected').remove();
            });
            
            // ######## DELETE ACTIVIDAD GENERAL #######
            $("#delete_act").click(function() {
                // Modal confirmacion
                $("#confirm_del_act_modal").modal("show");
            });
            $("#btn_delete_act").click(function() {
                $("#delete_act").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#act_edit_delact").val($("#act_edit_idact").val());
                data = $("#frm_editact").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "saveAct.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_editact').trigger("reset");
                        window.location.href = "/erp/apps/actividad/";
                    }   
                });
            });
            
            // REFRESH TAREAS
            $(document).on("click", "#refresh_tareas" , function() {
                loadContent("div-tareas", "/erp/apps/actividad/vistas/act-detalles.php?id="+<? echo $_GET["id"];?>);
//                $.ajax({
//                            type: "GET",  
//                            url: "vistas/act-detalles-reload.php",  
//                            data: {
//                                act_id: <? echo $_GET["id"];?>
//                            },
//                            dataType: "text",       
//                            success: function(response2)  
//                            {
//                                console.log("response2: "+response2);
//                                $("#div-tareas").html(response2);
//                            }   
//                        });
            });
            
            // ######## SAVE DETALLES #######
            $("#btn_actdetalle_save").click(function() {
                //alert($("#enviodetalle_detalle_id").val());
                $("#btn_actdetalle_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                tinymce.triggerSave();
                data = $("#frm_edit_actdetalle").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveActDetalle.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_edit_actdetalle').trigger("reset");
                        $("#btn_actdetalle_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#detalleact_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        // Mejorar refresh del timeline/tareas
                        
                        
                        loadContent("div-tareas", "/erp/apps/actividad/vistas/act-detalles.php?id="+<? echo $_GET["id"];?>);
                        
                        
//                        $.ajax({
//                            type: "GET",  
//                            url: "vistas/act-detalles-reload.php",  
//                            data: {
//                                act_id: <? //echo $_GET["id"];?>
//                            },
//                            dataType: "text",       
//                            success: function(response2)  
//                            {
//                                console.log("response2: "+response2);
//                                $("#div-tareas").html(response2);
//                            }   
//                        });
                        
                        //window.location.reload();
                    }   
                });
            });
            
            $("#btn_actdetallehoras_save").click(function() {
                //alert($("#enviodetalle_detalle_id").val());
                $("#btn_actdetallehoras_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_edit_actdetallehoras_horas").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "saveHoras.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        //alert(response);
                        //$('#frm_edit_actdetallehoras_horas').trigger("reset");
                        $("#btn_actdetallehoras_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#actdetallehoras_cantidad").val("0");
                        //$("#intdetalle_H820").val("0"); 
                        //$("#intdetalle_H208").val("0");
                        //$("#intdetalle_Hviaje").val("0");
                        //$("#intdetalle_costeH820").val("0");
                        //$("#intdetalle_costeH208").val("0");
                        $("#actdetallehoras_tipo").val("");
                        $("#actdetallehoras_tipo").selectpicker("refresh");
                        $("#actdetallehoras_tecnicos").val("");
                        $("#actdetallehoras_tecnicos").selectpicker("refresh");
                        $("#detalleact_horas_add_model").modal('hide');
                        //window.location.reload();
                        loadContent("tabla-horas", "/erp/apps/actividad/vistas/actdetalles-horas.php?det_id=" + $("#actdetalle_detalle_id").val());
                    }   
                });
            });
            
            // ######## DELETE DETALLES #######
            $(document).on("click", "#btn_confirmar_del_tarea" , function() {
            //$(".remove-detalle").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveActDetalle.php',
                    dataType : 'text',
                    data: {
                        actdetalle_deldetalle : $("#del_tarea_id").val()
                    },
                    success : function(data){
                        //alert(data);
                        //console.log("ok");
                        $("#confirm_del_tarea").modal('hide');
                        loadContent("div-tareas", "/erp/apps/actividad/vistas/act-detalles.php?id="+<? echo $_GET["id"]; ?>);
                        //window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // COnfirmacion del detalle
            $(document).on("click", ".remove-detalle" , function() {
                $("#del_tarea_id").val($(this).data("id"));
                $("#confirm_del_tarea").modal("show");
            });
            
            $(document).on("click", ".remove-detalle-horas" , function() {
                $("#del_tarea_hora_id").val($(this).data("id"));
                $("#confirm_del_tarea_hora").modal("show");
            });
            $(document).on("click", "#btn_confirmar_del_tarea_hora" , function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveHoras.php',
                    dataType : 'text',
                    data: {
                        actdetallehoras_delhora : $("#del_tarea_hora_id").val()
                    },
                    success : function(data){
                        //alert(data);
                        //console.log("ok");
                        $("#confirm_del_tarea_hora").modal("hide");
                        loadContent("tabla-horas", "/erp/apps/actividad/vistas/actdetalles-horas.php?det_id=" + $("#actdetalle_detalle_id").val());
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // Confirmacion del detalle documento
            $(document).on("click", "#btn_confirmar_del_doc" , function() {
                $.ajax({
                    type : 'POST',
                    url : 'processUpload.php',
                    dataType : 'text',
                    data: {
                        delDoc : $("#del_doc_id").val()
                    },
                    success : function(data){
                        //alert(data);
                        //console.log("ok");
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // Confirmacion del doc
            $(document).on("click", ".delDoc" , function() {
                $("#del_doc_id").val($(this).data("id"));
                $("#confirm_del_doc_modal").modal("show");
            });
            
            // ######## EDIT DETALLES #######
            $(document).on("click", "#tabla-detalles-act tr > td:not(:nth-child(1)):not(:nth-child(6))" , function() {
            //$("#tabla-detalles-act tr > td:not(:nth-child(5))").click(function() {
                loadActDetalleInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#detalleact_add_model").modal('show');
            });
            $(document).on("dblclick", "#tabla-detalles-act tr > td:nth-child(1)" , function() {
                console.log("dobleclick");
                $.ajax({
                    type : 'POST',
                    url : 'saveActDetalle.php',
                    dataType : 'text',
                    data: {
                        actdetalle_estado_id : $(this).parent("tr").data("id")
                    },
                    success : function(data){
                        //alert(data);
                        console.log("ok");
                        loadContent("div-tareas", "/erp/apps/actividad/vistas/act-detalles.php?id="+<? echo $_GET["id"]; ?>);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", ".stat-tarea" , function() {
                console.log("Click en span: ");
            });
            
            $(document).on("click", "#add-instalacion" , function() {
                $("#nombre_cliente").val($("#act_edit_clientes option:selected").text());
                $("#addinstalacion_model").modal("show");
            });
            $(document).on("click", "#btn_add_instalacion" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveInstalacion.php",  
                    data: {
                        clienteid: $("#act_edit_clientes").val(),
                        instalacionnombre: $("#nombre_instalacion").val(),
                        instalaciondireccion: $("#direccion_instalacion").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log("response: "+response);
                        //window.open("/erp/apps/entregas/view.php?id="+response,"_blank");
                        loadSelect("act_edit_instalacion","CLIENTES_INSTALACIONES","id","cliente_id",<? echo $idcli; ?>,"");
                        $("#act_edit_instalacion").selectpicker('refresh');
                        $("#addinstalacion_model").modal("hide");
                        //window.location.reload();
                    }   
                });
            });
            ///// SIMPLE 50% OK
            /*
            $("#print_act").click(function() {
                window.open(
                    "printAct.php?id=<? //echo $_GET['id']; ?>",
                    '_blank' 
                );
            });
            */
            $("#print_act").click(function() {
                $("#print_act").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Imprimiendo ...');
                $('#cover').fadeIn('slow');
                $.post('includes/print_pdf.php', 
                { 
                    id: <? echo $_GET['id']; ?>
                })
                .done(function( data ) {
                    //alert(data);
                    //alert("file://192.168.3.108/" + data);
                    $("#print_act").html('<img src="/erp/img/print.png" height="30">');
                    $('#cover').fadeOut('slow').delay(1000);
                    /*
                     $("#print_success").slideDown();
                    setTimeout(function(){
                        $("#categorias_success").fadeOut("slow");
                        //console.log(response[0].id);
                        window.location.reload();
                    }, 2000);
                    */
                    if (data != "error") {
                        window.open(
                            data,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                        console.log(data);
                        window.location.reload();
                    }
                    else {
                        
                    }       
                }); 
            });
            
            // CARGA DEL ARBOL DE DOCUMENTOS
                var treeData;

                console.log("start");
                $.ajax({
                    type: "GET",  
                    url: "responseDocs.php",
                    data: {
                        id: <? echo $_GET["id"]; ?>
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                          console.log("ok");
                          initTree(response, "treeview_json");
                    }   
                });

                function initTree(treeData, treeElement) {
                    //console.log(treeData);
                    $('#' + treeElement).treeview({
                        data: treeData,
                        enableLinks: true,
                        state: {
                            checked: true,
                            disabled: true,
                            expanded: true,
                            selected: true
                        },
                    });
                }
        });
	
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>