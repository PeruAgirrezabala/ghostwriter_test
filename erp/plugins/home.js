/*************************************
*         Variables globales         *
**************************************/

//Formatos de fecha:
//TODO: cargarlas desde el servidor
var DPMWEB_GLOBAL_DATE_TIME_FORMAT = 'YYYY-MM-DD HH:mm';

var DPMWEB_GLOBAL_DATE_FORMAT = 'YYYY-MM-DD';

var DPMWEB_GLOBAL_TIME_FORMAT = 'HH:mm';

/*
 * Flag para solicitar confirmación antes de salír del cuerpo indicado.
 */
var isBodyModify = false;

/**************************************************************************
* Constantes que representan el estado del resultado de una consulta AJAX *
***************************************************************************/
//public enum JSonResultState
//{
//    Ok = 0,        
//    Error = 1,
//    OkWithWarnings = 2
//}
var JSON_RESULT_STATE_OK = 0;
var JSON_RESULT_STATE_ERROR = 1;
var JSON_RESULT_STATE_OK_WARNINGS = 2;

//public enum JSonResultMessageType
//{
//    Info = 1,
//    Warning = 2,
//    Error = 3       
//}

var JSON_RESULT_MESSAGE_TYPE_INFO = 1;
var JSON_RESULT_MESSAGE_TYPE_WARNING = 2;
var JSON_RESULT_MESSAGE_TYPE_ERROR = 3;

//public enum JSonResultType
//{
//    Custom = 0,
//    View = 1,
//    Model = 2,
//    Redirect = 3,
//    SessionExpired = 4,
//    FileInfo = 5,
//    PermissionDenny = 6,
//    Body = 7
//}

var JSON_RESULT_TYPE_CUSTOM = 0;
var JSON_RESULT_TYPE_VIEW = 1;
var JSON_RESULT_TYPE_MODEL = 2;
var JSON_RESULT_TYPE_REDIRECT = 3;
var JSON_RESULT_TYPE_SESSION_EXPIRED = 4;
var JSON_RESULT_TYPE_FILE_INFO = 5;
var JSON_RESULT_TYPE_PERMISSION_DENNY = 6;
var JSON_RESULT_TYPE_BODY = 7;
var JSON_RESULT_TYPE_POST = 8;

var CONST_ANEXO_TYPE_PAC = "2";
var CONST_ANEXO_TYPE_FILE = "1";


/******************************************************
* Logica combo principal con los datos de la release *
******************************************************/

var MainReleaseComboId = 'MainReleaseComboId';

$(document).ready(function () {
    MainReleaseComboInit();
});

function MainReleaseComboInit() {
    MainReleaseComboHandleEvents();

    MainReleaseComboLoad();
}

/**
* Suscribe los siguientes eventos del combo:
* - Change
*/
function MainReleaseComboHandleEvents() {
    var combo = $('#' + MainReleaseComboId);

    combo.on('changed.bs.select', function (e, clickedIndex, newValue, oldValue) {

        //Guardamos el actual valor
        var oldValueId = GetSelectedRelease();
        var newValueId = combo.val();

        if (newValue) {
            MainReleaseComboIdChangeEvent(combo, oldValueId, newValueId);
        }
    });    
}

/**
* Función del evento del combo en el cambio de item:
* - Modifica el valor almacenado que representa a la release seleccionada.
* - TODO: Reinicia el cuerpo.
*/
function MainReleaseComboIdChangeEvent(selectedPicked, oldValueId, newValueId) {


    //Obtengo el identificador de la categoría seleccionada.
    var category = GetSelectedCategory();

    //Obtengo la subcategoría seleccionada.
    var subCategory = GetSelectedSubCategory();

    //Obtengo el sistema seleccionado.
    var system = GetSelectedSystem();

    //obtengo la release seleccionada.
    var release = newValueId;

    //Hacemos la llamada
    LoadBody(category, subCategory, release, system,
        function () { //La carga ha ido correcta
            isBodyModify = false;

            //Cambiamos el valor seleccionado.
            SetSelectedRelease(newValueId);
        },
        function () { //Se ha cancelado la carga
            //Dejamos el combo con el valor anterior
            selectedPicked.val(oldValueId);
            selectedPicked.selectpicker("refresh");
        });
}

/**
* Realiza la carga del combo (llama a Ajax). 
* Una vez cargado selecciona la release seleccionada a la carga de la página (valor 
* que viene del servidor).
*/
function MainReleaseComboLoad() {

    instance = GetMainReleaseComboInstance();

    instance.Load(function (select) {

        var selectedRelease = GetSelectedRelease();

        select.val(selectedRelease);

        select.selectpicker("refresh");
    });
}

/**
* Obtiene una instancia del módulo de acciones sobre los combos de tipo 
* bootstrap-select (http://silviomoreto.github.io/bootstrap-select)
*/
function GetMainReleaseComboInstance() {
    var url = '/Release/ReleasesParValue';
    var selectedPicked = $('#' + MainReleaseComboId)

    var config = {
        url: url,
        fieldNameValue: 'ID',
        fieldNameText: 'NAME',
        combo: $('#' + MainReleaseComboId)
    };

    var instance = bootStrapSelectModule;

    instance.Init(config);

    return instance;
}


