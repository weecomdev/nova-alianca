<!-- necessário para o ie não ter problemas para interpretar scripts no iní­cio da response -->
<font size="1" style="display: none;">&nbsp;</font>

<?php 
      global $traducao; 
      global $configObj;
      $variavelObrigatorios= new CamposObrigatorios();
      $campoVisiveis = new CamposObrigatorios();
?>


<script type="text/javascript">
	empresaAnteriorUtil.atualizarDadosListagem();
	jQuery("#DataAdmissao").mask("99/99/9999");
	jQuery("#DataRescisao").mask("99/99/9999");
	jQuery("#SalarioFinal").priceFormat({
	    prefix: '',
	    centsSeparator: ',',
	    thousandsSeparator: '.'
	});

	validacaoCampos = [];
	<?php while (!$listaCamposObr->EOF){ ?>  
		validacaoCampos.push({'Nome':'<?php echo $traducao['RHEMPRESASANTERIORES'][$listaCamposObr->fields['CampoTabela']];?>' , 'Descricao':'<?php echo $listaCamposObr->fields['Descricao60'];?>'});
	<?php 
		$variavelObrigatorios->AdicionaListaVariaveis($traducao['RHEMPRESASANTERIORES'][$listaCamposObr->fields['CampoTabela']]);
		$listaCamposObr->MoveNext(); } ?>

    <?php
        while (!$listaCamposInv->EOF){ 
	    $campoVisiveis->AdicionaListaVariaveis($traducao['RHEMPRESASANTERIORES'][$listaCamposInv->fields['CampoTabela']]);
	    $listaCamposInv->MoveNext(); } 
    ?>	
	


	jQuery(document).ready(function () {
	    var dialog = jQuery("#camposExperiencia").dialog({
	        autoOpen: false,
	        width: 722,
	        modal: true,
	        closeText: 'fechar',
	        resizable: false
	        
	                    	
	    });
	//    dialog.parent().appendTo(jQuery('form:first'));       
	});


	jQuery(function() {
		var configuracoes = {
				dateFormat: 'dd/mm/yy',
		        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
		        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		        showOn: "button",
		        buttonImage: "images/calendario.jpg",
		        buttonImageOnly: true,
		        buttonText: "Calendário",	             
		    };	
		jQuery( "#DataAdmissao" ).datepicker( configuracoes );
		jQuery( "#DataRescisao" ).datepicker( configuracoes );
	
		// As modificaçÃµes no css abaixo deve ficar abaixo da chamada do datepicker para que o botão criado fique centralizado ao campo.   
		jQuery(".ui-datepicker-trigger").css("margin-bottom","-3px");
		jQuery(".ui-datepicker-trigger").css("margin-left","5px");
		
	});
		
	
</script>		

<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php';?>
		
		<div class="clear">&nbsp;</div>
		
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-historico-profissional" tabindex="0" aria-label="Experiência Profissional Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">
					
						<form id="historicoProfissionalForm" name="historicoProfissionalForm" action="index.php" method="post" style="height: 26px">
							<div class="listagem-campos">
<!-- 								<input id="botaoCancelarEmpresa" type="button" class="botao-cancelar-empresa" value="" style="display: none;" onclick="empresaAnteriorUtil.atualizarDadosListagem();"/> -->								
								<input id="botaoAdicionarEmpresa" type="button" class="botao-adicionar-empresa" aria-label = "Adicionar Nova Experiência Profissional" value="" style="margin-left: 441px; margin-top: 1px" onclick="empresaAnteriorUtil.atualizarDadosListagem(); jQuery('#camposExperiencia').dialog({title: 'Nova Experiência Profissional'});"/>
