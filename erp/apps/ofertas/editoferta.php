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
            
            $("#uploaddocs").fileinput({
                uploadUrl: "upload.php?oferta_id=" + <? echo $_GET['id']; ?>,
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
                    nombre: $("#materialdetalle_docnombre").val(),
                    descripcion: $("#materialdetalle_docdesc").val(),
                    oferta_id: <? echo $_GET['id'] ?> 
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
                
            });   
            
            $('input[name="ofertamat_chkalmacen"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            function calcImportesMat() {
                //alert("calculo importes");
                var totalDTO = 0.00;
                                
                //descuentos activados
                if( $('#ofertamat_dtoprov_desc').prop('checked') ) {
                    //alert(parseFloat($("#ofertamat_dtoprov option:selected").text().split("/")[0].replace("% ",""), 10).toFixed(2));
                    totalDTO = parseFloat(totalDTO, 10) + parseFloat($("#ofertamat_dtoprov option:selected").text().split("/")[0].replace("% ",""), 10);
                    //alert (totalDTO);
                }
                if( $('#ofertamat_dtomat_desc').prop('checked') ) {
                    totalDTO = parseFloat(totalDTO, 10) + parseFloat($("#ofertamat_dtomat").val(), 10);
                }
                if( $('#ofertamat_dto_desc').prop('checked') ) {
                    totalDTO = parseFloat(totalDTO) + parseFloat($("#ofertamat_dto").val(), 10);
                }
                var dto = "0." + (100 - parseFloat(totalDTO, 10).toFixed(2));
                if (dto == "0.100") {
                    dto = 1;
                }
                
                var pvp = parseFloat($("#ofertamat_preciomat").val(),10)*parseFloat($("#ofertamat_cantidad").val(),10);
                var pvpdto = parseFloat(pvp, 10)*parseFloat(dto,10);
                //var inc = "1." + $("#ofertamat_incremento").val();
                var inc = parseFloat($("#ofertamat_incremento").val());
                $("#ofertamat_pvp").val(pvp.toFixed(2));
                $("#ofertamat_totaldtopercent").val(totalDTO.toFixed(2));
                $("#ofertamat_totaldto").val(((parseFloat(pvp)*parseFloat(totalDTO,10))/100).toFixed(2));
                $("#ofertamat_pvpdto").val(pvpdto.toFixed(2));
                //var pvpinc = parseFloat(pvpdto,10)*parseFloat(inc,10);
                //var pvpinc = parseFloat(pvpdto,10)/parseFloat(inc,10);
                var pvpinc = (pvpdto.toFixed(2)*inc)/100;
                var pvpventa = pvpdto+pvpinc;
                $("#ofertamat_pvpinc").val(pvpventa.toFixed(2));
            };
            
            function calcImportesSub() {
                var dto = "0." + (100 - parseFloat($("#ofertasub_dto").val(), 10).toFixed(2));
                if (dto == "0.100") {
                    dto = 1;
                }
                var pvpdto = parseFloat($("#ofertasub_cantidad").val(),10).toFixed(2)*(parseFloat($("#ofertasub_unitario").val(),10).toFixed(2)*parseFloat(dto,10).toFixed(2));
                //var inc = "1." + $("#ofertasub_incremento").val();
                var inc = parseFloat($("#ofertasub_incremento").val());
                var pvp = parseFloat($("#ofertasub_unitario").val(),10).toFixed(2)*parseFloat($("#ofertasub_cantidad").val(),10).toFixed(2);
                $("#ofertasub_pvp").val(pvp);
                $("#ofertasub_pvpdto").val(pvpdto.toFixed(2));
                //var pvpinc = parseFloat(pvpdto,10)*parseFloat(inc,10).toFixed(2);
                //var pvpinc = parseFloat(pvpdto,10)/parseFloat(inc,10);
                var pvpinc = (pvpdto.toFixed(2)*inc)/100;
                var pvpventa = pvpdto+pvpinc;
                $("#ofertasub_pvpinc").val(pvpventa.toFixed(2));
            };
            function calcImportesMano() {
                var dto = "0." + (100 - parseFloat($("#ofertamano_dto").val(), 10).toFixed(2));
                if (dto == "0.100") {
                    dto = 1;
                }
                var pvp_total = parseFloat($("#ofertamano_cantidad").val(),10).toFixed(2)*(parseFloat($("#ofertamano_preciohora").val(),10).toFixed(2)*parseFloat(dto,10).toFixed(2));
                //var inc = "1." + $("#ofertasub_incremento").val();
                var pvp = parseFloat($("#ofertamano_preciohora").val(),10).toFixed(2)*parseFloat($("#ofertamano_cantidad").val(),10).toFixed(2);
                $("#ofertamano_pvp").val(pvp);
                $("#ofertamano_pvp_total").val(pvp_total.toFixed(2));
                //var pvpinc = parseFloat(pvpdto,10)*parseFloat(inc,10).toFixed(2);
                //$("#ofertasub_pvp_total").val(pvpinc.toFixed(2));
            };
            function calcImportesViajes() {
                //var inc = "1." + $("#ofertaviajes_incremento").val();
                var inc = parseFloat($("#ofertaviajes_inc").val());
                //var pvp_total = parseFloat($("#ofertaviajes_cantidad").val(),10).toFixed(2)*(parseFloat($("#ofertaviajes_unitario").val(),10).toFixed(2));
                //var inc = "1." + $("#ofertaviajes_incremento").val();
                //console.log("inc: "+inc);
                var pvp = parseFloat($("#ofertaviajes_unitario").val(),10).toFixed(2)*parseFloat($("#ofertaviajes_cantidad").val(),10).toFixed(2);
                //console.log("pvp: "+pvp);
                $("#ofertaviajes_pvp").val(pvp);
                
                //var pvp_total = parseFloat(pvp,10)*parseFloat(inc,10).toFixed(2);
                var pvp_total = parseFloat(pvp,10)+(parseFloat(pvp,10)*parseFloat(inc,10).toFixed(2))/100;
                $("#ofertaviajes_pvp_total").val(pvp_total.toFixed(2));
                //var pvpinc = parseFloat(pvpdto,10)*parseFloat(inc,10).toFixed(2);
                //$("#ofertaviajes_pvp_total").val(pvpinc.toFixed(2));
            };
            function calcImportesOtros() {
                //var inc = "1." + $("#ofertaotros_inc").val();
                var inc = parseFloat($("#ofertaotros_inc").val());
                var pvp_total = parseFloat($("#ofertaotros_cantidad").val(),10).toFixed(2)*(parseFloat($("#ofertaotros_unitario").val(),10).toFixed(2));
                //var inc = "1." + $("#ofertaotros_incremento").val();
                var pvp = parseFloat($("#ofertaotros_unitario").val(),10).toFixed(2)*parseFloat($("#ofertaotros_cantidad").val(),10).toFixed(2);
                $("#ofertaotros_pvp").val(pvp);
                
                //var pvp_total = parseFloat(pvp,10)*parseFloat(inc,10).toFixed(2);
                var pvp_total = parseFloat(pvp,10)+(parseFloat(pvp,10)*parseFloat(inc,10).toFixed(2))/100;
                $("#ofertaotros_pvp_total").val(pvp_total.toFixed(2));
                //var pvpinc = parseFloat(pvpdto,10)*parseFloat(inc,10).toFixed(2);
                //$("#ofertaotros_pvp_total").val(pvpinc.toFixed(2));
            };
            
            
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	

                    
            $("#menuitem-ofertas").addClass("active");
            
            // ######## LOAD SELECTS #######
            loadSelect("ofertas_proyectos","PROYECTOS","id","","","ref");
            loadSelect("ofertas_clientes","CLIENTES","id","","","");
            loadSelectNotEstadoOferta("ofertas_estados",4);
            loadSelect("ofertamat_categorias1","MATERIALES_CATEGORIAS","id","parent_id",0);
            loadSelect("ofertasub_terceros","PROVEEDORES","id","","",);
            loadSelect("ofertamano_tareas","TAREAS","id","","", "perfil_id");
            
            loadContent("dash-materiales", "/erp/apps/ofertas/vistas/oferta-materiales.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-mano", "/erp/apps/ofertas/vistas/oferta-mano.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-sub", "/erp/apps/ofertas/vistas/oferta-terceros.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-viaje", "/erp/apps/ofertas/vistas/oferta-viajes.php?id=" + <? echo $_GET['id']; ?>);
            loadContent("dash-otros", "/erp/apps/ofertas/vistas/oferta-otros.php?id=" + <? echo $_GET['id']; ?>);
            
            
            //loadOferta(<? echo $_GET['id']; ?>);
            //alert(<? echo $_GET['id']; ?>);
            
            // ######## OPEN MODALS #######
            $("#add-costematerial").click(function() {
                $("#frm_edit_ofertamat").trigger("reset"); // No resetea los hidden?¡
                $('#ofertamat_detalle_id').val("");
                $('#ofertamat_material_id').val("");
                $("#ofertamat_precios").selectpicker();
                $("#ofertamat_precios").selectpicker('refresh');
                $("#ofertamat_proveedor").selectpicker();
                $("#ofertamat_proveedor").selectpicker('refresh');
                $("#ofertamat_materiales").selectpicker();
                $("#ofertamat_materiales").selectpicker('refresh');
                $('input[name="ofertamat_chkalmacen"]').bootstrapSwitch('state',parseInt(0));
                $("#ofertamat_chkalmacen").val("off");
                $("#material_add_model").modal('show');
            });
            $("#add-costesubcontratas").click(function() {
                $("#subcontratacion_add_model").modal('show');
            });
            $("#add-ventamanoobra").click(function() {
                $("#frm_edit_ofertamano").trigger("reset"); // No resetea los hidden?¡
                $('#ofertamano_detalle_id').val("");
                $("#ofertamano_tareas").selectpicker();
                $("#ofertamano_tareas").selectpicker('refresh');
                $("#ofertamano_horas").selectpicker();
                $("#ofertamano_horas").selectpicker('refresh');
                $("#manoobra_add_model").modal('show');
            });
            $("#add-ventaviajes").click(function() {
                $("#viajes_add_model").modal('show');
            });
            $("#add-ventaotros").click(function() {
                $("#otros_add_model").modal('show');
            });
            $("#add-documento").click(function() {
                $("#detallematerial_adddoc_model").modal('show');
            });
            
            // ######## SELECTS CHANGE EVENTS #######
            $("select.ofertamat_categorias").on("changed.bs.select", function (e) { 
                var numCat = $("select.ofertamat_categorias").length + 1;
                console.log("num elementos " + numCat);
                for (i = 1; i < numCat; i++) {
                    if (i != 1) {
                        console.log("delete " + numCat);
                        $("#ofertamat_categorias" + i).selectpicker("destroy");
                        $("#ofertamat_categorias" + i).closest(".form-group").remove();
                    }
                }
                
                var numCat = $("select.ofertamat_categorias").length + 1;
                var htmlElement = "<div class='form-group'><label class='labelBeforeBlack'></label><select id='ofertamat_categorias" + numCat + "' name='ofertamat_categorias" + numCat + "' class='selectpicker ofertamat_categorias' data-live-search='true' data-width='33%'><option></option></select></div>"
                $("select.ofertamat_categorias").last().closest(".form-group").after(htmlElement);
                
                loadSelect("ofertamat_categorias" + numCat,"MATERIALES_CATEGORIAS","id","parent_id",$(this).val());
                $("#ofertamat_categorias" + numCat).selectpicker();
                $("#ofertamat_categorias" + numCat).selectpicker('refresh');
            });
            $("body").on('change',"select.ofertamat_categorias", function(){
                //alert("ok");  
                loadSelect("ofertamat_materiales","MATERIALES","id","categoria_id",$(this).val(),"ref");
            });
            $("#ofertamat_materiales").on("changed.bs.select", function (e) {
                loadMaterialInfo($(this).val(), "MATERIALES");
                loadSelectMaterialesProv("ofertamat_proveedor",$(this).val());
                //loadSelectPreciosOferta("ofertamat_precios","MATERIALES_PRECIOS","id", "material_id", $(this).val());
                //loadSelect("ofertamat_precios","MATERIALES_PRECIOS","id","material_id",$(this).val(),"fecha_val", "", "","MATERIALES_PRECIOS.dto_material");
            });
            $("#ofertamat_proveedor").on("changed.bs.select", function (e) {
                loadSelectPreciosOferta("ofertamat_precios","MATERIALES_PRECIOS","material_id",$("#ofertamat_materiales").val(), "proveedor_id", $(this).val());
            });
            $("#ofertamat_precios").on("changed.bs.select", function (e) {
                 var selText = $(this).find('option:selected').text();
                 var partes = selText.split("-");
                 var pvp = partes[1].replace("€","").trim();
                 $("#ofertamat_preciomat").val(pvp);
                 loadSelect("ofertamat_dtoprov","PROVEEDORES_DTO","id","proveedor_id",$("#ofertamat_precios option:selected").data("proveedorid"),"fecha_val","","","");
            });
            // Mostrar modal de Añadir tarifa si solo se ha seleccionado proveedor
            $(document).on("click", "#addtarifa_material" , function() {
                console.log("Proveedor: "+$("#ofertamat_proveedor").val());
                console.log("Proveedor: "+$("#ofertamat_proveedor").text());
                if($("#ofertamat_proveedor").val()!=""){
                    $("#newtarifa_proveedorid").val($("#ofertamat_proveedor").val());
                    $("#newtarifa_materialid").val($("#ofertamat_materiales").val());
                    $("#addtarifa_modal").modal("show");
                }
            });
            // Añadir tarifa al material y proveedor 
            $(document).on("click", "#btn_new_tarifa" , function() {
                $("#btn_new_tarifa").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_add").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveTarifaMaterial.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_add').trigger("reset");
                        refreshSelects();
                        $("#btn_new_tarifa").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#addtarifa_modal").modal('hide');
                        $("#material_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        //window.location.reload();?¿
                    }   
                });
            });
            $("#ofertamano_tareas").on("changed.bs.select", function (e) {
                var dataperfil = $("option[value=" + $(this).val() + "]", this).attr('data-perfil');
                loadSelect("ofertamano_horas","PERFILES_HORAS","id","perfil_id",dataperfil,"precio");
            });
            $("#ofertamano_horas").on("changed.bs.select", function (e) {
                var dataprecio = $("option[value=" + $(this).val() + "]", this).attr('data-precio');
                $("#ofertamano_preciohora").val(dataprecio);
            });
            $("#ofertamat_criterio").change(function () {
                loadSelect("ofertamat_materiales","MATERIALES","id","ref",$(this).val(),"ref","nombre",$(this).val(),"",1);
            });
            
            
            // ######## FOCUSOUT EVENTS #######
            $(document).on("focusout", "#ofertamat_cantidad" , function() {
                //$("#ofertamat_cantidad").focusout(function() {
                calcImportesMat();
            });
            $(document).on("focusout", "#ofertamat_dto" , function() {
                //$("#ofertamat_dto").focusout(function() {
                calcImportesMat();
            });
            $(document).on("focusout", "#ofertamat_incremento" , function() {
                //$("#ofertamat_incremento").focusout(function() {
                calcImportesMat();
            });
            $(document).on("focusout", "#ofertamat_dtoprov_desc" , function() {
                //$("#ofertamat_dtoprov_desc").change(function() {
                calcImportesMat();
            });
            $(document).on("focusout", "#ofertamat_dtomat_desc" , function() {
                //$("#ofertamat_dtomat_desc").change(function() {
                calcImportesMat();
            });
            $(document).on("focusout", "#ofertamat_dto_desc" , function() {
                //$("#ofertamat_dto_desc").change(function() {
                calcImportesMat();
            });
            
            $(document).on("focusout", "#ofertasub_cantidad" , function() {
            //$("#ofertasub_cantidad").focusout(function() {
                calcImportesSub();
            });
            $(document).on("focusout", "#ofertasub_unitario" , function() {
            //$("#ofertasub_unitario").focusout(function() {
                calcImportesSub();
            });
            $(document).on("focusout", "#ofertasub_dto" , function() {
            //$("#ofertasub_dto").focusout(function() {
                calcImportesSub();
            });
            $(document).on("focusout", "#ofertasub_incremento" , function() {
            //$("#ofertasub_incremento").focusout(function() {
                calcImportesSub();
            });
            
            $(document).on("focusout", "#ofertamano_cantidad" , function() {
            //$("#ofertamano_cantidad").focusout(function() {
                calcImportesMano();
            });
            $(document).on("focusout", "#ofertamano_dto" , function() {
            //$("#ofertamano_dto").focusout(function() {
                calcImportesMano();
            });
            
            $(document).on("focusout", "#ofertaviajes_cantidad" , function() {
                //$("#ofertaviajes_cantidad").focusout(function() {
                calcImportesViajes();
            });
            $(document).on("focusout", "#ofertaviajes_unitario" , function() {
                //$("#ofertaviajes_unitario").focusout(function() {
                calcImportesViajes();
            });
            $(document).on("focusout", "#ofertaviajes_inc" , function() {
                //$("#ofertaviajes_inc").focusout(function() {
                calcImportesViajes();
            });
            
            $(document).on("focusout", "#ofertaotros_cantidad" , function() {
                //$("#ofertaotros_cantidad").focusout(function() {
                calcImportesOtros();
            });
            $(document).on("focusout", "#ofertaotros_unitario" , function() {
                //$("#ofertaotros_unitario").focusout(function() {
                calcImportesOtros();
            });
            $(document).on("focusout", "#ofertaotros_inc" , function() {
                //$("#ofertaotros_inc").focusout(function() {
                calcImportesOtros();
            });
            $(document).on("focusout", "#ofertamat_dto" , function() {
                //$("#ofertamat_dto").focusout(function() {
                $("#ofertamat_dto").val(parseFloat($("#ofertamat_dto").val()).toFixed(2));
            });            
            
            // ######## SAVE DETALLES #######
            $("#btn_ofertamat_save").click(function() {
                $("#btn_ofertamat_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_ofertamat").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_ofertamat").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveOfertamat.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_ofertamat').trigger("reset");
                        refreshSelects();
                        $("#btn_ofertamat_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#material_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        
                        // Por mejorar el refresco
                        $("#material_add_model").modal("hide");
                        loadContent("dash-materiales", "/erp/apps/ofertas/vistas/oferta-materiales.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                        //window.location.reload();
                    }   
                });
            });

            $("#btn_ofertasub_save").click(function() {
                $("#btn_ofertasub_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_ofertasub").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_ofertasub").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveOfertaSub.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_ofertasub').trigger("reset");
                        refreshSelects();
                        $("#btn_ofertasub_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#subcontratacion_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        loadContent("dash-sub", "/erp/apps/ofertas/vistas/oferta-terceros.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                        //window.location.reload();
                    }   
                });
            });
            
            $("#btn_ofertamano_save").click(function() {
                $("#btn_ofertamano_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_ofertamano").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_ofertamano").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveOfertaMano.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_ofertamano').trigger("reset");
                        refreshSelects();
                        $("#btn_ofertamano_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#manoobra_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        loadContent("dash-mano", "/erp/apps/ofertas/vistas/oferta-mano.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                        //window.location.reload();
                    }   
                });
            });
            
            $("#btn_ofertaviajes_save").click(function() {
                $("#btn_ofertaviajes_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_ofertaviajes").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_ofertaviajes").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveOfertaViaje.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_ofertaviajes').trigger("reset");
                        refreshSelects();
                        $("#btn_ofertaviajes_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#viajes_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        loadContent("dash-viaje", "/erp/apps/ofertas/vistas/oferta-viajes.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                        //window.location.reload();
                    }   
                });
            });
            
            $("#btn_ofertaotros_save").click(function() {
                $("#btn_ofertaotros_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_ofertaotros").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_ofertaotros").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveOfertaOtros.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_edit_ofertaotros').trigger("reset");
                        refreshSelects();
                        $("#btn_ofertaotros_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#viajes_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        loadContent("dash-otros", "/erp/apps/ofertas/vistas/oferta-otros.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                        //window.location.reload();
                    }   
                });
            });
            
            $("#edit_oferta").click(function() {
                //alert($(this).data('id'));
                $("#ofertas_clientes").val($("#ofertas_clienteid").val());
                $("#ofertas_clientes").selectpicker('refresh');
                $("#ofertas_estados").val($("#ofertas_estadoid").val());
                $("#ofertas_estados").selectpicker('refresh');
                $("#ofertas_proyectos").val($("#ofertas_proyectoid").val());
                $("#ofertas_proyectos").selectpicker('refresh');
                $("#oferta-view").hide();
                $("#oferta-edit").fadeIn();
            });
            
            $("#save_oferta").click(function() {
                $("#ofertas_btn_save").click();
            });
            
            $("#ofertas_btn_save").click(function() {
                $("#ofertas_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("ofertas_idoferta").val(<? echo $_GET['id']; ?>);
                data = $("#frm_oferta").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveOferta.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_oferta').trigger("reset");
                        refreshSelects();
                        $("#ofertas_btn_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#ofertas_success").slideDown();
                        console.log(response);
                        setTimeout(function(){
                            $("#ofertas_success").fadeOut("slow");
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            
            $("#print_oferta").click(function() {
                $("#print_oferta").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Imprimiendo ...');
                $('#cover').fadeIn('slow');
                $.post('includes/print_pdf.php', 
                { 
                    id_oferta: <? echo $_GET['id']; ?>
                })
                .done(function( data ) {
                    //alert(data);
                    //alert("file://192.168.3.108/" + data);
                    $("#print_oferta").html('<img src="/erp/img/print.png" height="30">');
                    $('#cover').fadeOut('slow').delay(1000);
                    /*
                     $("#print_success").slideDown();
                    setTimeout(function(){
                        $("#categorias_success").fadeOut("slow");
                        //console.log(response[0].id);
                        window.location.reload();
                    }, 2000);
                    */
                   console.log("data: "+data);
                    if (data != "error") {
                        //alert(data);
                        window.open(
                            data,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                    else {
                        
                    }       
                }); 
            });
            $("#versiones_aceptar").click(function() {
                $("#confirm_aceptoferta_model").modal("show");
            });
            $("#btn_versiones_aceptar").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'acceptOferta.php',
                    dataType : 'text',
                    data: {
                        accept_id : <? echo $_GET['id'] ?>
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // ######## DELETE DETALLES #######
            $(document).on("click", ".remove-detalle" , function() {
                $("#del_matof_id").val($(this).data("id"));
                $("#del_materialoferta_model").modal("show");
            });
            $(document).on("click", "#btn_del_matof" , function() {
            //$(".remove-detalle").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveOfertamat.php',
                    dataType : 'text',
                    data: {
                        ofertamat_deldetalle : $("#del_matof_id").val()
                    },
                    success : function(data){
                        console.log("ok");
                        $("#del_materialoferta_model").modal("hide");
                        loadContent("dash-materiales", "/erp/apps/ofertas/vistas/oferta-materiales.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                        //window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", ".remove-detalle-terceros" , function() {
                $("#del_sub_id").val($(this).data("id"));
                $("#del_costesubcontratas_model").modal("show");
            });
            $(document).on("click", "#btn-remove-detalle-sub" , function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveOfertaSub.php',
                    dataType : 'text',
                    data: {
                        ofertasub_deldetalle : $("#del_sub_id").val()
                    },
                    success : function(data){
                        //console.log("ok");
                        $("#del_costesubcontratas_model").modal("hide");
                        //window.location.reload();
                        loadContent("dash-sub", "/erp/apps/ofertas/vistas/oferta-terceros.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", ".remove-detalle-mano" , function() {
                $("#del_manof_id").val($(this).data("id"));
                $("#del_manooferta_model").modal("show");
            });
            $(document).on("click", "#btn-remove-detalle-mano" , function() {
            //$(".remove-detalle-mano").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveOfertaMano.php',
                    dataType : 'text',
                    data: {
                        ofertamano_deldetalle : $("#del_manof_id").val()
                    },
                    success : function(data){
                        console.log("ok");
                        // Mejorar refresh
                        $("#del_manooferta_model").modal("hide");
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-mano", "/erp/apps/ofertas/vistas/oferta-mano.php?id=" + <? echo $_GET['id']; ?>);
                        //window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", ".remove-detalle-viaje" , function() {
                $("#del_viajeof_id").val($(this).data("id"));
                $("#del_viajeoferta_model").modal("show");
            });
            $(document).on("click", "#btn-remove-detalle-viaje" , function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveOfertaViaje.php',
                    dataType : 'text',
                    data: {
                        ofertaviajes_deldetalle : $("#del_viajeof_id").val()
                    },
                    success : function(data){
                        console.log("ok");
                        $("#del_viajeoferta_model").modal("hide");
                        //window.location.reload();
                        loadContent("dash-viaje", "/erp/apps/ofertas/vistas/oferta-viajes.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", ".remove-detalle-otros" , function() {
                $("#del_otrosof_id").val($(this).data("id"));
                $("#del_otrosoferta_model").modal("show");
            });
            $(document).on("click", "#btn-remove-detalle-otros" , function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveOfertaOtros.php',
                    dataType : 'text',
                    data: {
                        ofertaotros_deldetalle : $("#del_otrosof_id").val()
                    },
                    success : function(data){
                        console.log("ok");
                        $("#del_otrosoferta_model").modal("hide");
                        //window.location.reload();
                        loadContent("dash-otros", "/erp/apps/ofertas/vistas/oferta-otros.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                        loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", ".delDoc" , function() {
                // Mostrar Modal de confirmación
                $("#deldoc_oferta_id").val($(this).data("id"));
                $("#ofertadeldoc_model").modal("show");
            });
            $(document).on("click", "#btn_delDoc" , function() {
                // Borrar
                $.ajax({
                    type : 'POST',
                    url : 'saveOfertaDoc.php',
                    dataType : 'text',
                    data: {
                        ofertadoc_del : $("#deldoc_oferta_id").val()
                    },
                    success : function(data){
                        console.log("ok");
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            // ######## EDIT DETALLES #######
            $(document).on("click", "#tabla-ofertas-mat tr > td:not(:nth-child(11))" , function() {
                //$("#tabla-ofertas-mat tr > td:not(:nth-child(11))").click(function() {
                if($(this).parent("tr").data("id")!=0){ // Solo si esta habilitado
                    loadOfertaDetalleInfo($(this).parent("tr").data("id"));
                    $("#material_add_model").modal('show');
                }
            });
            $(document).on("click", "#tabla-ofertas-sub tr > td:not(:nth-child(10))" , function() {
                //$("#tabla-ofertas-sub tr > td:not(:nth-child(10))").click(function() {
                loadOfertaDetalleSubInfo($(this).parent("tr").data("id"));
                $("#subcontratacion_add_model").modal('show');
            });
            $(document).on("click", "#tabla-ofertas-mano tr > td:not(:nth-child(8))" , function() {
                //$("#tabla-ofertas-mano tr > td:not(:nth-child(8))").click(function() {
                loadOfertaDetalleManoInfo($(this).parent("tr").data("id"));
                $("#manoobra_add_model").modal('show');
            });
            $(document).on("click", "#tabla-ofertas-viajes tr > td:not(:nth-child(7))" , function() {
                //$("#tabla-ofertas-viajes tr > td:not(:nth-child(7))").click(function() {
                loadOfertaDetalleViajeInfo($(this).parent("tr").data("id"));
                $("#viajes_add_model").modal('show');
            });
            $(document).on("click", "#tabla-ofertas-otros tr > td:not(:nth-child(7))" , function() {
                //$("#tabla-ofertas-otros tr > td:not(:nth-child(7))").click(function() {
                loadOfertaDetalleOtrosInfo($(this).parent("tr").data("id"));
                $("#otros_add_model").modal('show');
            });
            
            $("#print-materiales").click(function() {
                loadContent("tabla-matOferta", "/erp/apps/ofertas/vistas/materiales-oferta.php?oferta_id=" + <? echo $_GET['id']; ?>);
                $("#matOferta_view_model").modal('show');
            });
            $("#print_matOferta").click(function() {
                window.open(
                    "printMatOferta.php?oferta_id=" + + <? echo $_GET['id']; ?>,
                    '_blank' 
                );
            });
            $("#add-pedidos").click(function() {
                $("#add_materialoferta_model").modal("show");
            });
            $(document).on("click", "#btn-add-pedidos" , function() {
            //$("#btn-add-pedidos").click(function() {
                $("#btn-add-pedidos").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                
                // Validación de requisitos
                // Llamada al modelo para la generación de los pedidos
                $.ajax({
                    type: "POST",  
                    url: "crearPedidosFromMaterial.php",  
                    data: {
                        oferta_id: <? echo $_GET['id']; ?>,
                        tecnico_id: <? echo $_SESSION["user_session"]; ?>,
                        ped_nom: $("#nom_pedidooferta").val()
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        $("#btn_add_posiciones").html('<img src="/erp/img/proveedores.png" height="20">');
                        //$("#pedidosMaterial_success").slideDown();
                        setTimeout(function(){
                            //$("#pedidosMaterial_success").fadeOut("slow");
                            //console.log(response[0].id);
                            if(response!=0){
                                window.open(
                                    "/erp/apps/material/editPedido.php?id=" + response,
                                    '_blank' 
                                );
                                $("#btn-add-pedidos").html('Crear Pedido');
                                $("#nom_pedidooferta").val("");
                                $("#add_materialoferta_model").modal("hide");
                                loadContent("dash-materiales", "/erp/apps/ofertas/vistas/oferta-materiales.php?id=" + <? echo $_GET['id']; ?>);
                                //window.location.reload();
                            }else{
                                window.location.reload();
                            }
                            // En vez de reload refrescar vista materiales:!!
                            
                        }, 1000);
                    }   
                });
            });
            $("#refresh-materiales").click(function() {
                loadContent("dash-materiales", "/erp/apps/ofertas/vistas/oferta-materiales.php?id=" + <? echo $_GET['id']; ?>);
            });
            $(document).on("click", "#add-ventamanoobra-topro" , function() {
                $("#confirm_ventamanoobra_model").modal("show");
            });
            $(document).on("click", "#confirm-ventamanoobra-topro" , function() {
            //$("#btn-add-pedidos").click(function() {
                $("#confirm-ventamanoobra-topro").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                
                // Validación de requisitos
                // Llamada al modelo para la generación de los pedidos
                $.ajax({
                    type: "POST",  
                    url: "crearDetallesOfertaAProyecto.php",  
                    data: {
                        manoobra_id: <? echo $_GET['id']; ?>
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        $("#btn_add_posiciones").html('<img src="/erp/img/proveedores.png" height="20">');
                        //$("#pedidosMaterial_success").slideDown();
                        setTimeout(function(){
                            //$("#pedidosMaterial_success").fadeOut("slow");
                            //console.log(response[0].id);
                            if(response!=0){
//                                window.open(
//                                    "/erp/apps/material/editPedido.php?id=" + response,
//                                    '_blank' 
//                                );
                                $("#confirm-ventamanoobra-topro").html('Añadir');
                                $("#confirm_ventamanoobra_model").modal("hide");
                                loadContent("dash-mano", "/erp/apps/ofertas/vistas/oferta-mano.php?id=" + <? echo $_GET['id']; ?>);
                                //window.location.reload();
                            }else{
                                window.location.reload();
                            }
                            // En vez de reload refrescar vista materiales:!!
                            
                        }, 1000);
                    }   
                });
            });
            $("#refresh-ventamanoobra").click(function() {
                loadContent("dash-mano", "/erp/apps/ofertas/vistas/oferta-mano.php?id=" + <? echo $_GET['id']; ?>);
            });
            $(document).on("click", "#add-costesubcontratas-topro" , function() {
                $("#confirm_costesubcontratas_model").modal("show");
            });
            $(document).on("click", "#confirm-costesubcontratas-topro" , function() {
            //$("#btn-add-pedidos").click(function() {
                $("#confirm-costesubcontratas-topro").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                
                // Validación de requisitos
                // Llamada al modelo para la generación de los pedidos
                $.ajax({
                    type: "POST",  
                    url: "crearDetallesOfertaAProyecto.php",  
                    data: {
                        subcon_id: <? echo $_GET['id']; ?>
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        //$("#btn_add_posiciones").html('<img src="/erp/img/proveedores.png" height="20">');
                        //$("#pedidosMaterial_success").slideDown();
                        setTimeout(function(){
                            //$("#pedidosMaterial_success").fadeOut("slow");
                            //console.log(response[0].id);
                            if(response!=0){
//                                window.open(
//                                    "/erp/apps/material/editPedido.php?id=" + response,
//                                    '_blank' 
//                                );
                                $("#confirm-costesubcontratas-topro").html('Añadir');
                                $("#confirm_costesubcontratas_model").modal("hide");
                                loadContent("dash-sub", "/erp/apps/ofertas/vistas/oferta-terceros.php?id=" + <? echo $_GET['id']; ?>);
                                loadContent("dash-venta", "/erp/apps/ofertas/vistas/oferta-pvp.php?id=" + <? echo $_GET['id']; ?>);
                                loadContent("dash-costes", "/erp/apps/ofertas/vistas/oferta-costes.php?id=" + <? echo $_GET['id']; ?>);
                                //window.location.reload();
                            }else{
                                window.location.reload();
                            }
                            // En vez de reload refrescar vista materiales:!!
                            
                        }, 1000);
                    }   
                });
            });
            $("#refresh-costesubcontratas").click(function() {
                loadContent("dash-sub", "/erp/apps/ofertas/vistas/oferta-terceros.php?id=" + <? echo $_GET['id']; ?>);
            });
            $(document).on("click", "#add-ventaviajes-topro" , function() {
                $("#confirm_costevieje_model").modal("show");
            });
            $(document).on("click", "#confirm-costevieje-topro" , function() {
            //$("#btn-add-pedidos").click(function() {
                $("#confirm-costevieje-topro").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                
                // Validación de requisitos
                // Llamada al modelo para la generación de los pedidos
                $.ajax({
                    type: "POST",  
                    url: "crearDetallesOfertaAProyecto.php",  
                    data: {
                        viajes_id: <? echo $_GET['id']; ?>
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        //$("#btn_add_posiciones").html('<img src="/erp/img/proveedores.png" height="20">');
                        //$("#pedidosMaterial_success").slideDown();
                        setTimeout(function(){
                            //$("#pedidosMaterial_success").fadeOut("slow");
                            //console.log(response[0].id);
                            if(response!=0){
//                                window.open(
//                                    "/erp/apps/material/editPedido.php?id=" + response,
//                                    '_blank' 
//                                );
                                $("#confirm-costevieje-topro").html('Añadir');
                                $("#confirm_costevieje_model").modal("hide");
                                loadContent("dash-viaje", "/erp/apps/ofertas/vistas/oferta-viajes.php?id=" + <? echo $_GET['id']; ?>);
                                //window.location.reload();
                            }else{
                                window.location.reload();
                            }
                            // En vez de reload refrescar vista materiales:!!
                            
                        }, 1000);
                    }   
                });
            });
            $("#refresh-ventaviajes").click(function() {
                loadContent("dash-viaje", "/erp/apps/ofertas/vistas/oferta-viajes.php?id=" + <? echo $_GET['id']; ?>);
            });
            $(document).on("click", "#add-ventaotros-topro" , function() {
                $("#confirm_costeotros_model").modal("show");
            });
            $(document).on("click", "#confirm-costeotros-topro" , function() {
            //$("#btn-add-pedidos").click(function() {
                $("#confirm-costeotros-topro").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                
                // Validación de requisitos
                // Llamada al modelo para la generación de los pedidos
                $.ajax({
                    type: "POST",  
                    url: "crearDetallesOfertaAProyecto.php",  
                    data: {
                        otros_id: <? echo $_GET['id']; ?>
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        //$("#btn_add_posiciones").html('<img src="/erp/img/proveedores.png" height="20">');
                        //$("#pedidosMaterial_success").slideDown();
                        setTimeout(function(){
                            //$("#pedidosMaterial_success").fadeOut("slow");
                            //console.log(response[0].id);
                            if(response!=0){
//                                window.open(
//                                    "/erp/apps/material/editPedido.php?id=" + response,
//                                    '_blank' 
//                                );
                                $("#confirm-costeotros-topro").html('Añadir');
                                $("#confirm_costeotros_model").modal("hide");
                                loadContent("dash-otros", "/erp/apps/ofertas/vistas/oferta-otros.php?id=" + <? echo $_GET['id']; ?>);
                                //window.location.reload();
                            }else{
                                window.location.reload();
                            }
                            // En vez de reload refrescar vista materiales:!!
                            
                        }, 1000);
                    }   
                });
            });
            $("#refresh-ventaotros").click(function() {
                loadContent("dash-otros", "/erp/apps/ofertas/vistas/oferta-otros.php?id=" + <? echo $_GET['id']; ?>);
            });
            $("#versiones_oferta").click(function() {
                $.ajax({
                    type: "POST",  
                    url: "vistas/ofertas-versiones-modal.php",  
                    data: {
                        oferta_id: <? echo $_GET['id']; ?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        $("#versionesoferta_model").html(response);
                        $('.selectpicker').selectpicker('refresh');
                        $("#versionesoferta_model").modal('show');
                        setTimeout(function(){
                            //window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $(document).on("click", "#btn_add_version_oferta" , function() {
                //console.log($(".cp_v_oferta").val());
                $("#btn_add_version_oferta").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" /> Generando Copia...');
                data = $("#frm_cp_oferta").serializeArray();
                console.log("datos:"+data);
                $.ajax({
                    type: "POST",  
                    url: "duplicateOferta.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //console.log(response);
                        $("#btn_add_version_oferta").html('Crear Copia');
                        setTimeout(function(){
                            window.open("/erp/apps/ofertas/editoferta.php?id="+response);
                            window.location.reload();
                        }, 1000);
                    }   
                });
            });
            $(document).on("click", "#btn_change_version_oferta" , function() {
                var valid=$(".selectpicker").val();
                window.location.href = "/erp/apps/ofertas/editoferta.php?id="+valid;
                //$("#ofertas_idoferta").val($(".selectpicker").val(valid));
            });
            $('.selectversion').on('changed.bs.select', function (e) {
                window.location.href = "/erp/apps/ofertas/editoferta.php?id="+$(this).val();
            });
            $("#delete_oferta").click(function() {
                //$("del_versionoferta_id").val(<? echo $_GET['id']; ?>);
                $("#delete_versiones_model").modal('show');
            });
            $(document).on("click", "#btn_del_versionoferta_id" , function() {
            //$("#del_versionoferta_id").click(function() {
                //$("#add-pedidos").html('<img src="/erp/img/btn-ajax-loader.gif" height="20" />');
                // Validación de requisitos
                // Llamada al modelo para la generación de los pedidos
                $.ajax({
                    type: "POST",  
                    url: "saveOferta.php",  
                    data: {
                        oferta_deloferta: <? echo $_GET['id']; ?>
                    },
                    dataType: "json",       
                    success: function(response)  
                    {
                        //$("#btn_add_posiciones").html('<img src="/erp/img/proveedores.png" height="20">');
                        //$("#pedidosMaterial_success").slideDown();
                        setTimeout(function(){
                            //$("#pedidosMaterial_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.href = "/erp/apps/ofertas";
                        }, 1000);
                    }   
                });
            });
            // CARGA DEL ARBOL DE DOCUMENTOS
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

                function initTree(treeData, treeElement) {
                    //console.log(treeData);
                    $('#' + treeElement).treeview({
                        data: treeData,
                        enableLinks: true,
                        state: {
                            checked: true,
                            disabled: true,
                            expanded: true,
                            selected: true
                        },
                    });
                }
            
            
        });
	
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>
<style>
    #ofertas_versiones > div > button{
        width: 50%;
    }
</style>
<title id="titulo3">Agregar Oferta | Erp GENELEK</title>
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
            <h5><a href="/erp/apps/ofertas/">Ofertas</a> > <span id="current-page3"></span></h5>
        </div>
        <div id="erp-titulo" class="one-column">
            <h3 id="oferta-title3">
                OFERTA xxxx
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-datosgenerales-add" class="three-column" style="min-height: 370px;">
                <h4 class="dash-title">
                    <? include($pathraiz."/apps/ofertas/includes/tools-single-oferta.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/oferta-datosgenerales.php"); 
                ?>
            </div>
            <div id="dash-grafico-costes" class="three-column box-info" style="min-height: 370px;">
                <h4 class="dash-title">
                    GRÁFICO PRESUPUESTARIO
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/oferta-grafico.php"); 
                ?>
            </div>
            <div id="dash-resumen-ventas" class="three-column box-info" style="background-color: transparent; min-height: 370px;">
                <div id="dash-coste-add" class="one-column box-info">
                    <h4 class="dash-title">
                        COSTES
                    </h4>
                    <hr class="dash-underline">
                    <div id="dash-costes">
                    <? 
                        $fechamod = 1;
                        //include("vistas/oferta-costes.php"); 
                    ?>
                    </div>
                </div>
                
                <div id="dash-pvp-add" class="one-column box-info">
                    <h4 class="dash-title">
                        VENTA
                    </h4>
                    <hr class="dash-underline">
                    <div id="dash-venta">
                    <? 
                        $fechamod = 1;
                        //include("vistas/oferta-pvp.php"); 
                    ?>
                    </div>
                </div>
            </div>
            
            <span class="stretch"></span>
            
            <div id="dash-materiales-add" class="two-column">
                <h4 class="dash-title">
                    MATERIALES
                    <? include($pathraiz."/apps/ofertas/includes/tools-coste-materiales.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-materiales">
                <? 
                    $fechamod = 1;
                    //include("vistas/oferta-materiales.php"); 
                ?>
                </div>
            </div>
            <div id="dash-subcontrata-add" class="two-column">
                <h4 class="dash-title">
                    SUBCONTRATACIONES
                    <? include($pathraiz."/apps/ofertas/includes/tools-coste-subcontratas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-sub">
                <? 
                    $fechamod = 1;
                    //include("vistas/oferta-terceros.php"); 
                ?>
                </div>
            </div>
            <span class="stretch"></span>
                        
            <div id="dash-venta-add" class="two-column">
                <h4 class="dash-title">
                    MANO DE OBRA
                    <? include($pathraiz."/apps/ofertas/includes/tools-venta-manoobra.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-mano">
                <? 
                    $fechamod = 1;
                    //include("vistas/oferta-mano.php");  
                ?>
                </div>
            </div>
            <div id="dash-venta-add" class="two-column">
                <h4 class="dash-title">
                    VIAJES/DESPLAZAMIENTOS
                    <? include($pathraiz."/apps/ofertas/includes/tools-venta-viajes.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-viaje">
                <? 
                    $fechamod = 1;
                    //include("vistas/oferta-viajes.php"); 
                ?>
                </div>
            </div>
            <span class="stretch"></span>
            
            <div id="dash-otros-add" class="two-column">
                <h4 class="dash-title">
                    OTROS
                    <? include($pathraiz."/apps/ofertas/includes/tools-venta-otros.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-otros">
                <? 
                    $fechamod = 1;
                    //include("vistas/oferta-otros.php"); 
                ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="dash-venta-add" class="one-column">
                <h4 class="dash-title">
                    DOCUMENTACIÓN ADJUNTA
                    <? include($pathraiz."/apps/ofertas/includes/tools-venta-doc.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="treeview_json">
                    <? //include($pathraiz."/apps/material/vistas/pedido-documentos.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>
</body>
</html>