/*************************************
*  TRATAMIENTO GLOBAL CONSULTAS AJAX *
**************************************/
$(document).on({

    /***************Globales de actuación de ajax******************/
    ajaxStart: function () {
        //Añadimos la imagen de cargando.
        AddReloading();
    },

    ajaxStop: function () {
        //Eliminamos la imagen de cargando.
        RemoveReloading();        
    },

    ajaxError: function (event, xhr, options, exc)
    {
        $('#cuerpo').html(xhr.responseText);

        //Eliminamos la imagen de cargando.
        RemoveReloading();
        /*
        alert('The event object: ' + event);
        alert('XMLHttpRequest object: ' + xhr);
        alert('XMLHttpRequest object (status): ' + xhr.status);
        alert('Options used in the AJAX request: ' + options);
        alert('Options used in the AJAX request (url): ' + options.url);
        alert('JavaScript exception: ' + exc);
        */

    },

    ajaxComplete: function (event, XMLHttpRequest, ajaxOptions) {

        //0 Representa que no hay respuesta (conexión a internet?)
        if (XMLHttpRequest.readyState === 0) {
            alert('No hay conexión con el servidor.');
        } else {
            //Comprobamos resultados especiales a una pregunta ajax
            if (XMLHttpRequest.hasOwnProperty('responseJSON')) {
                //Comprobamos si es una redirección
                if (XMLHttpRequest.responseJSON.type === JSON_RESULT_TYPE_REDIRECT) {
                    window.location.href = XMLHttpRequest.responseJSON.redirectUrl
                }
                //Comprobamos si es una respuesta de que ha expirado la sessión.
                else if (XMLHttpRequest.responseJSON.type === JSON_RESULT_TYPE_SESSION_EXPIRED) {

                    //var res = XMLHttpRequest.responseJSON;
                    RemoveReloading();
                    GetViewModalLogin('contentModalLoginID');
                    //executeFunctionByName(res.data.function, window, res.data.arg);
                }
            }
        }
    }
});

/*************************************
*  VENTANA MODAL DE CARGANDO AJAX    *
**************************************/
/*
 * Activa la ventana modal de loading.
 */
function AddReloading() {
    //Añadimos el "cargando"    
    $('.loader').fadeIn();
}

/*
 * Desactiva la ventana modal de loading.
 */
function RemoveReloading() {
    //Eliminamos el "Cargando"    
    $('.loader').fadeOut();
}

/*
 * Funciones relacionadas con el menú principal de las categorías.
 *
 */
var MainCategoryMenu = (function () {

    return {
        /*
         * Activa una categoría por el nombre
         */
        SetCategory: function (categoryName) {
            
                $('#navbar .nav').find(".active").removeClass("active");
                $('#navbar .nav').find("#" + categoryName).addClass("active");
            
        }
    }    

})();

/*************************************
*  ACCESO A DATOS DE INPUT           *
**************************************/

/*
 * Obtiene un objeto con los datos seleccionados:
 * 
 * CategoryName: Almacena la categoría seleccionada por el usuario. 
 * SubCategoryName: Almacena la subcategoría seleccionada por el usuario.
 * DeliveryId: Almacena el identificador de la release seleccionada.
 * SystemId: Almacena el identificador del sistema seleccionado.
 * 
 */
function GetSelectedDataGroup() {

    //Almaceno las propiedades comunes
    var commons = {
        CategoryName: GetSelectedCategory(),
        SubCategoryName: GetSelectedSubCategory(),
        DeliveryId: GetSelectedRelease(),
        SystemId: GetSelectedSystem()
    };

    return commons;
}

/*
 * Función que marca como seleccionada una categoría 
 */
function SetSelectedCategory(category, notAddSelectedInMenu)
{
    $('#SelectedCategory').val(category);

    if (notAddSelectedInMenu === undefined || notAddSelectedInMenu === false)
    {
        $('#navbar .nav').find(".active").removeClass("active");
        $('#navbar .nav').find("#" + category).addClass("active");
    }
}

/*
 * Función que marca como seleccionada una subcategoría en cliente.
 */
function SetSelectedSubCategory(subCategory, notAddSelectedInMenu)
{
    if (subCategory !== "")
    {
        $('#SelectedSubCategory').val(subCategory);

        if (notAddSelectedInMenu === undefined || notAddSelectedInMenu === false)
        {
            $("#navBarMenuSubCat a").find(".active").removeClass("active");
            $("#navBarMenuSubCat").find("#" + subCategory).find('a').addClass("active");
        }
    }
}

/*
 * Función que asigna un identificador de delivery como seleccionada en cliente.
 */
function SetSelectedRelease(value) {
    $('#SelectedReleaseId').val(value);
}

/*
 * Función que asigna un identificador de sistema como seleccionada en cliente.
 */
function SetSelectedSystem(value) {
    $('#SelectedSystemId').val(value);
}

/*
 * Obtiene el nombre de la categoría actualmente seleccionada.
 */
function GetSelectedCategory()
{
    return $('#SelectedCategory').val();
    //return $('#navbar .nav').find('.active').attr('id');
}

/*
 * Obtiene el nombre de la sub categoría actualmente seleccionada.
 */
function GetSelectedSubCategory()
{    
    //return $('#navBarMenuSubCat .nav').find('.active').attr('id');
    return $('#SelectedSubCategory').val();    
}

/*
 * Obtiene el texto de la release actualmente seleccionada.
 */
function GetSelectedSystem()
{

    if ($('#SelectedSystemId').val() === '') return -1;

    return $('#SelectedSystemId').val();
}

/*
 * Obtiene el identificador de la release actualmente seleccionada.
 */
function GetSelectedRelease() {   

    if ($('#SelectedReleaseId').val() === '') return -1;

    return $('#SelectedReleaseId').val();

    //return mainReleaseCombo.GetValue();
}

/*************************************
*  NAVEGACIÓN                        *
**************************************/

/*
 * Lanza una ventana de confirmación para continuar con la carga del cuerpo.
 */
