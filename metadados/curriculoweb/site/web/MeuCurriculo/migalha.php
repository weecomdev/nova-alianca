<?php

global $configObj;

$valorDiretrizInteresse = $configObj->getValorDiretriz('interesseProfissionalObrigatorio');

switch($_POST['entidade']) {
		case 'informacoesPessoais':
			$ipAtivo = 'migalha-ativa';
		break;
		case 'informacoesProfissionais':
			$ifAtivo = 'migalha-ativa';
		break;

		case 'informacaoAcademica':
			$iaAtivo = 'migalha-ativa';
			break;
		case 'historicoProfissional':
			$hpAtivo = 'migalha-ativa';
			break;
		case 'dadosComplementares':
			$dcAtivo = 'migalha-ativa';
			break;
//		case 'requisitos':
//			$rAtivo = 'migalha-ativa';
//			break;
		case 'interessesProfissionais':
			$isAtivo = 'migalha-ativa';
		break;
		case 'palavrasChaves':
			$pcAtivo = 'migalha-ativa';
		break;
		case 'idiomas':
			$idAtivo = 'migalha-ativa';
		break;
		case 'informacoesAdicionais';
		    $iadAtivo = 'migalha-ativa';
		break;
	}
?>

<div class="migalha">
    <div class="<?php echo $ipAtivo; ?> migalha-align" onclick="
<?php if ($_SESSION["GUIA"] == "Pessoais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
		if (jQuery('#PretensaoSalarial').length > 0) 
			curriculoWebUtil.addCampoAlterado('PretensaoSalarial', jQuery('#PretensaoSalarial').val());
        curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
        curriculoWebUtil.avancar({modulo: 'pessoa', entidade:'informacoesPessoais'}); 
	}
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "InformacoesAdicionais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) {
		dadoComplementarUtil.salvarDadosComplementares(); 
	    curriculoWebUtil.avancar({modulo: 'pessoa', entidade:'informacoesPessoais'});
    }
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "Formacao") {?>	
	curriculoWebUtil.avancar({modulo: 'pessoa', entidade:'informacoesPessoais'});
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Experiencia") {?>	
	if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) 
		curriculoWebUtil.avancar({modulo: 'pessoa', entidade:'informacoesPessoais'});
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Interesses") {?>	
	if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>))
	{
		curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});
		curriculoWebUtil.avancar({modulo: 'pessoa', entidade:'informacoesPessoais'});
	}
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "PalavrasChave") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});
	curriculoWebUtil.avancar({modulo: 'pessoa', entidade:'informacoesPessoais'});
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "Idiomas") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});
	curriculoWebUtil.avancar({modulo: 'pessoa', entidade:'informacoesPessoais'});
<?php } ?>	
    ">
        Pessoais
    </div>
	<?php if ($_SESSION["ExibirDadosCompl"] == "S" || $_SESSION["ExibirRequisitos"] == "S" ) { ?>
	<div class="seta">&nbsp;</div>		
    <div class="<?php echo $iadAtivo; ?> migalha-align" onclick="
<?php if ($_SESSION["GUIA"] == "Pessoais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
		if (jQuery('#PretensaoSalarial').length > 0) 
			curriculoWebUtil.addCampoAlterado('PretensaoSalarial', jQuery('#PretensaoSalarial').val());
        curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
        curriculoWebUtil.avancar({ modulo: 'informacoesAdicionais', entidade: 'informacoesAdicionais' }); 
	}
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "InformacoesAdicionais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) {
		dadoComplementarUtil.salvarDadosComplementares(); 
	    curriculoWebUtil.avancar({ modulo: 'informacoesAdicionais', entidade: 'informacoesAdicionais' });
    }
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "Formacao") {?>	
	curriculoWebUtil.avancar({ modulo: 'informacoesAdicionais', entidade: 'informacoesAdicionais' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Experiencia") {?>	
	if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) 
		curriculoWebUtil.avancar({ modulo: 'informacoesAdicionais', entidade: 'informacoesAdicionais' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Interesses") {?>	
	if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>))
	{
		curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});
		curriculoWebUtil.avancar({ modulo: 'informacoesAdicionais', entidade: 'informacoesAdicionais' });
	}
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "PalavrasChave") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});
	curriculoWebUtil.avancar({ modulo: 'informacoesAdicionais', entidade: 'informacoesAdicionais' });
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "Idiomas") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});
	curriculoWebUtil.avancar({ modulo: 'informacoesAdicionais', entidade: 'informacoesAdicionais' });
