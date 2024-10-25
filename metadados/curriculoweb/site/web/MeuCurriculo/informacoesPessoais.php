<?php  
 global $traducao; 
 global $configObj;
 $variavelObrigatorios = new CamposObrigatorios();
 $variavelObrigatoriosFoto = new CamposObrigatorios();
 $variavelObrigatoriosAnexo = new CamposObrigatorios();
 $campoVisiveis = new CamposObrigatorios();
 $campoVisiveisFoto = new CamposObrigatorios();
 $campoVisiveisAnexo = new CamposObrigatorios();
?>
<!-- necess?rio para o ie n?o ter problemas para interpretar scripts no in?cio da response -->
<font size="1" style="display: none;">&nbsp;</font>

<script type="text/javascript">

curriculoWebUtil.resetCamposAlterados();

jQuery("#cpf").mask("999.999.999-99");
jQuery("#Nascimento").mask("99/99/9999");
jQuery("#ValidadeVisto").mask("99/99/9999");
jQuery("#DataRegistro").mask("99/99/9999");
jQuery("#DataPIS").mask("99/99/9999");
jQuery("#Cep").mask("99999-999");
jQuery("#PretensaoSalarial").priceFormat({
    prefix: '',
    centsSeparator: ',',
    thousandsSeparator: '.'
});
jQuery("#ValidadeHabilitacao").mask("99/99/9999");


jQuery('.alinhamento :input').bind("change", function(){
	if (this.type == "checkbox"){
		if (this.checked) this.value = "S";
		else this.value = "N";
	}
	curriculoWebUtil.addCampoAlterado(this.name,this.value);
});

validacaoCampos = [];
<?php while (!$listaCamposObr->EOF){ ?> 
 
	validacaoCampos.push({'Nome':'<?php echo $traducao['RHPESSOAS'][$listaCamposObr->fields['CampoTabela']];?>' , 'Descricao':'<?php echo $listaCamposObr->fields['Descricao60'];?>'});
<?php 
	$variavelObrigatorios->AdicionaListaVariaveis($traducao['RHPESSOAS'][$listaCamposObr->fields['CampoTabela']]);
	$listaCamposObr->MoveNext(); } ?>

<?php while (!$listaCamposObrFoto->EOF){ ?>
    validacaoCampos.push({'Nome':'<?php echo $traducao['RHPESSOASFOTOS'][$listaCamposObrFoto->fields['CampoTabela']];?>' , 'Descricao':'<?php echo $listaCamposObrFoto->fields['Descricao60'];?>'}); 
<?php	
    $variavelObrigatoriosFoto->AdicionaListaVariaveis($traducao['RHPESSOASFOTOS'][$listaCamposObrFoto->fields['CampoTabela']]);
	$listaCamposObrFoto->MoveNext(); } ?>

<?php while (!$listaCamposObrAnexo->EOF){ ?>
    validacaoCampos.push({'Nome':'<?php echo $traducao['RHPESSOASANEXOS'][$listaCamposObrAnexo->fields['CampoTabela']];?>' , 'Descricao':'<?php echo $listaCamposObrAnexo->fields['Descricao60'];?>'}); 
<?php	
    $variavelObrigatoriosAnexo->AdicionaListaVariaveis($traducao['RHPESSOASANEXOS'][$listaCamposObrAnexo->fields['CampoTabela']]);
	$listaCamposObrAnexo->MoveNext(); } ?>

<?php while (!$listaCamposInv->EOF){ 
	$campoVisiveis->AdicionaListaVariaveis($traducao['RHPESSOAS'][$listaCamposInv->fields['CampoTabela']]);
	$listaCamposInv->MoveNext(); } ?>

<?php while (!$listaCamposFotoInv->EOF){ 
	$campoVisiveisFoto->AdicionaListaVariaveis($traducao['RHPESSOASFOTOS'][$listaCamposFotoInv->fields['CampoTabela']]);
	$listaCamposFotoInv->MoveNext(); } ?>

 <?php while (!$listaCamposAnexoInv->EOF){ 
	$campoVisiveisAnexo->AdicionaListaVariaveis($traducao['RHPESSOASANEXOS'][$listaCamposAnexoInv->fields['CampoTabela']]);
	$listaCamposAnexoInv->MoveNext(); }
?>

function carregaFotoCandidato(){
	jQuery("#Foto").attr('src', 'index.php?modulo=imagem&acao=pessoa&dummy='+Math.random());
}


infoIncompletaUtil.setTexto('<iframe src="index.php?modulo=upload&acao=formFoto" height="100%" width="400px">Seu navegador n?o suporta iframes.</iframe>');
infoIncompletaUtil.setAposFecharTela(carregaFotoCandidato);

jQuery(document).ready(function () {
    var dialog = jQuery("#camposFoto").dialog({
        autoOpen: false,
        height: 350,
        width: 447,
        modal: true,
        closeText: 'fechar',
        resizable: false,
        close: function(){ carregaFotoCandidato(); }
            	        	                          	
    });    
});



jQuery(document).ready(function () {
    var dialog = jQuery("#camposAnexo").dialog({
        autoOpen: false,        
        height: 200,
        width: 300,
        modal: true,
        closeText: 'fechar',
        resizable: false,
        close: function () { curriculoWebUtil.carregaAnexoCandidato(); }
    });

});

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


jQuery(function() {	
 

	if(jQuery("#ValidadeVisto").is(':disabled')){
		jQuery('#Visto1').hide();
		jQuery('#Visto2').show();		
		
	}else{
		jQuery('#Visto2').hide();
		jQuery('#Visto1').show();
	}

	jQuery( "#ValidadeVisto" ).datepicker( configuracoes );
	jQuery( "#Nascimento" ).datepicker( configuracoes );
	jQuery("#DataRegistro").datepicker(configuracoes);
	jQuery("#DataPIS").datepicker(configuracoes);
	jQuery( "#ValidadeHabilitacao" ).datepicker( configuracoes );

	// As modifica?ões no css abaixo deve ficar abaixo da chamada do datepicker para que o bot?o criado fique centralizado ao campo.   
	jQuery(".ui-datepicker-trigger").css("margin-bottom","-4px");
	jQuery(".ui-datepicker-trigger").css("margin-left","2px");
	jQuery(".ui-datepicker-trigger").css("TabIndex",'0');
});


</script>

