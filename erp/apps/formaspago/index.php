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
            
            $("#menuitem-formaspago").addClass("active");

            loadGrid();
            
            $("#add-formapago").click(function() {
                $('#frm_new_formapago').trigger("reset");
                $("#addformapago_model").modal('show');
            });
                        
            // FORMAS PAGO
                $('#cmbformas_formapago').on('changed.bs.select', function (e) {
                    loadProveedorInfo($(this).val(), "FORMAS_PAGO");
                    loadGridDto($(this).val()); //cargo el grid de las terifas 
                });
                $("#btn_save_formapago").click(function() {
                    $("#btn_save_formapago").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                    data = $("#frm_new_formapago").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveFormapago.php",  
                        data: data,
                        dataType: "text",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_formapago').trigger("reset");
                            $("#btn_save_formapago").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#newformapago_success").slideDown();
                            setTimeout(function(){
                                $("#newformapago_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.reload();
                            }, 2000);
                        }   
                    });
                });
                $("#btn_del_formapago").click(function() {
                    $("#btn_del_formapago").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                    $("#formapago_del").val($("#newformapago_idforma").val());
                    data = $("#frm_new_formapago").serializeArray();
                    $.ajax({
                        type: "POST",  
                        url: "saveFormapago.php",  
                        data: data,
                        dataType: "json",       
                        success: function(response)  
                        {
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_formapago').trigger("reset");
                            $("#btn_del_formapago").html('<span class="glyphicon glyphicon-floppy-disk"></span> Eliminar');
                            $("#newformapago_success").slideDown();
                            setTimeout(function(){
                                $("#newformapago_success").fadeOut("slow");
                                //console.log(response[0].id);
                                window.location.reload();
                            }, 2000);
                        }   
                    });
                });
            // /FORMAS PAGO
	});
                
        function loadGrid () {
            $("#formaspago_grid").bootgrid('destroy');
            $("#commandforma-add").prop("disabled", false);

            var grid = $("#formaspago_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function ()
                {
                    /* To accumulate custom parameter with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
                },

                url: "responseFormaspago.php",
                data: { 
                        
                      } ,
                formatters: {
                    "commands": function(column, row)
                    {
                        return  "<button type=\"button\" class=\"btn btn-xs btn-default commandforma-edit\" data-row-id=\"" + row.id + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
                                "<button type=\"button\" class=\"btn btn-xs btn-default commandforma-pedidos\" data-row-id=\"" + row.id + "\" title=\"Pedidos al Proveedor\"><span class=\"glyphicon glyphicon-random\"></span></button>" +
                                "<button type=\"button\" class=\"btn btn-xs btn-default commandforma-delete\" data-row-id=\"" + row.id + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function()
            {
                //$("#command-download").prop("disabled", false);

                grid.find(".commandforma-edit").on("click", function(e)
                {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();
                    
                    //console.log(grid.data());//
                    $('#addformapago_model').modal('show');
                    
                    if($(this).data("row-id") > 0) {
                        // collect the data
                        $('#newformapago_idforma').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#newformapago_nombre').val(ele.siblings(':nth-of-type(2)').html().replace(/&nbsp;/gi,''));
                        $('#newformapago_datos').val(ele.siblings(':nth-of-type(3)').html().replace(/&nbsp;/gi,''));
                        $('#newformapago_desc').val(ele.siblings(':nth-of-type(4)').html().replace(/&nbsp;/gi,''));
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                }).end().find(".commandforma-pedidos").on("click", function(e)
                {
                    //window.location.href = "/erp/apps/material/?matid=" + $(this).data("row-id");
                    window.open(
                        "/erp/apps/material/?formapago=" + $(this).data("row-id"),
                        "_blank"
                    );
                }).end().find(".commandforma-delete").on("click", function(e)
                {
                    delForma($(this).data("row-id"));
                });
            });
            //$("#employee_grid").bootgrid('reload');		
        };
        
        function delForma (id) {
            $("#formapago_del").val(id);
            data = $("#frm_new_formapago").serializeArray();
            $.ajax({
                type: "POST",  
                url: "saveFormapago.php",  
                data: data,
                dataType: "json",       
                success: function(response)  
                {
                    // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                    $('#frm_new_formapago').trigger("reset");
                    window.location.reload();
                }   
            });
        };
        
	// this function must be defined in the global scope
	function fadeIn(obj) {
            $(obj).fadeIn(3000);
	};
	
</script>

<title>
    Formas de Pago | Erp GENELEK
</title>
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
                Formas de Pago
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-formaspago" class="one-column">
                <h4 class="dash-title">
                    FORMAS DE PAGO <? include($pathraiz."/apps/formaspago/includes/tools-formas.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-empresas" style="padding:10px;">
                    <? include($pathraiz."/apps/formaspago/vistas/tabla-formas.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
        
        
    </section>
	
</body>
</html>