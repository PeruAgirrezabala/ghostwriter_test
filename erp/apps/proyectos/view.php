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
            
            // Borrar cuando se cambie de filtros (04/02/2021)
            loadSelectMaterialAlmacen("filter_material_ref","ref");
            loadSelectMaterialAlmacen("filter_material_nombre","material");
            
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
            
            loadContent("dash-ofertas", "/erp/apps/proyectos/vistas/ofertas.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-sub", "/erp/apps/proyectos/vistas/proyectos-terceros.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-viajes", "/erp/apps/proyectos/vistas/proyectos-viajes.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-otros", "/erp/apps/proyectos/vistas/proyectos-otros.php?id=" + <? echo $_GET['id']; ?>);
            
            loadContent("content-materialutilizado", "/erp/apps/proyectos/vistas/proyectos-material.php?id="+<? echo $_GET['id']; ?>);
            
            loadContent("dash-resumenhoras", "/erp/apps/proyectos/vistas/proyectos-horas-enfrentadas-actividad.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-entregas", "/erp/apps/proyectos/vistas/entregas.php?id=" + <? echo $_GET['id']; ?>);
            //loadContent("dash-gastos", "/erp/apps/proyectos/vistas/proyecto-grafico-rendimiento_mod.php?id="+<? //echo $_GET['id']; ?>);
            
            loadContent("content-horas-imputadas", "vistas/proyectos-horas-imp-actividad.php?id=" + <? echo $_GET['id']; ?>);
            
            $("#btn_add_exp").click(function() {
                $('#proyectos_expedientes').append($('<option>', {value:$("#proyectos_parent").val(), text:$("#proyectos_parent").find("option:selected").text()}));
            });

            setTimeout(function(){
                $("#horas_tecnicos").selectpicker("val", <? echo $_SESSION['user_session']; ?>);
            }, 1000);
            setTimeout(function(){
                $(".selectpicker").selectpicker("refresh");
            }, 3000);
            

            $("#tabla-proyectos tr").click(function() {
                //alert($(this).data('id'));
            });
            $(document).on("click", "#refresh-ofertas" , function() {
                loadContent("dash-ofertas", "/erp/apps/proyectos/vistas/ofertas.php?id="+<? echo $_GET['id']; ?>);
            });
            $(document).on("click", "#refresh-material" , function() {
                loadContent("content-materialutilizado", "/erp/apps/proyectos/vistas/proyectos-material.php?id="+<? echo $_GET['id']; ?>);
            });
            $(document).on("click", "#refresh-entregas" , function() {
                loadContent("dash-entregas", "/erp/apps/proyectos/vistas/entregas.php?id=" + <? echo $_GET['id']; ?>);
            });
            $("#edit_proyecto").click(function() {
                $("#proyectos_clientes").val($("#proyectos_clienteid").val());
                $("#proyectos_clientes").selectpicker('refresh');
                $("#proyectos_ing").val($("#proyectos_ingid").val());
                $("#proyectos_ing").selectpicker('refresh');
                $("#proyectos_dirobra").val($("#proyectos_dirobraid").val());
                $("#proyectos_dirobra").selectpicker('refresh');
                $("#proyectos_promotor").val($("#proyectos_promotorid").val());
                $("#proyectos_promotor").selectpicker('refresh');
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
                window.location.href = "view.php?id=" + $(this).val();
            });
            
            // Filtros material almacen proyecto
            $('#filter_material_ref').change(function () {
                $(this).parent().children("button").addClass("filter-selected");
                console.log("OK"+$(this).val());
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoMaterialFromAlmacen.php",
                    data: {
                        valor: $(this).val(),
                        actualizar: 1
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        $("#tabla_material_almacen").html(response);
                    }   
                });
            });
            $(document).on("click", "#refresh-costesubcontratas" , function() {
                loadContent("dash-sub", "/erp/apps/proyectos/vistas/proyectos-terceros.php?id=" + <? echo $_GET['id']; ?>);
            });
            $(document).on("click", ".remove-detalle-terceros" , function() {
                $("#del_sub_id").val($(this).data("id"));
                $("#confirm_del_sub_model").modal("show");
            });
            $(document).on("click", "#confirm-del-sub" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoSub.php",
                    data: {
                        proyectosub_deldetalle: $("#del_sub_id").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        loadContent("dash-sub", "/erp/apps/proyectos/vistas/proyectos-terceros.php?id=" + <? echo $_GET['id']; ?>);
                        $("#confirm_del_sub_model").modal("hide");
                    }   
                });
            });
            
            $(document).on("click", "#refresh-ventaviajes" , function() {
                loadContent("dash-viajes", "/erp/apps/proyectos/vistas/proyectos-viajes.php?id=" + <? echo $_GET['id']; ?>);
            });
            $(document).on("click", ".remove-detalle-viaje" , function() {
                $("#del_viaje_id").val($(this).data("id"));
                $("#confirm_del_viaje_model").modal("show");
            });
            $(document).on("click", "#confirm-del-viaje" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoViaje.php",
                    data: {
                        proyectoviajes_deldetalle: $("#del_viaje_id").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        loadContent("dash-viajes", "/erp/apps/proyectos/vistas/proyectos-viajes.php?id=" + <? echo $_GET['id']; ?>);
                        $("#confirm_del_viaje_model").modal("hide");
                    }   
                });
            });
            
            $(document).on("click", "#refresh-ventaotros" , function() {
                loadContent("dash-otros", "/erp/apps/proyectos/vistas/proyectos-otros.php?id=" + <? echo $_GET['id']; ?>);
            });
            $(document).on("click", ".remove-detalle-otros" , function() {
                $("#del_otros_id").val($(this).data("id"));
                $("#confirm_del_otros_model").modal("show");
            });
            $(document).on("click", "#confirm-del-otros" , function() {
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoOtros.php",
                    data: {
                        proyectootros_deldetalle: $("#del_otros_id").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        loadContent("dash-otros", "/erp/apps/proyectos/vistas/proyectos-otros.php?id=" + <? echo $_GET['id']; ?>);
                        $("#confirm_del_otros_model").modal("hide");
                    }   
                });
            });
            
            //clean-filters
            $(document).on("click", "#clean-filters" , function() {
                $("#filter_material_ref").selectpicker("val", "");
                $("#filter_material_ref").parent().children("button").removeClass("filter-selected");
                $("#filter_material_nombre").selectpicker("val", "");
                $("#filter_material_nombre").parent().children("button").removeClass("filter-selected");
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoMaterialFromAlmacen.php",
                    data: {
                        valor: 0,
                        actualizar: 1
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $("#tabla_material_almacen").html(response);
                    }   
                });
                
            });
            // ######## OPEN MODALS #######
            $(document).on("click", "#tabla-ofertas tr td:last-child" , function() {
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
            $(document).on("click", "#add-group" , function() {
                $("#proyecto_adddocgroup_model").modal('show');
            });
            $(document).on("click", "#add-parte" , function() {
                $("#proyecto_addparte_model").modal('show');
            });
            $(document).on("click", "#add-orden" , function() {
                $("#orden_add_model").modal('show');
            });
            $(document).on("click", "#add-hito" , function() {
                $("#hito_add_model").modal('show');
            });
            $(document).on("click", "#add-horas" , function() {
                $("#horas_detalle_id").val("");
                $('#horas_tareas').selectpicker('refresh');
                $('#horas_horas').selectpicker('refresh');
                $('#horas_tecnicos').selectpicker('refresh');
                $('#frm_edit_horas').trigger("reset");
                $("#horas_add_model").modal('show');
            });
            $(document).on("click", "#add-oferta" , function() {
                console.log("valor cliente: "+$("#proyectos_clienteid").val());
                $("#newoferta_clientes").val($("#proyectos_clienteid").val());
                $('#newoferta_clientes').selectpicker('refresh');
                $("#addoferta_model").modal('show');
            });
            $(document).on("click", "#add-entrega" , function() {
                $("#addentrega_model").modal('show');
            });
            $(document).on("click", "#add-costesubcontratas" , function() {
                $("#subcontratacion_add_model").modal('show');
            });
            $(document).on("click", "#add-ventaviajes" , function() {
                $("#viajes_add_model").modal('show');
            });
            $(document).on("click", "#add-ventaotros" , function() {
                $("#otros_add_model").modal('show');
            });
            $(document).on("click", "#view-posiciones" , function() {
                $("#posiciones_view_model").modal('show');
            });
            $(document).on("click", "#tabla-ofertas tr td:first-child" , function() {
                window.open(
                    "/erp/apps/ofertas/editoferta.php?id=" + $(this).closest("tr").data("id"),
                    '_blank' 
                );
            });
            $(document).on("click", "#tabla-pedidos-proyecto tr > td:not(:nth-child(1))" , function() {
                window.open(
                    "/erp/apps/material/editPedido.php?id=" + $(this).parent("tr").data("id"),
                    '_blank' 
                );
            });
            // DUPLICADO
//            $("#tabla-entregas tr").click(function() {
//                window.open(
//                    "/erp/apps/entregas/view.php?id=" + $(this).data("id"),
//                    '_blank'  
//                );
//            });
            
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
                $('#' + treeElement).treeview({
                    data: treeData,
                    enableLinks: true
                });
            }
            
            $(document).on("click", ".delDoc" , function() {
                var elid = $(this).parent().attr('class').split(" ").slice(1).toString();
                console.log(elid);
                $("#del_doc_id").val($(this).data("id"));
                $("#del_option_id").val(elid);
                $("#confirm_del_doc_model").modal("show");
            });
            $(document).on("click", "#confirm-del-doc" , function() {
                var option=$("#del_option_id").val();
                var elid=$("#del_doc_id").val();
                switch (option){
                    case "node-treeview_json_planos":
                        $.ajax({
                            type : 'POST',
                            url : 'processUpload.php',
                            dataType : 'text',
                            data: {
                                delDocPlanos : elid
                            },
                            success : function(data){
                                //alert(data);
                                //console.log("ok");
                                window.location.reload();
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log("ERROR");
                            }
                        });
                        break;
                    case "node-treeview_json":
                        $.ajax({
                            type : 'POST',
                            url : 'processUpload.php',
                            dataType : 'text',
                            data: {
                                delDoc : elid
                            },
                            success : function(data){
                                //alert(data);
                                //console.log("ok");
                                window.location.reload();
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log("ERROR");
                            }
                        });
                        break;
                }
            });
            // MATERIALES
            // ######## LOAD SELECTS #######
            loadSelect("proyectomaterial_categorias1","MATERIALES_CATEGORIAS","id","parent_id",0);    
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
            $(document).on("changed.bs.select", "#horas_tareas" , function() {
            //$("#horas_tareas").on("changed.bs.select", function (e) {
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
                            window.open("/erp/apps/ofertas/editoferta.php?id=" + response,'_blank');
                            window.location.reload();
                            //window.location.href = "/erp/apps/ofertas/editoferta.php?id=" + response;
                        }, 1000);
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
                //console.log("dentro de  entregas");
                $("#btn_save_entrega").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_entrega").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "/erp/apps/entregas/saveEntregas.php",  
                    data: data,
                    dataType: "json",    
                    success: function(response)  
                    {
                        console.log("repuesta entregas: "+response);
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_entrega').trigger("reset");
                        refreshSelects();
                        $("#btn_save_entrega").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newentrega_success").slideDown();
                        setTimeout(function(){
                            $("#newentrega_success").fadeOut("slow");
                            window.open(
                                "/erp/apps/entregas/view.php?id=" + response,
                                '_blank' // <- This is what makes it open in a new window.
                            );
                            loadContent("dash-entregas", "/erp/apps/proyectos/vistas/entregas.php?id=" + <? echo $_GET['id']; ?>);
                            $("#addentrega_model").modal("hide");
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
            $(document).on("click", "#btn_orden_save" , function() {
            //$("#btn_orden_save").click(function() {
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
                        
                        // Cerramos modal y refresco...  ?¿?¿
                        //$("#orden_add_model").modal("hide");
                        $("#refresh-orden").click();
                        //window.location.reload();
                    }   
                });
            });
            $(document).on("click", ".remove-orden" , function() {
            //$(".remove-orden").click(function() {
                $("#del_orden_id").val($(this).data("id"));
                $("#delete_ordenes_model").modal("show");
            });
            $(document).on("click", "#btn_del_orden" , function() {
            //$("#btn_del_orden").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveOrden.php',
                    dataType : 'text',
                    data: {
                        orden_deldetalle : $("#del_orden_id").val()
                    },
                    success : function(data){
                        //window.location.reload();
                        $("#delete_ordenes_model").modal('hide');
                        $("#refresh-orden").click();
                        
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", "#refresh-orden" , function() {
            //$("#refresh-orden").click(function() {
                //loadContent("dash-ordenes", "/erp/apps/proyectos/vistas/proyectos-ordenes.php?id="+<? //echo $_GET["id"];?>);
                $.ajax({
                    type: "POST",  
                    url: "reloadTablaOrdenes.php",
                    data: {
                        id: <? echo $_GET["id"]; ?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $("#refresh-resumenhoras").click();
                        $("#dash-ordenes").html(response);
                    }   
                });
            });
            $(document).on("click", "#tabla-ordenes tr > td:not(:nth-child(6))" , function() {
            //$("#tabla-ordenes tr > td:not(:nth-child(6))").click(function() {
                loadProyectoOrdenInfo($(this).parent().data("id"));
                $("#orden_add_model").modal('show');
            });
            $(document).on("click", "#refresh-resumenhoras" , function() {
            //$("#refresh-resumenhoras").click(function() {
            loadContent("dash-resumenhoras", "/erp/apps/proyectos/vistas/proyectos-horas-enfrentadas-actividad.php?id=" + <? echo $_GET['id']; ?>);
//                $.ajax({
//                    type: "POST",  
//                    url: "vistas/proyectos-horas-enfrentadas-actividad-reload.php",
//                    data: {
//                        id: <? //echo $_GET["id"]; ?>
//                    },
//                    dataType: "text",       
//                    success: function(response)  
//                    {
//                        //console.log(response);
//                        $("#dash-resumenhoras").html(response);
//                    }   
//                });
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
            $(document).on("click", "#btn_horas_save" , function() {
                $("#btn_horas_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_orden").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_horas").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveHoras.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        $('#frm_edit_horas').trigger("reset");
                        refreshSelects();
                        $("#btn_horas_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#horas_add_model").modal('hide');
                        $("#horas_success").slideDown();
                        setTimeout(function(){
                            $("#horas_success").fadeOut("slow");
                            //console.log(response[0].id);
                            //window.location.reload();
                            loadContent("content-horas-imputadas", "vistas/proyectos-horas-imp-actividad.php?id=" + <? echo $_GET['id']; ?>);
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
            
            $(document).on("click", ".to-project" , function() {
                //$(".to-project").change(function () {
                $("#to_project").val($(this).data("pedidoid") + "-" + $("#to_project").val());
                $("#to_project2").val($(this).data("pedidoid") + "-" + $("#to_project").val());
                var topro = $("#to_project").val(); 
                var total = topro.length; 
                var n = topro.indexOf("-");
                var i=0;
                console.log("String total: "+total);
                var nums =  new Array(); 
                
                    while(i!=(total/5)){
                        topro.substring(0,(n-1));
                        console.log("Num: "+i+"/"+topro.substring(0,(n)));
                        nums.push(topro.substring(0,(n)));
                        topro = topro.substring((n+1),total);
                        n = topro.indexOf("-");
                        i++;
                    }
                    let sorted_arr = nums.slice().sort();
                    let results = [];
                    var duplicados_count=0;
                    for (let i = 0; i <= sorted_arr.length - 1; i++) {
                        if (sorted_arr[i + 1] == sorted_arr[i]) {
                            duplicados_count++;
                            console.log("Somos duplicado Nº"+duplicados_count+"....."+sorted_arr[i]);
                            //results.push(sorted_arr[i]);
                        }else{
                            if(duplicados_count%2==0){
                                results.push(sorted_arr[i]);
                            }
                            duplicados_count=0;
                        }
                    }
                      if($("#to_project2").val()!=""){
                          $("#to_project2").val("");
                      }
                    for(var o=0; o<results.length;o++){
                        console.log("Numeros unicos: "+results[o]);
                        $("#to_project2").val(results[o] + "-" + $("#to_project2").val());
                    }
            });
            
            $("#add-pedidos-to-material").click(function() {
                $("#add-pedidos-to-material_model").modal('show');
            });
            $("#add-pedidos-to-material-button").click(function() {
                $("#adding-mat").slideDown();
                $.ajax({
                    type : 'POST',
                    url : 'saveMaterialFromPedidos.php',
                    dataType : 'text',
                    data: {
                        proyecto_id : <? echo $_GET['id']; ?>,
                        pedidos_id : $("#to_project2").val()
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
            //////// Agregar/Realizar Envío ///////
            $("#btn_add_posiciones").click(function() {
                $("#add_envio_posiciones_model").modal("show");            
            });
            $("#btn_add_envio_posiciones").click(function() {
                $("#btn_add_posiciones").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                //data = $("#frm_add_posiciones").serializeArray();
                //console.log("pulsado: "+$("#det_mat_pro_grup2").val().slice(0,-1));
                $.ajax({
                    type: "POST",  
                    url: "saveMaterialFromPedidos.php",  
                    data: {
                        posiciones_proyecto_id: $("#posiciones_proyecto_id").val(),
                        pedidos_id2: $("#det_mat_pro_grup2").val().slice(0,-2),
                        envio_idtrabajador: <? echo $idtrabajador; ?>,
                        envio_proyecto_id: $("#posiciones_proyecto_id").val(),
                        nombre_envio: $("#nom_envio_posiciones").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        $('#frm_add_posiciones').trigger("reset");
                        $("#posiciones_view_model").modal('hide');
                        $("#btn_add_posiciones").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#posiciones_success").slideDown();
                        window.location.reload();
                        setTimeout(function(){
                            $("#posiciones_success").fadeOut("slow");
                            //console.log(response[0].id);
                            // Abrir nueva ventana
                            window.open("/erp/apps/envios/editEnvio.php?id="+response,'_blank');
                            
                        }, 1000);
                    }   
                });
            });
            //////// Devoluciones ///////
            $("#btn_devolver").click(function() {
                $("#devolver_mat_view_model").modal("show");
            });
            $("#btn_devolver_ok").click(function() {
                // SACAR USUARIO
                
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoMaterialFromAlmacen.php",  
                    data: {
                        devolver_materiales: $("#det_mat_pro_grup2").val().slice(0,-1),
                        devolver_proyecto_id: $("#posiciones_proyecto_id").val(),
                        devolver_idtrabajador: <? echo $idtrabajador; ?>,
                        devolver_nombre: $("#devolucion_nombre").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Redirecionar a la devolucion en otra ventana
                        window.location.reload();
                        setTimeout(function(){
                            // Realizar aqui el redireccionamiento por tiempos de carga de datos
                            window.open("/erp/apps/envios/editEnvio.php?id="+response,'_blank');
                        }, 500);
                    }   
                });
            });
            //////// CREAR GRUPOS ///////
            $(document).on("click", ".pos-to-project" , function() {
                //$(".pos-to-project").change(function() {
                console.log("Padre det id:"+$(this).parent().parent().data("id"));
                $("#det_mat_pro_grup").val($(this).parent().parent().data("id") + "-" + $("#det_mat_pro_grup").val());
                $("#det_mat_pro_grup2").val($(this).parent().parent().data("id") + "-" + $("#det_mat_pro_grup").val());
                var matProGro = $("#det_mat_pro_grup").val(); 
                var total = matProGro.length; 
                var n = matProGro.indexOf("-");
                var i=0;
                console.log("String total: "+total);
                var nums =  new Array(); 
                nums = matProGro.split("-");
//                    while(i!=(total/1)){
//                        matProGro.substring(0,(n-1));
//                        console.log("Num: "+i+"/"+matProGro.substring(0,(n)));
//                        nums.push(matProGro.substring(0,(n)));
//                        matProGro = matProGro.substring((n+1),total);
//                        n = matProGro.indexOf("-");
//                        i++;
//                    }
                    let sorted_arr = nums.slice().sort();
                    let results = [];
                    var duplicados_count=0;
                    for (let i = 0; i <= sorted_arr.length - 1; i++) {
                        if (sorted_arr[i + 1] == sorted_arr[i]) {
                            duplicados_count++;
                            console.log("Somos duplicado Nº"+duplicados_count+"....."+sorted_arr[i]);
                            //results.push(sorted_arr[i]);
                        }else{
                            if(duplicados_count%2==0){
                                results.push(sorted_arr[i]);
                            }
                            duplicados_count=0;
                        }
                    }
                      if($("#det_mat_pro_grup2").val()!=""){
                          $("#det_mat_pro_grup2").val("");
                      }
                    for(var o=0; o<results.length;o++){
                        console.log("Numeros unicos: "+results[o]);
                        $("#det_mat_pro_grup2").val(results[o] + "-" + $("#det_mat_pro_grup2").val());
                    }
                
                
            });
            $("#btn_agrupar").click(function() {
                // Mostrar modal
                //console.log("Agrupaciones!!");
                $("#btn_agrupar").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Creando Grupo ...');
                //data = $("#frm_add_posiciones").serializeArray();
                
                // CHECK IF GRUPO SELECCIONADO
                // GET INFO DE GRUPO SELECCIONADO AÑADIR RESTANTES AL GRUPO!
                
                $.ajax({
                    type: "POST",  
                    url: "saveProyectoMaterialFromAlmacen.php",  
                    data: {
                        check_materiales: $("#det_mat_pro_grup2").val().slice(0,-1),
                        check_proyecto_id: $("#posiciones_proyecto_id").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response.trim());
                        // Response OK? refresh else modal!!!!!!!
                        if(response.trim()=="SI"){
                            window.location.reload();
                        }else{
                            if(response.trim()=="NO"){
                                $("#add_group_view_model").modal("show");
                            }
                        }
                        $("#btn_agrupar").html('Agrupar');
                        setTimeout(function(){
                            //console.log(response[0].id);
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $("#btn_add_grupo").click(function() {
                // Insertar En grupo.
                console.log("Agrupaciones!!"+$("#det_mat_pro_grup2").val());
                $("#btn_agrupar").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Creando Grupo ...');
                data = $("#frm_add_posiciones").serializeArray();
                
                $.ajax({
                    type: "POST",  
                    url: "saveMaterialFromPedidos.php",  
                    data: {
                        nombre_grupo: $("#nom_materiales_grupo").val(),
                        detalles_id : $("#det_mat_pro_grup2").val().slice(0,-1),
                        grupo_proyecto_id: $("#posiciones_proyecto_id").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        // Get html actual del modal y añadirle el response?¿?¿
                            // Bloquear checkbox de los detalles que tengan asignado grupo
                            // Bloquear checkbox de los detalles de almacen que tengan asignado un grupo
                        // 
                        // $('#frm_add_posiciones').trigger("reset");
                        // $("#posiciones_view_model").modal('hide');
                        $("#btn_agrupar").html('Agrupado');
                        window.location.reload();
                        setTimeout(function(){
                            //console.log(response[0].id);
                            window.open("/erp/apps/entregas/view.php?id="+response,"_blank");
                        }, 1000);
                    }   
                });
            });
            // Select / Deselect grupo
            $(document).on("click", ".grup-pos-to-project" , function() {
                //$(".grup-pos-to-project").click(function() {                
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        id_grupo : $(this).parent().children('input').eq(1).val(),
                        load_grupo_detalles: 1
                    },
                    success : function(data){
                        //console.log(data);                        
                        /// Evitar duplicados                
                        //console.log("Padre det id:"+$(this).parent().parent().data("id"));
                        $("#det_mat_pro_grup2").val($.trim($("#det_mat_pro_grup2").val()+$.trim(data)));
                        $("#det_mat_pro_grup").val($.trim($("#det_mat_pro_grup").val()+$.trim(data)));
                        var matProGro = $("#det_mat_pro_grup").val(); 
                        var total = matProGro.length; 
                        var n = matProGro.indexOf("-");
                        var i=0;
                        console.log("String total: "+total);
                        var nums =  new Array(); 
                        nums = matProGro.split("-");
//                            while(i!=(total/6)){
//                                matProGro.substring(0,(n-1));
//                                console.log("Num: "+i+"/"+matProGro.substring(0,(n)));
//                                nums.push(matProGro.substring(0,(n)));
//                                matProGro = matProGro.substring((n+1),total);
//                                n = matProGro.indexOf("-");
//                                i++;
//                            }
                            let sorted_arr = nums.slice().sort();
                            let results = [];
                            var duplicados_count=0;
                            for (let i = 0; i <= sorted_arr.length - 1; i++) {
                                if (sorted_arr[i + 1] == sorted_arr[i]) {
                                    duplicados_count++;
                                    console.log("Somos duplicado Nº"+duplicados_count+"....."+sorted_arr[i]);
                                    //results.push(sorted_arr[i]);
                                }else{
                                    if(duplicados_count%2==0){
                                        results.push(sorted_arr[i]);
                                    }
                                    duplicados_count=0;
                                }
                            }
                              if($("#det_mat_pro_grup2").val()!=""){
                                  $("#det_mat_pro_grup2").val("");
                              }
                            for(var o=0; o<results.length;o++){
                                console.log("Numeros unicos: "+results[o]);
                                $("#det_mat_pro_grup2").val(results[o] + "-" + $("#det_mat_pro_grup2").val());
                            }

                        ///
                        //window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // / CREAR GRUPOS
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
            
            $("#export_excel_materiales_proyecto").click(function() {
                // add_from_alamcen_view_model
                //alert("dentro");
                $.ajax({
                    type : 'POST',
                    url : 'expExcelMaterialesProyecto.php',
                    dataType : 'text',
                    data: {
                        proyecto_id : $("#proyecto_id").val(),
                        pedidos_id : $("#to_project2").val()
                    },
                    success : function(response){
                        //alert(data);
                        //window.location.reload();
                        console.log ("Respuesta: "+response);
                        window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // Boton añadir al grupo
            //add_mat_to_group
            // / Boton Añadir a l grupo
            // Botones de borrar
            $(".remove-material-alm-pro").click(function() {
                $("#del_mat_alm").val($(this).parent().parent().data("id"));
                $("#confirm_del_mat_alm_model").modal("show");
            });
            $("#btn_del_mat_alm").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        del_mat_alm : $("#del_mat_alm").val()
                    },
                    success : function(response){
                        //alert(data);
                        window.location.reload();
                        //console.log ("Respuesta: "+response);
                        //window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            ///// DELETE GRUPO
            $(".remove-group-alm-pro").click(function() {
                $("#del_mat_grup").val($(this).val());
                $("#confirm_del_mat_grup_model").modal("show");
            });
            $("#btn_del_mat_grup").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        del_mat_grup : $("#del_mat_grup").val()
                    },
                    success : function(response){
                        //alert(data);
                        window.location.reload();
                        //console.log ("Respuesta: "+response);
                        //window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            ///// DETELE MATERIAL DEL GRUPO
            $(".remove-groupmat-alm-pro").click(function() {
                $("#del_mat1_grup").val($(this).val());
                $("#confirm_del_mat1_grup_model").modal("show");
            });
            $("#btn_del_mat1_grup").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        del_mat1_grup : $("#del_mat1_grup").val()
                    },
                    success : function(response){
                        //alert(data);
                        window.location.reload();
                        //console.log ("Respuesta: "+response);
                        //window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });            
            // / Botones de borrar
            $("#add_from_almacen_view").click(function() {
                $("#add_from_almacen_view_model").modal('show');
            });
            $("#btn_add_stock_from_almacen").click(function() {
                //alert("De momento no hago nada");
                var rowCount = $('#tabla-materiales-almacen>tbody tr').length;
                console.log("Count: "+rowCount);
                var valor=0;
                var checkeado=false;
                var valores = [];
                for(var i=0; i<rowCount; i++){
                    // Obtener el valor de id del materialstock
                    valor = $('#tabla-materiales-almacen>tbody').children('tr').eq(i).data("id2");
                    // obtener si esta checkeado
                    checkeado = $('#tabla-materiales-almacen>tbody').children('tr').eq(i).children('td').eq(0).children('input').eq(0).is(":checked");
                    if(checkeado){
                        valores.push(valor);
                    }
                }
                console.log("ID get:"+<? echo $_GET["id"]; ?>+"\nProyectoId:"+$("#proyecto_id").val());
//                console.log("Proyecto: "+$("#proyecto_id").val());
//                console.log("Total:"+valores.length);
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        proyecto_id : $("#proyecto_id").val(),
                        materiales_stock_ids : valores
                    },
                    success : function(response){
                        //alert(data);
                        window.location.reload();
                        //console.log ("Respuesta: "+response);
                        //window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $(document).on("click", "#ver_dividir_pedido_almacen" , function() { 
                var id = $(this).parent().parent().data("id2");
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        mat_stock_id : id
                    },
                    success : function(response){
                        //alert(data);
                        //window.location.reload(); 
                        console.log ("Respuesta: "+response);
                        $("#dividir_pedido_almacen_modal").html(response);
                        $("#select_div_ped_alm").selectpicker('refresh');
                        $("#dividir_pedido_almacen_modal").modal('show');
                        $("#materiales_stock_id").val(id);
                        //window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $(document).on("click", "#btn_divi_stock_from_almacen" , function() {     
                //alert("ID:"+$("#materiales_stock_id").val()+"\nCant:"+$("#select_div_ped_alm").val());
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        mat_stock_id2 : $("#materiales_stock_id").val(),
                        cant_divi : $("#select_div_ped_alm").val(),
                        proyecto_id : $("#posiciones_proyecto_id").val()
                    },
                    success : function(response){
                        // alert(data);
                        // console.log ("Respuesta: "+response);
                        // Por mejorar el refresco
                        // $("#add_from_almacen_view_model").modal('hide');
                        // $("#dividir_pedido_almacen_modal").modal('hide');
                        window.location.reload(); 
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // Dividir material asignado a proyecto
            $(document).on("click", ".btn_divi_material_asignado" , function() {
                //console.log($(this).parent().parent().data("id"));
                var iddet = $(this).parent().parent().data("id");
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        load_divi_mat_asign : iddet
                    },
                    success : function(response){
                        // alert(data);
                        // console.log ("Respuesta: "+response);
                        $("#divi_mat_asignado_proyecto_model").html(response);
                        $("#divi_mat_asign").val(iddet);
                        $("#select_div_ped_asig").selectpicker('refresh');
                        $("#divi_mat_asignado_proyecto_model").modal('show');
                        // $("#dividir_pedido_almacen_modal").modal('hide');
                        // window.location.reload(); 
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", "#btn_divi_mat_asign" , function() {
                //console.log($(this).parent().parent().data("id"));
                $.ajax({
                    type : 'POST',
                    url : 'saveProyectoMaterialFromAlmacen.php',
                    dataType : 'text',
                    data: {
                        divi_mat_asign : $("#divi_mat_asign").val(),
                        cant: $("#select_div_ped_asig").val()
                    },
                    success : function(response){
                        // alert(data);
                        console.log ("Respuesta: "+response);
                        // $("#dividir_pedido_almacen_modal").modal('hide');
                        // Mejorar reload
                        $("#refresh_posiciones").click();
                        $("#divi_mat_asignado_proyecto_model").modal("hide");
                        $("#posiciones_view_model").modal("hide");
                        //window.location.reload(); 
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });            
            // / Dividir material asignado a proyecto
            // deshabilitado temporalmente
            /*
            $("#tabla-horas tr").click(function() {
                //loadProyectoHorasInfo($(this).data("id"));
                //$("#horas_add_model").modal('show');
                window.open(
                    "/erp/apps/actividad/editAct.php?id=" + $(this).data("id"),
                    "_blank"
                );
            });*/
            
            $(document).on("click", ".open-actividad" , function() {
                // $(".open-actividad").click(function() {
                //loadProyectoHorasInfo($(this).data("id"));
                //$("#horas_add_model").modal('show');
                window.open(
                    "/erp/apps/actividad/editAct.php?id=" + $(this).data("id"),
                    "_blank"
                );
            });
            $(document).on("click", ".goto-entrega" , function() {
                // $(".goto-entrega").click(function() {
                window.open(
                    "/erp/apps/entregas/view.php?id=" + $(this).data("id"),
                    "_blank"
                );
            });
            $("#tabla-partes-intervencion tr").click(function() {
                window.open(
                    "/erp/apps/intervenciones/editInt.php?id=" + $(this).data("id"),
                    "_blank"
                );
            });
            $("#tabla-act tr").click(function() {
                window.open(
                    "/erp/apps/actividad/editAct.php?id=" + $(this).data("id"),
                    "_blank"
                );
            });
            
            $(".get-act").click(function() {
                $.ajax({
                    type : 'POST',
                    url : '/erp/apps/actividad/saveAct.php',
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
            // Deshabilitar add gastos botones. Add buttons dell 3 gastos!!
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
            $("#print_posiciones").click(function() {
                window.open(
                    "printPosiciones.php?id=<? echo $_GET['id']; ?>",
                    '_blank' 
                );
            });
            $("#refresh_posiciones").click(function() {
                $.ajax({
                    type: "POST",  
                    url: "reloadTablaPosicionesPedidos.php",  
                    data: {
                        refresh_posiciones: 1,
                        id: <? echo $_GET["id"];?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#tabla-posiciones-pedidos').html(response);
                        setTimeout(function(){
                            //$("#newenvio_success").fadeOut("slow");
                            //console.log(response[0].id);
                            //window.location.href = "/erp/apps/envios/editEnvio.php?id=" + response[0].id;
                        }, 1000);
                    }   
                });
            });
            // ALBARAN DE ENVIO DE MATERIAL DEL PROYECTO
            $(document).on("click", ".to-alb" , function() {
                //$(".to-alb").change(function () {
                $("#to_albaran").val($(this).data("matprojid") + "-" + $("#to_albaran").val());
            });
            $(document).on("click", ".view-envio" , function() {
                //$(".view-envio").click(function () {
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
            
            // Editar y borrar horas imputadas
            $(document).on("click", ".edit-horas-imput" , function() {
                // Mostar modal
                loadHorasImputadas($(this).data("id"));
                $("#horas_add_model").modal('show');
            });
            $(document).on("click", ".remove-horas-imput" , function() {
                $("#horas_deldetalle").val($(this).data("id"));
                $("#horas_remove_model").modal('show');
            });
            $(document).on("click", "#btn_remove_horas_imput" , function() {
                console.log("dentro");
                $.ajax({
                    type: "POST",  
                    url: "saveHoras.php",  
                    data: {
                        horas_deldetalle: $("#horas_deldetalle").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        $('#frm_edit_horas').trigger("reset");
                        refreshSelects();
                        $("#btn_horas_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#horas_remove_model").modal('hide');
                        $("#horas_add_model").modal('hide');
                        $("#horas_success").slideDown();
                        setTimeout(function(){
                            $("#horas_success").fadeOut("slow");
                            // POR MEJORAR REFRESCO Y VISUALIZACIÓN!!
                            loadContent("content-horas-imputadas", "vistas/proyectos-horas-imp-actividad.php?id=" + <? echo $_GET['id']; ?>);
                        }, 2000);
                    }   
                });
            });
            
            
            //COLLAPSE-EXPAND
            $(".expand-div").hide();
            $(".collapse-div").click(function() {
                $("#" + $(this).data("div")).slideUp("slow");
                $(this).parent("div").css("height","50px");
                $(this).parent("div").css("background-color","50px");
                $(this).parent("div").addClass("collapsed");
                $(this).hide();
                $(this).parent("div").children(".expand-div").show();
                
            });
            $(".expand-div").click(function() {
                $("#" + $(this).data("div")).slideDown("slow");
                if ($(this).data("height") != "") {
                    height = $(this).data("height");
                }
                else {
                    height = "auto";
                }
                $(this).parent("div").css("height",height);
                $(this).parent("div").removeClass("collapsed");
                $(this).hide();
                $(this).parent("div").children(".collapse-div").show();
                
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
                <button class="btn btn-default btn-circle collapse-div" title="Contraer" data-div="project-view"><img src="/erp/img/collapse.png"></button>
                <button class="btn btn-default btn-circle expand-div" title="Expandir" data-div="project-view" data-height=""><img src="/erp/img/expand.png"></button>
                
                    <h4 class="dash-title">
                        <? include($pathraiz."/apps/proyectos/includes/tools-single-project.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/current-project.php"); 
                    ?>
                
            </div>
            
            <div id="dash-grafico-costes" class="two-column" style="min-height: 370px;">
                <h4 class="dash-title">
                    RESUMEN DE GASTOS
                </h4>
                <hr class="dash-underline">
                <div id="dash-gastos">
                <? 
                    //$fechamod = 1;
                    include("vistas/proyecto-grafico-rendimiento_mod.php"); 
                ?>
                </div>
            </div>
            <span class="stretch"></span>
            
            <div id="dash-proyectos-ofertas" class="two-column">
                <h4 class="dash-title">
                    OFERTAS <? include($pathraiz."/apps/proyectos/includes/tools-ofertas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-ofertas" class="pre-scrollable">
                    <? //include("vistas/ofertas.php"); ?>
                </div>
            </div>
            <div id="proyecto-documentos" class="two-column">
                <h4 class="dash-title">
                    ENTREGAS <? include($pathraiz."/apps/proyectos/includes/tools-entregas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-entregas" class="pre-scrollable">
                    <? //include("vistas/entregas.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
            
            <div id="dash-horas-enfrentadas" class="one-column" style="height: 350px;">
                <button class="btn btn-default btn-circle collapse-div" title="Contraer" data-div="dash-resumenhoras"><img src="/erp/img/collapse.png"></button>
                <button class="btn btn-default btn-circle expand-div" title="Expandir" data-div="dash-resumenhoras" data-height="350px"><img src="/erp/img/expand.png"></button>
                <div id="dash" class="one-column" style="text-align: center;">
                    <h4 class="dash-title">
                        RESUMEN DE HORAS
                    </h4>
                    <hr class="dash-underline">
                    <div id="dash-resumenhoras">
                        <? //include("vistas/proyectos-horas-enfrentadas-actividad.php"); ?>
                    </div>
                </div>
            </div>
            
            <div id="dash-horas" class="two-column" >
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        ORDENES DE TRABAJO / HORAS VENDIDAS <? include($pathraiz."/apps/proyectos/includes/tools-ordenes.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="dash-ordenes">
                        <? include("vistas/proyectos-ordenes.php"); ?>
                    </div>
                </div>
                <span class="stretch"></span>
                <!--
                <div id="dash-hitos" class="one-column">
                    <h4 class="dash-title">
                        HITOS/TAREAS <? //include($pathraiz."/apps/proyectos/includes/tools-hitos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <? //include("vistas/proyectos-hitos.php"); ?>
                </div>
                -->
            </div>

            <div id="dash-horas" class="two-column" >
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        HORAS IMPUTADAS 
                        <? include($pathraiz."/apps/proyectos/includes/tools-horas-imp.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="content-horas-imputadas">
                        <? //include("vistas/proyectos-horas-imp-actividad.php"); ?>
                    </div>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-actividades" class="one-column">
                <div id="dash" class="one-column">
                    <h4 class="dash-title">
                        ACTIVIDAD / INTERVENCIONES
                    </h4>
                    <hr class="dash-underline">
                    <div class="pre-scrollable2">
                        <? include("vistas/proyectos-actividades.php"); ?>
                    </div>
                </div>
            </div>
            
            <div id="dash-horas" class="two-column" >
                <div id="dash-pedidosproyecto" class="one-column">
                    <h4 class="dash-title">
                        PEDIDOS MATERIAL
                        <? include($pathraiz."/apps/proyectos/includes/tools-pedidos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div class="pre-scrollable2">
                    <? 
                        //$fechamod = 1;
                        include($pathraiz."/apps/proyectos/vistas/proyectos-pedidos.php"); 
                    ?>
                    </div>
                </div>
            </div>
            
            <div id="dash-horas" class="two-column" >
                <div id="dash-materiales-add" class="one-column">
                    <h4 class="dash-title">
                        MATERIAL UTILIZADO
                        <? include($pathraiz."/apps/proyectos/includes/tools-material.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="content-materialutilizado">
                    <? 
                        $fechamod = 1;
                        //include("vistas/proyectos-material.php"); 
                    ?>
                    </div>
                </div>
            </div>
            <span class="stretch"></span>
            <!--
            <div id="dash-partes" class="two-column" >
                <div id="proyecto-partes" class="one-column">
                    <h4 class="dash-title">
                        PARTES DE INTERVENCIÓN <? //include($pathraiz."/apps/proyectos/includes/tools-partes.php"); ?>
                        <label class="helper">Este apartado se sustituye con el de ACTIVIDAD/INTERVENCIONES</label>
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //include($pathraiz."/apps/proyectos/vistas/proyectos-partes.php"); 
                    ?>
                </div>
            </div>
            -->
            <div id="proyecto-documentos" class="one-column">
                <h4 class="dash-title">
                    <h4 class="dash-title2">DOCUMENTOS</h4> <span id="helpico" title="Se escanea la carpeta del proyecto y se importan a la base de datos."></span> 
                        <? include($pathraiz."/apps/proyectos/includes/tools-documentos.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="treeview_json">
                    <? //include("vistas/documentos.php"); ?>
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
                <div id="dash-sub">
                <? 
                    $fechamod = 1;
                    //include("vistas/proyectos-terceros.php"); 
                ?>
                </div>
            </div>
            <div id="dash-venta-add" class="two-column">
                <h4 class="dash-title">
                    VIAJES/DESPLAZAMIENTOS
                    <? include("includes/tools-venta-viajes.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-viajes">
                <? 
                    $fechamod = 1;
                    //include("vistas/proyectos-viajes.php"); 
                ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-otros-add" class="two-column">
                <h4 class="dash-title">
                    OTROS
                    <? include("includes/tools-venta-otros.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-otros">
                <? 
                    $fechamod = 1;
                    //include("vistas/proyectos-otros.php"); 
                ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
</body>
</html>