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

            $("#menuitem-entregas").addClass("active");
            
            loadSelectYears("filter_proyectos_years","ENTREGAS","fecha_entrega","","");
            loadSelect("filter_proyectos","PROYECTOS","id","","","ref");
            loadSelect("filter_clientes","CLIENTES","id","","","");
            loadSelect("newentrega_estados","ESTADOS_ENTREGAS","id","","","");
            loadSelect("newentrega_proyecto","PROYECTOS","id","","","ref");
            loadSelect("filter_estados","ESTADOS_ENTREGAS","id","","","");
            
            year = "<? echo date("Y"); ?>";
            
            setTimeout(function(){
                $("#filter_proyectos_years").selectpicker("val", year);
                $("#filter_proyectos_years").parent().children("button").addClass("filter-selected");
            }, 1000);
            
            //console.log("año inicio: "+year);
            loadContent("tabla-entregas-container", "/erp/apps/entregas/vistas/entregas-activas.php?year=" + year);
                        
            $('#refresh_entregas').click(function () {
               loadContent("tabla-entregas-container", "/erp/apps/entregas/vistas/entregas-activas.php?year=" + $("#filter_proyectos_years").val() + "&proyecto=" + $("#filter_proyectos").val() + "&cli=" + $("#filter_clientes").val() + "&estado=" + $("#filter_estados").val());
            });
            
            // Las tablas de arriba de resumen. 
            $(document).on("click", ".tabla-entregas > tbody tr" , function() {
                window.open("view.php?id=" + $(this).data("id"),"_blank");
            });
            
            $("#add-entrega").click(function() {
                $("#addentrega_model").modal('show');
            });
            
            $(document).on("click", ".page-link" , function() {
                loadContent("tabla-entregas-container", "/erp/apps/entregas/vistas/entregas-activas.php?pag=" + $(this).data("pag") + "&year=" + $("#filter_proyectos_years").val() + "&proyecto=" + $("#filter_proyectos").val() + "&cli=" + $("#filter_clientes").val() + "&estado=" + $("#filter_estados").val());
            });
            
            $('#filter_proyectos_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log("año seleccionado: "+$(this).val());
                loadContent("tabla-entregas-container", "/erp/apps/entregas/vistas/entregas-activas.php?year=" + $(this).val() + "&proyecto=" + $("#filter_proyectos").val() + "&cli=" + $("#filter_clientes").val() + "&estado=" + $("#filter_estados").val());
            });
            $('#filter_proyectos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                // Si existe ese proyecto
                loadContent("tabla-entregas-container", "/erp/apps/entregas/vistas/entregas-activas.php?proyecto=" + $(this).val() + "&year=" + $("#filter_proyectos_years").val() + "&cli=" + $("#filter_clientes").val() + "&estado=" + $("#filter_estados").val());
            });
            $('#filter_clientes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-entregas-container", "/erp/apps/entregas/vistas/entregas-activas.php?cli=" + $(this).val() + "&proyecto=" + $("#filter_proyectos").val() + "&year=" + $("#filter_proyectos_years").val() + "&estado=" + $("#filter_estados").val());
            });
            $('#filter_estados').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-entregas-container", "/erp/apps/entregas/vistas/entregas-activas.php?estado=" + $(this).val() + "&proyecto=" + $("#filter_proyectos").val() + "&cli=" + $("#filter_clientes").val() + "&year=" + $("#filter_proyectos_years").val());
            });
            $('#clean-filters').click(function () {
               loadContent("tabla-entregas-container", "/erp/apps/entregas/vistas/entregas-activas.php");
               $("#filter_proyectos_years").selectpicker("val", "");
               $("#filter_proyectos").selectpicker("val", "");
               $("#filter_clientes").selectpicker("val", "");
               $("#filter_estados").selectpicker("val", "");
               $("#filter_proyectos_years").parent().children("button").removeClass("filter-selected");
               $("#filter_proyectos").parent().children("button").removeClass("filter-selected");
               $("#filter_clientes").parent().children("button").removeClass("filter-selected");
               $("#filter_estados").parent().children("button").removeClass("filter-selected");
            });
         
            $(document).on("click", "#tabla-entregas > tbody tr" , function() {
                //location.href = "view.php?id=" + $(this).data("id"); // ASDAS
                window.open("view.php?id=" + $(this).data("id"),"_blank");
            });
            
            $("#btn_save_entrega").click(function() {
                $("#btn_save_entrega").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_entrega").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveEntregas.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_entrega').trigger("reset");
                        $("#btn_save_entrega").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newentrega_success").slideDown();
                        setTimeout(function(){
                            $("#newentrega_success").fadeOut("slow");
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

<title>Entregas | Erp GENELEK</title>
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
                Entregas
            </h3>
        </div>
        <div id="dash-header">
            <div id="dash-numproyectos" class="four-column">
                <h4 class="dash-title">
                    CONTADORES
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/entregas/vistas/entregas-pendientes.php"); ?>
            </div>
            <div id="dash-ofertfactu" class="four-column">
                <h4 class="dash-title">
                    A ENTREGAR ESTE MES
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/entregas/vistas/entregas-mes.php"); ?>
            </div>
            <div id="dash-filtros" class="four-column">
                <h4 class="dash-title">
                    ENTREGAS ATRASADAS
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/entregas/vistas/entregas-caducadas.php"); ?>
            </div>
            <div id="dash-startedcompleted" class="four-column">
                <h4 class="dash-title">
                    ENTREGAS EN TEST
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/entregas/vistas/entregas-test.php"); ?>
            </div>
            <span class="stretch"></span>
            <div id="proyectos-filterbar" class="one-column">
                <? include($pathraiz."/apps/entregas/vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="four-column-three-merged">
                <h4 class="dash-title">
                    ENTREGAS
                    <? include($pathraiz."/apps/entregas/includes/tools.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="tabla-entregas-container">
                    <? 
                        $fechamod = 1;
                        //include($pathraiz."/apps/entregas/vistas/entregas-activas.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-aside" class="four-column">
                <div id="dash-alertas" class="one-column">
                    <h4 class="dash-title">
                        ALERTAS
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz."/apps/entregas/vistas/alertas.php"); ?>
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