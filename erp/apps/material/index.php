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
            
            $("#menuitem-pedidos").addClass("active");
            
            loadSelectYears("filter_pedidos_years","PEDIDOS_PROV","fecha","","");
            loadSelect("filter_proveedores","PROVEEDORES","id","","");
            loadSelect("filter_pedidos","PEDIDOS_PROV","id","","","pedido_genelek");
            loadSelect("filter_estados","PEDIDOS_PROV_ESTADOS","id","","","");
            loadSelect("filter_proyectos","PROYECTOS","id","","","ref");
            loadSelect("filter_clientes","CLIENTES","id","","","");
            //loadSelect("filter_entregas","ENTREGAS","id","","","");
            loadSelect("newpedido_clientes","CLIENTES","id","","","");
            loadSelect("newpedido_proyectos","PROYECTOS","id","","","ref");
            loadSelect("newpedido_proveedores","PROVEEDORES","id","","","");
            loadSelect("newpedido_formaspago","FORMAS_PAGO","id","","","");
            loadSelect("newpedido_estados","PEDIDOS_PROV_ESTADOS","id","","","");
            loadSelect("newpedido_tecnicos","erp_users","id","","","apellidos");
            loadSelect("cmbproveedores_proveedores","PROVEEDORES","id","","","");
            loadSelect("materiales_categoria1","MATERIALES_CATEGORIAS","id","parent_id",0);
            loadSelect("categorias_categorias","MATERIALES_CATEGORIAS","id","","","parent_id");
            loadSelect("categorias_categoriasparent","MATERIALES_CATEGORIAS","id","","");
            loadSelect("tarifaedit_proveedor","PROVEEDORES","id","","");
            loadSelect("newtarifa_proveedor","PROVEEDORES","id","","");
            
            matid = "<? echo $_GET['matid']; ?>";
            matid2 = "<? echo $_GET['matid']; ?>";
            
            if ((matid != "") && (matid != "undefined")){
                matid = "matid=" + matid;
                year = "";
                $("#export_excel_ped_mat_tot").show(); // Mostrar Exportar Pedidos Material
                $("#export_excel_ped_mat_nrec").show(); // Mostrar Exportar Pedidos Material
            }else{
                matid = "";
                year = "<? echo date("Y"); ?>";
                $("#export_excel_ped_mat_tot").hide(); // Ocultar Exportar Pedidos Material
                $("#export_excel_ped_mat_nrec").hide(); // Ocultar Exportar Pedidos Material
            }
            
            setTimeout(function(){
                $("#newpedido_tecnicos").selectpicker("val", "<? echo $_SESSION['user_session']; ?>");
                $("#filter_pedidos_years").selectpicker("val", year);
                $("#filter_pedidos_years").parent().children("button").addClass("filter-selected");
            }, 2000);
            
            $('input[name="filter_chkrecibido"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            loadContent("dash-gastos-material", "/erp/apps/proyectos/vistas/proyectos-gastos.php?year=" + year);
            loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?year=" + year + "&" + matid);
            
            $(document).on("click", ".page-link" , function() {
                loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?pag=" + $(this).data("pag") + "&year=" + $(this).data("year") + "&month=" + $(this).data("month") + "&prov=" + $(this).data("prov") + "&estado=" + $(this).data("estado") + "&" + matid + "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $('#filter_clientes').val());
            });
            
            $('#refresh-pedidos').click(function () {
               loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?year=" + $('#filter_pedidos_years').val() + "&month=" + $('#filter_pedidos_mes').val() + "&prov=" + $('#filter_proveedores').val() + "&estado=" + $('#filter_estados').val() + "&" + matid + "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $('#filter_clientes').val());
            });
            
            $('#clean-filters').click(function () {
               loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?" + matid);
               $("#filter_pedidos").selectpicker("val", "");
               $("#filter_proveedores").selectpicker("val", "");
               $("#filter_estados").selectpicker("val", "");
               $("#filter_pedidos_years").selectpicker("val", "");
               $("#filter_pedidos_mes").selectpicker("val", "");
               $("#filter_proyectos").selectpicker("val", "");
               $("#filter_clientes").selectpicker("val", "");
               $("#filter_pedidos").parent().children("button").removeClass("filter-selected");
               $("#filter_estados").parent().children("button").removeClass("filter-selected");
               $("#filter_proveedores").parent().children("button").removeClass("filter-selected");
               $("#filter_pedidos_years").parent().children("button").removeClass("filter-selected");
               $("#filter_pedidos_mes").parent().children("button").removeClass("filter-selected");
               $("#filter_proyectos").parent().children("button").removeClass("filter-selected");
               $("#filter_clientes").parent().children("button").removeClass("filter-selected");
               $("#print-mat-prov").hide();
            });
            
            $('#filter_pedidos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                location.href = "/erp/apps/material/editPedido.php?id=" + $(this).val();
            });
            // Al cambiar los filtros //
            $('#filter_proveedores').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?year=" + $('#filter_pedidos_years').val() + "&month=" + $('#filter_pedidos_mes').val() + "&prov=" + $(this).val() + "&estado=" + $('#filter_estados').val() + "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $('#filter_clientes').val());
                $("#print-mat-prov").show();
                $("#export_excel_ped_mat_tot").hide();
                $("#export_excel_ped_mat_nrec").hide();
                //location.href = "/erp/apps/material/?prov=" + $(this).val() + "&year=" + $('#filter_pedidos_years').val() + "&month=" + $('#filter_pedidos_mes').val();
            }); 
            $('#filter_estados').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?year=" + $('#filter_pedidos_years').val() + "&month=" + $('#filter_pedidos_mes').val() + "&prov=" + $('#filter_proveedores').val() + "&estado=" + $(this).val() + "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $('#filter_clientes').val());
                //location.href = "/erp/apps/material/?prov=" + $('#filter_proveedores').val() + "&year=" + $('#filter_pedidos_years').val() + "&month=" + $('#filter_pedidos_mes').val() + "&estado=" + $(this).val();
            });
            $('#filter_pedidos_years').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?year=" + $(this).val() + "&month=" + $('#filter_pedidos_mes').val() + "&prov=" + $('#filter_proveedores').val() + "&estado=" + $('#filter_estados').val() + "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $('#filter_clientes').val());
            });
            $('#filter_pedidos_mes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?year=" + $('#filter_pedidos_years').val() + "&month=" + $(this).val() + "&prov=" + $('#filter_proveedores').val() + "&estado=" + $('#filter_estados').val() + "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $('#filter_clientes').val());
            });
            $('#filter_proyectos').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?year=" + $('#filter_pedidos_years').val() + "&month=" + $('#filter_pedidos_mes').val() + "&prov=" + $('#filter_proveedores').val() + "&estado=" + $('#filter_estados').val() + "&proyecto=" + $(this).val()+ "&cliente=" + $('#filter_clientes').val());
            });
            $('#filter_clientes').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("dash-pedidos", "/erp/apps/material/vistas/material-home.php?year=" + $('#filter_pedidos_years').val() + "&month=" + $('#filter_pedidos_mes').val() + "&prov=" + $('#filter_proveedores').val() + "&estado=" + $('#filter_estados').val() + "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $(this).val());
            });
            // Filtro pedido por proveedor. Recibido.
            $('#select_recibido').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                loadContent("tabla-matProveedor", "/erp/apps/material/vistas/material-proveedores.php?proveedor_id=" + $("#filter_proveedores").val() + "&year=" + $("#filter_pedidos_years").val() + "&month=" + $("#filter_pedidos_mes").val() + "&estado=" + $("#filter_estados").val() + "&recibido=" + $("#select_recibido").val());
            });
            
            $('#refresh_proyectos').click(function () {
                $('#tabla-proyectos').fadeOut('slow', function(){
                    $('#tabla-proyectos').load('/erp/vistas/proyectos-activos.php', function(){
                        $('#tabla-proyectos').fadeIn('slow');
                    });
                });
            });
            
            $(document).on("click", "#tabla-pedidos > tbody tr" , function() {
                window.open(
                    "editPedido.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            $(document).on("click", "#tabla-pedidos-ultimos > tbody tr" , function() {
                window.open(
                    "editPedido.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            $(document).on("click", "#tabla-pedidos-fueraplazo > tbody tr" , function() {
                window.open(
                    "editPedido.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            
            $("#add-pedido").click(function() {
                $("#addpedido_model").modal('show');
            });
            $("#add-proveedor").click(function() {
                $("#addproveedor_model").modal('show');
            });
            $("#add-material").click(function() {
                clearMaterial();
                $("#addmaterial_model").modal('show');
            });
            $("#btn_add_categoria").click(function() {
                $("#addcategoria_model").modal('show');
            });
            $("#print-mat-prov").click(function() {
                if ($("#filter_proveedores").val() != "") {
                    loadContent("tabla-matProveedor", "/erp/apps/material/vistas/material-proveedores.php?proveedor_id=" + $("#filter_proveedores").val() + "&year=" + $("#filter_pedidos_years").val() + "&month=" + $("#filter_pedidos_mes").val() + "&estado=" + $("#filter_estados").val()+ "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $('#filter_clientes').val());
                    $("#matProv_view_model").modal('show');
                }else{
                    alert("Revisar si el proveedor esta seleccionado.");
                }
            });
            // Imprimir material pedido por proveedor en PDF
            $("#print_matProveedor").click(function() {
                var recibido;
                if($("#select_recibido").val()==""){
                    recibido="";
                }else{
                    if($("#select_recibido").val()=="1"){
                        recibido="1";
                    }else{
                        recibido="0";
                    }
                }
                window.open(
                    "printMatProveedor.php?proveedor_id=" + $("#filter_proveedores").val() + "&year=" + $("#filter_pedidos_years").val() + "&month=" + $("#filter_pedidos_mes").val() + "&estado=" + $("#filter_estados").val() + "&recibido=" + recibido + "&proyecto=" + $('#filter_proyectos').val()+ "&cliente=" + $('#filter_clientes').val(),
                    '_blank' 
                );
            });
            // Imprimir material pedido por proveedor en EXCEL
            $(document).on("click", "#printExcel_matProveedor" , function() {
                var recibido;
                if($("#select_recibido").val()==""){
                    recibido="";
                }else{
                    if($("#select_recibido").val()=="1"){
                        recibido="1";
                    }else{
                        recibido="0";
                    }
                }
                $.ajax({
                    type : 'GET',
                    url : 'expExcelPedxProv.php',
                    dataType : 'text',
                    data: {
                        proveedor_id: $("#filter_proveedores").val(),
                        year: $("#filter_pedidos_years").val(),
                        month: $("#filter_pedidos_mes").val(),
                        estado: $("#filter_estados").val(),
                        proyecto: $("#filter_proyectos").val(),
                        cliente: $("#filter_clientes").val(),
                        recibido: recibido
                    },
                    success : function(response){
                        //alert(data);
                        //window.location.reload();
                        console.log ("Respuesta: "+response);
                        window.open(response);
                        //window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            
            function clearMaterial() {
                $("#newmaterial_idmaterial").val("");
                $("#material_del").val("");
                $("#material_categoria_id").val("");
                $("#materiales_categoria1").val("");
                $("#materiales_categoria1").selectpicker("refresh");
                $("#materiales_categoria2").selectpicker("destroy");
                $("#materiales_categoria2").parent(".form-group").remove();
                $("#newmaterial_materiales").val("");
                $("#newmaterial_materiales").selectpicker("refresh");
                $('#frm_new_material').trigger("reset");
            };
            
            $("#btn_save_pedido").click(function() {
                // Validar el formulario antes de guardar
                if (validateForm() == 1) {
                    //error de validacion
                    $("#newpedido_error").slideDown();
                    setTimeout(function(){
                        $("#newpedido_error").fadeOut("slow");
                    }, 2000);
                }
                else {
                    $("#btn_save_pedido").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                    data = $("#frm_new_pedido").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "savePedido.php",  
                        data: data,
                        dataType: "json",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_pedido').trigger("reset");
                            refreshSelects();
                            $("#btn_save_pedido").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#newpedido_success").slideDown();
                            setTimeout(function(){
                                $("#newpedido_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.href = "editPedido.php?id=" + response[0].id;
                            }, 1000);
                        }   
                    });
                };
            });
            
            // PROVEEDORES
                $('#cmbproveedores_proveedores').on('changed.bs.select', function (e) {
                    loadProveedorInfo($(this).val(), "PROVEEDORES");
                    loadGridDto($(this).val()); //cargo el grid de las terifas 
                });
                $("#btn_save_proveedor").click(function() {
                    $("#btn_save_proveedor").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                    data = $("#frm_new_proveedor").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveProveedor.php",  
                        data: data,
                        dataType: "text",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_proveedor').trigger("reset");
                            $("#btn_save_proveedor").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#newproveedor_success").slideDown();
                            setTimeout(function(){
                                $("#newproveedor_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.reload();
                            }, 2000);
                        }   
                    });
                });
                $("#btn_del_proveedor").click(function() {
                    $("#btn_del_proveedor").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                    $("#proveedor_del").val($("#newproveedor_idproveedor").val());
                    data = $("#frm_new_proveedor").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveProveedor.php",  
                        data: data,
                        dataType: "json",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_proveedor').trigger("reset");
                            $("#btn_del_proveedor").html('<span class="glyphicon glyphicon-floppy-disk"></span> Eliminar');
                            $("#newproveedor_success").slideDown();
                            setTimeout(function(){
                                $("#newproveedor_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.reload();
                            }, 2000);
                        }   
                    });
                });
            // /PROVEEDORES
            
            // MATERIALES
                // MODAL DE CATEGORIAS
                $("#categorias_categorias").on("changed.bs.select", function (e) { 
                    $("#newcategoria_idcategoria").val($(this).val());
                    var selectedText = $(this).find("option:selected").text();
                    var selectedParent = $(this).find("option:selected").data("parent");
                    
                    $("#categorias_nombre").val(selectedText);
                    $("#group-parentcat").show();
                    $("#categorias_categoriasparent").val(selectedParent);
                    $("#categorias_categoriasparent").selectpicker("refresh");
                    $("#categorias_categoriasparent").selectpicker("render");
                });
                // /MODAL DE CATEGORIAS
                
                $("select.materiales_categorias").on("changed.bs.select", function (e) { 
                    var numCat = $("select.materiales_categorias").length + 1;
                    console.log("num elementos " + numCat);
                    for (i = 1; i < numCat; i++) {
                        if (i != 1) {
                            console.log("delete " + numCat);
                            $("#materiales_categoria" + i).selectpicker("destroy");
                            $("#materiales_categoria" + i).closest(".form-group").remove();
                        }
                    }

                    var numCat = $("select.materiales_categorias").length + 1;
                    var htmlElement = "<div class='form-group'><label class='labelBeforeBlack'></label><select id='materiales_categoria" + numCat + "' name='materiales_categoria" + numCat + "' class='selectpicker materiales_categorias' data-live-search='true' data-width='33%'><option></option></select></div>"
                    $("select.materiales_categorias").last().closest(".form-group").after(htmlElement);

                    loadSelect("materiales_categoria" + numCat,"MATERIALES_CATEGORIAS","id","parent_id",$(this).val());
                    $("#material_categoria_id").val($(this).val()); // Guardo el id de la ultima categoria seleccionada para guardarlo cuando se guarde el material nuevo o existente
                    $("#materiales_categoria" + numCat).selectpicker();
                    $("#materiales_categoria" + numCat).selectpicker('refresh');
                });
                $("body").on('change',"select.materiales_categorias", function(){
                    //alert("ok");  
                    loadSelect("newmaterial_materiales","MATERIALES","id","categoria_id",$(this).val(),"");
                    $("#material_categoria_id").val($(this).val()); // Guardo el id de la ultima categoria seleccionada para guardarlo cuando se guarde el material nuevo o existente
                });
                $("#newmaterial_materiales").on("changed.bs.select", function (e) {
                    loadMaterialesMaterialInfo($(this).val(), "MATERIALES");
                    setTimeout(function(){
                        console.log("MATERIAL ID: " + $("#newmaterial_idmaterial").val());
                        loadGrid($("#newmaterial_idmaterial").val()); //cargo el grid de las terifas 
                    }, 2000);
                });
                
                $('#newpedido_proyectos').on('changed.bs.select', function (e) {
                    loadSelect("newpedido_entregas","ENTREGAS","id","proyecto_id",$(this).val());
                });
                
                $("#btn_save_categoria").click(function() {
                    $("#btn_save_categoria").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                    data = $("#frm_new_categoria").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveCategoria.php",  
                        data: data,
                        dataType: "text",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_categoria').trigger("reset");
                            $("#btn_save_categoria").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#categorias_success").slideDown();
                            setTimeout(function(){
                                $("#categorias_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.reload();
                            }, 2000);
                        }   
                    });
                });
                
                $("#btn_save_material").click(function() {
                    $("#btn_save_material").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                    data = $("#frm_new_material").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveMaterial.php",  
                        data: data,
                        dataType: "json",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_material').trigger("reset");
                            $("#btn_save_material").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#newmaterial_success").slideDown();
                            setTimeout(function(){
                                $("#newmaterial_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.reload();
                            }, 2000);
                        }   
                    });
                });
                
                $( "#btn_tarifas" ).click(function() {
                    $("#tarifas_modal").modal("show");
                });  
                
                function ajaxAction(action) {
                    data = $("#frm_"+action).serializeArray();
                    //console.log(data);
                    $.ajax({
                        type: "POST",  
                        url: "responsetarifas.php",  
                        data: data,
                        dataType: "json",       
                        success: function(response)  
                        {
                            //alert (response);
                            //console.log(response);

                            $('#'+action+'_modal').modal('hide');
                            $("#tarifas_grid").bootgrid('reload');
                            $('#frm_add').trigger("reset");
                            $('#frm_edit').trigger("reset");
                        }   
                    });
                }
                
                $("#btn_descuentos" ).click(function() {
                    $("#dto_modal").modal("show");
                });
                
                function ajaxActionDto(action) {
                    data = $("#frm_"+action+"_dto").serializeArray();
                    //console.log(data);
                    $.ajax({
                        type: "POST",  
                        url: "responsedto.php",  
                        data: data,
                        dataType: "json",       
                        success: function(response)  
                        {
                            //alert (response);
                            //console.log(response);

                            $('#'+action+'_dto_modal').modal('hide');
                            $("#dto_grid").bootgrid('reload');
                            $('#frm_add_dto').trigger("reset");
                            $('#frm_edit_dto').trigger("reset");
                        }   
                    });
                }
                
                $( "#btn_edit_tarifa" ).click(function() {
                    ajaxAction('edit');
                });
                $( "#btn_new_tarifa" ).click(function() {
                    ajaxAction('add');
                });
                $( "#command-add" ).click(function() {
                    $("#newtarifa_materialid").val($("#newmaterial_idmaterial").val());
                    $('#add_modal').modal('show');
                });
                $( "#btn_edit_dto" ).click(function() {
                    ajaxActionDto('edit');
                });
                $( "#btn_new_dto" ).click(function() {
                    ajaxActionDto('add');
                });
                $( "#command-add-dto" ).click(function() {
                    $("#newdto_proveedorid").val($("#newproveedor_idproveedor").val());
                    $('#add_dto_modal').modal('show');
                });
            // /MATERIALES
                
                $("#btn_del_material").click(function() {
                    $("#btn_del_material").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                    $("#material_del").val($("#newmaterial_idmaterial").val());
                    data = $("#frm_new_material").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveMaterial.php",  
                        data: data,
                        dataType: "json",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_material').trigger("reset");
                            $("#btn_del_material").html('<span class="glyphicon glyphicon-floppy-disk"></span> Eliminar');
                            $("#newmaterial_success").slideDown();
                            setTimeout(function(){
                                $("#newmaterial_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.reload();
                            }, 2000);
                        }   
                    });
                });
            // /MATERIALES
            
            // Exportar Pedidos Material
                        
            $(document).on("click", "#export_excel_ped_mat_nrec" , function() {
                //console.log("aaaa4: "+matid2);
                $.ajax({
                    type : 'GET',
                    url : 'expExcelPedMatNRec.php',
                    dataType : 'text',
                    data: {
                        matid : matid2
                    },
                    success : function(response){
                        //alert(data);
                        //window.location.reload();
                        console.log ("Respuesta: "+response);
                        window.open(response);
                        //window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", "#export_excel_ped_mat_tot" , function() {
                //console.log("aaaa4: "+matid2);
                $.ajax({
                    type : 'GET',
                    url : 'expExcelPedMatTot2.php',
                    dataType : 'text',
                    data: {
                        matid : matid2
                    },
                    success : function(response){
                        //alert(data);
                        //window.location.reload();
                        console.log ("Respuesta: "+response);
                        window.open(response);
                        //window.open(response);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
                    
            
            // / Exportar Pedidos Material
            
            
            
	});
	
        function delTar (id) {
            var r = confirm("¿Está seguro de que desea eliminar la tarifa?");
            if (r == true) {
                $.post('responsetarifas.php', { id: id, action:'delete'}
                    , function(){
                        // when ajax returns (callback), 
                        $("#tarifas_grid").bootgrid('reload');
                }); 
            }
        }
        
        function delDto (id) {
            var r = confirm("¿Está seguro de que desea eliminar el descuento?");
            if (r == true) {
                $.post('responsedto.php', { id: id, action:'delete'}
                    , function(){
                        // when ajax returns (callback), 
                        $("#dto_grid").bootgrid('reload');
                }); 
            }
        }

        function loadGrid (material_id) {
            $("#tarifas_grid").bootgrid('destroy');
            $("#command-add").prop("disabled", false);

            var grid = $("#tarifas_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function ()
                {
                        /* To accumulate custom parameter with the request object */
                        return {
                                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                        };
                },

                url: "responsetarifas.php?material_id=" + material_id,
                data: { 
                        material_id: material_id
                      } ,
                formatters: {
                    "commands": function(column, row)
                    {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
                            "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function()
            {
                /* Executes after data is loaded and rendered */
                //$("#command-download").prop("disabled", false);

                grid.find(".command-edit").on("click", function(e)
                {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();

                    //console.log(grid.data());//
                    $('#edit_modal').modal('show');

                    if($(this).data("row-id") >0) {
                        // collect the data
                        $('#edit_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#tarifaedit_fechaval').val(ele.siblings(':nth-of-type(3)').html().replace(/&nbsp;/gi,''));
                        $('#tarifaedit_tarifa').val(ele.siblings(':nth-of-type(4)').html().replace(/&nbsp;/gi,''));
                        $('#tarifaedit_dto').val(ele.siblings(':nth-of-type(5)').html().replace(/&nbsp;/gi,''));
                        $('#tarifaedit_proveedor').val(ele.siblings(':nth-of-type(6)').html().replace(/&nbsp;/gi,''));
                        $("#tarifaedit_proveedor").selectpicker("refresh");
                        $("#tarifaedit_proveedor").selectpicker("render");
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                }).end().find(".command-delete").on("click", function(e)
                {
                    //var conf = confirm('Delete ' + $(this).data("row-id") + ' items?');
                    //alert(conf);
                    //alert($(this).data("row-id"));
                    //$("#confirm-delete").modal("show");
                    //$('#confirm-delete').attr("data-insid",$(this).data("row-id"));
                    delTar($(this).data("row-id"));
                    //if(conf){
                        //$.post('response.php', { id: $(this).data("row-id"), action:'delete'}
                            //, function(){
                                // when ajax returns (callback), 
                                //$("#employee_grid").bootgrid('reload');
                        //}); 
                        //$(this).parent('tr').remove();
                        //$("#employee_grid").bootgrid('remove', $(this).data("row-id"))
                    //}
                });
            });
            //$("#employee_grid").bootgrid('reload');		
        };
        
        function loadGridDto (proveedor_id) {
            $("#dto_grid").bootgrid('destroy');
            $("#command-add-dto").prop("disabled", false);

            var grid = $("#dto_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function ()
                {
                        /* To accumulate custom parameter with the request object */
                        return {
                                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                        };
                },

                url: "responsedto.php?proveedor_id=" + proveedor_id,
                data: { 
                        proveedor_id: proveedor_id
                      } ,
                formatters: {
                    "commands": function(column, row)
                    {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
                            "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function()
            {
                /* Executes after data is loaded and rendered */
                //$("#command-download").prop("disabled", false);

                grid.find(".command-edit").on("click", function(e)
                {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();

                    //console.log(grid.data());//
                    $('#edit_dto_modal').modal('show');

                    if($(this).data("row-id") >0) {
                        // collect the data
                        $('#edit_dto_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#dtoedit_fechaval').val(ele.siblings(':nth-of-type(2)').html().replace(/&nbsp;/gi,''));
                        $('#dtoedit_dto').val(ele.siblings(':nth-of-type(3)').html().replace(/&nbsp;/gi,''));
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                }).end().find(".command-delete").on("click", function(e)
                {
                    //var conf = confirm('Delete ' + $(this).data("row-id") + ' items?');
                    //alert(conf);
                    //alert($(this).data("row-id"));
                    //$("#confirm-delete").modal("show");
                    //$('#confirm-delete').attr("data-insid",$(this).data("row-id"));
                    delDto($(this).data("row-id"));
                    //if(conf){
                        //$.post('response.php', { id: $(this).data("row-id"), action:'delete'}
                            //, function(){
                                // when ajax returns (callback), 
                                //$("#employee_grid").bootgrid('reload');
                        //}); 
                        //$(this).parent('tr').remove();
                        //$("#employee_grid").bootgrid('remove', $(this).data("row-id"))
                    //}
                });
            });
            //$("#employee_grid").bootgrid('reload');		
        };
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>Pedidos | Erp GENELEK</title>
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
                Pedidos de Material
            </h3>
        </div>
        <div id="dash-header">
            <div id="dash-numproyectos" class="three-column">
                <h4 class="dash-title">
                    GASTOS MATERIAL
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="dash-gastos-material">
                    <? 
                        //include($pathraiz."/apps/proyectos/vistas/proyectos-gastos.php");
                    ?>
                </div>
            </div>
            <div id="dash-ofertfactu" class="three-column">
                <h4 class="dash-title">
                    ÚLTIMOS ARTÍCULOS RECIBIDOS
                </h4>
                <hr class="dash-underline">
                <div id="dash-pedidos-ultimos">
                    <? 
                        include("vistas/material-ultimos.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-filtros" class="three-column">
                <h4 class="dash-title">
                    ARTÍCULOS FUERA DE PLAZO
                </h4>
                <hr class="dash-underline">
                <div id="dash-pedidos-fuera">
                    <? 
                        include("vistas/material-fuera-plazo.php"); 
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
            <div id="proyectos-filterbar" class="one-column">
                <? include($pathraiz."/apps/material/vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="one-column">
                <h4 class="dash-title">
                    PEDIDOS DE MATERIAL
                    <? include($pathraiz."/apps/material/includes/tools-pedidos.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="dash-pedidos">
                    <? 
                        $fechamod = 1;
                        //include("vistas/material-home.php"); 
                    ?>
                </div>
            </div>
            <!--
            <div id="dash-aside" class="four-column">
                <div id="dash-alertas" class="one-column">
                    <h4 class="dash-title">
                        ALERTAS
                    </h4>
                    <hr class="dash-underline">
                    <? //include($pathraiz."/apps/material/vistas/alertas.php"); ?>
                </div>
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        ACTIVIDAD
                    </h4>
                    <hr class="dash-underline">
                    <? //include($pathraiz."/vistas/erp-actividad.php"); ?>
                </div>
            </div>
            -->
            <span class="stretch"></span>
        </div>
        
        
    </section>
	
</body>
</html>