<!-- onclick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) &&  curriculoWebUtil.validarCamposExperienciaProfissional()) {empresaAnteriorUtil.salvar(jQuery('#historicoProfissionalForm').get(0))}" -->
							</div>
						</form>
						
						<div class="borda-tabela">
							<table class="informacoes-academicas" width="655px">
								<tr>
									<th width="385px">Nome da empresa</th>									
									<th width="70px">Admissão</th>
									<th width="70px">Rescisão</th>
									<th width="70px">Primeiro Emprego</th>
									<th width="70px">Atual</th>
									<th width="30px"></th>
									<th width="30px"></th>
								</tr>								
							</table>
							<table id="tableListEmpresaAnterior" class="informacoes-academicas" width="655px">
							</table>	
						</div>
						
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="clear"></div>
	    <div style=" float: right;" >
		
		<?php 
		// FAZER IFS DE NAVEGACAO
		$voltarModulo = "pessoa";
		$voltarEntidade = "informacoesPessoais";
		
		if ($_SESSION["ExibirCursos"] == "S") {
			$voltarModulo = "informacaoAcademica";
			$voltarEntidade = "informacaoAcademica";
		} else
		if ($_SESSION["ExibirDadosCompl"] == "S" || $_SESSION["ExibirRequisitos"] == "S") {
			$voltarModulo = "informacoesAdicionais";
			$voltarEntidade = "informacoesAdicionais";
		} 

		
		$avancarModulo = "";
		$avancarEntidade = "";
		if ($_SESSION["ExibirInteresse"] == "S") {
			$avancarModulo = "pessoaAreaInteresse";
			$avancarEntidade = "interessesProfissionais";
		} else 
		if ($_SESSION["ExibirPalavrasChave"] == "S") {
			$avancarModulo = "pessoaPalavraChave";
			$avancarEntidade = "palavrasChaves";
		} else 
		if ($_SESSION["ExibirIdiomas"] == "S") {
			$avancarModulo = "pessoaIdioma";
			$avancarEntidade = "idiomas";
		}
// 		} else if ($_SESSION["ExibirRequisitos"] == "S") {
// 			$avancarModulo = "requisitos";
// 			$avancarEntidade = "requisitos";
// 		}
        ?>
        <?php 
        if ($voltarModulo != "") {
        ?>
        
		<div style=" float: left;"><input class="botao-voltar" type ="Button" aria-label = "Voltar" onClick="  curriculoWebUtil.avancar({modulo: '<?php echo $voltarModulo; ?>', entidade:'<?php echo $voltarEntidade; ?>'}); "></input></div>
        
		<?php 
        }
        ?>
		<?php 
		if ($avancarModulo != "") {
        ?>	
		<input class="botao-avancar"type ="Button" aria-label = "Avançar" onClick="if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) { curriculoWebUtil.avancar({modulo: '<?php echo $avancarModulo; ?>', entidade:'<?php echo $avancarEntidade; ?>'}); }"></input>
		<?php 
		}
		?>

        <input class="botao-concluir" type ="Button" aria-label = "Concluir"  onClick="if ( empresaAnteriorUtil.verificarPrimeiroEmprego()) { curriculoWebUtil.concluido(); }"></input>
        </div>
		<div class="clear"></div>
	</div>
</div>

