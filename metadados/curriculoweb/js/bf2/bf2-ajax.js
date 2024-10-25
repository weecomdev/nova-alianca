bf2.AjaxUtil = {
	createFileSenderFrame: function() {
		var frameDiv = document.createElement('div');		
		frameDiv.innerHTML = '<iframe style="display: none;" src="about:blank" id="bf2.sendFiles.frame" name="bf2.sendFiles.frame" onload="bf2.AjaxUtil.sendFilesFrameLoad();"></iframe>';
		document.body.appendChild(frameDiv);
		
		var frame = document.getElementById('bf2.sendFiles.frame');
		frame.originalSrc = bf2.baseUrl +'/jsp/frw/bf2-ajax-sendFiles.html';
		
		frame.loadOriginalSrc = bf2.Util.bindFunction(frame, 
			function() {
				this.src = this.originalSrc;
			}
		);
		
		frame.getDocument = bf2.Util.bindFunction(frame,
			function() {
				var frame = document.getElementById('bf2.sendFiles.frame');
				try {
					if (frame.contentDocument) {
						return frame.contentDocument; 
		  			}
		  		} catch (e1) {
	  				try {
						if (frame.contentWindow) {
							return frame.contentWindow.document;
		  				}
		  			} catch (e2) { 
						try {
							if (frame.document) {
								return frame.document;
							}
						} catch (e4) {
							if (frame.documentElement) {
								return frame.documentElement;
							}	 					
						}
					}
				}
				throw {message: 'N�o foi poss�vel retornar o documento do iframe'};
			}
		);

		frame.loadOriginalSrc();

		return frame;
	},
	
	sendFilesFrameLoad: function() {
		var frame = document.getElementById('bf2.sendFiles.frame');
		
		frame.domain = document.domain;
		if (!frame.isLoading)
			return;
		frame.isLoading = false;
		
		//frame.bf2Ajax.doCallback("");
		//frame.bf2Ajax = null;
		var frameDocument = frame.getDocument().documentElement;

		if (frameDocument != null) {
			var response = frameDocument.textContent || frameDocument.innerText;
			frame.loadOriginalSrc();
			
			var error = !isEmpty(response) ? true : false;
			frame.bf2Ajax.doCallback(error ? '{message: \"' +response +'\"}' : '', error);
			frame.bf2Ajax = null;
		}
	}
}

//bf2.Util.attachEventToObject(window, 'load', bf2.AjaxUtil.createFileSenderFrame);

/*
 * Data de cria��o: 08/01/2008
 * 
 * Requer o bf2.js. (Esse script � importado automaticamente pelo bf2.Importer)
 */

/**
 * Objeto respons�vel por realizar requisi��es.
 * Oferece fun��es para requisi��es por "GET" e "POST"; possui
 * tamb�m funcionalidades para post de formul�rios.
 * As requisi��es podem ser feitas de modo s�ncrono ou ass�ncrono.
 * 
 * @params JSON: {showWait}
 */