<?php } ?>	
    ">
        Informações Adicionais
    </div>
	<?php } ?>
	<?php if ($_SESSION["ExibirCursos"] == "S") { ?>
	<div class="seta">&nbsp;</div>
    <div class="<?php echo $iaAtivo; ?> migalha-align" onclick="
<?php if ($_SESSION["GUIA"] == "Pessoais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
		if (jQuery('#PretensaoSalarial').length > 0) 
			curriculoWebUtil.addCampoAlterado('PretensaoSalarial', jQuery('#PretensaoSalarial').val());
        curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
        curriculoWebUtil.avancar({ modulo: 'informacaoAcademica', entidade: 'informacaoAcademica' });
	}
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "InformacoesAdicionais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) {
		dadoComplementarUtil.salvarDadosComplementares(); 
	    curriculoWebUtil.avancar({ modulo: 'informacaoAcademica', entidade: 'informacaoAcademica' });
    }
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "Formacao") {?>
	curriculoWebUtil.avancar({ modulo: 'informacaoAcademica', entidade: 'informacaoAcademica' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Experiencia") {?>	
	if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) 
		curriculoWebUtil.avancar({ modulo: 'informacaoAcademica', entidade: 'informacaoAcademica' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Interesses") {?>	
	if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>))
	{
		curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});
		curriculoWebUtil.avancar({ modulo: 'informacaoAcademica', entidade: 'informacaoAcademica' });
	}
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "PalavrasChave") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});
	curriculoWebUtil.avancar({ modulo: 'informacaoAcademica', entidade: 'informacaoAcademica' });
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "Idiomas") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});
	curriculoWebUtil.avancar({ modulo: 'informacaoAcademica', entidade: 'informacaoAcademica' });
<?php } ?>	
    ">
        Formação
    </div>
	<?php } ?>
	<?php if ($_SESSION["ExibirEmpAnteriores"] == "S") { ?>
	<div class="seta">&nbsp;</div>
    <div class="<?php echo $hpAtivo; ?> migalha-align" onclick="
<?php if ($_SESSION["GUIA"] == "Pessoais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
		if (jQuery('#PretensaoSalarial').length > 0) 
			curriculoWebUtil.addCampoAlterado('PretensaoSalarial', jQuery('#PretensaoSalarial').val());
        curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
        curriculoWebUtil.avancar({ modulo: 'historicoProfissional', entidade: 'historicoProfissional' });
	}
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "InformacoesAdicionais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) { 
		dadoComplementarUtil.salvarDadosComplementares(); 
	    curriculoWebUtil.avancar({ modulo: 'historicoProfissional', entidade: 'historicoProfissional' });
    }
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "Formacao") {?>
	curriculoWebUtil.avancar({ modulo: 'historicoProfissional', entidade: 'historicoProfissional' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Experiencia") {?>	
	if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) 
		curriculoWebUtil.avancar({ modulo: 'historicoProfissional', entidade: 'historicoProfissional' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Interesses") {?>	
	if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>))
	{
		curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});
		curriculoWebUtil.avancar({ modulo: 'historicoProfissional', entidade: 'historicoProfissional' });
	}
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "PalavrasChave") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});
	curriculoWebUtil.avancar({ modulo: 'historicoProfissional', entidade: 'historicoProfissional' });
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "Idiomas") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});
	curriculoWebUtil.avancar({ modulo: 'historicoProfissional', entidade: 'historicoProfissional' });
<?php } ?>	
    ">
        Experiência
    </div>
	<?php } ?>
	<?php if ($_SESSION["ExibirInteresse"] == "S") { ?>
	<div class="seta">&nbsp;</div>
    <div class="<?php echo $isAtivo; ?> migalha-align" onclick="
<?php if ($_SESSION["GUIA"] == "Pessoais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
		if (jQuery('#PretensaoSalarial').length > 0) 
			curriculoWebUtil.addCampoAlterado('PretensaoSalarial', jQuery('#PretensaoSalarial').val());
        curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
        curriculoWebUtil.avancar({ modulo: 'pessoaAreaInteresse', entidade: 'interessesProfissionais' });
	}
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "InformacoesAdicionais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) {
		dadoComplementarUtil.salvarDadosComplementares(); 
	    curriculoWebUtil.avancar({ modulo: 'pessoaAreaInteresse', entidade: 'interessesProfissionais' });
    }
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "Formacao") {?>
	curriculoWebUtil.avancar({ modulo: 'pessoaAreaInteresse', entidade: 'interessesProfissionais' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Experiencia") {?>	
	if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) 
		curriculoWebUtil.avancar({ modulo: 'pessoaAreaInteresse', entidade: 'interessesProfissionais' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Interesses") {?>	
	if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>))
	{
		curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});
		curriculoWebUtil.avancar({ modulo: 'pessoaAreaInteresse', entidade: 'interessesProfissionais' });
	}
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "PalavrasChave") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});
	curriculoWebUtil.avancar({ modulo: 'pessoaAreaInteresse', entidade: 'interessesProfissionais' });
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "Idiomas") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});
	curriculoWebUtil.avancar({ modulo: 'pessoaAreaInteresse', entidade: 'interessesProfissionais' });
