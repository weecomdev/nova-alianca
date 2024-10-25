    VagaHome = function() {

	this.camposAlterados = new Array();
	this.lista = new Array();
	this.index = 0;
	
	this.bf2JsonAjax = new bf2.JSONAjax();	
	this.bf2Ajax = new bf2.Ajax();

	this.pesquisar = function(form, callback) {
		var param = new Array();
		
		jQuery(".campo").each(function(){
			if (this.value != ""){
				param[param.length] = this.name +"="+ this.value;
			}
		});
		
		param[param.length] = 'modulo=vagas';
		param[param.length] = 'acao=pesquisar';
		param[param.length] = 'local=home';
		var l = this.bf2JsonAjax.post('index.php', param);				
		
		this.lista = new Array();
		for (var i=0; i < l.length; i++)
			this.lista[i] = this.populate(l[i]);
		
		this.buildTableList();

		return false;			
	}

	this.pesquisarEntradaConsulta = function(form, callback) {
	    var param = new Array();
		
	    jQuery(".campo").each(function(){
	        if (this.value != ""){
	            param[param.length] = this.name +"="+ this.value;
	        }
	    });
		
	    param[param.length] = 'modulo=vagasConsulta';
	    param[param.length] = 'acao=pesquisar';
	    param[param.length] = 'local=home';
	    var l = this.bf2JsonAjax.post('index.php', param);				
		
	    this.lista = new Array();
	    for (var i=0; i < l.length; i++)
	        this.lista[i] = this.populate(l[i]);
		
	    this.buildTableListConsulta();

	    return false;			
	}
	
	this.buscarVagasConcorridas = function(form, callback) {
		var param = new Array();

		jQuery(".campo").each(function(){
			if (this.value != ""){
				param[param.length] = this.name +"="+ this.value;
			}
		});
		
		param[param.length] = 'modulo=vagas';
		param[param.length] = 'acao=buscarVagasConcorridas';
		
		var l = this.bf2JsonAjax.post('index.php', param);				
		
		this.lista = new Array();
		for (var i=0; i < l.length; i++)
			this.lista[i] = this.populate(l[i]);
		
		this.buildTableListConcorrida();

		return false;			
	}

	
	this.populate = function(es) {
		var element = new VagaHomeElement();

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
		element.VinculoEmpregaticio = es.VinculoEmpregaticio != null ? es.VinculoEmpregaticio : null;
		element.NomeVinculoEmpregaticio = es.NomeVinculoEmpregaticio != null ? es.NomeVinculoEmpregaticio : null;
		
		return element;
	}
	
	this.limparCampos = function() {
		jQuery(".campo").each(function(i,e){
			jQuery(e).val("");
		});	
	}


	this.buildTableList = function(){
        jQuery('#tableListVaga').empty();
        var tabela = document.getElementById("tableListVaga");
        var tableList = jQuery("#tableListVaga").get(0);

		if (this.lista.length == 0) {
			//cria a linha
			var row = tableList.insertRow(0);		
			
			var c0 = row.insertCell(0);			
            c0.align = "center";
            c0.innerHTML = "<span TabIndex='0'>Não existe nenhuma vaga disponível</span>";
		} else if (this.lista && this.lista.length > 0) {
            row = tableList.insertRow(0);

            var header = tabela.createTHead();
            var row = header.insertRow(0);

            row.insertCell(0).outerHTML = "<th>Função/Cargo</th>"
            row.insertCell(1).outerHTML = "<th>Vagas</th>"
			
			for (var x = 0; x < this.lista.length; x++) {
                var element = this.lista[x];

                row = tabela.insertRow(x+1);

				var c2 = row.insertCell(0);
				c2.width = "300px";
				c2.align = "center";
                var editar = document.createElement('a');
				editar.href = "javascript: vagaHomeUtil.detalharVaga({Requisicao: '" + element.Requisicao + "', CandidatoInscrito: 'N'});"
				editar.innerHTML = element.NomeFuncao != "" ? element.NomeFuncao : element.NomeCargo;

				c2.appendChild(editar);
				
				var c4 = row.insertCell(1);
				c4.width = "30px";
				c4.align = "center";
                c4.innerHTML = "<span TabIndex ='0'>" + element.QuantidadeVagas + "</span>";

                

			}
		}
	}

	this.buildTableListConsulta = function (){
            jQuery('#tableListVaga').empty();
		
	    var tableList = jQuery("#tableListVaga").get(0);
	    if (this.lista.length == 0) {
	        //cria a linha
	        var row = tableList.insertRow(0);		
			
	        var c0 = row.insertCell(0);			
	        c0.align = "center";
            c0.innerHTML = "<span TabIndex='0'>Não existe nenhuma vaga disponível</a>";
	    } else if (this.lista && this.lista.length > 0) {
	        row = tableList.insertRow(0);			
			
	        for (var x = 0; x < this.lista.length; x++) {
	            var element = this.lista[x];
	            row = tableList.insertRow(x+1);

	            var c2 = row.insertCell(0);
	            c2.width = "300px";
	            c2.align = "center";
                var editar = document.createElement('a');
	            editar.href = "javascript: vagaHomeUtil.detalharVagaConsulta({Requisicao: '" + element.Requisicao + "'});"
	            editar.innerHTML = element.NomeFuncao != "" ? element.NomeFuncao : element.NomeCargo;

	            c2.appendChild(editar);
				
	            var c4 = row.insertCell(1);
	            c4.width = "30px";
	            c4.align = "center";
                c4.innerHTML = "<span TabIndex ='0'>" + element.QuantidadeVagas + "</label>";
	        }
	    }
	}
	
	this.buildTableListConcorrida = function() {
		jQuery('#tableListVagaConcorrida').empty();
		
		var tableList = jQuery("#tableListVagaConcorrida").get(0);
		if (this.lista.length == 0) {
			//cria a linha
			var row = tableList.insertRow(0);		
			
			var c0 = row.insertCell(0);			
            c0.align = "center"; 
            c0.tabindex = 0;
            c0.innerHTML = "<span TabIndex='0'>Você não está concorrendo a nenhuma vaga.</span>";
		} else if (this.lista && this.lista.length > 0) {
			row = tableList.insertRow(0);
			
            th = document.createElement('th');
			th.innerHTML = "Função/Cargo";
			th.align = "center";
			row.appendChild(th);

			th = document.createElement('th');
			th.innerHTML = "Vagas";
			th.align = "center";
			row.appendChild(th);
			
			for (var x = 0; x < this.lista.length; x++) {
				var element = this.lista[x];
				row = tableList.insertRow(x+1);

				var c2 = row.insertCell(0);
				c2.width = "300px";
				c2.align = "center";
                var editar = document.createElement('a');
				editar.href = "javascript: vagaHomeUtil.detalharVaga({Requisicao: '" + element.Requisicao + "'});"
				editar.innerHTML = element.NomeFuncao != "" ? element.NomeFuncao : element.NomeCargo;
				c2.appendChild(editar);
				
				var c4 = row.insertCell(1);
				c4.width = "30px";
				c4.align = "center";
                c4.innerHTML = "<span TabIndex ='0' '>" + element.QuantidadeVagas + "</span>";
			}
		}
	}

	
	this.detalharVaga = function (options) {
		var ajax = new bf2.Ajax();
		
		var param = new Array();
		param[param.length] = "modulo=vagas";
		param[param.length] = "acao=detalharVaga";
		param[param.length] = "Requisicao=" + options.Requisicao;
		param[param.length] = "CandidatoInscrito=" + options.CandidatoInscrito;
		
		var h = ajax.post("index.php", param);
		
		bf2.Util.element('mainPanel').innerHTML = h;
		bf2.Util.evalScripts('mainPanel');
	}	

	this.detalharVagaConsulta = function (options) {
	    var ajax = new bf2.Ajax();
		
	    var param = new Array();
	    param[param.length] = "modulo=vagasConsulta";
	    param[param.length] = "acao=detalharVagaConsulta";
	    param[param.length] = "Requisicao="+options.Requisicao;
		
	    var h = ajax.post("index.php", param);
		
	    bf2.Util.element('mainPanel').innerHTML = h;
	    bf2.Util.evalScripts('mainPanel');
	}	
}

VagaHomeElement = function() {	
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
	this.VinculoEmpregaticio;
	this.NomeVinculoEmpregaticio;
}


var vagaHomeUtil = new VagaHome();