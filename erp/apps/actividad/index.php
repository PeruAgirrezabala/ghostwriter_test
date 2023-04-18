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

            $("#menuitem-actividad").addClass("active");
            
            loadSelectYears("filter_act_years","ACTIVIDAD","fecha","","");
            loadSelect("filter_clientes","CLIENTES","id","","");
            loadSelect("filter_estados","ACTIVIDAD_ESTADOS","id","","","");
            loadSelect("filter_prioridades","ACTIVIDAD_PRIORIDADES","id","","","");
            loadSelect("act_categorias","ACTIVIDAD_CATEGORIAS","id","","","");
            loadSelect("act_tareas","TAREAS","id","","","");
            loadSelect("act_mantenimientos","PROYECTOS","id","tipo_proyecto_id","2","ref");
            loadSelect("act_proyectos","PROYECTOS","id","tipo_proyecto_id","1","ref");
            loadSelect("act_ofertas","OFERTAS","id","","","ref");
            loadSelect("act_prior","ACTIVIDAD_PRIORIDADES","id","","","");
            loadSelect("act_clientes","CLIENTES","id","","","");
            loadSelect("act_estados","ACTIVIDAD_ESTADOS","id","","","");
            loadSelect("act_responsable","erp_users","id","empresa_id","1","apellidos","activo","'on'","",0); // Selecciona los trabajadores activos
            //loadSelect("act_responsable","erp_users","id","","","apellidos"); // Selecciona todos los trabajadores
            loadSelect("act_tecnicos","erp_users","id","empresa_id","1","apellidos","activo","'on'","",0); // Selecciona los trabajadores activos
            //loadSelect("act_tecnicos","erp_users","id","","","apellidos"); // Selecciona todos los trabajadores
            loadSelect("filter_tecnico","erp_users","id","empresa_id","1","apellidos","activo","'on'","",0); // Selecciona los trabajadores activos
            //loadSelect("filter_tecnico","erp_users","id","","","apellidos"); // Selecciona todos los trabajadores
            loadSelect("filter_categoria","ACTIVIDAD_CATEGORIAS","id","","","");
            
            var d = new Date();
            var month = d.getMonth()+1;
            var day = d.getDate();
            var output = d.getFullYear() + '-' +
                ((''+month).length<2 ? '0' : '') + month + '-' +
                ((''+day).length<2 ? '0' : '') + day;
            
            setTimeout(function(){
                $("#act_responsable").selectpicker("val", "<? echo $_SESSION['user_session']; ?>");
                $("#act_tecnicos").selectpicker("val", "<? echo $_SESSION['user_session']; ?>");
                $("#act_estados").selectpicker("val", "1");
                $("#act_prior").selectpicker("val", "1");
                $("#act_fecha").val(output);
                $("#filter_act_years").selectpicker("val", "<? echo date("Y"); ?>");
                $("#filter_act_years").parent().children("button").addClass("filter-selected");
            }, 4000);
            
            $('input[name="act_chkimputable"]').bootstrapSwitch({
                // The checkbox state. Se pone a true para que sea SI!
                state: true,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            $('input[name="act_chkfacturable"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            // Cambiar carga de instalaciones dependiendo del cliente seleccionado
            $('#act_clientes').on('changed.bs.select', function (e) {
                loadSelect("act_instalacion","CLIENTES_INSTALACIONES","id","cliente_id",$(this).val(),"");
            });
            
            loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=<? echo date("Y"); ?>");
            
            $(document).on("click", ".page-link" , function() {
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?pag=" + $(this).data("pag") + "&year=" + $("#filter_act_years").val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val()+ "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$("#filter_fsolucion").val());
            });
            
            $('#refresh-act').click(function () {
               loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val()+ "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$("#filter_fsolucion").val());
            });
            
            $('#clean-filters').click(function () {
               loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php");
               $("#filter_clientes").selectpicker("val", "");
               $("#filter_estados").selectpicker("val", "");
               $("#filter_prioridades").selectpicker("val", "");
               $("#filter_act_years").selectpicker("val", "");
               $("#filter_act_mes").selectpicker("val", "");
               $("#filter_tecnico").selectpicker("val", "");
               $("#filter_categoria").selectpicker("val", "");
               $("#filter_ffin").selectpicker("val", "");
               $("#filter_fsolucion").selectpicker("val", "");
               $("#filter_clientes").parent().children("button").removeClass("filter-selected");
               $("#filter_estados").parent().children("button").removeClass("filter-selected");
               $("#filter_prioridades").parent().children("button").removeClass("filter-selected");
               $("#filter_act_years").parent().children("button").removeClass("filter-selected");
               $("#filter_act_mes").parent().children("button").removeClass("filter-selected");
               $("#filter_tecnico").parent().children("button").removeClass("filter-selected");
               $("#filter_categoria").parent().children("button").removeClass("filter-selected");
               $("#filter_ffin").parent().children("button").removeClass("filter-selected");
               $("#filter_fsolucion").parent().children("button").removeClass("filter-selected");
            });
            
            $('#filter_act').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                location.href = "/erp/apps/actividad/editAct.php?id=" + $(this).val();
            });
            
            $('#filter_clientes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $(this).val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val() + "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$('#filter_fsolucion').val());
                //location.href = "/erp/apps/actividad/?cli=" + $(this).val() + "&year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&estado=" + $('#filter_act_estados').val() + "&prior=" + $('#filter_prioridades').val();
            }); 
            $('#filter_estados').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $(this).val() + "&prior=" + $('#filter_prioridades').val() + "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$('#filter_fsolucion').val());
                //location.href = "/erp/apps/actividad/?cli=" + $('#filter_clientes').val() + "&year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&estado=" + $(this).val() + "&prior=" + $('#filter_prioridades').val();
            });
            $('#filter_prioridades').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $(this).val() + "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$('#filter_fsolucion').val());
                //location.href = "/erp/apps/actividad/?cli=" + $('#filter_clientes').val() + "&year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $(this).val();
            });
            $('#filter_act_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $(this).val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val() + "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$('#filter_fsolucion').val());
                //location.href = "/erp/apps/actividad/?year=" + $(this).val() + "&month=" + $('#filter_act_mes').val() + "&cli=" +  $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val();
            });
            $('#filter_act_mes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $(this).val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val() + "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$('#filter_fsolucion').val());
                //if ($('#filter_act_years').val() != "") {
                //    location.href = "/erp/apps/actividad/?year=" + $('#filter_act_years').val() + "&month=" + $(this).val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val();
                //}
            });
            $('#filter_tecnico').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val() + "&tec="+$(this).val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$('#filter_fsolucion').val());
                //location.href = "/erp/apps/actividad/?cli=" + $('#filter_clientes').val() + "&year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $(this).val();
            });
            $('#filter_categoria').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val() + "&tec="+$('#filter_tecnico').val()+"&cat="+$(this).val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$('#filter_fsolucion').val());
                //location.href = "/erp/apps/actividad/?cli=" + $('#filter_clientes').val() + "&year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $(this).val();
            });
            
            
            $('#filter_ffin').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val() + "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$(this).val()+"&fsol="+$('#filter_fsolucion').val());
                //location.href = "/erp/apps/actividad/?cli=" + $('#filter_clientes').val() + "&year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $(this).val();
            });
            $('#filter_fsolucion').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-act", "/erp/apps/actividad/vistas/act-home.php?year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&cli=" + $('#filter_clientes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $('#filter_prioridades').val() + "&tec="+$('#filter_tecnico').val()+"&cat="+$('#filter_categoria').val()+"&ffin="+$('#filter_ffin').val()+"&fsol="+$(this).val());
                //location.href = "/erp/apps/actividad/?cli=" + $('#filter_clientes').val() + "&year=" + $('#filter_act_years').val() + "&month=" + $('#filter_act_mes').val() + "&estado=" + $('#filter_estados').val() + "&prior=" + $(this).val();
            });
            
            
            
            // Ver desde calendario
