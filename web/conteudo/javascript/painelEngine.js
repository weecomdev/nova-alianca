// HOME PAGE

//==================================================================================================//
// AJAX

//Busca informações no servidor
function findPainelEngine() {
	
	xmlPainelEngine = GetXmlHttpObject();
	xmlPainelEngine.onreadystatechange = showPainelEngine;
	xmlPainelEngine.open("GET","conteudo/server/ajaxPainelEngine.asp?Engine=" + (new getQuery).Engine,true);
	xmlPainelEngine.send(null);

}

//==================================================================================================//
// RESPOSTA XML

function showPainelEngine() {
	
	//div do painel
	var target = painelObjEngine;
	
	//resposta do servidor
	if (xmlPainelEngine.readyState == 4 || xmlPainelEngine.readyState == "complete") {
		
		//busca resposta em XML		
		var resposta = xmlPainelEngine.responseXML.documentElement;
		var imagens = resposta.getElementsByTagName('imagem');
		//var galeria = imagens[0].parentNode.getAttribute("galeria")
		
		//caso hajam imagens
		if (imagens.length > 0) {
			
			//para cada imagem
			for (var i = 0; i < imagens.length; i++) {
				
				//valores dos nós
				var foto = imagens[i].getAttribute("id");
				
				//inserir dados nas Arrays
				painelFotoEngine.push(foto);
				
			}
			
			//cria imagem com src da 1º foto
			var novoImg = document.createElement('img');
				target.appendChild(novoImg);
			
			//aciona troca de imagens
			fadePainelEngine();				

		}


	}

}
		
//==================================================================================================//
// TRANSIÇÕES

function fadePainelEngine() {

	//variáveis de velocidade
	var speed = 10;
    var timer = 0;
	
	//objetos do painel
	var painelDiv = painelObjEngine;
	var painelImg = painelDiv.getElementsByTagName("img")[0];
    
	//envia imagem atual para o fundo
	painelDiv.style.background = "url(" + painelImg.src + ") center no-repeat";
    
    //deixa IMG invisível
    mudaAlpha(0, painelImg);
    
    //troca caminho para imagem nova
    painelImg.src = "../imagens/engine_galeria/" + painelFotoEngine[painelNumEngine].split("_")[0] + "/fotos/" + painelFotoEngine[painelNumEngine] + ".jpg";
	
	//mostra IMG em fade
    for(i = 0; i <= 100; i++) {
        setTimeout("mudaAlpha(" + i + ", painelObjEngine.getElementsByTagName('img')[0])", (timer * speed));
        timer++;
    }
	
	//acionar função a cada intervalo
	if(timeFadeEngine == 0) { timeFadeEngine = window.setInterval("fadePainelEngine()", painelTempoEngine*1000); }
	
	//verifica próxima foto
	painelNumEngine = (painelNumEngine == (painelFotoEngine.length - 1)) ? 0 : (painelNumEngine + 1);

} 

//==================================================================================================//
// ONLOAD

var timeFadeEngine, painelObjEngine, painelNumEngine, painelFotoEngine, painelTempoEngine;

function loadPainelEngine() {
	
	painelObjEngine = document.getElementById("painelEngine");
	
	if (painelObjEngine) {
		timeFadeEngine = 0;
		painelNumEngine = 0;
		painelFotoEngine = new Array();
		painelTempoEngine = 4;
		findPainelEngine();
	}
	
}

addLoad(loadPainelEngine);