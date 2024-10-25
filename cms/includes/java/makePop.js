var arrow = 25;
var popDiv;
var popIframe;


function showPop(quem) {
	
	var popX = quem.clientX;
	var popY = quem.clientY;
	
	popDiv.style.display = "block"
	popDiv.style.top = document.body.scrollTop + popY - (popDiv.offsetHeight/2) - (arrow/2);
	popDiv.style.left = (popX - popDiv.offsetWidth) - arrow;
	
}

function hidePop() {

	popDiv.style.display = "none";
	if (document.getElementById("iframePop").contentWindow) { document.getElementById("iframePop").contentWindow.location.href = "about:blank"; }

}

function sizePop(wPop, hPop) {
	
	popDiv = document.getElementById("divPop");
	popIframe = document.getElementById("iframePop");
	popClose = popDiv.getElementsByTagName("div")[0]
	
	var oldH = popDiv.offsetHeight;
	
	popIframe.style.height = hPop;
	popDiv.style.height = hPop;
	popDiv.style.top = ((oldH - hPop)/2) + popDiv.offsetTop;

	var oldW = popDiv.offsetWidth;
	
	popIframe.style.width = wPop;
	popDiv.style.left = ((oldW - wPop) + popDiv.offsetLeft) - arrow;
	
	popClose.style.left = (popIframe.offsetLeft + popIframe.offsetWidth) - popClose.offsetWidth;
	popClose.style.visibility = "visible";

}

//==============================================================================================

function createPop() {

var insertPop = '' +
'<div onClick="hidePop();" title="fechar"></div>' +
'<iframe src="about:blank" name="msgPop" id="iframePop" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0"></iframe>'

var addPop = document.body;

novoPop = document.createElement('div'); 
novoPop.setAttribute('id', 'divPop'); 

addPop.appendChild(novoPop);

popDiv = document.getElementById("divPop");
popIframe = document.getElementById("iframePop");

popDiv.innerHTML = insertPop;
}

//==============================================================================================
//COMANDO ONLOAD

function addEvent(obj, evType, fn){ 
 if (obj.addEventListener)	{ obj.addEventListener(evType, fn, false); return true; }
 else if (obj.attachEvent)	{ var r = obj.attachEvent("on"+evType, fn); return r; }
 else { return false; } 
}
addEvent(window, 'load', createPop);