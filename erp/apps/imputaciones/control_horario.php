<?
    include("../../common.php");

    $monthNum  = date('m');
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F'); // March    $monthName = $dateObj->format('F'); // March

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
            
            setTimeout(function(){
                $("#filter_trabajadores").selectpicker("val", <? echo $idtrabajador; ?>);
            }, 1000);
            $("#filter_mes").selectpicker("val", <? echo $monthNum; ?>);
            
            $('#filter_trabajadores').on('changed.bs.select', function (e) {
                if ($("#filter_mes").val() != "") {
                    window.location.href = "/erp/apps/jornada/?idt=" + $(this).val() + "&mes=" + $("#filter_mes").val();
                }
                else {
                    window.location.href = "/erp/apps/jornada/?idt=" + $(this).val();
                }
            });
            
            $('#filter_mes').on('changed.bs.select', function (e) {
                if ($("#filter_trabajadores").val() != "") {
                    window.location.href = "/erp/apps/jornada/?idt=" + $('#filter_trabajadores').val() + "&mes=" + $(this).val();
                }
                else {
                    window.location.href = "/erp/apps/jornada/?mes=" + $(this).val();
                }
            });
            
            $(".tabla-detalles-acceso tr").click(function() {
                loadDetalleAcceso($(this).data("id"));
                $("#detalleacceso_add_model").modal('show');
            });
            
            $(".add-acceso").click(function() {
                $("#editacceso_idjornada").val($(this).data("jornadaid"));
                $("#editacceso_dia").val($(this).data("fecha"));
                $("#editacceso_horaentrada").val("");
                $("#editacceso_horasalida").val("");
                $("#editacceso_id").val("");
                $("#editacceso_del").val("");
                $("#detalleacceso_add_model").modal('show');
            });
            
            $(".num").click(function() {
                $("#ch_txartela").val($("#ch_txartela").val() + $(this).html());
            });
            
            $("#btn_ch_retroceder").click(function() {
                $("#ch_txartela").val($("#ch_txartela").val().substr(0,$("#ch_txartela").val().length-1));
            });
           
            
            $("#btn_ch_acceso").click(function() {
                $.ajax({
                    type: "POST",  
                    url: "saveAcceso.php",  
                    data: { txartela: $("#ch_txartela").val()
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        if (response == 99) {
                            $("#ch_error").slideDown();
                            setTimeout(function(){
                                $("#ch_error").fadeOut("slow");
                                $("#ch_txartela").val("");
                                //window.location.reload();
                            }, 3000);
                        }
                        else {
                            window.location.reload();
                        }
                    }   
                });
            });         
	});
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>JORNADA LABORAL | Erp GENELEK</title>
</head>

<body>
    <div id="cover">
        <div class="box">
            <img src="/erp/img/logo.png" class="spinnerlogo">
            <img src="/erp/img/loading.gif" class="spinner">
        </div>
    </div>
    <!--rest of the page... -->
    <? include($pathraiz."/includes/header_ch.php"); ?>
    
    <section style="margin-top: 75px;">
        <? 
            include($pathraiz."/apps/jornada/vistas/control-horario.php"); 
        ?>
    </section>
	
</body>
</html>