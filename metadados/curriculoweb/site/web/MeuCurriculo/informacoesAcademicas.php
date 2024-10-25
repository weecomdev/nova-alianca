<?php  global $traducao;
	   $variavelObrigatorios= new CamposObrigatorios();
       $campoVisiveis = new CamposObrigatorios();
?>
<!-- necessário para o ie não ter problemas para interpretar scripts no iní­cio da response -->
<font size="1" style="display: none;">&nbsp;</font>

<script type="text/javascript">
	pessoaCursoUtil.atualizarDadosListagem();
	jQuery("#Dt_Inicio").mask("99/99/9999");
	jQuery("#Dt_Encerra").mask("99/99/9999");
	jQuery("#Car_Horaria").priceFormat({
	    prefix: '',
	    centsSeparator: ',',
	    thousandsSeparator: '.'
	});

	validacaoCampos = [];
	<?php while (!$listaCamposObr->EOF){ ?>  
		validacaoCampos.push({'Nome':'<?php echo $traducao['RHPESSOACURSOSRS'][$listaCamposObr->fields['CampoTabela']];?>' , 'Descricao':'<?php echo $listaCamposObr->fields['Descricao60'];?>'});
	<?php 
		$variavelObrigatorios->AdicionaListaVariaveis($traducao['RHPESSOACURSOSRS'][$listaCamposObr->fields['CampoTabela']]);
		$listaCamposObr->MoveNext(); } ?>	

	listaCursos = [];	
	<?php 		
	    $cursos = "";
	     while (!$result->EOF) { 
	   	    $cursos.= "<option value=".$result->fields['Curso'].">".$result->fields['Descricao50']."</option>";
			echo "listaCursos.push({'TipoCurso':'".$result->fields['TipoCurso']."','Curso':'".$result->fields['Curso']."','Descricao50':'".$result->fields['Descricao50']."'})\n"; 	
	   	    $result->MoveNext(); 
	     } 
	?>
	
    <?php
        while (!$listaCamposInv->EOF){ 
	    $campoVisiveis->AdicionaListaVariaveis($traducao['RHPESSOACURSOSRS'][$listaCamposInv->fields['CampoTabela']]);
	    $listaCamposInv->MoveNext(); } 
    ?>	



jQuery(document).ready(function () {
	    var dialog = jQuery("#camposCurso").dialog({
	        autoOpen: false,
	        width: 722,
	        modal: true,
	        closeText: 'fechar',
	        resizable: false
	        		        	      
	                    	
	    });
   	    
	    
//   dialog.parent().appendTo(jQuery('form:first')); 
	       
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

	jQuery( "#Dt_Inicio" ).datepicker( configuracoes );
	jQuery( "#Dt_Encerra" ).datepicker( configuracoes );

	// As modificaçÃµes no css abaixo deve ficar abaixo da chamada do datepicker para que o botão criado fique centralizado ao campo.   
	jQuery(".ui-datepicker-trigger").css("margin-bottom","-3px");
	jQuery(".ui-datepicker-trigger").css("margin-left","2px");
});

	
</script>		

<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>				
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-informacoes-academicas" tabindex="0" aria-label="Formação Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">
						<form id="informacaoAcademicaForm" name="informacaoAcademicaForm" action="index.php" method="post" style="height: 26px">																						
<!--								<input id="botaoCancelarCurso" type="button" class="botao-cancelar-curso" value="" style="display: none;" onclick="pessoaCursoUtil.atualizarDadosListagem();"/> -->
								<input id="botaoAdicionarCurso" type="button" class="botao-adicionar-curso" aria-label = "Adicionar Curso" value="" style="margin-left: 537px; margin-top: 1px" onclick="pessoaCursoUtil.atualizarDadosListagem(); jQuery('#camposCurso').dialog({title: 'Novo Curso'});" />
