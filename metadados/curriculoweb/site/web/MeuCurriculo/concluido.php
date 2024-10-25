<?php 
session_start();
include "../../../imports.php";

global $configObj;
$webConfDao = new CandidatosWebConfDao($db);
$configObj = new Config($db, $webConfDao->buscaEmpresaPrincipal());

$infoIncompletas = new InfoIncompletas($db); 

?>
<div class="content-interna">
	<div class="alinhamento">
		<?php include 'migalha_concluido.php'; ?>
		<div class="clear">&nbsp;</div>
		<div class="div-box">
			<br/><br/>
			
            <?php
            if(!$infoIncompletas->existeCampoVazio()){
					echo "<center  id='mensagemSucesso' tabindex='0' style=\"font-size: 13px;\">".utf8_encode($configObj->getValorDiretriz('mensagemConcluido'))."</center>";
				}
				else{
					echo "<div  style=\"font-size: 13px; color:red\">
							<div style=\"text-align:center\">".
							utf8_encode($configObj->getValorDiretriz('mensagemCurriculoIncompletoConcluido')."</div></br></br>
							<div tabindex='0' id='mensagemFalha' style=\"margin-left: 210px\">".$infoIncompletas->getCamposVaziosHTML())."</div>
						  </div>";
				}

            ?>
			
			<br/><br/><br/>
			<div align="center">
				<div tabindex="0" aria-label="Pagina Inicial" onclick="curriculoWebUtil.openInicial();" class="botao-pagina-inicial"></div>
			</div>
		</div>
	</div>
</div>

<script>
    $( "#mensagemSucesso" ).focus();
    $( "#mensagemFalha" ).focus();
</script>