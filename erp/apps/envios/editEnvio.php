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


<title id="envio-title">Envíos | Erp GENELEK</title>
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
            <h5><a href="/erp/apps/envios/">Envíos</a> > <span id="current-page"></span></h5>
        </div>
        <div id="erp-titulo" class="one-column">
            <h3 id="envio-titulo">
                ENVIO xxxx
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-datosgenerales-add" class="three-column" style="min-height: 370px;">
                <h4 class="dash-title">
                    DATOS GENERALES <? include($pathraiz."/apps/envios/includes/tools-single-envio.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/envio-datosgenerales.php"); 
                ?>
            </div>
            <div id="dash-grafico-costes" class="three-column box-info" style="min-height: 370px;">
                <h4 class="dash-title">
                    ENVIADO A
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/envio-cliente.php"); 
                ?>
            </div>
            <div id="dash-resumen-ventas" class="three-column box-info" style="background-color: transparent; min-height: 370px;">
                <div id="dash-proyecto" class="one-column">
                    <h4 class="dash-title">
                        PERTENECIENTE AL PROYECTO
                    </h4>
                    <hr class="dash-underline">
                    <? 
                        //$fechamod = 1;
                        include("vistas/envio-proyecto.php");  
                    ?>
                </div>
                
                <div id="dash-subcontrata-add" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTOS 
                        <? include($pathraiz."/apps/envios/includes/tools-documentos.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="treeview_json">
                        <? //include($pathraiz."/apps/material/vistas/pedido-documentos.php"); ?>
                    </div>
                </div>
            </div>
            
            <span class="stretch"></span>
            
            <div id="dash-materiales-add" class="one-column">
                <h4 class="dash-title">
                    DETALLES DEL ENVÍO
                    <? include($pathraiz."/apps/envios/includes/tools-detalles-envio.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/envios-detalles.php"); 
                ?>
            </div>
            
            <span class="stretch"></span>
        </div>
    </section>
    <div id="prueba">
        
    </div>
</body>
</html>

<script>
	
	$(window).load(function(){
            $('#cover').fadeOut('slow').delay(5000);
	});
	
	$(document).ready(function() {
            $("#menuitem-envios").addClass("active");
            
            $("#uploaddocs").fileinput({
                uploadUrl: "upload.php?enviopath=" + $("#envios_edit_path").val() + "&id_envio=<? echo $_GET['id']; ?>",
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
                    nombre: $("#enviodetalle_docnombre").val(),
                    descripcion: $("#enviodetalle_docdesc").val(),
                    envio_id: <? echo $_GET['id'] ?> 
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    console.log("data1: "+data1);
                    //window.location.reload();
                });
                
            });
            
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	
            
            // ######## LOAD SELECTS #######
            loadSelect("enviodetalle_categorias1","MATERIALES_CATEGORIAS","id","parent_id",0);
            loadSelect("envios_edit_proyectos","PROYECTOS","id","","","ref");
            loadSelect("envios_edit_transportistas","TRANSPORTISTAS","id","","","");
            loadSelect("envios_edit_clientes","CLIENTES","id","","","");
            loadSelect("envios_edit_proveedores","PROVEEDORES","id","","","");
            loadSelect("envios_edit_estados","PEDIDOS_PROV_ESTADOS","id","","","");
            loadSelect("envios_edit_tecnicos","erp_users","id","","","apellidos");
            loadSelect("enviodetalle_proyectos","PROYECTOS","id","","","ref");
            loadSelect("enviodetalle_tecnicos","erp_users","id","","","apellidos");
            loadSelect("materiales_categoria1","MATERIALES_CATEGORIAS","id","parent_id",0);
            loadSelect("enviodetalle_sn","SERIAL_NUMBERS","id","","", "");
            loadSelect("envios_edit_tipo","ENVIOS_CLI_TIPOS","id","","","");
            loadSelect("envios_edit_portes","ENVIOS_CLI_PORTES","id","","","");
            
            // Modal envios detalles
            $("#enviodetalle_proyectos_div").hide();
            $("#enviodetalle_mat_proce").on("changed.bs.select", function (e) { 
                console.log("Cambiado a: "+$("#enviodetalle_mat_proce").val());
                // Mat Asignado a proyecto
                if($("#enviodetalle_mat_proce").val()=="1"){
                    $("#enviodetalle_proyectos_div").show();
                }
                // Material del alamacen o oficina
                if($("#enviodetalle_mat_proce").val()=="2"){
                    $("#enviodetalle_proyectos_div").hide();
                    $.ajax({
                        type : 'POST',
                        url : 'getMaterialesProyecto.php',
                        dataType : 'html',
                        data: {
                            proyecto_id : -1
                        },
                        success : function(data){
                            console.log("ok");
                            console.log(data);
                            $("#enviodetalle_materiales").html(data);
                            $("#enviodetalle_materiales").selectpicker("refresh");
                            $("#enviodetalle_materiales").selectpicker("render");
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("ERROR");
                        }
                    });
                }
                if($("#enviodetalle_mat_proce").val()==""){
                    $("#enviodetalle_proyectos_div").hide();
                }
            });
            // Edit de portes. Dependiendo de selección....
            $("#envios_edit_portes").on("changed.bs.select", function (e) {
               if($(this).val()==2){
                    // No pagado
                    $("#envios_edit_gastos").prop("disabled", false);
                    $("#envios_edit_gastos").val("");
                }else{
                    if($(this).val()==1){
                       // Pagado 
                       $("#envios_edit_gastos").prop("disabled", true);
                       $("#envios_edit_gastos").val(0);
                       $("#envios_edit_gastos").html(0);
                    }
                }
            });
            
            $('input[name="edit_chkrecibido"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            $('input[name="edit_chkgarantia"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            //loadOferta(<? //echo $_GET['id']; ?>);
            
            // ######## OPEN MODALS #######
            $("#add-detalleenvio").click(function() {
                $('#frm_edit_enviodetalle').trigger("reset");
                $('#enviodetalle_mat_proce').selectpicker("refresh");
                $('#enviodetalle_proyectos').selectpicker("refresh");
                $('#enviodetalle_materiales').selectpicker("refresh");
                //$("#enviodetalle_materiales").selectpicker("render");
                $("#tipo_envio_id").val($("#tipoenvio_id").val());
                $("#enviodetalle_cantidad_div").show();
                $("#del_detenvio").val("");
                $("#detalleenvio_add_model").modal('show');
            });
            $("#edit_envio").click(function() {
                $("#envio-view").hide();
                $("#envio-edit").show();
            });
            $("#add-material").click(function() {
                $("#selectmaterial_model").modal('show');
            });
            $("#add-documento").click(function() {
                $("#detalleenvio_adddoc_model").modal('show');
            });
            $("#duplicar_envio").click(function() {
                $("#envio_duplicar_model").modal('show');
            });
            
            // ######## SELECTS CHANGE EVENTS #######
            $("select.enviodetalle_categorias").on("changed.bs.select", function (e) { 
                var numCat = $("select.enviodetalle_categorias").length + 1;
                console.log("num elementos " + numCat);
                for (i = 1; i < numCat; i++) {
                    if (i != 1) {
                        console.log("delete " + numCat);
                        $("#enviodetalle_categorias" + i).selectpicker("destroy");
                        $("#enviodetalle_categorias" + i).closest(".form-group").remove();
                    }
                }
                
                var numCat = $("select.enviodetalle_categorias").length + 1;
                var htmlElement = "<div class='form-group'><label class='labelBeforeBlack'></label><select id='enviodetalle_categorias" + numCat + "' name='enviodetalle_categorias" + numCat + "' class='selectpicker enviodetalle_categorias' data-live-search='true' data-width='33%'><option></option></select></div>"
                $("select.enviodetalle_categorias").last().closest(".form-group").after(htmlElement);
                
                loadSelect("enviodetalle_categorias" + numCat,"MATERIALES_CATEGORIAS","id","parent_id",$(this).val());
                $("#enviodetalle_categorias" + numCat).selectpicker('render');
                $("#enviodetalle_categorias" + numCat).selectpicker('refresh');
            });
            $("body").on('change',"select.enviodetalle_categorias", function(){
                //alert("ok");  
                loadSelect("enviodetalle_materiales","MATERIALES","id","categoria_id",$(this).val(),"ref");
            });
            $("#enviodetalle_proyectos").on("changed.bs.select", function (e) {
                //alert("ok");  
                console.log($(this).val());
                $.ajax({
                    type : 'POST',
                    url : 'getMaterialesProyecto.php',
                    dataType : 'html',
                    data: {
                        proyecto_id : $(this).val()
                    },
                    success : function(data){
                        console.log("ok");
                        console.log(data);
                        $("#enviodetalle_materiales").html(data);
                        $("#enviodetalle_materiales").selectpicker("refresh");
                        $("#enviodetalle_materiales").selectpicker("render");
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
                //loadSelect("enviodetalle_materiales","MATERIALES_STOCK","id","proyecto_id",$(this).val(),"ref");
            });
            $("#enviodetalle_materiales").on("changed.bs.select", function (e) {
                //loadPedidoDetalleInfo($(this).val(), "MATERIALES");
                // cambiar variable oculta pedido_detall_id!?!
                // console.log("thi val: "+$(this).val());
                $("#pedido_detalle_id").val($(this).val());
                loadEnvioMaterialInfo($(this).val(), "MATERIALES");
            });
            
            $("#enviodetalle_precios").on("changed.bs.select", function (e) {
                //Cargar el precio seleccionado en el textbox enviodetalle_preciomat
                var selectedText = $(this).find("option:selected").text();
                var selectedTextSplit = selectedText.split("/");
                selectedtext = selectedTextSplit[0].replace("€","");
                selectedtext = selectedtext.trim();
                $("#enviodetalle_preciomat").val(selectedtext);
                selectedtext = selectedTextSplit[2].replace("%","");
                selectedtext = selectedtext.trim();
                $("#enviodetalle_dtomat").val(selectedtext);
            });
            
            $(".to-alb").change(function () {
                $("#to_albaran").val($(this).data("matid") + "-" + $("#to_albaran").val());
            });
            
            // ######## FOCUSOUT EVENTS #######
            
            $("#search-costematerial").click(function() {
            
                $.ajax({
                    type : 'POST',
                    url : 'getCategories.php',
                    dataType : 'html',
                    data: {
                        id : 6
                    },
                    success : function(data){
                        console.log("ok");
                        console.log(data);
                        $("#prueba").html(data);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            // ######## SAVE GENERAL #######
            $("#envios_edit_btn_save").click(function() {
                $("#envios_edit_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_editenvio").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_editenvio").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveEnvio.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_editenvio').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            
            // ######## SAVE DETALLES #######
            $("#btn_enviodetalle_save").click(function() {
                //alert($("#enviodetalle_detalle_id").val());
                $("#btn_enviodetalle_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_enviodetalle").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_enviodetalle").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveEnvioDetalle.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        $('#frm_edit_enviodetalle').trigger("reset");
                        refreshSelects();
                        $("#btn_enviodetalle_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#detalleenvio_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        window.location.reload();
                        setTimeout(function(){
                            //window.location.reload();
                        }, 2000);
                    }   
                });
            });
            
            // ######## DELETE PEDIDO #######
            $("#delete_envio").click(function() {
                $("#confirm_del_envio_modal").modal("show");
            });
            $("#btn_delete_envio").click(function() {
                $("#delete_envio").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#envios_edit_delenvio").val($("#envios_edit_idenvio").val());
                var disabled = $("#frm_edit_enviodetalle").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_editenvio").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "saveEnvio.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        $('#frm_editenvio').trigger("reset");
                        window.location.href = "/erp/apps/envios/";
                    }   
                });
            });
            
            $("#print_pedido").click(function() {
                $("#print_pedido").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Imprimiendo ...');
                $('#cover').fadeIn('slow');
                $.post('includes/print_pdf.php', 
                { 
                    id_pedido: $("#envios_edit_idpedido").val()
                })
                .done(function( data ) {
                    alert(data);
                    //alert("file://192.168.3.108/" + data);
                    $("#print_pedido").html('<img src="/erp/img/print.png" height="30">');
                    $('#cover').fadeOut('slow').delay(1000);
                    /*
                     $("#print_success").slideDown();
                    setTimeout(function(){
                        $("#categorias_success").fadeOut("slow");
                        //console.log(response[0].id);
                        window.location.reload();
                    }, 2000);
                    */
                    if (data != "error") {
                        window.open(
                            data,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                    else {
                        
                    }       
                }); 
            });
            
            $("#gen_albaran").click(function() {
                $("#gen_albaran").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Imprimiendo ...');
                $('#cover').fadeIn('slow');
                //alert($("#to_albaran").val());
                $.post('includes/print_albaran.php', 
                { 
                    materiales_id: $("#to_albaran").val(),
                    id_envio: <? echo $_GET['id']; ?>
                })
                .done(function( data ) {
                    //alert(data);
                    //alert("file://192.168.3.108/" + data);
                    $("#gen_albaran").html('<img src="/erp/img/albaran.png" height="30">');
                    $('#cover').fadeOut('slow').delay(1000);
                    /*
                     $("#print_success").slideDown();
                    setTimeout(function(){
                        $("#categorias_success").fadeOut("slow");
                        //console.log(response[0].id);
                        window.location.reload();
                    }, 2000);
                    */
                    if (data != "error") {
                        console.log("Data: "+data);
                        window.open(
                            data,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                    else {
                        console.log("Ha habido un error: "+data);
                    }       
                }); 
            });
            $("#print_transp").click(function() {
                $("#etiqueta_transportista_model").modal('show');
            });
            $("#btn_print_etiqueta").click(function() {
                printElement(document.getElementById("etiqueta_transportista"));
                window.print();
            });
            
            // ######## DELETE DETALLES #######
            $(".remove-detalle").click(function() {
                // show modal and pasar id;
                $("#del_detenvio").val($(this).data("id"));
                $("#remove_detalleenvio_model").modal("show");
            });
            $("#btn_remove_detalle").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveEnvioDetalle.php',
                    dataType : 'text',
                    data: {
                        enviodetalle_deldetalle : $("#del_detenvio").val()
                    },
                    success : function(data){
                        //alert(data);
                        console.log("ok");
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            // /
            
            $(".entregar-mat").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'saveEnvioDetalle.php',
                    dataType : 'text',
                    data: {
                        enviodetalle_entmat : $(this).data("id"), 
                        cantidad: $(this).parent("td").parent("tr").children("td:nth-child(5)").html()
                    },
                    success : function(data){
                        //alert(data);
                        console.log("recibido: "+data);
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
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
                    $("#materiales_categoria" + numCat).selectpicker();
                    $("#materiales_categoria" + numCat).selectpicker('refresh');
                });
                $("body").on('change',"select.materiales_categorias", function(){
                    //alert("ok");  
                    loadSelect("newmaterial_materiales","MATERIALES","id","categoria_id",$(this).val(),"");
                });
                $("#newmaterial_materiales").on("changed.bs.select", function (e) {
                    loadMaterialesMaterialInfo($(this).val(), "MATERIALES");
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
                        url: "savePedidoDetalle.php",
                        data: {
                            detalleenvio_idmaterial: $("#newmaterial_idmaterial"),
                            pedido_id: <? echo $_GET["id"]; ?> 
                        },
                        dataType: "text",       
                        success: function(response)  
                        {
                              //console.log("ok");
                              window.location.reload();
                        }   
                    });
                    
                    $.ajax({
                        type: "POST",  
                        url: "saveCategoria.php",  
                        data: data,
                        dataType: "text",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_categoria').trigger("reset");
                            $("#btn_save_material").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#categorias_success").slideDown();
                            setTimeout(function(){
                                $("#categorias_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.reload();
                            }, 2000);
                        }   
                    });
                });
                
                $("#enviodetalle_criterio").focusout(function(){
                    //loadSelect("enviodetalle_sn","SERIAL_NUMBERS","id","ref",$(this).val(), "", "nombre",$(this).val(),"", 1);
                    // Select de material...
                    console.log("focusout");
                    var proyecto=0;
                    if($("#enviodetalle_mat_proce").val()=="1"){
                        proyecto=$("#enviodetalle_proyectos").val();
                    }
                    if($("#enviodetalle_mat_proce").val()=="2"){
                        proyecto=-1;
                    }
                    $.ajax({
                        type : 'POST',
                        url : 'getMaterialesProyecto.php',
                        dataType : 'html',
                        data: {
                            proyecto_id : proyecto,
                            criterio : $(this).val()
                        },
                        success : function(data){
                            console.log("ok");
                            console.log(data);
                            $("#enviodetalle_materiales").html(data);
                            $("#enviodetalle_materiales").selectpicker("refresh");
                            $("#enviodetalle_materiales").selectpicker("render");
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("ERROR");
                        }
                    });
                });
                $("#enviodetalle_sn").change(function () {
                    loadSNlInfo($(this).val(),"envios");
                });
            // /MATERIALES
            
            // ######## EDIT DETALLES #######
            //$(document).on("click", "#tabla-siscal-todos tr > td:not(:nth-child(4))" , function() {
            $("#tabla-detalles-pedidos tr > td:not(:nth-child(1)):not(:nth-child(12)):not(:nth-child(13))").click(function() {
                loadEnvioDetalleInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#del_detenvio").val("");
                $("#enviodetalle_cantidad_div").hide(); //
                // Coger el stock de la tabla!
                //console.log("Dato unidades: "+ $(this).parent().find("td:nth-child(6)").html());
                //var unidades = $(this).parent().find("td:nth-child(6)").html();
                //$("#enviodetalle_stock").html(unidades);
                //$("#enviodetalle_stock").val(unidades);
                $("#detalleenvio_add_model").modal('show');
            });
            
            $('#enviodetalle_proyectos').on('changed.bs.select', function (e) {
                loadSelect("enviodetalle_entregas","ENTREGAS","id","proyecto_id",$(this).val());
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