<!-- 							onclick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposFormacao()) { pessoaCursoUtil.salvar(jQuery('#informacaoAcademicaForm').get(0)) }" -->									 																		
						</form>
						
						<div class="clear"></div>
						
						<div class="borda-tabela">
							<table class="informacoes-academicas" width="655px">
								<tr>
								    <th width="80px">Tipo</th>
									<th width="350px">Nome do Curso</th>
									<th width="100px">Car. Horária</th>									
									<th width="70px">Início</th>
									<th width="70px">Término</th>
									<th width="30px"></th>
									<th width="30px"></th>
								</tr>																
							</table>
							<table id="tableListPessoaCurso" class="informacoes-academicas" width="655px">
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
		
		if ($_SESSION["ExibirDadosCompl"] == "S" || $_SESSION["ExibirRequisitos"] == "S") {
			$voltarModulo = "informacoesAdicionais";
			$voltarEntidade = "informacoesAdicionais";
		}
		
		$avancarModulo = "";
		$avancarEntidade = "";
		if ($_SESSION["ExibirEmpAnteriores"] == "S") {
			$avancarModulo = "historicoProfissional";
			$avancarEntidade = "historicoProfissional";
		} else 
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
// 		else if ($_SESSION["ExibirRequisitos"] == "S") {
// 			$avancarModulo = "informacoesAdicionais";
// 			$avancarEntidade = "informacoesAdicionais";
// 		}
        ?>
        <?php 
        if ($voltarModulo != "") {
        ?>
		<div style=" float: left;"><input type ="Button" class="botao-voltar" aria-label = "Voltar" onClick="curriculoWebUtil.avancar({modulo: '<?php echo $voltarModulo; ?>', entidade:'<?php echo $voltarEntidade; ?>'});"></input></div>
		<?php 
        }
        ?>
		<?php 
		if ($avancarModulo != "") {
        ?>
		<input type ="Button" class="botao-avancar" aria-label = "Avançar" onClick="curriculoWebUtil.avancar({modulo: '<?php echo $avancarModulo; ?>', entidade:'<?php echo $avancarEntidade; ?>'});"></input>
		<?php 
		}
		?>

        <input class="botao-concluir" aria-label = "Concluir" type ="Button" onClick="curriculoWebUtil.concluido();"></input>
        </div>
		<div class="clear"></div>
	</div>
