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

            $("#edit_perfil").click(function() {
                $("#perfil-view").hide();
                $("#perfil-edit").show();
            });
            $("#cancel_perfil").click(function() {
                $("#perfil-view").show();
                $("#perfil-edit").hide();
            });
            $("#perfil_edit_btn_avatar").click(function() {
                console.info("klklklk");
                $("#addavatar_model").modal("show")
                getAllAvatarRoutes();
            });
            // PERFIL
            $("#perfil_edit_btn_save").click(function() {
                $("#perfil_edit_btn_save").html('<img src="/erp/img/btn-ajax-loader.gif" height="10" /> &nbsp; Guardando ...');
                data = $("#frm_editperfil").serializeArray();
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: "savePerfil.php",
                    data: data,
                    dataType: "Json",
                    success: function(response) {
                        //alert(response);
                        //$('#frm_editact').trigger("reset");
                        location.reload();
                    }
                });
            });
        });

        // this function must be defined in the global scope
        function fadeIn(obj) {
            $(obj).fadeIn(3000);
        };
        //funcion que nos devuelve un array de todos las rutas de las imagenes de los avatares (carpeta --> erp/img/avatares)
        function getAllAvatarRoutes() {
            const pathraiz = "../../img/avatares/";
            $.ajax({
                //String representing URL f the PHP script to becalled
                url: "includes/get_avatar_routes.php",
                //indicating the HTTP method to be used for the request 
                type: "get",
                //importante especificar el formato de los datos
                dataType: "Json",
                //log the response data to the console 
                //the response data is passed to the callback function as a parameter
                success: function(res) {
                    console.log(res);
                    console.log(<?php echo $_SESSION["user_session"]?>);

                    var imageContainer = document.getElementById("image-container");
                    //for que recorrera todos los elementos del array (en este caso los nombres de cada avatar)
                    for (const [key, value] of Object.entries(res)) {
                        //se crea un boton
                        const btn = document.createElement("button")
                        //se crea una imagen
                        const img = document.createElement("img");
                        //se le añade la ruta completa al nombre del avatar
                        img_route = pathraiz + value;
                        //se le asigna la ruta a la imagen recien creada
                        img.src = img_route
                        //se le asigna el id
                        img.id = key;
                        //ajuste visuales
                        img.style.width = "50px";
                        img.style.height = "50px";
                        //se le asigna el evento onclixk
                        btn.onclick = function(event) {
                            //esto es para que no recarge toda la pagina al elegir el avatr dado que no nos interesa
                            event.preventDefault();
                            //metodo para guadar el avatar
                            save_new_avatar(img, value);


                        };
                        //el boton creado se asigna dentro del div img container
                        imageContainer.appendChild(btn);
                        //dentro del boton se asigna la imagen
                        btn.appendChild(img);
                    }
                }
            });

        }
        //funcion para guardar el avatar
        function save_new_avatar(img, value) {
            //se pone el avatar recien elegido en la imagen de los campos de editar
            document.getElementById("update_avatar_target").src = img.src;
            //exixte un campo invisible en el cual se guarda el el nombre del avatar elegido
            document.getElementById("avatar_src_input").value = value;
            //para que desaparezca el desplegable de los avatares
            $("#addavatar_model").modal("hide");


        }
    </script>

    <title>
        Perfil de Usuario | Erp GENELEK
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
                Perfil de Usuario
            </h3>
        </div>
        <div id="dash-content">
            <div id="dash-perfilusuario" class="one-column">
                <h4 class="dash-title">
                    PERFIL <? include("includes/tools-perfil.php"); ?>
                </h4>
                <hr class="dash-underline">
                <div id="dash-perfil" style="padding:10px;">
                    <?
                    include("vistas/perfil.php");
                    ?>
                </div>
            </div>
            <span class="stretch"></span>
        </div>
    </section>

</body>

</html>