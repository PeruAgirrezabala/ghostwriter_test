<?
    include("../../common.php");
    
    checkPedidosProg ();

    if(!isset($_SESSION['user_session']))
    {
        $logeado = checkCookie();
        if ($logeado == "no") {
            header("Location: /erp/login.php");
        }
    }
    else {
        //aqui hago una select para verificar el tipo de usuario que es los proyectos a los que tiene acceso
        if ($_GET['year']) {
            $yearNum = $_GET['year'];
        }
        else {
            $yearNum  = date('Y');
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

<!-- custom js -->
<script src="/erp/functions.js"></script>

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                    $(this).effect('bounce',3000);
            });	

            $("#menuitem-previsiones").addClass("active");          
            
            year = "<? echo date("Y"); ?>";
            mes = "<? echo date("m"); ?>";
            
            loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + year);
            loadContent("dash-previsiones-calendario", "vistas/genelek-previsiones-calendario.php?year=" + year+"&mes="+mes);
            
            loadSelectYears("filter_years","PEDIDOS_PROV","fecha","","");
            loadSelect("filter_clientes","CLIENTES","id","","");
            loadSelect("filter_tecnicos","erp_users","id","empresa_id","1","apellidos");
            loadSelect("filter_proyectos","PROYECTOS","id","","","nombre");
            loadSelect("filter_estados","PREVISIONES_ESTADOS","id","","","");
            loadSelect("prev_tecnicos","erp_users","id","","","apellidos");
            loadSelect("prev_proyectos","PROYECTOS","id","tipo_proyecto_id","1","ref");
            loadSelect("prev_mantenimientos","PROYECTOS","id","tipo_proyecto_id","2","ref");
            loadSelect("prev_intervenciones","INTERVENCIONES","id","","","ref");
            loadSelect("prev_ofertas","OFERTAS","id","","","ref");
            loadSelect("prev_clientes","CLIENTES","id","","","");
            loadSelect("prev_estados","PREVISIONES_ESTADOS","id","","","");
            loadSelect("filtro_calendario_tecnicos","erp_users","id","","","apellidos");
            loadSelect("filtro_calendario_tipo_prevision","PREVISIONES_TIPOS","id","","","");
            
            
            $("#calendario_mes").selectpicker('refresh');
            $("#calendario_mes").selectpicker("render");
            $("#filtro_calendario_mes").val(<? echo date("m");?>);
            $("#filtro_calendario_year").val(<? echo date("Y");?>);
            $(".selectpicker").selectpicker();
            
            
            // Dependiendo de tipo mostrar uno u otro
            $('#prev_tipos').on('changed.bs.select', function (e) {
                console.log($(this).val());
                loadCombosTipo($(this).val());
            });
            
            setTimeout(function(){
                $("#filter_years").selectpicker("val", year);
                $("#filter_years").parent().children("button").addClass("filter-selected");
            }, 2000);
            
            $('#refresh-previsiones').click(function () {
                loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + $('#filter_years').val() + "&month=" + $('#filter_mes').val() + "&tec=" + $('#filter_tecnicos').val() + "&estado=" + $('#filter_estados').val() + "&pro=" + $('#filter_proyectos').val());
                //$("#calendario_mes").selectpicker('refresh');
                //$("#calendario_mes").selectpicker("render");
            });
            
            $(document).on("click", ".page-link" , function() {
                loadContent("dash-previsiones", "/erp/apps/previsiones/vistas/genelek-previsiones.php?pag=" + $(this).data("pag") + "&year=" + $('#filter_years').val() + "&month=" + $('#filter_mes').val() + "&tec=" + $('#filter_tecnicos').val() + "&estado=" + $('#filter_estados').val() + "&pro=" + $('#filter_proyectos').val());
            });
            
            $('#clean-filters').click(function () {
               loadContent("dash-previsiones", "vistas/genelek-previsiones.php?");
               $("#filter_tecnicos").selectpicker("val", "");
               $("#filter_clientes").selectpicker("val", "");
               $("#filter_estados").selectpicker("val", "");
               $("#filter_years").selectpicker("val", "");
               $("#filter_mes").selectpicker("val", "");
               $("#filter_tecnicos").parent().children("button").removeClass("filter-selected");
               $("#filter_estados").parent().children("button").removeClass("filter-selected");
               $("#filter_clientes").parent().children("button").removeClass("filter-selected");
               $("#filter_years").parent().children("button").removeClass("filter-selected");
               $("#filter_mes").parent().children("button").removeClass("filter-selected");
            });
            
            $('#filter_tecnicos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + $('#filter_years').val() + "&month=" + $('#filter_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&tec=" + $(this).val() + "&pro=" + $('#filter_proyectos').val());
            });
            
            $('#filter_clientes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + $('#filter_years').val() + "&month=" + $('#filter_mes').val() + "&cli=" + $(this).val() + "&estado=" + $('#filter_estados').val() + "&tec=" + $('#filter_tecnicos').val() + "&pro=" + $('#filter_proyectos').val());
            }); 
            $('#filter_estados').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + $('#filter_years').val() + "&month=" + $('#filter_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $(this).val() + "&tec=" + $('#filter_tecnicos').val() + "&pro=" + $('#filter_proyectos').val());
            });
            $('#filter_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + $(this).val() + "&month=" + $('#filter_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&tec=" + $('#filter_tecnicos').val() + "&pro=" + $('#filter_proyectos').val());
            });
            $('#filter_mes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + $('#filter_years').val() + "&month=" + $(this).val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&tec=" + $('#filter_tecnicos').val() + "&pro=" + $('#filter_proyectos').val());
            });
            $('#filter_proyectos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + $('#filter_years').val() + "&month=" + $('#filter_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&tec=" + $('#filter_tecnicos').val() + "&pro=" + $(this).val());
            });
            
            // REFRESCO CALENDARIO
            $(document).on("click", "#refresh-previsiones-calendario" , function() {
                $("#filtro_calendario_mes").val(mes);
                $("#filtro_calendario_mes").selectpicker('refresh');
                $("#filtro_calendario_mes").selectpicker("render");
                $("#filtro_calendario_year").val(year);
                $("#filtro_calendario_year").selectpicker('refresh');
                $("#filtro_calendario_year").selectpicker("render");
                $("#filtro_calendario_tipo_prevision").val("");
                $("#filtro_calendario_tecnicos").val("");
                $("#filtro_calendario_tipo_prevision").selectpicker('refresh');
                $("#filtro_calendario_tipo_prevision").selectpicker("render");
                $("#filtro_calendario_tecnicos").selectpicker('refresh');
                $("#filtro_calendario_tecnicos").selectpicker("render");
                $("#filtro_calendario_mes").parent().children("button").removeClass("filter-selected");
                $("#filtro_calendario_year").parent().children("button").removeClass("filter-selected");
                $("#filtro_calendario_tipo_prevision").parent().children("button").removeClass("filter-selected");
                $("#filtro_calendario_tecnicos").parent().children("button").removeClass("filter-selected");
                loadContent("dash-previsiones-calendario", "vistas/genelek-previsiones-calendario.php?year=" + year+"&mes="+mes);
            });
            
            // Cambio de filtros:
            $('#filtro_calendario_mes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log($(this).val());
                loadContent("dash-previsiones-calendario", "vistas/genelek-previsiones-calendario.php?year=" + $("#filtro_calendario_year").val()+"&mes="+$(this).val()+"&tipo_prevision="+$("#filtro_calendario_tipo_prevision").val()+"&tecnico="+$("#filtro_calendario_tecnicos").val());
            });
            $('#filtro_calendario_year').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log($(this).val());
                loadContent("dash-previsiones-calendario", "vistas/genelek-previsiones-calendario.php?year=" + $(this).val()+"&mes="+$("#filtro_calendario_mes").val()+"&tipo_prevision="+$("#filtro_calendario_tipo_prevision").val()+"&tecnico="+$("#filtro_calendario_tecnicos").val());
            });
            $('#filtro_calendario_tipo_prevision').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log($(this).val());
                loadContent("dash-previsiones-calendario", "vistas/genelek-previsiones-calendario.php?year=" + $("#filtro_calendario_year").val()+"&mes="+$("#filtro_calendario_mes").val()+"&tipo_prevision="+$(this).val()+"&tecnico="+$("#filtro_calendario_tecnicos").val());
            });
            $('#filtro_calendario_tecnicos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log($(this).val());
                loadContent("dash-previsiones-calendario", "vistas/genelek-previsiones-calendario.php?year=" + $("#filtro_calendario_year").val()+"&mes="+$("#filtro_calendario_mes").val()+"&tipo_prevision="+$("#filtro_calendario_tipo_prevision").val()+"&tecnico="+$(this).val());
            });
            //
            $('#prev_clientes').on('changed.bs.select', function (e) {
                //ajax to change Instalaciones
                $.ajax({
                    type: "POST",  
                    url: "cargarInstalaciones.php",  
                    data: {
                      cliente_id : $("#prev_clientes").val()  
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        $("#prev_instalacion").html(response).selectpicker('refresh');
                        console.log(response); // va bien
                        setTimeout(function(){
                            //window.location.reload();
                            
                        }, 1000);
                    }   
                });
            });
            
            $("#ver-previsiones").click(function() {
                loadContent("contenedor-previsiones", "vistas/vista-calendario-prev.php?yearNum=<? echo $yearNum; ?>");
                $("#calendario_prev").modal('show');
            });
            
            $("#add-prev").click(function() {
                $("#prev_tipos").prop("disabled",false);
                $("#prev_clientes").prop("disabled",false);
                $("#prev_proyectos").prop("disabled",false);
                $("#prev_tipos").prop("disabled",false);
                
                $("#prev_id").val("");
                $('#frm_previsiones').trigger("reset");
                $("#prev_clientes").selectpicker("val", "");
                $('#prev_addtecnicos').empty();
                $("#prev_proyectos").selectpicker("val", "");
                $("#prev_tipos").selectpicker("val", "");
                $("#prev_estados").selectpicker("val", "");
                $("#addprev_model").modal('show');
            });
            
            $("#btn_add_tec").click(function() {
                $('#prev_addtecnicos').append($('<option>', {value:$("#prev_tecnicos").val(), text:$("#prev_tecnicos").find("option:selected").text()}));
            });
            
            $("#btn_clear_tec").click(function() {
                $('#prev_addtecnicos option:selected').remove();
            });
            $("#btn_prev_save").click(function() {
                $("#btn_prev_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#prev_addtecnicos option").prop("selected", true);
                data = $("#frm_previsiones").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "savePrevision.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_previsiones').trigger("reset");
                        $("#btn_prev_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#prev_success").slideDown();
                        setTimeout(function(){
                            $("#prev_success").fadeOut("slow");
                            // mejorar recarga
                            // dash-previsiones
                            $("#addprev_model").modal('hide');
                            loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + year);
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $(document).on("click", ".remove-prev" , function() {
                //Mostrar Pop-Up
                $("#del_prevision_id").val($(this).data("id"));
                //console.log($(this).data("id"));
                //console.log($(this).parent("tr").data("id"));
                $("#delete_prevision_model").modal('show');
            });
            $(document).on("click", "#btn_del_prevision" , function() {
                $.ajax({
                    type : 'POST',
                    url : 'savePrevision.php',
                    dataType : 'text',
                    data: {
                        prev_del : $("#del_prevision_id").val()
                    },
                    success : function(data){
                        //console.log("ok");
                        $("#delete_prevision_model").modal('hide');
                        loadContent("dash-previsiones", "vistas/genelek-previsiones.php?year=" + year);
                        //window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $(document).on("click", "#tabla-previsiones tr > td:not(:nth-child(8)):not(:nth-child(5))" , function() {
                loadPrevisionInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                loadCombosTipo($(this).parent("tr").data("type").toString());
                $("#prev_tipos").prop("disabled",true);
                $("#prev_clientes").prop("disabled",true);
                $("#prev_proyectos").prop("disabled",true);
                $("#prev_tipos").prop("disabled",true);
                $("#addprev_model").modal('show');
            });
            
            $(document).on("click", ".view-prevision" , function() {
                console.log("Data: "+$(this).data("id"));
                console.log("Tipo: "+$(this).data("type"));
            });
            
	});
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
		$(obj).fadeIn(3000);
	};
        
        function loadCombosTipo(tipo){
            console.log("Tipo: "+tipo);
            switch(tipo){
                    case "1":
                        // Mantenimiento
                        console.log("M.Tipo: "+tipo);
                        $("#grupo_mantenimiento").show();
                        $("#grupo_intervencion").hide();
                        $("#grupo_proyecto").hide();
                        $("#grupo_oferta").hide();
                        break;
                    case "2":
                        // Intervencion
                        console.log("I.Tipo: "+tipo);
                        $("#grupo_mantenimiento").hide();
                        $("#grupo_intervencion").show();
                        $("#grupo_proyecto").hide();
                        $("#grupo_oferta").hide();
                        break;
                    case "3":
                        // Proyecto
                        console.log("P.Tipo: "+tipo);
                        $("#grupo_mantenimiento").hide();
                        $("#grupo_intervencion").hide();
                        $("#grupo_proyecto").show();
                        $("#grupo_oferta").hide();
                        break;
                    case "4":
                        // Visita ...
                        break;
                    case "5":
                        // ?¿ Gestion Interna ...
                        break;
                    case "6":
                        // Oferta
                        console.log("O.Tipo: "+tipo);
                        $("#grupo_mantenimiento").hide();
                        $("#grupo_intervencion").hide();
                        $("#grupo_proyecto").hide();
                        $("#grupo_oferta").show();
                        break;
                }
        }
	
</script>

<title>Previsiones | Erp GENELEK</title>
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
                Previsiones de Desplazamientos
            </h3>
        </div>
        <div id="dash-header">
            <div id="proyectos-filterbar" class="one-column">
                <? include("vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-previsiones-container" class="one-column">
                <h4 class="dash-title">
                    PREVISIONES <? include("includes/tools-previsiones.php"); ?>
                </h4>
                <hr class="dash-underline" style="margin-bottom: 0px;">
                <div class="loading-div"></div>
                <div id="dash-previsiones">
                    <? //include("vistas/genelek-previsiones.php"); ?>
                </div>
                
            </div>
            <span class="stretch"></span>
        </div>
        <div id="dash-content">
            <div id="dash-previsiones-container" class="one-column">
                <h4 class="dash-title">
                    PREVISIONES CALENDARIO <? include("includes/tools-previsiones-calendario.php"); ?>
                </h4>
                
                <div class="loading-div"></div>
                <div id="dash-previsiones-calendario">
                    <? //include("vistas/genelek-previsiones.php"); ?>
                </div>
                
            </div>
            <span class="stretch"></span>
        </div>
        
        
    </section>
	
    <div id="calendario_prev" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="display: inline-block;">CALENDARIO PREVISIONES</h4>
            </div>
            <div class="modal-body">
                <div class="loading-div"></div>
                <div class="contenedor-form" id="contenedor-previsiones">
                    
                </div>
                <div id="leyendaVacaciones" style="margin-top: 50px;">
                    <?
                        $db = new dbObj();
                        $connString =  $db->getConnstring();
                        
                        $sql = "SELECT 
                                        erp_users.nombre,
                                        erp_users.apellidos,
                                        erp_users.color
                                    FROM 
                                        erp_users
                                    WHERE
                                        erp_users.empresa_id = 1
                                    ORDER BY 
                                        nombre ASC";

                        file_put_contents("queryCalendario.txt", $sql);
                        $resultado = mysqli_query($connString, $sql) or die("Error al ejecutar la consulta de la Leyenda");

                        while ($registros = mysqli_fetch_array($resultado)) { 
                            echo "<label class='label block' style='white-space: normal;'><span class='badge' style='background-color:".$registros[2]."; white-space: normal;'>".$registros[0]." ".$registros[1]."</span></label>";
                        }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
    
</body>
</html>