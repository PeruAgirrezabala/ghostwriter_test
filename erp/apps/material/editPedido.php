<?
    include("../../common.php");
    session_start();
    if(!isset($_SESSION['user_session']))
    {
        $logeado = checkCookie();
        if ($logeado == "no") {
            header("Location: /erp/login.php");
        }
    }
    else {
        //$idtrabajador = $_SESSION['user_session'];
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
<!-- Editor -->
<!-- Algo más lengo pero en cloud...
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
-->
<script src='/erp/includes/plugins/tinymce/js/tinymce/tinymce.min.js'></script>

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
                
                <div id="dash-comentario-add" class="one-column">
                    <h4 class="dash-title">
                        COMENTARIOS INTERNOS 
                        <? include($pathraiz."/apps/material/includes/tools-comentario-interno.php"); ?>
                    </h4>
                    <hr class="dash-underline">
                    <div id="comentario-interno">
                        <? 
                            //$fechamod = 1;
                            include("vistas/comentarios-internos.php"); 
                        ?>
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
                <div id="dash-detalles">
                <? 
                    $fechamod = 1;
                    //include("vistas/pedidos-detalles.php"); 
                ?>
                </div>
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
            tinymce.init({
                selector: '.textarea-cp',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                },
                editor_deselector : "mceNoEditor",
                height: 250,
                width : '100%',
                autoresize_max_width: 600,
                theme: 'modern',
                plugins: [
                      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                      'searchreplace wordcount visualblocks visualchars code fullscreen',
                      'insertdatetime media nonbreaking save table contextmenu directionality',
                      'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager ',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
                relative_urls: false,
                image_advtab: true ,
                external_filemanager_path:"/erp/includes/plugins/filemanager/",
                filemanager_title:"Gestor de imágenes para MATERIAL/PEDIDO" ,
                external_plugins: { "filemanager" : "/erp/includes/plugins/filemanager/plugin.min.js"},
                templates: [
                      { title: 'Test template 1', content: 'Test 1' },
                      { title: 'Test template 2', content: 'Test 2' }
                ],
                content_css: [
                      '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                      '//www.tinymce.com/css/codepen.min.css'
                ]
            });
            
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
                console.log('File uploaded triggered');
                console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);
                               
               /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */
               
               console.log("fichero-subido - " + $("#fichero_subido").val());
               
                $.post( "processUpload.php", 
                { 
                    pathFile: data.response.uploaded,
                    nombre: $("#pedidodetalle_docnombre").val(),
                    descripcion: $("#pedidodetalle_docdesc").val(),
                    pedido_id: <? echo $_GET['id'] ?> 
                })
                .done(function( data1 ) {
                    alert( "ok" );
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
            loadSelect("pedidos_edit_tecnicos","erp_users","id","empresa_id","1","apellidos","activo","'on'","",0); // Selecciona los trabajadores activos
            //loadSelect("pedidos_edit_tecnicos","erp_users","id","","","apellidos"); // Selecciona todos los trabajadores
            loadSelect("pedidodetalle_proyectos","PROYECTOS","id","","","ref");
            loadSelect("pedidodetalle_tecnicos","erp_users","id","empresa_id","1","apellidos","activo","'on'","",0); // Selecciona los trabajadores activos
            //loadSelect("pedidodetalle_tecnicos","erp_users","id","","","apellidos"); // Selecciona todos los trabajadores            
            loadSelect("materiales_categoria1","MATERIALES_CATEGORIAS","id","parent_id",0);
            loadSelect("pedidodetalle_dtoprov","PROVEEDORES_DTO","id","proveedor_id",<? echo $proveedor_id; ?>,"fecha_val","","","");
            loadSelect("pedidodetalle_ivas","IVAS","id","","","");
            loadSelect("pedidodetalle_clientes","CLIENTES","id","","","");
            loadSelect("pedidos_edit_clientes","CLIENTES","id","","","");
            loadSelect("duplicar_pedido_proyectos","PROYECTOS","id","","","ref");
            loadSelect("newduplicado_clientes","CLIENTES","id","","","");
            loadSelect("envio_tipo","ENVIOS_CLI_TIPOS","id","","","");
            loadSelect("envio_portes","ENVIOS_CLI_PORTES","id","","","");
            loadSelect("envio_transportistas","TRANSPORTISTAS","id","","","");
            loadSelect("pedidos_edit_formaspago","FORMAS_PAGO","id","","","");
            
            loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles.php?id=" + <? echo $_GET['id']; ?>);
            
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
            
            $("#refresh-material").click(function() {
                loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles.php?id=" + <? echo $_GET['id']; ?>);
            });
            // ######## OPEN MODALS #######
            $("#add-detallepedido").click(function() {
                $('#frm_edit_pedidodetalle').trigger("reset");
                $("#pedidodetalle_detalle_id").val('');
                $("#pedidodetalle_material_id").val('');
                $("#pedidodetalle_clientes").selectpicker("render");
                $("#pedidodetalle_clientes").selectpicker("refresh");
                $("#pedidodetalle_proyectos").selectpicker("render");
                $("#pedidodetalle_proyectos").selectpicker("refresh");
                $("#pedidodetalle_tecnicos").selectpicker("render");
                $("#pedidodetalle_tecnicos").selectpicker("refresh");
                $("#pedidodetalle_precios").selectpicker("render");
                $("#pedidodetalle_precios").selectpicker("refresh");
                $("#pedidodetalle_materiales").selectpicker("render");
                $("#pedidodetalle_materiales").selectpicker("refresh");
                $("#pedidodetalle_fecha_entrega").val('');
                $('input[name="edit_chkrecibido"]').bootstrapSwitch('state',parseInt(0));
                $("#detallepedido_add_model").modal('show');
                
                //
                // Fecha aqui
                document.getElementById("pedidodetalle_fecha_entrega").value = '<? echo $fecha_entrega; ?>';
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
                //loadSelect("pedidodetalle_precios","MATERIALES_PRECIOS","id","proveedor_id",$("#pedidos_edit_proveedores").val(),"fecha_val", "material_id", $(this).val(),"MATERIALES_PRECIOS.dto_material");
                //loadSelect("pedidodetalle_precios","MATERIALES_PRECIOS","id","material_id", $(this).val(),"fecha_val","proveedor_id",$("#pedidos_edit_proveedores").val(),"MATERIALES_PRECIOS.dto_material");
                loadSelectTarifas("pedidodetalle_precios","MATERIALES_PRECIOS","id","material_id", $(this).val(),"fecha_val","proveedor_id",$("#pedidos_edit_proveedores").val(),"MATERIALES_PRECIOS.dto_material","","fecha_val");
                //console.log("logTarifas");
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
            
            // Checks multiselect material
            $(document).on("click", ".to-alb" , function() {
            //$(".to-alb").click(function() {
                
                var detalleid=$(this).parent().parent().data("id");
                $("#multi-mat-rec").val(detalleid+"-"+$("#multi-mat-rec").val());
                console.log($("#multi-mat-rec").val());
                
                var matrec = $("#multi-mat-rec").val(); 
                var total = matrec.length; 
                var n = matrec.indexOf("-");
                var i=0;
                console.log("String total: "+total);
                var nums =  new Array(); 
                
                    while(i!=(total/6)){
                        matrec.substring(0,(n-1));
                        console.log("Num: "+i+"/"+matrec.substring(0,(n)));
                        nums.push(matrec.substring(0,(n)));
                        matrec = matrec.substring((n+1),total);
                        n = matrec.indexOf("-");
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
                      if($("#multi-mat-rec").val()!=""){
                          $("#multi-mat-rec").val("");
                      }
                    for(var o=0; o<results.length;o++){
                        console.log("Numeros unicos: "+results[o]);
                        $("#multi-mat-rec").val(results[o] + "-" + $("#multi-mat-rec").val());
                    }
                
                console.log("Final:"+$("#multi-mat-rec").val());
                
            });
            //Add multiselect
            $("#recibir-multi-mat").click(function() {
                $("#confirm_multi_detalle_model").modal("show");
            });
            $(document).on("click", "#btn_confirm_multi_detalle" , function() {
                console.log("ENVIADO: "+$("#multi-mat-rec").val().slice(0, -1));
                $.ajax({
                    type: "POST",  
                    url: "savePedidoDetalle.php",  
                    data: {
                        mat_detalle_id : $("#multi-mat-rec").val().slice(0, -1)
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        //$('#frm_edit_pedidodetalle').trigger("reset");
                        //refreshSelects();
                        //$("#btn_pedidodetalle_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        //$("#detallepedido_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        //window.location.reload();
                        $("#confirm_multi_detalle_model").modal("hide");
                        loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles.php?id=" + <? echo $_GET['id']; ?>);
                    }   
                });
            });
            
            // Recepcion Parcial Material
            $(document).on("click", "#recibir-parte-mat" , function() {
                // Ver modal
                //console.log("modal");
                console.log($("#multi-mat-rec").val());
                var datos = "";
                if($("#multi-mat-rec").val()==""){
                    datos =0; 
                }else{
                    datos=$("#multi-mat-rec").val();
                }
                $.ajax({
                    type: "POST",  
                    url: "savePedidoDetalle.php",  
                    data: {
                        parteMat_modal : datos
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        $("#recepcionMaterialParcial_model").html(response);
                        $("#select_div_ped_alm").selectpicker("refresh");
                        $("#recepcionMaterialParcial_model").modal("show");
                        //console.log(response);
                    }   
                });
                
            });
            $(document).on("click", "#btn_divi_mat_recepionado" , function() {
                console.log($("#multi-mat-rec").val().slice(0,-1)+" ***** "+$("#select_div_ped_alm").val());
                $.ajax({
                    type: "POST",  
                    url: "savePedidoDetalle.php",  
                    data: {
                        part_mat_detalle_id : $("#multi-mat-rec").val().slice(0,-1),
                        part_mat : $("#select_div_ped_alm").val()
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        //$('#frm_edit_pedidodetalle').trigger("reset");
                        //refreshSelects();
                        //$("#btn_pedidodetalle_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        //$("#detallepedido_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        //window.location.reload();
                        $("#recepcionMaterialParcial_model").modal("hide");
                        loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles.php?id=" + <? echo $_GET['id']; ?>);
                    }   
                });
            });
            // / Recepcion Parcial Material
            
            $("#pedidodetalle_criterio").change(function () {
                loadSelect("pedidodetalle_materiales","MATERIALES","id","ref",$(this).val(),"ref","nombre",$(this).val(),"",1);
            });
            $("#pedidos_detalles_proyectos").on("changed.bs.select", function (e) {
               // Según el value de la opcion seleccionada que será el ID del textarea correspondiente donde se encuentra el contenido HTML de la etiqueta, lo cargo en el div etiqueta_recibido
               $("#etiqueta_recibido").html($("#" + $(this).val()).val());
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
            
            $(document).on("click", "#btn_clienteProyecto" , function() {
                //$("#btn_clienteProyecto").click(function() {
                $("#pedidodetalle_clientes").selectpicker("val",$("#pedidos_edit_clientes").val());
                $("#pedidodetalle_proyectos").selectpicker("val",$("#pedidos_edit_proyectos").val());
            });
            $(document).on("click", "#btn_addTarifaProv_modal" , function() {
                $("#newtarifa_proveedorid").val($("#pedidos_edit_proveedores").val());
                $("#newtarifa_materialid").val($("#pedidodetalle_materiales").val());
                $("#add_new_tarifa_modal").modal("show");
            });
            // Añadir tarifa al material y proveedor 
            $(document).on("click", "#btn_addTarifaProv" , function() {
                $("#btn_addTarifaProv").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
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
                        $("#btn_addTarifaProv").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#add_new_tarifa_modal").modal('hide');
                        $("#detallepedido_add_model").modal('hide');
                        //$("#proyectos_success").slideDown();
                        //window.location.reload();?¿
                    }   
                });
            });
            
            // ######## SAVE GENERAL #######
            $("#pedidos_edit_btn_save").click(function() {
                $("#pedidos_edit_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                var disabled = $("#frm_editpedido").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_editpedido").serializeArray();
                tinymce.triggerSave();
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
                if (validateForm() == 1) {
                    //error de validacion
                    $("#pedidodetalle_error").slideDown();
                    setTimeout(function(){
                        $("#pedidodetalle_error").fadeOut("slow");
                    }, 2000);
                }
                else {
                    if($("#pedidodetalle_proyectos").val()==""){
                        alert("Introduce Proyecto!");
                    }else{
                        $("#btn_pedidodetalle_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                        var disabled = $("#frm_edit_pedidodetalle").find(':input:disabled').removeAttr('disabled');
                        data = $("#frm_edit_pedidodetalle").serializeArray();
                        // re-disabled the set of inputs that you previously enabled
                        disabled.attr('disabled','disabled');
                        $.ajax({
                            type: "POST",  
                            url: "savePedidoDetalle.php",  
                            data: data,
                            dataType: "text",       
                            success: function(response)  
                            {
                                console.log(response);
                                $('#frm_edit_pedidodetalle').trigger("reset");
                                refreshSelects();
                                $("#btn_pedidodetalle_save").html('Guardar');
                                $("#detallepedido_add_model").modal('hide');
                                //window.location.reload();
                                loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles.php?id=" + <? echo $_GET['id']; ?>);
                            }   
                        });
                    }
                };
            });
            
            // ######## DELETE PEDIDO #######
            $("#delete_pedido").click(function() {
                //$("#delete_pedido").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#pedidos_edit_delpedido").val($("#pedidos_edit_idpedido").val());
                var disabled = $("#frm_edit_pedidodetalle").find(':input:disabled').removeAttr('disabled');
                data = $("#frm_editpedido").serializeArray();
                // re-disabled the set of inputs that you previously enabled
                disabled.attr('disabled','disabled');
                
                // Modal
                $("#delete_pedido_model").modal("show");
                
            });
            // Bnt del modal
            $("#btn_del_pedido").click(function() {
                    $.ajax({
                        type: "POST",  
                        url: "checkPedido.php",  
                        data: {
                            id : <? echo $_GET['id']?>
                        },
                        dataType: "json",       
                        success: function(response)  
                        {
                            if(response>=1){
                                alert("No se puede borrar. Hay que borrar primero los detalles");
                                $('#frm_editpedido').trigger("reset");
                                $("#delete_pedido").html('<img src="/erp/img/bin.png" height="30">');
                            }else{
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
                            }
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
                    //console.log(data);
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
            
            //#######  Boton Añadir envío  #########
            $(document).on("click", "#btn_addEnvio" , function() {
                $("#btn_addEnvio").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_addEnvio").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "saveEnvio.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        $('#frm_addEnvio').trigger("reset");
                        refreshSelects();
                        $("#btn_addEnvio").html('Guardar');
                        $("#add_envio_modal").modal('hide');
                        loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles.php?id=" + <? echo $_GET['id']; ?>);
                        //$("#proyectos_success").slideDown();
                        //window.location.reload();?¿
                    }   
                });
            });
            
            //TO-DO
            $("#btn_duplicarpedido_save").click(function() {
                data = $("#frm_duplicar_pedido").serializeArray();
                $.ajax({
                    type: "POST",  
                    url: "duplicarPedido.php",  
                    data: data,
                    dataType: "text",       
                    success: function(response)  
                    {
                        //alert(response);
                        //console.log("ok");
                        //location.href = "/erp/apps/material/editPedido.php?id=" + response;
                        window.open("/erp/apps/material/editPedido.php?id=" + response,'_blank');
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
            $(document).on("click", ".remove-detalle" , function() {
                $("#btn_del_detalle").data("id", $(this).data("id"));
                $("#delete_detalle_model").modal('show');
            });
            $(document).on("click", "#btn_del_detalle" , function() {
                $.ajax({
                    type : 'POST',
                    url : 'savePedidoDetalle.php',
                    dataType : 'text',
                    data: {
                        pedidodetalle_deldetalle : $(this).data("id")
                    },
                    success : function(data){
                        console.log("ok");
                        //loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles?id=" + <? //echo $_GET['id']; ?>);
                        //window.location.reload();
                        $("#delete_detalle_model").modal("hide");
                        loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles.php?id=" + <? echo $_GET['id']; ?>);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            $(document).on("click", ".delDoc" , function() {
                var elid = $(this).parent().attr('class').split(" ").slice(1).toString();
                // console.log(elid);
                $("#del_doc_id").val($(this).data("id"));
                $("#del_option_id").val(elid);
                $("#confirm_del_doc_model").modal("show");
            });
            $(document).on("click", "#confirm-del-doc" , function() {
                var option=$("#del_option_id").val();
                var elid=$("#del_doc_id").val();
                switch (option){
                    case "node-treeview_json_docprov":
                        $.ajax({
                            type : 'POST',
                            url : 'processUpload.php',
                            dataType : 'text',
                            data: {
                                delDocProv : elid
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
            $(document).on("click", ".recibir-mat" , function() {
                //alert("Cant: "+$(this).parent("td").parent("tr").children("td:nth-child(6)").html());
                //alert("affgg");
                console.log($(this).data("id"));
                console.log($(this).parent("td").parent("tr").children("td:nth-child(6)").html());
                $.ajax({
                    type : 'POST',
                    url : 'savePedidoDetalle.php',
                    dataType : 'text',
                    data: {
                        pedidodetalle_recmat : $(this).data("id"), 
                        cantidad: $(this).parent("td").parent("tr").children("td:nth-child(6)").html()
                    },
                    success : function(data){
                        console.log(data);
                        console.log("recibido");
                        //window.location.reload();
                        loadContent("dash-detalles", "/erp/apps/material/vistas/pedidos-detalles.php?id=" + <? echo $_GET['id']; ?>);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });
            // Enviar / Devolver Material ///// PENDIENTE!
            $(document).on("click", ".enviar-mat" , function() {
                console.log("Valor clickado: "+$(this).data("id"));
                // Mostrar Modal
                $("#envio_usuario_id").val($("#sesion_user_id").val());
                $("#materialdetalle_id").val($(this).data("id"));
                $("#materialdetalle_nombre").val($(this).parent().parent().children('td').eq(3).html()); // Get Nombre material
                $("#materialdetalle_ref").val($(this).parent().parent().children('td').eq(2).html()); // Get Ref material
                var cantidad = $(this).parent().parent().children('td').eq(5).html();
                for(var i=1;i<=cantidad;i++){ // Dependiendo de cuanta catidad haya, añadir en el combo los números
                    $("#envio_cant").append(new Option (i,i));
                }
                $("#envio_cant").selectpicker('refresh'); // Refrescar valores
                
                
                $("#add_envio_modal").modal("show");
                // 
                // Ver si para este pedido hay alguna devolución. Si existe, se anida, sino, se genera un envio/dev con cabeceras nuevo.
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
            $(document).on("click", "#tabla-detalles-pedidos tr > td:not(:nth-child(1)):not(:nth-child(15)):not(:nth-child(16))" , function() {
                loadPedidoDetalleInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#detallepedido_add_model").modal('show');
            });
            
            $('#pedidodetalle_proyectos').on('changed.bs.select', function (e) {
                loadSelect("pedidodetalle_entregas","ENTREGAS","id","proyecto_id",$(this).val());
            });
            
            
            // Comentarios Internos
            $(document).on("click", "#edit-coment-interno" , function() {
                $("#edit-coment-interno").hide(); // Ocultar boton editar
                $("#view-comentario-interno").hide(); // Ocultar ver comentario Interno
                $("#save-coment-interno").show(); // Mostrar boton guardar
                $("#editar-comentario-interno").show(); // Mostrar editar Comantario Interno        
            });
            $(document).on("click", "#save-coment-interno" , function() {
                $("#edit-coment-interno").show(); // Mostrar boton editar
                $("#view-comentario-interno").show(); // Mostrar ver comentario Interno
                $("#save-coment-interno").hide(); // Ocultar boton guardar
                $("#editar-comentario-interno").hide(); // Ocultar editar Comantario Interno
                $.ajax({
                    type: "POST",  
                    url: "saveComentarioInterno.php",  
                    data: {
                        view_com_inter : $("#editar_com_inter").val(),
                        prov_det_id : <? echo $_GET["id"]; ?>
                    },
                    dataType: "text",       
                    success: function(response)  
                    {
                        console.log(response);
                        loadContent("comentario-interno", "/erp/apps/material/vistas/comentarios-internos.php?id=" + <? echo $_GET['id'] ?>);
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