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

<!-- Bootstrap Treeview
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
    -->
    <link rel="stylesheet" href="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.js"></script>

<!-- custom js -->
<script src="/erp/functions.js"></script>

<!-- Bootstrap switch -->
<link href="/erp/plugins/bootstrap-switch.min.css" rel="stylesheet">
<script src="/erp/plugins/bootstrap-switch.min.js"></script>

<!-- File input -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="/erp/includes/plugins/fileinput/js/locales/es.js"></script>

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            $("#uploaddocs").fileinput({
                uploadUrl: "upload.php?proyectopath=" + $("#proyectos_path").val(),
                dropZoneEnabled: true,
                maxFileCount: 500, 
                language: "es"
            });
            
            filesUpload = [];
            
            $('#uploaddocs').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    pathFile: data.response.uploaded,
                    nombre: $("#proyecto_docnombre").val(),
                    descripcion: $("#proyecto_docdesc").val(),
                    proyecto_id: <? echo $_GET['id'] ?> ,
                    grupo_id: $("#proyecto_docgrupos").val()
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
                
            });

            $("#menuitem-mantenimientos").addClass("active");
            
            loadSelectYears("filter_proyectos_years","PROYECTOS","fecha_ini","","");
            loadSelect("filter_proyectos","PROYECTOS","id","","","ref");
            loadSelect("filter_clientes","CLIENTES","id","","","");
            loadSelect("proyectos_clientes","CLIENTES","id","","","");
            loadSelect("proyectos_estados","PROYECTOS_ESTADOS","id","","","");
            loadSelect("proyecto_docgrupos","GRUPOS_DOC","id","proyecto_id",<? echo $_GET['id']; ?>);
            loadSelect("proyecto_gruposdocgrupos","GRUPOS_DOC","id","proyecto_id",<? echo $_GET['id']; ?>);
            
            loadSelect("proyecto_partetipos","TIPOS_PARTES","id","","","");
            loadSelect("proyecto_parteestados","ESTADOS_PARTES","id","","","");
            loadSelect("proyecto_partetecnicos","erp_users","id","","","apellidos");
            loadSelect("proyectos_parent","PROYECTOS","id","","","ref");
            
            loadSelect("orden_tecnicos","erp_users","id","","", "apellidos");
            loadSelect("orden_tareas","TAREAS","id","","", "perfil_id");
            
            loadSelect("horas_tareas","TAREAS","id","","", "perfil_id");
            loadSelect("horas_tecnicos","erp_users","id","","", "apellidos");
            
            loadSelect("proyectos_tipoproyecto","TIPOS_PROYECTO","id","","","");
            
            // Load select de modal add visitas
            loadSelect("visita_responsable_mant","erp_users","id","","","apellidos");
            loadSelect("visita_estado_mant","ACTIVIDAD_ESTADOS","id","","","");
            loadSelect("visita_prioridad_mant","ACTIVIDAD_PRIORIDADES","id","","","");
            loadSelect("visita_tecnicos_mant","erp_users","id","","","apellidos");
            // Carga y descarga de usuarios al select
            $("#btn_add_tec").click(function() {
                console.log("Seleccionado: "+ $("#visita_tecnicos_mant").val() + $("#visita_tecnicos_mant").find("option:selected").text());
                $("#div_visita_addtecnicos_mant").find("select").append($('<option>', {value:$("#visita_tecnicos_mant").val(), text:$("#visita_tecnicos_mant").find("option:selected").text()}));
            });
            $("#btn_clear_tec").click(function() {
                console.log("Seleccionado: "+ $("#visita_tecnicos_mant").val() + $("#visita_tecnicos_mant").find("option:selected").text());
                $("#div_visita_addtecnicos_mant").find("select").find("option:selected").remove();
            });
            
            
            

            $("#btn_add_exp").click(function() {
                $('#proyectos_expedientes').append($('<option>', {value:$("#proyectos_parent").val(), text:$("#proyectos_parent").find("option:selected").text()}));
            });
            $("#btn_add_visita").click(function() {
                // Comprobar que no sea fecha = 0 
                if($("#proyectos_edit_fechavisita").val() != ""){
                    $("#visita_fecha_mant").val($("#proyectos_edit_fechavisita").val());
                    $("#add_visita_modal").modal("show");
                }else{
                    alert("Elige fecha!!");
                }
            });
            $("#btn_add_visita_mant").click(function() {
                $("#visita_addtecnicos_mant option").prop("selected", true);
                data = $("#frm_add_visita_mant").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveVisitaMant.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log("Respuesta de add visita mant.: "+response);
                        $('#frm_add_visita_mant').trigger("reset");
                        refreshSelects();
                        
                        $('#proyectos_visitas').append($('<option>', {value:$("#proyectos_edit_fechavisita").val(), text:$("#proyectos_edit_fechavisita").val()}));
                        
                        setTimeout(function(){
                            // redireccion en nueva ventana?¿?¿
                            window.open(
                            "/erp/apps/actividad/editAct.php?id=" + response,
                            '_blank' 
                            );
                            $("#add_visita_modal").modal("hide");
                            //$("#proyectos_success").fadeOut("slow");
                            window.location.reload();
                        }, 1500);
                    }   
                });
            });
            $("#btn_clear_visita").click(function() {
                $('#proyectos_visitas option:selected').remove();
            });
            $("#btn_clear_exp").click(function() {
                $('#proyectos_expedientes option:selected').remove();
            });
            $("#btn_done_visita").click(function() {
                $.post( "visitaDone.php", 
                { 
                    visita_id:  $('#proyectos_visitas option:selected').data("id")
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
            });

            setTimeout(function(){
                $("#horas_tecnicos").selectpicker("val", <? echo $_SESSION['user_session']; ?>);
            }, 1000);

            $(".tabla-mant-exp tr").click(function() {
                // Cambiar por abrir en otra pestaña
                // location.href = "/erp/apps/proyectos/view.php?id=" + $(this).data("id");
                window.open(
                    "/erp/apps/proyectos/view.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            $(".tabla-mant-visitas tr").click(function() {
                // Cambiar por abrir en otra pestaña
                // location.href = "/erp/apps/proyectos/view.php?id=" + $(this).data("id");
                window.open(
                    "/erp/apps/actividad/editAct.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            $("#edit_proyecto").click(function() {
                //alert($(this).data('id'));
                $("#proyectos_clientes").val($("#proyectos_clienteid").val());
                $("#proyectos_clientes").selectpicker('refresh');
                $("#proyectos_estados").val($("#proyectos_estadoid").val());
                $("#proyectos_estados").selectpicker('refresh');
                $("#proyectos_tipoproyecto").val($("#proyectos_tipoid").val());
                $("#proyectos_tipoproyecto").selectpicker('refresh');
                $("#proyectos_parent").val($("#proyectos_parentid").val());
                $("#proyectos_parent").selectpicker('refresh');
                $("#project-view").hide();
                $("#project-edit").fadeIn();
            });
            
            $("#save_proyectos").click(function() {
                $("#proyectos_btn_save").click();
            });
            $("#save-documento-recordatorio").click(function() {
                console.log($("#texto-recodatorio").val());
                console.log(<? echo $_GET['id']; ?>);
                $.ajax({
                    type: "GET",  
                    url: "saveRecordatorio.php",  
                    data: {
                           id: <? echo $_GET["id"]; ?>,
                           texto: $("#texto-recodatorio").val()
                          },
                    dataType: "json",       
                    success: function(response)  
                    {
                        console.log(response);
                        setTimeout(function(){
                            $("#proyectos_success").fadeOut("slow");
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#proyectos_btn_save").click(function() {
                $("#proyectos_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#proyectos_expedientes option").prop("selected", true);
                $("#proyectos_visitas option").prop("selected", true);
                data = $("#frm_proyecto").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveProyectos.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_proyecto').trigger("reset");
                        refreshSelects();
                        $("#proyectos_btn_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#proyectos_success").slideDown();
                        setTimeout(function(){
                            $("#proyectos_success").fadeOut("slow");
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            $("#extend_mantenimiento").click(function() {
                $("#extend_mantenimiento").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $.ajax({
                    type: "GET",  
                    url: "extendMant.php",
                    data: {
                        id: <? echo $_GET["id"]; ?>
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        //window.location.reload();
                        location.href = "/erp/apps/mantenimientos/";
                    }   
                });
            });
            
            $('#filter_proyectos').on('changed.bs.select', function (e) {
                //alert($(this).parent());
                //console.log($(this).parent().children("button"));
                //$(this).parent().children("button").addClass("filter-selected");
                window.location.href = "view.php?id=" + $(this).val();
            });
            
            // ######## OPEN MODALS #######
            $("#tabla-ofertas tr td:last-child").click(function() {
                //alert($(this).data("id"));
                $.ajax({
                    type: "GET",  
                    url: "responseDocsOfertas.php",
                    data: {
                        id: $(this).closest("tr").data("id")
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        console.log("docs ofertas");
                        initTree(response, "treeview_json_docsOfertas");
                        $("#docs_oferta_model").modal('show');
                    }   
                });
            });
            $("#add-group").click(function() {
                $("#proyecto_adddocgroup_model").modal('show');
            });
            $("#add-parte").click(function() {
                $("#proyecto_addparte_model").modal('show');
            });
            $("#add-orden").click(function() {
                $("#orden_add_model").modal('show');
            });
            $("#add-horas").click(function() {
                $("#horas_add_model").modal('show');
            });
            
            $("#tabla-ofertas tr td:first-child").click(function() {
                location.href = "/erp/apps/ofertas/editoferta.php?id=" + $(this).closest("tr").data("id");
            });
            $("#tabla-pedidos-proyecto tr").click(function() {
                location.href = "/erp/apps/material/editPedido.php?id=" + $(this).data("id");
            });
            
            var treeData;
            
            console.log("start");
            $.ajax({
                type: "GET",  
                url: "responseDocs.php",
                data: {
                    id: <? echo $_GET["id"]; ?>
                },
                dataType: "json",       
                success: function(response)  
                {
                      console.log("ok");
                      initTree(response, "treeview_json");
                }   
            });
            
            $.ajax({
                type: "GET",  
                url: "responsePlanos.php",
                data: {
                    id: <? echo $_GET["id"]; ?>
                },
                dataType: "json",       
                success: function(response)  
                {
                      console.log("ok");
                      initTree(response, "treeview_json_planos");
                }   
            });
            
            function initTree(treeData, treeElement) {
                //console.log(treeData);
                $('#' + treeElement).treeview({
                    data: treeData,
                    enableLinks: true
                });
            }
            
            // MATERIALES
            // ######## LOAD SELECTS #######
            loadSelect("proyectomaterial_categorias1","MATERIALES_CATEGORIAS","id","parent_id",0);
            //loadSelect("pedidos_edit_proveedores","PROVEEDORES","id","","","");            
            loadSelect("materiales_categoria1","MATERIALES_CATEGORIAS","id","parent_id",0);
            
            $("#add-material").click(function() {
                $("#material_add_model").modal('show');
            });
            
            // ######## SELECTS CHANGE EVENTS #######
            $("select.proyectomaterial_categorias").on("changed.bs.select", function (e) { 
                var numCat = $("select.proyectomaterial_categorias").length + 1;
                console.log("num elementos " + numCat);
                for (i = 1; i < numCat; i++) {
                    if (i != 1) {
                        console.log("delete " + numCat);
                        $("#proyectomaterial_categorias" + i).selectpicker("destroy");
                        $("#proyectomaterial_categorias" + i).closest(".form-group").remove();
                    }
                }
                
                var numCat = $("select.proyectomaterial_categorias").length + 1;
                var htmlElement = "<div class='form-group'><label class='labelBeforeBlack'></label><select id='proyectomaterial_categorias" + numCat + "' name='proyectomaterial_categorias" + numCat + "' class='selectpicker proyectomaterial_categorias' data-live-search='true' data-width='33%'><option></option></select></div>"
                $("select.proyectomaterial_categorias").last().closest(".form-group").after(htmlElement);
                
                loadSelect("proyectomaterial_categorias" + numCat,"MATERIALES_CATEGORIAS","id","parent_id",$(this).val());
                $("#proyectomaterial_categorias" + numCat).selectpicker('render');
                $("#proyectomaterial_categorias" + numCat).selectpicker('refresh');
            });
            $("body").on('change',"select.proyectomaterial_categorias", function(){
                //alert("ok");  
                loadSelect("proyectomaterial_materiales","MATERIALES","id","categoria_id",$(this).val(),"");
            });
            $("#proyectomaterial_materiales").on("changed.bs.select", function (e) {
                //loadPedidoDetalleInfo($(this).val(), "MATERIALES");
                loadPedidoMaterialInfo($(this).val(), "MATERIALES");
            });
            $("#orden_tareas").on("changed.bs.select", function (e) {
                var dataperfil = $("option[value=" + $(this).val() + "]", this).attr('data-perfil');
                loadSelect("orden_horas","PERFILES_HORAS","id","perfil_id",dataperfil,"");
            });
            $("#horas_tareas").on("changed.bs.select", function (e) {
                var dataperfil = $("option[value=" + $(this).val() + "]", this).attr('data-perfil');
                loadSelect("horas_horas","PERFILES_HORAS","id","perfil_id",dataperfil,"");
            });
            
            //***********
            
            // GRUPOS DOC
            $('#proyecto_gruposdocgrupos').on('changed.bs.select', function (e) {
                loadGruposDocInfo($(this).val(), "GRUPOS_DOC");
            });
            $("#btn_proyecto_gruposdoc_save").click(function() {
                $("#btn_proyecto_gruposdoc_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_proyecto_addgroup_doc").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveGrupoDocs.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_proyecto_addgroup_doc').trigger("reset");
                        $("#btn_proyecto_gruposdoc_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newgrupodoc_success").slideDown();
                        setTimeout(function(){
                            $("#newgrupodoc_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
            $("#btn_del_gruposdoc").click(function() {
                $("#btn_del_gruposdoc").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#gruposdoc_del").val($("#gruposdoc_idgrupo").val());
                data = $("#frm_proyecto_addgroup_doc").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveGrupoDocs.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_proyecto_addgroup_doc').trigger("reset");
                        $("#btn_del_gruposdoc").html('<span class="glyphicon glyphicon-floppy-disk"></span> Eliminar');
                        $("#newgrupodoc_success").slideDown();
                        setTimeout(function(){
                            $("#newgrupodoc_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            // PARTES
            $("#btn_proyecto_parte_save").click(function() {
                $("#btn_proyecto_parte_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_proyecto_addparte").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveParte.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_proyecto_addparte').trigger("reset");
                        $("#btn_proyecto_parte_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#proyecto_partesuccess").slideDown();
                        setTimeout(function(){
                            $("#proyecto_partesuccess").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }   
                });
            });
                        
            //ORDENES
            $("#btn_orden_save").click(function() {
                $("#btn_orden_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_orden").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_orden").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveOrden.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_orden').trigger("reset");
                        refreshSelects();
                        $("#btn_orden_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#orden_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        window.location.reload();
                    }   
                });
            });
            
            $(".remove-orden").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveOrden.php',
                    dataType : 'text',
                    data: {
                        orden_deldetalle : $(this).data("id")
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $("#tabla-ordenes tr").click(function() {
                loadProyectoOrdenInfo($(this).data("id"));
                $("#orden_add_model").modal('show');
            });
            
            //HORAS
            $("#btn_horas_save").click(function() {
                $("#btn_horas_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_orden").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_horas").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
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
            // Subida de archivo
            $("#uploaddocMantenimiento").fileinput('destroy');
            $("#uploaddocMantenimiento").fileinput({
                uploadUrl: "saveRecordatorio.php?tipo=MAN&id=" + <? echo $_GET["id"] ?>+"",
                dropZoneEnabled: true,
                maxFileCount: 500, 
                language: "es"
            });
            
            $('#uploaddocMantenimiento').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               //console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    tipo: "PROCESOS",
                    pathFile: data.response.uploaded,
                    doc_id: $("#adddocProcesos").val()
                })
                .done(function( data1 ) {
                    console.log(data1);
                    //alert( "ok" );
                    window.location.reload();
                }); 
            });
            
            $("#delete_proyecto").click(function() {
                var r = confirm("¿Estas seguro de que quieres borrar el Mantenimiento?\nLas Carpetas pueden ser borradas!");
                if(r == true){
                    $.ajax({
                        type: "POST",  
                        url: "saveProyectos.php",  
                        data: {
                            proyectos_delproyecto: $('#proyectos_idproyecto').val()
                        },
                        dataType: "json",       
                        success: function(response)  
                        {
                            
                            console.log(response);
                            //$('#frm_proyecto').trigger("reset");
                            //refreshSelects();
                            //$("#proyectos_btn_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            //$("#proyectos_success").slideDown();
                            setTimeout(function(){
                                //$("#proyectos_success").fadeOut("slow");
                                location.href = "/erp/apps/mantenimientos/index.php";
                            }, 1000);
                        }   
                    });
                }
                
                
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
            <h3 id="project-title">
                
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-aside" class="two-column">
                <div id="dash-proyectosactivos" class="one-column">
                    <h4 class="dash-title">
                        <? include($pathraiz."/apps/mantenimientos/includes/tools-single-project.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/current-project.php"); 
                    ?>
                </div>
            </div>
            
            <div id="dash-aside" class="two-column">
                <div id="dash-aside-top" class="one-column">
                    <div id="dash-alertas" class="two-column">
                        <h4 class="dash-title">
                            OFERTAS <? include($pathraiz."/apps/proyectos/includes/tools-ofertas.php"); ?>
                        </h4>
                        <hr class="dash-underline">
                        <? include("vistas/ofertas.php"); ?>
                    </div>
                    <div id="proyecto-documentos" class="two-column">
                        <h4 class="dash-title">
                            DOCUMENTOS <? include($pathraiz."/apps/proyectos/includes/tools-documentos.php"); ?>
                        </h4>
                        <hr class="dash-underline">
                        <div id="treeview_json">
                            <? //include("vistas/documentos.php"); ?>
                        </div>
                    </div>
                </div>
                <span class="stretch"></span>
                <div id="dash-aside-bot" class="one-column">
                    <div id="dash-recordatorio" class="one-column">
                        <h4 class="dash-title">
                            RECORDATORIO <? include($pathraiz."/apps/mantenimientos/includes/tools-recordatorio.php"); ?>
                        </h4>
                        <hr class="dash-underline">
                            <? include($pathraiz."/apps/mantenimientos/vistas/proyecto-recordatorio.php"); ?>
                    </div>
                </div>
                <!--
                <div id="proyecto-planos" class="two-column">
                    <h4 class="dash-title">
                        PLANOS <? //include($pathraiz."/apps/proyectos/includes/tools-planos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="treeview_json_planos">
                        <? //include("vistas/documentos.php"); ?>
                    </div>
                </div>
                
                <div id="dash-actividad" class="two-column">
                    <h4 class="dash-title">
                        PARTES <? //include($pathraiz."/apps/proyectos/includes/tools-partes.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? //include("vistas/partes.php"); ?>
                </div>
                -->
                
            </div>
            <span class="stretch"></span>
            <div id="dash-horas-enfrentadas" class="one-column" style="height: 350px;">
                <div id="dash" class="one-column" style="text-align: center;">
                    <h4 class="dash-title">
                        RESUMEN DE HORAS
                    </h4>
                    <hr class="dash-underline">
                    <? include("vistas/proyectos-horas-enfrentadas.php"); ?>
                </div>
            </div>
            
            <div id="dash-horas" class="two-column" >
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        ORDENES DE TRABAJO / HORAS VENDIDAS <? include($pathraiz."/apps/mantenimientos/includes/tools-ordenes.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? include("vistas/proyectos-ordenes.php"); ?>
                </div>
            </div>
            <div id="dash-horas" class="two-column" >
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        HORAS IMPUTADAS <? include($pathraiz."/apps/mantenimientos/includes/tools-horas-imp.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? include("vistas/proyectos-horas-imp.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-horas" class="two-column" >
                <div id="dash-pedidosproyecto" class="one-column">
                    <h4 class="dash-title">
                        PEDIDOS MATERIAL
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include($pathraiz."/apps/mantenimientos/vistas/proyectos-pedidos.php"); 
                    ?>
                </div>
            </div>
            
            <div id="dash-horas" class="two-column" >
                <div id="dash-materiales-add" class="one-column" >
                    <h4 class="dash-title">
                        MATERIAL UTILIZADO
                        <? include($pathraiz."/apps/mantenimientos/includes/tools-material.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/proyectos-material.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
</body>
</html>