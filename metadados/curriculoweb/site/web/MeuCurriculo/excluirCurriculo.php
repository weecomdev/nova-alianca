<?php
	global $configObj;
?>

<div class="content-interna" align="center">
					<br/><br/>
					
					<div id="msg-err" class="error-msg" align="center"></div>
					
					<br/><br/>
						
					<div class="titulo-Solicitar-Exclusao" tabindex="0" aria-label="Solicitar Exclusão do Currículo Web Grupo">&nbsp;</div>				
					<div class="box-middle-vagas-disponiveis" align="left">
						<div class="box-top-vagas-disponiveis"></div>					
						<!--<form name="loginForm" id="loginForm" action="index.php" method="post" onsubmit="return loginUtil.salvarExclusao(this)">-->						
							<input type="hidden" name="modulo" value="login"/>
							<input type="hidden" name="acao" value="salvarSenha"/> 
							
							<div class="listagem-campos">
								<div class="label-campos">CPF:</div>
								<input type="text" id="cpf" name="cpf" aria-label = "CPF" value="<?php echo $_SESSION["CPF"]; ?>" class="campo" size="15" readonly="readonly" />
							</div>
                            <div class="listagem-campos">
                            <div class="text-exclusao">
                               <?php echo $configObj->getValorDiretriz('mensagemExclusao'); ?>
                             </div>
                            </div>
 					
							<div class="clear">&nbsp;</div>							
							
							<input type="submit" id="botao-salvar" class="botao-salvar" aria-label = "Salvar" value="" onClick="curriculoWebUtil.salvarExclusao();" />
							<input type="button" id="botao-voltar" class="botao-voltar" aria-label = "Voltar" value="" onclick="curriculoWebUtil.redirect('?modulo=home&acao=inicial');" />
							
						<!--</form>	-->					
					</div>								
					<div class="box-bottom-vagas-disponiveis"></div>
					<div class="clear">&nbsp;</div>
				</div>
                	<script type="text/javascript" language="javascript">
		jQuery=$;	
		$(document).ready(function(){
			$("#cpf").mask("999.999.999-99");
		});
	</script>