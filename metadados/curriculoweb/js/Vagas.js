Vaga = function() {

	
	this.camposAlterados = new Array();
	this.lista = new Array();
	this.index = 0;
	
	this.bf2JsonAjax = new bf2.JSONAjax();	
	this.bf2Ajax = new bf2.Ajax();

	this.pesquisar = function(form, callback) {
		var param = new Array();
				
		jQuery(".campo").each(function(){	
			if (this.type == "checkbox" ) {
				if (this.checked) {	
					param[param.length] = this.name +"="+ this.value;
				}
		    }
			else if (this.value != "")  {
				param[param.length] = this.name +"="+ this.value;
			}
		});
		
		param[param.length] = 'modulo=vagas';
		param[param.length] = 'acao=pesquisar';
		
		this.bf2JsonAjax.post('index.php', param, function(l){
			
			vagaUtil.lista = new Array();
			for (var i=0; i < l.length; i++)
				vagaUtil.lista[i] = vagaUtil.populate(l[i]);
			
			vagaUtil.buildTableList();
			
		});				

		return false;			
	}
	
	this.populate = function(es) {
		var element = new VagaElement();

		element.Empresa = es.Empresa != null ? es.Empresa : null;
		element.Requisicao = es.Requisicao != null ? es.Requisicao : null;
		element.DataRequisicao = es.DataRequisicao != null ? es.DataRequisicao : null;
		
		element.SituacaoRequisicao = es.SituacaoRequisicao != null ? es.SituacaoRequisicao : null;
		element.QuantidadeVagas = es.QuantidadeVagas != null ? es.QuantidadeVagas : null;
		
		element.SalarioMaximo = es.SalarioMaximo != null ? es.SalarioMaximo : null;
		element.Funcao = es.Funcao != null ? es.Funcao : null;
		element.NomeFuncao = es.NomeFuncao != null ? es.NomeFuncao : null;
		element.Cargo = es.Cargo != null ? es.Cargo : null;
		element.NomeCargo = es.NomeCargo != null ? es.NomeCargo : null;
		element.AreaAtuacao = es.AreaAtuacao != null ? es.AreaAtuacao : null;		
		element.NomeAreaAtuacao = es.NomeAreaAtuacao != null ? es.NomeAreaAtuacao : null;
		element.Regiao = es.Regiao != null ? es.Regiao : null;		
		element.NomeRegiao = es.NomeRegiao != null ? es.NomeRegiao : null;		
		element.VinculoEmpregaticio = es.VinculoEmpregaticio != null ? es.VinculoEmpregaticio : null;
		element.NomeVinculoEmpregaticio = es.NomeVinculoEmpregaticio != null ? es.NomeVinculoEmpregaticio : null;
		
		return element;
	}
	
	this.limparCampos = function() {
		jQuery(".campo").each(function(i,e){
			jQuery(e).val("");
		});	
	}


	this.buildTableList = function() {
		jQuery('#tableListVaga').empty();
		
		var tableList = jQuery("#tableListVaga").get(0);
		if (this.lista.length == 0) {
			//cria a linha
			var row = tableList.insertRow(0);		
			
			var c0 = row.insertCell(0);			
			c0.align = "center";
            c0.innerHTML = "<span TabIndex='0'>Não existe nenhuma vaga disponível.</span>";
		} else if (this.lista && this.lista.length > 0) {
			row = tableList.insertRow(0);
			th = document.createElement('th');
			th.innerHTML = "Data";
			th.align = "center";
			row.appendChild(th);
			
			th = document.createElement('th');
			th.innerHTML = "Função";
			th.align = "center";
			row.appendChild(th);

			th = document.createElement('th');
			th.innerHTML = "Cargo";
			th.align = "center";
			row.appendChild(th);

			th = document.createElement('th');
			th.innerHTML = "Qtd. Vagas";
			th.align = "center";
			row.appendChild(th);
			
			th = document.createElement('th');
			th.innerHTML = "";
			th.align = "center";
			row.appendChild(th);
		
			for (var x = 0; x < this.lista.length; x++) {
				var element = this.lista[x];
				row = tableList.insertRow(x+1);

				var c1 = row.insertCell(0);
                c1.width = "60px";
                c1.Tabindex = 0;
                c1.innerHTML = "<span TabIndex ='0'>" + element.DataRequisicao + "</span>";
				
				var editar1 = document.createElement('a');
				editar1.href = "javascript: vagaUtil.detalharVaga({Requisicao: '" + element.Requisicao + "'});"
				editar1.innerHTML = element.NomeFuncao;
				
				var c2 = row.insertCell(1);
				c2.width = "200px";
				c2.align = "center";
				c2.appendChild(editar1);				
				
				var editar2 = document.createElement('a');
				editar2.href = "javascript: vagaUtil.detalharVaga({Requisicao: '" + element.Requisicao + "'});"
				editar2.innerHTML = element.NomeCargo;
				
				var c3 = row.insertCell(2);
				c3.width = "200px";
				c3.align = "center";
				c3.appendChild(editar2);
				
				var c4 = row.insertCell(3);
				c4.width = "60px";
				c4.align = "center";
                c4.innerHTML = "<span TabIndex ='0'>" + element.QuantidadeVagas + "</span>";
				
				var tdEd = row.insertCell(4);
				tdEd.width = "30px";
				tdEd.align = "center";
				
				var editar = document.createElement('a');
				editar.href = "javascript: vagaUtil.detalharVaga({Requisicao: '" + element.Requisicao + "'});"
				editar.innerHTML = "<img src=\"images/visualizar.jpg\" alt=\"Visualizar\" title=\"Visualizar\"/>";
				
				tdEd.appendChild(editar);
			}
		}
	}
	
	this.detalharVaga = function(options) {
		var ajax = new bf2.Ajax();
		
		var param = new Array();
		param[param.length] = "modulo=vagas";
		param[param.length] = "acao=detalharVaga";
		param[param.length] = "Requisicao="+options.Requisicao;
		
		var h = ajax.post("index.php", param);
		
		bf2.Util.element('mainPanel').innerHTML = h;
		bf2.Util.evalScripts('mainPanel');
	}	
}

VagaElement = function() {	
	this.Empresa;
	this.Requisicao;
	this.DataRequisicao;
	
	this.SituacaoRequisicao;
	this.QuantidadeVagas;
	
	this.SalarioMaximo;
	this.Funcao;
	this.NomeFuncao
	this.Cargo;
	this.NomeCargo;
	this.AreaAtuacao;	
	this.NomeAreaAtuacao;
	this.Regiao;
	this.NomeRegiao;
	this.VinculoEmpregaticio;
	this.NomeVinculoEmpregaticio;
}


var vagaUtil = new Vaga();