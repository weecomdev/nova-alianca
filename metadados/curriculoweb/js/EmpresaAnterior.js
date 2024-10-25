EmpresaAnterior = function() {

	this.lista = new Array();
	this.index = 0;
	
	this.bf2JsonAjax = new bf2.JSONAjax();	
	this.bf2Ajax = new bf2.Ajax();
	
	this.verificarAreaAtuacao1 = function(value) {
		if (value == "outro" || value == null) {
			jQuery("#Descricao401").show();
		    jQuery("#Descricao401").val("");
		} else {
			jQuery("#Descricao401").hide();
			jQuery("#Descricao401").val("");
		} 		
	}
	
	this.verificarAreaAtuacao2 = function(value) {
		if (value == "outro" || value == null) {
			jQuery("#Descricao402").show();
			jQuery("#Descricao402").val("");
		} else {
			jQuery("#Descricao402").hide();
			jQuery("#Descricao402").val("");
		}	
		
	}
	
	this.verificarAreaAtuacao3 = function(value) {
		if (value == "outro" || value == null) {
			jQuery("#Descricao403").show();
			jQuery("#Descricao403").val("");
		} else {
			jQuery("#Descricao403").hide();
			jQuery("#Descricao403").val("");
		} 		
	}
	
	this.verificarPrimeiroEmprego = function() {			
		var tableList = jQuery("#tableListEmpresaAnterior").get(0);
			
		params = new Array();
		params[0] = 'modulo=historicoProfissional';
		params[1] = 'acao=carregar';
		params[2] = 'PrimeiroEmprego=S';
			
		var bf2JsonAPE = new bf2.JSONAjax();
		var l = bf2JsonAPE.post('index.php', params);
		var lCont = 0;

		if ("Não existe nenhuma empresa cadastrada" != tableList.textContent && "Não existe nenhuma empresa cadastrada" != tableList.innerText) {
		    if (l.length < 1 || l == "[]") {
		        if (jQuery("#primeiroEmpregoObrigatorio").val() == "S") {
		            alert(jQuery("#mensagemPrimeiroEmpregoObrigatorio").val());
		            jQuery("#primeiroEmpregoObrigatorio").focus();
		            return false;
		        }
			} else {
				if (l.length > 1) {
					for (var i=0; i < l.length; i++)
					{
                        if ($(jQuery("#tableListEmpresaAnterior tbody tr")[i]).find("td")[3].innerHTML == '<span tabindex="0">Sim</span>')
								lCont = lCont + 1;
					}
					if (lCont > 1)
					{
						alert("Você não pode ter mais de um primeiro emprego!");
						return false;
					}
				}
			}
		} else {
			return true;
		}
		return true;
	}
	this.callbackSalvar = function(response){
		empresaAnteriorUtil.atualizarDadosListagem();
		//alert(response);
	}
	this.salvar = function(form) {                              
                
		var formEnviar = form;	
		
		form.acao.value = "criar";
		if (form.NroSequencia.value)
			form.acao.value = "alterar";
		
		//jQuery("#EstaTrabalhando").val("S");
		//jQuery("#PrimeiroEmprego").val("S");
		
		if (jQuery("#EstaTrabalhando").prop("checked")){
			jQuery("#EstaTrabalhando").val("S");
		}else{
			jQuery("#EstaTrabalhando").val("N");
		}
			
		if (jQuery("#PrimeiroEmprego").prop("checked")){
			jQuery("#PrimeiroEmprego").val("S");
		}else{
			jQuery("#PrimeiroEmprego").val("N");
		}
			
		
		//jQuery("#PrimeiroEmprego").attr("checked","true");
		
		var ajaxSalvar1 = new bf2.Ajax();
		ajaxSalvar1.postForm(formEnviar, this.callbackSalvar);
		//salva a data de alteração da pessoa
		setTimeout(function(){
			var ajax = new bf2.Ajax();
			var param = new Array();
			param[param.length] = "modulo=pessoa";
			param[param.length] = "acao=salvar";
			ajax.post("index.php", param, function(o){
			});
		}, 20);
		jQuery("#NroSequencia").val("");
		return false;			
	}
	
	this.populate = function(es) {
		var element = new EmpresaAnteriorElement();

		element.Empresa = es.Empresa != null ? es.Empresa : null;
		element.Pessoa = es.Pessoa != null ? es.Pessoa : null;
		element.NroSequencia = es.NroSequencia != null ? es.NroSequencia : null;
		
		element.EmpresaAnterior = es.EmpresaAnterior != null ? es.EmpresaAnterior : null;
		element.EstaTrabalhando = es.EstaTrabalhando != null ? (es.EstaTrabalhando == "N" ? "Não" : "Sim") : null;
		element.PrimeiroEmprego = es.PrimeiroEmprego != null ? (es.PrimeiroEmprego == "N" ? "Não" : "Sim") : null;
		
		element.DataAdmissao = es.DataAdmissao != null ? es.DataAdmissao : null;
		element.DataRescisao = es.DataRescisao != null ? es.DataRescisao : null;
		element.SalarioFinal = es.SalarioFinal != null ? es.SalarioFinal : null;
		element.Observacoes = es.Observacoes != null ? es.Observacoes : null;
		
		return element;
	}
	
	this.limparCampos = function() {
		jQuery(".campo").each(function(i,e){
			jQuery(e).val("");
		});
		jQuery("#EstaTrabalhando").prop("checked",true);
		jQuery("#PrimeiroEmprego").prop("checked",true);
	}
	
	this.atualizarDadosListagem = function() {
		var bf2JsonAjaxListagem = new bf2.JSONAjax();
		this.limparCampos();
		
			//jQuery("#EstaTrabalhando").attr("checked","true");		
			//jQuery("#PrimeiroEmprego").attr("checked","true");
	
		
		jQuery("#NroSequencia").val("");
//		jQuery("#botaoCancelarEmpresa").hide();
//		jQuery("#botaoAdicionarEmpresa").removeClass("botao-editar-empresa");
//		jQuery("#botaoAdicionarEmpresa").addClass("botao-adicionar-empresa");

		params = new Array();
		params[0] = 'modulo=historicoProfissional';
		params[1] = 'acao=carregar';
		
		var l = bf2JsonAjaxListagem.post('index.php', params);				
		
		this.lista = new Array();
		for (var i=0; i < l.length; i++)
			this.lista[i] = this.populate(l[i]);
		
		this.buildTableList();
		//jQuery("#camposExperiencia").dialog('close');
	}

	this.buildTableList = function() {
		jQuery('#tableListEmpresaAnterior').empty();
		
		var tableList = jQuery("#tableListEmpresaAnterior").get(0);
		
		if (this.lista.length == 0) {
		
			//cria a linha
			var row = tableList.insertRow(0);		
			
			var c0 = row.insertCell(0);			
			c0.align = "center";
            c0.innerHTML = "<span tabindex='0' >" + "Não existe nenhuma empresa cadastrada" + "</span>";
			
		} else if (this.lista && this.lista.length > 0) {
			for (var x = 0; x < this.lista.length; x++) {
				
				var element = this.lista[x];
				
				row = tableList.insertRow(x);

				var c1 = row.insertCell(0);
				c1.width = "385px"
                c1.innerHTML = "<span tabindex='0' >"+element.EmpresaAnterior+"</span>";
				
				var c2 = row.insertCell(1);
				c2.width = "70px";
				c2.align = "center";
                c2.innerHTML = "<span tabindex='0' >" + element.DataAdmissao + "</span>";
				
				var c3 = row.insertCell(2);
				c3.width = "70px";
				c3.align = "center";
                c3.innerHTML = "<span tabindex='0'>" + element.DataRescisao + "</span>";
				
				var c5 = row.insertCell(3);
				c5.width = "70px";
				c5.align = "center";
                c5.innerHTML = "<span tabindex='0'>" + element.PrimeiroEmprego + "</span>";
				
				var c4 = row.insertCell(4);
				c4.width = "70px";
				c4.align = "center";
                c4.innerHTML = "<span tabindex='0'>" + element.EstaTrabalhando + "</span>";
				
				var tdEd = row.insertCell(5);
				tdEd.width = "30px";
				tdEd.align = "center";
				
				var editar = document.createElement('a');
				editar.href = "javascript: empresaAnteriorUtil.editar(" + element.NroSequencia + ");"
				editar.innerHTML = "<img src=\"images/editar.jpg\" alt=\"Editar\" title=\"Editar\"/>";
				
				tdEd.appendChild(editar);
				
				var tdEx = row.insertCell(6);
				tdEx.width = "30px";
				tdEx.align = "center";
				
				var excluir = document.createElement('a');
				excluir.href = "javascript: empresaAnteriorUtil.remover(" + element.NroSequencia + ");"
				excluir.innerHTML = "<img src=\"images/lixeira.jpg\" alt=\"Remover\" title=\"Remover\"/>";
				
				tdEx.appendChild(excluir);
			}
		}
	}
	
	this.editar = function(NroSequencia) {

		var params = new Array();
		
		jQuery('#camposExperiencia').dialog({title: 'Editar Experiência Profissional'});
				
		params[0] = 'modulo=historicoProfissional';
		params[1] = 'acao=editar';
		params[2] = "NroSequencia=" + NroSequencia;
			
		obj = this.bf2JsonAjax.post('index.php', params);
		jQuery("#Empresa").val(obj.Empresa);
		jQuery("#Pessoa").val(obj.Pessoa);
		jQuery("#NroSequencia").val(obj.NroSequencia);
		
		jQuery("#EmpresaAnterior").val(obj.EmpresaAnterior);
		
			
		//jQuery("#EstaTrabalhando").val("S");
		if (obj.EstaTrabalhando == "S")
			jQuery("#EstaTrabalhando").prop("checked",true);
		else
			jQuery("#EstaTrabalhando").prop("checked",false);
		
		//jQuery("#PrimeiroEmprego").val("S");
		if (obj.PrimeiroEmprego == "S")
			jQuery("#PrimeiroEmprego").prop("checked",true);
		else
			jQuery("#PrimeiroEmprego").prop("checked",false);
		
		jQuery("#DataAdmissao").val(obj.DataAdmissao);
		jQuery("#DataRescisao").val(obj.DataRescisao);
		jQuery("#SalarioFinal").val(obj.SalarioFinal);
		jQuery("#Observacoes").val(obj.Observacoes);
//		jQuery("#botaoAdicionarEmpresa").removeClass("botao-adicionar-empresa");
//		jQuery("#botaoAdicionarEmpresa").addClass("botao-editar-empresa");		
//		jQuery("#botaoCancelarEmpresa").show();
		for (var i = 1; i <= 3; i++) {
		
			var params = new Array(); 
			params[0] = 'modulo=historicoProfissional';
			params[1] = 'acao=editarExperiencias';
			params[2] = "NroSequencia=" + NroSequencia;
			params[3] = "NroOrdem=" + i;

			obj = this.bf2JsonAjax.post('index.php', params);
			
			jQuery("#AreaAtuacao"+i).val("");
			if (obj.AreaAtuacao != null && obj.Descricao40 != null){
				eval("this.verificarAreaAtuacao"+i+"('"+obj.AreaAtuacao+"')");
			}
			if (obj.AreaAtuacao == null && (obj.Descricao40 != null && obj.Descricao40 != '')){
				eval("this.verificarAreaAtuacao"+i+"('"+obj.AreaAtuacao+"')");
				jQuery("#AreaAtuacao"+i).val("outro");
			}
			if (obj.AreaAtuacao != null && obj.Descricao40 == ""){
				jQuery("#AreaAtuacao"+i).val(obj.AreaAtuacao);
			}
				
			if ((jQuery("#AreaAtuacao"+i).val() == "outro"))
			{
				jQuery("#Descricao40"+i).show();
			}
			
			jQuery("#Descricao40"+i).val(obj.Descricao40);
			if (obj.AnosCasa == null) jQuery("#AnosCasa"+i).val("");
			else jQuery("#AnosCasa"+i).val(obj.AnosCasa);
			if (obj.MesesCasa == null) jQuery("#MesesCasa"+i).val(""); 
			else jQuery("#MesesCasa"+i).val(obj.MesesCasa);
		}
		
		jQuery("#camposExperiencia").dialog('open');
		
	}

	this.remover = function(NroSequencia) {
		
		if (confirm("Confirma a exclusão da empresa?")) {
		
			var params = new Array(); 
			params[0] = 'modulo=historicoProfissional';
			params[1] = 'acao=excluir';
			params[2] = "Empresa=" + jQuery("#Empresa").val();
			params[3] = "Pessoa=" + jQuery("#Pessoa").val(); 
			params[4] = "NroSequencia=" + NroSequencia;
				
			obj = this.bf2JsonAjax.post('index.php', params);
			
			if (obj.status == "true"){
				var param = new Array();
				param[param.length] = "modulo=pessoa";
				param[param.length] = "acao=salvar";
				this.bf2Ajax.post("index.php", param, function(o){
				});
				
				this.atualizarDadosListagem();
			} else {
				alert(obj);
			}			
		}
	}
	
	this.fechaTelaModal = function(){
		jQuery("#camposExperiencia").dialog('close');
	}
}

EmpresaAnteriorElement = function() {
	this.Empresa;
	this.Pessoa;
	this.NroSequencia;
	
	this.EmpresaAnterior;
	this.EstaTrabalhando;
	this.PrimeiroEmprego;
	
	this.DataAdminissao;
	this.DataRescisao;
	this.SalarioFinal;
	this.Observacoes;
	
}


var empresaAnteriorUtil = new EmpresaAnterior();