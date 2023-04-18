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

            $("#menuitem-envios").addClass("active");
            
            loadSelectYears("filter_envios_years","ENVIOS_CLI","fecha","","");
            loadSelect("filter_clientes","CLIENTES","id","","");
            loadSelect("filter_envios","ENVIOS_CLI","id","","","ref");
            loadSelect("filter_estados","ENVIOS_CLI_ESTADOS","id","","","");
            //loadSelect("filter_proyectos","PROYECTOS","id","","","");
            //loadSelect("filter_entregas","ENTREGAS","id","","","");
            loadSelect("newenvio_proyectos","PROYECTOS","id","","","ref");
            loadSelect("newenvio_ofertas_gen","OFERTAS","id","","","ref");
            loadSelect("newenvio_clientes","CLIENTES","id","","","");
            loadSelect("newenvio_proveedores","PROVEEDORES","id","","","");
            loadSelect("newenvio_transportistas","TRANSPORTISTAS","id","","","");
            loadSelect("newenvio_estados","PEDIDOS_PROV_ESTADOS","id","","","");
            loadSelect("newenvio_tecnicos","erp_users","id","","","apellidos");
            loadSelect("newenvio_tipo","ENVIOS_CLI_TIPOS","id","","","");
                        
            setTimeout(function(){
                $("#newenvio_tecnicos").selectpicker("val", "<? echo $_SESSION['user_session']; ?>");
            }, 2000);
            
            year = "<? echo $_GET['year']; ?>";
            month = "<? echo $_GET['month']; ?>";
            cli = "<? echo $_GET['prov']; ?>";
            matid = "<? echo $_GET['matid']; ?>";
            if (year != "") {
                setTimeout(function(){
                    $("#filter_envios_years").selectpicker("val", "<? echo $_GET['year']; ?>");
                }, 2000);
            }
            if (cli != "") {
                setTimeout(function(){
                    $("#filter_clientes").selectpicker("val", "<? echo $_GET['cli']; ?>");
                    
                }, 2000);
            }
            if (month != "") {
                $("#filter_envios_mes").selectpicker("val", "<? echo $_GET['month']; ?>");
            }
            
            <?
                $criteriaLink = "";
                if ($_GET['year'] != "") {
                    $criteriaLink = "?year=".$_GET['year'];
                }
                else {
                    $criteriaLink = "?year=".date("Y");
                    $criteriaLink = "?year=";
                }
                if ($_GET['cli'] != "") {
                    $criteriaLink .= "&cli=".$_GET['cli'];
                }
                if ($_GET['pag']) {
                    $criteriaLink .= "&pag=".$_GET['pag'];
                }
                if ($_GET['estado'] != "") {
                    $criteriaLink .= "&estado=".$_GET['estado'];
                }
                if ($_GET['matid'] != "") {
                    $criteriaLink .= "&matid=".$_GET['matid'];
                }
            ?>
            
            loadContent("dash-gastos-material", "/erp/apps/proyectos/vistas/proyectos-gastos.php?year=<? echo $_GET['year']; ?>");
            loadContent("dash-envios", "/erp/apps/envios/vistas/envios-home.php<? echo $criteriaLink; ?>");
            
            $('#refresh-envios').click(function () {
               loadContent("dash-envios", "/erp/apps/envios/vistas/envios-home.php");
            });
            
            $('#filter_envios').on('changed.bs.select', function (e) {
                $(this).parent().children("button").addClass("filter-selected");
                location.href = "/erp/apps/material/editPedido.php?id=" + $(this).val();
            });
            
            $('#filter_proveedores').on('changed.bs.select', function (e) {
                location.href = "/erp/apps/material/?prov=" + $(this).val() + "&year=" + $('#filter_envios_years').val() + "&month=" + $('#filter_envios_mes').val();
            }); 
            $('#filter_estados').on('changed.bs.select', function (e) {
                location.href = "/erp/apps/material/?prov=" + $('#filter_proveedores').val() + "&year=" + $('#filter_envios_years').val() + "&month=" + $('#filter_envios_mes').val() + "&estado=" + $(this).val();
            });
            $('#filter_envios_years').on('changed.bs.select', function (e) {
                location.href = "/erp/apps/material/?year=" + $(this).val() + "&prov=" +  $('#filter_proveedores').val();
            });
            $('#filter_envios_mes').on('changed.bs.select', function (e) {
                if ($('#filter_envios_years').val() != "") {
                    location.href = "/erp/apps/material/?year=" + $('#filter_envios_years').val() + "&month=" + $(this).val() +  $('#filter_proveedores').val();
                }
            });
            ocultarTodosEnvio();
            $('#newenvio_tipo').on('changed.bs.select', function (e) {
                ocultarTodosEnvio();
                var valor = $("#newenvio_tipo").val();
                console.log("valor:"+valor);
                switch(valor){
                    case "":
                        // Ocultar todo
                        console.log("estamos en vacio");
                        ocultarTodosEnvio();
                        break;
                    case "2":
                        // Mostrar solo DEV
                        console.log("estamos en dos");
                        ocultarTodosEnvio();
                        mostrarSoloDEV();
                        break;
                    case "1":
                        // Mostrar solo ENV
                        console.log("estamos en uno");
                        ocultarTodosEnvio();
                        mostrarSoloENV();                   
                        break;
                }
            });
            
            function ocultarTodosEnvio(){
                $("label[for='newenvio_transportistas']").hide();
                $("#newenvio_transportistas").parent().hide();
                $("label[for='newenvio_ref_trans']").hide();
                $("#newenvio_ref_trans").hide();
                $("label[for='newenvio_clientes']").parent().hide();
                $("#newenvio_clientes").hide();
                $("label[for='newenvio_proveedores']").parent().hide();
                $("#newenvio_proveedores").hide();
                $("label[for='newenvio_dest']").hide();
                $("#newenvio_dest").hide();
                $("label[for='newenvio_att']").hide();
                $("#newenvio_att").hide();
                $("label[for='newenvio_direnvio']").hide();
                $("#newenvio_direnvio").hide();
                $("label[for='newenvio_formaenvio']").hide();
                $("#newenvio_formaenvio").hide();
                $("label[for='newenvio_portes']").parent().hide();
                $("#newenvio_portes").hide();
                $("label[for='newenvio_gastos']").hide();
                $("#newenvio_gastos").hide();
                $("label[for='newenvio_pedido_CLI']").hide();
                $("#newenvio_pedido_CLI").hide();
                $("label[for='newenvio_oferta_prov']").hide();
                $("#newenvio_oferta_prov").hide();
                $("label[for='newenvio_proyectos']").parent().hide();
                $("#newenvio_proyectos").hide();
                $("label[for='newenvio_entregas']").parent().hide();
                $("#newenvio_entregas").hide();
                $("label[for='newenvio_ofertas_gen']").parent().hide();
                $("#newenvio_ofertas_gen").hide();
                $("label[for='newenvio_fecha']").hide();
                $("#newenvio_fecha").hide();
                $("label[for='newenvio_fechaentrega']").hide();
                $("#newenvio_fechaentrega").hide();
                $("label[for='newenvio_plazo']").hide();
                $("#newenvio_plazo").hide();
                $("label[for='newenvio_contacto']").hide();
                $("#newenvio_contacto").hide();
                $("label[for='newenvio_tecnicos']").parent().hide();
                $("#newenvio_tecnicos").hide();
                $("label[for='newenvio_estados']").parent().hide();
                $("#newenvio_estados").hide();
                $("label[for='newenvio_desc']").hide();
                $("#newenvio_desc").hide();
            }
            function mostrarSoloDEV(){
                $("label[for='newenvio_transportistas']").show();
                $("#newenvio_transportistas").parent().parent().show();
                $("#newenvio_transportistas").parent().show();
                $("label[for='newenvio_ref_trans']").show();
                $("#newenvio_ref_trans").show();
                $("label[for='newenvio_proveedores']").parent().show();
                $("#newenvio_proveedores").show();
                $("label[for='newenvio_dest']").show();
                $("#newenvio_dest").show();
                $("label[for='newenvio_att']").show();
                $("#newenvio_att").show();
                $("label[for='newenvio_direnvio']").show();
                $("#newenvio_direnvio").show();
                $("label[for='newenvio_formaenvio']").show();
                $("#newenvio_formaenvio").show();
                $("label[for='newenvio_portes']").parent().show();
                $("#newenvio_portes").show();
                $("label[for='newenvio_gastos']").show();
                $("#newenvio_gastos").show();
                $("label[for='newenvio_oferta_prov']").show();
                $("#newenvio_oferta_prov").show();
                $("label[for='newenvio_proyectos']").parent().show();
                $("#newenvio_proyectos").show();
                $("label[for='newenvio_ofertas_gen']").parent().show();
                $("#newenvio_ofertas_gen").show();
                $("label[for='newenvio_fecha']").show();
                $("#newenvio_fecha").show();
                $("label[for='newenvio_fechaentrega']").show();
                $("#newenvio_fechaentrega").show();
                $("label[for='newenvio_plazo']").show();
                $("#newenvio_plazo").show();
                $("label[for='newenvio_contacto']").show();
                $("#newenvio_contacto").show();
                $("label[for='newenvio_tecnicos']").parent().show();
                $("#newenvio_tecnicos").show();
                $("label[for='newenvio_estados']").parent().show();
                $("#newenvio_estados").show();
                $("label[for='newenvio_desc']").show();
                $("#newenvio_desc").show();
            }
            function mostrarSoloENV(){
                $("label[for='newenvio_transportistas']").show();
                $("#newenvio_transportistas").parent().parent().show();
                $("#newenvio_transportistas").parent().show();
                $("label[for='newenvio_ref_trans']").show();
                $("#newenvio_ref_trans").show();
                $("label[for='newenvio_clientes']").parent().show();
                $("#newenvio_clientes").show();
                $("label[for='newenvio_direnvio']").show();
                $("#newenvio_direnvio").show();
                $("label[for='newenvio_formaenvio']").show();
                $("#newenvio_formaenvio").show();
                $("label[for='newenvio_portes']").parent().show();
                $("#newenvio_portes").show();
                $("label[for='newenvio_gastos']").show();
                $("#newenvio_gastos").show();
                $("label[for='newenvio_pedido_CLI']").show();
                $("#newenvio_pedido_CLI").show();
                $("label[for='newenvio_proyectos']").parent().show();
                $("#newenvio_proyectos").show();
                $("label[for='newenvio_ofertas_gen']").parent().show();
                $("#newenvio_ofertas_gen").show();
                $("label[for='newenvio_fecha']").show();
                $("#newenvio_fecha").show();
                $("label[for='newenvio_fechaentrega']").show();
                $("#newenvio_fechaentrega").show();
                $("label[for='newenvio_plazo']").show();
                $("#newenvio_plazo").show();
                $("label[for='newenvio_contacto']").show();
                $("#newenvio_contacto").show();
                $("label[for='newenvio_tecnicos']").parent().show();
                $("#newenvio_tecnicos").show();
                $("label[for='newenvio_estados']").parent().show();
                $("#newenvio_estados").show();
                $("label[for='newenvio_desc']").show();
                $("#newenvio_desc").show();
            }
            // Portes Pagados o No pagados
            $('#newenvio_portes').on('changed.bs.select', function (e) {
                if($(this).val()==0){
                    // No pagado
                    $("#newenvio_gastos").prop("disabled", false);
                    $("#newenvio_gastos").val("");
                }else{
                    if($(this).val()==1){
                       // Pagado 
                       $("#newenvio_gastos").prop("disabled", true);
                       $("#newenvio_gastos").val(0);
                       $("#newenvio_gastos").html(0);
                    }
                }
            });
            
            $('#refresh_proyectos').click(function () {
                $('#tabla-proyectos').fadeOut('slow', function(){
                    $('#tabla-proyectos').load('/erp/vistas/proyectos-activos.php', function(){
                        $('#tabla-proyectos').fadeIn('slow');
                    });
                });
            });
            
            $(document).on("click", "#tabla-envios > tbody tr" , function() {
                window.open(
                    "editEnvio.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            $(document).on("click", "#tabla-envios-ultimos > tbody tr" , function() {
                window.open(
                    "editEnvio.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            $(document).on("click", "#tabla-pedidos-fueraplazo > tbody tr" , function() {
                window.open(
                    "editPedido.php?id=" + $(this).data("id"),
                    '_blank' 
                );
            });
            
            $("#add-envio").click(function() {
                $("#addenvio_model").modal('show');
            });
                        
            $("#btn_save_envio").click(function() {
                console.log("Valor"+$("#newenvio_gastos").val());
                $("#btn_save_envio").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_envio").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveEnvio.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_envio').trigger("reset");
                        refreshSelects();
                        $("#btn_save_envio").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newenvio_success").slideDown();
                        setTimeout(function(){
                            $("#newenvio_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.href = "editEnvio.php?id=" + response[0].id;
                        }, 1000);
                    }   
                });
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
                
                $('#newenvio_proyectos').on('changed.bs.select', function (e) {
                    loadSelect("newenvio_entregas","ENTREGAS","id","proyecto_id",$(this).val());
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

<title>Envíos | Erp GENELEK</title>
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
                Envío de Material
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
                    ÚLTIMOS ARTÍCULOS ENVIADOS
                </h4>
                <hr class="dash-underline">
                <div id="dash-pedidos-ultimos">
                    <? 
                        include("vistas/envios-ultimos.php"); 
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
                <? include($pathraiz."/apps/envios/vistas/filtros.php"); ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="four-column-three-merged">
                <h4 class="dash-title">
                    ENVÍOS DE MATERIAL
                    <? include($pathraiz."/apps/envios/includes/tools-envios.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="dash-envios">
                    <? 
                        $fechamod = 1;
                        //include("vistas/material-home.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-aside" class="four-column">
                <div id="dash-alertas" class="one-column">
                    <h4 class="dash-title">
                        ALERTAS
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz."/apps/envios/vistas/alertas.php"); ?>
                </div>
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        ACTIVIDAD
                    </h4>
                    <hr class="dash-underline">
                    <? //include($pathraiz."/vistas/erp-actividad.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
        
        
    </section>
	
</body>
</html>