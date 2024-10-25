// HOME PAGE

//==================================================================================================//
// AJAX

//Busca informações no servidor
function findPainel() {
	
	xmlPainel = GetXmlHttpObject();
	xmlPainel.onreadystatechange = showPainel;
	xmlPainel.open("GET","conteudo/server/ajaxPainel.asp",true);
	xmlPainel.send(null);

}

//==================================================================================================//
// RESPOSTA XML

function showPainel() {
	
	//div do painel
	var target = painelObj;
	
	//resposta do servidor
	if (xmlPainel.readyState == 4 || xmlPainel.readyState == "complete") {
		
		//busca resposta em XML		
		var resposta = xmlPainel.responseXML.documentElement;
		var imagens = resposta.getElementsByTagName('imagem');
		
		//caso hajam imagens
		if (imagens.length > 0) {
			
			//para cada imagem
			for (var i = 0; i < imagens.length; i++) {
				
				//valores dos nós
				var foto = imagens[i].getAttribute("id");
				var nome = imagens[i].getElementsByTagName('titulo')[0].firstChild.nodeValue;
				var desc = imagens[i].getElementsByTagName('mensagem')[0].firstChild.nodeValue;
				
				//inserir dados nas Arrays
				painelFoto.push(foto);
				painelNome.push(nome);
				painelInfo.push(desc);
				
			}
			
			//cria imagem com src da 1º foto
			var novoImg = document.createElement('img');
				target.appendChild(novoImg);
				
		}
		
		//cria Dl da legenda
		var novoDl = document.createElement('dl');
			target.appendChild(novoDl);
		
		//aciona troca de imagens
		fadePainel();

	}

}
		
//==================================================================================================//
// TRANSIÇÕES

function fadePainel() {

	//variáveis de velocidade
	var speed = 10;
    var timer = 0;
	
	//objetos do painel
	var painelDiv = painelObj;
	var painelImg = painelDiv.getElementsByTagName("img")[0];
	var painelLegenda = painelDiv.getElementsByTagName("dl")[0];
    
	//envia imagem atual para o fundo
	painelDiv.style.background = "url(" + painelImg.src + ") center no-repeat";
    
    //deixa IMG invisível
    mudaAlpha(0, painelImg);
    
    //troca caminho para imagem nova
    painelImg.src = "../imagens/home/" + painelFoto[painelNum] + ".jpg";
	painelImg.alt = (painelNome[painelNum] == "vazio") ? "Página inicial" : painelNome[painelNum] ;
	
	//limpar possiveis dados de legenda
	while(painelLegenda.childNodes.length > 0) { painelLegenda.removeChild(painelLegenda.childNodes[0]); }
	
	if(painelNome[painelNum] != "vazio" || painelInfo[painelNum] != "vazio") {
		
		painelLegenda.style.display = "";
		
		//inserir titulo caso exista
		if(painelNome[painelNum] != "vazio")  {
			var novoDt = document.createElement("dt");
				novoDt.appendChild(document.createTextNode(painelNome[painelNum]));
				painelLegenda.appendChild(novoDt)					
		}
		
		//inserir mensagem caso exista
		if(painelInfo[painelNum] != "vazio")  {
			var novoDd = document.createElement("dd");
				novoDd.appendChild(document.createTextNode(painelInfo[painelNum]));
				painelLegenda.appendChild(novoDd)					
		}
		
	}
	else { painelLegenda.style.display = "none"; }

	//mostra IMG em fade
    for(i = 0; i <= 100; i++) {
        setTimeout("mudaAlpha(" + i + ", painelObj.getElementsByTagName('img')[0])", (timer * speed));
        timer++;
    }
	
	//acionar função a cada intervalo
	if(timeFade == 0) { timeFade = window.setInterval("fadePainel()", painelTempo*1000); }
	
	//verifica próxima foto
	painelNum = (painelNum == (painelFoto.length - 1)) ? 0 : (painelNum + 1);

} 

//==================================================================================================//
// ONLOAD

var timeFade, painelObj, painelNum, painelFoto, painelNome, painelInfo, painelTempo;

function loadPainel() {
	
	painelObj = document.getElementById("painel");
	
	if (painelObj) {
		timeFade = 0;
		painelNum = 0;
		painelFoto = new Array();
		painelNome = new Array();
		painelInfo = new Array();
		painelTempo = 8;
		findPainel();
	}
	
}

addLoad(loadPainel);









