<?php  
	 //  include 'site/lib/TraducaoCamposObrigatorios.php';
       global $traducao;
	   $variavelObrigatorios= new CamposObrigatorios();
?>
<!-- necess�rio para o ie n�o ter problemas para interpretar scripts no in�cio da response -->
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


	
</script>		

<div class="content-interna">
	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>
		
		<div align="right"><font color="#369119"  >Os campos marcados com * s�o de preenchimento obrigat�rio.</font></div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-informacoes-academicas">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">
						<form id="informacaoAcademicaForm" name="informacaoAcademicaForm" action="index.php" method="post">
							<input type="hidden" name="modulo" value="informacaoAcademica" />
							<input type="hidden" name="acao" value="" />
							
							<input type="hidden" id="NroOrdem" name="NroOrdem" value="<?php echo $NroOrdem; ?>" class="campo" />							
						
							<div class="listagem-campos">
								<div class="label-campos2">Tipo de Curso:</div>
								<select id="TipoCurso" name="TipoCurso" aria-label = "Tipo de Curso Campo Obrigat�rio" class="campo" style="width: 250px;" onchange="pessoaCursoUtil.verificaTipoCurso(this.value); pessoaCursoUtil.atualizaCombo(listaCursos,this.value)" >
									<option value="">Selecione ... </option>
									<option value="outro">Outro Curso...</option>								
								<?php while (!$tipoCurso->EOF) { ?>
			   						<option value="<?php echo $tipoCurso->fields['TipoCurso']; ?>"><?php echo $tipoCurso->fields['Descricao40']; ?></option>
			   					<?php $tipoCurso->MoveNext(); } ?>			   						
								</select><a  class="asterisco">*</a>
							</div>					
						
							<div id="cursos"  class="listagem-campos" style="display: block;">
								<div class="label-campos2">Curso:</div>
								<select id="Curso" name="Curso" aria-label = "Curso Campo Obrigat�rio" class="campo" style="width: 350px;">
									<option value="">Selecione ... </option>									
								    <?php echo $cursos?>
								</select><a   class="asterisco">*</a>
							</div>
							
							<div id="outroCurso" class="listagem-campos" style="display: none;" >
								<div class="label-campos2">Nome do curso:</div>
								<input type="text"  id="Descricao50" name="Descricao50" class="campo" aria-label = "Nome do Curso Campo Obrigat�rio" size="60" maxlength="50"/></select><a  class="asterisco">*</a>
							</div>
							
							<div class="listagem-campos">
								<div class="label-campos2">Entidade:</div>
								<input type="text" aria-label = "Entidade" id="Descricao40" name="Descricao40" class="campo" size="40" maxlength="40"/>
								<?php if ($variavelObrigatorios->ExisteVariavel('Descricao40')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Descricao40").setAttribute("aria-label", "Entidade Campo Obrigat�rio"); </script>';}?>
							</div>
							
							<div class="listagem-campos">
								<div class="label-campos2">Carga Hor�ria:</div>
								<input type="text" id="Car_Horaria" aria-label = "Carga Hor�ria" name="Car_Horaria" class="campo" size="8" maxlength="9"/>
								<?php if ($variavelObrigatorios->ExisteVariavel('Car_Horaria')){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Car_Horaria").setAttribute("aria-label", "Carga Hor�ria Campo Obrigat�rio"); </script>';}?>
							</div>
							
							<div class="listagem-campos">
								<div class="label-campos2">In�cio:</div>
								<input type="text" id="Dt_Inicio" name="Dt_Inicio" aria-label = "In�cio" class="campo" size="10"/>
								<?php if ($variavelObrigatorios->ExisteVariavel('Dt_Inicio')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Dt_Inicio").setAttribute("aria-label", "In�cio Campo Obrigat�rio"); </script>';}?>
							</div>
							
							<div class="listagem-campos">
								<div class="label-campos2">Encerramento:</div>
								<input type="text" id="Dt_Encerra" name="Dt_Encerra" class="campo" aria-label = "Encerramento" size="10"/>
								<?php if ($variavelObrigatorios->ExisteVariavel('Dt_Encerra')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Dt_Encerra").setAttribute("aria-label", "Encerramento Campo Obrigat�rio"); </script>';}?>								
							</div>
							
							<div class="listagem-campos">
								<div class="label-campos2">&nbsp;</div>
								<input id="botaoCancelarCurso" type="button" aria-label = "Cancelar Curso" class="botao-cancelar-curso" value="" style="display: none;" onclick="pessoaCursoUtil.atualizarDadosListagem();"/>
								<input id="botaoAdicionarCurso" type="button" aria-label = "Adicionar Curso" class="botao-adicionar-curso" value="" />
<!-- 								onclick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposFormacao()) { pessoaCursoUtil.salvar(jQuery('#informacaoAcademicaForm').get(0)) }" -->
							</div>
						 
						</form>
						
						<div class="clear"></div>																	
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="clear"></div>
		<div class="botao-concluir" aria-label = "Concluir" onClick="curriculoWebUtil.concluido();"></div>
		<div class="clear"></div>
	</div>
</div>