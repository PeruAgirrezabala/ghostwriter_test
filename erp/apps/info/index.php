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

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            $("#menuitem-infoempresa").addClass("active");
            
            loadSelect("newregistro_empresa","EMPRESAS","id","","","");
            loadSelect("filter_empresas","EMPRESAS","id","","","");
            
            empresa = "<? echo $_GET['empresa'] ?>";
            
            $('#filter_empresas').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                location.href = "/erp/apps/info/?empresa=" + $(this).val();
            });
            
            setTimeout(function(){
                
                if (empresa == "") {
                    $("#filter_empresas").selectpicker("val", 1);
                    $("#newregistro_empresa").selectpicker("val", 1);
                }
                else {
                    $("#filter_empresas").selectpicker("val", empresa);
                    $("#newregistro_empresa").selectpicker("val", empresa);
                };
                $('#filter_empresas').parent().children("button").addClass("filter-selected");
            }, 1000);
            
            // OPEN MODALS 
            $("#add-registro").click(function() {
                $("#newregistro_plataforma").val("");
                $("#newregistro_usuario").val("");
                $("#newregistro_pass").val("");
                $("#newregistro_desc").val("");
                $("#addRegistro_model").modal('show');
            });
            $("#edit_info").click(function() {
                $("#info-view").hide();
                $("#info-edit").show();
            });
            $("#cancel_info").click(function() {
                $("#info-view").show();
                $("#info-edit").hide();
            });
            
            // INFO EMPRESA
            $("#info_edit_btn_save").click(function() {
                $("#info_edit_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_editinfo").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveInfo.php",  
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
            
            // REGISTROS
            $("#btn_save_registro").click(function() {
                $("#btn_save_registro").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_registro").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveRegistro.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_registro').trigger("reset");
                        $("#btn_save_registro").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newregistro_success").slideDown();
                        setTimeout(function(){
                            $("#newregistro_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            $("#tabla-registros tr > td:not(:nth-child(5))").click(function() {
                loadRegistroInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#addRegistro_model").modal('show');
            });
            
            // ######## DELETE #######
            $(".remove-registro").click(function() {
                $("#del_reg_plat").val($(this).data("id"));
                $("#confirm_del_reg_plat_model").modal("show");
            });
            $("#btn_del_registro_modal").click(function() {
                $("#del_reg_plat").val($("#newregistro_idreg").val());
                $("#confirm_del_reg_plat_model").modal("show");
            });
            $("#btn_del_registro").click(function(){
                $.ajax({
                    type : 'POST',
                    url : 'saveRegistro.php',
                    dataType : 'text',
                    data: {
                        newregistro_delreg : $("#del_reg_plat").val()
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
            
        });
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>
    Información de Empresa | Erp GENELEK
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
                Información de Empresa
            </h3>
        </div>
        <div id="dash-header">
            <div id="proyectos-filterbar" class="one-column">
                <? include("vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-infoempresa" class="one-column">
                <h4 class="dash-title">
                    INFORMACIÓN <? include("includes/tools-info.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-empresas" style="padding:10px;">
                    <? 
                        include("vistas/info-empresa.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-registrosempresa" class="one-column">
                <h4 class="dash-title">
                    REGISTROS PLATAFORMAS
                    <? 
                        include("includes/tools-registros.php"); 
                    ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-registros" style="padding:10px;">
                    <? 
                        include("vistas/registros-empresa.php"); 
                    ?>
                </div>
            </div>
        </div>
        
        
    </section>
	
</body>
</html>