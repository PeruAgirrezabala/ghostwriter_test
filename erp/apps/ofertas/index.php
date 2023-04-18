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

            $("#menuitem-ofertas").addClass("active");
            
            loadSelectYears("filter_ofertas_years","OFERTAS","fecha","","");
            loadSelect("filter_clientes","CLIENTES","id","","");
            loadSelect("filter_ofertas","OFERTAS","id","","","ref");
            loadSelect("newoferta_proyectos","PROYECTOS","id","","","ref");
            loadSelect("newoferta_clientes","CLIENTES","id","","","");
            loadSelect("filter_clientes","CLIENTES","id","","","");
            loadSelect("filter_estados","OFERTAS_ESTADOS","id","","","");
            
            year = "<? echo $_GET['year']; ?>";
            month = "<? echo $_GET['month']; ?>";
            cli = "<? echo $_GET['cli']; ?>";
            if (year != "") {
                setTimeout(function(){
                    $("#filter_ofertas_years").selectpicker("val", "<? echo $_GET['year']; ?>");
                    
                }, 2000);
            }
            if (cli != "") {
                setTimeout(function(){
                    $("#filter_clientes").selectpicker("val", "<? echo $_GET['cli']; ?>");
                    
                }, 2000);
            }
            if (month != "") {
                $("#filter_ofertas_mes").selectpicker("val", "<? echo $_GET['month']; ?>");
            }
            
            loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php");
            
            $('#clean-filters').click(function () {
               loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php");
               $("#filter_ofertas_years").selectpicker("val", "");
               $("#filter_ofertas_mes").selectpicker("val", "");
               $("#filter_ofertas").selectpicker("val", "");
               $("#filter_clientes").selectpicker("val", "");
               $("#filter_estados").selectpicker("val", "");
               $("#filter_ofertas_years").parent().children("button").removeClass("filter-selected");
               $("#filter_ofertas_mes").parent().children("button").removeClass("filter-selected");
               $("#filter_ofertas").parent().children("button").removeClass("filter-selected");
               $("#filter_clientes").parent().children("button").removeClass("filter-selected");
               $("#filter_estados").parent().children("button").removeClass("filter-selected");
            });
            
            $(document).on("click", ".page-link" , function() {
                loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php?pag=" + $(this).data("pag") + "&year=" + $(this).data("year") + "&cli=" + $(this).data("cli") + "&estado=" + $(this).data("estado"));
            });
            
            $('#refresh-ofertas').click(function () {
               loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php");
            });
            
            $('#filter_ofertas').on('changed.bs.select', function (e) {
                //alert($(this).parent());
                //console.log($(this).parent().children("button"));
                $(this).parent().children("button").addClass("filter-selected");
                location.href = "/erp/apps/ofertas/editoferta.php?id=" + $(this).val();
            });
            
            $('#filter_clientes').on('changed.bs.select', function (e) {
                loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php?cli=" + $(this).val() + "&year=" + $('#filter_ofertas_years').val() + "&month=" + $('#filter_ofertas_mes').val() + "&estado="+ $("#filter_estados").val());
                //location.href = "/erp/apps/ofertas/?cli=" + $(this).val() + "&year=" + $('#filter_ofertas_years').val() + "&month=" + $('#filter_ofertas_mes').val();
            });
            $('#filter_estados').on('changed.bs.select', function (e) {
                loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php?cli=" + $('#filter_clientes').val() + "&year=" + $('#filter_ofertas_years').val() + "&month=" + $('#filter_ofertas_mes').val() + "&estado="+ $(this).val());
                //location.href = "/erp/apps/ofertas/?cli=" + $(this).val() + "&year=" + $('#filter_ofertas_years').val() + "&month=" + $('#filter_ofertas_mes').val();
            });
            $('#filter_ofertas_years').on('changed.bs.select', function (e) {
                console.log("logAño:"+$(this).val());
                loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php?year=" + $(this).val() + "&cli=" +  $('#filter_clientes').val() + "&month=" + $('#filter_ofertas_mes').val() + "&estado="+ $("#filter_estados").val());
                //location.href = "/erp/apps/ofertas/?year=" + $(this).val() + "&cli=" +  $('#filter_clientes').val() + "&month=" + $('#filter_ofertas_mes').val();
            });
            $('#filter_ofertas_mes').on('changed.bs.select', function (e) {
                //location.href = "/erp/apps/ofertas/?year=" + $('#filter_ofertas_years').val() + "&month=" + $(this).val() + "&cli=" + $('#filter_clientes').val();
                loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php?year=" + $('#filter_ofertas_years').val() + "&cli=" +  $('#filter_clientes').val() + "&month=" + $(this).val() + "&estado="+ $("#filter_estados").val());
            });
            
            $(document).on("click", "#refresh_proyectos" , function() {
                $('#tabla-proyectos').fadeOut('slow', function(){
                    $('#tabla-proyectos').load('/erp/vistas/proyectos-activos.php', function(){
                        $('#tabla-proyectos').fadeIn('slow');
                    });
                });
            });

            $(document).on("click", "#tabla-proyectos > tbody tr" , function() {
                //location.href = "editoferta.php?id=" + $(this).data("id");
                $.ajax({
                    type: "POST",  
                    url: "choseOferta.php",  
                    data: {
                        id: $(this).data("id")
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        window.open("editoferta.php?id="+response,'_blank');
                    }   
                });
            });
            
            $("#add-oferta").click(function() {
                $("#addoferta_model").modal('show');
            });
            
            $("#btn_save_oferta").click(function() {
//                if($("#newoferta_proyectos").val()==""){
//                    alert("Introducir un proyecto!");
//                }else{
                    $("#btn_save_oferta").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                    data = $("#frm_new_oferta").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveOferta.php",  
                        data: data,
                        dataType: "text",       
                        success: function(response)  
                        {
                            console.log(response);
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_oferta').trigger("reset");
                            refreshSelects();
                            $("#btn_save_oferta").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#newoferta_success").slideDown();
                            setTimeout(function(){
                                $("#newoferta_success").fadeOut("slow");
                                window.open("editoferta.php?id=" + response,'_blank');
                                loadContent("tabla-ofertas-container", "/erp/apps/ofertas/vistas/ofertas-home.php");
                                $("#addoferta_model").modal("hide");
                            }, 2000);
                        }   
                    });
                //} 
            });
	});
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>Ofertas | Erp GENELEK</title>
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
                Ofertas
            </h3>
        </div>
        <div id="dash-header">
            <div id="dash-numproyectos" class="four-column">
                <h4 class="dash-title">
                    CONTADORES
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/ofertas/vistas/historial.php"); ?>
            </div>
            <div id="dash-ofertfactu" class="four-column">
                <h4 class="dash-title">
                    VENTAS > COSTES
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/ofertas/vistas/ofertas-costes.php"); ?>
            </div>
            <div id="dash-filtros" class="four-column-two-merged">
                <h4 class="dash-title">
                    VENTAS > COSTES POR TIPO
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/ofertas/vistas/ofertas-costes-separados.php"); ?>
            </div>
            <span class="stretch"></span>
            <div id="proyectos-filterbar" class="one-column">
                <? include($pathraiz."/apps/ofertas/vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="four-column-three-merged">
                <h4 class="dash-title">
                    OFERTAS
                    <? include($pathraiz."/apps/ofertas/includes/tools-ofertas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="tabla-ofertas-container">
                    <? 
                        $fechamod = 1;
                        //include("vistas/ofertas-home.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-aside" class="four-column">
                <div id="dash-alertas" class="one-column">
                    <h4 class="dash-title">
                        ALERTAS
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz."/apps/ofertas/vistas/alertas.php"); ?>
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