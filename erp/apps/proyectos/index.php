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

<!-- CHARTS -->
    <script src="/erp/includes/plugins/chart/dist/Chart.bundle.js"></script>

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
            loadSelect("filter_estados","PROYECTOS_ESTADOS","id","","","");
            loadSelect("newproyecto_clientes","CLIENTES","id","","","");
            loadSelect("newproyecto_cliente_final","CLIENTES","id","","","");
            loadSelect("newproyecto_ing","CLIENTES","id","","","");
            loadSelect("newproyecto_dirobra","CLIENTES","id","","","");
            loadSelect("newproyecto_promotor","CLIENTES","id","","","");
            loadSelect("proyectos_clientes","CLIENTES","id","","","");
            loadSelect("newproyecto_estados","PROYECTOS_ESTADOS","id","","","");
            loadSelect("newproyecto_parentproyecto","PROYECTOS","id","","","ref");
            loadSelect("newproyecto_tipoproyecto","TIPOS_PROYECTO","id","","","");
            
            loadContent("gastos-proyectos-container", "/erp/apps/proyectos/vistas/proyectos-gastos.php");
            loadContent("tabla-proyectos-container", "/erp/vistas/proyectos-activos.php");
            loadContent("horas-proyectos-container", "/erp/apps/proyectos/vistas/proyectos-horas.php");
            
            $(document).on("click", ".page-link" , function() {
                loadContent("tabla-proyectos-container", "/erp/vistas/proyectos-activos.php?pag=" + $(this).data("pag") + "&year=" + $(this).data("year") + "&cli=" + $(this).data("cli") + "&estado=" + $(this).data("estado"));
            });
            
            $('#refresh_proyectos').click(function () {
               loadContent("tabla-proyectos-container", "/erp/vistas/proyectos-activos.php");
            });
            
            $('#clean-filters').click(function () {
               loadContent("tabla-proyectos-container", "/erp/vistas/proyectos-activos.php");
               $("#filter_clientes").selectpicker("val", "");
               $("#filter_estados").selectpicker("val", "");
               $("#filter_proyectos_years").selectpicker("val", "");
               $("#filter_estados").parent().children("button").removeClass("filter-selected");
               $("#filter_clientes").parent().children("button").removeClass("filter-selected");
               $("#filter_proyectos_years").parent().children("button").removeClass("filter-selected");
            });
            
            $("#add-proyecto").click(function() {
                $("#addproyecto_model").modal('show');
            });
            $("#btn_add_cliente").click(function() {
                $("#addcliente_model").modal('show');
            });
            $("#btn_add_cliente_final").click(function() {
                $("#addcliente_model").modal('show');
            });
            
            $('#filter_proyectos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                location.href = "/erp/apps/proyectos/view.php?id=" + $(this).val();
            });
            
            $('#filter_proyectos_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-proyectos-container", "/erp/vistas/proyectos-activos.php?year=" + $(this).val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val());
                //location.href = "/erp/apps/proyectos/?year=" + $(this).val();
            });
            
            $('#filter_clientes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-proyectos-container", "/erp/vistas/proyectos-activos.php?year=" + $('#filter_proyectos_years').val() + "&cli=" + $(this).val() + "&estado=" + $('#filter_estados').val());
                //location.href = "/erp/apps/proyectos/?year=" + $(this).val();
            });
            
            $('#filter_estados').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-proyectos-container", "/erp/vistas/proyectos-activos.php?year=" + $('#filter_proyectos_years').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $(this).val());
                //location.href = "/erp/apps/proyectos/?year=" + $(this).val();
            });
            
            $(document).on("click", "#tabla-proyectos > tbody tr" , function() {
                window.open(
                    "view.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            
            $("#btn_save_proyecto").click(function() {
                $("#btn_save_proyecto").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_proyecto").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveProyectos.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_proyecto').trigger("reset");
                        $("#btn_save_proyecto").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newproyecto_success").slideDown();
                        setTimeout(function(){
                            $("#newproyecto_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            $("#proyectos_clientes").on("changed.bs.select", function (e) {
                loadProyectosClientes($(this).val());
            });
            
            $("#btn_save_cliente").click(function() {
                $("#btn_save_cliente").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_cliente").serializeArray();
                formData = new FormData($("#frm_new_cliente")[0]);
                $.ajax({
                    type: "POST",  
                    url: "saveClientes.php",  
                    data: formData,
                    processData: false,
                    contentType: false,       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_cliente').trigger("reset");
                        $("#btn_save_cliente").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newcliente_success").slideDown();
                        setTimeout(function(){
                            $("#newcliente_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
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
            <h3>
                Proyectos
            </h3>
        </div>
        <div id="dash-header">
            <div id="dash-numproyectos" class="four-column">
                <h4 class="dash-title">
                    CONTADORES
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/proyectos/vistas/historial.php"); ?>
            </div>
            <div id="dash-ofertfactu" class="four-column">
                <h4 class="dash-title">
                    HORAS VENDIDAS > HORAS IMPUTADAS
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="horas-proyectos-container">
                    <? //include($pathraiz."/apps/proyectos/vistas/proyectos-horas.php"); ?>
                </div>
            </div>
            <div id="dash-filtros" class="four-column-two-merged">
                <h4 class="dash-title">
                    GASTOS MATERIAL
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="gastos-proyectos-container">
                    <? //include($pathraiz."/apps/proyectos/vistas/proyectos-gastos.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="proyectos-filterbar" class="one-column">
                <? include($pathraiz."/apps/proyectos/vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="four-column-three-merged">
                <h4 class="dash-title">
                    PROYECTOS
                    <? include($pathraiz."/apps/proyectos/includes/tools.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="tabla-proyectos-container">
                    <? 
                        $fechamod = 1;
                        //include($pathraiz."/vistas/proyectos-activos.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-aside" class="four-column">
                <div id="dash-alertas" class="one-column">
                    <h4 class="dash-title">
                        ALERTAS
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz."/vistas/alertas.php"); ?>
                </div>
                <div id="dash-riesgos" class="one-column">
                    <h4 class="dash-title">
                        RIESGOS
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz."/vistas/riesgos.php"); ?>
                </div>
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        ACTIVIDAD
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