<div class="content-interna">

	<div class="alinhamento">
		
		<?php include 'migalha.php'; ?>
		
		<div class="clear">&nbsp;</div>
		
		<div class="float350" tabindex="0"><?php echo $configObj->getValorDiretriz('mensagemMeuCurriculo'); ?>&nbsp;</div>
		<div class="float350" align="right"><br/><font color="#369119" >Os campos marcados com * são de preenchimento obrigatório.</font></div>
		
		<div class="clear">&nbsp;</div>		
		
		<div class="div-box">
			<div class="titulo-cpf" tabindex="0" aria-label="CPF Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content-cpf">
						<div class="listagem-campos">
							<div class="label-campos">Número:</div>
							<input type="text" disabled="disabled" class="campo" size="12" id="cpf" aria-label="Cpf Campo Obrigatório" name="cpf" value="<?php echo $pessoa->fields['CPF']; ?>" /><a  class="asterisco">*</a>
						</div>
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="div-box">
			<div class="titulo-informacoes-pessoais" tabindex="0" aria-label="Informações Pessoais Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">
                        <?php if ($campoVisiveisFoto->ExisteVariavel('Foto')) { ?>						
						    <div class="listagem-campos">
                        <?php } else { ?>
                            <div style='float:left;width:520px'>
                        <?php } ?>
	                    <fieldset><legend>Filiação</legend>				
				     		<br />
				     		<div class="listagem-campos" style='height:18px;'>
					    		<div class="label-campos">Nome:</div>
						    	<input type="text" class="campo" aria-label = "Nome Campo Obrigatório" size="40" id="Nome" name="Nome" value="<?php echo $pessoa->fields['Nome']; ?>" maxLength="40"/><a  class="asterisco">*</a>
						    </div>
                            <?php	if (!$campoVisiveis->ExisteVariavel('Pai')) { ?>
						        <div class="listagem-campos" style='height:18px;'>
							        <div class="label-campos">Pai:</div>
							        <input type="text" class="campo" aria-label = "Pai" size="40" id="Pai" name="Pai" value="<?php echo $pessoa->fields['Pai']; ?>" maxLength="40"/><?php if ($variavelObrigatorios->ExisteVariavel('Pai')){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Pai").setAttribute("aria-label", "Pai Campo Obrigatório"); </script>';}?>
						         </div> 
                            <?php } ?>
                            <?php	if (!$campoVisiveis->ExisteVariavel('Mae')) { ?>
						        <div class="listagem-campos" style='height:18px;'>
							        <div class="label-campos">Mãe:</div>
							        <input type="text" class="campo" aria-label = "Mãe" size="40" id="Mae" name="Mae" value="<?php echo $pessoa->fields['Mae']; ?>" maxLength="40"/><?php if ($variavelObrigatorios->ExisteVariavel('Mae')){ echo '<a class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Mae").setAttribute("aria-label", "Mãe Campo Obrigatório"); </script>';}?>
						        </div>
                            <?php } ?>
                        </fieldset>						
						</div>					
						
                        <?php if (!$campoVisiveisFoto->ExisteVariavel('Foto')) { ?>
					    <div style='float: right'>                   	
					      <fieldset style='width:85px;'><legend>Foto</legend>
                            <?php if ($variavelObrigatoriosFoto->ExisteVariavel('Foto')){ echo '<a class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Foto").setAttribute("aria-label", "Foto Campo Obrigatório"); </script>';}?>			
    					    <div style='float:right' align='center'><img alt="Foto do(a) Candidato(a)" aria-label = "Foto do Candidato" id="Foto" width="74px" height="99px" style="cursor: pointer;" onclick="">
						    <br/>						    
                            <strong id="linkFoto2" class="migalha-ativa"><button style="font-size : 11px;border:none;background: none;width: 102px"  onclick="" class="migalha-ativa">Selecionar Foto</button></strong>	                                                      						    
						    </div>				
					      </fieldset>
					    </div>  
					    <div style='clear:both'></div>
			            <?php } ?>
																		
						<fieldset><legend>Nascimento</legend>
						
							<div class="listagem-campos">
								<div class="label-campos">Data:</div>
								<input type="text" class="campo" size="12" aria-label = "Data de Nascimento Campo Obrigatório" id="Nascimento" name="Nascimento" value="<?php echo $dateUtil->formatar($pessoa->fields['Nascimento']); ?>" /><a  class="asterisco">*</a>
							</div>
                            <?php	if (!$campoVisiveis->ExisteVariavel('UFNascimento')) { ?>
							    <div class="listagem-campos">
								    <div class="label-campos">UF:</div> 
								    <select id="UFNascimento" name="UFNascimento" aria-label = "UF" onchange="curriculoWebUtil.buscarCidadesPorUF('UFNascimento', 'LocalNascimento');" class="campo" style="width: 80px;">
									    <option value="">Selecione ... </option>
							    <?php if ($listaOpcaoUFNascimento != NULL) {
							    while (!$listaOpcaoUFNascimento->EOF) { ?>
			   						    <option value="<?php echo $listaOpcaoUFNascimento->fields['Opcao']; ?>" <?php if ($listaOpcaoUFNascimento->fields['Opcao'] == $pessoa->fields['UFNascimento']) echo " selected "; ?>>
			   						    <?php echo $listaOpcaoUFNascimento->fields['Descricao60']; ?>
			   						    </option>
			   					    <?php $listaOpcaoUFNascimento->MoveNext(); } }?>
			   					    </select>
			   					    <?php if ($variavelObrigatorios->ExisteVariavel('UFNascimento')){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("UFNascimento").setAttribute("aria-label", "UF Campo Obrigatório"); </script>';}?>
							    </div>
                            <?php } ?>
                            <?php if (!$campoVisiveis->ExisteVariavel('Cidade')) { ?>
							    <div class="listagem-campos">
								    <div class="label-campos">Cidade:</div>
                                    <select id="LocalNascimento" name="LocalNascimento" aria-label = "Cidade" aria-label = "Local Nascimento" class="campo" style="width: 160px;" title="Selecione a UF para visualizar as Cidades">
									    <option value="">Selecione ... </option>
								    <?php if ($listaOpcaoLocalNascimento != NULL) {
                                              while (!$listaOpcaoLocalNascimento->EOF) { ?>
			   						    <option value="<?php echo $listaOpcaoLocalNascimento->fields['Cidade']; ?>" <?php if ($listaOpcaoLocalNascimento->fields['Cidade'] == $pessoa->fields['LocalNascimento']) echo " selected "; ?>>
			   						    <?php echo $listaOpcaoLocalNascimento->fields['Descricao80']; ?>
			   						    </option>
			   					    <?php $listaOpcaoLocalNascimento->MoveNext();
                                              }
                                          }?>
			   					    </select>
			   					    <?php if ($variavelObrigatorios->ExisteVariavel('LocalNascimento')){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("LocalNascimento").setAttribute("aria-label", "Cidade Campo Obrigatório"); </script>';}?>                                
							     </div>
                             <?php } ?>
						 
						</fieldset>
						
						<fieldset><legend>Dados Adicionais</legend>
							<div class="listagem-campos">
								<div class="label-campos">Sexo:</div>
								<input tabindex="0" type="radio" value="M" id="Sexo" aria-label = "Sexo Masculino Campo Obrigatório" name="Sexo" <?php if ($pessoa->fields['Sexo'] == "M") echo " checked "; ?> />Masculino 
								<input tabindex="0" type="radio" value="F" id="Sexo" name="Sexo" aria-label = "Sexo Feminino Campo Obrigatório" <?php if ($pessoa->fields['Sexo'] == "F") echo " checked "; ?> />Feminino<a  class="asterisco">*</a>
							</div>
                            <?php if (!$campoVisiveis->ExisteVariavel('EstadoCivil')) { ?>
							    <div class="listagem-campos">
								    <div class="label-campos">Estado Civil:</div>
								    <select id="EstadoCivil" name="EstadoCivil" aria-label = "Estado Civil" class="campo" style="width: 160px;">
									    <option value="">Selecione ... </option>
									    <?php if ($listaEstadoCivil != NULL) {
									    while (!$listaEstadoCivil->EOF) { ?>
				   						    <option value="<?php echo $listaEstadoCivil->fields['EstadoCivil']; ?>" <?php if ($listaEstadoCivil->fields['EstadoCivil'] == $pessoa->fields['EstadoCivil']) echo " selected "; ?>>
				   						    <?php echo $listaEstadoCivil->fields['Descricao20']; ?>
				   						    </option>
				   					    <?php $listaEstadoCivil->MoveNext(); } }?>
								    </select>
								    <?php if ($variavelObrigatorios->ExisteVariavel('EstadoCivil')){ echo '<a class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("EstadoCivil").setAttribute("aria-label", "Estado Civil Campo Obrigatório"); </script>';}?>
							    </div>
                             <?php } ?>
                             <?php if (!$campoVisiveis->ExisteVariavel('GrauInstrucao')) { ?>
							    <div class="listagem-campos">
								    <div class="label-campos">Grau Instrução:</div>
								    <select id="GrauInstrucao" name="GrauInstrucao" aria-label = "Grau de Instrução" class="campo" style="width: 160px;">
									    <option value="">Selecione ... </option>
									    <?php if ($listaGrauInstrucao != NULL) {
									    while (!$listaGrauInstrucao->EOF) { ?>
				   						    <option value="<?php echo $listaGrauInstrucao->fields['GrauInstrucao']; ?>" <?php if ($listaGrauInstrucao->fields['GrauInstrucao'] == $pessoa->fields['GrauInstrucao']) echo " selected "; ?>>
				   						    <?php echo $listaGrauInstrucao->fields['Descricao20']; ?>
				   						    </option>
				   					    <?php $listaGrauInstrucao->MoveNext(); } }?>
								    </select>
								    <?php if ($variavelObrigatorios->ExisteVariavel('GrauInstrucao')){ echo '<a class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("GrauInstrucao").setAttribute("aria-label", "Grau de Instrução Campo Obrigatório"); </script>';}?>
							    </div>
                             <?php } ?>
							<?php 
							if (!$campoVisiveis->ExisteVariavel('PretensaoSalarial'))  {
							?>
							<div class="listagem-campos">
								<div class="label-campos">Pretensão Salarial:</div>
								<input type="text" class="campo" size="12" aria-label = "Pretenção Salarial" id="PretensaoSalarial" name="PretensaoSalarial" value="<?php echo NumberUtil::formatar($pessoa->fields['PretensaoSalarial']); ?>" />
								<?php if ($variavelObrigatorios->ExisteVariavel('PretensaoSalarial')){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("PretensaoSalarial").setAttribute("aria-label", "Pretenção Salarial Campo Obrigatório"); </script>';}?>								
							</div>
							<?php 
							}
							?>
							<?php 
							if (!$campoVisiveis->ExisteVariavel('DeficienteFisico')) {
							?>
							<div class="listagem-campos">
								<div class="label-campos">Possui Deficiência:</div>
								<select id="DeficienteFisico" name="DeficienteFisico" aria-label = "Possui Deficiência?" class="campo" style="width: 160px;">
									<option value="">Selecione ... </option>
									<?php if ($listaOpcaoDeficienteFisico != NULL) {
									while (!$listaOpcaoDeficienteFisico->EOF) { ?>

				   						<option aria-label= "<?php $pDeficiencia = $listaOpcaoDeficienteFisico->fields['Opcao']; if ($pDeficiencia == 0){ echo "Não possui Deficiência";} else if ($pDeficiencia == 1){echo "Deficiência Física";} else if ($pDeficiencia == 2) {echo "Deficiência Auditiva";} else if ($pDeficiencia == 3) { echo "Deficiência Visual";} else if ($pDeficiencia == 4){ echo "Deficiência Intelectual(Mental)"; } else if ($pDeficiencia == 5) { echo "Deficiência Múltipla"; }?>" value="<?php echo $listaOpcaoDeficienteFisico->fields['Opcao']; ?>" <?php if ($listaOpcaoDeficienteFisico->fields['Opcao'] == $pessoa->fields['DeficienteFisico']) echo " selected "; ?>>
				   						<?php echo $listaOpcaoDeficienteFisico->fields['Descricao60']; ?>
				   						</option>
				   					<?php $listaOpcaoDeficienteFisico->MoveNext(); } }?>
                                  </select>
								 <?php if ($variavelObrigatorios->ExisteVariavel('DeficienteFisico')){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("DeficienteFisico").setAttribute("aria-label", "Possui Deficiência? Campo Obrigatório"); </script>';}?>
							</div>
							<div class="listagem-campos">
								<div class="label-campos">&nbsp;</div>
								<input type="checkbox" name="BenefReabilitado" aria-label = "E beneficiário Reabilitado" value="S" id="BenefReabilitado" <?php if ($pessoa->fields['BenefReabilitado'] == "S") echo " checked "; ?> class="campo" />É Beneficiário Reabilitado?
							</div>
                            <?php } ?>
                            <?php if (!$campoVisiveisAnexo->ExisteVariavel('ArquivoBlob')) { ?>
							    <div class="listagem-campos" style='height:18px;'>  
	                                <div class="label-campos">Anexo:</div>
	                                <input type="text" class="campo" size="30" id="ArquivoBlob" name="Nome"  aria-Label="Anexo" disabled="disabled" value="<?php echo $pessoaAnexo->fields['NomeArquivo']; ?>" maxLength="30"/>
	                                <button id="botaoIncluirAnexo" type="button" class="botao-incluir-anexo" title="Incluir/Alterar Anexo botão"></button>                               
	                                <button id="botaoExcluirAnexo" type="button" class="botao-excluir-anexo" title="Excluir" onclick="curriculoWebUtil.removerAnexo();"></button>
                                    <?php if ($variavelObrigatoriosAnexo->ExisteVariavel('ArquivoBlob')){ echo '<a class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("ArquivoBlob").setAttribute("aria-label", "Anexo Campo Obrigatório"); </script>';}?>                               
                                </div>
                            <?php } ?>   
						</fieldset>
						
						<fieldset><legend>Opções</legend>
							<div class="listagem-campos">
								<div class="label-campos">&nbsp;</div>
								<input type="checkbox" name="Estudando" aria-label = "Estudando" value="S" id="Estudando" <?php if ($pessoa->fields['Estudando'] == "S") echo " checked "; ?> class="campo" />Está Estudando?
								<input type="checkbox" name="EstaTrabalhando" value="S" aria-label = "Trabalhando" id="EstaTrabalhando" <?php if ($pessoa->fields['EstaTrabalhando'] == "S") echo " checked "; ?> class="campo" />Está Trabalhando?
							</div>
							<div class="listagem-campos">
								<div class="label-campos">&nbsp;</div>
								Data da Última atualização: <?php echo DataUtil::getDataExtenso($pessoa->fields['UltAlteracao']); ?>
							</div>
						</fieldset>
						
						
                        <?php 
						if ((!$campoVisiveis->ExisteVariavel('Nacionalidade')) || (!$campoVisiveis->ExisteVariavel('ValidadeVisto')) || (!$campoVisiveis->ExisteVariavel('AnoChegadaBrasil')) || (!$campoVisiveis->ExisteVariavel('TipoVisto'))  )  {
						?>
						<fieldset><legend>Nacionalidade</legend>
                        <?php if (!$campoVisiveis->ExisteVariavel('Nacionalidade')) { ?>
							<div class="listagem-campos">
								<div class="label-campos">Nacionalidade:</div>
								<select id="Nacionalidade" name="Nacionalidade" aria-label = "Nacionalidade" class="campo" style="width: 160px;">
									<option value="">Selecione ... </option>
								<?php if ($listaNacionalidade != NULL) {
								while (!$listaNacionalidade->EOF) { ?>
								
			   						<option value="<?php echo $listaNacionalidade->fields['Nacionalidade']; ?>" <?php if ($listaNacionalidade->fields['Nacionalidade'] == $pessoa->fields['Nacionalidade']) echo " selected "; ?>>
			   						<?php echo $listaNacionalidade->fields['Descricao20']; ?>
			   						</option>
			   					<?php $listaNacionalidade->MoveNext(); } }?>
								</select>
								<?php if ($variavelObrigatorios->ExisteVariavel('Nacionalidade')){ echo '<a class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Nacionalidade").setAttribute("aria-label", "Nacionalidade Campo Obrigatório"); </script>';}?>							
								<div id="valorNacionalidade" name="valorNacionalidade"></div>
								
							</div>
                             <?php } ?>
							
							<script>
							    jQuery("#Nacionalidade").change(function () {						    	
							    	
							    	if (jQuery(this).val() == "10"){
							    		jQuery('#AnoChegadaBrasil').attr('disabled', true);
							    		jQuery('#ValidadeVisto').attr('disabled', true);
							    		jQuery('#TipoVisto').attr('disabled', true);
							    		jQuery('#AnoChegadaBrasil').removeClass('campo');
							    		jQuery('#ValidadeVisto').removeClass('campo');
							    		jQuery('#TipoVisto').removeClass('campo');
							    		jQuery('#AnoChegadaBrasil').attr('class', 'campo-disabled');
							    		jQuery('#ValidadeVisto').attr('class', 'campo-disabled');
							    		jQuery('#TipoVisto').attr('class', 'campo-disabled');
							    		
							    		jQuery('#Visto1').hide();
							    		jQuery('#Visto2').show();						    									  
					    		
							        } else { 
							        	jQuery('#AnoChegadaBrasil').attr('disabled', false);
							        	jQuery('#ValidadeVisto').attr('disabled', false);
							        	jQuery('#TipoVisto').attr('disabled', false);
							        	jQuery('#AnoChegadaBrasil').removeClass('campo-disabled');
							    		jQuery('#ValidadeVisto').removeClass('campo-disabled');
							    		jQuery('#TipoVisto').removeClass('campo-disabled');
							    		jQuery('#AnoChegadaBrasil').attr('class', 'campo');
							    		jQuery('#ValidadeVisto').attr('class', 'campo');
							    		jQuery('#TipoVisto').attr('class', 'campo');
							    		
							    		jQuery('#Visto2').hide();
							    		jQuery('#Visto1').show();
							        }    

                                }) 
							</script>
							
                             <?php if (!$campoVisiveis->ExisteVariavel('ValidadeVisto')) { ?>
							    <div class="listagem-campos" id="Visto1">
								    <div class="label-campos">Validade do Visto:</div>
								    <input type="text" aria-label = "Validade do Visto" <?php if ($pessoa->fields['Nacionalidade'] == '10' ){ ?>  disabled="disabled" <?php }?> class ="campo" size="12" id="ValidadeVisto" name="ValidadeVisto" value="<?php echo $dateUtil->formatDate($pessoa->fields['ValidadeVisto']); ?>" />
								    <?php if ($variavelObrigatorios->ExisteVariavel('ValidadeVisto')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("ValidadeVisto").setAttribute("aria-label", "Validade do Visto Campo Obrigatório"); </script>';}?>							
				  			    </div>	
				  			
				  			    <div class="listagem-campos" id="Visto2">
								    <div class="label-campos">Validade do Visto:</div>
								    <input type="text"  aria-label="Validade do Visto2" disabled="disabled" class ="campo" size="12" id="ValidadeVisto2" name="ValidadeVisto2" value="<?php echo $dateUtil->formatDate($pessoa->fields['ValidadeVisto']); ?>" />
								    <?php if ($variavelObrigatorios->ExisteVariavel('ValidadeVisto')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("ValidadeVisto2").setAttribute("aria-label", "Validade do Visto2 Campo Obrigatório"); </script>';}?>							
							    </div>
                             <?php } ?>

							<?php if (!$campoVisiveis->ExisteVariavel('AnoChegadaBrasil')) { ?>																
							<div class="listagem-campos">
								<div class="label-campos">Ano Chegada Brasil:</div>
								<input type="text" aria-label = "Ano de Chegada no Brasil" <?php if ($pessoa->fields['Nacionalidade'] == '10' ){ ?>  disabled="disabled" <?php }?> class="campo" size="12" id="AnoChegadaBrasil" name="AnoChegadaBrasil" value="<?php echo $pessoa->fields['AnoChegadaBrasil']; ?>" />
								<?php if ($variavelObrigatorios->ExisteVariavel('AnoChegadaBrasil')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("AnoChegadaBrasil").setAttribute("aria-label", "Ano de Chegada no Brasil Campo Obrigatório"); </script>';}?>
							</div>
                             <?php } ?>
                             <?php if (!$campoVisiveis->ExisteVariavel('TipoVisto')) { ?>		
							<div class="listagem-campos">
								<div class="label-campos">Visto:</div>
								<select id="TipoVisto" aria-label = "Visto" <?php if ($pessoa->fields['Nacionalidade'] == '10' ){ ?>  disabled="disabled" <?php }?> name="TipoVisto" class="campo" style="width: 160px;">
									<option value="">Selecione ... </option>
									<?php if ($listaOpcaoTipoVisto != NULL) {
									while (!$listaOpcaoTipoVisto->EOF) { ?>
				   						<option value="<?php echo $listaOpcaoTipoVisto->fields['Opcao']; ?>" <?php if ($listaOpcaoTipoVisto->fields['Opcao'] == $pessoa->fields['TipoVisto']) echo " selected "; ?>>
				   						<?php echo $listaOpcaoTipoVisto->fields['Descricao60']; ?>
				   						</option>
				   					<?php $listaOpcaoTipoVisto->MoveNext(); } }?>
								</select>
								<?php if ($variavelObrigatorios->ExisteVariavel('TipoVisto')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("TipoVisto").setAttribute("aria-label", "Visto Campo Obrigatório"); </script>';}?>
							</div>
                            <?php } ?>
						</fieldset>
                         <?php } ?>
						
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
  <?php 
      if ((!$campoVisiveis->ExisteVariavel('Identidade')) ||
          (!$campoVisiveis->ExisteVariavel('TipoIdentidade')) || 
          (!$campoVisiveis->ExisteVariavel('ConselhoClasse')) || 
          (!$campoVisiveis->ExisteVariavel('RegistroConselho')) ||
          (!$campoVisiveis->ExisteVariavel('DataRegistro')) || 
          (!$campoVisiveis->ExisteVariavel('RegistroHabilitacao')) || 
          (!$campoVisiveis->ExisteVariavel('CategoriaHabilitacao')) || 
          (!$campoVisiveis->ExisteVariavel('ValidadeHabilitacao')) || 
          (!$campoVisiveis->ExisteVariavel('PIS')) || 
          (!$campoVisiveis->ExisteVariavel('DataPIS')))  {
      ?>
		<div class="div-box">
			<div class="titulo-documentos" tabindex="0" aria-label="Documentos Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
						<?php if ((!$campoVisiveis->ExisteVariavel('Identidade')) || (!$campoVisiveis->ExisteVariavel('TipoIdentidade')  )) { ?>
						<div class="listagem-campos">
							<div class="label-campos">Identidade:</div>
                            <?php if (!$campoVisiveis->ExisteVariavel('Identidade')) { ?>
							    <input type="text" class="campo" aria-label = "Identidade" size="15" id="Identidade" name="Identidade" value="<?php echo $pessoa->fields['Identidade']; ?>" maxLength="15"/>
							    <?php if ($variavelObrigatorios->ExisteVariavel('Identidade')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Identidade").setAttribute("aria-label", "Identidade Campo Obrigatório"); </script>';}?>
                            <?php } ?>
                            <?php if (!$campoVisiveis->ExisteVariavel('TipoIdentidade')) { ?>
							    <select id="TipoIdentidade" name="TipoIdentidade" aria-label = "Tipo de Identidade" class="campo" style="width: 160px;">
								    <option value="">Selecione ... </option>
								    <?php if ($listaOpcaoTipoIdentidade != NULL) {
								    while (!$listaOpcaoTipoIdentidade->EOF) { ?>
			   						    <option value="<?php echo $listaOpcaoTipoIdentidade->fields['Opcao']; ?>" <?php if ($listaOpcaoTipoIdentidade->fields['Opcao'] == $pessoa->fields['TipoIdentidade']) echo " selected "; ?>>
			   						    <?php echo $listaOpcaoTipoIdentidade->fields['Descricao60']; ?>
			   						    </option>
			   					    <?php $listaOpcaoTipoIdentidade->MoveNext(); } }?>
							    </select>
							        <?php if ($variavelObrigatorios->ExisteVariavel('TipoIdentidade')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("TipoIdentidade").setAttribute("aria-label", "Tipo de Identidade Campo Obrigatório"); </script>';}?>
                                <?php } ?>
						</div>
                        <?php } ?>
                          <?php 
                          if ((!$campoVisiveis->ExisteVariavel('ConselhoClasse')) ||
                              (!$campoVisiveis->ExisteVariavel('RegistroConselho')) || 
                              (!$campoVisiveis->ExisteVariavel('DataRegistro')))  {
                          ?>
						    <div style='float:left'>
							    <fieldset style='width:310px;'><legend>Habilitação Profissional</legend>
                                 <?php if (!$campoVisiveis->ExisteVariavel('ConselhoClasse')) { ?>
								    <div class="listagem-campos">
									    <div class="label-campos">Conselho de Classe:</div>
									    <input type="text" class="campo" size="8" id="ConselhoClasse" aria-label = "Conselho de Classe" name="ConselhoClasse" value="<?php echo $pessoa->fields['ConselhoClasse']; ?>" maxLength="8"/>
									    <?php if ($variavelObrigatorios->ExisteVariavel('ConselhoClasse')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("ConselhoClasse").setAttribute("aria-label", "Conselho de Classe Campo Obrigatório"); </script>';}?>
								    </div>
                                 <?php } ?>
                                 <?php if (!$campoVisiveis->ExisteVariavel('RegistroConselho')) { ?>
								    <div class="listagem-campos">
									    <div class="label-campos">Registro no Conselho:</div>
									    <input type="text" class="campo" size="12" id="RegistroConselho" name="RegistroConselho" aria-label = "Registro no Conselho" value="<?php echo $pessoa->fields['RegistroConselho']; ?>" maxLength="12"/>
									    <?php if ($variavelObrigatorios->ExisteVariavel('RegistroConselho')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("RegistroConselho").setAttribute("aria-label", "Registro no Conselho Campo Obrigatório"); </script>';}?>
								    </div>
                                 <?php } ?>
                                 <?php if (!$campoVisiveis->ExisteVariavel('DataRegistro')) { ?>
								    <div class="listagem-campos">
									    <div class="label-campos">Data Registro:</div>
									    <input type="text" class="campo" size="12" id="DataRegistro" aria-label = "Data do Registro" name="DataRegistro" value="<?php if ($pessoa->fields['DataRegistro'] != "")echo $dateUtil->formatDate($pessoa->fields['DataRegistro']); ?>" />
									    <?php if ($variavelObrigatorios->ExisteVariavel('DataRegistro')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("DataRegistro").setAttribute("aria-label", "Data do Registro Campo Obrigatório"); </script>';}?>
								    </div>	
                                 <?php } ?>
       						    </fieldset>
       					    </div>
	                    <?php } ?>
                          <?php 
                          if ((!$campoVisiveis->ExisteVariavel('RegistroHabilitacao')) ||
                              (!$campoVisiveis->ExisteVariavel('CategoriaHabilitacao')) || 
                              (!$campoVisiveis->ExisteVariavel('ValidadeHabilitacao')))  {
                          ?>
                          <?php 
                          if (($campoVisiveis->ExisteVariavel('ConselhoClasse')) &&
                              ($campoVisiveis->ExisteVariavel('RegistroConselho')) && 
                              ($campoVisiveis->ExisteVariavel('DataRegistro'))  && 
                              ($campoVisiveis->ExisteVariavel('PIS')) && 
                              ($campoVisiveis->ExisteVariavel('DataPIS')))  {
                          ?>
       					    <div style='float: left'>
                          <?php } else { ?>
                               <div style='float: right'>
                           <?php }  ?>
       						    <fieldset style='width:310px;'><legend>Carteira Nacional de Habilitação</legend>
                                   <?php if (!$campoVisiveis->ExisteVariavel('RegistroHabilitacao')) { ?>
       							        <div class="listagem-campos">
       								        <div class="label-campos">Nº do Registro:</div>
       								        <input type="text" class="campo" size="15" aria-label = "Número do Registro" id="RegistroHabilitacao" name="RegistroHabilitacao" value="<?php echo $pessoa->fields['RegistroHabilitacao']; ?>" maxLength="15"/>
       								        <?php if ($variavelObrigatorios->ExisteVariavel('RegistroHabilitacao')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("RegistroHabilitacao").setAttribute("aria-label", "Número do Registro Campo Obrigatório"); </script>';}?>
       							        </div>
                                   <?php } ?>
                                   <?php if (!$campoVisiveis->ExisteVariavel('CategoriaHabilitacao')) { ?>
       							        <div class="listagem-campos">
       								        <div class="label-campos">Categoria:</div>
       								        <input type="text" class="campo" size="3" id="CategoriaHabilitacao" aria-label = "Categoria de Habilitação" name="CategoriaHabilitacao" value="<?php echo $pessoa->fields['CategoriaHabilitacao']; ?>" maxLength="3"/>
       								        <?php if ($variavelObrigatorios->ExisteVariavel('CategoriaHabilitacao')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("CategoriaHabilitacao").setAttribute("aria-label", "Categoria de Habilitação do Registro Campo Obrigatório"); </script>';}?>
       							        </div>
                                   <?php } ?>
                                   <?php if (!$campoVisiveis->ExisteVariavel('ValidadeHabilitacao')) { ?>
       							    <div class="listagem-campos">
       								    <div class="label-campos">Validade:</div>
       								    <input type="text" class="campo" size="12" id="ValidadeHabilitacao" aria-label = "Validade Habilitação" name="ValidadeHabilitacao" value="<?php if ($pessoa->fields['ValidadeHabilitacao'] != "")echo $dateUtil->formatDate($pessoa->fields['ValidadeHabilitacao']); ?>"/>
       								    <?php if ($variavelObrigatorios->ExisteVariavel('ValidadeHabilitacao')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("ValidadeHabilitacao").setAttribute("aria-label", "Validade Habilitação Campo Obrigatório"); </script>';}?>
       							    </div>
                                   <?php } ?>       							
       						    </fieldset>
       					    </div>
                          <?php } ?>
                          <?php 
                          if ((!$campoVisiveis->ExisteVariavel('PIS')) ||
                              (!$campoVisiveis->ExisteVariavel('DataPIS')))  {
                          ?>
						    <div style='float:left'>
							    <fieldset style='width:310px;'><legend>PIS</legend>
                                    <div class="listagem-campos">   
                                        <div class="label-campos">&nbsp;</div>                                                                   
                                        <input type="checkbox" name="PossuiPIS" value="S"  id="PossuiPIS" aria-label = "Possui PIS " class="campo" onchange="curriculoWebUtil.habilitar();""
                                        <?php if ($pessoa->fields['PossuiPIS'] == "S") echo " checked "; ?>/>Possui PIS?                                                                        
                                    </div>	
                                  <?php if (!$campoVisiveis->ExisteVariavel('PIS')) { ?>
								    <div class="listagem-campos">                                                                      
									    <div class="label-campos">Número do PIS:</div>
									    <input type="text" class="campo" aria-label = "Número do Pis" <?php if ($pessoa->fields['PossuiPIS'] == "N" ){ ?>  disabled="disabled" <?php }?> size="11" id="PIS" name="PIS" value="<?php echo $pessoa->fields['PIS']; ?>" maxLength="11"/>
									    <?php if ($variavelObrigatorios->ExisteVariavel('PIS')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("PIS").setAttribute("aria-label", "Número do Pis Campo Obrigatório"); </script>';}?>
								    </div>
                                  <?php } ?>
                                  <?php if (!$campoVisiveis->ExisteVariavel('DataPIS')) { ?>
								    <div class="listagem-campos" id="CampoPIS">
									    <div class="label-campos">Data do Cadastro:</div>
                                        <input type="text" class="campo" aria-label = "Data do Cadastro" <?php if ($pessoa->fields['PossuiPIS'] == "N" ){ ?>  disabled="disabled" <?php }?>size="12" id="DataPIS" name="DataPIS" value="<?php if ($pessoa->fields['DataPIS'] != "")echo $dateUtil->formatDate($pessoa->fields['DataPIS']); ?>" />
									    <?php if ($variavelObrigatorios->ExisteVariavel('DataPIS')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("DataPIS").setAttribute("aria-label", "Data do Cadastro Campo Obrigatório"); </script>';}?>
								    </div>
                                  <?php } ?>	                           
       						    </fieldset>
       					    </div>
						<?php } ?>	
       					<div style='clear:both'></div>
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
        <?php } ?>

		<div class="div-box">
			<div class="titulo-dados-de-contato" tabindex="0" aria-label="Dados de Contato Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
						<?php if (!$campoVisiveis->ExisteVariavel('Cep')) { ?>
						    <div class="listagem-campos">
							    <div class="label-campos">CEP:</div>
							    <input type="text" class="campo" size="15" id="Cep" name="Cep" aria-label = "CEP" value="<?php echo $pessoa->fields['Cep']; ?>" />
                                <?php if ($variavelObrigatorios->ExisteVariavel('Cep')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Cep").setAttribute("aria-label", "Cep Campo Obrigatório"); </script>';}?>
						    </div>
	                    <?php } ?>
                        <?php if ((!$campoVisiveis->ExisteVariavel('Rua')) ||
                                  (!$campoVisiveis->ExisteVariavel('NroRua')) ) { ?>     
						<div class="listagem-campos">
                        <?php if (!$campoVisiveis->ExisteVariavel('Rua')) { ?>
							<div class="label-campos">Logradouro:</div>
							<div style="float: left; width: 200px;"><input type="text" class="campo" aria-label = "Logradouro" size="40" id="Rua" name="Rua" value="<?php echo $pessoa->fields['Rua']; ?>" style="width:180px;" maxLength="40"/>
								<?php if ($variavelObrigatorios->ExisteVariavel('Rua')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Rua").setAttribute("aria-label", "Logradouro Campo Obrigatório"); </script>';}?>	</div>
                        <?php } ?>
                        <?php if (!$campoVisiveis->ExisteVariavel('NroRua')) { ?>
							<div class="label-campos">Numero:</div>
							<div style="float: left;"><input type="text" class="campo" size="8" id="NroRua" name="NroRua" aria-label = "Número da Rua" value="<?php echo $pessoa->fields['NroRua']; ?>" maxLength="8"/>
									<?php if ($variavelObrigatorios->ExisteVariavel('NroRua')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("NroRua").setAttribute("aria-label", "Número da Rua Campo Obrigatório"); </script>';}?></div>
                         <?php } ?>
							<div class="clear"></div>
						</div>
						<?php } ?>
                        <?php if ((!$campoVisiveis->ExisteVariavel('Complemento')) ||
                                  (!$campoVisiveis->ExisteVariavel('Bairro')) ) { ?> 
						    <div class="listagem-campos">
                            <?php if (!$campoVisiveis->ExisteVariavel('Complemento')) { ?>
							    <div class="label-campos">Complemento:</div>
							    <div style="float: left; width: 200px;"><input type="text" class="campo" size="13" aria-label = "Complemento" id="Complemento" name="Complemento" value="<?php echo $pessoa->fields['Complemento']; ?>" maxLength="13"/>
								    <?php if ($variavelObrigatorios->ExisteVariavel('Complemento')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Complemento").setAttribute("aria-label", "Complemento Campo Obrigatório"); </script>';}?></div>
                            <?php } ?>
                            <?php if (!$campoVisiveis->ExisteVariavel('Bairro')) { ?>
							    <div class="label-campos">Bairro:</div>
							    <div style="float: left;"><input type="text" class="campo" size="25" id="Bairro" aria-label = "Bairro" name="Bairro" maxlength="20" value="<?php echo $pessoa->fields['Bairro']; ?>" />
								    <?php if ($variavelObrigatorios->ExisteVariavel('Bairro')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Bairro").setAttribute("aria-label", "Bairro Campo Obrigatório"); </script>';}?></div>
                            <?php } ?>
							    <div class="clear"></div>
						    </div>
	                    <?php } ?>

                        <?php if (!$campoVisiveis->ExisteVariavel('UF')) { ?>
						<div class="listagem-campos">
							<div class="label-campos">UF:</div>
							<select id="UF" name="UF" class="campo" aria-label = "UF" onchange="curriculoWebUtil.buscarCidadesPorUF('UF', 'Cidade');" style="width: 80px;">
								<option value="">Selecione ... </option>
							<?php if ($listaOpcaoUF != NULL) {
							while (!$listaOpcaoUF->EOF) { ?>
			   					<option value="<?php echo $listaOpcaoUF->fields['Opcao']; ?>" <?php if ($listaOpcaoUF->fields['Opcao'] == $pessoa->fields['UF']) echo " selected "; ?>>
			   					<?php echo $listaOpcaoUF->fields['Descricao60']; ?>
			   					</option>
			   				<?php $listaOpcaoUF->MoveNext(); } }?>
			   				</select>
			   				<?php if ($variavelObrigatorios->ExisteVariavel('UF')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("UF").setAttribute("aria-label", "UF Campo Obrigatório"); </script>';}?>
						</div> 
                        <?php } ?>                      

                        <?php if (!$campoVisiveis->ExisteVariavel('Cidade')) { ?>
						    <div class="listagem-campos">
							    <div class="label-campos">Cidade:</div>
                                <select id="Cidade" name="Cidade" class="campo" aria-label = "Cidade" style="width: 160px;" title="Selecione a UF para visualizar as Cidades">
								    <option value="">Selecione ... </option>
							    <?php if ($listaOpcaoCidade != NULL) {
                                          while (!$listaOpcaoCidade->EOF) { ?>
			   					    <option value="<?php echo $listaOpcaoCidade->fields['Cidade']; ?>" <?php if ($listaOpcaoCidade->fields['Cidade'] == $pessoa->fields['Cidade']) echo " selected "; ?>>
			   					    <?php echo $listaOpcaoCidade->fields['Descricao80']; ?>
			   					    </option>
			   				    <?php $listaOpcaoCidade->MoveNext();
                                          }
                                      }?>
			   				    </select>
			   				    <?php if ($variavelObrigatorios->ExisteVariavel('Cidade')){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Cidade").setAttribute("aria-label", "Cidade Campo Obrigatório"); </script>';}?>                                
						    </div>
                        <?php } ?> 
						<?php if ((!$campoVisiveis->ExisteVariavel('DDD')) ||
                                  (!$campoVisiveis->ExisteVariavel('Telefone')) ) { ?>
						    <div class="listagem-campos">
                                <?php if (!$campoVisiveis->ExisteVariavel('DDD')) { ?>
							        <div class="label-campos">DDD:</div>
							        <input type="text" class="campo" size="4" id="DDD" aria-label = "DDD" name="DDD" value="<?php echo $pessoa->fields['DDD']; ?>" maxLength="4"/><?php if ($variavelObrigatorios->ExisteVariavel('DDD')){ echo '<a  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("DDD").setAttribute("aria-label", "DDD Campo Obrigatório"); </script>';}?>
                                <?php } ?>
                                <?php if (!$campoVisiveis->ExisteVariavel('Telefone')) { ?> 
							    Telefone Res.:
							    <input type="text" class="campo" size="15" id="Telefone" aria-label = "Telefone Residencial" name="Telefone" value="<?php echo $pessoa->fields['Telefone']; ?>" maxLength="15"/>
							    <?php if ($variavelObrigatorios->ExisteVariavel('Telefone')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("Telefone").setAttribute("aria-label", "Telefone Residencia Campo Obrigatório"); </script>';}?>
                                <?php } ?>
						    </div>
                        <?php } ?> 
                        <?php if ((!$campoVisiveis->ExisteVariavel('DDDCelular')) ||
                                  (!$campoVisiveis->ExisteVariavel('TelefoneCelular')) ) { ?>
						            <div class="listagem-campos">
                                    <?php if (!$campoVisiveis->ExisteVariavel('DDDCelular')) { ?>
							            <div class="label-campos">DDD Celular:</div>
							            <input type="text" class="campo" size="4" id="DDDCelular" aria-label = "DDD Celular" name="DDDCelular" value="<?php echo $pessoa->fields['DDDCelular']; ?>" maxLength="4"/>
							            <?php if ($variavelObrigatorios->ExisteVariavel('DDDCelular')){ echo '<a   class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("DDDCelular").setAttribute("aria-label", "DDD Celular Campo Obrigatório"); </script>';}?>
                                    <?php } ?>
                                    <?php if (!$campoVisiveis->ExisteVariavel('TelefoneCelular')) { ?> 
							            Telefone Celular:
							            <input type="text" class="campo" size="15" id="TelefoneCelular" name="TelefoneCelular" aria-label = "Telefone Celular" value="<?php echo $pessoa->fields['TelefoneCelular']; ?>" maxLength="15"/>
							            <?php if ($variavelObrigatorios->ExisteVariavel('TelefoneCelular')){ echo '<a   tabindex="0"  class="asterisco">*</a>';echo '<script type="text/javascript"> document.getElementById("TelefoneCelular").setAttribute("aria-label", "Telefone Celular Campo Obrigatório"); </script>';}?>
                                    <?php } ?>
						            </div>
                        <?php } ?> 
						<div class="listagem-campos">
							<div class="label-campos">E-mail:</div>
							<input type="text" class="campo" size="75" id="Email" name="Email" aria-label = "Email Campo Obrigatório" value="<?php echo $pessoa->fields['Email']; ?>" maxLength="80"/><a   class="asterisco">*</a>
						</div>
	
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>	
	<div class="clear"></div>


		<?php 
		// FAZER IFS DE NAVEGACAO
		$avancarModulo = "";
		$avancarEntidade = "";
		if ($_SESSION["ExibirDadosCompl"] == "S" || $_SESSION["ExibirRequisitos"] == "S") {
			$avancarModulo = "informacoesAdicionais";
			$avancarEntidade = "informacoesAdicionais";
		} else if ($_SESSION["ExibirCursos"] == "S") {
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

    <div style=" float: right;" >
		
		<?php 
		if ($avancarModulo != "") {
		?>
		<input type="button"  id="BotaoAvancar" class="botao-avancar"  aria-label = "Avançar" onClick="if (curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
            if (jQuery('#PretensaoSalarial').length > 0) curriculoWebUtil.addCampoAlterado('PretensaoSalarial', jQuery('#PretensaoSalarial').val());
            curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
            curriculoWebUtil.avancar({modulo: '<?php echo $avancarModulo; ?>', entidade:'<?php echo $avancarEntidade; ?>'}); }"></input>
		<?php   
		}
		?>

        	<input type="button"  id="BotaoConcluir"    class="botao-concluir" aria-label = "Concluir"   onClick="if ( curriculoWebUtil.validarCamposObrigatorios(validacaoCampos) && curriculoWebUtil.validarCamposInformacoesPessoais()) { 
            if (jQuery('#PretensaoSalarial').length > 0) curriculoWebUtil.addCampoAlterado('PretensaoSalarial',jQuery('#PretensaoSalarial').val()); 
            curriculoWebUtil.salvar({modulo: 'pessoa', entidade:'informacoesPessoais', acao:'salvar'});
            curriculoWebUtil.concluido(); }"></input>

    </div>

				<div class="clear"></div>

		<div class="clear"></div>
	</div>
</div>

<div id="camposFoto" title="Fazer upload de uma foto" style="font-size: 11px; font-family: Arial; ">
	<iframe src="index.php?modulo=upload&acao=formFoto" height="100%" width="400px">Seu navegador n?o suporta iframes.</iframe>
</div>
<div id="camposAnexo" title="Fazer upload de um anexo" style="font-size: 11px; font-family: Arial; ">
	<iframe src="index.php?modulo=upload&acao=formAnexo" height="100%" width="100%">Seu navegador não suporta iframes.</iframe>
</div>

<script>

carregaFotoCandidato();

jQuery("#Foto").click(function(){
	jQuery("#camposFoto").dialog('open');			
	
});

jQuery("#linkFoto2").click(function(){
	jQuery("#camposFoto").dialog('open');
});

jQuery("#botaoIncluirAnexo").click(function () {
    jQuery("#camposAnexo").dialog('open');
    });


//Executar depois que tudo for montado
$(document).ready(function(){

	document.getElementById("Nascimento").addEventListener("focus", function(){
		if( $("#ui-datepicker-div").css("display") === 'none')
		{
			$($("#Nascimento").parent()[0]).find('img.ui-datepicker-trigger').click();
		}
	});

    var validadevisto = document.getElementById("ValidadeVisto");

    if (validadevisto)
    {
	    validadevisto.addEventListener("focus", function(){
		if( $("#ui-datepicker-div").css("display") === 'none')
		{
			$($("#ValidadeVisto").parent()[0]).find('img.ui-datepicker-trigger').click();
		}

        });
   }
    
   var DataRegistro = document.getElementById("DataRegistro");

   if (DataRegistro)
   {
   	 DataRegistro.addEventListener("focus", function(){
		if( $("#ui-datepicker-div").css("display") === 'none')
		{
			$($("#DataRegistro").parent()[0]).find('img.ui-datepicker-trigger').click();
		}
	});
   }
    
  var ValidadeHabilitacao = document.getElementById("ValidadeHabilitacao");
  
  if(ValidadeHabilitacao)
  {
  	ValidadeHabilitacao.addEventListener("focus", function(){
		if( $("#ui-datepicker-div").css("display") === 'none')
		{
			$($("#ValidadeHabilitacao").parent()[0]).find('img.ui-datepicker-trigger').click();
		}
	});
  }

  var DataPIS = document.getElementById("DataPIS");
  
  if (DataPIS)
  {
  	 DataPIS.addEventListener("focus", function(){
		if( $("#ui-datepicker-div").css("display") === 'none')
		{
			$($("#DataPIS").parent()[0]).find('img.ui-datepicker-trigger').click();
		}
    });
  }
	
});


</script>