</div>

 
<div id="camposCurso" title="Novo Curso" style="font-size: 11px; font-family: Arial; ">		
	<div class="clear"></div>
	<div align="right"><font color="#369119" >Os campos marcados com * são de preenchimento obrigatório.</font></div>
		<div class="div-box" style="margin-top: 7px">			
		<div class="box-middle" >
			<div class="box-top"></div>			
			<div class="clear">&nbsp;</div>
			<div class="box-middle-content" style="min-height: 100px;overflow: hidden;" >
			<form id="informacaoAcademicaForm2" name="informacaoAcademicaForm2" action="index.php" method="post">
				<input type="hidden" name="modulo" value="informacaoAcademica" />
				<input type="hidden" name="acao" value="" />
										
				<input type="hidden" id="NroOrdem" name="NroOrdem" value="<?php echo $NroOrdem; ?>" class="campo" />							
			
				<div class="listagem-campos">
					<div class="label-campos2">Tipo de Curso:</div>
					<select id="TipoCurso" name="TipoCurso" class="campo"  aria-label = "Tipo de Curso Campo Obrigatório" style="width: 250px;" onchange="pessoaCursoUtil.verificaTipoCurso(this.value); pessoaCursoUtil.atualizaCombo(listaCursos,this.value)" >
						<option value="">Selecione ... </option>
						<option value="outro">Outro Curso...</option>								
					<?php while (!$tipoCurso->EOF) { ?>
			   						<option value="<?php echo $tipoCurso->fields['TipoCurso']; ?>"><?php echo $tipoCurso->fields['Descricao40']; ?></option>
			   					<?php $tipoCurso->MoveNext();
                          } ?>			   						
					</select><span>*</span>
				</div>					
			
				<div id="cursos"  class="listagem-campos" style="display: block;">
					<div class="label-campos2">Curso:</div>
					<select id="Curso" name="Curso" class="campo" aria-label = "Curso Campo Obrigatório" style="width: 350px;">
						<option value="">Selecione ... </option>									
					    <?php echo $cursos?>
					</select><a   class="asterisco">*</a>
				</div>
				
				<div id="outroCurso" class="listagem-campos" style="display: none;">
					<div class="label-campos2">Nome do curso:</div>
					<input type="text" aria-label = "Nome do Curso" id="Descricao50" name="Descricao50" class="campo" size="60" maxlength="50"/></select><a tabindex="0"   class="asterisco">*</a>
				</div>
				<?php	if (!$campoVisiveis->ExisteVariavel('Descricao40')) { ?>
				    <div class="listagem-campos">
					    <div class="label-campos2">Entidade:</div>
					    <input type="text" id="Descricao40" name="Descricao40" aria-label = "Entidade" class="campo" size="40" maxlength="40"/>
					    <?php if ($variavelObrigatorios->ExisteVariavel('Descricao40')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Descricao40").setAttribute("aria-label", "Entidade Campo Obrigatório"); </script>';}?>
				    </div>
                <?php } ?>
				<?php	if (!$campoVisiveis->ExisteVariavel('Car_Horaria')) { ?>
				    <div class="listagem-campos">
					    <div class="label-campos2">Carga Horária:</div>
					    <input type="text" id="Car_Horaria" name="Car_Horaria" class="campo" aria-label = "Carga Horária" size="8" maxlength="9"/>
					    <?php if ($variavelObrigatorios->ExisteVariavel('Car_Horaria')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Car_Horaria").setAttribute("aria-label", "Carga Horária Campo Obrigatório"); </script>';}?>
				    </div>
                <?php } ?>
				<?php	if (!$campoVisiveis->ExisteVariavel('Dt_Inicio')) { ?>
				<div class="listagem-campos">
					<div class="label-campos2">Iní­cio:</div>
					<input type="text" id="Dt_Inicio" name="Dt_Inicio" class="campo" aria-label = "Iní­cio" size="10"/>
					<?php if ($variavelObrigatorios->ExisteVariavel('Dt_Inicio')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Dt_Inicio").setAttribute("aria-label", "Iní­cio Campo Obrigatório"); </script>';}?>
				</div>
                <?php } ?>
				<?php	if (!$campoVisiveis->ExisteVariavel('Dt_Encerra')) { ?>
				    <div class="listagem-campos">
					    <div class="label-campos2">Encerramento:</div>
					    <input type="text" id="Dt_Encerra" name="Dt_Encerra" class="campo" aria-label = "Encerramento" size="10"/>
					    <?php if ($variavelObrigatorios->ExisteVariavel('Dt_Encerra')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Dt_Encerra").setAttribute("aria-label", "Encerramento Campo Obrigatório"); </script>';}?>								
				    </div>
                <?php } ?>
				<div class="listagem-campos">
					<div class="label-campos2">&nbsp;</div>
							
					<input id="CancelarCurso" type="button" aria-label = "Cancelar" class="botao-cancelar" value="" style="margin-left: 95px" onclick="pessoaCursoUtil.atualizarDadosListagem(); pessoaCursoUtil.fechaTelaModal();" />
					<input id="salvaCurso" type="button" aria-label = "Salvar" class="botao-salvar" value="" style="margin-right: 245px" onclick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposFormacao()) { pessoaCursoUtil.salvar(jQuery('#informacaoAcademicaForm2').get(0)); pessoaCursoUtil.fechaTelaModal();}"/>
				
				</div>
			 
			</form>  
		  </div>	
		</div>
	<div class="box-bottom"></div>
  </div>
</div>
<script>
jQuery("#botaoAdicionarCurso").click(function(){
	
		//validacaoCampos = [];
	//	jQuery("#teste2").html();
	//	jQuery("#teste2").load("site/web/MeuCurriculo/camposInformacoesAcademicas.php");
		jQuery("#camposCurso").dialog('open');
		

});

</script>