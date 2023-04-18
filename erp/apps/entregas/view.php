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
        if (($_GET['idt'] != "undefined") &&($_GET['idt'] != "")) {
            $idtrabajador = $_GET['idt'];
        }
        else {
            $idtrabajador = $_SESSION['user_session'];
        }
    }
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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

<!-- Bootstrap Treeview
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
    -->
    <link rel="stylesheet" href="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.js"></script>

<!-- CHARTS -->
    <script src="/erp/includes/plugins/chart/dist/Chart.bundle.js"></script>
    <!--<script src="includes/chart/dist/Chart.bundle.min.js"></script>-->        
    
<!-- custom js -->
<script src="/erp/functions.js"></script>

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
            
            $("#uploaddocs").fileinput({
                uploadUrl: "upload.php?proyectopath=" + $("#proyectos_path").val(),
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
                    nombre: $("#proyecto_docnombre").val(),
                    descripcion: $("#proyecto_docdesc").val(),
                    proyecto_id: <? echo $_GET['id'] ?> ,
                    grupo_id: $("#proyecto_docgrupos").val()
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
                
            });

            $("#menuitem-entregas").addClass("active");
            
            loadSelect("newensayo_estados","ESTADOS_ENSAYOS","id","","","");
            loadSelect("newensayo_plantilla","PLANTILLAS","id","","","");
            loadSelect("newensayo_tecnico","erp_users","id","","","apellidos");
            loadSelect("entregas_estados","ESTADOS_ENTREGAS","id","","","");
            //loadSelect("entregas_instalacion","CLIENTES_INSTALACIONES","id","cliente_id",$("#entregas_clienteid").val(),"","");
            loadSelectInstalacionesProyecto("entregas_instalacion",$("#entregas_idproyecto").val());
            loadTitulosEntregas("entrega-titulo","ENTREGAS",<? echo $_GET["id"]; ?>);
            loadTitulosEntregas("current-page","ENTREGAS",<? echo $_GET["id"]; ?>);
            
            loadContent("dash-pruebas-entrega", "/erp/apps/entregas/vistas/pruebas-entrega.php?id="+<? echo $_GET["id"]; ?>);
            
            $.ajax({
                type: "POST",  
                url: "reloadObjets.php",  
                data: {
                    boton_envio_grupos: 1,
                    entrega_id: <? echo $_GET["id"]; ?>
                },
                dataType: "text",       
                success: function(response)  
                {
                    console.log("response: "+response);
                    if(response.trim()=="1"){
                        $("#add-grupo-envio").prop("disabled",false);
                    }else{
                        if(response.trim()=="2"){
                            $("#add-grupo-envio").prop("disabled",true);
                        }else{
                            // Cosas a hacer ?¿
                            $("#add-grupo-envio").prop("disabled",true);
                            $("#ira-envio").show();
                            $("#ira-envio").attr("onclick", "window.open('/erp/apps/envios/editEnvio.php?id="+response.trim()+"','_blank')");
                            $("#delete_entrega").prop("disabled",true);
                            $("#delete_entrega").attr("title", "No se puede borrar si se ha realizado un Envío!");
                        }
                        if(response.trim()=="3"){
                            $("#add-grupo-envio").prop("disabled",true);
                            $("#ira-envio").hide();
                            $("#delete_entrega").prop("disabled",false);
                            $("#delete_entrega").attr("title", "Borrar Entrega!");
                        }
                    }
                }   
            });            
            // Print desde el view
            $(document).on("click", "#print_ensayo" , function() {
                // Check ensayo.
                // Plantilla seleccionada: switch...                
                console.log("Valor: "+$("#newensayo_plantilla").val());
                if($("#entregas_instalacionid").val()==0 || $("#entregas_instalacionid").val()==""){
                    alert("ERROR. Es necesario asignar Instalación.");
                }else{
                    switch($("#newensayo_plantilla").val()){
                        case "5": // 5 PROTOCOLO DE PRUEBAS RELES PROTECCIÓN
                            window.open("printPruebasReles.php?id="+$("#newensayo_idensayo").val(),'_blank');
                            break;
                        case "40": // 40 PROTOCOLO DE PRUEBAS DE ARMARIOS EN INGLES
                            window.open("printPruebasArmariosIngles.php?id="+$("#newensayo_idensayo").val()+"&plantilla_id="+$("#newensayo_plantilla").val(),'_blank');
                            break;
                        case "44": // 44 PROTOCOLO DE PRUEBAS EN ARMARIO
                            window.open("printPruebasArmario.php?id="+$("#newensayo_idensayo").val()+"&plantilla_id="+$("#newensayo_plantilla").val(),'_blank');
                            break;
                        case "99": // 99 PROTOCOLO DE PRUEBAS
                            window.open("printPruebas.php?id="+$("#newensayo_idensayo").val()+"&plantilla_id="+$("#newensayo_plantilla").val(),'_blank');
                            break;
                        default:
                            alert("No se puede imprimir para esa plantilla!");
                            break;
                    }
                }
            });
            // Print desde la tabla
            $(document).on("click", ".print_ensayo_view" , function() {
                // val=pantilla
                // data-id=id
                console.log("Valor: "+$(this).val());
                if($("#entregas_instalacionid").val()==0 || $("#entregas_instalacionid").val()==""){
                    alert("ERROR. Es necesario asignar Instalación.");
                }else{
                    switch($(this).val()){
                        case "5": // 5 PROTOCOLO DE PRUEBAS RELES PROTECCIÓN
                            window.open("printPruebasReles.php?id="+$(this).data('id'),'_blank');
                            break;
                        case "40": // 40 PROTOCOLO DE PRUEBAS DE ARMARIOS EN INGLES
                            window.open("printPruebasArmariosIngles.php?id="+$(this).data('id')+"&plantilla_id="+$(this).val(),'_blank');
                            break;
                        case "44": // 44 PROTOCOLO DE PRUEBAS EN ARMARIO
                            window.open("printPruebasArmario.php?id="+$(this).data('id')+"&plantilla_id="+$(this).val(),'_blank');
                            break;
                        case "99": // 99 PROTOCOLO DE PRUEBAS
                            window.open("printPruebas.php?id="+$(this).data('id')+"&plantilla_id="+$(this).val(),'_blank');
                            break;
                        default:
                            alert("No se puede imprimir para esa plantilla!");
                            break;
                    }
                }
            });
            
            $(document).on("click", "#edit_entrega" , function() {
                //alert($(this).data('id'));
                $("#entregas_clientes").val($("#entregas_clienteid").val());
                $("#entregas_clientes").selectpicker('refresh');
                $("#entregas_estados").val($("#entregas_estadoid").val());
                $("#entregas_estados").selectpicker('refresh');
                $("#entregas_instalacion").val($("#entregas_instalacionid").val());
                $("#entregas_instalacion").selectpicker('refresh');
                $("#entrega-view").hide();
                $("#entrega-edit").fadeIn();
            });
            
            $(document).on("click", "#save_entrega" , function() {
                $("#entregas_btn_save").click();
            });
            
            $(document).on("click", "#entregas_btn_save" , function() {
                $("#entregas_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#entregas_expedientes option").prop("selected", true);
                data = $("#frm_entrega").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveEntregas.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log("response: "+response);
                        $('#frm_entrega').trigger("reset");
                        refreshSelects();
                        $("#entregas_btn_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#entregas_success").slideDown();
                        setTimeout(function(){
                            $("#entregas_success").fadeOut("slow");
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            //////////////// DELETE ENTREGA /////////////////
            $(document).on("click", "#delete_entrega" , function() {
                $("#confirm_delete_entrega").modal("show");
            });
            $(document).on("click", "#btn_delete_entrega" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEntregas.php",  
                    data: {
                        entregas_delentrega: <? echo $_GET["id"]; ?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        setTimeout(function(){
                            window.location.href = "/erp/apps/entregas/index.php";
                        }, 1000);
                    }   
                });
            });
            $(document).on("click", "#btn_save_ensayo" , function() {
                $("#btn_save_ensayo").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                
                data = $("#frm_new_ensayo").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response){
                        //console.log("response new prueba:"+response);
                        $('#frm_new_ensayo').trigger("reset");
                        refreshSelects();
                        $("#btn_save_ensayo").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newensayo_success").slideDown();
                        setTimeout(function(){
                            $("#newensayo_success").fadeOut("slow");
                            $("#addensayo_model").modal("hide");
                            loadContent("dash-pruebas-entrega", "/erp/apps/entregas/vistas/pruebas-entrega.php?id="+<? echo $_GET["id"]; ?>);
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            // FOCUS OUT DE LOS TEXTOS
            $(document).on("focusout", ".valor_prueba" , function() {
                //console.log("VALOR A LA SALIDA: "+$(this).val());
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        cambioesnayoid: $("#newensayo_idensayo").val(),
                        detalleid: $(this).parent().parent().data("id"),
                        valor: $(this).val()
                    },
                    dataType: "text",       
                    success: function(response){
                        //Console.log("response focusout:"+response);
                        setTimeout(function(){
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            // Add Instalacion
            $(document).on("click", "#add-instalacion" , function() {
                $("#nombre_cliente").val($("#entregas_clientes").val());
                $("#addinstalacion_model").modal("show");
            });
            $(document).on("click", "#btn_add_instalacion" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveInstalacion.php",  
                    data: {
                        clienteid: $("#entregas_clienteid").val(),
                        instalacionnombre: $("#nombre_instalacion").val(),
                        instalaciondireccion: $("#direccion_instalacion").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log("response: "+response);
                        window.open("/erp/apps/entregas/view.php?id="+response,"_blank");
                        window.location.reload();
                    }   
                });
            });
            //////////////// DUPLICATE ENTREGA /////////////////
            $(document).on("click", "#duplicar_entrega" , function() {
                $("#confirm_duplicate_entrega").modal("show");
            });
            $(document).on("click", "#btn_duplicate_entrega" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEntregas.php",  
                    data: {
                        entregas_duplientrega: <? echo $_GET["id"]; ?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log("response: "+response);
                        window.open("/erp/apps/entregas/view.php?id="+response,"_blank");
                        window.location.reload();
                    }   
                });
            });
            
            // ESTADOS ENSAYOS
            $(document).on("click", ".aprobar-ensayo" , function() {
                //alert($(this).data("id"));
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        newensayo_idensayo: $(this).data("id"),
                        action: 2
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            $(document).on("click", ".fallido-ensayo" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        newensayo_idensayo: $(this).data("id"),
                        action: 3
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            $(document).on("click", ".enproceso-ensayo" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        newensayo_idensayo: $(this).data("id"),
                        action: 1
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            $(document).on("click", ".aviso-ensayo" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        newensayo_idensayo: $(this).data("id"),
                        action: 4
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            $(document).on("click", ".pendiente-ensayo" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        newensayo_idensayo: $(this).data("id"),
                        action: 5
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            
            ///////////////////// Realizar envio del grupo! /////////////////////
            // Solo dejar hacerlo si estan todos los ensayos OK!
            
            // Realizar envio!
            $(document).on("click", "#add-grupo-envio" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEntregas.php",  
                    data: {
                        realizar_envio: 1,
                        envio_id_entrega: <? echo $_GET['id']; ?>,
                        envio_idtrabajador: <? echo $idtrabajador; ?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.open("/erp/apps/envios/editEnvio.php?id="+response,"_blank");
                        //console.log("Response: "+response);
                        $("#add-grupo-envio").prop("disabled",true);
                        setTimeout(function(){
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            ///////////// Borrar Ensayo /////////////////////////
            $(document).on("click", ".remove-ensayo" , function() {
                $("#del_ensayoid").val($(this).data("id"));
                $("#confirm_del_ensayo_model").modal("show");
            });
            $(document).on("click", "#btn_del_ensayo" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        ensayos_delensayo: $("#del_ensayoid").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            $(document).on("click", ".remove-ensayo-doc" , function() {
                $("#del_ensayoiddoc").val($(this).data("id"));
                $("#confirm_del_ensayodoc_model").modal("show");
            });
            $(document).on("click", "#btn_del_ensayo_doc" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        ensayos_delensayodoc: $("#del_ensayoiddoc").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            $(document).on("click",".remove-ensayo-info",function() {
                $("#del_infoensayoid").val($(this).data("id"));
                $("#confirm_del_infoensayo_model").modal("show");
            });
            $(document).on("click","#btn_del_infoensayo",function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        ensayos_delinfoensayo: $("#del_infoensayoid").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        $("#confirm_del_infoensayo_model").modal("hide");
                        $("#addensayo_model").modal("hide");
                        //window.location.reload();
                    }   
                });
            });
            ////////// Carga para subir fichero  ////////////
            /************* FICHERO ENTREGA   ********/
            $(document).on("click", "#add-documento" , function() {
                $("#entrega_adddoc_model").modal("show");
            });
            $("#adddocEntrega_fecha").focusout(function() {
                $("#newentrega_adjunto").fileinput('destroy');
                $("#newentrega_adjunto").fileinput({
                    //uploadUrl: "upload.php?tipo=PROCESOS&iddoc=" + $("#adddocProcesos").val() + "&fecha=" + $("#adddocProcesos_fecha").val(),
                    uploadUrl: "uploadEntrega.php?entregaid="+$("#doc_entrega_id").val()+ "&fecha=" + $("#adddocEntrega_fecha").val()+"&nombredoc="+$("#entrega_doctitulo").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $('#newentrega_adjunto').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "ENTREGA",
                    pathFile: data.response.uploaded,
                    titulo: $("#entrega_doctitulo").val(),
                    descripcion: $("#entrega_docdesc").val(),
                    entrega_id: $("#doc_entrega_id").val()
                })
                .done(function( data1 ) {
                    console.log(data1);
                    //alert( "ok" );
                    window.location.reload();
                }); 
            });
            
            
            $(document).on("click", ".delDoc" , function() {
                $("#deldoc_entregas").val($(this).data("id"));
                $("#confirm_deldoc_entrega_model").modal("show");
            });
            
            $(document).on("click", "#btn_deldoc_entregas" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEntregas.php",  
                    data: {
                        deldoc_entrega: $("#deldoc_entregas").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            /************* FICHERO ENSAYOS   ********/
            $("#adddocEnsayo_fecha").focusout(function() {
                $("#newensayo_adjunto").fileinput('destroy');
                $("#newensayo_adjunto").fileinput({
                    //uploadUrl: "upload.php?tipo=PROCESOS&iddoc=" + $("#adddocProcesos").val() + "&fecha=" + $("#adddocProcesos_fecha").val(),
                    uploadUrl: "upload.php?ensayoid="+$("#newensayo_idensayo").val()+ "&fecha=" + $("#adddocEnsayo_fecha").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
                });
            });
            $('#newensayo_adjunto').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "ENSAYO",
                    pathFile: data.response.uploaded,
                    ensayo_id: $("#newensayo_idensayo").val(),
                    doc_fecha: $("#adddocEnsayo_fecha").val()
                })
                .done(function( data1 ) {
                    console.log(data1);
                    //alert( "ok" );
                    window.location.reload();
                }); 
            });
            
            // ### REFRESH PRUEBAS ###
            $(document).on("click", "#refresh_ensayos" , function() {
                loadContent("dash-pruebas-entrega", "/erp/apps/entregas/vistas/pruebas-entrega.php?id="+<? echo $_GET["id"]; ?>);
            });
            // ######## OPEN MODALS #######
            $("#add-ensayo").click(function() {
                //Limpiar modal!!
                $('#frm_new_ensayo').trigger("reset");
                $("#newensayo_archivos").html("");
                $("#info-ensayo").html("");
                $("#newensayo_idensayo").val("");
                $("#addensayo_model").modal('show');
            });
            $(document).on("click", "#tabla-ensayos tr > td:not(:nth-child(5)):not(:nth-child(6)):not(:nth-child(7))" , function() {
                //Cargar ensayo en la ventana Modal
                loadEnsayo($(this).parent().data("id"));
                // loadEnsayoArchivos("newensayo_archivos",$(this).parent().data("id")); // Para los documentos
                $("#addensayo_model").modal('show');                
            });
            // Add ensayo info
            $(document).on("click", "#add-ensayo-info" , function() {
                //Limpiar modal!!
                $('#frm_add_infoensayo').trigger("reset");
                $("#add_infoensayoid").val("");
                $("#add_ensayoid").val($("#newensayo_idensayo").val());
                $("#confirm_add_infoensayo_model").modal('show');
            });
            $(document).on("click", "#btn_add_infoensayo" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",  
                    data: {
                        add_ensayoinfo: $("#add_infoensayoid").val(),
                        add_ensayo: $("#add_ensayoid").val(),
                        add_tituloinfo: $("#newensayoinfo_titulo").val(),
                        add_descinfo: $("#newensayoinfo_desc").val(),
                        add_estadoinfo: $("#newensayoinfo_estado").val(),
                        add_fechainfo: $("#newensayoinfo_fecha").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $("#addensayo_model").modal('hide');
                        $("#confirm_add_infoensayo_model").modal('hide');
                        //window.location.reload();
                    }   
                });
            });
            // Modificar ensayo info
            $(document).on("click", "#tabla-ensayos-info5 tr > td:not(:nth-child(5))" , function() {
                //Limpiar modal!!
                $('#frm_add_infoensayo').trigger("reset");
                $("#add_ensayoid").val($("#newensayo_idensayo").val());
                $("#add_infoensayoid").val($(this).parent().data("id"));
                loadEnsayoInfo($(this).parent().data("id"));
                $("#confirm_add_infoensayo_model").modal('show');
            });
            // Infor ver=> no-ver
            $(document).on("click", "#view_info" , function() {
                
                if($("#info-ensayo").is(":visible")){
                    $("#view_info").children().attr('src','/erp/img/ojo.png');
                    $("#info-ensayo").hide();
                }else{
                    $("#view_info").children().attr('src','/erp/img/noojo.png');
                    $("#info-ensayo").show();
                } 
            });
            
            $(document).on("dblclick", ".estado-info" , function() {
                console.log("ID seleccionado: "+$(this).parent().parent().data("id"));
                //console.log("Objeto: "+$(this));
                var objSpan=$(this);
                $.ajax({
                    type: "POST",  
                    url: "saveEnsayos.php",
                    data: {
                        ensayospruebas_id: $(this).parent().parent().data("id")
                    },
                    dataType: "text",       
                    success: function(response)  
                    { // PENDIENTE O REALIZADO
                          console.log("color del dot: "+response.trim());
                          console.log(objSpan);
                          $(objSpan).removeClass();
                          $(objSpan).attr('class', response.trim()+' estado-info');
                          //initTree(response, "treeview_json");
                    }   
                });
            });
            
            var treeData;
            
            $.ajax({
                type: "GET",  
                url: "responseDocs.php",
                data: {
                    id: <? echo $_GET["id"]; ?>
                },
                dataType: "json",       
                success: function(response)  
                {
                      console.log("ok?!: "+response);
                      initTree(response, "treeview_json");
                }   
            });
            
            function initTree(treeData, treeElement) {
                //console.log(treeData);
                $('#' + treeElement).treeview({
                    data: treeData,
                    enableLinks: true
                });
            }
	});
	
        
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title id="entrega-title">Entregas | Erp GENELEK</title>
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
            <h5><a href="/erp/apps/entregas/">ENTREGAS</a> > <span id="current-page"></span></h5>
        </div>
        <div id="erp-titulo" class="one-column">
            <h3 id="entrega-titulo">
                
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-aside" class="two-column">
                <div id="dash-proyectosactivos" class="one-column">
                    <h4 class="dash-title">
                        <? include($pathraiz."/apps/entregas/includes/tools-single-entrega.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/current-entrega.php"); 
                    ?>
                </div>
            </div>
            
            <div id="dash-aside" class="two-column">
                <div id="dash-estado-pruebas" class="two-column">
                    <h4 class="dash-title">
                        ESTADO DE LAS PRUEBAS
                    </h4>
                    <hr class="dash-underline">
                    <? include("vistas/entregas-grafico.php"); ?>
                </div>
                <div id="proyecto-documentos" class="two-column">
                    <h4 class="dash-title">
                        DOCUMENTOS <? include($pathraiz."/apps/entregas/includes/tools-documentos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="treeview_json">
                        <? //include("vistas/documentos.php"); ?>
                    </div>
                </div>
                <span class="stretch"></span>
                <!--
                <div id="proyecto-planos" class="two-column">
                    <h4 class="dash-title">
                        PLANOS <? //include($pathraiz."/apps/proyectos/includes/tools-planos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="treeview_json_planos">
                        <? //include("vistas/documentos.php"); ?>
                    </div>
                </div>
                
                <div id="dash-actividad" class="two-column">
                    <h4 class="dash-title">
                        PARTES <? //include($pathraiz."/apps/proyectos/includes/tools-partes.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? //include("vistas/partes.php"); ?>
                </div>
                -->
                
            </div>
            <span class="stretch"></span>
            <div id="dash-entregas-ensayos" class="one-column" style="height: 350px;">
                <div id="dash" class="one-column">
                    <h4 class="dash-title">
                        PRUEBAS <? include($pathraiz."/apps/entregas/includes/tools-ensayos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="dash-pruebas-entrega">
                        <? //include("vistas/pruebas-entrega.php"); ?>
                    </div>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
</body>
</html>