bf2.Ajax = function(generalParams) {

	this.generalParams = generalParams ? generalParams : {};
	this.generalParams.showWait = this.generalParams.showWait != undefined ? this.generalParams.showWait : true;
	this.waitMessage = null;
	if (this.generalParams.showWait) {
   	this.waitMessage = document.createElement('div');
		this.waitMessage.className = 'waitMessage';
		this.waitMessage.innerHTML = '<div class="waitText">Carregando...</div>';
   } 

	var asyncCallback; // nome da fun��o de callback no caso de requisi��o ass�ncrona
	var requester; // inst�ncia do objeto respons�vel pelas requisi��es

	try {
		if (window.XMLHttpRequest) {
			requester = new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			try {
				requester = new ActiveXObject('Msxml2.XMLHTTP');
			} catch (e2) {
				requester = new ActiveXObject('Microsoft.XMLHTTP');
			}
		}
	} catch (e1) {
		alert('N�o foi poss�vel criar objeto Ajax.\nCausa: ' +e1.message);
	}
	
	this.getRequester = function() {
		return requester;
	}
	
	this.getAsyncCallback = function() {
		return asyncCallback;
	}
	
	this.setAsyncCallback = function(callback) {
		asyncCallback = callback;
	}

	/**
	 * Confira o objeto de requisi��o para uma nova requisi��o.
	 *
	 * @return Retorna true caso seja ass�ncrona ou false caso seja s�ncrona.
	 */
	this.configure = function(method, url, params, callback) {
		var currentAsync = callback != undefined;
		asyncCallback = callback;

		if (params != null) {
			if (url.indexOf('?') > -1)
				url += '&' +params;
			else url += '?' +params;
		}
		requester.open(method, url, currentAsync);
		
		if (currentAsync)
			requester.onreadystatechange = bf2.Util.bindFunction(this, this.onStateChange);

		requester.setRequestHeader("Cache-Control", 
			"no-store, no-cache, must-revalidate");
		requester.setRequestHeader("Cache-Control", 
			"post-check=0, pre-check=0");
		requester.setRequestHeader("Pragma", "no-cache");
		requester.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");

		return currentAsync;
	}

	this.createParamsURL = function(params) {
		if (params == null || params == undefined || params.length == 0)
			return null;
		var str = '';
		for (var i=0; i < params.length; i++) {
			var param = params[i];
			str += param.substring(0, param.indexOf('=') +1) +encodeURIComponent(param.substring(param.indexOf('=') +1));
			if (i < params.length -1)
				str += "&";
		}
		return str;
	}

	/**
	 * Realiza o requisi��o via GET.
	 * 
	 * @param params Array de par�metros para a requisi��o
	 * @param callback Nome da fun��o de callback. Se informada far� requisi��o ass�ncrona, caso contr�rio ser� s�ncrona.
	 */
	this.get = function(url, params, callback) {
		this.showWait();

		params = this.createParamsURL(params);
		var async = this.configure("GET", url, params, callback);

		requester.send(null);

		if (!async) {
			this.lastResponseCode = requester.status;
			this.hideWait();
	  		return this.constructReturn(requester);
	  	}
	}

	/**
	 * Realiza o requisi��o via POST.
	 * 
	 * @param params Array de par�metros para a requisi��o
	 * @param callback Nome da fun��o de callback. Se informada far� requisi��o ass�ncrona, caso contr�rio ser� s�ncrona.
	 */
	this.post = function(url, params, callback) {
		this.showWait();
		
		params = this.createParamsURL(params);
		var async = this.configure("POST", url, null, callback);

		requester.send(params);

		if (!async) {
			this.lastResponseCode = requester.status;
			this.hideWait();
	  		return this.constructReturn(requester);
	  	}
	}

	/**
	 * Realiza o "submit" do formul�rio requisi��o via POST.
	 * 
	 * @param callback Nome da fun��o de callback. Se informada far� requisi��o ass�ncrona, caso contr�rio ser� s�ncrona.
	 */
	this.postForm = function(form, callback) {
		this.showWait();
		return new bf2.FormSender(this).postForm(form, callback);
	}
	
	this.constructReturn = function(requester, responseText) {
		if (requester.status == 401) // unauthorized
			document.location.href = 'action/login/login';
		else {
			if (requester.status == 500)
				throw {message: (responseText ? responseText : requester.responseText)};
			return (responseText ? responseText : requester.responseText);
		}
	}

	this.onStateChange = function() {
		var requester = this.getRequester();
		var state = requester.readyState;
		if (state == 4 && requester.status == 200) // 4 == DONE
			this.doCallback(requester.responseText);
		else if (state == 4 && requester.status == 500) {
			this.doCallback(requester.responseText, true); // true indica que � uma exce��o
		} if (state == 4 && requester.status == 401) // unauthorized
			document.location.href = 'action/login/login';
	}
	
	this.showWait = function() {
		if (this.generalParams.showWait) {
			document.body.appendChild(this.waitMessage);
			this.waitMessage.style.display = '';
			this.waitMessage.style.visibility = 'visible';
		}
	}

	this.hideWait = function() {
		if (this.generalParams.showWait)
			document.body.removeChild(this.waitMessage);
	}
	
	this.doCallback = function(responseText, isError) {
		var retorno = this.constructReturn(this.getRequester(), responseText);
		var cb = this.getAsyncCallback();
		if (typeof cb == 'function')
			cb(retorno, isError);
		else eval(cb +'(retorno, ' +isError +')');
		this.hideWait();
	}
}

/**
 * Extende o objeto ajax e transforma o retorno das requisi��es
 * para JSON.
 * 
 * @params JSON: {showWait}
 */
bf2.JSONAjax = function(generalParams) {
	this.extendsFrom = bf2.Ajax;
	this.extendsFrom(generalParams);

	this.constructReturn = function(requester, responseText) {
		if (requester.status == 401) {// unauthorized
			document.location.href = 'action/login/login';
		} else {
			if (requester.status == 500)
				throw {message: (responseText ? responseText : requester.responseText)};
			return eval('(' +(responseText ? responseText : requester.responseText) +')');
		}
	}
}

bf2.FormSender = function(bf2Ajax) {
	
	this.bf2Ajax = bf2Ajax;
	
	/**
	 * L� os campos de entrada do formul�rio e os retorna em um array.
	 */
	this.readParams = function(form) {
		return bf2.Util.getFormElements(form);
	}
	
	this.isUploadForm = function(form) {
		for (var i=0; i < form.elements.length; i++) {
			var element = form.elements[i];
			if (element.type == 'file')
				return true;
		}
		return false;
	}
	
	/**
	 * Realiza o "submit" do formul�rio requisi��o via POST.
	 * 
	 * @param callback Nome da fun��o de callback. Se informada far� requisi��o ass�ncrona, caso contr�rio ser� s�ncrona.
	 */
	this.postForm = function(form, callback) {
		var retorno = null;
		var enctype = form.enctype;
		//if ('multipart/form-data' == enctype)
		if (this.isUploadForm(form))
			retorno = this.postByFrame(form, callback);
		else retorno = this.postByAjax(form, callback);
		
		this.bf2Ajax = null;
		
		return retorno;
	}
	
	this.postByAjax = function(form, callback) {
		var params = this.readParams(form);
		var url = form.action;
		
		return this.bf2Ajax.post(url, params, callback);
	}
	
	this.postByFrame = function(form, callback) {
		if (!callback)
			throw {message: '� necess�rio informar a fun��o de retorno para formul�rios com upload de arquivos!'};
			
		var frame = document.getElementById('bf2.sendFiles.frame');
					
		if (frame.isLoading)
			throw {message: 'Aguarde o final do envio dos arquivos!'};
			
		this.bf2Ajax.showWait();

		var submitForm = form;
		submitForm.target = frame.name;
		
		this.bf2Ajax.setAsyncCallback(callback);
			
		frame.isLoading = true;
		frame.bf2Ajax = this.bf2Ajax;
		
		submitForm.submit();
	}
}