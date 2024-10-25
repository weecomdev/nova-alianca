InfoIncompleta = function() {
	this.texto = "";
	this.divTransparente = document.createElement('div');
	this.divTransparente.className = 'waitMessage';
	this.tela = document.createElement('div');
	this.aposFecharTela=null;
	this.abreTela = function() {
		document.body.appendChild(this.divTransparente);
		this.divTransparente.style.display = '';
		this.divTransparente.style.visibility = 'visible';

		document.body.appendChild(this.tela);
		this.tela.style.display = '';
		this.tela.style.visibility = 'visible';

	};
	this.fechaTela = function() {
		document.body.removeChild(this.divTransparente);
		document.body.removeChild(this.tela);
		if(this.aposFecharTela != null){
			this.aposFecharTela();
		}
	};
	this.setAposFecharTela = function(funcao){
		this.aposFecharTela = funcao;
	};
	this.setTexto = function(pTexto) {
		this.texto = pTexto;
		this.tela.innerHTML = '<div class="infoIncompleta">'
				+ '<div class="fecharTela"><a href="javascript:infoIncompletaUtil.fechaTela()"><img src="images/btn_close.gif"></img></a></div>'
				+ '<div class="textoInfoIncompleta">' + pTexto + '</div>'
				+ '</div>';
	};
};
infoIncompletaUtil = new InfoIncompleta();