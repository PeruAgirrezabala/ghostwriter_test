<?
    include("common.php");
    //session_start();
    
    if(!isset($_SESSION['user_session']))
    {
        $logeado = checkCookie();
        if ($logeado == "no") {
            header("Location: /login.php");
        }
    }
    else {
        if ($_SESSION['user_rol'] != "SUPERADMIN") {
            header("Location: /");
        }
    }
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link href="/css/tools.css" rel="stylesheet">
<!-- <link rel="shortcut icon" href="/img/favicon.ico"> -->
<link rel="icon" type="image/png" href="/img/favicon.png" />

<!--<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script> 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

<link href="/apps/crm/dist/jquery.bootgrid.css" rel="stylesheet" />

<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 

<script src="/apps/crm/dist/jquery.bootgrid.min.js"></script>

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
<script src="functions.js"></script>

<!-- Bootstrap switch -->
<link href="/plugins/bootstrap-switch.min.css" rel="stylesheet">
<script src="/plugins/bootstrap-switch.min.js"></script>

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            //Hide toodas las vistas
            $("#accesosroles").hide();
            
            url = window.location.href;
            params = url.split('?')[1];
            vista = params.split('=')[1].replace('#','');
            if (vista === "c") {
                $("#accesosweroi").hide();
                $("#menuclientes").addClass("active");
            }
            else {
                $("#accesosclientes").hide();
                $("#menuweroi").addClass("active");
            }
            
            loadGridClientes();
            loadGrid();
            
            $('input[name="chkescritura"]').bootstrapSwitch('state', false, true);
            $('input[name="chkescritura-weroi"]').bootstrapSwitch('state', false, true);
            
            loadSelect("accesosroles_roles","tools_roles","id","","");
            loadSelect("edit_accesosroles_roles","tools_roles","id","","");
            loadSelect("new_accesosroles_roles","tools_roles","id","","");
            loadSelect("accesos_proyecto","tools_proyectos","id","","");
            loadSelect("edit_accesos_proyecto","tools_proyectos","id","","");
            
            $('#accesosroles_roles').on('changed.bs.select', function (e) {
                //alert($(this).val());
                $('#cover').fadeIn('slow');
                $("#app_boolean_id").val("");
                $("#app_bitly_id").val("");
                $("#app_crm_id").val("");
                $("#app_eventos_id").val("");
                $("#app_juntador_id").val("");
                $("#app_tracking_id").val("");
                loadSoloNombre($(this).val(),"tools_roles");
                loadRoles($(this).val(),"tools_roles_apps");
                $("#accesosroles_btn_del").prop("disabled", false);
                $('#cover').fadeOut('slow');
            });
            
            $("#desasignar-proyecto").prop("disabled", true);
            $("#asignar-proyecto").prop("disabled", true);
            $("#desasignar-proyecto-weroi").prop("disabled", true);
            $("#asignar-proyecto-weroi").prop("disabled", true);
            
            $("#crmmenu li").click('',function(){
                
                //  ret = DetailsView.GetProject($(this).attr("#data-id"), OnComplete, OnTimeOut, OnError);
                var list = $(this).parent().find('li');
                $(list.get().reverse()).each(function () {
                    if ( $("#"+$(this).attr("data-id")).is(":visible") === true ) {
                        //alert($(this).attr("data-id"));
                        //hide la vista que est� activa
                        $("#"+$(this).attr("data-id")).hide("slide", { direction: "left" }, 1000);
                    }
                    //quitar la clase active de todos los li
                    $(this).removeClass("active");
                });
                //asignar la clase active del li clickado
                $(this).addClass("active");
                $("#"+$(this).attr("data-id")).delay(1500).show("slide", { direction: "right" }, 1000);
            });
        }); 
            
        
        
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<style>
    .dropdown-menu li:nth-child(5), li:nth-child(n+13):nth-child(-n+36) {
        display: inherit;
    }
</style>

<title>Gestión de Accesos | Tools WEROI</title>
</head>

