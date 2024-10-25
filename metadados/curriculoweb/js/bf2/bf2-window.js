/*
 * Data de criação: 08/01/2008
 * 
 * Requer o bf2.js. (Esse script é importado automaticamente pelo bf2.Importer)
 */

// Define o objeto WindowUtil
if (!bf2.WindowUtil) {
	bf2.WindowUtil = {
		getWindowFromEvent: function(evt) {
			var src = bf2.Util.getTargetOnEvent(evt);
			src = src ? src : evt;
			
			var win = src;
			while (win) {
				if (win._window) {
					win = win._window;
					break;
				}
				win = win.parentNode;
			}
			
			return win;
		},
	
		closeWindow: function(evt) {
			var win = bf2.WindowUtil.getWindowFromEvent(evt);

			win.close();
		},
		
		addDropableWindow: function(win){
			var key = 'key_' +win.identifier;
			bf2.WindowUtil.dropableWindows[key] = win;
			return key;
		},
		
		destroyWindow: function(key) {
			var win = bf2.WindowUtil.dropableWindows[key];
			bf2.WindowUtil.dropableWindows[key] = null;
			document.body.removeChild(win.windowPanel);
			
			var maxZIndex = document.maxZIndex;
			maxZIndex--;
			document.maxZIndex = maxZIndex;
		},
		
		toTop: function(div) {
			var maxZIndex = document.maxZIndex;
			if (maxZIndex == undefined)
				maxZIndex = 100;
			maxZIndex++;
			document.maxZIndex = maxZIndex;
			div.style.zIndex = maxZIndex;
		},
		
		hideSelects: function(parent) {
			var selects = parent.getElementsByTagName('select');
			if (selects) {
				for (var i=0; i < selects.length; i++) {
					var select = selects[i];
					var wasVisible = select.style.display != 'none' && select.style.vsibility != 'hidden'; 
					if (wasVisible) {
						select.wasVisible = true;
			   		select.style.visibility = 'hidden';
			   	}
				}
			}
		},
		
		showSelects: function(parent) {
			var selects = parent.getElementsByTagName('select');
			if (selects) {
				for (var i=0; i < selects.length; i++) {
					var select = selects[i];
					if (select.wasVisible)
						select.style.visibility = '';
					select.wasVisible = null;
				}
			}
		},
		
		resizeModalBlockPanels: function() {
			var cssClass = 'div.dialogBlockPanel'.toLowerCase();
			var ruleAttr = '';
			if (bf2.Browser.IE)
				ruleAttr = 'rules';
			else ruleAttr = 'cssRules';
			
			var changed = false;
			for (var i=0; i < document.styleSheets.length; i++) {
				var styles = document.styleSheets[i][ruleAttr];
				for (var k=0; k < styles.length; k++) {
					var style = styles[k];
					if (style.selectorText != null && cssClass == style.selectorText.toLowerCase()) {
						style.style['width'] = bf2.Util.getBrowserScrollWidth() + 'px';
						style.style['height'] = bf2.Util.getBrowserScrollHeight() + 'px';

						changed = true;
						break;
					}
				}
				if (changed)
					break;
			}		
		},
		
		closeOnEscListener: function(evt) {
			var key = bf2.Util.getKeyFromEvent(evt);
			if (key == bf2.Util.KEY_ESCAPE)
				bf2.WindowUtil.closeWindow(evt);
		},
		
		dropableWindows: new Array(),
		visibleWindowsStack: new Array()
	}

	bf2.Util.attachEventToObject(window, 'resize', bf2.WindowUtil.resizeModalBlockPanels); 
	
}

bf2.DefaultWindowListener = function() {
	
	this.onShow = function(win) {
		try {
			bf2.Calendar.closeCalendar();
		} catch (e) {}
	}
	this.onClose = function(win) {}
	
	this.onActivate = function(win) {
		if (win.isClosed)
			return;
			
		bf2.WindowUtil.toTop(win.windowPanel);
		
		var stack = bf2.WindowUtil.visibleWindowsStack;
		this.removeWindowFromStack(win, stack);

		var lastWindow = stack[stack.length -1]; // remove e retorna a próxima janela visível
		if (lastWindow != null)
			bf2.WindowUtil.hideSelects(lastWindow.windowPanel);

		stack.push(win);
		bf2.WindowUtil.showSelects(win.windowPanel);
	}
	
	this.onDeactivate = function(win) {
		var stack = bf2.WindowUtil.visibleWindowsStack;
		this.removeWindowFromStack(win, stack);
		
		var lastWindow = stack.pop(); // remove e retorna a próxima janela visível
		if (lastWindow != null)
			lastWindow.activate();
			
		try {
			bf2.Calendar.closeCalendar();
		} catch (e) {}
	}
	
	this.removeWindowFromStack = function(win, stack) {
		for (var i=stack.length -1; i >= 0; i--) {
			if (stack[i] == win)
				stack.splice(i, 1);
		}
	}
}

