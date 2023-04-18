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

    <!-- Bootstrap Treeview
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
    -->
    <link rel="stylesheet" href="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
    <script type="text/javascript" charset="utf8" src="/erp/includes/plugins/bootstrap-treeview/1.2.0/bootstrap-treeview.js"></script>

    <!-- custom js -->
    <script src="/erp/functions.js"></script>

    <!-- Bootstrap Grid -->
    <script src="/erp/includes/bootstrap/jquery.bootgrid.min.js"></script>
    <!-- Bootstrap switch -->
    <link href="/erp/plugins/bootstrap-switch.min.css" rel="stylesheet">
    <script src="/erp/plugins/bootstrap-switch.min.js"></script>
    <!-- File input -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="/erp/includes/plugins/fileinput/js/locales/es.js"></script>

    <script>
        $(window).load(function() {
            $('#cover').fadeOut('slow').delay(5000);
        });

        $(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce', 3000);
            });

            filesUpload = [];

            $('#uploaddocs_audit').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form,
                    files = data.files,
                    extra = data.extra,
                    response = data.response,
                    reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);

                /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */

                //console.log("fichero-subido - " + $("#fichero_subido").val());

                $.post("processUpload_audit.php", {
                        pathFile: data.response.uploaded,
                        nombre: $("#auditores_docnombre").val(),
                        descripcion: $("#auditores_docdesc").val(),
                        auditor_id: $("#newauditor_idauditor").val()
                    })
                    .done(function(data1) {
                        //alert( "ok" );
                        window.location.reload();
                    });

            });
            $('#uploaddocs').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form,
                    files = data.files,
                    extra = data.extra,
                    response = data.response,
                    reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);

                /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */

                //console.log("fichero-subido - " + $("#fichero_subido").val());

                $.post("processUpload.php", {
                        pathFile: data.response.uploaded,
                        nombre: $("#proveedores_docnombre").val(),
                        descripcion: $("#proveedores_docdesc").val(),
                        proveedor_id: $("#newproveedor_idproveedor").val()
                    })
                    .done(function(data1) {
                        //alert( "ok" );
                        window.location.reload();
                    });

            });
            $('#uploaddocs_cli').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form,
                    files = data.files,
                    extra = data.extra,
                    response = data.response,
                    reader = data.reader;
                //console.log('File uploaded triggered');
                //console.log(data.response.uploaded);
                filesUpload.push(data.response.uploaded);

                /* A PARTIR DE AQUI PROCESAR LA INSERT EN BASE DE DATOS */

                //console.log("fichero-subido - " + $("#fichero_subido").val());

                $.post("processUpload_cli.php", {
                        pathFile: data.response.uploaded,
                        nombre: $("#clientes_docnombre").val(),
                        descripcion: $("#clientes_docdesc").val(),
                        proveedor_id: $("#newcliente_idcliente").val(),
                        cliente_id: $("#newcliente_idcliente").val()
                    })
                    .done(function(data1) {
                        //alert( "ok" );
                        window.location.reload();
                    });

            });

            <?
            if ($_GET['v'] == "c") {
                echo "$('#menuitem-clientes').addClass('active');";
                echo "loadGridCli();";
            } elseif ($_GET['v'] == "p") {
                echo "$('#menuitem-proveedores').addClass('active');";
                echo "loadGridProv();";
            } else {
                echo "$('#menuitem-auditores').addClass('active');";
                echo "loadGridAudit();";
            }
            ?>
            $("#add-auditor").click(function() {
                $('#frm_new_auditor').trigger("reset");
                $('#treeview_json').treeview({
                    data: "",
                    enableLinks: true,
                    state: {
                        checked: true,
                        disabled: true,
                        expanded: true,
                        selected: true
                    },
                });
                $("#addauditor_model").modal('show');
            });
            $("#add-proveedor").click(function() {
                $('#frm_new_proveedor').trigger("reset");
                $('#treeview_json').treeview({
                    data: "",
                    enableLinks: true,
                    state: {
                        checked: true,
                        disabled: true,
                        expanded: true,
                        selected: true
                    },
                });
                $("#addproveedor_model").modal('show');
            });
            $("#add-cliente").click(function() {
                $('#frm_new_cliente').trigger("reset");
                $('#treeview_json').treeview({
                    data: "",
                    enableLinks: true,
                    state: {
                        checked: true,
                        disabled: true,
                        expanded: true,
                        selected: true
                    },
                });
                $('#cliente_instalaciones').hide();
                $("#newcliente_idcliente").val("");
                $("#addcliente_model").modal('show');
            });
            // AUDITORES
            $('#cmbauditores_auditores').on('changed.bs.select', function(e) {
                loadAuditorInfo($(this).val(), "AUDITORES");
                //loadGridDto($(this).val()); //cargo el grid de las terifas 
            });
            $("#btn_save_auditor").click(function() {
                $("#btn_save_auditor").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_new_auditor").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "saveAuditor.php",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        //alert(response);
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_auditor').trigger("reset");
                        $("#btn_save_auditor").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newauditor_success").slideDown();
                        setTimeout(function() {
                            $("#newauditor_success").fadeOut("slow");
                            //console.log(response[0].id);
                            $("#auditores_grid").bootgrid("reload");
                            $("#addauditor_model").modal('hide');
                            //window.location.reload();
                        }, 2000);
                    }
                });
            });
            $("#btn_del_auditor").click(function() {
                $("#btn_del_auditor").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#auditor_del").val($("#newauditor_idauditor").val());
                data = $("#frm_new_auditor").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "saveAuditor.php",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_auditor').trigger("reset");
                        $("#btn_del_auditor").html('<span class="glyphicon glyphicon-floppy-disk"></span> Eliminar');
                        $("#newauditor_success").slideDown();
                        setTimeout(function() {
                            $("#newauditor_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }
                });
            });
            // /AUDITORES
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
                    dataType: "json",
                    success: function(response) {
                        //alert(response);
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_proveedor').trigger("reset");
                        $("#btn_save_proveedor").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newproveedor_success").slideDown();
                        setTimeout(function() {
                            $("#newproveedor_success").fadeOut("slow");
                            //console.log(response[0].id);
                            $("#proveedores_grid").bootgrid("reload");
                            $("#addproveedor_model").modal('hide');
                            //window.location.reload();
                        }, 2000);
                    }
                });
            });
            $("#btn_del_proveedor").click(function() {
                $("#idprovedor_del").val($("#newproveedor_idproveedor").val());
                $("#confirm_delete_proveedor").modal("show");
            });
            $("#delete_proveedor").click(function() {
                $("#btn_del_proveedor").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                //$("#proveedor_del").val($("#newproveedor_idproveedor").val());
                //data = $("#frm_new_proveedor").serializeArray();
                console.log("kk44: " + $("#idprovedor_del").val());
                $.ajax({
                    type: "POST",
                    url: "saveProveedor.php",
                    data: {
                        proveedor_del: $("#idprovedor_del").val()
                    },
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

            // CLIENTES
            $('#cmbclientes_clientes').on('changed.bs.select', function(e) {
                loadProyectosClientes($(this).val());
            });
            $("#btn_save_cliente").click(function() {
                $("#btn_save_cliente").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                formData = new FormData($("#frm_new_cliente")[0]);
                $.ajax({
                    type: "POST",
                    url: "saveCliente.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_cliente').trigger("reset");
                        $("#btn_save_cliente").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#newcliente_success").slideDown();
                        setTimeout(function() {
                            $("#newcliente_success").fadeOut("slow");
                            //console.log(response[0].id);
                            $("#clintes_grid").bootgrid("reload");
                            $("#addcliente_model").modal('hide');
                            //window.location.reload();
                        }, 2000);
                    }
                });
            });
            $("#btn_del_cliente").click(function() {
                $("#idcliente_del").val($("#newcliente_idcliente").val());
                $("#confirm_delete_cliente").modal("show");
            });
            $("#del_cliente").click(function() {
                $("#btn_del_cliente").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Eliminando ...');
                $("#cliente_del").val($("#newproveedor_idcliente").val());
                data = $("#frm_new_cliente").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "saveCliente.php",
                    data: {
                        cliente_del: $("#idcliente_del").val()
                    },
                    dataType: "json",
                    success: function(response) {
                        // Guardo la oferta nueva y devuelvo en response el id asignado a la oferta nueva
                        $('#frm_new_cliente').trigger("reset");
                        $("#btn_del_cliente").html('<span class="glyphicon glyphicon-floppy-disk"></span> Eliminar');
                        $("#newcliente_success").slideDown();
                        setTimeout(function() {
                            $("#newcliente_success").fadeOut("slow");
                            //console.log(response[0].id);
                            window.location.reload();
                        }, 2000);
                    }
                });
            });
            // /CLIENTES
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
                        //console.log(response);

                        $('#' + action + '_modal').modal('hide');
                        $("#tarifas_grid").bootgrid('reload');
                        $('#frm_add').trigger("reset");
                        $('#frm_edit').trigger("reset");
                    }
                });
            }

            $("#btn_descuentos").click(function() {
                $("#dto_modal").modal("show");
            });

            function ajaxActionDto(action) {
                data = $("#frm_" + action + "_dto").serializeArray();
                //console.log(data);
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
            $("#add-documento-audit").click(function() {
                $("#auditores_adddoc_model").modal('show');
                $("#uploaddocs_audit").fileinput({
                    uploadUrl: "upload_docaudit.php?id_auditor=" + $("#newauditor_idauditor").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500,
                    language: "es"
                });
            });
            $("#add-documento").click(function() {
                $("#proveedores_adddoc_model").modal('show');
                $("#uploaddocs").fileinput({
                    uploadUrl: "upload.php?id_proveedor=" + $("#newproveedor_idproveedor").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500,
                    language: "es"
                });
            });
            $("#add-documento-cli").click(function() {
                $("#clientes_adddoc_model").modal('show');
                $("#uploaddocs_cli").fileinput({
                    uploadUrl: "upload_doccli.php?id_cliente=" + $("#newcliente_idcliente").val(),
                    dropZoneEnabled: true,
                    maxFileCount: 500,
                    language: "es"
                });
            });

            $("#btn-ver-instalaciones").click(function() {
                if ($("#cliente_instalaciones").is(':visible')) {
                    $("#cliente_instalaciones").hide();
                } else {
                    //data = $("#frm_indicador").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "cliente_instalaciones.php",
                        data: {
                            id_cli: $('#newcliente_idcliente').val()
                        },
                        dataType: "text",
                        success: function(response) {
                            //console.log(response);
                            $("#cliente_instalaciones").html(response);
                            //$(".save-editar-indicador-anyo").hide();
                            //$(".indicador_anteriores_valor_nuevo").hide();
                            $(".cliente_instalacion_nombre_nuevo").hide();
                            $(".cliente_instalacion_nuevo").hide();
                            $("#cliente_instalaciones").show();
                            //$('#frm_proceso').trigger("reset");
                            //$("#btn_proceso_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                            setTimeout(function() {
                                //window.location.reload();
                            }, 1000);
                        }
                    });
                }
            });

            $(document).on("click", ".editar-cliente-instalacion", function() {
                // Ocultar
                $('#editar-cliente-instalacion' + $(this).val()).hide();
                $('#txt_indicador_anteriores_valor_nuevo' + $(this).val()).hide();
                $('#txt_cliente_instalacion_nombre_nuevo' + $(this).val()).hide();
                // Settear valores
                var valortxt = $('#txt_indicador_anteriores_valor_nuevo' + $(this).val()).text();
                $('#cliente_instalacion_nuevo' + $(this).val()).val(valortxt);
                var valortxt2 = $('#txt_cliente_instalacion_nombre_nuevo' + $(this).val()).text();
                $('#cliente_instalacion_nombre_nuevo' + $(this).val()).val(valortxt2);
                // Mostrar
                $('#cliente_instalacion_nuevo' + $(this).val()).show();
                $('#cliente_instalacion_nombre_nuevo' + $(this).val()).show();
                $('#save-editar-cliente-instalacion' + $(this).val()).show();
            });
            $(document).on("click", ".save-editar-cliente-instalacion", function() {
                var txt_inst_nom = $("#cliente_instalacion_nombre_nuevo" + $(this).val()).val();
                var txt_inst_direc = $("#cliente_instalacion_nuevo" + $(this).val()).val();
                // Mostar
                $('#editar-cliente-instalacion' + $(this).val()).show();
                $('#txt_indicador_anteriores_valor_nuevo' + $(this).val()).show();
                $('#txt_cliente_instalacion_nombre_nuevo' + $(this).val()).show();
                // Ocultar
                $('#cliente_instalacion_nuevo' + $(this).val()).hide();
                $('#cliente_instalacion_nombre_nuevo' + $(this).val()).hide();
                $('#save-editar-cliente-instalacion' + $(this).val()).hide();
                $.ajax({
                    type: "POST",
                    url: "saveClienteInstalaciones.php",
                    data: {
                        id_cli: $('#newcliente_idcliente').val(),
                        id_inst: $(this).val(),
                        inst_cli_nom: txt_inst_nom,
                        inst_cli_direc: txt_inst_direc
                    },
                    dataType: "text",
                    success: function(response) {
                        $("#cliente_instalaciones").hide();
                        $("#btn-ver-instalaciones").click();
                        setTimeout(function() {
                            //window.location.reload();
                        }, 1000);
                    }
                });
            });

            $(document).on("click", "#add-instalacion-cliente", function() {
                $.ajax({
                    type: "POST",
                    url: "saveClienteInstalaciones.php",
                    data: {
                        id_cli: $('#newcliente_idcliente').val()
                    },
                    dataType: "text",
                    success: function(response) {
                        $("#cliente_instalaciones").hide();
                        $("#btn-ver-instalaciones").click();
                        setTimeout(function() {
                            //window.location.reload();
                        }, 1000);
                    }
                });
            });

            $(document).on("click", "#borrar-cliente-instalacion", function() {
                var r = confirm("Estas seguro de que quieres Borrar?");
                if (r == true) {
                    $.ajax({
                        type: "POST",
                        url: "saveClienteInstalaciones.php",
                        data: {
                            id_cli_bor: $('#newcliente_idcliente').val(),
                            id_inst_bor: $(this).val()
                        },
                        dataType: "text",
                        success: function(response) {
                            $("#cliente_instalaciones").hide();
                            $("#btn-ver-instalaciones").click();
                            setTimeout(function() {
                                //window.location.reload();
                            }, 1000);
                        }
                    });
                }

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

        function loadGridAudit() {
            $("#auditores_grid").bootgrid('destroy');
            $("#commandaudit-add").prop("disabled", false);

            var grid = $("#auditores_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function() {
                    /* To accumulate custom parameter with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
                },

                url: "responseAuditores.php",
                data: {

                },
                formatters: {
                    "commands": function(column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default commandaudit-edit\" data-row-id=\"" + row.id + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " +
                            "<button type=\"button\" class=\"btn btn-xs btn-default commandaudit-pedidos\" data-row-id=\"" + row.id + "\" title=\"Pedidos al?¿ Proveedor\"><span class=\"glyphicon glyphicon-random\"></span></button>" +
                            "<button type=\"button\" class=\"btn btn-xs btn-default commandaudit-delete\" data-row-id=\"" + row.id + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function() {
                //$("#command-download").prop("disabled", false);

                grid.find(".commandaudit-edit").on("click", function(e) {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();
                    console.log($(this).parent().parent().data("row-id"));
                    //console.log(grid.data());//
                    $('#addauditor_model').modal('show');

                    if ($(this).parent().parent().data("row-id") > 0) {
                        // collect the data
                        $('#newauditor_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        loadAuditorInfo(ele.siblings(':first').html(), "AUDITORES");
                        setTimeout(function() {
                            loadGridDto(ele.siblings(':first').html());
                        }, 1000);

                        // CARGA DEL ARBOL DE DOCUMENTOS
                        var treeData;

                        console.log("start");
                        $.ajax({
                            type: "GET",
                            url: "responseDocsAudit.php",
                            data: {
                                id: ele.siblings(':first').html()
                            },
                            dataType: "json",
                            success: function(response) {
                                console.log("ok");
                                initTree(response, "treeview_json");
                            }
                        });

                        function initTree(treeData, treeElement) {
                            console.log(treeData);
                            console.log(treeElement);
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
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                }).end().find(".commandaudit-pedidos").on("click", function(e) {

                    window.open(
                        "/erp/apps/material/?audit=" + $(this).data("row-id"),
                        "_blank"
                    );
                }).end().find(".commandaudit-delete").on("click", function(e) {
                    delProv($(this).data("row-id"));
                });
            });
            //$("#employee_grid").bootgrid('reload');		
        };
        $(document).on("click", ".delDoc", function() {
            $("#del_doc_id").val($(this).data("id"));
            $("#confirm_del_doc_modal").modal("show");
        });
        $(document).on("click", "#confirm-del-doc", function() {

            <?
            if ($_GET['v'] == "c") {
                echo '$.ajax({
                        type : "POST",
                        url : "processUpload_cli.php",
                        dataType : "text",
                        data: {
                            delDoc : $("#del_doc_id").val()
                        },
                        success : function(data){
                            //alert(data);
                            //console.log("ok");
                            //window.location.reload();
                            $("#addcliente_model").modal("hide");
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("ERROR");
                        }
                        });';
            } else {
                echo '$.ajax({
                        type : "POST",
                        url : "processUpload.php",
                        dataType : "text",
                        data: {
                            delDoc : $("#del_doc_id").val()
                        },
                        success : function(data){
                            //alert(data);
                            //console.log("ok");
                            //window.location.reload();
                            $("#addproveedor_model").modal("hide");
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("ERROR");
                        }
                        });';
            }
            ?>;
            $.ajax({
                type: "POST",
                url: "processUpload.php",
                dataType: "text",
                data: {
                    delDoc: $("#del_doc_id").val()
                },
                success: function(data) {

                    window.location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("ERROR");
                }
            });
        });

        function loadGridProv() {
            $("#proveedores_grid").bootgrid('destroy');
            $("#commandprov-add").prop("disabled", false);

            var grid = $("#proveedores_grid").bootgrid({
                ajax: true,
                rowSelect: true,
                post: function() {
                    /* To accumulate custom parameter with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
                },

                url: "responseProveedores.php",
                data: {

                },
                formatters: {
                    "contacts": function(column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default commandprov-contacts\" data-row-id=\"" + row.id + "\" title=\"Contactos\"><span class=\"glyphicon glyphicon-phone\"></span></button>";
                    },
                    "commands": function(column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default commandprov-edit\" data-row-id=\"" + row.id + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " +
                            "<button type=\"button\" class=\"btn btn-xs btn-default commandprov-pedidos\" data-row-id=\"" + row.id + "\" title=\"Pedidos al Proveedor\"><span class=\"glyphicon glyphicon-random\"></span></button>" +
                            "<button type=\"button\" class=\"btn btn-xs btn-default commandprov-delete\" data-row-id=\"" + row.id + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>"+
                            "<button type=\"button\" class=\"btn btn-xs btn-default commandprov-contacts\" data-row-id=\"" + row.id + "\" title=\"Contactos\"><span class=\"glyphicon glyphicon-phone\"></span></button>";
                    },
                }
            }).on("loaded.rs.jquery.bootgrid", function() {


                grid.find(".commandprov-edit").on("click", function(e) {

                    var ele = $(this).parent();

                    //console.log(grid.data());//
                    $('#addproveedor_model').modal('show');

                    if ($(this).data("row-id") > 0) {
                        // collect the data
                        $('#newproveedor_id').val(ele.siblings(':first').html()); // in case we're changing the key
                        loadProveedorInfo(ele.siblings(':first').html(), "PROVEEDORES");
                        setTimeout(function() {
                            loadGridDto(ele.siblings(':first').html());
                        }, 1000);

                        // CARGA DEL ARBOL DE DOCUMENTOS
                        var treeData;

                        console.log("start");
                        $.ajax({
                            type: "GET",
                            url: "responseDocs.php",
                            data: {
                                id: ele.siblings(':first').html()
                            },
                            dataType: "json",
                            success: function(response) {
                                console.log("ok");
                                initTree(response, "treeview_json");
                            }
                        });

                        function initTree(treeData, treeElement) {
                            console.log(treeData);
                            console.log(treeElement);
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
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                }).end().find(".commandprov-pedidos").on("click", function(e) {
                    window.open(
                        "/erp/apps/material/?prov=" + $(this).data("row-id"),
                        "_blank"
                    );
                }).end().find(".commandprov-delete").on("click", function(e) {
                    delProv($(this).data("row-id"));
                }).end().find(".commandprov-contacts").on("click", function(e) {
                    $("#contacts_modal").modal("show");
                    rowid = ($(this).data("row-id"));
                    loadContacts(rowid,"p");
                    form_add_contact = $("#add_contact_form");
                    $("#show-more-add-contact").on("click", function(e) {
                        form_add_contact.slideDown();
                    });
                    $("#show-less-add-contact").on("click", function(e) {
                        form_add_contact.slideUp();
                    });
                    $("#btn_save_contacto").on("click", function(e) {
                        console.log("estamos arriba" + rowid);
                        newcontact(rowid,"p");


                    });

                });
            });
        };
        $(document).on("click", ".delDoc", function() {
            $("#del_doc_id").val($(this).data("id"));
            $("#confirm_del_doc_modal").modal("show");
        });
        $(document).on("click", "#confirm-del-doc", function() {

            <?
            if ($_GET['v'] == "c") {
                echo '$.ajax({
                        type : "POST",
                        url : "processUpload_cli.php",
                        dataType : "text",
                        data: {
                            delDoc : $("#del_doc_id").val()
                        },
                        success : function(data){
                            //alert(data);
                            //console.log("ok");
                            //window.location.reload();
                            $("#addcliente_model").modal("hide");
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("ERROR");
                        }
                        });';
            } else {
                echo '$.ajax({
                        type : "POST",
                        url : "processUpload.php",
                        dataType : "text",
                        data: {
                            delDoc : $("#del_doc_id").val()
                        },
                        success : function(data){
                            //alert(data);
                            //console.log("ok");
                            //window.location.reload();
                            $("#addproveedor_model").modal("hide");
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("ERROR");
                        }
                        });';
            }
            ?>;
            $.ajax({
                type: "POST",
                url: "processUpload.php",
                dataType: "text",
                data: {
                    delDoc: $("#del_doc_id").val()
                },
                success: function(data) {

                    window.location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("ERROR");
                }
            });
        });

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
                grid.find(".command-edit").on("click", function(e) {
                    var ele = $(this).parent();

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

                    delDto($(this).data("row-id"));

                });
            });
        };

        function loadGridCli() {
            //The bootgrid plugin is a jQuery plugin that provides a grid control to display data in a table-like format.
            //destroy' method, the plugin instance is removed and any associated events and data are cleaned up.
            $("#clintes_grid").bootgrid('destroy');
            //setting the "disabled" property to false, the button is now enabled and can be clicked to trigger the add client action.
            $("#commandcli-add").prop("disabled", false);
            //This code initializes the "bootgrid" plugin for an HTML element with the ID "clintes_grid"
            var grid = $("#clintes_grid").bootgrid({
                //indicates that the data will be loaded using Ajax.
                ajax: true,
                //allows users to select rows in the grid.
                rowSelect: true,
                //defines a custom function to accumulate additional parameters with the request object.
                //In this case, the function adds an "id" parameter with a static value of "b0df282a-0d67-40e5-8558-c9e93b7befed".
                post: function() {
                    /* To accumulate custom parameter 
                    with the request object */
                    return {
                        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                    };
                },
                //specifies the URL for the server-side script that returns the data in JSON format.
                url: "responseClientes.php",
                //specifies additional data to be sent with the Ajax request. In this case, it is empty.
                data: {

                },
                //defines a set of functions to format the data in each cell of the grid. 
                //The "commands" formatter returns a set of three buttons for each row: "Editar" (edit), "Proyectos del cliente" (client projects), and "Eliminar" (delete)
                formatters: {
                    "contactos": function(column, row){
                        return "<button type=\"button\" class=\"btn btn-xs btn-default commandcli-contacts\" data-row-id=\"" + row.id + "\" title=\"Contactos\"><span class=\"glyphicon glyphicon-phone\"></span></button>";
                    },
                    "commands": function(column, row) {
                        return "<button type=\"button\" class=\"btn btn-xs btn-default commandcli-edit\" data-row-id=\"" + row.id + "\" title=\"Editar\"><span class=\"glyphicon glyphicon-edit\"></span></button> " +
                            "<button type=\"button\" class=\"btn btn-xs btn-default commandcli-proyectos\" data-row-id=\"" + row.id + "\" title=\"Proyectos del cliente\"><span class=\"glyphicon glyphicon-random\"></span></button>" +
                            "<button type=\"button\" class=\"btn btn-xs btn-default commandcli-delete\" data-row-id=\"" + row.id + "\" title=\"Eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
                    },
                }
                //This event is triggered when the grid data is loaded and rendered.
                //provides a way to synchronize other UI elements or behaviors with the grid content.
            }).on("loaded.rs.jquery.bootgrid", function() {
                /* Executes after data is loaded and rendered */


                // shows a modal window for editing the selected row
                grid.find(".commandcli-edit").on("click", function(e) {
                    //alert("You pressed edit on row: " + $(this).data("row-id"));
                    var ele = $(this).parent();


                    $('#cliente_instalaciones').hide();
                    $('#addcliente_model').modal('show');

                    //checks if the data attribute with the key "row-id" of the current jQuery object ($(this)) is greater than 0
                    if ($(this).data("row-id") > 0) {
                        // collect the data
                        //The value of the first sibling element's HTML content of the current jQuery object (ele.siblings(':first').html()) is set as the value of the #newcliente_idcliente element's value using the .val() method of jQuery
                        $('#newcliente_idcliente').val(ele.siblings(':first').html()); // in case we're changing the key
                        //The loadProyectosClientes() function is called with the same value passed as an argument
                        loadProyectosClientes(ele.siblings(':first').html());

                        // CARGA DEL ARBOL DE DOCUMENTOS
                        var treeData;
                        //jQuery to make an AJAX request to a PHP script named responseDocsCli.php
                        console.log("start");
                        $.ajax({
                            type: "GET",
                            url: "responseDocsCli.php",
                            data: {
                                //includes a parameter named id whose value is set to the HTML content of the first sibling element of the ele jQuery object
                                id: ele.siblings(':first').html()
                            },
                            //the response is expected to be in JSON format.
                            dataType: "json",
                            //initTree() function is called with the response data and the ID of the tree view element as arguments. 
                            success: function(response) {
                                console.log("ok");
                                initTree(response, "treeview_json");
                            }
                        });
                        //The initTree() function initializes the tree view element using the data provided and some additional settings.  
                        function initTree(treeData, treeElement) {
                            console.log(treeData);
                            console.log(treeElement);
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
                        //this block is xecuted if the are not any row selected   
                    } else {
                        alert('Ninguna fila seleccionada! Selecciona una fila primero, después clica el boton editar');
                    }
                    //code for the click event of the button commandcli-proyectos

                }).end().find(".commandcli-proyectos").on("click", function(e) {
                    //open a new window with URL--> constucted by concatenating a fixed path with the value of the data attribute row-id of the clicked buttons parent element
                    window.open(
                        "/erp/apps/proyectos/?cli=" + $(this).data("row-id"),
                        "_blank"
                    );
                    //click event of comandcli-clientes
                }).end().find(".commandcli-delete").on("click", function(e) {
                    //it calls the delProv() function with the value of the data attribute "row-id" of the clicked button's parent element as an argument.
                    delProv($(this).data("row-id"));
                }).end().find(".commandcli-contacts").on("click", function(e) {
                    $("#contacts_modal").modal("show");
                    rowid = ($(this).data("row-id"));
                    loadContacts(rowid,"c");
                    form_add_contact = $("#add_contact_form");
                    $("#show-more-add-contact").on("click", function(e) {
                        form_add_contact.slideDown();
                    });
                    $("#show-less-add-contact").on("click", function(e) {
                        form_add_contact.slideUp();
                    });
                    $("#btn_save_contacto").on("click", function(e) {
                        console.log("estamos arriba" + rowid);
                        newcontact(rowid,"c");


                    });

                });

            });

        };

        function newcontact(id,tipo) {
            var clientes_o_proveedores;
            switch(tipo){
                case "c":
                    clientes_o_proveedores="CLIENTES_CONTACTOS";
                    break;
                case "p":
                    clientes_o_proveedores="PROVEEDORES_CONTACTOS";
                    break;
                default:
                    console.log("input error--> "+tipo);    

            }
            // Unbind the click event from the btn_save_contacto button
            $("#btn_save_contacto").off("click");
            // Get the form element
            var form = document.getElementById("new-contact");


            // Create a new FormData object from the form
            var formData = new FormData(form);
            name = formData.get("newcontacto_nombre");
            job = formData.get("newcontacto_cargo");
            mail = formData.get("newcontacto_mail");
            phone = formData.get("newcliente_telefono");
            description = formData.get("newcontacto_descripcion");
            console.log(name);
            console.log(id);
            $.ajax({
                type: "POST",
                url: "includes/post-contacts.php",
                data: {
                    id: id,
                    name: name,
                    job:job,
                    mail: mail,
                    phone: phone,
                    description: description,
                    tipo:clientes_o_proveedores,
                },
                dataType: "json",
                success: function(response) {
                    console.log("nice");
                    form.reset();
                    $("#contacts_modal").modal("hide");

                }

            })
        }


        function loadContacts(id,tipo) {
            var clientes_o_proveedores;
            switch(tipo){
                case "c":
                    clientes_o_proveedores="CLIENTES_CONTACTOS";
                    break;
                case "p":
                    clientes_o_proveedores="PROVEEDORES_CONTACTOS";
                    break;
                default:
                    console.log("input error--> "+tipo);    

            }
            $.ajax({
                type: "GET",
                url: "includes/get-contacts.php",
                data: {
                    //includes a parameter named id whose value is set to the HTML content of the first sibling element of the ele jQuery object
                    id: id,
                    tipo:clientes_o_proveedores,
                },
                //the response is expected to be in JSON format.
                dataType: "json",
                success: function(response) {
                    // clear the existing rows from the table
                    $("#contact-content table tbody").empty();

                    // loop through the contacts and add a row for each one
                    $.each(response, function(i, contact) {
                        console.log(contact);
                        var row = "<tr style='border: 1px solid black; text-align: center;'>" +
                            "<td style='border: 1px solid black; text-align: center;'>" + contact.id + "</td>" +
                            "<td style='border: 1px solid black; text-align: center;'>" + contact.nombre + "</td>" +
                            "<td style='border: 1px solid black; text-align: center;'>" + contact.cargo + "</td>" +
                            "<td style='border: 1px solid black; text-align: center;'>" + contact.mail + "</td>" +
                            "<td style='border: 1px solid black; text-align: center;'>" + contact.telefono + "</td>" +
                            "</tr>";
                        $("#contact-content table tbody").append(row);
                    });
                }
            });

        }

        function delProv(idProv) {
            <?
            if ($_GET['v'] == "c") {
                echo '
                        $("#idcliente_del").val(idProv);
                        $("#confirm_delete_cliente").modal("show");
                    ';
            } elseif ($_GET['v'] == "p") {
                echo '
                        $("#idprovedor_del").val(idProv);
                        $("#confirm_delete_proveedor").modal("show");
                    ';
            } else {
            }
            ?>

        }

        // this function must be defined in the global scope
        function fadeIn(obj) {
            $(obj).fadeIn(3000);
        };
    </script>

    <title>
        <?
        if ($_GET['v'] == "c") {
            echo "Clientes | Erp GENELEK";
        } elseif ($_GET['v'] == "p") {
            echo "Proveedores | Erp GENELEK";
        } else {
            echo "Auditores | Erp GENELEK";
        }
        ?>
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
    <? include($pathraiz . "/includes/header.php"); ?>

    <section id="contenido">
        <div id="erp-titulo" class="one-column">
            <h3>
                Empresas
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="one-column">
                <h4 class="dash-title">
                    <?
                    if ($_GET['v'] == "c") {
                        echo "CLIENTES";
                        include($pathraiz . "/apps/empresas/includes/tools-clientes.php");
                    } elseif ($_GET['v'] == "p") {
                        echo "PROVEEDORES";
                        include($pathraiz . "/apps/empresas/includes/tools-proveedores.php");
                    } else {
                        echo "AUDITORES";
                        include($pathraiz . "/apps/empresas/includes/tools-auditores.php");
                    }

                    ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-empresas" style="padding:10px;">
                    <?
                    if ($_GET['v'] == "c") {
                        include($pathraiz . "/apps/empresas/vistas/tabla-clientes.php");
                    } elseif ($_GET['v'] == "p") {
                        include($pathraiz . "/apps/empresas/vistas/tabla-proveedores.php");
                    } else {
                        include($pathraiz . "/apps/empresas/vistas/tabla-auditores.php");
                    }
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>


    </section>

</body>

</html>