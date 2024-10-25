<div class="content-interna">
	<div class="alinhamento">
		<div tabindex="0">Pesquise abaixo as vagas, oportunidades de trabalho e emprego disponíveis.</div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-pesquisar-vagas" tabindex="0" aria-label="Pesquisar Vagas Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
						
						<form action="index.php" >
						
							<div class="listagem-campos">
								<div class="label-campos">Cargo:</div>
								<select id="Cargo" name="Cargo" class="campo" style="width: 340px;" value ="Cargo">
									<option value="" aria-label="Cargo">Selecione o Cargo... </option>
								<?php 
								if (!is_null($listaCargo)){
									while (!$listaCargo->EOF) { ?>
				   						<option value="<?php echo $listaCargo->fields['Cargo']; ?>"><?php echo $listaCargo->fields['Descricao40']; ?></option>
				   					<?php $listaCargo->MoveNext(); 
									}
								} ?>
								</select>
							</div>
							<div class="listagem-campos">
								<div class="label-campos">Função:</div>
								<select id="Funcao" name="Funcao" class="campo" style="width: 340px;">
									<option value="" aria-label="Função">Selecione ... </option>
								<?php 
								if (!is_null($listaFuncao)){
									while (!$listaFuncao->EOF) { ?>
				   						<option value="<?php echo $listaFuncao->fields['Funcao']; ?>"><?php echo $listaFuncao->fields['Descricao40']; ?></option>
				   					<?php $listaFuncao->MoveNext(); 
									}
								} ?>
								</select>
							</div>
							<div class="listagem-campos">
								<div class="label-campos">Área de Atuação:</div>
								<select id="AreaAtuacao" name="AreaAtuacao" class="campo" style="width: 340px;">
									<option value="" aria-label="Área de Atuação">Selecione ... </option>
								<?php 
								if (!is_null($listaAreaAtuacao)){
									while (!$listaAreaAtuacao->EOF) { ?>
				   						<option value="<?php echo $listaAreaAtuacao->fields['AreaAtuacao']; ?>"><?php echo $listaAreaAtuacao->fields['Descricao60']; ?></option>
				   					<?php $listaAreaAtuacao->MoveNext(); 
									}
								} ?>
								</select>
							</div>
							<div class="listagem-campos">
								<div class="label-campos">Região:</div>
								<select id="Regiao" name="Regiao" class="campo" style="width: 340px;">
									<option value=""  aria-label="Região">Selecione ... </option>
								<?php 
								if (!is_null($listaRegiao)){
									while (!$listaRegiao->EOF) { ?>
				   						<option value="<?php echo $listaRegiao->fields['Regiao']; ?>"><?php echo $listaRegiao->fields['Descricao60']; ?></option>
				   					<?php $listaRegiao->MoveNext(); 
									}
								} ?>
								</select>
							</div>							
							<div class="listagem-campos">
								<div class="label-campos">Vínculo Empregatício:</div>
								<select id="VinculoEmpregaticio" name="VinculoEmpregaticio" class="campo" style="width: 340px;">
									<option value="" aria-label="Vínculo Empregaticio">Selecione ... </option>
								<?php 
								if (!is_null($listaVinculoEmpregaticio)){
									while (!$listaVinculoEmpregaticio->EOF) { ?>
				   						<option value="<?php echo $listaVinculoEmpregaticio->fields['VinculoEmpregaticio']; ?>"><?php echo $listaVinculoEmpregaticio->fields['Descricao40']; ?></option>
				   					<?php $listaVinculoEmpregaticio->MoveNext(); 
									}
								} ?>
								</select>
							</div>
							<div class="listagem-campos">
								<div class="label-campos">Faixa Salarial(R$):</div>
								<input type="text" class="campo" size="18" id="SalarioInicio" name="SalarioInicio" aria-label="Faixa Salarial"/> até    
								<input type="text" class="campo" size="18" id="SalarioFim" name="SalarioFim" aria-label="Ate" />
							</div>
							
							<fieldset style="padding-left: 20px;">
								<legend>Situação da Vaga</legend>
								<div class="listagem-campos">
								    <div class="label-campos">&nbsp;</div>
									<input type="checkbox" id="SituacaoRequisicaoAberta" name="SituacaoRequisicaoAberta" value="N" class="campo" aria-label="Aberta"/>Aberta
									<input type="checkbox" id="SituacaoRequisicaoSuspensa" name="SituacaoRequisicaoSuspensa" value="S" class="campo" aria-label="Suspensa"/>Suspensa
									<input type="checkbox" id="SituacaoRequisicaoEncerrada" name="SituacaoRequisicaoEncerrada" value="E" class="campo" aria-label="Encerrada"/>Encerrada
									
								</div>
							</fieldset>
							<div class="listagem-campos">
								<div class="label-campos">&nbsp;</div>
								<input type="button" class="botao-filtrar" style="float: none; margin-bottom: 10px; margin-top: 10px;" aria-label="Filtrar" 
								onclick="vagaUtil.pesquisar(this.form);" >
							</div>
						
						</form>
						<div class="clear"></div>
						
						
						<div class="borda-tabela">
							<table id="tableListVaga" class="informacoes-academicas" width="655px">
								
							</table>	
						</div>
						
						
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="clear"></div>
	
	</div>
</div>