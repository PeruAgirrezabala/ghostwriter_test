<?
include("common.php");

checkPedidosProg();
if (!isset($_SESSION['user_session'])) {
    $logeado = checkCookie();
    if ($logeado == "no") {
        header("Location: /erp/login.php");
    }
} else {
    //aqui hago una select para verificar el tipo de usuario que es los proyectos a los que tiene acceso
    if ($_GET['year']) {
        $yearNum = $_GET['year'];
    } else {
        $yearNum  = date('Y');
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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-es_ES.js"></script>

    <!-- custom js -->
    <script src="/erp/functions.js"></script>

    <script>
        $(window).load(function() {
            $('#cover').fadeOut('slow').delay(5000);
        });

        $(document).ready(function() {
            $('.icon').mouseenter(function() {
                $(this).effect('bounce', 3000);
            });

            $("#menuitem-home").addClass("active");

            <?
            $criteriaLink = "";
            if ($_GET['year'] != "") {
                $criteriaLink = "?year=" . $_GET['year'];
            } else {
                $criteriaLink = "?year=" . date("Y");
                $criteriaLink = "?year=";
            }
            if ($_GET['cli'] != "") {
                $criteriaLink .= "&cli=" . $_GET['cli'];
            }
            if ($_GET['pag']) {
                $criteriaLink .= "&pag=" . $_GET['pag'];
            }
            ?>

            loadContent("tabla-proyectos-container", "/erp/vistas/proyectos-activos.php<? echo $criteriaLink; ?>");

            loadSelect("prev_tecnicos", "erp_users", "id", "", "", "apellidos");
            loadSelect("prev_proyectos", "PROYECTOS", "id", "tipo_proyecto_id", "1", "ref");
            loadSelect("prev_mantenimientos", "PROYECTOS", "id", "tipo_proyecto_id", "2", "ref");
            loadSelect("prev_intervenciones", "INTERVENCIONES", "id", "", "", "ref");
            loadSelect("prev_ofertas", "OFERTAS", "id", "", "", "ref");
            loadSelect("prev_clientes", "CLIENTES", "id", "", "", "");
            loadSelect("prev_estados", "PREVISIONES_ESTADOS", "id", "", "", "");

            $('#refresh_proyectos').click(function() {
                loadContent("tabla-proyectos-container", "/erpvistas/proyectos-activos.php<? echo $criteriaLink; ?>");
            });

            $(document).on("click", "#tabla-proyectos > tbody tr", function() {
                window.open(
                    "/erp/apps/proyectos/view.php?id=" + $(this).data("id"),
                    '_blank'
                );
            });

            $("#ver-previsiones").click(function() {
                loadContent("contenedor-previsiones", "/erp/vistas/vista-calendario-prev.php?yearNum=<? echo $yearNum; ?>");
                $("#calendario_prev").modal('show');
            });

            $("#add-prev").click(function() {
                $("#addprev_model").modal('show');
            });

            $("#btn_add_tec").click(function() {
                $('#prev_addtecnicos').append($('<option>', {
                    value: $("#prev_tecnicos").val(),
                    text: $("#prev_tecnicos").find("option:selected").text()
                }));
            });

            $("#btn_clear_tec").click(function() {
                $('#prev_addtecnicos option:selected').remove();
            });

            $("#btn_prev_save").click(function() {
                $("#btn_prev_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                $("#prev_addtecnicos option").prop("selected", true);
                data = $("#frm_previsiones").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "savePrevision.php",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#frm_previsiones').trigger("reset");
                        $("#btn_prev_save").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
                        $("#prev_success").slideDown();
                        setTimeout(function() {
                            $("#prev_success").fadeOut("slow");
                            window.location.reload();
                        }, 1000);
                    }
                });
            });

            $(".remove-prev").click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'savePrevision.php',
                    dataType: 'text',
                    data: {
                        prev_del: $(this).data("id")
                    },
                    success: function(data) {
                        console.log("ok");
                        window.location.reload();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("ERROR");
                    }
                });
            });

            $("#tabla-previsiones tr > td:not(:nth-child(8)):not(:nth-child(6))").click(function() {
                loadPrevisionInfo($(this).parent("tr").data("id"));
                //loadOfertaDetalleInfo($(this).data("id"));
                $("#addprev_model").modal('show');
            });

            $("#tabla-hitos tr").click(function() {
                window.open(
                    "/erp/apps/proyectos/view.php?id=" + $(this).data("id"),
                    '_blank'
                );
            });

            $('#proyectos-cad').click(function() {
                window.open(
                    "/erp/apps/proyectos/",
                    '_blank'
                );
            });
            $('#proyectos-horas').click(function() {
                window.open(
                    "/erp/apps/proyectos/",
                    '_blank'
                );
            });
            $('#entregas-cad').click(function() {
                window.open(
                    "/erp/apps/entregas/",
                    '_blank'
                );
            });
            $('#mant-cad').click(function() {
                window.open(
                    "/erp/apps/mantenimientos/",
                    '_blank'
                );
            });
            $('#pedidos-cad').click(function() {
                window.open(
                    "/erp/apps/material/",
                    '_blank'
                );
            });
            $('#prl-cad').click(function() {
                window.open(
                    "/erp/apps/prevencion/",
                    '_blank'
                );
            });
        });

        // this function must be defined in the global scope
        function fadeIn(obj) {
            $(obj).fadeIn(3000);
        };
        

    
    </script>

    <title>Inicio | Erp GENELEK</title>
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
                Dashboard
            </h3>
        </div>
        <div id="dash-header">
            <!--
            <div id="dash-numproyectos" class="four-column">
                <h4 class="dash-title">
                    CONTADORES
                </h4>
                <hr class="dash-underline">
                <? //include($pathraiz."/vistas/historial.php"); 
                ?>
            </div>
            
            <div id="dash-nuevosmes" class="four-column-two-merged">
                <h4 class="dash-title">
                    NUEVO ESTE MES
                </h4>
                <hr class="dash-underline" style="margin-bottom: 0px;">
                <? //include($pathraiz."/vistas/proyectos-nuevosmes.php"); 
                ?>
            </div>
            -->
            <div id="dash-previsiones" class="two-column">
                <h4 class="dash-title">
                    ALERTAS <? //include($pathraiz."/includes/tools-previsiones.php"); 
                            ?>
                </h4>
                <hr class="dash-underline" style="margin-bottom: 0px;">
                <? include($pathraiz . "/vistas/alertas-boxes.php"); ?>
            </div>
            <!--
            <div id="dash-previsiones" class="two-column">
                <h4 class="dash-title">
                    PREVISIONES <? //include($pathraiz."/includes/tools-previsiones.php"); 
                                ?>
                </h4>
                <hr class="dash-underline" style="margin-bottom: 0px;">
                <? //include($pathraiz."/vistas/genelek-previsiones.php"); 
                ?>
            </div>

            <div id="dash-alertas" class="four-column">
                <h4 class="dash-title">
                    ALERTAS
                </h4>
                <hr class="dash-underline">
                <? //include($pathraiz."/vistas/alertas.php"); 
                ?>
            </div>
            -->
            <span class="stretch"></span>
        </div>
        <div id="dash-content">
            <div id="dash-proyectosactivos" class="four-column-three-merged">
                <h4 class="dash-title">
                    PROYECTOS ACTIVOS
                    <? //include($pathraiz."/apps/proyectos/includes/tools.php"); 
                    ?>
                </h4>
                <hr class="dash-underline">
                <div class="loading-div"></div>
                <div id="tabla-proyectos-container">
                    <? //include($pathraiz."/vistas/proyectos-activos.php"); 
                    ?>
                </div>
            </div>
            <div id="dash-aside" class="four-column" style="background-color: transparent;">
                <div id="dash-hitos" class="one-column">
                    <h4 class="dash-title">
                        HITOS A TU NOMBRE
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz . "/vistas/hitos.php"); ?>
                </div>
                <div id="dash-riesgos" class="one-column">
                    <h4 class="dash-title">
                        RIESGOS
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz . "/vistas/riesgos.php"); ?>
                </div>
                <div id="dash-actividad" class="one-column">
                    <h4 class="dash-title">
                        ACTIVIDAD (últimos 20 registros)
                    </h4>
                    <hr class="dash-underline">
                    <? include($pathraiz . "/vistas/erp-actividad.php"); ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>



    </section>

</body>

</html>