function confirmChangeBody(urlAction, onOkDataCallback, onCancelDataCallback) {

    function doAction() {
        if (onOkDataCallback != undefined) {
            onOkDataCallback();
        }
    }

    if (isBodyModify) {
        $.confirm({
            theme: 'bootstrap',
            type: 'red',
            title: 'Confirmar continuar',
            content: 'Si continua perderá los datos no guardados. ¿Desea continuar?',
            autoClose: 'cancelAction|8000',
            closeIcon: true,
            closeIconClass: 'fa fa-close',
            icon: 'fa fa-warning',
            draggable: true,
            backgroundDismiss: false,
            backgroundDismissAnimation: 'glow',
            animation: 'zoom',
            buttons: {
                confirm: {
                    action: function () {
                        doAction();
                    },
                    keys: ['enter'],
                    text: 'Continuar'
                },

                cancelAction: {
                    action: function () {
                        if (onCancelDataCallback != undefined) {
                            onCancelDataCallback();
                        }
                    },
                    btnClass: 'btn btn-danger',
                    keys: ['esc'],
                    text: 'Cancelar'
                }
            }
        });
    } else {
        doAction();
    }
}

/*
    * Abre una ventana nueva con los datos pasados.
    *
    */
function OpenNewWindows(category, subCategory, release, system) {
    window.open('../Home/blank?category=' + category + '&subCategory=' + subCategory + '&release=' + release + '&system=' + system, '_blank');
};

/**
 * Recarga el cuerpo de la página con la categoría y subcategoría seleccionados.
 */
function Reload() {

    //Obtengo el identificador de la categoría seleccionada.
    var category = GetSelectedCategory();

    //Obtengo la subcategoría seleccionada.
    var subCategory = GetSelectedSubCategory();

    //Obtengo el sistema seleccionado.
    var system = GetSelectedSystem();

    //obtengo la release seleccionada.
    var release = GetSelectedRelease();

    //Hacemos la llamada
    LoadBody(category, subCategory, release, system);
}

/**
 * Recarga el cuerpo de la página con la subcategoría por defecto de la categoría.
 */
function ReloadCatMain() {

    //Obtengo el identificador de la categoría seleccionada.
    var category = GetSelectedCategory();

    //Obtengo la subcategoría seleccionada.
    var subCategory = "";

    //Obtengo el sistema seleccionado.
    var system = GetSelectedSystem();

    //obtengo la release seleccionada.
    var release = GetSelectedRelease();

    //Hacemos la llamada
    LoadBody(category, subCategory, release, system);
}

/*
 * Carga el cuerpo de la página pasándole la subcategoría.
 */
function LoadBodyFromSubCat(item) {    

    //Obtengo la subcategoría del item pasado.
    var subCategory = $(item).attr("id");

    //Obtengo el identificador de la categoría seleccionada.
    var category = GetSelectedCategory();    

    //Obtengo el sistema seleccionado.
    var system = GetSelectedSystem();

    //obtengo la release seleccionada.
    var release = GetSelectedRelease();

    //Hacemos la llamada
    LoadBody(category, subCategory, release, system);
}

/*
 * Carga el cuerpo de la página pasándole el nombre de la categoría. 
 */
function LoadBodyFromCategory(item) {        

    //Obtengo el identificador de la categoría pasada.
    var category = $(item).attr("id");

    //Obtengo el sistema seleccionado.
    var system = GetSelectedSystem();

    //obtengo la release seleccionada.
    var release = GetSelectedRelease();    

    //Hacemos la llamada
    LoadBody(category, "", release, system, function () {

        //Limpio el menú de las subcategorías
        $('#navBarMenuSubCat').empty();

        LoadMenuSubCat(item);
    });
}

/*
 * Función que solicita la carga de una subcategoría. (Solo de la misma categoría)
 */
function LoadToSubCategory(subCategory)
{
    //Obtengo el identificador de la categoría seleccionada.
    var category = GetSelectedCategory();

    //Obtengo el sistema seleccionado.
    var system = GetSelectedSystem();

    //obtengo la release seleccionada.
    var release = GetSelectedRelease();

    //Hacemos la llamada
    LoadBody(category, subCategory, release, system);
}

/*
 * Carga el cuerpo de la página con el nombre de la categoría y el nombre de la subcategoría, 
 * pasando como parámetros la release y el sistema seleccionado. 
 */
function LoadBody(category, subCategory, release, system, onLoadOkDataCallback, onCancelDataCallback) {

    //Limpiamos el cuerpo
    //$('#cuerpo').empty();

    //Preparo los parámetros para la carga del cuerpo
    //var urlAction = "@Url.Action("GetBody", "param-category")?subCat=param-subcat&release=param-release&system=param-system";
    var urlAction = "/param-category/GetBody?subCat=param-subcat&release=param-release&system=param-system";

    //Preparamos la url con los parámetros pasados
    urlAction = urlAction.replace("param-category", category)
                .replace("param-subcat", subCategory)
                .replace("param-release", release)
                .replace("param-system", system);        

    //Solicitamos la carga del view
    confirmChangeBody(urlAction, function () {
        //Cargamos el view recibido en la etiqueta que corresponde al cuerpo.
        LoadData('#cuerpo', urlAction, onLoadOkDataCallback);
    }, onCancelDataCallback);     
}

/*
 * Llamada al ajax para la petición de la vista parcial del cuerpo de la página.
 * Se carga en el elemento html "target" pasado. 
 */
function LoadData(target, url, onLoadBodyOkCallback) {
    $.ajax({
        url: url,
        success: function (result) {

            var stopProccess = ProcessJSonResultGeneric(result, "Load body", null, null, false)
                        
            if (stopProccess) return;

            //Si el resultado es correcto, continuamos con la carga

            //Cambiamos el flag de cuerpo modificado.
            isBodyModify = false;

            //Tratamos la carga de un view o específica del cuerpo de una categoría/subcategoría
            if (result.type === JSON_RESULT_TYPE_VIEW || result.type === JSON_RESULT_TYPE_BODY) {               

                //Limpiamos el destino
                $(target).empty();

                //Asignamos el html resultado.
                $(target).html(result.data.view);
            }

            //Solo cargamos el menú si es carga del cuerpo de una categoría/subcategoría
            if (result.type === JSON_RESULT_TYPE_BODY) {

                //Asignamos el texto.
                if (typeof result.data.systemId != 'undefined') {
                    document.title = result.data.title;
                }

                if (typeof result.data.systemId != 'undefined') {
                    SetSelectedSystem(result.data.systemId);
                }

                if (typeof result.data.deliveryId != 'undefined') {
                    SetSelectedRelease(result.data.deliveryId);
                }

                if (typeof result.data.categoryName != 'undefined') {
                    SetSelectedCategory(result.data.categoryName)
                }

                SetSelectedSubCategory(result.data.subCategoryName);    
                
                //Ejecutamos el evento de callback si no ha dado error.
                if (typeof onLoadBodyOkCallback !== 'undefined') {
                    onLoadBodyOkCallback(result);
                }
            }

            
        }//Fin success
    });
}

