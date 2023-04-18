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

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            $("#menuitem-lomio").addClass("active");
            
            $("#tabla-int tr").on("click", function() {
                window.open(
                    "/erp/apps/intervenciones/view.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            
            $("#tabla-previsiones tr").on("click", function() {
                window.open(
                    "/",
                    '_blank' 
                );
            });
            
            $("#tabla-ordenes tr").on("click", function() {
                window.open(
                    "/erp/apps/proyectos/view.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            
            $("#tabla-hitos tr").on("click", function() {
                window.open(
                    "/erp/apps/proyectos/view.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            
            $("#tabla-detalles-pedidos tr").on("click", function() {
                window.open(
                    "/erp/apps/material/editPedido.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            
            $("#tabla-ensayos tr").on("click", function() {
                window.open(
                    "/erp/apps/entregas/view.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            
            $("#tabla-doc-PER tr").on("click", function() {
                window.open(
                    "/erp/apps/prevencion/",
                    '_blank' 
                );
            });
            
            $("#tabla-jornada tr").on("click", function() {
                window.open(
                    "/erp/apps/jornada/",
                    '_blank' 
                );
            });
            
	});
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<style>
    .dash-title {
        background-color: #5cb85c;
        padding: 10px;
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
        margin-left: 0px;
        color: #ffffff;
    }
    .pre-scrollable {
        max-height: 230px;
    }
</style>
    

<title>COMO ESTÁ LO MIO | Erp GENELEK</title>
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
                COMO ESTÁ LO MIO
            </h3>
        </div>
        <div id="dash-header">
            <div class="two-column" style="min-height: 300px;max-height: 300px;">
                <h4 class="dash-title">
                    INTERVENCIONES
                </h4>
                <hr class="dash-underline">
                <div id="dash-intervenciones" class="pre-scrollable">
                    <? include($pathraiz."/apps/lomio/vistas/intervenciones.php"); ?>
                </div>
            </div>
            <div class="two-column" style="min-height: 300px;max-height: 300px;">
                <h4 class="dash-title">
                    PREVISIONES
                </h4>
                <hr class="dash-underline">
                <div id="doc-per-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/lomio/vistas/previsiones.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div class="two-column" style="min-height: 300px;max-height: 300px;">
                <h4 class="dash-title">
                    ORDENES DE TRABAJO
                </h4>
                <hr class="dash-underline">
                <div id="doc-per-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/lomio/vistas/ordenes.php"); ?>
                </div>
            </div>
            <div class="two-column" style="min-height: 300px;max-height: 300px;">
                <h4 class="dash-title">
                    HITOS
                </h4>
                <hr class="dash-underline">
                <div id="doc-per-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/lomio/vistas/hitos.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div class="two-column" style="min-height: 300px;max-height: 300px;">
                <h4 class="dash-title">
                    MATERIAL PEDIDOS
                </h4>
                <hr class="dash-underline">
                <div id="doc-per-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/lomio/vistas/pedidos.php"); ?>
                </div>
            </div>
            <div class="two-column" style="min-height: 300px;max-height: 300px;">
                <h4 class="dash-title">
                    TEST ENTREGAS
                </h4>
                <hr class="dash-underline">
                <div id="doc-per-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/lomio/vistas/entregas-pruebas.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div class="two-column" style="min-height: 300px;max-height: 300px;">
                <h4 class="dash-title">
                    DOCUMENTACIÓN PRL
                </h4>
                <hr class="dash-underline">
                <div id="doc-per-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/lomio/vistas/personal.php"); ?>
                </div>
            </div>
            <div class="two-column" style="min-height: 300px;max-height: 300px;">
                <h4 class="dash-title">
                    JORNADA LABORAL
                </h4>
                <hr class="dash-underline">
                <div id="doc-per-container" class="pre-scrollable">
                    <? include($pathraiz."/apps/lomio/vistas/jornada.php"); ?>
                </div>
            </div>
            
            <span class="stretch"></span>
        </div>
    </section>
	
</body>
</html>