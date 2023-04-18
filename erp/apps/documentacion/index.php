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

<!-- custom js -->
    <script src="/erp/functions.js"></script>

<!-- Bootstrap Grid -->
    <script src="/erp/includes/bootstrap/jquery.bootgrid.min.js"></script>
<!-- Bootstrap switch -->
    <link href="/erp/plugins/bootstrap-switch.min.css" rel="stylesheet">
    <script src="/erp/plugins/bootstrap-switch.min.js"></script>

<!-- File input -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="/erp/includes/plugins/fileinput/js/locales/es.js"></script>

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            $('#menuitem-documentacion').addClass('active');
            
            loadSelect("newdoc_tipo","TIPOS_DOCISO","id","","");
            
            $("#docdoc_docfechaexp").focusout(function() {
                $("#uploaddocsDOC").fileinput('destroy');
                $("#uploaddocsDOC").fileinput({
                    uploadUrl: "upload.php?iddoc=" + $("#docDOC_iddoc").val() + "&fecha=" + $("#docdoc_docfechaexp").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            
            filesUpload = [];
            
            $('#uploaddocsDOC').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "doc",
                    pathFile: data.response.uploaded,
                    doc_id: $("#docDOC_iddoc").val(),
                    fecha_exp: $("#docdoc_docfechaexp").val()
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                }); 
            });
            
            // OPEN MODALS 
            $("#add-doc").click(function() {
                $("#addDoc_model").modal('show');
            });
            $(".upload-doc-DOC").click(function() {
                $("#docDOC_iddoc").val($(this).data("id"));
                $("#doc_adddoc_model").modal('show');
            });
            
            // PROCTILLAS
            $("#btn_save_doc").click(function() {
                $("#btn_save_doc").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_doc").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveDoc.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_doc').trigger("reset");
                        $("#btn_save_procedimiento").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newdoc_success").slideDown();
                        setTimeout(function(){
                            $("#newdoc_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            $("#tabla-doc tr > td:not(:nth-child(6)):not(:nth-child(7))").click(function() {
                loadDocInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#addDoc_model").modal('show');
            });
            
            // Borrar Documento
            $("#btn_del_doc_modal").click(function() {
                $("#delDoc_model").modal('show');
            });
            $("#btn_del_doc").click(function() {
                $("#btn_del_doc").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#newdoc_deldoc").val($("#newdoc_iddoc").val());
                data = $("#frm_new_doc").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "saveDoc.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_new_doc').trigger("reset");
                        setTimeout(function(){
                            $("#deldoc_success").slideDown();
                            //$("#deldoc_success").fadeOut("slow");
                            //console.log(response[0].id);;
                        }, 1000);
                        setTimeout(function(){
                            $("#deldoc_success").fadeOut("slow");                            
                            $("#addDoc_model").modal('hide');
                            $("#delDoc_model").modal('hide');
                            window.location.href = "/erp/apps/documentacion/";
                        }, 2500);
                    }   
                });
            });
            
        });
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>DOCUMENTACION | Erp GENELEK</title>
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
                REGISTROS / DOCUMENTACION
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="one-column">
                <h4 class="dash-title">
                    
                    <? 
                        include($pathraiz."/apps/documentacion/includes/tools-doc.php"); 
                    ?>
                </h4>
                <div id="dash-empresas" style="padding:10px;">
                    <? 
                        include($pathraiz."/apps/documentacion/vistas/tabla-doc.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
	
</body>
</html>