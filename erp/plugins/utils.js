/*******************************************************************************
* Miscelanea
*******************************************************************************/

function GetBasePath() {

    var pathArray = location.href.split('/');
    var protocol = pathArray[0];
    var host = pathArray[2];
    var url = protocol + '//' + host;

    return url;
}

function executeFunctionByName(functionName, context, args) {
    var args = [].slice.call(arguments).splice(2);
    var namespaces = functionName.split(".");
    var func = namespaces.pop();
    for (var i = 0; i < namespaces.length; i++) {
        context = context[namespaces[i]];
    }
    return context[func].apply(context, args);
}

function setPageTitle(title) {
    document.title = title;
}

// Disable function
jQuery.fn.extend({
    disable: function (state) {
        return this.each(function () {
            this.disabled = state;
        });
    }
});


/*******************************************************************************
* Ajax
*******************************************************************************/

/* Extensiones
**************************************************/

/**
* Carga un view en un elemento pasado.
*
* Si ok, el objeto devolvera el view en 'data.result.view'
*/
(function ($) {
    $.fn.extend({
        AjaxViewPartIn: function (url, dictionaryParamas, OnSuccessCallbackFunc, OnErroCallbackFunc) {

            return this.each(function () {

                $this = $(this);

                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function (result) {

                        var stopProccess = ProcessJSonResultGeneric(result, "AjaxViewPartIn", null, null, false)

                        if (stopProccess) return;

                        //Limpiamos el destino
                        $this.empty();

                        //Asignamos el html resultado.
                        $this.html(result.data.view);

                        if (typeof OnSuccessCallbackFunc !== 'undefined') {
                            OnSuccessCallbackFunc(result);
                        }
                    },
                    error: function (data) {

                        //Limpiamos el destino
                        $this.empty();

                        //Asignamos el html resultado.
                        $this.html('Error al cargar la petición: ' + data.exceptionText);

                        if (typeof OnErroCallbackFunc !== 'undefined') {
                            OnErroCallbackFunc(result);
                        }
                    }
                });
            });
        },
    });
}(jQuery));

/* Metodos
**************************************************/

/**
 * Función que procesa un resultado de tipo JsonResultModel.
 * - Comprueba y ejecuta si el resultado corresponde a que ha expirado la sessión. (devuelve true)
 * - Añade los mensajes a la tabla de mensajes
 * - Lanza un toast si ha ocurrido algún error.
 *  
 * @param {JSonResultModel} resultado de la operación.
 * @param {text} Nombre de la operación
 */
function ProcessJSonResultGeneric(e, nameOperation, OnSuccessCallbackFunc, OnErrorCallbackFunc, checkStateOk) {

    var result = e;

    //Obtenemos las opciones de configuración genéricas del toast
    toastr.options = GetToastROptions();

    //Preparamos el mensaje.
    nameOperation = " " + nameOperation;
    
    //Comprobamos que el modelo sea correcto
    if (e === null || e === 'undefined') {
        toastr.error("No se ha devuelto ningún resultado para la operación: " + nameOperation, "");

        if (OnErrorCallbackFunc != null && typeof OnErrorCallbackFunc !== 'undefined') {
            OnErrorCallbackFunc(result);
        }

        //Indicamos que se pare la continuación del proceso
        return true;
    }

    //Comprobamos si es una redirección. Si es así, redireccionamos en la función
    CheckResultRedirect(result);
    
    //Cargamos el panel de mensajes.
    LoadMessageGrid(result.messages);

    //En caso que haya expirado la sessión se informa al usuario
    if (e.type === JSON_RESULT_TYPE_SESSION_EXPIRED) {
        toastr.warning("La operación no ha sido realizada por que ha expirado la sessión. Vuelva a intentar la operación.");

        //Indicamos que se pare la continuación del proceso        
        return true;
    }

    //Informamos al usuario de la operación con error
    if (result.state === JSON_RESULT_STATE_ERROR) {
        var text = '';

        if (result.exceptionText !== null && result.exceptionText.trim() !== '') {
            text = result.exceptionText;
        } else {
            var messagesError = result.messages.filter(function (messages) { return messages.MessageType === JSON_RESULT_MESSAGE_TYPE_ERROR; });
            for (i = 0; i < messagesError.length; i++) {
                text = text + messagesError[i].Message;
            }
        }

        toastr.error("Error en la operación" + nameOperation + ": " + text, "");

        if (OnErrorCallbackFunc != null && typeof OnErrorCallbackFunc !== 'undefined') {
            OnErrorCallbackFunc(result);
        }

        //Indicamos que se pare la continuación del proceso (si se quiere continuar, se realizaría en el callback de error)        
        return true;
    }

    //Informamos al usuario de la operación ok si así lo desea
    if (checkStateOk !== 'undefined' && checkStateOk === true) {
        if (result.state === JSON_RESULT_STATE_OK) {
            toastr.info("Operación realizada correctamente: " + nameOperation, "");

            if (OnSuccessCallbackFunc !== null && typeof OnSuccessCallbackFunc !== 'undefined') {
                OnSuccessCallbackFunc(result);
            }

            return false;
        }
    }    

    //Información al usuario de finalización con warnings.
    if (result.state === JSON_RESULT_STATE_OK_WARNINGS) {

        var textWarning = '';
        var messagesWarning = result.messages.filter(function (messages) { return messages.MessageType === JSON_RESULT_MESSAGE_TYPE_WARNING; });
        for (i = 0; i < messagesWarning.length; i++) {
            textWarning = textWarning + messagesWarning[i].Message;
        }

        toastr.warning("Operación" + nameOperation + " finalizada con warnings: " + textWarning, "");

        if (OnSuccessCallbackFunc !== null && typeof OnSuccessCallbackFunc !== 'undefined') {
            OnSuccessCallbackFunc(result);
        }

        return false;
    }
}

