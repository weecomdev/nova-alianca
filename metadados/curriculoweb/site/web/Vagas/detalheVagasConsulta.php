<?php
global $configObj;
$valorDiretrizInteresse = $configObj->getValorDiretriz('ObrigarPreenchimentoCamposObrParaVagas');
?>
<div class="content-vaga">
	<div class="alinhamento">		
		<div class="clear"></div>
		
		<div class="div-box">
			<div class="titulo-detalhes-vaga">&nbsp;</div>
			<div class="box-middle">
				<div class="box-top"></div>
					<div class="box-middle-content">	
						<div class="vaga-descricao">
							<div class="vaga-titulo"><?php echo $requisicao->fields['Funcao']!=""?$requisicao->fields['nomeFuncao']:$requisicao->fields['nomeCargo']; ?> (<?php echo $requisicao->fields['QuantidadeVagas']; ?>)</div>
							<?php echo nl2br($requisicao->fields['DescricaoAtividades']); ?>
						</div>											
						<div class="clear"></div>						
						<div class="detalhe-vaga-box">
							<table class="vaga-tabela">
							    <?php if (!is_null($requisicao->fields['Requisicao'])) { ?>
							    <tr>
							       <th>Código da Requisição</th>
							       <td><?php echo $requisicao->fields['Requisicao']; ?></td>
							    </tr>    
                                                            <?php } ?>
								<?php if (!is_null($requisicao->fields['nomeAreaAtuacao'])) { ?>
                                <tr>
                                    <th>Área Atuação</th>
                                    <td><?php echo $requisicao->fields['nomeAreaAtuacao']; ?></td>
                                </tr>						
								<?php } ?>
                                                                
                                <?php if (!is_null($requisicao->fields['nomeRegiao'])) { ?>
                                <tr>
                                    <th>Região</th>
                                    <td><?php echo $requisicao->fields['nomeRegiao']; ?></td>
                                </tr>	
								<?php } ?>                                                                
                                                                
								<?php if (!is_null($requisicao->fields['SituacaoRequisicao'])) { ?>
								<tr>
									<th>Situação da Vaga</th>
									<td><?php 
                                          switch($requisicao->fields['SituacaoRequisicao']){
                                              case "E": echo "Encerrada"; break;
                                              case "N": echo "Aberta"; break;
                                              case "S": echo "Suspensa"; break;
                                          }
                                        ?>
									</td>
								</tr>
								<?php } ?>
								<?php if ((!is_null($requisicao->fields['InicioSelecao'])) && 
                                                ("0000-00-00"!=$requisicao->fields['InicioSelecao'])) { ?>
								<tr>
									<th>Vaga publicada em</th>
									<td><?php echo DataUtil::formatar($requisicao->fields['InicioSelecao']); ?></td>
								</tr>
								<?php } elseif ((!is_null($requisicao->fields['DataRequisicao'])) && 
                                                        ("0000-00-00"!=$requisicao->fields['DataRequisicao'])) { ?>								
								<tr>
									<th>Vaga publicada em</th>
									<td><?php echo DataUtil::formatar($requisicao->fields['DataRequisicao']); ?></td>
								</tr>
								<?php } ?>								
								<?php if (!is_null($requisicao->fields['SituacaoRequisicao'])) { 
                                          if (($requisicao->fields['SituacaoRequisicao']) == "E") {
                                              if (!is_null($requisicao->fields['Dt_Encerra'])) { ?>  											
												<tr>
													<th>Data de Encerramento</th>
													<td><?php echo DataUtil::formatar($requisicao->fields['Dt_Encerra']); ?></td>
												</tr>											
									<?php }
                                          } else  if(($requisicao->fields['PrazoEncerramento']) != "0000-00-00") {?>
											<tr>
												<th>Prazo de Encerramento</th>
												<td><?php echo DataUtil::formatar($requisicao->fields['PrazoEncerramento']); ?></td>
											</tr>								
							    <?php }
                                      } ?>
								
								<?php if (!is_null($requisicao->fields['nomeVinculoEmpregaticio'])) { ?>
								<tr>
									<th>Vínculo Empregatí­cio</th>
									<td><?php echo $requisicao->fields['nomeVinculoEmpregaticio']; ?></td>
								</tr>
								<?php } ?>
								<?php if (!is_null($requisicao->fields['SalarioMaximo'])) { ?>
								<tr>
									<th>Salário</th>
									<?php if (NumberUtil::formatar($requisicao->fields['SalarioMaximo']) == "0,00") { ?>
									  <td>A negociar</td>
									<?php } else { ?>    
									<td>R$ <?php echo NumberUtil::formatar($requisicao->fields['SalarioMaximo']);
                                          }?></td>
									
								</tr>
								<?php } ?>
								<?php if (!is_null($requisicao->fields['Observacoes'])) { ?>
								<tr>
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
	
        <div class="botao-voltar" aria-label = "Voltar" onclick="curriculoWebUtil.openEntradaConsulta();"></div>
		
		<div class="clear"></div>
	</div>
</div>