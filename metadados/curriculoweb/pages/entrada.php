<?php 
include_once 'imports.php';
global $configObj;
?>
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
	

	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-1.6.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/lib/jquery/jquery.maskedinput.js"></script>
	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-ui.min.js"></script>			
	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/bf2/bf2.js"></script>
	<script type="text/javascript" language="javascript" src="js/curriculoweb.js"></script>
	<script type="text/javascript" language="javascript">jQuery.noConflict();</script>
	

</head>

<body onload="">
	<script type="text/javascript" language="javascript">
		function foco() {
			document.getElementById('usuario').focus();
		}
	</script>
	
	
	<div class="container_16">	
		<div class="grid_1">&nbsp;</div>
		<div class="grid_14">
			<div class="content">	
				
				<div class="logotipo" align="center">
					<img src="images/logotipo_inicio.jpg" alt="logotipo"/>
				</div>
				
				<div class="curriculo-online">&nbsp;</div>
				
				<center>
					<a href="?modulo=home&acao=cadastrar" aria-label = "Cadastrar">cadastrar</a> | <a href="?modulo=login" aria-label = "login">login</a>
				</center>				
				

				<div class="rodape-login">&nbsp;</div>
			</div>
		</div>			
		<div class="grid_1">&nbsp;</div>
	</div>
	<!-- Script da máscara -->
	<script language="javascript" type="text/javascript">
		jQuery(function($){
			jQuery("#usuario").mask("999.999.999-99");
		});
	</script>		
	<!-- Fim do Script da máscara -->
</body>

</html>
