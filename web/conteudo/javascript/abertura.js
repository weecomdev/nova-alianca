// ABERTURA

//==================================================================================================//
// AJAX

//Busca informações no servidor
function findPainel() {
	
	xmlPainel = GetXmlHttpObject();
	xmlPainel.onreadystatechange = showPainel;
	xmlPainel.open("GET","conteudo/server/ajaxAbertura.asp",true);
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
				var desc = imagens[i].firstChild.nodeValue;
				
				//inserir dados nas Arrays
				painelFoto.push(foto);
				painelInfo.push(desc);
				
			}
			
			//cria imagem com src da 1º foto
			var novoImg = document.createElement('img');
				document.getElementById("imagem").appendChild(novoImg);
				
			//cria P da legenda
			var novoP = document.createElement('p');
				document.getElementById("mensagem").appendChild(novoP);
		
			//aciona troca de imagens
			fadePainel();
			
		}

	}

}
		
//==================================================================================================//
// TRANSIÇÕES

function fadePainel() {
	
	//ao final da animação, redirecionar
	if (painelNum == painelFoto.length) { window.location.href = "default.asp"; }
	else {
	
		//variáveis de velocidade
		var speed = 10;
		var timer = 0;
		
		//objetos do painel
		var painelDiv = document.getElementById("imagem");
		var painelImg = painelDiv.getElementsByTagName("img")[0];
		var painelLegenda = document.getElementById("mensagem").getElementsByTagName("p")[0];
		
		//envia imagem atual para o fundo
		painelDiv.style.background = "url(" + painelImg.src + ") center no-repeat";
		
		//deixa IMG invisível
		mudaAlpha(0, painelImg);
		
		//troca caminho para imagem nova
		painelImg.src = "../imagens/abertura/" + painelFoto[painelNum] + ".jpg";
		painelImg.alt = painelInfo[painelNum];
		
		//inserir mensagem caso exista
		if(painelInfo[painelNum] != "vazio")  { painelLegenda.innerHTML = painelInfo[painelNum]; }
		else { painelLegenda.innerHTML = ""; }
	
		//mostra IMG em fade
		for(i = 0; i <= 100; i++) {
			setTimeout("mudaAlpha(" + i + ", document.getElementById('imagem').getElementsByTagName('img')[0])", (timer * speed));
			timer++;
		}
		
		//acionar função a cada intervalo
		if(timeFade == 0) { timeFade = window.setInterval("fadePainel()", painelTempo*1000); }
		
		//verifica próxima foto
		painelNum++;
		//painelNum = (painelNum == (painelFoto.length - 1)) ? 0 : (painelNum + 1);
		
	}
	
} 

//==================================================================================================//
// ONLOAD

var timeFade, painelObj, painelNum, painelFoto, painelInfo, painelTempo;

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

onload = loadPainel;









