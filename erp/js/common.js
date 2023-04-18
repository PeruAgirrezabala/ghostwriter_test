//! jsCommons.js 
 //! version : 0.0.1
 //! authors : Julen Diaz / Sergio Rubio
 //! License : http://www.opensource.org/licenses/mit-license.php

/*
* Resumen posibles dependencias:
*	Jquery: https://jquery.com/
*	moment: https://momentjs.com/
*/

/*
 * Manuales y Ayudas:
 *  Documentacón funciones js: http://usejsdoc.org/
 */


var jsCommons = {};

jsCommons.version = '0.0.1';

jsCommons = (function(){

	"use strict";

	var LANG_THROW_PARAMETERS_NULL= 'The parameters can not be null.';

	// Create a new object, that prototypically inherits from the Error constructor
	function JsCommonsError(message) {
		this.name = 'JsCommonsError';
		this.message = message || 'JsCommonsError';
		this.stack = (new Error()).stack;
	}

	// Create a new object, that prototypically inherits from the Error constructor
	function JsCommonsValidationError(message) {
		this.name = 'JsCommonsValidationError';
		this.message = message || 'JsCommonsValidationError';
		this.stack = (new Error()).stack;
	}

	// Create a new object, that prototypically inherits from the Error constructor
	function JsCommonsRequireError(message) {
		this.name = 'JsCommonsRequireError';
		this.message = message || 'JsCommonsRequireError';
		this.stack = (new Error()).stack;
	}

	/**
	 * Almacena los patrones genéricos utilizados en las operaciones.
	 */
	var patterns = { 
		//Patrón para correo electrónico.
		mail: /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
	};

	var customErrorType = {
		JsCommonsError: JsCommonsError.name,
		JsCommonsValidationError: JsCommonsValidationError.name,
		JsCommonsRequireError: JsCommonsRequireError.name
	}

	var momment = {};

	momment = (function(){

		return {
			/**
			* Comprueba si "ahora" se encuentra dentro de un rango de fechas.
			*
			* @argument dateFromString - Fecha en texto desde.
			* @argument dateToString - Fecha en texto hasta.
			* @argument formatString - Formato de fecha para la conversión con el plugin moment.js (https://momentjs.com/).
			*
			* @returns Obtiene -1 si la fecha "ahora" es menor que la fecha desde, 0 si se encuentra dentro del rango y 1 si la fecha se encuentra fuera del rango superior a la fecha hasta.
			*
			* @requires moment (https://momentjs.com/)
			*
			* @throws Error si las fechas no son válidas o la fecha desde es mayor que la fecha hasta.
			*/
			dateIsInRange: function(dateFromString, dateToString, formatString) {
				var isAfterRes = 1;
				var isInRes = 0;
				var isBeforeRes = -1;

				try {
              		var checkmoment = moment();
            	} catch (error) {
              		throw new JsCommonsRequireError("moment.js is needed");
            	}	

				var currentDate = moment;				

				var LANG_THROW_DATE_FROM_NOT_VALID_DATE = "Date 'From' not is a valid date!!!";
				var LANG_THROW_DATE_TO_NOT_VALID_DATE = "Date 'To' not is a valid date!!!";
				var LANG_THROW_DATE_TO_MUST_GREATER_FROM = "The date 'To' must be greater than the date 'From'!!!";

				//Check dates
				var dateFrom = moment(dateFromString, formatString, true);
				var dateTo = moment(dateToString, formatString, true);

				if (!dateFrom.isValid()) {
				throw new Error(LANG_THROW_DATE_FROM_NOT_VALID_DATE);
				}

				if (!dateTo.isValid()) {
				throw new Error(LANG_THROW_DATE_TO_NOT_VALID_DATE);
				}

				if (!dateFrom.isBefore(dateTo)) {
				throw new Error(LANG_THROW_DATE_TO_MUST_GREATER_FROM);
				}

				if (currentDate.isAfter(dateTo)) {
				return isAfterRes;
				}

				if (currentDate.isBefore(dateFrom)) {
				return isBeforeRes;
				}

				return isInRes;				
			}
		};
	})();
	
	
	return {
		customErrorType: customErrorType,
		patterns: patterns,
		momment:  momment,

		//#region Tested
		/**
		 * Check if object is null or undefined.
		 * 
		 * @param {object} value to check.
		 * 
		 * @return returns true if it is null or undefined or false otherwise.
		 */
		isNullOrUndefined: function(value) {
			//Check undefined
			if(typeof value === "undefined") return true;

			//Check null
			if(value === null) return true;

			return false;
		},

		/**
		 * Check if is absolute uri.
		 * 
		 * @param {object} value to check.
		 * 
		 * @return returns true if it is absolute or false otherwise.
		 */
		isAbsoluteUri: function(value) {
			if(this.isNullOrUndefined(value)) throw new JsCommonsError(LANG_THROW_PARAMETERS_NULL);

			var re = new RegExp('^(?:[a-z]+:)?//', 'i');

			return re.test(value);
		}, 
		//#endregion
		

		//TODO: funciones sin testear

		/**
		 * Validate mail format.
		 * 
		 * @param {string} value - Text to validate.
		 */
		isMail: function(value) {
			if(this.isNullOrUndefined(value)) throw new JsCommonsError(LANG_THROW_PARAMETERS_NULL);

			var re = this.patterns.mail;

			//var re = /^(([^<>()[\]\\.,;:\s@”]+(\.[^<>()[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			
			return re.test(value);
		},

		/**
		 * Validate Spanish NIF.
		 * {@link http://www.interior.gob.es/web/servicios-al-ciudadano/dni/calculo-del-digito-de-control-del-nif-nie}
		 * 
		 * @param {string} value - Text to validate.
		 * @param {object} options - Options for function.
		 * @param {boolean} [options.throwError=false] - Throw error if not is valid.
		 * @param {string} [options.langErrorDniFormat] - Error text for invalid format.
		 * @param {string} [options.langErrorDniLetter] - Error text for invalid letter.	 
		 * 
		 * @example <caption>Example usage.</caption>	 * 
		 * 
		 * jsValidation.nif('00000000D', new { throwError: false });
		 * 
		 * @returns {boolean} If options.throwError is disabled, returns true if it is valid or false otherwise.	 
		 */
		isNif: function (value, options) {

			//Check
			if(this.isNullOrUndefined(value)) throw new Error(LANG_THROW_PARAMETERS_NULL);

			//Lang
			var LANG_THROW_LETTER_INCORRECT_DEFAULT = 'Nif erroneo, la letra del NIF no se corresponde';
			var LANG_THROW_INCORRECT_FORMAT_DEFAULT = 'Nif erroneo, formato no válido';

			//Options
			var settings = $.extend({
				// These are the defaults.
				throwError: false,
				langErrorDniLetter: LANG_THROW_LETTER_INCORRECT_DEFAULT,
				langErrorDniFormat: LANG_THROW_INCORRECT_FORMAT_DEFAULT
			}, options);

			//Options local vars		
			var throwError = settings.throwError;
			var langErrorDniLetter = settings.langErrorDniLetter;
			var langErrorDniFormat = settings.langErrorDniFormat;

			//auxiliar vars
			var numero;
			var locallet; 
			var letra;
			var expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;
			
			letra = 'TRWAGMYFPDXBNJZSQVHLCKET';

			if(expresion_regular_dni.test(value) === true){
				
				//Logic for validation
				numero = value.substr(0,dni.length-1);
				numero = numero.replace('X', 0);
				numero = numero.replace('Y', 1);
				numero = numero.replace('Z', 2);
				locallet = value.substr(value.length-1, 1);
				numero = numero % 23;			
				letra = letra.substring(numero, numero+1);
				
				//Check letter
				if (letra != locallet) {

					if (throwError) {
						throw new JsCommonsValidationError(langErrorDniLetter);
					}
					
					return false;
				}

				//Is valid
				return true;
			} else {

				if (throwError) {
					throw new JsCommonsValidationError(langErrorDniFormat);
				}

				return false;
			}
		},

		/**
		 * Modifica el título de la pestaña de la página.
		 * 
		 * @argument title - Texto con el título.
		 * 
		 * @returns undefined
		 */
		setPageTitle: function (value) {
			if (this.isNullOrUndefined(value)) throw new Error(LANG_THROW_PARAMETERS_NULL);

			document.title = title;
		},

		/**
		 * Obtiene una cadena de texto con números aleatorios.
		 * 
		 * @return Una cade na de texto con números aleatorios.
		 */
		getGuid: function () {
			return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) { var r = Math.random() * 16 | 0, v = c == 'x' ? r : r & 0x3 | 0x8; return v.toString(16); });
		},

		setGuidId: function(element) {
			if (this.isNullOrUndefined(element)) throw new Error(LANG_THROW_PARAMETERS_NULL);

			var	id = this.getGuid();

			element.id = id;

			return id;
		},
		eventCustomCreate : function(eventName) {
			if (this.isNullOrUndefined(eventName)) throw new JsCommonsError(LANG_THROW_PARAMETERS_NULL);
			
			var eventConnected; // The custom event that will be created

			if (document.createEvent) {
				eventConnected = document.createEvent("HTMLEvents");
				eventConnected.initEvent(eventName, true, true);
			} else {
				eventConnected = document.createEventObject();
				eventConnected.eventType = eventName;
			}

			eventConnected.eventName = eventName;
		},

		eventCustomAdd : function(element, eventName, callback) {
			if (this.isNullOrUndefined(element)) throw new JsCommonsError(LANG_THROW_PARAMETERS_NULL);
			if (this.isNullOrUndefined(eventName)) throw new JsCommonsError(LANG_THROW_PARAMETERS_NULL);

			// Listen for the event.
			element.addEventListener(eventName, callback, false);
		},

		eventCustomDispatch : function(eventName, args) {
			if (this.isNullOrUndefined(eventName)) throw new JsCommonsError(LANG_THROW_PARAMETERS_NULL);

			//Lanzamos el evento de conectado.
            if (document.createEvent) {				
				document.dispatchEvent(new CustomEvent(eventName, {
    				detail: { args: args }
  				}));
            } else {
				//TODO: como testear esta parte?
                document.fireEvent("on" + eventName, new CustomEvent(
                    eventName,
                    {
                      detail: { args: args }
                    }
                  ));
            } 
		},
		//TODO: RemoveEventListener : function(element, name) {},

		
	};
})();//End jsCommons

