<!-- necess?rio para o ie não ter problemas para interpretar scripts no in?cio da response -->
<font size="1" style="display: none;">&nbsp;</font>
<?php $variavelObrigatorios= new CamposObrigatorios();?>
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
   //validar o requisitos obrigatorios 
	validacaoRequisitoObr =[];
	<?php while (!$listaRequisitosObr->EOF){ ?>
 		validacaoRequisitoObr.push({'Nome':'requisito<?php echo $listaRequisitosObr->fields['Requisito'];?>' , 'Descricao':'<?php echo $listaRequisitosObr->fields['Descricao80'];?>'});
    <?php
        $variavelObrigatorios->AdicionaListaVariaveis($listaRequisitosObr->fields['Requisito']);  
        $listaRequisitosObr->MoveNext(); } ?>	
</script>

<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>
		
		<div align="right"><font color="#369119" >Os campos marcados com * são de preenchimento obrigatório.</font></div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-requisitos">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">
						<form action="index.php" method="post" onsubmit="curriculoWebUtil.salvar({modulo: 'requisitos', entidade:'requisitos', evaluateValueHidden:true});return false;">
							
							<?php while (!$listaRequisitos->EOF) { ?>
								<div class="listagem-campos">
									<div class="label-campos3"><?php echo $listaRequisitos->fields['Descricao80']; ?></div>		   						
		   							<?php 
										$campo = $listaRequisitos->fields['Requisito'];
										$valor="";
										$listaRequisitosPessoa->MoveFirst();
	   									while (!$listaRequisitosPessoa->EOF) {
	   										if ($listaRequisitosPessoa->fields['Requisito'] == $campo) {
		   										if ($listaRequisitos->fields['TipoRequisito'] == "AV") 
		   											$valor = $listaRequisitosPessoa->fields['Item_Avaliacao'];
		   										if ($listaRequisitos->fields['TipoRequisito'] == "QT") 
		   											$valor = $listaRequisitosPessoa->fields['QuantidadeRequisito'];
		   										if ($listaRequisitos->fields['TipoRequisito'] == "TX") 
		   											$valor = $listaRequisitosPessoa->fields['TextoRequisito'];
	   										}
	   										$listaRequisitosPessoa->MoveNext();
	   									}
	   								
		   								if ($listaRequisitos->fields['TipoRequisito'] == "AV") {
		   									$listaEscalaRequisito = $escalaRequisitoDao->buscarItensEscalaRequisitoPorPk($listaRequisitos->fields['Avaliacao']);
		   										?> 
		   										<select name="requisito<?php echo $listaRequisitos->fields['Requisito']; ?>" id="requisito<?php echo $listaRequisitos->fields['Requisito']; ?>" class="campo">
		   										<option value="">Selecione...</option>
			   									<?php 
			   									$listaEscalaRequisito->MoveFirst();
			   									while (!$listaEscalaRequisito->EOF) {
			   										?><option value="<?php echo $listaEscalaRequisito->fields['Item_Avaliacao']; ?>"
			   											<?php if ($listaEscalaRequisito->fields['Item_Avaliacao'] == $valor) echo "selected='selected'";?>><?php echo $listaEscalaRequisito->fields['Descricao15']; ?></option>
			   										<?php $listaEscalaRequisito->MoveNext();
			   									}
			   									?>
			   									</select>

		   									<?php  
		   								} else if ($listaRequisitos->fields['TipoRequisito'] == "QT") {
		   									?>
		   									<!-- Script da máscara -->
												<script language="javascript" type="text/javascript">
													jQuery("#requisito<?php echo $listaRequisitos->fields['Requisito']; ?>").priceFormat({
													    prefix: '',
													    centsSeparator: ',',
													    centsPrecision: '<?php echo $listaRequisitos->fields['NroDecimais']; ?>',
													    thousandsSeparator: '.'
													});
												</script>		
											<!-- Fim do Script da máscara -->
		   									<input type="text" name="requisito<?php echo $listaRequisitos->fields['Requisito']; ?>" id="requisito<?php echo $listaRequisitos->fields['Requisito']; ?>" class="campo" size="10" 
		   										maxlength="10" value="<?php if($valor != "") echo $numberUtil->formatar($valor, $listaRequisitos->fields['NroDecimais']); ?>"/>
		   										
		   										
		   								<?php
		   								} else if ($listaRequisitos->fields['TipoRequisito'] == "TX") {
		   									?>
		   									<input type="text" name="requisito<?php echo $listaRequisitos->fields['Requisito']; ?>" id="requisito<?php echo $listaRequisitos->fields['Requisito']; ?>" class="campo" size="40" 
		   										value="<?php echo $valor; ?>"/><?php
		   								}
		   							?>
		   							<?php if ($variavelObrigatorios->ExisteVariavel($listaRequisitos->fields['Requisito'])){ echo '<a   class="asterisco">*</a>';}?>
		   						</div>
							
							<?php $listaRequisitos->MoveNext();
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
		
		if ($_SESSION["ExibirDadosCompl"] == "S") {
			$voltarModulo = "dadosComplementares";
			$voltarEntidade = "dadosComplementares";
		} 
		if ($_SESSION["ExibirCursos"] == "S") {
			$voltarModulo = "informacaoAcademica";
			$voltarEntidade = "informacaoAcademica";
		}  
		if ($_SESSION["ExibirEmpAnteriores"] == "S") {
			$voltarModulo = "historicoProfissional";
			$voltarEntidade = "historicoProfissional";
		} 
		if ($_SESSION["ExibirInteresse"] == "S") {
			$voltarModulo = "pessoaAreaInteresse";
			$voltarEntidade = "interessesProfissionais";
		} 
		if ($_SESSION["ExibirPalavrasChave"] == "S") {
			$voltarModulo = "pessoaPalavraChave";
			$voltarEntidade = "palavrasChaves";
		} 
		if ($_SESSION["ExibirIdiomas"] == "S") {
			$voltarModulo = "pessoaIdioma";
			$voltarEntidade = "idiomas";
		}  
		?>
		<?php 
		if ($voltarModulo != "") {
        ?>		
		<div style=" float: left;"><input class="botao-voltar" aria-label = "Voltar" onClick=" if (curriculoWebUtil.validarCamposObrigatorios(validacaoRequisitoObr)) { curriculoWebUtil.salvar({modulo: 'requisitos', entidade:'requisitos', evaluateValueHidden:true});curriculoWebUtil.avancar({modulo: '<?php echo $voltarModulo; ?>', entidade:'<?php echo $voltarEntidade; ?>'}); }"></input></div>
		<?php 
		}
        ?>
        <input class="botao-concluir" aria-label = "Concluir" onClick=" if (curriculoWebUtil.validarCamposObrigatorios(validacaoRequisitoObr)) {curriculoWebUtil.salvar({modulo: 'requisitos', entidade:'requisitos', evaluateValueHidden:true});curriculoWebUtil.concluido(); } "></input>
        </div>
		<div class="clear"></div>
	</div>
</div>