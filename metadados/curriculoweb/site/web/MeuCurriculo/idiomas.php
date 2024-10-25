<!-- necessário para o ie não ter problemas para interpretar scripts no iní­cio da response -->
<font size="1" style="display: none;">&nbsp;</font>

<script type="text/javascript">

curriculoWebUtil.resetCamposAlterados();
jQuery('.alinhamento :input').bind("change", function(){
	if (this.type == "checkbox"){
		if (this.checked) {
			curriculoWebUtil.addCampoAlterado(this.name,this.value);			
			var nivel = jQuery(jQuery(this).data('nivel'));
			if (curriculoWebUtil.camposAlterados.indexOf(nivel.attr('name')+'='+nivel.val()) == -1){
	         	 curriculoWebUtil.addCampoAlterado(nivel.attr('name'),nivel.val());
	        }
		}
		else curriculoWebUtil.deleteCampoAlterado(this.name,this.value);

	} else {
		if (this.name != "undefined") {
		  curriculoWebUtil.addCampoAlterado(this.name,this.value);
          if (curriculoWebUtil.camposAlterados.indexOf('idiomas[]='+jQuery(this).data('idioma')) == -1){
         	 curriculoWebUtil.addCampoAlterado('idiomas[]',jQuery(this).data('idioma'));
          }
		}
		
	}
});

</script>
<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>
		
		<div align="right"><font color="#369119"  >Os campos marcados com * são de preenchimento obrigatório.</font></div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-idiomas" tabindex="0" aria-label="Idiomas Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
					
						<?php 
						while (!$listaIdiomas->EOF) {
							$idiomaChecked = false;
							$idiomaNivel = "";
							if (!is_null($listaIdiomasPessoa)){
								$listaIdiomasPessoa->MoveFirst();
								while (!$listaIdiomasPessoa->EOF) {
									if ($listaIdiomas->fields['Idioma'] == $listaIdiomasPessoa->fields['Idioma']){
										$idiomaChecked = true;
										$idiomaNivel = $listaIdiomasPessoa->fields['NivelIdioma'];
									}
									$listaIdiomasPessoa->MoveNext();
								}
							}
						?>
						<div class="listagem-campos">
						<label>  
							<div class="label-campos"><?php echo $listaIdiomas->fields['Descricao20']; ?>
							<input type="checkbox" name="idiomas[]" id="idioma<?php echo $listaIdiomas->fields['Idioma']; ?>" value="<?php echo $listaIdiomas->fields['Descricao20']; ?>" class="campo" aria-labelledby ="<?php $listaIdiomaNivel->fields['Descricao20'];?>" 
						
							
							<?php if($idiomaChecked) echo "checked"; ?> /></div>
							<select  name="nivel<?php echo $listaIdiomas->fields['Idioma']; ?>" id="nivel<?php echo $listaIdiomas->fields['Idioma']; ?>" class="campo"   style="width: 160px;" <?php if(!$idiomaChecked) echo "disabled='disabled'"; ?>>
							<label>  
								<option value="" aria-labelledby ="<?php $listaIdiomaNivel->fields['Descricao20'];?>" >Selecione...</option>
								<?php 
								$listaIdiomaNivel->MoveFirst();
								while (!$listaIdiomaNivel->EOF) {
									?><option value="<?php echo $listaIdiomaNivel->fields['NivelIdioma']; ?>"
										<?php if ($listaIdiomaNivel->fields['NivelIdioma'] == $idiomaNivel) echo "selected='selected'";?>><?php echo $listaIdiomaNivel->fields['Descricao20']; ?></option>
									<?php $listaIdiomaNivel->MoveNext();
								} 
								?>
							</select>
						</div>
						<script>
						    jQuery("#nivel<?php echo $listaIdiomas->fields['Idioma']; ?>").data('idioma','<?php echo $listaIdiomas->fields['Idioma']; ?>');
						    jQuery("#idioma<?php echo $listaIdiomas->fields['Idioma']; ?>").data('nivel','#nivel<?php echo $listaIdiomas->fields['Idioma']; ?>');
							jQuery("#idioma<?php echo $listaIdiomas->fields['Idioma']; ?>").click(
								function(){
									if (this.checked) 
										jQuery("#nivel<?php echo $listaIdiomas->fields['Idioma']; ?>").removeAttr("disabled");
									else 
										jQuery("#nivel<?php echo $listaIdiomas->fields['Idioma']; ?>").attr("disabled","disabled");
								}
							);

						</script>
						<?php $listaIdiomas->MoveNext();
                        } ?>
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
		
		if ($_SESSION["ExibirPalavrasChave"] == "S") {
			$voltarModulo = "pessoaPalavraChave";
			$voltarEntidade = "palavrasChaves";
		} else
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
// 		if ($_SESSION["ExibirRequisitos"] == "S") {
// 			$avancarModulo = "requisitos";
// 			$avancarEntidade = "requisitos";
// 		}
		?>
		<?php 
		if ($voltarModulo != "") {
        ?>
		<div style=" float: left;"><input type ="Button"  class="botao-voltar" aria-label = "Voltar" Onclick="curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});curriculoWebUtil.avancar({modulo: '<?php echo $voltarModulo; ?>', entidade:'<?php echo $voltarEntidade; ?>'});"></input></div>
		<?php 
		}
        ?>
        <input type ="Button" class="botao-concluir" aria-label = "Concluir" Onclick="curriculoWebUtil.salvar({modulo: 'pessoaIdioma', entidade:'idiomas'});curriculoWebUtil.concluido();"></input>
        </div>
		<div class="clear"></div>
	</div>
</div>