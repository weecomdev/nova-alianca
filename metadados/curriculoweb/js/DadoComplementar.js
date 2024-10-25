DadoComplementar = function() {

	this.salvarDadosComplementares = function () { 
		jQuery('.alinhamento :input').each(function(i, e){
			curriculoWebUtil.addCampoAlterado(e.name,e.value);
		});
		curriculoWebUtil.salvar({modulo: 'informacoesAdicionais', entidade:'informacoesAdicionais', evaluateValueHidden:true});
		//salva a data de alteração da pessoa
		setTimeout(function(){
			var ajax = new bf2.Ajax();
			var param = new Array();
			param[param.length] = "modulo=pessoa";
			param[param.length] = "acao=salvar";
			ajax.post("index.php", param, function(o){
			});
		}, 20);
	}
}

var dadoComplementarUtil = new DadoComplementar();