/*************************************
*  CARGA DE MENUS                    *
**************************************/

/*
 * Carga el menú de sub categorías dada la categoría pasada. 
 */
function LoadMenuSubCat(item)
{
    //Limpio el target
    $('#navBarMenuSubCat').empty();

    //Obtengo el identificador de la categoría pasada.
    var category = $(item).attr("id");

    $('#navBarMenuSubCat').attr('data-categoria', category);
    
    var urlAction = "/Home/GetNavBarMenuSubCat?category=param-category";

    //Preparamos la url con los parámetros pasados
    urlAction = urlAction.replace("param-category", category);

    //Recargo el subMenú
    LoadSubMenuData('#navBarMenuSubCat', urlAction, $('#menuStatus').val());
}

/*
 * Llamada al ajax para la petición de la vista parcial del menú de las subcategorías.
 * Se carga en el elemento html "target" pasado. 
 */
function LoadSubMenuData(target, url, isMenuOpen) {
    $.ajax({        
        url: url,
        DataType: "json",
        success: function (result) {
            LoadSuccess(target, result);
        },        
        error: function (jqXHR, textStatus, errorThrown) {
            LoadError(jqXHR, textStatus, errorThrown);
        }
    });   

    function LoadSuccess(target, result) {

        $(target).html(result.view);

        //Mostramos u ocultamos el menú si no se han encontrado elementos de menú para la subcategoría.
        if (result.count > 0 && isMenuOpen) {
            //Se muestra el menú.

            //$('#navBarMenuSubCat').css('display', 'block');
        } else {
            //Se oculta el menú
            //$('#navBarMenuSubCat').css('display', 'none');
        }
    };

    function LoadError(jqXHR, textStatus, errorThrown) 
    { 
        $('#navBarMenuSubCat').css('display', 'none');
    };            
}

/*************************************
*  AUXILIARES                        *
**************************************/


/*  Toastr
**************************************/

function GetToastROptions() {
    var opt = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-full-width",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
    };

    return opt;
}


/****************************************************
* Ventana modal de login
*****************************************************/

/**
* Muestra la ventana modal de login.
* Carga un view obtenido por json en el target indicado, abriendo la ventana modal y eliminándo el código de la ventana modal una vez se cierre.
* @param {any} target 
*/
function GetViewModalLogin(target, actualCategory, actualSubCategory, openCallBackFunction, closeCallBackFunction) {

    /**Variables comunes modal de selección ***/
    /*
        * Indica la razon del cierre de la ventana modal: aceptar.
        */
    var ReasonOk = 1;
    /*
    * Almacena el nombre del controlador para los contactos.
    */
    var ControllerName = '/Account';

    /*
        * Almacena el nombre de la función para la obtención del view.
        */
    var ControllerViewModalSelectFunc = "/ViewModalLogin";

    /*
        * Almacena el identificador de la ventana modal
        */
    var modalId = "modalLogin";

    /*
        * Almacena la función a llamar cuando se abrá la ventana modal.
        */
    var gOpenCallBackFunction;

    /*
        * Almacena la función a llamar cuando se cierre la ventana modal.
        */
    var gCloseCallBackFunction;

    /*
        * Almacena el objeto destino para añadir la ventana modal.
        */
    var gTarget;

    /*Específicos*/

    /*
    * Almacena la url para validar el usuario.
    */
    var appConfigUrlSaveContact = '/Account/LoginModal';

    /**Textos ***/
    var langOperationName = 'obtención de la ventana de login';

    var langErrorOpenModal = 'Error al abrir la ventana modal de login. No se ha encontrado la ventana modal.';

    var langErrorLogin = 'Ha fallado el intento de login. Consulte con su administrador.';

    //Obtenemos las opciones de configuración genéricas del toast
    toastr.options = GetToastROptions();

    /*
        * Obtiene la razón de cierre. Si no existe razón, se devolverá la equivalente a cancelar.
        */
    function GetOutPutReason() {
        var modal = $('#' + modalId);

        if (modal[0].hasAttribute("data-reason")) {
            return modal.attr("data-reason");
        }
        else {
            return ReasonCancel;
        }
    }

    /*
        * Añade la razón de cierre a la ventana modal.
        */
    function SetOutPutReason(reason) {

        var modal = $('#' + modalId);

        modal.attr("data-reason", reason);
    }

    /*
    * Inicialización del grid de sistema no seleccionado.
    */
    function InitModal() {

        /*
            * Configuración eventos comunes modal
            *************************************/
        $('.vf-login-submit').on('click', function () {

            var modalObject = $("#" + modalId);

            // Get the form.
            var form = $(modalObject).find('form');

            // Set up an event listener for the contact form.
            form.submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: appConfigUrlSaveContact,
                    method: 'POST',
                    type: "post",
                    //contentType: "application/x-www-form-urlencoded",
                    data: $(this).serialize(),
                    success: function (result) {                       

                        if (result.state === JSON_RESULT_STATE_OK) {

                            SetOutPutReason(ReasonOk);
                            modalObject.modal('hide');

                        } else {
                            $("#modalLoginAlert").text(result.messages[0].Message)
                        }
                    },
                    error: function () {
                        toastr.error(langErrorLogin);
                    }
                });

                return false;
            });
        });
    }

    /*Iniciamos el proceso de apertura de la ventana modal*/

    //Actualizamos las variables globales:
    gOpenCallBackFunction = openCallBackFunction;
    gCloseCallBackFunction = closeCallBackFunction;
    $gTarget = $('#' + target);

    //Construimos la url
    var url = ControllerName + ControllerViewModalSelectFunc;

    //Realizamos la petición ajax para los datos.
    $.ajax({
        url: url,        
        success: function (result) {

            //Limpiamos el destino pasado
            $gTarget.empty();

            //Procesamos la parte de la información al usuario. (mensajes, error y warning si existen)
            ProcessJSonResultGeneric(result, langOperationName);

            //Asignamos el html resultado.
            $gTarget.html(result.data.view);

            //Obtenemos la ventana modal
            var modalObject = $("#" + modalId);

            //abrimos la ventana modal si existe
            if (modalObject.length) {

                //Instanciamos el evento para que al abrir inicialice la ventana si es necesario.
                modalObject.on('show.bs.modal', function () {

                    //Inicializamos la ventana modal
                    InitModal();

                    if (typeof gOpenCallBackFunction !== 'undefined') {
                        gOpenCallBackFunction(modalObject);
                    }
                });

                //Instanciamos el evento para que al cerrar se elimine la ventana del target.
                modalObject.on('hidden.bs.modal', function () {

                    var closeReason = GetOutPutReason();

                    if (closeReason.toString() === ReasonOk.toString()) {}

                    //Ejecutamos el evento de callback
                    if (typeof gCloseCallBackFunction !== 'undefined') {
                        gCloseCallBackFunction(modalObject, closeReason, rows);
                    }

                    $gTarget.empty();
                    RemoveReloading();
                });

                //abrimos por defecto
                modalObject.modal('show');

            } else {
                //Información al usuario
                toastr.error(langErrorOpenModal);                
            }
        },
        error: function (event, xhr, options, exc) {
            alert('The event object: ' + event);
            alert('XMLHttpRequest object: ' + xhr);
            alert('XMLHttpRequest object (status): ' + event.status);
            alert('Options used in the AJAX request: ' + options);
            alert('Options used in the AJAX request (url): ' + options.url);
            alert('JavaScript exception: ' + exc);
        }
    });
}