/*
 * Comprueba que un JSonResult responde con redirección. Se añade a todas las peticiones ajax.
 */
function CheckResultRedirect(result) {
    if (result !== null || result !== 'undefined' && result.hasOwnProperty('isRedirect')) {
        if (result.isRedirect) {
            window.location.href = result.redirectUrl;
        }
    }
}

/*******************************************************************************
* Objetos
*******************************************************************************/

/**
 * Tipo de objeto que proporciona funciones de acceso de tipo diccionario.
 *
 * Inicialización: var dic = dictionary
 *
 * Insertar un elemento: dic.Add('key1', 'value1')
 *
 * Comprobar si contiene una clave: dic.ContainsKey('key1')
 *
 * Obtener el primer valor encontrado con la clave pasada: dic.GetFirstValueOf('key1')
 */
var dictionary = (function () {

    // Private variables / properties
    var array = [];

    function GetFirstValueOf(lKey) {
        var keyValue = array.filter(function (array) { return array.key === lKey; });

        if (keyValue.length > 0) {
            return keyValue[0].value;
        }
    }

    function ContainsKey(lKey) {
        if (typeof GetFirstValueOf(lKey) === 'undefined') {
            return false;
        }

        return true;
    }

    // Public API
    return {
        Data: function () {
            return array;
        },

        /*
        * Añade elementos al array de tipo key - value
        */
        Add: function (lKey, lValue) {
            var res = array.push({ key: lKey, value: lValue });

            return res;
        },

        /**
        * Obtiene el primer valor encontrado con la clave pasada o undefined si no ha encontrado la clave.
        */
        GetFirstValueOf: function (lKey) {
            return GetFirstValueOf(lKey);
        },

        /**
        * Comprueba si existe una clave en el array
        */
        ContainsKey: function (lKey) {
            return ContainsKey(lKey);
        },

        /**
        * Comprueba si existe una clave en el array
        */
        Length: function () {
            return array.length;
        },
    };
}());


/*******************************************************************************
* CSS y JS
*******************************************************************************/

function loadScriptIfNotExits(url, callback, initFunctionName, args)
{
    if (!isMyScriptLoaded(url))
    {
        loadScript(url, function () {

            if (typeof callback !== 'undefined') {
                callback();

                if (typeof initFunctionName !== 'undefined') executeFunctionByName(initFunctionName, window, args);
            }
        });
    } else {
        if (typeof initFunctionName !== 'undefined') executeFunctionByName(initFunctionName, window, args);
    }
}

function loadCssIfNotExits(url, callback) {
    if (!isMyStyleLoaded(url)) {
        loadCss(url, function () {
            if (typeof callback !== 'undefined') {
                callback();                
            }
        });
    } 
}

