<!-- necessário para o ie não ter problemas para interpretar scripts no iní­cio da response -->
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


    <?php while (!$listaRequisitosObr->EOF){ ?>
        validacaoDadoComplementaresObr.push({'Nome':'requisito<?php echo $listaRequisitosObr->fields['Requisito'];?>' , 'Descricao':'<?php echo $listaRequisitosObr->fields['Descricao80'];?>'});
    <?php
        $variavelObrigatorios->AdicionaListaVariaveis($listaRequisitosObr->fields['Requisito']);  
        $listaRequisitosObr->MoveNext(); } ?>		
</script>


<script type="text/javascript">
	curriculoWebUtil.resetCamposAlterados();

	jQuery('.alinhamento :input').bind("change", function(){
		if (this.type == "checkbox"){
			if (this.checked) this.value = "S";
			else this.value = "N";
		}
		curriculoWebUtil.addCampoAlterado(this.name,this.value);
	});
	jQuery('.alinhamento :input').bind("keyup", function(){
		if (this.type == "checkbox"){
			if (this.checked) this.value = "S";
			else this.value = "N";
		}
		curriculoWebUtil.addCampoAlterado(this.name,this.value);
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
		jQuery( "#DTA1" ).datepicker( configuracoes );
		jQuery( "#DTA2" ).datepicker( configuracoes );
		jQuery( "#DTA3" ).datepicker( configuracoes );
		jQuery( "#DTA4" ).datepicker( configuracoes );
		jQuery( "#DTA5" ).datepicker( configuracoes );
		jQuery( "#DTA6" ).datepicker( configuracoes );
		jQuery( "#DTA7" ).datepicker( configuracoes );
		jQuery( "#DTA8" ).datepicker( configuracoes );
		jQuery( "#DTA9" ).datepicker( configuracoes );			

		// As modificaçÃµes no css abaixo deve ficar abaixo da chamada do datepicker para que o botão criado fique centralizado ao campo.   
		jQuery(".ui-datepicker-trigger").css("margin-bottom","-3px");
		jQuery(".ui-datepicker-trigger").css("margin-left","2px");
	});
	
	
</script>




