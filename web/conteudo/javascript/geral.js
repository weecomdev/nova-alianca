
// SCRIPTS GERAIS

//======================================================================================================================================//
//AJAX

// Retorna o HttpRequest que deve ser acionado

function GetXmlHttpObject() {
	
	var objXMLHttp = null;
	
	if (window.XMLHttpRequest) { objXMLHttp = new XMLHttpRequest() }
	else if (window.ActiveXObject) { objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP") }
	
	return objXMLHttp;

}

// Busca informações no servidor

function findInfo(engine, parametros) {
	
	//objeto xmlHttp
	xmlHttp = GetXmlHttpObject();
	
	//url no servidor
	var url = "conteudo/server/ajax" + engine + ".asp"
	if(typeof parametros != "undefined") { url += "?" + parametros; }

	//acionar ajax
	xmlHttp.onreadystatechange = eval("show" + engine)
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)

}

//======================================================================================================================================//
// RETORNAR QUERYSTRING

function getQuery() {
	
	//valores querystring
	this.queryText = window.location.search.replace("?","");
	var queryArray = this.queryText.split("&");
	
	//para cada valor
	for (var i = 0; i < queryArray.length; i++) {
		if(queryArray[i]) {
			var inQuery = queryArray[i].split("=");
			eval("this." + inQuery[0] + " = '" + inQuery[1] + "'");
		}
	}
		
}

//======================================================================================================================================//
// ADICIONAR ONLOAD

function addLoad(func) {
	
	var oldonload = window.onload;
	
	if (typeof window.onload != 'function') { window.onload = func; }
	else { window.onload = function() { oldonload(); func(); } }
	
}

//======================================================================================================================================//
// Muda transparência para todos os browsers

function mudaAlpha(valor, objeto) {

	objeto.style.opacity = (valor / 100);
    objeto.style.MozOpacity = (valor / 100);
    objeto.style.KhtmlOpacity = (valor / 100);
    objeto.style.filter = "alpha(opacity=" + valor + ")";
	
}

//======================================================================================================================================//
// DESTACAR LINKS DO MENU

function checkEngine() {
	
	var query = new getQuery;
	var listas = document.getElementById("topo").getElementsByTagName("li");
	
	for(var i = 0; i < listas.length; i++) {
		
		var checkLink = listas[i].getElementsByTagName("A")[0];
		if(checkLink.getAttributeNode("href").value.search("Engine=" + query.Engine) != -1) { checkLink.className = "engine"; }
		
	}
	
}

addLoad(checkEngine);

//==================================================================================================================//
// VALIDAR E ENVIAR FORMULÁRIOS

function enviaForm(quem) {
	
	var check = true;
	var formulario = quem.parentNode;
	var labels = formulario.getElementsByTagName("label");
	var botao = formulario.getElementsByTagName("a")[0];

	//verificar campos
	for (var i = 0; i < labels.length; i++) {
		
		var checkFor = labels[i].getAttributeNode("for");
		
		if (checkFor && checkFor.value != "") {
			
			var campo = document.getElementById(checkFor.value);
			
			if (campo.value.length > 0) { campo.className = "ok"; labels[i].className = "ok"; }
			else { campo.className = "erro"; labels[i].className = "erro"; check = false; }
			
		}

	}
	
	//enviar caso esteja tudo ok
	if (check) {
		botao.innerHTML = "enviando";
		formulario.submit()
	}
	
}

//==================================================================================================================//
// ACESSO RESTRITO

// Valida campos e aciona ajax
function loginEnvia(quem) {
	
	var labels = quem.parentNode.getElementsByTagName("label");
	var campos = quem.parentNode.getElementsByTagName("input");
	var login = campos[0].value;
	var senha = campos[1].value;
	
	//caso os campos estejam corretos aciona ajax
	if (login.length > 0 && senha.length > 0 ) {
		loginMsg("Enviando dados");
		//findInfo("Login","login=" + login + "&senha=" + senha);
	}
	//caso hajam erros exibe mensagem
	else {
		for(var i=0; i <= 1; i++) { labels[i].className = (campos[i].value.length == 0) ? "erro" : "";  } 
		loginMsg("Preencha corretamente os campos", "erro");
	}
	
}

