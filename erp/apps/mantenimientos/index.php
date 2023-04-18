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

            $("#menuitem-mantenimientos").addClass("active");
            
            loadSelectYears("filter_proyectos_years","PROYECTOS","fecha_ini","","");
            loadSelect("filter_proyectos","PROYECTOS","id","tipo_proyecto_id","2","ref");
            loadSelect("filter_clientes","CLIENTES","id","","","");
            loadSelect("filter_expedientes","PROYECTOS","id","tipo_proyecto_id","1","ref");
            loadSelect("newproyecto_clientes","CLIENTES","id","","","");
            loadSelect("proyectos_clientes","CLIENTES","id","","","");
            loadSelect("newproyecto_estados","PROYECTOS_ESTADOS","id","","","");
            loadSelect("newproyecto_parentproyecto","PROYECTOS","id","","","ref");
            loadSelect("newproyecto_tipoproyecto","TIPOS_PROYECTO","id","","","");
            
            
            year = "<? echo $_GET['year']; ?>";
            if (year != "") {
                setTimeout(function(){
                    $("#filter_proyectos_years").selectpicker("val", "<? echo $_GET['year']; ?>");
                }, 1000);
            }
            
            <?
                $criteriaLink = "";
                if ($_GET['year'] != "") {
                    $criteriaLink = "?year=".$_GET['year'];
                }
                else {
                    $criteriaLink = "?year=".date("Y");
                    $criteriaLink = "?year=";
                }
                if ($_GET['cli'] != "") {
                    $criteriaLink .= "&cli=".$_GET['cli'];
                }
                if ($_GET['pag']) {
                    $criteriaLink .= "&pag=".$_GET['pag'];
                }
            ?>
            
            $('#clean-filters').click(function () {
               $("#filter_proyectos_years").selectpicker("val", "");
               $("#filter_proyectos").selectpicker("val", "");
               $("#filter_clientes").selectpicker("val", "");
               $("#filter_expedientes").selectpicker("val", "");
               $("#filter_proyectos_years").parent().children("button").removeClass("filter-selected");
               $("#filter_proyectos").parent().children("button").removeClass("filter-selected");
               $("#filter_clientes").parent().children("button").removeClass("filter-selected");
               $("#filter_expedientes").parent().children("button").removeClass("filter-selected");
               loadContent("tabla-mantenimientos-container", "/erp/apps/mantenimientos/vistas/proyectos-activos.php");
            });
            
            loadContent("tabla-mantenimientos-container", "/erp/apps/mantenimientos/vistas/proyectos-activos.php<? echo $criteriaLink; ?>");
            //loadContent("tabla-mantenimientos-historico-container", "/erp/apps/mantenimientos/vistas/proyectos-historico.php");
            
            $("#ver-historicos").click(function() {
                $("#mantenimientos_historico_model").modal('show');
            });
            
                        
            $('#refresh_mantenimientos').click(function () {
               loadContent("tabla-mantenimientos-container", "/erp/apps/mantenimientos/vistas/proyectos-activos.php<? echo $criteriaLink; ?>");
            });
            
            $("#add-proyecto").click(function() {
                $("#addproyecto_model").modal('show');
            });
            $("#btn_add_cliente").click(function() {
                $("#addcliente_model").modal('show');
            });
            
            $("#tabla-proyectos tr").click(function() {
                //alert($(this).data('id'));
            });
            
            $('#filter_proyectos').on('changed.bs.select', function (e) {
                //alert($(this).parent());
                //console.log($(this).parent().children("button"));
                $(this).parent().children("button").addClass("filter-selected");
                //loadContent("tabla-mantenimientos-container", "/erp/apps/mantenimientos/view.php?id=" + $(this).val());
                location.href = "/erp/apps/mantenimientos/view.php?id=" + $(this).val();
            });
            
            $('#filter_proyectos_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-mantenimientos-container", "/erp/apps/mantenimientos/vistas/proyectos-activos.php?year=" + $(this).val() +"&cli="+$("#filter_clientes").val()+"&exp="+$("#filter_expedientes").val());
                //location.href = "/erp/apps/mantenimientos/?year=" + $(this).val() +"&cli="+$("#filter_clientes").val();
            });
            $('#filter_clientes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-mantenimientos-container", "/erp/apps/mantenimientos/vistas/proyectos-activos.php?year=" + $("#filter_proyectos_years").val() +"&cli="+$(this).val()+"&exp="+$("#filter_expedientes").val());
                //location.href = "/erp/apps/mantenimientos/?year=" + $("#filter_proyectos_years").val() +"&cli="+$(this).val();
            });
            $('#filter_expedientes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-mantenimientos-container", "/erp/apps/mantenimientos/vistas/proyectos-activos.php?year=" + $("#filter_proyectos_years").val() +"&cli="+$("#filter_clientes").val()+"&exp="+$(this).val());
                //location.href = "/erp/apps/mantenimientos/?year=" + $("#filter_proyectos_years").val() +"&cli="+$(this).val();
            });
            
            $('#refresh_proyectos').click(function () {
                $('#tabla-proyectos').fadeOut('slow', function(){
                    $('#tabla-proyectos').load('/erp/apps/mantenimientos/vistas/proyectos-activos.php', function(){
                        $('#tabla-proyectos').fadeIn('slow');
                    });
                });
                //$("#tabla-proyectos").load("/erp/vistas/proyectos-activos.php");
            });
            
            $(".tabla-mant-exp tr").click(function() {
                location.href = "/erp/apps/proyectos/view.php?id=" + $(this).data("id");
            });
            
            // Proximas visitas
            $(document).on("click", "#tabla-visitas-proximos > tbody tr" , function() {
                //location.href = "view.php?id=" + $(this).data("id");
                window.open("/erp/apps/actividad/editAct.php?id=" + $(this).data("id"),"_blank");
            });
            // ...
            $(document).on("click", "#tabla-proyectos tr > td:not(:nth-child(8))" , function() {
                //location.href = "view.php?id=" + $(this).data("id");
                window.open("view.php?id=" + $(this).parent().data("id"),"_blank");
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

<title>Mantenimientos | Erp GENELEK</title>
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
                Mantenimientos
            </h3>
        </div>
        <div id="dash-header">
            <div id="dash-numproyectos" class="four-column">
                <h4 class="dash-title">
                    CONTADORES
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/mantenimientos/vistas/proyectos-totales.php"); ?>
            </div>
            <div id="dash-ofertfactu" class="four-column">
                <h4 class="dash-title">
                    PRÓXIMOS 30 DÍAS
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/mantenimientos/vistas/visitas-proximos.php"); ?>
            </div>
            <div id="dash-filtros" class="four-column">
                <h4 class="dash-title">
                    VISITAS ATRASADAS
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/mantenimientos/vistas/visitas-atrasadas.php"); ?>
                <? //include($pathraiz."/apps/proyectos/vistas/filtros.php"); ?>
            </div>
            <div id="dash-startedcompleted" class="four-column">
                <h4 class="dash-title">
                    EN CURSO
                </h4>
                <hr class="dash-underline">
                <? include($pathraiz."/apps/mantenimientos/vistas/visitas-encurso.php"); ?>
            </div>
            <span class="stretch"></span>
            <div id="proyectos-filterbar" class="one-column">
                <? include($pathraiz."/apps/mantenimientos/vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="four-column-three-merged">
                <h4 class="dash-title">
                    MANTENIMIENTOS
                    <? include($pathraiz."/apps/mantenimientos/includes/tools.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="tabla-mantenimientos-container">
                    <? 
                        $fechamod = 1;
                        //include($pathraiz."/apps/mantenimientos/vistas/proyectos-activos.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-aside" class="four-column">
                <div id="dash-info">
                    <h4 class="dash-title">
                        VISITAS INFO
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz."/apps/mantenimientos/vistas/info.php"); ?>
                </div>
                <div id="dash-alertas2">
                    <h4 class="dash-title">
                        VISITAS ALERTAS
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz."/apps/mantenimientos/vistas/alertas.php"); ?>
                </div>
                <div id="dash-actividad">
                    <h4 class="dash-title">
                        VISITAS ACTIVIDAD
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