<!-- necessário para o ie não ter problemas para interpretar scripts no início da response -->
<font size="1" style="display: none;">&nbsp;</font>
<?php $variavelObrigatorios= new CamposObrigatorios();?>
<script type="text/javascript">
	curriculoWebUtil.resetCamposAlterados();

	validacaoDadoComplementaresObr =[];
	<?php while (!$listaDadosComplementaresObr->EOF){ ?>  
		validacaoDadoComplementaresObr.push({'Nome':'<?php echo $listaDadosComplementaresObr->fields['Variavel'];?>' , 'Descricao':'<?php echo $listaDadosComplementaresObr->fields['Descricao80'];?>'});		
    <?php 
    	$variavelObrigatorios->AdicionaListaVariaveis($listaDadosComplementaresObr->fields['Variavel']);
    	$listaDadosComplementaresObr->MoveNext(); } ?>
	
</script>

<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>
		
		<div align="right"><font color="#369119" >Os campos marcados com * são de preenchimento obrigatório.</font></div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-dados-complementares">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">
						<form action="index.php" method="post" onsubmit="dadoComplementarUtil.salvarDadosComplementares(); return false;">
							<input type="hidden" name="modulo" value="dadosComplementares" />
							<input type="hidden" name="acao" value="" />

							<?php 
							
							// valor dos campos
							if ($resultDados) {
								$camposDados = $resultDados->fields;
								$camposDados2 = array();
								if ($camposDados)
									foreach ($camposDados as $chave => $valor)
										$camposDados2[strtoupper($chave)] = $valor;
							}									 
							
							while (!$result->EOF) { ?>
							
								<div class="listagem-campos">
									<div class="label-campos3"><span id="<?php echo $result->fields['Variavel']; ?>_desc"><?php echo $result->fields['Descricao80']; ?></span></div>		   						
		   							
		   							<?php 										
		   							    $campo = $result->fields['CampoTabelaFutura'];
	   									$valor = $camposDados2[$campo];
		   							
		   								if ($result->fields['TipoCampo'] == "COD") {
		   									$resultCodigo = $codigoDao->buscarCodigoComplementarPorVariavel($result->fields['Variavel'],$result->fields['TabelaDescricao'],$result->fields['CampoDescricao'] );
		   									$campoDescricao = ucfirst(strtolower($result->fields['CampoDescricao']));
		   									if (strtolower($result->fields['TabelaDescricao']) == "rhopcoescompl")
		   										$campoComparativo = "OpcaoComplementar";
		   									if (strtolower($result->fields['TabelaDescricao']) == "rhcodigoscompl")
		   										$campoComparativo = "CodigoComplementar";
		   									?><select name="<?php echo $result->fields['Variavel']; ?>" aria-label = "<?php echo $result->fields['Descricao80']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo">
		   										<option value="">Selecione...</option>
		   									<?php 
		   									$resultCodigo->MoveFirst();
		   									while (!$resultCodigo->EOF) {
		   										?><option value="<?php echo $resultCodigo->fields[$campoComparativo]; ?>" aria-label = "<?php echo $result->fields['Descricao80']; ?>"
		   											<?php if ($valor == $resultCodigo->fields[$campoComparativo]) echo "selected='selected'";?>><?php echo $resultCodigo->fields["$campoDescricao"]; ?></option>
		   										<?php $resultCodigo->MoveNext();
		   									}
		   									?></select><?php
		   									
		   								} else if ($result->fields['TipoCampo'] == "OPC") {
		   									$resultOpcao = $opcaoDao->buscarOpcaoComplementarPorVariavel($result->fields['Variavel']);
		   									
		   									while (!$resultOpcao->EOF) {
		   										?> <input name="<?php echo $result->fields['Variavel']; ?>" aria-label = "<?php echo $result->fields['Descricao80']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo" aria-label = "<?php echo $result->fields['Variavel']; ?>" type="radio" 
		   											value="<?php echo $resultOpcao->fields['OpcaoComplementar']; ?>"
		   											<?php if ($valor == $resultOpcao->fields['OpcaoComplementar']) echo "checked='checked'";?>><?php echo $resultOpcao->fields['Descricao20']; 
		   										$resultOpcao->MoveNext();
		   									}		   											   									
		   								} else if ($result->fields['TipoCampo'] == "MEM") {
		   									?><textarea name="<?php echo $result->fields['Variavel']; ?>" aria-label = "<?php echo $result->fields['Descricao80']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo" rows="3" cols="60" onkeyup="return imposeMaxLength(this, 800);"><?php echo $valor; ?></textarea><?php
		   								} else if ($result->fields['TipoCampo'] == "DAT") {
		   									?>
		   									
		   									<!-- Script da máscara -->
												<script language="javascript" type="text/javascript">
													jQuery("#<?php echo $result->fields['Variavel']; ?>").mask("99/99/9999");
												</script>		
											<!-- Fim do Script da máscara -->
		   									<input type="text" aria-label = "<?php echo $result->fields['Descricao80']; ?>" name="<?php echo $result->fields['Variavel']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo" size="10" 
		   										maxlength="10" value="<?php echo $dateUtil->formatar($valor); ?>"/>
		   										
		   								<?php
		   								} else if ($result->fields['TipoCampo'] == "TXT") {
		   									?><input type="text" aria-label = "<?php echo $result->fields['Descricao80']; ?>" name="<?php echo $result->fields['Variavel']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo" size="40" 
		   										maxlength="<?php echo $result->fields['TamanhoCampo']; ?>" value="<?php echo $valor; ?>"/><?php
		   								}
		   							?>
		   							<?php if ($variavelObrigatorios->ExisteVariavel($result->fields['Variavel'])){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("'.$result->fields["Variavel"].'").setAttribute("aria-label", "'.$result->fields["Descricao80"].' Campo Obrigatório"); </script>';}?> 
		   						</div>
							
							<?php $result->MoveNext(); } ?>
							
						</form>
						
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="clear"></div>
	
		<div class="botao-concluir" aria-label = "Concluir"  onClick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) {dadoComplementarUtil.salvarDadosComplementares();curriculoWebUtil.concluido();}"></div>
		<?php 
		// FAZER IFS DE NAVEGACAO
		$voltarModulo = "pessoa";
		$voltarEntidade = "informacoesPessoais";
		
		$avancarModulo = "";
		$avancarEntidade = "";
		if ($_SESSION["ExibirCursos"] == "S") {
			$avancarModulo = "informacaoAcademica";
			$avancarEntidade = "informacaoAcademica";
		} else if ($_SESSION["ExibirEmpAnteriores"] == "S") {
			$avancarModulo = "historicoProfissional";
			$avancarEntidade = "historicoProfissional";
		} else if ($_SESSION["ExibirInteresse"] == "S") {
			$avancarModulo = "pessoaAreaInteresse";
			$avancarEntidade = "interessesProfissionais";
		} else if ($_SESSION["ExibirPalavrasChave"] == "S") {
			$avancarModulo = "pessoaPalavraChave";
			$avancarEntidade = "palavrasChaves";
		} else if ($_SESSION["ExibirIdiomas"] == "S") {
			$avancarModulo = "pessoaIdioma";
			$avancarEntidade = "idiomas";
		} else if ($_SESSION["ExibirRequisitos"] == "S") {
			$avancarModulo = "requisitos";
			$avancarEntidade = "requisitos";
		}
		?>
		<?php 
		if ($avancarModulo != "") {
		?>
		<div class="botao-avancar" aria-label = "Avançar" onClick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) { dadoComplementarUtil.salvarDadosComplementares();curriculoWebUtil.avancar({modulo: '<?php echo $avancarModulo; ?>', entidade:'<?php echo $avancarEntidade; ?>'}); }"></div>
		<?php 
		}
		?>
		<?php 
		if ($voltarModulo != "") {
        ?>
		<div style=" float: left;"><div class="botao-voltar" aria-label = "Voltar" onClick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) { dadoComplementarUtil.salvarDadosComplementares();curriculoWebUtil.avancar({modulo: '<?php echo $voltarModulo; ?>', entidade:'<?php echo $voltarEntidade; ?>'}); }"></div></div>
		<?php 
		}
		?>
		<div class="clear"></div>
	</div>
</div>