<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>
		
		<div align="right"><font color="#369119" >Os campos marcados com * são de preenchimento obrigatório.</font></div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-informacoes-adicionais" tabindex="0" aria-label="Informações Adicionais Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">
						<form action="index.php" method="post" onsubmit="dadoComplementarUtil.salvarDadosComplementares(); return false;">
							<input type="hidden" name="modulo" value="informacoesAdicionais" />
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
							
							while (!$result->EOF) { 
								if(($result->fields['Tipo'] == '1' && $_SESSION["ExibirDadosCompl"] != "S") || ($result->fields['Tipo'] == '2' && $_SESSION["ExibirRequisitos"] != "S")){
									$result->MoveNext();
									continue;
								}
								   ?>
	                             						
								<div class="listagem-campos">									
									<div class="label-campos3"><span id="<?php echo $result->fields['Variavel']; ?>_desc"><?php  echo $result->fields['Descricao80']; ?></span></div>		   						
		   								   									   								   							
		   							
		   							<?php 										
		   							    $campo = $result->fields['CampoTabelaFutura'];
	   									$valor = $camposDados2[$campo];
	   										   										   														
										
	   									
	   									$campo2 = $result->fields['Requisito'];
										$valor2="";
										$listaRequisitosPessoa->MoveFirst();
										
										
	   									while (!$listaRequisitosPessoa->EOF) {
	   										if ($listaRequisitosPessoa->fields['Requisito'] == $campo2) {
		   										if ($result->fields['TipoRequisito'] == "AV") 
		   											$valor2 = $listaRequisitosPessoa->fields['Item_Avaliacao'];
		   										if ($result->fields['TipoRequisito'] == "QT") 
		   											$valor2 = $listaRequisitosPessoa->fields['QuantidadeRequisito'];
		   										if ($result->fields['TipoRequisito'] == "TX") 
		   											$valor2 = $listaRequisitosPessoa->fields['TextoRequisito'];
	   										}
	   										$listaRequisitosPessoa->MoveNext();
	   									}
	   										   									
	   									if ($_SESSION["ExibirRequisitos"] == "S" ) {
	   										 
	   									if ($result->fields['TipoRequisito'] == "AV") {	   										
		   									$listaEscalaRequisito = $escalaRequisitoDao->buscarItensEscalaRequisitoPorPk($result->fields['Avaliacao']);
		   										?> 
		   										<select name="requisito<?php echo $result->fields['Requisito']; ?>" aria-label = "<?php echo $result->fields['Descricao80']; ?>" id="requisito<?php echo $result->fields['Requisito']; ?>" class="campo">
		   										<option value="">Selecione...</option>
			   									<?php 
			   									$listaEscalaRequisito->MoveFirst();
			   									while (!$listaEscalaRequisito->EOF) {
			   										?><option value="<?php echo $listaEscalaRequisito->fields['Item_Avaliacao']; ?>"
			   											<?php if ($listaEscalaRequisito->fields['Item_Avaliacao'] == $valor2) echo "selected='selected'";?>><?php echo $listaEscalaRequisito->fields['Descricao15']; ?></option>
			   										<?php $listaEscalaRequisito->MoveNext();
			   									}
			   									?>
			   									</select>

		   									<?php  
		   								} else if ($result->fields['TipoRequisito'] == "QT") {
		   									?>
		   									<!-- Script da máscara -->
												<script language="javascript" type="text/javascript">
													jQuery("#requisito<?php echo $result->fields['Requisito']; ?>").priceFormat({
													    prefix: '',
													    centsSeparator: ',',
													    centsPrecision: '<?php echo $result->fields['NroDecimais']; ?>',
													    thousandsSeparator: '.'
													});
												</script>		
											<!-- Fim do Script da máscara -->
		   									<input type="text" aria-label = "<?php echo $result->fields['Descricao80']; ?>" name="requisito<?php echo $result->fields['Requisito']; ?>" id="requisito<?php echo $result->fields['Requisito']; ?>" class="campo" size="10" 
		   										maxlength="10" value="<?php if($valor2 != "") echo $numberUtil->formatar($valor2, $result->fields['NroDecimais']); ?>"/>
		   										
		   										
		   								<?php
		   								} else if ($result->fields['TipoRequisito'] == "TX") {
		   									?>
		   									<input type="text" aria-label = "<?php echo $result->fields['Descricao80']; ?>" name="requisito<?php echo $result->fields['Requisito']; ?>" id="requisito<?php echo $result->fields['Requisito']; ?>" class="campo" size="40" 
		   										value="<?php echo $valor2; ?>" maxLength="40"/><?php
		   								}
		   							?>
		   							<?php if ($variavelObrigatorios->ExisteVariavel($result->fields['Requisito'])){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("requisito'.$result->fields["Requisito"].'").setAttribute("aria-label", "'.$result->fields['Descricao80'].'Campo Obrigatório"); </script>';}
	   								}?>
	   									
	   									
	   									
	   									
	   									
	   									
	   									
	   									
	   									
	   								<?php if ($_SESSION["ExibirDadosCompl"] == "S") { ?>	
		   							<?php    
		   								if ($result->fields['TipoCampo'] == "COD") {
		   									$resultCodigo = $codigoDao->buscarCodigoComplementarPorVariavel($result->fields['Variavel'],$result->fields['TabelaDescricao'],$result->fields['CampoDescricao'] );
		   									$campoDescricao = ucfirst(strtolower($result->fields['CampoDescricao']));
		   									if (strtolower($result->fields['TabelaDescricao']) == "rhopcoescompl")
		   										$campoComparativo = "OpcaoComplementar";
		   									if (strtolower($result->fields['TabelaDescricao']) == "rhcodigoscompl")
		   										$campoComparativo = "CodigoComplementar";
		   									?><select name="<?php echo $result->fields['Variavel']; ?>"  aria-label = "<?php echo $result->fields['Descricao80']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo">
		   										<option value="">Selecione...</option>
		   									<?php 
		   									$resultCodigo->MoveFirst();
		   									while (!$resultCodigo->EOF) {
		   										?><option value="<?php echo $resultCodigo->fields[$campoComparativo]; ?>"
		   											<?php if ($valor == $resultCodigo->fields[$campoComparativo]) echo "selected='selected'";?>><?php echo $resultCodigo->fields["$campoDescricao"]; ?></option>
		   										<?php $resultCodigo->MoveNext();
		   									}
		   									?></select><?php
		   									
		   								} else if ($result->fields['TipoCampo'] == "OPC") {
		   									$resultOpcao = $opcaoDao->buscarOpcaoComplementarPorVariavel($result->fields['Variavel']);
		   									
		   									while (!$resultOpcao->EOF) {
		   										?> <input name="<?php echo $result->fields['Variavel']; ?>"  aria-label = "<?php echo $result->fields['Descricao80']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo" type="radio" 
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
		   									<input type="text"  aria-label= "<?php echo $result->fields['Descricao80']; ?>" name="<?php echo $result->fields['Variavel']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo" size="10" 
		   										maxlength="10" value="<?php echo $dateUtil->formatar($valor); ?>"/>
		   										
		   								<?php
		   								} else if ($result->fields['TipoCampo'] == "TXT") {
		   									?><input type="text"  aria-label= "<?php echo $result->fields['Descricao80']; ?>" name="<?php echo $result->fields['Variavel']; ?>" id="<?php echo $result->fields['Variavel']; ?>" class="campo" size="40" 
		   										maxlength="<?php echo $result->fields['TamanhoCampo']; ?>" value="<?php echo $valor; ?>"/><?php
		   								}
	   								}	?>
		   							<?php //if ($variavelObrigatorios->ExisteVariavel($result->fields['Variavel'])){ echo '<span tabindex="0"   class="asterisco">*</span>';}?> 
		   						</div>
							
							<?php $result->MoveNext();
                            } ?>
							
						</form>
						
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
		}
// 		} else if ($_SESSION["ExibirRequisitos"] == "S") {
// 			$avancarModulo = "informacoesAdicionais";
// 			$avancarEntidade = "informacoesAdicionais";
// 		}
        ?>
        <?php 
        if ($voltarModulo != "") {
        ?>
		<div style=" float: left;"><input class="botao-voltar" type ="Button"aria-label = "Voltar" onClick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) { dadoComplementarUtil.salvarDadosComplementares();curriculoWebUtil.avancar({modulo: '<?php echo $voltarModulo; ?>', entidade:'<?php echo $voltarEntidade; ?>'}); }"></input></div>
		<?php 
        }
        ?>
		<?php 
		if ($avancarModulo != "") {
        ?>
		<input class="botao-avancar" type ="Button" aria-label = "Avançar" onClick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) { dadoComplementarUtil.salvarDadosComplementares();curriculoWebUtil.avancar({modulo: '<?php echo $avancarModulo; ?>', entidade:'<?php echo $avancarEntidade; ?>'}); }"></input>
		<?php 
		}
		?>
		
       <input class="botao-concluir" type ="Button" aria-label = "Concluir" onClick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoDadoComplementaresObr) && curriculoWebUtil.validarCamposDadosComplementar()) {dadoComplementarUtil.salvarDadosComplementares();curriculoWebUtil.concluido();}"></input>
        </div>
		<div class="clear"></div>
	</div>
</div>