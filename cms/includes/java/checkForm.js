var haveerrors = 0;
var formArray = new Array();

function validateForm(f) {
	
	haveerrors = 0;
	formCheck();

	for (var i = 0; i < formArray.length; i++) {

		switch(formArray[i][1]) {
		// 1 = campo vazio
		case 1:
			showImage(formArray[i][0], eval("f." + formArray[i][0] + ".value.length < 1"));
		break;
		// 2 = email
		case 2:
			showImage(formArray[i][0], eval('f.' + formArray[i][0] + '.value.search("@") == -1 || f.' + formArray[i][0] + '.value.search("[.*]") == -1'));
		break;
		// 3 = select igual a zero
		case 3:
			showImage(formArray[i][0], eval("f." + formArray[i][0] + ".value == 0"));
		break;
		// 4 = adição de arquivo
		case 4:
			showImage(formArray[i][0], eval('f.' + formArray[i][0] + '.value.length < 1 || f.' + formArray[i][0] + '.value.search(".' + formArray[i][2] + '") == -1'));
		break;
		// 5 = edição de arquivo
		case 5:
			showImage(formArray[i][0], eval('f.' + formArray[i][0] + '.value.length > 1 && f.' + formArray[i][0] + '.value.search(".' + formArray[i][2] + '") == -1'));
		break;
		// 6 = editor de html
		case 6:
			(navigator.appName.search("Microsoft") == -1) ? 
			showImage(formArray[i][0], eval('document.getElementById("editorFrame").contentWindow.document.body.innerHTML == "<p>&nbsp;</p>" || document.getElementById("editorFrame").contentWindow.document.body.innerHTML == "<br>"')) :	
			showImage(formArray[i][0], eval('document.getElementById("editorFrame").contentWindow.document.body.innerHTML == "<P>&nbsp;</P>"'));
		break;
		// caso específico = executa a condição enviada
		default: showImage(formArray[i][0], eval(formArray[i][1])); 
		}
	
	}
	if (haveerrors == false) { progresso(); }
	return (!haveerrors);
}

function showImage(campo, errors) {

	var checkInput = eval("document.form." + campo);
	var checkTd = eval("document.getElementById('td_" + campo + "')");
	var botaoId = document.getElementById("botao");
	var editorId = document.getElementById("editorFrame");
		
	if (errors) {
		
		if (checkInput) { checkInput.className = 'inputErro'; }
		if (checkTd) 	{ checkTd.className = 'itemErro'; }
		if (botaoId)	{
			botaoId.value = 'corrija os dados destacados acima'; 
			botaoId.style.background = "url(../interface/page_botao_erro.jpg) center no-repeat";
		}
		if (editorId && campo == "editBox") { editorId.className = "erro"; }
	
	}
	else {
	
		if (checkInput) { checkInput.className = 'inputEditar'; }
		if (checkTd) 	{ checkTd.className = 'itemEditar'; }
		if (editorId && campo == "editBox") { editorId.className = ""; }
	
	}
	
	if (!haveerrors && errors) { haveerrors = errors; }
}

function progresso() {
	
	var botaoId = document.getElementById("botao");
	
	if (document.getElementById("editorFrame")) { final(); }
	
	botaoId.value = ""; 
	botaoId.style.background = "url(../interface/page_barra.gif) center no-repeat"; 

}