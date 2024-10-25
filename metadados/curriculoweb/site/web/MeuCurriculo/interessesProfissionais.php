<!-- necess?rio para o ie não ter problemas para interpretar scripts no in?cio da response -->
<font size="1" style="display: none;">&nbsp;</font>

<?php
   global $configObj;
   $valorDiretrizInteresse = $configObj->getValorDiretriz('interesseProfissionalObrigatorio');  
  
?>

	
<script type="text/javascript">
curriculoWebUtil.resetCamposAlterados();
var qtdInteresses = 0;

jQuery('.alinhamento :input').bind("change", function(){
	if (this.type == "checkbox"){
	
//  Comando usado para carregar todos as caixas marcadas fora da pagina, ou seja, acaba carregando todas as caixas 
//que estao marcadas antes desta pagina somando com as caixas marcadas na propria pagina, assim ocasionando inconsistencia.
// 	    jQuery('input[type=checkbox]:checked').each( function() {
// 			qtdPalavras = qtdPalavras+1;
// 		}); 
		  
    	
    	// Comando para carregar as caixas marcadas na propria página.
    	qtdInteresses = jQuery('input[name="areasInteresse[]"]:checked').length;

        if (this.checked) {												
			if (qtdInteresses <= jQuery("#NroMaximoInteresses").val()) {
				curriculoWebUtil.addCampoAlterado(this.name,this.value);
			} else {
				alert("Você já cadastrou o número máximo de interesses!");
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
		
		<div align="right"><font color="#369119" tabindex="0">Você pode selecionar até <?php echo $_SESSION["NroMaximoInteresses"]; ?> interesses profissionais.</font>
		<input type="hidden" id="NroMaximoInteresses" name="NroMaximoInteresses" value="<?php echo $_SESSION["NroMaximoInteresses"]; ?>"/></div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-interesses-profissionais" tabindex="0" aria-label="Interesses Profissionais Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
						<div class="listagem-campos" id="listagem-campos">
							<?php 
							while (!$listaAreaAtuacao->EOF) {
								$areaAtuacaoChecked = false;
								if (!is_null($listaAreaInteressePessoa)){
									$listaAreaInteressePessoa->MoveFirst();
									while (!$listaAreaInteressePessoa->EOF) {
										if ($listaAreaAtuacao->fields['AreaAtuacao'] == $listaAreaInteressePessoa->fields['AreaAtuacao']){
											$areaAtuacaoChecked = true;
										}
										$listaAreaInteressePessoa->MoveNext();
									}
								}
							?>
		   					
							<div class="check">
							<label>
							<input type="checkbox" name="areasInteresse[]" aria-labelledby ="<?php $listaAreaAtuacao->fields['Descricao60'];?>" id="areaInteresse<?php echo $listaAreaAtuacao->fields['AreaAtuacao']; ?>" value="<?php echo $listaAreaAtuacao->fields['AreaAtuacao']; ?>" class="campo" <?php if($areaAtuacaoChecked) echo "checked"; ?> />
							<?php echo $listaAreaAtuacao->fields['Descricao60']; ?>
							</div>
							<?php $listaAreaAtuacao->MoveNext(); 
							} 
							?>
							<input type="hidden" name="NroOrdem" value="<?php $listaAreaInteressePessoa->MoveLast(); echo $listaAreaInteressePessoa->fields['NroOrdem']==""?"0":$listaAreaInteressePessoa->fields['NroOrdem']; ?>" />
						</div>
						<div class="clear"></div>
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="clear"></div>
	    <div style=" float: right;" >
	    	    
	<?php 
		//<div class="botao-concluir" onClick="curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});curriculoWebUtil.concluido();"></div>
	?>
		<?php  	
		// FAZER IFS DE NAVEGACAO
		$voltarModulo = "pessoa";
		$voltarEntidade = "informacoesPessoais";
		
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
		if ($_SESSION["ExibirPalavrasChave"] == "S") {
			$avancarModulo = "pessoaPalavraChave";
			$avancarEntidade = "palavrasChaves";
		} else 
		if ($_SESSION["ExibirIdiomas"] == "S") {
			$avancarModulo = "pessoaIdioma";
			$avancarEntidade = "idiomas";
		}
// 		}		
// 		else if ($_SESSION["ExibirRequisitos"] == "S") {
// 			$avancarModulo = "requisitos";
// 			$avancarEntidade = "requisitos";
// 		}

        ?>
        <?php 
		if ($voltarModulo != "") {
        ?>
		<div style=" float: left;"><input class="botao-voltar" type ="Button" aria-label = "Voltar" onClick="if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>)){curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});curriculoWebUtil.avancar({modulo: '<?php echo $voltarModulo; ?>', entidade:'<?php echo $voltarEntidade; ?>'})};"></input></div>	     
		<?php }
		 
		?>
		<?php 
		if ($avancarModulo != "") {
        ?>
		<input class="botao-avancar" type ="Button" aria-label = "Avançar" onClick="if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>)){curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});curriculoWebUtil.avancar({modulo: '<?php echo $avancarModulo; ?>', entidade:'<?php echo $avancarEntidade; ?>'})};"></input>		    
		<?php }
        ?>
        <input class="botao-concluir"aria-label = "Concluir"  type ="Button" onClick="if (curriculoWebUtil.validaCheckInteresses(<?php echo $valorDiretrizInteresse;?>)){curriculoWebUtil.salvar({modulo: 'pessoaAreaInteresse', entidade:'interessesProfissionais', evaluateValueHidden:true});curriculoWebUtil.concluido()};"></input>
		
		</div>
		<div class="clear"></div>
	</div>
</div>