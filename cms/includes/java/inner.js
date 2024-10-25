//=====================================================================================================
// CHECAGEM DE ACESSO

function checkFrame() {
	
	if (top.document == document) { top.window.location = "../default.asp" }
	
}

//=====================================================================================================
// DIMENCIONAR IFRAME

function sizeLoad() {

	var sizeFrame;
	var sizeFinal = (navigator.appName.search("Microsoft") == -1) ? document.body.offsetHeight : document.body.scrollHeight ;
	
	var sizeEdit = parent.document.getElementById("editFrame");
	var sizeAdd = parent.document.getElementById("addFrame");

	(sizeEdit) ? sizeFrame = sizeEdit : sizeFrame = sizeAdd;
	
	var checksize = sizeFrame.offsetHeight;
	
	if (checksize == 0) {
		for(var i = checksize; i <= sizeFinal; i++) { setTimeout((function(i) { return function() { sizeFrame.style.height = i; } })(i), i * 5) }
	}
	else {
		sizeFrame.style.height = sizeFinal;
	}
}

//=====================================================================================================
// INNER POP UP

var popDiv;
var popBack;
var popIframe;

function showPop(quem) {
	
	popBack.style.display = "block"
	popDiv.style.display = "block"
	
	var popTop = (navigator.appName.search("Microsoft") == -1) ? 
	(document.body.offsetHeight - popDiv.offsetHeight)/2 : 
	(document.body.scrollHeight - popDiv.offsetHeight)/2 ;
	
	popDiv.style.top = popTop;
	
}

function hidePop() {

	popBack.style.display = "none"
	popDiv.style.display = "none";
	
	if (document.getElementById("innerFrame").contentWindow) { document.getElementById("innerFrame").contentWindow.location.href = "about:blank"; }

}

function sizePop(wPop, hPop) {
	
	popDiv = document.getElementById("innerPop");
	popIframe = document.getElementById("innerFrame");
	popClose = popDiv.getElementsByTagName("div")[0]
	
	popIframe.style.height = hPop;
	popIframe.style.width = wPop;
	
	var popTop = (document.body.offsetHeight - popDiv.offsetHeight)/2
	
	popDiv.style.top = popTop;

	popClose.style.left = (popIframe.offsetLeft + popIframe.offsetWidth) - popClose.offsetWidth;
	popClose.style.visibility = "visible";

}


function createPop() {

	var insertPop = '' +
	'<div onClick="hidePop();" title="fechar"></div>' +
	'<iframe src="about:blank" name="innerFrame" id="innerFrame" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0"></iframe>'
	
	var addPop = document.body;
	
	novoBack = document.createElement('div'); 
	novoBack.setAttribute('id', 'backPop'); 
	
	novoPop = document.createElement('div'); 
	novoPop.setAttribute('id', 'innerPop'); 
	
	addPop.appendChild(novoBack);
	addPop.appendChild(novoPop);
	
	popDiv = document.getElementById("innerPop");
	popBack = document.getElementById("backPop");
	popIframe = document.getElementById("innerFrame");
	
	popDiv.innerHTML = insertPop;
}

//=====================================================================================================
// EDITAR FOTOS

function fotoDel() {

	hidePop();
	var checkFoto = document.getElementById("fotoCel");
	if (checkFoto) {
		fotoChange();
		checkFoto.removeChild(checkFoto.getElementsByTagName("div")[0]);
		sizeLoad();
	}

}

function fotoChange() { 
	
	var fotoOnde = document.getElementById("fotoCel");
	var fotoCheck = fotoOnde.getElementsByTagName("input")[0]

	if (!fotoCheck) {
		novo = document.createElement('input'); 
		novo.setAttribute('type', 'file'); 
		novo.setAttribute('name', 'arquivo');
		novo.setAttribute('className', 'inputEditar');
		novo.setAttribute('size', '58'); 
	
		fotoOnde.appendChild(novo);
	}
	else {
		fotoOnde.removeChild(fotoOnde.lastChild);
	}

	sizeLoad();
	
}

//================================================================================================================
// ADICIONAR OU REMOVER CAMPOS DE ARQUIVO

function fileAdd(quantos, onde) { 

	var fileOnde = (onde) ? eval('document.getElementById("' + onde + '")') : document.getElementById("fileCel");

	for(var i=0; i < quantos; i++) { 
	
		quebra = document.createElement("br")
	
		novo = document.createElement('input'); 
		novo.setAttribute('type', 'file'); 
		novo.setAttribute('name', 'arquivo[]');
		novo.setAttribute('className', 'inputEditar');
		novo.setAttribute('size', '58'); 
		
		fileOnde.appendChild(quebra);
		fileOnde.appendChild(novo);
		
		sizeLoad();
		
	} 
	
}

