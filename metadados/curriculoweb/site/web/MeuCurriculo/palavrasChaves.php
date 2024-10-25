<!-- necess?rio para o ie não ter problemas para interpretar scripts no in?cio da response -->
<font size="1" style="display: none;">&nbsp;</font>

<script type="text/javascript">
curriculoWebUtil.resetCamposAlterados();
var qtdPalavras = 0;

jQuery('.alinhamento :input').bind("change", function(){
	if (this.type == "checkbox"){

		qtdPalavras = jQuery('input[name="palavrasChave[]"]:checked').length; 
		
		if (this.checked) {
			if (qtdPalavras <= jQuery("#NroMaximoPlvChave").val()) {
				curriculoWebUtil.addCampoAlterado(this.name,this.value);
			} else {
				alert("Você já cadastrou o número máximo de palavras-chave!");
				this.checked = false;
			}
		} else { 
			curriculoWebUtil.deleteCampoAlterado(this.name,this.value); 
		}
 
	} else {
		if (this.name != "undefined")
		curriculoWebUtil.addCampoAlterado(this.name,this.value);
	}
});
</script>
<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>
		
		<div align="right"><font color="#369119" tabindex="0">Você pode selecionar até <?php echo $_SESSION["NroMaximoPlvChave"]; ?> palavras-chave.</font>
		<input type="hidden" id="NroMaximoPlvChave" name="NroMaximoPlvChave" value="<?php echo $_SESSION["NroMaximoPlvChave"]; ?>"/></div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-palavras-chaves" tabindex="0" aria-label="Palavras-Chave Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
						<div class="listagem-campos">
							<?php 
							while (!$listaPalavrasChave->EOF) {
								$palavraChaveChecked = false;
								if (!is_null($listaPalavrasChavePessoa)){
									$listaPalavrasChavePessoa->MoveFirst();
									while (!$listaPalavrasChavePessoa->EOF) {
										if ($listaPalavrasChave->fields['PalavraChave'] == $listaPalavrasChavePessoa->fields['PalavraChave']){
											$palavraChaveChecked = true;
										}
										$listaPalavrasChavePessoa->MoveNext();
									}
								}
							?>
		   					
							<div class="check">
							<label> 
							<input type="checkbox" name="palavrasChave[]" aria-labelledby ="<?php $listaPalavrasChave->fields['Descricao40'];?>" id="palavraChave<?php echo $listaPalavrasChave->fields['PalavraChave']; ?>" value="<?php echo $listaPalavrasChave->fields['PalavraChave']; ?>" class="campo" <?php if($palavraChaveChecked) echo "checked"; ?> />
							<?php echo $listaPalavrasChave->fields['Descricao40']; ?>
							</div>
							<?php $listaPalavrasChave->MoveNext(); 
							} ?>
						</div>
						<div class="clear"></div>
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="clear"></div>
	
		<?php 
		// FAZER IFS DE NAVEGACAO
		$voltarModulo = "pessoa";
		$voltarEntidade = "informacoesPessoais";
		
		if ($_SESSION["ExibirInteresse"] == "S") {
			$voltarModulo = "pessoaAreaInteresse";
			$voltarEntidade = "interessesProfissionais";
		} else
		if ($_SESSION["ExibirEmpAnteriores"] == "S") {
			$voltarModulo = "historicoProfissional";
			$voltarEntidade = "historicoProfissional";
		} else
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
		if ($_SESSION["ExibirIdiomas"] == "S") {
			$avancarModulo = "pessoaIdioma";
			$avancarEntidade = "idiomas";
		}
// 		} 
// 		else if ($_SESSION["ExibirRequisitos"] == "S") {
// 			$avancarModulo = "informacoesAdicionais";
// 			$avancarEntidade = "informacoesAdicionais";
// 		}
        ?>
        <div style=" float: right;" >
        <?php 
        if ($voltarModulo != "") {
        ?>
        <div style=" float: left;"><input type ="Button" class="botao-voltar" aria-label="Voltar" Onclick="curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});curriculoWebUtil.avancar({modulo: '<?php echo $voltarModulo; ?>', entidade:'<?php echo $voltarEntidade; ?>'});"></input></div>
		<?php 
                    }
        ?>
		<?php 
		if ($avancarModulo != "") {
        ?>	
		<input type ="Button" class="botao-avancar" aria-label = "Avançar"  Onclick="curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});curriculoWebUtil.avancar({modulo: '<?php echo $avancarModulo; ?>', entidade:'<?php echo $avancarEntidade; ?>'});"></input>
		<?php 
		}
        ?>
        <input type ="Button" class="botao-concluir" aria-label="Concluir" onclick="curriculoWebUtil.salvar({modulo: 'pessoaPalavraChave', entidade:'pessoaPalavraChave'});curriculoWebUtil.concluido();"></input>
        </div>
		<div class="clear"></div>
	</div>
</div>