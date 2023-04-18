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
            
            //kk
            //refresh_contratistas_plataformas
            $(document).on("click", "#refresh_contratistas_plataformas", function(){
                console.log("ojo: kk");
                $.getJSON( "output.json" , function( result ){
                    console.log("Largo: ");
                    console.log(result.ArchiveList.length);
                    var largo = result.ArchiveList.length;
                    var count=0;
                    while(largo>=count){
                        console.log("aws glacier delete-archive --vault-name Genelek_Sistemas_Backup --account-id 404923956885 --archive-id "+result.ArchiveList[count].ArchiveId);
//                        $.ajax({
//                            type: "POST",  
//                            url: "saveAWS.php",  
//                            data: {
//                                id: archivoid
//                            },
//                            dataType: "text",       
//                            success: function(response)  
//                            {
//                                
//                            }   
//                        });
                        count++;
                    }
                });
            });
            
            // / kk
            
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            $("#menuitem-PRL").addClass("active");
            
            $("#adddocADMON_docfechaexp").focusout(function() {
                $("#uploaddocsADMON").fileinput('destroy');
                $("#uploaddocsADMON").fileinput({
                    uploadUrl: "upload.php?tipo=ADMON&iddoc=" + $("#adddocADMON_iddoc").val() + "&fecha=" + $("#adddocADMON_docfechaexp").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $("#adddocPRL_docfechaexp").focusout(function() {
                $("#uploaddocsPRL").fileinput('destroy');
                $("#uploaddocsPRL").fileinput({
                    uploadUrl: "upload.php?tipo=PRL&iddoc=" + $("#adddocPRL_iddoc").val() + "&fecha=" + $("#adddocPRL_docfechaexp").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $("#adddocPER_docfechaexp").focusout(function() {
                $("#uploaddocsPER").fileinput('destroy');
                $("#uploaddocsPER").fileinput({
                    uploadUrl: "upload.php?tipo=PER&iddoc=" + $("#adddocPER_iddoc").val() + "&fecha=" + $("#adddocPER_docfechaexp").val() + "&user_id=" +$("#adddocPER_iduser").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $("#adddocCLI_docfechaexp").focusout(function() {
                $("#uploaddocsCLI").fileinput('destroy');
                $("#uploaddocsCLI").fileinput({
                    uploadUrl: "upload.php?tipo=CLI&iddoc=" + $("#adddocCLI_iddoc").val() + "&fecha=" + $("#adddocCLI_docfechaexp").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            
            filesUpload = [];
            
            $('#uploaddocsADMON').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "admon",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocADMON_iddoc").val(),
                    fecha_exp: $("#adddocADMON_docfechaexp").val()
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                }); 
            });
            
            $('#uploaddocsPRL').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "prl",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocPRL_iddoc").val(),
                    fecha_exp: $("#adddocPRL_docfechaexp").val()
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
                
            });
            
            $('#uploaddocsPER').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "per",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocPER_iddoc").val(),
                    fecha_exp: $("#adddocPER_docfechaexp").val(),
                    user_id: $("#adddocPER_iduser").val()
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
                
            });
            
            $('#uploaddocsCLI').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "cli",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocCLI_iddoc").val(),
                    fecha_exp: $("#adddocCLI_docfechaexp").val()
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    //window.location.reload();
                    loadContent("doc-clientes-container", "/erp/apps/prevencion/vistas/doc-clientes.php?cliente_id=" + $('#contratistas_contratistas').val());
                    $("#adddocCLI_adddoc_model").modal('hide');
                    $('#frm_new_doc_CLI').trigger("reset");
                    $("#adddocCLI_docfechaexp").val("");
                    $("#uploaddocsCLI").fileinput('destroy');
                    $("#uploaddocsCLI").fileinput({
                        uploadUrl: "upload.php?tipo=CLI&iddoc=" + $("#adddocCLI_iddoc").val() + "&fecha=" + $("#adddocCLI_docfechaexp").val(),
                        dropZoneEnabled: true,
                        maxFileCount: 500, 
                        language: "es"
                    });
                }); 
            });
            
            
            loadSelect("filter_empresas","EMPRESAS","id","","","");
            loadSelectYears("filter_prevencion_years","PROYECTOS","fecha_ini","","");
            loadSelect("filter_per_tecnicos","erp_users","id","empresa_id","<? echo $empresa_id; ?>","apellidos");
            
            loadSelect("contratistas_contratistas","CLIENTES","id","","","");
            loadSelect("newdocADMON_empresas","EMPRESAS","id","","","");
            loadSelect("newdocADMON_organismo","ORGANISMOS","id","","","");
            loadSelect("newdocADMON_periodicidades","PERIODICIDADES","id","","","");
            setTimeout(function(){
                $("#newdocADMON_empresas").selectpicker("val", "1");
            }, 1000);
            loadSelect("newdocPRL_empresas","EMPRESAS","id","","","");
            loadSelect("newdocPRL_organismo","ORGANISMOS","id","","","");
            loadSelect("newdocPRL_periodicidades","PERIODICIDADES","id","","","");
            setTimeout(function(){
                $("#newdocPRL_empresas").selectpicker("val", "1");
            }, 2000);
            loadSelect("newdocPER_empresas","EMPRESAS","id","","","");
            loadSelect("newdocPER_organismo","ORGANISMOS","id","","","");
            loadSelect("newdocPER_periodicidades","PERIODICIDADES","id","","","");
            setTimeout(function(){
                $("#newdocPER_empresas").selectpicker("val", "1");
                loadSelect("newdocPER_trabajadores","erp_users","id","empresa_id","1","apellidos");
            }, 2000);
            loadSelect("newdocCLI_organismo","ORGANISMOS","id","","","");
            loadSelect("newdocCLI_periodicidades","PERIODICIDADES","id","","","");
            setTimeout(function(){
                $("#newdocCLI_empresas").selectpicker("val", "1");
            }, 1000);
            
            
            year = "<? echo $_GET['year']; ?>";
            if (year != "") {
                setTimeout(function(){
                    $("#filter_prevencion_years").selectpicker("val", "<? echo $_GET['year']; ?>");
                }, 1000);
            }
            
            empresa_id = "<? echo $_GET['empresa_id']; ?>";
            if (empresa_id == "") {
                empresa_id = "1";
            }
                    
            setTimeout(function(){
                $("#filter_empresas").selectpicker("val", empresa_id);
            }, 1000);
            
               
            // OPEN MODALS 
            $("#add-doc-ADMON").click(function() {
                $("#adddocADMON_model").modal('show');
            });
            $("#add-doc-PRL").click(function() {
                $("#adddocPRL_model").modal('show');
            });
            $("#add-doc-PER").click(function() {
                $("#adddocPER_model").modal('show');
            });
            $("#add-doc-CLI").click(function() {
                $("#adddocCLI_model").modal('show');
            });
            $("#add-contratistas-plataformas").click(function() {
                $('#frm_new_contratistas-plataformas').trigger("reset");
                $("#newcontratistas-plataformas-id").val("");
                $("#newcontratistas-plataformas-cli").val($("#contratistas_contratistas").val());
                $("#addcontratistas-plataformas").modal('show');
            });
            $("#add-contacto-CLI").click(function() {
                $("#btn_save_contacto_CLI").html('Añadir');
                $('#frm_new_contacto_CLI').trigger("reset");
                $("#newcontactoCLI_id_update").val("");
                $("#newcontactoCLI_id").val($("#contratistas_contratistas").val());
                $("#addcontactoCLI_model").modal('show');
            });
            $(".upload-doc-ADMON").click(function() {
                $("#adddocADMON_iddoc").val($(this).data("id"));
                $("#adddocADMON_adddoc_model").modal('show');
            });
            $(".upload-doc-PRL").click(function() {
                $("#adddocPRL_iddoc").val($(this).data("id"));
                $("#adddocPRL_adddoc_model").modal('show');
            });
            $(document).on("click", ".upload-doc-PER" , function() {
                $("#adddocPER_iddoc").val($(this).data("id"));
                $("#adddocPER_iduser").val($(this).data("userid"));
                $("#adddocPER_adddoc_model").modal('show');
            });
            $(document).on("click", ".upload-doc-CLI" , function() {
                $("#adddocCLI_iddoc").val($(this).data("id"));
                $("#adddocCLI_adddoc_model").modal('show');
            });
            
            $('#newdocPER_empresas').on('changed.bs.select', function (e) {
                loadSelect("newdocPER_trabajadores","erp_users","id","empresa_id",$(this).val(),"apellidos");
            });
            
            $('#filter_prevencion_years').on('changed.bs.select', function (e) {
                location.href = "/erp/apps/prevencion/?year=" + $(this).val();
            });
            $('#filter_empresas').on('changed.bs.select', function (e) {
                location.href = "/erp/apps/prevencion/?empresa_id=" + $(this).val();
            });
            
            // Criterios de filtro/busqueda de Documentación personal
            $('#filter_per_tecnicos').on('changed.bs.select', function (e) {
                //alert("/apps/prevencion/vistas/personal.php?tecnicoid=" + $(this).val());
                loadContent("doc-per-container", "/erp/apps/prevencion/vistas/personal.php?tecnicoid=" + $(this).val() + "&empresaid=<? echo $empresa_id; ?>&criterio=" + $("#filter_per_criterio").val());
            });
            $("#filter_per_criterio").change(function () {
                loadContent("doc-per-container", "/erp/apps/prevencion/vistas/personal.php?tecnicoid=" + $("#filter_per_tecnicos").val() + "&empresaid=<? echo $empresa_id; ?>&criterio=" + $(this).val());
            });
            // /
            
            $(document).on("click", "#tabla-proyectos tr" , function() {
                location.href = "view.php?id=" + $(this).data("id");
            });
            
            $("#btn_save_doc_ADMON").click(function() {
                $("#btn_save_doc_ADMON").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_doc_ADMON").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveDocAdmon.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_doc_ADMON').trigger("reset");
                        $("#btn_save_doc_ADMON").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newdocADMON_success").slideDown();
                        setTimeout(function(){
                            $("#newdocADMON_success").fadeOut("slow");
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            $("#btn_save_doc_PRL").click(function() {
                $("#btn_save_doc_PRL").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_doc_PRL").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveDocPRL.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_doc_PRL').trigger("reset");
                        $("#btn_save_doc_PRL").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newdocPRL_success").slideDown();
                        setTimeout(function(){
                            $("#newdocPRL_success").fadeOut("slow");
                            window.location.reload();
                        }, 2000);
                    }   
                });
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
                        $("#btn_save_doc_CLI").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newdocCLI_success").slideDown();
                        setTimeout(function(){
                            $("#newdocCLI_success").fadeOut("slow");
                            //window.location.reload();
                            $('#adddocCLI_model').modal('hide')
                            loadContent("doc-clientes-container", "/erp/apps/prevencion/vistas/doc-clientes.php?cliente_id=" + $('#contratistas_contratistas').val());
                        }, 2000);
                    }   
                });
            });
            $("#btn_save_contacto_CLI").click(function() {
                //$("#btn_save_contacto_CLI").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando...');
                data = $("#frm_new_contacto_CLI").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveContactoCLI.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_contacto_CLI').trigger("reset");
                        $("#btn_save_contacto_CLI").html('Añadir');
                        setTimeout(function(){
                            $("#newcontactoCLI_success").fadeOut("slow");
                            //window.location.reload();
                            $('#addcontactoCLI_model').modal('hide');
                            loadContent("contacto-clientes-container", "/erp/apps/prevencion/vistas/contactos-clientes.php?cliente_id=" + $('#contratistas_contratistas').val());
                        }, 500);
                    }   
                });
            });
            $("#btn_save_contratistas-plataformas").click(function() {
                //$("#btn_save_contacto_CLI").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando...');
                data = $("#frm_new_contratistas-plataformas").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveContratistasPlataformas.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        setTimeout(function(){
                            $("#newcontratistas-plataformas_success").fadeOut("slow");
                            //window.location.reload();
                            $('#addcontratistas-plataformas').modal('hide');
                            loadContent("contratistas-plataformas", "/erp/apps/prevencion/vistas/contratistas-plataformas.php?cliente_id=" + $('#contratistas_contratistas').val());
                        }, 500);
                    }   
                });
            });
            

            /* Switch Habilitado */
            $('#newcontactoCLI_activo').on('switchChange.bootstrapSwitch', function (event, state) {
                if(state==true){
                    //$('input[name="newcontactoCLI_activo"]').bootstrapSwitch('state',true);
                    $("#txt_activo").val("on");
                }else{
                    //$('input[name="newcontactoCLI_activo"]').bootstrapSwitch('state',false);
                    $("#txt_activo").val("off");
                }
                event.preventDefault();
            });
            $('input[name="newcontactoCLI_activo"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
                
            });
            /* / Switch Habilitado */
            $(document).on("click", ".enviar-doc", function(){
                $.ajax({
                    type: "POST",  
                    url: "linkDocEnviar.php",  
                    data: {
                            id_doc: $(this).data("id"),
                            sent_doc: 1
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        loadContent("doc-enviar-container", "/erp/apps/prevencion/vistas/doc-enviar.php?cliente_id=" + $('#contratistas_contratistas').val() + "&empresa_id=" + <? echo $empresa_id; ?>);
                    }   
                });
            });
            $(document).on("click", ".enviado-doc", function(){
                $.ajax({
                    type: "POST",  
                    url: "linkDocEnviar.php",  
                    data: {
                            id_doc: $(this).data("id"),
                            sent_doc: 0
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //window.location.reload();
                        loadContent("doc-enviar-container", "/erp/apps/prevencion/vistas/doc-enviar.php?cliente_id=" + $('#contratistas_contratistas').val() + "&empresa_id=" + <? echo $empresa_id; ?>);
                    }   
                });
            });
            
            $(document).on("click", ".remove-doc-cli", function(){
                $.ajax({
                    type: "POST",  
                    url: "linkDocEnviar.php",  
                    data: {
                            id_doc: $(this).data("id"),
                            remove_doc: 1
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //window.location.reload();
                        loadContent("doc-enviar-container", "/erp/apps/prevencion/vistas/doc-enviar.php?cliente_id=" + $('#contratistas_contratistas').val() + "&empresa_id=" + <? echo $empresa_id; ?>);
                    }   
                });
            });
            
            // Borrado Plataformas
            $(document).on("click", ".remove-contratistas-plataformas", function(){
                $("#del-contratistas-plataformas").val($(this).data("id"));
                $("#modal-del-contratistas-plataformas").modal("show");    
            });
            $(document).on("click", "#btn-del-contratistas-plataformas", function(){
                $.ajax({
                    type: "POST",  
                    url: "saveContratistasPlataformas.php",  
                    data: {
                            del_contratistaPlat: $("#del-contratistas-plataformas").val()
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        $("#modal-del-contratistas-plataformas").modal("hide");
                        //console.log(response);
                        loadContent("contratistas-plataformas", "/erp/apps/prevencion/vistas/contratistas-plataformas.php?cliente_id=" + $('#contratistas_contratistas').val());
                    }   
                });
            });
            /////////
            $(document).on("click", ".remove-contacto-cliente", function(){
                $("#del_contacto_cliente").val($(this).data("id"));
                $("#confirm_del_contacto_CLI_model").modal("show");
                
            });
           $(document).on("click", "#btn_del_contacto_cliente", function(){
                $.ajax({
                    type: "POST",  
                    url: "saveContactoCLI.php",  
                    data: {
                            id_contacto_cli: $("#del_contacto_cliente").val(),
                            remove_contacto_cli: 1
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        $("#confirm_del_contacto_CLI_model").modal("hide");
                        //console.log(response);
                        loadContent("contacto-clientes-container", "/erp/apps/prevencion/vistas/contactos-clientes.php?cliente_id=" + $('#contratistas_contratistas').val());
                    }   
                });
            });
            $('#contratistas_contratistas').on('changed.bs.select', function (e) {
                loadContratista($(this).val());
                loadContent("doc-enviar-container", "/erp/apps/prevencion/vistas/doc-enviar.php?cliente_id=" + $(this).val() + "&empresa_id=" + <? echo $empresa_id; ?>);
                loadContent("doc-clientes-container", "/erp/apps/prevencion/vistas/doc-clientes.php?cliente_id=" + $(this).val());
                // Contratistas Plataformas *
                loadContent("contratistas-plataformas", "/erp/apps/prevencion/vistas/contratistas-plataformas.php?cliente_id=" + $(this).val());
                // Contacto Clientes
                loadSelect("newcontactoCLI_instalacion","CLIENTES_INSTALACIONES","id","cliente_id",$(this).val(),"");
                loadContent("contacto-clientes-container", "/erp/apps/prevencion/vistas/contactos-clientes.php?cliente_id=" + $(this).val());
                
                $("#contratista-view").show();
            });
            
            // PLANTILLAS
            
            $("#docplan_docfechaexp").focusout(function() {
                $("#uploaddocsPLAN").fileinput('destroy');
                $("#uploaddocsPLAN").fileinput({
                    uploadUrl: "uploadPlantilla.php?iddoc=" + $("#docPLAN_iddoc").val() + "&fecha=" + $("#docplan_docfechaexp").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            
            filesUpload = [];
            
            $('#uploaddocsPLAN').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUploadPlantilla.php", 
                { 
                    tipo: "plan",
                    pathFile: data.response.uploaded,
                    doc_id: $("#docPLAN_iddoc").val(),
                    fecha_exp: $("#docplan_docfechaexp").val()
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                }); 
            });
            
            // OPEN MODALS 
            $("#add-plan").click(function() {
                $("#addPlantilla_model").modal('show');
            });
            $(".upload-doc-PLAN").click(function() {
                $("#docPLAN_iddoc").val($(this).data("id"));
                $("#plantilla_adddoc_model").modal('show');
            });
            $("#tabla-doc-PER tr > td:not(:nth-child(7)):not(:nth-child(8))").click(function() {
                loadPERInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#adddocPER_model").modal('show');
            });
            $("#tabla-doc-PRL tr > td:not(:nth-child(6)):not(:nth-child(7))").click(function() {
                loadPRLInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#adddocPRL_model").modal('show');
            });
            $("#tabla-doc-ADMON tr > td:not(:nth-child(6)):not(:nth-child(7))").click(function() {
                loadADMONInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#adddocADMON_model").modal('show');
            });
            // Instalaciones
            $(document).on("click", "#tabla-doc-CLI tr > td:not(:nth-child(6))", function(){
                $("#btn_save_contacto_CLI").html('Guardar');
                $("#newcontactoCLI_id_update").val($(this).parent("tr").data("id"));
                loadContactoCliente($(this).parent("tr").data("id"));
                $("#newcontactoCLI_instalacion").selectpicker("refresh");
                //loadSelect("newcontactoCLI_instalacion","CLIENTES_INSTALACIONES","id","id",$(this).val(),"");
                $("#addcontactoCLI_model").modal('show');
            });
            // Ver Gestion Instalaciones
            $("#btn_viewInstalaciones").click(function() {
                // Insertar instalaciones
                $.ajax({
                    type: "GET",  
                    url: "loadGestionarInstalaciones.php",  
                    data: {
                        newcontactoCLI_id: $("#newcontactoCLI_id").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Añadimos contenido de todas las instlaciones del cliente
                        $("#instalaciones_cliente_tabla").html(response);
                        // Abrimos el modal
                        $("#gestionarInstalaciones_model").modal('show');
                    }   
                });
            });
            // Añadir instalacion PENDIENTE
            $(document).on("click", "#add-instalacion-cliente", function(){
                //Limpiar form
                //frm_new_instalacion_CLI
                //Show modal add/mod
                $("#confirm_add_instalacion_CLI_model").modal('show');
            });
            // Save Instalacion PENDIENTE
            $(document).on("click", "#btn_add_instalacion_cliente", function(){
                //$("#btn_del_plantilla").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                //$("#newplantilla_delplan").val($("#newplantilla_idplan").val());
                data = $("#frm_new_plantilla").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "saveInstalacionCliente.php",  
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
            // Modificar instalacion //PENDIENTE
            
            // Borrar instalacion // PENDIENTE
            
            $(document).on("click", "#tabla-contratistas-plataformas tr > td:not(:nth-child(6))", function(){
                loadContratistaPlataformaInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#newcontratistas-plataformas-cli").val($("#contratistas_contratistas").val());
                $("#addcontratistas-plataformas").modal('show');
            });
            // PLANTILLAS
            $("#btn_save_plantilla").click(function() {
                $("#btn_save_plantilla").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_plantilla").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "savePlantilla.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_plantilla').trigger("reset");
                        $("#btn_save_plantilla").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newplantilla_success").slideDown();
                        setTimeout(function(){
                            $("#newplantilla_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            $("#tabla-plantillas tr > td:not(:nth-child(5)):not(:nth-child(6))").click(function() {
                loadPlanInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#addPlantilla_model").modal('show');
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
            
            $(document).on("click", ".ver-docs-personal", function(){
                //$(this).data();
                $.ajax({
                    type: "POST",  
                    url: "multiDocPersonal.php",  
                    data: {
                        docversiones_id: $(this).data("id")
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#multiDocPersonal_modal').html(response);
                        $('#multiDocPersonal_modal').modal("show");
                    }   
                });
            });
            $(document).on("click", ".del-docs-personal", function(){
                $("#del_version_per_id").val($(this).data("id"));
                $("#confirm_del_version_personal").modal("show");
            });
            $(document).on("click", "#btn_confirmar_del_personal", function(){
                $.ajax({
                    type: "POST",  
                    url: "multiDocPersonal.php",  
                    data: {
                        deldocversiones_id: $("#del_version_per_id").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $("#confirm_del_version_personal").modal("hide");
                        $('#multiDocPersonal_modal').modal("hide");
                    }   
                });
            });
	});
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>PRL | Erp GENELEK</title>
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
                DOCUMENTACIÓN PRL
            </h3>
        </div>
        <div id="dash-header">
            <div id="proyectos-filterbar" class="one-column">
                <? include($pathraiz."/apps/prevencion/vistas/filtros.php"); ?>
            </div>
            <span class="stretch"></span>
            <div  class="three-column">
                <h4 class="dash-title">
                    DOCUMENTACIÓN ADMINISTRATIVA
                    <? include($pathraiz."/apps/prevencion/includes/tools-admon.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="doc-admon-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/prevencion/vistas/admon.php"); ?>
                </div>
            </div>
            <div class="three-column">
                <h4 class="dash-title">
                    DOCUMENTACIÓN PREVENCIÓN
                    <? include($pathraiz."/apps/prevencion/includes/tools-prl.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="doc-prl-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/prevencion/vistas/prl.php"); ?>
                </div>
            </div>
            <div class="three-column">
                <h4 class="dash-title">
                    DOCUMENTACIÓN PERSONAL
                    <? include($pathraiz."/apps/prevencion/includes/tools-personal.php"); ?>
                    <? include($pathraiz."/apps/prevencion/includes/tools-personal-filtros.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="doc-per-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/prevencion/vistas/personal.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
        <div id="erp-titulo" class="one-column">
            <h3>
                CONTRATISTAS
            </h3>
        </div>
        <div id="dash-contratistas">
            <div id="dash-contratistas" class="two-column">
                <h4 class="dash-title">
                    CONTRATISTAS
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="contratistas-container">
                    <? include($pathraiz."/apps/prevencion/vistas/contratistas.php"); ?>
                </div>
                
                <h4 class="dash-title">
                    RIESGOS <small class="text-muted">(DOCUMENTOS ENVIADOS ANTERIORMENTE Y QUE ESTÁN CADUCADOS O A PUNTO DE CADUCAR)</small>
                </h4>
                
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="contratistas-riesgos">
                    <? include($pathraiz."/apps/prevencion/vistas/contratistas-riesgos.php"); ?>
                </div>
            </div>
            <div class="two-column" style="background-color: transparent;">
                <div id="dash-doc-clientes" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTACIÓN CONTRATISTA
                        <? include($pathraiz."/apps/prevencion/includes/tools-cli.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div class="loading-div"></div>
                    <div id="doc-clientes-container" class="pre-scrollable">
                        <? //include($pathraiz."/apps/prevencion/vistas/doc-clientes.php"); ?>
                    </div>
                </div>
                <div id="dash-doc-enviar" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTACIÓN A ENVIAR
                    </h4>
                    <hr class="dash-underline">
                    <div class="loading-div"></div>
                    <div id="doc-enviar-container">
                        <? //include($pathraiz."/apps/prevencion/vistas/doc-enviar.php"); ?>
                    </div>
                </div>
                <div id="dash-contratistas-plataformas" class="one-column">
                    <h4 class="dash-title">
                        CONTRATISTAS PLATAFORMAS
                        <? include($pathraiz."/apps/prevencion/includes/tools-contratistas-plataformas.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div class="loading-div"></div>
                    <div id="contratistas-plataformas">
                        <? //include($pathraiz."/apps/prevencion/vistas/contratistas-plataformas.php"); ?>
                    </div>
                </div>
                <div id="dash-contacto-clientes" class="one-column">
                    <h4 class="dash-title">
                        CONTACTO CLIENTES
                        <? include($pathraiz."/apps/prevencion/includes/tools-cli-contacto.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div class="loading-div"></div>
                    <div id="contacto-clientes-container" class="pre-scrollable">
                        <? //include($pathraiz."/apps/prevencion/vistas/contactos-clientes.php"); ?>
                    </div>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-iframe" class="one-column">
                <h4 class="dash-title">
                    PLATAFORMA DE PREVENCIÓN
                    <? include($pathraiz."/apps/prevencion/includes/tools-plataforma.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="plataforma-iframe" style="text-align: center;">
                    <? include($pathraiz."/apps/prevencion/vistas/plataforma-iframe.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-plantillas" class="one-column">
                <h4 class="dash-title">
                    PLANTILLAS DE DOCUMENTOS PRL
                    <? include($pathraiz."/apps/prevencion/includes/tools-plantillas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="plataforma-iframe" style="text-align: center;">
                    <? include($pathraiz."/apps/prevencion/vistas/prl-plantillas.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
        
    </section>
	
</body>
</html>