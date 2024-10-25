<!-- necessário para o ie Não ter problemas para interpretar scripts no iní­cio da response -->
<font size="1" style="display: none;">&nbsp;</font>

<script type="text/javascript">
jQuery("#PretensaoSalarial").priceFormat({
    prefix: '',
    centsSeparator: ',',
    thousandsSeparator: '.'
});
</script>

<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>
		
		<div align="right"><font color="#369119" >Os campos marcados com * são de preenchimento obrigatório.</font></div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-informacoes-profissionais">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
						<div class="listagem-campos">
							<div class="label-campos2">Está trabalhando atualmente?</div>
							<input type="radio" class="campo" size="40"/>Sim&nbsp;&nbsp;&nbsp;<input type="radio" class="campo" size="40"/>Não
						</div>
						<div class="listagem-campos">
							<div class="label-campos2">É seu primeiro emprego?</div>
							<input type="radio" class="campo" size="40"/>Sim&nbsp;&nbsp;&nbsp;<input type="radio" class="campo" size="40"/>Não
						</div>
						<div class="listagem-campos">
							<div class="label-campos2">Objetivos Profissionais:</div>
							<textarea type="text" class="campo" style="height: 60px; width: 480px;"></textarea>
						</div>
						<div class="listagem-campos">
							<div class="label-campos2">Pretensão Salarial(R$):</div>
							<input type="text" class="campo" id="PretensaoSalarial" name="PretensaoSalarial" size="27"/><a   class="asterisco">*</a>
						</div>
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="clear"></div>
	
		<div class="botao-cancelar" aria-label = "Cancelar" ></div>
		<div class="botao-concluir" aria-label = "Concluir"  ></div>
        <input class="botao-avancar" type="Button"  aria-label="Avançar" onclick="curriculoWebUtil.avancar({modulo: 'meucurriculo', entidade:'informacoesAcademicas'});"></input>
        <div style=" float: left;"><input class="botao-voltar" type="Button" aria-label="Voltar" onclick="curriculoWebUtil.avancar({modulo: 'meucurriculo', entidade:'informacoesPessoais'});"></input></div>
		
		<div class="clear"></div>
	</div>
</div>