<div id="camposExperiencia" title="Nova ExperiêNCIA Profissional" style="font-size: 11px; font-family: Arial;">
	<div class="clear">&nbsp;</div>		
		<div align="right"><font color="#369119" >Os campos marcados com * são de preenchimento obrigatório.</font></div>		
		<div class="clear"></div>		
		<div class="div-box" style="margin-top: 7px">	
			<div class="box-middle">			
				<div class="box-top"></div>				
					<div class="box-middle-content" style="min-height: 100px;overflow: hidden;">
										
						<form id="historicoProfissionalForm2" name="historicoProfissionalForm2" action="index.php" method="post">
						
							<input type="hidden" name="modulo" value="historicoProfissional" />
							<input type="hidden" name="acao" value="" />
							
							<input type="hidden" id="NroSequencia" name="NroSequencia" value="<?php echo $NroSequencia; ?>" />
							<input type="hidden" id="primeiroEmpregoObrigatorio" value="<?php echo $configObj->getValorDiretriz('primeiroEmpregoObrigatorio'); ?>" />
							<input type="hidden" id="mensagemPrimeiroEmpregoObrigatorio" value="<?php echo $configObj->getValorDiretriz('mensagemPrimeiroEmpregoObrigatorio'); ?>" />
								
						
							<div class="listagem-campos">
								<div class="label-campos2" >Empresa:</div>
								<input type="text" id="EmpresaAnterior" name="EmpresaAnterior" aria-label = "Empresa Campo Obrigatório" class="campo" style="width: 274px" maxlength="40"/><a   class="asterisco">*</a>
								<input type="checkbox" id="PrimeiroEmprego" name="PrimeiroEmprego" aria-label = "Primeiro Emprego?"/>Primeiro Emprego?
								<input type="checkbox" id="EstaTrabalhando" name="EstaTrabalhando" aria-label = "Emprego Atual?" />Emprego Atual?
							</div>
							
							<div class="listagem-campos">
								<div class="label-campos2">Admissão:</div>
								<div style="float: left;"><input type="text" id="DataAdmissao"  aria-label = "Data de Admissao Campo Obrigatório" name="DataAdmissao" class="campo" style="width: 99px"/><a   class="asterisco">*</a></div>
								<div style="float: left; width: 120px; text-align: right; margin-right: 5px;">Rescisão:</div>
								<input type="text" id="DataRescisao" name="DataRescisao" class="campo"  aria-label = "Data de Rescisão" style="width: 99px"/>
							</div>
							
							<?php	if (!$campoVisiveis->ExisteVariavel('SalarioFinal')) { ?>
							<div class="listagem-campos">
								<div class="label-campos2">Último Salário (R$):</div>
								<input type="text" id="SalarioFinal" name="SalarioFinal" class="campo" aria-label = "Ultimo Salário"  style="width: 174px"/><?php if ($variavelObrigatorios->ExisteVariavel('SalarioFinal')){ echo '<a class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("SalarioFinal").setAttribute("aria-label", "Ultimo Salário Campo Obrigatório"); </script>';}?>
							</div>
                            <?php } ?>
							<?php	if (!$campoVisiveis->ExisteVariavel('Observacoes')) { ?>
							    <div class="listagem-campos">
								    <div class="label-campos2">Atividades / Projetos Desenvolvidos / Observações</div>
								    <textarea type="text" id="Observacoes" name="Observacoes" class="campo" aria-label = "Atividades / Projetos Desenvolvidos / Observações"  style="height: 60px; width: 380px;" onkeyup="return imposeMaxLength(this,800);"></textarea><?php if ($variavelObrigatorios->ExisteVariavel('Observacoes')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Observacoes").setAttribute("aria-label", "Atividades / Projetos Desenvolvidos / Observações Campo Obrigatório"); </script>';}?> 
							    </div>
                            <?php } ?>
						
						<div class="clear"></div>
						
						<fieldset style="padding-left: 15px; margin-bottom: 19px">
							<legend>Informe sua Experiência Profissional na Empresa</legend>
							
							<div>Área de Atuação</div>							
						
							<div class="listagem-campos">
								<select name="AreaAtuacao1" id="AreaAtuacao1" class="campo" aria-label = "Area de Atuacao 1" style="width: 237px;" onchange="empresaAnteriorUtil.verificarAreaAtuacao1(this.value)">
									<option value="">Selecione ... </option>
								<?php while (!$result->EOF) { ?>
			   						<option value="<?php echo $result->fields['AreaAtuacao']; ?>"><?php echo $result->fields['Descricao60']; ?></option>
			   					<?php $result->MoveNext(); } ?>
			   						<option value="outro">Outro</option>
								</select>
								
								<input type="text" name="Descricao401" id="Descricao401" class="campo" size="30" maxlength="40" style="display: none;" />
								
								<input type="text" name="AnosCasa1" id="AnosCasa1" class="campo" size="3" aria-label = "Anos" maxlength="2" /> Anos
								<input type="text" name="MesesCasa1" id="MesesCasa1" class="campo" aria-label = "Meses" size="3" maxlength="2" /> Meses
							</div>
							
							<div class="listagem-campos">
								<select name="AreaAtuacao2" id="AreaAtuacao2" class="campo" style="width: 237px;"aria-label = "Area de Atuacao 2" onchange="empresaAnteriorUtil.verificarAreaAtuacao2(this.value)">
									<option value="">Selecione ... </option>
								<?php $result->MoveFirst(); while (!$result->EOF) { ?>
			   						<option value="<?php echo $result->fields['AreaAtuacao']; ?>"><?php echo $result->fields['Descricao60']; ?></option>
			   					<?php $result->MoveNext(); } ?>
			   						<option value="outro">Outro</option>
								</select>
								
								<input type="text" name="Descricao402" id="Descricao402" class="campo" size="30" maxlength="40"  style="display: none;" />
								
								<input type="text" name="AnosCasa2" id="AnosCasa2" class="campo" size="3" aria-label = "Anos" maxlength="2" /> Anos
								<input type="text" name="MesesCasa2" id="MesesCasa2" class="campo" size="3"  aria-label = "Meses" maxlength="2" /> Meses
							</div>
							
							<div class="listagem-campos">
								<select name="AreaAtuacao3" id="AreaAtuacao3" class="campo" aria-label = "Area de Atuacao 3" style="width: 237px;" onchange="empresaAnteriorUtil.verificarAreaAtuacao3(this.value)">
									<option value="">Selecione ... </option>
								<?php $result->MoveFirst(); while (!$result->EOF) { ?>
			   						<option value="<?php echo $result->fields['AreaAtuacao']; ?>"><?php echo $result->fields['Descricao60']; ?></option>
			   					<?php $result->MoveNext(); } ?>
			   						<option value="outro">Outro</option>
								</select>
								
								<input type="text" name="Descricao403" id="Descricao403" class="campo" size="30" maxlength="40" style="display: none;" />
								
								<input type="text" name="AnosCasa3" id="AnosCasa3" class="campo" size="3" aria-label = "Anos" maxlength="2" /> Anos
								<input type="text" name="MesesCasa3" id="MesesCasa3" class="campo" size="3" aria-label = "Meses"  maxlength="2" /> Meses
							</div>
							
						</fieldset>
						
						<div class="listagem-campos">
<!--  							<input id="botaoCancelarEmpresa" type="button" class="botao-cancelar-empresa" value="" style="display: none;" onclick="empresaAnteriorUtil.atualizarDadosListagem();"/> -->								
<!--							<input id="botaoAdicionarEmpresa" type="button" class="botao-adicionar-empresa" value="" onclick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) &&  curriculoWebUtil.validarCamposExperienciaProfissional()) {empresaAnteriorUtil.salvar(jQuery('#historicoProfissionalForm').get(0))}"/> -->
							<div class="label-campos2">&nbsp;</div>
							<input id="CancelarCurso" type="button" aria-label = "Cancelar" class="botao-cancelar" value="" style="margin-left: 95px; margin-top: 0px" onclick="empresaAnteriorUtil.atualizarDadosListagem(); empresaAnteriorUtil.fechaTelaModal();" />
							<input id="salvaCurso" type="button" aria-label = "Salvar" class="botao-salvar" value="" style="margin-right: 245px; margin-top: 0px" onclick=" if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) &&  curriculoWebUtil.validarCamposExperienciaProfissional()) { empresaAnteriorUtil.salvar(jQuery('#historicoProfissionalForm2').get(0)); empresaAnteriorUtil.fechaTelaModal();}"/>							
						</div>
						</form>
					</div>
				</div>
		<div class="box-bottom"></div>
	</div>

</div>

<script>
	jQuery("#botaoAdicionarEmpresa").click(function(){
		jQuery("#camposExperiencia").dialog('open');
	});	
</script>


