<?php 
include_once 'imports.php'; 
global $configObj;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt-BR'>
<head>
	
	<title>Curr�culo Web</title>	
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1' />
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
	<script type="text/javascript" language="javascript" src="js/Pessoa.js"></script>
	<script type="text/javascript" language="javascript" src="js/util.js"></script>	
	<script type="text/javascript" language="javascript">jQuery.noConflict();</script>
	

</head>

<body>
	<script type="text/javascript">        
		jQuery(document).ready(function(){
		    var isChrome = /Chrome/.test(navigator.userAgent);
            if (isChrome)
                document.querySelector(".botao-avancar").style.marginTop = "15px";
		    else
                document.querySelector(".botao-avancar").style.marginTop = "25px";

            $("#Nome").focus();
		    $("#Cpf").mask("999.999.999-99");
	    });
	</script>
	
	<div class="container_16">	
		<div class="grid_1">&nbsp;</div>
		<div class="grid_14">
			<div class="content">	
				
				<div class="logotipo" align="center">
					<img src="images/logotipo_inicio.jpg" alt="logotipo"/>
				</div>
				
				<div class="curriculo-online">&nbsp;</div>
				
				<div id="msg-err" class="error-msg" align="center"></div>
				
				<p align="center">Crie seu usu�rio para acessar o ambiente do Curr�culo web.</p>
				
				<div class="titulo-cadastrar"></div>
								
				<div class="box-cadastrar">
				
					<form name="novoForm" id="novoForm" action="index.php" method="post" onsubmit="return pessoaUtil.cadastrar(this)">
											
						<input type="hidden" name="modulo" value="home"/>
						<input type="hidden" name="acao" value="salvar"/> 
						
						<div class="box-login-content">
					
							<div class="cpf-senha">Nome:</div>
							<div class="campos-login"><input type="text" id="Nome" aria-label = "Nome" name="Nome" class="campo-login" size="30" maxLength="40"/></div>
							<div class="clear"></div>
							
							<div class="cpf-senha">CPF:</div>
							<div class="campos-login"><input type="text" id="Cpf" name="Cpf" aria-label = "CPF" class="campo-login" size="30" onblur="if(!pessoaUtil.validarCPF(this.value)) this.value = ''" /></div>							
							<div class="clear"></div>
							
							
							<div class="cpf-senha">E-mail:</div>
							<div class="campos-login"><input type="text" id="Email" name="Email" aria-label = "EMAIL" class="campo-login" size="30" maxLength="80"/></div>							
							<div class="clear"></div>
							
	
							<div class="cpf-senha">Senha:</div>
							<div class="campos-login">
								<input type="password" id="Senha" name="Senha" aria-label = "Senha" class="campo-login" size="30" />
							</div>
							<div class="clear"></div>
							
							<div class="cpf-senha">Confirmar Senha:</div>
							<div class="campos-login">
								<input type="password" id="ConfirmaSenha" name="ConfirmaSenha" aria-label = "Confirmar Senha" class="campo-login" size="30" />
							</div>
							
							<div class="clear"></div>
							<div class="ok-login">
								<input type="submit" id="botao-login" class="botao-avancar" aria-label = "Avan�ar" value="" />
							</div>
							<div class="clear"></div>
							
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