//            $(document).on("click", ".view-prevision" , function() {
//                window.open(
//                    "editAct.php?id=" + $(this).data("id"),
//                    '_blank' 
//                );
//            });
            $(document).on("mousedown", ".view-prevision" , function(e) {
                if($(this).data("id")==""){
                    // Nada. Comprobar que no sea vacio.... Sino abre una pestaña sin id
                }else{
                    switch(e.which)
                    {
                        case 1: // left click
                            window.open(
                                "editAct.php?id=" + $(this).data("id"),
                                '_blank' 
                            );
                        break;
                        case 2: // middle click
                            window.open(
                                "editAct.php?id=" + $(this).data("id"),
                                '_blank' 
                            );
                        break;
                        case 3:
                            //right Click
                        break;
                    }
                }
                
            });
            // Tabla sin asignar
            $(document).on("click", "#tabla-sin-asignar tr > td" , function() {
                window.open(
                    "editAct.php?id=" + $(this).parent("tr").data("id"),
                    '_blank' 
                );
            });
            // Tabla prioridades
            $(document).on("click", "#tabla-plan-prior tr > td" , function() {
                window.open(
                    "editAct.php?id=" + $(this).parent("tr").data("id"),
                    '_blank' 
                );
            });
            // Tabla últimas modificadas
            $(document).on("click", "#tabla-ultimas-mod tr > td" , function() {
                window.open(
                    "editAct.php?id=" + $(this).parent("tr").data("id"),
                    '_blank' 
                );
            });
            $(document).on("click", "#tabla-act tr > td:not(:nth-child(14))" , function() {
                window.open(
                    "editAct.php?id=" + $(this).parent("tr").data("id"),
                    '_blank' 
                );
            });
            
            $("#add-act").click(function() {
                $('#act_addtecnicos').empty();
                
                $("#addact_model").modal('show');
            });
           
            $("#btn_act_save").click(function() {
                $("#btn_act_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#act_addtecnicos option").prop("selected", true);
                data = $("#frm_act_addact").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveAct.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log("Dato ID: "+response);
                        $("#btn_act_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        // Realizar comprobaciones!!
                        // Comprobar si devuelve un numero o false. Es decir, si están los datos necesarios introducidos
                        if(response==false){
                            $("#act_error").slideDown();
                        }else{
                            $("#act_success").slideDown();
                        }
                        setTimeout(function(){
                            $("#act_success").fadeOut("slow");                            
                            // Realizar comprobaciones!!
                            // Comprobar si devuelve un numero o false. Es decir, si están los datos necesarios introducidos
                            if(response==false){
                                $("#act_error").slideDown();
                            }else{
                                $("#act_success").slideDown();
                                window.open('/erp/apps/actividad/editAct.php?id='+response, '_blank');
                                window.location.reload();
                            }
                            //window.location.href = "editAct.php?id=" + response;
                        }, 2000);
                    }   
                });
            });
            // Con las nuevas funcionalidades no se prevee su uso
            $(document).on("click", ".get-act" , function() {
                console.log("Función obsoleta. Borrar si se ve conveniente.");
                $.ajax({
                    type : 'POST',
                    url : 'saveAct.php',
                    dataType : 'text',
                    data: {
                        get_act : $(this).data("id"),
                        soltar_act : $(this).data("soltar")
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
            
            $("#btn_add_tec").click(function() {
                $('#act_addtecnicos').append($('<option>', {value:$("#act_tecnicos").val(), text:$("#act_tecnicos").find("option:selected").text()}));
            });
            $("#btn_clear_tec").click(function() {
                $('#act_addtecnicos option:selected').remove();
            });
            
            /////////////////////////////// CONTENIDO CALENDARIO //////////////////////////////
            year = "<? echo date("Y"); ?>";
            mes = "<? echo date("m"); ?>";
            
            loadContent("dash-previsiones-calendario", "vistas/genelek-planning-calendario.php?year=" + year+"&mes="+mes);
            
            loadSelect("filtro_calendario_tecnicos","erp_users","id","","","apellidos");
            loadSelect("filtro_calendario_tipo_prevision","ACTIVIDAD_CATEGORIAS","id","","","");
            
            
            $("#calendario_mes").selectpicker('refresh');
            $("#calendario_mes").selectpicker("render");
            $("#filtro_calendario_mes").val(<? echo date("m");?>);
            $("#filtro_calendario_year").val(<? echo date("Y");?>);
            $(".selectpicker").selectpicker();
            
            // REFRESCO CALENDARIO
            $(document).on("click", "#refresh-previsiones-calendario" , function() {
                $("#filtro_calendario_mes").val(Number(mes));
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
                loadContent("dash-previsiones-calendario", "vistas/genelek-planning-calendario.php?year=" + year+"&mes="+mes);
            });
            
            // Cambio de filtros:
            $('#filtro_calendario_mes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log($(this).val());
                loadContent("dash-previsiones-calendario", "vistas/genelek-planning-calendario.php?year=" + $("#filtro_calendario_year").val()+"&mes="+$(this).val()+"&tipo_prevision="+$("#filtro_calendario_tipo_prevision").val()+"&tecnico="+$("#filtro_calendario_tecnicos").val());
            });
            $('#filtro_calendario_year').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log($(this).val());
                loadContent("dash-previsiones-calendario", "vistas/genelek-planning-calendario.php?year=" + $(this).val()+"&mes="+$("#filtro_calendario_mes").val()+"&tipo_prevision="+$("#filtro_calendario_tipo_prevision").val()+"&tecnico="+$("#filtro_calendario_tecnicos").val());
            });
            $('#filtro_calendario_tipo_prevision').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log($(this).val());
                loadContent("dash-previsiones-calendario", "vistas/genelek-planning-calendario.php?year=" + $("#filtro_calendario_year").val()+"&mes="+$("#filtro_calendario_mes").val()+"&tipo_prevision="+$(this).val()+"&tecnico="+$("#filtro_calendario_tecnicos").val());
            });
            $('#filtro_calendario_tecnicos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                //console.log($(this).val());
                loadContent("dash-previsiones-calendario", "vistas/genelek-planning-calendario.php?year=" + $("#filtro_calendario_year").val()+"&mes="+$("#filtro_calendario_mes").val()+"&tipo_prevision="+$("#filtro_calendario_tipo_prevision").val()+"&tecnico="+$(this).val());
            });
            //
            // Ver leyenda colores
            $(document).on("click", "#view-leyenda-colores" , function() {
                if($("#leyenda-colores").is(":visible")){
                    $("#leyenda-colores").hide();
                    $("#view-leyenda-colores").attr("title","Ver leyenda Colores")
                    $("#view-leyenda-colores").children("img").attr("src","/erp/img/noojo.png");
                }else{
                    $("#leyenda-colores").show();
                    $("#view-leyenda-colores").attr("title","Ocultar leyenda Colores")
                    $("#view-leyenda-colores").children("img").attr("src","/erp/img/ojo.png");
                }
            });
            
            //
            
            /////////////////////////////////////////////////////////////////////////////////
	});
	
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>Actividad | Erp GENELEK</title>
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
                ACTIVIDAD
            </h3>
        </div>
        <div id="dash-header">
            <div id="dash-numproyectos" class="three-column">
                <h4 class="dash-title">
                    SIN ASIGNAR
                </h4>
                <hr class="dash-underline" style="margin-bottom: 0px;">
                <div class="loading-div"></div>
                <div id="dash-plan-pendientes">
                    <? 
                        include("vistas/sin-asignar.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-ofertfactu" class="three-column">
                <h4 class="dash-title">
                    ÚLTIMAS MODIFICADAS (10 últimas modificaciones)
                </h4>
                <hr class="dash-underline" style="margin-bottom: 0px;">
                <div id="dash-pedidos-ultimos">
                    <? 
                        include("vistas/ultimas-mod.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-filtros" class="three-column">
                <h4 class="dash-title">
                    ACTIVIDAD PRIORITARIA
                </h4>
                <hr class="dash-underline" style="margin-bottom: 0px;">
                <div id="dash-pedidos-fuera" class="pre-scrollable">
                    <? 
                        include("vistas/prioritarias.php"); 
                    ?>
                </div>
                <h4 class="dash-title">
                    ACTIVIDAD RETRASADA
                </h4>
                <hr class="dash-underline" style="margin-bottom: 0px;">
                <div id="dash-pedidos-fuera" class="pre-scrollable">
                    <? 
                        include("vistas/retrasos.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="proyectos-filterbar" class="one-column">
                <? include("vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-actividades" class="one-column">
                <h4 class="dash-title">
                    ACTIVIDAD / INTERVENCIONES
                    <? include($pathraiz."/apps/actividad/includes/tools-act.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="dash-act">
                    <? 
                        //include("vistas/act-home.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
        <div id="dash-content">
            <div id="dash-previsiones-container" class="one-column">
                <h4 class="dash-title">
                    ACTIVIDADES CALENDARIO <? include("includes/tools-planning-calendario.php"); ?>
                </h4>
                
                <div class="loading-div"></div>
                <div id="dash-previsiones-calendario">
                    <? //include("vistas/genelek-PLANNING-CALENDARIO.php"); ?>
                </div>
                
            </div>
            <span class="stretch"></span>
        </div>
        
    </section>
	
</body>
</html>