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
<style>
    input[type="search"]::-webkit-search-cancel-button {
      -webkit-appearance: searchfield-cancel-button;
    }
</style>

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

<!-- CHARTS -->
    <script src="/erp/includes/plugins/chart/dist/Chart.bundle.js"></script>
    <!--<script src="includes/chart/dist/Chart.bundle.min.js"></script>-->
    
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
            
            $("#add-documento").click(function() {
                $("#proyecto_adddoc_model").modal('show');
            });

            $("#menuitem-proyectos").addClass("active");
            
            loadSelectYears("filter_proyectos_years","PROYECTOS","fecha_ini","","");
            loadSelect("filter_proyectos","PROYECTOS","id","","","ref");
            loadSelect("filter_clientes","CLIENTES","id","","","");
            loadSelect("proyectos_clientes","CLIENTES","id","","","");
            loadSelect("proyectos_ing","CLIENTES","id","","","");
            loadSelect("proyectos_dirobra","CLIENTES","id","","","");
            loadSelect("proyectos_promotor","CLIENTES","id","","","");
            loadSelect("proyectos_estados","PROYECTOS_ESTADOS","id","","","");
            loadSelect("proyecto_docgrupos","GRUPOS_DOC","id","proyecto_id","<? echo $_GET['id']; ?>");
            loadSelect("proyecto_gruposdocgrupos","GRUPOS_DOC","id","proyecto_id","<? echo $_GET['id']; ?>");
            
            loadSelect("proyecto_partetipos","TIPOS_PARTES","id","","","");
            loadSelect("proyecto_parteestados","ESTADOS_PARTES","id","","","");
            loadSelect("proyecto_partetecnicos","erp_users","id","","","apellidos");
            loadSelect("proyectos_parent","PROYECTOS","id","","","ref");
            
            loadSelect("orden_tecnicos","erp_users","id","","", "apellidos");
            loadSelect("orden_tareas","TAREAS","id","","", "perfil_id");
            
            loadSelect("hito_tecnicos","erp_users","id","","", "apellidos");
            loadSelect("hito_estados","HITOS_ESTADOS","id","","", "");
            
            loadSelect("horas_tareas","TAREAS","id","","", "perfil_id");
            loadSelect("horas_tecnicos","erp_users","id","","", "apellidos");
            
            loadSelect("proyectos_tipoproyecto","TIPOS_PROYECTO","id","","","");
            
            loadSelect("newoferta_clientes","CLIENTES","id","","","");
            
            loadSelect("newentrega_estados","ESTADOS_ENTREGAS","id","","","");
            
            loadSelect("proyectosub_terceros","PROVEEDORES","id","","","");
            
            loadSelect("newenvio_envios","ENVIOS_CLI","id","","","ref");
            loadSelect("newenvio_proyectos","PROYECTOS","id","","","ref");
            loadSelect("newenvio_ofertas_gen","OFERTAS","id","","","ref");
            loadSelect("newenvio_clientes","CLIENTES","id","","","");
            loadSelect("newenvio_proveedores","PROVEEDORES","id","","","");
            loadSelect("newenvio_transportistas","TRANSPORTISTAS","id","","","");
            loadSelect("newenvio_estados","PEDIDOS_PROV_ESTADOS","id","","","");
            loadSelect("newenvio_tecnicos","erp_users","id","","","apellidos");

            $("#btn_add_exp").click(function() {
                $('#proyectos_expedientes').append($('<option>', {value:$("#proyectos_parent").val(), text:$("#proyectos_parent").find("option:selected").text()}));
            });

            setTimeout(function(){
                $("#horas_tecnicos").selectpicker("val", <? echo $_SESSION['user_session']; ?>);
            }, 1000);

            $("#tabla-proyectos tr").click(function() {
                //alert($(this).data('id'));
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
            
            $("#proyectos_btn_save").click(function() {
                $("#proyectos_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#proyectos_expedientes option").prop("selected", true);
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
            
            $('#proyecto_docgrupos').on('changed.bs.select', function (e) {
                //$("#grupo_name").val($("#proyecto_docgrupos option:selected").text());
                $("#uploaddocs").fileinput({
                    uploadUrl: "upload.php?proyecto_id=" + <? echo $_GET['id']; ?> + "&grupo=" + $("#proyecto_docgrupos option:selected").text(),
                    dropZoneEnabled: true,
                    maxFileCount: 500, 
                    language: "es"
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
            $("#add-hito").click(function() {
                $("#hito_add_model").modal('show');
            });
            $("#add-horas").click(function() {
                $("#horas_add_model").modal('show');
            });
            $("#add-oferta").click(function() {
                $("#addoferta_model").modal('show');
            });
            $("#add-entrega").click(function() {
                $("#addentrega_model").modal('show');
            });
            $("#add-costesubcontratas").click(function() {
                $("#subcontratacion_add_model").modal('show');
            });
            $("#add-ventaviajes").click(function() {
                $("#viajes_add_model").modal('show');
            });
            $("#add-ventaotros").click(function() {
                $("#otros_add_model").modal('show');
            });
            
            $("#tabla-ofertas tr td:first-child").click(function() {
                window.open(
                    "/erp/apps/ofertas/editoferta.php?id=" + $(this).closest("tr").data("id"),
                    '_blank' 
                );
            });
            $("#tabla-pedidos-proyecto tr").click(function() {
                window.open(
                    "/erp/apps/material/editPedido.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            $("#tabla-entregas tr").click(function() {
                window.open(
                    "/erp/apps/entregas/view.php?id=" + $(this).data("id"),
                    '_blank'  
                );
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
                $("#selectmaterial_model").modal('show');
            });
            
            $("#btn_proyectomaterial_save").click(function() {
                $("#btn_proyectomaterial_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_add_material").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoMaterial.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        
                        $('#frm_add_material').trigger("reset");
                        refreshSelects();
                        $("#btn_proyectomaterial_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#material_success").slideDown();
                        setTimeout(function(){
                            $("#material_success").fadeOut("slow");
                            window.location.reload();
                        }, 500);
                    }   
                });
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
                //loadPedidoMaterialInfo($(this).val(), "MATERIALES");
                loadMaterialInfo($(this).val(), "MATERIALES");
                loadSelectPreciosOferta("proyectomaterial_precios","MATERIALES_PRECIOS","id", "material_id", $(this).val());
            });
            $("#proyectomaterial_precios").on("changed.bs.select", function (e) {
                 var selText = $(this).find('option:selected').text();
                 var partes = selText.split("-");
                 var pvp = partes[1].replace("€","").trim();
                 $("#proyectomaterial_preciomat").val(pvp);
                 loadSelect("proyectomaterial_dtoprov","PROVEEDORES_DTO","id","proveedor_id",$("#proyectomaterial_precios option:selected").data("proveedorid"),"fecha_val","","","");
            });
            
            $("#orden_tareas").on("changed.bs.select", function (e) {
                var dataperfil = $("option[value=" + $(this).val() + "]", this).attr('data-perfil');
                loadSelect("orden_horas","PERFILES_HORAS","id","perfil_id",dataperfil,"");
            });
            $("#horas_tareas").on("changed.bs.select", function (e) {
                var dataperfil = $("option[value=" + $(this).val() + "]", this).attr('data-perfil');
                loadSelect("horas_horas","PERFILES_HORAS","id","perfil_id",dataperfil,"");
            });
            $("#proyectomaterial_criterio").change(function () {
                loadSelect("proyectomaterial_materiales","MATERIALES","id","ref",$(this).val(),"ref","nombre",$(this).val(),"",1);
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
            
            //OFERTAS
            $("#btn_save_oferta").click(function() {
                $("#btn_save_oferta").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_oferta").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "/erp/apps/ofertas/saveOferta.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_oferta').trigger("reset");
                        refreshSelects();
                        $("#btn_save_oferta").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newoferta_success").slideDown();
                        setTimeout(function(){
                            $("#newoferta_success").fadeOut("slow");
                            window.location.href = "/erp/apps/ofertas/editoferta.php?id=" + response;
                        }, 2000);
                    }   
                });
            });
            
            $(document).on("click", "#tabla-ofertas tr" , function() {
                window.open(
                    "/erp/apps/ofertas/editoferta.php?id=" + $(this).data("id"),
                    '_blank' // <- This is what makes it open in a new window.
                );
            });
            
            //ENTREGAS
            $("#btn_save_entrega").click(function() {
                $("#btn_save_entrega").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_entrega").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "/erp/apps/entregas/saveEntregas.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_entrega').trigger("reset");
                        refreshSelects();
                        $("#btn_save_entrega").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newentrega_success").slideDown();
                        setTimeout(function(){
                            $("#newentrega_success").fadeOut("slow");
                            window.location.href = "/erp/apps/entregas/view.php?id=" + response;
                        }, 2000);
                    }   
                });
            });
            
            $(document).on("click", "#tabla-entregas tr" , function() {
                window.open(
                    "/erp/apps/entregas/view.php?id=" + $(this).data("id"),
                    '_blank' 
                );
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
            
            //HITOS
            $("#btn_hito_save").click(function() {
                $("#btn_hito_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_orden").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_hito").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveHito.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_hito').trigger("reset");
                        refreshSelects();
                        $("#btn_hito_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#hito_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        window.location.reload();
                    }   
                });
            });
            
            $(".remove-hito").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveHito.php',
                    dataType : 'text',
                    data: {
                        hito_deldetalle : $(this).data("id")
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $("#tabla-hitos tr > td:not(:nth-child(6))").click(function() {
                loadProyectoHitoInfo($(this).parent("tr").data("id"));
                $("#hito_add_model").modal('show');
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
            
            $(".to-project").change(function () {
                $("#to_project").val($(this).data("pedidoid") + "-" + $("#to_project").val());
            });
            
            $("#add-pedidos-to-material").click(function() {
                $("#adding-mat").slideDown();
                $.ajax({
                    type : 'POST',
                    url : 'saveMaterialFromPedidos.php',
                    dataType : 'text',
                    data: {
                        proyecto_id : <? echo $_GET['id']; ?>,
                        pedidos_id : $("#to_project").val()
                    },
                    success : function(data){
                        //alert(data);
                        setTimeout(function(){
                            $("#adding-mat").fadeOut("slow");
                            window.location.reload();
                        }, 2000);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(".remove-mat").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterial.php',
                    dataType : 'text',
                    data: {
                        proyectomaterial_deldetalle : $(this).data("id"),
                        proyectomaterial_cantidad: $(this).parent("td").parent("tr").children("td:nth-child(4)").html()
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
            
            $("#tabla-horas tr").click(function() {
                loadProyectoHorasInfo($(this).data("id"));
                $("#horas_add_model").modal('show');
            });
            $("#tabla-partes-intervencion tr").click(function() {
                window.open(
                    "/erp/apps/intervenciones/editInt.php?id=" + $(this).data("id"),
                    "_blank"
                );
            });
            
            // GASTOS
            $("#btn_proyectosub_save").click(function() {
                $("#btn_proyectosub_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_proyectosub").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_proyectosub").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoSub.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_proyectosub').trigger("reset");
                        refreshSelects();
                        $("#btn_proyectosub_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#subcontratacion_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        window.location.reload();
                    }   
                });
            });
            
            $("#btn_proyectoviajes_save").click(function() {
                $("#btn_proyectoviajes_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_proyectoviajes").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_proyectoviajes").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoViaje.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_proyectoviajes').trigger("reset");
                        refreshSelects();
                        $("#btn_proyectoviajes_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#viajes_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        window.location.reload();
                    }   
                });
            });
            
            $("#btn_proyectootros_save").click(function() {
                $("#btn_proyectootros_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_proyectootros").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_proyectootros").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoOtros.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_proyectootros').trigger("reset");
                        refreshSelects();
                        $("#btn_proyectootros_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#viajes_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        window.location.reload();
                    }   
                });
            });
            
            function calcImportesMat() {
                //alert("calculo importes");
                var totalDTO = 0.00;
                var totalDTOaCliente = 0.00;
                                
                //descuentos activados
                if( $('#proyectomaterial_dtoprov_desc').prop('checked') ) {
                    //alert(parseFloat($("#proyectomaterial_dtoprov option:selected").text().split("/")[0].replace("% ",""), 10).toFixed(2));
                    totalDTO = parseFloat(totalDTO, 10) + parseFloat($("#proyectomaterial_dtoprov option:selected").text().split("/")[0].replace("% ",""), 10);
                    //alert (totalDTO);
                }
                if( $('#proyectomaterial_dtomat_desc').prop('checked') ) {
                    totalDTO = parseFloat(totalDTO, 10) + parseFloat($("#proyectomaterial_dtomat").val(), 10);
                }
                if( $('#proyectomaterial_dto_desc').prop('checked') ) {
                    totalDTOaCliente = parseFloat(totalDTO) + parseFloat($("#proyectomaterial_dto").val(), 10);
                }
                var dto = "0." + (100 - parseFloat(totalDTO, 10).toFixed(2));
                if (dto == "0.100") {
                    dto = 1;
                }
                              
                var pvp = parseFloat($("#proyectomaterial_preciomat").val(),10)*parseFloat($("#proyectomaterial_cantidad").val(),10);
                var pvpdto = parseFloat(pvp, 10)*parseFloat(dto,10);
                
                $("#proyectomaterial_pvp").val(pvp.toFixed(2));
                $("#proyectomaterial_totaldtopercent").val(totalDTO.toFixed(2));
                $("#proyectomaterial_totaldto").val(((parseFloat(pvp)*parseFloat(totalDTO,10))/100).toFixed(2));
                $("#proyectomaterial_pvptotal").val(pvpdto.toFixed(2));
            };
            
            function calcImportesSub() {
                var dto = "0." + (100 - parseFloat($("#proyectosub_dto").val(), 10));
                if (dto == "0.100") {
                    dto = 1;
                }
                var pvpdto = parseFloat($("#proyectosub_cantidad").val(),10)*(parseFloat($("#proyectosub_unitario").val(),10).toFixed(2)*parseFloat(dto,10));
                var iva = 1.21;
                var pvp = parseFloat($("#proyectosub_unitario").val(),10)*parseFloat($("#proyectosub_cantidad").val(),10);
                $("#proyectosub_pvp").val(pvp.toFixed(2));
                var importeiva = parseFloat(pvpdto,10)*0.21;
                $("#proyectosub_iva").val(importeiva.toFixed(2));
                $("#proyectosub_pvpdto").val(pvpdto.toFixed(2));
                var pvp_total = parseFloat(pvpdto,10)*parseFloat(iva,10);
                $("#proyectosub_pvp_total").val(pvp_total.toFixed(2));
            };
            function calcImportesViajes() {
                var iva = 1.21;
                var pvp = parseFloat($("#proyectoviajes_unitario").val(),10)*parseFloat($("#proyectoviajes_cantidad").val(),10);
                var importeiva = parseFloat(pvp,10)*0.21;
                $("#proyectoviajes_pvp").val(pvp.toFixed(2));
                $("#proyectoviajes_iva").val(importeiva.toFixed(2));
                var pvp_total = parseFloat(pvp,10)*parseFloat(iva,10);
                $("#proyectoviajes_pvp_total").val(pvp_total.toFixed(2));
                //var pvpinc = parseFloat(pvpdto,10)*parseFloat(inc,10).toFixed(2);
                //$("#proyectoviajes_pvp_total").val(pvpinc.toFixed(2));
            };
            function calcImportesOtros() {
                var iva = 1.21;
                var pvp = parseFloat($("#proyectootros_unitario").val(),10)*parseFloat($("#proyectootros_cantidad").val(),10);
                $("#proyectootros_pvp").val(pvp.toFixed(2));
                var importeiva = parseFloat(pvp,10)*0.21;
                var pvp_total = parseFloat(pvp,10)*parseFloat(iva,10);
                $("#proyectootros_iva").val(importeiva.toFixed(2));
                $("#proyectootros_pvp_total").val(pvp_total.toFixed(2));
                //var pvpinc = parseFloat(pvpdto,10)*parseFloat(inc,10).toFixed(2);
                //$("#proyectootros_pvp_total").val(pvpinc.toFixed(2));
            };
            
            // ######## FOCUSOUT EVENTS #######
            $("#proyectomaterial_cantidad").focusout(function() {
                calcImportesMat();
            });
            $("#proyectomaterial_dto").focusout(function() {
                calcImportesMat();
            });
            $("#proyectomaterial_dtoprov_desc").change(function () {
                calcImportesMat();
            });
            $("#proyectomaterial_dtomat_desc").change(function () {
                calcImportesMat();
            });
            
            $("#proyectosub_cantidad").focusout(function() {
                calcImportesSub();
            });
            $("#proyectosub_unitario").focusout(function() {
                $("#proyectosub_unitario").val(parseFloat($("#proyectosub_unitario").val()).toFixed(2));
                calcImportesSub();
            });
            $("#proyectosub_dto").focusout(function() {
                calcImportesSub();
            });
            $("#proyectosub_incremento").focusout(function() {
                calcImportesSub();
            });
            
            $("#proyectoviajes_cantidad").focusout(function() {
                calcImportesViajes();
            });
            $("#proyectoviajes_unitario").focusout(function() {
                $("#proyectoviajes_unitario").val(parseFloat($("#proyectoviajes_unitario").val()).toFixed(2));
                calcImportesViajes();
            });
            $("#proyectoviajes_inc").focusout(function() {
                calcImportesViajes();
            });
            
            $("#proyectootros_cantidad").focusout(function() {
                calcImportesOtros();
            });
            $("#proyectootros_unitario").focusout(function() {
                $("#proyectootros_unitario").val(parseFloat($("#proyectootros_unitario").val()).toFixed(2));
                calcImportesOtros();
            });
            $("#proyectootros_inc").focusout(function() {
                calcImportesOtros();
            });
            
            // ######## EDIT DETALLES #######
            $("#tabla-ofertas-sub tr").click(function() {
                loadProyectoDetalleSubInfo($(this).data("id"));
                $("#subcontratacion_add_model").modal('show');
            });
            $("#tabla-ofertas-viajes tr").click(function() {
                loadProyectoDetalleViajeInfo($(this).data("id"));
                $("#viajes_add_model").modal('show');
            });
            $("#tabla-ofertas-otros tr").click(function() {
                loadOfertaDetalleOtrosInfo($(this).data("id"));
                $("#otros_add_model").modal('show');
            });
            
            $("#print_proyecto").click(function() {
                window.open(
                    "printProyecto.php?id=<? echo $_GET['id']; ?>",
                    '_blank' 
                );
            });
            
            //ALBARAN DE ENVIO DE MATERIAL DEL PROYECTO
            $(".to-alb").change(function () {
                $("#to_albaran").val($(this).data("matprojid") + "-" + $("#to_albaran").val());
            });
            $(".view-envio").click(function () {
                window.open(
                    '/erp/apps/envios/editEnvio.php?id=' + $(this).data("id"),
                    '_blank'
                );
            });
            
            $("#gen_albaran").click(function() {
                if ($("#to_albaran").val() != "") {
                    $("#salida_material_model").modal('show');
                }
                else {
                    alert("Selecciona primero algún material");
                }
                    
            });
            
            $("#btn_salidamaterial_save").click(function() {
                $("#btn_salidamaterial_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Generando ...');
                //$('#cover').fadeIn('slow');
                alert($("#to_albaran").val());
                data = $("#frm_salida_material").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "/erp/apps/envios/saveEnvio.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_salida_material').trigger("reset");
                        $("#btn_salidamaterial_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newenvio_success").slideDown();
                        setTimeout(function(){
                            $("#newenvio_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.href = "/erp/apps/envios/editEnvio.php?id=" + response[0].id;
                        }, 1000);
                    }   
                });
            });
	});
	
        
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title id="project-title">Proyectos | Erp GENELEK</title>
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
        <div class="form-group">
            <h5><a href="/erp/apps/proyectos/">Proyectos</a> > <span id="current-page"></span></h5>
        </div>
        <div id="erp-titulo" class="one-column">
            <h3 id="project-titulo">
                
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-aside" class="two-column">
                <div id="dash-proyectosactivos" class="one-column">
                    <h4 class="dash-title">
                        <? include($pathraiz."/apps/proyectos/includes/tools-single-project.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/current-project.php"); 
                    ?>
                </div>
            </div>
            
            <div id="dash-grafico-costes" class="two-column" style="min-height: 370px;">
                <h4 class="dash-title">
                    RESUMEN DE GASTOS
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/proyecto-grafico-rendimiento.php"); 
                ?>
            </div>
            
            <div id="dash-proyectos-ofertas" class="two-column">
                <h4 class="dash-title">
                    OFERTAS <? include($pathraiz."/apps/proyectos/includes/tools-ofertas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? include("vistas/ofertas.php"); ?>
            </div>
            <div id="proyecto-documentos" class="two-column">
                <h4 class="dash-title">
                    ENTREGAS <? include($pathraiz."/apps/proyectos/includes/tools-entregas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? include("vistas/entregas.php"); ?>
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
                        ORDENES DE TRABAJO / HORAS VENDIDAS <? include($pathraiz."/apps/proyectos/includes/tools-ordenes.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? include("vistas/proyectos-ordenes.php"); ?>
                </div>
                <span class="stretch"></span>
                <div id="dash-hitos" class="one-column">
                    <h4 class="dash-title">
                        HITOS/TAREAS <? include($pathraiz."/apps/proyectos/includes/tools-hitos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? include("vistas/proyectos-hitos.php"); ?>
                </div>
            </div>

            <div id="dash-horas" class="two-column" >
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        HORAS IMPUTADAS <? include($pathraiz."/apps/proyectos/includes/tools-horas-imp.php"); ?>
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
                        <? include($pathraiz."/apps/proyectos/includes/tools-pedidos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include($pathraiz."/apps/proyectos/vistas/proyectos-pedidos.php"); 
                    ?>
                </div>
            </div>
            
            <div id="dash-horas" class="two-column" >
                <div id="dash-materiales-add" class="one-column" >
                    <h4 class="dash-title">
                        MATERIAL UTILIZADO
                        <? include($pathraiz."/apps/proyectos/includes/tools-material.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/proyectos-material.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-partes" class="two-column" >
                <div id="proyecto-partes" class="one-column">
                    <h4 class="dash-title">
                        PARTES DE INTERVENCIÓN <? include($pathraiz."/apps/proyectos/includes/tools-partes.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        include($pathraiz."/apps/proyectos/vistas/proyectos-partes.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-horas" class="two-column" >
                <div id="proyecto-documentos" class="one-column">
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
            <div id="proyectos-gastosbar" class="one-column">
                <h3 id="gastos-title">
                    GASTOS IMPUTADOS AL PROYECTO
                </h3>
            </div>
            <div id="dash-subcontrata-add" class="two-column">
                <h4 class="dash-title">
                    SUBCONTRATACIONES
                    <? include("includes/tools-coste-subcontratas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/proyectos-terceros.php"); 
                ?>
            </div>
            <div id="dash-venta-add" class="two-column">
                <h4 class="dash-title">
                    VIAJES/DESPLAZAMIENTOS
                    <? include("includes/tools-venta-viajes.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/proyectos-viajes.php"); 
                ?>
            </div>
            <span class="stretch"></span>
            <div id="dash-otros-add" class="two-column">
                <h4 class="dash-title">
                    OTROS
                    <? include("includes/tools-venta-otros.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/proyectos-otros.php"); 
                ?>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
</body>
</html>