/**
 *
 * @params JSON: {width, height, title, left, top, titleHeight, closeOnEsc}
 * @parentWindow Janela pai, se tiver
 */ 
bf2.Window = function(params, parentWindow) {

	this.params = params ? params : {};
	this.windowPanel = document.createElement('div');
	this.windowTitle = document.createElement('div');
	this.windowContent = document.createElement('div');
	this.identifier = ((Math.random() *Math.random()) %Math.random()) +Math.random();
	this.isClosed = false;
	this.listeners = new Array(); // lista de listeners registrados para a window. os eventos notificados são onShow, onClose onActivate e onDeactivate.
	this.parentWindow = parentWindow;
	
	this.configure = function(params) {
		this.windowPanel.style.display = 'none';
		
		//params.width = params.width ? params.width : 150;
		//params.height = params.height ? params.height : 100;
		//params.left = params.left ? params.left : 0;
		//params.top = params.top ? params.top : 0;
		params.title = params.title ? params.title : '';
		params.titleHeight = params.titleHeight ? params.titleHeight : 24;
		params.closeOnEsc = params.closeOnEsc != undefined ? params.closeOnEsc : true;
		
		this.windowPanel.appendChild(this.windowTitle);
		this.windowPanel.appendChild(this.windowContent);

		this.configureWindowPanel(params);
		this.configureWindowTitle(params);
		this.configureWindowContent(params);
		
		document.body.appendChild(this.windowPanel);
	}
	
	this.configureWindowPanel = function(params) {
		this.windowPanel.className = 'windowPanel';
		
		if (params.width)
			this.windowPanel.style.width = params.width +'px';
		if (params.height)
			this.windowPanel.style.height = params.height +'px';
		if (params.left)
			this.windowPanel.style.left = params.left +'px';
		if (params.top)
			this.windowPanel.style.top = params.top +'px';
			
		this.windowPanel.onclick = 
			function(evt) {
				var src = bf2.Util.getTargetOnEvent(evt);
				if (src.type && src.type == 'button')
					return;
				this._window.activate(); 
			};
		
		this.windowPanel._window = this;
		
		if (params.closeOnEsc)
			bf2.Util.attachEventToObject(this.windowPanel, 'keypress', 
					bf2.WindowUtil.closeOnEscListener);
	}
	
	this.configureWindowTitle = function(params) {
		this.windowTitle.className = 'windowTitle';
		
		bf2.Util.attachEventToObject(this.windowTitle, 'click', bf2.WindowUtil.resizeModalBlockPanels);
		
		var divClose = document.createElement('div');
		divClose.className = 'closeButton';
		divClose.onclick = bf2.WindowUtil.closeWindow;
		divClose._window = this;
		this.windowTitle.appendChild(divClose);
		
		var spanTitle = document.createElement('span');
		spanTitle.className = 'titleText';
		this.windowTitle.appendChild(spanTitle);
		this.windowTitle.setTitle = function(title) {
			spanTitle.innerHTML = title;
		}
		
		//spanTitle.innerHTML = params.title;
		this.setTitle(params.title);
		this.windowTitle.style.height = params.titleHeight +'px';
	}
	
	this.setTitle = function(title) {
		this.params.title = title;
		this.windowTitle.setTitle(params.title);
	}
	
	this.getParentWindow = function() {
		return this.parentWindow;
	}
	
	this.centralize = function() {
		var windowSize = bf2.Util.getBrowserSize();
		var panelHeight = this.windowPanel.clientHeight;
		var panelWidth = this.windowPanel.clientWidth;
		if (!this.params.left) {
			var left = (windowSize.width /2) -(panelWidth /2);
			left = left >= 0 ? left : 0;
			this.windowPanel.style.left = left +'px';
		}
		if (!this.params.top) {
			var top = (windowSize.height /2) -(panelHeight /2);
			top = top >= 0 ? top : 0;
			this.windowPanel.style.top = top +'px';
		}
	}
	
	this.blockSize = function() {
		var defaultMaxWidth = 650;
		var defaultMaxHeight = 450;
		
		var height = this.params.height;
		if (!height)
			height = defaultMaxHeight;
		var width = this.params.width;
		if (!width)
			width = defaultMaxWidth;

		var titleHeight = this.params.titleHeight;
		this.windowContent.style.height = height -titleHeight +'px';
		this.windowContent.style.width = width +'px';
		
		this.windowPanel.style.height = height +'px';
		this.windowPanel.style.width = width +'px';
		
		var size = bf2.Util.getBrowserSize();
		bf2.DragAndDrop.configure(this.windowTitle, this.windowPanel, 0, size.width -width -3, 0, size.height -height -3);
	}
	
	this.configureWindowContent = function(params) {
		this.windowContent.className = 'windowContent';
		
		if (params.height) {
			var contentHeight = params.height -params.titleHeight;
			this.windowContent.style.height = contentHeight +'px';
		}
	}
	
	this.show = function() {
		this.fireOnShow();
		this.activate();

		this.windowPanel.style.display = '';		

		this.blockSize();
		if (!this.params.left || !this.params.top)
			this.centralize();
		this.focusOnFirstField();
	}

	this.close = function() {
		this.isClosed = true;

		this.deactivate();
		this.fireOnClose();
		
		this.windowPanel.style.display = 'none';

		var key = bf2.WindowUtil.addDropableWindow(this);
		bf2.WindowUtil.destroyWindow(key);
	}
	
	this.getContentPanelInnerHTML = function() {
		return this.windowContent.innerHTML;
	}
	
	this.setContentPanelInnerHTML = function(_innerHTML) {
		this.windowContent.innerHTML = _innerHTML;
		var scripts = this.windowContent.getElementsByTagName('script');
		for (var i=0; i < scripts.length; i++) {
			var script = scripts[i];
			eval(script.text);
		}
	}
	
	this.getElementsByTagName = function(tagName) {
		return this.windowPanel.getElementsByTagName(tagName);
	}
	
	this.addWindowListener = function(listener) {
		this.listeners.push(listener);
	}
	
	this.activate = function() {
		this.fireOnActivate();
	}
	
	this.deactivate = function() {
		this.fireOnDeactivate();
	}
	
	this.fireOnShow = function() {
		this.fireEvent('onShow');
	}
	
	this.fireOnClose = function() {
		this.fireEvent('onClose');
	}
	
	this.fireOnActivate = function() {
		this.fireEvent('onActivate');
	}
	
	this.fireOnDeactivate = function() {
		this.fireEvent('onDeactivate');
	}
	
	this.fireEvent = function(eventName) {
		for (var i=0; i < this.listeners.length; i++) {
			var listener = this.listeners[i];
			var event = eval('listener.' +eventName);
			if (event)
				event.apply(listener, [this]);
		}
	}
	
	this.getFirstField = function(element) {
		if (!element)
			element = this.windowPanel;
		
		var field = null;
		var childs = element.childNodes;
		if (childs) {
			for (var i=0; i < childs.length; i++) {
				var child = childs[i];
				if (child.type)
					field = child;
				else field = this.getFirstField(child);
				if (field)
					break;
			}
		}
		return field;
	}
	
	this.focusOnFirstField = function() {
		var field = this.getFirstField();
		if (field && field.type != "hidden")
			field.focus();
	}
	
	this.configure(params);
	this.addWindowListener(new bf2.DefaultWindowListener());
}

/**
 *
 * @params JSON: {width, height, title, left, top, titleHeight, closeOnEsc}
 * @parentWindow
 */ 
bf2.Dialog = function(params, parentWindow) {
	
	// INICIO - aqui é configurado o painel que dá o efeito de janela modal
	// o efeito é simples: uma div transparente utilizando 100% do espaço
	// da janela é colocada um nível acima da div da janela.
	this.blockPanel = document.createElement('div');
	
	this.blockPanel.className = 'dialogBlockPanel';
	
	document.body.appendChild(this.blockPanel);
	
	bf2.WindowUtil.toTop(this.blockPanel);

	// Aqui é feita a herança da Window
	// somente é necessário redefinir os métodos close e show
	this.extendsFrom = bf2.Window;
	this.extendsFrom(params, parentWindow);
	
	this.superClose = this.close;
	this.superShow = this.show;

	this.close = function() {
		this.superClose();
		this.blockPanel.parentNode.removeChild(this.blockPanel);
	}
	
	this.show = function() {
		this.superShow();
		bf2.WindowUtil.resizeModalBlockPanels();
	}
}