/***************************************
* ++ Tabla presentación resultados
****************************************/

var messageGrid;

$(document).ready(function () {
    /*
     * INICIALIZACIÓN DE LA CONSOLA
     */

    /**
    * Renderizado para el campo de tipo de mensaje.
    */
    var messageGridTypeRenderer = function (value, record, $cell, $displayEl) {
        $cell.css('font-style', 'italic');

        //Dependiendo del identificador del tipo de mensaje mapeamos y modificamos el texto y su estilo de la celda.
        if (value == 1) {
            $displayEl.text('INFO');
            $displayEl.css('background-color', '#dff8f3');
        } else if (value == 2) {
            $displayEl.text('WARNING');
            $displayEl.css('background-color', '#e79595');
        } else if (value == 3) {
            $displayEl.text('ERROR');
            $displayEl.css('background-color', '#8c1a1a');
        }
    };

    var messageGridDateTimeRenderer = function (value, record, $cell, $displayEl) {

        var value = moment.utc(new Date(parseInt(value.substr(6)))).local().format("YYYY/MM/DD HH:mm:ss SSS");

        $cell.css('font-style', 'italic');

        $displayEl.text(value);
    };

    /**
    * Variable que almacena el elemento grid de la tabla de mensajes y su configuración.
    */
    messageGrid = $('#GridListMessagesId').grid({
        uiLibrary: 'bootstrap',
        columns: [
            { field: "CreatedDateTime", title: "DateTime", width: "25%", sortable: true, renderer: messageGridDateTimeRenderer },
            { field: "MessageType", title: "Type", width: "15%", renderer: messageGridTypeRenderer },
            { field: "Message", title: "Console" }
        ]
    });
});

/**
* Carga los datos en el grid de presentación de resultados.
*
*/
function LoadMessageGrid(dataFrom) {

    //Aquí le incluimos los datos    

    $(dataFrom).each(function (index) {
        messageGrid.addRow({
            "CreatedDateTime": this.CreatedDateTime,
            "MessageType": this.MessageType,
            "Message": this.Message
        });

        //console.log(index + ": " + this.CreatedDateTime);
        //console.log(index + ": " + this.MessageType);
        //console.log(index + ": " + this.Message);            
    });

    //messageGrid.data.dataSource = dataFrom;
    //messageGrid.render(messageGrid.data.dataSource);
}
/***************************************
* --------------------------------------
****************************************/

/*************************************
*  TODO: REVISAR SI SE UTILIZAN      *
**************************************/

/*
 * Selecciona del combo principal de la release un elemento por el valor 
 * o el correspondiente al index 0 si el valor no existe.
 */
function SetMainComboSelectedIndexByVal(val) {
    //Asignamos la release seleccionada para el usuario en el combo.
    var itemForSelect = mainReleaseCombo.FindItemByValue(val);

    if (itemForSelect !== null) {
        mainReleaseCombo.SetSelectedIndex(itemForSelect.index);
    } else {
        mainReleaseCombo.SetSelectedIndex(0);
    }
}

/*
 * Refresca el combo principal.
 */
function ReleaseComboMainRefresh() {
    mainReleaseCombo.PerformCallback("refresh");
}
   
/*
 * Selecciona del combo principal de la release un elemento por el valor 
 * o el correspondiente al index 0 si el valor no existe.
 */
function SetMainComboSelectedIndexByVal(val) {
    //Asignamos la release seleccionada para el usuario en el combo.
    var itemForSelect = mainReleaseCombo.FindItemByValue(val);

    if (itemForSelect !== null) {
        mainReleaseCombo.SetSelectedIndex(itemForSelect.index);
    } else {
        mainReleaseCombo.SetSelectedIndex(0);
    }
}