/*
* Función que carga un script js en la cabecera. 
* 
* Ejemplo:
*     
*    loadScript("/Content/js/register.js", function () {
*        //initialization code
*     });
*/
function loadScript(url, callback) {

    //var len = $('script[src="' + url + '"]').length;

    //if (len > 0) return;

    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState) {  //IE
        script.onreadystatechange = function () {
            if (script.readyState === "loaded" ||
                    script.readyState === "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function () {
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

/**
* Función que carga dinámicamente un css en la cabecera.
* 
* Ejemplo:
*     
*    loadScript("/Content/blueimp-gallery2/css/blueimp-gallery-indicator.css", function () {
*        //initialization code
*     });
*/
function loadCss(url, callback) {

    var script = document.createElement("link")
    script.type = "text/css";
    script.rel = 'stylesheet';
    script.media = 'all';
    script.id = url;


    if (script.readyState) {  //IE
        script.onreadystatechange = function () {
            if (script.readyState === "loaded" ||
                    script.readyState === "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function () {
            callback();
        };
    }

    script.href = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

/*
 * Función que comprueba si un css ha sido cargado.
 */
function isMyStyleLoaded(url) {
    var scripts = $("[rel='styleSheet']");

    for (var i = scripts.length; i--;) {
        if (scripts[i].href == GetBasePath() + url) return true;
    }

    return false;
}

/*
 * Función que comprueba si un script ha sido cargado.
 */
function isMyScriptLoaded(url) {    
    var scripts = document.getElementsByTagName('script');

    for (var i = scripts.length; i--;) {
        if (scripts[i].src == GetBasePath() + url) return true;
    }

    return false;
}

/*******************************************************************************
* Utilidades bootstrap-select: https://silviomoreto.github.io/bootstrap-select/
*******************************************************************************/


/* Extensiones
**************************************************/

(function ($) {
    $.fn.extend({
        /**
        * Carga un combo de tipo bootstrap-select desde una urls
        */
        bootStrapSelectLoad: function (url, OnSuccessCallbackFunc, OnErroCallbackFunc) {

            return this.each(function () {

                $this = $(this);

                if ($this.hasClass('selectpicker') === false) {
                    throw new Error('Element not is a selectpicker');
                }

                var module = bootStrapSelectModule;
                var config = {
                    url: url,
                    combo: $this
                };

                module.Init(config);
                module.Load(OnSuccessCallbackFunc, OnErroCallbackFunc);
            });
        },
    });
}(jQuery));

/* Metodos
**************************************************/

/*
 * Carga un combo con una lista de tipo: key - value.
 * 
 * Ej lista: "[{"Key":1,"Value":"Elemento 1"},{"Key":6,"Value":"Elemento 6"}]"
 * Ej llamada: LoadSelectedPickerCombo($("#CmbContactFilterContactGroupId"), lstAppConfigContactsGroup);
 */
function LoadSelectedPickerCombo(combo, jsonStringKeyValue, value) {
    var selected;

    //Transformamos el listado a un listado de elementos con las propiedades key y Value
    var listaDeserializada = JSON.parse(jsonStringKeyValue);

    //Añadimos los elementos al combo.
    for (i = 0 ; i < listaDeserializada.length; i++) {
        var keyValuePair = listaDeserializada[i];
        selected = (value !== undefined && keyValuePair.Key.toString() === value.toString()) ? "SELECTED" : "";
        $(combo).append('<option ' + selected + ' value="' + keyValuePair.Key + '">' + keyValuePair.Value + '</option>');
    }

    //configuramos el combo.
    $(combo).selectpicker({
        style: 'btn-info'
    });

    //Seleccionamos el valor pasado.
    if (value !== 'undefined' && value !== null) {
        $(combo).val(value);
    }

    //Refrescamos el combo.
    $(combo).selectpicker('refresh');
}


/* Metodos
**************************************************/

/**
 * Módulo para realizar algunas operaciones sobre el combo de tipo bootstrap-select  
 */
var bootStrapSelectModule = (function () {

    // Private variables / properties
    var config = {
        url: '',
        //fieldNameValue: 'id',
        //fieldNameText: 'name',
        combo: ''
    };

    // Public API
    return {

        /*
        * Inicializa el módulo con la configuración pasada.
        */
        Init: function (options) {
            for (var prop in options) {
                if (options.hasOwnProperty(prop)) {
                    config[prop] = options[prop];
                }
            };
        },

        /*
        * Carga el combo mediante Ajax desde la url indicada.
        */
        Load: function (OnSuccessCallbackFunc, OnErroCallbackFunc) {
            var select = config['combo'];
            var url = config['url'];
            var module = this;


            $.ajax({
                url: url,
                dataType: 'json',
                success: function (data) {
                    //select.html('');
                    module.Clear();

                    var obj = jQuery.parseJSON(data);

                    $.each(obj, function (key, val) {
                        select.append('<option value="' + key + '">' + val + '</option>');
                    });

                    select.selectpicker('refresh');

                    if (typeof OnSuccessCallbackFunc !== 'undefined') {
                        OnSuccessCallbackFunc(select);
                    }
                },
                error: function (data) {

                    module.Clear();

                    select.append('<option>' + '#ERROR#' + '</option>');

                    select.selectpicker('refresh');

                    if (typeof OnErroCallbackFunc !== 'undefined') {
                        OnErroCallbackFunc(select);
                    }
                }
            });
        },

        /**
        * Recarga el combo mediante Ajax desde la url indicada manteniendo el item seleccionado.
        */
        Reload: function () {
            var select = config['combo'];

            var idSelected = select.val();

            this.Load(function () {
                select.val(idSelected);
                select.selectpicker('refresh');
            });
        },

        /*
        * Obtiene el valor del elemento seleccionado.
        */
        GetSelectedValue: function () {
            return config['combo'].val();
        },

        /**
        * Limpia el combo.
        */
        Clear: function () {
            config['combo'].html('');
            config['combo'].selectpicker('refresh');
        },

        /**
        * Elimina el item seleccionado.
        */
        RemoveSelected: function () {
            var value = this.GetSelectedValue();

            config['combo'].find('[value=' + value + ']').remove();

            config['combo'].selectpicker("refresh");
        }
    }
}());

/***********************************************
* Utilidades Gijgo grid. http://gijgo.com/grid/
************************************************/

/* Globales
**************************************************/

var GijgoUtilsGridColumnLocalId = "LocalId";
var GijgoUtilsGridColumnEditStatus = "EditStatus";

var GijgoUtilsGridEditStatusRowCharNew = "N";
var GijgoUtilsGridEditStatusRowCharUpdate = "U";
var GijgoUtilsGridEditStatusRowCharOriginal = "O";

function GetEditBtnGigjo(dataKey, dataType) {
    return '<button type="button" class="btn btn-default btn-sm btn-edit" data-key="' + dataKey + '" data-type="' + dataType + '"><span class="glyphicon glyphicon-pencil" aria-hidden="true" style="color:#3b9fb5"></span></button>'
}

function GetUpdateBtnGigjo(dataKey, dataType) {
    return '<button type="button" class="btn btn-default btn-sm btn-update" data-key="' + dataKey + '" data-type="' + dataType + '" style="margin-right:5px;color:green"><span class="fa fa-check" aria-hidden="true"></span></button>'
}

function GetCancelBtnGigjo(dataKey, dataType) {
    return '<button type="button" class="btn btn-default btn-sm btn-cancel" data-key="' + dataKey + '" data-type="' + dataType + '"><span class="fa fa-times" aria-hidden="true" style="color:#aaa"></span></button>'
}

function GetDeleteBtnGigjo() {
    return '<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>'
}


/* Renders y ayuda para renders
 ************************************************/

GijgoUtilsGridPhoneRenderer = function (value, record, $cell, $displayEl, id)
{
    var $editBtnBootStrap = $('<a href="tel:' + value + '" title="' + value + '">' + value + '</a>');

    $displayEl.empty();

    $displayEl.append($editBtnBootStrap);
}

//Editor tipo dateTimePicker para la fecha y hora del grid gijgo
//https://eonasdan.github.io/bootstrap-datetimepicker/
GijgoUtilsGridColumnDateTimePickerEdition = function ($container, currentValue) {
    
    var $inputGigjoDatePicker = $("<input value='' type='hidden'></input>"
        + "<div class='input-group date' style='position:relative'>"
        + "<input type='text' class='form-control' />"
        + "<span class='input-group-addon'>"
        + "<span class='glyphicon glyphicon-calendar'></span>"
        + "</span>"
        + "</div>");
    
    $container.append($inputGigjoDatePicker);

    $($inputGigjoDatePicker).datetimepicker({    
        format: DPMWEB_GLOBAL_DATE_TIME_FORMAT
    });

    //Necesario para que se vea el diálogo
    $container.css('overflow', 'visible');
    $($container.closest('td')[0]).css('overflow', 'visible');

    //comprobamos que el currenDate es una fecha válida
    var datemoment = moment(currentValue);

    if (datemoment.isValid()) {
        $($inputGigjoDatePicker).datetimepicker({
            date: datemoment
        });
    }

    var $input = $container.find('input');
    $input.val(currentValue);

    //Cuando se modifique cambiamos el valor del input
    $($inputGigjoDatePicker).on('dp.change', function (e) {
        if (e.date !== false) {
            $input.val(e.date.local().format(DPMWEB_GLOBAL_DATE_TIME_FORMAT));
        } else {
            $input.val('');
        }
    });
}

//Editor tipo dateTimePicker para la fecha y hora del grid gijgo
//https://eonasdan.github.io/bootstrap-datetimepicker/
GijgoUtilsGridColumnDatePickerEdition = function ($container, currentValue) {

    var $inputGigjoDatePicker = $("<input value='' type='hidden'></input>"
        + "<div class='input-group date' id='.columnDateTimePicker'>"
        + "<input type='text' class='form-control' />"
        + "<span class='input-group-addon'>"
        + "<span class='glyphicon glyphicon-calendar'></span>"
        + "</span>"
        + "</div>");

    $container.append($inputGigjoDatePicker);

    $($inputGigjoDatePicker).datetimepicker({
        format: DPMWEB_GLOBAL_DATE_FORMAT
    });

    //Necesario para que se vea el diálogo
    $container.css('overflow', 'visible');
    $($container.closest('td')[0]).css('overflow', 'visible');

    //comprobamos que el currenDate es una fecha válida
    var datemoment = moment(currentValue);

    if (datemoment.isValid()) {
        $($inputGigjoDatePicker).datetimepicker({
            date: datemoment
        });
    }

    var $input = $container.find('input');
    $input.val(currentValue);

    //Cuando se modifique cambiamos el valor del input
    $($inputGigjoDatePicker).on('dp.change', function (e) {
        if (e.date !== false) {
            $input.val(e.date.local().format(DPMWEB_GLOBAL_DATE_FORMAT));
        } else {
            $input.val('');
        }
    });
}

//Editor tipo dateTimePicker para la hora del grid gijgo
//https://eonasdan.github.io/bootstrap-datetimepicker/
GijgoUtilsGridColumnTimerPickerEdition = function ($container, currentValue) {

    var $inputGigjoDatePicker = $("<input value='' type='hidden'></input>"
        + "<div class='input-group date' id='.columnDateTimePicker'>"
        + "<input type='text' class='form-control' />"
        + "<span class='input-group-addon'>"
        + "<span class='glyphicon glyphicon-calendar'></span>"
        + "</span>"
        + "</div>");

    $container.append($inputGigjoDatePicker);

    $($inputGigjoDatePicker).datetimepicker({
        format: DPMWEB_GLOBAL_TIME_FORMAT
    });

    //Necesario para que se vea el diálogo
    $container.css('overflow', 'visible');
    $($container.closest('td')[0]).css('overflow', 'visible');

    //comprobamos que el currenDate es una fecha válida
    var datemoment = moment(currentValue);

    if (datemoment.isValid()) {
        $($inputGigjoDatePicker).datetimepicker({
            date: datemoment
        });
    }

    var $input = $container.find('input');
    $input.val(currentValue);

    //Cuando se modifique cambiamos el valor del input
    $($inputGigjoDatePicker).on('dp.change', function (e) {
        if (e.date !== false) {
            $input.val(e.date.local().format(DPMWEB_GLOBAL_TIME_FORMAT));
        } else {
            $input.val('');
        }
    });
}

//Editor tipo spinner para el grid gijgo
//https://api.jqueryui.com/spinner/
GijgoUtilsGridSpinnerEdition = function ($container, currentValue) {
    //TODO IKER: incluir el estylo donde tenga que estar.
    var $inputGigjoDatePicker = $("<input class='spinner grid_spinner' style='width: 30px;'></input>");

    $container.append($inputGigjoDatePicker);

    var spinner = $($inputGigjoDatePicker).spinner();

    spinner.spinner({
        min: 0,
        step: 1
    });
        
    spinner.spinner("value", currentValue);
}

/*
 * Renderiza el texto de una celda de Gijgo.com con el texto del listado dado el valor (fuerza un valor la primera vez). 
 * Ej lista: "[{"Key":1,"Value":"Elemento 1"},{"Key":6,"Value":"Elemento 6"}]"
 * Ej llamada: 
 * ContactGroupRenderer = function (value, record, $cell, $displayEl) {
 *      $displayEl.text(GijgoUtilGetRendererValueCombo(value, $cell, lstAppConfigContactsGroup));
 *  };
 */
function GijgoUtilRendererForceValueCombo(value, record, $cell, $displayEl, list) {

    var key;

    if (value === undefined || value === null) {
        return;
    }

    //Obtenemos del "diccionario" la clave-valor que corresponde
    var keyValueList = list.filter(function (list) { return list.Key.toString() === value.toString() });

    $displayEl.empty();

    $displayEl.append('<input type="hidden" value=""></input>');

    //Añadimos el texto si lo ha encontrado.
    if (keyValueList.length > 0) {
        $displayEl.append(keyValueList[0].Value);
        key = keyValueList[0].Key;
    }

    //Añadimos el valor al input
    var $input = $displayEl.find('input');
    $input.val(key);
}

function GijgoUtilEditorValueCombo($container, currentValue, list) {
    var selectHtml, selected, localCurrentValue;


    localCurrentValue = $(currentValue).val();

    selectHtml = '<input value="" type="hidden"></input>';

    //Creamos el combo
    selectHtml += "<select class=''>";

    list.forEach(function (label, value) {
        selected = (localCurrentValue !== undefined && label.Key.toString() === localCurrentValue.toString()) ? "SELECTED" : "";
        selectHtml += "<option " + selected + " value=" + label.Key + ">" + label.Value + "</option>"
    });

    selectHtml += "</select>";

    //Añadimos el combo
    $container.append(selectHtml);

    var $combo = $container.find('select');
    var $input = $container.find('input');

    //Configuramos el combo
    $combo.selectpicker({
        liveSearch: true, //Activa la búsqueda del combo
        container: 'body' //Evita que el desplegable se incluya por debajo del grid (nota. se puede incluir cualquier clase)
    });

    $combo.on('change', function () {
        $input.val($(this).find("option:selected").val());
    });

    if (localCurrentValue === undefined || localCurrentValue.trim() === '') {
        localCurrentValue = list[0].Key;
    }

    //Asignamos los valores 
    $input.val(localCurrentValue);
    $combo.val(localCurrentValue);
    $combo.selectpicker('refresh');
};

/* Metodos
**************************************************/

function GijgoUtilMarkRowAsNew(grid, localId, record) {

    record.EditStatus = GijgoUtilsGridEditStatusRowCharNew;

    grid.updateRow(localId, record);
}

function GijgoUtilMarkRowAsUpdated(grid, localId, record) {    

    //Marcamos la fila como modificada si no es nueva
    if (record.hasOwnProperty('Id')) {
        if (record.Id > 0) {

            record.EditStatus = GijgoUtilsGridEditStatusRowCharUpdate;

            grid.updateRow(localId, record);
        }
    }
}

/**
* Función para cargar los grids de edición en línea.
* - Se añade a los datos una propiedad que representa el identificador local.
* - Se añade a los datos una propiedad que representa el tipo de fila (nueva, actualizada, original)
*/
function GijgoUtilLoadGrid(grid, data) {

    if (data === undefined || data === null) return

    //Recorremos cada elemento añadiéndole las nuevas propiedades
    for (i = 0; i < data.length; i++) {
        //Añadimos el identificador local para trabajar en el grid.
        if (data[i].hasOwnProperty(GijgoUtilsGridColumnLocalId) == false) {
            data[i][GijgoUtilsGridColumnLocalId] = i + 1;
        }

        if (data[i].hasOwnProperty(GijgoUtilsGridColumnEditStatus) == false) {
            data[i][GijgoUtilsGridColumnEditStatus] = GijgoUtilsGridEditStatusRowCharOriginal;
        }
    }

    grid.data.dataSource = data;
    grid.render(grid.data.dataSource);
}

function GijgoUtilPrepareInlineEditData(grid, data) {

    if (data === undefined || data === null) return

    //Recorremos cada elemento añadiéndole las nuevas propiedades
    for (i = 0; i < data.length; i++) {
        //Añadimos el identificador local para trabajar en el grid.
        if (data[i].hasOwnProperty(GijgoUtilsGridColumnLocalId) == false) {
            data[i][GijgoUtilsGridColumnLocalId] = i + 1;
        }

        if (data[i].hasOwnProperty(GijgoUtilsGridColumnEditStatus) == false) {
            data[i][GijgoUtilsGridColumnEditStatus] = GijgoUtilsGridEditStatusRowCharOriginal;
        }
    }

    return data;
}

function GejgoUtilRemoveReloadBtn(parentId) {
    //Me cargo el botón de actualizar del grid que no veo utilidad actual.
    $('#' + parentId + ' .btn[data-role="page-refresh"]').remove();
}

/*
* Función que comprueba si la fila se considera nueva.
*/
function GijgoUtilIsNewRow(grid, key) {    
    return grid.getById(key).EditStatus.trim() == '' || grid.getById(key).EditStatus.trim() == GijgoUtilsGridEditStatusRowCharNew;    
}

/********************************************************
* Utilidades ToastTr https://github.com/CodeSeven/toastr
********************************************************/
function ToastTrVerificationShow(message) {

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "10000",
        "hideDuration": "1000",
        "timeOut": "0",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    toastr.error("Verificación", message).attr('style', 'width: 600px !important');
}

/********************************************************
* Utilidades Table to json https://github.com/lightswitch05/table-to-json/blob/master/src/jquery.tabletojson.js
*
* Fusilado por que no dispone de paquete nugget. 
********************************************************/
(function ($) {
    'use strict';

    $.fn.tableToJSON = function (opts) {

        // Set options
        var defaults = {
            ignoreColumns: [],
            onlyColumns: null,
            ignoreHiddenRows: true,
            ignoreEmptyRows: false,
            headings: null,
            allowHTML: false,
            includeRowId: false,
            textDataOverride: 'data-override',
            extractor: null,
            textExtractor: null
        };
        opts = $.extend(defaults, opts);

        var notNull = function (value) {
            return value !== undefined && value !== null;
        };

        var notEmpty = function (value) {
            return value !== undefined && value.length > 0;
        };

        var ignoredColumn = function (index) {
            if (notNull(opts.onlyColumns)) {
                return $.inArray(index, opts.onlyColumns) === -1;
            }
            return $.inArray(index, opts.ignoreColumns) !== -1;
        };

        var arraysToHash = function (keys, values) {
            var result = {}, index = 0;
            $.each(values, function (i, value) {
                // when ignoring columns, the header option still starts
                // with the first defined column
                if (index < keys.length && notNull(value)) {
                    if (notEmpty(keys[index])) {
                        result[keys[index]] = value;
                    }
                    index++;
                }
            });
            return result;
        };

        var cellValues = function (cellIndex, cell, isHeader) {
            var $cell = $(cell),
              // extractor
              extractor = opts.extractor || opts.textExtractor,
              override = $cell.attr(opts.textDataOverride),
              value;
            // don't use extractor for header cells
            if (extractor === null || isHeader) {
                return $.trim(override || (opts.allowHTML ? $cell.html() : cell.textContent || $cell.text()) || '');
            } else {
                // overall extractor function
                if ($.isFunction(extractor)) {
                    value = override || extractor(cellIndex, $cell);
                    return typeof value === 'string' ? $.trim(value) : value;
                } else if (typeof extractor === 'object' && $.isFunction(extractor[cellIndex])) {
                    value = override || extractor[cellIndex](cellIndex, $cell);
                    return typeof value === 'string' ? $.trim(value) : value;
                }
            }
            // fallback
            return $.trim(override || (opts.allowHTML ? $cell.html() : cell.textContent || $cell.text()) || '');
        };

        var rowValues = function (row, isHeader) {
            var result = [];
            var includeRowId = opts.includeRowId;
            var useRowId = (typeof includeRowId === 'boolean') ? includeRowId : (typeof includeRowId === 'string') ? true : false;
            var rowIdName = (typeof includeRowId === 'string') === true ? includeRowId : 'rowId';
            if (useRowId) {
                if (typeof $(row).attr('id') === 'undefined') {
                    result.push(rowIdName);
                }
            }
            $(row).children('td,th').each(function (cellIndex, cell) {
                result.push(cellValues(cellIndex, cell, isHeader));
            });
            return result;
        };

        var getHeadings = function (table) {
            var firstRow = table.find('tr:first').first();
            return notNull(opts.headings) ? opts.headings : rowValues(firstRow, true);
        };

        var construct = function (table, headings) {
            var i, j, len, len2, txt, $row, $cell,
              tmpArray = [], cellIndex = 0, result = [];
            table.children('tbody,*').children('tr').each(function (rowIndex, row) {
                if (rowIndex > 0 || notNull(opts.headings)) {
                    var includeRowId = opts.includeRowId;
                    var useRowId = (typeof includeRowId === 'boolean') ? includeRowId : (typeof includeRowId === 'string') ? true : false;

                    $row = $(row);

                    var isEmpty = ($row.find('td').length === $row.find('td:empty').length) ? true : false;

                    if (($row.is(':visible') || !opts.ignoreHiddenRows) && (!isEmpty || !opts.ignoreEmptyRows) && (!$row.data('ignore') || $row.data('ignore') === 'false')) {
                        cellIndex = 0;
                        if (!tmpArray[rowIndex]) {
                            tmpArray[rowIndex] = [];
                        }
                        if (useRowId) {
                            cellIndex = cellIndex + 1;
                            if (typeof $row.attr('id') !== 'undefined') {
                                tmpArray[rowIndex].push($row.attr('id'));
                            } else {
                                tmpArray[rowIndex].push('');
                            }
                        }

                        $row.children().each(function () {
                            $cell = $(this);
                            // skip column if already defined
                            while (tmpArray[rowIndex][cellIndex]) { cellIndex++; }

                            // process rowspans
                            if ($cell.filter('[rowspan]').length) {
                                len = parseInt($cell.attr('rowspan'), 10) - 1;
                                txt = cellValues(cellIndex, $cell);
                                for (i = 1; i <= len; i++) {
                                    if (!tmpArray[rowIndex + i]) { tmpArray[rowIndex + i] = []; }
                                    tmpArray[rowIndex + i][cellIndex] = txt;
                                }
                            }
                            // process colspans
                            if ($cell.filter('[colspan]').length) {
                                len = parseInt($cell.attr('colspan'), 10) - 1;
                                txt = cellValues(cellIndex, $cell);
                                for (i = 1; i <= len; i++) {
                                    // cell has both col and row spans
                                    if ($cell.filter('[rowspan]').length) {
                                        len2 = parseInt($cell.attr('rowspan'), 10);
                                        for (j = 0; j < len2; j++) {
                                            tmpArray[rowIndex + j][cellIndex + i] = txt;
                                        }
                                    } else {
                                        tmpArray[rowIndex][cellIndex + i] = txt;
                                    }
                                }
                            }

                            txt = tmpArray[rowIndex][cellIndex] || cellValues(cellIndex, $cell);
                            if (notNull(txt)) {
                                tmpArray[rowIndex][cellIndex] = txt;
                            }
                            cellIndex++;
                        });
                    }
                }
            });
            $.each(tmpArray, function (i, row) {
                if (notNull(row)) {
                    // remove ignoredColumns / add onlyColumns
                    var newRow = notNull(opts.onlyColumns) || opts.ignoreColumns.length ?
                      $.grep(row, function (v, index) { return !ignoredColumn(index); }) : row,

                      // remove ignoredColumns / add onlyColumns if headings is not defined
                      newHeadings = notNull(opts.headings) ? headings :
                        $.grep(headings, function (v, index) { return !ignoredColumn(index); });

                    txt = arraysToHash(newHeadings, newRow);
                    result[result.length] = txt;
                }
            });
            return result;
        };

        // Run
        var headings = getHeadings(this);
        return construct(this, headings);
    };
})(jQuery);

/********************************************************
* Exportación de tablas.
********************************************************/

function FuncEntExportExcel(rows, id, entId, entTypeId, fromDataBase) {
        

    //Almaceno los datos de la tabla/s
    var table =
    {
        id: id,
        rows: rows,        
    }    

    //Almaceno las propiedades específicas
    var entProperties = {
        EntId: entId,
        EntTypeId: entTypeId,
        ExportFromDataBase: fromDataBase
    }

    //Creo el objeto general
    var obj = {
        commons: GetSelectedDataGroup(),
        properties: entProperties,
        table: table
    }

    //console.info(JSON.stringify(obj));

    $.ajax({
        cache: false,
        url: '/Commons/ExportEntToExcel',
        type: 'POST',
        data: { jsonString: JSON.stringify(obj) },
        success: function (result) {

            var id = "Sin identificador";

            if (grid !== undefined) {
                id = grid.attr("id");
            }

            var stopProccess = ProcessJSonResultGeneric(result, "Exportación tabla con identificador " + id, null, null, false)

            if (stopProccess) return;              

            if (result.type === JSON_RESULT_TYPE_FILE_INFO) {
                window.location = '/Commons/DownloadFile?relativePath=' + result.data.RelativeUrl;
            }
        }
    })
}

/********************************************************
* Conexiones Signal
********************************************************/

/*
 * Conexión signal para las acciones con los entregables.
 */
function connectSignalEntActions(actionCallback) {

    toastr.options = GetToastROptions();

    // Reference the auto-generated proxy for the hub.
    var entAction = $.connection.entActionHub;

    // Create a function that the hub can call back to display messages.
    entAction.client.userViewChange = function (entActionEventArgs) {
        //toastr.info("Operación realizada correctamente: " + entActionEventArgs, "");
        if (typeof actionCallback !== 'undefined') {
            actionCallback(entActionEventArgs);           
        }
    };

    //TODO: Probar-> https://stackoverflow.com/questions/41672293/signalr-not-capturing-reconnecting-events-on-client-side
    //TODO: https://stackoverflow.com/questions/17438428/signalr-net-client-how-to-re-establish-a-connection
    //$.connection.hub.reconnecting(function () {
    //    $('#hub-info').text(getDateTime() + ': reconnecting... ');
    //});


    // Start the connection
    $.connection.hub.start().done();
}

/*******************************************************************/
//var GlobalInputDataModule = (function () {
//    var deliveryIdDefault = -1;
//    var systemIdDefault = -1;

//    var $InputSelectedSystemId = $('#SelectedSystemId');

//    return {
//        GetSystem: function () {
//            var value = $InputSelectedSystemId.val();

//            if (!$.isNumeric(value) || value === '') return -1;

//            return $InputSelectedSystemId.val();
//        },
//        SetSystem: function (value) {
//            $InputSelectedSystemId.val(value);
//        }
//    }
//})();

//GlobalInputDataModule.SetSystem('2')

//alert(GlobalInputDataModule.GetSystem());

//alert('do it');


