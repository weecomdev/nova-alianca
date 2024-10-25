<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt-BR'>
<head>
	<title>Currículo Web</title>	
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv='Content-Type' content='text/html; charset= ISO-8859-1' />
	<meta name="author" content="BF2 Tecnologia" />
	<meta name="Description" content="" />
	<meta name="Language" content="PT-BR" />	
	<meta name="Copyright" content="BF2 Tecnologia" />
	<meta name="Designer" content="BF2 Tecnologia" />
	
	<base href="<?php echo $_SESSION['UsaHttps']."://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF'])."/" ?>"/>

    <?php include_once 'imports.php'; 
     global $configObj;?>
	
    <link rel="shortcut icon" href="images/favicon.ico" />	
	<link rel="stylesheet" type="text/css" href="style/reset.css" />
	<link rel="stylesheet" type="text/css" href="style/text.css" />
	<link rel="stylesheet" type="text/css" href="style/960.css" />
	<link rel="stylesheet" type="text/css" href="style/curriculoweb.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.all.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.base.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.theme.css" />	
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.accordion.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.button.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.core.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.datepicker.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.dialog.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.progressbar.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.resizable.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.selectable.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.slider.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.tabs.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="style/cor<?php echo $configObj->getValorDiretriz('cor');?>.css" />

	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-1.6.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/lib/jquery/jquery.maskedinput.js"></script>
	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-ui.min.js"></script>	
	<script language="javascript" type="text/javascript" src="js/lib/jquery/jquery.priceFormat.js"></script>
	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/bf2/bf2.js"></script>
	<script type="text/javascript" language="javascript" src="js/Pessoa.js"></script>
	<script type="text/javascript" language="javascript" src="js/util.js"></script>	
	<script type="text/javascript" language="javascript">jQuery.noConflict();</script>
	<script type="text/javascript" language="javascript" src="js/date-pt-BR.js"></script>
	<script type="text/javascript" language="javascript" src="js/curriculoweb.js"></script>	
	<script type="text/javascript" language="javascript" src="js/infoIncompletas.js"></script>
	
	<script type="text/javascript" src="js/PessoaCurso.js"></script>
	<script type="text/javascript" src="js/EmpresaAnterior.js"></script>
	<script type="text/javascript" src="js/DadoComplementar.js"></script>
	<script type="text/javascript" src="js/Vagas.js"></script>
	<script type="text/javascript" src="js/VagasHome.js"></script>
	<script type="text/javascript" src="js/Login.js"></script> 

	
	
	

</head>

<body>
	<script type="text/javascript" language="javascript">
		jQuery=$;	
		$(document).ready(function(){
			$("#cpf").mask("999.999.999-99");
		});
	</script>

	<div class="container_16">	
		<div class="grid_1">&nbsp;</div>
		<div class="grid_14">
			<?php include 'site/web/cabecalho.php'; ?>
			<div class="clear">&nbsp;</div>
			
			<div id="mainPanel">
			
				<div class="content-interna" align="center">
					<br/><br/>
					
					<div id="msg-err" class="error-msg" align="center"></div>
					
					<br/><br/>
						
					<div class="titulo-alterar-senha" tabindex="0" aria-label="Alterar Senha Grupo">&nbsp;</div>				
					<div class="box-middle-vagas-disponiveis" align="left">
						<div class="box-top-vagas-disponiveis"></div>					
						<form name="loginForm" id="loginForm" action="index.php" method="post" onsubmit="return loginUtil.salvarSenha(this)">						
							<input type="hidden" name="modulo" value="login"/>
							<input type="hidden" name="acao" value="salvarSenha"/> 
							
							<div class="listagem-campos">
								<div class="label-campos">CPF:</div>
								<input type="text" id="cpf" name="cpf" aria-label = "CPF" value="<?php echo $_SESSION["CPF"]; ?>" class="campo" size="15" readonly="readonly" />
							</div>

							<div class="listagem-campos">
								<div class="label-campos">Senha Atual:</div>
								<input type="password" id="senhaAtual" aria-label = "Senha Atual" name="senhaAtual" class="campo" size="23" />
							</div>							
							
							<div class="listagem-campos">
								<div class="label-campos">Senha Nova:</div>
								<input type="password" id="senhaNova" name="senhaNova" aria-label = "Senha Nova" class="campo" size="23" />
							</div>						
							
							<div class="listagem-campos">
								<div class="label-campos">Confirme a senha:</div>							
								<input type="password" id="senhaConfirma" name="senhaConfirma" aria-label = "Confirme a Senha" class="campo" size="23" />
							</div>
							
							<div class="clear">&nbsp;</div>							
							
							<input type="submit" id="botao-salvar" class="botao-salvar" aria-label = "Salvar" value="" />
							<input type="button" id="botao-voltar" class="botao-voltar" aria-label = "Voltar" value="" onclick="curriculoWebUtil.redirect('?modulo=home&acao=inicial');" />
							
						</form>						
					</div>								
					<div class="box-bottom-vagas-disponiveis"></div>
					<div class="clear">&nbsp;</div>
				</div>
				
			</div>				

			<div class="clear">&nbsp;</div>
                <?php include 'site/web/rodape.php'; ?>
		<div class="grid_1">&nbsp;</div>
	</div>
	
</body>

</html>