function fileDel(onde) {

	var fileOnde = (onde) ? eval('document.getElementById("' + onde + '")') : document.getElementById("fileCel");
	
	if (fileOnde.getElementsByTagName("input").length > 1) {
		fileOnde.removeChild(fileOnde.lastChild);
		fileOnde.removeChild(fileOnde.lastChild);
		sizeLoad();
	}
	
}

//=====================================================================================================
// REMOVER ARQUIVO DA LISTA

function arquivoDel(quem) {
	
	var lista = document.getElementById("arquivos").getElementsByTagName("ul")[0]
	var arquivo = lista.getElementsByTagName("li")
	
	lista.removeChild(arquivo[quem]);
	
	for (var i = 0; i < arquivo.length; i++) {
		
		var linkDel = arquivo[i].getElementsByTagName("a")[0]
		var hrefDel = linkDel.href.split("Arquivo=")[0]
		
		linkDel.href = hrefDel + "Arquivo=" + i
		
	}
	
	hidePop();
	sizeLoad();
}

//=====================================================================================================
// REMOVER PDF

function pdfDel() {

	hidePop();

	var lista = document.getElementById("arquivos");
	var pdfBox = document.getElementById("pdf");
	
	pdfChange();
	pdfBox.removeChild(lista);
	sizeLoad();

}

function pdfChange() { 
	
	var pdfOnde = document.getElementById("pdf");
	var pdfCheck = pdfOnde.getElementsByTagName("input")[0]

	if (!pdfCheck) {
		novo = document.createElement('input'); 
		novo.setAttribute('type', 'file'); 
		novo.setAttribute('name', 'ficha');
		novo.setAttribute('className', 'inputEditar');
		novo.setAttribute('size', '58'); 
	
		pdfOnde.appendChild(novo);
	}
	else {
		pdfOnde.removeChild(pdfOnde.lastChild);
	}

	sizeLoad();
	
}

//=====================================================================================================
// SELECT DE ESTADO E CIDADE

function GetXmlHttpObject() {
	
	var objXMLHttp = null;
	
	if (window.XMLHttpRequest) { objXMLHttp = new XMLHttpRequest() }
	else if (window.ActiveXObject) { objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP") }
	
	return objXMLHttp;

}

function findCidade(quem) {
	
	xmlHttp = GetXmlHttpObject();
	xmlHttp.onreadystatechange = showCidade;
	xmlHttp.open("GET","../includes/ajaxCidade.asp?UF=" + quem,true);
	xmlHttp.send(null);

}

function showCidade() {
	
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		
		// resposta em XML		
		var resposta = xmlHttp.responseXML.documentElement;
		var itens = resposta.getElementsByTagName("cidade");
		
		// caso hajam imagens
		if (itens.length > 0) {
			
			var cidadeSelect = document.getElementById("cidade");
			
			//limpar Select das cidades
			while(cidadeSelect.childNodes.length > 0) { cidadeSelect.removeChild(cidadeSelect.childNodes[0]); }

			//legenda do Select
			var legenda = document.createElement("option");
				legenda.setAttribute("value","0");
				legenda.appendChild(document.createTextNode("Escolha uma cidade"));
				
			cidadeSelect.appendChild(legenda);

			//para cada cidade
			for (var i = 0; i < itens.length; i++) {
				
				//valores dos nós
				var id = itens[i].getAttribute("id");
				var nome = itens[i].firstChild.nodeValue;
				
				//criar Options
				var novoOption = document.createElement('option');
					novoOption.setAttribute("value", id)
					novoOption.appendChild(document.createTextNode(nome));
					
				//inserir no Select
				cidadeSelect.appendChild(novoOption)					
				
			}
			
		}
		
	}
	
}

//=====================================================================================================
// ACIONAR EVENTOS AO CARREGAR IFRAME


if (navigator.appName.search("Microsoft") == -1) {
	window.addEventListener("load", checkFrame, false)
	window.addEventListener("load", sizeLoad, false)
	window.addEventListener("load", createPop, false)
}
else {
	window.attachEvent("onload", checkFrame);
	window.attachEvent("onload", sizeLoad);
	window.attachEvent("onload", createPop);
}
