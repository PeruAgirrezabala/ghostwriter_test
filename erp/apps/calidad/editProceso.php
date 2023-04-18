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


<title id="pagina-titulo">Pedidos | Erp GENELEK</title>
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
            <h5><a href="/erp/apps/material/">Pedidos</a> > <span id="current-page"></span></h5>
        </div>
        <div id="erp-titulo" class="one-column">
            <h3 id="pedido-title">
                PEDIDO xxxx
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-datosgenerales-add" class="three-column" style="min-height: 370px;">
                <h4 class="dash-title">
                    DATOS GENERALES <? include($pathraiz."/apps/material/includes/tools-single-pedido.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/pedido-datosgenerales.php"); 
                ?>
            </div>
            <div id="dash-grafico-costes" class="three-column box-info" style="min-height: 370px;">
                <h4 class="dash-title">
                    COMPRADO A
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/pedido-proveedor.php"); 
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
                        include("vistas/pedido-proyecto.php");  
                    ?>
                </div>
                
                <div id="dash-subcontrata-add" class="one-column">
                    <h4 class="dash-title">
                        DOCUMENTOS 
                        <? include($pathraiz."/apps/material/includes/tools-documentos.php"); ?>
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
                    DETALLES DEL PEDIDO
                    <? include($pathraiz."/apps/material/includes/tools-detalles-pedido.php"); ?>
                </h4>
                <hr class="dash-underline">
                <? 
                    //$fechamod = 1;
                    include("vistas/pedidos-detalles.php"); 
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
            $("#menuitem-pedidos").addClass("active");
            
            $("#uploaddocs").fileinput({
                uploadUrl: "upload.php?pedidopath=" + $("#pedidos_edit_path").val() + "&id_pedido=<? echo $_GET['id']; ?>",
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
                    nombre: $("#pedidodetalle_docnombre").val(),
                    descripcion: $("#pedidodetalle_docdesc").val(),
                    pedido_id: <? echo $_GET['id'] ?> 
                })
                .done(function( data1 ) {
                    //alert( "ok" );
                    window.location.reload();
                });
                
            });
            
            function calcImportesMat() {
                //alert("calculo importes");
                var totalDTO = 0.00;
                var DTOextra = 0.00;
                var totalDTOextra = 0.00;
                                
                //descuentos activados
                if( $('#pedidodetalle_dtoprov_desc').prop('checked') ) {
                    //alert(parseFloat($("#pedidodetalle_dtoprov option:selected").text().split("/")[0].replace("% ",""), 10).toFixed(2));
                    totalDTO = parseFloat(totalDTO, 10) + parseFloat($("#pedidodetalle_dtoprov option:selected").text().split("/")[0].replace("% ",""), 10);
                    //alert (totalDTO);
                }
                if( $('#pedidodetalle_dtomat_desc').prop('checked') ) {
                    totalDTO = parseFloat(totalDTO, 10) + parseFloat($("#pedidodetalle_dtomat").val(), 10);
                }
                if($('#pedidodetalle_dto_desc').prop('checked')) {
                    if($('#pedidodetalle_dto_sobretotal').prop('checked')) {
                        //no sumar al totalDTO
                        DTOextra = parseFloat($("#pedidodetalle_dto").val(), 10);
                        DTOextra = "0." + (100 - parseFloat(DTOextra, 10).toFixed(2));
                        totalDTOextra = parseFloat($("#pedidodetalle_dto").val(), 10);;
                    }
                    else {
                        totalDTO = parseFloat(totalDTO) + parseFloat($("#pedidodetalle_dto").val(), 10);
                    }
                }
                console.log(parseFloat(totalDTO).toFixed(2));
                var dto = "0." + (100 - parseFloat(totalDTO, 10).toFixed(2));
                console.log (dto);
                console.log (DTOextra);
                if (dto == "0.100") {
                    dto = 1;
                }
                if (DTOextra == "0.100") {
                    DTOextra = 1;
                }
                
                var pvp = parseFloat($("#pedidodetalle_preciomat").val(),10).toFixed(2)*parseFloat($("#pedidodetalle_cantidad").val(),10).toFixed(2);
                var pvpdto = parseFloat(pvp, 10)*parseFloat(dto,10);
                // Si está seleccionado el descuento adicional para aplicarse después de todos los descuentos, lo aplico.
                if($('#pedidodetalle_dto_sobretotal').prop('checked')) {
                    pvpdto = parseFloat(pvpdto, 10)*parseFloat(DTOextra,10);
                }
                //var inc = "1." + $("#pedidodetalle_incremento").val();
                $("#pedidodetalle_pvp").val(pvp.toFixed(2));
                $("#pedidodetalle_totaldtopercent").val(totalDTO.toFixed(2));
                if($('#pedidodetalle_dto_sobretotal').prop('checked')) {
                    $("#pedidodetalle_totaldtopercent").val($("#pedidodetalle_totaldtopercent").val() + " + " + parseFloat(totalDTOextra,10).toFixed(2));
                }
                $("#pedidodetalle_totaldto").val(((parseFloat($("#pedidodetalle_pvp").val())*parseFloat(totalDTO,10))/100).toFixed(2));
                $("#pedidodetalle_pvpdto").val(pvpdto.toFixed(2));
                //var pvpinc = parseFloat(pvpdto,10)*parseFloat(inc,10).toFixed(2);
                //$("#pedidodetalle_pvpinc").val(pvpinc.toFixed(2));
            };
            
            $('.icon').mouseenter(function() {
                $(this).effect('bounce',3000);
            });	

            $("#menuitem-material").addClass("active");
            
            // ######## LOAD SELECTS #######
            loadSelect("pedidodetalle_categorias1","MATERIALES_CATEGORIAS","id","parent_id",0);
            loadSelect("pedidos_edit_proyectos","PROYECTOS","id","","","ref");
            loadSelect("pedidos_edit_proveedores","PROVEEDORES","id","","","");
            loadSelect("pedidos_edit_estados","PEDIDOS_PROV_ESTADOS","id","","","");
            loadSelect("pedidos_edit_tecnicos","erp_users","id","","","apellidos");
            loadSelect("pedidodetalle_proyectos","PROYECTOS","id","","","ref");
            loadSelect("pedidodetalle_tecnicos","erp_users","id","","","apellidos");
            loadSelect("materiales_categoria1","MATERIALES_CATEGORIAS","id","parent_id",0);
            loadSelect("pedidodetalle_dtoprov","PROVEEDORES_DTO","id","proveedor_id",<? echo $proveedor_id; ?>,"fecha_val","","","");
            loadSelect("pedidodetalle_ivas","IVAS","id","","","");
            loadSelect("pedidodetalle_clientes","CLIENTES","id","","","");
            loadSelect("pedidos_edit_clientes","CLIENTES","id","","","");
            loadSelect("duplicar_pedido_proyectos","PROYECTOS","id","","","ref");
            loadSelect("newduplicado_clientes","CLIENTES","id","","","");
            
            setTimeout(function(){
                $("#pedidodetalle_ivas").selectpicker("val", 4);
                //$("#pedidodetalle_ivas").val(4);
            }, 3000);
            
            $('input[name="edit_chkrecibido"]').bootstrapSwitch({
                // The checkbox state
                state: false,
                // Text of the left side of the switch
                onText: 'SI',
                // Text of the right side of the switch
                offText: 'NO'
            });
            
            //loadOferta(<? //echo $_GET['id']; ?>);
            
            // ######## OPEN MODALS #######
            $("#add-detallepedido").click(function() {
                $('#frm_edit_pedidodetalle').trigger("reset");
                $("#pedidodetalle_precios").selectpicker("render");
                $("#pedidodetalle_precios").selectpicker("refresh");
                $("#pedidodetalle_materiales").selectpicker("render");
                $("#pedidodetalle_materiales").selectpicker("refresh");
                $('input[name="edit_chkrecibido"]').bootstrapSwitch('state',parseInt(0));
                $("#detallepedido_add_model").modal('show');
            });
            $("#edit_pedido").click(function() {
                $("#pedido-view").hide();
                $("#pedido-edit").show();
            });
            $("#add-material").click(function() {
                $("#selectmaterial_model").modal('show');
            });
            $("#add-documento").click(function() {
                $("#detallepedido_adddoc_model").modal('show');
            });
            $("#duplicar_pedido").click(function() {
                $("#pedido_duplicar_model").modal('show');
            });
                        
            // ######## SELECTS CHANGE EVENTS #######
            $("select.pedidodetalle_categorias").on("changed.bs.select", function (e) { 
                var numCat = $("select.pedidodetalle_categorias").length + 1;
                console.log("num elementos " + numCat);
                for (i = 1; i < numCat; i++) {
                    if (i != 1) {
                        console.log("delete " + numCat);
                        $("#pedidodetalle_categorias" + i).selectpicker("destroy");
                        $("#pedidodetalle_categorias" + i).closest(".form-group").remove();
                    }
                }
                
                var numCat = $("select.pedidodetalle_categorias").length + 1;
                var htmlElement = "<div class='form-group'><label class='labelBeforeBlack'></label><select id='pedidodetalle_categorias" + numCat + "' name='pedidodetalle_categorias" + numCat + "' class='selectpicker pedidodetalle_categorias' data-live-search='true' data-width='33%'><option></option></select></div>"
                $("select.pedidodetalle_categorias").last().closest(".form-group").after(htmlElement);
                
                loadSelect("pedidodetalle_categorias" + numCat,"MATERIALES_CATEGORIAS","id","parent_id",$(this).val());
                $("#pedidodetalle_categorias" + numCat).selectpicker('render');
                $("#pedidodetalle_categorias" + numCat).selectpicker('refresh');
            });
            $("body").on('change',"select.pedidodetalle_categorias", function(){
                //alert("ok");  
                loadSelect("pedidodetalle_materiales","MATERIALES","id","categoria_id",$(this).val(),"ref");
            });
            $("#pedidodetalle_materiales").on("changed.bs.select", function (e) {
                //loadPedidoDetalleInfo($(this).val(), "MATERIALES");
                loadPedidoMaterialInfo($(this).val(), "MATERIALES", $("#pedidos_edit_proveedores").val());
                loadSelect("pedidodetalle_precios","MATERIALES_PRECIOS","id","proveedor_id",$("#pedidos_edit_proveedores").val(),"fecha_val", "material_id", $(this).val(),"MATERIALES_PRECIOS.dto_material");
            });
            
            $("#pedidodetalle_precios").on("changed.bs.select", function (e) {
                //Cargar el precio seleccionado en el textbox pedidodetalle_preciomat
                var selectedText = $(this).find("option:selected").text();
                var selectedTextSplit = selectedText.split("/");
                selectedtext = selectedTextSplit[0].replace("€","");
                selectedtext = selectedtext.trim();
                $("#pedidodetalle_preciomat").val(selectedtext);
                selectedtext = selectedTextSplit[2].replace("%","");
                selectedtext = selectedtext.trim();
                $("#pedidodetalle_dtomat").val(selectedtext);
            });
            
            $(".to-alb").change(function () {
                $("#to_albaran").val($(this).data("matid") + "-" + $("#to_albaran").val());
            });
            
            $("#pedidodetalle_criterio").change(function () {
                loadSelect("pedidodetalle_materiales","MATERIALES","id","ref",$(this).val(),"ref","nombre",$(this).val(),"",1);
            });
            
            
            // ######## FOCUSOUT EVENTS #######
            $("#pedidodetalle_cantidad").focusout(function() {
                calcImportesMat();
            });
            $("#pedidodetalle_dto").focusout(function() {
                calcImportesMat();
            });
            $("#pedidodetalle_incremento").focusout(function() {
                calcImportesMat();
            });
            $("#pedidodetalle_dto").focusout(function() {
                $("#pedidodetalle_dto").val(parseFloat($("#pedidodetalle_dto").val()).toFixed(2));
            });
            $("#pedidodetalle_dtoprov_desc").change(function() {
                calcImportesMat();
            });
            $("#pedidodetalle_dtomat_desc").change(function() {
                calcImportesMat();
            });
            $("#pedidodetalle_dto_desc").change(function() {
                calcImportesMat();
            });
            $("#pedidodetalle_dto_sobretotal").change(function() {
                calcImportesMat();
            });
            
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
            $("#pedidos_edit_btn_save").click(function() {
                $("#pedidos_edit_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_editpedido").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_editpedido").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "savePedido.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_editpedido').trigger("reset");
                        window.location.reload();
                    }   
                });
            });
            
            // ######## SAVE DETALLES #######
            $("#btn_pedidodetalle_save").click(function() {
                //alert($("#pedidodetalle_detalle_id").val());
                $("#btn_pedidodetalle_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_edit_pedidodetalle").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_edit_pedidodetalle").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "savePedidoDetalle.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        //alert(response);
                        $('#frm_edit_pedidodetalle').trigger("reset");
                        refreshSelects();
                        $("#btn_pedidodetalle_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#detallepedido_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        window.location.reload();
                    }   
                });
            });
            
            // ######## DELETE PEDIDO #######
            $("#delete_pedido").click(function() {
                $("#delete_pedido").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#pedidos_edit_delpedido").val($("#pedidos_edit_idpedido").val());
                var disabled = $("#frm_edit_pedidodetalle").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_editpedido").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                $.ajax({
                    type: "POST",  
                    url: "savePedido.php",  
                    data: data,
                    dataType: "json",       
                    success: function(response)  
                    {
                        $('#frm_editpedido').trigger("reset");
                        window.location.href = "/erp/apps/material/";
                    }   
                });
            });
            
            $("#print_pedido").click(function() {
                $("#print_pedido").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Imprimiendo ...');
                $('#cover').fadeIn('slow');
                $.post('includes/print_pdf.php', 
                { 
                    id_pedido: $("#pedidos_edit_idpedido").val()
                })
                .done(function( data ) {
                    //alert(data);
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
            
            $("#print_recibido").click(function() {
                $("#etiqueta_recibido_model").modal('show');
            });
            $("#btn_print_recibido").click(function() {
                printElement(document.getElementById("etiqueta_recibido"));
                window.print();
            });
            
            //TODO
            $("#btn_duplicarpedido_save").click(function() {
                data = $("#frm_duplicar_pedido").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "duplicarPedido.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        alert(response);
                        console.log("ok");
                        location.href = "/erp/apps/material/editPedido.php?id=" + response;
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            $("#gen_albaran").click(function() {
                $("#gen_albaran").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Imprimiendo ...');
                $('#cover').fadeIn('slow');
                alert($("#to_albaran").val());
                $.post('includes/print_albaran.php', 
                { 
                    materiales_id: $("#to_albaran").val(),
                    id_pedido: <? echo $_GET['id']; ?>
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
                        window.open(
                            data,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                    else {
                        
                    }       
                }); 
            });
            
            $("#recibir_pedido").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'savePedido.php',
                    dataType : 'text',
                    data: {
                        pedido_recid : <? echo $_GET['id']; ?>
                    },
                    success : function(data){
                        //alert(data);
                        //console.log("recibido");
                        window.location.reload();
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            
            // ######## DELETE DETALLES #######
            $(".remove-detalle").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'savePedidoDetalle.php',
                    dataType : 'text',
                    data: {
                        pedidodetalle_deldetalle : $(this).data("id")
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
            
            $(".recibir-mat").click(function() {
                $.ajax({
                    type : 'POST',
                    url : 'savePedidoDetalle.php',
                    dataType : 'text',
                    data: {
                        pedidodetalle_recmat : $(this).data("id"), 
                        cantidad: $(this).parent("td").parent("tr").children("td:nth-child(5)").html()
                    },
                    success : function(data){
                        //alert(data);
                        console.log("recibido");
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
                            detallepedido_idmaterial: $("#newmaterial_idmaterial"),
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
            // /MATERIALES
            
            // ######## EDIT DETALLES #######
            $("#tabla-detalles-pedidos tr > td:not(:nth-child(1)):not(:nth-child(14)):not(:nth-child(15))").click(function() {
                loadPedidoDetalleInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#detallepedido_add_model").modal('show');
            });
            
            $('#pedidodetalle_proyectos').on('changed.bs.select', function (e) {
                loadSelect("pedidodetalle_entregas","ENTREGAS","id","proyecto_id",$(this).val());
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