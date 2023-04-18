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

<!-- Bootstrap Treeview
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
    -->
    <link rel="stylesheet" href="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.js"></script>
    
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
<!-- Color Picker Spectrum -->
    <script src='/erp/includes/plugins/spectrum-master/src/spectrum.js'></script>
    <link rel='stylesheet' href='/erp/includes/plugins/spectrum-master/src/spectrum.css' />   

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            $("#menuitem-accesos").addClass("active");
            
            loadSelect("permisos_apps","erp_apps","id","","","nombre");
            loadSelect("newuser_roles","erp_roles","id","","","");
            loadSelect("newuser_empresas","EMPRESAS","id","","","");
            $("#newuser_color").spectrum({ 
            });
            
            // APPS ROLES
            $("#add-app").click(function() {
                $("#add-app").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                $.ajax({
                    type: "POST",  
                    url: "saveApp.php",  
                    data: {
                        app_id: $("#permisos_apps").val(),
                        role_id: $("#permisos_idrole").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response.trim());
                        
                        if (response.trim() == -1) {
                            $("#permisos_error").slideDown();
                            setTimeout(function(){
                                $("#permisos_error").fadeOut("slow");
                                $("#add-app").html('<img src="/erp/img/add.png" height="20">');
                            }, 2000);
                        }
                        else {
                            $("#add-app").html('<img src="/erp/img/add.png" height="20">');
                            loadContent("roles-permisos", "vistas/permisos-roles.php?role_id=" + $("#permisos_idrole").val());
                            //window.location.reload();
                        }
                    }   
                });
            });
            $("#add-all-app").click(function() {
                $("#add-app").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                $.ajax({
                    type: "POST",  
                    url: "saveApp.php",  
                    data: {
                        app_id: "all",
                        role_id: $("#permisos_idrole").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response.trim());
                        
                        if (response.trim() == -1) {
                            $("#permisos_error").slideDown();
                            setTimeout(function(){
                                $("#permisos_error").fadeOut("slow");
                                $("#add-app").html('<img src="/erp/img/add.png" height="20">');
                            }, 2000);
                        }
                        else {
                            $("#add-app").html('<img src="/erp/img/add.png" height="20">');
                            loadContent("roles-permisos", "vistas/permisos-roles.php?role_id=" + $("#permisos_idrole").val());
                            //window.location.reload();
                        }
                    }   
                });
            });
            
            // ROLES
            $("#btn_save_role").click(function() {
                $("#btn_save_role").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_role").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveRole.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.location.reload();
                    }   
                });
            });
            
            $("#add-role").click(function() {
                $("#addRole_model").modal('show');
            });
            $(".edit-role").click(function() {
                loadRoleInfo($(this).data("id"));
                $("#addRole_model").modal('show');
            });
            
            
            // USERS
            $("#btn_save_user").click(function() {
                console.log("tt2");
                $("#btn_save_user").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_user").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveUser.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Reemplazamos el reload por un window refresh:
                        // window.location.reload();
                        loadContent("users-container", "vistas/users.php");
                        $("#addUser_model").modal('hide');                        
                    }   
                });
                $("#btn_save_user").html('Guardar');
            });
            $("#tabla-roles tr > td:not(:nth-child(2)):not(:nth-child(3))").click(function() {
                loadContent("roles-permisos", "vistas/permisos-roles.php?role_id=" + $(this).parent("tr").data("id"));
                $("#roles-apps-container").show();
                $("#permisos_idrole").val($(this).parent("tr").data("id"));
            });
            $("#add-user").click(function() {
                $('#frm_new_user').trigger("reset");
                $("#newuser_iduser").val("");
                $("#newuser_empresas").val("");
                $("#newuser_roles").val("");
                $("#newuser_roles").selectpicker("val", "");
                $("#newuser_empresas").selectpicker("val", "");
                $("#newuser_color").spectrum({
                    color: ""
                });
                $("#addUser_model").modal('show');
            });
            $(document).on("click", ".edit-user", function(){
                loadUserInfo($(this).data("id"));
                $("#addUser_model").modal('show');
            });
            $(document).on("click", "#btn_avatar_user", function(){
                $("#avatar_user_model").modal('show');
            });
            $(document).on("click", ".avatar-icon", function(){
                //console.log("pulsado icono: "+$(this).data("id"));
                $("#tabla-users-avatares td:nth-child(-n+10)" ).css("background-color", "white");
                $(this).css("background-color", "#7ac1e8");
                
                // src = $(this).find('img').attr('src')  
                //console.log($(this).find('img').attr('src'));
                $("#newuser_avatar").val($(this).find('img').attr('src'));
            });
            $("#btn_save_avatar_user").click(function() {
                // Reemplazar visualmente el caambio
                $('#newuser_avatar_img').attr('src',$('#newuser_avatar').val());
                // cerrar modal
                $("#avatar_user_model").modal('hide');
            });
            // ######## DELETE #######
            $(".remove-role").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveRole.php',
                    dataType : 'text',
                    data: {
                        newrole_delrole : $(this).data("id")
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
            $(".remove-user").click(function() {
                $("#btn_delete_user").data("id", $(this).data("id"));
                $("#delete_user_model").modal('show');
            });
            $("#btn_delete_user").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveUser.php',
                    dataType : 'text',
                    data: {
                        newuser_deluser : $(this).data("id")
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
            $(document).on("click", ".remove-permiso-app", function(){
                $.ajax({
                    type : 'POST',
                    url : 'saveApp.php',
                    dataType : 'text',
                    data: {
                        app_delapp : $(this).data("id")
                    },
                    success : function(data){
                        //alert(data);
                        //console.log(data);
                        //window.location.reload();
                        loadContent("roles-permisos", "vistas/permisos-roles.php?role_id=" + $("#permisos_idrole").val());
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            
            $(document).on("click", "#view-users", function(){
                //console.log("kkkkk"+$("#view-users").val());
                                
                var onofftrabajadores = '';
                if($("#view-users").val()=='on'){
                    onofftrabajadores = 'on';
                    loadContent("users-container", "vistas/users.php?viewTrabajadores=" + onofftrabajadores);
                    $("#view-users").val('off');
                    $('#texto-trabajadores').text("Trabajadores en Activo");
                    $("#imgojo-trabajadores").attr('src','/erp/img/ojo.png');
                }else{
                    onofftrabajadores = 'off';
                    loadContent("users-container", "vistas/users.php?viewTrabajadores=" + onofftrabajadores);
                    $("#view-users").val('on');
                    $('#texto-trabajadores').text("Todos los Trabajadores");
                    $("#imgojo-trabajadores").attr('src','/erp/img/noojo.png');
                }
                
            });
        });
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>
    Gestión de accesos | Erp GENELEK
</title>
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
                Gestión de accesos
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-trabajadores" class="two-column">
                <h4 class="dash-title">
                    TRABAJADORES <? include("includes/tools-users.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="users-container" style="padding:10px;">
                    <? 
                        include("vistas/users.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-roles" class="four-column">
                <h4 class="dash-title">
                    ROLES
                    <? 
                        include("includes/tools-roles.php"); 
                    ?>
                </h4>
                <hr class="dash-underline">
                <div id="roles-container" style="padding:10px;">
                    <? 
                        include("vistas/roles.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-permisos" class="four-column">
                <h4 class="dash-title">
                    ROLES APPS <? include("includes/tools-permisos-apps.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="roles-permisos" style="padding:10px;">
                    <? 
                        //include("vistas/permisos.php"); 
                    ?>
                </div>
                <div class="alert-middle alert alert-danger alert-dismissable" id="permisos_error" style="display:none; margin: 0px auto 0px auto;">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <p>Permiso existente</p>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
        
        
    </section>
	
</body>
</html>