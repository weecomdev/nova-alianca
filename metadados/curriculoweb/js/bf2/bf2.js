function imposeMaxLength(Object, MaxLen){
    var retorno = (Object.value.length <= MaxLen);
	if(!retorno){
		Object.value = Object.value.substring(0,MaxLen);
	}
    return retorno;
}
var bf2 = {
	Browser: {
		IE:     !!(window.attachEvent && !window.opera),
		Opera:  !!window.opera,
		WebKit: navigator.userAgent.indexOf('AppleWebKit/') > -1,
		Gecko:  navigator.userAgent.indexOf('Gecko') > -1 && navigator.userAgent.indexOf('KHTML') == -1,
		MobileSafari: !!navigator.userAgent.match(/Apple.*Mobile.*Safari/),
		Firefox: !!navigator.userAgent.match(/.*Firefox.*/)
	},
	
	baseUrl: null,
	
	Importer: function() {
		
		this.addScript = function(src) {
			document.write('<script type="text/javascript" src="'+src +'.js"><\/script>');
		}
		
		this.addStyle = function(src) {
			document.write('<link rel="stylesheet" href="' +src +'.css"></link>');
		}
		
		var defaultStyles = 
			['\/style\/bf2-ajax'];
		for (var i=0; i < defaultStyles.length; i++)
			this.addStyle(bf2.baseUrl +defaultStyles[i]);
			
		var defaultScripts = 
			['js\/bf2\/bf2-util', 'js\/bf2\/bf2-ajax'];
		for (var i=0; i < defaultScripts.length; i++)
			this.addScript(bf2.baseUrl +defaultScripts[i]);
	}
}

var scripts = document.getElementsByTagName('script');
for (var i = 0; i < scripts.length; i++) {
	var script = scripts[i];	
	if (script.src && script.src.indexOf('js/bf2/bf2.js') > -1) {
		var src = script.src;
		bf2.baseUrl = src.substring(0, src.indexOf('js/bf2/bf2.js'));
		break;
	}	
}
if (bf2.baseUrl == null || bf2.baseUrl.length == 0) {
	var bases = document.getElementsByTagName('base');
	if (bases.length > 0)
		bf2.baseUrl = bases[0].href;
}

var _importer = new bf2.Importer();