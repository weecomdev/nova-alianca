<?php
   global $configObj;
   $infoIncompletas = new InfoIncompletas($this->db); 
   $valorDiretrizInteresse = $configObj->getValorDiretriz('ObrigarPreenchimentoCamposObrParaVagas');
   $limiteInscricoesVagasSimultaneas = $configObj->getValorDiretriz('limiteInscricoesVagasSimultaneas');
   $mensagemLimiteInscricoes = $configObj->getValorDiretriz('mensagemLimiteInscricoesVagas');
   if (($mensagemLimiteInscricoes == null) || ($mensagemLimiteInscricoes == ""))
       $mensagemLimiteInscricoes = "Você não pode concorrer a mais vagas pois ultrapassou o limite permitido.";
   $existeCampoVazio = $infoIncompletas->existeCampoVazio();
   $diretrizSalarioOferecido = $configObj->getValorDiretriz('exibirSalarioOferecido');   
?>
<div class="content-interna">
	<div class="alinhamento">
		<div tabindex="0">Confira abaixo as vagas, oportunidades de trabalho e emprego disponíveis.</div>
		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-detalhes-vaga" tabindex="0" aria-label="Detalhes da Vaga Grupo">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
						<div class="vaga-descricao">
							<div class="vaga-titulo" tabindex="0"><?php echo $requisicao->fields['Funcao']!=""?$requisicao->fields['nomeFuncao']:$requisicao->fields['nomeCargo']; ?> (<?php echo $requisicao->fields['QuantidadeVagas']; ?>)</div>
							<?php echo nl2br($requisicao->fields['DescricaoAtividades']); ?>
						</div>
						
						<div class="vaga-candidatar" tabindex="0">				  												
						<?php if (( $requisicoesTurma == null) &&  (($requisicao->fields['SituacaoRequisicao']) == "N")){ ?>										
                          <?php if(($existeCampoVazio)&& ($valorDiretrizInteresse == 2)) { ?>						  
                                    <br> Para concorrer a esta vaga você deve preencher todos os campos obrigatórios do currí­culo. </br>
                         <?php } else if ($limiteInscricoesVagasSimultaneas != null && 
                                    $limiteInscricoesVagasSimultaneas > 0 && 
                                    $vagasConcorridas >= $limiteInscricoesVagasSimultaneas) {?>
                                    <br> <?php echo $mensagemLimiteInscricoes ?> </br>
                         <?php } else {?>
						   		<input type="button" id="botao-registrar" aria-label="Quero me candidatar a esta vaga" class="botao-quero-me-candidatar" onclick="curriculoWebUtil.registrarCandidatura({requisicao: '<?php echo $requisicao->fields['Requisicao']; ?>'});"/>							
						        <div style="display: none;" id="div-registrado" >Você está concorrendo a esta vaga</div>
                         <?php } ?> 
						  	
							   	
						 <?php } else if ($requisicoesTurma != null && $requisicoesTurma->numrows() == 1 && ($requisicao->fields['SituacaoRequisicao']) == "N"){ ?>
							<b>Você já está concorrendo a esta vaga</b>
						<?php } ?>
						</div>
						
						<div class="clear"></div>
						
						<div class="detalhe-vaga-box">
							<table class="vaga-tabela">
							    <?php if (!is_null($requisicao->fields['Requisicao'])) { ?>
							    <tr tabindex="0">
							       <th>Código da Requisição</th>
							       <td><?php echo $requisicao->fields['Requisicao']; ?></td>
							    </tr>    
                                                            <?php } ?>
								<?php if (!is_null($requisicao->fields['nomeAreaAtuacao'])) { ?>
                                                                <tr tabindex="0">
                                                                        <th>Área Atuação</th>
                                                                        <td><?php echo $requisicao->fields['nomeAreaAtuacao']; ?></td>
                                                                </tr>						
								<?php } ?>
                                                                
                                                                <?php if (!is_null($requisicao->fields['nomeRegiao'])) { ?>
                                                                <tr tabindex="0">
                                                                    <th>Região</th>
                                                                    <td><?php echo $requisicao->fields['nomeRegiao']; ?></td>
                                                                </tr>	
								<?php } ?>                                                                
                                                                
								<?php if (!is_null($requisicao->fields['SituacaoRequisicao'])) { ?>
								<tr tabindex="0">
									<th>Situação da Vaga</th>
									<td><?php 
									switch($requisicao->fields['SituacaoRequisicao']){
										case "E": echo "Encerrada"; break;
										case "N": echo "Aberta"; break;
										case "S": echo "Suspensa"; break;
                                        case "A": echo "Aguardando Aprovação"; break;
                                        case "C": echo "Cancelada"; break;
									}
									?>
									</td>
								</tr>
								<?php } ?>
								<?php if ((!is_null($requisicao->fields['InicioSelecao'])) && 
										  ("0000-00-00"!=$requisicao->fields['InicioSelecao'])) { ?>
								<tr tabindex="0">
									<th>Vaga publicada em</th>
									<td><?php echo DataUtil::formatar($requisicao->fields['InicioSelecao']); ?></td>
								</tr>
								<?php } elseif ((!is_null($requisicao->fields['DataRequisicao'])) && 
										  		("0000-00-00"!=$requisicao->fields['DataRequisicao'])) { ?>								
								<tr tabindex="0">
									<th>Vaga publicada em</th>
									<td><?php echo DataUtil::formatar($requisicao->fields['DataRequisicao']); ?></td>
								</tr>
								<?php } ?>								
								<?php if (!is_null($requisicao->fields['SituacaoRequisicao'])) { 
									    if (($requisicao->fields['SituacaoRequisicao']) == "E") {
									    	if (!is_null($requisicao->fields['Dt_Encerra'])) { ?>  											
												<tr tabindex="0">
													<th>Data de Encerramento</th>
													<td><?php echo DataUtil::formatar($requisicao->fields['Dt_Encerra']); ?></td>
												</tr>											
									<?php }
                                        } else  if(($requisicao->fields['PrazoEncerramento']) != "0000-00-00") {?>
											<tr tabindex="0">
												<th>Prazo de Encerramento</th>
												<td><?php echo DataUtil::formatar($requisicao->fields['PrazoEncerramento']); ?></td>
											</tr>								
							    <?php }} ?>
								
								<?php if (!is_null($requisicao->fields['nomeVinculoEmpregaticio'])) { ?>
								<tr tabindex="0">
									<th>Vínculo Empregatício</th>
									<td><?php echo $requisicao->fields['nomeVinculoEmpregaticio']; ?></td>
								</tr>
								<?php } ?>
								<?php if (!is_null($requisicao->fields['SalarioMaximo'])) { ?>
								<tr tabindex="0">
                                    <?php if($diretrizSalarioOferecido == 1) { ?>										
                                    <th>Salário</th>
									    <?php if (NumberUtil::formatar($requisicao->fields['SalarioMaximo']) == "0,00") { ?>
									      <td>A negociar</td>
									    <?php } else { ?>    
									    <td>R$ <?php echo NumberUtil::formatar($requisicao->fields['SalarioMaximo']); }?></td>
                                    <?php } ?>
									
								</tr>
								<?php } ?>
								<?php if (!is_null($requisicao->fields['Observacoes'])) { ?>
								<tr tabindex="0">
									<th>Observações</th>
									<td><?php echo nl2br($requisicao->fields['Observacoes']); ?></td>
								</tr>
								<?php } ?>
								
							</table>
						</div>
						
					</div>
				<div class="box-bottom"></div>
			</div>
		</div>
		
		<div class="clear"></div>
	
		<!--<div class="botao-fazer-nova-pesquisa" onclick="curriculoWebUtil.openMenu({modulo: 'vagas', entidade:'pesquisar'});" aria-label="Fazer uma nova pesquisa"></div>-->       
        <input type ="button" class="botao-fazer-nova-pesquisa" style="display:block;" onclick="curriculoWebUtil.openMenu({modulo: 'vagas', entidade:'pesquisar'});" aria-label="Fazer uma nova pesquisa"></input>
		<?php if (($requisicoesTurma != null && $requisicoesTurma->numrows() == 1  )){ ?>					
            <input type="button" aria-label = "Excluir Candidato Desta Vaga" class="botao-excluir-candidato-desta-vaga" onclick="curriculoWebUtil.removerCandidatura({requisicao: '<?php echo $requisicao->fields['Requisicao']; ?>'});"></input>
        <?php } ?> 
		<div class="clear"></div>
	</div>
</div>