<body>
    <div id="cover">
        <div class="box">
            <img src="/img/logo.png" class="spinnerlogo">
            <img src="/img/loading.gif" class="spinner">
        </div>
    </div>
     <!--rest of the page... -->
    <? include($pathraiz."/includes/header.php"); ?>
    
    <section id="contenido">
    	<div id="crmcontainer">
            <h2><img class="iconTittle" src="/img/accesos.png"> GESTIÓN DE ACCESOS</h2>
            <hr width="100%" class="separatorCRM">
            <? include("includes/accesosmenu.php"); ?>
                        
            <? include("vistas/accesosroles.php"); ?>
            <? include("vistas/accesosweroi.php"); ?>
            <? include("vistas/accesosclientes.php"); ?>
            
            <!-- crmConfirmDelete -->
            <div class="modal fade" id="confirm-delete" data-usuarioid="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            ELIMINAR USUARIO
                        </div>
                        <div class="modal-body">
                            ¿Estas seguro de que deseas eliminar el Usuario?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-ok" data-dismiss="modal" id="delUsuario">Eliminar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- crmConfirmDelete -->
            
            <!-- crmConfirmDelete -->
            <div class="modal fade" id="confirm-delete-client" data-usuarioid="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            ELIMINAR CLIENTE
                        </div>
                        <div class="modal-body">
                            ¿Estas seguro de que deseas eliminar el Cliente?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-ok" data-dismiss="modal" id="delClient">Eliminar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- crmConfirmDelete -->
        </div>
    </section>
     
</body>
</html>

<script type="text/javascript">

// clientes
    