//#region JQuery extensions
(function( $ ) {
 
	/**
	 * Añade un identificador aleatorio a la propiedad ID del objeto.
	 * 
	 * @see {@link jsCommons.setGuidId}	 
	 */		
	$.fn.setGuId = function(elements) {

		return $(this).each( function() {
			// Do something to each element here.

			jsCommons.setGuidId(this);			
		}); 
	};	

	//TODO: No funcional. Probar con la misma estructura como momment, llamada tipo $(element).jsCommons.setGuidId()
	$.fn.jsCommons = function(elements){
		var localElements = function() {
			return {
				setGuidId: function() {
					return $(localElements).each(function() {
						// Do something to each element here.

						jsCommons.setGuidId(this);
					});
				}
			};
		}();

		return localElements;		
	};

/* 	//Pruebas
	$.fn.jsCommons.setGuId = function(elements) {

		return $(this).each( function() {
			// Do something to each element here.

			jsCommons.setGuidId(this);			
		}); 
	};	 */

}( jQuery ));
//#endregion



/**
 * Array Extensions:
 * - all:  Check if all the elements meet the condition.
 * 	example use: 
 * 		this.data.all(x=> x.selected == true)
 * 
 * - any: Check if any elements meet the condition.
 *  example use:
 * 		this.data.any(x=> x.selected == false)
 */