// Recebe resposta do cadastro (Ajax)
function showLogin() {
	
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		loginMsg(xmlHttp.responseText);
		//window.open("")
	}
		
}

// Exibe mensagem
function loginMsg(txt, tipo) {
	
	var legenda = document.getElementById("cabecalho").getElementsByTagName("fieldset")[0].getElementsByTagName("b")[0];
	
	//define possível class
	tipo = (typeof tipo == "undefined") ? "" : " class='" + tipo + "'";
	
	//insere txt no elemento
	legenda.innerHTML = "<span" + tipo + ">" + txt + "</span>";
	
}

//==================================================================================================================//
// REPRESENTANTES

function repBusca(quem, onde) {
	
	if(quem != 0) {
	
		if (typeof onde == "undefined") { findInfo("Mapa","UF=" + quem); }
		else { findInfo("Rep","Cidade=" + quem); }
		
	}
	
}

//retorno do Ajax
function showMapa() {
	
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		
		// resposta em XML		
		var resposta = xmlHttp.responseXML.documentElement;
		var itens = resposta.getElementsByTagName("cidade");
			
		// caso hajam imagens
		if (itens.length > 0) {
			
			//Selecionar o estado
			var uf = itens[0].parentNode.getAttribute("uf").toUpperCase();
			var ufOptions = document.getElementById("estado").getElementsByTagName("option");
			
			for (var i = 0; i < ufOptions.length; i++) { if(ufOptions[i].value == uf) { ufOptions[i].selected = true; } }			
				
			//Select das cidades
			var cidadeSelect = document.getElementById("cidade");
			
			//caso exista o Select das cidades
			if (cidadeSelect) {
				while(cidadeSelect.childNodes.length > 0) { cidadeSelect.removeChild(cidadeSelect.childNodes[0]); }				
			}
			else {
				// criar Select
				var cidadeSelect = document.createElement('select');
					cidadeSelect.setAttribute("id", "cidade")
					cidadeSelect.onchange = function() { repBusca(this.value, 'cidade'); };
					
				//inserir Select no Fieldset
				var target = document.getElementById("conteudo").getElementsByTagName("fieldset")[0];
					target.appendChild(cidadeSelect);
			}
			
			//legenda do Select
			var legenda = document.createElement("option");
				legenda.setAttribute("value","0");
				legenda.appendChild(document.createTextNode("Escolha uma cidade de referência"));
				
			cidadeSelect.appendChild(legenda);

			//para cada item
			for (var i = 0; i < itens.length; i++) {
				
				//valores dos nós
				var id = itens[i].getAttribute("id");
				var total = itens[i].getAttribute("total");
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

//retorno do ajax
function showRep() {
	
	var target = document.getElementById("resultado");
	
	target.innerHTML = (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") ? xmlHttp.responseText : "carregando...";	
	
}

//==================================================================================================================//
// ONDE COMPRAR

function ondeBusca(quem, onde) {
	
	if (typeof onde == "undefined") { findInfo("Onde","UF=" + quem); }
	else { window.location.href = "default.asp?Engine=onde&Id=" + quem; }
	
}

//retorno do ajax
function showOnde() {
	
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		
		// resposta em XML		
		var resposta = xmlHttp.responseXML.documentElement;
		var itens = resposta.getElementsByTagName("cidade");
		
		// caso hajam imagens
		if (itens.length > 0) {
			
			var cidadeSelect = document.getElementById("cidade");
			
			//caso exista o Select das cidades
			if (cidadeSelect) {
				while(cidadeSelect.childNodes.length > 0) { cidadeSelect.removeChild(cidadeSelect.childNodes[0]); }				
			}
			else {
				// criar Select
				var cidadeSelect = document.createElement('select');
					cidadeSelect.setAttribute("id", "cidade")
					cidadeSelect.onchange = function() { ondeBusca(this.value, 'cidade'); };
					
				//inserir Select no Fieldset
				var target = document.getElementById("conteudo").getElementsByTagName("fieldset")[0];
					target.appendChild(cidadeSelect);
					
			}
			
			//legenda do Select
			var legenda = document.createElement("option");
				legenda.setAttribute("value","0");
				legenda.appendChild(document.createTextNode("Escolha uma cidade"));
				
			cidadeSelect.appendChild(legenda);

			//para cada item
			for (var i = 0; i < itens.length; i++) {
				
				//valores dos nós
				var id = itens[i].getAttribute("id");
				var total = itens[i].getAttribute("total");
				var nome = itens[i].firstChild.nodeValue;
				
				//criar Options
				var novoOption = document.createElement('option');
					novoOption.setAttribute("value", id)
					novoOption.appendChild(document.createTextNode(nome + " (" + total + ")"));
					
				//inserir no Select
				cidadeSelect.appendChild(novoOption)					
				
			}
			
		}
		
	}
	
}

//==================================================================================================================//
// GALERIA DE FOTOS

var zoomDiv;
var zoomImg;

//zoom na thumb desejada
function zoom(quem) {

	//variáveis de velocidade
	var speed = 10;
    var timer = 0;
	
	//objetos
	zoomDiv = document.getElementById("zoom");
	zoomImg = zoomDiv.getElementsByTagName("img")[0];
    
    //envia imagem atual para o fundo
    zoomDiv.style.backgroundImage = "url(" + zoomImg.src + ")";
    
    //deixa IMG invisível
    mudaAlpha(0, zoomImg);
    
    //troca caminho para imagem nova
    zoomImg.src = quem.src.replace("thumbs","fotos");

    //mostra IMG em fade
    for(i = 0; i <= 100; i++) {
        setTimeout("mudaAlpha(" + i + ", document.getElementById('zoom').getElementsByTagName('img')[0])", (timer * speed));
        timer++;
    }
	
}


// inserir thumbs na página
function showThumb() {
	
	var target = document.getElementById("thumb");
	target.innerHTML = (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") ? xmlHttp.responseText : "carregando..." ;
	
}

//carregar thumbs
function loadGaleria() {

	var query = new getQuery;
	
	if(typeof query.Id == "undefined") { query.Id = 0; }
	
	if(query.Engine == "confraria" && query.subEngine == "galeria" ) { findInfo("Thumb", "Id=" + query.Id); }

}

addLoad(loadGaleria);

//==================================================================================================================//
// PRODUTOS

function listaTitulo(quem) {
	
	var conteudo = nextObject(quem);
	
	conteudo.style.display = (conteudo.style.display != "block") ? "block" : "" ;
	quem.className = (quem.className != "menos") ? "menos" : "";
	
}

var nextObject = function(n) { do n = n.nextSibling; while (n && n.nodeType != 1); return n; };

//==================================================================================================================//
// ENDEREÇO

//Buscar geocode do Google
function loadMapa() {

	//caso seja contato
	if((new getQuery).Engine == "contato") {
	
		//endereço
//		var lugar = document.getElementById("endereco").getElementsByTagName("address")[0].innerHTML;
		var lugar = document.getElementById("mapa_address").value;
		
		//aciona mapa
		if (GBrowserIsCompatible()) {
		
			var geoCoder = new GClientGeocoder();
				geoCoder.getLatLng(lugar,montaMapa)
				
		}
		
		//onUnload
		window.onunload = GUnload;
		
	}
	
}

//onload
addLoad(loadMapa)

//Criar mapa
function montaMapa(centro) {
	
	var target = document.getElementById("mapa");
	
	//caso encontre o geocode
	if(centro) {
		
		//mensagem do balão
		var msgPop = "<b>Vinícola Aliança</b><br/>" +
					 target.parentNode.getElementsByTagName("b")[0].innerHTML;
		
		//cria novo mapa
		var mapa = new GMap2(target);
			mapa.setCenter(centro, 16);
			mapa.addControl(new GLargeMapControl())
		
		//cria ícone
		var icone = new GIcon();
			icone.image = "interface/imagens/marco.png";
			icone.iconAnchor = new GPoint(3, 53);
			icone.infoWindowAnchor = new GPoint(3, 0);
		
		//criar marco
		var marco = new GMarker(mapa.getCenter(), icone);
		
		//adicionar evento ao marco
		GEvent.addListener(marco,"click", function() { mapa.openInfoWindowHtml(centro, msgPop); });
	
		//insere marco no mapa
		mapa.addOverlay(marco);
	
	}
	//caso não encontre
	else { target.parentNode.removeChild(target); }
	
}

