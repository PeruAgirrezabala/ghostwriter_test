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
        if (($_GET['idt'] != "undefined") &&($_GET['idt'] != "")) {
            $idtrabajador = $_GET['idt'];
        }
        else {
            $idtrabajador = $_SESSION['user_session'];
        }
        
        if ($_GET['year']) {
            $yearNum = $_GET['year'];
        }
        else {
            $yearNum  = date('Y');
        }
        
        //$monthNum = date('m');
        //$monthName = date("F", strtotime($monthNum)); 
        
        if ($_GET['mes']) {
            $monthNum = $_GET['mes'];
        }
        else {
            $monthNum  = date('m');
        }
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March
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

            //$("#menuitem-proyectos").addClass("active");
            
            loadSelect("filter_trabajadores","erp_users","id","","","apellidos");
            loadSelect("horas_proyectos","PROYECTOS","id","","","ref");
            loadSelect("horas_tareas","TAREAS","id","","", "perfil_id");
            
            loadSelect("horasint_int","INTERVENCIONES","id","","","ref");
            loadSelect("horasint_tareas","TAREAS","id","","", "perfil_id");
            
            setTimeout(function(){
                $("#filter_trabajadores").selectpicker("val", <? echo $idtrabajador; ?>);
            }, 1000);
            $("#filter_year").selectpicker("val", <? echo $yearNum; ?>);
            $("#filter_mes").selectpicker("val", <? echo $monthNum; ?>);
            
            $('#filter_trabajadores').on('changed.bs.select', function (e) {
                if ($("#filter_mes").val() != "") {
                    window.location.href = "/erp/apps/imputaciones/?idt=" + $(this).val() + "&mes=" + $("#filter_mes").val();
                }
                else {
                    window.location.href = "/erp/apps/imputaciones/?idt=" + $(this).val();
                }
            });
            
            $('#filter_mes').on('changed.bs.select', function (e) {
                if ($("#filter_trabajadores").val() != "") {
                    window.location.href = "/erp/apps/imputaciones/?idt=" + $('#filter_trabajadores').val() + "&year=" + $('#filter_year').val() + "&mes=" + $(this).val();
                }
                else {
                    window.location.href = "/erp/apps/imputaciones/?mes=" + $(this).val() + "&year=" + $('#filter_year').val();
                }
            });
            
            $('#filter_year').on('changed.bs.select', function (e) {
                if ($("#filter_trabajadores").val() != "") {
                    window.location.href = "/erp/apps/jornada/?idt=" + $('#filter_trabajadores').val() + "&year=" + $(this).val() + "&mes=" + $('#filter_mes').val();
                }
                else {
                    window.location.href = "/erp/apps/jornada/?year=" + $(this).val() + "&mes=" + $('#filter_mes').val();;
                }
            });
            
            $("#horas_tareas").on("changed.bs.select", function (e) {
                var dataperfil = $("option[value=" + $(this).val() + "]", this).attr('data-perfil');
                loadSelect("horas_horas","PERFILES_HORAS","id","perfil_id",dataperfil,"");
            });
            
            $("#add-horas").click(function() {
                $("#horas_add_model").modal('show');
            });
            $("#add-horas-int").click(function() {
                $("#horasint_add_model").modal('show');
            });
            
            $("#btn_horas_save").click(function() {
                $("#btn_horas_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_edit_horas").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                //console.log(data);
                $.ajax({
                    type: "POST",  
                    url: "saveHoras.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_horas').trigger("reset");
                        refreshSelects();
                        $("#btn_horas_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#horas_add_model").modal('hide');
                        $("#horas_success").slideDown();
                        setTimeout(function(){
                            $("#horas_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            $(".remove-horas").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveHoras.php',
                    dataType : 'text',
                    data: {
                        horas_deldetalle : $(this).data("id")
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $("#tabla-horas tr").click(function() {
                loadProyectoHorasInfo($(this).data("id"));
                $("#horas_add_model").modal('show');
            });
            
            $("#btn_horasint_save").click(function() {
                $("#btn_horasint_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_edit_horasint").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                //console.log(data);
                $.ajax({
                    type: "POST",  
                    url: "saveHorasInt.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_horasint').trigger("reset");
                        refreshSelects();
                        $("#btn_horasint_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#horasint_add_model").modal('hide');
                        $("#horasint_success").slideDown();
                        setTimeout(function(){
                            $("#horasint_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            $(".remove-horas-int").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveHorasInt.php',
                    dataType : 'text',
                    data: {
                        horasint_deldetalle : $(this).data("id")
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $("#tabla-horas-int tr").click(function() {
                loadIntHorasInfo($(this).data("id"));
                $("#horasint_add_model").modal('show');
            });
            
	});
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>IMPUTACIONES HORARIAS | Erp GENELEK</title>
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
                IMPUTACIONES DE HORAS
            </h3>
        </div>
        <div id="dash-header">
            <div id="proyectos-filterbar" class="one-column">
                <? include($pathraiz."/apps/imputaciones/vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-periodoliquidacion" class="one-column">
                <div>
                    <? 
                        include($pathraiz."/apps/imputaciones/vistas/registro-periodoliquidacion.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-jornadalaboral" class="one-column">
                <h4 class="dash-title">
                    IMPUTACIONES A PROYECTOS
                    <? include($pathraiz."/apps/imputaciones/includes/tools-horas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="jornada-wrapper">
                    <? 
                        include($pathraiz."/apps/imputaciones/vistas/registro-horas.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
            
            <div id="dash-jornadalaboral" class="one-column">
                <h4 class="dash-title">
                    IMPUTACIONES A INTERVENCIONES
                    <? include($pathraiz."/apps/imputaciones/includes/tools-horas-int.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="jornada-wrapper">
                    <? 
                        include($pathraiz."/apps/imputaciones/vistas/registro-horas-int.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
        
        
    </section>
	
</body>
</html>