$(document).ready(function() {

    if (!Array.prototype.all) {
        
        Object.defineProperty(Array.prototype, 'all', {
        
            /**
             * Check if all the elements meet the condition.
             */
            value: function (predicate) {
                    // 1. Let O be ? ToObject(this value).
                    if (this == null) {
                        throw new TypeError('"this" is null or not defined');
                    }

                    var o = Object(this);

                    // 2. Let len be ? ToLength(? Get(O, "length")).
                    var len = o.length >>> 0;

                    // 3. If IsCallable(predicate) is false, throw a TypeError exception.
                    if (typeof predicate !== 'function') {
                        throw new TypeError('predicate must be a function');
                    }

                    // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
                    var thisArg = arguments[1];

                    // 5. Let k be 0.
                    var k = 0;

                    // 6. Repeat, while k < len
                    while (k < len) {
                        // a. Let Pk be ! ToString(k).
                        // b. Let kValue be ? Get(O, Pk).
                        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
                        // d. If testResult is false, return k.
                        var kValue = o[k];
                        
                        if (!predicate.call(thisArg, kValue, k, o)) {
                            
                            //If one is not correct, we return false.
                            return false;
                        }
                        
                        // e. Increase k by 1.
                        k++;
                    }

                    // 7. all true.
                    return true;
                },
            configurable: true,
            writable: true
        });
    }

    if (!Array.prototype.any) {
        
        Object.defineProperty(Array.prototype, 'any', {
        
            /**
             * Check if any elements meet the condition.
             */
            value: function (predicate) {
                    // 1. Let O be ? ToObject(this value).
                    if (this == null) {
                        throw new TypeError('"this" is null or not defined');
                    }

                    var o = Object(this);

                    // 2. Let len be ? ToLength(? Get(O, "length")).
                    var len = o.length >>> 0;

                    // 3. If IsCallable(predicate) is false, throw a TypeError exception.
                    if (typeof predicate !== 'function') {
                        throw new TypeError('predicate must be a function');
                    }

                    // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
                    var thisArg = arguments[1];

                    // 5. Let k be 0.
                    var k = 0;

                    // 6. Repeat, while k < len
                    while (k < len) {
                        // a. Let Pk be ! ToString(k).
                        // b. Let kValue be ? Get(O, Pk).
                        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
                        // d. If testResult is true, return k.
                        var kValue = o[k];
                        
                        if (predicate.call(thisArg, kValue, k, o)) {
                            
                            //If one is correct, we return true.
                            return true;
                        }
                        
                        // e. Increase k by 1.
                        k++;
                    }

                    // 7. all are false.
                    return false;
                },
            configurable: true,
            writable: true
        });
    }
});




/**
 * ¿This code checks for the presence of require.js, a JavaScript dependency management library.?
 */
(function() {
  if (typeof define === "function" && define.amd)
    define("jsCommons", function() {
      return jsCommons;
    });
  else if (typeof module !== "undefined" && module.exports)
    module.exports = jsCommons;
  else 
  	window.jsCommons = jsCommons;
})();