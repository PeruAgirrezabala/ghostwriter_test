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

<!-- Bootstrap Treeview -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>

<!-- custom js -->
<script src="/erp/functions.js"></script>

<!-- Bootstrap switch -->
<link href="/erp/plugins/bootstrap-switch.min.css" rel="stylesheet">
<script src="/erp/plugins/bootstrap-switch.min.js"></script>

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	

            $("#menuitem-proyectos").addClass("active");
            
            loadSelectYears("filter_proyectos_years","PROYECTOS","fecha_ini","","");
            loadSelect("filter_proyectos","PROYECTOS","id","","","ref");
            loadSelect("filter_clientes","CLIENTES","id","","","");
            loadSelect("proyectos_clientes","CLIENTES","id","","","");
            loadSelect("proyectos_estados","PROYECTOS_ESTADOS","id","","","");
            
            $("#tabla-proyectos tr").click(function() {
                //alert($(this).data('id'));
            });
            
            $("#edit_proyecto").click(function() {
                //alert($(this).data('id'));
                $("#proyectos_clientes").val($("#proyectos_clienteid").val());
                $("#proyectos_clientes").selectpicker('refresh');
                $("#proyectos_estados").val($("#proyectos_estadoid").val());
                $("#proyectos_estados").selectpicker('refresh');
                $("#project-view").hide();
                $("#project-edit").fadeIn();
            });
            
            $("#save_proyectos").click(function() {
                $("#proyectos_btn_save").click();
            });
            
            $("#proyectos_btn_save").click(function() {
                $("#proyectos_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_proyecto").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveProyectos.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_proyecto').trigger("reset");
                        refreshSelects();
                        $("#proyectos_btn_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#proyectos_success").slideDown();
                        setTimeout(function(){
                            $("#proyectos_success").fadeOut("slow");
                            window.location.reload();
                        }, 3000);
                    }   
                });
            });
            
            $('#filter_proyectos').on('changed.bs.select', function (e) {
                //alert($(this).parent());
                //console.log($(this).parent().children("button"));
                //$(this).parent().children("button").addClass("filter-selected");
                window.location.href = "view.php?id=" + $(this).val();
            });
            
            $(".oferta").click(function() {
                //alert($(this).data("id"));
                $.ajax({
                    type: "GET",  
                    url: "responseDocsOfertas.php",
                    data: {
                        id: $(this).data("id")
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        console.log("docs ofertas");
                        initTree(response, "treeview_json_docsOfertas");
                        $("#add_oferta_model").modal('show');
                    }   
                });
            });
            
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
            
            $.ajax({
                type: "GET",  
                url: "responsePlanos.php",
                data: {
                    id: <? echo $_GET["id"]; ?>
                },
                dataType: "json",       
                success: function(response)  
                {
                      console.log("ok");
                      initTree(response, "treeview_json_planos");
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

<title>Proyectos | Erp GENELEK</title>
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
            <h3 id="project-title">
                
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="two-column">
                <h4 class="dash-title">
                    <? include($pathraiz."/apps/proyectos/includes/tools-single-project.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/current-project.php"); 
                ?>
            </div>
            <div id="dash-aside" class="two-column">
                <div id="dash-alertas" class="two-column">
                    <h4 class="dash-title">
                        OFERTAS <? include($pathraiz."/apps/proyectos/includes/tools-ofertas.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? include("vistas/ofertas.php"); ?>
                </div>
                <div id="proyecto-documentos" class="two-column">
                    <h4 class="dash-title">
                        DOCUMENTOS <? include($pathraiz."/apps/proyectos/includes/tools-documentos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="treeview_json">
                        <? //include("vistas/documentos.php"); ?>
                    </div>
                </div>
                <span class="stretch"></span>
                <div id="proyecto-planos" class="two-column">
                    <h4 class="dash-title">
                        PLANOS <? include($pathraiz."/apps/proyectos/includes/tools-planos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="treeview_json_planos">
                        <? //include("vistas/documentos.php"); ?>
                    </div>
                </div>
                <div id="dash-actividad" class="two-column">
                    <h4 class="dash-title">
                        PARTES <? include($pathraiz."/apps/proyectos/includes/tools-partes.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? //include($pathraiz."/vistas/erp-actividad.php"); ?>
                </div>
                <span class="stretch"></span>
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        INTERVENCIONES <? include($pathraiz."/apps/proyectos/includes/tools-intervenciones.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? //include($pathraiz."/vistas/erp-actividad.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
	
</body>
</html>