<?php } ?>	
    ">
        Interesses
    </div>
	<?php } ?>
	<?php if ($_SESSION["ExibirPalavrasChave"] == "S") { ?>
	<div class="seta">&nbsp;</div>
    <div class="<?php echo $pcAtivo; ?> migalha-align" onclick="
<?php if ($_SESSION["GUIA"] == "Pessoais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
		if (jQuery('#PretensaoSalarial').length > 0) 
			curriculoWebUtil.addCampoAlterado('PretensaoSalarial', jQuery('#PretensaoSalarial').val());
        curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
        curriculoWebUtil.avancar({ modulo: 'pessoaPalavraChave', entidade: 'palavrasChaves' });
	}
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "InformacoesAdicionais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) {
		dadoComplementarUtil.salvarDadosComplementares(); 
	    curriculoWebUtil.avancar({ modulo: 'pessoaPalavraChave', entidade: 'palavrasChaves' });
    }
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "Formacao") {?>	
	curriculoWebUtil.avancar({ modulo: 'pessoaPalavraChave', entidade: 'palavrasChaves' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Experiencia") {?>	
	if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) 
		curriculoWebUtil.avancar({ modulo: 'pessoaPalavraChave', entidade: 'palavrasChaves' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Interesses") {?>	
	if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>))
	{
		curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});
		curriculoWebUtil.avancar({ modulo: 'pessoaPalavraChave', entidade: 'palavrasChaves' });
	}
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "PalavrasChave") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});
	curriculoWebUtil.avancar({ modulo: 'pessoaPalavraChave', entidade: 'palavrasChaves' });
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "Idiomas") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});
	curriculoWebUtil.avancar({ modulo: 'pessoaPalavraChave', entidade: 'palavrasChaves' });
<?php } ?>	
    ">
        Palavras-chave
    </div>
	<?php } ?>
	<?php if ($_SESSION["ExibirIdiomas"] == "S") { ?>
	<div class="seta">&nbsp;</div>
    <div class="<?php echo $idAtivo; ?> migalha-align" onclick="
<?php if ($_SESSION["GUIA"] == "Pessoais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
		if (jQuery('#PretensaoSalarial').length > 0) 
			curriculoWebUtil.addCampoAlterado('PretensaoSalarial', jQuery('#PretensaoSalarial').val());
        curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
        curriculoWebUtil.avancar({ modulo: 'pessoaIdioma', entidade: 'idiomas' });
	}
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "InformacoesAdicionais") {?>
	if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) {
		dadoComplementarUtil.salvarDadosComplementares(); 
	    curriculoWebUtil.avancar({ modulo: 'pessoaIdioma', entidade: 'idiomas' });
    }
<?php } ?>			

<?php if ($_SESSION["GUIA"] == "Formacao") {?>
	curriculoWebUtil.avancar({ modulo: 'pessoaIdioma', entidade: 'idiomas' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Experiencia") {?>	
	if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) 
		curriculoWebUtil.avancar({ modulo: 'pessoaIdioma', entidade: 'idiomas' });
<?php } ?>		

<?php if ($_SESSION["GUIA"] == "Interesses") {?>	
	if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>))
	{
		curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});
		curriculoWebUtil.avancar({ modulo: 'pessoaIdioma', entidade: 'idiomas' });
	}
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "PalavrasChave") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});
	curriculoWebUtil.avancar({ modulo: 'pessoaIdioma', entidade: 'idiomas' });
<?php } ?>	

<?php if ($_SESSION["GUIA"] == "Idiomas") {?>	
	curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});
	curriculoWebUtil.avancar({ modulo: 'pessoaIdioma', entidade: 'idiomas' });
<?php } ?>	
    ">
        Idiomas
    </div>
	<?php } ?>
	
</div>
<div class="clear"></div>