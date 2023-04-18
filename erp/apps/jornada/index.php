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
        
        //$monthNum = date('m');
        //$monthName = date("F", strtotime($monthNum)); 
        
        if ($_GET['year']) {
            $yearNum = $_GET['year'];
        }
        else {
            $yearNum  = date('Y');
        }
        
        if ($_GET['mes']) {
            $monthNum = $_GET['mes'];
        }
        else {
            $monthNum  = date('m');
        }
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
	//animacion
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	//animacion
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	

            //$("#menuitem-proyectos").addClass("active");
            
            loadSelect("filter_trabajadores","erp_users","id","empresa_id","1","apellidos","activo","'on'","",0);
            loadSelect("editacceso_tipohora","JORNADAS_TIPOS_HORAS","id","","","");
            
            loadSelect("proyectojornada_proyectos","PROYECTOS","id","","","ref");
            
            loadContent("jornada-wrapper", "/erp/apps/jornada/vistas/registro-jornada_new.php?year="+<? echo $yearNum ?>+"&month="+<? echo $monthNum ?>+"&idt="+<? echo $idtrabajador ?>);
            
            setTimeout(function(){
                $("#editacceso_tipohora").selectpicker("val", 1);
            }, 1000);
            
            setTimeout(function(){
                $("#filter_trabajadores").selectpicker("val", <? echo $idtrabajador; ?>);
            }, 1000);
            $("#filter_mes").selectpicker("val", <? echo $monthNum; ?>);
            $("#filter_year").selectpicker("val", <? echo $yearNum; ?>);
            
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
                    window.location.href = "/erp/apps/jornada/?idt=" + $('#filter_trabajadores').val() + "&year=" + $('#filter_year').val() + "&mes=" + $(this).val();
                }
                else {
                    window.location.href = "/erp/apps/jornada/?mes=" + $(this).val() + "&year=" + $('#filter_year').val();
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
            
            $(document).on("click", ".tabla-detalles-acceso tr", function(){
            //$(".tabla-detalles-acceso tr").click(function() {
                loadDetalleAcceso($(this).data("id"));
                $("#detalleacceso_add_model").modal('show');
            });
            
            $(document).on("click", "#link-teclado", function(){
            //$("#link-teclado").click(function() {
                window.location.href = "/erp/apps/jornada/control_horario.php";
            });
            
            $(document).on("click", ".add-acceso", function(){
            //$(".add-acceso").click(function() {
                $("#editacceso_tipohora").selectpicker("val", 1);
                $("#editacceso_idjornada").val($(this).data("jornadaid"));
                $("#editacceso_dia").val($(this).data("fecha"));
                $("#editacceso_horaentrada").val("");
                $("#editacceso_horasalida").val("");
                $("#editacceso_id").val("");
                $("#editacceso_del").val("");
                $("#detalleacceso_add_model").modal('show');
            });
            
            $(document).on("click", "#add-festivos", function(){
            //$("#add-festivos").click(function() {
                $("#festivos_add_model").modal('show');
            });
            
            $(document).on("click", "#ver-vacaciones", function(){
            //$("#ver-vacaciones").click(function() {
                loadContent("contenedor-vacaciones", "/erp/apps/jornada/vistas/vista-calendario.php?yearNum=<? echo $yearNum; ?>");
                $("#calendario_vac").modal('show');
            });
            
            $(document).on("click", "#add-media", function(){
            //$("#add-media").click(function() {
                $("#media_add_model").modal('show');
            });
            
            $(document).on("click", "#btn_save_detalleacceso", function(){
            //$("#btn_save_detalleacceso").click(function() {
                $("#btn_save_detalleacceso").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_edit_acceso").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveAcceso.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log("response: "+response);
                        loadContent("jornada-wrapper", "/erp/apps/jornada/vistas/registro-jornada_new.php?year="+<? echo $yearNum ?>+"&month="+<? echo $monthNum ?>+"&idt="+<? echo $idtrabajador ?>);
                        $('#frm_edit_acceso').trigger("reset");
                        $("#btn_save_detalleacceso").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#editacceso_success").slideDown();
                        setTimeout(function(){
                            $("#editacceso_success").fadeOut("slow");
                            //Mejorar refresco
                            $("#detalleacceso_add_model").modal("hide");
                            //window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            $(document).on("click", ".add-autoacceso", function(){
                $(this).html('<img src="/erp/img/btn-ajax-loader.gif" height="10" />');
                console.log("Auto acceso.");
            //$(".add-autoacceso").click(function() {
                $.ajax({
                    type: "POST",  
                    url: "saveAcceso.php",  
                    data: { editacceso_autojornada: 1,
                            editacceso_dia: $(this).data("fecha"),
                            editacceso_idjornada: $(this).data("jornadaid"),
                            editacceso_tipojornada: $(this).data("tipojornada")
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        $("#detalleacceso_add_model").modal("hide");
                        loadContent("jornada-wrapper", "/erp/apps/jornada/vistas/registro-jornada_new.php?year="+<? echo $yearNum ?>+"&month="+<? echo $monthNum ?>+"&idt="+<? echo $idtrabajador ?>);    
                        //window.location.reload();
                    }   
                });
            });
            
            $(document).on("click", ".add-autovacaciones", function(){
                $(this).html('<img src="/erp/img/btn-ajax-loader.gif" height="10" />');
                //$(".add-autovacaciones").click(function() {
                $.ajax({
                    type: "POST",  
                    url: "saveAcceso.php",  
                    data: { editacceso_autovacaciones: 1, 
                            editacceso_dia: $(this).data("fecha"),
                            editacceso_idjornada: $(this).data("jornadaid"),
                            editacceso_tipojornada: $(this).data("tipojornada")
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        loadContent("jornada-wrapper", "/erp/apps/jornada/vistas/registro-jornada_new.php?year="+<? echo $yearNum ?>+"&month="+<? echo $monthNum ?>+"&idt="+<? echo $idtrabajador ?>);    
                        //window.location.reload();
                    }   
                });
            });
            
            $(document).on("click", ".add-automedico", function(){
                $(this).html('<img src="/erp/img/btn-ajax-loader.gif" height="10" />');
                //$(".add-automedico").click(function() {
                $.ajax({
                    type: "POST",  
                    url: "saveAcceso.php",  
                    data: { editacceso_automedico: 1, 
                            editacceso_dia: $(this).data("fecha"),
                            editacceso_idjornada: $(this).data("jornadaid"),
                            editacceso_tipojornada: $(this).data("tipojornada")
                          },
                    dataType: "text",       
                    success: function(response)  
                    {
                        loadContent("jornada-wrapper", "/erp/apps/jornada/vistas/registro-jornada_new.php?year="+<? echo $yearNum ?>+"&month="+<? echo $monthNum ?>+"&idt="+<? echo $idtrabajador ?>);    
                        //window.location.reload();
                    }   
                });
            });
            
            $(document).on("click", "#btn_del_detalleacceso", function(){
            //$("#btn_del_detalleacceso").click(function() {
                $("#btn_del_detalleacceso").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#editacceso_del").val($("#editacceso_id").val());
                data = $("#frm_edit_acceso").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveAcceso.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        loadContent("jornada-wrapper", "/erp/apps/jornada/vistas/registro-jornada_new.php?year="+<? echo $yearNum ?>+"&month="+<? echo $monthNum ?>+"&idt="+<? echo $idtrabajador ?>);
                        $('#frm_edit_acceso').trigger("reset");
                        $("#btn_del_detalleacceso").html('Eliminar');
                        $("#editacceso_success").slideDown();
                        setTimeout(function(){
                            $("#editacceso_success").fadeOut("slow");
                            $("#detalleacceso_add_model").modal("hide");
                            //window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            $(document).on("click", "#btn_save_festivo", function(){
            //$("#btn_save_festivo").click(function() {
                $("#btn_save_festivo").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_festivos").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveFestivo.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_festivos').trigger("reset");
                        $("#btn_save_festivo").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#festivo_success").slideDown();
                        setTimeout(function(){
                            $("#festivo_success").fadeOut("slow");
                            //window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            $(document).on("click", "#btn_save_media", function(){
            //$("#btn_save_media").click(function() {
                $("#btn_save_media").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_media").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveMedia.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_media').trigger("reset");
                        $("#btn_save_media").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#media_success").slideDown();
                        setTimeout(function(){
                            $("#media_success").fadeOut("slow");
                            //window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            $(document).on("click", "#gen-jornadas", function(){
            //$("#gen-jornadas").click(function() {
                $("#gen-jornadas").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Generando ...');
                $.getJSON("/erp/apps/jornada/genJornadas.php", 
                {
                   trabajadorid: <? echo $idtrabajador; ?>,
                   start_date: "2023-01-01",
                   end_date: "2023-12-31"
                },
                function(data) { 
                    console.log (data);
                    //obj = JSON.parse(data);
                    window.location.reload();
                });
            });
            
            $(document).on("click", "#gen-jornadas-all", function(){
            //$("#gen-jornadas-all").click(function() {
                $("#gen-jornadas-all").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Generando ...');
                $.getJSON("/erp/apps/jornada/genJornadasAll.php", 
                {
                   trabajadorid: <? echo $idtrabajador; ?>,
                   start_date: "2023-01-01",
                   end_date: "2023-12-31"
                },
                function(data) { 
                    console.log (data);
                    //obj = JSON.parse(data);
                    window.location.reload();
                });
            });
            
            $(document).on("click", "#save-calendario", function(){
            //$("#save-calendario").click(function() {
                $.getJSON("/erp/apps/jornada/saveCalendario.php", 
                {
                   start_date: "2021-01-01",
                   end_date: "2021-12-31"
                },
                function(data) { 
                    console.log (data);
                    //obj = JSON.parse(data);
                    window.location.reload();
                });
            });
//            OLD
//            $("#exportar-excel").click(function() {
//                //location.href = "//192.168.3.109/erp/apps/jornada/expExcel.php";
//                var datos = {"trabajadorid":<? echo $idtrabajador; ?>};
                //alert(<? //echo $idtrabajador; ?>);
//                $.ajax({
//                    type: "POST",  
//                    url: "expExcel.php",  
//                    data: datos,
//                    dataType: "text",       
//                    success: function(response)  
//                    {
//                        console.log (response);
//                        location.href = "//192.168.3.109/erp/apps/jornada/expExcel.php/?idt="+ $('#filter_trabajadores').val() + "&year=" + $('#filter_year').val() + "&mes=" + $('#filter_mes').val();
//                        setTimeout(function(){
//                            //$("#media_success").fadeOut("slow");
//                            //window.location.reload();
//                        }, 2000);
//                    }   
//                });
//            });
            $(document).on("click", "#exportar-excel-m", function(){
            //$("#exportar-excel-m").click(function() {
                $("#exportar-excel-m").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                //location.href = "//192.168.3.109/erp/apps/jornada/expExcel.php";
                //var datos = {"trabajadorid":<? echo $idtrabajador; ?>};
                //alert(<? //echo $idtrabajador; ?>);
                $.ajax({
                    type: "POST",  
                    url: "expExcelM.php",  
                    data: {
                        idtrabajador:<? echo $idtrabajador; ?>,
                        monthNum:<? echo $monthNum; ?>,
                        yearNum:<? echo $yearNum; ?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log (response);
                        window.open(response);
                        //location.href = response;
                        $("#exportar-excel-m").html('<img src="/erp/img/excelM.png" height="20" />');
                        setTimeout(function(){
                            //$("#media_success").fadeOut("slow");
                            //window.location.reload();
                        }, 2000);
                    }   
                });
            });
            $(document).on("click", "#exportar-excel-a", function(){
            //$("#exportar-excel-a").click(function() {
                console.log("Dentro de export-A");
                $("#exportar-excel-a").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                //location.href = "//192.168.3.109/erp/apps/jornada/expExcel.php";
                //var datos = {"trabajadorid":<? //echo $idtrabajador; ?>};
                //alert(<? //echo $idtrabajador; ?>);
                $.ajax({
                    type: "POST",  
                    url: "expExcelA.php",  
                    data: {
                        idtrabajador:<? echo $idtrabajador; ?>,
                        monthNum:<? echo $monthNum; ?>,
                        yearNum:<? echo $yearNum; ?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log (response);
                        window.open(response);
                        //location.href = response;
                        $("#exportar-excel-a").html('<img src="/erp/img/excelA.png" height="20" />');
                        setTimeout(function(){
                            //$("#media_success").fadeOut("slow");
                            //window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            /*80.38.129.5
            * CAMBIO DE PROYECTO ASOCIADO
             */
            $(document).on("mouseenter", ".proyecto_jornada", function(){
                
                $(this).css("color","red");
        
                //$(this).html("cambiar");
                //console.log("dentro");
            });
            $(document).on("mouseout", ".proyecto_jornada", function(){
                
                $(this).css("color","#333");
                //$(this).html($(this).data("text"));
                //console.log("fuera.hijo");
            });
            $(document).on("mouseenter", ".proyecto_jornada_td", function(){
                $(this).first().css("color","red");
                //$(this).first().html("cambiar");
                //console.log("dentro");
            });
            $(document).on("mouseout", ".proyecto_jornada_td", function(){
                
                $(this).first().css("color","#333");
                //console.log("fuera.td.");
                //console.log($(this).first());
            });
            
            $(document).on("click", ".proyecto_jornada", function(){
                $("#idcalendariojornada").val($(this).parent().parent().data("id"));
                $("#idtrabajadorjornada").val($("#filter_trabajadores").val());
                $("#proyectojornada_model").modal("show"); 
                //console.log("cambio");
            });
            $(document).on("click", ".proyecto_jornada_td", function(){
                $("#idcalendariojornada").val($(this).parent().data("id"));
                //console.log("value id: "+$("#iddattrabajador").val());
                $("#idtrabajadorjornada").val($("#iddattrabajador").val());
                $("#proyectojornada_model").modal("show"); 
                //console.log("cambio");
            });
            
            $(document).on("click", "#btn_save_proyectojornada", function(){
                data = $("#frm_edit_proyectojornada").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveJornadaProyectos.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log (response);
                        //location.href = response;
                        $('#frm_edit_proyectojornada').trigger("reset");
                        $("#proyectojornada_success").slideDown();
                        loadContent("jornada-wrapper", "/erp/apps/jornada/vistas/registro-jornada_new.php?year="+<? echo $yearNum ?>+"&month="+<? echo $monthNum ?>+"&idt="+<? echo $idtrabajador ?>);
                        setTimeout(function(){
                            $("#proyectojornada_success").fadeOut("slow");
                            $("#proyectojornada_model").modal("hide");
                            //window.location.reload();
                        }, 1200);
                    }   
                });
            });
            
            // Ver tabla de excels
            $(document).on("click", "#view-tabla-excels-div", function(){
                if($("#tabla-excels-div").is(':visible')){
                    $("#tabla-excels-div").hide();
                }else{
                    $("#tabla-excels-div").show();
                }
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
    <? include($pathraiz."/includes/header.php"); ?>
    
    <section id="contenido">
        <div id="erp-titulo" class="one-column">
            <h3>
                REGISTRO DE LA JORNADA LABORAL
            </h3>
        </div>
        <div id="dash-header">
            <div id="proyectos-filterbar" class="one-column">
                <? include($pathraiz."/apps/jornada/vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-datosempresa" class="two-column">
                <h4 class="dash-title">
                    DATOS DE LA EMPRESA
                    <? //include($pathraiz."/apps/proyectos/includes/tools.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div>
                    <? 
                        include($pathraiz."/apps/jornada/vistas/registro-datosempresa.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-datostrabajador" class="two-column">
                <h4 class="dash-title">
                    DATOS DEL TRABAJADOR
                    <? //include($pathraiz."/apps/proyectos/includes/tools.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div>
                    <? 
                        include($pathraiz."/apps/jornada/vistas/registro-datostrabajador.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-periodoliquidacion" class="one-column">
                <div>
                    <? 
                        include($pathraiz."/apps/jornada/vistas/registro-periodoliquidacion.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-jornadalaboral" class="one-column">
                <h4 class="dash-title">
                    JORNADA LABORAL
                    <? include($pathraiz."/apps/jornada/includes/tools-jornada.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="jornada-wrapper" style="text-align: center;">
                    <? 
                        //include($pathraiz."/apps/jornada/vistas/registro-jornada_new.php"); 
                    ?>
                </div>
            </div>
            
            <span class="stretch"></span>
        </div>
        
        
    </section>
	
</body>
</html>