/*
 * Refresca el combo principal.
 */
function ReleaseComboMainRefresh() {
    mainReleaseCombo.PerformCallback("refresh");
}

    function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
    }
    }
}

    function ShowButton(buttonId) {
    var button = $('#' +buttonId);

    if (button !== null) {
        button.show();
    }
}

    function HideButton(buttonId) {
    var button = $('#' +buttonId);

    if (button !== null) {
        button.hide();
    }
}

    /*
     * Simple función para la carga dentro de una etiqueta del resultado de una llamada por ajax a una acción del controlador.
     * 
     * 
     */
    function RenderPartialViewInTarget(controller, action, divTargetId) {
        //Do ajax call  
    $.ajax({
            type: 'GET',
            url: '/' + controller + '/' +action,
            dataType: 'html', //dataType - html
            success: function (result) {
            $('#' + divTargetId + '').html(result);
    }
        //Del error se encarga la función global de home.js
    });
}


    /**
     * Obtiene el valor de un combo de bootstrap (select)
     * 
     * @param {text} comboId Nombre identificador del combo.
     * 
     * @returns {number} Valor del combo actualmente seleccionado.
     */
    function GetComboValue(comboId) {
        //Obtenemos el identificador seleccionado.
    var combo = document.getElementById(comboId);
    return combo.options[combo.selectedIndex].value;
}


    function SetComboSelectedIndex(comboId, intValue) {
    $(comboId).prop("selectedIndex", intValue);
}

    function checkInternet() {
    var status = navigator.onLine;
    if (status) {
        alert("Working");
    } else {
        alert("Not Working ");
    }
}

    function _setBrowser() {
    var userAgent = navigator.userAgent.toLowerCase();

        // Figure out what browser is being used
    jQuery.browser = {
            version: (userAgent.match(/.+(?:rv|it|ra|ie|me|ve)[\/: ]([\d.]+)/) || [])[1],
            chrome: /chrome/.test(userAgent),
            safari: /webkit/.test(userAgent) && !/chrome/.test(userAgent),
            opera: /opera/.test(userAgent),
            firefox: /firefox/.test(userAgent),
            msie: /msie/.test(userAgent) && !/opera/.test(userAgent),
            mozilla: /mozilla/.test(userAgent) && !/(compatible|webkit)/.test(userAgent),
            webkit: $.browser.webkit,
            gecko: /[^like]{4} gecko/.test(userAgent),
            presto: /presto/.test(userAgent),
            xoom: /xoom/.test(userAgent),
            android: /android/.test(userAgent),
            androidVersion: (userAgent.match(/.+(?:android)[\/: ]([\d.]+)/) || [0, 0])[1],
            iphone: /iphone|ipod/.test(userAgent),
            iphoneVersion: (userAgent.match(/.+(?:iphone\ os)[\/: ]([\d_]+)/) || [0, 0])[1].toString().split('_').join('.'),
            ipad: /ipad/.test(userAgent),
            ipadVersion: (userAgent.match(/.+(?:cpu\ os)[\/: ]([\d_]+)/) || [0, 0])[1].toString().split('_').join('.'),
            blackberry: /blackberry/.test(userAgent),
            winMobile: /Windows\ Phone/.test(userAgent),
            winMobileVersion: (userAgent.match(/.+(?:windows\ phone\ os)[\/: ]([\d_]+)/) || [0, 0])[1]
    };

    jQuery.browser.mobile = ($.browser.iphone || $.browser.ipad || $.browser.android || $.browser.blackberry);
};



    ////////////////////////// Test to intercept events 
    var validNavigation = false;

$(window).bind('beforeunload', function () {
    //return 'It is going to be refreshed';
});

    function endSession() {
        // Browser or broswer tab is closed
        // Do sth here ...
        //alert("bye");
}

    function wireUpEvents() {
        /*
        * For a list of events that triggers onbeforeunload on IE
        * check http://msdn.microsoft.com/en-us/library/ms536907(VS.85).aspx
        */
    window.onbeforeunload = function () {
        if (!validNavigation) {
            endSession();
    }
    }

        // Attach the event keypress to exclude the F5 refresh
    $(document).bind('keypress', function (e) {
        if (e.keyCode === 116) {
            validNavigation = true;
    }
    });

        // Attach the event click for all links in the page
    $("a").bind("click", function () {
        validNavigation = true;
    });

        // Attach the event submit for all forms in the page
    $("form").bind("submit", function () {
        validNavigation = true;
    });

        // Attach the event click for all inputs in the page
    $("input[type=submit]").bind("click", function () {
        validNavigation = true;
    });

}

    // Wire up the events as soon as the DOM tree is ready
    $(document).ready(function () {
        wireUpEvents();
    });
    ////////////////////////// Test to intercept events 



    ////////////////////////// Minimizado de paneles
    /*
     * Funciónes obtenidas del plugin: https://github.com/alfredobarron/smoke
     * 
     * Integrado en la parte fíja de la página. En la etiqueta "foot"
     */
(function ($) {

     /**
       * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
       * Fullscreen
       * $('div').smkFullscreen();
       * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
       */
    $.fn.smkFullscreen = function () {

        // Se crea el boton fullscreen
        var btnFullscreen = '<a class="btn smk-fullscreen" href="#"><span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span></a>';

        // Se agrega el boton fullscreen en el elemento
        $(this).append(btnFullscreen);

        // Evento del boton fullscreen
        $('.smk-fullscreen').click(function (event) {
            event.preventDefault();
            toggleFullScreen();
        });

        // Se crea el metodo que dispara el fullscreen
        function toggleFullScreen() {
            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
            }
        }
    }

        // Se crea el metodo que cambia el icono del boton
        var changeFullscreen = function () {
            $('.smk-fullscreen').children('.glyphicon').toggleClass('glyphicon-fullscreen').toggleClass('glyphicon-resize-small');
    };

        // Se escuchan los cambios del fullscreen
        document.addEventListener("fullscreenchange", changeFullscreen, false);
        document.addEventListener("msfullscreenchange", changeFullscreen, false);
        document.addEventListener("mozfullscreenchange", changeFullscreen, false);
        document.addEventListener("webkitfullscreenchange", changeFullscreen, false);
 };
 })(jQuery);

    ////////////////////////// Minimizado de paneles
    /*
     * Funciónes obtenidas del plugin: https://github.com/alfredobarron/smoke
     * 
     * Necesita integración de cada view en el cuerpo que lo necesite.
     * 
     * Para todos los paneles del view (y subViews): $('.panel').smkPanel;
     * Para un panel en especial utilizar su id.
     */