function loadGridClientes () {
    $("#clients_grid").bootgrid('destroy');
    var grid = $("#clients_grid").bootgrid({
            ajax: true,
            rowSelect: true,
            post: function ()
            {
                    /* To accumulate custom parameter with the request object */
                    return {
                            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
            },

            url: "response_clientes.php",
            formatters: {
                    "commands": function(column, row)
                    {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
                            "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";

                    }
            }
    }).on("loaded.rs.jquery.bootgrid", function()
    {
            $("#clients-command-add").appendTo("#clients_grid-header .actionBar");
            $("#clients-command-add").css("float","left");
            $('#editclient_passwordUsuario').val("");

            /* Executes after data is loaded and rendered */
            grid.find(".command-edit").on("click", function(e)
            {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele =$(this).parent();
                    var g_id = $(this).parent().siblings(':first').html();
                    var g_name = $(this).parent().siblings(':nth-of-type(2)').html();
                    console.log(g_id);
                    console.log(g_name);

                    //console.log(grid.data());//
                    $('#editclient_model').modal('show');

                    if($(this).data("row-id") >0) {
                            // collect the data
                            $('#editclient_id').val(ele.siblings(':first').html()); // in case we're changing the key
                            $('#editclient_nombreUsuario').val(ele.siblings(':nth-of-type(2)').html().replace(/&nbsp;/gi,''));
                            $('#editclient_apellidosUsuario').val(ele.siblings(':nth-of-type(3)').html().replace(/&nbsp;/gi,''));
                            $('#editclient_emailUsuario').val(ele.siblings(':nth-of-type(4)').html().replace(/&nbsp;/gi,''));
                            $('#editclient_telefono').val(ele.siblings(':nth-of-type(5)').html().replace(/&nbsp;/gi,''));
                            $('#editclient_empresa').val(ele.siblings(':nth-of-type(6)').html().replace(/&nbsp;/gi,''));
                            $('#editclient_passwordUsuario').val("");                                
                            if(ele.siblings(':nth-of-type(8)').html().replace(/&nbsp;/gi,'') === "on") {
                                $('input[name="chkactivoclient"]').bootstrapSwitch('state', true, true);
                            }
                            else {
                                $('input[name="chkactivoclient"]').bootstrapSwitch('state', false, true);
                            }
                            loadSelectAccesosProyectos(g_id);
                    } else {
                        alert('Ninguna fila seleccionada! Primero selecciona una fila, después clicka en el botón editar');
                    }
            }).end().find(".command-delete").on("click", function(e)
            {
                    //var conf = confirm('Delete ' + $(this).data("row-id") + ' items?');
                    //alert(conf);
                    //alert($(this).data("row-id"));
                    $("#confirm-delete-client").modal("show");
                    $('#confirm-delete-client').attr("data-usuarioid",$(this).data("row-id"));

                    //if(conf){
                            //$.post('response.php', { id: $(this).data("row-id"), action:'delete'}
                                //, function(){
                                    // when ajax returns (callback), 
                                    //$("#employee_grid").bootgrid('reload');
                            //}); 
                            //$(this).parent('tr').remove();
                            //$("#employee_grid").bootgrid('remove', $(this).data("row-id"))
                    //}
            });
    });
    //$("#employee_grid").bootgrid('reload');		
};

// *******

function loadGrid () {
    $("#weroi_grid").bootgrid('destroy');   
    var grid = $("#weroi_grid").bootgrid({
            ajax: true,
            rowSelect: true,
            post: function ()
            {
                    /* To accumulate custom parameter with the request object */
                    return {
                            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
            },

            url: "response_usuarios.php",
            formatters: {
                    "commands": function(column, row)
                    {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
                            "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";

                    }
            }
    }).on("loaded.rs.jquery.bootgrid", function()
    {
            
            $("#command-add").appendTo("#weroi_grid-header .actionBar");
            $("#command-add").css("float","left");
            $('#edit_passwordUsuario').val("");

            /* Executes after data is loaded and rendered */
            grid.find(".command-edit").on("click", function(e)
            {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele =$(this).parent();
                    var g_id = $(this).parent().siblings(':first').html();
                    var g_name = $(this).parent().siblings(':nth-of-type(2)').html();
                    console.log(g_id);
                    console.log(g_name);

                    //console.log(grid.data());//
                    $('#edit_model').modal('show');

                    if($(this).data("row-id") >0) {
                            // collect the data
                            $('#edit_id').val(ele.siblings(':first').html()); // in case we're changing the key
                            $('#edit_nombreUsuario').val(ele.siblings(':nth-of-type(2)').html().replace(/&nbsp;/gi,''));
                            $('#edit_emailUsuario').val(ele.siblings(':nth-of-type(4)').html().replace(/&nbsp;/gi,''));
                            $('#edit_apellidosUsuario').val(ele.siblings(':nth-of-type(3)').html().replace(/&nbsp;/gi,''));
                            $('#edit_tlfnoUsuario').val(ele.siblings(':nth-of-type(5)').html().replace(/&nbsp;/gi,''));
                            $('#edit_empresaUsuario').val(ele.siblings(':nth-of-type(6)').html().replace(/&nbsp;/gi,''));
                            $('#edit_passwordUsuario').val("");                                
                            $('#edit_accesosroles_roles').selectpicker('val', ele.siblings(':nth-of-type(11)').html());
                            if(ele.siblings(':nth-of-type(9)').html().replace(/&nbsp;/gi,'') === "on") {
                                $('input[name="chkactivo"]').bootstrapSwitch('state', true, true);
                            }
                            else {
                                $('input[name="chkactivo"]').bootstrapSwitch('state', false, true);
                            }
                            loadSelectAccesosProyectosWeroi(g_id);
                    } else {
                        alert('Ninguna fila seleccionada! Primero selecciona una fila, después clicka en el botón editar');
                    }
            }).end().find(".command-delete").on("click", function(e)
            {
                    //var conf = confirm('Delete ' + $(this).data("row-id") + ' items?');
                    //alert(conf);
                    //alert($(this).data("row-id"));
                    $("#confirm-delete").modal("show");
                    $('#confirm-delete').attr("data-usuarioid",$(this).data("row-id"));

                    //if(conf){
                            //$.post('response.php', { id: $(this).data("row-id"), action:'delete'}
                                //, function(){
                                    // when ajax returns (callback), 
                                    //$("#employee_grid").bootgrid('reload');
                            //}); 
                            //$(this).parent('tr').remove();
                            //$("#employee_grid").bootgrid('remove', $(this).data("row-id"))
                    //}
            });
    });
    //$("#employee_grid").bootgrid('reload');		
};

$( document ).ready(function() {
    $('#add_model').on('shown.bs.modal', function() { 
       $('#new_cualificacion').selectpicker('val',4);
    }) ;
    
    function delUsuario (id) {
        $.post('response_usuarios.php', { id: id, action:'delete'}
            , function(){
                // when ajax returns (callback), 
                $("#weroi_grid").bootgrid('reload');
        }); 
    }
    
    function delCliente (id) {
        $.post('response_clientes.php', { id: id, action:'delete'}
            , function(){
                // when ajax returns (callback), 
                $("#clients_grid").bootgrid('reload');
        }); 
    }
    
    $( "#delUsuario" ).click(function() {
        delUsuario ($('#confirm-delete').attr("data-usuarioid"));
    });
    
    $( "#delClient" ).click(function() {
        delCliente ($('#confirm-delete-client').attr("data-usuarioid"));
    });
    
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    
    function validateFieldsWeroi (action) {
        // validacion de los campos oblicagorios dependiendo del boton seleccionado
        stopProcess = 0;
        $(".labelerror").hide();
        
        switch(action) {
            case "add":
                if ($("#new_nombreUsuario").val() === "") {
                    stopProcess = 1;
                    $("#new_nombreUsuario-error").show();
                }
                if ($("#new_apellidosUsuario").val() === "") {
                    stopProcess = 1;
                    $("#new_apellidosUsuario-error").show();
                }
                if ($("#new_emailUsuario").val() === "") {
                    stopProcess = 1;
                    $("#new_emailUsuario-error").html("* Este campo es obligatorio");
                    $("#new_emailUsuario-error").show();
                }
                else {
                    var email = $("#new_emailUsuario").val();
                    if (validateEmail(email)) {
                        
                    }
                    else {
                        stopProcess = 1;
                        $("#new_emailUsuario-error").html("* Introduzca un email válido");
                        $("#new_emailUsuario-error").show();
                    }
                }
                if ($("#new_tlfnoUsuario").val() === "") {
                    stopProcess = 1;
                    $("#new_tlfnoUsuario-error").show();
                }
                if ($("#new_empresaUsuario").val() === "") {
                    stopProcess = 1;
                    $("#new_empresaUsuario-error").show();
                }
                if ($("#new_passwordUsuario").val() === "") {
                    stopProcess = 1;
                    $("#new_passwordUsuario-error").show();
                }
                if ($("#new_accesosroles_roles").val() === "") {
                    stopProcess = 1;
                    $("#new_accesosroles_roles-error").show();
                }
                break;
            case "edit":
                if ($("#edit_nombreUsuario").val() === "") {
                    stopProcess = 1;
                    $("#edit_nombreUsuario-error").show();
                }
                if ($("#edit_apellidosUsuario").val() === "") {
                    stopProcess = 1;
                    $("#edit_apellidosUsuario-error").show();
                }
                if ($("#edit_emailUsuario").val() === "") {
                    stopProcess = 1;
                    $("#edit_emailUsuario-error").show();
                }
                else {
                    var email = $("#edit_emailUsuario").val();
                    if (validateEmail(email)) {
                        
                    }
                    else {
                        stopProcess = 1;
                        $("#edit_emailUsuario-error").html("* Introduzca un email válido");
                        $("#edit_emailUsuario-error").show();
                    }
                }
                if ($("#edit_tlfnoUsuario").val() === "") {
                    stopProcess = 1;
                    $("#edit_tlfnoUsuario-error").show();
                }
                if ($("#edit_empresaUsuario").val() === "") {
                    stopProcess = 1;
                    $("#edit_empresaUsuario-error").show();
                }
                if ($("#edit_accesosroles_roles").val() === "") {
                    stopProcess = 1;
                    $("#edit_accesosroles_roles-error").show();
                }
                break;
        }
        
        if (stopProcess == 0) {
            $(".labelerror").hide();
        }
                
        return stopProcess;
    } // function validate
    
    
    function validateFieldsClientes (action) {
        // validacion de los campos oblicagorios dependiendo del boton seleccionado
        stopProcess = 0;
        
        switch(action) {
            case "add":
                if ($("#newclient_nombreUsuario").val() === "") {
                    stopProcess = 1;
                    $("#newclient_nombreUsuario-error").show();
                }
                if ($("#newclient_apellidosUsuario").val() === "") {
                    stopProcess = 1;
                    $("#newclient_apellidosUsuario-error").show();
                }
                if ($("#newclient_emailUsuario").val() === "") {
                    stopProcess = 1;
                    $("#newclient_emailUsuario-error").html("* Este campo es obligatorio");
                    $("#newclient_emailUsuario-error").show();
                }
                else {
                    var email = $("#newclient_emailUsuario").val();
                    if (validateEmail(email)) {
                        
                    }
                    else {
                        stopProcess = 1;
                        $("#newclient_emailUsuario-error").html("* Introduzca un email válido");
                        $("#newclient_emailUsuario-error").show();
                    }
                }
                if ($("#newclient_telefono").val() === "") {
                    stopProcess = 1;
                    $("#newclient_telefono-error").show();
                }
                if ($("#newclient_empresa").val() === "") {
                    stopProcess = 1;
                    $("#newclient_empresa-error").show();
                }
                if ($("#newclient_passwordUsuario").val() === "") {
                    stopProcess = 1;
                    $("#newclient_passwordUsuario-error").show();
                }
                break;
            case "edit":
                if ($("#editclient_nombreUsuario").val() === "") {
                    stopProcess = 1;
                    $("#editclient_nombreUsuario-error").show();
                }
                if ($("#editclient_apellidosUsuario").val() === "") {
                    stopProcess = 1;
                    $("#editclient_apellidosUsuario-error").show();
                }
                if ($("#editclient_emailUsuario").val() === "") {
                    stopProcess = 1;
                    $("#editclient_emailUsuario-error").show();
                }
                else {
                    var email = $("#editclient_emailUsuario").val();
                    if (validateEmail(email)) {
                        
                    }
                    else {
                        stopProcess = 1;
                        $("#editclient_emailUsuario-error").html("* Introduzca un email válido");
                        $("#editclient_emailUsuario-error").show();
                    }
                }
                if ($("#editclient_telefono").val() === "") {
                    stopProcess = 1;
                    $("#editclient_telefono-error").show();
                }
                if ($("#editclient_empresa").val() === "") {
                    stopProcess = 1;
                    $("#editclient_empresa-error").show();
                }
                break;
        }
        
        if (stopProcess == 0) {
            $(".labelerror").hide();
        }
                
        return stopProcess;
    } // function validate
     
    function ajaxAction(action) {
        stopProcess = 0;
        validacion = 0;
        if (action == "edit") {
            validacion = validateFieldsWeroi("edit");
            if (validacion == 1) {
                stopProcess = 1;
                $("#errorNewUsuario").html("Todos los campos son obligatorios");
                $("#alertNewUsuario").slideDown();
                setTimeout(function(){
                    $("#alertNewUsuario").fadeOut("slow"); 
                }, 5000);
            }
            else {
                $("#btn_edit").html('<img src="/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
            }
        }
        if (action == "add") {
            validacion = validateFieldsWeroi("add");
            if (validacion == 1) {
                stopProcess = 1;
                $("#errorNewUsuario").html("Todos los campos son obligatorios");
                $("#alertNewUsuario").slideDown();
                setTimeout(function(){
                    $("#alertNewUsuario").fadeOut("slow"); 
                }, 5000);
            }
            else {
                $("#btn_add").html('<img src="/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
            }
        }
        if (stopProcess == 0) {
            data = $("#frm_"+action).serializeArray();
            $.ajax({
                type: "POST",  
                url: "response_usuarios.php",  
                data: data,
                dataType: "json",       
                success: function(response)  
                {
                    if(response.error) {
                        $("#new_emailUsuario-error").html("* Email ya existente");
                        $("#new_emailUsuario-error").show();
                        $("#errorNewUsuario").html(response.error);
                        $("#alertNewUsuario").slideDown();
                        setTimeout(function(){
                            $("#alertNewUsuario").fadeOut("slow"); 
                        }, 5000);
                    }
                    else {
                        $("#new_emailUsuario-error").html("");
                        $("#new_emailUsuario-error").hide();
                        $('#'+action+'_model').modal('hide');
                        $("#weroi_grid").bootgrid('reload');
                        $('#frm_add').trigger("reset");
                        $('#frm_edit').trigger("reset");
                        refreshSelects();
                    }
                    $("#btn_edit").html('&nbsp; Guardar');
                    $("#btn_add").html('&nbsp; Guardar');
                }   
            });
        }
    }
    
    function ajaxActionClient(action) {
        stopProcess = 0;
        validacion = 0;
        if (action == "edit") {
            validacion = validateFieldsClientes("edit");
            if (validacion == 1) {
                stopProcess = 1;
                $("#errorNewCliente").html("Todos los campos son obligatorios");
                $("#alertNewCliente").slideDown();
                setTimeout(function(){
                    $("#alertNewCliente").fadeOut("slow"); 
                }, 5000);
            }
            else {
                $("#client_btn_edit").html('<img src="/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
            }
        }
        if (action == "add") {
            validacion = validateFieldsClientes("add");
            if (validacion == 1) {
                stopProcess = 1;
                $("#errorNewCliente").html("Todos los campos son obligatorios");
                $("#alertNewCliente").slideDown();
                setTimeout(function(){
                    $("#alertNewCliente").fadeOut("slow"); 
                }, 5000);
            }
            else {
                $("#client_btn_add").html('<img src="/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
            }
        }
        if (stopProcess == 0) {
            data = $("#frm_"+action+"_client").serializeArray();
            $.ajax({
                type: "POST",  
                url: "response_clientes.php",  
                data: data,
                dataType: "json",       
                success: function(response)  
                {
                    if(response.error) {
                        $("#newclient_emailUsuario-error").html("Email ya existente");
                        $("#newclient_emailUsuario-error").show();
                        $("#errorNewCliente").html(response.error);
                        $("#alertNewCliente").slideDown();
                        setTimeout(function(){
                            $("#alertNewCliente").fadeOut("slow"); 
                        }, 5000);
                    }
                    else {
                        $("#newclient_emailUsuario-error").hide();
                        $("#newclient_emailUsuario-error").html("");
                        $('#'+action+'client_model').modal('hide');
                        $("#clients_grid").bootgrid('reload');
                        $('#frm_add_client').trigger("reset");
                        $('#frm_edit_client').trigger("reset");
                        refreshSelects();
                    }
                    $("#client_btn_edit").html('&nbsp; Guardar');
                    $("#client_btn_add").html('&nbsp; Guardar');
                }   
            });
        }
    }
    
    $( "#accesosroles_btn_save" ).click(function() {
        $("#accesosroles_btn_save").html('<img src="/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
        data = $("#frm_roles").serializeArray();
        $.ajax({
            type: "POST",  
            url: "saveRoles.php",  
            data: data,
            dataType: "json",       
            success: function(response)  
            {
                $('#frm_roles').trigger("reset");
                //$('#crmclientes_clientes').selectpicker('destroy');
                loadSelect("accesosroles_roles","tools_roles","id","","");
                loadSelect("edit_accesosroles_roles","tools_roles","id","","");
                $('#accesosroles_roles').selectpicker('render');
                $('#edit_accesosroles_roles').selectpicker('render');
                $("*[data-id]").removeClass("appSelected");
                refreshSelects();
                $("#accesosroles_btn_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
            }   
        });
    });
    $( "#accesosroles_btn_clean" ).click(function() {
        $('#frm_roles').trigger("reset");
        $('#accesosroles_roles').selectpicker('render');
        $("#accesosroles_btn_del").prop("disabled", true);
    });
    $( "#accesosroles_btn_del" ).click(function() {
        $("#accesosroles_btn_del").html('<img src="/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
        $('#accesosroles_delrole').val($('#accesosroles_roles').val());
        data = $("#frm_roles").serializeArray();
        $.ajax({
            type: "POST",  
            url: "saveRoles.php",  
            data: data,
            dataType: "json",       
            success: function(response)  
            {
                $('#frm_roles').trigger("reset");
                //$('#crmclientes_clientes').selectpicker('destroy');
                loadSelect("accesosroles_roles","tools_roles","id","","");
                $('#accesosroles_roles').selectpicker('render');
                $("*[data-id]").removeClass("appSelected");
                refreshSelects();
                $("#accesosroles_btn_del").html('<span class="glyphicon glyphicon-remove"></span> Eliminar');
                if($('#accesosroles_delrole').val() != "") {
                    $("#accesosroles_delsuccess").slideDown();
                    setTimeout(function(){
                      $("#accesosroles_delsuccess").fadeOut("slow"); 
                    }, 5000);
                }
                else {
                    $("#accesosroles_success").slideDown();
                    setTimeout(function(){
                      $("#accesosroles_success").fadeOut("slow"); 
                    }, 5000);
                }
                    
                $('#accesosroles_delrole').val("");
            }   
        });
    });
    
    $( "#command-add" ).click(function() {
        $('#add_model').modal('show');
    });
    
    $( "#btn_add" ).click(function() {
        ajaxAction('add');
    });
    
    $( "#btn_edit" ).click(function() {
        ajaxAction('edit');
    });
    
    $( "#clients-command-add" ).click(function() {
        $('#addclient_model').modal('show');
    });
    
    $( "#client_btn_add" ).click(function() {
        ajaxActionClient('add');
    });
    
    $( "#client_btn_edit" ).click(function() {
        ajaxActionClient('edit');
    });
    
    $(".appsSelector img").click(function() {
        if ($(this).hasClass("appSelected")) {
            $(this).removeClass("appSelected");
            $("#"+$(this).attr("data-app")).val("");
        }
        else {
            $(this).addClass("appSelected");
            $("#"+$(this).attr("data-app")).val($(this).attr("data-id"));
        }
    });
    
    $('input[name="chkactivo"]').on('switchChange.bootstrapSwitch', function(event, state) {
        console.log(this); // DOM element
        console.log(event); // jQuery event
        console.log(state); // true | false
    });
    
    $( "#accesos_proyecto" ).on("change",function() {
        $("#asignar-proyecto").prop("disabled", false);
    });
    
    $( "#asignar-proyecto" ).click(function() {
        //alert($('#accesos_proyecto').val());
        asignarProyecto ($('#accesos_proyecto').val(), $('#editclient_id').val(), "add", $("#chkescritura").bootstrapSwitch('state'));
    });
    $( "#desasignar-proyecto" ).click(function() {
        //alert($('#accesos_proyecto').val());
        if ($('#editclient_proyectosacceso').val()) {
            proyecto = $('#editclient_proyectosacceso').val()[0];
        }
        else {
            proyecto = 0;
        }
        asignarProyecto (proyecto, $('#editclient_id').val(), "del");
    });
    $("#editclient_proyectosacceso").on("change", function() {
        $("#desasignar-proyecto").prop("disabled", false);
    });
    
    $(".alert button.close").click(function (e) {
        $(this).parent().fadeOut('slow');
    });
    
    $( "#edit_accesos_proyecto" ).on("change",function() {
        $("#asignar-proyecto-weroi").prop("disabled", false);
    });
    
    $( "#asignar-proyecto-weroi" ).click(function() {
        //alert($('#accesos_proyecto').val());
        asignarProyectoWeroi ($('#edit_accesos_proyecto').val(), $('#edit_id').val(), "add", $("#chkescritura-weroi").bootstrapSwitch('state'));
    });
    $( "#desasignar-proyecto-weroi" ).click(function() {
        //alert($('#edit_accesos_proyecto').val());
        if ($('#edit_proyectosacceso').val()) {
            proyecto = $('#edit_proyectosacceso').val()[0];
        }
        else {
            proyecto = 0;
        }
        asignarProyectoWeroi (proyecto, $('#edit_id').val(), "del");
    });
    $("#edit_proyectosacceso").on("change", function() {
        $("#desasignar-proyecto-weroi").prop("disabled", false);
    });

    $(".alert-dismissable").click(function (e) {
        $(this).fadeOut('slow');
    });
});
</script>