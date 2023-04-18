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

<!-- Bootstrap Grid -->
    <script src="/erp/includes/bootstrap/jquery.bootgrid.min.js"></script>
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
            
            $('#menuitem-licencias').addClass('active');
            
            loadSelect("newlicencia_users","erp_users","id","","","apellidos");
            loadSelect("newlicencia_proyectos","PROYECTOS","id","","","REF");
            
            // LICENCIAS
            $("#btn_save_licencia").click(function() {
                $("#btn_save_licencia").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_lic").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveLic.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_lic').trigger("reset");
                        $("#btn_save_licencia").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newlicencia_success").slideDown();
                        setTimeout(function(){
                            $("#newlicencia_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            $("#tabla-licencias > tbody tr").click(function() {
                loadLicInfo($(this).data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#detallelic_add_model").modal('show');
            });
            
            $(".unlock-lic").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveLic.php',
                    dataType : 'text',
                    data: {
                        unlocklic_id : $(this).data("id")
                    },
                    success : function(data){
                        //alert(data);
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $("#vaciar_licencia").click(function() {
                $("#vaciar_licencia").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; ...');
                data = $("#frm_new_lic").serializeArray();
                $.ajax({
                    type : 'POST',
                    url : 'saveLic.php',
                    dataType : 'text',
                    data: {
                        vaciar_lic : $("#newlicencia_idlic").val()
                    },
                    success : function(data){
                        //console.log(data);
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

<title>Licencias Wonderware | Erp GENELEK</title>
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
                Licencias Wonderware
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="one-column">
                <h4 class="dash-title">
                    
                    <? 
                        //include($pathraiz."/apps/licencias/includes/tools-licencias.php"); 
                    ?>
                </h4>
                <div id="dash-empresas" style="padding:10px;">
                    <? 
                        include($pathraiz."/apps/licencias/vistas/tabla-licencias.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
	
</body>
</html>