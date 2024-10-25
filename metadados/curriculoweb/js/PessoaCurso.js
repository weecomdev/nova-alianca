PessoaCurso = function() {

	this.lista = new Array();
	this.index = 0;	
	
	this.bf2JsonAjax = new bf2.JSONAjax();	
	this.bf2Ajax = new bf2.Ajax();	
	
	this.verificaTipoCurso = function(value) {
		if (value == "outro" || value == null) {
			jQuery("#outroCurso").show();
			jQuery("#Descricao50").val("");
			jQuery("#cursos").hide();
			
		} else {
			jQuery("#outroCurso").hide();
			jQuery("#Descricao50").val("");
			jQuery("#cursos").show();
			
		} 		
	}
	
	this.atualizaCombo = function(listaCurso,tipoCurso){		
		jQuery("#Curso option:not(option:first)").remove();

		for(var i = 0; i < listaCurso.length;i++)
		{
			if(listaCurso[i].TipoCurso == tipoCurso){
				jQuery('#Curso').append('<option value="'+listaCurso[i].Curso+'">'+listaCurso[i].Descricao50+'</option');
			}	
		}
	}
		
	this.callbackSalvar = function(response){		
		pessoaCursoUtil.atualizarDadosListagem();
		//alert(response);		
	}
	this.salvar = function(form) {
		form.acao.value = "criar";
		if (form.NroOrdem.value)
			form.acao.value = "alterar";	
		
		var ajaxSalvar1 = new bf2.Ajax();
		ajaxSalvar1.postForm(form, this.callbackSalvar);
		//salva a data de alteração da pessoa
		setTimeout(function(){
			var ajax = new bf2.Ajax();
			var param = new Array();
			param[param.length] = "modulo=pessoa";
			param[param.length] = "acao=salvar";
			ajax.post("index.php", param, function(o){
			});
		}, 20);		
		return false;			
	}
	
	this.populate = function(es) {
		var element = new PessoaCursoElement();

		element.Empresa = es.Empresa != "" ? es.Empresa : "";
		element.Pessoa = es.Pessoa != "" ? es.Pessoa : "";
		element.NroOrdem = es.NroOrdem != "" ? es.NroOrdem : "";
		
		element.Curso = es.Curso != "" ? es.Curso : "";
		element.Descricao50 = es.Descricao50 != "" ? es.Descricao50 : "";
		element.Nm_Curso = es.Nm_Curso != "" ? es.Nm_Curso : "";
		
		element.Descricao40 = es.Descricao40 != "" ? es.Descricao40 : "";
		element.Car_Horaria = es.Car_Horaria != "" ? es.Car_Horaria : "";
		element.Dt_Inicio = es.Dt_Inicio != "" ? es.Dt_Inicio : "";
		element.Dt_Encerra = es.Dt_Encerra != "" ? es.Dt_Encerra : "";
		
		element.DescTpCurso = es.DescTpCurso != ""  ? es.DescTpCurso : "Outro";
		
		return element;
	}
	
	this.limparCampos = function() {
		jQuery(".campo").each(function(i,e){
			jQuery(e).val("");
		});	
	}
	
	this.atualizarDadosListagem = function() {
		
		this.limparCampos();
		//jQuery("#botaoCancelarCurso").hide();
		//jQuery("#botaoAdicionarCurso").removeClass("botao-editar-curso");
		//jQuery("#botaoAdicionarCurso").addClass("botao-adicionar-curso");

		params = new Array();
		params[0] = 'modulo=informacaoAcademica';
		params[1] = 'acao=carregar';
		
		var l = this.bf2JsonAjax.post('index.php', params);				
		
		this.lista = new Array();
		for (var i=0; i < l.length; i++)
			this.lista[i] = this.populate(l[i]);
		
		this.buildTableList();
		//jQuery("#camposCurso").dialog('close');	
	}

    this.buildTableList = function () {
        var NomeCurso = "";
		jQuery('#tableListPessoaCurso').empty();
		
		var tableList = jQuery("#tableListPessoaCurso").get(0);
		
		if (this.lista.length == 0) {
		
			//cria a linha
			var row = tableList.insertRow(0);		
			
			var c0 = row.insertCell(0);			
			c0.align = "center";
            c0.innerHTML = "<span tabindex='0' >" + "Não existe nenhum curso cadastrado" + "</span>";

			
		} else if (this.lista && this.lista.length > 0) {
			for (var x = 0; x < this.lista.length; x++) {
				
				var element = this.lista[x];

				row = tableList.insertRow(x);

				var c0 = row.insertCell(0);
				c0.width = "100px";
                c0.innerHTML = "<span tabindex='0'>" + element.DescTpCurso + "</span>";

                if (element.Nm_Curso == "") { NomeCurso = element.Descricao50; } else { NomeCurso = element.Nm_Curso;}
				var c1 = row.insertCell(1);
				c1.width = "450px";
                c1.innerHTML = "<span tabindex='0'>" + NomeCurso+ "</span>";
				
				var c2 = row.insertCell(2);
				c2.width = "150px";
                c2.align = "center";
                c2.innerHTML = "<span tabindex='0' >" + element.Car_Horaria + "</span>";
				
				var c3 = row.insertCell(3);
				c3.width = "70px";
                c3.align = "center";
                c3.innerHTML = "<span tabindex='0' >" + element.Dt_Inicio + "</span>";
				
				var c4 = row.insertCell(4);
				c4.width = "70px";
                c4.align = "center";
                c4.innerHTML = "<span tabindex='0'>" + element.Dt_Encerra + "</span>";
				
				var tdEd = row.insertCell(5);
				tdEd.width = "30px";
				tdEd.align = "center";
				
				var editar = document.createElement('a');
				editar.href = "javascript: pessoaCursoUtil.editar(" + element.NroOrdem + ");"
				editar.innerHTML = "<img src=\"images/editar.jpg\" alt=\"Editar\" title=\"Editar\"/>";				
				
				tdEd.appendChild(editar);
				
				var tdEx = row.insertCell(6);
				tdEx.width = "30px";
				tdEx.align = "center";
				
				var excluir = document.createElement('a');
				excluir.href = "javascript: pessoaCursoUtil.remover(" + element.NroOrdem + ");"
				excluir.innerHTML = "<img src=\"images/lixeira.jpg\" alt=\"Remover\" title=\"Remover\"/>";
				
				tdEx.appendChild(excluir);
			}
		}
	}
	
	this.editar = function(NroOrdem) {

		var params = new Array();
        jQuery("#camposCurso").dialog({title: "Editar Curso"}); 
		params[0] = 'modulo=informacaoAcademica';
		params[1] = 'acao=editar';
		params[2] = "Empresa=" + jQuery("#Empresa").val();
		params[3] = "Pessoa=" + jQuery("#Pessoa").val(); 
		params[4] = "NroOrdem=" + NroOrdem;
			
		obj = this.bf2JsonAjax.post('index.php', params);
		
		jQuery("#Empresa").val(obj.Empresa);
		jQuery("#Pessoa").val(obj.Pessoa);
		jQuery("#NroOrdem").val(obj.NroOrdem);
	
		jQuery("#TipoCurso").val(obj.TipoCurso);
		jQuery("#TipoCurso").change();
		jQuery("#Curso").val(obj.Curso);		
		jQuery("#Nm_Curso").val(obj.Nm_Curso);
		
		if (obj.Curso == null) {
			jQuery("#outroCurso").show();
			jQuery("#Descricao50").val(obj.Descricao50);
			if (obj.Descricao50 != ""){
				jQuery("#TipoCurso").val("outro");			
			}
			jQuery("#cursos").hide();
		} else {
			jQuery("#outroCurso").hide();
			jQuery("#Descricao50").val("");
			jQuery("#cursos").show();
			jQuery("#TipoCurso").val(obj.TipoCurso);
		}
			
	//	jQuery("#botaoAdicionarCurso").removeClass("botao-adicionar-curso");
	//	jQuery("#botaoAdicionarCurso").addClass("botao-editar-curso");		
	//	jQuery("#botaoCancelarCurso").show();
		jQuery("#camposCurso").dialog('open');		
		
		jQuery("#Descricao40").val(obj.Descricao40);
		jQuery("#Car_Horaria").val(obj.Car_Horaria);
		jQuery("#Dt_Inicio").val(obj.Dt_Inicio);
		jQuery("#Dt_Encerra").val(obj.Dt_Encerra);
		
	}

	this.remover = function(NroOrdem) {
		
		if (confirm("Confirma a exclusão do curso?")) {
		
			var params = new Array(); 
			params[0] = 'modulo=informacaoAcademica';
			params[1] = 'acao=excluir';
			params[2] = "Empresa=" + jQuery("#Empresa").val();
			params[3] = "Pessoa=" + jQuery("#Pessoa").val(); 
			params[4] = "NroOrdem=" + NroOrdem;		
				
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
		jQuery("#camposCurso").dialog('close');		
	}
	
	
}

PessoaCursoElement = function() {	
	this.Empresa;
	this.Pessoa;
	this.NroOrdem;
	
	this.Curso;
	this.Descricao50;
	this.Nm_Curso;
	
	this.Descricao40;
	this.Car_Horario;
	this.Dt_Inicio;
	this.Dt_Encerra;	
	
	this.TipoCurso;
	this.DescTpCurso;
}


var pessoaCursoUtil = new PessoaCurso();