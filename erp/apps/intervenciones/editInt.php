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

<title id="int-title">Intervenciones | Erp GENELEK</title>
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
            <h5><a href="/erp/apps/intervenciones/">Intervenciones</a> > <span id="current-page"></span></h5>
        </div>
        <div id="erp-titulo" class="one-column">
            <h3 id="int-titulo">
                INTERVENCIÓN xxxx
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-datosgenerales-add" class="three-column" style="min-height: 370px;">
                <h4 class="dash-title">
                    DATOS GENERALES <? include($pathraiz."/apps/intervenciones/includes/tools-single-int.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/int-datosgenerales.php"); 
                ?>
            </div>
            <div id="dash-grafico-costes" class="three-column box-info" style="min-height: 370px;">
                <h4 class="dash-title">
                    CLIENTE
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/int-cliente.php"); 
                ?>
            </div>
            <div id="dash-resumen-ventas" class="three-column box-info" style="background-color: transparent; min-height: 370px;">
                <div id="dash-proyecto" class="one-column">
                    <h4 class="dash-title">
                        PERTENECIENTE AL PROYECTO
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/int-proyecto.php");  
                    ?>
                </div>
                
                <div id="dash-subcontrata-add" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTOS 
                        <? include($pathraiz."/apps/intervenciones/includes/tools-documentos.php"); ?>
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
                    DETALLES DE LA INTERVENCIÓN
                    <? include($pathraiz."/apps/intervenciones/includes/tools-detalles-int.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/int-detalles.php"); 
                ?>
            </div>
            
            <span class="stretch"></span>
            
            <div id="dash-materiales-add" class="one-column">
                <h4 class="dash-title">
                    MATERIAL AFECTADO
                    <? include($pathraiz."/apps/intervenciones/includes/tools-material-int.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/int-material.php"); 
                ?>
            </div>
            
            <div id="dash-hora-add" class="one-column">
                <h4 class="dash-title">
                    HORAS IMPUTADAS A LA INTERVENCIÓN
                    <? include($pathraiz."/apps/intervenciones/includes/tools-horas-imp.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    include("vistas/int-horas-imp.php"); 
                ?>
            </div>
            
            <span class="stretch"></span>
        </div>
    </section>
    <div id="prueba">
        
    </div>
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
                filemanager_title:"Gestor de imágenes para INTERVENCIONES" ,
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
           
            $("#menuitem-intervenciones").addClass("active");
            
            $("#uploaddocs").fileinput({
                uploadUrl: "upload.php?intpath=" + $("#int_edit_path").val() + "&id_int=<? echo $_GET['id']; ?>",
                dropZoneEnabled: true,
                maxFileCount: 500, 
                language: "es"
            });
            
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
                    nombre: $("#intetalle_docnombre").val(),
                    descripcion: $("#intdetalle_docdesc").val(),
                    int_id: <? echo $_GET['id'] ?> 
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
                
            });
            
            $('input[name="int_edit_chkfacu"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            // ######## LOAD SELECTS #######
            loadSelect("int_edit_clientes","CLIENTES","id","","","");
            loadSelect("int_edit_ofertas","OFERTAS","id","","","ref");
            loadSelect("int_edit_proyectos","PROYECTOS","id","","","ref");
            loadSelect("int_edit_tecnicos","erp_users","id","","","apellidos");
            loadSelect("int_edit_tecnicossel","erp_users","id","","","apellidos");
            loadSelect("int_edit_estados","INTERVENCIONES_ESTADOS","id","","","");
            loadSelect("horas_tareas","TAREAS","id","","", "perfil_id");
            loadSelect("horas_tecnicos","erp_users","id","","", "apellidos");
            loadSelect("intmaterial_materiales","SERIAL_NUMBERS","id","","", "");
            
            loadSelectTecnicos("intdetalle_tecnicos","INTERVENCIONES_TECNICOS","id","int_id",<? echo $_GET['id']; ?>);
            
            $('input[name="edit_chkrecibido"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            //loadOferta(<? //echo $_GET['id']; ?>);
            
            // ######## OPEN MODALS #######
            $("#add-detalleint").click(function() {
                $('#frm_edit_intdetalle').trigger("reset");
                $("#intdetalle_horas").val("");
                $("#intdetalle_detalle_id").val("");
                $("#intdetalle_tecnicos").val("");
                $("#cuadro-horas").hide();
                $("#detalleint_add_model").modal('show');
            });
            $("#edit_int").click(function() {
                $("#int-view").hide();
                $("#int-edit").show();
            });
            $("#add-material").click(function() {
                $("#selectmaterial_model").modal('show');
            });
            $("#add-documento").click(function() {
                $("#detalleint_adddoc_model").modal('show');
            });
            $("#duplicar_int").click(function() {
                $("#int_duplicar_model").modal('show');
            });
            $("#add-horas").click(function() {
                $("#horas_add_model").modal('show');
            });
            $("#add-material").click(function() {
                $("#selectmaterial_model").modal('show');
            });
            
            // ######## SELECTS CHANGE EVENTS #######
            $("select.enviodetalle_categorias").on("changed.bs.select", function (e) { 
                var numCat = $("select.enviodetalle_categorias").length + 1;
                console.log("num elementos " + numCat);
                for (i = 1; i < numCat; i++) {
                    if (i != 1) {
                        console.log("delete " + numCat);
                        $("#enviodetalle_categorias" + i).selectpicker("destroy");
                        $("#enviodetalle_categorias" + i).closest(".form-group").remove();
                    }
                }
                
                var numCat = $("select.enviodetalle_categorias").length + 1;
                var htmlElement = "<div class='form-group'><label class='labelBeforeBlack'></label><select id='enviodetalle_categorias" + numCat + "' name='enviodetalle_categorias" + numCat + "' class='selectpicker enviodetalle_categorias' data-live-search='true' data-width='33%'><option></option></select></div>"
                $("select.enviodetalle_categorias").last().closest(".form-group").after(htmlElement);
                
                loadSelect("enviodetalle_categorias" + numCat,"MATERIALES_CATEGORIAS","id","parent_id",$(this).val());
                $("#enviodetalle_categorias" + numCat).selectpicker('render');
                $("#enviodetalle_categorias" + numCat).selectpicker('refresh');
            });
            $("body").on('change',"select.enviodetalle_categorias", function(){
                //alert("ok");  
                loadSelect("enviodetalle_materiales","MATERIALES","id","categoria_id",$(this).val(),"");
            });
            $("#enviodetalle_materiales").on("changed.bs.select", function (e) {
                //loadPedidoDetalleInfo($(this).val(), "MATERIALES");
                loadEnvioMaterialInfo($(this).val(), "MATERIALES", "");
            });
            
            $("#enviodetalle_precios").on("changed.bs.select", function (e) {
                //Cargar el precio seleccionado en el textbox enviodetalle_preciomat
                var selectedText = $(this).find("option:selected").text();
                var selectedTextSplit = selectedText.split("/");
                selectedtext = selectedTextSplit[0].replace("€","");
                selectedtext = selectedtext.trim();
                $("#enviodetalle_preciomat").val(selectedtext);
                selectedtext = selectedTextSplit[2].replace("%","");
                selectedtext = selectedtext.trim();
                $("#enviodetalle_dtomat").val(selectedtext);
            });
            $("#intdetalle_tecnicos").on("changed.bs.select", function (e) {
                loadCuadroHoras($(this).val(), $("#intdetalle_detalle_id").val());
            });
                        
            $(".to-alb").change(function () {
                $("#to_albaran").val($(this).data("matid") + "-" + $("#to_albaran").val());
            });
            $("#horas_tareas").on("changed.bs.select", function (e) {
                var dataperfil = $("option[value=" + $(this).val() + "]", this).attr('data-perfil');
                loadSelect("horas_horas","PERFILES_HORAS","id","perfil_id",dataperfil,"");
            });
            
            
            // ######## FOCUSOUT EVENTS #######
            
            $("#search-costematerial").click(function() {
            
                $.ajax({
                    type : 'POST',
                    url : 'getCategories.php',
                    dataType : 'html',
                    data: {
                        id : 6
                    },
                    success : function(data){
                        console.log("ok");
                        console.log(data);
                        $("#prueba").html(data);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            // ######## SAVE GENERAL #######
            $("#int_edit_btn_save").click(function() {
                $("#int_edit_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_editint").find(':input:disabled').removeAttr('disabled');
                $("#int_edit_tecnicosint option").prop("selected", true);
                data = $("#frm_editint").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveInt.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        alert(response);
                        //$('#frm_editint').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            
            // ######## SAVE DETALLES #######
            $("#btn_intdetalle_save").click(function() {
                //alert($("#enviodetalle_detalle_id").val());
                $("#btn_intdetalle_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_intdetalle").find(':input:disabled').removeAttr('disabled');
                tinymce.triggerSave()
                data = $("#frm_edit_intdetalle").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveIntDetalle.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_edit_intdetalle').trigger("reset");
                        refreshSelects();
                        $("#btn_intdetalle_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#detalleint_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        window.location.reload();
                    }   
                });
            });
            $("#btn_intdetalle_saveHoras").click(function() {
                //alert($("#enviodetalle_detalle_id").val());
                $("#btn_intdetalle_saveHoras").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_intdetalle").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_intdetalle").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveIntDetalle.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        //alert(response);
                        //$('#frm_edit_intdetalle').trigger("reset");
                        //refreshSelects();
                        $("#btn_intdetalle_saveHoras").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#intdetalle_horas").val("");
                        $("#intdetalle_H820").val("0"); 
                        $("#intdetalle_H208").val("0");
                        $("#intdetalle_Hviaje").val("0");
                        $("#intdetalle_costeH820").val("0");
                        $("#intdetalle_costeH208").val("0");
                        $("#intdetalle_tecnicos").val("");
                        $("#intdetalle_tecnicos").selectpicker("refresh");
                        //$("#detalleint_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        //window.location.reload();
                    }   
                });
            });
            
            
            // ######## DELETE PEDIDO #######
            $("#delete_int").click(function() {
                $("#delete_int").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#int_edit_delint").val($("#int_edit_idint").val());
                data = $("#frm_editint").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "saveInt.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert("ok");
                        $('#frm_editint').trigger("reset");
                        window.location.href = "/erp/apps/intervenciones/";
                    }   
                });
            });
            
            $("#print_int").click(function() {
                window.open(
                    "printInt.php?id=<? echo $_GET['id']; ?>",
                    '_blank' 
                );
            });
            
            // ######## DELETE DETALLES #######
            $(".remove-detalle").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveIntDetalle.php',
                    dataType : 'text',
                    data: {
                        intdetalle_deldetalle : $(this).data("id")
                    },
                    success : function(data){
                        //alert(data);
                        console.log("ok");
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            // ######## EDIT DETALLES #######
            $("#tabla-detalles-int tr > td:not(:nth-child(7))").click(function() {
                loadIntDetalleInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#detalleint_add_model").modal('show');
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
                
            $("#btn_add_tec").click(function() {
                $("#int_edit_tecnicosint").append($("<option>", {value:$("#int_edit_tecnicossel").val(), text:$("#int_edit_tecnicossel").find("option:selected").text()}));
            });
            $("#btn_clear_int").click(function() {
                $('#int_edit_tecnicosint option:selected').remove();
            });
            
            //HORAS
            $("#btn_horas_save").click(function() {
                $("#btn_horas_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_orden").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_horas").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveHoras.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_horas').trigger("reset");
                        refreshSelects();
                        $("#btn_horas_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#horas_add_model").modal('hide');
                        $("#horas_success").slideDown();
                        setTimeout(function(){
                            $("#horas_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            //MATERIALES
                $("#intmaterial_criterio").change(function () {
                    loadSelect("intmaterial_materiales","SERIAL_NUMBERS","id","ref",$(this).val(), "", "nombre",$(this).val(),"", 1);
                });
                $("#intmaterial_materiales").change(function () {
                    loadSNlInfo($(this).val());
                });
                $("#btn_intmaterial_save").click(function() {
                    $("#btn_intmaterial_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                    data = $("#frm_add_material").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveIntMaterial.php",  
                        data: data,
                        dataType: "json",       
                        success: function(response)  
                        {

                            $('#frm_add_material').trigger("reset");
                            refreshSelects();
                            $("#btn_intmaterial_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#material_success").slideDown();
                            setTimeout(function(){
                                $("#material_success").fadeOut("slow");
                                window.location.reload();
                            }, 1000);
                        }   
                    });
                });
                $(".remove-mat").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveIntMaterial.php',
                    dataType : 'text',
                    data: {
                        int_edit_delintmat : $(this).data("id")
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
                
            //MATERIALES
            
            $(".remove-horas").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveHoras.php',
                    dataType : 'text',
                    data: {
                        horas_deldetalle : $(this).data("id")
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $("#tabla-horas tr").click(function() {
                loadIntHorasInfo($(this).data("id"));
                $("#horas_add_model").modal('show');
            });

        });
	
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>