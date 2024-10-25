//==========================================================================================================
// ACIONA EDITOR
//==========================================================================================================

function iniciar() {
	editor.document.designMode = 'On';

	makeText()
	formatar();
	barra();

	//editor.document.onkeyup = limpar;
}

//==========================================================================================================
// BARRA DE FERRAMENTAS
//==========================================================================================================

function barra() {
	
	var barraHTML = '' +
	'<a href="javascript:negrito();"	style="background-image: url(../interface/edit_negrito.gif);"	title="Negrito">		</a>' +
	'<a href="javascript:italico();"	style="background-image: url(../interface/edit_italico.gif);"	title="Italico">		</a>' +
	'<a href="javascript:createLink();"	style="background-image: url(../interface/edit_link.gif);"		title="Adicionar link">	</a>' +
	'<a href="javascript:marcadores();"	style="background-image: url(../interface/edit_marcador.gif);"	title="Marcadores">		</a>' +
	'<a href="javascript:numeracao();"	style="background-image: url(../interface/edit_numeracao.gif);"	title="Numerar">		</a>' +
	'<a href="javascript:recortar();"	style="background-image: url(../interface/edit_recortar.gif);"	title="Recortar">		</a>' +
	'<a href="javascript:copiar();"		style="background-image: url(../interface/edit_copiar.gif);"	title="Copiar">			</a>' +
	'<a href="javascript:colar();"		style="background-image: url(../interface/edit_colar.gif);"		title="Colar">			</a>' +
	'<a href="javascript:desfazer();"	style="background-image: url(../interface/edit_desfazer.gif);"	title="Desfazer">		</a>' +
	'<a href="javascript:refazer();"	style="background-image: url(../interface/edit_refazer.gif);"	title="Refazer">		</a>';

//	'<a href="javascript:entitular();"	style="background-image: url(../interface/edit_ALL.gif);"	title="Quebra">		</a>';
	
	if(document.getElementById("divEdit")) { document.getElementById("divEdit").innerHTML = barraHTML; }

}

//==========================================================================================================
// VERIFICAR CONTEÚDO EXISTENTE
//==========================================================================================================

function makeText() {
	
	var beginText = (document.form.editBox.value.length != 0) ? document.form.editBox.value : "<P>&nbsp;</P>"
	
	editor.document.open()
	editor.document.write(beginText)
	editor.document.close()

}

//==========================================================================================================
// FORMATAÇÃO DO EDITOR
//==========================================================================================================

function formatar() {
	editor.document.body.style.cssText = "" +
	"background-color: #FFFFFF;" +
	"font-family: Trebuchet MS, Arial, Helvetica, sans-serif;" +
	"font-size: 11px;" +
	"margin: 5px;" +
	"scrollbar-base-color: #f2f2f2;";
}

//==========================================================================================================
// COMANDOS DE EDIÇÃO
//==========================================================================================================

function recortar()		{ editor.document.execCommand('cut', false, null); }
function copiar()		{ editor.document.execCommand('copy', false, null); }
function colar()		{ editor.document.execCommand('paste', false, null); }
function desfazer()		{ editor.document.execCommand('undo', false, null); }
function refazer()		{ editor.document.execCommand('redo', false, null); }
function negrito()		{ editor.document.execCommand('bold', false, null); }
function italico()		{ editor.document.execCommand('italic', false, null); }
function numeracao()	{ editor.document.execCommand('insertorderedlist', false, null); }
function marcadores()	{ editor.document.execCommand('insertunorderedlist', false, null); }

function createLink() {
	
	if (navigator.appName.search("Microsoft") == -1) {
		
		var checkText = editor.document.getSelection();
		
		if (!checkText) { alert("selecione algum texto para adicionar link") }
		else {
			var linkUrl = prompt("Insira o link desejado: :", "http://")
			editor.document.execCommand("createlink",false,linkUrl);
		}
	}
	else {
		editor.focus();
		editor.document.execCommand('createlink');
	}
	
}


function entitular()	{ editor.document.execCommand('FormatBlock', false, '<BR>'); }

//==========================================================================================================
// LIMPEZA DE FORMATAÇÃO
//==========================================================================================================

function limpar() {

//BUSCAR TAGS
	var tagSpan = editor.document.getElementsByTagName("SPAN");
	var tagFont = editor.document.getElementsByTagName("FONT");
	var tagU = editor.document.getElementsByTagName("U");
	var tagB = editor.document.getElementsByTagName("B");
	var tagI = editor.document.getElementsByTagName("I");
	var tagP = editor.document.getElementsByTagName("P");

//EXCLUIR TAGS
	if(tagSpan.length > 0) { for (var i = 0; i <= tagSpan.length; i++) { tagSpan[i].outerHTML = tagSpan[i].innerHTML; } }
	if(tagFont.length > 0) { for (var i = 0; i <= tagFont.length; i++) { tagFont[i].outerHTML = tagFont[i].innerHTML; } }
	if(tagU.length > 0) { for (var i = 0; i <= tagU.length; i++) { tagU[i].outerHTML = tagU[i].innerHTML; } }

//SUBSTITUIR TAGS	
	if(tagB.length > 0) { for (var i = 0; i <= tagB.length; i++) { tagB[i].outerHTML = "<STRONG>" + tagB[i].innerHTML + "</STRONG>"; } }
	if(tagI.length > 0) { for (var i = 0; i <= tagI.length; i++) { tagI[i].outerHTML = "<EM>" + tagI[i].innerHTML + "</EM>"; } }

//LIMPAR PARAGRAFOS
	//if(tagP.length > 0) { for (var i = 0; i <= tagP.length; i++) { tagP[i].clearAttributes(); tagP[i].style.cssText= ""; } }
	if(tagP.length > 0) { for (var i = 0; i < tagP.length; i++) { tagP[i].clearAttributes(); tagP[i].clearAttributes(); } }
}

//==========================================================================================================
// TARGET DOS LINKS
//==========================================================================================================

function checkLink() {
	
	var tagLink = editor.document.getElementsByTagName("A");
	var checkHost = window.location.host;
	
	for (var i = 0; i < tagLink.length; i++) { 
	
		var checkHref = tagLink[i].getAttribute("href");
	
		if (checkHref.search(checkHost) == -1 && checkHref.search("mailto:") == -1) {
			
			tagLink[i].setAttribute("target", "_blank");
		
		}
		
	}
}


//==========================================================================================================
// PREPARA PARA ENVIO
//==========================================================================================================

function final() { 
	//limpar();
	checkLink();
	document.form.editBox.value = editor.document.body.innerHTML;
	document.form.editBox.value = document.form.editBox.value.replace("<P>&nbsp;</P>","");
}

//==========================================================================================================
//COMANDO ONLOAD
//==========================================================================================================

(navigator.appName.search("Microsoft") == -1) ?
window.addEventListener("load", iniciar, false) :
window.attachEvent("onload", iniciar) ;
