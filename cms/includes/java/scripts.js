//================================================================================================================
// TOPO

var helpTXT;

function findHelp() {

	if (helpTXT) {
		document.getElementById("helpInfo").innerHTML = helpTXT;
		document.getElementById("helpIco").style.display = "block";
	}
	
	if (document.getElementById("userInfo")) {
		document.getElementById("userIco").style.display = "block";
	}

}

function infoShow(quem) {

	var checkInfo = eval('document.getElementById("' + quem + 'Info");');
	var checkHide =	(quem == "user") ? "help" : "user";
	
	eval('document.getElementById("' + checkHide + 'Info").style.display = "none";');
	
	checkInfo.style.display = (checkInfo.style.display == "" || checkInfo.style.display == "none") ? "block" : "none";

}

function idiomaShow(quem) {
	
	var target = document.getElementById("topoIdioma");
	
	target.style.display = (target.style.display == "block") ? "none" : "block";
	
}

function idioma(quem) {

	if(quem.value != "") { window.location.href = "../includes/idioma.asp?Idioma=" + quem.value; }
}


//================================================================================================================
// MENU DA ESQUERDA

function menuShow(quem) {

var showNum = document.getElementById("menu").getElementsByTagName("div")
var linkNum = document.getElementById("menu").getElementsByTagName("b")

	if (showNum[quem].style.display != "block") { 
		for (var i = 0; i < showNum.length; i++) {
			if 	(quem != i) {
				showNum[i].style.display = 'none';
				linkNum[i].style.backgroundImage = 'url(../interface/layout_menu_off.jpg)';
				linkNum[i].style.color = '#333333';
			}
			else {
				showNum[i].style.display = 'block';
				linkNum[i].style.backgroundImage = 'url(../interface/layout_menu_on.jpg)';
				linkNum[i].style.color = '#003366';
			}
		}
	}
	else {
		showNum[quem].style.display = "none";
		linkNum[quem].style.backgroundImage = 'url(../interface/layout_menu_off.jpg)';
		linkNum[quem].style.color = '#333333';
	}

}

//================================================================================================================
// ADICIONAR OPTION APÓS INSERÇÃO INTERNA

function optionAdd(quem, url, nome) { 

	var selBox = document.getElementById(quem)
	
	if (selBox) {

		novo = document.createElement('option'); 
		novo.setAttribute('value', url); 
		novo.setAttribute('selected', true);
		
		selBox.appendChild(novo);
		novo.innerHTML = nome;
		novo.parentNode.focus();
		
		itemAdd();

	}
	else { window.location.reload(); }
	
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
		
	} 
	
}

function fileDel(onde) {

	var fileOnde = (onde) ? eval('document.getElementById("' + onde + '")') : document.getElementById("fileCel");
	
	if (fileOnde.getElementsByTagName("input").length > 1) {
		fileOnde.removeChild(fileOnde.lastChild);
		fileOnde.removeChild(fileOnde.lastChild);
	}
	
}

//=====================================================================================================
// EDITAR FOTOS

function fotoDel() {

	hidePop();
	var checkFoto = document.getElementById("fotoCel");
	if (checkFoto) {
		fotoChange();
		checkFoto.removeChild(checkFoto.getElementsByTagName("div")[0]);
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

}

//============================================================================================ FUNÇÕES DE LISTAGEM 

// ORDENAR BUSCA =================================================================================================

var listPalavra;
var listQuery;

function ordenar() {

	if (form.ordem.value != "0") {
		window.location.href = "listar.asp?Palavra=" + listPalavra + "&Ordem=" + form.ordem.value + "&" + listQuery ;
	}

}	

// FERRAMENTA DE BUSCA ===========================================================================================

function inBusca() { if (form.palavra.value == "Ferramenta de busca") { form.palavra.value = "" } }
function outBusca() { if (form.palavra.value == "") { form.palavra.value = "Ferramenta de busca" } }

function buscar() {
	if (form.palavra.value != "" && form.palavra.value != "Ferramenta de busca") {
		window.location.href = "listar.asp?Palavra=" + document.form.palavra.value + "&" + listQuery ;
	}
}

// EDIÇÃO OU OUTRAS OPERAÇÕES INTERNAS  ===========================================================================

function subEditar(quem, url, engine) {

//-----------------------------------------------------------------------------------------
	if(document.getElementById("divPop")) { hidePop() }
	if(document.getElementById("addFrame")) { itemAdd() }
//-----------------------------------------------------------------------------------------
	
var engineURL = (!engine) ? "editar" : engine;
	
var editFrame = "<iframe src='" + engineURL + ".asp?Id=" + url + "' id='editFrame' class='hideEdit' scrolling='no' marginwidth='0' marginheight='0' frameborder='0' vspace='0' hspace='0'></iframe>";

var allSub = document.getElementsByTagName("center");

if (allSub[quem].innerHTML == "") {

	for (var i = 0; i <= allSub.length; i++) {
		if 	(quem != i) { 
			allSub[i].innerHTML = "";
			allSub[i].style.display = "none";
		}
		else { 
			allSub[i].innerHTML = editFrame;
			allSub[i].style.display = "block";
		}
	}

}
else {
	
	var checkEngine = document.getElementById("editFrame").src.search(engineURL)

	if (checkEngine == -1) {
		document.getElementById("editFrame").src = engineURL + ".asp?Id=" + url;
	}
	else {
		allSub[quem].style.display = "none";
		allSub[quem].innerHTML = "";
	}

}

}


// ADIÇÃO INTERNA ==============================================================================================

function itemAdd(linkAdd) {

//-----------------------------------------------------------------------------------------
	if (document.getElementById("divPop")) { hidePop() }

	if (document.getElementById("editFrame")) {
		document.getElementById("editFrame").parentNode.style.display = "none";
		document.getElementById("editFrame").parentNode.innerHTML = "";
	}
//-----------------------------------------------------------------------------------------

if (!linkAdd) { linkAdd = "adicionar.asp" }
	
var addFrame = "<iframe src='" + linkAdd + "' id='addFrame' scrolling='no' marginwidth='0' marginheight='0' frameborder='0' vspace='0' hspace='0'></iframe>";
var checkAdd = document.getElementById('divAdd')

	if (checkAdd) {	

		if (checkAdd.innerHTML == "") {
			checkAdd.innerHTML = addFrame;
			checkAdd.style.display = "block";
		}
		else {
			checkAdd.innerHTML = "";
			checkAdd.style.display = "none";
		}

	}
	else { window.location.href = linkAdd }

} 

//==============================================================================================================
// ONLOAD

(navigator.appName.search("Microsoft") == -1) ?
window.addEventListener("load", findHelp, false) :
window.attachEvent("onload", findHelp) ;
