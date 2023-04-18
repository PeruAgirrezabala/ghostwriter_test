<?
include("../../common.php");

if (!isset($_SESSION['user_session'])) {
    $logeado = checkCookie();
    if ($logeado == "no") {
        header("Location: /erp/login.php");
    }
} else {
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
        $(window).load(function() {
            $('#cover').fadeOut('slow').delay(5000);
        });

        $(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce', 3000);
            });

            $("#menuitem-materiales").addClass("active");

            loadGrid();

            loadSelect("newpedido_proyectos", "PROYECTOS", "id", "", "", "ref");
            loadSelect("newpedido_proveedores", "PROVEEDORES", "id", "", "", "");
            loadSelect("newpedido_estados", "PEDIDOS_PROV_ESTADOS", "id", "", "", "");
            loadSelect("newpedido_tecnicos", "erp_users", "id", "", "", "");
            loadSelect("cmbproveedores_proveedores", "PROVEEDORES", "id", "", "", "");
            loadSelect("materiales_categoria1", "MATERIALES_CATEGORIAS", "id", "parent_id", 0);
            loadSelect("categorias_categorias", "MATERIALES_CATEGORIAS", "id", "", "", "parent_id");
            loadSelect("categorias_categoriasparent", "MATERIALES_CATEGORIAS", "id", "", "");
            loadSelect("tarifaedit_proveedor", "PROVEEDORES", "id", "", "");
            loadSelect("newtarifa_proveedor", "PROVEEDORES", "id", "", "");

            loadSelect("newmaterial_proveedores", "PROVEEDORES", "id", "", "", "");
            loadSelect("newmaterial_clientes", "CLIENTES", "id", "", "", "");

            $("#tabla-proyectos tr").click(function() {
                //alert($(this).data('id'));
            });

            $('#filter_proyectos').on('changed.bs.select', function(e) {
                //alert($(this).parent());
                //console.log($(this).parent().children("button"));
                $(this).parent().children("button").addClass("filter-selected");
            });

            $('#refresh_proyectos').click(function() {
                $('#tabla-proyectos').fadeOut('slow', function() {
                    $('#tabla-proyectos').load('/erp/vistas/proyectos-activos.php', function() {
                        $('#tabla-proyectos').fadeIn('slow');
                    });
                });


                //$("#tabla-proyectos").load("/erp/vistas/proyectos-activos.php");
            });
            $("#tabla-pedidos tr").click(function() {
                location.href = "editPedido.php?id=" + $(this).data("id");
                /*
                $("#tabla-pedidos").hide();
                loadDetallesPedido($(this).data("id"));
                
                $.ajax({
                    type: "POST",  
                    url: "editPedido.php",  
                    data: {
                        id: $(this).data("id")
                    },
                    dataType: "html",       
                    success: function(response)  
                    {
                        //$("#tabla-pedidos").hide("slow");
                        $("#dash-pedidos").append(response);                       
                        //$("#tabla-pedidos").show("slow");
                    }   
                });
                
                
                $("#frm_edit_pedido").show();
                */
            });

            $("#tabla-pedidos-ultimos tr").click(function() {
                location.href = "editPedido.php?id=" + $(this).data("id");
            });
            //al clickar boton de añadir materiales se abre el formulario a rellenar para añadir los materiales
            $("#add-pedido").click(function() {
                $("#addpedido_model").modal('show');
            });
            $("#add-proveedor").click(function() {
                $('#frm_new_proveedor').trigger("reset");
                $("#addproveedor_model").modal('show');
            });
            $("#add-material").click(function() {
                clearMaterial();
                $("#div-ultimoprecio").hide();
                $("#addmaterial_model").modal('show');
            });
            $("#btn_add_categoria").click(function() {
                $('#frm_new_categoria').trigger("reset");
                $("#addcategoria_model").modal('show');
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
                $("#btn_save_pedido").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_pedido").serializeArray();
                //
                $.ajax({
                    type: "POST",
                    url: "savePedido.php",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_pedido').trigger("reset");
                        refreshSelects();
                        $("#btn_save_pedido").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newpedido_success").slideDown();
                        setTimeout(function() {
                            $("#newpedido_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.href = "editPedido.php?id=" + response[0].id;
                        }, 2000);
                    }
                });
            });

            // PROVEEDORES
            $('#cmbproveedores_proveedores').on('changed.bs.select', function(e) {
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
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_proveedor').trigger("reset");
                        $("#btn_save_proveedor").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newproveedor_success").slideDown();
                        setTimeout(function() {
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
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_proveedor').trigger("reset");
                        $("#btn_del_proveedor").html('<span class="glyphicon glyphicon-floppy-disk"></span> Eliminar');
                        $("#newproveedor_success").slideDown();
                        setTimeout(function() {
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
            $("#categorias_categorias").on("changed.bs.select", function(e) {
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

            $("select.materiales_categorias").on("changed.bs.select", function(e) {
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

                loadSelect("materiales_categoria" + numCat, "MATERIALES_CATEGORIAS", "id", "parent_id", $(this).val());
                $("#material_categoria_id").val($(this).val()); // Guardo el id de la ultima categoria seleccionada para guardarlo cuando se guarde el material nuevo o existente
                $("#materiales_categoria" + numCat).selectpicker();
                $("#materiales_categoria" + numCat).selectpicker('refresh');
            });
            $("body").on('change', "select.materiales_categorias", function() {
                //alert("ok");  
                loadSelect("newmaterial_materiales", "MATERIALES", "id", "categoria_id", $(this).val(), "ref");
                $("#material_categoria_id").val($(this).val()); // Guardo el id de la ultima categoria seleccionada para guardarlo cuando se guarde el material nuevo o existente
            });
            $("#newmaterial_materiales").on("changed.bs.select", function(e) {
                loadMaterialesMaterialInfo($(this).val(), "MATERIALES");
                setTimeout(function() {
                    console.log("MATERIAL ID: " + $("#newmaterial_idmaterial").val());
                    loadGridTarifas($("#newmaterial_idmaterial").val()); //cargo el grid de las tarifas
                }, 2000);
            });

            $("#btn_save_categoria").click(function() {
                $("#btn_save_categoria").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_categoria").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "saveCategoria.php",
                    data: data,
                    dataType: "text",
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_categoria').trigger("reset");
                        $("#btn_save_categoria").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#categorias_success").slideDown();
                        setTimeout(function() {
                            $("#categorias_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }
                });
            });
            //evento click del boton de crear nuevos objetos
            $("#btn_save_material").click(function() {
                //si este div esta ya esta visible debido a que el usuario no metio los datos correctos para que se guarde
                $("#newmaterial_error").slideUp();
                //para que el boton de guardado tenga animacion de cargando
                $("#btn_save_material").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                //guardamos los inputs del formulario en un array
                data = $("#frm_new_material").serializeArray();
                //log
                console.info(data);
                //comprobamos si los campos required estan llenos
                if (formularioMaterialesLleno(data)) {
                    //si es true ejecutamos el script al que targeteamos
                    $.ajax({
                        type: "POST",
                        url: "saveMaterial.php",
                        data: data,
                        dataType: "text",
                        //si la peticion se ejecuta con exito
                        success: function(response) {

                            console.log(response);
                            // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                            $('#frm_new_material').trigger("reset");
                            $("#btn_save_material").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            $("#newmaterial_success").slideDown();
                            setTimeout(function() {
                                $("#newmaterial_success").fadeOut("slow");
                                //console.log(response[0].id);
                                $('#addmaterial_model').modal('hide');
                                // refrescar subventana;
                                $("#materiales_grid").bootgrid('reload');
                                //window.location.reload();
                            }, 1000);

                        }
                    });
                    //si los inputs requeridos no estan llenos
                }else{
                    //log
                    console.info("rellena los canpos cabron");
                    //animacion 
                    $("#btn_save_material").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                    //mensaje de error
                    $("#newmaterial_error").slideDown();

                }
            });

            $("#btn_tarifas").click(function() {
                $("#tarifas_modal").modal("show");
            });

            function ajaxAction(action) {
                data = $("#frm_" + action).serializeArray();
                //console.log(data);
                $.ajax({
                    type: "POST",
                    url: "responsetarifas.php",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        //alert (response);
                        console.log(response);

                        $('#' + action + '_modal').modal('hide');
                        $("#tarifas_grid").bootgrid('reload');
                        $('#frm_add').trigger("reset");
                        $('.selectpicker').selectpicker();
                        $('.selectpicker').selectpicker('render');
                        $('.selectpicker').selectpicker('refresh');
                        $('#frm_edit').trigger("reset");
                        //window.location.reload();
                    }
                });
            }

            $("#btn_descuentos").click(function() {
                $("#dto_modal").modal("show");
            });

            function ajaxActionDto(action) {
                data = $("#frm_" + action + "_dto").serializeArray();
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: "responsedto.php",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        //alert (response);
                        //console.log(response);

                        $('#' + action + '_dto_modal').modal('hide');
                        $("#dto_grid").bootgrid('reload');
                        $('#frm_add_dto').trigger("reset");
                        $('#frm_edit_dto').trigger("reset");
                    }
                });
            }

            $("#btn_edit_tarifa").click(function() {
                ajaxAction('edit');
            });
            $("#btn_new_tarifa").click(function() {
                ajaxAction('add');
            });
            $("#command-add").click(function() {
                $("#newtarifa_materialid").val($("#newmaterial_idmaterial").val());
                $('#add_modal').modal('show');
            });
            $("#btn_edit_dto").click(function() {
                ajaxActionDto('edit');
            });
            $("#btn_new_dto").click(function() {
                ajaxActionDto('add');
            });
            $("#command-add-dto").click(function() {
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
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_material').trigger("reset");
                        $("#btn_del_material").html('<span class="glyphicon glyphicon-floppy-disk"></span> Eliminar');
                        $("#newmaterial_success").slideDown();
                        setTimeout(function() {
                            $("#newmaterial_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }
                });
            });
            $("#add-sn").click(function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $("#mat_container").show();
                    $("#sn_container").hide();
                    $("#material_sn").val("0");
                } else {
                    $(this).addClass('active');
                    $("#mat_container").hide();
                    $("#sn_container").show();
                    $("#material_sn").val("1");
                }
            });
            $(document).on("keyup", "#newmaterial_ref", function() {
                //$("#newmaterial_ref").keyup(function(){
                console.log("Valor ref: " + $(this).val());
                $.ajax({
                    type: "GET",
                    url: "buscarRefDuplicado.php",
                    data: {
                        textonuevo: $(this).val(),
                        idmat: $("#newmaterial_idmaterial").val()
                    },
                    dataType: "text",
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        console.log("REF DUPLICADO: " + response);
                        if (response == 1) {
                            $("#alerta-ref-duplicado").show();
                        } else {
                            $("#alerta-ref-duplicado").hide();
                        }
                        setTimeout(function() {
                            $("#newmaterial_success").fadeOut("slow");
                            //console.log(response[0].id);
                            //window.location.reload();
                        }, 2000);
                    }
                });
                console.log("FIN.");
            });
            // /MATERIALES

            // VER STOCK
            $("#ver-stock").click(function() {
                // dash-materiales -> vistas/tabla-materiales
                // show modal
                $('#view_stock_model').modal('show');
            });
            // /VER STOCK

            // CARGAR FILTROS
            loadSelectMaterialAlmacen("filter_material_ref", "ref");
            loadSelectMaterialAlmacen("filter_material_nombre", "material");
            // / CARGAR FILTROS

            // CAMBIOS DE FILTRO/BUSQUEDA
            // Filtros material almacen proyecto
            $('#filter_material_ref').on('changed.bs.select', function(e) {
                $(this).parent().children("button").addClass("filter-selected");
                console.log("OK" + $(this).val());
                $.ajax({
                    type: "POST",
                    url: "saveTablaMateriales.php",
                    data: {
                        valor: $(this).val(),
                        actualizar: 1
                    },
                    dataType: "text",
                    success: function(response) {
                        console.log(response);
                        $("#tabla_stock").html(response);
                        //                        console.log("docs ofertas");
                        //                        initTree(response, "treeview_json_docsOfertas");
                        //                        $("#docs_oferta_model").modal('show');
                    }
                });
            });
            $('#filter_material_nombre').on('changed.bs.select', function(e) {
                //$(this).parent().children("button").addClass("filter-selected");
                console.log("OK" + $(this).val());
                $.ajax({
                    type: "POST",
                    url: "saveTablaMateriales.php",
                    data: {
                        valor: $(this).val(),
                        actualizar: 1
                    },
                    dataType: "text",
                    success: function(response) {
                        console.log(response);
                        $("#tabla_stock").html(response);
                        //                        console.log("docs ofertas");
                        //                        initTree(response, "treeview_json_docsOfertas");
                        //                        $("#docs_oferta_model").modal('show');
                    }
                });
            });
            //clean-filters
            $("#clean-filters").click(function() {
                $("#filter_material_ref").selectpicker("val", "");
                $("#filter_material_ref").parent().children("button").removeClass("filter-selected");
                $("#filter_material_nombre").selectpicker("val", "");
                $("#filter_material_nombre").parent().children("button").removeClass("filter-selected");
                $.ajax({
                    type: "POST",
                    url: "saveTablaMateriales.php",
                    data: {
                        valor: 0,
                        actualizar: 1
                    },
                    dataType: "text",
                    success: function(response) {
                        //console.log(response);
                        $("#tabla_stock").html(response);
                    }
                });

            });
            // / CAMBIOS DE FILTRO/BUSQUEDA

            // btn add stock
            $("#btn_add_stock_modal").click(function() {
                //$("#add_material_id").val($("newmaterial_idmaterial").val());
                $("#addstock_modal").modal("show");
            });

            $("#btn_add_stock").click(function() {
                $.ajax({
                    type: "POST",
                    url: "saveMaterial.php",
                    data: {
                        add_material_stock: 1,
                        cantidad: $("#add_stock").val(),
                        material_id: $("#newmaterial_idmaterial").val()
                    },
                    dataType: "text",
                    success: function(response) {
                        console.log(response);
                        window.location.reload();
                        //$("#tabla_stock").html(response);
                    }
                });
            });

            $(document).on("click", "#btn_view_mat_ped_alm", function() {
                //$("#btn_view_mat_ped_alm").click(function() {
                //console.log("kk");
                window.open(
                    "/erp/apps/material/?matid=" + $(this).data("id"),
                    "_blank"
                );
            });


        });


        function delTar(id) {
            var r = confirm("¿Está seguro de que desea eliminar la tarifa?");
            if (r == true) {
                $.post('responsetarifas.php', {
                    id: id,
                    action: 'delete'
                }, function() {
                    // when ajax returns (callback), 
                    $("#tarifas_grid").bootgrid('reload');
                });
            }
        }

        function delDto(id) {
            var r = confirm("¿Está seguro de que desea eliminar el descuento?");
            if (r == true) {
                $.post('responsedto.php', {
                    id: id,
                    action: 'delete'
                }, function() {
                    // when ajax returns (callback), 
                    $("#dto_grid").bootgrid('reload');
                });
            }
        }

        function toolTipCeldas() {
            $("#materiales_grid").children("tbody").children("tr").each(function() {
                var str = $(this).children("td:nth-child(3)").html();
                var res = str.substr(0, 58) + " ...";
                $(this).children("td:nth-child(3)").html(res);
                $(this).children("td:nth-child(3)").attr("title", str);
            });
        }


        function loadGrid() {
            $("#materiales_grid").bootgrid('destroy');
            $("#command-add").prop("disabled", false);
            console.log("Ini LOAD GRIG");
            // dont show materiales_grid
            // show div loader!
            $("#materiales_grid").hide();
            $("#loading-materiales").show();

            var grid = $("#materiales_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function() {
                    /* To accumulate custom parameter with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
                },

                url: "responseMateriales.php",
                data: {

                },
                formatters: {
                    "commands": function(column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.material + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " +
                            "<button type=\"button\" class=\"btn btn-xs btn-default command-pedidos\" data-row-id=\"" + row.material + "\" title=\"Pedidos\"><span class=\"glyphicon glyphicon-random\"></span></button>" +
                            "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.material + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function() {
                toolTipCeldas();
                $("#materiales_grid").show();
                $("#loading-materiales").hide();
                /* Executes after data is loaded and rendered */
                //$("#command-download").prop("disabled", false);

                grid.find(".command-edit").on("click", function(e) {
                    $("#div-ultimoprecio").show();
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();

                    //console.log(grid.data());//
                    $('#addmaterial_model').modal('show');

                    if ($(this).data("row-id") > 0) {
                        // Ocultar alerta ref duplicado
                        $("#alerta-ref-duplicado").hide();
                        // collect the data
                        $('#newmaterial_idmaterial').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#newmaterial_ref').val(ele.siblings(':nth-of-type(2)').html().replace(/&nbsp;/gi, ''));
                        //$('#newmaterial_nombre').val(ele.siblings(':nth-of-type(3)').html().replace(/&nbsp;/gi,''));
                        $('#newmaterial_nombre').val(ele.siblings(':nth-of-type(3)').attr("title").replace(/&nbsp;/gi, ''));
                        $('#newmaterial_fabricante').val(ele.siblings(':nth-of-type(4)').html().replace(/&nbsp;/gi, ''));
                        $('#newmaterial_modelo').val(ele.siblings(':nth-of-type(5)').html().replace(/&nbsp;/gi, ''));
                        $('#newmaterial_lastprice').val(ele.siblings(':nth-of-type(6)').html().replace(/&nbsp;/gi, ''));
                        $('#newmaterial_dto').val(ele.siblings(':nth-of-type(7)').html().replace(/&nbsp;/gi, ''));
                        $('#newmaterial_stock').val(ele.siblings(':nth-of-type(8)').html().replace(/&nbsp;/gi, ''));
                        loadMaterialesStock("newmaterial_stock", ele.siblings(':first').html());
                        //$("#material_categoria_id").val(ele.siblings(':nth-of-type(11)').html().replace(/&nbsp;/gi,''));
                        $("#materiales_categoria1").selectpicker('val', ele.siblings(':nth-of-type(11)').html());
                        $("#newmaterial_desc").val(ele.siblings(':nth-of-type(12)').html().replace(/&nbsp;/gi, ''));
                        $("#newmaterial_sustituto").val(ele.siblings(':nth-of-type(10)').html().replace(/&nbsp;/gi, ''));
                        loadSelect("newmaterial_materiales", "MATERIALES", "id", "categoria_id", ele.siblings(':nth-of-type(11)').html().replace(/&nbsp;/gi, ''), "ref");
                        setTimeout(function() {
                            $("#materiales_categoria1").selectpicker('val', ele.siblings(':nth-of-type(11)').html());
                            $("#newmaterial_materiales").selectpicker("val", ele.siblings(':first').html());
                            $('.selectpicker').selectpicker('refresh');
                            loadGridTarifas($("#newmaterial_idmaterial").val()); //cargo el grid de las tarifas
                        }, 500);
                        //$("#tarifaedit_proveedor").selectpicker("refresh");
                        //$("#tarifaedit_proveedor").selectpicker("render");                       
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                }).end().find(".command-pedidos").on("click", function(e) {
                    //window.location.href = "/erp/apps/material/?matid=" + $(this).data("row-id");
                    window.open(
                        "/erp/apps/material/?matid=" + $(this).data("row-id"),
                        "_blank"
                    );
                }).end().find(".command-delete").on("click", function(e) {
                    delTar($(this).data("row-id"));
                });
            });
            //$("#employee_grid").bootgrid('reload');		
        };

        function loadGridDto(proveedor_id) {
            $("#dto_grid").bootgrid('destroy');
            $("#command-add-dto").prop("disabled", false);

            var grid = $("#dto_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function() {
                    /* To accumulate custom parameter with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
                },

                url: "responsedto.php?proveedor_id=" + proveedor_id,
                data: {
                    proveedor_id: proveedor_id
                },
                formatters: {
                    "commands": function(column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " +
                            "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function() {
                /* Executes after data is loaded and rendered */
                //$("#command-download").prop("disabled", false);

                grid.find(".command-edit").on("click", function(e) {
                    $("#div-ultimoprecio").show();
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();

                    //console.log(grid.data());//
                    $('#edit_dto_modal').modal('show');

                    if ($(this).data("row-id") > 0) {
                        // collect the data
                        $('#edit_dto_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#dtoedit_fechaval').val(ele.siblings(':nth-of-type(2)').html().replace(/&nbsp;/gi, ''));
                        $('#dtoedit_dto').val(ele.siblings(':nth-of-type(3)').html().replace(/&nbsp;/gi, ''));
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                }).end().find(".command-delete").on("click", function(e) {
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

        function loadGridTarifas(material_id) {
            $("#tarifas_grid").bootgrid('destroy');
            $("#command-add").prop("disabled", false);

            var grid = $("#tarifas_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function() {
                    /* To accumulate custom parameter with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
                },

                url: "responsetarifas.php?material_id=" + material_id,
                data: {
                    material_id: material_id
                },
                formatters: {
                    "commands": function(column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " +
                            "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function() {
                /* Executes after data is loaded and rendered */
                //$("#command-download").prop("disabled", false);

                grid.find(".command-edit").on("click", function(e) {
                    $("#div-ultimoprecio").show();
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();

                    //console.log(grid.data());//
                    $('#edit_modal').modal('show');

                    if ($(this).data("row-id") > 0) {
                        // collect the data
                        $('#edit_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        $('#tarifaedit_fechaval').val(ele.siblings(':nth-of-type(3)').html().replace(/&nbsp;/gi, ''));
                        $('#tarifaedit_tarifa').val(ele.siblings(':nth-of-type(4)').html().replace(/&nbsp;/gi, ''));
                        $('#tarifaedit_dto').val(ele.siblings(':nth-of-type(5)').html().replace(/&nbsp;/gi, ''));
                        $('#tarifaedit_proveedor').val(ele.siblings(':nth-of-type(6)').html().replace(/&nbsp;/gi, ''));
                        $("#tarifaedit_proveedor").selectpicker("refresh");
                        $("#tarifaedit_proveedor").selectpicker("render");
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                }).end().find(".command-delete").on("click", function(e) {
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

        // this function must be defined in the global scope
        function fadeIn(obj) {
            $(obj).fadeIn(3000);
        };
        //funcion para sber si los inputs estan llenos
        function formularioMaterialesLleno(data){
            //se revisan que el campo de categoria, referencia y nombre esten llenos al contrario devuelve false
            if(data[4].value != "" && data[10].value != "" && data[11].value != ""){
                return true;
            }else{
                return false;
            }
        } 
  
    </script>

    <title>Materiales | Erp GENELEK</title>
</head>

<body>
    <div id="cover">
        <div class="box">
            <img src="/erp/img/logo.png" class="spinnerlogo">
            <img src="/erp/img/loading.gif" class="spinner">
        </div>
    </div>
    <!--rest of the page... -->
    <? include($pathraiz . "/includes/header.php"); ?>

    <section id="contenido">
        <div id="erp-titulo" class="one-column">
            <h3>
                Material
            </h3>
        </div>
        <div id="dash-header">
            <div id="proyectos-filterbar" class="one-column">
                <? //include($pathraiz."/apps/material/vistas/filtros.php"); 
                ?>
            </div>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="one-column">
                <h4 class="dash-title">
                    TODOS LOS MATERIALES
                    <? include($pathraiz . "/apps/material/includes/tools-material.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-materiales" style="padding:10px;">
                    <? include($pathraiz . "/apps/material/vistas/tabla-materiales.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>


    </section>

</body>

</html>