<?php 
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
		case 'requisitos':
			$rAtivo = 'migalha-ativa'; 
			break;
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
	<div class="<?php echo $ipAtivo; ?> migalha-align" onClick="curriculoWebUtil.avancar({modulo: 'pessoa', entidade:'informacoesPessoais'});">Pessoais</div>
	<?php if ($_SESSION["ExibirDadosCompl"] == "S" || $_SESSION["ExibirRequisitos"] == "S" ) { ?>
	<div class="seta">&nbsp;</div>
	<div class="<?php echo $iadAtivo; ?> migalha-align" onClick="curriculoWebUtil.avancar({modulo: 'informacoesAdicionais', entidade: 'informacoesAdicionais'});"><?php echo utf8_encode("Informações Adicionais"); ?></div> 
	<?php } ?>
	<?php if ($_SESSION["ExibirCursos"] == "S") { ?>
	<div class="seta">&nbsp;</div>
	<div class="<?php echo $iaAtivo; ?> migalha-align" onClick="curriculoWebUtil.avancar({modulo: 'informacaoAcademica', entidade: 'informacaoAcademica' });"><?php echo utf8_encode("Formação"); ?></div>
	<?php } ?>
	<?php if ($_SESSION["ExibirEmpAnteriores"] == "S") { ?>
	<div class="seta">&nbsp;</div>
	<div class="<?php echo $hpAtivo; ?> migalha-align" onClick="curriculoWebUtil.avancar({modulo: 'historicoProfissional', entidade: 'historicoProfissional' });"><?php echo utf8_encode("Experiência"); ?></div>
	<?php } ?>
	<?php if ($_SESSION["ExibirInteresse"] == "S") { ?>
	<div class="seta">&nbsp;</div>
	<div class="<?php echo $isAtivo; ?> migalha-align" onClick="curriculoWebUtil.avancar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais'});">Interesses</div>
	<?php } ?>
	<?php if ($_SESSION["ExibirPalavrasChave"] == "S") { ?>
	<div class="seta">&nbsp;</div>
	<div class="<?php echo $pcAtivo; ?> migalha-align" onClick="curriculoWebUtil.avancar({modulo: 'pessoaPalavraChave', entidade:'palavrasChaves'});">Palavras-chave</div>
	<?php } ?>
	<?php if ($_SESSION["ExibirIdiomas"] == "S") { ?>
	<div class="seta">&nbsp;</div>
	<div class="<?php echo $idAtivo; ?> migalha-align" onClick="curriculoWebUtil.avancar({modulo: 'pessoaIdioma', entidade:'idiomas'});">Idiomas</div>
	<?php } ?>	
</div>
<div class="clear"></div>