(function ($) {
     /*
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Panel
     * $('.panel').smkPanel({hide: 'min,remove,full', class: 'name-class'});
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     */
 //   $.fn.smkPanel = function (options) {
 //       // Variables default
 //       var settings = $.extend({
 //               hide: ''
 //       }, options);

 //       var thisPanel = $(this);

 //       // Se eliminan los espacios en blanco de la variable settings.hide
 //       var hideSinEspacios = settings.hide.replace(/\s/g, '');

 //       // Se quiebra la variable hideSinEspacios para obtener sus valores y se agregan en el array arrayHide
 //       var arrayHide = hideSinEspacios.split(',');

 //       // Se obtiene el .panel-title de cada panel
 //       var panelHeading = $(this).children('.panel-heading');
 //       if (!panelHeading.length) {
 //           panelHeading = $("<div>", { class: 'panel-heading' });
 //           $(this).prepend(panelHeading);
 //       }

 //       var panelTitle = panelHeading.children('.panel-title');

 //       panelHeading.addClass('clearfix');

 //       if (panelTitle.length) {
 //           panelTitle.addClass('pull-left');
 //       }

 //       // Se crea el btn-group
 //       var btnGroup = '<div class="btn-group btn-group-xs pull-right" role="group">';

 //       // Se valida que no exista en el array el boton min para poder agregarlo dentro de btnGroup
 //       if ($.inArray('min', arrayHide) === -1) {
 //           btnGroup += '<a class="btn smk-min" href="#"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>';
 //       }

 //       // Se valida que no exista en el array el boton remove para poder agregarlo dentro de btnGroup
 //       if ($.inArray('remove', arrayHide) === -1) {
 //           btnGroup += '<a class="btn smk-remove" href="#"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
 //       }

 //       // Se valida que no exista en el array el boton full para poder agregarlo dentro de btnGroup
 //       if ($.inArray('full', arrayHide) === -1) {
 //           btnGroup += '<a class="btn smk-full" href="#"><span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span></a>';
 //       }

 //       btnGroup += '</div>';

 //       // Se inserta dentro de .panel-heading
 //       $(this).children('.panel-heading').append(btnGroup);

 //       // Evento del boton Min
 //       thisPanel.find('.smk-min').click(function (event) {
 //           event.preventDefault();
 //           var body = $(this).parents('.panel-heading').siblings('.panel-body');
 //           var footer = $(this).parents('.panel-heading').siblings('.panel-footer');
 //           var icon = $(this).children('.glyphicon');
 //           $(footer).slideToggle('fast');
 //           $(body).slideToggle('fast', function () {
 //               icon.toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
 //           });

 //       });

 //       // Evento del boton Remove
 //       thisPanel.find('.smk-remove').click(function (event) {
 //           event.preventDefault();
 //           var panel = $(this).parents('.panel');
 //           panel.fadeOut(400, function () {
 //               //this.remove();
 //           });
 //       });

 //       // Evento del boton Full
 //       thisPanel.find('.smk-full').click(function (event) {
 //           event.preventDefault();
 //           var panel = $(this).parents('.panel');
 //           var body = $(this).parents('.panel-heading').siblings('.panel-body');
 //           var icon = $(this).children('.glyphicon');
 //           var iconPlus = $(this).siblings('.btn').children('.glyphicon-plus');

 //           if (panel.hasClass('panel-full')) {
 //               panel.removeClass('panel-full');
 //               $(this).siblings('.btn').show();
 //               if (iconPlus.length === 1) {
 //                   body.hide();
 //           }
 //               $('body').css({ 'overflow': 'auto' });
 //               // $('.container-fluid').css({'display':'block'});
 //               // $('#content').css({'position':'fixed'});
 //           } else {
 //               panel.addClass('panel-full');
 //               $(this).siblings('.btn').hide();
 //               if (iconPlus.length === 1) {
 //                   body.show();
 //           }
 //               $('body').css({ 'overflow': 'hidden' });
 //               // $('.container-fluid').css({'display':'initial'});
 //               // $('#content').css({'position':'initial'});
 //       }
 //           icon.toggleClass('glyphicon-resize-full').toggleClass('glyphicon-resize-small');
 //       });
 //};
 })(jQuery);



    ////////////////////////// Back to Top
    /*
     * Funciónes obtenidas del plugin: https://bootsnipp.com/snippets/featured/back-to-top-scroll-feature
     * 
     * Integrado en la parte fíja de la página. En la etiqueta "foot"
     */
$(document).ready(function () {

    $(function () {

        $(document).on('scroll', function () {

            if ($(window).scrollTop() > 100) {
                $('.scroll-top-wrapper').addClass('show');
            } else {
                $('.scroll-top-wrapper').removeClass('show');
        }
        });

        $('.scroll-top-wrapper').on('click', scrollToTop);
    });

    function scrollToTop() {
        verticalOffset = typeof (verticalOffset) !== 'undefined' ? verticalOffset : 0;
        element = $('body');
        offset = element.offset();
        offsetTop = offset.top;
        $('html, body').animate({ scrollTop: offsetTop }, 500, 'linear');
}
 });









