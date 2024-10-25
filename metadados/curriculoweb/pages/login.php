<?php 
include_once 'imports.php'; 
global $configObj;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt-BR'>
<head>
	
	<title>Currí­culo Web</title>	
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv='Content-Type' content='text/html; charset = ISO-8859-1' />
	<meta name="author" content="BF2 Tecnologia" />
	<meta name="Description" content="" />
	<meta name="Language" content="PT-BR" />	
	<meta name="Copyright" content="BF2 Tecnologia" />
	<meta name="Designer" content="BF2 Tecnologia" />
	
	<base href="<?php echo $_SESSION['UsaHttps']."://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF'])."/" ?>"/>
	

	
	<link rel="shortcut icon" href="images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="style/reset.css" />
	<link rel="stylesheet" type="text/css" href="style/text.css" />
	<link rel="stylesheet" type="text/css" href="style/960.css" />
	<link rel="stylesheet" type="text/css" href="style/cor<?php echo $configObj->getValorDiretriz('cor');?>.css" />
	<link rel="stylesheet" type="text/css" href="style/curriculoweb-login.css" />
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
	<link rel="stylesheet" type="text/css" href="style/TermoConsentimento.css" />

	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-1.6.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/lib/jquery/jquery.maskedinput.js"></script>
	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-ui.min.js"></script>	
	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/bf2/bf2.js"></script>
	<script type="text/javascript" language="javascript" src="js/util.js"></script>
	<script type="text/javascript" language="javascript" src="js/Login.js"></script>
	<script type="text/javascript" language="javascript" src="js/Pessoa.js"></script>
	<script type="text/javascript" language="javascript">jQuery.noConflict();</script>
	<script type="text/javascript" language="javascript" src="js/date-pt-BR.js"></script>
	
	<script type="text/javascript" language="javascript" src="js/curriculoweb.js"></script>
		
	

</head>

<body>

	<script type="text/javascript" language="javascript">
	jQuery=$;
	jQuery(document).ready(function(){
		jQuery("#cpf").focus();
		jQuery("#cpf").mask("999.999.999-99");
	});
	</script>
	
	<div class="container_16">	
		<div class="grid_1">&nbsp;</div>
		<div class="grid_14">
			<div class="content">	
				
				<div class="logotipo" align="center">
					<img src="images/logotipo_inicio.jpg" alt="logotipo"/>
				</div>
				
				<div class="curriculo-online">
					&nbsp;
				</div>
				
				<div id="msg-err" class="error-msg" align="center"></div>
				
				<div class="titulo-login"></div>
				
				<div class="box-login">
					<form name="loginForm" id="loginForm" action="index.php" method="post" onsubmit="return loginUtil.login(this)">
						<input type="hidden" name="modulo" value="login"/>
						<input type="hidden" name="acao" value="login"/> 
						<div class="box-login-content">
							<div class="cpf-senha-login">CPF:</div>
							<div class="campos-login"><input type="text" id="cpf" name="cpf" aria-label = "CPF" class="campo-login" size="23" onblur="if(!pessoaUtil.validarCPF(this.value)) this.value = ''"/></div>							
							<div class="clear"></div>

							<div class="cpf-senha-login">Senha:</div>
							<div class="campos-login"><input type="password" id="senha" aria-label = "Senha" name="senha" class="campo-login" size="23" /></div>							
							<div class="clear"></div>
							
							<div class="esqueceu-senha" align="center" id="esqueceuSenha" name="esqueceuSenha" onClick="curriculoWebUtil.esqueceuSenha();">Esqueceu a senha? <strong style="cursor: pointer;" tabindex="0">Clique aqui</strong>.</div>
							<div class="clear"></div>
							
							<div class="ok-login" align="center">
								<input type="submit" id="botao-login" aria-label = "OK" class="ok" value="" />
							</div>
						</div>
					</form>
				</div>
                <div id="alerta"></div>

				<div class="rodape-login">&nbsp;</div>
			</div>
		</div>			
		<div class="grid_1">&nbsp;</div>
	</div>	
</body>

</html>
