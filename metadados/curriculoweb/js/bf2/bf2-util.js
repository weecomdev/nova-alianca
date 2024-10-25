/*
 * Data de criação: 08/02/2008
 * 
 * Requer o bf2.js. (Esse script é importado automaticamente pelo bf2.Importer)
 */

// Define o objeto Util
if (!bf2.Util) {
	bf2.Util = {
		
		KEY_ESCAPE: 27,
		KEY_ENTER: 13,
		KEY_TAB: 9,
		KEY_BACKSPACE: 8,
		
		getBrowserScrollHeight: function() {
			var height = bf2.Util.getBrowserHeight();
			var scrollHeight = document.body.scrollHeight;
			return height > scrollHeight ? height : scrollHeight;
		},
		
		getBrowserScrollWidth: function() {
			var width = bf2.Util.getBrowserWidth();
			var scrollWidth = document.body.scrollWidth;
			return width > scrollWidth ? width : scrollWidth;
		},
		
		getBrowserHeight: function() {
			return document.body.clientHeight;
		},
		
		getBrowserWidth: function() {
			return document.body.clientWidth;
		},
		
		getBrowserSize: function() {
			return {
				width: bf2.Util.getBrowserWidth(), 
				height: bf2.Util.getBrowserHeight()
			}
		},
		
		attachEventToObject: function(object, event, func) {
			if (bf2.Browser.IE)	
				object.attachEvent('on' +event, func);
			else object.addEventListener(event, func, true);
		},
		
		getEvent: function(evt) {
			if (!evt) 
				evt = window.event;
			return evt;
		},
		
		getTargetOnEvent: function(evt) {
			evt = bf2.Util.getEvent(evt);
			return evt.target ? evt.target : evt.srcElement;
		},
		
		getKeyFromEvent: function(evt) {
			evt = bf2.Util.getEvent(evt);
			if (bf2.Browser.IE)
				return evt.keyCode;
			else return evt.which == 0 && evt.keyCode > 0 ? evt.keyCode : evt.which;
		},
		
		bindFunction: function(object, method, args) {
			if (!args)
				args = [];
			return function() {
				return method.apply(object, args);
			}
		},
		
		evalScripts: function(element) {
			if (typeof element == 'string')
				element = document.getElementById(element);
			if (element == null)
				return;
			var scripts = element.getElementsByTagName('script');
			for (var i=0; i < scripts.length; i++) {
				var script = scripts[i];
				eval(script.text);
			}
		},
		
		element: function(id) {
			if (id.indexOf('.') > -1)
				id = id.replace('.', '\\.');
			var elem = jQuery('#' +id);
			if (elem.length > 0)
				return elem.get(0);
			return null;
		},
		
		isArray: function(obj) {
			return obj && obj.length && !obj.charAt;
		},
		
		isEmpty: function(str) {
			return !obj || obj == '' || obj.trim().length() == 0;
		},
		
		random: function(max) {
			if (!max)
				max = 1000000;
			return Math.floor(Math.random() *max);
		},
		
		transformDateTime: function(value, typeDate, typeTransform) {
			var mYear = "";
			var mMonth = "";
			var mDay = "";
			var mHour = "";
			var mMinute = "";
			var mSecond = "";
			
			var retorno = "";
			
			var vDateName = value;

			if (typeDate == "dd/mm/yyyy H:i:s"){
				mDay = vDateName.substr(0,2)
				mMonth = vDateName.substr(3,2);
				mYear = vDateName.substr(6,4);
				mHour = vDateName.substr(11,2)
				mMinute = vDateName.substr(14,2);
				mSecond = vDateName.substr(17,2);
			}
			
			if (typeDate == "dd/mm/yyyy"){
				mDay = vDateName.substr(0,2)
				mMonth = vDateName.substr(3,2);
				mYear = vDateName.substr(6,4);
			}
			
			if (typeTransform == "yyyy-mm-dd H:i:s"){
				retorno = mYear+"-"+mMonth+"-"+mDay + " " + mHour + ":" + mMinute + ":" + mSecond;
			}
			
			if (typeTransform == "yyyy-mm-dd"){
				retorno = mYear+"-"+mMonth+"-"+mDay;
			}
				
			return retorno ;
		},
		
		/**
		 * Lê os campos de entrada do formulário e os retorna em um array (formato: nomeInput=valorInput).
	 	 */
		getFormElements: function(form) {
			var params = new Array();
			var elements = form.elements;
			for (var i=0; i < elements.length; i++) {
				var element = elements[i];
	
				if (element.type == 'checkbox' && !element.checked)
					continue;
				if (element.type == 'radio' && !element.checked)
					continue;
				
				if (element.type != 'select-multiple') {
					if (!element.isEditor)
						params[params.length] = element.name +"=" +element.value;
					else params[params.length] = element.name +"=" +tinyMCE.get(element.name).getContent();
				} else if (element.type == 'select-multiple') {
					if (element.options.length > 0) {				
						for (var k=0; k < element.options.length; k++) {
							op = element.options[k];
							if (op.selected)
								params[params.length] = element.name +"=" +op.value;
						}
					}
				}
			}
			return params;
		},
		
		isDate: function(dateStr) {
			try {
				if (dateStr == null || dateStr.trim().length == 0)
					return false;
			} catch (e) {
				return false;
			}

			var datePat = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
			var matchArray = dateStr.match(datePat);
			
			if (matchArray == null)
				return false;
			
			var day = matchArray[1];
			var month = matchArray[3];
			var year = matchArray[5];
			
			if (day < 1 || day > 31)
				return false;
					
			if (month < 1 || month > 12)
				return false;
			
			if ((month == 4 || month == 6 || month == 9 || month == 11) && day == 31)
				return false;
			
			if (month == 2) {
				var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
				if (day > 29 || (day==29 && !isleap))
					return false;
			}

			return true;
		}
	}
}