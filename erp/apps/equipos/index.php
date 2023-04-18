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
            
            $('#menuitem-equipos').addClass('active');
            
            loadSelect("newPC_tecnicos","erp_users","id","","","apellidos");
            loadSelect("newPC_proyectos","PROYECTOS","id","","","REF");
            loadSelect("newPC_estados","ESTADOS_EQUIPOS","id","","","");
            
            loadContent("dash-pcscontainer", "/erp/apps/equipos/vistas/tabla-pcs.php");
            
            // OPEN MODALS 
            $("#add-pc").click(function() {
                $("#addPC_model").modal('show');
            });
            
            // EQUIPOS
            $("#btn_save_pc").click(function() {
                $("#btn_save_pc").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_pc").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "savePC.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_pc').trigger("reset");
                        $("#btn_save_pc").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newPC_success").slideDown();
                        setTimeout(function(){
                            $("#newPC_success").fadeOut("slow");
                            //console.log(response[0].id);
                            //window.location.reload();
                            $("#addPC_model").modal("hide");
                            loadContent("dash-pcscontainer", "/erp/apps/equipos/vistas/tabla-pcs.php");
                        }, 1000);
                    }   
                });
            });
            
            // ######## DELETE EQUIPO #######
            $(document).on("click", "#btn_del_pc" , function() {
                //$(".remove-pc").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'savePC.php',
                    dataType : 'text',
                    data: {
                        newPC_delid : $("#delPC_id").val()
                    },
                    success : function(data){
                        console.log("ok");
                        //window.location.reload();
                        $("#delocnfirmPC_model").modal("hide");
                        loadContent("dash-pcscontainer", "/erp/apps/equipos/vistas/tabla-pcs.php");
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // Confirmar borrado
            $(document).on("click", ".remove-pc" , function() {
                $("#delPC_id").val($(this).data("id"));
                $("#delocnfirmPC_model").modal("show");
            });
            
            
            // Load model y contenido
            $(document).on("click", "#tabla-pcs tr > td:not(:nth-child(6)):not(:nth-child(9))" , function() {
                //$("#tabla-pcs tr > td:not(:nth-child(6)):not(:nth-child(9))").click(function() {
                console.log($(this).parent().data("id"));
                loadPCinfo($(this).parent().data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#addPC_model").modal('show');
            });
            
            window.setInterval(function(){
                $(".hostnames").each(function() {
                    //console.log($(this).html());
                    pingHost($(this).html(), $(this).parent("tr").children("td.pc-states"));
                });
            }, 5000);
        });
        
        function pingHost(hostname, item) {
            $.ajax({
                type: "POST",  
                url: "pingHost.php",  
                data: {host: hostname},
                dataType: "json",       
                success: function(response)  
                {
                    console.log(response);
                    item.html(response.data1);
                    item.parent("tr").children("td.pc-ip").html(response.data2);
                }   
            });
        };
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>Equipos en Laboratorio | Erp GENELEK</title>
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
                PCs en Laboratorio
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-equiposlab" class="one-column">
                <h4 class="dash-title">
                    
                    <? 
                        include($pathraiz."/apps/equipos/includes/tools-equipos.php"); 
                    ?>
                </h4>
                <div class="loading-div"></div>
                <div id="dash-pcscontainer">
                    <? //include($pathraiz."/apps/equipos/vistas/tabla-pcs.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
	
</body>
</html>