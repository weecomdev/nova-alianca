
if (!bf2.dropableWindows)
	bf2.dropableWindows = new Array();

function _windowClose(evt) {
	if (!evt) evt = window.event;
	var src = evt.target ? evt.target : evt.srcElement;
	var win = src._window;
	win.close();
}

function _windowDestroy(key) {
	var window = bf2.dropableWindows[key];
	bf2.dropableWindows[key] = null;
	document.body.removeChild(window.windowPanel);
}

function _toTop(div) {
	var maxZIndex = document.maxZIndex;
	if (maxZIndex == undefined)
		maxZIndex = 100;
	maxZIndex++;
	document.maxZIndex = maxZIndex;
	div.style.zIndex = maxZIndex;
}

/**
 *
 * @params JSON: {width, height, title, left, top, titleHeight}
 */ 
bf2.Validator = function(params) {

	this.windowPanel = document.createElement('div');
	this.windowTitle = document.createElement('div');
	this.windowContent = document.createElement('div');
	this.identifier = ((Math.random() *Math.random()) %Math.random()) +Math.random();
	
function impValData(field,bmsg,itipo)
{
	erroValidacao = true;

	if (field.value=="")
	{
		erroValidacao = false;
		return true;
	}
	var atipo=["data","dd/mm/aa","dd/mm/aaaa","dd/mm","mm/aaaa"];

	//arrumado bug do formato MM/DDDD , itipo = 4
	var bformatoData = (itipo)? itipo : formatoData(field.value);

	itipo=(itipo)?itipo:0; //0=qualquer, 1=dmaa,2=dmaaaa,3=ddmm,4=mmaaaa

	var bDDMMAA 	= ((bformatoData==1)&&(itipo==0||itipo==1));
	var bDDMMAAAA	= ((bformatoData==2)&&(itipo==0||itipo==2));
	var bDDMM 		= ((bformatoData==3)&&(itipo==0||itipo==3));
	var bMMAAAA		= ((bformatoData==4)&&(itipo==0||itipo==4));
	if ((!bDDMMAA)&&(!bDDMMAAAA)&&(!bDDMM)&&(!bMMAAAA))// formato não reconhecido
	{
		if(bmsg)
			alert ("Conteúdo informado não reconhecido como sendo "+atipo[itipo]+"!\nVerifique sua digitação!");

		//field.select();field.focus();
		selecionarCampo(field);
		return false;
	}

	var dia0,mes0,ano0;
	var auxData;
	var dData="";
	var dHoje=new Date();

	if (bDDMMAAAA)
		dData = impFormat(field.value,reDDMMAAAA,fsDDMMAAAA);
	else if (bDDMMAA)
		dData = impFormat(field.value,reDDMMAA,fsDDMMAA);
	else
		dData = impFormat(field.value+"/"+dHoje.getFullYear(),reDDMMAAAA,fsDDMMAAAA);
	if (bMMAAAA)
		dData=impFormat(field.value,reMMAAAA,fsMMAAAA); //MMAAAA

	dma=dData.split("/");

	if (bDDMMAA)
	{
		dma[2]= (dma[2]<20)?parseInt(dma[2])+2000:parseInt(dma[2])+1900; // janelamento de data
	}

	if (bMMAAAA)
	{
		dma[2]= dma[1];  dma[1]= dma[0]; //ajusta array comparativo para MMAAAA
	}

	var obj = new Date(dma[2], dma[1]-1, dma[0]); //cria data no browser

	dma[0]= "00" + dma[0];
	dma[1]= "00" + dma[1];
	dma[2]= "0000" + dma[2];
	dma[0] = dma[0].substr(dma[0].length-2);
	dma[1] = dma[1].substr(dma[1].length-2);
	dma[2] = dma[2].substr(dma[2].length-4);
	dData=dma.join("/");

	dia0 = "00" + obj.getDate();
	mes0 = "00" + (obj.getMonth()+1);
	ano0 = "0000" + obj.getFullYear();
	dia0 = dia0.substr(dia0.length-2);
	mes0 = mes0.substr(mes0.length-2);
	ano0 = ano0.substr(ano0.length-4);

	if (bMMAAAA)
	{
		auxData =  mes0 + "/"+ ano0;
		dData = dma[1] + "/"+ dma[2];
	}
	else
	{
		auxData = dia0 + "/"+  mes0 + "/"+ ano0;
	}

	if ((auxData != dData))
	{
		if (bmsg)
			alert ("Conteúdo informado não reconhecido como sendo "+atipo[itipo]+" válida!\nVerifique sua digitação!");

		//if (bmsg) alert("Data incorreta\nVerifique sua Digitação")
		selecionarCampo(field);
		return false;
	}
	else
	{
		if (bMMAAAA)
		{
			field.value=mes0+"/"+ano0;
		}
		else
		{
			field.value=dia0+"/"+mes0+((itipo==3)?"":("/"+((itipo==1)?ano0.substring(ano0,2):ano0)));
		}

		erroValidacao = false;
		return true;
	}
}
	
	this.configureWindowPanel = function(params) {
		this.windowPanel.className = 'windowPanel';
		
		this.windowPanel.style.width = params.width +'px';
		this.windowPanel.style.height = params.height +'px';
		this.windowPanel.style.left = params.left +'px';
		this.windowPanel.style.top = params.top +'px';

		this.windowPanel.onclick = function() {_toTop(this)};

		_toTop(this.windowPanel);
	}
	
	this.configureWindowTitle = function(params) {
		this.windowTitle.className = 'windowTitle';
		
		var divClose = document.createElement('div');
		divClose.className = 'closeButton';
		divClose.onclick = _windowClose;
		divClose._window = this;
		this.windowTitle.appendChild(divClose);
		
		var spanTitle = document.createElement('span');
		spanTitle.className = 'titleText';
		this.windowTitle.appendChild(spanTitle);
		
		spanTitle.innerHTML = params.title;
		this.windowTitle.style.height = params.titleHeight +'px';
	}
	
	this.configureWindowContent = function(params) {
		this.windowContent.className = 'windowContent';
		
		var contentHeight = params.height -params.titleHeight;
		this.windowContent.style.height = contentHeight +'px';
	}
	
	this.show = function() {
		new Effect.Appear(this.windowPanel);
	}

	this.hide = function() {
		this.windowPanel.style.display = 'none';
	}
	
	this.close = function() {
		new Effect.Fold(this.windowPanel);

		var maxZIndex = document.maxZIndex;
		maxZIndex--;
		document.maxZIndex = maxZIndex;
		
		var key = 'key_' +this.identifier;
		bf2.dropableWindows[key] = this;
		setTimeout('_windowDestroy(\'' +key +'\')', 2000);
	}
	
	this.getContentPanel = function() {
		return this.windowContent;
	}
	
	this.getWindowPanel = function() {
		return this.windowTitle;
	}
	
	this.configure(params);
	
	bf2.DragAndDrop.configure(this.windowTitle, this.windowPanel, 0, null, 0);
}