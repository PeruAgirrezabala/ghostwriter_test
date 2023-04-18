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
            
            $('#menuitem-parametros').addClass('active');
            
            loadSelect("newhora_perfil","PERFILES","id","","");
            loadSelect("newhora_tipo","TIPOS_HORA","id","","");
            loadSelect("newtarea_perfil","PERFILES","id","","");
            
            // OPEN MODALS 
            $("#add-perfil").click(function() {
                $("#addPerfil_model").modal('show');
            });
            $("#add-categoria").click(function() {
                $("#addCat_model").modal('show');
            });
            $("#add-hora").click(function() {
                $("#addHora_model").modal('show');
            });
            $("#add-tarea").click(function() {
                $("#addTarea_model").modal('show');
            });
            $("#add-tipohora").click(function() {
                $("#addTipohora_model").modal('show');
            });
          
            
            // GUARDADO GENERAL
            $("#btn_save_perfil").click(function() {
                $("#btn_save_perfil").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_perfil").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_perfil').trigger("reset");
                        $("#btn_save_perfil").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newperfil_success").slideDown();
                        setTimeout(function(){
                            $("#newperfil_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#btn_save_cat").click(function() {
                $("#btn_save_cat").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_cat").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_cat').trigger("reset");
                        $("#btn_save_cat").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newCat_success").slideDown();
                        setTimeout(function(){
                            $("#newCat_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#btn_save_hora").click(function() {
                $("#btn_save_hora").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_hora").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_hora').trigger("reset");
                        $("#btn_save_hora").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newhora_success").slideDown();
                        setTimeout(function(){
                            $("#newhora_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#btn_save_tarea").click(function() {
                $("#btn_save_tarea").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_tarea").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_tarea').trigger("reset");
                        $("#btn_save_tarea").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newtarea_success").slideDown();
                        setTimeout(function(){
                            $("#newtarea_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#btn_save_tipohora").click(function() {
                $("#btn_save_tipohora").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_tipohora").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_new_tipohora').trigger("reset");
                        $("#btn_save_tipohora").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newtipohora_success").slideDown();
                        setTimeout(function(){
                            $("#newtipohora_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            
            // EDITAR
            $("#tabla-perfiles tr > td:not(:nth-child(2))").click(function() {
                loadPerfilInfo($(this).parent("tr").data("id"));
                $("#addPerfil_model").modal('show');
            });
            $("#tabla-categorias tr > td:not(:nth-child(2))").click(function() {
                loadCategoriaInfo($(this).parent("tr").data("id"));
                $("#addCat_model").modal('show');
            });
            $("#tabla-tareas tr > td:not(:nth-child(4))").click(function() {
                loadTareaInfo($(this).parent("tr").data("id"));
                $("#addTarea_model").modal('show');
            });
            $("#tabla-horas tr > td:not(:nth-child(5))").click(function() {
                loadHoraInfo($(this).parent("tr").data("id"));
                $("#addHora_model").modal('show');
            });
            $("#tabla-tiposhora tr > td:not(:nth-child(2))").click(function() {
                loadTipoHoraInfo($(this).parent("tr").data("id"));
                $("#addTipohora_model").modal('show');
            });
            
            // ELIMNAR
            $("#btn_del_perfil").click(function() {
                $("#btn_del_perfil").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#newperfil_del").val($("#newperfil_id").val());
                data = $("#frm_new_perfil").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_new_perfil').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            $("#btn_del_cat").click(function() {
                $("#btn_del_cat").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#newCat_del").val($("#newCat_id").val());
                data = $("#frm_new_cat").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_new_cat').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            $("#btn_del_tarea").click(function() {
                $("#btn_del_tarea").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#newtarea_del").val($("#newtarea_id").val());
                data = $("#frm_new_tarea").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_new_tarea').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            $("#btn_del_hora").click(function() {
                $("#btn_del_hora").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#newhora_del").val($("#newhora_id").val());
                data = $("#frm_new_hora").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_new_hora').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            $("#btn_del_tipohora").click(function() {
                $("#btn_del_tipohora").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#newtipohora_del").val($("#newtipohora_id").val());
                data = $("#frm_new_tipohora").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                $.ajax({
                    type: "POST",  
                    url: "save.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_new_tipohora').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            
            // ######## BOTON ELIMINAR #######
            $(".del-perfil").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'save.php',
                    dataType : 'text',
                    data: {
                        newperfil_del : $(this).data("id")
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
            $(".del-categoria").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'save.php',
                    dataType : 'text',
                    data: {
                        newCat_del : $(this).data("id")
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
            $(".del-tipohora").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'save.php',
                    dataType : 'text',
                    data: {
                        newtipohora_del : $(this).data("id")
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
            $(".del-tarea").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'save.php',
                    dataType : 'text',
                    data: {
                        newtarea_del : $(this).data("id")
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
            $(".del-hora").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'save.php',
                    dataType : 'text',
                    data: {
                        newhora_del : $(this).data("id")
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
            
        });
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>PARÁMETROS | Erp GENELEK</title>
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
                PARÁMETROS
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-categorias" class="three-column">
                <h4 class="dash-title">
                    CATEGORÍAS
                    <? 
                        include("includes/tools-categorias.php"); 
                    ?>
                </h4>
                <div id="dash-empresas" style="padding:10px;">
                    <? 
                        include("vistas/tabla-categorias.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-perfiles" class="three-column">
                
                <h4 class="dash-title">
                    PERFILES
                    <? 
                        include("includes/tools-perfiles.php"); 
                    ?>
                </h4>
                <div id="dash-empresas" style="padding:10px;">
                    <? 
                        include("vistas/tabla-perfiles.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-tiposhora" class="three-column">
                <h4 class="dash-title">
                    TIPOS DE HORA
                    <? 
                        include("includes/tools-tiposhora.php"); 
                    ?>
                </h4>
                <div id="dash-empresas" style="padding:10px;">
                    <? 
                        include("vistas/tabla-tiposhora.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-tareas" class="two-column">
                <h4 class="dash-title">
                    TAREAS
                    <? 
                        include("includes/tools-tareas.php"); 
                    ?>
                </h4>
                <div id="dash-empresas" style="padding:10px;">
                    <? 
                        include("vistas/tabla-tareas.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-horas" class="two-column">
                <h4 class="dash-title">
                    HORAS
                    <? 
                        include("includes/tools-horas.php"); 
                    ?>
                </h4>
                <div id="dash-empresas" style="padding:10px;">
                    <? 
                        include("vistas/tabla-perfiles-horas.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
	
</body>
</html>