/**
     * Módulo para realizar algunas operaciones sobre el combo de tipo bootstrap-select
     * 
     * http://silviomoreto.github.io/bootstrap-select/
     * Examples: https://silviomoreto.github.io/bootstrap-select/examples/
     */




   


    

    ///**
    // * Recarga el combo manteniendo el item seleccionado si sigue existiendo.
    // */
    //function MainReleaseComboReload() {

    //    instance = GetMainReleaseComboInstance();

    //    instance.Reload();
    //}

    


    


    //GetMenuSelectedCat
    //SetMenuSelectedCat
    //GetSubMenuSelectedSubcat
    //SetSubMenuSelectedSubcat

    //GetInputSelectedCatName
    //SetInputSelectedCatName
    //GetInputSelectedSubCatName
    //SetInputSelectedSubCatName
    //GetInputSelectedSystemId
    //SetInputSelectedSystemId
    //GetInputSelectedDeliveryId
    //SetInputSelectedDeliveryId

    /*
     * Funciones relacionadas con el menú de las subcategorías..
     */
    var MainSubCategoryMenu = (function () {

        return {
            /*
             * Activa una categoría por el nombre
             */
            SetCategory: function (subCategoryName) {
                $("#navBarMenuSubCat .nav").find(".active").removeClass("active");
                $("#navBarMenuSubCat .nav").find("#" + subCategoryName).addClass("active");
            }
        }
    })();

    /*
     * Funciones relacionadas con el almacenamiento de datos seleccionados por el usuario:
     * Delivery seleccionada.
     * Sistema seleccionado.
     * Categoría seleccionada.
     * Subcategoría seleccionada.
     */
    var UserSelectedData = (function () {

        var deliveryIdDevault = -1;
        var systemIdDefault = -1;

        return {
            SetCategory: function (category, notAddSelectedInMenu) {
                $('#SelectedCategory').val(category);

                if (notAddSelectedInMenu === 0) {
                    MainCategoryMenu.SetCategory(category);
                }
            },

            SetSubCategory: function (subCategory, notAddSelectedInMenu) {
                if (subCategory !== "") {
                    $('#SelectedSubCategory').val(subCategory);

                    if (notAddSelectedInMenu === 0) {
                        MainCategoryMenu.SetSubCategory(category);
                    }
                }
            },

            SetDelivery: function (deliveryId) {
                if (subCategory !== "") {
                    $('#SelectedReleaseId').val(deliveryId);
                } else {
                    $('#SelectedReleaseId').val(deliveryIdDevault);
                }
            },

            SetSystem: function (systemId) {
                if (subCategory !== "") {
                    $('#SelectedSystemId').val(systemId);
                } else {
                    $('#SelectedSystemId').val(systemIdDefault);
                }
            },

            GetCategory: function () {
                return $('#SelectedCategory').val();
            },

            GetSubCategory: function () {
                return $('#SelectedSubCategory').val();
            },

            GetDelivery: function () {
                if ($('#SelectedReleaseId').val() === '') return -1;

                return $('#SelectedReleaseId').val();
            },

            GetSystem: function () {
                if ($('#SelectedSystemId').val() === '') return -1;

                return $('#SelectedSystemId').val();
            }
        };
    })();

/*************************************
*  Pruebas                            *
**************************************/
/*
* Abre una ventana nueva con la categoría que lo ha solicitado.
*
*/
function OpenNewWindowsFromCat(category) {
    var category = category;
    var subCategory = '';
    var release = GetSelectedRelease();
    var system = GetSelectedSystem();

    console.log("Solicitud apertura de nueva ventana desde cat: " + category + " - " + subCategory);

    OpenNewWindows(category, subCategory, release, system);
}

/*
* Abre una ventana nueva con la categoría que lo ha solicitado.
*
*/
function OpenNewWindowsFromSubCat(subCat) {
    var category = GetSelectedCategory();
    var subCategory = subCat;
    var release = GetSelectedRelease();
    var system = GetSelectedSystem();

    console.log("Solicitud apertura de nueva ventana desde subCat: " + category + " - " + subCategory);

    OpenNewWindows(category, subCategory, release, system);
}

$(document).ready(function () {
    $('.main-menu-item a').on('click', function (evnt) {
        if (
            evnt.ctrlKey ||
            evnt.shiftKey ||
            evnt.metaKey || // apple
            (evnt.button && evnt.button == 1) // middle click, >IE9 + everyone else
        ) {

            evnt.preventDefault();

            var idItem = evnt.currentTarget.id;

            OpenNewWindowsFromCat(idItem);
        }

        return;
    })

    $('.main-menu-item a').on('click auxclick contextmenu', function (e) {
        if (e.type == "contextmenu") {
            console.log("Context menu prevented.");
            return;
        }

        switch (e.which) {
            case 1:
                break;
            case 2:
                e.preventDefault();
                OpenNewWindowsFromCat($(e.target).parent('.main-menu-item')[0].id)
                break;
            case 3:
                e.preventDefault();
                break;
        }
    });

    $('.subcat-menu-item').on('click', function (evnt) {
        if (
            evnt.ctrlKey ||
            evnt.shiftKey ||
            evnt.metaKey || // apple
            (evnt.button && evnt.button == 1) // middle click, >IE9 + everyone else
        ) {

            evnt.preventDefault();

            var idItem = $(evnt.target).parent('.main-menu-item')[0].id;

            OpenNewWindowsFromSubCat(idItem);
        }

        return;
    });    

    $('.subcat-menu-item').on('click auxclick contextmenu', function (e) {
        if (e.type == "contextmenu") {
            console.log("Context menu prevented.");
            return;
        }

        switch (e.which) {
            case 1:                
                break;
            case 2:                
                e.preventDefault();
                OpenNewWindowsFromSubCat(e.currentTarget.id);
                break;
            case 3:
                e.preventDefault();                
                break;
        }
    });
});